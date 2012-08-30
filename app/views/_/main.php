
<?php if ($me): ?>

  <img src="//graph.facebook.com/<?php echo $me['id']; ?>/picture" alt="<?php echo $me['name']; ?>"/>
  <h1>Hello <?php echo $me['name']; ?></h1>
  
  <a href="#invite" id="invite"
    data-action="invite"
    data-filter="app_non_users"
    data-message="This message can be customized..."
    data-extra=""
    data-title="Try out or FacebookApp!"
  >Invite your friends to this Boilerplate Facebook Application!</a>
  
  <br>
    
  <a href="#publish" id="publish"
    data-action="publish"
    data-name="Share by <?php echo $me['name']; ?>"
    data-url="<?php echo FACEBOOK_CANVAS_URL; ?>"
    data-image="http://humanstxt.org/img/HTML5-boilerplate.png"
    data-title="Publish to stream"
    data-description="Try out our new Boilerplate based FacebookApp"
    data-message="This message can be customized..."
  >Publish something funny, or not...</a></li>
  </ul>
  
<?php endif; ?>

