<?php

namespace Application\Service;


use Product\Filter\ProductIDFilter;
use Product\Filter\ProductQuantityFilter;
use Zend\Debug\Debug;
use Zend\InputFilter\InputFilter;

class FilterService
{
    private $productIDFilter;
    private $productQuantityFilter;

    public function __construct(
        ProductIDFilter $productIDFilter,
        ProductQuantityFilter $productQuantityFilter
    ) {
        $this->productIDFilter = $productIDFilter;
        $this->productQuantityFilter = $productQuantityFilter;
    }

    public function isValid(InputFilter $filterClass, $data)
    {
        $filterClass->setData($data);

        if (!$filterClass->isValid()) {
            return [
                "filterFlag" => 0,
                "filterMessages" => $filterClass->getMessages()
            ];
        }

        return [
            "filterFlag" => 1,
            "filterValues" => $filterClass->getValues()
        ];
    }
}