<?php

namespace Itafroma\Snaglogger;

use Psr\Log\InvalidArgumentException;
use Psr\Log\LogLevel;

/**
 * Maps PSR-3 log levels to Bugsnag severities.
 */
class SeverityMapper implements SeverityMapperInterface
{
    private $mapping = [
        LogLevel::EMERGENCY => 'error',
        LogLevel::ALERT => 'error',
        LogLevel::CRITICAL => 'error',
        LogLevel::ERROR => 'error',
        LogLevel::WARNING => 'warning',
        LogLevel::NOTICE => 'info',
        LogLevel::INFO => 'info',
        LogLevel::DEBUG => 'info',
    ];

    /**
     * {@inheritDoc}
     */
    public function getSeverityForLogLevel($level)
    {
        if (!isset($this->mapping[$level])) {
            $message = sprintf('The log level %s is not supported.', $level);
            throw new InvalidArgumentException($message);
        }

        return $this->mapping[$level];
    }
}
