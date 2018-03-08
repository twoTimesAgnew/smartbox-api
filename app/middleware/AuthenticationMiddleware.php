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
class AuthenticationMiddleware implements MiddlewareInterface
{
    /**
     * Before entering any route, make sure user has access
     *
     * @returns bool
     */
    public function beforeHandleRoute(Event $event, Micro $app)
    {
        # Instantiating Redis instance
        $client = new Redis();

        # Checking if auth.IP is already in redis, if so, authorize
        if($client->exists("auth." . $app->request->getClientAddress()))
        {
            $app->infoLogger->info("IP " . $app->request->getClientAddress() . " already authorized.");
            return true;
        }

        # If auth.IP not in redis, check headers
        if($app->request->getHeader("Authorization") && $app->request->getHeader("Authorization") == "smartbox-api-key")
        {
            # If headers are good, add auth.IP to redis
            $client->set("auth." . $app->request->getClientAddress(), 1, "ex", 600);
            $app->infoLogger->info("Adding nonce for user " . $app->request->getClientAddress() . " to Redis.");
            return true;
        }

        # Any other case will be rejected and logged
        $app->infoLogger->info("Unauthorized access to API from IP " . $app->request->getClientAddress());
        $app->response->setStatusCode(401);
        $app->response->setJsonContent(["status" => "error", "message" => "Unauthorized access to API"]);
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