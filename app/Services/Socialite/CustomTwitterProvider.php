<?php

namespace App\Services\Socialite;

use Laravel\Socialite\One\TwitterProvider;

class CustomTwitterProvider extends TwitterProvider
{
    /**
     * {@inheritdoc}
     */
    public function redirect()
    {
        // Ensure session is started before OAuth flow
        if (!session()->isStarted()) {
            session()->start();
        }

        return parent::redirect();
    }

    /**
     * Get the authentication URL for the provider.
     *
     * @param  string  $token
     * @return string
     */
    protected function getAuthUrl($token)
    {
        // Use twitter.com for the redirect to avoid SSL certificate issues with api.x.com/api.twitter.com in some browsers
        return 'https://twitter.com/oauth/authenticate?oauth_token='.$token;
    }
}
