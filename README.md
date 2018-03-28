# Smartbox API

## Technical Specs

* Phalcon 3.2.3
* PHP 7.1
* MongoDB
* Docker

## Installation

Clone the project from this git repo
```text
git clone http://github.com/twotimesagnew/smartbox-api.git
```

Navigate into the directory, then run the following command
```text
docker-compose up -d
```

To verify that everything worked, the command `docker ps` should return the following
```text
CONTAINER ID        IMAGE               COMMAND                  CREATED             STATUS              PORTS                      NAMES
c59c3630b485        smartbox_api        "docker-php-entryp..."   3 seconds ago       Up 3 seconds        0.0.0.0:8600->80/tcp       smartbox_api_1
dc5be97eb474        mongo:latest        "docker-entrypoint..."   4 seconds ago       Up 4 seconds        0.0.0.0:27017->27017/tcp   smartbox_mongo_1
a4592b078eca        redis:latest        "docker-entrypoint..."   4 seconds ago       Up 4 seconds        0.0.0.0:6379->6379/tcp     smartbox_redis_1
```

## Authentication

This API is protected by a very basic authentication system. The only requirement is that the request must contain  
an `Authorization` header with a value equal to `smartbox-api-key`.  

Example CURL
```text
curl -X GET -H "Authorization: smartbox-api-key" http://52.14.40.2:8600/products
```

## Routes

### Products

#### GET /products  
Returns a JSON list of all products
```json
[
  {
      "uuid": "298s0agf8xcuj190cs010x9gujajq8as0",
      "spotId": "B3",
      "userId": 33,
      "location": {
          "lat": -72.0291392,
          "lon": 9.928119,
          "city": "Montreal",
          "readable": "123 White Ave."
        },
      "status": 1,
      "dateIn": "03/07/2018",
      "dateOut": "03/08/2018"
  },
  {
      "uuid": "d9a0sgf8xc0s8918c14510x9guj0f000c",
      "spotId": "D4",
      "userId": 12,
      "location": {
          "lat": 7.0291392,
          "lon": 90.928119,
          "city": "Beijing",
          "readable": "123 Ching Chong Ave."
        },
      "status": 0,
      "dateIn": "03/07/2018"
  }
]
```

#### POST /products  
Adds a new product  
Required Fields
* userId - Int
* spotId - String
* location - Array
  * lat - Float
  * lon - Float
  * city - String
  * readable - String

##### Returns
* 200 OK
```
{ "status" : "success", "message" : "success message" }
```
* 500 Internal Server Error
```
{ "status" : "error", "message" : "error message" }
```

#### GET /products/user/{id}
Returns all products for a specific user

##### Returns
* 200 OK
```json
[
    {
        "uuid": "c97a34e9190a63d39c12032b9195f9b35ab3f9e2e0e86",
        "userId": 1,
        "spotId": "A2",
        "location": {
            "lat": 70.999,
            "lon": 70.999,
            "city": "Montreal",
            "readable": "123 White Ave."
        },
        "dateIn": 1521744354,
        "dateOut": null,
        "status": 0,
        "_id": {
            "$oid": "5ab3f9e2da9af20001571f92"
        }
    }
]
```
* 200 OK but no data
```json
[
  {
    "status": "success",
    "message": "No products found for this user"
  }
]
```

#### GET /products/{uuid}
Returns all info for a specific product

##### Returns
* 200 OK
```json
{
    "_id": {
        "$oid": "5aa1abc53f3881000175cde2"
    },
    "uuid": "6f01c295bda7e2c5f156b329a178c72c5aa1abc515ff6",
    "userId": 1,
    "spotId": "B6",
    "location": {
        "lat": 71.92921,
        "lon": 90.2112,
        "city": "Montreal",
        "readable": "123 White Ave."
    },
    "dateIn": 1520544709,
    "dateOut": null,
    "status": 0
}
```
* 404 Not Found
```json
{
    "status": "error",
    "message": "No product found for uuid"
}
```

#### PUT /products/{uuid}
Updates a product. Any field that belongs to the document can be updated.  
If a product's status is being updated to 2, the dateOut time will automatically  
be updated to the current time.

##### Returns
* 200 OK
```json
{
    "status": "success",
    "message": "Successfully updated document"
}
```
* 400 Bad Request
```json
{
    "status": "error",
    "message": "Error updating document"
}
```