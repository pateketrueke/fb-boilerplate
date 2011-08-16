var $conf = $('#conf');

FB.init({
  appId   : $conf.data('appid'),
  status  : true, // check login status
  cookie  : true, // enable cookies to allow the server to access the session
  xfbml   : true // parse XFBML
});

FB.Canvas.setAutoResize();


jQuery(function($){
  
  
  // invites
  $('a[data-action=invite]').click(function() {
  
    var item = $(this);
  
    FB.ui({
      method: 'apprequests',
      filters: item.data('filter').split(','),
      message: item.data('message'),
      data: item.data('extra'),
      title: item.data('title')
    }, function(response) {
      
      /* do something */
      
    });
    
    return false;
  });
  
  
  // publish
  $('a[data-action=publish]').click(function() {
    
    var item = $(this);
    
    FB.ui({
      method: 'feed',
      name: item.data('name'),
      link: item.data('url'),
      picture: item.data('image'),
      caption: item.data('title'),
      description: item.data('description'),
      message: item.data('message')
    }, function(response) {
      
      /* do something */
      
    });
    
    return false;
  });
  
  
  // related parent/external-on-top links
  $('a[rel*=parent]').click(function(){
  
    window.parent.location.href = this.href;
    
    return false;
    
  });
  
});
