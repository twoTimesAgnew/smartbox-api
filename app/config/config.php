<?php
/*
 * Modified: prepend directory path of current file, because of this file own different ENV under between Apache and command line.
 * NOTE: please remove this comment.
 */
defined('BASE_PATH') || define('BASE_PATH', getenv('BASE_PATH') ?: realpath(dirname(__FILE__) . '/../..'));
defined('APP_PATH') || define('APP_PATH', BASE_PATH . '/app');

return new \Phalcon\Config([
    'application' => [
        'modelsDir'      => APP_PATH . '/models/',
        'migrationsDir'  => APP_PATH . '/migrations/',
        'viewsDir'       => APP_PATH . '/views/',
        'baseUri'        => '/smartbox-api/',
    ],

    'mongodb' => [
        'host' => "smartbox_mongo_1",
        'port' => 27017,
        'db' => 'smartbox',
    ],

    "redis" => [
        "host" => "smartbox_redis_1",
        "port" => 6379,
        "db" => 1
    ],

    "logs" => [
        "api" => APP_PATH . "/logs/api.txt",
        "error" => APP_PATH . "/logs/error.txt",
        "info" => APP_PATH . "/logs/info.txt"
    ]
]);
