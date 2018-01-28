<?php

namespace App\Helpers;

class PriceHelper
{
    /**
     * Format Price
     * @param float $price
     * @return string
     */
    public function priceFormat(float $price)
    {
        $decimal = $price < 1 ? 3 : 2;
        return number_format($price, $decimal, ',', '');
    }

    /**
     * Calculate Percantage Difference Between Original & New Value
     * @param float $originalValue
     * @param float $newValue
     * @return float
     */
    public function calculatePercentage(float $originalValue, float $newValue): float
    {
        return ($newValue - $originalValue)/$originalValue * 100;
    }    
}
