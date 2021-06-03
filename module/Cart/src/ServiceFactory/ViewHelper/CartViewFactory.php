<?php


namespace Cart\ServiceFactory\ViewHelper;


use Cart\ViewHelper\CartView;
use Psr\Container\ContainerInterface;

class CartViewFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new CartView();
    }
}
