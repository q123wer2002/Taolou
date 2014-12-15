TaoLou.controller('Taolou_postJob',['$scope','$http',function postJob($scope,$http){

	//init
	$scope.jobName='';
	$scope.jobType='';
	$scope.jobLocation='';
	$scope.jobNature='';
	$scope.jobSalary='';
	$scope.jobStockOption='';
	$scope.jobDetail='';

	$scope.jobStockOption=false;
	$scope.jobTypeStauts=false;
	$scope.jobLocationStatus=false;
	$scope.jobNatureStatus=false;


	$scope.postJob=[
		//{'name':$socpe.jobName,'type':$scope.jobType,'location':$scope.jobLocation,'nature':$scope.jobNature,'salary':$scope.jobSalary,'stockOption':$scope.jobStockOption,'detail':$scope.jobDetail,};
	];


	//click function
	$scope.stockOptionFun=function(){
		if($scope.jobStockOption){$scope.jobStockOption=false;}
		else{$scope.jobStockOption=true;}
	}
	$scope.typeStatusFun=function(){
		if($scope.jobTypeStauts){$scope.jobTypeStauts=false;}
		else{$scope.jobTypeStauts=true;}
	}
	$scope.locationStatusFun=function(){
		if($scope.jobLocationStatus){$scope.jobLocationStatus=false;}
		else{$scope.jobLocationStatus=true;}
	}
	$scope.natureStatusFun=function(){
		if($scope.jobNatureStatus){$scope.jobNatureStatus=false;}
		else{$scope.jobNatureStatus=true;}
	}




	//server to show drop list
	$scope.jobTypes=[
		{'name':'軟體業','tag':'1'},
	];

	$scope.jobLocations=[
		{'name':'台北','tag':'1'},
	];

	$scope.jobNatures=[
		{'name':'全職','tag':'1'},
		{'name':'兼職','tag':'1'},
		{'name':'實習','tag':'1'},
	];
}]);