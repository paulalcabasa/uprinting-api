<?php

namespace Cart\Model;

class CartItem
{
    public $cart_item_id;
    public $cart_id;
    public $product_id;
    public $weight;
    public $qty;
    public $unit_price;
    public $price;
 
    public function exchangeArray($data)
    {

        $this->cart_item_id = isset($data['cart_item_id']) ? $data['cart_item_id'] : null;
        $this->cart_id = isset($data['cart_id']) ? $data['cart_id'] : null;
        $this->product_id = isset($data['product_id']) ? $data['product_id'] : null;
        $this->weight = isset($data['weight']) ? $data['weight'] : null;
        $this->qty = isset($data['qty']) ? $data['qty'] : null;
        $this->unit_price = isset($data['unit_price']) ? $data['unit_price'] : null;
        $this->price = isset($data['price']) ? $data['price'] : null;
    }

    public function getArrayCopy()
    {
        return get_object_vars($this);
    }
}
