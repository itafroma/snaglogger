<?php

namespace Itafroma\Snaglogger\Test;

use Itafroma\Snaglogger\MessageInterpolator;
use PHPUnit\Framework\TestCase;

/**
 * Tests the default message interpolator.
 */
class MessageInterpolatorTest extends TestCase
{
    /**
     * Ensures the interpolator performs replacements as expected.
     */
    public function testInterpolate()
    {
        $interpolator = new MessageInterpolator();
        $message = 'The {quick} brown fox jumped {over} the lazy brown {dog}.';
        $context = [
            'quick' => 'slow',
            '{over}' => 'below',
        ];

        $expected = 'The slow brown fox jumped {over} the lazy brown {dog}.';
        $actual = $interpolator->interpolate($message, $context);

        $this->assertEquals($expected, $actual);
    }
}
