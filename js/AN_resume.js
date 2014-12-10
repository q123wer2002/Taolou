TaoLou.controller('Taolou_userResume',['$scope','$http',function userResume($scope,$http){

	$scope.userResumes=[];
	$scope.checkboxModeFun=function(item){
		if(item.intelligence){item.intelligence=false;}
		else{item.intelligence=true;}
	}
	$scope.selectSkillFun=function(item){
		if(item.selectSkill){item.selectSkill=false;}
		else{item.selectSkill=true;}
	}


	$scope.RESUME_INIT=function(){
		if($scope.RESUME_intelligence=='y'){$scope.intell=true;}
		else{$scope.intell=false;}

		if($scope.RESUME_type=="pdf"){$scope.figure="REPDF";}
		else if($scope.RESUME_type=="doc" || $scope.RESUME_type=="docx"){$scope.figure="REDOC";}
		else if($scope.RESUME_type=="txt"){$scope.figure="RETEXT";}
		else{$scope.figure="REX";}

		$scope.userResumes.push=({"name":$scope.RESUME_name,"type":$scope.figure,"skill":$scope.RESUME_skill,"intelligence":$scope.intell,"size":$scope.RESUME_size,"createDate":$scope.RESUME_createDate,"selectSkill":false});
	}

}]);

//一般的javascript

$(document).ready(function(){

	//點擊觸發上傳
	$('#clickUpload').click(function(){
		var el = document.getElementById("resumeUploadInput");
      	if (el) {el.click();}
	});
	//============

	//拖曳上傳
	$(function(){
		$('#file_dropupload').on('drop',function(e){ // 綁定drop到指定DOM上
			e.preventDefault(); //防止預設事件處理
			var files = e.originalEvent.dataTransfer.files; //取得drop的檔案
			var formData = new FormData(); 
			formData.append('foo',files[0]); // 這裡只抓所有拖曳檔案中的第一個檔案, files[0].size可取得檔案大小(byte)
			$.ajax({
			    url:"server/resumeAjax.php", // 這裡指定檔案處理的地方
			    data:formData,
			    type:'POST',
			    processData: false, //請務必指定, 否則jQuery會幫你處理檔案, 可能造成檔案編碼錯誤的問題
			    contentType: false, //同上
			    cache: false
			});
		});
	});
	//==============
});