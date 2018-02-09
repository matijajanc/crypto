<?php

namespace App\Service\Poloniex\Api;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class PoloniexApi
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
     * API Trading URL
     */
    const TRADING_URL = "https://poloniex.com/tradingApi";

    /**
     * API Public API
     */
    const PUBLIC_URL = "https://poloniex.com/public";

    /**
     * @var SessionInterface
     */
    private $session;

    /**
     * PoloniexApi constructor.
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
     * Get Request Response From Poloniex Trading API
     * 
     * @param array $params
     * @return array
     */
    public function getPoloniexApiRequest(array $params = []): array 
    {
        $params = $this->generateNonce($params);
        $sign = $this->generatePostDataString($params);

        try {
            $client = new Client();
            $response = $client->request('POST', self::TRADING_URL,
                [
                    'headers' => [
                        'Key' => $this->apiKey,
                        'Sign' => $sign,
                        'User-Agent' => 'Mozilla/4.0 (compatible; Poloniex PHP bot; '.php_uname('a').'; PHP/'.phpversion().')',
                        'Accept'     => 'application/json'
                    ],
                    'form_params' => $params,
                    'verify' => false,
                    'connect_timeout' => 3
                ]);

            $response = $response->getBody()->getContents();
            return json_decode($response, true);
        } catch (RequestException $e) {
            $this->session->getFlashBag()->add(
                'notice',
                'Poloniex API Request Exception => '. $e->getResponse()
            );
            return [];
        }
    }

    /**
     * Generate a nonce to avoid problems with 32bit systems
     *
     * @param $params
     * @return array
     */
    private function generateNonce($params): array
    {
        $mt = explode(' ', microtime());
        $params['nonce'] = $mt[1].substr($mt[0], 2, 6);

        return $params;
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
        return hash_hmac('sha512', $post_data, $this->apiSecret);
    }
}
