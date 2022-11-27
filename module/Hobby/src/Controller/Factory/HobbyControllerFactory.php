<?php
namespace Hobby\Controller\Factory;

use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Hobby\Controller\HobbyController;
use Hobby\Service\HobbyManager;

/**
 * This is the factory for AuthorityController. Its purpose is to instantiate the
 * controller and inject dependencies into it.
 */
class HobbyControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        $hobbyManager = $container->get(HobbyManager::class);

        // Instantiate the controller and inject dependencies
        return new HobbyController($entityManager, $hobbyManager);
    }
}
