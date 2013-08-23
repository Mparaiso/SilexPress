<?php

use App\Config;

// DIRECTIVE FOR PHP built-in server 

$filename = __DIR__.preg_replace('#(\?.*)$#', '', $_SERVER['REQUEST_URI']);
if (php_sapi_name() === 'cli-server' && is_file($filename)) {
return false;
}

// bootstrapping
$autoload = require(__DIR__."/../vendor/autoload.php");

$autoload->add("App",__DIR__."/../");
$autoload->add("",__DIR__."/../Lib");
$debug = getenv("DEBUG")?getenv("DEBUG"):"false";

$app = new \Silex\Application(array("debug"=>$debug));
$app->register(new Config);

$app['http_cache']->run();
