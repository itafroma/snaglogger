<?php

namespace Itafroma\Snaglogger;

/**
 * Defines a factory for creating Snaglogger loggers.
 *
 * This is an optional convenience interface to allow downstream libraries the
 * ability to depend on an abstraction for creating loggers. If you need to
 * customize the logger each time you instantiate it, use its constructor
 * instead.
 */
interface LoggerFactoryInterface
{
    /**
     * Creates a Snaglogger logger.
     *
     * @param string $key
     *   A Bugsnag API key.
     *
     * @return Logger
     *   A fully-built Snaglogger logger.
     */
    public function create($key);
}
