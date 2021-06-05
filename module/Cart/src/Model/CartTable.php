<?php

namespace Cart\Model;
use Zend\Db\TableGateway\TableGateway;

class CartTable
{
    private $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function insertCart($data)
    {
        $this->tableGateway->insert($data);
        return $this->tableGateway->lastInsertValue;
    }

    public function updateCart($data)
    {
        return $this->tableGateway->update($data, array('cart_id' => $data['cart_id']));
    }

    public function getCart($cartId)
    {
        $select = $this->tableGateway->getSql()->select();
        $select->where(
            [
                'cart_id' => $cartId
            ]
        );

        return $this->tableGateway->selectWith($select)->current();
    }

}
