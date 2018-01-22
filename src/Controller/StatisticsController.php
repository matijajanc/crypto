<?php

namespace App\Controller;

use App\Util\CalculateCryptocurrencies;
use App\Util\Cryptocurrencies;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class StatisticsController extends Controller
{
    public function index(Cryptocurrencies $cryptocurrencies, CalculateCryptocurrencies $calculateCryptocurrencies)
    {
        echo "<pre>";
            
        
        $allCryptocurrencies = $cryptocurrencies->getCryptocurrencies();
        $calcCrypto = $calculateCryptocurrencies->calcCryptocurrencies($allCryptocurrencies);
        $sumCrypto = $calculateCryptocurrencies->sumCryptocurrencies($calcCrypto);
        var_dump($allCryptocurrencies);
        var_dump($calcCrypto);
        var_dump($sumCrypto); exit;

        return $this->render('statistics.html.twig');
    }
}
