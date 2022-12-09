<?php
	
	namespace FasoDev\VisaCheckoutSdk\Tests;
	
	use FasoDev\VisaCheckoutSdk\CardData;
	use FasoDev\VisaCheckoutSdk\Transaction;
	use PHPUnit\Framework\TestCase;
	
	class TransactionTest extends TestCase
	{
		public function testTransaction()
		{
			$transaction = Transaction::from(
				'1234567890',
				'APPROVED',
				100.00,
				'USD',
				'Payment description',
				CardData::make(
					'visa',
					'4111111111111111',
					'12',
					'2025',
					'123',
					'John Doe',
				)
			);
			
			$this->assertEquals('1234567890', $transaction->id());
			$this->assertEquals('APPROVED', $transaction->status());
			$this->assertEquals(100.00, $transaction->amount());
			$this->assertEquals('USD', $transaction->currency());
			$this->assertEquals('Payment description', $transaction->description());
			$this->assertEquals('visa', $transaction->cardData()->type());
			$this->assertEquals('4111111111111111', $transaction->cardData()->number());
			$this->assertEquals('12', $transaction->cardData()->expirationMonth());
			$this->assertEquals('2025', $transaction->cardData()->expirationYear());
			$this->assertEquals('123', $transaction->cardData()->cvv());
			$this->assertEquals('John Doe', $transaction->cardData()->holderName());
		}
		
	}