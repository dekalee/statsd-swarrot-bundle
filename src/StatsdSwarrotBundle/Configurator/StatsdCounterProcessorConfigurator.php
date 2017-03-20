<?php

namespace Dekalee\StatsdSwarrotBundle\Configurator;

use Dekalee\StatsdSwarrotBundle\Processor\StatsdCounterProcessor;
use Swarrot\SwarrotBundle\Processor\ProcessorConfiguratorEnableAware;
use Swarrot\SwarrotBundle\Processor\ProcessorConfiguratorExtrasAware;
use Swarrot\SwarrotBundle\Processor\ProcessorConfiguratorInterface;
use Symfony\Component\Console\Input\InputInterface;

/**
 * Class StatsdCounterProcessorConfigurator
 */
class StatsdCounterProcessorConfigurator implements ProcessorConfiguratorInterface
{
    use ProcessorConfiguratorEnableAware, ProcessorConfiguratorExtrasAware;

    /**
     * {@inheritdoc}
     */
    public function getProcessorArguments(array $options)
    {
        return [
            StatsdCounterProcessor::CLASS,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getCommandOptions()
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function resolveOptions(InputInterface $input)
    {
        return $this->getExtras();
    }
}
