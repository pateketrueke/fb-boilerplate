<?php

class fb
{

  private static $me = NULL;
  private static $self = NULL;
  private static $login_options = array(
                    'canvas' => 1,
                    'fbconnect' => 0,
                    'scope' => 'email,user_likes,publish_stream',
                  );


  // handle dynamic calls
  public static function __callStatic($method, $arguments)
  {
    static $repl = array(
              '/[^a-z0-9]|\s+/i' => ' ',
              '/\s([a-z])/ie' => 'ucfirst("\\1")',
            );

    $method = preg_replace(array_keys($repl), $repl, $method);

    if (method_exists(static::instance(), $method)) {
      return call_user_func_array(array(static::instance(), $method), $arguments);
    }
  }

  // our Facebook object
  public static function instance()
  {
    if (is_null(static::$self)) {
      static::$self = new Facebook(array(
        'appId' => option('facebook_app_id'),
        'secret' => option('facebook_secret'),
        'cookie' => TRUE,
      ));
    }
    return static::$self;
  }

  // initialize everything
  public static function init()
  {
    $test = headers_list();

    if (array_key_exists('X-Facebook-User', $test)) {
      static::$me = (array) json_decode($test['X-Facebook-User']);
    }

    // TODO: how to renew the permissions?

    if ( ! static::$me) {
      if ( ! static::get_user()) {
        $opts =& static::$login_options;

        $opts['fbconnect'] = (int) (option('fbconnect') ?: $opts['fbconnect']);
        $opts['canvas'] = (int) (option('canvas') ?: $opts['canvas']);
        $opts['scope'] = option('scope') ?: $opts['scope'];

        if (static::is_canvas()) {
          echo '<script type="text/javascript">top.location.href="', static::get_login_url($opts), '";</script>';
        } else {
          header('Location: ' . static::get_login_url($opts));
        }
        exit;
      } else {
        try {
          static::$me = static::api('/me');
        } catch (FacebookApiException $e) {
          trigger_error(print_r($e, TRUE));
          exit;
        }
      }
    }
  }

  // FQL queries
  public static function query($fql, $callback = '')
  {
    return static::api(array(
      'callback' => $callback,
      'method' => 'fql.query',
      'query' => $fql,
    ));
  }

  // on request_ids handler
  public static function request_ids(Closure $lambda)
  {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      if ( ! empty($_GET[__FUNCTION__])) {
        $ids = array_filter(explode(',', urldecode($_GET[__FUNCTION__])));
        $ids && call_user_func_array($lambda, $ids);
      }
    }
  }

  // our app use canvas?
  public static function is_canvas()
  {
    return ! empty(static::$login_options['canvas']);
  }

  // about app user
  public static function me()
  {
    return static::$me;
  }
}
