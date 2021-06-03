<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Customer\Controller;

use Application\Controller\AppAbstractRestfulController;
use Customer\Model\Customer;
use Customer\Model\CustomerTable;
use Customer\Filter\CustomerFilter;
use Customer\Filter\loginFilter;
use Zend\View\Model\JsonModel;
use Auth\Service\TokenService;

class CustomerController extends AppAbstractRestfulController
{   

    private $customerTable;
    private $customer;
    private $customerFilter;
    private $loginFilter;
    private $tokenService;

    public function __construct(
        CustomerTable $customerTable,
        Customer $customer,
        CustomerFilter $customerFilter,
        LoginFilter $loginFilter,
        TokenService $tokenService
    )
    {
        $this->customerTable = $customerTable;
        $this->customer = $customer;
        $this->customerFilter = $customerFilter;
        $this->loginFilter = $loginFilter;
        $this->tokenService = $tokenService;
    }

    public function create($data)
    {
    
        $errors = [];

        $this->customer->exchangeArray($data);
        $this->customerFilter->setData($this->customer->getArrayCopy());
    
        if (!$this->customerFilter->isValid()) {
            return new JsonModel([
                'state' => false,
                'errors' => $this->customerFilter->getMessages()
            ]);
        }

        $isExist = $this->customerTable->isExist($this->customer->email);
        
        if($isExist) {
            return new JsonModel([
                'state' => false,
                'errors' => [
                    'mail' => 'E-mail already exist.'
                ]
            ]);
        }

        $form = $this->customer->getArrayCopy();
        
        // remove cause this is not stored in db
        unset($form['confirm_password']);

        $customerId = $this->customerTable->insertCustomer($form);
                    
        if ($customerId) {

            $token = $this->tokenService->generateToken([
                "customer_id" => $customerId,
                "first_name" => $this->customer->first_name]);
    
            return new JsonModel([
                'state' => true,
                'token' => $token,
                'message' => 'Registration successful.'
            ]);
        }
   
    }

    public function getList()
    {
        $customers = $this->customerTable->getCustomers();
        return new JsonModel($customers);
    }

}
