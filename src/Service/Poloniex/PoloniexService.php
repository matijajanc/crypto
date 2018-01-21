<?php

namespace App\Service\Poloniex;

use App\Util\CryptoFilters;

class PoloniexService
{
    /**
     * @var PoloniexApi
     */
    protected $api;

    /**
     * @var CryptoFilters
     */
    protected $filters;

    /**
     * PoloniexService constructor.
     * @param PoloniexApi $poloniex
     * @param CryptoFilters $filters
     */
    public function __construct(PoloniexApi $api, CryptoFilters $filters)
    {
        $this->api = $api;
        $this->filters = $filters;
    }

    /**
     * Get Crypto Balances
     *
     * @return array
     */
    public function getBalances() {
        return $this->filters->filterPoloniexCryptocurrencies($this->api->getPoloniexApiRequest([
                'command' => 'returnBalances'
            ]
        ));
    }
}
