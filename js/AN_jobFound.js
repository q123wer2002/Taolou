TaoLou.controller('Taolou_jobFound',['$scope','$http',function jobFound($scope,$http){

	//init
	$scope.showBG=false;
	$scope.Message=false;
	$scope.messageContent='';


	//function
	$scope.showMan=function(){
		if($scope.showBG){$scope.showBG=false;$scope.Message=false;}
		else{$scope.showBG=true;}
	}
	$scope.showMessage=function(){
		if($scope.Message){$scope.Message=false;}
		else{$scope.Message=true;}
	}

	//message
	$scope.messageToMan=function(item){
		var messageObject={"method":"messageToSeeker","receiveId":item,"message":$scope.messageContent};
		$http({
			method:'POST',
			url:'server/checkSeekerAjax.php',
			data: $.param(messageObject),
			headers: {'Content-type': 'application/x-www-form-urlencoded'},
		}).
		success(function(json){
			console.log(json);
			$scope.messageContent='';
			$scope.showBG=false;
			$scope.Message=false;
		}).
		error(function(json){
			console.warn(json);
			$scope.skillErrorMess='發生不可預測的錯誤';
		});
	}
}]);