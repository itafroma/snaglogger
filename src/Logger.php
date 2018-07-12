<?php

namespace Itafroma\Snaglogger;

use Bugsnag\Client;
use Bugsnag\Report;
use Exception;
use Itafroma\Snaglogger\Callbacks\RemoveLoggerFromStacktrace;
use Itafroma\Snaglogger\Callbacks\LoggerStacktrace;
use Psr\Log\LoggerInterface;
use Psr\Log\LoggerTrait;
use Throwable;

/**
 * A PSR-3 compliant logger for reporting to Bugsnag.
 *
 * Notes:
 * - Bugsnag does not have corresponding severities for each log level required
 *   by PSR-3, so log levels need to be mapped to Bugsnag severities. This is
 *   done via implemenations of \Itafroma\Snaglogger\SeverityMapperInterface.
 * - Log messages will be sent to Bugsnag as errors unless the 'exception' key
 *   is set within the $context array. In that case, the message and exception
 *   will be sent to BugSnag as an exception.
 * - Bugsnag requires an name for errors reported. This can be set via the
 *   'error-type' key within the $context array.
 * - The data within the $context array will be sent to Bugsnag as metadata.
 */
class Logger implements LoggerInterface
{
    use LoggerTrait;

    /**
     * A Bugsnag client.
     *
     * @var Client
     */
    private $bugsnag;

    /**
     * A log messasge interpolator.
     *
     * @var MessageInterpolatorInterface
     */
    private $interpolator;

    /**
     * A severity level mapper.
     *
     * @var SeverityMapperInterface
     */
    private $mapper;

    /**
     * Initializes the logger.
     *
     * @param Client $bugsnag
     *   A Bugsnag client.
     * @param MessageInterpolatorInterface $interpolator
     *   A log message interpolator.
     * @param SeverityMapperInterface $mapper
     *   A severity level mapper.
     */
    public function __construct(
        Client $bugsnag,
        MessageInterpolatorInterface $interpolator,
        SeverityMapperInterface $mapper
    ) {
        $this->bugsnag = $bugsnag;
        $this->interpolator = $interpolator;
        $this->mapper = $mapper;

        $this->bugsnag->registerCallback(new RemoveLoggerFromStacktrace());
    }

    /**
     * {@inheritDoc}
     */
    public function log($level, $message, array $context = [])
    {
        $severity = $this->mapper->getSeverityForLogLevel($level);

        // The severity mapper can return null for a log level, indicating the
        // log level should not be sent to Bugsnag.
        if (is_null($severity)) {
            return;
        }

        // Interpolate the error message.
        $message = $this->interpolator->interpolate($message, $context);

        // Log exceptions as such.

        if (isset($context['exception']) && ($context['exception'] instanceof Exception || $context['exception'] instanceof Throwable)) {
            $exception = $context['exception'];
            unset($context['exception']);

            $this->bugsnag->notifyException($exception, function (Report $report) use ($context, $severity) {
                $report->setMetaData($context);
                $report->setSeverity($severity);
            });

            return;
        }

        // Get error type.
        $type = isset($context['error-type']) ? $context['error-type'] : $severity;

        $this->bugsnag->notifyError($type, $message, function (Report $report) use ($context, $severity) {
            $report->setMetaData($context);
            $report->setSeverity($severity);
        });
    }
}
