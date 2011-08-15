<?php

// bootstrap
set_time_limit(0);

define('ROOT', __DIR__);

require ROOT.'/library/facebook.php';
require ROOT.'/library/functions.php';

require ROOT.'/includes/config.php';
require ROOT.'/includes/script.php';


$session = fb::session();
$me      = fb::me();


/* Please, feel free to copy the layout file to another place and use it! */
require ROOT.'/includes/layout.php';