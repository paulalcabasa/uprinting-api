<?php

namespace Auth\Controller;

use Application\Controller\AppAbstractRestfulController;
use Application\Service\ErrorService;
use Auth\Service\TokenService;

// use Cart\Filter\CartIDFilter;
use Cart\Model\CartTable;

use Customer\Filter\LoginFilter;
use Customer\Model\CustomerTable;

use Zend\Http\Response;
use Zend\View\Model\JsonModel;

use Auth\Helper\CsrfHelper;

class AuthController extends AppAbstractRestfulController
{
    private $cartTable;
    //private $cartIDFilter;

    private $customerTable;
    private $errorService;
    private $tokenService;
    private $loginFilter;
    private $csrfHelper;


    public function __construct(
        CartTable $cartTable,
        CustomerTable $customerTable,
        ErrorService $errorService,
        TokenService $tokenService,
        LoginFilter $loginFilter,
        CsrfHelper $csrfHelper
    ) {
        $this->cartTable = $cartTable;
        $this->customerTable = $customerTable;
        $this->errorService = $errorService;
        $this->tokenService = $tokenService;
        //$this->cartIDFilter = $cartIDFilter;
        $this->loginFilter = $loginFilter;
        $this->csrfHelper = $csrfHelper;
    }

    public function create($postData)
    {
        
        $checkCsrf = $this->csrfHelper->verifyCsrfToken(
            $postData['csrfToken'],
           // 'error token',
            $postData['formName']
        );


        if(!$checkCsrf) {
            $validationError = $this->errorService->prepareCustomErrorMessage(
                "Login", "invalidCsrfToken", "CSRF Token is not valid!");
            $this->getResponse()->setStatusCode(Response::STATUS_CODE_401);
            return new JsonModel($validationError);
        }

        $this->loginFilter->setData($postData);
        
        if (!$this->loginFilter->isValid()) {
            $validationErrors = $this->loginFilter->getMessages();
            $this->getResponse()->setStatusCode(Response::STATUS_CODE_412);
            return new JsonModel(["errors" => $validationErrors]);
        }

        $postUserData = $this->loginFilter->getValues();
     
        $credentials = [
            'email' => $postUserData['email'], 
            'password' => $postUserData['password']
        ];

        $customerDetails = $this->customerTable->getCustomer($credentials);
        
        if (count($customerDetails) == 0) {
            $validationError = $this->errorService->prepareCustomErrorMessage(
                "Login", "incorrectCredentials", "Incorrect email and password");
            $this->getResponse()->setStatusCode(Response::STATUS_CODE_401);
            
            return new JsonModel(["errors" => $validationError]);
        }

        $token = $this->tokenService->generateToken([
            "customer_id" => $customerDetails->customer_id,
            "first_name" => $customerDetails->first_name]);
        
        $cartId = $postData['cartId'];
        
        if($cartId) {
            $this->cartTable->updateCart([
                'cart_id' => $cartId,
                'customer_id' => $customerDetails->customer_id
            ]);
        } 
         
        return new JsonModel([
            "token" => $token,
            "state" => true
        ]);
    }

    
}
