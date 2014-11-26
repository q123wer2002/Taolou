TaoLou.controller('Taolou_onlineCV',['$scope','$http',function onlineCV($scope,$http){
	
	$scope.phone=[
		{'phone':'886911400733'},
	];
	
	$scope.job_wish=[
		{'name':'Android',
		'type1':'y','type2':'y','type3':'y',
		'min_salary':'200000',
		'stock_option':'y',
		'loc':'Taiwan',
		'far_work':'y'},
	];

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

	$scope.edit = function(item) {
		item.editing=true;
	}
	$scope.save = function(item) {
		delete item.editing;
	}

	$scope.delete = function(item){
		item.isDelete=true;
	}
	$scope.reload = function() {
   		location.reload();
   	}

   	//選單的 Angular JS
   	$scope.educations=[
   		{'name':'博士','eduTag':'1'},
   		{'name':'碩士','eduTag':'2'},
   		{'name':'大專院校','eduTag':'3'},
   		{'name':'高中','eduTag':'4'},
   		{'name':'國中','eduTag':'5'},
   		{'name':'國小','eduTag':'6'},
   		{'name':'其他','eduTag':'7'},
	];
	$scope.jobStatus=[
   		{'name':'正在找工作','josTag':'1'},
   		{'name':'觀望中，有好工作可以考慮','jbsTag':'2'},
   		{'name':'目前不想換工作','jbsTag':'3'},
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
		$('.popEditProfileDiv').animate({bottom:'10%'},500);
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
});