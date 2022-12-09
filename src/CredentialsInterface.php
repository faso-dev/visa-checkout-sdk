<?php
	
	namespace FasoDev\VisaCheckoutSdk;
	
	interface CredentialsInterface
	{
		public function accessToken(): string;
		
		public function apiKey(): string;
		
		public function apiSharedSecret(): string;
		
		
	}