<?php

namespace App\Service\Bittrex\Mapper;

use App\Service\ExchangeApiMapperInterface;

class BittrexMapper implements ExchangeApiMapperInterface
{
    public function remapBalances($balances): array 
    {
        $cryptos = [];
        foreach($balances['result'] as $item) {
            if ($item['Balance'] > 0) {
                $cryptos[$item['Currency']] = $item['Balance'];
            }
        }
        return $cryptos;
    }
}
