<?php

namespace Itafroma\Snaglogger;

use Bugsnag\Client;
use Bugsnag\Configuration;

/**
 * Creates Snaglogger loggers with sensible defaults.
 *
 * If you wish to customize the functionality of a Snaglogger logger, either
 * create your own implementation of LoggerFactoryInterface or use the Logger
 * constructor directly.
 */
class LoggerFactory implements LoggerFactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function create($key)
    {
        $client = Client::make($key);
        $interpolator = new MessageInterpolator();
        $mapper = new SeverityMapper();

        return new Logger($client, $interpolator, $mapper);
    }
}
