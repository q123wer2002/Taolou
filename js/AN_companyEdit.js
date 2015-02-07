TaoLou.controller('Taolou_companyEdit',['$scope','$http',function companyEdit($scope,$http){

	//init angular items
	$scope.companyPhoto="";
	$scope.ceoPhoto="";
	
	$scope.companyShortName="";
	$scope.companyName="";
	$scope.companyWebsite="";
	$scope.companyFB="";
	$scope.companyCreateYear="";
	$scope.companyCreateMonth="";
	$scope.companySize="";
	$scope.companyDetail="";
	$scope.companyCEO="";
	$scope.companyFinStage="";
	$scope.companyFinYear="";
	$scope.companyFinMonth="";

	$scope.CreateYearStatus=false;
	$scope.CreateMonthStatus=false;
	$scope.companySizeStatus=false;
	$scope.companyFinStageStatus=false;
	$scope.companyFinYearStatus=false;
	$scope.companyFinMonthStatus=false;



	//show deopList function
	$scope.showCreateYearFun=function(){
		if($scope.CreateYearStatus){$scope.CreateYearStatus=false;}
		else{$scope.CreateYearStatus=true;}
	}
	$scope.showCreateMonthFun=function(){
		if($scope.CreateMonthStatus){$scope.CreateMonthStatus=false;}
		else{$scope.CreateMonthStatus=true;}
	}
	$scope.showcompanySizeFun=function(){
		if($scope.companySizeStatus){$scope.companySizeStatus=false;}
		else{$scope.companySizeStatus=true;}
	}
	$scope.showcompanyFinStageFun=function(){
		if($scope.companyFinStageStatus){$scope.companyFinStageStatus=false;}
		else{$scope.companyFinStageStatus=true;}
	}
	$scope.showcompanyFinYearFun=function(){
		if($scope.companyFinYearStatus){$scope.companyFinYearStatus=false;}
		else{$scope.companyFinYearStatus=true;}
	}
	$scope.showcompanyFinMonthFun=function(){
		if($scope.companyFinMonthStatus){$scope.companyFinMonthStatus=false;}
		else{$scope.companyFinMonthStatus=true;}
	}


	//click dropList to save item to scope
	$scope.saveCreateYearFun=function(item){
		$scope.companyCreateYear=item+"年";
		$scope.CreateYearStatus=false;
	}
	$scope.saveCreateMonthFun=function(item){
		$scope.companyCreateMonth=item+"月";
		$scope.CreateMonthStatus=false;
	}
	$scope.savecompanySizeFun=function(item){
		$scope.companySize=item.name;
		$scope.companySizeStatus=false;
	}
	$scope.savecompanyFinStageFun=function(item){
		$scope.companyFinStage=item.name;
		$scope.companyFinStageStatus=false;
	}
	$scope.savecompanyFinYearFun=function(item){
		$scope.companyFinYear=item+"年";
		$scope.companyFinYearStatus=false;
	}
	$scope.saveompanyFinMonthFun=function(item){
		$scope.companyFinMonth=item+"月";
		$scope.companyFinMonthStatus=false;
	}





	//特蘇技能 setting
	$scope.myallSkillList="";
	$scope.allskills=[];
	$scope.myskills=[];
	$scope.showSpecial=false;
	$scope.showSpecialFun=function(){
		if($scope.showSpecial){$scope.showSpecial=false;}
		else{$scope.showSpecial=true;}
	}
	$scope.skillListInit=function(){
		$scope.allskills=$scope.allComSkill.split('|');
		$scope.myskills=$scope.myallSkillList.split('|');
	}
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
					url:'server/companyEditAjax.php',
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


	//dropList about companySize
	$scope.companySizes=[
		{'name':"10人以下"},
		{'name':"10~50人"},
		{'name':"50~200人"},
		{'name':"200~2000人"},
		{'name':"2000人以上"},
	];

	//dropList about companyFinance
	$scope.companyFins=[
		{'name':"已上市"},
		{'name':"已被收購"},
		{'name':"尚未融資"},
		{'name':"天使"},
		{'name':"A輪"},
		{'name':"B輪"},
		{'name':"C輪"},
		{'name':"D輪"},
		{'name':"E輪"},
		{'name':"F輪"},
		{'name':"F輪以後"},
		{'name':"其他"},
	];

	//save all data into company detail
	$scope.saveEditCompany=function(){
		if($scope.companyShortName==""){$scope.companyEditError="公司簡稱未填寫";}
		else if($scope.companyName==""){$scope.companyEditError="公司名稱未填寫";}
		else if($scope.companyWebsite==""){$scope.companyEditError="公司網址未填寫";}
		else if($scope.companySize==""){$scope.companyEditError="公司規模未選擇";}
		else if($scope.companyDetail==""){$scope.companyEditError="公司描述未填寫";}
		else if($scope.myskills==""){$scope.companyEditError="公司專長未選填";}
		else if($scope.companyCEO==""){$scope.companyEditError="公司CEO姓名未填寫";}
		else if($scope.companyCreateYear==""){$scope.companyEditError="公司創立年未選擇";}
		else if($scope.companyCreateMonth==""){$scope.companyEditError="公司創立月未選擇";}
		else if($scope.companyFinStage==""){$scope.companyEditError="公司融資階段未選擇";}
		else if($scope.companyFinYear==""){$scope.companyEditError="公司融資年份未選擇";}
		else if($scope.companyFinMonth==""){$scope.companyEditError="公司融資月未選擇";}
		else{
			var saveEditComObject={"method":"saveEditCom","companyShortName":$scope.companyShortName,"companyName":$scope.companyName,"website":$scope.companyWebsite,"companyFB":$scope.companyFB,"memberSize":$scope.companySize,"detail":$scope.companyDetail,"companySkill":$scope.myskills,"CEO":$scope.companyCEO,"companyCreateYear":$scope.companyCreateYear,"companyCreateMonth":$scope.companyCreateMonth,"stage":$scope.companyFinStage,"companyFinYear":$scope.companyFinYear,"companyFinMonth":$scope.companyFinMonth};
			$http({
				method:'POST',
				url:'server/companyEditAjax.php',
				data: $.param(saveEditComObject),
				headers: {'Content-type': 'application/x-www-form-urlencoded'},
			}).
			success(function(json){
				console.log(json);
				location.href="companies.php";
			}).
			error(function(json){
				console.warn(json);
				$scope.skillErrorMess='發生不可預測的錯誤';
			});
		}
	}

}]);

