<?php


namespace Cart\ViewHelper;


use Zend\View\Helper\AbstractHelper;

class CartView extends AbstractHelper
{
    public function __construct()
    {
    }

    public function __invoke($template)
    {
        $data = array();

        return $this->getView()->render($template, $data);
    }
}
