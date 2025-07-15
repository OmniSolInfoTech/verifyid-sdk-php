<?php namespace Config;

use CodeIgniter\Config\BaseService;

class Services extends BaseService
{
    public static function verifyid($getShared = true)
    {
        if ($getShared) {
            return static::getSharedInstance('verifyid');
        }
        $apiKey = getenv('VERIFYID_API_KEY');
        $baseUrl = getenv('VERIFYID_BASE_URL') ?: 'https://api.verifyid.io';
        return new \VerifyID\VerifyID($apiKey, $baseUrl);
    }
}
