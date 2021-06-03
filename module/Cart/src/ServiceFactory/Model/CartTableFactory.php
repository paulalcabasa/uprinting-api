<?php


namespace Cart\ServiceFactory\Model;

use Cart\Model\Cart;
use Cart\Model\CartTable;
use Psr\Container\ContainerInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

class CartTableFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $dbAdapter = $container->get('uprint_db');

        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype($container->get(Cart::class));
        $tableGateway = new TableGateway('carts', $dbAdapter, null, $resultSetPrototype);

        return new CartTable($tableGateway);
    }
}
