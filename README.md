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
      "id": 1,
      "spot_id": "B3",
      "recipient": "Victor Agnew",
      "smartbox_loc": [
          "lat": -72.0291392,
          "lon": 9.928119,
          "city": "Montreal",
          "readable": "123 White Ave."
        ],
      "status": 1,
      "date_in": "03/07/2018",
      "date_out": "03/08/2018"
  },
  {
      "id": 2,
      "spot_id": "D6",
      "recipient": "Ben St-Laurent",
      "smartbox_loc": [
          "lat": -72.0291392,
          "lon": 9.928119,
          "city": "Montreal",
          "readable": "123 White Ave."
        ],
      "status": 0,
      "date_in": "03/07/2018"
  }
]
```
