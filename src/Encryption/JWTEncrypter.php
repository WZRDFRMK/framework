<?php

namespace Wzrd\Framework\Encrypter;

use JWT;

class JWTEncrypter implements Encrypter
{
    /**
     * Security key
     *
     * @var string
     */
    private $key;

    /**
     * Initialize hash with security key
     *
     * @param string $key
     */
    public function __construct($key)
    {
        $this->key = $key;
    }

    /**
     * Encrypt the given value.
     *
     * @param mixed $value
     *
     * @return string
     */
    public function encrypt($value)
    {
        return JWT::encode($data, $this->key);
    }

    /**
     * Decrypt the given value.
     *
     * @param string $value
     *
     * @return mixed
     */
    public function decrypt($value)
    {
        return (array) JWT::decode($value, $this->key);
    }
}
