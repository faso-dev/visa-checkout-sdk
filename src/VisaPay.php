<?php
	
	namespace FasoDev\VisaCheckoutSdk;
	
	use FasoDev\SimpleCurlClient\Curl\CurlRequestErrorException;
	
	class VisaPay implements PaymentInterface
	{
		use CheckoutRequestTrait;
		
		private Config $config;
		
		private function __construct(Config $config)
		{
			$this->config = $config;
		}
		
		public static function fromConfig(Config $config): self
		{
			return new self($config);
		}
		
		/**
		 * @throws PaymentException
		 * @throws CurlRequestErrorException
		 */
		public function createPayment(
			float             $amount,
			string            $currency,
			CardDataInterface $cardData,
			string            $description = null
		): TransactionInterface
		{
			$response = $this->request(
				'POST',
				$this->config->checkoutUrl(),
				$this->requestBody($amount, $currency, $cardData, $description),
			);
			
			if ($response->status() !== 201) {
				throw new PaymentException(
					$response->json()['responseStatus']['message'],
					$response->status(),
				);
			}
			
			return $this->handleResponse(
				$this->request(
					'POST',
					$this->config->checkoutUrl(),
					$this->requestBody($amount, $currency, $cardData, $description),
				)->json(),
			);
		}
	}
