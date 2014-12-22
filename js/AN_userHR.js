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