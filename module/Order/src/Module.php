<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Order;

use Zend\Stdlib\ArrayUtils;

/* for api security */
use Auth\Listener\AuthListener;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

class Module implements ConfigProviderInterface
{
    const VERSION = '3.0.3-dev';

    public function onBootstrap(MvcEvent $e)
    {
        $eventManager = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
        $request = $e->getApplication()->getRequest();
        
        $sm = $e->getApplication()->getServiceManager();

        $httpMethod = $request->getMethod();
        
        if ($httpMethod != 'OPTIONS') {
           
            $eventManager->getSharedManager()->attach(
                'OrderController',
                'dispatch',
                function ($e) use ($sm) {
                    $authListener = new AuthListener();
                    return $authListener($e);
                },
                2
            );

        }

        //Attach render errors
        $eventManager->attach(MvcEvent::EVENT_RENDER_ERROR, function($e)  {
            if ($e->getParam('exception')) {
                $this->exception( $e->getParam('exception') ) ; //Custom error render function.
            }
        } );
        //Attach dispatch errors
        $eventManager->attach(MvcEvent::EVENT_DISPATCH_ERROR, function($e)  {
            if ($e->getParam('exception')) {
                $this->exception( $e->getParam('exception') ) ;//Custom error render function.
            }
        } );
    }


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

    private function exception($e) {
        echo "<span style='font-family: courier new; padding: 2px 5px; background:red; color: white;'> " . $e->getMessage() . '</span><br/>' ;
        echo "<pre>" . $e->getTraceAsString() . '</pre>' ;
    }
}
