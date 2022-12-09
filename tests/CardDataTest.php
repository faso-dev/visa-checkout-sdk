<?php
	
	namespace FasoDev\VisaCheckoutSdk\Tests;
	
	use FasoDev\VisaCheckoutSdk\CardData;
	use PHPUnit\Framework\TestCase;
	
	class CardDataTest extends TestCase
	{
		public function testCardData()
		{
			$cardData = CardData::make(
				'visa',
				'4111111111111111',
				'12',
				'2025-12',
				'123',
				'John Doe',
			);
			
			$this->assertEquals('visa', $cardData->type());
			$this->assertEquals('4111111111111111', $cardData->number());
			$this->assertEquals('123', $cardData->cvv());
			$this->assertEquals('2025-12', $cardData->expirationYear());
			$this->assertEquals('12', $cardData->expirationMonth());
			$this->assertEquals('John Doe', $cardData->holderName());
		}
		
		public function testCardDataWithInvalidType()
		{
			$this->expectException(\InvalidArgumentException::class);
			CardData::make(
				'invalid',
				'4111111111111111',
				'12',
				'2025-12',
				'123',
				'John Doe',
			);
		}
	}