<?php

namespace App\Util;

class CalculateCryptocurrencies
{

    public function calculatePricePerCoin()
    {
        $tokens = $this->apiGetPricemulti();
        foreach ($tokens as $cryptoCode => $item) {
            foreach ($item as $currencyCode => $currency) {
                $tokens[$cryptoCode][$currencyCode.'_PRICE'] = $currency * $this->cryptocurrencys[$cryptoCode];
            }
        }
        return $tokens;
    }
}
