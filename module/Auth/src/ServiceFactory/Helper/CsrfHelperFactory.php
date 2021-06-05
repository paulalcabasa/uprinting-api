<?php

namespace Auth\ServiceFactory\Helper;

use Auth\Helper\CsrfHelper;
use Psr\Container\ContainerInterface;

class CsrfHelperFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new CsrfHelper();
    }
}