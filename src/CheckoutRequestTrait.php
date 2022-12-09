<?php
	
	namespace FasoDev\VisaCheckoutSdk;
	
	use Psr\Http\Client\ClientExceptionInterface;
	use function var_dump;
	
	trait CheckoutRequestTrait
	{
		private function requestBody(
			float             $amount,
			string            $currency,
			CardDataInterface $cardData,
			string            $description = null,
		): array
		{
			return [
				'amount' => $amount,
				'currency' => $currency,
				'card' => $cardData->toArray(),
				'description' => $description,
			];
		}
		
		private function handleResponse(array $response): TransactionInterface
		{
			return new Transaction(
				$response['id'],
				$response['status'],
				$response['amount'],
				$response['currency'],
				$response['description'],
				CardData::make(
					$response['card']['type'],
					$response['card']['number'],
					$response['card']['expiryMonth'],
					$response['card']['expiryYear'],
					$response['card']['cvc'],
					$response['card']['holder'],
				),
			);
		}
		
		private function request(
			string $method,
			string $url,
			array  $body = [],
		): CurlClientResponseInterface
		{
			if ($method === 'GET') {
				$url .= '?' . http_build_query($body);
				
				return $this->config->httpClient()->get($url);
			}
			
			return $this->config->httpClient()->post($url, $body);
			
		}
	}