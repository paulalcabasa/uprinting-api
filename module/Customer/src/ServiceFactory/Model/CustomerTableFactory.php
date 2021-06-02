<?php


namespace Customer\ServiceFactory\Model;


use Customer\Model\Customer;
use Customer\Model\CustomerTable;
use Psr\Container\ContainerInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

class CustomerTableFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $dbAdapter = $container->get('uprint_db');

        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype($container->get(Customer::class));
        $tableGateway = new TableGateway('customers', $dbAdapter, null, $resultSetPrototype);

        return new CustomerTable($tableGateway);
    }
}
