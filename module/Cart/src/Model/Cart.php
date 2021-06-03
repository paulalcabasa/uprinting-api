<?php


namespace Cart\Model;

class Cart
{
    public $cart_id;
    public $customer_id;
    public $order_datetime;
    public $sub_total;
    public $taxable_amount;
    public $discount;
    public $tax;
    public $shipping_total;
    public $total_amount;
    public $total_weight;
    public $company_name;
    public $email;
    public $first_name;
    public $last_name;
    public $phone;
    public $shipping_method;
    public $shipping_name;
    public $shipping_address1;
    public $shipping_address2;
    public $shipping_address3;
    public $shipping_city;
    public $shipping_state;
    public $shipping_country;

 
    public function exchangeArray($data)
    {

        $this->cart_id = isset($data['cart_id']) ? $data['cart_id'] : null;
        $this->customer_id = isset($data['customer_id']) ? $data['customer_id'] : null;
        $this->order_datetime = isset($data['order_datetime']) ? $data['order_datetime'] : date('Y-m-d H:i:s');
        $this->sub_total = isset($data['sub_total']) ? $data['sub_total'] : 0;
        $this->taxable_amount = isset($data['taxable_amount']) ? $data['taxable_amount'] : 0;
        $this->discount = isset($data['discount']) ? $data['discount'] : 0;
        $this->tax = isset($data['tax']) ? $data['tax'] : 0;
        $this->shipping_total = isset($data['shipping_total']) ? $data['shipping_total'] : 0;
        $this->total_amount = isset($data['total_amount']) ? $data['total_amount'] : 0;
        $this->total_weight = isset($data['total_weight']) ? $data['total_weight'] : 0;
        $this->company_name = isset($data['company_name']) ? $data['company_name'] : 0;
        $this->email = isset($data['email']) ? $data['email'] : 0;
        $this->first_name = isset($data['first_name']) ? $data['first_name'] : 0;
        $this->last_name = isset($data['last_name']) ? $data['last_name'] : 0;
        $this->phone = isset($data['phone']) ? $data['phone'] : 0;
        $this->shipping_method = isset($data['shipping_method']) ? $data['shipping_method'] : 0;
        $this->shipping_name = isset($data['shipping_name']) ? $data['shipping_name'] : 0;
        $this->shipping_address1 = isset($data['shipping_address1']) ? $data['shipping_address1'] : 0;
        $this->shipping_address2 = isset($data['shipping_address2']) ? $data['shipping_address2'] : 0;
        $this->shipping_address3 = isset($data['shipping_address3']) ? $data['shipping_address3'] : 0;
        $this->shipping_city = isset($data['shipping_city']) ? $data['shipping_city'] : 0;
        $this->shipping_state = isset($data['shipping_state']) ? $data['shipping_state'] : 0;
        $this->shipping_country = isset($data['shipping_country']) ? $data['shipping_country'] : 0;

    }

    public function getArrayCopy()
    {
        return get_object_vars($this);
    }
}
