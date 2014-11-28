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

	}

	$scope.divskills=[{'name':'show'}];

	$scope.skills=[
		{'name':'PHP','isDelete':'false'},
		{'name':'JAVASCRIPT','isDelete':'false'},
		{'name':'HTML5','isDelete':'false'},
		{'name':'前端設計','isDelete':'false'},
	];

	$scope.allskills=[
		{'name':'PHP'},
		{'name':'Angular'},
		{'name':'WebServer'},
	];

	$scope.eduexps=[
		{'education':'碩士','start_edu':'2013','end_edu':'2014','school':'NCTU','marjor':'information'},
		{'education':'碩士','start_edu':'2013','end_edu':'2014','school':'NCTU','marjor':'information'},
	];

	$scope.newitem='';
	$scope.addskills = function(){
		if(this.newitem != ''){
			this.skills.push({name:this.newitem,isDelete:false});
			this.newitem='';
		}
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