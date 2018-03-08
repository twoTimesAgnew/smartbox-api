<?php

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
        "Middleware" => APP_PATH . "/middleware"
    ]
);

$loader->register();
