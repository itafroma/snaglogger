<?php

namespace Itafroma\Snaglogger\Test;

use Itafroma\Snaglogger\SeverityMapper;
use PHPUnit\Framework\TestCase;
use Psr\Log\InvalidArgumentException;
use Psr\Log\LogLevel;

/**
 * Tests the default log-level-to-Bugsnag-severity mapper.
 */
class SeverityMapperTest extends TestCase
{
    /**
     * Ensures the severity mapper handles all required log levels.
     */
    public function testRequiredLogLevels()
    {
        $mapper = new SeverityMapper();

        $this->assertEquals('error', $mapper->getSeverityForLogLevel(LogLevel::EMERGENCY));
        $this->assertEquals('error', $mapper->getSeverityForLogLevel(LogLevel::ALERT));
        $this->assertEquals('error', $mapper->getSeverityForLogLevel(LogLevel::CRITICAL));
        $this->assertEquals('error', $mapper->getSeverityForLogLevel(LogLevel::ERROR));
        $this->assertEquals('warning', $mapper->getSeverityForLogLevel(LogLevel::WARNING));
        $this->assertEquals('info', $mapper->getSeverityForLogLevel(LogLevel::NOTICE));
        $this->assertEquals('info', $mapper->getSeverityForLogLevel(LogLevel::INFO));
        $this->assertEquals('info', $mapper->getSeverityForLogLevel(LogLevel::DEBUG));
    }

    /**
     * Ensures the severity mapper throws an exception for an optional log level.
     */
    public function testExceptionIsThrownForUnhandledLogLevel()
    {
        $this->expectException(InvalidArgumentException::class);

        $mapper = new SeverityMapper();

        $mapper->getSeverityForLogLevel('invalid');
    }
}
