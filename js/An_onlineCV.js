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
		{'name':'PHP','isDelete':'false'},
		{'name':'JAVASCRIPT','isDelete':'false'},
		{'name':'HTML5','isDelete':'false'},
		{'name':'前端設計','isDelete':'false'},
	];

	$scope.allskills=[
		{'name':'PHP'},
		{'name':'Angular'},
		{'name':'WebServer'},
	];

	$scope.eduexps=[
		{'education':'碩士','start_edu':'2013','end_edu':'2014','school':'NCTU','marjor':'information'},
		{'education':'碩士','start_edu':'2013','end_edu':'2014','school':'NCTU','marjor':'information'},
	];

	$scope.newitem='';
	$scope.addskills = function(){
		if(this.newitem != ''){
			this.skills.push({name:this.newitem,isDelete:false});
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
		item.isDelete=true;
	}
	$scope.reload = function() {
   		location.reload();
   	}


}]);