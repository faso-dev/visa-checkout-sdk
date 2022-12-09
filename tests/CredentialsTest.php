<?php
	
	namespace FasoDev\VisaCheckoutSdk\Tests;
	
	use FasoDev\VisaCheckoutSdk\Credentials;
	use PHPUnit\Framework\TestCase;
	
	class CredentialsTest extends TestCase
	{
		public function testCredentials()
		{
			$credentials = Credentials::make(
				'VCO_USER_1234567890',
				'VCO_PASS_1234567890',
			);
			
			$this->assertEquals('VCO_USER_1234567890', $credentials->apiKey());
			$this->assertEquals('VCO_PASS_1234567890', $credentials->apiSharedSecret());
			$this->assertEquals(
				base64_encode('VCO_USER_1234567890:VCO_PASS_1234567890'),
				$credentials->accessToken()
			);
		}
	}