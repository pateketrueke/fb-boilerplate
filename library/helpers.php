<?php

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

// about me
function me() {}
