<?php

class app_controller {

  private $head = array();

  private $styles = array(
            'plain' => array(),
            'compiled' => array(),
          );

  private $scripts = array(
            'plain' => array(),
            'compiled' => array(),
          );

  private $status = 200;
  private $headers = array();

  private $locals = array(
              'layout' => 'default.php',
              'title' => 'Untitled',
              'body' => '',
            );


  function __get($key)
  {
    if (isset($this->locals[$key])) {
      return $this->locals[$key];
    }
    // TODO: raise exception
  }

  function __set($key, $value)
  {
    $this->locals[$key] = $value;
  }


  function set_header($key, $value)
  {
    $this->headers[$key] = $value;
  }

  function unset_header($key)
  {
    if (isset($this->headers[$key])) {
      unset($this->headers[$key]);
    }
  }

  function set_headers(array $all)
  {
    $this->headers = $all;
  }

  function get_headers()
  {
    return $this->headers;
  }

  function clear_headers()
  {
    $this->headers = array();
  }


  function set_status($code)
  {
    $this->status = $code;
  }

  function get_status()
  {
    return $this->status;
  }


  function add_head($text)
  {
    $this->head []= $text;
  }

  function get_head()
  {
    return join("\n", $this->head);
  }


  // TODO: concatenate, minify and compile assets!

  function add_style($style, $raw = FALSE)
  {
    if ($raw) {
      $this->styles['plain'] []= "<style>$style</style>";
    } else {
      $tmp = Tailor\Base::partial($style, 'styles_dir');

      if ( ! is_file($tmp)) {
        raise("Stylesheet file missing: $style");
      }

      $this->styles['compiled'] []= $tmp;
    }
  }

  function get_styles()
  {
    $id  = '';
    $tmp = array();
    $out = $this->styles['plain'];

    foreach ($this->styles['compiled'] as $file) {
      $id   .= md5_file($file);
      $tmp []= file_get_contents($file);
    }

    $hash = md5($id);
    $css  = "$hash.css";
    $old  = BASE."/public/css/$css";

    file_put_contents($old, join("\n", $tmp));

    return '<link rel="stylesheet" href="' . path("/css/$css") . '">';
  }


  function add_script($script, $raw = FALSE)
  {
    if ($raw) {
      $this->scripts['plain'] []= "<script>$script</script>";
    } else {
      $tmp = Tailor\Base::partial($script, 'scripts_dir');

      if ( ! is_file($tmp)) {
        raise("Javascript file missing: $script");
      }

      $this->scripts['compiled'] []= $tmp;
    }
  }

  function get_scripts()
  {
    //return $this->scripts;
  }

  function get_vars()
  {
    return $this->locals;
  }

}
