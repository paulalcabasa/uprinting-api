<?php


namespace Customer\Filter;

use Zend\Filter\StringTrim;
use Zend\Filter\StripTags;
use Zend\InputFilter\InputFilter;
use Zend\Validator\NotEmpty;
use Zend\Validator\StringLength;
use Zend\Validator\Identical;



class LoginFilter extends InputFilter
{
    

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
                    ),
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
    }

}
