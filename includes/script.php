<?php

fb::init();

fb::request_ids(function()
{
  foreach (func_get_args() as $id)
  {
    try {
      if ($src = fb::api($id))
      {
        // do something
        try {
          fb::api("/$src[id]/", 'DELETE');
        } catch (Exception $E) {
          trigger_error(print_r($E));
        }
      }
    } catch (Exception $e) {
      trigger_error(print_r($e));
    }
  }
  
  // everything is ok?
  fb::redirect(FACEBOOK_CANVAS_URL);
});

