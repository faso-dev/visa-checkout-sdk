<?php
	
	namespace FasoDev\VisaCheckoutSdk;
	
	class CurlClientResponse implements CurlClientResponseInterface
	{
		protected int $status;
		protected array $headers = [];
		protected string $body;
		
		public function __construct(int $status, array $headers, string $body)
		{
			$this->status = $status;
			$this->headers = $headers;
			$this->body = $body;
		}
		
		public function status(): int
		{
			return $this->status;
		}
		
		public function header(string $header): ?string
		{
			return $this->headers[$header] ?? null;
		}
		
		public function headers(): array
		{
			return $this->headers;
		}
		
		public function body(): string
		{
			return $this->body;
		}
		
		public function json(): array
		{
			return json_decode($this->body, true);
		}
	}

