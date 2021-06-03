<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Cart\Controller;

use Zend\Mvc\Controller\AbstractActionController;

use Cart\Model\Cart;
use Cart\Model\CartTable;
use Cart\Model\CartItem;
use Cart\Model\CartItemTable;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;
use Zend\Session\Container;
use Product\Model\Product;
use Product\Model\ProductTable;

class CartController extends AbstractActionController
{   

    private $cartTable;
    private $cart;
    private $cartItemTable;
    private $cartItem;
    private $sessionContainer;
    private $productTable;
    private $product;

    public function __construct(
        CartTable $cartTable,
        Cart $cart,
        CartItemTable $cartItemTable,
        CartItem $cartItem,
        $sessionContainer,
        ProductTable $productTable,
        Product $product
    )
    {
        $this->cartTable = $cartTable;
        $this->cart = $cart;
        $this->cartItemTable = $cartItemTable;
        $this->cartItem = $cartItem;
        $this->sessionContainer = $sessionContainer;
        $this->productTable = $productTable;
        $this->product = $product;
    }
    
    // public function create()
    // {
        
    //     // // remove item
    //     // $request = $this->getRequest();
    //     // if ($request->isPost()) {
    //     //     echo "delete post";
    //     // }


    //     if(!isset($this->sessionContainer->cartId)) {
    //         $this->sessionContainer->cartId = 0;
    //     }
    //     $template = $this->params()->fromRoute('template', NULL);
    //     $viewTemplate = $this->params()->fromRoute('viewTemplate', NULL);
    //     $this->layout($template);
        
    //     $cart = [];
    //     if(isset($this->sessionContainer->cartId)){
    //         $cart = $this->cartItemTable->getByCartId($this->sessionContainer->cartId);
    //     }

    //     $viewModel = new ViewModel([
    //         'cart' => $cart
    //     ]);

    //     $viewModel->setTemplate($viewTemplate);
    //     return $viewModel;
    // }

   

    public function create($data)
    {
        $this->cart->exchangeArray([
            'customer_id' => 0,
            'order_datetime' => date('Y-m-d H:i:s'),
            'sub_total' => 0,
            'taxable_amount' => 0,
            'discount' => 0,
            'tax' => 0,
            'shipping_total' => 0,
            'total_amount' => 0,
            'total_weight' => 0,
            'company_name' => 0,
            'email' => 0,
            'first_name' => 0,
            'last_name' => 0,
            'phone' => 0,
            'shipping_method' => 0,
            'shipping_name' => 0,
            'shipping_address1' => 0,
            'shipping_address2' => 0,
            'shipping_address3' => 0,
            'shipping_city' => 0,
            'shipping_state' => 0,
            'shipping_country' => 0
        ]);
        $cartId = $this->cartTable->insertCart($this->cart->getArrayCopy());
        // Check if a session for this cart is created
     //   if($this->sessionContainer->cartId == 0){
            
        //    $this->sessionContainer->cartId = $cartId;
        //}

        // $data = $this->getRequest()->getPost();

        // $cartId = $this->sessionContainer->cartId;

        // $cartItem = $this->cartItemTable->getCartItem($cartId, $data['product']['product_id']);
        
        // // if already exist in CART - perform update
        // if($cartItem) {

        //     // update
        //     if($cartItem->qty + $data['quantity'] > $data['product']['stock_qty']){
        //         return new JsonModel(array(
        //             'message' => 'Insufficient stock.',
        //             'cart_id' => $cartId,
        //             'success' => false
        //         ));
        //     }

        //     $totalQty = $cartItem->qty + $data['quantity'];
        //     $this->cartItemTable->updateCartItem([
        //         'cart_item_id' => $cartItem->cart_item_id,
        //         'qty' => $totalQty,
        //         'price' =>  $totalQty * $data['product']['price']
        //     ]);
        // }
        // else {

        //     // insert
        //     $cartItems = [
        //         'cart_id' => $cartId,
        //         'product_id' => $data['product']['product_id'],
        //         'weight' => $data['product']['weight'],
        //         'qty' => $data['quantity'],
        //         'unit_price' => $data['product']['price'],
        //         'price' => $data['product']['price'] * $data['quantity']
        //     ];
        //     $this->cartItem->exchangeArray($cartItems);
        //     $this->cartItemTable->insertCartItem($this->cartItem->getArrayCopy());
        // }

        return new JsonModel(array(
            'message' => 'success',
            'cart_id' => $cartId,
            'success' => true
        ));
    }

    // public function removeToCartAction()
    // {
    //     $data = $this->getRequest()->getPost();
    //     $cartItemId = $data->cartItemId;

    //     $this->cartItemTable->deleteItem($cartItemId); 

    //     return new JsonModel(array(
    //         'message' => 'remove to cart'
    //     ));
    // }

    // public function updateItemAction()
    // {
    //     $data = $this->getRequest()->getPost();
    //     $cartItemId = $data->cartItemId;
    //     $qty = $data->qty;
    //     $unitPrice = $data->unitPrice;
    //     $productId = $data->productId;
    //     $price = $unitPrice * $qty;

    //     $product = $this->productTable->getProduct($productId);

    //     if($qty <= $product->stock_qty) {
    //         $this->cartItemTable->updateItem([
    //             'cart_item_id' => $cartItemId,
    //             'qty' => $qty,
    //             'price' => $price
    //         ]); 
    //         return new JsonModel(array(
    //             'message' => 'updated cart',
    //             'success' => true
    //         ));
    //     }
    //     else {
    //         return new JsonModel(array(
    //             'message' => 'Insufficient quantity.',
    //             'success' => false
    //         ));
    //     }

        
    // }


}
