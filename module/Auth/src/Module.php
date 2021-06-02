<?php
namespace Auth;

use Auth\Listener\AuthListener;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

class Module implements ConfigProviderInterface
{
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
                'SecuredController',
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
        return include __DIR__ . '/../config/module.config.php';
    }

    private function exception($e) {
        echo "<span style='font-family: courier new; padding: 2px 5px; background:red; color: white;'> " . $e->getMessage() . '</span><br/>' ;
        echo "<pre>" . $e->getTraceAsString() . '</pre>' ;
    }
}