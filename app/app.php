<?php
/**
 * Local variables
 * @var \Phalcon\Mvc\Micro $app
 */

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
    $app->response->setJsonContent("We're here!");
    $app->response->send();
});
