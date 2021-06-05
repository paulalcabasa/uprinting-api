<?php

namespace Auth\Controller;

use Application\Controller\AppAbstractRestfulController;
use Zend\Http\Response;
use Zend\View\Model\JsonModel;
use Auth\Helper\CsrfHelper;

class CsrfController extends AppAbstractRestfulController
{

    private $CsrfHelper;
    
    public function __construct(
        CsrfHelper $csrfHelper
    ) {
       
 
        $this->CsrfHelper = $csrfHelper;
    }

    public function create($formName)
    {
        $token = $this->CsrfHelper->generateCsrfToken($formName);         
        return new JsonModel([
            "csrfToken" => $token
        ]);
    }
    

    
}
