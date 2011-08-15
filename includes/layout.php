<!DOCTYPE html>
<!--[if lt IE 7 ]> <html class="no-js ie6" lang="en" xmlns:fb="http://www.facebook.com/2008/fbml"> <![endif]-->
<!--[if IE 7 ]>    <html class="no-js ie7" lang="en" xmlns:fb="http://www.facebook.com/2008/fbml"> <![endif]-->
<!--[if IE 8 ]>    <html class="no-js ie8" lang="en" xmlns:fb="http://www.facebook.com/2008/fbml"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--> <html class="no-js" lang="en" xmlns:fb="http://www.facebook.com/2008/fbml"> <!--<![endif]-->
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

  <title></title>
  <meta name="description" content="">
  <meta name="author" content="">

  <link rel="stylesheet" href="assets/css/html5.css?_<?= filemtime(ROOT.'/assets/css/html5.css'); ?>">
  <link rel="stylesheet" href="assets/css/style.css?_<?= filemtime(ROOT.'/assets/css/style.css'); ?>">
  <script src="assets/js/libs/modernizr-1.7.min.js"></script>

</head>

<body>

  <div id="container">
    <div id="fb-root"></div>

    <div id="conf"
      data-extra="<?php /* additional data */ ?>"
      data-appid="<?= FACEBOOK_APP_ID; ?>"
      data-canvas="<?= FACEBOOK_CANVAS_URL; ?>"
      data-pic="<?= CANVAS_PICTURE; ?>"
      data-me="<?= $me['link']; ?>"
    ></div>

    <header>
      FacebookApp
    </header>
    
    <div id="main" role="main">
      <?php if ($me): ?>
        <div id="notice"></div>
        
        <h1>Hello World</h1>
        
        <a href="#invite" id="invite">Invite your friends to this Boilerplate Facebook Application!</a>
      <?php endif; ?>
    </div>
    
    <footer>
      &copy; Our Company <?= date('Y'); ?>
    </footer>
    
  </div>


  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.js"></script>
  <script>window.jQuery || document.write("<script src='assets/js/libs/jquery-1.5.1.min.js'>\x3C/script>")</script>

  <script type="text/javascript" src="//connect.facebook.net/es_LA/all.js"></script>

  <script>var sess = <?= json_encode($session); ?>;</script>
  <script src="assets/js/plugins.js"></script>
  <script src="assets/js/script.js"></script>

  <script>
    var _gaq=[["_setAccount","<?php FACEBOOK_UA; ?>"],["_trackPageview"]];
    (function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];g.async=1;
    g.src=("https:"==location.protocol?"//ssl":"//www")+".google-analytics.com/ga.js";
    s.parentNode.insertBefore(g,s)}(document,"script"));
  </script>

</body>
</html>
