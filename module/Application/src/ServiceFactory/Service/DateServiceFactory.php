<?php

namespace Application\ServiceFactory\Service;

use Application\Service\DateService;
use Psr\Container\ContainerInterface;

class DateServiceFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $serviceLocator = $container;

        return new DateService();
    }
}