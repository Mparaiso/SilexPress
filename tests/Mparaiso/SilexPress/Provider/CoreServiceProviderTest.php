<?php

use Mparaiso\SilexPress\Core\Service\Base;
use Silex\WebTestCase;
use Symfony\Component\HttpKernel\HttpKernel;

class CoreServiceProviderTest extends WebTestCase
{
    function __construct()
    {

    }

    /**
     * Creates the application.
     *
     * @return HttpKernel
     */
    public function createApplication()
    {
        return Bootstrap::getApp();
    }

    public function testMongoDBConnection()
    {
        $this->assertTrue($this->app["sp.core.db.connection"] instanceof \MongoDB);
        $this->assertTrue($this->app["sp.core.service.post"] instanceof Base);
    }
}
