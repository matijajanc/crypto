<?php

namespace App\Service\Cryptocompare;

use App\Service\Cryptocompare\Api\CryptocompareApi;
use App\Service\Wallet\WalletService;

class CryptocompareService
{
    /**
     * @var CryptocompareApi
     */
    protected $api;

    /**
     * @var array
     */
    protected $currencies;

    /**
     * @var array
     */
    protected $cryptocurrencies;

    /**
     * CryptocompareService constructor.
     * @param array $currencies
     * @param CryptocompareApi $api
     * @param WalletService $wallet
     */
    public function __construct(array $currencies, CryptocompareApi $api, WalletService $wallet)
    {
        $this->api = $api;
        $this->currencies = $currencies;
        $this->cryptocurrencies = $wallet->getBalances();
    }

    /**
     * Get Multi Prices
     * @return array
     */
    public function getMultiPrices(): array
    {
        return $this->api->getCryptocompareApiRequest('data/pricemulti', [
            'fsyms' => implode(',', array_keys($this->cryptocurrencies)),
            'tsyms' => implode(',', $this->currencies)
        ]);
    }
}
