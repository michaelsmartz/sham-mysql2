---
title: API Reference

language_tabs:
- cURL
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

#Authentication
<!-- START_a925a8d22b3615f12fca79456d286859 -->
## Log the user in

> Example request:

```bash
curl -X POST "http://localhost/api/auth/login"     -d "email"="Li8Fb1sxmJ0rEde1" \
    -d "password"="ZoVqTjsA3wPyuaPx" 
```

```javascript
const url = new URL("http://localhost/api/auth/login");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

let body = JSON.stringify({
    "email": "Li8Fb1sxmJ0rEde1",
    "password": "ZoVqTjsA3wPyuaPx",
})

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```

> Example response (200):

```json
{
    "access_token": "blablabla",
    "token_type": "bearer",
    "expires_in": 3600
}
```
> Example response (401):

```json
{
    "error": "Unauthorized"
}
```

### HTTP Request
`POST api/auth/login`

#### Body Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    email | email |  required  | Email address
    password | string |  required  | Password

<!-- END_a925a8d22b3615f12fca79456d286859 -->

<!-- START_19ff1b6f8ce19d3c444e9b518e8f7160 -->
## Logging the user out

> Example request:

```bash
curl -X POST "http://localhost/api/auth/logout" \
    -H "Authorization: Bearer {token}"
```

```javascript
const url = new URL("http://localhost/api/auth/logout");

let headers = {
    "Authorization": "Bearer {token}",
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

> Example response (200):

```json
{
    "message": "Successfully logged out"
}
```

### HTTP Request
`POST api/auth/logout`


<!-- END_19ff1b6f8ce19d3c444e9b518e8f7160 -->

#Employees

API for Employees
<!-- START_42af3d8d5862fde3052509cbae29451c -->
## Create a new Employee

> Example request:

```bash
curl -X POST "http://localhost/api/employees" \
    -H "Authorization: Bearer {token}"
```

```javascript
const url = new URL("http://localhost/api/employees");

let headers = {
    "Authorization": "Bearer {token}",
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

> Example response (200):

```json
{
    "success": true,
    "data": {
        "id": 1,
        "first_name": "John",
        "surname": "Doe",
        "more_fields": "more values"
    },
    "message": "Employee created successfully."
}
```

### HTTP Request
`POST api/employees`


<!-- END_42af3d8d5862fde3052509cbae29451c -->


