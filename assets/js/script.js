var $conf = $('#conf');

FB.init({
  appId   : $conf.data('appid'),
  session : sess, // don't refetch the session when PHP already has it
  status  : true, // check login status
  cookie  : true, // enable cookies to allow the server to access the session
  xfbml   : true // parse XFBML
});

FB.Canvas.setAutoResize();


jQuery(function($){
  
  // invites
  $('#invite,.invite').bind('click', function() {
    FB.ui({
      method: 'apprequests',
      filters: ['app_non_users'],
      message: 'Try out our Boilerplate Application on Facebook!',
      data: $conf.data('extra'),
      title: 'BoilerplateApp'
    }, function(response) {
      /* do something */
    });
  });
  
  // publish
  var publish = function publish(item) {
    FB.ui({
      method: 'feed',
      name: item.name || 'name',
      link: item.url || 'url',
      picture: item.image || 'image',
      caption: item.title || 'title',
      description: item.description || 'description',
      message: item.message || 'message'
    }, function(response) {
      /* do something */
    });
  };
  
  // related parent/external-on-top links
  $('a[rel*=parent]').bind('click', function(){
    window.parent.location.href = this.href;
    return false;
  });
  
});
