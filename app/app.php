<?php
/**
 * Local variables
 * @var \Phalcon\Mvc\Micro $app
 */

use Lib\Redis;

/**
 * Add your routes here
 */
$app->map('/', function () use ($app) {
    $app->response->setStatusCode(200);
    $app->response->setJsonContent("Almost there, try /products", JSON_UNESCAPED_SLASHES);
    $app->response->send();
});

$app->post("/products", function () use ($app) {
    $app->response->setStatusCode(200);
    $app->response->setJsonContent($app->request->getClientAddress());
    $app->apiLogger->info("Accessed /products");
    $app->response->send();
});
