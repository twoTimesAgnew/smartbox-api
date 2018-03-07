# Smartbox API

This is a placeholder README.me for Smartbox REST API

## Technical Specs

* Phalcon 3.2.3
* PHP 7.1
* MongoDB

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
