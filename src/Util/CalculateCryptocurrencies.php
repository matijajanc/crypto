<?php

namespace App\Util;

use App\Service\Cryptocompare\CryptocompareService;

class CalculateCryptocurrencies
{
    protected $cryptocompare;

    public function __construct(CryptocompareService $cryptocompare)
    {
        $this->cryptocompare = $cryptocompare;
    }

    public function calcCryptocurrencies(array $cryptocurrencies): array
    {
        return $this->calculatePricePerCoin($this->mergeCryptocurrencies($cryptocurrencies));
    }

    public function sumCryptocurrencies(array $cryptocurrencies): array
    {
        $eur = 0;
        $usd = 0;
        foreach ($cryptocurrencies as $cryptocurrency) {
            $eur += $cryptocurrency['EUR_PRICE'];
            $usd += $cryptocurrency['USD_PRICE'];
        }
        $eur = $this->priceFormat($eur);
        $usd = $this->priceFormat($usd);
        return compact('eur', 'usd');
    }

    private function mergeCryptocurrencies($balances)
    {
        $merged = [];
        foreach ($balances as $balanceLocation) {
            foreach ($balanceLocation as $key => $value) {
                if(array_key_exists($key, $merged)) {
                    $merged[$key] += (float) $value;
                } else {
                    $merged[$key] = (float) $value;
                }
            }
        }
        return $merged;
    }

    private function calculatePricePerCoin(array $cryptocurrencies): array
    {
        $tokens = $this->cryptocompare->getMultiPrices();
        foreach ($tokens as $cryptoCode => $item) {
            foreach ($item as $currencyCode => $currency) {
                $tokens[$cryptoCode][$currencyCode.'_PRICE'] = $currency * $cryptocurrencies[$cryptoCode];
            }
        }
        return $tokens;
    }

    private function priceFormat(float $price)
    {
        return number_format($price, 2, ',', '');
    }
}
