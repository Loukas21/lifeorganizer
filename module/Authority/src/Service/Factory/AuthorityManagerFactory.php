<?php
namespace Authority\Service\Factory;

use Interop\Container\ContainerInterface;
use Authority\Service\AuthorityManager;

/**
 * This is the factory class for AuthorityManager service. The purpose of the factory
 * is to instantiate the service and pass it dependencies (inject dependencies).
 */
class AuthorityManagerFactory
{
    /**
     * This method creates theAuthorityManager service and returns its instance.
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        $viewRenderer = $container->get('ViewRenderer');
        $config = $container->get('Config');

        return new AuthorityManager($entityManager, $viewRenderer, $config);
    }
}
