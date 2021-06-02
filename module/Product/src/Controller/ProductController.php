<?php

namespace Product\Controller;

use Zend\View\Model\JsonModel;
use Application\Controller\AppAbstractRestfulController;
use Product\Model\Product;
use Product\Model\ProductTable;

class ProductController extends AppAbstractRestfulController
{

    private $product;
    private $productTable;

    public function __construct(
        Product $product,
        ProductTable $productTable
    )
    {
        $this->product = $product;
        $this->productTable = $productTable;
    }

    // get array - GET no params
    public function getList()
    {
        $products = $this->productTable->getProducts();
        return new JsonModel($products);
    }

    // get with params
    public function get($id)
    {
        // filter for ID
        $product = $this->productTable->getProduct($id);
        return new JsonModel([
            'product' => $product
        ]);
    }

    // POST
    public function create($data)
    {
        return new JsonModel([
            ['message' => 'create data']
        ]);
    }

    // UPDATE
    public function update($id, $data)
    {
        return new JsonModel([
            ['message' => 'update data']
        ]);
    }

    // DELETE
    public function delete($id)
    {
        return new JsonModel([
            ['message' => 'delete data with id' . $id]
        ]);
    }


}