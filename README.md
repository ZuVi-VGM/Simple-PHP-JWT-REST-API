
# Simple-PHP-JWT-REST-API

A simple PHP REST API created to handle JWT tokens' creation and validation.

[![Status](https://img.shields.io/badge/Status-In_developement-yellow)](https://choosealicense.com/licenses/mit/)
## Tech Stack

PHP, REST API & JWT Tokens


## Used By

This API is used in the following project:

- [ZuVi-VGM/Simple-JS-P2P-Web-Game](https://github.com/ZuVi-VGM/Simple-JS-P2P-Web-Game)



## Features

- Token Creation
- Token Validation


## API Reference

#### Get all items

```http
  POST /token/create
```

| Parameter | Type     | Description                |
| :-------- | :------- | :------------------------- |
| `peer_id` | `string` | **Required**. Your Peer id |
| `hmac_key` | `string` | **Required**. Your communication key |

#### Get item

```http
  GET /token/validate/${token}
```

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `token`      | `string` | **Required**. Token to validate |




## Demo

Coming soon...


## Support

For support, email [ZuVi-VGM](mailto:vitog.m98@gmail.com).


## Authors

- [@ZuVi-VGM](https://www.github.com/ZuVi-VGM)

