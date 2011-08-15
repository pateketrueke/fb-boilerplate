<?php

class fb
{
  private static $me = NULL;
  private static $self = NULL;
  private static $session = NULL;
  
  private static $login_options = array(
                    'canvas' => 1,
                    'fbconnect' => 0,
                    'req_perms' => 'email,publish_stream,user_location,user_birthday',
                  );
  
  // handle dynamic calls
  final public static function __callStatic($method, $arguments)
  {
    static $repl = array(
              '/[^a-z0-9]|\s+/i' => ' ',
              '/\s([a-z])/ie' => 'ucfirst("\\1")',
            );
    
    $method = preg_replace(array_keys($repl), $repl, $method);
    
    if (method_exists(fb::instance(), $method))
    {
      return call_user_func_array(array(fb::instance(), $method), $arguments);
    }
  }
  
  // our Facebook object
  final public static function instance()
  {
    if (is_null(fb::$self))
    {
      fb::$self = new Facebook(array(
        'appId' => FACEBOOK_APP_ID,
        'secret' => FACEBOOK_SECRET,
        'cookie' => TRUE,
      ));
    }
    return fb::$self;
  }
  
  // initialize everything
  final public static function init()
  {
    $test = headers_list();
    
    if (array_key_exists('X-Facebook-User', $test))
    {
      fb::$me = (array) json_decode($test['X-Facebook-User']);
    }
    
    if (empty(fb::$me))
    {
      fb::$me      = NULL;
      fb::$session = fb::get_session();
      
      if ( ! fb::$session)
      {
        fb::redirect(fb::get_login_url(fb::$login_options));
      }
      else
      {
        try {
          fb::$me = fb::api('/me');
        } catch (FacebookApiException $e) {
          trigger_error(print_r($e));
        }
      }
    }
  }
  
  // on request_ids handler
  final public static function request_ids(Closure $lambda)
  {
    if ($_SERVER['REQUEST_METHOD'] === 'POST')
    {
      if ( ! empty($_GET[$method]))
      {
        $ids = explode(',', urldecode($_GET[$method]));
        call_user_func_array($lambda, $ids);
      }
    }
  }
  
  // our friends using this app
  final public static function friends_using()
  {
    $me = fb::me();
    
    $uid = ! empty($me['id']) ? $me['id'] : -1;
    $fql = "SELECT uid FROM user WHERE has_added_app=1 and uid IN (SELECT uid2 FROM friend WHERE uid1 = $uid)";
    
    $set = fb::api(array(
      'method' => 'fql.query',
      'query' => $fql,
    ));
    
    return $set;
  }
  
  // set canvas
  final public static function canvas($bool)
  {
    fb::$login_options['canvas'] = (int) $bool;
  }
  
  // set fbconnect
  final public static function fbconnect($bool)
  {
    fb::$login_options['fbconnect'] = (int) $bool;
  }
  
  // set permissions
  final public static function permissions($set)
  {
    fb::$login_options['req_perms'] = join(',', array_filter(func_get_args()));
  }
  
  // handle redirects
  final public static function redirect($url)
  {
    if (fb::is_canvas())
    {
      echo '<script type="text/javascript">top.location.href="', $url, '";</script>';
    }
    else
    {
      header("Location: $url");
    }
    exit;
  }
  
  // our app use canvas?
  final public static function is_canvas()
  {
    return ! empty(fb::$login_options['canvas']);
  }

  // retrieve session
  final public static function session()
  {
    return fb::$session;
  }
  
  // about app user
  final public static function me()
  {
    return fb::$me;
  }
}
