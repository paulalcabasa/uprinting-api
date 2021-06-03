<?php

namespace Cart\ServiceFactory\Storage;


use Psr\Container\ContainerInterface;
use Zend\Session\Container;

class CartSessionFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new Container('cart');
    }
}