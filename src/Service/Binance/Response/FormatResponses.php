<?php
namespace App\Service\Binance\Response;

class FormatResponses
{
    /**
     * Arange Cryptocurrencies Array
     * @param array $balances
     * @return array
     */
    public function arangeAccountResponse(array $balances): array
    {
        $cryptos = [];
        foreach ($balances as $key => $balance) {
            $cryptos[$balance['asset']] = $balance['free'];
        }
        return $cryptos;
    }
}
