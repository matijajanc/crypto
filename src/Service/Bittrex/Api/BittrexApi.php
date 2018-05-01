<?php

namespace App\Service\Bittrex\Api;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class BittrexApi
{
    /**
     * @var string
     */
    protected $apiKey;

    /**
     * @var string
     */
    protected $apiSecret;

    /**
     * API URL
     */
    const API_URL = "https://bittrex.com/api/v1.1/";

    /**
     * @var SessionInterface
     */
    protected $session;

    /**
     * BinanceApi constructor.
     * @param string $apiKey
     * @param string $apiSecret
     * @param SessionInterface $session
     */
    public function __construct(string $apiKey, string $apiSecret, SessionInterface $session)
    {
        $this->apiKey = $apiKey;
        $this->apiSecret = $apiSecret;
        $this->session = $session;
    }

    /**
     * Get Request Response From Binance Trading API
     *
     * @param string $uri
     * @param array $params
     * @return mixed|null|\Psr\Http\Message\ResponseInterface
     */
    public function getBinanceApiRequest(string $uri, array $params = [])
    {
        $params['apikey'] = $this->apiKey;
        $params['nonce'] = time();
        $fullUri = self::API_URL.$uri.'?'.http_build_query($params);

        try {
            $client = new Client();
            $response = $client->request('GET', self::API_URL.$uri,
                [
                    'headers' => [
                        'apisign' => $this->generatePostDataString($fullUri),
                        'Accept'     => 'application/json'
                    ],
                    'query' => $params,
                    'verify' => false,
                    'http_errors' => false,
                    'connect_timeout' => 3
                ]);
            $response = $response->getBody()->getContents();

            return json_decode($response, true);
        } catch (RequestException $e) {
            $this->session->getFlashBag()->add(
                'notice',
                'Bittrex API Request Exception => '. $e->getResponse()
            );
            return [];
        }
    }

    /**
     * Generate Hash Hmac
     *
     * @param $uri
     * @return string
     */
    private function generatePostDataString($uri): string
    {
        return hash_hmac('sha512', $uri, $this->apiSecret);
    }
}
