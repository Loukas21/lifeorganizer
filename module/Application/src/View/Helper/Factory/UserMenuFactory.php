<?php
namespace Application\View\Helper\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Application\View\Helper\Usermenu;
use Application\Service\NavManager;

/**
 * This is the factory for Menu view helper. Its purpose is to instantiate the
 * helper and init menu items.
 */
class UserMenuFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $navManager = $container->get(NavManager::class);

        // Get menu items.
        $items = $navManager->getMenuItems();

        // Instantiate the helper.
        return new UserMenu($items);
    }
}
