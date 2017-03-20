<?php

namespace Dekalee\StatsdSwarrotBundle\Processor;

use Swarrot\Broker\Message;
use Swarrot\Processor\ConfigurableInterface;
use Swarrot\Processor\ProcessorInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class StatsdCounterProcessor
 */
class StatsdCounterProcessor implements ConfigurableInterface
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
        $result = $this->processor->process($message, $options);

        $connection = new \Domnikl\Statsd\Connection\UdpSocket($options['statsd_host'], $options['statsd_port']);
        $statsd = new \Domnikl\Statsd\Client($connection, $options['statsd_namespace']);
        $statsd->increment($options['statsd_counter']);

        return $result;
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired('statsd_namespace');
        $resolver->setRequired('statsd_counter');
        $resolver->setDefaults([
            'statsd_host' => '172.17.0.1',
            'statsd_port' => 8125,
        ]);
    }
}
