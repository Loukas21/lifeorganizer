<?php
namespace Quote\Service\Factory;

use Interop\Container\ContainerInterface;
use Quote\Service\QuoteManager;

/**
 * This is the factory class for QuoteManager service. The purpose of the factory
 * is to instantiate the service and pass it dependencies (inject dependencies).
 */
class QuoteManagerFactory
{
    /**
     * This method creates the QuoteManager service and returns its instance.
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        $viewRenderer = $container->get('ViewRenderer');
        $config = $container->get('Config');

        return new QuoteManager($entityManager, $viewRenderer, $config);
    }
}
