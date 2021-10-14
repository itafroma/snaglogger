<?php

namespace Itafroma\Snaglogger\Test\Callbacks;

use Bugsnag\Configuration;
use Bugsnag\Report;
use Bugsnag\Stacktrace;
use Itafroma\Snaglogger\Callbacks\RemoveLoggerFromStacktrace;
use PHPUnit\Framework\TestCase;

/**
 * Tests the Bugsnag callback to remove PSR-3 loggers from the top of the stacktrace.
 */
class RemoveLoggerFromStacktraceTest extends TestCase
{
    /**
     * A mock stacktrace.
     *
     * @var \Bugsnag\Stacktrace
     */
    protected $stacktrace;

    /**
     * A mock Bugsnag report.
     *
     * @var \Bugsnag\Report
     */
    protected $report;

    /**
     * {@inheritDoc}
     */
    public function setUp(): void
    {
        $config = $this->createMock(Configuration::class);

        $this->stacktrace = new Stacktrace($config);

        $this->report = $this->createMock(Report::class);
        $this->report->method('getStacktrace')
            ->willReturn($this->stacktrace);
    }

    /**
     * Ensures the callback removes \Psr\Log\LoggerInterface::log.
     */
    public function testCallbackRemovesLoggerLog()
    {
        $this->stacktrace->addFrame('logger.php', 10, 'log', '\Psr\Log\NullLogger');
        $this->stacktrace->addFrame('base.php', 10, 'base');

        $callback = new RemoveLoggerFromStacktrace();
        $callback($this->report);

        $this->assertEquals(1, count($this->stacktrace->toArray()));
    }

    /**
     * Ensures the callback removes all scopes asscoiated with a PSR-3 convenience method.
     */
    public function testCallbackRemovesLoggerConvenienceMethod()
    {
        $this->stacktrace->addFrame('logger.php', 10, 'log', '\Psr\Log\NullLogger');
        $this->stacktrace->addFrame('logger.php', 20, 'error', '\Psr\Log\NullLogger');
        $this->stacktrace->addFrame('base.php', 10, 'base');

        $callback = new RemoveLoggerFromStacktrace();
        $callback($this->report);

        $this->assertEquals(1, count($this->stacktrace->toArray()));
    }

    /**
     * Ensures the callback ignores procedural code at the top of the stacktrace.
     */
    public function testCallbackIgnoresProceduralCode()
    {
        $this->stacktrace->addFrame('procedural.php', 10, 'procedural');
        $this->stacktrace->addFrame('base.php', 10, 'base');

        $callback = new RemoveLoggerFromStacktrace();
        $callback($this->report);

        $this->assertEquals(2, count($this->stacktrace->toArray()));
    }

    /**
     * Ensures the callback ignores non PSR-3 logger classes.
     */
    public function testCallbackIgnoresNonPsr3Code()
    {
        $this->stacktrace->addFrame('non-psr3.php', 10, 'test', '\Exception');
        $this->stacktrace->addFrame('base.php', 10, 'base');

        $callback = new RemoveLoggerFromStacktrace();
        $callback($this->report);

        $this->assertEquals(2, count($this->stacktrace->toArray()));
    }
}
