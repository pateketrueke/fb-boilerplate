<?php


// template render
function render($file, array $vars = array())
{
  $inc_file = ROOT."/includes/views/$file";
  $vars && extract($vars);
  require $inc_file;
}

// partial render
function partial($file, array $vars = array())
{
  ob_start();
  
  $inc_file = ROOT."/includes/views/_/$file";
  
  $vars && extract($vars);
  require $inc_file;
  
  $out = ob_get_clean();
  return $out;
}


// our friends using this app
function friends_using()
{
  $me  = fb::me();
  $uid = ! empty($me['id']) ? $me['id'] : -1;
  
  $args = func_get_args();
  $what = $args ? join(',', $args) : 'name';
  
  return fb::query("SELECT $what FROM user WHERE has_added_app=1 and uid IN (SELECT uid2 FROM friend WHERE uid1=$uid)");
}

// current user like-pages
function page_likes()
{
  $me  = fb::me();
  $uid = ! empty($me['id']) ? $me['id'] : -1;
  
  $args = func_get_args();
  $what = $args ? join(',', $args) : 'name';
  
  return fb::query("SELECT $what FROM page WHERE page_id IN(SELECT page_id FROM page_fan WHERE uid=$uid)");
}

