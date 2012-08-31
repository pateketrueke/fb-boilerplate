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
        $obj = new $controller_klass;
        params($match['params']);

        ob_start();
        $obj->$method();
        $tmp = ob_get_clean();

        if ($tpl = $obj->layout) {
          $vars = $obj->get_vars();

          $vars['head'] = $obj->get_head();
          $vars['styles'] = $obj->get_styles();
          $vars['scripts'] = $obj->get_scripts();

          $out  = render("layouts/$tpl", $vars);
        } else {
          $out = $obj->body;
        }
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

echo $out;
