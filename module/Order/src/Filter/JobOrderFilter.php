<?php


namespace Order\Filter;

use Zend\Filter\StringTrim;
use Zend\Filter\StripTags;
use Zend\InputFilter\InputFilter;
use Zend\Validator\NotEmpty;
use Zend\Validator\StringLength;
use Zend\Validator\Identical;

class JobOrderFilter extends InputFilter
{
    protected $filters = array();

    public function __construct()
    {
        $this->filters = array(
            'shipping_name' => array(
                'name' => 'shipping_name',
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
                    ),
                    array(
                        'name' => 'stringLength',
                        'options' => array(
                            'max' => 35
                        )
                    )
                ),
            ),
            'shipping_address1' => array(
                'name' => 'shipping_address1',
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
                                NotEmpty::IS_EMPTY => 'Address 1 is required.',
                            )
                        ),
                        'break_chain_on_failure' => true
                    )
                    ,
                    array(
                        'name' => 'stringLength',
                        'options' => array(
                            'max' => 35
                        )
                    )
                ),
            ),
            'shipping_city' => array(
                'name' => 'shipping_city',
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
                                NotEmpty::IS_EMPTY => 'City is required.',
                            )
                        ),
                        'break_chain_on_failure' => true
                    )
                    ,
                    array(
                        'name' => 'stringLength',
                        'options' => array(
                            'max' => 35
                        )
                    )
                ),
            ),
            'shipping_state' => array(
                'name' => 'shipping_state',
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
                                NotEmpty::IS_EMPTY => 'State is required.',
                            )
                        ),
                        'break_chain_on_failure' => true
                    )
                    ,
                    array(
                        'name' => 'stringLength',
                        'options' => array(
                            'max' => 35
                        )
                    )
                ),
            ),
            'shipping_country' => array(
                'name' => 'shipping_country',
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
                                NotEmpty::IS_EMPTY => 'Country is required.',
                            )
                        ),
                        'break_chain_on_failure' => true
                    )
                    ,
                    array(
                        'name' => 'stringLength',
                        'options' => array(
                            'max' => 35
                        )
                    )
                ),
                
            )
        );
    }

    public function setInputFilter($formData)
    {
        if ($formData) {
            $inputFields = array_keys($formData);

            foreach ($inputFields as $key) {
                if (isset($this->filters[$key])) {
                    $this->add($this->filters[$key]);
                }
            }
        }
    }
}
