<?php
namespace Customer;

use Customer\Controller\CustomerController;
use Customer\Filter\CustomerFilter;
use Customer\Filter\LoginFilter;
use Customer\Model\Customer;
use Customer\Model\CustomerTable;
use Customer\ServiceFactory\Controller\CustomerControllerFactory;
use Customer\ServiceFactory\Model\CustomerTableFactory;


return array(
    'controllers' => [
        'factories' => [
            CustomerController::class => CustomerControllerFactory::class
        ]
    ],
    'service_manager' => [
        'invokables' => [
            Customer::class => Customer::class,
            CustomerFilter::class => CustomerFilter::class,
            LoginFilter::class => LoginFilter::class,
        ],
        'factories' => [
            CustomerTable::class => CustomerTableFactory::class
        ]
    ],
    'view_manager' => array(
        'strategies' => array(
            'ViewJsonStrategy'
        ),
    )
);
