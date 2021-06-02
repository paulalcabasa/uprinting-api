<?php


namespace Customer\ServiceFactory\Controller;


use Customer\Controller\CustomerController;
use Customer\Filter\CustomerFilter;
use Customer\Filter\LoginFilter;
use Customer\Model\Customer;
use Customer\Model\CustomerTable;
use Interop\Container\ContainerInterface;

class CustomerControllerFactory
{

    public function __invoke(ContainerInterface $container)
    {   
        $serviceLocator = $container->getServiceLocator();
		$customerTable = $serviceLocator->get(CustomerTable::class);
  		$customer = $serviceLocator->get(Customer::class);
        $customerFilter = $serviceLocator->get(CustomerFilter::class);
        $loginFilter = $serviceLocator->get(LoginFilter::class);
     
        return new CustomerController(
			$customerTable,
            $customer,
            $customerFilter,
            $loginFilter
        );
    }
}
