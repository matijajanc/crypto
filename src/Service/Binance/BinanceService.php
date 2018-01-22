<?php

namespace App\Service\Binance;

use App\Service\Binance\Response\FormatResponses;
use App\Util\CryptoFilters;

class BinanceService
{
    /**
     * @var BinanceApi
     */
    protected $api;

    /**
     * @var CryptoFilters
     */
    protected $filters;

    /**
     * @var FormatResponses
     */
    protected $format;

    /**
     * BinanceService constructor.
     * @param BinanceApi $api
     * @param CryptoFilters $filters
     * @param FormatResponses $format
     */
    public function __construct(BinanceApi $api, CryptoFilters $filters, FormatResponses $format)
    {
        $this->api = $api;
        $this->filters = $filters;
        $this->format = $format;
    }

    /**
     * Get Binance Balances
     * @return array
     */
    public function getBalances()
    {
        return $this->format->arangeAccountResponse($this->getAccountInformation());
    }

    /**
     * Get User Account Information
     * @return array
     */
    public function getAccountInformation()
    {
        return $this->filters->filterBinanceCryptocurrencies($this->api->getBinanceApiRequest('v3/account'));
    }
}