TaoLou.filter('range', function() {
	return function(input, total) {
		total = parseInt(total);
	    for (var i=2015; i>(2015-total); i--)
	    	input.push(i);
	    return input;
	  };
});


//一般的javascript
function handleFilesCom(files) {
  var d = document.getElementById('companyPhotoFile');
  if (!files.length) {} 
  else {
  	var file = files[0];
    //document.forms["userPhotoForm"].submit();
    var form_data = new FormData();
	form_data.append("file", file);
	form_data.append("method", "updateCompanyPhoto");

    $.ajax({
		type: "POST",
		url: "server/companyEditAjax.php",
		data: form_data,
		processData: false,
        contentType: false,
		error: function (json){console.warn(json);},
		success: function (json) {
			console.log(json);
			var reader = new FileReader();
			reader.readAsDataURL(file);
			reader.onload = function(e){
				$('#companyPhoto').attr('src', e.target.result);
				$(".changeOK").animate({'top':'0px'},500).delay(1500).animate({'top':'-200px'},500);
			}
		}
	});	
  }
}

function handleFilesCEO(files) {
  var d = document.getElementById('ceoPhotoFile');
  if (!files.length) {} 
  else {
  	var file = files[0];
    //document.forms["userPhotoForm"].submit();
    //console.log(file.size);
	var form_data = new FormData();
	form_data.append("file", file);
	form_data.append("method", "updateCEOPhoto");
	
	$.ajax({
		type: "POST",
		url: "server/companyEditAjax.php",
		data: form_data,
		processData: false,
        contentType: false,
        /*beforeSend:function(){
        	$(".loading").animate({'top':'0px'},500);
        },
        complete:function(){
        	$(".loading").animate({'top':'-200px'},500);
        },*/
		error: function (json){console.warn(json);},
		success: function (json) {
			console.log(json);
			var reader = new FileReader();
			reader.readAsDataURL(file);
			reader.onload = function(e){
				$('#ceoPhoto').attr('src', e.target.result);
				$(".changeOK").animate({'top':'0px'},500).delay(1500).animate({'top':'-200px'},500);
			}
		}
	});

  }
}



//一般 jquery
$(document).ready(function(){
	$('#updaetBut').click(function(){
		var ComPhoto = document.getElementById('companyPhotoFile');
		if (ComPhoto) {ComPhoto.click();}
	});

	$('#ceoupdaetBut').click(function(){
		var ceoPhoto = document.getElementById('ceoPhotoFile');
		if (ceoPhoto) {ceoPhoto.click();}
	});
	
	//地址顯示
	var countySel = $('#LOCATION_countySel').val();
	var districtSel = $('#LOCATION_districtSel').val();
	var css = [
            'county form-control',
            'district form-control',
            'zipcode form-control'
        ];

	$('#twzipcode').twzipcode({
		'countySel': countySel,
		'districtSel': districtSel,
		'css': css
	}).change(function(){
		var location = new FormData();
		var data = $('#twzipcode').twzipcode('serialize');

		location.append("method", "updateLocation");
		location.append("location",data);

		$.ajax({
			type: "POST",
			url: "server/companyEditAjax.php",
			data: location,
			processData: false,
	        contentType: false,
			error: function (json){console.warn(json);},
			success: function (json) {console.log(json);}
		});
	});

});