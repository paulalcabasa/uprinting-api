<?php


namespace Order\Model;

class JobItem
{
    public $job_item_id;
    public $job_order_id;
    public $product_id;
    public $weight;
    public $qty;
    public $unit_price;
    public $price;

    public function exchangeArray($data)
    {
        $this->job_item_id = isset($data['job_item_id']) ? $data['job_item_id'] : null;
        $this->job_order_id = isset($data['job_order_id']) ? $data['job_order_id'] : null;
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
