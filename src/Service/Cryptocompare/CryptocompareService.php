<?php

namespace App\Service\Cryptocompare;

use App\Service\Cryptocompare\Api\CryptocompareApi;

class CryptocompareService
{
    /**
     * @var CryptocompareApi
     */
    protected $api;

    /**
     * @var array
     */
    protected $currencys;

    /**
     * @var array
     */
    protected $cryptocurrencies;

    /**
     * CryptocompareService constructor.
     * @param CryptocompareApi $api
     * @param array $currencys
     * @param array $cryptocurrencys
     */
    public function __construct(CryptocompareApi $api, array $currencys, array $cryptocurrencies)
    {
        $this->api = $api;
        $this->currencys = $currencys;
        $this->cryptocurrencies = $cryptocurrencies;
    }

    /**
     * Get Multi Prices
     * @return array
     */
    public function getMultiPrices(): array
    {
        return $this->api->getCryptocompareApiRequest('data/pricemulti', [
            'fsyms' => implode(',', array_keys($this->cryptocurrencies)),
            'tsyms' => implode(',', $this->currencys)
        ]);
    }
}
