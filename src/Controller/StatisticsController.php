<?php

namespace App\Controller;

use App\Service\CalculateCrypto\CalculateCryptoService;
use App\Util\CalculateCryptocurrencies;
use App\Util\Cryptocurrencies;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class StatisticsController extends Controller
{
    public function index(Cryptocurrencies $cryptocurrencies, CalculateCryptoService $calculateCrypto)
    {
        //echo "<pre>";
        $allCryptocurrencies = $cryptocurrencies->getCryptocurrencies();
        $calcCrypto = $calculateCrypto->calcCryptocurrencies($allCryptocurrencies);
        $sumCrypto = $calculateCrypto->sumCryptocurrencies($calcCrypto);

//        echo "<pre>";
//        var_dump($allCryptocurrencies);
//        var_dump($calcCrypto);
//        var_dump($sumCrypto); exit;

        return $this->render('statistics.html.twig', [
            'total' => $sumCrypto,
            'cryptocurrencies' => $calcCrypto
        ]);
    }
}
