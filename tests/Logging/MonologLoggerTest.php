<?php

namespace Wzrd\Test\Logging;

use Mockery;
use PHPUnit_Framework_TestCase;
use Wzrd as Framework;

class MonologLoggerTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->monolog = Mockery::mock('Monolog\Logger')->makePartial();
        $this->logger = new Framework\Logging\MonologLogger($this->monolog);
    }

    public function test_emergency_level()
    {
        $this->monolog->shouldReceive('addEmergency')->with('message', array('context' => 'value'))->once();
        $this->logger->emergency('message', array('context' => 'value'));
    }

    public function test_alert_level()
    {
        $this->monolog->shouldReceive('addAlert')->with('message', array('context' => 'value'))->once();
        $this->logger->alert('message', array('context' => 'value'));
    }

    public function test_critical_level()
    {
        $this->monolog->shouldReceive('addCritical')->with('message', array('context' => 'value'))->once();
        $this->logger->critical('message', array('context' => 'value'));
    }

    public function test_error_level()
    {
        $this->monolog->shouldReceive('addError')->with('message', array('context' => 'value'))->once();
        $this->logger->error('message', array('context' => 'value'));
    }

    public function test_warning_level()
    {
        $this->monolog->shouldReceive('addWarning')->with('message', array('context' => 'value'))->once();
        $this->logger->warning('message', array('context' => 'value'));
    }

    public function test_notice_level()
    {
        $this->monolog->shouldReceive('addNotice')->with('message', array('context' => 'value'))->once();
        $this->logger->notice('message', array('context' => 'value'));
    }

    public function test_info_level()
    {
        $this->monolog->shouldReceive('addInfo')->with('message', array('context' => 'value'))->once();
        $this->logger->info('message', array('context' => 'value'));
    }

    public function test_debug_level()
    {
        $this->monolog->shouldReceive('addDebug')->with('message', array('context' => 'value'))->once();
        $this->logger->debug('message', array('context' => 'value'));
    }

    public function test_custom_level()
    {
        $this->monolog->shouldReceive('addRecord')->with('level', 'message', array('context' => 'value'))->once();
        $this->logger->log('level', 'message', array('context' => 'value'));
    }

    public function tearDown()
    {
        parent::tearDown();
        Mockery::close();
    }
}
