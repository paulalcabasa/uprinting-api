<?php


namespace Customer\Model;

class Customer
{
    
    public $customer_id;
    public $email;
    public $password;
    public $company_name;
    public $first_name;
    public $last_name;
    public $confirm_password;
    public $phone;

    public function exchangeArray($data)
    {
        $this->customer_id = isset($data['customer_id']) ? $data['customer_id'] : null;
        $this->email = isset($data['email']) ? $data['email'] : null;
        $this->password = isset($data['password']) ? $data['password'] : null;
        $this->company_name = isset($data['company_name']) ? $data['company_name'] : null;
        $this->first_name = isset($data['first_name']) ? $data['first_name'] : null;
        $this->last_name = isset($data['last_name']) ? $data['last_name'] : null;
        $this->confirm_password = isset($data['confirm_password']) ? $data['confirm_password'] : null;
        $this->phone = isset($data['phone']) ? $data['phone'] : null;
    }

    public function getArrayCopy()
    {
        return get_object_vars($this);
    }
}
