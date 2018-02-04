<?php

namespace App\Service\CalculateCrypto;

use App\Helpers\PriceHelper;
use App\Repository\CryptocurrencyRepository;
use App\Service\Cryptocompare\CryptocompareService;

class CalculateCryptoService
{
    /**
     * @var
     */
    protected $currencies;
    /**
     * @var CryptocompareService
     */
    protected $cryptocompare;

    /**
     * @var PriceHelper
     */
    protected $priceHelper;

    /**
     * @var CryptocurrencyRepository
     */
    protected $cryptoRepo;

    /**
     * CalculateCryptoService constructor.
     * @param array $currencies
     * @param CryptocompareService $cryptocompare
     * @param PriceHelper $priceHelper
     * @param CryptocurrencyRepository $cryptoRepo
     */
    public function __construct(array $currencies, CryptocompareService $cryptocompare, PriceHelper $priceHelper, CryptocurrencyRepository $cryptoRepo)
    {
        $this->currencies = $currencies;
        $this->cryptocompare = $cryptocompare;
        $this->priceHelper = $priceHelper;
        $this->cryptoRepo = $cryptoRepo;
    }

    /**
     * Get Data For Every Cryptocurrency
     * e.g. [
     *      crypto value in EUR
     *      crypto value in USD
     *      value for 1 token in EUR
     *      value for 1 token in USD
     *      number of tokens
     *      difference between the invested money and the current price
     * ]
     * @param array $cryptocurrencies
     * @return array
     */
    public function calcCryptocurrencies(array $cryptocurrencies): array
    {
        return $this->calculatePricePerCoin($this->mergeCryptocurrencies($cryptocurrencies));
    }

    /**
     * Get Total Amount For Each Currency
     * Sum Each Cryptocurreny For Each Currency
     * e.g. [
     *      total in EUR,
     *      total in USD,
     *      difference between the invested money and the current price
     * ]
     * @param array $cryptocurrencies
     * @return array
     */
    public function sumCryptocurrencies(array $cryptocurrencies): array
    {
        foreach ($this->currencies as $item) {
            ${strtolower($item)} = array_sum(array_column($cryptocurrencies, $item.'_PRICE'));
        }
        $diff = $this->priceHelper->calculatePercentage($this->cryptoRepo->getTotalInvestedMoney(), ${strtolower($this->currencies[0])});
        return [
            'eur' => $eur ?? 0,
            'usd' => $usd ?? 0,
            'diff' => $diff
        ];
    }

    /**
     * Merge Cryptocurrencies From Differente Sources (Wallets, Exchanges)
     * @param $balances
     * @return array
     */
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

    /**
     * Calculate Amount In Currencies For Each Cryptocurrency
     * And Difference Between The Invested Money And The Current Price For Cryptocurrency
     * @param array $cryptocurrencies
     * @return array
     */
    private function calculatePricePerCoin(array $cryptocurrencies): array
    {
        $tokens = $this->cryptocompare->getMultiPrices();
        foreach ($tokens as $cryptoCode => $item) {
            foreach ($item as $currencyCode => $currency) {
                $tokens[$cryptoCode][$currencyCode.'_PRICE'] = $currency * $cryptocurrencies[$cryptoCode];
            }
            $tokens[$cryptoCode]['tokens'] = $cryptocurrencies[$cryptoCode];
            $tokens[$cryptoCode]['percentage_diff'] = $this->priceHelper->calculatePercentage(
                $this->getInvestedMoneyByCrypto($cryptoCode),
                (array_shift($item) * $cryptocurrencies[$cryptoCode])
            );
        }
        return $tokens;
    }

    /**
     * Get Invested Money By Cryptocurrency
     * @param string $cryptoSymbol
     * @return float
     */
    private function getInvestedMoneyByCrypto(string $cryptoSymbol): float
    {
        $return = array_filter($this->cryptoRepo->findAll(), function ($item) use ($cryptoSymbol) {
            return $item->getTitle() === $cryptoSymbol;
        });
        if (count($return)) {
            return array_pop($return)->getInvestedMoney();
        }
        return 0;
    }
}
