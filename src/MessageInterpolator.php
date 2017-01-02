<?php

namespace Itafroma\Snaglogger;

/**
 * A log message interpolator.
 *
 * This default implementation uses PSR-3's reference interpolation:
 * - If a log message contains a placeholder keyword, denoted by curly braces,
 *   (e.g. "{foo}"),
 * - And the $context array contains a key matching the placeholder,
 * - And the value of the key can be cast to a string,
 * - The placeholder within the log message will be replaced with the
 *   corresponding value within the $cotext array.
 */
class MessageInterpolator implements MessageInterpolatorInterface
{
    /**
     * {@inheritDoc}
     */
    public function interpolate($message, array $context = [])
    {
        $replacements = [];
        foreach ($context as $key => $value) {
            if (is_scalar($value) || is_callable([$value, '__toString'])) {
                $token = sprintf('{%s}', (string) $key);
                $replacements[$token] = (string) $value;
            }
        }

        return strtr($message, $replacements);
    }
}
