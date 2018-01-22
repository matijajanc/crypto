<?php

namespace App\Service\Wallet;

class WalletService
{
    /**
     * @var array
     */
    protected $cryptocurrencys;

    /**
     * WalletService constructor.
     * @param array $cryptocurrencys
     */
    public function __construct(array $cryptocurrencys)
    {
        $this->cryptocurrencys = $cryptocurrencys;
    }

    /**
     * Get Wallet Balances
     * @return array
     */
    public function getBalances()
    {
        return $this->cryptocurrencys;
    }
}
