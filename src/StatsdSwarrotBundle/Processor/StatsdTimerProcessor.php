<?php

namespace Dekalee\StatsdSwarrotBundle\Processor;

use Swarrot\Broker\Message;
use Swarrot\Processor\ConfigurableInterface;
use Swarrot\Processor\ProcessorInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class StatsdTimerProcessor
 */
class StatsdTimerProcessor implements ConfigurableInterface
{
    private $processor;

    /**
     * @param ProcessorInterface $processor
     */
    public function __construct(ProcessorInterface $processor)
    {
        $this->processor = $processor;
    }

    /**
     * {@inheritdoc}
     */
    public function process(Message $message, array $options)
    {
        $connection = new \Domnikl\Statsd\Connection\UdpSocket($options['statsd_host'], $options['statsd_port']);
        $statsd = new \Domnikl\Statsd\Client($connection, $options['statsd_namespace']);

        $statsd->startTiming('event_processing');

        try {
            $result = $this->processor->process($message, $options);
        } catch (\Exception $e) {
            $statsd->endTiming('event_processing');
            throw $e;
        }
        $statsd->endTiming('event_processing');

        return $result;
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired('statsd_namespace');
        $resolver->setDefaults([
            'statsd_host' => '172.17.0.1',
            'statsd_port' => 8125,
        ]);
    }
}
