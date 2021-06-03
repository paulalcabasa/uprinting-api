<?php


namespace Cart\Filter;

use Zend\Filter\StringTrim;
use Zend\Filter\StripTags;
use Zend\InputFilter\InputFilter;


class CartIdFilter extends InputFilter
{
    protected $filters = array();

    public function __construct()
    {
        $this->add(
            array(
                'name' => 'cart_id',
                'required' => true,
                'filters' => array(
                    array('name' => StripTags::class),
                    array('name' => StringTrim::class)
                ),
                'validators' => array(
                    array(
                        'name' => NotEmpty::class,
                        'options' => array(
                            'messages' => array(
                                NotEmpty::IS_EMPTY => 'Shipping Name is required.',
                            )
                        ),
                        'break_chain_on_failure' => true
                    )
                ),
            )
        );
    }

  
}
