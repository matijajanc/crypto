<?php

namespace App\Service\Binance\Api;


use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

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

    /**
     * API URL
     */
    const BINANCE_URL = "https://www.binance.com/api/";

    /**
     * Number of milliseconds after timestamp the request is valid for
     */
    const RECV_WINDOW = 6000000;

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
                    'http_errors' => false,
                    'connect_timeout' => 3
                ]);
            $response = $response->getBody()->getContents();
            return json_decode($response, true);
        } catch (RequestException $e) {
            $this->session->getFlashBag()->add(
                'notice',
                'Binance API Request Exception => '. $e->getResponse()
            );
            return [];
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
