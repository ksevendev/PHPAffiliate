<?php

    namespace Affiliate\Libraries;

	use Affiliate\Libraries\Request;

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
			return $response;
		}

	}
