<?php
	
	declare(strict_types=1);
	
	namespace FasoDev\VisaCheckoutSdk;
	
	use IteratorAggregate;
	use JsonSerializable;
	
	interface CardDataInterface extends IteratorAggregate, JsonSerializable
	{
		public function toArray(): array;
		
		public function type(): string;
		
		public function number(): string;
		
		public function expirationMonth(): string;
		
		public function expirationYear(): string;
		
		public function cvv(): string;
		
		public function holderName(): string;
	}
