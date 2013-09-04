<?php

/**
 *
 * silexpress command line application
 * usage :
 * php console.php
 *
 */

$autoload = require(__DIR__ . "/vendor/autoload.php");

$autoload->add("", __DIR__ . "/App");
$autoload->add("", __DIR__ . "/Lib");

$app = new SilexPress(array("debug" => true));
$app["session.test"] = 1;
$app->boot();
$app["console"]->run();