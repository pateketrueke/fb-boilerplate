<?php

// bootstrap
set_time_limit(0);

define('BASE', __DIR__);


// initialize
require BASE.'/library/facebook.php';
require BASE.'/library/helpers.php';
require BASE.'/library/static.php';

require BASE.'/includes/config.php';
require BASE.'/includes/script.php';



// credentials
$me = fb::me();


/* Define template values */

$vars['style']  = array('assets/css/style.css');
$vars['script'] = array('assets/js/plugins.js', 'assets/js/script.js', 'application.js');

$vars['title']  = 'FacebookApp';
$vars['header'] = 'FacebookApp Fanpage';
$vars['footer'] = '&copy; FacebookApp Credits ' . date('Y');

$vars['yield']  = partial_view('main.php', compact('me'));
$vars['me'] = $me;

render_view('layout.php', $vars);
