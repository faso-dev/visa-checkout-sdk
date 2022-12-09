<?php
	
	namespace FasoDev\VisaCheckoutSdk;
	
	class Config
	{
		private CredentialsInterface $credentials;
		
		private string $baseUrl = 'https://sandbox.api.visa.com';
		
		private array $requestHeaders;
		
		private int $timeout = 30;
		
		private ?string $proxy = null;
		
		private int $connectTimeout = 30;
		
		private string $checkoutEndpoint = 'checkout/v2/checkouts';
		
		private ?CurlClientInterface $httpClient = null;
		
		private bool $sslVerification = true;
		
		private string $userAgent = 'Visa Checkout SDK';
		
		private ?Config $singleton = null;
		
		private function __construct(
			CredentialsInterface $credentials,
			CurlClientInterface  $httpClient = null,
		)
		{
			if (null === $this->singleton) {
				$this->credentials = $credentials;
				$this->putDefaultRequestHeaders();
				if (null === $this->httpClient) {
					$this->httpClient = $httpClient ?: CurlClient::make(
						$this->requestHeaders,
						[
							CURLOPT_TIMEOUT => $this->timeout,
							CURLOPT_CONNECTTIMEOUT => $this->connectTimeout,
							CURLOPT_PROXY => $this->proxy,
							CURLOPT_SSL_VERIFYPEER => $this->sslVerification,
							CURLOPT_SSL_VERIFYHOST => $this->sslVerification,
							CURLOPT_USERAGENT => $this->userAgent,
						]
					);
				}
				$this->singleton = $this;
			}
			
			return $this->singleton;
		}
		
		private function putDefaultRequestHeaders(): void
		{
			$this->requestHeaders = [
				'Accept' => 'application/json',
				'Content-Type' => 'application/json',
				'Authorization' => 'Basic ' . $this->credentials->accessToken(),
				'User-Agent' => $this->userAgent,
				'Accept-Encoding' => 'gzip',
				'Accept-Language' => 'en_US',
				'Cache-Control' => 'no-cache',
				'Pragma' => 'no-cache'
			];
		}
		
		public static function make(CredentialsInterface $credentials, CurlClientInterface $httpClient = null): self
		{
			return new self($credentials, $httpClient);
		}
		
		public function credentials(): CredentialsInterface
		{
			return $this->credentials;
		}
		
		public function putCredentials(CredentialsInterface $credentials): self
		{
			$this->credentials = $credentials;
			
			return $this;
		}
		
		public function baseUrl(): string
		{
			return $this->baseUrl;
		}
		
		public function putBaseUrl(string $baseUrl): self
		{
			$this->baseUrl = $baseUrl;
			
			return $this;
		}
		
		public function requestHeaders(): array
		{
			return $this->requestHeaders;
		}
		
		public function putRequestHeaders(array $requestHeaders): self
		{
			$this->requestHeaders = $requestHeaders;
			
			return $this;
		}
		
		public function timeout(): int
		{
			return $this->timeout;
		}
		
		public function putTimeout(int $timeout): self
		{
			$this->timeout = $timeout;
			
			return $this;
		}
		
		public function proxy(): ?string
		{
			return $this->proxy;
		}
		
		public function putProxy(?string $proxy): self
		{
			$this->proxy = $proxy;
			
			return $this;
		}
		
		public function connectTimeout(): int
		{
			return $this->connectTimeout;
		}
		
		public function putConnectTimeout(int $connectTimeout): self
		{
			$this->connectTimeout = $connectTimeout;
			
			return $this;
		}
		
		public function checkoutEndpoint(): string
		{
			return $this->checkoutEndpoint;
		}
		
		public function putCheckoutEndpoint(string $checkoutEndpoint): self
		{
			$this->checkoutEndpoint = $checkoutEndpoint;
			
			return $this;
		}
		
		public function httpClient(): ?CurlClientInterface
		{
			return $this->httpClient;
		}
		
		public function putHttpClient(CurlClientInterface $httpClient): self
		{
			$this->httpClient = $httpClient;
			
			return $this;
		}
		
		public function sslVerification(): bool
		{
			return $this->sslVerification;
		}
		
		public function disableSslVerification(): self
		{
			$this->sslVerification = false;
			
			return $this;
		}
		
		public function enableSslVerification(): self
		{
			$this->sslVerification = true;
			
			return $this;
		}
		
		public function userAgent(): string
		{
			return $this->userAgent;
		}
		
		public function putUserAgent(string $userAgent): self
		{
			$this->userAgent = $userAgent;
			
			return $this;
		}
		
		public function checkoutUrl(): string
		{
			return $this->baseUrl . '/' . $this->checkoutEndpoint;
		}
		
	}
	
	
	