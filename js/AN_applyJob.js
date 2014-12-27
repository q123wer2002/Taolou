TaoLou.controller('Taolou_applyJob',['$scope','$http',function applyJob($scope,$http){

	//init
	$scope.showMessage="";
	$scope.CVs=[
		{'name':'Taolou的線上履歷','id':0},
	];
	$scope.CVINIT=function(){
		$scope.CVs.push({'name':$scope.CV_NAME,'id':$scope.CV_ID});
	}

	//show and hide function
	$scope.showCVDiv=function(){
		jQuery('.bg').css({'display':'block'});
		jQuery(".CVDiv").animate({'bottom':'40%'},500);
	}
	$scope.hideCVDiv=function(){
		jQuery('.bg').css({'display':'none'});
		jQuery(".CVDiv").animate({'bottom':'-400px'},500);
	}
	$scope.notMember=function(){
		jQuery(".changeOK").animate({'top':'-125px'});
	}

	//apply and collect function
	$scope.apply=function(){
		var applyObject={"method":"applyJob","jobID":$scope.jobID,"CV":$scope.myCV};
		
		$http({
			method:'POST',
			url:'server/applyJobAjax.php',
			data: $.param(applyObject),
			headers: {'Content-type': 'application/x-www-form-urlencoded'},
		}).
		success(function(json){
			console.log(json);
			if(json.first=="success"){
				location.reload();
			}
		}).
		error(function(json){
			console.warn(json);
			$scope.jobError='發生不可預測的錯誤';
		});
	}

	$scope.collect=function(){
		var collectObject={"method":"collectJob","jobID":$scope.jobID};
		
		$http({
			method:'POST',
			url:'server/applyJobAjax.php',
			data: $.param(collectObject),
			headers: {'Content-type': 'application/x-www-form-urlencoded'},
		}).
		success(function(json){
			console.log(json);
		}).
		error(function(json){
			console.warn(json);
			$scope.jobError='發生不可預測的錯誤';
		});
	}
}]);	