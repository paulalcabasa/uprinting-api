<?php

namespace Customer\Model;
use Zend\Db\TableGateway\TableGateway;

class CustomerTable
{
    private $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function insertCustomer($data)
    {
        $this->tableGateway->insert($data);
        return $this->tableGateway->lastInsertValue;
    }

    public function getCustomer($credentials)
    {
        $select = $this->tableGateway->getSql()->select();
        $select->where(
            [
                'email' => $credentials['email'],
                'password' => $credentials['password']
            ]
        );
        return $this->tableGateway->selectWith($select)->current();
    }

    public function getCustomers()
    {
        $select = $this->tableGateway->getSql()->select();
        return $this->tableGateway->selectWith($select);
    }

    public function isExist($email)
    {
        $select = $this->tableGateway->getSql()->select();
        $select->where(
            [
                'email' => $email,
            ]
        );
        return $this->tableGateway->selectWith($select)->current();
    }

}
