<?php

namespace App\Helpers;

class PriceHelper
{
    /**
     * Format Price
     * If price below 1 then round to three decimal places
     * otherwise to two decimal places
     * @param float $price
     * @return string
     */
    public function priceFormat(float $price)
    {
        $decimal = $price < 1 ? 3 : 2;
        return number_format($price, $decimal, ',', '');
    }

    /**
     * Calculate Percentage Difference Between Original & New Value
     * Check If Division by zero
     * @param float $originalValue
     * @param float $newValue
     * @return float
     */
    public function calculatePercentage(float $originalValue, float $newValue): float
    {
        if ($originalValue) {
            return ($newValue - $originalValue)/$originalValue * 100;
        }
        return 0;
    }
}
