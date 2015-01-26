    // This is called with the results from from FB.getLoginStatus().
  function statusChangeCallback(response) {
    if (response.status === 'connected') {
      // Logged into your app and Facebook.
      saveFB_user();

      var uid = response.authResponse.userID; 
      var accessToken = response.authResponse.accessToken;
      //console.log(uid+"//"+accessToken);
    
    } else if (response.status === 'not_authorized') {
      // The person is logged into Facebook, but not your app.
      FB.login(function(response) {
        if (response.status === 'connected'){
        	saveFB_user();
        }
      }, {scope: 'email,user_likes,user_photos,user_friends'});
    } else {
      // The person is not logged into Facebook, so we're not sure if
      // they are logged into this app or not.
      FB.login(function(response) {
      	if (response.status === 'connected'){
        	saveFB_user();
        }
      }, {scope: 'email,user_likes,user_photos,user_friends'});
    }
  }

  // This function is called when someone finishes with the Login
  // Button.  See the onlogin handler attached to it in the sample
  // code below.
  

  function checkLoginState() {
    FB.getLoginStatus(function(response) {
      statusChangeCallback(response);
    });
  }

  // Here we run a very simple test of the Graph API after login is
  // successful.  See statusChangeCallback() for when this call is made.

  function saveFB_user() {
    //console.log('Welcome!  Fetching your information.... ');
    FB.api('/me?fields=email,picture,name,id', function(response) {

      //console.log(response);
      //document.getElementById('status').innerHTML=response;

      //save user into Taolou system
    	var userFBObject={"method":"checkFBuser","FB_id":response.id,"userName":response.name,"email":response.email,"photo":response['picture']['data']['url']};
  		$.ajax({
  			type: "POST",
  			url: "server/accountAjax.php",
  			data: $.param(userFBObject),
  			headers: {'Content-type': 'application/x-www-form-urlencoded'},
  			async: true,
  			error: function (xhr,error){console.warn(xhr);},
  			success: function (json) {
  				console.log(json);
  				location.href='index.php';
  			}
  		});

    });
  }