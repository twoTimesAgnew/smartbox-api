<?php

include_once BASE_PATH . '/vendor/autoload.php';

/**
 * Registering an autoloader
 */
$loader = new \Phalcon\Loader();

$loader->registerDirs(
    [
        $config->application->modelsDir
    ]
);

$loader->registerNamespaces(
    [
        "Phalcon" => BASE_PATH . "/vendor/phalcon/incubator/Library/Phalcon/",
        "Controllers" => APP_PATH . "/controllers",
        "Middleware" => APP_PATH . "/middleware",
        "Lib" => APP_PATH . "/lib"
    ]
);

$loader->register();
