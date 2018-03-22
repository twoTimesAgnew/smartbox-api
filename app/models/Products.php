<?php

namespace Models;

use Phalcon\Mvc\MongoCollection as MongoCollection;

class Products extends MongoCollection
{
    public $_id;
    public $uuid;
    public $userId;
    public $spotId;
    public $location;
    public $dateIn;
    public $dateOut;
    public $status;

    const ATTRIBUTES = ["_id", "uuid", "userId", "spotId", "location", "dateIn", "dateOut", "status"];

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
     * Return the list of attributes
     *
     * @return array
     */
    public function getAttributes()
    {
        $attributes = [];

        foreach(self::ATTRIBUTES as $attribute)
        {
            if(isset($this->$attribute)) {
                $attributes[$attribute] = $this->$attribute;
            }
        }

        return $attributes;
    }

    /**
     * Sets all attributes for a model instance
     *
     * @param $doc
     */
    public function setAttributes($doc)
    {
        foreach(self::ATTRIBUTES as $attribute)
        {
            if(isset($doc->$attribute)) {
                $this->$attribute = $doc->$attribute;
            }
        }
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
                "userId" => (int) $id
            ]
        ]);
    }

    /**
     * Returns product corresponding to uuid
     *
     * @param $uuid
     * @return array
     */
    public static function findByUuid($uuid)
    {
        return Products::findFirst([
            "conditions" => [
                "uuid" => $uuid
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

    public static function updateDoc($uuid, $req)
    {
        $product = new Products();
        $product->setAttributes(Products::findByUuid($uuid));

        if(empty($req))
        {
            return false;
        }

        foreach($req as $key => $value)
        {
            if(in_array($key, self::ATTRIBUTES)) {
                if($value !== $product->$key) {
                    $product->$key = $value;
                }
            }

            if($key === "status" && $value === 2) {
                $product->dateOut = strtotime("now");
            }
        }

        if($product->save())
        {
            return true;
        }

        return false;
    }
}