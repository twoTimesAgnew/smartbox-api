<?php

use Phalcon\Di\FactoryDefault;
use Phalcon\Mvc\Micro;
use Phalcon\Events\Manager;
use Middleware\NotFoundMiddleware;
use Middleware\AuthenticationMiddleware;

error_reporting(E_ALL);

define('BASE_PATH', dirname(__DIR__));
define('APP_PATH', BASE_PATH . '/app');

try {

    /**
     * The FactoryDefault Dependency Injector automatically registers the services that
     * provide a full stack framework. These default services can be overidden with custom ones.
     */
    $di = new FactoryDefault();

    /**
     * Include Services
     */
    include APP_PATH . '/config/services.php';

    /**
     * Get config service for use in inline setup below
     */
    $config = $di->getConfig();

    /**
     * Include Autoloader
     */
    include APP_PATH . '/config/loader.php';

    /**
     * Starting the application
     * Assign service locator to the application
     */
    $eventsManager = new Manager();
    $app = new Micro($di);

    $eventsManager->attach('micro', new NotFoundMiddleware());
    $app->before(new NotFoundMiddleware());

    $eventsManager->attach('micro', new AuthenticationMiddleware());
    $app->before(new AuthenticationMiddleware());

    $app->setEventsManager($eventsManager);

    /**
     * Include Application
     */
    include APP_PATH . '/app.php';

    /**
     * Handle the request
     */
    $app->handle();

} catch (\Exception $e) {
      echo $e->getMessage() . '<br>';
      echo '<pre>' . $e->getTraceAsString() . '</pre>';
}
