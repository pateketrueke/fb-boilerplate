<?php

// bootstrap
set_time_limit(0);

define('ROOT', __DIR__);


// initialize
require ROOT.'/library/facebook.php';
require ROOT.'/library/helpers.php';
require ROOT.'/library/static.php';

require ROOT.'/includes/config.php';
require ROOT.'/includes/script.php';



// credentials
$me = fb::me();


/* Define template values */

$vars['style']  = array('assets/css/style.css');
$vars['script'] = array('assets/js/plugins.js', 'assets/js/script.js', 'application.js');

$vars['title']  = 'FacebookApp';
$vars['header'] = 'FacebookApp Fanpage';
$vars['footer'] = '&copy; FacebookApp Credits ' . date('Y');

$vars['yield']  = partial('main.php', compact('me'));

render('layout.php', $vars);

