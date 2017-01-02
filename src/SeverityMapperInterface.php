<?php

namespace Itafroma\Snaglogger;

use Psr\Log\InvalidArgumentException;

/**
 * Defines a mapper for translating PSR-3 log levels to Bugsnag severities.
 *
 * BugSnag does not implement every log level PSR-3 requires, so some log levels
 * either need to be mapped to already-taken Bugsnag severities or ignored.
 */
interface SeverityMapperInterface
{
    /**
     * Retrieves the Bugsnag severity mapped to the PSR-3 log level passed.
     *
     * Note that PSR-3 requires implementing libraries to accept the log levels
     * defined in \Psr\Log\LogLevel, even if it means doing nothing. If a
     * required log level is passed but you do not wish to send it to Bugsnag,
     * return null instead of throwing an exception.
     *
     * @param mixed $level
     *
     *
     * @throws InvalidArgumentException
     *   When a custom, non-required log level is passed that is not, or should
     *   not be, supported.
     *
     * @return string|null
     *   Either:
     *   - One of the supported Bugsnag severities: 'error', 'warning', or 'info'
     *   - null if no report should be sent to Bugsnag for the log level
     */
    public function getSeverityForLogLevel($level);
}
