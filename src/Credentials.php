<?php
	
	namespace FasoDev\VisaCheckoutSdk;
	
	class Credentials implements CredentialsInterface
	{
		private string $apiKey;
		
		private string $sharedSecret;
		
		private string $accessToken;
		
		private ?Credentials $singleton = null;
		
		private function __construct(string $apiKey, string $sharedSecret)
		{
			if (null !== $this->singleton) {
				return $this->singleton;
			}
			
			if (empty($apiKey)) {
				throw new \InvalidArgumentException('The API key cannot be empty');
			}
			
			if (empty($sharedSecret)) {
				throw new \InvalidArgumentException('The shared secret cannot be empty');
			}
			
			$this->apiKey = $apiKey;
			$this->sharedSecret = $sharedSecret;
			$this->accessToken = $this->generateAccessToken();
			
			$this->singleton = $this;
			
			return $this;
			
		}
		
		public static function make(string $apiKey, string $sharedSecret): self
		{
			return new self($apiKey, $sharedSecret);
		}
		
		private function generateAccessToken(): string
		{
			return base64_encode($this->apiKey . ':' . $this->sharedSecret);
		}
		
		public function apiKey(): string
		{
			return $this->apiKey;
		}
		
		public function accessToken(): string
		{
			return $this->accessToken;
		}
		
		public function apiSharedSecret(): string
		{
			return $this->sharedSecret;
		}
	}