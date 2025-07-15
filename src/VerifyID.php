<?php
namespace VerifyID;

/**
 * Class VerifyID
 *
 * PHP SDK for interacting with the VerifyID.io API endpoints.
 */
class VerifyID
{
    /**
     * @var string API Key for authentication (x-api-key header)
     */
    protected $apiKey;

    /**
     * @var string Base URL for the API
     */
    protected $baseUrl = 'https://api.verifyid.io';

    /**
     * VerifyID constructor.
     *
     * @param string $apiKey   Your VerifyID API Key.
     * @param string|null $baseUrl Optionally override the API base URL.
     */
    public function __construct(string $apiKey, string $baseUrl = null)
    {
        $this->apiKey = $apiKey;
        if ($baseUrl) $this->baseUrl = $baseUrl;
    }

    /**
     * Internal helper to make POST requests.
     *
     * @param string $endpoint API endpoint (path)
     * @param array $payload   Request payload as associative array
     * @return mixed           Decoded API response
     * @throws \Exception      On CURL errors
     */
    protected function request(string $endpoint, array $payload)
    {
        $ch = curl_init($this->baseUrl . $endpoint);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Content-Type: application/json",
            "x-api-key: {$this->apiKey}"
        ]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        if ($response === false) {
            throw new \Exception('Curl error: ' . curl_error($ch));
        }
        curl_close($ch);
        return json_decode($response, true);
    }

    /**
     * Full KYC Verification
     *
     * @param string $frontImage  Base64-encoded front of ID/passport
     * @param string $selfieImage Base64-encoded selfie image
     * @param string|null $backImage  Base64-encoded back of ID (optional)
     * @param float $threshold   Similarity threshold (default: 0.6)
     * @return mixed             API response
     */
    public function fullKycVerification(string $frontImage, string $selfieImage, string $backImage = null, float $threshold = 0.6)
    {
        $payload = [
            "front_image" => $frontImage,
            "selfie_image" => $selfieImage,
            "threshold" => $threshold
        ];
        if ($backImage) $payload["back_image"] = $backImage;
        return $this->request('/kyc/full_verification', $payload);
    }

    /**
     * Face Match - Compare a document image and a selfie
     *
     * @param string $frontImage  Base64-encoded front of ID/passport
     * @param string $selfieImage Base64-encoded selfie image
     * @param float $threshold    Similarity threshold (default: 0.6)
     * @return mixed              API response
     */
    public function faceMatch(string $frontImage, string $selfieImage, float $threshold = 0.6)
    {
        $payload = [
            "front_image" => $frontImage,
            "selfie_image" => $selfieImage,
            "threshold" => $threshold
        ];
        return $this->request('/face-match', $payload);
    }

    /**
     * Liveness Detection - Passive liveness check on a selfie image
     *
     * @param string $imageBase64 Base64-encoded face image
     * @return mixed              API response
     */
    public function livenessDetection(string $imageBase64)
    {
        $payload = [
            "image_base64" => $imageBase64
        ];
        return $this->request('/liveness-detection', $payload);
    }

    /**
     * Deepfake Detection - Test if a face image is synthetic
     *
     * @param string $imageBase64 Base64-encoded face image
     * @return mixed              API response
     */
    public function deepfakeDetection(string $imageBase64)
    {
        $payload = [
            "image_base64" => $imageBase64
        ];
        return $this->request('/deepfake-detection', $payload);
    }

    /**
     * Document Reader (OCR) - Extract text and KYC fields from an ID or passport
     *
     * @param string $imageFront  Base64-encoded front of document
     * @param string|null $imageBack Base64-encoded back of document (optional)
     * @return mixed              API response
     */
    public function documentReader(string $imageFront, string $imageBack = null)
    {
        $payload = [
            "image_front" => $imageFront
        ];
        if ($imageBack) $payload["image_back"] = $imageBack;
        return $this->request('/document-reader', $payload);
    }

    /**
     * Credit Card Reader - Extract card number and name from image
     *
     * @param string $imageBase64 Base64-encoded credit card image (front)
     * @return mixed              API response
     */
    public function creditCardReader(string $imageBase64)
    {
        $payload = [
            "image_base64" => $imageBase64
        ];
        return $this->request('/credit-card-reader', $payload);
    }

    /**
     * Barcode Reader - Extract data from barcode image (usually back of ID)
     *
     * @param string $imageBase64 Base64-encoded barcode image
     * @return mixed              API response
     */
    public function barcodeReader(string $imageBase64)
    {
        $payload = [
            "image_base64" => $imageBase64
        ];
        return $this->request('/barcode-reader', $payload);
    }

    /**
     * AML/PEP/Crime Checker - Search AML, PEP, and crime lists
     *
     * @param string|null $name    Full name or company/business name
     * @param int|null $entity     Entity type (0=Person, 1=Company, etc.)
     * @param string|null $country 2-letter ISO country code (optional)
     * @param string|null $dataset Dataset: sanctions|peps|crime|all (optional)
     * @return mixed               API response
     */
    public function amlPepCrimeChecker(string $name = null, int $entity = null, string $country = null, string $dataset = null)
    {
        $payload = [];
        if ($name !== null) $payload['name'] = $name;
        if ($entity !== null) $payload['entity'] = $entity;
        if ($country !== null) $payload['country'] = $country;
        if ($dataset !== null) $payload['dataset'] = $dataset;
        return $this->request('/aml-pep-crime-checker', $payload);
    }
}
