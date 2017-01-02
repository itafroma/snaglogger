<?php

namespace Itafroma\Snaglogger\Test;

use Itafroma\Snaglogger\Logger;
use Itafroma\Snaglogger\LoggerFactory;
use PHPUnit_Framework_TestCase;

/**
 * Tests the factory for creating Snaglogger loggers.
 */
class LoggerFactoryTest extends PHPUnit_Framework_TestCase
{
    /**
     * Ensures create() creates an instance of a Snaglogger logger.
     */
    public function testCreate()
    {
        $key = 'feeddeadbeef';
        $factory = new LoggerFactory();

        $client = $factory->create($key);

        $this->assertInstanceOf(Logger::class, $client);
    }
}
