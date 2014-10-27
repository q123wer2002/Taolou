var TaoLoo = angular.module('TaoLoo',[]);

TaoLoo.controller('TaoLooMenu',['$scope', function TaoLooMenu($scope){

	$scope.lists=[
		{'name':'會員專區','url':'login.html'},
		{'name':'聯絡我們','url':'contact.html'},
		{'name':'店家搜尋','url':'search.html'},
		{'name':'最新活動','url':'news.html'}
	];
}]);