<?php
namespace Quote\Controller\Plugin\Factory;

use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Quote\Service\QuoteManager;
use Quote\Controller\Plugin\RandomQuotePlugin;

/**
 * This is the factory for AccessPlugin. Its purpose is to instantiate the plugin
 * and inject dependencies into its constructor.
 */
class RandomQuotePluginFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $quoteManager = $container->get(QuoteManager::class);

        return new RandomQuotePlugin($quoteManager);
    }
}
