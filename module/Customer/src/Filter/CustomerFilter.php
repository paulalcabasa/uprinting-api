<?php


namespace Customer\Filter;

use Zend\Filter\StringTrim;
use Zend\Filter\StripTags;
use Zend\InputFilter\InputFilter;
use Zend\Validator\NotEmpty;
use Zend\Validator\StringLength;
use Zend\Validator\Identical;

class CustomerFilter extends InputFilter
{
    protected $filters = array();

    public function __construct()
    {
     
        $this->add(
            array(
                'name' => 'email',
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
                                NotEmpty::IS_EMPTY => 'Email is required.',
                            )
                        ),
                        'break_chain_on_failure' => true
                    )
                ),
            )
        );

        $this->add(
            array(
                'name' => 'password',
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
                                NotEmpty::IS_EMPTY => 'Password is required.',
                            )
                        ),
                        'break_chain_on_failure' => true
                    )
                ),
            )
        );

        $this->add(
            array(
                'name' => 'confirm_password',
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
                                NotEmpty::IS_EMPTY => 'Confirm Password is required.',
                            )
                        ),
                        'break_chain_on_failure' => true
                    ),
                    array(
                        'name'    => 'Identical',
                        'options' => array(
                            'token' => 'password'
                        ),
                    ),
                ),
            )
        );

        $this->add(
            array(
                'name' => 'first_name',
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
                                NotEmpty::IS_EMPTY => 'First Name is required.',
                            )
                        ),
                        'break_chain_on_failure' => true
                    )
                ),
            )
        );

        $this->add(
            array(
                'name' => 'last_name',
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
                                NotEmpty::IS_EMPTY => 'Last Name is required.',
                            )
                        ),
                        'break_chain_on_failure' => true
                    )
                ),
            )
        );

       
    }


}
