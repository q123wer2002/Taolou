TaoLou.controller('Taolou_userResume',['$scope','$http',function userResume($scope,$http){

	$scope.userResumes=[];
	$scope.userResumesSkills=[];

	$scope.checkDelete=false;
	$scope.checkboxModeFun=function(item){
		var delResumeObject={"method":"checkboxIntellFun","resume":item};

		$http({
			method:'POST',
			url:'server/resumeAjax.php',
			data: $.param(delResumeObject),
			headers: {'Content-type': 'application/x-www-form-urlencoded'},
		}).
		success(function(json){
			console.log(json);
			if(item.intelligence){item.intelligence=false;}
			else{item.intelligence=true;}
		}).
		error(function(json){
			console.warn(json);
			$scope.jobError='發生不可預測的錯誤';
		});
	}
	$scope.selectSkillFun=function(item){
		if(item.selectSkill){item.selectSkill=false;}
		else{item.selectSkill=true;}
	}
	$scope.RESUME_INIT=function(){
		if($scope.RESUME_intelligence=='y'){$scope.intell=true;$scope.intelligenceName='開啟';}
		else{$scope.intell=false;$scope.intelligenceName='取消';}

		if($scope.RESUME_type=="pdf"){$scope.figure="REPDF";}
		else if($scope.RESUME_type=="doc" || $scope.RESUME_type=="docx"){$scope.figure="REDOC";}
		else if($scope.RESUME_type=="txt"){$scope.figure="RETEXT";}
		else{$scope.figure="REX";}

		$scope.RESUME_skill=$scope.RESUME_skill.split('|');
		$scope.userResumes.push({"id":$scope.RESUME_id,"name":$scope.RESUME_name,"type":$scope.figure,"skill":$scope.RESUME_skill,"intelligence":$scope.intell,"size":$scope.RESUME_size,"src":$scope.RESUME_src,"createDate":$scope.RESUME_createDate,"newSkill":'',"selectSkill":false,"checkBG":false,"checkDiv":false});
		//console.log($scope.userResumes);
	}
	$scope.RESUME_SYSSKILL_INIT=function(){
		$scope.SYSTEM_SKILL=$scope.SYSTEM_SKILL.split('|');
		//console.log($scope.SYSTEM_SKILL);
	}
	//add skill
	$scope.addSkill=function(resume,skillName){
		var index = resume.skill.indexOf(skillName);
		if(index!='-1'){$scope.errorMes='已經有此技能';}
		else{resume.skill.push(skillName);$scope.errorMes="";}
	}
	//remove skill
	$scope.remove=function(resume,skillName){
		var index = resume.skill.indexOf(skillName);
		if(index!='-1'){resume.skill.splice(index,1);}
		//console.log(index);
	}
	//add new skill
	$scope.newSkillFun=function(resume){
		if(resume.newSkill != ""){
			var index = $scope.SYSTEM_SKILL.indexOf(resume.newSkill);
			if(index!='-1'){$scope.errorMes='已經有此技能';}
			else{
				var addSkillObject={"method":"addNewSkill","skill":resume.newSkill};
				$http({
					method:'POST',
					url:'server/resumeAjax.php',
					data: $.param(addSkillObject),
					headers: {'Content-type': 'application/x-www-form-urlencoded'},
				}).
				success(function(json){
					resume.skill.push(resume.newSkill);
					$scope.errorMes='';
					resume.newSkill='';
					console.log(json);
					//location.reload();
				}).
				error(function(json){
					console.warn(json);
					$scope.errorMes='發生不可預測的錯誤';
				});
			}
		}else{$scope.errorMes='未填入技能';}
	}
	//save skills
	$scope.save=function(resume){
		var skillObject={"method":"saveResumeSkill","resume":resume};
		$http({
			method:'POST',
			url:'server/resumeAjax.php',
			data: $.param(skillObject),
			headers: {'Content-type': 'application/x-www-form-urlencoded'},
		}).
		success(function(json){
			//console.log(json);
			$scope.selectSkillFun(resume);
			//location.reload();
		}).
		error(function(json){
			console.warn(json);
			$scope.errorMes='發生不可預測的錯誤';
		});
	}
	//delete
	$scope.showDelete=function(item){
		item.checkBG=true;
		item.checkDiv=true;
	}
	$scope.closeBG=function(item){
		item.checkBG=false;
		item.checkDiv=false;
	}
	$scope.delete=function(item){
		var delResumeObject={"method":"deleteResume","resume":item};
		
		$http({
			method:'POST',
			url:'server/resumeAjax.php',
			data: $.param(delResumeObject),
			headers: {'Content-type': 'application/x-www-form-urlencoded'},
		}).
		success(function(json){
			console.log(json);
			location.reload();
		}).
		error(function(json){
			console.warn(json);
			$scope.jobError='發生不可預測的錯誤';
		});
	}

	//upload resume

	//init
	
		//點擊觸發上傳
	jQuery('#clickUpload').click(function(){
		var el = document.getElementById("resumeUploadInput");
      	if (el) {el.click();}
	});
		//============

	//手動上傳檔案
	$scope.handleFiles=function(element){
		if (!element.files.length) {} 
		else {
			var file = element.files[0];

			//console.log(file);
			//style='background:#73AE1F;'
			document.getElementById("uploadContent").innerHTML=file['name'];
			//+"<br><a href='javascript:;' id='clickUpload'><span class='hand'>選擇其他履歷</span></a><script>var el = document.getElementById('resumeUploadInput');if(el){el.click();}</script>";
			jQuery('#uploadBtn').css({'background':'#73AE1F'}).attr({'href':'javascript:handleFiles();'});
		}
	}



}]);

//一般的javascript

$(document).ready(function(){


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

function handleFiles() {
	var files=document.getElementById('resumeUploadInput').files;
	if (!files.length) {} 
	else {
		var file = files[0];
	//check file type
		var ext = file.name.split('.').pop();
		if(ext=='doc'|| ext=='docx'||ext=='pdf' ||ext=='txt'){
			//start upload file
			var form_data = new FormData();
			form_data.append("file", file);
			form_data.append("method", "uploadResume");

			//console.log(file);
			$.ajax({
				type: "POST",
				url: "server/resumeAjax.php",
				data: form_data,
				processData: false,
		        contentType: false,
				error: function (json){console.warn(json);},
				success: function (json) {
					console.log(json);
					location.href="userResume.php";
					/*var reader = new FileReader();
					reader.readAsDataURL(file);
					reader.onload = function(e){
						$('#companyPhoto').attr('src', e.target.result);
						$(".changeOK").animate({'top':'0px'},500).delay(1500).animate({'top':'-200px'},500);
					}*/
				}
			});
		}else{
			alert('檔案格式錯誤');
			location.reload();
		}
	}
}

