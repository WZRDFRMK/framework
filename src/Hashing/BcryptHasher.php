<?php

namespace WZRD\Hashing;

use WZRD\Contracts\Hashing\Hasher;

class BcryptHasher implements Hasher
{
    /**
     * Hash the given value.
     *
     * @param string $value
     * @param array  $options
     *
     * @return string
     */
    public function hash($value, array $options = [])
    {
        return password_hash($value, PASSWORD_BCRYPT, $options);
    }

    /**
     * Check the given plain value against a hash.
     *
     * @param string $value
     * @param string $hash
     * @param array  $options
     *
     * @return bool
     */
    public function verify($value, $hash, array $options = [])
    {
        return (bool) password_verify($value, $hash);
    }
}
