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

// url generation
function url($for, array $params = array()) {
  return Broil\Routing::path($for, $params);
}

// static files
function path($to) {
  return Broil\Config::get('root') . "public$to";
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

// throw exceptions
function raise($message, $status = 500) {
  status($status);
  throw new Exception($message);
}

// status header
function status($code) {
  static $reasons = array(
            100 => 'Continue',
            101 => 'Switching Protocols',
            102 => 'Processing',
            200 => 'OK',
            201 => 'Created',
            202 => 'Accepted',
            203 => 'Non-Authoritative Information',
            204 => 'No Content',
            205 => 'Reset Content',
            206 => 'Partial Content',
            207 => 'Multi-Status',
            226 => 'IM Used',
            300 => 'Multiple Choices',
            301 => 'Moved Permanently',
            302 => 'Found',
            303 => 'See Other',
            304 => 'Not Modified',
            305 => 'Use Proxy',
            306 => 'Reserved',
            307 => 'Temporary Redirect',
            400 => 'Bad Request',
            401 => 'Unauthorized',
            402 => 'Payment Required',
            403 => 'Forbidden',
            404 => 'Not Found',
            405 => 'Method Not Allowed',
            406 => 'Not Acceptable',
            407 => 'Proxy Authentication Required',
            408 => 'Request Timeout',
            409 => 'Conflict',
            410 => 'Gone',
            411 => 'Length Required',
            412 => 'Precondition Failed',
            413 => 'Request Entity Too Large',
            414 => 'Request-URI Too Long',
            415 => 'Unsupported Media Type',
            416 => 'Requested Range Not Satisfiable',
            417 => 'Expectation Failed',
            422 => 'Unprocessable Entity',
            423 => 'Locked',
            424 => 'Failed Dependency',
            426 => 'Upgrade Required',
            500 => 'Internal Server Error',
            501 => 'Not Implemented',
            502 => 'Bad Gateway',
            503 => 'Service Unavailable',
            504 => 'Gateway Timeout',
            505 => 'HTTP Version Not Supported',
            506 => 'Variant Also Negotiates',
            507 => 'Insufficient Storage',
            510 => 'Not Extended',
          );

  header("HTTP/1.0 $code {$reasons[$code]}");
  header("Status: $code {$reasons[$code]}");
}
