<?php

use Phalcon\Mvc\View\Simple as View;
use Phalcon\Mvc\Url as UrlResolver;
use Phalcon\Db\Adapter\MongoDB\Client as MongoDBClient;
use Phalcon\Mvc\Collection\Manager;
use Predis\Client as Redis;
use Phalcon\Logger\Adapter\File as Logger;

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

$di->setShared('redis', function () {
    $config = $this->getConfig();

    $redis = new Redis(["host" => $config->redis->redis_host,
                        "port" => $config->redis->redis_port,
                        "database" => $config->redis->redis_db,
                        "timeout" => $config->redis->redis_timeout]);
    return $redis;
});

/** * Sets shared loggers */
$di->setShared('apiLogger', function () {
    $config = $this->getConfig();

    $logger = new Logger($config->logs->api);
    return $logger;
});

$di->setShared('authLogger', function () {
    $config = $this->getConfig();

    $logger = new Logger($config->logs->auth);
    return $logger;
});

$di->setShared('errorLogger', function () {
    $config = $this->getConfig();

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

