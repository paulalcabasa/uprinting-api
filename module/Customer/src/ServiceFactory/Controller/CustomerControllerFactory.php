<?php


namespace Customer\ServiceFactory\Controller;


use Customer\Controller\CustomerController;
use Customer\Filter\CustomerFilter;
use Customer\Filter\LoginFilter;
use Customer\Model\Customer;
use Customer\Model\CustomerTable;
use Interop\Container\ContainerInterface;
use Auth\Service\TokenService;
use Auth\Helper\CsrfHelper;
use Cart\Model\CartTable;
use Application\Service\ErrorService;
class CustomerControllerFactory
{

    public function __invoke(ContainerInterface $container)
    {   
        $serviceLocator = $container->getServiceLocator();
		$customerTable = $serviceLocator->get(CustomerTable::class);
  		$customer = $serviceLocator->get(Customer::class);
        $customerFilter = $serviceLocator->get(CustomerFilter::class);
        $loginFilter = $serviceLocator->get(LoginFilter::class);
        $tokenService = $serviceLocator->get(TokenService::class);
        $cartTable = $serviceLocator->get(CartTable::class);
        $csrfHelper = $serviceLocator->get(CsrfHelper::class);
        $errorService = $serviceLocator->get(ErrorService::class);

        return new CustomerController(
			$customerTable,
            $customer,
            $customerFilter,
            $loginFilter,
            $tokenService,
            $cartTable,
            $csrfHelper,
            $errorService
        );
    }
}
