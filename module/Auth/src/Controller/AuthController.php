<?php

namespace Auth\Controller;

use Application\Controller\AppAbstractRestfulController;
use Application\Service\ErrorService;
use Auth\Service\TokenService;

// use Cart\Filter\CartIDFilter;
// use Cart\Model\CartTable;

use Customer\Filter\LoginFilter;
use Customer\Model\CustomerTable;

use Zend\Http\Response;
use Zend\View\Model\JsonModel;

class AuthController extends AppAbstractRestfulController
{
    //private $cartTable;
    //private $cartIDFilter;

    private $customerTable;
    private $errorService;
    private $tokenService;
    private $loginFilter;

    public function __construct(
        //CartTable $cartTable,
        CustomerTable $customerTable,
        ErrorService $errorService,
        TokenService $tokenService,
        //CartIDFilter $cartIDFilter,
        LoginFilter $loginFilter
    ) {
        //$this->cartTable = $cartTable;
        $this->customerTable = $customerTable;
        $this->errorService = $errorService;
        $this->tokenService = $tokenService;
        //$this->cartIDFilter = $cartIDFilter;
        $this->loginFilter = $loginFilter;
    }

    public function create($postData)
    {
        
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

        return new JsonModel(["token" => $token]);
    }
}
