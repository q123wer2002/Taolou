TaoLou.controller('Taolou_userResume',['$scope','$http',function userResume($scope,$http){

	$scope.userResumes=[];
	$scope.checkboxModeFun=function(item){
		if(item.intelligence){item.intelligence=false;}
		else{item.intelligence=true;}
	}
	$scope.selectSkillFun=function(item){
		if(item.selectSkill){item.selectSkill=false;}
		else{item.selectSkill=true;}
	}


	$scope.RESUME_INIT=function(){
		if($scope.RESUME_intelligence=='y'){$scope.intell=true;}
		else{$scope.intell=false;}

		if($scope.RESUME_type=="pdf"){$scope.figure="REPDF";}
		else if($scope.RESUME_type=="doc" || $scope.RESUME_type=="docx"){$scope.figure="REDOC";}
		else if($scope.RESUME_type=="txt"){$scope.figure="RETEXT";}
		else{$scope.figure="REX";}

		$scope.userResumes.push=({"name":$scope.RESUME_name,"type":$scope.figure,"skill":$scope.RESUME_skill,"intelligence":$scope.intell,"size":$scope.RESUME_size,"createDate":$scope.RESUME_createDate,"selectSkill":false});
	}

}]);