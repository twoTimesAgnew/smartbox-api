<?php

namespace Middleware;

use Phalcon\Mvc\Micro;
use Phalcon\Mvc\Micro\MiddlewareInterface;
use Phalcon\Events\Event;
use Lib\Redis;

/**
* NotFoundMiddleware
*
* Processes the 404s
*/
class NotFoundMiddleware implements MiddlewareInterface
{
    /**
    * The route has not been found
    *
    * @returns bool
    */
    public function beforeNotFound(Event $event, Micro $app)
    {
        if(is_null($app->response->getStatusCode())) {
            $app->response->setStatusCode(404);
        } else {
            $app->response->setStatusCode($app->response->getStatusCode());
        }

        if(is_null($app->response->getContent())) {
            $app->response->setJsonContent(["status" => "error", "message" => "Invalid Route"]);
        } else {
            $app->response->setJsonContent(["status" => "error", "message" => $app->response->getContent()]);
        }

        $app->response->send();

        return false;
    }

    /**
    * Calls the middleware
    *
    * @param Micro $application
    *
    * @returns bool
    */
    public function call(Micro $app)
    {
        return true;
    }
}