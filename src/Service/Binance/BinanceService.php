<?php

namespace App\Service\Binance;

use App\Service\Binance\Api\BinanceApi;
use App\Service\Binance\Mapper\BinanceMapper;

class BinanceService
{
    /**
     * @var BinanceApi
     */
    protected $api;

    /**
     * @var BinanceMapper
     */
    protected $mapper;

    /**
     * BinanceService constructor.
     * @param BinanceApi $api
     * @param BinanceMapper $mapper
     */
    public function __construct(BinanceApi $api, BinanceMapper $mapper)
    {
        $this->api = $api;
        $this->mapper = $mapper;
    }

    /**
     * Get Binance Balances
     * @return array
     */
    public function getBalances()
    {
        return $this->mapper->remapBalances($this->getAccountInformation());
    }

    /**
     * Get User Account Information
     * @return array
     */
    public function getAccountInformation()
    {
        return $this->api->getBinanceApiRequest('v3/account');
    }
}
