##Disclaimer
This is a very lightweight PHP Instagram API Library that I've created to test
the API. It is very simple and it works, it may not be the best thing to use in
production though.

##Required libraries
All requirements are set in the `composer.json`

- [guzzle http client](http://docs.guzzlephp.org/en/latest/)

## How to use
###Quick Start
Create an instance of the `Instagram` object using you Instagram App
information.

It is important that the `callback_uri` to match the one you set up in the app
setting or the oauth login url will fail.

```php
use Instagram\Instagram;

$instagram = new Instagram('client_id', 'client_secret', 'callback_uri');
```

###Set an Access Token
```php
$instagram->setAccessToken('Access Token');
```

###Generic request
Create a request to any API endpoint.

The `generic` method lets you request an endpoint and add parameters to the
request.

Examples:

```php
 //recent photos with the hasthag love
$content = $instagram->generic('/tags/love/media/recent');

//liked photos for the user set with the access token
$content = $instagram->generic('/users/self/media/liked');

//search for users by username
$content = $instagram->generic('/users/search', ['q' => 'aseba']);

//get recent media from user
$content = $instagram->generic('user/media/recent');
```

###Oauth
####Login

You can use `getLogin()` to get the url to take the user to start the oauth
process.

```
$instagram->getLogin('response type', [scopes]));
```

- `Response Type` is set to `code` by default.
- `scopes` is empty by default.

Example:
```php
$instagram->getLogin('token', ['basic','public_content','comments', 'relationships', 'follower_list']));
```

###Signed requests
If your app requires signed requests you can use the `$instagram->sign()` to
start signing all requests to Instagram.

###Full working example

`test.php`

```php
<?php

set_time_limit(0);
date_default_timezone_set('UTC');
require __DIR__.'/vendor/autoload.php';

use Instagram\Instagram;

$instagram = new Instagram('client_id', 'client_secret', 'callback_uri');
$instagram->setAccessToken('Access Token');
$instagram->sign();
$content = $instagram->generic('tags/love/media/recent');

foreach($content->data as $media) {
  echo($media->caption->text . "\n");
}
```
