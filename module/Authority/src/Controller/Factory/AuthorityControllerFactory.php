<?php
namespace Authority\Controller\Factory;

use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Authority\Controller\AuthorityController;
use Authority\Service\AuthorityManager;

/**
 * This is the factory for AuthorityController. Its purpose is to instantiate the
 * controller and inject dependencies into it.
 */
class AuthorityControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        $authorityManager = $container->get(AuthorityManager::class);

        // Instantiate the controller and inject dependencies
        return new AuthorityController($entityManager, $authorityManager);
    }
}
