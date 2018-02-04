<?php

namespace App\Service\Wallet\Mapper;

use App\Service\ExchangeApiMapperInterface;

class WalletMapper implements ExchangeApiMapperInterface
{
    public function remapBalances($balances): array
    {
        $tokens = [];
        foreach ($balances as $item) {
            $tokens[$item->getTitle()] = $item->getTokens();
        }
        return $tokens;
    }
}
