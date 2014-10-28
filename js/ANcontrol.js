var TaoLou = angular.module('TaoLou',[]);

TaoLou.controller('TaoLouMenu',['$scope', function TaoLouMenu($scope){

	$scope.lists=[
		{'name':'首頁','url':'index.html'},
		{'name':'發現更多公司','url':'moreCompany.html'},
		{'name':'註冊','url':'login.html'},
		{'name':'登入','url':'login.html'}
	];
}]);