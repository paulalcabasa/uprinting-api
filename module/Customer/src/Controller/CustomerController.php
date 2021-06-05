<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Customer\Controller;

use Application\Controller\AppAbstractRestfulController;
use Application\Service\ErrorService;
use Customer\Model\Customer;
use Customer\Model\CustomerTable;
use Customer\Filter\CustomerFilter;
use Customer\Filter\loginFilter;
use Zend\View\Model\JsonModel;
use Auth\Service\TokenService;
use Cart\Model\CartTable;
use Auth\Helper\CsrfHelper;
use Zend\Http\Response;
class CustomerController extends AppAbstractRestfulController
{   

    // these are classes and must be capitalized
    private $CustomerTable;
    private $Customer;
    private $CustomerFilter;
    private $LoginFilter;
    private $TokenService;
    private $CartTable;
    private $CsrfHelper;
    private $ErrorService;

    public function __construct(
        // for parameter oks lang camel case
        CustomerTable $customerTable,
        Customer $customer,
        CustomerFilter $customerFilter,
        LoginFilter $loginFilter,
        TokenService $tokenService,
        CartTable $cartTable,
        CsrfHelper $csrfHelper,
        ErrorService $errorService
    )
    {
        $this->CustomerTable = $customerTable;
        $this->Customer = $customer;
        $this->CustomerFilter = $customerFilter;
        $this->LoginFilter = $loginFilter;
        $this->TokenService = $tokenService;
        $this->CartTable = $cartTable;
        $this->CsrfHelper = $csrfHelper;
        $this->ErrorService = $errorService;
    }

    public function create($data)
    {
        
        $checkCsrf = $this->CsrfHelper->verifyCsrfToken(
            $data['csrfToken'],
            //'error token',
            $data['formName']
        );


        if(!$checkCsrf) {
            $validationError = $this->ErrorService->prepareCustomErrorMessage(
                "Login", "invalidCsrfToken", "CSRF Token is not valid!");
            $this->getResponse()->setStatusCode(Response::STATUS_CODE_401);
            return new JsonModel($validationError);
        }

        $errors = [];

        $this->Customer->exchangeArray($data);
        
        $this->CustomerFilter->setData($this->Customer->getArrayCopy());
    

        if (!$this->CustomerFilter->isValid()) {
            return new JsonModel([
                'state' => false,
                'errors' => $this->CustomerFilter->getMessages()
            ]);
        }

        $isExist = $this->CustomerTable->isExist($this->Customer->email);
        
        if($isExist) {
            return new JsonModel([
                'state' => false,
                'errors' => [
                    'mail' => 'E-mail already exist.'
                ]
            ]);
        }

        $form = $this->Customer->getArrayCopy();
        
        // remove cause this is not stored in db
        unset($form['confirm_password']);

        $customerId = $this->CustomerTable->insertCustomer($form);
                    
        if ($customerId) {

            $token = $this->TokenService->generateToken([
                "customer_id" => $customerId,
                "first_name" => $this->Customer->first_name]);
    
            $cartId = $data['cartId'];
        
            if($cartId) {
                $this->CartTable->updateCart([
                    'cart_id' => $cartId,
                    'customer_id' => $customerId
                ]);
            } 

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
