<?php
/**
 * Global Configuration Override
 *
 * You can use this file for overriding configuration values from modules, etc.
 * You would place values in here that are agnostic to the environment and not
 * sensitive to security.
 *
 * @NOTE: In practice, this file will typically be INCLUDED in your source
 * control, so do not include passwords or other sensitive information in this
 * file.
 */

return [
    'service_manager' => array(
        'abstract_factories' => array(
            'Zend\Db\Adapter\AdapterAbstractServiceFactory',
        ),
    ),
    'db' => [
        'adapters' => [
            'uprint_db' => [
                'dsn'       => 'mysql:dbname=uprint;host=localhost',
                'username' => 'root',
                'password' => '',
                'driver'    => 'Pdo',
                'driver_options' => array(
                    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''
                ),
            ]
        ]
    ],
    'session_config' => [
        'remember_me_seconds' => 172800,
        'use_cookies' => true,
        'cookie_domain' => '.local.com',
    ]
];
