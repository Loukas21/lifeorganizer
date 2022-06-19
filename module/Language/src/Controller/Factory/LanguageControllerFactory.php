<?php
namespace Language\Controller\Factory;

use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Language\Controller\LanguageController;
use Language\Service\LanguageManager;

/**
 * This is the factory for LanguageController. Its purpose is to instantiate the
 * controller and inject dependencies into it.
 */
class LanguageControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        $languageManager = $container->get(LanguageManager::class);

        // Instantiate the controller and inject dependencies
        return new LanguageController($entityManager, $languageManager);
    }
}
