<?php
namespace Quote\Controller\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Quote\Controller\QuoteController;
use Quote\Service\QuoteManager;

/**
 * This is the factory for QuoteController. Its purpose is to instantiate the
 * controller and inject dependencies into it.
 */
class QuoteControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        $quoteManager = $container->get(QuoteManager::class);

        // Instantiate the controller and inject dependencies
        return new QuoteController($entityManager, $quoteManager);
    }
}
