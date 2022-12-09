<?php
	declare(strict_types=1);
	
	namespace FasoDev\VisaCheckoutSdk;
	
	use Traversable;
	
	class CardData implements CardDataInterface
	{
		private string $type;
		private string $number;
		private string $expirationMonth;
		private string $expirationYear;
		private string $cvv;
		private string $holderName;
		
		private function __construct(
			string $type,
			string $number,
			string $expirationMonth,
			string $expirationYear,
			string $cvv,
			string $holderName
		)
		{
			if (!in_array($type, ['visa', 'mastercard', 'amex', 'discover', 'diners', 'jcb'])) {
				throw new \InvalidArgumentException('Invalid card type');
			}
			$this->holderName = $holderName;
			$this->cvv = $cvv;
			$this->expirationYear = $expirationYear;
			$this->expirationMonth = $expirationMonth;
			$this->number = $number;
			$this->type = $type;
		}
		
		public static function make(
			string $type,
			string $number,
			string $expirationMonth,
			string $expirationYear,
			string $cvv,
			string $holderName
		): self
		{
			return new self($type, $number, $expirationMonth, $expirationYear, $cvv, $holderName);
		}
		
		public function toArray(): array
		{
			return [
				'type' => $this->type,
				'number' => $this->number,
				'expirationMonth' => $this->expirationMonth,
				'expirationYear' => $this->expirationYear,
				'cvv' => $this->cvv,
				'holderName' => $this->holderName,
			];
		}
		
		public function type(): string
		{
			return $this->type;
		}
		
		public function number(): string
		{
			return $this->number;
		}
		
		public function expirationMonth(): string
		{
			return $this->expirationMonth;
		}
		
		public function expirationYear(): string
		{
			return $this->expirationYear;
		}
		
		public function cvv(): string
		{
			return $this->cvv;
		}
		
		public function holderName(): string
		{
			return $this->holderName;
		}
		
		public function getIterator(): Traversable
		{
			return new \ArrayIterator($this->toArray());
		}
		
		public function jsonSerialize(): array
		{
			return $this->toArray();
		}
	}