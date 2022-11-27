<?php
namespace Hobby\Service\Factory;

use Interop\Container\ContainerInterface;
use Hobby\Service\HobbyManager;

/**
 * This is the factory class for HobbyManager service. The purpose of the factory
 * is to instantiate the service and pass it dependencies (inject dependencies).
 */
class HobbyManagerFactory
{
    /**
     * This method creates the HobbyManager service and returns its instance.
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        $viewRenderer = $container->get('ViewRenderer');
        $config = $container->get('Config');

        return new HobbyManager($entityManager, $viewRenderer, $config);
    }
}
