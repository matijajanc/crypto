<?php

namespace App\Service\CalculateCrypto;

use App\Service\Cryptocompare\CryptocompareService;

class CalculateCryptoService
{
    /**
     * @var
     */
    protected $moneyInvested;

    /**
     * @var
     */
    protected $cryptocurrencies;

    /**
     * @var CryptocompareService
     */
    protected $cryptocompare;

    /**
     * CalculateCryptoService constructor.
     * @param $money_invested
     * @param $cryptocurrencies
     * @param CryptocompareService $cryptocompare
     */
    public function __construct($money_invested, $cryptocurrencies, CryptocompareService $cryptocompare)
    {
        $this->moneyInvested = $money_invested;
        $this->cryptocurrencies = $cryptocurrencies;
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
        $diff = $this->calculatePercentage($this->moneyInvested, $eur);
        $eur = $this->priceFormat($eur);
        $usd = $this->priceFormat($usd);
        return compact('eur', 'usd', 'diff');
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
            $tokens[$cryptoCode]['tokens'] = $cryptocurrencies[$cryptoCode];
            $tokens[$cryptoCode]['percentage_diff'] = $this->calculatePercentage($this->cryptocurrencies[$cryptoCode][1], (array_shift($item) * $cryptocurrencies[$cryptoCode]));
        }
        return $tokens;
    }

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
