<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Order\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;

use Order\Model\JobOrder;
use Order\Model\JobOrderTable;
use Order\Model\JobItem;
use Order\Model\JobItemTable;
use Order\Filter\JobOrderFilter;
use Order\Model\Shipping;
use Order\Model\ShippingTable;

use Cart\Model\CartItem;
use Cart\Model\CartItemTable;
use Cart\Model\Cart;
use Cart\Model\CartTable;

use Product\Model\Product;
use Product\Model\ProductTable;

class OrderController extends AbstractActionController
{   

    private $customerSessionContainer;
    private $cartSessionContainer;
    private $jobOrderTable;
    private $jobOrder;
    private $jobItemTable;
    private $jobItem;
    private $jobOrderFilter;
    private $cartItem;
    private $cartItemTable;
    private $shipping;
    private $shippingTable;
    private $cart;
    private $cartTable;
    private $productTable;
    private $product;

    private $shippingRates = [];
    private $totalWeight = 0;
    private $cartId;


    public function __construct(
        $customerSessionContainer,
        $cartSessionContainer,
        JobOrderTable $jobOrderTable,
        JobOrder $jobOrder,
        JobItemTable $jobItemTable,
        JobItem $jobItem,
        JobOrderFilter $jobOrderFilter,
        CartItem $cartItem,
        CartItemTable $cartItemTable,
        Shipping $shipping,
        ShippingTable $shippingTable,
        Cart $cart,
        CartTable $cartTable,
        ProductTable $productTable,
        Product $product
    )
    {
        $this->customerSessionContainer = $customerSessionContainer;
        $this->cartSessionContainer = $cartSessionContainer;
        $this->jobOrderTable = $jobOrderTable;
        $this->jobOrder = $jobOrder;
        $this->jobItemTable = $jobItemTable;
        $this->jobItem = $jobItem;
        $this->jobOrderFilter = $jobOrderFilter;
        $this->cartItemTable = $cartItemTable;
        $this->cartItem = $cartItem;
        $this->shippingTable = $shippingTable;
        $this->shipping = $shipping;
        $this->cart = $cart;
        $this->cartTable = $cartTable;

        $this->productTable = $productTable;
        $this->product = $product;

        $this->cartId = $this->cartSessionContainer->cartId;
        $this->shippingRates = $this->getShippingRates();
        $this->totalWeight = $this->computeTotalWeight();
    }

    private function computeTotalWeight()
    {
        $totalWeight = 0;
        $cartItems = $this->cartItemTable->getByCartId($this->cartId);
        foreach($cartItems as $item){
            $totalWeight += $item['weight'] * $item['qty'];
        }
        return $totalWeight;
    }

    private function getShippingRates()
    {
        $shippingRates = $this->shippingTable->getShipping();
        $groupedRates = array();
        foreach ( $shippingRates as $value ) {
            $groupedRates[$value->shipping_method][] = $value;
        }
        return $groupedRates;
    }

    private function calculateRatePerMethod()
    {
        $shippingRates = $this->shippingRates;
              
        $weightBalance = [
            'Ground' => $this->totalWeight,
            'Expedited' => $this->totalWeight
        ];

        $ratesPerMethod = [
            'Ground' => 0,
            'Expedited' => 0
        ];

        // identify max weight 
        $maxRates = [
            'Ground' => [
                'rate' => 0,
                'weight' => 0
            ],
            'Expedited' => [
                'rate' => 0,
                'weight' => 0
            ],
        ];

        // shipping calculation with the range
        foreach($shippingRates as $method => $rates) {
            foreach($rates as $rate) {

                if($rate->max_weight > $maxRates[$method]['weight']) {
                    $maxRates[$method]['weight'] = $rate->max_weight;
                    $maxRates[$method]['rate'] = $rate->shipping_rate;
                }

                if($rate->min_weight <= $weightBalance['Ground'] && $rate->max_weight >= $weightBalance['Ground']){ 
                    $ratesPerMethod[$method] += $rate->shipping_rate;
                }

            }
        }

    
        // run this is exceeds max weight
        if($ratesPerMethod['Ground'] == 0 && $ratesPerMethod['Expedited'] == 0) {
            while($weightBalance['Ground'] > 0) {
                if($weightBalance['Ground'] >= $maxRates['Ground']['weight']) {
                    $ratesPerMethod['Ground'] += $maxRates['Ground']['rate'];
                    $ratesPerMethod['Expedited'] += $maxRates['Expedited']['rate'];
                    $weightBalance['Ground'] -= $maxRates['Ground']['weight']; 
                    $weightBalance['Expedited'] -= $maxRates['Expedited']['weight']; 
                }
                else {
                    foreach($shippingRates as $method => $rates) {
                        foreach($rates as $rate) {   
                            if($rate->min_weight <= $weightBalance[$method] && $rate->max_weight >= $weightBalance[$method]){ 
                                $ratesPerMethod[$method] += $rate->shipping_rate;
                                $weightBalance[$method] -= $rate->max_weight;
                            }
                            else {
                            
                                $weightBalance[$method]--;
                            }
                        }
                   }
                }   
            }   
        }
        return $ratesPerMethod;
    }

    public function indexAction()
    {
        
        
        $template = $this->params()->fromRoute('template', NULL);
        $viewTemplate = $this->params()->fromRoute('viewTemplate', NULL);
        $this->layout($template);

        $jobOrderId = $this->params()->fromRoute('id', 0);
        $joHeader = $this->jobOrderTable->getJobOrder($jobOrderId);
        $items = $this->jobItemTable->getByJobOrder($jobOrderId);
      
        $viewModel = new ViewModel([
            'jobOrder' => $joHeader,
            'items' => $items
        ]);

        $viewModel->setTemplate($viewTemplate);
        return $viewModel;
    }

