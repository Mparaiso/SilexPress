<?php

namespace Mparaiso\SilexPress\Provider;


use Mparaiso\SilexPress\Core\Service\Base;
use Silex\Application;
use Silex\ServiceProviderInterface;

class CoreServiceProvider implements ServiceProviderInterface
{
    /**
     * Registers services on the given app.
     *
     * This method should only be used to configure services and parameters.
     * It should not get services.
     *
     * @param Application $app An Application instance
     */
    public function register(Application $app)
    {
        // \MongoDB
        $app["sp.core.db.connection"] = $app->share(function ($app) {
            $mongo = new \MongoClient($app['config.server']);
            return $mongo->selectDB($app['config.database']);
        });
        $app["sp.core.vars.collection.post"] = "posts"; // name of the posts collection
        $app["sp.core.vars.model.post"] = 'Mparaiso\SilexPress\Core\Model\Post'; // post model class

        $app["sp.core.service.post"] = $app->share(function ($app) {
            return new Base($app["sp.core.db.connection"], $app["sp.core.vars.collection.post"], $app["sp.core.vars.model.post"]);
        });
    }

    /**
     * Bootstraps the application.
     *
     * This method is called after all services are registered
     * and should be used for "dynamic" configuration (whenever
     * a service must be requested).
     */
    public function boot(Application $app)
    {
        // TODO: Implement boot() method.
    }
}
