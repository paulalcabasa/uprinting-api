<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Cart\Controller;

use Application\Controller\AppAbstractRestfulController;

use Cart\Model\Cart;
use Cart\Model\CartTable;

use Cart\Model\CartItem;
use Cart\Model\CartItemTable;

use Product\Model\Product;
use Product\Model\ProductTable;

use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;

// use Cart\Filter\CartIdFilter;

class CartController extends AppAbstractRestfulController
{   

    private $CartTable;
    private $Cart;

    private $CartItemTable;
    private $CartItem;

    private $ProductTable;
    private $Product;

    private $CartIdFilter;


    public function __construct(
        CartTable $cartTable,
        Cart $cart,

        CartItemTable $cartItemTable,
        CartItem $cartItem,

        ProductTable $productTable,
        Product $product
        //CartIdFilter $cartIdFilter
    )
    {
        $this->CartTable = $cartTable;
        $this->Cart = $cart;

        $this->CartItemTable = $cartItemTable;
        $this->CartItem = $cartItem;

        $this->ProductTable = $productTable;
        $this->Product = $product;

       // $this->CartIdFilter = $cartIdFilter;
    }
    
    public function create($data)
    {
        
        $cartId = $data['cartId'];

        if(!$data['cartId']){
           
            $this->Cart->exchangeArray([
                'customer_id' => $data['customerId']
            ]);
                
            $cartId = $this->CartTable->insertCart($this->Cart->getArrayCopy());
        }

        // get cart item
        $cartItem = $this->CartItemTable->getCartItem($cartId, $data['product']['product_id']);
        
        if($cartItem) {
            if($cartItem->qty + $data['quantity'] > $data['product']['stock_qty']){
                return new JsonModel(array(
                    'message' => 'Insufficient stock.',
                    'cart_id' => $cartId,
                    'state' => false
                ));
            }
        }

        // if not yet existing
        if(!$cartItem) {
            
            $cartItem = [
                'cart_id' => $cartId,
                'product_id' => $data['product']['product_id'],
                'weight' => $data['product']['weight'],
                'qty' => $data['quantity'],
                'unit_price' => $data['product']['price'],
                'price' => $data['product']['price'] * $data['quantity']
            ];

            $this->CartItem->exchangeArray($cartItem);
            $this->CartItemTable->insertCartItem($this->CartItem->getArrayCopy());

            return new JsonModel(array(
                'message' => 'Cart Item inserted!',
                'cartId' => $cartId,
                'state' => true
            ));
        }

        // update quantity
        $totalQty = $cartItem->qty + $data['quantity'];

        $params = [
            'cart_item_id' => $cartItem->cart_item_id,
            'qty' => $totalQty,
            'price' =>  $totalQty * $data['product']['price']
        ];

        $this->CartItemTable->updateCartItem($params);

        return new JsonModel(array(
            'cartId' => $cartId,
            'message' => "updated cart",
            'state' => true
        ));

    }


}
