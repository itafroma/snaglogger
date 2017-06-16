# Snaglogger

Snaglogger is a PSR-3-compatible logger that sends log messages to [Bugsnag](https://bugsnag.com).

## Installation

Snaglogger can be added to your project via [Composer](https://getcomposer.org):

```json
{
    "require": {
        "itafroma/snaglogger": "^2.0"
    }
}
```

Snaglogger uses [semantic versioning](http://semver.org). In general, you can pin to `^[MAJOR].0` and be confident you will not receive breaking changes during updates.

## Usage

### Quickstart

Snaglogger comes with a factory that instantiates the logger with sensible defaults:

```php
use Itafroma\Snaglogger\LoggerFactory;

$key    = 'YOUR BUGSNAG API KEY HERE';
$logger = LoggerFactory::create($key);
```

Once instantiated, the logger will work as any other PSR-3-compatiable logger:

```php
$logger->info('This is an informational message.');
$logger->error('This is an error.');
```

### The PSR-3 context array

Snaglogger will send the contents of the `$context` array to Bugsnag as [metadata](https://docs.bugsnag.com/platforms/php/other/#custom-diagnostics).

Additionally, Snaglogger treats two `$context` keys as special:

- If the `exception` key contains an instance of an exception, Snaglogger will record the log message as an exception instead of an error.
- If the `error-type` key is set, Snaglogger will use that as the error type. Otherwise, it will use the error severity.

Finally, Snaglogger will use the `$context` array for placeholder replacement within the log message:

```php
$message = 'The {location} is on fire!';
$context = ['location' => 'roof'];

// Bugsnag will record the error message as "The roof is on fire!"
$logger->error($message, $context);
```

### Severity levels

Bugsnag only supports three severity levels: info, warning, and error. However, PSR-3 requires loggers to support eight: emergency, alert, critical, error, warning, notice, info, and debug. By default, Snaglogger maps these additional log levels to the closest Bugsnag severity level:

- emergency → error
- alert → error
- critical → error
- error → error
- warning → warning
- notice → info
- info → info
- debug → info

### Advanced usage

Some functionality can be customized by implementing certain interfaces:

- Custom severity mapping: [`\Itafroma\Snaglogger\SeverityMapperInterface`](./src/SeverityMapperInterface.php)
- Custom message interpolation: [`\Itafroma\Snaglogger\MessageInterpolatorInterface`](./src/MessageInterpolatorInterface.php)

More information can be found in those interfaces' inline documentation.

You may also want to [customize the Bugsnag client](https://docs.bugsnag.com/platforms/php/other/configuration-options/).

To override Snaglogger's default functionality, you will need to:

1. Implement your own concrete class of [`\Itafroma\Snaglogger\LoggerFactoryInterface`](./src/LoggerFactoryInterface.php), and/or
2. Call the `Logger` constructor directly.

For example:

```php
$client = Client::make('API KEY')->setReleaseStage('prod');
$interpolator = new CustomMessageInterpolator();
$mapper = new CustomSeverityMapper();

$logger = new Logger($client, $interpolator, $mapper);
```

## Contributing

Contributions are welcome! Please see the separate [CONTRIBUTING](./CONTRIBUTING.md) file for more information.

## Copyright and license

This extension is copyright [Mark Trapp](https://marktrapp.com). All Rights Reserved. It is made available under the terms of the MIT license. A copy of the license can be found in the [LICENSE](./LICENSE) file.

## Disclaimer

This project has no affliation with Bugsnag in any way. Additional disclaimers can be found in the [LICENSE](./LICENSE) file.
