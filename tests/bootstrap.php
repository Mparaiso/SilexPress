<?php


use Doctrine\MongoDB\Connection;
use Doctrine\MongoDB\LoggableDatabase;

$loader = require(__DIR__ . '/../vendor/autoload.php');
$loader->add('', __DIR__ . '/../App');
$loader->add('', __DIR__ . '/../Lib');

class Bootstrap
{
    static function getApp()
    {
        $app = new SilexPress(array("debug" => true, "session.test" => 1));
        $app["sp.core.collection.post"] = "test_posts";
        return $app;
    }

    /**
     * doctrine/mongodb integration
     * @return Pimple
     */
    static function getContainer()
    {
        $c = new \Pimple();
        $c["mongo.server"] = getenv('SILEXPRESS_DBSERVER');
        $c["mongo.db"] = getenv('SILEXPRESS_DBNAME');
        $c["event_manager"] = $c->share(function () {
            return new \Doctrine\Common\EventManager();
        });
        $c['mongo.config'] = $c->share(function () {
            return new \Doctrine\MongoDB\Configuration();
        });
        $c["mongo.connection"] = $c->share(function ($c) {
            return new Connection(new MongoClient($c["mongo.server"]), array(), $c['mongo.config'], $c["event_manager"]);
        });
        $c["mongo.database"] = $c->share(function ($c) {
            return new LoggableDatabase($c["mongo.connection"], $c["mongo.db"], $c["event_manager"], "$", 1, $c["mongo.logger"]);
        });
        $c["mongo.logger"] = $c->share(function () {
            $app = self::getApp();
            return function ($message) use ($app) {
                $app["logger"]->debug(var_export($message,true));
            };
        });
        return $c;
    }
}

