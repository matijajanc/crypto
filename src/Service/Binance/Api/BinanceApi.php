<?php

namespace App\Service\Binance\Api;


use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class BinanceApi
{
    /**
     * @var string
     */
    protected $apiKey;

    /**
     * @var string
     */
    protected $apiSecret;

    const BINANCE_URL = "https://www.binance.com/api/";

    const RECV_WINDOW = 6000000;

    /**
     * BinanceApi constructor.
     * @param string $apiKey
     * @param string $apiSecret
     */
    public function __construct(string $apiKey, string $apiSecret)
    {
        $this->apiKey = $apiKey;
        $this->apiSecret = $apiSecret;
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
        $params['timestamp'] = $this->generateTimestamp();
        $params['recvWindow'] = self::RECV_WINDOW;
        $params['signature'] = $this->generatePostDataString($params);
        try {
            $client = new Client();
            $response = $client->request('GET', self::BINANCE_URL.$uri,
                [
                    'headers' => [
                        'User-Agent' => 'Mozilla/4.0 (compatible; PHP Binance API)',
                        'X-MBX-APIKEY' => $this->apiKey,
                        'Accept'     => 'application/json'
                    ],
                    'query' => $params,
                    'verify' => false,
                    'http_errors' => false
                ]);
            $response = $response->getBody()->getContents();
            return json_decode($response, true);
        } catch (RequestException $e) {
            return $e->getResponse();
        }
    }

    /**
     * Generate timestamp to avoid problems with 32bit systems
     *
     * @return int
     */
    private function generateTimestamp()
    {
        return round(microtime(true) * 1000);
    }

    /**
     * Generate the POST data string
     *
     * @param $params
     * @return string
     */
    private function generatePostDataString($params): string
    {
        $post_data = http_build_query($params, '', '&');
        return hash_hmac('sha256', $post_data, $this->apiSecret);
    }
}
