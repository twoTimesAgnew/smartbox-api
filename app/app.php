<?php
/**
 * Local variables
 * @var \Phalcon\Mvc\Micro $app
 */

use Models\Product;

/**
 * Add your routes here
 */
$app->map('/', function () use ($app) {
    $app->response->setStatusCode(200);
    $app->response->setJsonContent("Almost there, try /products", JSON_UNESCAPED_SLASHES);
    $app->response->send();
});

$app->get("/users/:id", function() use ($app) {

});

$app->get("/products", function () use ($app) {
    $app->response->setStatusCode(200);
    $app->response->setJsonContent(Product::getAll());

    $app->response->send();
});

$app->post("/products", function () use ($app) {

    $data = $app->request->getJsonRawBody();
    if(Product::insert($data))
    {
        $app->response->setStatusCode(200);
        $app->response->setJsonContent(["status" => "success", "message" => "successfully added new product for user " . $data->userId]);
        $app->apiLogger->info("Successfully inserted new product for user " . $data->userId);
    } else {
        $app->response->setStatusCode(500);
        $app->response->setJsonContent(["status" => "error", "message" => "error while inserting"]);
    }

    $app->response->send();

})->beforeMatch(
    function() use ($app)
    {
        $data = $app->request->getJsonRawBody();

        if(!isset($data->userId) || !isset($data->spotId) || !isset($data->location))
        {
            $app->response->setStatusCode(400, "Bad Request");
            $app->response->setJsonContent(["status" => "error", "message" => "Invalid request, parameter(s) missing."]);

            return false;
        }

        return true;
    }
);



