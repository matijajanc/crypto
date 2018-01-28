<?php

namespace App\Service\Wallet\Mapper;

use App\Service\ExchangeApiMapperInterface;

class WalletMapper implements ExchangeApiMapperInterface
{
    /**
     * @var
     */
    protected $cryptocurrencies;

    /**
     * WalletMapper constructor.
     * @param $cryptocurrencies
     */
    public function __construct($cryptocurrencies)
    {
        $this->cryptocurrencies = $cryptocurrencies;
    }

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

    /**
     * Get Invested Money For Each Currency
     * @return array
     */
    public function getInvestedMoneyPerCoin(): array
    {
        return array_map(function ($item) {
            return array_pop($item);
        }, $this->cryptocurrencies);
    }
}
