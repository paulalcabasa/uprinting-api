<?php


namespace Product\ServiceFactory\Controller;

use Product\Controller\ProductController;
use Interop\Container\ContainerInterface;
use Product\Model\Product;
use Product\Model\ProductTable;

class ProductControllerFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $serviceLocator = $container->getServiceLocator();

        $product = $serviceLocator->get(Product::class);
        $productTable = $serviceLocator->get(ProductTable::class);


        return new ProductController(
            $product, $productTable
        );
    }
}
