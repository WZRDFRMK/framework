<?php

namespace WZRD\Test\Logging;

use Mockery;
use PHPUnit_Framework_TestCase;
use WZRD as Framework;

class MonologLoggerTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->monolog = Mockery::mock('Monolog\Logger')->makePartial();
        $this->logger  = new Framework\Logging\MonologLogger($this->monolog);
    }

    public function test_emergency_level()
    {
        $this->monolog->shouldReceive('addEmergency')->with('message', ['context' => 'value'])->once();
        $this->logger->emergency('message', ['context' => 'value']);
    }

    public function test_alert_level()
    {
        $this->monolog->shouldReceive('addAlert')->with('message', ['context' => 'value'])->once();
        $this->logger->alert('message', ['context' => 'value']);
    }

    public function test_critical_level()
    {
        $this->monolog->shouldReceive('addCritical')->with('message', ['context' => 'value'])->once();
        $this->logger->critical('message', ['context' => 'value']);
    }

    public function test_error_level()
    {
        $this->monolog->shouldReceive('addError')->with('message', ['context' => 'value'])->once();
        $this->logger->error('message', ['context' => 'value']);
    }

    public function test_warning_level()
    {
        $this->monolog->shouldReceive('addWarning')->with('message', ['context' => 'value'])->once();
        $this->logger->warning('message', ['context' => 'value']);
    }

    public function test_notice_level()
    {
        $this->monolog->shouldReceive('addNotice')->with('message', ['context' => 'value'])->once();
        $this->logger->notice('message', ['context' => 'value']);
    }

    public function test_info_level()
    {
        $this->monolog->shouldReceive('addInfo')->with('message', ['context' => 'value'])->once();
        $this->logger->info('message', ['context' => 'value']);
    }

    public function test_debug_level()
    {
        $this->monolog->shouldReceive('addDebug')->with('message', ['context' => 'value'])->once();
        $this->logger->debug('message', ['context' => 'value']);
    }

    public function test_custom_level()
    {
        $this->monolog->shouldReceive('addRecord')->with('level', 'message', ['context' => 'value'])->once();
        $this->logger->log('level', 'message', ['context' => 'value']);
    }

    public function tearDown()
    {
        parent::tearDown();
        Mockery::close();
    }
}
