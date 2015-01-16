TaoLou.controller('Taolou_jobSeeker',['$scope','$http',function jobSeeker($scope,$http){

	//init
	$scope.selectSeeker='選擇求職者狀態';
	$scope.selectSeekerStatus=false;

	$scope.jobSeekerStatus=[
		{'name':'所有求職者','tag':1},
		{'name':'未觀看','tag':2},
		{'name':'不錄取','tag':3},
		{'name':'考慮中','tag':4},
	];

	$scope.seekers=[];

	//init function
	$scope.SEEKERINIT=function(){
		if($scope.SEEKER_STATUS='wait'){$scope.seekStatus=0;}
		else if($scope.SEEKER_STATUS='deny'){$scope.seekStatus=1;}
		else if($scope.SEEKER_STATUS='thinking'){$scope.seekStatus=2;}
		else if($scope.SEEKER_STATUS='access'){$scope.seekStatus=3;}

		$scope.seekers.push({'name':$scope.SEEKER_NAME,'photo':$scope.SEEKER_PHOTO,'resume_name':$scope.SEEKER_RESUME_NAME,'resume_src':$scope.SEEKER_RESUME_SRC,'status':$scope.seekStatus});
	}

	//change function
	$scope.showStatus=function(){
		if($scope.selectSeekerStatus){$scope.selectSeekerStatus=false;}
		else{$scope.selectSeekerStatus=true;}
	}
	$scope.changeSeekerStatus=function(item){
		
	}

	//click function
	$scope.changeJobMode=function(item){
		$scope.selectSeeker=item.name;
		$scope.selectSeekerStatus=false;
	}


}]);