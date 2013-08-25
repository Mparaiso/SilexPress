<?php

use App\Config;

$loader = require __DIR__ . '/../vendor/autoload.php';
$loader->add('App', __DIR__ . "/../");
$loader->add('', __DIR__ . "/../Lib");

class Bootstrap
{
    static function getApp()
    {
        $app = new \Silex\Application;
        $app["debug"] = true;
        $app["session.test"] = 1;
        $app->register(new Config, array(
            "sp.core.collection.post" => "test_posts",
        ));
        return $app;
    }
}

