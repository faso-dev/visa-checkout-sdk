<?php
	
	namespace FasoDev\VisaCheckoutSdk;
	
	class CheckoutSdk
	{
		protected PaymentInterface $payment;
		
		public function __construct(PaymentInterface $payment)
		{
			$this->payment = $payment;
		}
		
		public function createPayment(
			float             $amount,
			string            $currency,
			CardDataInterface $cardData,
			string            $description = null
		): TransactionInterface
		{
			return $this->payment->createPayment($amount, $currency, $cardData, $description);
		}
	}