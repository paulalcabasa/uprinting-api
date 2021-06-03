<?php


namespace Cart\ServiceFactory\Model;

use Cart\Model\CartItem;
use Cart\Model\CartItemTable;
use Psr\Container\ContainerInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

class CartItemTableFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $dbAdapter = $container->get('uprint_db');

        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype($container->get(CartItem::class));
        $tableGateway = new TableGateway('cart_items', $dbAdapter, null, $resultSetPrototype);

        return new CartItemTable($tableGateway);
    }
}
