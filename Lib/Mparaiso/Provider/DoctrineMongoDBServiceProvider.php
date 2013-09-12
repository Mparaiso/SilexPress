<?php
/**
 * 
 * @author mark prades
 *
 */
namespace Mparaiso\Provider;

use Silex\ServiceProviderInterface;
use Silex\Application;
use Doctrine\MongoDB\Database;
use Doctrine\MongoDB\LoggableDatabase;
use Doctrine\MongoDB\Connection;
use MongoClient;

class DoctrineMongoDBServiceProvider implements ServiceProviderInterface
{

    function register(Application $app)
    {
        $app["mp.mongo.server"] = "localhost";
        $app["mp.mongo.db"] = null;
        $app["mp.mongo.event_manager"] = $app->share(function ()
        {
            return new \Doctrine\Common\EventManager();
        });
        $app['mp.mongo.config'] = $app->share(function ()
        {
            return new \Doctrine\MongoDB\Configuration();
        });
        $app["mp.mongo.connection"] = $app->share(function ($app)
        {
            return new Connection(new MongoClient($app["mp.mongo.server"]), array(), $app['mp.mongo.config'], $app["mp.mongo.event_manager"]);
        });
        
        if ($app["debug"] == true && isset($app["logger"])) {
            $app["mp.mongo"] = $app["mp.mongo.database"] = $app->share(function ($app)
            {
                return new LoggableDatabase($app["mp.mongo.connection"], $app["mp.mongo.db"], $app["mp.mongo.event_manager"], "$", 1, $app["mp.mongo.logger"]);
            });
            $app["mp.mongo.logger"] = $app->share(function ($app)
            {
                
                return function ($message) use($app)
                {
                    $app["logger"]->debug(var_export($message, true));
                };
            });
        } else {
            $app["mp.mongo"] = $app["mp.mongo.database"] = $app->share(function ($app)
            {
                return new Database($app["mp.mongo.connection"], $app["mp.mongo.db"], $app["mp.mongo.event_manager"], "$", 1, $app["mp.mongo.logger"]);
            });
        }
    }

    function boot(Application $app)
    {}
}