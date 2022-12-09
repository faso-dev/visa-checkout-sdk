<?php
	
	namespace FasoDev\VisaCheckoutSdk;
	
	use function array_merge;
	use function count;
	use function curl_setopt;
	use const CURLOPT_HEADER;
	use const CURLOPT_HTTPHEADER;
	use const CURLOPT_RETURNTRANSFER;
	use const CURLOPT_SSL_VERIFYHOST;
	use const CURLOPT_SSL_VERIFYPEER;
	
	class CurlClient implements CurlClientInterface
	{
		protected array $headers;
		
		protected array $options;
		
		protected false|\CurlHandle $curl;
		
		private function __construct(array $headers = [], array $options = [])
		{
			$this->curl = curl_init();
			$this->headers = $headers;
			$this->options = $options;
			$this->defaultOptions();
		}
		
		public static function make(array $headers = [], array $options = []): self
		{
			return new self($headers, $options);
		}
		
		/**
		 * @throws CurlRequestErrorException
		 */
		public function get(
			string $url,
			array  $headers = [],
		): CurlClientResponseInterface
		{
			return $this->request('GET', $url, [], $headers);
		}
		
		/**
		 * @throws CurlRequestErrorException
		 */
		public function post(
			string $path,
			array  $data = [],
			array  $headers = [],
		): CurlClientResponseInterface
		{
			return $this->request('POST', $path, $data, $headers);
		}
		
		/**
		 * @throws CurlRequestErrorException
		 */
		private function request(string $method, string $path, array $data = [], array $headers = []): CurlClientResponseInterface
		{
			curl_setopt($this->curl, CURLOPT_URL, $path);
			curl_setopt($this->curl, CURLOPT_CUSTOMREQUEST, $method);
			curl_setopt($this->curl, CURLOPT_HEADER, count(
					$headers = array_merge($this->headers, $headers),
				) > 0
			);
			
			if ($method === 'POST') {
				curl_setopt($this->curl, CURLOPT_POST, true);
				curl_setopt($this->curl, CURLOPT_POSTFIELDS, $data);
			}
			
			$response = curl_exec($this->curl);
			
			if ($response === false) {
				throw new CurlRequestErrorException(
					'Error while executing curl request: ' . curl_error($this->curl)
				);
			}
			
			// handle request timeout error
			if (curl_errno($this->curl) === CURLE_OPERATION_TIMEDOUT) {
				throw new CurlRequestErrorException(
					'Visa Checkout API request timed out. Please try again later.',
					CURLE_OPERATION_TIMEDOUT
				);
			}
			
			// handle request connection error
			if (curl_errno($this->curl) === CURLE_COULDNT_CONNECT) {
				throw new CurlRequestErrorException(
					'Could not connect to ' . $path . '. Please check your internet connection and try again.',
					curl_errno($this->curl)
				);
			}
			
			$headerSize = curl_getinfo($this->curl, CURLINFO_HEADER_SIZE);
			
			$headers = $this->parseHeaders(substr($response, 0, $headerSize));
			
			$body = substr($response, $headerSize);
			
			return new CurlClientResponse(
				(int)curl_getinfo($this->curl, CURLINFO_HTTP_CODE),
				$headers,
				$body
			);
		}
		
		private function defaultOptions(): void
		{
			curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($this->curl, CURLOPT_HTTPHEADER, $this->headers);
			curl_setopt($this->curl, CURLOPT_SSL_VERIFYPEER, false);
		}
		
		public function enableDebug(): self
		{
			curl_setopt($this->curl, CURLOPT_VERBOSE, true);
			return $this;
		}
		
		public function disableDebug(): self
		{
			curl_setopt($this->curl, CURLOPT_VERBOSE, false);
			return $this;
		}
		
		public function enableSSLVerify(): self
		{
			curl_setopt($this->curl, CURLOPT_SSL_VERIFYPEER, true);
			return $this;
		}
		
		public function disableSSLVerify(): self
		{
			curl_setopt($this->curl, CURLOPT_SSL_VERIFYPEER, false);
			return $this;
		}
		
		public function __destruct()
		{
			curl_close($this->curl);
		}
		
		private function parseHeaders(string $content): array
		{
			$headers = [];
			$lines = explode("\r\n", $content);
			foreach ($lines as $line) {
				$parts = explode(': ', $line);
				if (count($parts) === 2) {
					$headers[$parts[0]] = $parts[1];
				}
			}
			
			return $headers;
		}
	}