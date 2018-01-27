<?php

namespace App\Service\Binance\Mapper;

use App\Service\ExchangeApiMapperInterface;

class BinanceMapper implements ExchangeApiMapperInterface
{
    /**
     * Format Binance Response In Desired Format
     * @param $balances
     * @return array
     */
    public function remapBalances($balances): array
    {
        $cryptos = [];
        foreach ($balances['balances'] as $key => $balance) {
            if ((float) $balance['free'] > 0) {
                $cryptos[$balance['asset']] = $balance['free'];
            }
        }
        return $cryptos;
    }
}
