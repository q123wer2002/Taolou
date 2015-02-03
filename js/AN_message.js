TaoLou.controller('Taolou_Message',['$scope','$http','$location','$anchorScroll',function message($scope,$http,$location,$anchorScroll){

	$scope.messageArea="";
	$scope.messages=[];
	
	$scope.MESSAGEINIT=function(){
		if($scope.MESSAGE_LEFT){
			$scope.messages.push({"left":$scope.MESSAGE_LEFT,"right":"","time":$scope.MESSAGE_time});
		}
		else if($scope.MESSAGE_RIGHT){
			$scope.messages.push({"left":"","right":$scope.MESSAGE_RIGHT,"time":$scope.MESSAGE_time});
		}
		$scope.scrollDown($scope.MESSAGE_time); 
	}
	$scope.scrollDown=function(item){
		$location.hash(item);
		// call $anchorScroll()
		$anchorScroll();
	}
	$scope.sendMessage=function(){
		if($scope.messageArea == ""){$scope.Error="請輸入訊息";}
		else{
			$scope.Error="";
			//message to array
			$scope.messages.push({"left":"","right":$scope.messageArea,"time":"剛剛"});
			$scope.scrollDown("剛剛");
			//=================
			var message=$scope.messageArea;
			$scope.messageArea="";
			//save message
			var MessageObject={"method":"message","reveicer":$scope.receiver,"messagecontent":message};
			$http({
				method:'POST',
				url:'server/messageAjax.php',
				data: $.param(MessageObject),
				headers: {'Content-type': 'application/x-www-form-urlencoded'},
			}).
			success(function(json){
				console.log(json);
				//location.reload();
			}).
			error(function(json){
				console.warn(json);
			});
		}
	}

}]);