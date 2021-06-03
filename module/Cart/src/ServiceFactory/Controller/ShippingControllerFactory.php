<?php


namespace Cart\ServiceFactory\Controller;


use Cart\Controller\ShippingController;
// use Album\Filter\AlbumFilter;

use Psr\Container\ContainerInterface;

class ShippingControllerFactory
{
    // 
    public function __invoke(ContainerInterface $container)
    {
        $CartSessionContainer = $container->get('CartSessionContainer');
        $CustomerSessionContainer = $container->get('CustomerSessionContainer');

        return new ShippingController(
          $CartSessionContainer,
		  $CustomerSessionContainer
        );
    }
}
