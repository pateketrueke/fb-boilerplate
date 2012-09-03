<?php

// bootstrap
require 'library/initialize.php';

// error handling
set_exception_handler(function ($e) {
  echo $e->getMessage();
});

set_error_handler(function ($errno, $errmsg, $file, $line, $trace) {
  if (($errno & error_reporting()) == $errno) {
    raise("$errmsg at $file, line $line");
    return TRUE;
  }
  return FALSE;
});

// application
if ($match = Broil\Routing::run()) {
  @list($klass, $method) = explode('#', $match['to']);

  $controller_file  = BASE."/app/controllers/$klass.php";
  $controller_klass = "{$klass}_controller";

  if (is_file($controller_file)) {
    require BASE.'/library/application.php';
    require $controller_file;

    if (class_exists($controller_klass, FALSE)) {
      if (in_array($method, get_class_methods($controller_klass))) {
        eval('class req_klass{function __call($m,$a){return call_user_func_array(array("Postman\\Request",$m),$a);}}');

        params($match['params']);

        $app = new $controller_klass;
        $app->request = new req_klass;

        $obj = new Postman\Handle($app);
        $out = new Postman\Response($obj->execute($method));

        if ($tpl = $app->layout) {
          $vars = $app->get_vars();

          $vars['head'] = $app->get_head();
          $vars['styles'] = $app->get_styles();
          $vars['scripts'] = $app->get_scripts();
          $vars['body'] = $app->body ?: $out->response;

          $out->response = render("layouts/$tpl", $vars);
        } else {
          $out->response = $app->body ?: $out->response;
        }

        $out->headers = $app->get_headers();
        $out->status = $app->get_status();

        echo $out;
      } else {
        raise("Method $controller_klass#$method missing in $controller_file");
      }
    } else {
      raise("Class $controller_klass not found in $controller_file");
    }
  } else {
    raise("Controller file not found: $controller_file");
  }
} else {
  raise('No matching route', 404);
}
