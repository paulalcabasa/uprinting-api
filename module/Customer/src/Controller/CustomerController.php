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

class CustomerController extends AppAbstractRestfulController
{   

    private $customerTable;
    private $customer;
    private $customerFilter;
    private $loginFilter;

    public function __construct(
        CustomerTable $customerTable,
        Customer $customer,
        CustomerFilter $customerFilter,
        LoginFilter $loginFilter
    )
    {
        $this->customerTable = $customerTable;
        $this->customer = $customer;
        $this->customerFilter = $customerFilter;
        $this->loginFilter = $loginFilter;
    }

    public function getList()
    {
        $customers = $this->customerTable->getCustomers();
        return new JsonModel($customers);
    }

}
