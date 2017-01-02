<?php

namespace Itafroma\Snaglogger\Test;

use Itafroma\Snaglogger\SeverityMapper;
use PHPUnit_Framework_TestCase;
use Psr\Log\LogLevel;

/**
 * Tests the default log-level-to-Bugsnag-severity mapper.
 */
class SeverityMapperTest extends PHPUnit_Framework_TestCase
{
    /**
     * Ensures the severity mapper handles all required log levels.
     */
    public function testRequiredLogLevels()
    {
        $mapper = new SeverityMapper();

        $mapper->getSeverityForLogLevel(LogLevel::EMERGENCY);
        $mapper->getSeverityForLogLevel(LogLevel::ALERT);
        $mapper->getSeverityForLogLevel(LogLevel::CRITICAL);
        $mapper->getSeverityForLogLevel(LogLevel::ERROR);
        $mapper->getSeverityForLogLevel(LogLevel::WARNING);
        $mapper->getSeverityForLogLevel(LogLevel::NOTICE);
        $mapper->getSeverityForLogLevel(LogLevel::INFO);
        $mapper->getSeverityForLogLevel(LogLevel::DEBUG);
    }

    /**
     * Ensures the severity mapper throws an exception for an optional log level.
     *
     * @expectedException \Psr\Log\InvalidArgumentException
     */
    public function testExeptionIsThrownForUnhandledLogLevel()
    {
        $mapper = new SeverityMapper();

        $mapper->getSeverityForLogLevel('invalid');
    }
}
