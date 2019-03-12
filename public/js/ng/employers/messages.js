(function () {
	'use strict';
		var app = angular.module('app');
		var base_url = $('body').data('base_url');
		$('#thread_list').TrackpadScrollEmulator();

		app.config(function ($routeProvider, $locationProvider) {
		    $locationProvider.html5Mode(false);
		});

		app.controller('EmployerMessagesController', ['GlobalConstant','$scope','$window','$http','$cookies', '$location','$route', '$timeout', function(GlobalConstant, $scope, $window, $http, $cookies,$location,$route,$timeout) {

			// Check mobile agent
        	$scope.mobile_agent = (/android|webos|iphone|ipad|ipod|blackberry|iemobile|opera mini/i.test(navigator.userAgent.toLowerCase()));
        	$scope.token_id = $cookies.get('token_id');
        	$scope.token = $cookies.get('token');
			$scope.params = {access_token: $scope.token};
			$scope.childThreads = [];
			$scope.external = [];
			$scope.internal = [];
			$scope.threads = [];
			$scope.scrollingMorePresent = true;
			var scrollCounter = 1;

			var color_bg_initial_set = [];
			// random color set
			color_bg_initial_set = [
				"member-initials--sky",
				"member-initials--pvm-purple",
				"member-initials--pvm-green",
				"member-initials--pvm-red",
				"member-initials--pvm-yellow"
			];

			$scope.base_url = base_url.replace(/\/$/, "");

			$http.get(  GlobalConstant.CompanyGetCompanyApi )
	    		.then(function(response) {
	    		if(response.status == 200){
	    			$scope.companyInfo = response.data.data;
	    		}

	    	});

	    	// play sound on new message
	    	 $scope.playSound = function (soundObj) {
				var sound = document.getElementById(soundObj);
				sound.play();
            }

	    	$scope.addThread = function(thread_id, type) {

				/*
				Employer side : thread id must be obkey
				Candidate side : thread id either obkey or profile url
				*/
			if(!type){
	    			type = 'internal';
	    		}

	    		thread_id = thread_id.split('/');
				var receiver_id = thread_id[1] ? thread_id[1] : (typeof thread_id == 'object') ? thread_id[0] : thread_id;
	    		var params = {data : {"receiver_id" : receiver_id} };

	    		$http.post( GlobalConstant.MessagesThreadApi ,  params)
	    		.then(function(response) {
				console.log(response)
				var data = response.data.data;
				if(response.status == 201 || response.status == 200) {

					$scope.mainThreads(type, data.thread_id);

				}
			    });


	    	}

	    	// URL HASH WACTH ////////////////////////
    	 	var timeoutMessageEmployer = "";
	    	$scope.$watch(function () {
			    return location.hash
			}, function (urlHash) {
				var hash = urlHash.split('/');

				console.log(hash)

				if(hash.length > 2){

					hash.shift();
				}



				if(hash[0] == 'new_thread'){

					$scope.mainThreads(hash[0], hash[1])

				}else{


					if(timeoutMessageEmployer){
                    	$timeout.cancel(timeoutMessageEmployer);
               		}

					if(hash[1]){



						var newThread = function() {

							 $http.get(  GlobalConstant.APIRoot + 'messaging/thread/'+ hash[1] + '/message/new' )
							 .then(function(response){
							 	var data = response.data.data;
							 	//console.log(data);
							 	// console.log(hash[0].substring(1))

							 	if(data.messages.length){
							 		// $scope.mainThreads(hash[0], hash[1])
							 		 $scope.playSound('message_beep');
							 		$scope.getChildThread($scope.thread_id);
							 		// alert($scope.thread_id)

							 	}
							 })

							timeoutMessageEmployer = $timeout(newThread, 2000);
						}

						timeoutMessageEmployer = $timeout(newThread, 2000);

					}

				}


			});


			// Get Main Threads
			$scope.mainThreads = function(type, thread_id) {
				// Reset scrollCounter for childthread
				scrollCounter = 1;
				$scope.thread_type = type; // use to view the company name if internal type
				$scope.childThreads = [];



				// $scope.threads = [];
				if(type == 'internal'){
					$scope.isInternal = true;
				}else if(type == 'external'){
					$scope.isInternal = false;
				}else if(type == 'new_thread'){

					$scope.addThread(thread_id, 'external');
					return false;
				}

				$scope.showLoading = true;

				$http.get( GlobalConstant.MessagesThreadApi )
		    		.then(function(response) {
		    		var data = response.data.data;

		    		$scope.threads = [];

		    		if(data.length) {
		    			$scope.external = [];
						$scope.internal = [];

		    			// Get total internal and external thread
		    			angular.forEach(data, function(v,k){
		    				if(v.thread.message_type == 'external'){
		    					$scope.external.push(1);
		    				}else{
		    					$scope.internal.push(1);
		    				}

		    				if(type == v.thread.message_type){
		    					$scope.threads.push(v);
		    				}
		    			});


		    			// added user initial name and bg color
		    			for (var a = 0; a < $scope.threads.length; a++) {
							$scope.F_initial = $scope.threads[a].members.receiver.first_name;
							$scope.F_initial = $scope.F_initial.substr(0, 1);

							$scope.L_initial = $scope.threads[a].members.receiver.last_name;
							$scope.L_initial = $scope.L_initial.substr(0, 1);

							$scope.threads[a].members.receiver.initial = $scope.F_initial + $scope.L_initial;

							// change default photo's background color
							var color_bg_initial = color_bg_initial_set[Math.floor(Math.random()*color_bg_initial_set.length)];
							$scope.threads[a].members.receiver.profile_color = color_bg_initial;
		    			}

		    			// console.log($scope.threads);

		    			if($scope.threads.length){
		    				$scope.thread_id = $scope.threads[0].thread.thread_id;
		    				if(thread_id){
								$scope.thread_id = thread_id;
		    				}


	    					window.location = base_url + 'employer/messages/#'+type+'/' + $scope.thread_id;


			    			$scope.getChildThread($scope.thread_id);
		    			}else{

		    				$scope.getChildThread(false);

		    				// window.location = base_url + 'employer/messages/#'+type+'/';
		    			}

		    			$scope.showLoading = false;

		    		}else{
		    			$scope.showLoading = false;
		    		}

				});

			}





			if(window.location.hash){

				var type = window.location.hash;

					type = type.split('/');

				if(type.length > 2){
					type.shift();
				}


				$scope.mainThreads(type[0], type[1]);
			}else{

				$scope.mainThreads('external');
			}


			$scope.threadCategory = function(category) {
				if(category == 'internal'){
					$scope.mainThreads(category);
				}else{
					$scope.mainThreads('external');
				}

			}

	    	// Get Company Users
			$http.get(GlobalConstant.CompanyGetCompanyUsersApi)
			.then(function(response){
				var data = response.data.data;

				if(data.length){
					$scope.companyUsers = data;
				}
			})

			var forceScrollBottom = function(bottomPosition) {

				var i = 0
				var scrollInterval = setInterval(function(){

					bottomPosition = (typeof bottomPosition != 'undefined') ? bottomPosition : $(".tse-scroll-content")[0].scrollHeight;
					$(".tse-scroll-content").scrollTop(bottomPosition);
					i++;

				  	if(i > 5){
							clearInterval(scrollInterval);
						}
				},100);
			}

			// Get Child Thrreads
			$scope.getChildThread = function(thread_id, offset) {



				if(thread_id == false){
					$('#thread_list').find('.tse-content').hide();
					return false;
				}

				if(offset){
					$scope.params.offset = offset;
				}else{
					$scope.params.offset = 0;
					scrollCounter = 1;
					offset = 0;
				}


				//$http({method: 'GET', params: $scope.params, async: false,  url: GlobalConstant.MessagesThreadApi + '/' + thread_id + '/message' })
				$http.get(    GlobalConstant.MessagesThreadApi + '/' + thread_id + '/message' ,  {async: false} )
	    		.then(function(response) {
		    		var data = response.data.data;

		    		console.log("data:",  data);
		    		// console.log(data.messages.length)
		    		if(!data.messages.length){
		    			$scope.scrollingMorePresent = false;
		    		}
		    		$scope.scrollingMorePresent = data.scrolling.more_present;

		    		if(offset){
		    			var messages = [];
		    			var liHeight = $(".tse-scroll-content li:first").height() + 25;
		    			var incrementLiHieght = 0;

		    			angular.forEach(data.messages, function(v){
		    				$scope.childThreads.messages.push(v)
		    				incrementLiHieght += liHeight;
		    			})
		    			forceScrollBottom(incrementLiHieght);

		    		}else{
		    			$scope.childThreads = data;
		    		}

		    		// console.log($scope.childThreads)

			    	$scope.thread_id = data.thread.thread_id;

		    		if(!$scope.threads.length){
		    			$('#thread_list').find('.tse-content').hide();
		    		}else{
		    			$('#thread_list').find('.tse-content').show();
		    		}

		    		console.log("childs: ", $scope.childThreads);

	    			// added user initial ne and bg color
	    	// 		for (var c = 0; c < $scope.childThreads.length; c++) {
						// $scope.F_initial_msg = $scope.childThreads[c].members.receiver.first_name;
						// $scope.F_initial_msg = $scope.F_initial_msg.substr(0, 1);

						// $scope.L_initial_msg = $scope.childThreads[c].members.receiver.last_name;
						// $scope.L_initial_msg = $scope.L_initial_msg.substr(0, 1);

						// $scope.childThreads[c].members.receiver.initial = $scope.F_initial_msg + $scope.L_initial_msg;

						// // change default photo's background color
						// var color_bg_initial = color_bg_initial_set[Math.floor(Math.random()*color_bg_initial_set.length)];
						// $scope.childThreads[c].members.receiver.profile_color = color_bg_initial;
						// console.log("tae");

	    	// 		}

					$scope.F_initial_msg_receiver = $scope.childThreads.members.receiver.first_name;
					$scope.F_initial_msg_receiver = $scope.F_initial_msg_receiver.substr(0, 1);
					$scope.L_initial_msg_receiver = $scope.childThreads.members.receiver.last_name;
					$scope.L_initial_msg_receiver = $scope.L_initial_msg_receiver.substr(0, 1);
					$scope.childThreads.members.receiver.initial = $scope.F_initial_msg_receiver + $scope.L_initial_msg_receiver;

					var color_bg_initial = color_bg_initial_set[Math.floor(Math.random()*color_bg_initial_set.length)];
					$scope.childThreads.members.receiver.profile_color = color_bg_initial;


					$scope.F_initial_msg_sender = $scope.childThreads.members.sender.first_name;
					$scope.F_initial_msg_sender = $scope.F_initial_msg_sender.substr(0, 1);
					$scope.L_initial_msg_sender = $scope.childThreads.members.sender.last_name;
					$scope.L_initial_msg_sender = $scope.L_initial_msg_sender.substr(0, 1);
					$scope.childThreads.members.sender.initial = $scope.F_initial_msg_sender + $scope.L_initial_msg_sender;

					var color_bg_initial = color_bg_initial_set[Math.floor(Math.random()*color_bg_initial_set.length)];
					$scope.childThreads.members.sender.profile_color = color_bg_initial;

	    			console.log("msg threads: ", $scope.childThreads);

				})
				.finally(function(){
					if(!offset){
						forceScrollBottom();
					}

				})

			}


			$(".tse-scroll-content").scroll(function(){
				var obj = $(this);

				if(obj.scrollTop() === 0){

					if($location.hash() && $scope.scrollingMorePresent){

					var type = $location.hash();
						type = type.split('/');
					var thread_id = type[1];
					var offset = scrollCounter * 20;

						$scope.getChildThread(thread_id, offset)

					}

					scrollCounter++;

				}
			})


			// countEnterPress => hack for preventing pressing user manny times the enter key, to avoid multiple saving
			var countEnterPress = 0;
	    	$scope.addMessage = function(e) {

	    		var add_message = $.trim($('#add_message').val());


	    		if(  e.type == 'submit'){
	    			countEnterPress = 1;

    				if($scope.thread_id) {
    					$scope.addMsgParams = {"data" : {"message": add_message}};
						$http.post(  GlobalConstant.MessagesThreadApi + '/'+ $scope.thread_id +'/message' ,  $scope.addMsgParams, { async : false })
						.then(function(response) {
							if(response.status == 201) {
								countEnterPress = 0;
								$scope.childThreads.messages.unshift(response.data.data);
							 	angular.element($('#add_message')).val("").removeClass('ng-valid')


							}
					    })
					    .finally(function(){
							forceScrollBottom();
						});

    				}

    				e.preventDefault();
	    		}

	    	}



	    	$scope.showCompanyUsers = function() {
	    		$(".addNewTheadContainer").fadeToggle(300);
	    	}



		}]);


}());