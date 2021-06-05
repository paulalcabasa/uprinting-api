<?php

namespace Cart\ServiceFactory\Helper;

use Cart\Helper\CartIdEncryptionHelper;

use Psr\Container\ContainerInterface;

class CartIdEncryptionHelperFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new CartIdEncryptionHelper();
    }
}