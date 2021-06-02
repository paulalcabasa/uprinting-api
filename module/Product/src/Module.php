<?php
namespace Product;

use Zend\Stdlib\ArrayUtils;

class Module
{
    const VERSION = '3.0.3-dev';

    public function getConfig()
    {
        $config = array();
        // get config files
        $configFiles = array(
            __DIR__ . '/../config/module.config.services.php',
            __DIR__ . '/../config/module.config.routes.php'
        );

        foreach($configFiles as $configFile) {
            if (file_exists($configFile)) {
                $config = ArrayUtils::merge($config, include $configFile);
            }
        }

        return $config;
    }
}
