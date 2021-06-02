<?php

namespace Application\ServiceFactory\Service;

use Application\Service\NullRemoverService;
use Psr\Container\ContainerInterface;

class NullRemoverServiceFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $serviceLocator = $container;

        return new NullRemoverService();
    }
}