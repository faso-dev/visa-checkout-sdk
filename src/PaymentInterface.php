<?php
	
	namespace FasoDev\VisaCheckoutSdk;
	
	interface PaymentInterface
	{
		
		public function createPayment(
			float             $amount,
			string            $currency,
			CardDataInterface $cardData,
			string            $description = null,
		): TransactionInterface;
	}