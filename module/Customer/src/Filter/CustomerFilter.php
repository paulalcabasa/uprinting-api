<?php


namespace Customer\Filter;

use Zend\Filter\StringTrim;
use Zend\Filter\StripTags;
use Zend\InputFilter\InputFilter;
use Zend\Validator\NotEmpty;
use Zend\Validator\StringLength;
use Zend\Validator\Identical;
use Zend\Validator\Db\RecordExists;
use Zend\Db\Adapter\Adapter;



class CustomerFilter extends InputFilter
{
    protected $filters = array();

    public function __construct()
    {
     

        $this->filters = array(
            'email' => array(
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
                //     array(
                //         'name'    => RecordExists::class,
                //         'options' => array(
                //  //           'adapter' => $adapter,
                //             'table' => 'customers',
                //             'field' => 'email'
                //         ),
                //     ),
                ),
            ),
            'password' => array(
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
            ),
            'confirm_password' => array(
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
            ),
            'first_name' => array(
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
            ),
            'last_name' => array(
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
