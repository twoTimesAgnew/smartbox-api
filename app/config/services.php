<?php

use Phalcon\Mvc\View\Simple as View;
use Phalcon\Mvc\Url as UrlResolver;
use Phalcon\Db\Adapter\MongoDB\Client as MongoDBClient;
use Phalcon\Mvc\Collection\Manager;
use Predis\Client as Predis;
use Phalcon\Logger\Adapter\File as Logger;

$config = include APP_PATH . "/config/config.php";

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

$di->setShared('redis', function () use ($config) {

    $redis = new Predis(["host" => $config->redis->host,
                         "port" => $config->redis->port,
                         "database" => $config->redis->db]);

    return $redis;
});

/** * Sets shared loggers */
$di->setShared('apiLogger', function () use ($config) {

    $logger = new Logger($config->logs->api);
    return $logger;
});

$di->setShared('infoLogger', function () use ($config) {

    $logger = new Logger($config->logs->info);
    return $logger;
});

$di->setShared('errorLogger', function () use ($config) {

    $logger = new Logger($config->logs->error);
    return $logger;
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

