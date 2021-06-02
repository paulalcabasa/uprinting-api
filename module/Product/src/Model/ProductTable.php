<?php

namespace Product\Model;
use Zend\Db\TableGateway\TableGateway;

class ProductTable
{
    private $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function getProducts()
    {
        $select = $this->tableGateway->getSql()->select();
        return $this->tableGateway->selectWith($select);
    }

    public function getProduct($productId)
    {
        $select = $this->tableGateway->getSql()->select();
        $select->where(
            [
                'product_id' => $productId
            ]
        );

        return $this->tableGateway->selectWith($select)->current();
    }

    public function updateProduct($data)
    {
        return $this->tableGateway->update($data, array('product_id' => $data['product_id']));
    }

}
