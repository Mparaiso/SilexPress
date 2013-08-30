<?php


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
}

