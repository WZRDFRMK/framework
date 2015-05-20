<?php

namespace WZRD\Test\Auth;

use Exception;
use Mockery;
use PHPUnit_Framework_TestCase;
use WZRD as Framework;
use WZRD\Contracts as Contracts;

class AuthenticatorTest extends PHPUnit_Framework_TestCase
{
    public function test_authenticate()
    {
        // Init ..
        $authenticator = new Framework\Auth\Authenticator;
        $providers = [
            Mockery::mock('WZRD\Contracts\Auth\Provider'),
            Mockery::mock('WZRD\Contracts\Auth\Provider')
        ];

        // Prepare
        $data = ['email' => 'foo@bar'];
        $providers[0]->shouldReceive('authenticate')->with($data)->andThrow(new Exception('Invalid'))->once();
        $providers[1]->shouldReceive('authenticate')->with($data)->andReturn(true)->once();

        // Do authenticate
        $this->assertTrue($authenticator->authenticate($data, $providers));
    }

    public function test_authenticate_throw_exception()
    {
        // Init ..
        $authenticator = new Framework\Auth\Authenticator;
        $providers = [
            Mockery::mock('WZRD\Contracts\Auth\Provider'),
            Mockery::mock('WZRD\Contracts\Auth\Provider')
        ];

        // Prepare
        $data = ['email' => 'foo@bar'];
        $providers[0]->shouldReceive('authenticate')->with($data)->andThrow(new Exception('Invalid'))->once();
        $providers[1]->shouldReceive('authenticate')->with($data)->andThrow(new Exception('Not found'))->once();

        // Do authenticate
        try {
            $authenticator->authenticate($data, $providers);
            $this->fail('Exception must be throw');
        } catch (Exception $e) {
            $this->assertEquals('Invalid', $e->getMessage());
            return;
        }
    }

    public function tearDown()
    {
        parent::tearDown();
        Mockery::close();
    }
}
