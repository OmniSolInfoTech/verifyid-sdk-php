# VerifyID PHP SDK

![Packagist Version (custom server)](https://img.shields.io/packagist/v/verifyid/sdk)
![Packagist PHP Version](https://img.shields.io/packagist/dependency-v/verifyid/sdk/php)
![Static Badge](https://img.shields.io/badge/php-Laravel-purple)
![Static Badge](https://img.shields.io/badge/php-CodeIgnitor-yellow)
![License](https://img.shields.io/github/license/omnisolinfotech/verifyid-sdk-php)

Official PHP client for [VerifyID.io](https://api.verifyid.io) – seamless integration for KYC, AML, and identity verification.

## Installation

```bash
composer require verifyid/sdk
```
# Usage
## Vanilla PHP

require 'vendor/autoload.php';

use VerifyID\VerifyID;
```bash
$verifyID = new VerifyID('YOUR_API_KEY');

// Full KYC Verification
$response = $verifyID->fullKycVerification($frontBase64, $selfieBase64, $backBase64);

// Face Match
$response = $verifyID->faceMatch($frontBase64, $selfieBase64);

// Liveness Detection
$response = $verifyID->livenessDetection($selfieBase64);

// Deepfake Detection
$response = $verifyID->deepfakeDetection($selfieBase64);

// Document OCR
$response = $verifyID->documentReader($frontBase64, $backBase64);

// Credit Card Reader
$response = $verifyID->creditCardReader($creditCardBase64);

// Barcode Reader
$response = $verifyID->barcodeReader($barcodeBase64);

// AML/PEP/Crime Check
$response = $verifyID->amlPepCrimeChecker('John Doe', 0, 'ZA', 'all');
```

## Laravel
1. Add VERIFYID_API_KEY=your-api-key to your .env file.
2. The SDK will be auto-registered thanks to the Service Provider and Facade.
```bash
use VerifyID\Laravel\VerifyIDFacade as VerifyID;

// Example usage in Controller or Service
$response = VerifyID::fullKycVerification($frontBase64, $selfieBase64, $backBase64);

// Or dependency-injected:
public function handle(\VerifyID\VerifyID $verifyID) {
    $response = $verifyID->fullKycVerification($front, $selfie, $back);
}
```

Publish the config (optional):
```bash
php artisan vendor:publish --tag=verifyid-config
```
## CodeIgniter 4
1. Set your API key in .env:
```bash
VERIFYID_API_KEY=your-api-key
VERIFYID_BASE_URL=https://api.verifyid.io
```
2. Use the SDK via the provided service in your controllers:
```bash
$verifyID = service('verifyid');
$response = $verifyID->fullKycVerification($frontBase64, $selfieBase64, $backBase64);
```

# Endpoints Supported
* Full KYC Verification
* Face Match
* Liveness Detection
* DDeepfake Detection
* Document Reader (OCR)
* Credit Card Reader
* Barcode Reader
* AML/PEP/Crime Checker

# Notes
* All images must be base64 encoded (base64_encode(file_get_contents($path))).
* Responses are associative arrays.
* For advanced usage (custom base URL, etc.), pass a second parameter to new VerifyID($apiKey, $baseUrl).

# Testing
```bash
composer install
./vendor/bin/phpunit
```