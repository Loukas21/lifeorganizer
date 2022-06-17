<?php
namespace QuoteTest\Controller;

use Quote\Controller\QuoteController;
use Laminas\Stdlib\ArrayUtils;
use Laminas\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

class QuoteControllerTest extends AbstractHttpControllerTestCase
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
        /*
        $this->dispatch('/quote', 'GET');
        $this->assertResponseStatusCode(200);
        $this->assertModuleName('quote');
        $this->assertControllerName(QuoteController::class); // as specified in router's controller name alias
        $this->assertControllerClass('QuoteController');
        $this->assertMatchedRouteName('quote');
        */
        $this->dispatch('/quotes');
        $this->assertResponseStatusCode(302);
        $this->assertModuleName('quote');
        $this->assertControllerName(QuoteController::class);
        $this->assertControllerClass('QuoteController');
        $this->assertMatchedRouteName('quotes');
    }
    /*
    public function testIndexActionViewModelTemplateRenderedWithinLayout()
    {
        $this->dispatch('/', 'GET');
        $this->assertQuery('.container .jumbotron');
    }
    */
    public function testInvalidRouteDoesNotCrash()
    {
        $this->dispatch('/invalid/route', 'GET');
        $this->assertResponseStatusCode(404);
    }

}
