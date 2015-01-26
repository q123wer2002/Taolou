TaoLou.controller('Taolou_userHr',['$scope','$http',function userHr($scope,$http){

	//init
	$scope.company="";
	$scope.FB="";
	$scope.Google="";
	$scope.Nmae='';
	$scope.email="";
	$scope.photo="";
	$scope.newContent="";

	$scope.COMPANY_USER="";
	$scope.COMPANY_NAME="";

	$scope.companyStatus=false;
	$scope.noCompanyStatus=false;
	$scope.showChangeDiv=false;
	$scope.changeContactStatus=false;
	$scope.doubleCheck=false;

	//array
	$scope.companies=[];
	$scope.companyUsers=[];

	//init function
	$scope.COMPANYINIT=function(){
		$scope.companies.push({'name':$scope.COMPANY_NAME});
	}
	$scope.COMPANYUSERINIT=function(){
		$scope.companyUsers.push({'name':$scope.COMPANY_USER});
	}


	//only show function
	$scope.companyFun=function(){
		if($scope.companyStatus){$scope.companyStatus=false;}
		else{$scope.companyStatus=true;}
	}
	$scope.noCompanyFun=function(){
		if($scope.noCompanyStatus){$scope.noCompanyStatus=false;}
		else{$scope.noCompanyStatus=true;}
	}
	$scope.showchangeDivFun=function(){
		if($scope.showChangeDiv){$scope.showChangeDiv=false;}
		else{$scope.showChangeDiv=true;}
	}
	$scope.changeContactFun=function(){
		if($scope.changeContactStatus){$scope.changeContactStatus=false;}
		else{$scope.changeContactStatus=true;}
	}

	//save data function
	$scope.companySave=function(item){
		$scope.company=item.name;
		$scope.companyStatus=false;
	}
	$scope.changeContact=function(item){
		$scope.newContent=item.name;
		$scope.changeContactStatus=false;
	}

	//open file to save image
	jQuery('#openFile').click(function(){
		var ComPhoto = document.getElementById('photoFile');
		if (ComPhoto) {ComPhoto.click();}
	});

	//funally save all data
	$scope.userHRdblCheck=function(){
		if($scope.company==""){$scope.userHRError="請選擇您的公司";}
		else if($scope.Name==""){$scope.userHRError="請填寫您的姓名";}
		else{
			$scope.userHRError="";
			$scope.doubleCheck=true;
			jQuery("#alert").animate({'top':'0px'},500);
		}
	}
	$scope.userHRSave=function(){
		var userHRObject={"method":"saveUserHR","companyName":$scope.company,"facebook":$scope.FB,"google":$scope.Google,"userName":$scope.Name};
		
		$http({
			method:'POST',
			url:'server/userHRAjax.php',
			data: $.param(userHRObject),
			headers: {'Content-type': 'application/x-www-form-urlencoded'},
		}).
		success(function(json){
			console.log(json);
			location.href="companies.php";
		}).
		error(function(json){
			console.warn(json);
			$scope.jobError='發生不可預測的錯誤';
		});
	}
	//re send company valid email
	$scope.reSendCompanyValid=function(){
		var reCompanyValid={"method":"reCompanyValid","companyName":$scope.company};
		
		$http({
			method:'POST',
			url:'server/userHRAjax.php',
			data: $.param(reCompanyValid),
			headers: {'Content-type': 'application/x-www-form-urlencoded'},
		}).
		success(function(json){
			console.log(json);
			$("#resend").animate({'top':'0px'},500).delay(1500).animate({'top':'-200px'},500);
		}).
		error(function(json){
			console.warn(json);
			$scope.jobError='發生不可預測的錯誤';
		});
	}

	//save company user
	$scope.CHANGEUSER=function(){
		if($scope.newContent==""){$scope.contactError="請選擇聯絡人";}
		else{
			var userChangeObject={"method":"changeUser","userName":$scope.newContent};
			
			$http({
				method:'POST',
				url:'server/userHRAjax.php',
				data: $.param(userChangeObject),
				headers: {'Content-type': 'application/x-www-form-urlencoded'},
			}).
			success(function(json){
				console.log(json);
				location.reload();
			}).
			error(function(json){
				console.warn(json);
				$scope.jobError='發生不可預測的錯誤';
			});
		}
	}

}]);


//一般的javascript
function handleFiles(files) {
  if (!files.length) {} 
  else {
  	var file = files[0];
    //document.forms["userPhotoForm"].submit();
    var form_data = new FormData();
	form_data.append("file", file);
	form_data.append("method", "updatePhoto");

    $.ajax({
		type: "POST",
		url: "server/userHRAjax.php",
		data: form_data,
		processData: false,
        contentType: false,
		error: function (json){console.warn(json);},
		success: function (json) {
			console.log(json);
			var reader = new FileReader();
			reader.readAsDataURL(file);
			reader.onload = function(e){
				$('#Photo').attr('src', e.target.result);
				$('#photoName').attr('value',file.name);
				$("#saveOK").animate({'top':'0px'},500).delay(1500).animate({'top':'-200px'},500);
			}
		}
	});
  }
}


//FACEBOOK  
//FACEBOOK
//FACEBOOK
//FACEBOOK
//FACEBOOK
//FACEBOOK

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
    	var userFBObject={"method":"linkFB","FB_id":response.id,"userName":response.name,"email":response.email,"photo":response['picture']['data']['url']};
		$.ajax({
			type: "POST",
			url: "server/userHRAjax.php",
			data: $.param(userFBObject),
			headers: {'Content-type': 'application/x-www-form-urlencoded'},
			async: true,
			error: function (xhr,error){console.warn(xhr);},
			success: function (json) {
				console.log(json);
				location.reload();
			}
		});

    });
  }

//LINKEDIN  
//LINKEDIN
//LINKEDIN
//LINKEDIN
//LINKEDIN
//LINKEDIN

var openyet=false;
// 2. Runs when the JavaScript framework is loaded
function onLinkedInLoad() {
  $('a[id*=li_ui_li_gen_]').html("<a class=\"input-weibo-holder\" href=\"javascript:;\"><input class='required' placeholder=\"綁定LinkedIn\" ng-model='IN' disabled></a>");
  $('#LinkedInLogin').css({display:'inline-block'});
  IN.Event.on(IN, "auth", onLinkedInAuth);
}

// 2. Runs when the viewer has authenticated
function onLinkedInAuth() {
//IN.API.Connections("me")
//IN.API.Profile("me")
    IN.API.Profile("me")
      .fields("id","headline","firstName", "lastName",  "picture-url", "email-address")
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
    var userLinkedInObject={"method":"linkIN","IN_id":member['id'],"IN_headline":member['headline'],"IN_name":name,"IN_email":member['emailAddress'],"IN_photo":member['pictureUrl']};
      $.ajax({
        type: "POST",
        url: "server/userHRAjax.php",
        data: $.param(userLinkedInObject),
        headers: {'Content-type': 'application/x-www-form-urlencoded'},
        async: true,
        error: function (xhr,error){console.warn(xhr);},
        success: function (json) {
          console.log(json);
          location.reload();
        }
      });
  }else{}


}
function displayConnectionErrors(){console.warn("error");}