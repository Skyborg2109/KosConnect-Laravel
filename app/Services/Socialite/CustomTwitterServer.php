<?php

namespace App\Services\Socialite;

use League\OAuth1\Client\Server\Twitter;
use GuzzleHttp\Client;

class CustomTwitterServer extends Twitter
{
    // =========================================================================
    // OVERRIDE URL CONFIGURATION METHODS (Using X/Twitter's New API)
    // =========================================================================

    public function urlTemporaryCredentials()
    {
        return 'https://api.twitter.com/oauth/request_token';
    }

    public function urlAuthorization()
    {
        return 'https://twitter.com/oauth/authenticate';
    }

    public function urlTokenCredentials()
    {
        return 'https://api.twitter.com/oauth/access_token';
    }

    public function urlUserDetails()
    {
        return 'https://api.twitter.com/1.1/account/verify_credentials.json?include_email=true';
    }

    // =========================================================================
    // OVERRIDE LOGIC METHODS (Force URL usage regardless of internal logic)
    // =========================================================================

    public function getTemporaryCredentialsUrl()
    {
        return 'https://api.twitter.com/oauth/request_token';
    }

    public function getAuthorizationUrl($temporaryIdentifier, array $options = [])
    {
        // Handle both object (Credentials entity) and string identifiers
        if (is_object($temporaryIdentifier) && method_exists($temporaryIdentifier, 'getIdentifier')) {
             $token = $temporaryIdentifier->getIdentifier();
        } else {
             $token = (string) $temporaryIdentifier;
        }

        return 'https://twitter.com/oauth/authenticate?oauth_token=' . $token;
    }

    public function getAccessTokenUrl($temporaryIdentifier, $verifier)
    {
        return 'https://api.twitter.com/oauth/access_token';
    }

    // =========================================================================
    // OVERRIDE HTTP CLIENT (Handle SSL and modern requirements)
    // =========================================================================
    
    public function createHttpClient()
    {
        $config = [
            'headers' => [
                'User-Agent' => 'Laravel-OAuth-Client/2.0',
                'Accept' => 'application/json',
            ],
            'timeout' => 30,
            'connect_timeout' => 10,
        ];

        // For production, ensure proper SSL verification
        // Only disable in local development if absolutely necessary
        if (config('app.env') === 'local' && config('app.debug') === true) {
            $config['verify'] = false;
        }

        return new Client($config);
    }
}
