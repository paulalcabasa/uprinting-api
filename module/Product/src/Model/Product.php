<?php


namespace Product\Model;

class Product
{
    public $product_id;
    public $product_name;
    public $product_desc;
    public $product_image;
    public $product_thumbnail;
    public $weight;
    public $price;
    public $stock_qty;
    public $taxable_flag;

    public function exchangeArray($data)
    {
        $this->product_id = isset($data['product_id']) ? $data['product_id'] : null;
        $this->product_name = isset($data['product_name']) ? $data['product_name'] : null;
        $this->product_desc = isset($data['product_desc']) ? $data['product_desc'] : null;
        $this->product_image = isset($data['product_image']) ? $data['product_image'] : null;
        $this->product_thumbnail = isset($data['product_thumbnail']) ? $data['product_thumbnail'] : null;
        $this->weight = isset($data['weight']) ? $data['weight'] : null;
        $this->price = isset($data['price']) ? $data['price'] : null;
        $this->stock_qty = isset($data['stock_qty']) ? $data['stock_qty'] : null;
        $this->taxable_flag = isset($data['taxable_flag']) ? $data['taxable_flag'] : null;
    }

    public function getArrayCopy()
    {
        return get_object_vars($this);
    }
}
