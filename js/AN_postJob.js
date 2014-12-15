TaoLou.controller('Taolou_postJob',['$scope','$http',function postJob($scope,$http){

	//init
	$scope.jobTitle='';
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

	//select into input (function)
	$scope.selectJobType=function(item){
		$scope.jobType=item.name;
		$scope.jobTypeStauts=false;
	}

	$scope.selectJobNature=function(item){
		$scope.jobNature=item.name;
		$scope.jobNatureStatus=false;
	}



	//server to show drop list
	$scope.jobTypes=[];
		//init jobtypes
	$scope.JOBTYPE_NAME="";
	$scope.JOBTYPEINIT=function(){
		$scope.jobTypes.push({'name':$scope.JOBTYPE_NAME});
	}
		//===============init over=================
	

	$scope.jobLocations=[
		{'name':'台北','tag':'1'},
	];

	$scope.jobNatures=[
		{'name':'全職','tag':'1'},
		{'name':'兼職','tag':'1'},
		{'name':'實習','tag':'1'},
	];

	//save job into server
	$scope.saveJob=function(){
		if($scope.jobTitle==""){$scope.jobError="請輸入'標題'";}
		else if($scope.jobName==""){$scope.jobError="請輸入職位'名稱'";}
		else if($scope.jobType==""){$scope.jobError="請選擇職位'類別'";}
		else if($scope.jobLocation==""){$scope.jobError="請選擇職位'地點'";}
		else if($scope.jobNature==""){$scope.jobError="請選擇職位'性質'";}
		else if($scope.jobSalary==""){$scope.jobError="請輸入'薪水'";}
		else if($scope.jobDetail==""){$scope.jobError="請輸入職位'描述'";}
		else{
			$scope.jobError="";
			var jobObject={"method":"saveJob","title":$scope.jobTitle,"jobName":$scope.jobName,"location":$scope.jobLocation,"jobType":$scope.jobType,"jobNature":$scope.jobNature,"salary":$scope.jobSalary,"stock_option":$scope.jobStockOption,"detail":$scope.jobDetail};

			$http({
				method:'POST',
				url:'server/postJobAjax.php',
				data: $.param(jobObject),
				headers: {'Content-type': 'application/x-www-form-urlencoded'},
			}).
			success(function(json){
				console.log(json);
				//$scope.eduexps.push({'id':json.Eduid,'education':'','start_edu':'','end_edu':'','school':'','major':'','status':true,'eduSelector':false,'startSelector':false,'endSelector':false});
			}).
			error(function(json){
				console.warn(json);
				$scope.eduErrorMes='發生不可預測的錯誤';
			});
		}
	}
}]);