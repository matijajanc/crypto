<?php

namespace App\Controller;

use App\Service\Binance\BinanceService;
use App\Service\Cryptocompare\CryptocompareService;
use App\Service\Poloniex\PoloniexService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class StatisticsController extends Controller
{
    public function index(CryptocompareService $cryptocompare, PoloniexService $poloniex, BinanceService $binance)
    {
        var_dump($cryptocompare->getMultiPrices());
        echo "<br><br><br>";
        echo "<pre>";
        var_dump($binance->getAccountInformation());
        echo "<br><br><br>";
        var_dump($poloniex->getBalances()); exit;
        return $this->render('statistics.html.twig');
    }
}
