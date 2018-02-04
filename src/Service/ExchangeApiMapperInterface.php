<?php

namespace App\Service;

interface ExchangeApiMapperInterface
{
    /**
     * Format Binance Response In Desired Format
     * e.g. [
     *      'ETH' => value,
     *      'BTC' => value
     * ]
     * @param $balances
     * @return array
     */
    public function remapBalances($balances);
}
