<?php

namespace App\Controller;

use App\Repository\CryptocurrencyRepository;
use App\Service\CalculateCrypto\CalculateCryptoService;
use App\Util\Cryptocurrencies;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Intl\Intl;

class StatisticsController extends Controller
{
    /**
     * Get Statistics For Cryptocurrencies Invested In
     * @param Cryptocurrencies $cryptocurrencies
     * @param CalculateCryptoService $calculateCrypto
     * @param CryptocurrencyRepository $cryptoRepo
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(Cryptocurrencies $cryptocurrencies, CalculateCryptoService $calculateCrypto, CryptocurrencyRepository $cryptoRepo)
    {
        $allCryptocurrencies = $cryptocurrencies->getCryptocurrencies();
        $calcCrypto = $calculateCrypto->calcCryptocurrencies($allCryptocurrencies);
        $sumCrypto = $calculateCrypto->sumCryptocurrencies($calcCrypto);

        return $this->render('statistics.html.twig', [
            'total' => $sumCrypto,
            'cryptocurrencies' => $calcCrypto,
            'money_invested' => $cryptoRepo->getTotalInvestedMoney(),
            'currency_symbol' => Intl::getCurrencyBundle()->getCurrencySymbol($this->getParameter('currencies')[0])
        ]);
    }
}
