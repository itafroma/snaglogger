<?php

namespace Itafroma\Snaglogger\Test;

use Itafroma\Snaglogger\Logger;
use Itafroma\Snaglogger\LoggerFactory;
use PHPUnit\Framework\TestCase;

/**
 * Tests the factory for creating Snaglogger loggers.
 */
class LoggerFactoryTest extends TestCase
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
