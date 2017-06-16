<?php

namespace Itafroma\Snaglogger\Callbacks;

use Bugsnag\Report;
use Psr\Log\LoggerInterface;

/**
 * Configuration callback to ignore a PSR-3 logger at the top of the stacktrace sent to Bugsnag.
 *
 * This is used to remove the PSR-3 logger wrapper that invokes Bugsnag's
 * notification calls from the stacktrace, creating a stacktrace that will look
 * the same as if the Bugsnag client was called directly.
 */
class RemoveLoggerFromStacktrace
{
    /**
     * Execute the callback.
     *
     * @param \Bugsnag\Report $report the bugsnag report instance
     *
     * @return void
     */
    public function __invoke(Report $report)
    {
        $stacktrace = $report->getStacktrace();

        foreach ($stacktrace->toArray() as $scope) {

            // Ignore procedural code.
            if (strpos($scope['method'], '::') === false) {
                break;
            }

            list ($class, $method) = explode('::', $scope['method']);
            $interfaces = class_implements($class);

            // Ignore if the stacktrace does not start with a call to a PSR-3 logger.
            if (!in_array(LoggerInterface::class, $interfaces)) {
                break;
            }

            // LoggerInterface::log was called, remove it from the trace and
            // check the next entry to see if it was called via one of PSR-3's
            // convenience methods
            if ($method === 'log') {
                $stacktrace->removeFrame(0);
            }
            // One of PSR-3's convenience methods was called: remove it from the
            // trace and stop.
            elseif (in_array($method, get_class_methods(LoggerInterface::class))) {
                $stacktrace->removeFrame(0);
                break;
            }
        }
    }
}
