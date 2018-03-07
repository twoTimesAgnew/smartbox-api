<?php
use Phalcon\Mvc\MongoCollection as MongoCollection;
class Item extends MongoCollection
{
    public $firstName;
    public $lastName;
    public $email;
    /**
     * Sets the Model's collection
     *
     * @return string
     */
    public function getSource()
    {
        return 'items';
    }
    /**
     * Returns all users from the Users collection
     *
     * @return array
     */
    public static function getAll()
    {
        return Item::find();
    }
    /**
     * Inserts a new user into the collection
     *
     * @param $req
     * @return bool
     */
    public static function insert($req)
    {
        $item = new Item();
        $item->first = $req->first;
        $item->last = $req->last;
        $item->dob = $req->dob;
        $item->email = $req->email;
        # Create() returns bool
        if($item->create())
        {
            return true;
        }
        return false;
    }
}