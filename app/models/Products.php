<?php

namespace Models;

use Phalcon\Mvc\MongoCollection as MongoCollection;

class Products extends MongoCollection
{
    public $uuid;
    public $userId;
    public $spotId;
    public $location;
    public $dateIn;
    public $dateOut;
    public $status;

    /**
     * Sets the Model's collection
     *
     * @return string
     */
    public function getSource()
    {
        return 'products';
    }
    /**
     * Returns all users from the Users collection
     *
     * @return array
     */
    public static function findAll()
    {
        return Products::find();
    }

    /**
     * Find all products for a specific user
     *
     * @param $id
     * @return array
     */
    public static function findByUserId($id)
    {
        # Finds Products for userId = id where status != 2 (picked up)
        return Products::find([
            "conditions" => [
                "userId" => (int) $id,
                "status" => [
                    '$ne' => 2
                ]
            ]
        ]);
    }

    /**
     * Inserts a new user into the collection
     *
     * @param $req
     * @return bool
     */
    public static function insert($req)
    {
        $product = new Products();
        $product->uuid = uniqid(md5(random_bytes(10)));
        $product->userId = $req->userId;
        $product->spotId = $req->spotId;
        $product->location = $req->location;
        $product->status = 0;
        $product->dateIn = strtotime("now");

        # Create() returns bool
        if($product->create())
        {
            return true;
        }

        return false;
    }
}