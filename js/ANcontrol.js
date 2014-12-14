var TaoLou = angular.module('TaoLou',[]);

TaoLou.controller('TaoLouMenu',['$scope','$http',function TaoLouMenu($scope,$http){

	$scope.lists=[
		{'name':'首頁','url':'index.php'},
		{'name':'主題公司','url':'topicCompany.php'},
		{'name':'職位','url':'jobs.php'},
		{'name':'註冊/登入','url':'account.php?action=login'}
	];

	$scope.memberLists=[
		{'name':'首頁','url':'index.php'},
		{'name':'主題公司','url':'topicCompany.php'},
		{'name':'職位','url':'jobs.php'},
		{'name':'簡歷','url':'userResume.php'},
		{'name':'求職管理','url':'jobManage.php'}
	];

	$scope.companyLists=[
		{'name':'首頁','url':'index.php'},
		{'name':'主題公司','url':'topicCompany.php'},
		{'name':'我的公司','url':'company.php'},
		{'name':'職位管理','url':'companyPost.php'},
	];


	$scope.searchText='';
	$scope.search=function(){
		if($scope.searchText != ""){
			var searchObject={'method':'search','keyword':$scope.searchText};
			$http({
				method:'POST',
				url:'server/ajax.php',
				data: $.param(searchObject),
				headers: {'Content-type': 'application/x-www-form-urlencoded'},
			}).
			success(function(json){
				console.log(json);
			}).
			error(function(json){
				console.warn(json);
			});
		}
	}
	
}]);


TaoLou.controller('TaoLoujob-index',['$scope', function TaoLoujobIndex($scope){

	$scope.hotJobs=[
		{'name':'全部','hotTag':'1'},
		{'name':'產品經理','hotTag':'2'},
		{'name':'前端工程師','hotTag':'3'},
		{'name':'後端工程師','hotTag':'4'},
		{'name':'iOS工程師','hotTag':'5'},
		{'name':'Android工程師','hotTag':'6'},
	];

	$scope.positions=[
		{'name':'全部','posTag':'1'},
		{'name':'北部','posTag':'2'},
		{'name':'中部','posTag':'3'},
		{'name':'南部','posTag':'4'},
		{'name':'東部','posTag':'5'},
		{'name':'外海','posTag':'6'}
	];

	$scope.jobTypes=[
		{'name':'全部','typeTag':'1'},
		{'name':'正職','typeTag':'2'},
		{'name':'兼職','typeTag':'3'},
		{'name':'實習','typeTag':'4'}
	];

	$scope.ranks=[
		{'name':'綜合排名'},
		{'name':'人氣'},
		{'name':'最新'}
	];

}]);