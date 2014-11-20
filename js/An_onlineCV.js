TaoLou.controller('Taolou_onlineCV',['$scope','$http',function onlineCV($scope,$http){
	
	$scope.phone=[
		{'phone':'886911400733'},
	];
	
	$scope.job_wish=[
		{'name':'Android',
		'type1':'y','type2':'y','type3':'y',
		'min_salary':'200000',
		'stock_option':'y',
		'loc':'Taiwan',
		'far_work':'y'},
	];

	$scope.divskills=[{'name':'show'}];

	$scope.skills=[
		{'name':'PHP','isSelect':'false'},
		{'name':'JAVASCRIPT','isSelect':'false'},
		{'name':'HTML5','isSelect':'false'},
		{'name':'前端設計','isSelect':'false'},
	];

	$scope.newitem='';
	$scope.addskills = function(){
		if(this.newitem != ''){
			this.skills.push({name:this.newitem,isSelect:false});
			this.newitem='';
		}
	}

	$scope.edit = function(item) {
		item.editing=true;
	}
	$scope.save = function(item) {
		delete item.editing;
	}

	$scope.delete = function(item){
		item.isSelect=true;
	}
	$scope.reload = function() {
   		location.reload();
   	}


}]);