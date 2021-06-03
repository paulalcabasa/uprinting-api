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
use Psr\Container\ContainerInterface;


use Product\Model\Product;
use Product\Model\ProductTable;

class OrderControllerFactory
{
  
    public function __invoke(ContainerInterface $container)
    {
		$CustomerSessionContainer = $container->get('CustomerSessionContainer');
		$CartSessionContainer = $container->get('CartSessionContainer');
		
		$jobOrderFilter = $container->get(JobOrderFilter::class);
		
		$jobOrder = $container->get(JobOrder::class);
		$jobOrderTable = $container->get(JobOrderTable::class);

		$jobItem = $container->get(JobItem::class);
		$jobItemTable = $container->get(JobItemTable::class);

		$cartItem = $container->get(CartItem::class);
		$cartItemTable = $container->get(CartItemTable::class);

		$shipping = $container->get(Shipping::class);
		$shippingTable = $container->get(ShippingTable::class);
		
		$cart = $container->get(Cart::class);
		$cartTable = $container->get(CartTable::class);
		
		$productTable = $container->get(ProductTable::class);
        $product = $container->get(Product::class);

		return new OrderController(
			$CustomerSessionContainer,
			$CartSessionContainer,
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
            $product
		);
    }
}
