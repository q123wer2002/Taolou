
  // 2. Runs when the JavaScript framework is loaded
 function onLinkedInLoad() {
 	$('a[id*=li_ui_li_gen_]').html("<a class='red-btn weibo' style='background:#0274B3;'>用LinkedIn登入</a>");
	$('#LinkedInLogin').css({display:'block'});
    IN.Event.on(IN, "auth", onLinkedInAuth);
  }

  // 2. Runs when the viewer has authenticated
function onLinkedInAuth() {
	//IN.API.Profile("me")
  IN.API.Connections("me")
    .fields("firstName", "lastName", "industry", "distance", "positions", "picture-url", "email-address", "skills")
    .result(displayConnections)
    .error(displayConnectionErrors);
}

  // 2. Runs when the Profile() API call returns successfully
function displayConnections(profiles) {
	var member = profiles.values[0];
	console.log(profiles);
}
