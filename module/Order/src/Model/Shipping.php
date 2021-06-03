<?php


namespace Order\Model;

class Shipping
{
    public $shipping_id;
    public $min_weight;
    public $max_weight;
    public $shipping_method;
    public $shipping_rate;

    public function exchangeArray($data)
    {
        $this->shipping_id = isset($data['shipping_id']) ? $data['shipping_id'] : null;
        $this->min_weight = isset($data['min_weight']) ? $data['min_weight'] : null;
        $this->max_weight = isset($data['max_weight']) ? $data['max_weight'] : null;
        $this->shipping_method = isset($data['shipping_method']) ? $data['shipping_method'] : null;
        $this->shipping_rate = isset($data['shipping_rate']) ? $data['shipping_rate'] : null;
    }

    public function getArrayCopy()
    {
        return get_object_vars($this);
    }
}
