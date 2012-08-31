<?php

class main_controller extends app_controller
{
  function index()
  {
    $this->add_style('main.css');
    $this->body = partial('main.php');
  }
}
