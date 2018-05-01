<?php

namespace App\Service\Bittrex;

use App\Service\Bittrex\Api\BittrexApi;
use App\Service\Bittrex\Mapper\BittrexMapper;

class BittrexService
{
    /**
     * @var BittrexApi
     */
    protected $api;

    /**
     * @var BittrexMapper
     */
    protected $mapper;


    public function __construct(BittrexApi $api, BittrexMapper $mapper)
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
        return $this->mapper->remapBalances($this->getAccountBalances());
    }

    /**
     * Get User Account Ballances
     * @return array
     */
    public function getAccountBalances()
    {
        return $this->api->getBinanceApiRequest('account/getbalances');
    }
}