    public function onDispatch(\Zend\Mvc\MvcEvent $e)
    {
    
        if(!isset($this->customerSessionContainer->user)) {
            $this->cartSessionContainer->redirectUrl = 'shipping-info';
            return $this->redirect()->toRoute('customer-login');
        }
        return parent::onDispatch($e);
    }
    
    public function shippingAction() 
    {
       
        $request = $this->getRequest();
        $post = [];
       
        if($request->isPost()){
           
            $post = $request->getPost();
            $this->jobOrder->exchangeArray($request->getPost());
            $this->jobOrderFilter->setInputFilter($this->jobOrder->getArrayCopy());
            $this->jobOrderFilter->setData($this->jobOrder->getArrayCopy());

            if ($this->jobOrderFilter->isValid()) {

                $cartItems = $this->cartItemTable->getByCartId($this->cartId);
                $subTotal = 0;
                $taxableAmount = 0;
                $discount = 0;
                $tax = 0;
                $taxableAmount = 0;
                $shippingTotal = $post->shipping_total;
                $totalWeight = $this->totalWeight;
                foreach($cartItems as $item){
                    $subTotal += $item['price'] * $item['qty'];
                    if($item['taxable_flag'] == 'y') {
                        $taxableAmount += $item['price'] * $item['qty'];
                        $tax += ($item['price'] * $item['qty']) * 0.1;
                    }
                }

                $totalAmount = $subTotal + $tax + $shippingTotal;
                    
                $cartParams = [
                    'cart_id' => $this->cartId,
                    'customer_id' => $this->customerSessionContainer->user['customerId'],
                    'sub_total' => $subTotal,
                    'taxable_amount' => $taxableAmount,
                    'tax' => $tax,
                    'shipping_total' => $shippingTotal,
                    'total_amount' => $totalAmount,
                    'total_weight' => $totalWeight,
                    'company_name' => $this->customerSessionContainer->user['companyName'],
                    'email' => $this->customerSessionContainer->user['email'],
                    'first_name' => $this->customerSessionContainer->user['firstName'],
                    'last_name' => $this->customerSessionContainer->user['lastName'],
                    'phone' => $this->customerSessionContainer->user['phone'],
                    'shipping_method' => $post->shipping_method,
                    'shipping_name' => $post->shipping_name,
                    'shipping_address1' => $post->shipping_address1,
                    'shipping_address2' => $post->shipping_address2,
                    'shipping_address3' => $post->shipping_address3,
                    'shipping_city' => $post->shipping_city,
                    'shipping_state' => $post->shipping_state,
                    'shipping_country' => $post->shipping_country
                ];
                
                $this->cartTable->updateCart($cartParams);

                // create job order
                $joParams = [
                    'customer_id' => $this->customerSessionContainer->user['customerId'],
                    'order_datetime' => date('Y-m-d H:i:s'),
                    'sub_total' => $subTotal,
                    'taxable_amount' => $taxableAmount,
                    'discount' => 0,
                    'tax' => $tax,
                    'shipping_total' => $shippingTotal,
                    'total_amount' => $totalAmount,
                    'total_weight' => $totalWeight,
                    'company_name' => $this->customerSessionContainer->user['companyName'],
                    'email' => $this->customerSessionContainer->user['email'],
                    'first_name' => $this->customerSessionContainer->user['firstName'],
                    'last_name' => $this->customerSessionContainer->user['lastName'],
                    'phone' => $this->customerSessionContainer->user['phone'],
                    'shipping_method' => $post->shipping_method,
                    'shipping_name' => $post->shipping_name,
                    'shipping_address1' => $post->shipping_address1,
                    'shipping_address2' => $post->shipping_address2,
                    'shipping_address3' => $post->shipping_address3,
                    'shipping_city' => $post->shipping_city,
                    'shipping_state' => $post->shipping_state,
                    'shipping_country' => $post->shipping_country
                ];
            
                $this->jobOrder->exchangeArray($joParams);
                $jobOrderId = $this->jobOrderTable->insertJobOrder($this->jobOrder->getArrayCopy());

                // the cart item above is being destroyed after running another query after it
                $cartItems = $this->cartItemTable->getByCartId($this->cartId);
                foreach($cartItems as $item){                   
                    $itemParams = [
                        'job_order_id' => $jobOrderId,
                        'product_id' => $item['product_id'],
                        'weight' => $item['weight'],
                        'qty' => $item['qty'],
                        'unit_price' => $item['price'],
                        'price' => $item['price'] * $item['qty']
                    ];
                    $this->jobItem->exchangeArray($itemParams);
                    $this->jobItemTable->insertJobItem($this->jobItem->getArrayCopy());

                    // update stock
                    $newStock = $item['stock_qty'] - $item['qty'];
                    $productId = $item['product_id'];
                    if($newStock >= 0) {
                        $this->productTable->updateProduct([
                            'product_id' => $productId,
                            'stock_qty' => $newStock
                        ]);
                    }
                }
                
                // empty cart before redirect
                $this->cartSessionContainer->cartId = 0;
                
                return $this->redirect()->toRoute('order-confirmation', array(
                    'controller' => 'order',
                    'action' => 'index',
                    'id' => $jobOrderId
                ));

            }
            else {
                $viewData['errors'][] = $this->jobOrderFilter->getMessages();
            }

        }

        $template = $this->params()->fromRoute('template', NULL);
        $viewTemplate = $this->params()->fromRoute('viewTemplate', NULL);
        $this->layout($template);
        
        $viewData['post'] = $post;
        $viewData['shippingRates'] = $this->calculateRatePerMethod();

        $viewModel = new ViewModel($viewData);

        $viewModel->setTemplate($viewTemplate);
        return $viewModel;
    }


}
