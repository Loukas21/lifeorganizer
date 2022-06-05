<?php
namespace Publication\Controller\Factory;

use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Publication\Controller\BookController;
use Publication\Service\PublicationManager;

/**
 * This is the factory for BookController. Its purpose is to instantiate the
 * controller and inject dependencies into it.
 */
class BookControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        $publicationManager = $container->get(PublicationManager::class);

        // Instantiate the controller and inject dependencies
        return new BookController($entityManager, $publicationManager);
    }
}
