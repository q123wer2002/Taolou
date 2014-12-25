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
		jQuery(".CVDiv").animate({'bottom':'200px'},500);
	}
	$scope.hideCVDiv=function(){
		jQuery('.bg').css({'display':'none'});
		jQuery(".CVDiv").animate({'bottom':'-400px'},500);
	}

	//apply and collect function
	$scope.apply=function(){
		var applyObject={"method":"applyJob","jobID":$scope.jobID,"CV":$sceop.myCV};
		
		$http({
			method:'POST',
			url:'server/applyJobAjax.php',
			data: $.param(applyObject),
			headers: {'Content-type': 'application/x-www-form-urlencoded'},
		}).
		success(function(json){
			console.log(json);
			if(json.first=="success"){
				$scope.showMessage="投遞成功，等待公司回覆";
				jQuery(".changeOK").animate({'top':'-100px'},1000).delay(2000).animate({'top':'-300px'},1000);
			}else if(json.first=="NotMember"){
				$scope.showMessage="投遞成功，等待公司回覆";
				jQuery(".changeOK").animate({'top':'-100px'},1000);
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