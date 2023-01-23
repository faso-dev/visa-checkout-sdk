<?php
	
	namespace FasoDev\VisaCheckoutSdk\Tests;
	
	use Exception;
	use FasoDev\VisaCheckoutSdk\CardData;
	use FasoDev\VisaCheckoutSdk\Config;
	use FasoDev\VisaCheckoutSdk\Credentials;
	use FasoDev\VisaCheckoutSdk\PaymentException;
	use FasoDev\VisaCheckoutSdk\VisaPay;
	use PHPUnit\Framework\TestCase;
	
	class VisaPayTest extends TestCase
	{
		public function testVisaPay()
		{
			$visaCard = CardData::make(
				'visa',
				'4111111111111111',
				'12',
				'2025',
				'123',
				'John Doe',
			);
			
			$config = Config::make(Credentials::make(
				'VCO_USER_1234567890',
				'VCO_PASS_1234567890',
			));
			
			$payment = VisaPay::fromConfig($config);
			
			$this->assertEquals(
				'https://sandbox.api.visa.com/checkout/v2/checkouts',
				$config->checkoutUrl()
			);
			$this->expectException(Exception::class);
			$transaction = $payment->createPayment(
				100.00,
				'USD',
				$visaCard,
				'Payment description'
			);
		}
	}
