<?php

namespace Order\ServiceFactory\Service;
use Psr\Container\ContainerInterface;
use Order\Service\OrderService;

class OrderServiceFactory {

    public function __invoke(ContainerInterface $container)
    {
        return new OrderService();
    }

}