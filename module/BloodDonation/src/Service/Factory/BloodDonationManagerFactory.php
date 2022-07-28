<?php
namespace BloodDonation\Service\Factory;

use Interop\Container\ContainerInterface;
use BloodDonation\Service\BloodDonationManager;

/**
 * This is the factory class for BloodDonationManager service. The purpose of the factory
 * is to instantiate the service and pass it dependencies (inject dependencies).
 */
class BloodDonationManagerFactory
{
    /**
     * This method creates the BloodDonationManager service and returns its instance.
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        $viewRenderer = $container->get('ViewRenderer');
        $config = $container->get('Config');

        return new BloodDonationManager($entityManager, $viewRenderer, $config);
    }
}
