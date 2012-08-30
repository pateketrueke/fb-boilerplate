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


// resources
Tailor\Config::set('cache_dir', BASE.'/library/cache');

Tailor\Config::set('views_dir', BASE.'/app/views');
Tailor\Config::set('images_dir', BASE.'/assets/images');
Tailor\Config::set('styles_dir', BASE.'/assets/styles');
Tailor\Config::set('scripts_dir', BASE.'/assets/scripts');


// main routing
Broil\Config::set('root', $_SERVER['DOCUMENT_ROOT']);
Broil\Config::set('rewrite', FALSE);
Broil\Config::set('index_file', 'index.php');
Broil\Config::set('request_uri', ! empty($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '/');
Broil\Config::set('request_method', $_SERVER['REQUEST_METHOD']);
Broil\Config::set('server_name', $_SERVER['SERVER_NAME']);
Broil\Config::set('subdomain', option('subdomain'));
Broil\Config::set('domain', option('domain'));

require BASE.'/app/routes.php';

if ($match = Broil\Routing::run()) {
  @list($klass, $method) = explode('#', $match['to']);

  $controller_file  = BASE."/app/controllers/$klass.php";
  $controller_klass = "{$klass}_controller";

  if (is_file($controller_file)) {
    require BASE.'/library/application.php';
    require $controller_file;

    if (class_exists($controller_klass, FALSE)) {
      $obj = new $controller_klass;

      if (method_exists($obj, $method)) {
        params($match['params']);

        ob_start();
        $obj->$method();
        $out = ob_get_clean();


        if ($tpl = $controller_klass::$layout) {
          $out = render("layouts/$tpl", array(
            'title' => $controller_klass::$title,
            'body' => $out,
          ));
        }

        echo $out;
        exit;
      }
    }
  }

}

die('Not found!');
