<?php

namespace App\Service\Binance;

use App\Util\CryptoFilters;

class BinanceService
{
    /**
     * @var BinanceApi
     */
    protected $api;

    /**
     * @var CryptoFilters
     */
    protected $filters;
    
    public function __construct(BinanceApi $api, CryptoFilters $filters)
    {
        $this->api = $api;
        $this->filters = $filters;
    }
    
    public function getAccountInformation()
    {
        return $this->filters->filterBinanceCryptocurrencies($this->api->getBinanceApiRequest('v3/account'));
    }
}
