<?php

namespace App\Service\Poloniex;

use App\Service\Poloniex\Api\PoloniexApi;
use App\Service\Poloniex\Mapper\PoloniexMapper;

class PoloniexService
{
    /**
     * @var PoloniexApi
     */
    protected $api;

    /**
     * @var PoloniexMapper
     */
    protected $mapper;

    /**
     * PoloniexService constructor.
     * @param PoloniexApi $api
     * @param PoloniexMapper $mapper
     */
    public function __construct(PoloniexApi $api, PoloniexMapper $mapper)
    {
        $this->api = $api;
        $this->mapper = $mapper;
    }

    /**
     * Get Crypto Balances
     * @return array
     */
    public function getBalances() {
        return $this->mapper->remapBalances($this->api->getPoloniexApiRequest([
                'command' => 'returnBalances'
            ]
        ));
    }
}
