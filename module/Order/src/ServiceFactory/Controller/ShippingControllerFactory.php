<?php


namespace Order\ServiceFactory\Controller;

use Order\Controller\ShippingController;
use Interop\Container\ContainerInterface;
use Order\Model\Shipping;
use Order\Model\ShippingTable;

class ShippingControllerFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $serviceLocator = $container->getServiceLocator();

        $shipping = $serviceLocator->get(Shipping::class);
        $shippingTable = $serviceLocator->get(ShippingTable::class);

        return new ShippingController(
            $shipping, $shippingTable
        );
    }
}
