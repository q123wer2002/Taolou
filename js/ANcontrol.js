var TaoLou = angular.module('TaoLou',[]);

TaoLou.controller('TaoLouMenu',['$scope', function TaoLouMenu($scope){

	$scope.lists=[
		{'name':'首頁','url':'index.php'},
		{'name':'發現更多公司','url':'moreCompany.html'},
		{'name':'註冊','url':'login.html'},
		{'name':'登入','url':'login.html'}
	];
}]);

TaoLou.controller('TaoLoujob-index',['$scope', function TaoLoujobIndex($scope){

	$scope.hotJobs=[
		{'name':'全部','hotTag':'1'},
		{'name':'產品經理','hotTag':'2'},
		{'name':'前端工程師','hotTag':'3'},
		{'name':'後端工程師','hotTag':'4'},
		{'name':'iOS工程師','hotTag':'5'},
		{'name':'Android工程師','hotTag':'6'},
		{'name':'設計師','hotTag':'7'},
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

}]);