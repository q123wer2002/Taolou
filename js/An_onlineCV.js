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

	$scope.edit = function(item) {
		item.editing=true;
	}
	$scope.save = function(item) {
		delete item.editing;
	}
	$scope.reload = function() {
   		location.reload();
   	}


}]);