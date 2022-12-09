<?php
	
	namespace FasoDev\VisaCheckoutSdk;
	
	interface TransactionInterface
	{
		public function id(): string;
		
		public function status(): string;
		
		public function amount(): float;
		
		public function currency(): string;
		
		public function description(): string;
		
		public function cardData(): CardDataInterface;
		
		public function isSuccessful(): bool;
		
		public function isDeclined(): bool;
		
		public function isError(): bool;
	}