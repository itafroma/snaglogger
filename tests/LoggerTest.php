<?php

namespace Itafroma\Snaglogger\Test;

use Bugsnag\Client;
use Error;
use Exception;
use Itafroma\Snaglogger\Logger;
use Itafroma\Snaglogger\MessageInterpolatorInterface;
use Itafroma\Snaglogger\SeverityMapperInterface;
use PHPUnit_Framework_TestCase;

/**
 * Tests the Snaglogger logger.
 */
class LoggerTest extends PHPUnit_Framework_TestCase
{
    /**
     * A mock Bugsnag client.
     *
     * @var Client
     */
    private $bugsnag;

    /**
     * A mock message interpolator.
     *
     * @var MessageInterpolatorInterface
     */
    private $interpolator;

    /**
     * A mock severity mapper.
     *
     * @var SeverityMapperInterface
     */
    private $mapper;

    /**
     * {@inheritDoc}
     */
    public function setUp()
    {
        $this->bugsnag = $this->createMock(Client::class);
        $this->interpolator = $this->createMock(MessageInterpolatorInterface::class);
        $this->mapper = $this->createMock(SeverityMapperInterface::class);
    }

    /**
     * Ensures Bugsnag is notified of an exception if the 'exception' key in $context is an exception.
     */
    public function testException()
    {
        $this->bugsnag->expects($this->once())
            ->method('notifyException');
        $this->bugsnag->expects($this->exactly(0))
            ->method('notifyError');

        $this->mapper->method('getSeverityForLogLevel')
            ->willReturn('error');

        $logger = new Logger($this->bugsnag, $this->interpolator, $this->mapper);
        $context = [
            'exception' => new Exception(),
        ];

        $logger->error('Test message', $context);
    }

    /**
     * Ensures Bugsnag is notified of an exception if the 'exception' key in $context is a throwable.
     *
     * @requires PHP 7.0
     *
     */
    public function testThrowable()
    {
        $this->bugsnag->expects($this->once())
            ->method('notifyException');
        $this->bugsnag->expects($this->exactly(0))
            ->method('notifyError');

        $this->mapper->method('getSeverityForLogLevel')
            ->willReturn('error');

        $logger = new Logger($this->bugsnag, $this->interpolator, $this->mapper);
        $context = [
            'exception' => new Error(),
        ];

        $logger->error('Test message', $context);
    }

    /**
     * Ensures BugSnag ignores the 'exception' key in $context if it's not an actual exception.
     */
    public function testFakeException()
    {
        $this->bugsnag->expects($this->exactly(0))
            ->method('notifyException');
        $this->bugsnag->expects($this->once())
            ->method('notifyError');

        $this->mapper->method('getSeverityForLogLevel')
            ->willReturn('error');

        $logger = new Logger($this->bugsnag, $this->interpolator, $this->mapper);
        $context = [
            'exception' => 'not a real exception',
        ];

        $logger->error('Test message', $context);
    }

    /**
     * Ensures nothing happens if the severity mapper returns null.
     */
    public function testIgnoreSeverityLevel()
    {
        $this->bugsnag->expects($this->exactly(0))
            ->method('notifyException');
        $this->bugsnag->expects($this->exactly(0))
            ->method('notifyError');

        $this->mapper->method('getSeverityForLogLevel')
            ->willReturn(null);

        $logger = new Logger($this->bugsnag, $this->interpolator, $this->mapper);

        $logger->error('Test message');
    }

    /**
     * Ensures the 'error-type' key within $context is used for the error name.
     */
    public function testErrorName()
    {
        $name = 'Test name';

        $this->bugsnag->expects($this->once())
            ->method('notifyError')
            ->with($this->equalTo($name));

        $this->mapper->method('getSeverityForLogLevel')
            ->willReturn('error');

        $logger = new Logger($this->bugsnag, $this->interpolator, $this->mapper);

        $logger->error('Test message', ['error-type' => $name]);
    }

    /**
     * Ensures the severity level is used as the error name if 'error-type' is not set in $context.
     */
    public function testFallbackErrorName()
    {
        $this->bugsnag->expects($this->once())
            ->method('notifyError')
            ->with($this->equalTo('error'));

        $this->mapper->method('getSeverityForLogLevel')
            ->willReturn('error');

        $logger = new Logger($this->bugsnag, $this->interpolator, $this->mapper);

        $logger->error('Test message');
    }
}
