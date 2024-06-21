<?php

    namespace KSeven\PHPAffiliate\System;

    use KSeven\PHPAffiliate\System\Request;

	class BaseLib {

		private $request;

		public function __construct()
		{ 
			$this->request = new Request();
		}

		public function check_connection()
		{
			$get_data = $this->request->post('checkout/connection');
			$response = json_decode($get_data, true);
			return $response;
		}

		public function getProduct($id)
		{
			$get_data = $this->request->post('checkout/product', ["id" => $id]);
			$response = json_decode($get_data, true);
			return $response;
		}

		private function get_ip_from_third_party()
		{
			$curl = curl_init ();
			curl_setopt($curl, CURLOPT_URL, "http://ipecho.net/plain");
			curl_setopt($curl, CURLOPT_HEADER, 0);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 10); 
			curl_setopt($curl, CURLOPT_TIMEOUT, 10);
			$response = curl_exec($curl);
			curl_close($curl);
			return $response;
		}

	}
