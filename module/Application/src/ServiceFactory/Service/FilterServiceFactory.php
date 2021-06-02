<?php

namespace Application\ServiceFactory\Service;

use Application\Service\FilterService;
use Product\Filter\ProductIDFilter;
use Product\Filter\ProductQuantityFilter;
use Psr\Container\ContainerInterface;

class FilterServiceFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $serviceLocator = $container;
        $ProductIDFilter = $serviceLocator->get(ProductIDFilter::class);
        $ProductQuantityFilter = $serviceLocator->get(ProductQuantityFilter::class);

        return new FilterService(
            $ProductIDFilter,
            $ProductQuantityFilter
        );
    }
}