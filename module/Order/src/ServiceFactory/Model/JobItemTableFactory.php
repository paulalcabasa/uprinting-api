<?php


namespace Order\ServiceFactory\Model;


use Order\Model\JobItem;
use Order\Model\JobItemTable;
use Psr\Container\ContainerInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

class JobItemTableFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $dbAdapter = $container->get('uprint_db');

        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype($container->get(JobItem::class));
        $tableGateway = new TableGateway('job_items', $dbAdapter, null, $resultSetPrototype);

        return new JobItemTable($tableGateway);
    }
}
