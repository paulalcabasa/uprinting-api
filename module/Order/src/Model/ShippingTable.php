<?php

namespace Order\Model;
use Zend\Db\TableGateway\TableGateway;

class ShippingTable
{
    private $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function getShipping()
    {
        $select = $this->tableGateway->getSql()->select();
        return $this->tableGateway->selectWith($select);
    }

}
