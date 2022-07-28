<?php
namespace BloodDonationTest\Controller;

use BloodDonation\Controller\BloodDonationController;
use Laminas\Stdlib\ArrayUtils;
use Laminas\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

class BloodDonationControllerTest extends AbstractHttpControllerTestCase
{
    protected function setUp() : void
    {
        // The module configuration should still be applicable for tests.
        // You can override configuration here with test case specific values,
        // such as sample view templates, path stacks, module_listener_options,
        // etc.
        $configOverrides = [];

        $this->setApplicationConfig(ArrayUtils::merge(
            include __DIR__ . '/../../../../config/application.config.php',
            $configOverrides
        ));

        parent::setUp();
    }

    public function testIndexActionCanBeAccessed()
    {
        $this->dispatch('/blooddonation');
        $this->assertResponseStatusCode(302);
        $this->assertModuleName('blooddonation');
        $this->assertControllerName(BloodDonationController::class);
        $this->assertControllerClass('BloodDonationController');
        $this->assertMatchedRouteName('blooddonation');
    }

    public function testInvalidRouteDoesNotCrash()
    {
        $this->dispatch('/invalid/route', 'GET');
        $this->assertResponseStatusCode(404);
    }

}
