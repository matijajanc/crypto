<?php

namespace App\Service\CalculateCrypto;

use App\Service\Cryptocompare\CryptocompareService;

class CalculateCryptoService
{
    protected $moneyInvested;

    protected $cryptocompare;

    public function __construct($money_invested, CryptocompareService $cryptocompare)
    {
        $this->moneyInvested = $money_invested;
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
        $diff = $this->getDifferenceInInput((float) $eur);      // Correct, transform not correct!!!
        return compact('eur', 'usd', 'diff');
    }

    private function getDifferenceInInput(float $eur)
    {
        return (($this->moneyInvested - $eur)/$this->moneyInvested)*100;
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
                $tokens[$cryptoCode]['tokens'] = $cryptocurrencies[$cryptoCode];
            }
        }
        return $tokens;
    }

    private function priceFormat(float $price)
    {
        return number_format($price, 2, ',', '');
    }
}
