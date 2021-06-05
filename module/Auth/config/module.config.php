<?php
namespace Auth;

use Auth\Controller\AuthController;
use Auth\Service\TokenService;
use Auth\ServiceFactory\Controller\AuthControllerServiceFactory;
use Auth\ServiceFactory\Service\TokenServiceFactory;
use Zend\Mvc\Router\Http\Segment;
use Auth\Model\Cart;
use Auth\Model\CartTable;


use Auth\Controller\CsrfController;
use Auth\ServiceFactory\Controller\CsrfControllerFactory;
use Auth\Helper\CsrfHelper;
use Auth\ServiceFactory\Helper\CsrfHelperFactory;

return [
    'router' => [
        'routes' => [
            'auth' => [
                'type'    => Segment::class,
                'options' => [
                    'route' => '/auth[/:id]',
                    'constraints' => [
                        'id' => '[0-9]+',
                    ],
                    'defaults' => [
                        'controller' => AuthController::class
                    ],
                ],
            ],
            'csrf' => [
                'type'    => Segment::class,
                'options' => [
                    'route' => '/csrf[/:formName]',
                    'constraints' => [
                        'id' => '[0-9]+',
                    ],
                    'defaults' => [
                        'controller' => CsrfController::class
                    ],
                ],
            ]
        ],
    ],
    'controllers' => [
        'factories' => [
            AuthController::class => AuthControllerServiceFactory::class,
            CsrfController::class => CsrfControllerFactory::class
        ]
    ],
    'service_manager' => [
        'factories' => [
            TokenService::class => TokenServiceFactory::class,
            CsrfHelper::class => CsrfHelperFactory::class,
        ],
    ],
    'view_manager' => [
        'display_not_found_reason' => true,
        'display_exceptions' => true,
        'doctype' => 'HTML5',
        'not_found_template' => 'error/404',
        'exception_template' => 'error/index',
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
        'strategies' => array(
            'ViewJsonStrategy',
        ),
    ],
];