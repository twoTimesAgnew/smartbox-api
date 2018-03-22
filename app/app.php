<?php
/**
 * Local variables
 * @var \Phalcon\Mvc\Micro $app
 */

use Models\Products;

/**
 * Add your routes here
 */
$app->map('/', function () use ($app) {
    $app->response->setStatusCode(200);
    $app->response->setJsonContent("Almost there, try /products", JSON_UNESCAPED_SLASHES);
    $app->response->send();
});

$app->get("/products", function () use ($app) {
    $app->response->setStatusCode(200);
    $app->response->setJsonContent(Products::findAll());

    $app->response->send();
});

$app->post("/products", function () use ($app) {

    $data = $app->request->getJsonRawBody();
    if(Products::insert($data))
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

$app->put("/products/{uuid}", function ($uuid) use ($app) {

    $req = $app->request->getJsonRawBody();
    $update = Products::updateDoc($uuid, $req);

    if($update)
    {
        $app->response->setStatusCode(200);
        $message = ["status" => "success", "message" => "Successfully updated document"];
    }
    else
    {
        $app->response->setStatusCode(400);
        $message = ["status" => "error", "message" => "Error updating document"];
    }

    $app->response->setJsonContent($message);

    $app->response->send();
});

$app->get("/products/user/{id}", function ($id) use ($app) {
    $products = Products::findByUserId($id);

    if(empty($products))
    {
        $products = ["status" => "error", "message" => "No products found for this user"];
    }

    $app->response->setStatusCode(200);
    $app->response->setJsonContent($products);

    $app->response->send();
});



