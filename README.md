#PHPIRT
## PHP Instagram implementation

###Disclaimer
This an in ultra-alpha library, but it works. It's just a piece of code I've created to play along with the [Instagram Real Time API](http://instagram.com/developer/realtime/)

### Required libraries
You'll need to have the curl library installed along with PHP.

We also use [curl library](https://github.com/shuber/curl) from [shuber](https://github.com/shuber)

If you `git@github.com:aseba/php-instagram-lib.git` everyhing should be working fine

### How to use the REAL TIME API

You will need an instagram client id and client secret. Get it [here](http://instagr.am/developer/manage/).

In order to use this library you will need to set it somewhere where the `callback.php` file can be accessible by instagram servers

`test.php` file has an example on usage for the basic subscriptions calls

To configure the callback usage you must create a new class extending `SubscriptionProcessor` in `phpirt.php` file and redefine the `public static function process($data){}` function. You can see an example at `callback.php` file

#### Example
```
$i = new InstagramRealTime(INSTAGRAM_KEY, INSTAGRAM_SECRET);
$photos = $i->generic("/tags/$hashtag/media/recent");
```