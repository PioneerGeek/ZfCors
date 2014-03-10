#ZfCors

Provides CORS headers for your application responses.

### Installation
----------------

Add `ZfCors` to your `composer.json`:

~~~json
{
    "repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/Punchkick-Interactive/ZfCors.git"
        }
    ],
    "require": {
        "punchkick-interactive/ZfCors": "dev-master"
    }
}
~~~

### Usage
---------

The module ships with default headers preconfigured in its `module.config.php` as follows:

~~~php
'corsHeaders' => array(
        'access-control-allow-headers' => 'accept, accept-encoding, content-type',
        'access-control-allow-methods' => '*',
        'access-control-allow-origin' => '*',
    ),
~~~

Feel free to override the above default headers in your app's `module.config.php` or any config files you have as you need.

## And That's All!
------------------