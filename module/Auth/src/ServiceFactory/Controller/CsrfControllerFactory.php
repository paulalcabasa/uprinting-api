<?php


namespace Auth\ServiceFactory\Controller;
use Interop\Container\ContainerInterface;
use Auth\Helper\CsrfHelper;
use Auth\Controller\CsrfController;

class CsrfControllerFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $serviceLocator = $container->getServiceLocator();
        $csrfHelper = $serviceLocator->get(CsrfHelper::class);

        return new CsrfController(
            $csrfHelper
        );
    }
}