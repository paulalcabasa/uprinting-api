<?php


namespace Order\ServiceFactory\Model;


use Order\Model\JobOrder;
use Order\Model\JobOrderTable;
use Psr\Container\ContainerInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

class JobOrderTableFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $dbAdapter = $container->get('uprint_db');

        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype($container->get(JobOrder::class));
        $tableGateway = new TableGateway('job_orders', $dbAdapter, null, $resultSetPrototype);

        return new JobOrderTable($tableGateway);
    }
}
