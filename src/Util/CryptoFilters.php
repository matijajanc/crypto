<?php

namespace App\Util;

class CryptoFilters
{
    public function filterPoloniexCryptocurrencies(array $currencies): array
    {
        return array_filter($currencies, function ($item) {
                return (float) $item > 0;
        });
    }
    
    public function filterBinanceCryptocurrencies(array $currencies): array
    {
        return array_filter($currencies['balances'], function ($item) {
            return (float) $item['free'] > 0;
        });
    }
}
