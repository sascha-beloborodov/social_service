---
title: API Reference

language_tabs:
- bash
- javascript

includes:

search: true

toc_footers:
- <a href='http://github.com/mpociot/documentarian'>Documentation Powered by Documentarian</a>
---
<!-- START_INFO -->
# Info

Welcome to the generated API reference.
[Get Postman Collection](http://localhost/docs/collection.json)
<!-- END_INFO -->

#general
<!-- START_5c0e5fd96d6d16d858ac71290615a481 -->
## Sends message to user.

Notice!
If user did not approve - hi doesn't see a message

> Example request:

```bash
curl -X POST "http://abebot.tk//api/instagram/messages/text" \
-H "Accept: application/json" \
    -d "user_id"="885653200" \
    -d "message"="velit" \

```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://abebot.tk//api/instagram/messages/text",
    "method": "POST",
    "data": {
        "user_id": 885653200,
        "message": "velit"
},
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`POST api/instagram/messages/text`

#### Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    user_id | integer |  required  | Minimum: `1`
    message | string |  required  | Maximum: `65000`

<!-- END_5c0e5fd96d6d16d858ac71290615a481 -->

<!-- START_4f44439e444bf7c480463e75c50d0c9e -->
## Sends image to user.

Notice! Also as 'sendText' -
If user did not approve - hi doesn't see a message

> Example request:

```bash
curl -X POST "http://abebot.tk//api/instagram/messages/image" \
-H "Accept: application/json" \
    -d "user_id"="351763623" \
    -d "image"="neque" \

```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://abebot.tk//api/instagram/messages/image",
    "method": "POST",
    "data": {
        "user_id": 351763623,
        "image": "neque"
},
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`POST api/instagram/messages/image`

#### Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    user_id | integer |  required  | Minimum: `1`
    image | string |  required  | Maximum: `10000` Allowed mime types: `png`, `jpg`, `jpeg` or `gif`

<!-- END_4f44439e444bf7c480463e75c50d0c9e -->

