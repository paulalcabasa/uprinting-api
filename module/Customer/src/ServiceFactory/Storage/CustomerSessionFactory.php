<?php

namespace Customer\ServiceFactory\Storage;


use Psr\Container\ContainerInterface;
use Zend\Session\Container;

class CustomerSessionFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new Container('customer');
    }
}