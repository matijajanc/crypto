<?php

namespace App\Service\Binance\Mapper;

use App\Service\ExchangeApiMapperInterface;

class BinanceMapper implements ExchangeApiMapperInterface
{
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
