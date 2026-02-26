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

    // Removed createHttpClient as it was stripping OAuth 1.0 signatures.
}
