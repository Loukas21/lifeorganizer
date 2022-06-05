<?php
namespace Publication\Service\Factory;

use Interop\Container\ContainerInterface;
use Publication\Service\PublicationManager;

/**
 * This is the factory class for PublicationManager service. The purpose of the factory
 * is to instantiate the service and pass it dependencies (inject dependencies).
 */
class PublicationManagerFactory
{
    /**
     * This method creates the PublicationManager service and returns its instance.
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        $viewRenderer = $container->get('ViewRenderer');
        $config = $container->get('Config');

        return new PublicationManager($entityManager, $viewRenderer, $config);
    }
}
