<?php
namespace Language\Service\Factory;

use Interop\Container\ContainerInterface;
use Language\Service\LanguageManager;

/**
 * This is the factory class for LanguageManager service. The purpose of the factory
 * is to instantiate the service and pass it dependencies (inject dependencies).
 */
class LanguageManagerFactory
{
    /**
     * This method creates the LanguageManager service and returns its instance.
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        $viewRenderer = $container->get('ViewRenderer');
        $config = $container->get('Config');

        return new LanguageManager($entityManager, $viewRenderer, $config);
    }
}
