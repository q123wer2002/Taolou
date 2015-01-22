//帳戶專用
TaoLou.controller('TaolouAccount',function account($scope,$http){

	$scope.email='';
	$scope.password='';
	$scope.errorMessage='';
	$scope.memberType=[
		{'name':'一般用戶','values':'n'},
		{'name':'人力資源','values':'y'},
	];

	$scope.account = function() {
		if($scope.email != "" && $scope.password != ""){
			if($scope.myType.values==''){
				$scope.errorMessage='*請選擇用戶類別';
			}
			else if($scope.myType.values=="x"){
				var accountObject={"method":"login","memberType":"0","email":$scope.email,"password":$scope.password};
			}
			else{
				var accountObject={"method":"signup","memberType":$scope.myType.values,"email":$scope.email,"password":$scope.password};
			}
			$http({
				method:'POST',
				url:'server/accountAjax.php',
				data: $.param(accountObject),
				headers: {'Content-type': 'application/x-www-form-urlencoded'},
			}).
			success(function(json){
				console.log(json);
				if(json.actions=="signup"){
					if(json.url=='X'){$scope.errorMessage='*'+json.first;}
					else{window.open(json.url,'_self');}
				}
				else if(json.actions=='login'){
					if(json.url=='X'){$scope.errorMessage='*'+json.first;}
					else{window.open(json.url,'_self');}
				}
			}).
			error(function(json){
				console.warn(json);
			});
		}
		else{$scope.errorMessage='*請填入信箱與密碼';}
	}


	$scope.logout=function(){
		var accountObject={'method':'logout'};
		$http({
			method:'POST',
			url:'server/accountAjax.php',
			data: $.param(accountObject),
			headers: {'Content-type': 'application/x-www-form-urlencoded'},
		}).
		success(function(json){
			console.log(json);
			if(json.actions=="logout"){
				if(json.url=='X'){$scope.errorMessage='*'+json.first;}
				else{window.open(json.url,'_self');}
			}
		}).
		error(function(jsin){
			console.warn(json);
		});
	}

	//=================================================================
	//設定專用
	$scope.ex_password="";
	$scope.new_password="";
	$scope.changePass=function(){
		if($scope.ex_password == ""){$scope.passError="請輸入舊密碼";}
		else if($scope.new_password == ""){$scope.passError="請輸入新密碼";}
		else{
			$scope.passError="";

			var settingObject={'method':'changePassword',"ex_pass":$scope.ex_password,"new_pass":$scope.new_password};
			$http({
				method:'POST',
				url:'server/accountAjax.php',
				data: $.param(settingObject),
				headers: {'Content-type': 'application/x-www-form-urlencoded'},
			}).
			success(function(json){
				console.log(json);
				if(json.mes == "error"){$scope.passError=json.first;}
				else{
					$scope.ex_password="";
					$scope.new_password="";
					jQuery(".changeOK").animate({'top':'-100px'},1000).delay(2000).animate({'top':'-300px'},1000);
				}
			}).
			error(function(jsin){
				console.warn(json);
			});

		}
	}
	$scope.messageAlert=false;
	$scope.resumeAlert=false;
	$scope.changeModeMessageFun=function(){
		if($scope.messageAlert){$scope.messageAlert=false;}
		else{$scope.messageAlert=true;}
	}
	$scope.changeModeResumeFun=function(){
		if($scope.resumeAlert){$scope.resumeAlert=false;}
		else{$scope.resumeAlert=true;}
	}
	$scope.changeAlert=function(){
		if($scope.messageAlert){$scope.messageAlert=1;}else{$scope.messageAlert=0;}
		if($scope.resumeAlert){$scope.resumeAlert=1;}else{$scope.resumeAlert=0;}
		var alertObject={'method':'changeAlert',"messageAlert":$scope.messageAlert,"resumeAlert":$scope.resumeAlert};
		$http({
			method:'POST',
			url:'server/accountAjax.php',
			data: $.param(alertObject),
			headers: {'Content-type': 'application/x-www-form-urlencoded'},
		}).
		success(function(json){
			console.log(json);
			jQuery(".changeOK").animate({'top':'-100px'},1000).delay(2000).animate({'top':'-300px'},1000);
		}).
		error(function(jsin){
			console.warn(json);
		});
	}

});
//=========================



$('#FacebookBtn').click(function(){
	statusChangeCallback();
});