<?php

namespace Order\Model;
use Zend\Db\TableGateway\TableGateway;

class JobOrderTable
{
    private $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function insertJobOrder($data)
    {
        $this->tableGateway->insert($data);
        return $this->tableGateway->lastInsertValue;
    }

    public function getJobOrder($jobOrderId)
    {
        $select = $this->tableGateway->getSql()->select();
        $select->where(
            [
                'job_order_id' => $jobOrderId
            ]
        );
        return $this->tableGateway->selectWith($select)->current();
    }

 


}
