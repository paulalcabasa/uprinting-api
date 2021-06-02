<?php


namespace Product\ServiceFactory\Model;


use Product\Model\Product;
use Product\Model\ProductTable;
use Psr\Container\ContainerInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

class ProductTableFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $dbAdapter = $container->get('uprint_db');
        
        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype($container->get(Product::class));
        $tableGateway = new TableGateway('products', $dbAdapter, null, $resultSetPrototype);

        return new ProductTable($tableGateway);
    }
}
