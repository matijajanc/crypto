<?php

namespace App\Util;

use App\Service\Binance\BinanceService;
use App\Service\Bittrex\BittrexService;
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
     * @var BittrexService
     */
    protected $bittrex;

    /**
     * Cryptocurrencies constructor.
     * @param WalletService $wallet
     * @param BinanceService $binance
     * @param PoloniexService $poloniex
     * @param BittrexService $bittrex
     */
    public function __construct(
        WalletService $wallet,
        BinanceService $binance,
        PoloniexService $poloniex,
        BittrexService $bittrex
    ){
        $this->wallet = $wallet;
        $this->binance = $binance;
        $this->poloniex = $poloniex;
        $this->bittrex = $bittrex;
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
            'poloniex' => $this->poloniex->getBalances(),
            'bittrex' => $this->bittrex->getBalances()
        ];
    }
}
