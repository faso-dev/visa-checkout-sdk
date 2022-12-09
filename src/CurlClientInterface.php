<?php
	
	namespace FasoDev\VisaCheckoutSdk;
	
	interface CurlClientInterface
	{
		public function get(string $url, array $headers = []): CurlClientResponseInterface;
		
		public function post(string $path, array $data = [], array $headers = []): CurlClientResponseInterface;
	}