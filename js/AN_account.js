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
				console.log(json.first);
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

});
//=========================