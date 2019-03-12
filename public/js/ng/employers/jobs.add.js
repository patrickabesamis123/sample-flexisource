(function () {
	'use strict';
		var app = angular.module('app' );
		var base_url = $('body').data('base_url');


	function functiontofindIndexByKeyValue(arraytosearch, key, valuetosearch) {

		for (var i = 0; i < arraytosearch.length; i++) {

		    if (arraytosearch[i][key] == valuetosearch) {
		        return i;
		    }
		}
		return null;
	}

   	app.service('RequirementsToPreApply', function() {
	  var data = [];
	  var FromRequirements = function(newObj) {
	  	data.length = 0
	  	data.push(newObj);
	  };

	  var ToQuestions  = function(){
	      return data;
	  };

	  return {
	    FromRequirements: FromRequirements,
	    ToQuestions: ToQuestions
	  };
	});

	app.service('ReloadJobDetailsOnSlideSwitch', function() {
		var data = [];
		  var fromPreStep = function(newObj) {
		  	data.length = 0
		  	data.push(newObj);
		  };

		  var ToNewStep  = function(){
		      return data;
		  };

		  return {
		    fromPreStep: fromPreStep,
		    ToNewStep: ToNewStep
		  };
	})

	app.service('JobToTemplate', function() {
	  var data = [];
	  var FromJob = function(newObj) {
	  	data.length = 0
	  	data.push(newObj);
	  };

	  var ToTemplate  = function(){
	      return data;
	  };

	  return {
	    FromJob: FromJob,
	    ToTemplate: ToTemplate
	  };
	});

	app.controller('EmployerJobCreateStep0', ['GlobalConstant','$scope','$window','$http','$cookies','$filter', '$timeout', '$compile', function(GlobalConstant, $scope, $window, $http, $cookies,$filter, $timeout, $compile) {

		var token = $cookies.get('token');
		//Get saved templates
		$scope.templates = [];
	  	$http.get(GlobalConstant.EmployerRootApi + '/company/template/job')
	  	.then(function(response) {
			$scope.templates = response.data.data;
		});
		$scope.hideme = true;
		$( '.jobtype' ).on('change', function(){
			$scope.hideme = false;
		});
		$scope.jobtype = 1;
	  	//Submit step 0
	  	$scope.SubmitStep0 = function(){

			if (angular.isDefined($scope.selectedtemplate)  && $scope.selectedtemplate != null) {
				$cookies.put('loadTemplate', $scope.selectedtemplate.id, { 'path':'/'} );
				$window.location.href = base_url+'employer/job/add/employee';
			}else{
				alert('Please select a saved role templete.');
			}


	  	}

  		$scope.createRole = function() {
	  		$cookies.remove('step_pa', { 'path':'/'})	;
			$cookies.remove('step_sq', { 'path':'/'})	;
			$cookies.remove('JobId', { 'path':'/'})	;
			$cookies.remove('step2', { 'path':'/'})	;
			$cookies.remove('step3', { 'path':'/'})	;
			$cookies.remove('loadTemplate', { 'path':'/'});
			$window.location.href = base_url+'employer/job/add/employee';
	  	}
	}]);


	app.controller('EmployerJobCreate', ['GlobalConstant','RequirementsToPreApply','fileUploadService',   '$scope','$window','$http','$cookies','$filter','$location', '$anchorScroll', 'JobToTemplate', '$timeout', function(GlobalConstant,RequirementsToPreApply, fileUploadService, $scope, $window, $http, $cookies,$filter,$location, $anchorScroll, JobToTemplate, $timeout ) {

		//Variables
			// Check mobile agent
        	$scope.mobile_agent = (/android|webos|iphone|ipad|ipod|blackberry|iemobile|opera mini/i.test(navigator.userAgent.toLowerCase()));
        	$scope.token_id = $cookies.get('token_id');
        	$scope.token = $cookies.get('token');
			$scope.params = {access_token: $scope.token};

			if (angular.isDefined($scope.token)) {

			//Populate Working Day
			$scope.workdays = [
				{id: 1, display_name:"Monday", substrdays:"Mon"},
				{id: 2, display_name:"Tuesday", substrdays:"Tue"},
				{id: 3, display_name:"Wednesday", substrdays:"Wed"},
				{id: 4, display_name:"Thursday", substrdays:"Thu"},
				{id: 5, display_name:"Friday", substrdays:"Fri"},
				{id: 6, display_name:"Saturday", substrdays:"Sat"},
				{id: 0, display_name:"Sunday", substrdays:"Sun"}
			];
			$scope.selectedDays = {
			    data: [$scope.workdays[1]]
			 };

			//Populate Start Time
			$scope.ampm = [
				{text: 'am', value: 'am'},
				{text: 'pm', value: 'pm'}
			 ];

			$scope.start_time_list = [
				{ text: "1:00", value: "01:00"},
				{ text: "1:30", value: "01:30"},
				{ text: "2:00", value: "02:00"},
				{ text: "2:30", value: "02:30"},
				{ text: "3:00", value: "03:00"},
				{ text: "3:30", value: "03:30"},
				{ text: "4:00", value: "04:00"},
				{ text: "4:30", value: "04:30"},
				{ text: "5:00", value: "05:00"},
				{ text: "5:30", value: "05:30"},
				{ text: "6:00", value: "06:00"},
				{ text: "6:30", value: "06:30"},
				{ text: "7:00", value: "07:00"},
				{ text: "7:30", value: "07:30"},
				{ text: "8:00", value: "08:00"},
				{ text: "8:30", value: "08:30"},
				{ text: "9:00", value: "09:00"},
				{ text: "9:30", value: "09:30"},
				{ text: "10:00", value: "10:00"},
				{ text: "10:30", value: "10:30"},
				{ text: "11:00", value: "11:00"},
				{ text: "11:30", value: "11:30"},
				{ text: "12:00", value: "12:00"},
				{ text: "12:30", value: "12:30"},
			];

			$scope.end_time_list = [
				{ text: "1:00", value: "13:00"},
				{ text: "1:30", value: "13:30"},
				{ text: "2:00", value: "14:00"},
				{ text: "2:30", value: "14:30"},
				{ text: "3:00", value: "15:00"},
				{ text: "3:30", value: "15:30"},
				{ text: "4:00", value: "16:00"},
				{ text: "4:30", value: "16:30"},
				{ text: "5:00", value: "17:00"},
				{ text: "5:30", value: "17:30"},
				{ text: "6:00", value: "18:00"},
				{ text: "6:30", value: "18:30"},
				{ text: "7:00", value: "19:00"},
				{ text: "7:30", value: "19:30"},
				{ text: "8:00", value: "20:00"},
				{ text: "8:30", value: "20:30"},
				{ text: "9:00", value: "21:00"},
				{ text: "9:30", value: "21:30"},
				{ text: "10:00", value: "22:00"},
				{ text: "10:30", value: "22:30"},
				{ text: "11:00", value: "23:00"},
				{ text: "11:30", value: "23:30"},
				{ text: "12:00", value: "00:00"},
				{ text: "12:30", value: "00:30"},
			];

			//Set initial start time in am
			$scope.start_time_items = $scope.start_time_list;

			$scope.end_time_items = $scope.end_time_list;


			$scope.salaryType = [
				{ text: "Annual salary package", value: "Annual salary package"},
				{ text: "Annual & commission", value: "Annual & commission"},
				{ text: "Commission only", value: "Commission only"},

			];


			$scope.min_salary_list = [];
			//Populate min_salary field
			for (var i = 10000; i <= 200000; i += 5000) {
				var text  = i.toString();
				if (text.length <= 5) {
					var dataText = text.substring(0, 2)+'K'
				}else{
					var dataText = text.substring(0, 3)+'K'
				}
				var data = {text: dataText, value: i}
				$scope.min_salary_list.push(data);
			}



			$scope.max_salary_list = [ ];
			//Populate min_salary field
			for (var i = 15000; i <= 400000; i += 5000) {
				var text  = i.toString();
				if (text.length <= 5) {
					var dataText = text.substring(0, 2)+'K'
				}else{
					var dataText = text.substring(0, 3)+'K'
				}
				var data = {text: dataText, value: i}
				$scope.max_salary_list.push(data);
			}

			$scope.min_experience_list = [
				{text: "0", value: "0"},
				{text: "1", value: "1"},
				{text: "2", value: "2"},
				{text: "3", value: "3"},
				{text: "4", value: "4"},
				{text: "5", value: "5"},
				{text: "6", value: "6"},
				{text: "7", value: "7"},
				{text: "8", value: "8"},
				{text: "9", value: "9"},
				{text: "10", value: "10"},
			];

			$scope.max_experience_list = [];

			$scope.reasons = [
				{ text: "Growing Company", value: "Growing Company"},
				{ text: "New Role", value: "New Role"},
				{ text: "Replacement", value: "Replacement"},
				{ text: "Other", value: "Other"},
			];

			$scope.selectedDays.data = [];
			$scope.benefit = [];
			$scope.maxexp = true;

            //Other Details Section
            $scope.flexible_working =  'Yes'
            $scope.part_time = 'Yes'
            $scope.above_salary_band = 'Yes'
            $scope.high_potential_less_experience = 'Yes'



            $scope.uploadmsg = false;

            $scope.flexible = false;
        		//Variables

        		//Field Control


			//Get Countries

			$scope.disableLocation = true;


			$http.get(GlobalConstant.StaticOptionsApi+'/countries')
			.then(function(response){
				$scope.countries = response.data.data
				$scope.hidecounty = false
				if (angular.isDefined($scope.JobData)  ) {
					$scope.populateLocation( $scope.JobData.location.data );
				}
			});

			$scope.populateLocation = function( jobdata ){
				//populate dropdown field
				//console.log(jobdata)
				var selected_country = $filter('filter')($scope.countries, jobdata.country.id, true) ;
				var index =  functiontofindIndexByKeyValue($scope.countries, 'id', selected_country[0].id)

				$scope.country = $scope.countries[index];

				var splitme = jobdata.display_name.split(' ');
				var searchthis =  splitme[0].replace(/[^\w\s]/gi, '')

				$http.get(GlobalConstant.APIRoot+'static/autocomplete/location?q='+searchthis+'&country_id='+jobdata.country.id)
				.then(function(response){
					angular.forEach(response.data.data, function(val, key){
						//console.log(val.display_name)
						if (val.display_name === jobdata.display_name) {

							$scope.searchLocation = jobdata.display_name;
							$timeout(function(){
								$scope.LocationId = jobdata.id
							}, 100)

						}else{
							$scope.searchLocation = jobdata.display_name;
							$scope.LocationId = ''
						}
					})

				});
			}


			$scope.$watch('country', function(newVal, oldVal){

				//console.log(oldVal)
				if ( angular.isDefined(newVal) ) {
					$scope.searchLocation = ''

					if (angular.isDefined(oldVal) && newVal.id != oldVal.id ) {

						$scope.LocationId = newVal.id
					}
				 	$scope.disableLocation = false;

				}else{
					 //console.log('dsa')
					$scope.searchLocation = ''
					$scope.disableLocation = true;
				}
				if(!$('#autoDataLocation').is(':visible')){
	   		 			$('#autoDataLocation').hide( );
		   		 	}
			})

			var typingTimer;  //timer identifier
			var doneTypingInterval = 10;
			var idx = 0;
			$('#location').on('keyup', function (e) {

				$('#LocationId').val( null );
				if(e.which >= 37 && e.which <= 40 || e.which == 13){

					var li = $('#autoDataLocation li');

					if(li.length){

						if(e.which == 40){

							if(!li.hasClass('selected_filter')){
								li.removeClass('selected_filter');
								$('#autoDataLocation li:eq('+idx+')').addClass('selected_filter')

							}else{
								idx = $('#autoDataLocation li.selected_filter').prevAll().length + 1;
								$('#autoDataLocation li').removeClass('selected_filter');

								if($('#autoDataLocation li:eq('+idx+')').nextAll().length == 0){
									idx = li.length - 1;
								}

								$('#autoDataLocation li:eq('+idx+')').addClass('selected_filter')
							}
						}else if(e.which == 38) {
							if(li.hasClass('selected_filter')){
								idx--;
								idx = idx <= 0 ? 0 : idx;
								//console.log(idx)
								li.removeClass('selected_filter');
								$('#autoDataLocation li:eq('+idx+')').addClass('selected_filter')
							}
						}else if(e.which == 13) {
							var userOption = $('#autoDataLocation li:eq('+idx+')').find('a').text();
							$('#location').val(userOption);
							$('#autoDataLocation').addClass('ng-hide');
							idx = 0;
						}

					}

					return false;
				}
				  $timeout.cancel(typingTimer);
				  typingTimer =  $timeout($scope.doneTyping(), doneTypingInterval);
			});

			$scope.searchLocation = ''
			$scope.data  = ''
			$scope.getAutoCompleteData = function(data){

				$scope.data = data

				$scope.searchLocation = data.display_name;
				$scope.LocationId = data.id;
				if(!$('#autoDataLocation').is(':visible')){
   		 			$('#autoDataLocation').slideToggle('slow');
	   		 	}

	   		 	idx = 0;
			}

			$scope.$watch('searchLocation',function( newVal, oldVal ){
				if (newVal && $scope.data.display_name != newVal) {
					$scope.LocationId = null;
					//console.log('got triggered')
				}else{
					$scope.LocationId = $scope.data.id
				}
			});




			//user is "finished typing," do something
			$scope.doneTyping = function () {
			  	$scope.autoLocation = [];
			  	//console.log('done')
				$http.get(GlobalConstant.APIRoot+'static/autocomplete/location?q='+ $('#location').val()+'&country_id='+$scope.country.id )
				.then(function(response){


			   		$scope.autoLocation = response.data.data;

			   		if ($scope.autoLocation.length == 0) {
			   			$scope.autoLocation.push( {id: null, display_name: 'No result'})
			   		}

			   		$timeout(function(){
			   			if( angular.element( $('#autoDataLocation') ).is(':hidden') ){
   		 					angular.element($('#autoDataLocation')).slideToggle('slow');
	   		 			}

			   		}, 200)

				 });
			}

			angular.element($('body')).click(function(){

	            if (angular.element($('#autoDataLocation')).is(':visible')) {
	                angular.element(  $('#autoDataLocation') ).slideToggle()
	            }
	         })


			$('.min_experience').change(function(){
				$scope.max_experience_list = [];
				$scope.maxexp = false;
				var minexp = parseInt ( $(this).val() ) + 1 ;

				if (minexp  >= 11) {
					var value = {text: "10+", value: "10"}
					$scope.max_experience_list.push(value);
				}else{
					 for (var i=minexp;i<=10;i++){
					 		//console.log(i)
					 		if (i == 10) {
					 			var value = {text: '10+', value: i}
					 		}else{
					 			var value = {text: i, value: i}
					 		}
					 		$scope.max_experience_list.push(value);
				    }
				}
			});


			//Populate accountablities
			$scope.accountabilities = [];
			$scope.showemptyMsgaccountabilities = true;
			//Button for add new row accountabilities
			$scope.addNewAccountability = function() {
			    var newItemNo = $scope.accountabilities.length+1;
			    $scope.accountabilities.push( {id: newItemNo, type:'Primary' } );

			    if($scope.accountabilities.length == 0){
					$scope.showemptyMsgaccountabilities = true;
				}else{
					$scope.showemptyMsgaccountabilities = false;
				}
			};

			//Remove last row for accountabilities
			$scope.removeAccountability = function(data) {
	    		$scope.accountabilities.splice(data, 1);
		    	$scope.showemptyMsgaccountabilities = true;
			};


			//Populate Requirements
			$scope.requirements = [];
			$scope.showemptyMsg = true;
			//Button for add new row Requirements
			$scope.addNewRequirements = function() {
			    var newItemNo = $scope.requirements.length+1;
			    $scope.requirements.push( {id: newItemNo , type:'Primary' } );

			    if($scope.requirements.length == 0){
					$scope.showemptyMsg = true;
				}else{
					$scope.showemptyMsg = false;
				}
			};


			//Remove last row for Requirements
			$scope.removeRequirements = function(data) {
		    	$scope.requirements.splice(data, 1);
		    	$scope.showemptyMsg = true;
			};

			//Populate Benefits
			$scope.benefits = [];
			$scope.showemptyMsgbenefits = true;
			//Button for add new row Benefits
			$scope.addNewBenefits = function() {
			    var newItemNo = $scope.benefits.length+1;
			    $scope.benefits.push( {id: newItemNo, type: "Paid by Employer" } );
			     if($scope.benefits.length == 0){
					$scope.showemptyMsgbenefits = true;
				}else{
					$scope.showemptyMsgbenefits = false;
				}
			};

			//Remove last row for Benefits
			$scope.removeBenefits = function( data ) {
		    	$scope.benefits.splice(data, 1);
		    	$scope.showemptyMsgbenefits = true;
			};

			//Populate accountablities
			$scope.objectives = [ ];
			$scope.showemptyMsgobjectives = true;
			//Button for add new row accountabilities
			$scope.addNewObjective = function() {
			    var newItemNo = $scope.objectives.length+1;
			    $scope.objectives.push( {id: newItemNo } );
			     if($scope.objectives.length == 0){
					$scope.showemptyMsgobjectives = true;
				}else{
					$scope.showemptyMsgobjectives = false;
				}
			};

			//Remove last row for accountabilities
			$scope.removeObjective = function(data) {
			    $scope.objectives.splice(data, 1);
			    $scope.showemptyMsgobjectives = true;
			};


			$scope.hideregion   = true;
			$scope.hidecity 	= true;
			$scope.hidesuburb 	= true;
			$scope.loadcity 	= true;
			$scope.loadsuburb 	= true;
			$scope.hideroletype = true;

			$scope.preload = false;

			$scope.URLQS = $location.search();
			$scope.JobIsActive =  false

			////console.log('['+$scope.URLQS.id+']')

			$scope.autopopulateIndustry = function ( industry  ){
				//Selected Industry

				var selected_industry = $filter('filter')($scope.industries, industry.id ) ;

	   			angular.forEach( selected_industry, function(val, key) {
     				var index =  $scope.industries.indexOf( val );
     				 $scope.selectedIndustry = $scope.industries[index];
				 });
			}

	 		//Populate data from first submit
			if (  angular.isDefined( $scope.URLQS.id  ) && $scope.URLQS.id   != '' &&  $scope.URLQS.id != true  ){

				$scope.maxexp = false;
				//  GET API VALUE OF JOB ID
				$scope.JobData = [];

				$.ajax({
					url : GlobalConstant.EmployerAddJob+'/'+$scope.URLQS.id,
					method : 'get',
					headers : {Authorization: "Bearer "+$cookies.get('token')} ,
					async : false,
					success : function(response) {
						$scope.JobData = response.data;
						$scope.preload = true;
						//console.log($scope.preload)
					}
				});


			}
			//Populate field if template is loaded
			else if( angular.isDefined($cookies.get('loadTemplate') )   && angular.isUndefined($scope.URLQS.id) ){
				//get template data

					$.ajax({
						url : GlobalConstant.EmployerRootApi + '/company/template/job/'+$cookies.get('loadTemplate'),
						method : 'get',
						headers : {Authorization: "Bearer "+$cookies.get('token')},
						async : false,
						success : function(response) {
							$scope.JobData = response.data.template_data;
							$scope.preload = true;
							//console.log('template loaded')
						}
					});

			}else{

				//Set Initial Value for checkboxes and radio
				$scope.selectedDays.data  = [1,2,3,4,5];
				$scope.lead_selected 	  =  'Yes';
				$scope.preload = true;
			}
			//($scope.JobData)
			//Field Control
			if (angular.isDefined($scope.JobData)  ) {

					if ($scope.JobData.job_status == 'active') {
						$scope.JobIsActive =  true
					}else{
						$scope.JobIsActive =  false
					}

					//Populate fields from result
				    $scope.job_title 		= $scope.JobData.job_title;
					$scope.selectedDays.data  = $scope.JobData.working_days;
					$scope.lead_manage_team 	= $scope.JobData.job_meta.lead_manage_team;

					//console.log($scope.JobData)
					if ($scope.JobData.accountabilities.length != 0) {

						$scope.accountabilities = [];

						angular.forEach($scope.JobData.accountabilities, function(val, key){
							var value = {"id": val.id, "name": val.name,  "type": val.type_display_name}
							$scope.accountabilities.push(value)
						});

					}

					if ($scope.JobData.requirements.length != 0) {
						$scope.requirements = [];
						angular.forEach($scope.JobData.requirements, function(val, key){
							var value = {"id": val.id, "name": val.name,  "type": val.type_display_name}
							$scope.requirements.push(value)
						});

					}

					if ($scope.JobData.benefits.length != 0) {
						$scope.benefits = []
						angular.forEach($scope.JobData.benefits, function(val, key){
							var value = {"id": val.id, "name": val.name,  "type": val.type_display_name}
							$scope.benefits.push(value)

						});
					}

					if ($scope.JobData.objectives.length != 0) {
						$scope.objectives = 	$scope.JobData.objectives;
					}

					$scope.job_description = $scope.JobData.job_description
					//min exp
						var selected_min_experience_list = $filter('filter')($scope.min_experience_list, {value:  $scope.JobData.min_experience.toString( ) } , true ) ;
						angular.forEach( selected_min_experience_list, function(val, key) {
							var index =  $scope.min_experience_list.indexOf( val );
							$scope.min_experience = $scope.min_experience_list[index];
						});
					if ($scope.min_experience != null || angular.isUndefined($scope.min_experience) == false) {


						var getminexp = parseInt( $scope.min_experience.value);
						for (var i=getminexp; i<=10; i++){

						 	if (i == 10) {
						 		var value = {text: '10+', value: i}
						 	}else{
					 			var value = {text: i, value: i}
					 		}
					 		 $scope.max_experience_list.push(value);

				        	//$('.max_experience').append($('<option></option>').val(i).html(i))
				   	 	}

					    //max exp
					    var selected_max_experience_list = $filter('filter')($scope.max_experience_list, {value: $scope.JobData.max_experience}, true ) ;
					    //console.log(selected_max_experience_list)
			    		angular.forEach( selected_max_experience_list, function(val, key) {
							var index =  $scope.max_experience_list.indexOf( val );
							$scope.max_experience = $scope.max_experience_list[index];
						});
					}

					//Select Min Salary on load for PUT Method
					var selected_min_salary = $filter('filter')($scope.min_salary_list, {value: $scope.JobData.min_salary}, true  ) ;
					angular.forEach( selected_min_salary, function(val, key) {
						var index =  $scope.min_salary_list.indexOf( val );
						$scope.min_salary = $scope.min_salary_list[index];
					});

					//Select Max Salary on load for PUT Method
				    var selected_max_salary = $filter('filter')($scope.max_salary_list, {value: $scope.JobData.max_salary}, true  ) ;
					angular.forEach( selected_max_salary, function(val, key) {
						var index =  $scope.max_salary_list.indexOf( val );
						$scope.max_salary =  $scope.max_salary_list[index] ;
					});

					//Select Start Time on load for PUT Method
					var selected_start_time = $filter('filter')($scope.start_time_items, {value: $scope.JobData.start_time}  ) ;
					if(selected_start_time.length != 0){
						//Populate time if data is in AM
						angular.forEach( selected_start_time, function(val, key) {
							var index =  $scope.start_time_items.indexOf( val );
							$scope.start_time = $scope.start_time_items[index];
							$scope.start_ampm = $scope.ampm[0]
						});
					}else{
						//Populate time if data is in PM
						var selected_start_time_if_pm = $filter('filter')($scope.end_time_items, {value: $scope.JobData.start_time}  ) ;

						angular.forEach( selected_start_time_if_pm, function(val, key) {
							var index =  $scope.end_time_items.indexOf( val );

							$scope.start_ampm = $scope.ampm[1]
						});

						if ($scope.JobData.start_time != null ) {
							var filter_end_time = $filter('filter')($scope.end_time_items, {value: $scope.JobData.start_time} , true ) ;
							var selected_hour_field = $filter('filter')($scope.start_time_items, {text: filter_end_time[0].text} , true )
							var index_hour = $scope.start_time_items.indexOf( selected_hour_field[0] );

							$scope.start_time = $scope.start_time_items[index_hour];
						}

					}

					//Select Finish Time on load for PUT Method
					var selected_finish_time = $filter('filter')($scope.end_time_items, {value: $scope.JobData.finish_time} ) ;

					if(selected_finish_time.length != 0){
					 	//Populate time if data is in PM
			    		angular.forEach( selected_finish_time, function(val, key) {
							var index =  $scope.end_time_items.indexOf( val );
							$scope.end_ampm = $scope.ampm[1]
						});

						var filter_end_time = $filter('filter')($scope.end_time_items, {value: $scope.JobData.finish_time} , true ) ;
						var selected_hour_field = $filter('filter')($scope.start_time_items, {text: filter_end_time[0].text} , true )
						var index_hour = $scope.start_time_items.indexOf( selected_hour_field[0] );

						$scope.finish_time = $scope.start_time_items[index_hour];

					}else{
						//Populate time if data is in AM
						var selected_end_time_if_am = $filter('filter')($scope.start_time_items, {value: $scope.JobData.finish_time}  ) ;

						angular.forEach( selected_end_time_if_am, function(val, key) {
							var index =  $scope.start_time_items.indexOf( val );
							$scope.finish_time = $scope.start_time_items[index];
							$scope.end_ampm = $scope.ampm[0]
						});
					}


					//Select Reason on load for PUT method
					var selected_reason = $filter('filter')($scope.reasons, {value: $scope.JobData.job_meta.job_reason} ) ;
					angular.forEach( selected_reason, function(val, key) {
						var index =  $scope.reasons.indexOf( val );
						$scope.job_reason = $scope.reasons[index];
					});
					$scope.lead_selected =  $scope.JobData.job_meta.lead_manage_team;

					if ($scope.JobData.is_salary_public == false) {
						$scope.publish_salary = '0'
					}else if ($scope.JobData.is_salary_public == true) {
						$scope.publish_salary = '1'
					}


					//Other Details
					angular.forEach($scope.JobData.search_helpers, function (value, key) {
						switch( value.name ){
							case 'Flexible Working' :
								$scope.flexible_working =  value.type_display_name
								break;
							case 'Part Time':
								 $scope.part_time = value.type_display_name
							 	break;
							case 'Going above salary band' :
							 	$scope.above_salary_band = value.type_display_name
								break;
							case 'Someone with high potential / less experience' :
								$scope.high_potential_less_experience = value.type_display_name
								break;
						}
					})

					//Populate flexible
					$scope.flexible = $scope.JobData.flexible_hours;
					if ($scope.JobData.flexible_hours == true) {

						angular.element( $('.disableTime') ).attr('disabled', 'true');

					}

					var selected_salary_type = $filter('filter')($scope.salaryType, {value: $scope.JobData.salary_type} ) ;
					angular.forEach( selected_salary_type, function(val, key) {
						var index =  $scope.salaryType.indexOf( val );

						$scope.salary_type = $scope.salaryType[index];
					});

					$scope.salary_notes = $scope.JobData.salary_notes

			}



			//Populate Pre apply question
			$scope.passDataToQuestion = function(currObj){
			        RequirementsToPreApply.FromRequirements(currObj);
			};

    		$scope.$watch('requirements', function(newVal, oldVal) {

	    			$scope.data = []
	    			angular.forEach(newVal, function(val, key){
	    				if ( angular.isDefined(val.name)) {
	    					$scope.data.push(val.name)

	    				}
	    			})

    				$scope.passDataToQuestion( $scope.data )
			}, true);





			//Get Role Type
		  	$scope.roleTypes = [];
		  	$scope.role_type = []
		  	$http.get(GlobalConstant.StaticOptionsApi + '/work_type').then(function(response) {
				$scope.roleTypes = response.data.data;
				$scope.hideroletype = false;

				if (angular.isDefined($scope.JobData)  ) {
					var FoundRole = $filter('filter')($scope.roleTypes, $scope.JobData.role_type ) ;

					angular.forEach( FoundRole, function(val, key) {
						var index =  $scope.roleTypes.indexOf( val );

					 	$scope.role_type = $scope.roleTypes[index];
					});
				}

			});



			//Get Industries
			$scope.industries = [];
			$http.get(GlobalConstant.StaticOptionIndustryApi).then(function(response){

			 	$scope.industries = 	response.data.data;
			 	if (angular.isDefined($scope.JobData)  ) {
				 	$scope.autopopulateIndustry($scope.JobData.industry.data.industry );
			 	}


			});





			//Sub industry
			$scope.hidesub = true;
			$scope.$watch('selectedIndustry', function (newval, oldval) {
				if (!angular.isUndefined(newval)) {

					$scope.SubIndustries = [];
					$http.get(GlobalConstant.APIRoot+'static/options/industries/sub/'+newval.id).then(function(response){
						$scope.hidesub = false;
					 	$scope.SubIndustries = 	response.data.data;

					 	////console.log($scope.SubIndustries);
					 	$scope.autopopulateSubIndustry = function ( subindustry  ){
							//Selected Sub Industry

							var selected_subindustry = $filter('filter')($scope.SubIndustries, subindustry.id ) ;

				   			angular.forEach( selected_subindustry, function(val, key) {
			     				var index =  $scope.SubIndustries.indexOf( val );
			     			//	//console.log( index ) ;
			     				$scope.selectedSubIndustry = $scope.SubIndustries[index];

							 });

						}
						if (angular.isDefined($scope.JobData)) {
							$scope.autopopulateSubIndustry($scope.JobData.industry.data.sub );
						}

					});
				}
			})


			//Disable Time Field
			$scope.$watch('flexible',function( newVal, oldVal ){
				if (newVal == true) {
					angular.element( $('.disableTime') ).attr('disabled', 'true')
				}else{
					angular.element( $('.disableTime') ).removeAttr('disabled' )
				}
			});



		//Field Control

				$scope.publishing = false;
				$scope.EmployeeAddJobStep1 = function ( isdraft ) {

					//Set location depends on location API
				  		if ($scope.LocationId != null) {
				  			//console.log('1')
							var newLocation = $scope.LocationId
						}else{
							//console.log('2')
							if ($scope.searchLocation != '') {
								var newLocation = {country_id: $scope.country.id, location: $scope.searchLocation }
								//console.log('2a')
							}else{
								//console.log('2b')
								var newLocation = $scope.country.id
							}

						}

						//console.log(newLocation)

						var preferred_location = newLocation

				  		//Data for Work Days
				  		var workDays_data = $scope.selectedDays.data;
			  			//Store Data to new array for the value to be submitted
				  		$scope.requirementsval = [];
						angular.forEach( $scope.requirements , function (value, key) {
							delete value.id;
							delete value.$$hashKey;
							$scope.requirementsval.push( value );
						});

						$scope.accountabilityval = [];
						angular.forEach( $scope.accountabilities , function (value, key) {
							delete value.id;
							delete value.$$hashKey;

							$scope.accountabilityval.push( value );

						});


				  		$scope.benefitsval = [];
						angular.forEach( $scope.benefits , function (value, key) {
							delete value.id;
							delete value.$$hashKey;
							$scope.benefitsval.push( value );
						});

						$scope.objectivesval = [];
						angular.forEach( $scope.objectives , function (value, key) {
							delete value.id;
							delete value.$$hashKey;
							$scope.objectivesval.push( value );
						});

						$scope.data_industry = function () {
							if (!angular.isUndefined( $scope.SubIndustries ) ) {
								return parseInt( $scope.selectedSubIndustry.id );
							}else{
								return parseInt( $scope.selectedIndustry.id );
							}
						}

						if ( angular.isDefined( $scope.start_time) && $scope.flexible != true ){
							$scope.StartTime = $scope.start_time.value +' '+ $scope.start_ampm.value;
						}else{
							$scope.StartTime = null
						}

						if (angular.isDefined( $scope.finish_time)  && $scope.flexible != true ){
							$scope.FinishTime = $scope.finish_time.value +' '+ $scope.end_ampm.value;
						}else{
							$scope.FinishTime = null
						}

						//publish salary
						var publishSalary = Boolean( parseInt($scope.publish_salary) );

						if (publishSalary == false) {
							$scope.salary_notes = ''
						}
						$scope.AllData =  {
								"data":{
									        "job_title": $scope.job_title,
									        "role_type":$scope.role_type.id,
									        "working_days": workDays_data,
									        "min_salary": parseInt( $scope.min_salary.value ),
									        "max_salary": parseInt( $scope.max_salary.value ),
									        "start_time": $scope.StartTime,
									        "finish_time": $scope.FinishTime ,
									        "flexible_hours":$scope.flexible,
									        "industry": $scope.data_industry(),
									        "min_experience": parseInt( $scope.min_experience.value ),
									        "max_experience": parseInt( $scope.max_experience.value ),
									        "is_salary_public": publishSalary,
									        "location":preferred_location,
									        "lead_manage_team":Boolean( parseInt($scope.lead_manage_team) ),

									        "salary_type": $scope.salary_type.value,
									        "salary_notes": $scope.salary_notes,

									        "job_reason":$scope.job_reason.value,
									        "job_meta": {

										        },


									        "job_description":$scope.job_description,
									        "job_video_url":"",

									        "benefits": $scope.benefitsval ,
									        "requirements":$scope.requirementsval ,
									        "accountabilities":$scope.accountabilityval,
									        "objectives": $scope.objectivesval,
									        "search_helpers":{
									            "flexible_working":$scope.flexible_working,
									            "part_time": $scope.part_time,
									            "above_salary_band":$scope.above_salary_band,
									            "high_potential_less_experience": $scope.high_potential_less_experience
									        },
									    }
									};
					 //console.log(  $scope.AllData  );
					 //return false
					 $scope.publishing = true;
					if ( angular.isUndefined( $scope.URLQS.id  ) || $scope.URLQS.id   == '' ||  $scope.URLQS.id == true      ) {

						//Use Post Method on first submit
					    	$http.post( GlobalConstant.EmployerAddJob,  $scope.AllData )
					    	.then(function(response) {
					    		//alert('update success');
					    		////console.log(response);
					    		var data = response.data.data
					    		 $scope.publishing = false;
					    		//If Draft go back to job page
					    		if (angular.isDefined(isdraft) && isdraft == 'draft') {
					    			alert('The current role has been saved as a draft. You will find it on the Company Roles tab of your Dashboard');
					    			//$window.location.href = base_url+'employer/jobs';
					    			$location.search('id', data.id);
					    			$location.search('draft', 1);
					    			$('.formstep2 .slideoverlay').addClass('enableslide');
					    		}else{
					    			//console.log(response)
						    		$location.search('id', data.id);
						    		//$cookies.put('JobId', data.id, { 'path':'/'} );
						    		 //console.log('firstsubmit not draft')
						    		$('.step2').trigger('click');
						    		$('.formstep2 .slideoverlay').addClass('enableslide');
						    		$scope.disableslide = false;
						    		$cookies.put('step2', 1, { 'path':'/'} );
					    		}

					    		 $scope.passDataTemplateName = function(currObj){
							        JobToTemplate.FromJob(currObj);
							    };

							    var date = new Date()
							    var data = $filter('date')(date, 'mediumDate' )

							    if (angular.isDefined($scope.JobData)) {
								    if (angular.isDefined($scope.JobData.location)) {
								    	var location = $scope.JobData.location.display_name
								    }else{
								    	var location = ''
								    }
							    }

							    $scope.passDataTemplateName( $scope.job_title + ' - '+ location + ' - '+ data )

					    		angular.element( $("html, body")).animate({ scrollTop: 0 }, 1000);



				    		////console.log(response);
						},  function(response) {
							$scope.loadsuburb 	= true;
							$scope.ErrorMsgs = response.data.errors;
				    		//console.log(response);
				    		//alert('some error');
				    	});


					}else{

						//Use PUT Method on after first submit
						$http.put( GlobalConstant.EmployerAddJob+'/'+$scope.URLQS.id, $scope.AllData )
						.then(function(response) {
					    		//alert('update success');
					    		////console.log(response);
					    		 $scope.publishing = false;
					    		 //console.log(angular.isDefined(isdraft))
					    		 //console.log(isdraft)
					    		if (angular.isDefined(isdraft) === true && isdraft === 'draft') {
					    			alert('The current role has been saved as a draft. You will find it on the Company Roles tab of your Dashboard');
					    			//$window.location.href = base_url+'employer/jobs';
					    			//console.log('put draft')
					    		}

					    		if( angular.isUndefined(isdraft) === true && isdraft !== 'draft'  ){
						    		 //console.log('update not draft')
						    		$('.step2').trigger('click');
						    		$cookies.put('step2', 1, { 'path':'/'} );
						    		$scope.disableslide = false;
						    	}


					    		angular.element( $("html, body")).animate({ scrollTop: 0 }, 1000);


						},  function(response) {
							$scope.loadsuburb 	= true;
							$scope.ErrorMsgs = response.data.errors;
				    		////console.log(response);
				    		//alert('some error');
				    	});

					}
				};
			}
	}]);

	app.controller('EmployerJobCreateStep2', ['GlobalConstant','RequirementsToPreApply','fileUploadService', 'ReloadJobDetailsOnSlideSwitch','$scope','$window','$http','$cookies','$filter', '$timeout', '$compile','$location', function(GlobalConstant,RequirementsToPreApply,fileUploadService,ReloadJobDetailsOnSlideSwitch, $scope, $window, $http, $cookies,$filter, $timeout, $compile,$location) {
			$scope.getJobIdonSlide = -1;
			$scope.getTemplateonSlide = -1;
			$scope.URLQS = $location.search();
			$scope.uploadvideo = 'No'
			$('.step2').on('click', function(){
				$scope.getJobIdonSlide = $scope.URLQS.id;
				$scope.getTemplateonSlide = $cookies.get('loadTemplate');

			});

			$scope.isSafari = Object.prototype.toString.call(window.HTMLElement).indexOf('Constructor') > 0;


			$scope.JobId = [];

	    	$scope.token = $cookies.get('token');

	    	if (angular.isDefined($scope.token)) {

					$scope.RequirementsList = {};

					$scope.RequirementsList.icebreaker_video = 'no';
					$scope.RequirementsList.portfolio ='no'   ;
					$scope.RequirementsList.about_me ='no'   ;
					$scope.RequirementsList.references = 'no';
					$scope.RequirementsList.education =  'no';
					$scope.RequirementsList.work_experience = 'no';
					$scope.RequirementsList.resume = 'no';

					$scope.req_1 	= 'no';
					$scope.req_2 = 'no'   ;
					$scope.req_3 ='no'   ;
					$scope.req_4 = 'no';
					$scope.req_5 =  'no';
					$scope.req_6 = 'no';
					$scope.req_7 = 'no';


				  // Video/Image Modal buttons
		            $scope.record_btn = false;
		            $scope.record_again_btn = false;
		            $scope.stop_btn = false;
		            $scope.save_btn = false;
		            $scope.change_btn = false;
		            // Video/Image Modal Sections
		            $scope.showSection1 = false;
		            $scope.showSection2 = true;
		            $scope.modal_percent = true;
		            // Modal drag drop images
		            $scope.ondragoverout_image = false;
		            $scope.ondragover_image = true;

		            $scope.uploadmsg = false;

		            $scope.showVideo = false
		            $scope.showUploadingVideo = false



					$scope.disableslide = true;

					//Activate slide on load
					if (  angular.isDefined( $scope.URLQS.id  ) && $scope.URLQS.id   != '' &&  $scope.URLQS.id != true  ){
							$scope.disableslide = false;
					}

					//On Slide Change
		            $('#carousel-example-generic').on('slid.bs.carousel', function() {


					//If Slide is step 2
					if( $('#TEstMe section.active').hasClass('formstep2') ){

						 //console.log( $scope.URLQS.id )	 ;
						 var getJobId = $scope.URLQS.id
						//Populate data If not template
						if (  angular.isDefined( $scope.URLQS.id  ) && $scope.URLQS.id   != '' &&  $scope.URLQS.id != true  ){

							$scope.disableslide = false;

							$.ajax({
			    			url : GlobalConstant.EmployerAddJob+'/'+getJobId,
			    			method : 'get',
			    			headers : {Authorization: "Bearer "+$cookies.get('token')} ,
			    			async : false,
			    			success : function(response) {
			    				$scope.JobData = response.data;
				    			}
				    		});

							//console.log('no Template')

							//Populate Pre-apply from step 1
							if ($scope.JobData.questions.pre_apply.length == 0 ) {
				    				 angular.forEach($scope.JobData.requirements, function(val, key){
				    					var data = {question: 'Do you have '+val.name+ '?'  }
				    					$scope.PreArrovalQuestions.push(data);
				    				})
				    				// $scope.PreArrovalQuestions = ;

				    				$scope.DataFromStep1 = RequirementsToPreApply.ToQuestions();
					    			$scope.$watchCollection('DataFromStep1', function(newVal, OldVal){


					    				//return false

					    				$scope.PreArrovalQuestions = [];

					    				if( $scope.JobData.job_meta )  {
						    				if ($scope.JobData.job_meta.lead_manage_team == 1) {

							    				$scope.PreArrovalQuestions.push({question: "Do you have any management experience?"});
							    				//console.log($scope.PreArrovalQuestions)
							    			}


						    			}

				    					angular.forEach(newVal[0], function(val, key){

					    				  	var data = {question: 'Do you have '+val+ '?'  }
					    				 	////console.log(data)
					    				  	$scope.PreArrovalQuestions.push(data);
					    				  })
									})
							}


						}
						//Populate field if template is loaded
						else if( angular.isDefined($cookies.get('loadTemplate') )   && angular.isUndefined($scope.URLQS.id) ){
							$scope.JobIsActive =  false


				    		$scope.JobParams = 'access_token='+$cookies.get('token') ;
				    		 $.ajax({
				    			url : GlobalConstant.EmployerRootApi + '/company/template/job/'+$cookies.get('loadTemplate'),
				    			method : 'get',
				    			headers : {Authorization: "Bearer "+$cookies.get('token')} ,
				    			async : false,
				    			success : function(response) {

								$scope.JobData = response.data.template_data;
								////console.log($scope.JobData ) ;
								//console.log('template')

			    				}
							});

						}
						//console.log($scope.JobData)


						//Load Data
						if (angular.isDefined ( $scope.JobData)) {


							 			if ($scope.JobData.questions.pre_apply.length != 0) {
					    					$scope.PreArrovalQuestions =[];
						    				angular.forEach($scope.JobData.questions.pre_apply, function(val, key){
						    					var data = {question: val.question , ideal_answer: val.ideal_answer  }
						    					$scope.PreArrovalQuestions.push(data);
						    					//console.log(data)

						    				})
					    				}

							 			if ($scope.JobData.job_status == 'active') {
											$scope.JobIsActive =  true
										}else{
											$scope.JobIsActive =  false
										}
										//console.log($scope.JobIsActive)

										////console.log($scope.PreArrovalQuestions)

					    			 	if ( $scope.JobData.job_meta.job_video && $scope.JobData.job_meta.job_video_url != '' ) {

						    				$scope.uploadvideo = 'Yes'

						    				if ($scope.JobData.job_meta.job_video_url != '') {
						    					$scope.showVideo = true;
						    					$scope.showUploadingVideo = false;


							    				var myPlayer = amp('vid1', {
										                                "techOrder": ["azureHtml5JS", "flashSS", "silverlightSS", "html5"],
										                                "nativeControlsForTouch": false,
										                                autoplay: false,
										                                controls: true,
										                                width: "275",
										                                logo: {"enabled": false},
										                                poster: ""
										                            }, function() {

										                            });



									                                myPlayer.src([{
									                                    src: $scope.JobData.job_meta.job_video_url,
									                                    type: "application/vnd.ms-sstr+xml"
									                                }]);



						    				}else{
						    					$scope.showVideo = false;
						    					$scope.showUploadingVideo = true
						    				}

						    				//console.log('video id, with url')


						    			}else if($scope.JobData.job_meta.job_video && $scope.JobData.job_meta.job_video_url == ''){
											//console.log('video id, no url')
						    				$scope.uploadvideo = 'Yes'
						    				$scope.showVideo = false;
						    				$scope.showUploadingVideo = true
						    			}

					    				//Populate reuirements slide
					    				if ( $scope.JobData.application_requirements.icebreaker_video != null || angular.isUndefined( $scope.JobData.application_requirements.icebreaker_video ) == false ){
											$scope.req_1 =  $scope.JobData.application_requirements.icebreaker_video;
										}else{
											$scope.req_1 =  'no';
										}

										if ( $scope.JobData.application_requirements.portfolio != null || angular.isUndefined( $scope.JobData.application_requirements.portfolio ) == false ){
											$scope.req_2 =  $scope.JobData.application_requirements.portfolio;
										}else{
											$scope.req_2 =  'no';
										}

										if ( $scope.JobData.application_requirements.about_me != null || angular.isUndefined( $scope.JobData.application_requirements.about_me ) == false ){
											$scope.req_3 =  $scope.JobData.application_requirements.about_me;
										}else{
											$scope.req_3 =  'no';
										}

										if ( $scope.JobData.application_requirements.references != null || angular.isUndefined( $scope.JobData.application_requirements.references ) == false ){
											$scope.req_4 =  $scope.JobData.application_requirements.references;
										}else{
											$scope.req_4 =  'no';
										}

										if ( $scope.JobData.application_requirements.education != null || angular.isUndefined( $scope.JobData.application_requirements.education ) == false ){
											$scope.req_5 =  $scope.JobData.application_requirements.education;
										}else{
											$scope.req_5 =  'no';
										}

										if ( $scope.JobData.application_requirements.work_experience != null || angular.isUndefined( $scope.JobData.application_requirements.work_experience ) == false ){
											$scope.req_6 =  $scope.JobData.application_requirements.work_experience;
										}else{
											$scope.req_6 =  'no';
										}

										if ( $scope.JobData.application_requirements.resume != null || angular.isUndefined( $scope.JobData.application_requirements.resume ) == false ){
											$scope.req_7 =  $scope.JobData.application_requirements.resume;
										}else{
											$scope.req_7 =  'no';
										}

					    				//Populate pre apply questions
										if ($scope.JobData.questions.pre_apply.length != 0) {
											$scope.PreArrovalQuestions = $scope.JobData.questions.pre_apply
							    		}

							    		//POpulate Standard questions
							    		if ($scope.JobData.questions.application.length != 0) {

							    			$scope.StandardQuestions = $scope.JobData.questions.application;

							    			angular.forEach ($scope.JobData.questions.application , function (val, key) {

												if (val.answer_type == "multiple_choice") {
													$timeout(function() {


								    					angular.forEach(val.answer_choices, function(opt_val, opt_key) {

								    						var html = '<div class="option_cont opt_'+opt_key+'" style="position:relative"> <input type="text" class="option"  value="'+opt_val+'" ng-disabled="JobIsActive"> <a class="remove btn pull-right" ng-click="removeOptions('+opt_key+')" ng-hide="JobIsActive">x</a> </div>';
								    						angular.element( $('.options'+val.id) ).append($compile(html)($scope));
								    						//$('.options'+val.id).append('<div style="position:relative"> <input type="text" class="option" ng-model="answer_choices" value="'+opt_val+'" ><a class="remove btn pull-right" ng-click="removeOptions( )">-</a> </div> ');
								    						$scope.showoptions = false;

								    						if($scope.StandardQuestions.length == 0){
																$scope.showemptyMsgStandardQuestions = true;
															}else{
																$scope.showemptyMsgStandardQuestions = false;
															}

								    					});
							    					}, 300 );

							    				};

							    			});
							    		}
						}

					}
					});
					//});


					/***** Video Modeal ****/

						// $('#video_upload_modal_new').change(function() {
						// 	// $scope.new_video_upload_modal('video_upload_modal_new');
						// 	 fileUploadService.videoUpload($scope, 'video_upload_modal_new');
						// 	  // $scope.videoCreateRole = true;
						// 	  $scope.makeDummyVideo();

						// })


						$('#video_upload_modal_new').change(function() {
                   			 $scope.new_video_upload_modal('video_upload_modal_new');
                		})

                		 $scope.new_video_upload_modal = function(file_elm, evt) {

                    		fileUploadService.video_upload($scope, file_elm, evt);
                		}


						$scope.makeDummyVideo = function() {
							var getQueryString = $location.search()
							var getJobId = getQueryString.id

							// Update video for dummy video url
								var videoData = {
											"data":{
											    "job_video":{
											        "doc_file_type":"mp4",
											        // "doc_url":"https://previewmedev.streaming.mediaservices.windows.net/c0d90bfc-1f1c-484c-be14-45852669128c/camera_120740530.ism/manifest",
											        "doc_url":"",
											        "doc_filename":"Some filename"
											    }
											}
									}

				                $http.put( GlobalConstant.EmployerAddJob +'/'+ getJobId , videoData )
				                .then(function(response) {
				                	// last id on cron db
									if($scope.last_id){
										delete $scope.last_id;
									}
				                },
				                function(response) {
				                    alert('error on video')
				                });

						}


						  var preview_new = document.getElementById('preview_new');
						   $scope.buttonsHideShow = function(a,b,c,d,e) {
					            $scope.record_btn = a;
					            $scope.record_again_btn = b;
					            $scope.stop_btn = c;
					            $scope.save_btn = d;
					            $scope.change_btn = e;
					        }

					         $scope.openVideoModal = function(doc_type){
					        	$scope.doc_type = doc_type; // just dummy doc_type, for ref. on cron db.

					        	var getQueryString = $location.search()
								var getJobId = getQueryString.id
					        	$scope.question_id = getQueryString.id
					        	$('#pmvCameraModalNew').modal('show');



					        }

					        $scope.sectionsHideShow = function(a,b) {
					            $scope.showSection1 = a;
					            $scope.showSection2 = b;
					        }

					        $scope.startVideo = function() {

				        	   if($scope.isSafari) {
		                        	// alert('Oh oh looks like your\'re using Safari! Use Chrome or Firefox to record a video using your webcam.');
		                        	alert('Oh oh this feature is not yet supported by your browser. Drag and drop a video file instead, or use Chrome, Firefox or Microsoft Edge to record a video using your webcam.');
		                    	}else{
		                         	fileUploadService.startVideo($scope);
		                    	}

					        }

					        $scope.recordVideo = function() {
					            fileUploadService.recordVideo($scope);
					        }

					        $scope.stopVideo = function() {
					            fileUploadService.stopVideo($scope);
					        }

					        $scope.saveVideo = function() {
					            fileUploadService.saveVideo($scope);
					            // $scope.videoCreateRole = true;
					             $scope.uploadmsg = true;
					             $scope.makeDummyVideo();
					         }

					        $scope.recordVideoAgain = function() {
					            $scope.buttonsHideShow(true,true,false,true,true)
					            $scope.recordVideo();
					        }



					        $scope.changeVideo = function() {

					          fileUploadService.changeVideo($scope);


					        }

				       		// camera modal on close event, force webcam to close if open
				            $('#pmvCameraModal, #pmvCameraModalNew, #pmvImageModalNew').on('hidden.bs.modal', function() {

				                if (window.stream) {
				                    stream.stop();
				                    window.stream = "";
				                }


				                $scope.buttonsHideShow(false,false,false,false,false);
				                $scope.sectionsHideShow(false,true);
				                // hide percentage
				                $scope.modal_percent = true;
				                // reset preview video
				                $('#preview_new').attr('src', '');
				                $('#preview_img_new').attr('src', '');
				            })
					/***** Video Modeal ****/
					//Add multiple Pre Approval Questions
						$scope.PreArrovalQuestionsOptions = [
							{id: 1, display_name:"yes"},
							{id: 2, display_name:"no"},
							{id: 3, display_name:"developing"},
						];

						//Populate PreArrovalQuestions
						$scope.PreArrovalQuestions = [];




						$scope.showemptyMsgPreArrovalQuestions = false;

						//Button for add new row PreArrovalQuestions
						$scope.addNewPreArrovalQuestions = function() {
							//$scope.PreArrovalQuestions.ideal_answer  = ["Yes"];//Set checkbox as default

						    var newItemNo = $scope.PreArrovalQuestions.length+1;
						    $scope.PreArrovalQuestions.push( {id: newItemNo, ideal_answer:["yes"] } );
						    if($scope.PreArrovalQuestions.length == 0){
								$scope.showemptyMsgPreArrovalQuestions = true;
							}else{
								$scope.showemptyMsgPreArrovalQuestions = false;
							}


						};

						//Remove last row for PreArrovalQuestions
						$scope.removePreArrovalQuestions = function( index ) {
					    	$scope.PreArrovalQuestions.splice(index, 1);

					    	if($scope.PreArrovalQuestions.length == 0){
								$scope.showemptyMsgPreArrovalQuestions = true;
							}else{
								$scope.showemptyMsgPreArrovalQuestions = false;
							}

						};

						$scope.CheckYes = function(data, box){
							if (box == 'developing') {
								if (angular.isDefined(data.ideal_answer)) {
								 var findYes = data.ideal_answer.indexOf('yes') ;
								 var findDev = data.ideal_answer.indexOf('developing') ;

								 //find if not developing is checked
								 if (findDev == -1) {
								 	if (findYes == -1) {
								 		//console.log(data.ideal_answer)
								 		data.ideal_answer.push('yes')
								 		data.ideal_answer.push('developing')
								 	}

								 }
								}else{
									data.ideal_answer = []
									data.ideal_answer.push('yes')
								 	data.ideal_answer.push('developing')
									//console.log('no ideal answer')
								}
							}

						}
					//END Add multiple Pre Approval Questions

					//Add multiple Standard Questions


						//Populate StandardQuestions
						$scope.StandardQuestions = [];

						$scope.showemptyMsgStandardQuestions = true;
						$scope.options = [{}];


						//Button for add new row StandardQuestions
						$scope.addNewStandardQuestions = function() {
							var newItemNo = $scope.StandardQuestions.length+1;
						    $scope.StandardQuestions.push( {id: newItemNo   } );
						    if($scope.StandardQuestions.length == 0){
								$scope.showemptyMsgStandardQuestions = true;
							}else{
								$scope.showemptyMsgStandardQuestions = false;
							}
						};

						//Remove last row for StandardQuestions
						$scope.removeStandardQuestions = function( index ) {

							$scope.StandardQuestions.splice(index, 1);

							if($scope.StandardQuestions.length == 0){
								$scope.showemptyMsgStandardQuestions = true;
							}else{
								$scope.showemptyMsgStandardQuestions = false;
							}
						};


						$scope.showoptions = true;

					    $scope.AddMoreOptions = function(id ) {

					    	var indexKey = $('.option_cont').length ;
					    	var html = '<div class="option_cont opt_'+indexKey+'" style="position:relative"> <input type="text" class="option" > <a class="remove btn pull-right" ng-click="removeOptions('+indexKey+')">x</a> </div>';


								angular.element( $('.options'+id) ).append($compile(html)($scope));
								$scope.showoptions = false;
						};


						$scope.removeOptions = function( index ) {
					    	var myEl = angular.element( document.querySelector( '.opt_'+index ) );
							myEl.remove();

					    	$scope.showemptyMsgaccountabilities = true;
						};
					//END Add multiple Standard Questions



 				$scope.LoadJobDataOnFirstLoad = function(){

					if (angular.isDefined($scope.JobData)) {


						if ($scope.JobData.questions) {
							//console.log($scope.JobData.questions.pre_apply)
							if ($scope.JobData.questions.pre_apply.length == 0 ) {
				    				 angular.forEach($scope.JobData.requirements, function(val, key){
				    					var data = {question: 'Do you have '+val.name+ '?'  }
				    					$scope.PreArrovalQuestions.push(data);
				    				})
				    				// $scope.PreArrovalQuestions = ;

				    				$scope.DataFromStep1 = RequirementsToPreApply.ToQuestions();
					    			$scope.$watchCollection('DataFromStep1', function(newVal, OldVal){


					    				//return false

					    				$scope.PreArrovalQuestions = [];

					    				if( $scope.JobData.job_meta )  {
						    				if ($scope.JobData.job_meta.lead_manage_team == 1) {

							    				$scope.PreArrovalQuestions.push({question: "Do you have any management experience?"});
							    				//console.log($scope.PreArrovalQuestions)
							    			}


						    			}

				    					angular.forEach(newVal[0], function(val, key){

					    				  	var data = {question: 'Do you have '+val+ '?'  }
					    				 	////console.log(data)
					    				  	$scope.PreArrovalQuestions.push(data);
					    				  })
									})
							}
				    	}
				   	}else{
				    		//If no jobD

				    		$http.get( GlobalConstant.EmployerAddJob+'/'+$scope.URLQS.id  )
							.then(function(response) {
								$scope.JobData = response.data.data
								if ($scope.JobData.questions.pre_apply.length == 0) {
				    				 angular.forEach($scope.JobData.requirements, function(val, key){
				    					var data = {question: 'Do you have '+val.name+ '?'  }
				    					$scope.PreArrovalQuestions.push(data);
				    				})
				    				// $scope.PreArrovalQuestions = ;

				    				$scope.DataFromStep1 = RequirementsToPreApply.ToQuestions();
					    			$scope.$watchCollection('DataFromStep1', function(newVal, OldVal){

					    				//console.log(newVal)

					    				$scope.PreArrovalQuestions = [];

					    				if ($scope.JobData.job_meta.lead_manage_team == 1) {

						    				$scope.PreArrovalQuestions.push({question: "Do you have any management experience?"});
						    				//console.log($scope.PreArrovalQuestions)
						    			}

				    					angular.forEach(newVal[0], function(val, key){

					    				  	var data = {question: 'Do you have '+val+ '?'  }
					    				 	//console.log(data)
					    				  	$scope.PreArrovalQuestions.push(data);
					    				  })
									})

				    			}else{

				    				 angular.forEach($scope.JobData.questions.pre_apply, function(val, key){
				    				 	//console.log(val)

				    					var data = {question: val.question , ideal_answer: val.ideal_answer  }
				    					$scope.PreArrovalQuestions.push(data);
				    				})
				    				//$scope.PreArrovalQuestions = ;
				    			}
							});

				    		//console.log('no job yet')
				    }
				}








	    	//Uploade referrence

	    	$scope.modal_percent_value = 0;

	    	 $scope.StandardQuestions.question_document = [{}]

	    	$scope.uploadReference = function ( index ) {
	    		$scope.fieldIndex = index ;
	    		  fileUploadService.openModal($scope, '.formstep2 #pmvFileModalNew', 'resume');
	    	}

	    	$("#file_upload").change(function() {
            // $scope.file_upload_modal(false,'Form_resume_upload_modal');
	            var elemId = $(this).attr('id');
	            var event = false;
	            var docFileType =  'resume';
	            var fileSizeLimit = 2;


	           fileUploadService.uploadFile($scope, elemId, event, docFileType, fileSizeLimit);

        	});

    		$scope.file_save = function(e) {
	            var elem = $(e.currentTarget);
	            fileUploadService.save($scope);



	             $scope.StandardQuestions[ $scope.fieldIndex ].question_document = [];
	            $scope.StandardQuestions[ $scope.fieldIndex ].question_document.doc_url =  $scope.return_data.url;
	            $scope.StandardQuestions[ $scope.fieldIndex ].question_document.doc_filename =  $scope.return_data.file_name;
	            // //console.log($scope.StandardQuestions[ $scope.fieldIndex ].question_document.doc_url)
	            // //console.log($scope.StandardQuestions[ $scope.fieldIndex ].question_document.doc_filename)
	        }

	     	$scope.file_change = function() {

	            fileUploadService.fileChange($scope);
	        }





			//Submit function step 2
			$scope.EmployeeAddJobStep2 = function ( isdraft ) {
				var getQueryString = $location.search()
				var getJobId = getQueryString.id

				if ($scope.JobData.job_status == 'active') {
					$cookies.put('step2', 1, { 'path':'/'} );
					$('.step3').trigger('click');
					return false
				}

				//Get all data for Standard question
				$scope.dataStandardQuestions = [];
				//console.log( $scope.StandardQuestions.length )
				if ( $scope.StandardQuestions.length  !=0 ) {
					angular.forEach($scope.StandardQuestions, function(value, key) {

						var id = value.id;
						var question = value.question;
						var answer_type = value.answer_type;

						$scope.multipleOption = []

						if (angular.isUndefined(getJobId) == false   && angular.isUndefined( $cookies.get('loadTemplate') ) == true ) {
							$('.options'+id).find('input:text').each(function () {
								$scope.multipleOption.push( $(this).val() );
							});

						}
						else if (angular.isUndefined(getJobId) == false    && angular.isUndefined( $cookies.get('loadTemplate') ) == false ) {
							$('.options').find('input:text').each(function () {
								$scope.multipleOption.push( $(this).val() );
							});

						}

						//console.log(value)
						if (   value.question_document )  {

							if (value.question_document.doc_url) {
								var doc_url  = value.question_document.doc_url
								var file_name = value.question_document.doc_filename;


								var filetype = file_name.split('.');
		 						var get_file_type =   filetype[filetype.length - 1] ;
							}else{
								var doc_url  = ''
								var file_name = ''
								var get_file_type =  ''
							}

							$scope.allStandarQuestionData = {
								question: question,
								answer_type: answer_type,
								answer_choices: $scope.multipleOption,
								question_document: [{
									doc_url: doc_url,
									doc_file_type: get_file_type,
									doc_filename: file_name,
								}]
							};


						}else{
							$scope.allStandarQuestionData = {
								question: question,
								answer_type: answer_type,
								answer_choices: $scope.multipleOption,

							};

						}

						if ($scope.multipleOption.length == 0) {
							delete $scope.allStandarQuestionData.answer_choices
						}


						$scope.dataStandardQuestions.push( $scope.allStandarQuestionData );
					});
				}


				//Get app data for pre approval questins

				$scope.dataPreApproval = [];
				if ($scope.PreArrovalQuestions.length != 0) {
					angular.forEach( $scope.PreArrovalQuestions , function (value, key) {
						delete value.id;
						delete value.$$hashKey;
						$scope.dataPreApproval.push( value );
					});
				}



				// Data to be submitted for requirements
				// //console.log($scope.RequirementsList)

				//  Data to be submitted to pre apply api
				// //console.log($scope.dataPreApproval)

				//  Data to be submitted Standard question
				// //console.log($scope.dataStandardQuestions)

				////console.log(getJobId)
				//return false





				//Show success msg
				$scope.requirements_mgs = false;
				if (getJobId != '' || getJobId != null) {

					var StepMethodPreApproval  	= $cookies.get('step_pa');
					var StepMethodStandardQuestion 	= $cookies.get('step_sq');

					//Submit Requirements ONLY USES PUT
					if ($scope.RequirementsList.length != null || $scope.RequirementsList.length != 'undefined') {
						$http.put( GlobalConstant.EmployerAddJob+'/'+getJobId+'/application-requirements',  {data: $scope.RequirementsList } )
						.then(function(response) {
					    		//alert('update success');
					    		////console.log(response);
					    		$scope.requirements_mgs = true;
					    		if (angular.isDefined(isdraft) && isdraft == 'draft') {
					    			 //console.log('submitted application requirements');


					    		}else{

						    		$cookies.put('step2', 1, { 'path':'/'} );
						    		$('.step3').trigger('click');
						    	}
						    	angular.element( $("html, body")).animate({ scrollTop: 0 }, 1000);

						},  function(response) {
							$scope.requirements_mgs = false;
							$scope.ErrorMsgs = response.data.message;
			    				alert($scope.ErrorMsgs);
				    		});
			    		}


					//Pre apply Question
					//if ($scope.dataPreApproval.length != 0) {

					 	var preApplyURL =  GlobalConstant.EmployerAddJob+'/'+getJobId+'/questions/pre-apply';
					 	var preApplyAllData = {data: $scope.dataPreApproval }
						if (angular.isDefined(getQueryString.draft) && getQueryString.draft == 1) {
							var pa_method1 = "PUT";
							$scope.preApply = $http.put(preApplyURL, preApplyAllData)
						}else{
							//console.log(StepMethodPreApproval)
							if (StepMethodPreApproval != 1) {
								var pa_method1 = "POST"
								$scope.preApply = $http.post(preApplyURL, preApplyAllData)
								$cookies.put('step2', 1, { 'path':'/'} );
								$cookies.put('step_pa', 1, { 'path':'/'} );
							}else{
								//Submit PUT
								var pa_method1 = "PUT";
								$scope.preApply = $http.put(preApplyURL, preApplyAllData)

							}
						}

						//console.log( pa_method1 ) ;
						//return false
						//Submit POST

					    	$scope.preApply.then(function(response) {
					    		//alert('update success');
					    		////console.log(response);
					    		//$scope.requirements_mgs = true;
					    		//console.log('pre approval')
					    		if (angular.isDefined(isdraft) && isdraft == 'draft') {
					    			   //console.log('submitted Pre approval questions');
					    			   alert('The current role has been saved as a draft. You will find it on the Company Roles tab of your Dashboard');
					    		}else{
					    			$('.step3').trigger('click');
					    		}
					    		angular.element( $("html, body")).animate({ scrollTop: 0 }, 1000);

						},  function(response) {
								$scope.requirements_mgs = false;
								$scope.ErrorMsgs = response.data.message;
				    			alert($scope.ErrorMsgs);
					    		////console.log(response);
					    		//alert('some error');
					    	});
					 //}
					//}


					//Submit Standard Questions
					//if ($scope.dataStandardQuestions.length != 0) {

 					var StandardQuestionURL = 	GlobalConstant.EmployerAddJob+'/'+getJobId+'/questions/application';
 					var StandaraQuestionAllData = {data: $scope.dataStandardQuestions }

					if (angular.isDefined(getQueryString.draft) && getQueryString.draft == 1) {
						var sq_method = "PUT";
						$scope.StandardQuestionMethod = $http.put(StandardQuestionURL, StandaraQuestionAllData).then(function(response) {
							//console.log(response);
							//console.log('test 1')
						})
					}else{


						if (StepMethodStandardQuestion != 1) {
							var sq_method = "post"
							$scope.StandardQuestionMethod = $http.post(StandardQuestionURL, StandaraQuestionAllData).then(function(response) {
							//console.log(response);
							//console.log('test2')
						})
							$cookies.put('step2', 1, { 'path':'/'} );
							$cookies.put('step_sq', 1, { 'path':'/'} );
						}else{
							//Submit PUT
							var sq_method = "put";
							$scope.StandardQuestionMethod = $http.put(StandardQuestionURL, StandaraQuestionAllData).then(function(response) {
							//console.log(response);
							//console.log('test 3')
						})
						}
					}





						//Submit POST
						$scope.StandardQuestionMethod.then(function(response) {

					    		 //$scope.requirements_mgs = true;
					    		if (angular.isDefined(isdraft) && isdraft == 'draft') {
					    			 //console.log('submitted Standard Questions');
					    			 //$scope.alertWhenDraft.push( 'Standard Questions' )
					    			 alert('The current role has been saved as a draft. You will find it on the Company Roles tab of your Dashboard');
					    			 $location.search('id', data.id);
					    			 $location.search('draft', 1)
					    			 //$window.location.href = base_url+'employer/jobs';
					    		}else{
					    			$('.step3').trigger('click');
					    		}
				    			angular.element( $("html, body")).animate({ scrollTop: 0 }, 1000);

						},  function(response) {
							$scope.requirements_mgs = false;
							$scope.ErrorMsgs = response.data.message;
				    			alert($scope.ErrorMsgs);

					    		////console.log(response);
					    		//alert('some error');
				    		});

						//Submit Pre approval questions.


				}else{
					//Go to step1 if no job id
					$('.step1').trigger('click');

				}
			}


		}
	}]);

	app.controller('EmployerJobCreateStep3',
		['GlobalConstant','$scope','$window','$http','$cookies','$filter', '$timeout', '$compile','$location', '$modal', '$log', 'JobToTemplate',
		function(GlobalConstant, $scope, $window, $http, $cookies,$filter, $timeout, $compile,$location, $modal, $log, JobToTemplate) {
			$scope.URLQS = $location.search();
			var getJobId = $scope.URLQS.id;
			$scope.disableslide = true;

			$scope.getJobIdonSlide = -1;
			$scope.getTemplateonSlide = -1;
			$('.step3').on('click', function(){

				$scope.getJobIdonSlide =  $scope.URLQS.id;
				$scope.getTemplateonSlide = $cookies.get('loadTemplate');

				var tempname = JobToTemplate.ToTemplate()
				if (tempname.length != 0) {
					$scope.savetemplate.name = JobToTemplate.ToTemplate();
				}


			});



			$scope.$watch ('getJobIdonSlide', function(newVal, oldVal) {


				if ( angular.isDefined(newVal) && newVal != -1  ) {
					$scope.disableslide = false;

					//Check if template is loaded
					if (angular.isUndefined(newVal) == false && angular.isUndefined( $cookies.get('step2') ) == true && angular.isUndefined( $scope.getJobIdonSlide ) == false ) {
						//get data from template

						if (angular.isDefined($cookies.get('loadTemplate'))) {
			    		 $.ajax({
			    			url : GlobalConstant.EmployerRootApi + '/company/template/job/'+$cookies.get('loadTemplate'),
			    			method : 'get',
			    			headers : {Authorization: "Bearer "+$cookies.get('token')} ,
			    			async : false,
			    			success : function(response) {

							$scope.JobData = response.data;


		    				}
						 });
			    		}
			    	}



			    }
			});

			//Populate fields with data

			if (angular.isDefined(getJobId) ) {
				$scope.disableslide = false;
			}


			$scope.SelectedMemberTeam = [];
			$scope.GetAllCompanyTeam = [];
			$scope.GetAllCompanyMember = [];
			$scope.savetemplate = {};
			$scope.savetemplate.save = false;
			$scope.selectedData =  {};
			$scope.selectedData.data = {};
			$scope.SelectedJobManager =  {};

			$scope.selectedflow = {};
			//$scope.selectedflow.id = [];

			//Generate data if template is loaded
			if (angular.isDefined(getJobId)     && angular.isDefined( $cookies.get('loadTemplate') ) ||  angular.isUndefined(getJobId)     && angular.isDefined( $cookies.get('loadTemplate') )  ) {
				$scope.JobParams = 'access_token='+$cookies.get('token') ;
		    		$.ajax({
		    			url : GlobalConstant.EmployerRootApi + '/company/template/job/'+$cookies.get('loadTemplate'),
		    			method : 'get',
		    			headers : {Authorization: "Bearer "+$cookies.get('token')} ,
		    			async : false,
		    			success : function(response) {
		    				$scope.JobData = response.data.template_data;
		    				$scope.selectedData.data = {};
		    			}
		    		});

		    	$scope.JobIsActive =  false


			}
			//Generate data if no template is generated and load draft data
			else if(angular.isDefined(getJobId)  && angular.isUndefined( $cookies.get('loadTemplate') )   ){

				$scope.JobParams = 'access_token='+$cookies.get('token') ;
		    		$.ajax({
		    			url : GlobalConstant.EmployerAddJob+'/'+$scope.URLQS.id,
		    			method : 'get',
		    			headers : {Authorization: "Bearer "+$cookies.get('token')} ,
		    			async : false,
		    			success : function(response) {
		    				$scope.JobData = response.data;
		    			}
		    		});

	    		if (angular.isDefined($scope.JobData )) {
	    		//$scope.savetemplate.name = $scope.JobData.job_title +' - '+$scope.JobData.role_type.display_name;
	    		$scope.date = new Date()
	    		 var data = $filter('date')($scope.date, 'mediumDate' )
	    		 //console.log(data)

	    		$scope.savetemplate.name = $scope.JobData.job_title +' - '+ $scope.JobData.location.data.display_name + ' - '+data;

	    		//Generate workflow step
	    		$scope.workflowSteps = $scope.JobData.workflow_steps
	    		if ($scope.JobData.job_status == 'active') {
					$scope.JobIsActive =  true
				}else{
					$scope.JobIsActive =  false
				}

 	    		//console.log($scope.workflowSteps)
 	    		}

			}




			//Get All Team List
			$http.get( GlobalConstant.APIRoot+'employer/company/team' )
				.then(function(response) {
			    		//alert('update success');
			    		////console.log(response);

			    		$scope.GetAllCompanyTeam = response.data.data;

			    		//Paginate list
						$scope.currentPageteam = 0;
					    $scope.pageSizeteam = 5;
					    $scope.searchteam = '';
					    $scope.nopageteam = false;
					    $scope.datateam = [];


					    $scope.getDatateam = function () {
					      return $filter('filter')($scope.GetAllCompanyTeam, $scope.searchteam)
					    }

					    $scope.numberOfPagesteam= function(){
					        return Math.ceil($scope.getDatateam().length/$scope.pageSizeteam);
					    }


					    $scope.nopageteam = true;
					    if ( isNaN( $scope.numberOfPagesteam() ) == false) {
					    	$scope.nopageteam = false;
					    }else{
							$scope.nopageteam = true;
					    }




					    ////console.log($scope.numberOfPagesteam());
					    for (var i=0; i<65; i++) {
					        $scope.datateam.push("Item "+i);
					    }


					  	if ($scope.JobData) {

				    		if ( $scope.JobData.visibility.teams.length != 0) {
				    			$scope.selectedData.data.team = [];
				    			$scope.selectedData.data.team = 	$scope.JobData.visibility.teams ;
				    		}else{
								$scope.selectedData.data.team = -1

				    		}
			    		}





					},  function(response) {
						$scope.requirements_mgs = false;
						$scope.ErrorMsgs = response.data.errors;
			    		////console.log(response);
			    		//alert('some error');
			});


			//Get All member List
			$http.get( GlobalConstant.APIRoot+'employer/company/member' )
				.then(function(response) {
		    		//alert('update success');
		    		////console.log(response);
		    		//$scope.requirements_mgs = true;
		    		$scope.GetAllCompanyMember = response.data.data;

		    		//Paginate list
					$scope.currentPage = 0;
				    $scope.pageSize = 10;
				    $scope.searchmember = '';
				    $scope.datamember = [];
				    $scope.getData = function () {
				      return $filter('filter')($scope.GetAllCompanyMember, $scope.searchmember)
				    }

				    $scope.numberOfPages=function(){
				        return Math.ceil($scope.getData().length/$scope.pageSize);
				    }

				    $scope.nopagemember = true;
				    if (isNaN( $scope.numberOfPages() ) == false  ) {
				    	$scope.nopagemember = false;
				    }else{
						$scope.nopagemember = true;
				    }

				    for (var i=0; i<65; i++) {
				        $scope.datamember.push("Item "+i);
				    }
				    //if template is loaded populate member data

			     	if ($scope.JobData) {
				    	if ($scope.JobData.visibility.members.length != 0 ) {

				    	 	$scope.selectedData.data.member = [];
				    	 	$scope.selectedData.data.member = $scope.JobData.visibility.members;
				    	}

				    	if (angular.isUndefined(  $scope.JobData.job_manager)  == false ||  $scope.JobData.job_manager != null) {
				    	  	$scope.SelectedJobManager = $scope.JobData.job_manager;
				    	}
			    	}



				},  function(response) {
					$scope.requirements_mgs = false;
					$scope.ErrorMsgs = response.data.errors;
		    		////console.log(response);
		    		//alert('some error');
			});


			$scope.RemoveTeamMember = function( id, type ){

				if (type == 'team') {
					if (id != -1) {
						//$scope.selectedData.data.team = -1;
						var index = $scope.selectedData.data.team.indexOf( id )

						$scope.selectedData.data.team.splice( index, 1 )
					}
				}else if( type == 'member'){
					var index = $scope.selectedData.data.member.indexOf( id )
					$scope.selectedData.data.member.splice( index, 1 )
					//console.log($scope.selectedData.data.member)
					//console.log(index)

				}else if( type == 'manager'){
					$scope.SelectedJobManager.id =  null
					// var index = $scope.selectedData.data.member.indexOf( id )
					// $scope.selectedData.data.member.splice( index )
					//console.log($scope.SelectedJobManager)

				}

			}

			//If DIV is visible it will be hidden and vice versa.
			$scope.IsVisible = false;
			$scope.ShowHide = function () {
                $scope.IsVisible = $scope.IsVisible ? false : true;
            }
            $scope.ShowHidemanager = function () {
                $scope.IsVisibleManager = $scope.IsVisibleManager ? false : true;
            }



			//Show modals
			$scope.showInviteModal = function () {


				var modalInstance = $modal.open({
				      templateUrl: 'inviteMember',
				      controller: 'MemberModalInstanceCtrl',
				      resolve: {
				        data: function () {
				          return $scope.data;

				        }
				      }
				    });

					//Process Modal Result
				    modalInstance.result.then(function (data) {

				      $scope.user = data;

				      if ($scope.user != null ) {
				    		$scope.GetAllCompanyMember.push($scope.user);
				    		//console.log( $scope.GetAllCompanyTeam )
				    		if (angular.isDefined($scope.selectedData.data) ) {
				    			//console.log('has data')
				    			if (angular.isUndefined($scope.selectedData.data.member) == false) {
				    				//console.log('has data, has member')
				    				$scope.selectedData.data.member.push($scope.user.id);

				    			}else{
				    				//console.log('has data, no member')
				    				$scope.selectedData.push({member:$scope.user.id} );

				    			}
				    		}else{
				    			//console.log('no data, no member');
				    			$scope.selectedData.data = {};
				    			$scope.selectedData.data.member =  [];
				    			$scope.selectedData.data.member.push( $scope.user.id  );
				    		}

				    		if ( $scope.buttons.chosen == 'addmore') {
				   				$scope.resetfields();
				   			}else{
				   				$('.triggerNext').trigger('click');
				   			}
				   		}else{
				   			////console.log(response.data.errors);

				   			//$scope.InvitedErrors.push(response.data.errors);
				   		}

				     }, function () {
				      $log.info('Modal dismissed at: ' + new Date());
				    });
				//$('#InviteTeamMember').modal('show');
			}

			$scope.showInviteManagerModal = function () {
				var modalInstance = $modal.open({
				      templateUrl: 'inviteManager',
				      controller: 'MemberModalInstanceCtrl',
				      resolve: {
				        data: function () {
				          return $scope.data;

				        }
				      }
				});

				//Process Modal Result
			    modalInstance.result.then(function (data) {
			      $scope.user = data;
			      //console.log( $scope.user )

		    		if ( $scope.user != null ) {
			    		$scope.GetAllCompanyMember.push( $scope.user);

			    		//Check if object has id key
			    		if (angular.isDefined($scope.SelectedJobManager.id)  ) {
			    			$scope.SelectedJobManager.id =  $scope.user.id ;
			    		}else{
			    			$scope.SelectedJobManager.id = {};
			    			$scope.SelectedJobManager.id =   $scope.user.id ;
						}


			   		}else{

			   			$scope.InvitedErrorsManager.push(response.data.errors);
			   		}

			     }, function () {
			      $log.info('Modal dismissed at: ' + new Date());
			    });
				//$('#InviteManager').modal('show');
			}




			$scope.buttons = { chosen: "" };
			//Get Employer details to obtain OB_KEY
			$http.get( GlobalConstant.APIRoot+'employer/profile'  )
			.then(function(response) {
		    		//alert('update success');
		    		////console.log(response);
		    		//$scope.requirements_mgs = true;
		    		var cont_key = response.data.data.azure_container_key;
		    		var azureContainer  =  cont_key.split('/')
		    		$cookies.put('ob_key', azureContainer[1], { 'path':'/'} );
		    		$cookies.put('cont_key', azureContainer[0], { 'path':'/'}  );
				},  function(response) {
					$scope.requirements_mgs = false;
					$scope.ErrorMsgs = response.data.errors;
		    		////console.log(response);
		    		//alert('some error');
			});

			//Upload image
			$scope.upload = function(FieldId, dataProgress, UploadMessage ) {
						var fileField = document.getElementById( FieldId );



						var file_data = fileField.files[0];
						////console.log(file_data);
						var allowed_files = ['jpg','jpeg','png'];
						var filename = file_data.name;
						var last_dot =	filename.lastIndexOf('.');
						var file_folder = 'image';


						var ext = 	filename.substr(last_dot + 1).toLowerCase();
							if(allowed_files.indexOf(ext) == -1){
								alert('Invalid file must be .jpg, .jpeg .png extension');
								return false;
							}

						var ob_key = $cookies.get('cont_key');
						var ob_key2 = $cookies.get('ob_key');
					    var form_data = new FormData();
					    	form_data.append('file', file_data);
					    	$scope.progressResumeValue = 0;

					    	if($( dataProgress ).hasClass('ng-hide')){
								$( dataProgress ).removeClass('ng-hide');
							}

						var params = '?ob_key='+ ob_key +'&ob_key2='+ ob_key2 +'&file_folder='+ file_folder;
					     $.ajax({
			                url: GlobalConstant.SimpleFileUpload + '/upload_submit' + params,
			                dataType: 'text',
			                cache: false,
			                contentType: false,
			                processData: false,
			                data: form_data,
			                type: 'post',
			                success: function(res){

			                	$scope.image_url = res;

			                	if(!$( dataProgress ).hasClass('ng-hide')){
			                   		$scope.progressResumeValue = 0;
			                   		  $( dataProgress ).addClass('ng-hide');
			                   		  fileField.value = '';
			                   	}

			                   	$( UploadMessage ).html('<img src="'+$scope.image_url+'"   class="img-responsive" >' );

			                },
			                beforeSend : function() {
			                	$( UploadMessage ).html('uploading to server please wait...');
			                },
			                 xhr: function() {
						        var xhr = new window.XMLHttpRequest();
						        xhr.upload.addEventListener("progress", function(evt) {
						            if (evt.lengthComputable) {
						            	 var percentComplete = Math.ceil((evt.loaded / evt.total) * 100);

						                 $scope.progressResumeValue = percentComplete;
						              ////console.log( $scope.progressResumeValue);
						            }
						       }, false);

						       // xhr.addEventListener("progress", function(evt) {
						       //     if (evt.lengthComputable) {
						       //         var percentComplete = evt.loaded / evt.total;
						       //         //Do something with download progress
						       //          ////console.log('here');
						       //          ////console.log(percentComplete);
						       //     }
						       // }, false);

						       return xhr;
						    },


			     		});
			}

			$("#Form_my_file2").change(function() {
			   $scope.upload('Form_my_file2', '#data_progress2', '#file_upload_msg2');
			});

			$scope.submitting = false;
			//Invite Member Form
			$scope.InviteMembers = function () {



				$scope.submitting = true;
				var formData = {};
				// get user input from the form
				$('#InviteMemberForm').serializeArray().map(function(item) {
					formData[item.name] = item.value;
				});




				$scope.InvitedMembers = [];
				$scope.InvitedErrors = [];
				$http.post(  GlobalConstant.EmployerRegisterMember , {data: formData})
			    	.then(function(response) {
			    		//alert('update success');
			    		////console.log(response)
			    		$scope.submitting = false;
			    		$scope.hideme = false;
			    		if (response.data.data != null ) {
				    		$scope.InvitedMembers.push(formData);

				    		if (angular.isUndefined($scope.selectedData.data) == false) {
				    			////console.log('has data')
				    			if (angular.isUndefined($scope.selectedData.data.member) == false) {
				    				////console.log('has data, has member')
				    				$scope.selectedData.data.member.push(response.data.data.id);

				    			}else{
				    				////console.log('has data, no member')
				    				$scope.selectedData.push({member:response.data.data.id} );

				    			}
				    		}else{
				    			////console.log('no data, no member');
				    			$scope.selectedData.data = {};
				    			$scope.selectedData.data.member =  [];
				    			$scope.selectedData.data.member.push( response.data.data.id  );
				    		}

				    		if ( $scope.buttons.chosen == 'addmore') {
				   				$scope.resetfields();
				   			}else{
				   				$('.triggerNext').trigger('click');
				   			}
				   		}else{
				   			////console.log(response.data.errors);
				   			$scope.InvitedErrors.push(response.data.errors);
				   		}

					},  function(response) {

			    		////console.log(response);
			    		alert('some error');
			    	});
			}



			//Invite Job Manager
			//Invite Member Form
			$scope.InviteManager = function () {

				var formData = {};
				// get user input from the form
				$('#InviteMemberForm').serializeArray().map(function(item) {
					formData[item.name] = item.value;
				});


				$scope.InvitedManagerList = [];
				$scope.InvitedErrorsManager = [];
				$http.post( GlobalConstant.EmployerRegisterMember,  {data: formData})
			    	.then(function(response) {
			    		//alert('update success');
			    		////console.log(response)
			    		$scope.hideme = false;
			    		if (response.data.data != null ) {
				    		$scope.InvitedManagerList.push(formData);

				    		//Check if object has id key
				    		if (angular.isUndefined($scope.SelectedJobManager.id) == false) {
				    			$scope.SelectedJobManager.id = response.data.data.id ;
				    		}else{
				    			$scope.SelectedJobManager.id = {};
				    			$scope.SelectedJobManager.id =  response.data.data.id ;
							}


				   		}else{

				   			$scope.InvitedErrorsManager.push(response.data.errors);
				   		}

					},  function(response) {

			    		////console.log(response);
			    		alert('some error');
			    	});
			}


			//Set Unsortable
			$scope.unsortable =  function(user){
		        return $.inArray(user, [1, 4, 5]) > -1;
		        // if (user == 1 || user == 4 || user == 5) {
		        // 	return false;
		        // }else{
		        // 	return true
		        // }
		    }

			$scope.remapped = [];

			//console.log( $scope.JobData )
			if ($scope.JobData) {
				if(
					//angular.isDefined($scope.JobData)  &&
					angular.isDefined(getJobId)  &&
					angular.isUndefined( $cookies.get('loadTemplate') )  &&
					//angular.isDefined($scope.URLQS.draft) &&
					//$scope.URLQS.draft == '1' &&
					$scope.JobData.workflow_steps.length != 0
					)
				{

						////console.log($scope.JobData.workflow_steps)
						$scope.workflowSteps  = $scope.JobData.workflow_steps;
						$scope.selectedflow.id  = [];

						angular.forEach($scope.workflowSteps, function (val, key) {

							if (val.enabled == true) {
								$scope.selectedflow.id.push(val.id)
							}
							$scope.remapped.push( {id:val.id, name: val.name }  )
	    				});
	    				//console.log('a')

				}else{
					 //console.log('b')
					////console.log('try to load steps')
				   	//Get Workflow Steps
		    		 	if (angular.isDefined(getJobId)   && angular.isDefined( $cookies.get('loadTemplate') ) ||  angular.isUndefined(getJobId)   && angular.isDefined( $cookies.get('loadTemplate') ) ) {
			    			//Load template populate data
			    			//console.log($scope.JobData)
			    			var steps =  $scope.JobData.workflow_steps;
							//$scope.selectedflow.id  = [1,2,3,6,4,5];
							$scope.workflowSteps = $scope.JobData.workflow_steps;
							$scope.selectedflow.id = []

							angular.forEach($scope.workflowSteps, function (val, key) {

								if (val.enabled == true) {

									$scope.selectedflow.id.push(val.id)
								}
								$scope.remapped.push( {id:val.id, name: val.name }  )
		    				});
						}else{
							$http.get( GlobalConstant.APIRoot+'employer/job/default-workflow-steps' )
							.then(function(response) {

				    			var data = response.data.data
				    			//console.log(data)
				    			if (angular.isDefined(getJobId)  && angular.isUndefined( $cookies.get('loadTemplate') )   || angular.isUndefined(getJobId)  && angular.isUndefined( $cookies.get('loadTemplate') )  ) {
					    			$scope.workflowSteps  = response.data.data;



					    			$scope.selectedflow.id  = [1,2,3,6,4,5];

					    		}



							});
						}
				}
			}else{
				$http.get( GlobalConstant.APIRoot+'employer/job/default-workflow-steps' )
							.then(function(response) {

				    			var data = response.data.data
				    			//console.log(data)
				    			if (angular.isDefined(getJobId)  && angular.isUndefined( $cookies.get('loadTemplate') )   || angular.isUndefined(getJobId)  && angular.isUndefined( $cookies.get('loadTemplate') )  ) {
					    			$scope.workflowSteps  = response.data.data;



					    			$scope.selectedflow.id  = [1,2,3,6,4,5];

					    		}



							});
			}




		// Start Sortable
			//Remap Array on after drag and drop
			//if(angular.isDefined($scope.JobData) && $scope.JobData.job_status != 'active' ){
				$(function() {
					$( "#sortable li" ).click(function() {
						////console.log('as')
					});

					$( "#sortable" ).sortable({
				    		items: "li:not(.unsortable)",
				    		stop: function(e, ui) {

			                 			var remappedArray = $.map($(this).find('.dropitem'), function(el) {

				                 			if( $(el).is(':checked') ){
					                 			//return parseInt(  $(el).val() );
					                 			var returnObject = {"id": $(el).val(), "name":$(el).next().next().next().val() }
					                 			////console.log( $(el).next().next().val() );
					                 			return returnObject;

					                 		}
					             		      	 //return $(el).attr('id') + ' = ' + $(el).index();
			             		   		});
			                			$scope.remapped  = remappedArray ;
			               	  	 }
				   	});
				    	$( "#sortable" ).disableSelection();

				    	var sortedIDs = $( "#sortable" ).sortable( "toArray" );

				    //disable drag drop on job edit
				    if ( angular.isDefined($scope.JobData) && $scope.JobData.job_status == 'active') {
						angular.element($( "#sortable" )).sortable('disable');
					}
				});




			//}




		    $scope.$watchCollection('selectedflow.id', function(newVal, oldVal) {

				if (angular.isDefined($scope.JobData) && $scope.JobData.workflow_steps.length == 0 ) {
					$scope.remapped = [
							   { "id":1, "name":"Long List"},
							   { "id":2,  "name":"Short List" },
							   { "id":3,  "name":"Interview" },
							   { "id":6, "name":"Job Manager Review" },
							   { "id":4,  "name":"Hired"   },
							   { "id":5, "name":"Not Interested"    }
							];
				}else{

					$scope.remapped = []
					angular.forEach(newVal, function(val, key){
						$scope.remaparray = $filter('filter')($scope.workflowSteps,   {id: val} , true  );
							if( angular.isDefined( $scope.remaparray[0]) ){
								$scope.remapped.push( {id:$scope.remaparray[0].id, name: $scope.remaparray[0].name }  )
							}
						});
					}


					var remappedArray = $.map($("#sortable").find('.dropitem'), function(el) {
						if( $(el).is(':checked') ){
	             			var returnObject = {"id": $(el).val(), "name":$(el).next().next().next().val() }
	             			$(el).parent().parent().addClass('parentme')
	             			return returnObject;
	             		}else{
	             			$(el).parent().parent().removeClass('parentme')
	             		}

	            	});

	            	//assign remapped array
	            	$scope.changing = function (){
	            		$scope.remapped  = remappedArray ;
	            	}

				////console.log($scope.remapped)
	        });


		  	$scope.functiontofindIndexByKeyValue = function(arraytosearch, key, valuetosearch) {


				for (var i = 0; i < arraytosearch.length; i++) {
					if (arraytosearch[i][key] == valuetosearch) {
						return i + 1;
					}
				}
				return null;
			}
		//End Sortable



			$scope.publishing = false;
			//Submit step3  form
			$scope.EmployeeAddJobStep3 = function (isdraft) {
				$scope.publishing = true;

				$scope.URLQS = $location.search();
				var getJobId = $scope.URLQS.id;
				//console.log(getJobId);

				//Get Job data first before actual submit
				if ( getJobId   != null    ) {

				 	//Get and set data for selected member
					if (angular.isDefined($scope.selectedData.data)  ) {
	    				if ( angular.isDefined($scope.selectedData.data.member)  ) {
	    					var selectedMember = $scope.selectedData.data.member;
	    				}else{
	    					var selectedMember = null;
	    				}

	    				if ( angular.isDefined($scope.selectedData.data.team) ) {
	    					var selectedTeam = $scope.selectedData.data.team;
	    				}else{
	    					var selectedTeam = [];
	    				}
    				}else{
    					var selectedMember = [];
    					var selectedTeam = [];
    				}

    				//Get data for drag and drop
    				if ($scope.remapped.length != 0 ) {
    					var SubmitWorkFlow = $.map($("#sortable").find('.dropitem'), function(el) {
		             		if( $(el).is(':checked') ){
		             			//return parseInt(  $(el).val() );
		             			var returnObject = {"id": parseInt( $(el).val() ), "name":$(el).next().next().next().val() }

		             			return returnObject;
		             		}
		               	 //return $(el).attr('id') + ' = ' + $(el).index();
		            	});
						//console.log( SubmitWorkFlow );

    					$scope.stepdata = []
    					angular.forEach($scope.remapped, function(val, key) {

    						var returnObject = {"id": parseInt( val.id), "name":val.name }
    						$scope.stepdata.push(returnObject)
    					})


					}else{
						var SubmitWorkFlow = $scope.stepdata;

					}



    				 if ( $scope.SelectedJobManager == null) {
    				 	var managerData = ''
    				 }else{
    				 	var managerData = $scope.SelectedJobManager.id
    				 }

    				//Add step3 data to current job
    				//check if editing a job
    				if(angular.isDefined($scope.URLQS.edit) && $scope.URLQS.edit == 1){
    					$scope.GetJobData =  {
	    						'visibility_members': selectedMember,
	    						'visibility_teams': selectedTeam,
	    					} ;
    				}else{
	    				$scope.GetJobData =  {
	    						'visibility_members': selectedMember,
	    						'visibility_teams': selectedTeam,
	    						'job_manager': managerData,
	    						'template': $scope.savetemplate,
	    						'workflow_steps': SubmitWorkFlow
	    					} ;
    				}


    				////console.log($scope.GetJobData);
    				//return false
			    		//alert('update success');
			    		////console.log(response);


			    			//Save draft
			    			if (angular.isDefined(isdraft) && isdraft == 'draft' || angular.isDefined($scope.URLQS.edit) && $scope.URLQS.edit == 1) {
			    				//console.log('draft')
			    	 			$http.put(  GlobalConstant.EmployerAddJob+'/'+$scope.URLQS.id , {data: $scope.GetJobData } )
						    	.then(function(response) {
						    		if ($scope.JobData.job_status == "active") {
						    			$('.step4').attr('data-slide-to', 3);
								    	$('.step4').trigger('click');
						    		}else{
						    			alert('Saved as draft!');
						    		}

			    					$cookies.remove('ob_key', { 'path':'/'})	;
					    			$cookies.remove('cont_key', { 'path':'/'})	;
					    			$cookies.remove('step_pa', { 'path':'/'})	;
					    			$cookies.remove('step_sq', { 'path':'/'})	;
					    			$cookies.remove('JobId', { 'path':'/'})	;
					    			$cookies.remove('step2', { 'path':'/'})	;
					    			$cookies.remove('step3', { 'path':'/'})	;
					    			$cookies.remove('loadTemplate', { 'path':'/'});

					    			angular.element($('#RemoveCookiesOnLeave')).remove();
					    			$(window).unbind('beforeunload')

								},  function(response) {
									$scope.loadsuburb 	= true;
									$scope.ErrorMsgs = response.data.errors;
						    		////console.log(response);
						    		//alert('some error');
						    	});

						    	angular.element( $("html, body")).animate({ scrollTop: 0 }, 1000);

			    			}else{
			    				//console.log('not draft')
			    				$http.put(  GlobalConstant.EmployerAddJob+'/'+$scope.URLQS.id,  {data: $scope.GetJobData } )
			    				.then(function(response) {
										//console.log(response)
										//submit to publish API
					    			$http.put(  GlobalConstant.EmployerAddJob+'/'+getJobId+'/publish '  )
								    	.then(function(response) {
								    		//alert('update success');
								    		//console.log(response);
								    		//Add PUT request to publish job
								    			$cookies.remove('ob_key', { 'path':'/'})	;
								    			$cookies.remove('cont_key', { 'path':'/'})	;
								    			$cookies.remove('step_pa', { 'path':'/'})	;
								    			$cookies.remove('step_sq', { 'path':'/'})	;
								    			$cookies.remove('JobId', { 'path':'/'})	;
								    			$cookies.remove('step2', { 'path':'/'})	;
								    			$cookies.remove('step3', { 'path':'/'})	;
								    			$cookies.remove('loadTemplate', { 'path':'/'})	;
								    			$('.step4').attr('data-slide-to', 3);
								    			$('.step4').trigger('click');
								    			$('.formstep4 .slideoverlay').hide();
												$('#AddEmployeeJob .carousel-indicators li').each( function(){
													$(this).attr('data-slide-to', -1);
												});

												angular.element($('#RemoveCookiesOnLeave')).remove();
												$(window).unbind('beforeunload')

										},  function(response) {
											$scope.loadsuburb 	= true;
											$scope.ErrorMsgs = response.data.errors;
								    		//console.log(response);
								    		//alert('some error');
								    	});

								},  function(response) {

							    		//console.log(response);

							    })

						    }
			    		 $scope.publishing = false;





	    		}
			}

	}]);

	app.controller('EmployerJobCreateStep4', ['GlobalConstant','$scope','$window','$http','$cookies','$filter', '$timeout', '$compile', '$location',function(GlobalConstant, $scope, $window, $http, $cookies,$filter, $timeout, $compile,$location) {
			$scope.URLQS = $location.search();
			var getJobId = $scope.URLQS.id;
			$scope.disableslide = true;


			//Populate fields with data
			if (angular.isUndefined(getJobId) == false ) {
				$scope.disableslide = false;
			}

			$scope.AddNewJob = function(){
				var base_url = $('body').data('base_url');
				$window.location.href = base_url+'employer/job/add/employee'  ;
				$(window).unbind('beforeunload')
			}

			$scope.showsocial = false;
			$('#carousel-example-generic').on('slid.bs.carousel', function() {

				if( $('#TEstMe section.active').hasClass('formstep4') ){
					if (angular.isDefined($scope.URLQS.id)) {
						$http.get( GlobalConstant.EmployerAddJob+'/'+$scope.URLQS.id  )
						.then(function(response) {
							$scope.job = response.data.data;
							if ($scope.job.job_status == 'active') {
								$scope.showsocial = true;
							}
							//console.log($scope.job)
						});
					}
				}
			});

	}]);

	app.controller('RemoveCookiesOnLeave',['GlobalConstant','$scope','$window','$http','$cookies','$filter', '$timeout', '$compile', '$location',function(GlobalConstant, $scope, $window, $http, $cookies,$filter, $timeout, $compile,$location) {

		$(window).bind('beforeunload', function(){
		  return 'Are you sure you want to leave?';
		});

		$(window).unload(function(){
		  	$cookies.remove('ob_key', { 'path':'/'})	;
			$cookies.remove('cont_key', { 'path':'/'})	;
			$cookies.remove('JobId', { 'path':'/'})	;
			$cookies.remove('loadTemplate', { 'path':'/'})	;
		});





     }]);

	app.controller('MemberModalInstanceCtrl',['GlobalConstant', '$scope', '$cookies', '$http','$modalInstance', '$location', 'data',
		function (GlobalConstant, $scope, $cookies, $http, $modalInstance, $location, data) {
		 $scope.user = {
		 	first_name:'',
		 	last_name:'',
		 	email: '',
		 	account_type: 6
		 } ;
		 $scope.submitting = false;
		 $scope.query_str =   $location.search();
		 function reassignData(){
		 	angular.forEach(  $scope.query_str, function(v, k){
		  			$location.search( k, v)
		  		});
		 }

		  $scope.ok = function () {



		  		$scope.submitting = true;
		  		//Submit invite for member
		  	 	$http.post( GlobalConstant.EmployerRegisterMember,  {data: $scope.user} )
			    	.then(function(response) {
			    		$scope.submitting = false;
			    		//console.log(response);
			    		if (response.data.data != null ) {
			    			reassignData()
						    $modalInstance.close( response.data.data );

					   	}else{
					   		reassignData()
				   			////console.log(response.data.errors);
				   			$modalInstance.close(response.data.errors);
				   		}

					},  function(response) {
						$scope.submitting = false;
						//console.log(response)
			    		alert('some error');
			    	});



		  };



		  $scope.cancel = function () {
		    $modalInstance.dismiss('cancel');
		    reassignData()
		  };
	}]);


}());

$(document).ready(function() {
/* HOLD ON THIS AS PER JOHNNY
	$("#flexi").click(function(){
		if ($(this).is(':checked')) {
			$(".work-shift").addClass("to-disable");
		}
		else {
			$(".work-shift").removeClass("to-disable");
		}
	});
	*/

	$('[data-toggle="tooltip"]').tooltip();

	function MemberDropdowFilter( field_element, display_element  ){
	 	$( field_element ).focusin(function(){

			$(this).keypress(function(){
				if ( $( display_element ).is(":hidden")  ) {
					$( display_element ).slideToggle( "slow");
				}
			})

		});

		$( field_element ).focusout(function(){
			setTimeout(function(){
			  $( display_element ).slideToggle( "slow");
			}, 500);


		});
	}
	MemberDropdowFilter('#SearchMemberField', '#SearchMember' )
	MemberDropdowFilter('#SearchTeamField', '#SearchTeam' )
	MemberDropdowFilter('#SearchManagerField', '#SearchManager' );





});