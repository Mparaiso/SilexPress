<?php

// DIRECTIVE FOR PHP built-in server

use Symfony\Component\HttpFoundation\Request;

$filename = __DIR__ . preg_replace('#(\?.*)$#', '', $_SERVER['REQUEST_URI']);
if (php_sapi_name() === 'cli-server' && is_file($filename)) {
    return false;
}

// bootstrapping
$autoload = require(__DIR__ . "/../vendor/autoload.php");

// FR : configure les dossiers pour l'autoload PHP , les classes des dossiers App et dossier Lib sont directement dispo
// EN : set PHP autoload for directory App and directory Lib
$autoload->add("", __DIR__ . "/../App");
$autoload->add("", __DIR__ . "/../Lib");

$debug = getenv("SILEXPRESS_ENV") == "development" ? true : false;

$app = new SilexPress(array("debug" => $debug));
$app->before(function (Request $request) use ($app) {
    if ($app["debug"] == true) {
        $request->getSession()->getFlashBag()->add("warning", "You are in development mode! , change SILEXPRESS_ENV server variable to 'production' for production settings.");
    }
});
$app['http_cache']->run();
