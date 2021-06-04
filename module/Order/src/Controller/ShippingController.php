<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Order\Controller;

use Application\Controller\AppAbstractRestfulController;

use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;

use Order\Model\Shipping;
use Order\Model\ShippingTable;

use Cart\Model\CartItem;
use Cart\Model\CartItemTable;

class ShippingController extends AppAbstractRestfulController
{   
    private $shipping;
    private $shippingTable;

    private $CartItem;
    private $CartItemTable;
    
    public function __construct(
        Shipping $shipping,
        ShippingTable $shippingTable,
        CartItem $cartItem,
        CartItemTable $cartItemTable
    )
    {
       
        $this->shippingTable = $shippingTable;
        $this->shipping = $shipping;

        $this->CartItem = $cartItem;
        $this->CartItemTable = $cartItemTable;
        
        // $this->cartId = $this->cartSessionContainer->cartId;
        // $this->shippingRates = $this->getShippingRates();
        // $this->totalWeight = $this->computeTotalWeight();
    }

    public function get($cartId)
    {

        $totalWeight = 0;

     

        //get shipping rates from database
        $ratesTable = $this->shippingTable->getShipping();
        $shippingRates = array();
        foreach ( $ratesTable as $value ) {
            $shippingRates[$value->shipping_method][] = $value;
        }
        
        // cart items
        $cartItems = $this->CartItemTable->getByCartId($cartId);
        // parse cart items from local storage to get weight
        foreach($cartItems as $item) {
           $totalWeight += ($item['weight'] * $item['qty']);
        }

        $weightBalance = [
            'Ground' => $totalWeight,
            'Expedited' => $totalWeight
        ];

        $ratesPerMethod = [
            'Ground' => 0,
            'Expedited' => 0
        ];

        $maxRates = [
            'Ground' => [
                'rate' => 0,
                'weight' => 0
            ],
            'Expedited' => [
                'rate' => 0,
                'weight' => 0
            ],
        ];

        // if does not exceed the weight limit
        foreach($shippingRates as $method => $rates) {
            foreach($rates as $rate) {

                if($rate->max_weight > $maxRates[$method]['weight']) {
                    $maxRates[$method]['weight'] = $rate->max_weight;
                    $maxRates[$method]['rate'] = $rate->shipping_rate;
                }

                if($rate->min_weight <= $weightBalance['Ground'] && $rate->max_weight >= $weightBalance['Ground']){ 
                    $ratesPerMethod[$method] += $rate->shipping_rate;
                }

            }
        }

        // if exceeds weight limit
        if($ratesPerMethod['Ground'] == 0 && $ratesPerMethod['Expedited'] == 0) {
            while($weightBalance['Ground'] > 0) {
                if($weightBalance['Ground'] >= $maxRates['Ground']['weight']) {
                    $ratesPerMethod['Ground'] += $maxRates['Ground']['rate'];
                    $ratesPerMethod['Expedited'] += $maxRates['Expedited']['rate'];
                    $weightBalance['Ground'] -= $maxRates['Ground']['weight']; 
                    $weightBalance['Expedited'] -= $maxRates['Expedited']['weight']; 
                }
                else {
                    foreach($shippingRates as $method => $rates) {
                        foreach($rates as $rate) {   
                            if($rate->min_weight <= $weightBalance[$method] && $rate->max_weight >= $weightBalance[$method]){ 
                                $ratesPerMethod[$method] += $rate->shipping_rate;
                                $weightBalance[$method] -= $rate->max_weight;
                            }
                            else {
                            
                                $weightBalance[$method]--;
                            }
                        }
                   }
                }   
            }   
        }

        return new JsonModel([
            'totalWeight' => $totalWeight,
            'ratesPerMethod' => $ratesPerMethod
        ]);
    }

}
