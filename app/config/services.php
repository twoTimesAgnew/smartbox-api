<?php

use Phalcon\Mvc\View\Simple as View;
use Phalcon\Mvc\Url as UrlResolver;
use Phalcon\Db\Adapter\MongoDB\Client as MongoDBClient;
use Phalcon\Mvc\Collection\Manager;

# Mongodb service
$di->setShared('mongo', function() {
    $config = $this->getConfig();

    $mongo = new MongoDBClient(
        "mongodb://" . $config->mongodb->host . ":" . $config->mongodb->port
    );
    return $mongo->selectDatabase($config->mongodb->db);
});
# Need this to make our Models use Mongo service
$di->setShared('collectionManager', function () {
    return new Manager();
});

/**
 * Shared configuration service
 */
$di->setShared('config', function () {
    return include APP_PATH . "/config/config.php";
});

/**
 * Sets the view component
 */
$di->setShared('view', function () {
    $config = $this->getConfig();

    $view = new View();
    $view->setViewsDir($config->application->viewsDir);
    return $view;
});

/**
 * The URL component is used to generate all kind of urls in the application
 */
$di->setShared('url', function () {
    $config = $this->getConfig();

    $url = new UrlResolver();
    $url->setBaseUri($config->application->baseUri);
    return $url;
});

