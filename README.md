## Visa Checkout SDK

This is a PHP library for the Visa Checkout API. It allows you to integrate Visa Checkout into your PHP application and make payments using Visa cards.

### Requirements

* PHP 8.0 or later
* Composer
* Visa Checkout account
* Visa Checkout SDK account
* Visa Checkout SDK merchant ID
* Visa Checkout SDK API key
* Visa Checkout SDK shared secret
* Visa Checkout SDK API endpoint
* Visa Checkout SDK API version

### Installation

To install the library, you can use Composer:

```bash
composer require faso-dev/visa-checkout-sdk
```

### Usage

Here is an example of how to use the library to create a payment using a Visa card:

```php
    use FasoDev\VisaCheckoutSdk\CardData;
    use FasoDev\VisaCheckoutSdk\Config;
    use FasoDev\VisaCheckoutSdk\Credentials;
    use FasoDev\VisaCheckoutSdk\PaymentException;
    use FasoDev\VisaCheckoutSdk\VisaPay;
    
    $config = Config::make(
        Credentials::make(
            'VCO_USER_1234567890',
            'VCO_PASS_1234567890',
        ),
    );
    
    $config->putUserAgent('Your user agent'); // Optional
    $config->putTimeout(30); // seconds, default is 30, optional
    $config->putConnectTimeout(30); // seconds, optional
    $config->putProxy('Your proxy'); // optional
    $config->putBaseUrl('Your base url'); // optional, but util if VISA change the base url
    $config->putCheckoutEndpoint('Your checkout endpoint'); // optional, but util if VISA change the checkout endpoint
    $config->putRequestHeaders(['Your request headers']);// optional
    
    // create a payable instance
    $payment = VisaPay::fromConfig($config);
    
    // create a visa card
    $visaCard = CardData::make(
        'visa',
        '4111111111111111',
        '12',
        '2025',
        '123',
        'John Doe',
    );
    // create a payment
	try {
		$transaction = (new CheckoutSdk($payment))->createPayment(
			100.00,
			'USD',
			$visaCard,
			'Payment description'
		);
		if ($transaction->isSuccessful()) {
			// add transaction info to your database(id, status, amount, currency, description, user_id, etc.)
		} elseif ($transaction->isDeclined()) {
			// retry payment or do something
		} else {
			// notify user or do something
		}
	} catch (PaymentException $e) {
		// handle exception
		echo $e->getMessage();
	}
```

### Testing

To run the tests, you can use the following command:

```bash
composer test
```

### License

The MIT License (MIT). 

#### Credits

- [Faso Dev](https://github.com/faso-dev)
