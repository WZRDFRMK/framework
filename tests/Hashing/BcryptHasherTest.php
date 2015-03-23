<?php

namespace WZRD\Test\Hashing;

use Mockery;
use PHPUnit_Framework_TestCase;
use WZRD as Framework;

class BcryptHasherTest extends PHPUnit_Framework_TestCase
{
    public function test_hash_and_veriify()
    {
        // Init ..
        $hasher = new Framework\Hashing\BcryptHasher();

        // Hash
        $plain_value = 'value';
        $hash = $hasher->hash($plain_value, array('cost' => 10));
        $hash_with_different_cost = $hasher->hash($plain_value, array('cost' => 5));

        // Test
        $this->assertNotEquals($plain_value, $hash);
        $this->assertNotEquals($hash, $hash_with_different_cost);
        $this->assertTrue($hasher->verify($plain_value, $hash));
    }

    public function tearDown()
    {
        parent::tearDown();
        Mockery::close();
    }
}
