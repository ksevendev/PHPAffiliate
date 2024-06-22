<?php

    namespace KSeven\PHPAffiliate\System;

	use KSeven\PHPAffiliate\System\Request;

	class BaseLib {

		/**
		 * @var Request
		 */
		protected $request;

		public function __construct()
		{ 
			$this->request = new Request();
		}

		public function check_connection()
		{
			return $this->request->post('checkout/connection');
		}

		public function getProduct($id)
		{
			$response = $this->request->post('checkout/product', [
				"id" => $id
			]);
			$response = json_decode($response, true);
			return $response;
		}

	}
