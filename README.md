
# Simple-PHP-JWT-REST-API [![License: CC BY-NC 4.0](https://licensebuttons.net/l/by-nc/4.0/80x15.png)](https://creativecommons.org/licenses/by-nc/4.0/)

A simple PHP REST API created to handle JWT tokens' creation and validation.

[![Status](https://img.shields.io/badge/Status-Released-blue)](https://choosealicense.com/licenses/mit/)

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

## License
<p xmlns:cc="http://creativecommons.org/ns#" xmlns:dct="http://purl.org/dc/terms/"><a property="dct:title" rel="cc:attributionURL" href="https://github.com/ZuVi-VGM/Simple-PHP-JWT-REST-API">ZuVi-VGM/Simple-PHP-JWT-REST-API</a> by <a rel="cc:attributionURL dct:creator" property="cc:attributionName" href="https://github.com/ZuVi-VGM">Vito Gabriele Marino [ZuVi-VGM]</a> is licensed under <a href="http://creativecommons.org/licenses/by-nc/4.0/?ref=chooser-v1" target="_blank" rel="license noopener noreferrer" style="display:inline-block;">CC BY-NC 4.0<img style="height:22px!important;margin-left:3px;vertical-align:text-bottom;" src="https://mirrors.creativecommons.org/presskit/icons/cc.svg?ref=chooser-v1"><img style="height:22px!important;margin-left:3px;vertical-align:text-bottom;" src="https://mirrors.creativecommons.org/presskit/icons/by.svg?ref=chooser-v1"><img style="height:22px!important;margin-left:3px;vertical-align:text-bottom;" src="https://mirrors.creativecommons.org/presskit/icons/nc.svg?ref=chooser-v1"></a></p>

## Authors

- [@ZuVi-VGM](https://www.github.com/ZuVi-VGM)
