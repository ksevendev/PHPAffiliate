<?php

namespace Affiliate\Libraries;

use Config\App as AppConfig;
use Affiliate\Config\Affiliate as Config;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Client;

class Request
{

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
        $this->apiURL = ($forceSecureRequests ? 'https://' : 'http://') . rtrim($apiURL, '/') . '/';

        $apikey = env('affiliate.apikey', $Config->apikey);
        $this->apikey = $apikey;

        $baseURL = env('app.baseURL', $AppConfig->baseURL);
        $this->baseUrl = $baseURL;
        
        $timeOut = env('affiliate.timeOut', $Config->timeOut);
        $this->timeOut = $timeOut;

        $this->client = new Client([
            'base_uri' => $this->baseUrl,
            'timeout'  => $this->timeOut,
            'headers' => [
                'apikey' => $this->apikey,
                'checkoutUrl' => $this->baseUrl,
            ],
            'verify' => $forceSecureRequests, // Desativa a verificação de SSL
        ]);
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

    public function getIP()
    {
        try {
            $response = $this->client->get('http://ipecho.net/plain');
            return $response->getBody()->getContents();
        } catch (RequestException $e) {
            throw new \Exception('Guzzle error: ' . $e->getMessage());
        }
    }
}

