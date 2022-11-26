<?php
namespace AuthorityTest\Controller;

use Authority\Controller\AuthorityController;
use Laminas\Stdlib\ArrayUtils;
use Laminas\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

class AuthorityeControllerTest extends AbstractHttpControllerTestCase
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
        $this->dispatch('/authorities');
        $this->assertResponseStatusCode(302);
        $this->assertModuleName('authority');
        $this->assertControllerName(AuthorityController::class);
        $this->assertControllerClass('AuthorityController');
        $this->assertMatchedRouteName('authorities');
    }

    public function testInvalidRouteDoesNotCrash()
    {
        $this->dispatch('/invalid/route', 'GET');
        $this->assertResponseStatusCode(404);
    }

}
