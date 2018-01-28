<?php

namespace App\Service\Wallet;

use App\Service\Wallet\Mapper\WalletMapper;

class WalletService
{
    /**
     * @var array
     */
    protected $cryptocurrencys;

    /**
     * @var WalletMapper
     */
    protected $mapper;

    /**
     * WalletService constructor.
     * @param array $cryptocurrencys
     * @param WalletMapper $mapper
     */
    public function __construct(array $cryptocurrencies, WalletMapper $mapper)
    {
        $this->cryptocurrencys = $cryptocurrencies;
        $this->mapper = $mapper;
    }

    /**
     * Get Wallet Balances
     * @return array
     */
    public function getBalances()
    {
        return $this->mapper->remapBalances($this->cryptocurrencys);
    }
}
