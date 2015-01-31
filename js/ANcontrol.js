var TaoLou = angular.module('TaoLou',[]);

TaoLou.controller('TaoLouMenu',['$scope','$http',function TaoLouMenu($scope,$http){

	$scope.lists=[
		{'name':'主題公司','url':'topicCompany.php'},
		{'name':'職缺','url':'jobs.php'},
		{'name':'註冊/登入','url':'account.php?action=login'}
	];

	$scope.memberLists=[
		{'name':'主題公司','url':'topicCompany.php'},
		{'name':'職缺','url':'jobs.php'},
		{'name':'簡歷','url':'userResume.php'},
		{'name':'求職管理','url':'jobManage.php'}
	];

	$scope.companyLists=[
		{'name':'職缺','url':'jobs.php'},
		{'name':'主題公司','url':'topicCompany.php'},
		{'name':'我的公司','url':'companies.php'},
		{'name':'職位管理','url':'companyPost.php'},
	];

	//search init
	$scope.searchText='';
	$scope.searchPlaceHolder='搜尋公司或職位';
	$scope.searchC=[];
	$scope.searchJ=[];

	$scope.companySearch=false;
	$scope.jobSearch=false;
	$scope.noSearch=false;

	//search click
	$scope.closeSearch=function(){
		$scope.companySearch=false;
		$scope.jobSearch=false;
		$scope.noSearch=false;
		$scope.searchC=[];
		$scope.searchJ=[];
	}

	//search function
	$scope.insertCompany=function(item){
		if(item.company){
			for(var i=0;i<item.company.length;i++){
				$scope.searchC.push({'name':item.company[i]['companyName'],'jobs':item.company_jobCOUNT[item.company[i]['id']]['jobcount'],'src':item.company_jobCOUNT[item.company[i]['id']]['src']});
			}
		}
	}
	$scope.insertJob=function(item){
		if(item.job){
			for(var i=0;i<item.job.length;i++){
				$scope.searchJ.push({'name':item.job[i]['jobName'],'company':item.job_companyName[item.job[i]['id']]['companyName'],'src':item.job_companyName[item.job[i]['id']]['src']});
			}
		}
	}

	//search function
	$scope.search=function(){
		if($scope.searchText != ""){
			$scope.closeSearch();
			var searchObject={'method':'search','keyword':$scope.searchText};
			$http({
				method:'POST',
				url:'server/ajax.php',
				data: $.param(searchObject),
				headers: {'Content-type': 'application/x-www-form-urlencoded'},
			}).
			success(function(json){
				//console.log(json);
				if(json.status=='company&job'){
					$scope.companySearch=true;
					$scope.jobSearch=true;
					//load function
					$scope.insertCompany(json);
					$scope.insertJob(json);
				}
				else if(json.status=='company'){
					$scope.companySearch=true;
					//load function
					$scope.insertCompany(json);
				}
				else if(json.status=='job'){
					$scope.jobSearch=true;
					//console.warn(json.job.length);
					//load function
					$scope.insertJob(json);
				}
				else{$scope.noSearch=true;}
			}).
			error(function(json){
				console.warn(json);
			});
		}
	}
	
}]);


TaoLou.controller('TaoLoujob-index',['$scope', function TaoLoujobIndex($scope){

	$scope.hotJobs=[
		{'name':'全部'},
		{'name':'產品經理'},
		{'name':'前端工程師'},
		{'name':'後端工程師'},
		{'name':'iOS工程師'},
		{'name':'Android工程師'},
	];

	$scope.positions=[
		{'name':'全部','number':1},
		{'name':'基隆','number':2},
		{'name':'台北','number':3},
		{'name':'新北','number':4},
		{'name':'宜蘭','number':5},
		{'name':'新竹','number':6},
		{'name':'桃園','number':7},
		{'name':'苗栗','number':8},
		{'name':'台中','number':9},
		{'name':'彰化','number':10},
		{'name':'南投','number':11},
		{'name':'嘉義','number':12},
		{'name':'雲林','number':13},
		{'name':'台南','number':14},
		{'name':'高雄','number':15},
		{'name':'屏東','number':16},
		{'name':'台東','number':17},
		{'name':'花蓮','number':18},
		{'name':'金門','number':19},
		{'name':'連江','number':20},
		{'name':'澎湖','number':21},
		{'name':'南海諸島','number':22},
		{'name':'海外','number':23},
	];

	$scope.jobTypes=[
		{'name':'全部','number':1},
		{'name':'全職','number':2},
		{'name':'兼職','number':3},
		{'name':'實習','number':4}
	];

	$scope.ranks=[
		{'name':'綜合排名'},
		{'name':'人氣'},
		{'name':'最新'}
	];

	//init 
	$scope.cityStatus=false;
	$scope.typeStatus=false;
	$scope.salaryStatus=false;

	//city Selector
	$scope.cityNumber=function(city){
		for(var i=0;i<$scope.positions.length;i++){
			if($scope.positions[i].name === city){$scope.cityNum=$scope.positions[i].number;}
		}
	}
	//jobtype Selector
	$scope.jobTypesNumber=function(type){
		for(var i=0;i<$scope.jobTypes.length;i++){
			if($scope.jobTypes[i].name === type){$scope.typeNum=$scope.jobTypes[i].number;}
		}
	}
	//salary INIT
	$scope.salaryINIT=function(){
		if($scope.salary != ""){
			var a=$scope.salary.split("%5B");
			//show a[0]=[low,high]
			
			//console.log(a[0]);
			var b=a[0].split(",")
			//console.log(b[1]);
			var c=b[0].split("[")
			//console.log(c[1]);
			var d=b[1].split("]")
			//console.log(d[0]);
			
			$scope.salaryLow=c[1];
			$scope.salaryHigh=d[0];
		}
	}
}]);

TaoLou.controller('TaoLou_mailValid',['$scope','$http', function mailValid($scope,$http){

	$scope.mailVlid='再寄一次認證信';

	//init
	$scope.mail="";

	$scope.mailStatus=false;

	//function
	$scope.checkEmail=function(){
		if($scope.mailStatus){$scope.mailStatus=false;}
		else{$scope.mailStatus=true;}
	}

	$scope.changeMail=function(){
		if($scope.mail==""){$scope.error="error";}
		else{
			var mailObject={'method':'changeMail','email':$scope.mail};

			$http({
				method:'POST',
				url:'server/ajax.php',
				data: $.param(mailObject),
				headers: {'Content-type': 'application/x-www-form-urlencoded'},
			}).
			success(function(json){
				console.log(json);
				$scope.mailStatus=false;
			}).
			error(function(json){
				console.warn(json);
			});
		}
	}

	$scope.reSendMail=function(){
		var mailObject={'method':'reSendMail','email':$scope.mail};
		$http({
			method:'POST',
			url:'server/ajax.php',
			data: $.param(mailObject),
			headers: {'Content-type': 'application/x-www-form-urlencoded'},
		}).
		success(function(json){
			console.log(json);
			location.href='index.php';
		}).
		error(function(json){
			console.warn(json);
		});
	}

	//company valid success
	$scope.validSuccess=function(){
		var successObject={'method':'validSuccess','name':$scope.name,'email':$scope.email,'companyName':$scope.companyName};
		$http({
			method:'POST',
			url:'server/ajax.php',
			data: $.param(successObject),
			headers: {'Content-type': 'application/x-www-form-urlencoded'},
		}).
		success(function(json){
			console.log(json);
			location.href='index.php';
		}).
		error(function(json){
			console.warn(json);
		});
	}
}]);


