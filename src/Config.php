<?php
	
	namespace FasoDev\VisaCheckoutSdk;
	
	use FasoDev\SimpleCurlClient\Curl\CurlClientBuilder;
	use FasoDev\SimpleCurlClient\Http\ClientInterface;
	
	class Config
	{
		private CredentialsInterface $credentials;
		
		private string $baseUrl = 'https://sandbox.api.visa.com';
		
		private array $requestHeaders;
		
		private int $timeout = 30;
		
		private ?string $proxy = null;
		
		private int $connectTimeout = 30;
		
		private string $checkoutEndpoint = 'checkout/v2/checkouts';
		
		private ?ClientInterface $httpClient = null;
		
		private CurlClientBuilder $httpClientBuilder;
		
		private bool $sslVerification = true;
		
		private string $userAgent = 'Visa Checkout SDK';
		
		private ?Config $singleton = null;
		
		private function __construct(
			CredentialsInterface $credentials,
			ClientInterface      $httpClient = null,
		)
		{
			if (null === $this->singleton) {
				$this->credentials = $credentials;
				$this->httpClientBuilder = CurlClientBuilder::create();
				if (null === $this->httpClient) {
					$this->httpClient = $httpClient ?: $this->httpClientBuilder->build();
				}
				$this->singleton = $this;
			}
			
			return $this->singleton;
		}
		
		private function putDefaultRequestHeaders(): void
		{
			$this->httpClientBuilder->defineHeader([
				'Accept' => 'application/json',
				'Content-Type' => 'application/json',
				'Authorization' => 'Basic ' . $this->credentials->accessToken(),
				'User-Agent' => $this->userAgent,
				'Accept-Encoding' => 'gzip',
				'Accept-Language' => 'en_US',
				'Cache-Control' => 'no-cache',
				'Pragma' => 'no-cache'
			]);
		}
		
		public static function make(CredentialsInterface $credentials, ClientInterface $httpClient = null): self
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
			$this->httpClientBuilder->defineHeader($requestHeaders);
			return $this;
		}
		
		public function timeout(): int
		{
			return $this->timeout;
		}
		
		public function putTimeout(int $timeout): self
		{
			$this->timeout = $timeout;
			$this->httpClientBuilder->defineTimeout($timeout);
			return $this;
		}
		
		public function proxy(): ?string
		{
			return $this->proxy;
		}
		
		public function putProxy(?string $proxy): self
		{
			$this->proxy = $proxy;
			$this->httpClientBuilder->defineProxy($proxy);
			
			return $this;
		}
		
		public function connectTimeout(): int
		{
			return $this->connectTimeout;
		}
		
		public function putConnectTimeout(int $connectTimeout): self
		{
			$this->connectTimeout = $connectTimeout;
			$this->httpClientBuilder->defineConnectTimeout($connectTimeout);
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
		
		public function httpClient(): ?ClientInterface
		{
			return $this->httpClient;
		}
		
		public function putHttpClient(ClientInterface $httpClient): self
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
			$this->httpClientBuilder->defineSslVerifyHost(false);
			return $this;
		}
		
		public function enableSslVerification(): self
		{
			$this->sslVerification = true;
			$this->httpClientBuilder->defineSslVerifyHost(true);
			
			return $this;
		}
		
		public function userAgent(): string
		{
			return $this->userAgent;
		}
		
		public function putUserAgent(string $userAgent): self
		{
			$this->userAgent = $userAgent;
			$this->httpClientBuilder->defineUserAgent($userAgent);
			return $this;
		}
		
		public function checkoutUrl(): string
		{
			return $this->baseUrl . '/' . $this->checkoutEndpoint;
		}
		
	}
	
	
