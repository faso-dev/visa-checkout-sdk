<?php
	
	namespace FasoDev\VisaCheckoutSdk\Tests;
	
	use FasoDev\VisaCheckoutSdk\CurlClient;
	use PHPUnit\Framework\TestCase;
	use function var_dump;
	
	class CurlClientTest extends TestCase
	{
		public function testSuccessfullGetRequest()
		{
			$response = CurlClient::make()->get('https://httpbin.org/get');
			$this->assertEquals(200, $response->status());
			$this->assertNotEmpty($response->body());
		}
		
		public function testFailedGetRequest()
		{
			$response = CurlClient::make()->get('https://httpbin.org/status');
			$this->assertEquals(404, $response->status());
			var_dump($response->body());
			$this->assertNotEmpty($response->body());
		}
		
		public function testSuccessfullPostRequest()
		{
			$response = CurlClient::make()->post('https://jsonplaceholder.typicode.com/posts', [
				'title' => 'foo',
				'body' => 'bar',
				'userId' => 1,
			], [
				'Content-Type: application/json; charset=UTF-8',
			]);
			$this->assertEquals(201, $response->status());
			$this->assertNotEmpty($response->json());
		}
	}