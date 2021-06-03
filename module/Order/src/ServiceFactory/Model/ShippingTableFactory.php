<?php


namespace Order\ServiceFactory\Model;


use Order\Model\Shipping;
use Order\Model\ShippingTable;
use Psr\Container\ContainerInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

class ShippingTableFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $dbAdapter = $container->get('uprint_db');

        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype($container->get(Shipping::class));
        $tableGateway = new TableGateway('shipping', $dbAdapter, null, $resultSetPrototype);

        return new ShippingTable($tableGateway);
    }
}
