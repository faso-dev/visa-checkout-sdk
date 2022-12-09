<?php
	
	namespace FasoDev\VisaCheckoutSdk;
	
	interface CurlClientResponseInterface
	{
		public function status(): int;
		
		public function header(string $header): ?string;
		
		public function headers(): array;
		
		public function body(): string;
		
		public function json(): array;
	}