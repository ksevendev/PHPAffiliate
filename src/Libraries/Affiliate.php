<?php

namespace Affiliate\Libraries;

use Config\App as AppConfig;
use Affiliate\Config\Affiliate as Config;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Client;

class Affiliate
{

    protected $config;

    protected $apiURL;

    protected $apikey;
    
    protected $baseUrl;

    protected $timeOut;

    protected $client;

    public function __construct()
    {
        $Config = new Config();
        $AppConfig = new AppConfig();

        $apiURL = env('affiliate.apiURL', $Config->apiURL);
        $forceSecureRequests = env('affiliate.forceSecureRequests', $Config->forceSecureRequests);

        $setHttp = $forceSecureRequests ? 'https://' : 'http://';

        $this->apiURL = $setHttp . rtrim($apiURL, '/') . '/api/';

        $apikey = env('affiliate.apikey', $Config->apikey);
        $this->apikey = $apikey;

        $baseURL = env('app.baseURL', $AppConfig->baseURL);
        $baseURL = rtrim(str_replace(['https://', 'http://'], '', $baseURL), '/');
        $this->baseUrl = $baseURL;
        
        $timeOut = env('affiliate.timeOut', $Config->timeOut);
        $this->timeOut = $timeOut;
        
        $this->config = [
            'base_uri' => $this->apiURL,
            'timeout'  => $this->timeOut,
            'headers' => [
                'checkoutUrl' => $this->baseUrl,
                'apikey' => $this->apikey,
            ],
            'verify' => $forceSecureRequests, // Desativa a verificação de SSL
        ];

        $this->client = new Client($this->config);
    }

    public function checkConnection()
    {
        return $this->post('checkout/connection');
    }

    public function getProduct($id)
    {
        $response = $this->post('checkout/product', [
            "id" => $id
        ]);
        return $response;
    }

    /**
     * get ip
     *
     * @return string
     * @throws \Exception
     */
    public function getIP()
    {
        try {
            $response = $this->client->get('http://ipecho.net/plain');
            return $response->getBody()->getContents();
        } catch (RequestException $e) {
            throw new \Exception('Guzzle error: ' . $e->getMessage());
        }
    }

    /**
     * Send a POST request to the API
     *
     * @param string $endpoint
     * @param array $data
     * @param array $headers
     * @return string
     * @throws \Exception
     */
    public function post(string $endpoint, array $data = [], array $headers = [])
    {
        try {
            $response = $this->client->post($endpoint, [
                'form_params' => $data,
                'headers' => array_merge($this->client->getConfig('headers'), $headers),
            ]);
            return $response->getBody()->getContents();
        } catch (RequestException $e) {
            throw new \Exception('Guzzle error: ' . $e->getMessage());
        }
    }

    /**
     * Send a GET request to the API
     *
     * @param string $endpoint
     * @param array $params
     * @param array $headers
     * @return string
     * @throws \Exception
     */
    public function get(string $endpoint, array $params = [], array $headers = [])
    {
        try {
            $response = $this->client->get($endpoint, [
                'query' => $params,
                'headers' => array_merge($this->client->getConfig('headers'), $headers),
            ]);
            return $response->getBody()->getContents();
        } catch (RequestException $e) {
            throw new \Exception('Guzzle error: ' . $e->getMessage());
        }
    }
}

