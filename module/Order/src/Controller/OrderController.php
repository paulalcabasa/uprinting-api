<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Order\Controller;

use Application\Controller\AppAbstractRestfulController;

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

use Customer\Model\Customer;
use Customer\Model\CustomerTable;

use Auth\Service\TokenService;

use Order\Service\OrderService;

class OrderController extends AppAbstractRestfulController
{   


    private $JobOrderTable;
    private $JobOrder;

    private $JobItemTable;
    private $JobItem;

    private $JobOrderFilter;

    private $CartItem;
    private $CartItemTable;

    private $Shipping;
    private $ShippingTable;

    private $Cart;
    private $CartTable;

    private $ProductTable;
    private $Product;

    private $CustomerTable;
    private $Customer;
  
    private $TokenService;

    private $OrderService;

    public function __construct(
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
        Product $product,
        CustomerTable $customerTable,
        Customer $customer,
        TokenService $tokenService,
        OrderService $orderService
    )
    {
     
        $this->JobOrderTable = $jobOrderTable;
        $this->JobOrder = $jobOrder;
        $this->JobItemTable = $jobItemTable;
        $this->JobItem = $jobItem;
        $this->JobOrderFilter = $jobOrderFilter;
        $this->CartItemTable = $cartItemTable;
        $this->CartItem = $cartItem;
        $this->ShippingTable = $shippingTable;
        $this->Shipping = $shipping;
        $this->Cart = $cart;
        $this->CartTable = $cartTable;

        $this->ProductTable = $productTable;
        $this->Product = $product;

        $this->CustomerTable = $customerTable;
        $this->Customer = $customer;

        $this->TokenService = $tokenService;
        $this->OrderService = $orderService;

    }

 
  
        
    public function create($data) 
    {
    

        $this->JobOrder->exchangeArray($data);
        $this->JobOrderFilter->setData($this->JobOrder->getArrayCopy());
       
        if ($this->JobOrderFilter->isValid()) {


            // check if CartId matches the customer id
            $checkoutCart = $this->CartTable->getCart($data['cart_id']);
            
            if(!$checkoutCart){
                return new JsonModel([
                    'message' => 'Cart does not exist!',
                    'state' => false
                ]);
            }

            if($checkoutCart->customer_id != $this->JobOrder->customer_id) {
                return new JsonModel([
                    'message' => 'Invalid cart id, does not match with your credentials.',
                    'state' => false,
                    'cart customer id' => $checkoutCart->customer_id
                ]);
            }


            $cartItems = $this->CartItemTable->getByCartId($data['cart_id']);
       
            $subTotal = 0;
            $taxableAmount = 0;
            $discount = 0;
            $tax = 0;
            $taxableAmount = 0;
            $shippingTotal = $data['shipping_total'];
            $totalWeight = 0;
            
            foreach($cartItems as $item){
                $subTotal += $item['price'] * $item['qty'];

               if($item['taxable_flag'] == 'y') {
                   $taxableAmount += $item['price'] * $item['qty'];
                   $tax += ($item['price'] * $item['qty']) * 0.1;
               }

               $totalWeight += $item['weight'] * $item['qty'];
            }

            $totalAmount = $subTotal + $tax + $shippingTotal;
            
            $customer = $this->CustomerTable->getByCustomerId($this->JobOrder->customer_id);
          
            $cartParams = [
                'cart_id' => $data['cart_id'],
                'customer_id' => $customer->customer_id,
                'sub_total' => $subTotal,
                'taxable_amount' => $taxableAmount,
                'tax' => $tax,
                'shipping_total' => $shippingTotal,
                'total_amount' => $totalAmount,
                'total_weight' => $totalWeight,
                'company_name' => $customer->company_name,
                'email' => $customer->email,
                'first_name' => $customer->first_name,
                'last_name' => $customer->last_name,
                'phone' => $customer->phone,
                'shipping_method' => $data['shipping_method'],
                'shipping_name' => $data['shipping_name'],
                'shipping_address1' => $data['shipping_address1'],
                'shipping_address2' => $data['shipping_address2'],
                'shipping_address3' => $data['shipping_address3'],
                'shipping_city' => $data['shipping_city'],
                'shipping_state' => $data['shipping_state'],
                'shipping_country' => $data['shipping_country']
            ];
            
            $this->CartTable->updateCart($cartParams);
            
            // create job order
            $joParams = [
                'customer_id' => $customer->customer_id,
                'order_datetime' => date('Y-m-d H:i:s'),
                'sub_total' => $subTotal,
                'taxable_amount' => $taxableAmount,
                'discount' => 0,
                'tax' => $tax,
                'shipping_total' => $shippingTotal,
                'total_amount' => $totalAmount,
                'total_weight' => $totalWeight,
                'company_name' => $customer->company_name,
                'email' => $customer->email,
                'first_name' => $customer->first_name,
                'last_name' => $customer->last_name,
                'phone' => $customer->phone,
                'shipping_method' => $data['shipping_method'],
                'shipping_name' => $data['shipping_name'],
                'shipping_address1' => $data['shipping_address1'],
                'shipping_address2' => $data['shipping_address2'],
                'shipping_address3' => $data['shipping_address3'],
                'shipping_city' => $data['shipping_city'],
                'shipping_state' => $data['shipping_state'],
                'shipping_country' => $data['shipping_country']
            ];
        
            $this->JobOrder->exchangeArray($joParams);
            $jobOrderId = $this->JobOrderTable->insertJobOrder(
                $this->JobOrder->getArrayCopy()
            );
           
            foreach($cartItems as $item){       
                
                // job order item insertion
                $itemParams = [
                    'job_order_id' => $jobOrderId,
                    'product_id' => $item['product_id'],
                    'weight' => $item['weight'],
                    'qty' => $item['qty'],
                    'unit_price' => $item['price'],
                    'price' => $item['price'] * $item['qty']
                ];
                $this->JobItem->exchangeArray($itemParams);
                $this->JobItemTable->insertJobItem($this->JobItem->getArrayCopy());

                // update product stock
                $newStock = $item['stock_qty'] - $item['qty'];
                $productId = $item['product_id'];
                if($newStock >= 0) {
                    $this->ProductTable->updateProduct([
                        'product_id' => $productId,
                        'stock_qty' => $newStock
                    ]);
                }
            }

            return new JsonModel([
                'message' => 'job order created',
                'jobOrderId' => $jobOrderId,
                'state' => true
            ]);
            
        }
        else {
            return new JsonModel([
                'message' => 'Invalid form data',
                'errors' => $this->JobOrderFilter->getMessages(),
                'state' => false
                
            ]);
        }


    }

    public function get($id) 
    {

        $joHeader = $this->JobOrderTable->getJobOrder($id);
        $items = $this->JobItemTable->getByJobOrder($id);
      
        return new JsonModel([
            'joHeader' => $joHeader,
            'items' => $items
        ]);
        
     
    }

}
