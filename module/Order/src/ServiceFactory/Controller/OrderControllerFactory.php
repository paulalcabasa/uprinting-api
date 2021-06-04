<?php


namespace Order\ServiceFactory\Controller;


use Order\Controller\OrderController;

use Order\Model\JobOrder;
use Order\Model\JobOrderTable;

use Order\Model\JobItem;
use Order\Model\JobItemTable;
use Order\Filter\JobOrderFilter;

use Cart\Model\CartItem;
use Cart\Model\CartItemTable;

use Order\Model\Shipping;
use Order\Model\ShippingTable;

use Cart\Model\Cart;
use Cart\Model\CartTable;

use Interop\Container\ContainerInterface;


use Customer\Model\Customer;
use Customer\Model\CustomerTable;

use Product\Model\Product;
use Product\Model\ProductTable;

use Auth\Service\TokenService;

class OrderControllerFactory
{
  
    public function __invoke(ContainerInterface $container)
    {
		
		$serviceLocator = $container->getServiceLocator();

		$jobOrderFilter = $serviceLocator->get(JobOrderFilter::class);
		
		$jobOrder = $serviceLocator->get(JobOrder::class);
		$jobOrderTable = $serviceLocator->get(JobOrderTable::class);

		$jobItem = $serviceLocator->get(JobItem::class);
		$jobItemTable = $serviceLocator->get(JobItemTable::class);

		$cartItem = $serviceLocator->get(CartItem::class);
		$cartItemTable = $serviceLocator->get(CartItemTable::class);

		$shipping = $serviceLocator->get(Shipping::class);
		$shippingTable = $serviceLocator->get(ShippingTable::class);
		
		$cart = $serviceLocator->get(Cart::class);
		$cartTable = $serviceLocator->get(CartTable::class);
		
		$productTable = $serviceLocator->get(ProductTable::class);
        $product = $serviceLocator->get(Product::class);

		$customerTable = $serviceLocator->get(CustomerTable::class);
        $customer = $serviceLocator->get(Customer::class);

		$tokenService = $serviceLocator->get(TokenService::class);

		return new OrderController(
			$jobOrderTable,
			$jobOrder,
			
			$jobItemTable,
			$jobItem,

			$jobOrderFilter,

			$cartItem,
			$cartItemTable,

			$shipping,
			$shippingTable,

			$cart,
			$cartTable,

			$productTable,
            $product,

			$customerTable,
			$customer,

			$tokenService
		);
    }
}
