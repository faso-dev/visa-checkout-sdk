<?php
	
	namespace FasoDev\VisaCheckoutSdk;
	
	class Transaction implements TransactionInterface
	{
		private string $id;
		
		private string $status;
		
		private float $amount;
		
		private string $currency;
		
		private string $description;
		
		private CardDataInterface $cardData;
		
		public function __construct(
			string            $id,
			string            $status,
			float             $amount,
			string            $currency,
			string            $description,
			CardDataInterface $cardData
		)
		{
			$this->id = $id;
			$this->status = $status;
			$this->amount = $amount;
			$this->currency = $currency;
			$this->description = $description;
			$this->cardData = $cardData;
		}
		
		public static function from(
			string            $id,
			string            $status,
			float             $amount,
			string            $currency,
			string            $description,
			CardDataInterface $cardData
		): self
		{
			return new self($id, $status, $amount, $currency, $description, $cardData);
		}
		
		public function id(): string
		{
			return $this->id;
		}
		
		public function status(): string
		{
			return $this->status;
		}
		
		public function amount(): float
		{
			return $this->amount;
		}
		
		public function currency(): string
		{
			return $this->currency;
		}
		
		public function description(): string
		{
			return $this->description;
		}
		
		public function cardData(): CardDataInterface
		{
			return $this->cardData;
		}
		
		public function successfull(): bool
		{
			return $this->status === 'SUCCESS';
		}
		
		public function declined(): bool
		{
			return $this->status === 'DECLINED';
		}
		
		public function failded(): bool
		{
			return $this->status === 'ERROR';
		}
	}