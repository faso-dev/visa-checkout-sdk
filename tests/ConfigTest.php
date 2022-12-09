<?php
	
	namespace FasoDev\VisaCheckoutSdk\Tests;
	
	use FasoDev\VisaCheckoutSdk\Config;
	use FasoDev\VisaCheckoutSdk\Credentials;
	use PHPUnit\Framework\TestCase;
	use function base64_encode;
	
	class ConfigTest extends TestCase
	{
		public function testConfig()
		{
			$config = Config::make(
				Credentials::make(
					'VCO_USER_1234567890',
					'VCO_PASS_1234567890',
				),
			);
			
			$this->assertEquals('VCO_USER_1234567890', $config->credentials()->apiKey());
			$this->assertEquals('VCO_PASS_1234567890', $config->credentials()->apiSharedSecret());
			$this->assertEquals(
				base64_encode('VCO_USER_1234567890:VCO_PASS_1234567890'),
				$config->credentials()->accessToken()
			);
			
			$this->assertEquals('https://sandbox.api.visa.com', $config->baseUrl());
			$this->assertEquals('checkout/v2/checkouts', $config->checkoutEndpoint());
			$config->putUserAgent('test');
			$this->assertEquals('test', $config->userAgent());
		}
	}