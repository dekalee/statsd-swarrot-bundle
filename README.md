Dekalee Redis swarrot
=====================

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/dekalee/statsd-swarrot-bundle/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/dekalee/statsd-swarrot-bundle/?branch=master)
[![Latest Stable Version](https://poser.pugx.org/dekalee/statsd-swarrot-bundle/v/stable)](https://packagist.org/packages/dekalee/statsd-swarrot-bundle)
[![Total Downloads](https://poser.pugx.org/dekalee/statsd-swarrot-bundle/downloads)](https://packagist.org/packages/dekalee/statsd-swarrot-bundle)
[![License](https://poser.pugx.org/dekalee/statsd-swarrot-bundle/license)](https://packagist.org/packages/dekalee/statsd-swarrot-bundle)

This bundle will provide a processor to send some stats to [statsd](https://github.com/etsy/statsd)
during an event processing with the [swarrot](https://github.com/swarrot/swarrot) library.

Installation
------------

Use composer to install this bundle :

```
    composer require dekalee/statsd-swarrot-bundle
```

Activate it in the `AppKernel.php` file:

```php
    new Dekalee\StatsdSwarrotBundle\DekaleeStatsdSwarrotBundle(),
```

Configuration
-------------

In your `config.yml` file, you could add a middleware processor which is going to send some timer and counter metrics
to your statsd instance:

```yaml
    swarrot:
        consumers:
            tag:
                processor: foo.processor
                middleware_stack:
                    -
                        configurator: dekalee_statsd_swarrot.processor.statsd_timer
                        extras:
                            statsd_namespace: timer_foo
                            statsd_host: 127.0.0.1
                            statsd_port: 8215
                    -
                        configurator: dekalee_statsd_swarrot.processor.statsd_counter
                        extras:
                            statsd_namespace: counter_foo
                            statsd_counter: foo_count
                            statsd_host: 127.0.0.1
                            statsd_port: 8215
```
