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



class CartItemController extends AppAbstractRestfulController
{   

    private $CartTable;
    private $Cart;

    private $CartItemTable;
    private $CartItem;

    private $ProductTable;
    private $Product;

   // private $CartIdFilter;


    public function __construct(
        CartTable $cartTable,
        Cart $cart,

        CartItemTable $cartItemTable,
        CartItem $cartItem,

        ProductTable $productTable,
        Product $product

     //   CartIdFilter $cartIdFilter
    )
    {
        $this->CartTable = $cartTable;
        $this->Cart = $cart;

        $this->CartItemTable = $cartItemTable;
        $this->CartItem = $cartItem;

        $this->ProductTable = $productTable;
        $this->Product = $product;

    //    $this->CartIdFilter = $cartIdFilter;
    }

    public function get($id)
    {
        $cartItems = $this->CartItemTable->getByCartId($id);
        return new JsonModel($cartItems);
    }

    public function delete($id)
    {
        $this->CartItemTable->deleteItem($id);

        return new JsonModel([
            ['message' => 'Deleted cart item']
        ]);
    }

     // UPDATE
    public function update($id, $data)
    {   
        
       
        $cartItemId = $id;
        $qty = $data['qty'];


        $unitPrice = $data['unit_price'];
        $productId = $data['product_id'];
        $price = $data['unit_price'] * $qty;

        $product = $this->ProductTable->getProduct($productId);

        if($qty >= $product->stock_qty) {
          
            return new JsonModel(array(
                'message' => 'Insufficient quantity.',
                'state' => false
            ));
        }
            
        
        $this->CartItemTable->updateItem([
            'cart_item_id' => $cartItemId,
            'qty' => $qty,
            'price' => $price
        ]); 

        return new JsonModel(array(
            'message' => 'updated cart',
            'state' => true
        ));

    }
 

}
