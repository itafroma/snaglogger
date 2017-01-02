<?php

namespace Itafroma\Snaglogger;

/**
 * Defines a interpolator, or token replacer, for log messages.
 */
interface MessageInterpolatorInterface
{
    /**
     * Constructs a log message using a context array for interpolation.
     *
     * PSR-3 requires implementing libraries to treat the context array as
     * leniently as possible. To facilitate this, if the context array passed
     * contains keys that are not supported by your interpolator, they should
     * be silently ignored.
     *
     * @param string $message
     *   The original message to use as a base for interpolation.
     * @param mixed[] $context
     *   Contextual data that can be used for interpolation.
     *
     * @return string
     *   The fully-constructed log message.
     */
    public function interpolate($message, array $context = []);
}
