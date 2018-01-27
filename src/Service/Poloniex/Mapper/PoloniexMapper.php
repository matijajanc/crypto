<?php

namespace App\Service\Poloniex\Mapper;

use App\Service\ExchangeApiMapperInterface;

class PoloniexMapper implements ExchangeApiMapperInterface
{
    /**
     * Format Poloniex Response In Desired Format
     * @param $balances
     * @return array
     */
    public function remapBalances($balances): array 
    {
        return array_filter($balances, function ($item) {
            return (float) $item > 0;
        });
    }
}
