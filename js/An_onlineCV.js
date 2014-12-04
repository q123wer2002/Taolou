TaoLou.controller('Taolou_onlineCV',['$scope','$http',function onlineCV($scope,$http){
	
	$scope.phone=[
		{'phone':''},
	];

	//編輯,儲存手機
	$scope.editphone = function(item) {
		item.editing=true;
	}
	$scope.savephone = function(item) {
		delete item.editing;
		var userProfileObject={"method":"savePhone","phone":$scope.phone[0].phone};
		$http({
			method:'POST',
			url:'server/onlineCVAjax.php',
			data: $.param(userProfileObject),
			headers: {'Content-type': 'application/x-www-form-urlencoded'},
		}).
		success(function(json){
			console.log(json);
		}).
		error(function(json){
			console.warn(json);
		});
	}
	
	//求職願望 setting
	$scope.addjobwishB=false;
	$scope.addjobwish=function(){$scope.addjobwishB=true;$scope.lcoationSplit();}
	$scope.closejobwish=function(){$scope.addjobwishB=false;}
	$scope.JobTypes=[
		{'name':'全職','status':''},
		{'name':'兼職','status':''},
		{'name':'實習','status':''},
	];
	$scope.lcoationSplit=function(){
		$scope.locations=$scope.jobwish_loc.split('|');
	}
	$scope.addloca=function(locname){
		var index = $scope.locations.indexOf(locname);
		if(index!='-1'){$scope.errorMes='已經有此地區';}
		else{this.locations.push(locname);$scope.errorMes="";}
	}
	$scope.deleteloca=function(locname){
		var index = $scope.locations.indexOf(locname);
		if(index!='-1'){this.locations.splice(index,1);}
	}
	$scope.newaddloca=function(){
		if($scope.newLoca != ""){
			var newLocaObject={"method":"newLoca","location":$scope.newLoca};
			$http({
				method:'POST',
				url:'server/onlineCVAjax.php',
				data: $.param(newLocaObject),
				headers: {'Content-type': 'application/x-www-form-urlencoded'},
			}).
			success(function(json){
				if(json.message == 'error'){
					$scope.errorMes='已經有此地區';
				}
				else{
					$scope.locanums = json.locaid;
					$scope.locations.push($scope.newLoca);
					$scope.newLoca="";
					$scope.errorMes="";
				}
			}).
			error(function(json){
				console.warn(json);
			});
		}
	}
		//save
	$scope.save_jobwish=function(){
		if($scope.jobwish_name==""){$scope.errorMess="請填入職位名稱";}
		else if($scope.jobwish_min_salary==""){$scope.errorMess="請填入最低薪水";}
		else if($scope.locations==""){$scope.errorMess="請選擇工作地點";}
		else{
			$scope.errorMess="";
			var jobWishObject={"method":"jobwish","name":$scope.jobwish_name,"jobType":$scope.JobTypes,"leastSalary":$scope.jobwish_min_salary,"stock_option":$scope.jobwish_stock_option,"location":$scope.locations,"telework":$scope.jobwish_telework};
			$http({
				method:'POST',
				url:'server/onlineCVAjax.php',
				data: $.param(jobWishObject),
				headers: {'Content-type': 'application/x-www-form-urlencoded'},
			}).
			success(function(json){
				console.log(json);
				if(json.first=="success"){$scope.reload();}
			}).
			error(function(json){
				console.warn(json);
			});
		}
	}

	//特蘇技能 setting
	$scope.showSpecial=false;
	$scope.showSpecialFun=function(){
		if($scope.showSpecial){$scope.showSpecial=false;}
		else{$scope.showSpecial=true;}
	}
	$scope.skillListInit=function(){
		$scope.myskills=$scope.myallSkillList.split('|');
		$scope.allskills=$scope.allSkillList.split('|');
	}
	$scope.allskills=[];
	$scope.myskills=[];
	$scope.addskill=function(skill){
		var index = $scope.myskills.indexOf(skill);
		if(index!='-1'){$scope.skillErrorMess='你已經有此技能';}
		else{this.myskills.push(skill);$scope.skillErrorMess="";}
	}
	$scope.deleteskill=function(skill){
		var index = $scope.myskills.indexOf(skill);
		if(index!='-1'){this.myskills.splice(index,1);}
	}
	$scope.newaddskill=function(){
		if($scope.newskill != ""){
			var index = $scope.allskills.indexOf($scope.newskill);
			if(index == '-1'){
				var newSkillObject={"method":"newSkill","skill":$scope.newskill};
				$http({
					method:'POST',
					url:'server/onlineCVAjax.php',
					data: $.param(newSkillObject),
					headers: {'Content-type': 'application/x-www-form-urlencoded'},
				}).
				success(function(json){
					console.log(json);
					$scope.myskills.push($scope.newskill);
					$scope.allskills.push($scope.newskill);
					$scope.newskill="";
				}).
				error(function(json){
					console.warn(json);
					$scope.skillErrorMess='發生不可預測的錯誤';
				});
			}else{$scope.skillErrorMess='已經有此技能';}
		}else{$scope.skillErrorMess='未填入技能';}
	}
	$scope.saveSkill=function(){
		if($scope.myskills == ""){$scope.skillErrorMess="尚未填入你的技能";}
		else{
			$scope.skillErrorMess="";
			var mySkillObject={"method":"mySkill","skillList":$scope.myskills};
			$http({
				method:'POST',
				url:'server/onlineCVAjax.php',
				data: $.param(mySkillObject),
				headers: {'Content-type': 'application/x-www-form-urlencoded'},
			}).
			success(function(json){
				console.log(json);
				$scope.showSpecialFun();
			}).
			error(function(json){
				console.warn(json);
				$scope.skillErrorMess='發生不可預測的錯誤';
			});
		}
	}

	//教育 setting 一般按鍵function
	$scope.showEducation=false;
	$scope.showEducationFun=function(item){
		if(item.status){item.status=false;}
		else{item.status=true;}
	}
	$scope.showlastEducation=function(item){
		if(item.eduSelector){item.eduSelector=false;}
		else{item.eduSelector=true;}
	}
	$scope.showStartSelectoe=function(item){
		if(item.startSelector){item.startSelector=false;}
		else{item.startSelector=true;}
	}
	$scope.showEndSelector=function(item){
		if(item.endSelector){item.endSelector=false;}
		else{item.endSelector=true;}
	}
	$scope.settingEduc=function(saver,item){
		saver.education=item.name;
		$scope.showlastEducation(saver);
	}
	$scope.settingStart=function(saver,item){
		saver.start_edu=item;
		$scope.showStartSelectoe(saver);
	}
	$scope.settingEnd=function(saver,item){
		saver.end_edu=item;
		$scope.showEndSelector(saver);
	}
		//教育陣列
	$scope.eduexps=[
		//{'status':false,'eduSelector':false,'startSelector':false,'endSelector':false},
	];
		//初始化function
	$scope.initEducatinoFun=function(){
		this.eduexps.push({'id':$scope.EDU_ID,'education':$scope.EDU_eduBG,'start_edu':$scope.EDU_startEdu,'end_edu':$scope.EDU_endEdu,'school':$scope.EDU_school,'major':$scope.EDU_major,'status':false,'eduSelector':false,'startSelector':false,'endSelector':false});
	}
		//新增education Function
	$scope.addEducationFun=function(){
		var EducaObject={"method":"myAddEducation"};
		$http({
			method:'POST',
			url:'server/onlineCVAjax.php',
			data: $.param(EducaObject),
			headers: {'Content-type': 'application/x-www-form-urlencoded'},
		}).
		success(function(json){
			alert(json.Eduid);
			console.log(json.Eduid);
			$scope.eduexps.push({'id':json.Eduid,'education':'','start_edu':'','end_edu':'','school':'','major':'','status':true,'eduSelector':false,'startSelector':false,'endSelector':false});
		}).
		error(function(json){
			console.warn(json);
			$scope.eduErrorMes='發生不可預測的錯誤';
		});
	}
		//儲存edcation function
	$scope.saveEducaFun=function(item){
		if(item.education==''){$scope.eduErrorMes="學歷還沒有選填喔";}
		else if(item.start_edu==''){$scope.eduErrorMes="開始年份還沒有選填喔";}
		else if(item.end_edu==''){$scope.eduErrorMes="結束年份還沒有選填喔";}
		else if(item.start_edu>item.end_edu){$scope.eduErrorMes="開始與結束年份有填錯";}
		else if(item.school==''){$scope.eduErrorMes="學校還沒有填寫喔";}
		else if(item.major==''){$scope.eduErrorMes="主修還沒有填寫喔";}
		else{
			$scope.eduErrorMes="";
			var EducaObject={"method":"myEducation", "id":item.id, "educationBG":item.education, "startYear":item.start_edu, "endYear":item.end_edu, "school":item.school, "major":item.major};

			$http({
				method:'POST',
				url:'server/onlineCVAjax.php',
				data: $.param(EducaObject),
				headers: {'Content-type': 'application/x-www-form-urlencoded'},
			}).
			success(function(json){
				console.log(json);
				item.status=false;
			}).
			error(function(json){
				console.warn(json);
				$scope.eduErrorMes='發生不可預測的錯誤';
			});
		}
	}
		//刪除education function
	$scope.deleteEdu=function(item){
		var EducaObject={"method":"mydeleteEducation", "id":item.id};
		$http({
			method:'POST',
			url:'server/onlineCVAjax.php',
			data: $.param(EducaObject),
			headers: {'Content-type': 'application/x-www-form-urlencoded'},
		}).
		success(function(json){
			console.log(json);
			var index=$scope.eduexps.indexOf(item);
    		$scope.eduexps.splice(index,1);
		}).
		error(function(json){
			console.warn(json);
			$scope.eduErrorMes='發生不可預測的錯誤';
		});
	}


	$scope.delete = function(item){
		item.isDelete=true;
	}
	$scope.reload = function() {
   		location.reload();
   	}

   	//選單的 Angular JS
   	$scope.educations=[
   		{'name':'博士'},
   		{'name':'碩士'},
   		{'name':'大專院校'},
   		{'name':'高中'},
   		{'name':'國中'},
   		{'name':'國小'},
   		{'name':'其他'},
	];
	$scope.jobStatus=[
   		{'name':'正在找工作'},
   		{'name':'觀望中，有好工作可以考慮'},
   		{'name':'目前不想換工作'},
	];




}]);

