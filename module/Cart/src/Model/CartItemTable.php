<?php

namespace Cart\Model;
use Zend\Db\TableGateway\TableGateway;

class CartItemTable
{
    private $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function insertCartItem($data)
    {
        $this->tableGateway->insert($data);
        return $this->tableGateway->lastInsertValue;
    }

    public function updateCartItem($data)
    {
        return $this->tableGateway->update($data, array('cart_item_id' => $data['cart_item_id']));
    }

    public function getCartItem($cartId, $productId)
    {
        $select = $this->tableGateway->getSql()->select();
        $select->where(
            [
                'cart_id' => $cartId,
                'product_id' => $productId
            ]
        );

        return $this->tableGateway->selectWith($select)->current();
    }

    public function getByCartId($cartId)
    {
        $sql = "SELECT item.cart_item_id,
                        product.product_id,
                        product.product_name,
                        product.product_desc,
                        product.product_image,
                        product.product_thumbnail,
                        item.weight,
                        item.qty,
                        item.unit_price,
                        item.price,
                        product.taxable_flag,
                        product.stock_qty   
                FROM cart_items item 
                    LEFT JOIN products product
                        ON product.product_id = item.product_id
                WHERE cart_id = " . $cartId;
        $stmt = $this->tableGateway->getAdapter()->driver->getConnection()->execute($sql);
        return $stmt;
    }

    public function deleteItem($id)
    {
        return $this->tableGateway->delete(array('cart_item_id' => $id));
    }

    public function updateItem($data)
    {
        return $this->tableGateway->update($data, array('cart_item_id' => $data['cart_item_id']));
    }


}
