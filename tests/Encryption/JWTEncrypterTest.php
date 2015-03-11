<?php

namespace Wzrd\Framework\Test\Encryption;

use JWT;
use Mockery;
use PHPUnit_Framework_TestCase;
use Wzrd\Framework as Framework;

class JWTEncrypterTest extends PHPUnit_Framework_TestCase
{
    public function test_encrypt_decrypt()
    {
        // Init ..
        $encrypter = new Framework\Encryption\JWTEncrypter('security_key');
        $encrypter_2 = new Framework\Encryption\JWTEncrypter('diff_key');

        // Test !
        $plain_value = 'value';

        // Do encrypt / encrypt
        $encrypted_value = $encrypter->encrypt($plain_value);
        $decrypted_value = $encrypter->decrypt($encrypted_value);
        $encrypted_value_2 = $encrypter_2->encrypt($plain_value);
        $decrypted_value_2 = $encrypter_2->decrypt($encrypted_value_2);

        // Test if encrypted value is different of plain value
        $this->assertNotEquals($plain_value, $encrypted_value);

        // Test if different security key provide different encryption
        $this->assertNotEquals($encrypted_value, $encrypted_value_2);

        // Test if decrypt equals plain value
        $this->assertEquals($plain_value, $decrypted_value);
        $this->assertEquals($plain_value, $decrypted_value_2);
    }

    public function test_encrypt_decrypt_array()
    {
        // Init ..
        $encrypter = new Framework\Encryption\JWTEncrypter('security_key');

        // Test !
        $plain_value = array('test' => 'ok');
        $encrypted_value = $encrypter->encrypt($plain_value);
        $decrypted_value = $encrypter->decrypt($encrypted_value);
        $this->assertNotEquals($plain_value, $encrypted_value);
        $this->assertEquals($plain_value, (array) $decrypted_value);
    }

    public function tearDown()
    {
        parent::tearDown();
        Mockery::close();
    }
}
