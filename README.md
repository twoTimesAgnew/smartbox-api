# Smartbox API

This is a placeholder README.me for Smartbox REST API

## Technical Specs

* Phalcon 3.2.3
* PHP 7.1
* MongoDB

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
```
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
