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
If user did not approve - he doesn't see a message

> Example request:

```bash
curl -X POST "http://localhost/api/instagram/messages/text" \
-H "Accept: application/json" \
    -d "user_id"="885653200" \
    -d "message"="velit" \

```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/api/instagram/messages/text",
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
If user did not approve - he doesn't see a message

> Example request:

```bash
curl -X POST "http://localhost/api/instagram/messages/image" \
-H "Accept: application/json" \
    -d "user_id"="351763623" \
    -d "image"="neque" \

```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/api/instagram/messages/image",
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

<!-- START_8e25693341dd79962cce6246be6e6b5d -->
## Get threads of a current user. &lt;br&gt;
Pending threads will approve automatically

> Example request:

```bash
curl -X GET "http://localhost/api/instagram/messages/threads" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/api/instagram/messages/threads",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
{
    "message": "Bad credentials: You must provide a username and password to login()."
}
```

### HTTP Request
`GET api/instagram/messages/threads`

`HEAD api/instagram/messages/threads`


<!-- END_8e25693341dd79962cce6246be6e6b5d -->

<!-- START_2544763eb9ce558e2b09c9b60dc70cb6 -->
## Get history of all threads (all users). &lt;br&gt;
TODO: make separate methods - getHistoryByThread and getHistoryByUserId

> Example request:

```bash
curl -X GET "http://localhost/api/instagram/messages/history" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/api/instagram/messages/history",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
{
    "message": "Bad credentials: You must provide a username and password to login()."
}
```

### HTTP Request
`GET api/instagram/messages/history`

`HEAD api/instagram/messages/history`


<!-- END_2544763eb9ce558e2b09c9b60dc70cb6 -->

<!-- START_32deab1ce932b3953a68ce535df8e64d -->
## api/vk/users/getById

> Example request:

```bash
curl -X GET "http://localhost/api/vk/users/getById" \
-H "Accept: application/json" \
    -d "user_ids"="facilis" \
    -d "fields"="facilis" \

```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/api/vk/users/getById",
    "method": "GET",
    "data": {
        "user_ids": "facilis",
        "fields": "facilis"
},
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
{
    "message": "You forgot VK ACCESS TOKEN"
}
```

### HTTP Request
`GET api/vk/users/getById`

`HEAD api/vk/users/getById`

#### Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    user_ids | string |  required  | Minimum: `1`
    fields | string |  required  | Minimum: `1`

<!-- END_32deab1ce932b3953a68ce535df8e64d -->

<!-- START_de61fa7fc602ee9f5114e170a8c04b37 -->
## todo: pagination?

Notice! Only standalone-permissions - messages

> Example request:

```bash
curl -X GET "http://localhost/api/vk/messages/get" \
-H "Accept: application/json" \
    -d "last_message_id"="2118765914" \

```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/api/vk/messages/get",
    "method": "GET",
    "data": {
        "last_message_id": 2118765914
},
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
{
    "message": "You forgot VK ACCESS TOKEN"
}
```

### HTTP Request
`GET api/vk/messages/get`

`HEAD api/vk/messages/get`

#### Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    last_message_id | integer |  optional  | Minimum: `0`

<!-- END_de61fa7fc602ee9f5114e170a8c04b37 -->

<!-- START_1a6b852dfef44fbe0f6d5d96f34650d8 -->
## Notice! Only standalone-permissions - messages

> Example request:

