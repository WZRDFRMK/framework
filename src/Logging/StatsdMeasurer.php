<?php

namespace Wzrd\Logging;

use League\StatsD\Client as Statsd;
use Wzrd\Contracts\Logging\Measurer;

class StatsdMeasurer implements Measurer
{
    /**
     * StatsD instance
     *
     * @var League\StatsD\Client
     */
    private $statsd;

    /**
     * Initialize measurer with StatsD instance
     *
     * @param League\StatsD\Client $statsd
     */
    public function __construct(Statsd $statsd)
    {
        $this->statsd = $statsd;
    }

    /**
     * Increment a metric
     *
     * @param  string|array $metrics Metric(s) to increment
     * @param  int $delta Value to decrement the metric by
     * @param  int $sampleRate Sample rate of metric
     * @return bool True if data transfer is successful
     */
    public function increment($metrics, $delta = 1, $sampleRate = 1)
    {
        return $this->statsd->increment($metrics, $delta, $sampleRate);
    }

    /**
     * Decrement a metric
     *
     * @param  string|array $metrics Metric(s) to decrement
     * @param  int $delta Value to increment the metric by
     * @param  int $sampleRate Sample rate of metric
     * @return bool True if data transfer is successful
     */
    public function decrement($metrics, $delta = 1, $sampleRate = 1)
    {
        return $this->statsd->decrement($metrics, $delta, $sampleRate);
    }

    /**
     * Timing
     *
     * @param  string $metric Metric to track
     * @param  float $time Time in milliseconds
     * @return bool True if data transfer is successful
     */
    public function timing($metric, $time)
    {
        return $this->statsd->timing($metric, $time);
    }

    /**
     * Time a function
     *
     * @param  string $metric Metric to time
     * @param  callable $func Function to record
     * @return bool True if data transfer is successful
     */
    public function time($metric, $func)
    {
        return $this->statsd->time($metric, $func);
    }

    /**
     * Gauges
     *
     * @param  string $metric Metric to gauge
     * @param  int $value Set the value of the gauge
     * @return bool True if data transfer is successful
     */
    public function gauge($metric, $value)
    {
        return $this->statsd->gauge($metric, $value);
    }

    /**
     * Sets - count the number of unique values passed to a key
     *
     * @param $metric
     * @param mixed $value
     * @return bool True if data transfer is successful
     */
    public function set($metric, $value)
    {
        return $this->statsd->set($metric, $value);
    }
}
