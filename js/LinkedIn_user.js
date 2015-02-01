
var openyet=false;
// 2. Runs when the JavaScript framework is loaded
function onLinkedInLoad() {
  $('a[id*=li_ui_li_gen_]').html("<img src='https://pbs.twimg.com/profile_images/2945466711/12e018532d913494d841f79da5dd70bf_400x400.png' width='30' style='position:absolute;top:10px;left:-33px;'><span class='red-btn weibo' style='background:#0274B3;'>用LinkedIn登入</span>");
  $('#LinkedInLogin').css({display:'block'});
  IN.Event.on(IN, "auth", onLinkedInAuth);
}

// 2. Runs when the viewer has authenticated
function onLinkedInAuth() {
//IN.API.Connections("me")
//IN.API.Profile("me")
    IN.API.Profile("me")
      .fields("id","headline","firstName", "lastName", "positions:(is-current,company:(name,type,size,industry,ticker),title,start-date,end-date)", "picture-url", "email-address", "educations", "skills", "languages")
      .result(saveUserProfile)
      .error(displayConnectionErrors);
}

// 2. Runs when the Profile() API call returns successfully
function saveUserProfile(profiles) {
  var member = profiles.values[0];
  console.log(member);

  if(!openyet){
    openyet=true;
    console.log(member);

    var name=member['firstName']+" "+member['lastName'];
    var userLinkedInObject={"method":"checkINuser","IN_id":member['id'],"IN_headline":member['headline'],"IN_name":name,"IN_email":member['emailAddress'],"IN_photo":member['pictureUrl'],"IN_educations":member['educations'],"IN_postions":member['positions'],"skills":member['skills']};
      $.ajax({
        type: "POST",
        url: "server/accountAjax.php",
        data: $.param(userLinkedInObject),
        headers: {'Content-type': 'application/x-www-form-urlencoded'},
        async: true,
        error: function (xhr,error){console.warn(xhr);},
        success: function (json) {
          console.log(json);
          location.href='index.php';
        }
      });
  }else{}


}
function displayConnectionErrors(){console.warn("error");}
