<?php
	
	namespace FasoDev\VisaCheckoutSdk;
	
	class PaymentException extends \Exception implements \Throwable
	{
		public function __construct(string $message, int $code = 0, \Throwable $previous = null)
		{
			parent::__construct($message, $code, $previous);
		}
	}