<?php

// routing
function get($path, $action, array $params = array()) {
  Broil\Routing::add(strtoupper(__FUNCTION__), $path, $action, $params);
}
function put($path, $action, array $params = array()) {
  Broil\Routing::add(strtoupper(__FUNCTION__), $path, $action, $params);
}
function post($path, $action, array $params = array()) {
  Broil\Routing::add(strtoupper(__FUNCTION__), $path, $action, $params);
}
function delete($path, $action, array $params = array()) {
  Broil\Routing::add(strtoupper(__FUNCTION__), $path, $action, $params);
}

// root-shortcut
function root($action, array $params = array()) {
  get('/', $action, $params);
}

// variables
function params($item, $default = FALSE) {
  static $bag = array();

  if (is_array($item)) {
    $bag = array_merge($bag, $item);
  } else {
    return ! empty($bag[$item]) ? $bag[$item] : $default;
  }
}

// templating
function render($file, array $vars = array())
{
  return Tailor\Base::render(Tailor\Base::partial($file), $vars);
}

// partial render
function partial($file, array $vars = array())
{
  return render("_/$file", $vars);
}

// assign options
function config($item, $value = NULL) {
  static $bag = array();

  if ($item === TRUE) {
    return $bag;
  } elseif (is_array($item)) {
    foreach ($item as $key => $value) {
      $bag[$key] = $value;
    }
  } else {
    $bag[$item] = $value;
  }
}

// retrieve options
function option($item, $default = FALSE) {
  if ($set = config(TRUE)) {
    $default = ! empty($set[$item]) ? $set[$item] : $default;
  }
  return $default;
}
