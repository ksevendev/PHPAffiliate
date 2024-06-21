<?php

    namespace KSeven\Affiliate\System;

    use KSeven\Affiliate\Config\Affiliate AS Config;

    class Request {

		protected $baseUrl;

		protected $key;

		protected $language;

		public function __construct()
		{ 
            $config = new Config();
			$this->baseUrl = ($config->SSL ? 'http://' : 'http://') . $config->URL . '/';
			$this->key = $config->KEY;
		}

        /**
         * Send a request to the API
         *
         * @param string $url
         * @param string $method
         * @param array $data
         * @param array $headers
         * @return string
         * @throws \Exception
         */
        private function sendRequest($url, $method = 'GET', $data = [], $headers = [])
        {
            $curl = curl_init();
            $ApiUrl = $this->baseUrl . $url;
            $defaultOptions = [
                CURLOPT_URL => $ApiUrl,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            ];
            $methodOptions = [];
            if ($method === 'POST') {
                $methodOptions = [
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS => $data,
                ];
            } elseif ($method === 'GET' && !empty($data)) {
                $ApiUrl .= '?' . http_build_query($data);
                $defaultOptions[CURLOPT_URL] = $ApiUrl;
            }
            $headerOptions = [];
            if (!empty($headers)) {
                $headerOptions = [
                    CURLOPT_HTTPHEADER => $headers,
                ];
            }
            curl_setopt_array($curl, $defaultOptions + $methodOptions + $headerOptions);
            $response = curl_exec($curl);

            if (curl_errno($curl)) {
                $error_msg = curl_error($curl);
                curl_close($curl);
                throw new \Exception('cURL error: ' . $error_msg);
            }
            curl_close($curl);
            return $response;
        }

        /**
         * Send a request post to the API
         *
         * @param string $url
         * @param array $data
         * @return string
         * @throws \Exception
         */
        public function post($url, $data = [])
        {
            $postHeaders = [
                'checkoutUrl: ' . base_url(),
                'apikey: ' . $this->key,
            ];
            return $this->sendRequest($url, 'POST', $data, $postHeaders);
        }

    }