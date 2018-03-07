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
        "Controllers" => APP_PATH . "/controllers"
    ]
);

$loader->register();
