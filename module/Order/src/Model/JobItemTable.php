<?php

namespace Order\Model;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\ResultSet\Resultset;

class JobItemtable
{
    private $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function insertJobItem($data)
    {
        $this->tableGateway->insert($data);
        return $this->tableGateway->lastInsertValue;
    }

    public function getByJobOrder($id)
    {
        $sql = "SELECT item.job_item_id,
                        product.product_name,
                        product.product_desc,
                        product.product_thumbnail,
                        item.qty,
                        item.price,
                        item.unit_price
                FROM job_items item
                    LEFT JOIN job_orders job_order
                        ON job_order.job_order_id = item.job_order_id
                    LEFT JOIN products product
                        ON product.product_id = item.product_id
                WHERE job_order.job_order_id = " . $id;
        $result = $this->tableGateway->getAdapter()->driver->getConnection()->execute($sql);
     
        $resultSet = new ResultSet();
        $resultSet->initialize($result);
        $result = $resultSet->toArray();
        return $result;
    }

}
