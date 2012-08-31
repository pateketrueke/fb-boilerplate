<?php

// bootstrap
set_time_limit(0);
define('BASE', dirname(__DIR__));


// initialize
require BASE.'/vendor/autoload.php';

// required
require BASE.'/library/facebook.php';
require BASE.'/library/helpers.php';
require BASE.'/library/kernel.php';

// options
config(call_user_func(function () {
    require BASE.'/app/config.php';
    return get_defined_vars();
  }));

fb::init();

// resources
Tailor\Config::set('cache_dir', BASE.'/library/cache');

Tailor\Config::set('views_dir', BASE.'/app/views');
Tailor\Config::set('images_dir', BASE.'/assets/images');
Tailor\Config::set('styles_dir', BASE.'/assets/styles');
Tailor\Config::set('scripts_dir', BASE.'/assets/scripts');


// main routing
Broil\Config::set('root', dirname($_SERVER['PHP_SELF']));
Broil\Config::set('rewrite', FALSE);
Broil\Config::set('index_file', 'index.php');
Broil\Config::set('request_uri', ! empty($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '/');
Broil\Config::set('request_method', $_SERVER['REQUEST_METHOD']);
Broil\Config::set('server_name', $_SERVER['SERVER_NAME']);
Broil\Config::set('subdomain', option('subdomain'));
Broil\Config::set('domain', option('domain'));

require BASE.'/app/routes.php';
