<?php

namespace App\Service\Cryptocompare\Api;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class CryptocompareApi
{
    /**
     * API URL
     */
    const CRYPTOCOMPARE_URL = 'https://min-api.cryptocompare.com/';

    /**
     * Get Request Response From Cryptocompare API
     *
     * @param string $uri
     * @param array $params
     * @return array
     */
    public function getCryptocompareApiRequest(string $uri, array $params = []): array
    {
        try {
            $client = new Client();
            $response = $client->request('GET', self::CRYPTOCOMPARE_URL.$uri,
                [
                    'query' => $params,
                    'verify' => false
                ]);
            $response = $response->getBody()->getContents();

            return json_decode($response, true);
        } catch (RequestException $e) {
            return $e->getResponse();
        }
    }
}
