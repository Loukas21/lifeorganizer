<?php
namespace BloodDonation\Controller\Factory;

use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use BloodDonation\Controller\BloodDonationController;
use BloodDonation\Service\BloodDonationManager;

/**
 * This is the factory for BloodDonationController. Its purpose is to instantiate the
 * controller and inject dependencies into it.
 */
class BloodDonationControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        $bloodDonationManager = $container->get(BloodDonationManager::class);

        // Instantiate the controller and inject dependencies
        return new BloodDonationController($entityManager, $bloodDonationManager);
    }
}
