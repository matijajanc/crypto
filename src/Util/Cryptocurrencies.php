<?php

namespace App\Util;

use App\Service\Binance\BinanceService;
use App\Service\Poloniex\PoloniexService;
use App\Service\Wallet\WalletService;

class Cryptocurrencies
{
    /**
     * @var WalletService
     */
    protected $wallet;

    /**
     * @var BinanceService
     */
    protected $binance;

    /**
     * @var PoloniexService
     */
    protected $poloniex;

    /**
     * Cryptocurrencies constructor.
     * @param WalletService $wallet
     * @param BinanceService $binance
     * @param PoloniexService $poloniex
     */
    public function __construct(
        WalletService $wallet,
        BinanceService $binance,
        PoloniexService $poloniex
    ){
        $this->wallet = $wallet;
        $this->binance = $binance;
        $this->poloniex = $poloniex;
    }

    /**
     * Get Cryptocurrencies From All Sources (Wallets, Exchanges)
     * @return array
     */
    public function getCryptocurrencies()
    {
        return [
            'wallet' => $this->wallet->getBalances(),
            'binance' => $this->binance->getBalances(),
            'poloniex' => $this->poloniex->getBalances()
        ];
    }
}
