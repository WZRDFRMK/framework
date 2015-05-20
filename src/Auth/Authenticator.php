<?php

namespace WZRD\Auth;

use Exception;
use WZRD\Contracts\Auth\Provider;
use WZRD\Contracts\Auth\Authenticator as AuthenticatorContract;

class Authenticator implements AuthenticatorContract
{
    /**
     * Authenticate data with providers.
     *
     * @param array                          $data
     * @param WZRD\Contracts\Auth\Provider[] $providers
     *
     * @return mixed
     */
    public function authenticate(array $data, array $providers)
    {
        // Initialize the exceptions stack
        $exceptions = [];

        // Try to authenticate
        foreach ($providers as $provider) {
            if ($provider instanceof Provider) {
                try {
                    return $provider->authenticate($data);
                } catch (Exception $e) {
                    $exceptions[] = $e;
                }
            }
        }

        // If no values are returned, throw the first exception
        throw array_shift($exceptions);
    }
}
