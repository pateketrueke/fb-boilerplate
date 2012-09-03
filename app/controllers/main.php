<?php

class main_controller extends app_controller
{
  function index()
  {
    $this->add_style('boilerplate.css');

    $this->add_script('application.js');
    $this->add_script('plugins.js');
    $this->add_script('script.js');

    echo partial('main.php');
  }
}
