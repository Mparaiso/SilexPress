<?php

// DIRECTIVE FOR PHP built-in server

use App\Config;

$filename = __DIR__ . preg_replace('#(\?.*)$#', '', $_SERVER['REQUEST_URI']);
if (php_sapi_name() === 'cli-server' && is_file($filename)) {
    return false;
}

// bootstrapping
$autoload = require(__DIR__ . "/../vendor/autoload.php");

// FR : configure les dossiers pour l'autoload PHP , les classes des dossiers App et dossier Lib sont directement dispo
// EN : set PHP autoload for directory App and directory Lib
$autoload->add("App", __DIR__ . "/../");
$autoload->add("", __DIR__ . "/../Lib");

$debug = getenv("SILEXPRESS_ENV") == "development" ? true : false;

$app = new \Silex\Application;
$app["debug"] = true;
$app->register(new Config);

$app['http_cache']->run();
