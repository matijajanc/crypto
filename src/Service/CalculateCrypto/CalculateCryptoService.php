<?php

namespace App\Service\CalculateCrypto;

use App\Helpers\PriceHelper;
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
     * @var PriceHelper
     */
    protected $priceHelper;

    /**
     * CalculateCryptoService constructor.
     * @param $money_invested
     * @param $cryptocurrencies
     * @param CryptocompareService $cryptocompare
     * @param PriceHelper $priceHelper
     */
    public function __construct($money_invested, $cryptocurrencies, CryptocompareService $cryptocompare, PriceHelper $priceHelper)
    {
        $this->moneyInvested = $money_invested;
        $this->cryptocurrencies = $cryptocurrencies;
        $this->cryptocompare = $cryptocompare;
        $this->priceHelper = $priceHelper;
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
        $diff = $this->priceHelper->calculatePercentage($this->moneyInvested, $eur);
        $eur = $this->priceHelper->priceFormat($eur);
        $usd = $this->priceHelper->priceFormat($usd);
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
            $tokens[$cryptoCode]['percentage_diff'] = $this->priceHelper->calculatePercentage($this->cryptocurrencies[$cryptoCode][1], (array_shift($item) * $cryptocurrencies[$cryptoCode]));
        }
        return $tokens;
    }
}
