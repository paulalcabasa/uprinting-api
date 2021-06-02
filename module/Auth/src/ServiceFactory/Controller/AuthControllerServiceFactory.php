<?php


namespace Auth\ServiceFactory\Controller;


use Application\Service\ErrorService;
use Auth\Controller\AuthController;
use Auth\Service\TokenService;
//use Cart\Filter\CartIDFilter;
//use Cart\Model\CartTable;
use Customer\Filter\LoginFilter;
use Customer\Model\CustomerTable;
use Psr\Container\ContainerInterface;

class AuthControllerServiceFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $serviceLocator = $container->getServiceLocator();
     //   $cartTable = $serviceLocator->get(CartTable::class);
        $customerTable = $serviceLocator->get(CustomerTable::class);
        $errorService = $serviceLocator->get(ErrorService::class);
        $tokenService = $serviceLocator->get(TokenService::class);
       // $cartIDFilter = $serviceLocator->get(CartIDFilter::class);
        $loginFilter = $serviceLocator->get(LoginFilter::class);

        return new AuthController(
          //  $cartTable, 
            $customerTable,
            $errorService, 
            $tokenService,
           // $cartIDFilter, 
            $loginFilter
        );
    }
}