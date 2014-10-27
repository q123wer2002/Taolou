var KenChen = angular.module('KenChen',[]);

KenChen.controller('KenMenu',['$scope', function KenMenucontrol($scope){

	$scope.lists=[
		{'name':'會員專區','url':'login.html'},
		{'name':'聯絡我們','url':'contact.html'},
		{'name':'店家搜尋','url':'search.html'},
		{'name':'最新活動','url':'news.html'}
	];
}]);

KenChen.controller('KenStore',['$scope', function KenStorecontrol($scope){
	$scope.regions=[
		{'name':'全區','url':'all.html','regionTag':'1'},
		{'name':'台北基隆','url':'','regionTag':'2'},
		{'name':'新北','url':'','regionTag':'3'},
		{'name':'桃竹苗','url':'','regionTag':'4'},
		{'name':'中彰投','url':'','regionTag':'5'},
		{'name':'雲嘉南','url':'','regionTag':'6'},
		{'name':'高屏','url':'','regionTag':'7'},
		{'name':'宜花東','url':'','regionTag':'8'}
	];

	$scope.storeTypes=[
		{'name':'食','typeTag':'1'},
		{'name':'衣','typeTag':'2'},
		{'name':'住','typeTag':'3'},
		{'name':'行','typeTag':'4'},
		{'name':'育','typeTag':'5'},
		{'name':'樂','typeTag':'6'}
	];

	/*$scope.stores=[
		{'name':'大啊統滷味','regionTag':'2','typeTag':'1'},
		{'name':'大22滷味','regionTag':'4','typeTag':'3'}
	];*/
}]);