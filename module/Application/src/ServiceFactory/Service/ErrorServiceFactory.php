<?php

namespace Application\ServiceFactory\Service;

use Application\Service\ErrorService;
use Psr\Container\ContainerInterface;

class ErrorServiceFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $serviceLocator = $container;

        return new ErrorService();
    }
}