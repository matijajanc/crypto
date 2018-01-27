<?php

namespace App\Service\Wallet\Mapper;

use App\Service\ExchangeApiMapperInterface;

class WalletMapper implements ExchangeApiMapperInterface
{
    /**
     * Get Only Crypto Balances
     * @param $balances
     * @return array
     */
    public function remapBalances($balances)
    {
        return array_map(function ($item) {
            return array_shift($item);
        }, $balances);
    }
}