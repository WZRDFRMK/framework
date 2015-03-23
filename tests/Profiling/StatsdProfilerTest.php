<?php

namespace WZRD\Test\Profiling;

use Mockery;
use PHPUnit_Framework_TestCase;
use WZRD as Framework;

class StatsdProfilerTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->statsd = Mockery::mock('League\StatsD\Client')->makePartial();
        $this->measurer = new Framework\Profiling\StatsdMeasurer($this->statsd);
    }

    public function test_increment()
    {
        $this->statsd->shouldReceive('increment')->with('metric', 1, 1)->once();
        $this->measurer->increment('metric');
    }

    public function test_decrement()
    {
        $this->statsd->shouldReceive('decrement')->with('metric', 1, 1)->once();
        $this->measurer->decrement('metric', 1, 1);
    }

    public function test_timing()
    {
        $this->statsd->shouldReceive('timing')->with('metric', 1000)->once();
        $this->measurer->timing('metric', 1000);
    }

    public function test_time()
    {
        $func = function() {};
        $this->statsd->shouldReceive('time')->with('metric', $func)->once();
        $this->measurer->time('metric', $func);
    }

    public function test_gauge()
    {
        $this->statsd->shouldReceive('gauge')->with('metric', 50)->once();
        $this->measurer->gauge('metric', 50);
    }

    public function test_set()
    {
        $this->statsd->shouldReceive('set')->with('metric', 50)->once();
        $this->measurer->set('metric', 50);
    }

    public function tearDown()
    {
        parent::tearDown();
        Mockery::close();
    }
}
