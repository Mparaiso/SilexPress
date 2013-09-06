<?php

namespace Mparaiso\Provider;

use Silex\WebTestCase;
use Symfony\Component\HttpKernel\HttpKernel;
use Symfony\Component\Routing\RouteCollection;

class MediaServiceTest extends WebTestCase
{


    public function createApplication()
    {
        return \Bootstrap::getApp();
    }

    // test register
    function testRegister()
    {
        $this->assertNotNull($this->app['sp.media.service.attachment']);
        $this->assertNotNull($this->app['sp.media.service.upload']);
    }

    // test boot
    function testBoot()
    {
        $this->app->boot();
        $routes = $this->app["routes"];
        /* @var RouteCollection $routes */
        $this->assertNotNull($routes->get("sp.admin.media.index"));
    }
}
