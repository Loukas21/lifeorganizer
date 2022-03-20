<?php
namespace Quote\View\Helper\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Quote\Service\QuoteManager;
use Quote\View\Helper\RandomQuote;

/**
 * This is the factory for Access view helper. Its purpose is to instantiate the helper
 * and inject dependencies into its constructor.
 */
class RandomQuoteFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $quoteManager = $container->get(QuoteManager::class);

        return new RandomQuote($quoteManager);
    }
}