TaoLou.filter('range', function() {

	return function(input, total) {
		total = parseInt(total);
	    for (var i=2014; i>(2014-total); i--)
	    	input.push(i);
	    return input;
	  };
});


//一般的Javascript
$(document).ready(function(){
	$('.editProfile').click(function(){
		$('.popEditProfileDiv').animate({bottom:'15%'},500);
	});
	$('.closePop').click(function(){
		$('.popEditProfileDiv').animate({bottom:'-100%'},500);
	});

	//點擊出現下拉選單
	$('#showYears').click(function(){
		$('#yearSelect').toggle('fast');
	});
	$('#showEducation').click(function(){
		$('#educationSelect').toggle('fast');
	});
	$('#showJobStatus').click(function(){
		$('#jobStatusSelect').toggle('fast');
	});

	//點擊下拉選單，出現值
	$('.yearsSelected').click(function(){
		var yearValue=$(this).data('value');
		$('#showYears input').val(yearValue);
		$('#yearSelect').toggle('fast');
	});
	$('.educationSelected').click(function(){
		var eduValue=$(this).data('value');
		$('#showEducation input').val(eduValue);
		$('#educationSelect').toggle('fast');
	});
	$('.jbsSelected').click(function(){
		var jbsValue=$(this).data('value');
		$('#showJobStatus input').val(jbsValue);
		$('#jobStatusSelect').toggle('fast');
	});

	//儲存到資料庫
	$('.pop_save').click(function(){
		var userName=$('#userName').val();
		var userBorn=$('#showYears input').val();
		var userEducation=$('#showEducation input').val();
		var userWorkyear=$('#userWorkyear').val();
		var userJobstatus=$('#showJobStatus input').val();
		connect_db_save(userName,userBorn,userEducation,userWorkyear,userJobstatus);
		$('.popEditProfileDiv').animate({bottom:'-100%'},500);
	});
});

//Ajax to save data  //save pop data
function connect_db_save(userName,userBorn,userEducation,userWorkyear,userJobstatus)
{
	//alert(userName+userBorn+userEducation+userWorkyear+userJobstatus);
	var now = new Date();
	var userProfileObject={"method":"saveUserProfile","userName":userName,"userBorn":userBorn,"userEducation":userEducation,"userWorkyear":userWorkyear,"userJobstatus":userJobstatus};
	$.ajax({
		type: "POST",
		url: "server/onlineCVAjax.php",
		data: $.param(userProfileObject),
		headers: {'Content-type': 'application/x-www-form-urlencoded'},
		async: true,
		error: function (xhr,error){console.warn(json);},
		success: function (json) {console.log(json);location.reload();}
	});
}