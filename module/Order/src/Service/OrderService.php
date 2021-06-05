<?php

namespace Order\Service;

class OrderService 
{

    public function computeWeight($cartItems)
    {   
        $totalWeight = 0;

        foreach($cartItems as $item){
           if($item['taxable_flag'] == 'y') {
               $taxableAmount += $item['price'] * $item['qty'];
               $tax += ($item['price'] * $item['qty']) * 0.1;
           }
           $totalWeight += $item['weight'] * $item['qty'];
        }

        return $totalWeight;
    }


}