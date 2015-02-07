TaoLou.controller('Taolou_jobSeeker',['$scope','$http',function jobSeeker($scope,$http){
	//email loading BG
	$scope.loading=false;
	//===============

	//init
	$scope.selectSeeker='所有求職者';
	$scope.selectSeekerFilter='';
	$scope.selectSeekerStatus=false;

	$scope.bg=false;
	$scope.peopleCheck=false;
	$scope.noOneCheck=false;

	$scope.jobSeekerStatus=[
		{'name':'所有求職者','tag':''},
		{'name':'尚未決定者','tag':0},
		{'name':'不錄取','tag':1},
		{'name':'履歷下載','tag':2},
		{'name':'已面試','tag':3},
		{'name':'錄取者','tag':4},
	];

	$scope.seekers=[];

	//init function
	$scope.SEEKERINIT=function(){
		if($scope.SEEKER_STATUS==''){$scope.seekStatus=0;}
		else if($scope.SEEKER_STATUS=='reject'){$scope.seekStatus=1;}
		else if($scope.SEEKER_STATUS=='download'){$scope.seekStatus=2;}
		else if($scope.SEEKER_STATUS=='wait'){$scope.seekStatus=3;}
		else if($scope.SEEKER_STATUS=='access'){$scope.seekStatus=4;}

		if($scope.SEEKER_COMMENT){var status=true;}
		else{var status=false;}

		$scope.seekers.push({'id':$scope.SEEKER_ID,'name':$scope.SEEKER_NAME,'photo':$scope.SEEKER_PHOTO,'resume_name':$scope.SEEKER_RESUME_NAME,'resume_src':$scope.SEEKER_RESUME_SRC,'status':$scope.seekStatus,'comment':$scope.SEEKER_COMMENT,"commentSatus":status,'message':"",'openMessage':false,'change':false});
	}

	//change function
	$scope.showStatus=function(){
		if($scope.selectSeekerStatus){$scope.selectSeekerStatus=false;}
		else{$scope.selectSeekerStatus=true;}
	}
	$scope.changeStatusTo1=function(item){
		item.status=1;
		item.change=true;
	}
	$scope.changeStatusTo2=function(item){
		item.status=2;
		item.change=true;
	}
	$scope.changeStatusTo3=function(item){
		item.status=3;
		item.change=true;
	}
	$scope.changeStatusTo4=function(item){
		item.status=4;
		item.change=true;
	}

	//click function
	$scope.changeJobMode=function(item){
		$scope.selectSeeker=item.name;
		$scope.selectSeekerFilter=item.tag;
		$scope.selectSeekerStatus=false;
	}
	$scope.closeBG=function(){
		$scope.bg=false;
		$scope.peopleCheck=false;
		$scope.noOneCheck=false;
	}
	$scope.controlMessage=function(item){
		if(item.openMessage){item.openMessage=false;}
		else{item.openMessage=true;}
	}
	$scope.messageToSeeker=function(item){
		//email loading BG
		$scope.loading=true;
		//===============
		var messageObject={"method":"messageToSeeker","receiveId":item.id};
		$http({
			method:'POST',
			url:'server/checkSeekerAjax.php',
			data: $.param(messageObject),
			headers: {'Content-type': 'application/x-www-form-urlencoded'},
		}).
		success(function(json){
			//jump to message.php
			location.href='userMessage.php?action='+json.urlID;
		}).
		error(function(json){
			console.warn(json);
			$scope.skillErrorMess='發生不可預測的錯誤';
		});
	}

	//save data
	$scope.saveCheck=function(){
		$scope.countAccess=0;
		for(var i=0;i<$scope.seekers.length;i++){
			if($scope.seekers[i].status==4){$scope.countAccess++;}
		}
		if($scope.countAccess!=0){$scope.bg=true;$scope.peopleCheck=true;}
		else{$scope.bg=true;$scope.noOneCheck=true;}
	}
	$scope.sendComment=function(seeker){
		if(seeker.comment!=""){
			//email loading BG
			$scope.loading=true;
			//===============
			var commentObject={"method":"comment","seeker":seeker,"JOB_ID":$scope.JOB_ID};
			$http({
				method:'POST',
				url:'server/checkSeekerAjax.php',
				data: $.param(commentObject),
				headers: {'Content-type': 'application/x-www-form-urlencoded'},
			}).
			success(function(json){
				//email loading BG
				$scope.loading=false;
				//===============
				//console.log(json);
				seeker.commentSatus=true;
				//location.href='companyPost.php';
			}).
			error(function(json){
				console.warn(json);
				$scope.skillErrorMess='發生不可預測的錯誤';
			});
		}
	}
	$scope.save=function(){
		//email loading BG
		$scope.closeBG();
		$scope.loading=true;
		//===============
		var seekerObject={"method":"saveSeeker","seekers":$scope.seekers,"JOB_ID":$scope.JOB_ID};
		$http({
			method:'POST',
			url:'server/checkSeekerAjax.php',
			data: $.param(seekerObject),
			headers: {'Content-type': 'application/x-www-form-urlencoded'},
		}).
		success(function(json){
			//email loading BG
			$scope.loading=false;
			//===============
			console.log(json);
			location.href='companyPost.php';
		}).
		error(function(json){
			console.warn(json);
			$scope.skillErrorMess='發生不可預測的錯誤';
		});
	}


}]);