```bash
curl -X POST "http://localhost/api/vk/messages/text" \
-H "Accept: application/json" \
    -d "user_id"="70960460" \
    -d "message"="aperiam" \
    -d "attachment"="aperiam" \

```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/api/vk/messages/text",
    "method": "POST",
    "data": {
        "user_id": 70960460,
        "message": "aperiam",
        "attachment": "aperiam"
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
`POST api/vk/messages/text`

#### Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    user_id | integer |  required  | Minimum: `1`
    message | string |  required  | Minimum: `1` Maximum: `65000`
    attachment | string |  optional  | Minimum: `1` Maximum: `65000`

<!-- END_1a6b852dfef44fbe0f6d5d96f34650d8 -->

<!-- START_af7b5cb2eb9e03f7d9e9ce94bf151abb -->
## Notice! Only standalone-permissions - messages

> Example request:

```bash
curl -X GET "http://localhost/api/vk/messages/history" \
-H "Accept: application/json" \
    -d "user_id"="1563171598" \
    -d "offset"="9774361" \
    -d "count"="9774361" \

```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/api/vk/messages/history",
    "method": "GET",
    "data": {
        "user_id": 1563171598,
        "offset": 9774361,
        "count": 9774361
},
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
{
    "message": "You forgot VK ACCESS TOKEN"
}
```

### HTTP Request
`GET api/vk/messages/history`

`HEAD api/vk/messages/history`

#### Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    user_id | integer |  required  | Minimum: `1`
    offset | integer |  optional  | 
    count | integer |  optional  | 

<!-- END_af7b5cb2eb9e03f7d9e9ce94bf151abb -->

<!-- START_9b3d970b82ffe5b1555dbf83c6d3046e -->
## Notice! Only standalone-permissions - messages

> Example request:

```bash
curl -X GET "http://localhost/api/vk/messages/dialogs" \
-H "Accept: application/json" \
    -d "offset"="5" \
    -d "count"="5" \

```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/api/vk/messages/dialogs",
    "method": "GET",
    "data": {
        "offset": 5,
        "count": 5
},
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
{
    "message": "You forgot VK ACCESS TOKEN"
}
```

### HTTP Request
`GET api/vk/messages/dialogs`

`HEAD api/vk/messages/dialogs`

#### Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    offset | integer |  optional  | 
    count | integer |  optional  | 

<!-- END_9b3d970b82ffe5b1555dbf83c6d3046e -->

<!-- START_822ad1cbf4d95cb820968f9c46235e75 -->
## api/vk/groups/getOneById

> Example request:

```bash
curl -X GET "http://localhost/api/vk/groups/getOneById" \
-H "Accept: application/json" \
    -d "group_ids"="velit" \

```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/api/vk/groups/getOneById",
    "method": "GET",
    "data": {
        "group_ids": "velit"
},
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
{
    "message": "You forgot VK ACCESS TOKEN"
}
```

### HTTP Request
`GET api/vk/groups/getOneById`

`HEAD api/vk/groups/getOneById`

#### Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    group_ids | string |  required  | Minimum: `1`

<!-- END_822ad1cbf4d95cb820968f9c46235e75 -->

<!-- START_5006dc51cdc99a19b7014ebe0d49bfe3 -->
## api/vk/groups

> Example request:

```bash
curl -X GET "http://localhost/api/vk/groups" \
-H "Accept: application/json" \
    -d "user_id"="2105718355" \
    -d "extended"="343063369" \
    -d "fields"="voluptatibus" \

```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/api/vk/groups",
    "method": "GET",
    "data": {
        "user_id": 2105718355,
        "extended": 343063369,
        "fields": "voluptatibus"
},
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
{
    "message": "You forgot VK ACCESS TOKEN"
}
```

### HTTP Request
`GET api/vk/groups`

`HEAD api/vk/groups`

#### Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    user_id | integer |  optional  | Minimum: `1`
    extended | integer |  optional  | 
    fields | string |  optional  | Minimum: `1`

<!-- END_5006dc51cdc99a19b7014ebe0d49bfe3 -->

<!-- START_661bbdee7994c4de5e133e840487f079 -->
## api/vk/friends

> Example request:

```bash
curl -X GET "http://localhost/api/vk/friends" \
-H "Accept: application/json" \
    -d "user"="34686718" \
    -d "fields"="et" \

```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/api/vk/friends",
    "method": "GET",
    "data": {
        "user": 34686718,
        "fields": "et"
},
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
{
    "message": "You forgot VK ACCESS TOKEN"
}
```

### HTTP Request
`GET api/vk/friends`

`HEAD api/vk/friends`

#### Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    user | integer |  optional  | 
    fields | string |  optional  | 

<!-- END_661bbdee7994c4de5e133e840487f079 -->

<!-- START_30dc553120973e71cea92049086e68d9 -->
## api/vk/likes/to

> Example request:

```bash
curl -X POST "http://localhost/api/vk/likes/to" \
-H "Accept: application/json" \
    -d "type"="nobis" \
    -d "owner_id"="1466591977" \
    -d "item_id"="1466591977" \

```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/api/vk/likes/to",
    "method": "POST",
    "data": {
        "type": "nobis",
        "owner_id": 1466591977,
        "item_id": 1466591977
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
`POST api/vk/likes/to`

#### Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    type | string |  required  | Minimum: `1`
    owner_id | integer |  required  | Minimum: `1`
    item_id | integer |  required  | Minimum: `1`

<!-- END_30dc553120973e71cea92049086e68d9 -->

<!-- START_4cb1fff1c7202abd46414da357583581 -->
## api/vk/posts/one

> Example request:

```bash
curl -X GET "http://localhost/api/vk/posts/one" \
-H "Accept: application/json" \
    -d "owner_id"="et" \
    -d "post_id"="et" \
    -d "fields"="et" \

```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/api/vk/posts/one",
    "method": "GET",
    "data": {
        "owner_id": "et",
        "post_id": "et",
        "fields": "et"
},
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
{
    "message": "You forgot VK ACCESS TOKEN"
}
```

### HTTP Request
`GET api/vk/posts/one`

`HEAD api/vk/posts/one`

#### Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    owner_id | string |  required  | Minimum: `1`
    post_id | string |  required  | Minimum: `1`
    fields | string |  optional  | 

<!-- END_4cb1fff1c7202abd46414da357583581 -->

<!-- START_8e3320ff006437bba4793c54677581ec -->
## api/vk/posts

> Example request:

```bash
curl -X GET "http://localhost/api/vk/posts" \
-H "Accept: application/json" \
    -d "owner_id"="6" \
    -d "offset"="6" \
    -d "count"="6" \

```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/api/vk/posts",
    "method": "GET",
    "data": {
        "owner_id": 6,
        "offset": 6,
        "count": 6
},
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
{
    "message": "You forgot VK ACCESS TOKEN"
}
```

### HTTP Request
`GET api/vk/posts`

`HEAD api/vk/posts`

#### Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    owner_id | integer |  optional  | 
    offset | integer |  optional  | 
    count | integer |  optional  | 

<!-- END_8e3320ff006437bba4793c54677581ec -->

<!-- START_83e0755bd75e5e98063e0a296c479c39 -->
## api/vk/posts/create

> Example request:

```bash
curl -X POST "http://localhost/api/vk/posts/create" \
-H "Accept: application/json" \
    -d "owner_id"="262394401" \
    -d "message"="quia" \
    -d "from_group"="77" \
    -d "attachments"="quia" \

```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/api/vk/posts/create",
    "method": "POST",
    "data": {
        "owner_id": 262394401,
        "message": "quia",
        "from_group": 77,
        "attachments": "quia"
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
`POST api/vk/posts/create`

#### Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    owner_id | integer |  required  | Minimum: `1`
    message | string |  required  | Maximum: `65000`
    from_group | integer |  optional  | 
    attachments | string |  optional  | 

<!-- END_83e0755bd75e5e98063e0a296c479c39 -->

<!-- START_23ba1a9d0b4f205b730c70d5b3b3f755 -->
## api/vk/posts/edit

> Example request:

```bash
curl -X PUT "http://localhost/api/vk/posts/edit" \
-H "Accept: application/json" \
    -d "owner_id"="919426477" \
    -d "message"="molestiae" \
    -d "post_id"="919426477" \
    -d "attachments"="molestiae" \

```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/api/vk/posts/edit",
    "method": "PUT",
    "data": {
        "owner_id": 919426477,
        "message": "molestiae",
        "post_id": 919426477,
        "attachments": "molestiae"
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
`PUT api/vk/posts/edit`

#### Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    owner_id | integer |  required  | Minimum: `1`
    message | string |  required  | Maximum: `65000`
    post_id | integer |  required  | Minimum: `1`
    attachments | string |  optional  | 

<!-- END_23ba1a9d0b4f205b730c70d5b3b3f755 -->

<!-- START_46479f4dee59fb6340dff9e43af7b6f4 -->
## api/vk/posts/delete

> Example request:

```bash
curl -X DELETE "http://localhost/api/vk/posts/delete" \
-H "Accept: application/json" \
    -d "owner_id"="701009180" \
    -d "post_id"="701009180" \

```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/api/vk/posts/delete",
    "method": "DELETE",
    "data": {
        "owner_id": 701009180,
        "post_id": 701009180
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
`DELETE api/vk/posts/delete`

#### Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    owner_id | integer |  required  | Minimum: `1`
    post_id | integer |  required  | Minimum: `1`

<!-- END_46479f4dee59fb6340dff9e43af7b6f4 -->

<!-- START_400ef8435311b9f3ba78dc66f258deb8 -->
## api/vk/posts/comments

> Example request:

```bash
curl -X GET "http://localhost/api/vk/posts/comments" \
-H "Accept: application/json" \
    -d "owner_id"="1710572406" \
    -d "post_id"="1710572406" \
    -d "offset"="83007384" \
    -d "count"="83007384" \
    -d "extended"="83007384" \
    -d "fields"="quibusdam" \

```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/api/vk/posts/comments",
    "method": "GET",
    "data": {
        "owner_id": 1710572406,
        "post_id": 1710572406,
        "offset": 83007384,
        "count": 83007384,
        "extended": 83007384,
        "fields": "quibusdam"
},
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
{
    "message": "You forgot VK ACCESS TOKEN"
}
```

### HTTP Request
`GET api/vk/posts/comments`

`HEAD api/vk/posts/comments`

#### Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    owner_id | integer |  required  | Minimum: `1`
    post_id | integer |  required  | Minimum: `1`
    offset | integer |  optional  | 
    count | integer |  optional  | 
    extended | integer |  optional  | 
    fields | string |  optional  | 

<!-- END_400ef8435311b9f3ba78dc66f258deb8 -->

<!-- START_7386c404b1ee4f011aaf167acaf21cbd -->
## api/vk/posts/comments/create

> Example request:

```bash
curl -X POST "http://localhost/api/vk/posts/comments/create" \
-H "Accept: application/json" \
    -d "owner_id"="168058665" \
    -d "post_id"="168058665" \
    -d "message"="beatae" \
    -d "attachments"="beatae" \

```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/api/vk/posts/comments/create",
    "method": "POST",
    "data": {
        "owner_id": 168058665,
        "post_id": 168058665,
        "message": "beatae",
        "attachments": "beatae"
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
`POST api/vk/posts/comments/create`

#### Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    owner_id | integer |  required  | Minimum: `1`
    post_id | integer |  required  | Minimum: `1`
    message | string |  required  | Maximum: `65000`
    attachments | string |  optional  | 

<!-- END_7386c404b1ee4f011aaf167acaf21cbd -->

<!-- START_32f6af47058eabc8bf7bf1b7c4cf2a7b -->
## api/vk/posts/comments

> Example request:

```bash
curl -X PUT "http://localhost/api/vk/posts/comments" \
-H "Accept: application/json" \
    -d "owner_id"="2001084415" \
    -d "comment_id"="2001084415" \
    -d "message"="recusandae" \
    -d "attachments"="recusandae" \

```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/api/vk/posts/comments",
    "method": "PUT",
    "data": {
        "owner_id": 2001084415,
        "comment_id": 2001084415,
        "message": "recusandae",
        "attachments": "recusandae"
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
`PUT api/vk/posts/comments`

#### Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    owner_id | integer |  required  | Minimum: `1`
    comment_id | integer |  required  | Minimum: `1`
    message | string |  required  | Maximum: `65000`
    attachments | string |  optional  | 

<!-- END_32f6af47058eabc8bf7bf1b7c4cf2a7b -->

<!-- START_632a6be274648082e106fdd3d5eef228 -->
## api/vk/posts/comments

> Example request:

```bash
curl -X DELETE "http://localhost/api/vk/posts/comments" \
-H "Accept: application/json" \
    -d "owner_id"="1072365317" \
    -d "comment_id"="1072365317" \

```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/api/vk/posts/comments",
    "method": "DELETE",
    "data": {
        "owner_id": 1072365317,
        "comment_id": 1072365317
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
`DELETE api/vk/posts/comments`

#### Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    owner_id | integer |  required  | Minimum: `1`
    comment_id | integer |  required  | Minimum: `1`

<!-- END_632a6be274648082e106fdd3d5eef228 -->

