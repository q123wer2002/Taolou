TaoLou.controller('Taolou_Message',['$scope','$http',function message($scope,$http){
	
	$scope.messageArea="";
	
	$scope.sendMessage=function(){
		if($scope.messageArea == ""){$scope.Error="請輸入訊息";}
		else{
			$scope.Error="";

			var MessageObject={"method":"message","reveicer":$scope.receiver,"messagecontent":$scope.messageArea};
			
			$http({
				method:'POST',
				url:'server/messageAjax.php',
				data: $.param(MessageObject),
				headers: {'Content-type': 'application/x-www-form-urlencoded'},
			}).
			success(function(json){
				console.log(json);
				$scope.messageArea="";
				location.reload();
			}).
			error(function(json){
				console.warn(json);
			});
		}
	
	}
}]);