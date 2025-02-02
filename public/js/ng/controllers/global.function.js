(function() {
	'use strict';
	//var base_url = $('body').data('base_url');
	var app = angular.module('app');
	var base_url = $('body').attr('data-base_url');

  app.factory('pageCookie', ['GlobalConstant','$cookies', '$http', '$interval', '$timeout', '$window', 'ajaxService',
		function(GlobalConstant, $cookies, $http, $interval, $timeout, $window, ajaxService) {
		return {
			InitCookie: function ($scope) {
				var cookiepage = $cookies.getObject('allmodules');
				var allmodules = [];

				if (cookiepage) {
					allmodules = cookiepage;
				} else {
	  			allmodules = [{
	  				login: {},
				    registration: {},
				    job_search: {},
				    job_view: {},
				    dashboard:{},
				    tms: {
				    	jobid: 0,
				      loadmore: {
				      	status: false,
				      	offset: 0,
				      	step_id: 0
				      },
			        expanded_card: {
			        	status: false,
			          step_id: 0,
			          object_id: 0,
			          print_opt: false,
			          applicant_data: {},
			          see_notes: ""
			        }
				    }
					}];
				}

				$cookies.putObject('allmodules', allmodules);
				return allmodules[0];
	  	},
	  	UpdateCookie: function ($scope) {
	  		console.log('update cookie ', $scope);
	  		var updateCookie = [$scope];

	  		$cookies.putObject('allmodules', updateCookie);
	  		return true;
	  	}
		} // end return
	}]);

	app.config(['$routeProvider', '$locationProvider', function ($routeProvider, $locationProvider) {
    $locationProvider.html5Mode(false);
	}]);

  app.factory('GlobalSearch', function() {
  	var data = {
      SearchValue: ''
    };
    return {
      getSearchVal: function () {
        return data.SearchValue;
      },
      setSearchVal: function (val) {
        data.SearchValue = val;
      }
    };
  });

	app.controller('globalFunction', ['GlobalConstant',  '$scope','$window','$http','$cookies','$filter','$timeout' , 'OAuth',  'OAuthToken', '$rootScope',
	function(GlobalConstant,  $scope , $window , $http , $cookies , $filter , $timeout, OAuth, OAuthToken, $rootScope) {
		// console.log(GlobalConstant);
		//Cookie Checker



		var getToken = $cookies.get('token');
		var getTokenId = $cookies.get('token_id');
		var timeOffset = 2000;

		if (typeof getToken != 'undefined' || getToken != null) {
			var GetLoginTime =  parseInt ($cookies.get('LoginTime'));
			var GetExpireTime = parseInt ($cookies.get('exp'));
			var currentTime = new Date();
			var currentTimeTimestamp = Math.round(currentTime.getTime() / 1000);
			//Vars to display DATA, NOT IMPORTANT
			var ExpireTimeInt = parseInt (GetLoginTime + GetExpireTime);
			var RefreshTimeInt = parseInt (GetLoginTime  + (GetExpireTime - timeOffset));
			// var RefreshTimeInt		 = parseInt (GetLoginTime  + (GetExpireTime - 3570));
			var expiredate = new Date(ExpireTimeInt * 1000);
			var refreshDate = new Date(RefreshTimeInt * 1000);
			var flag = true;
			// var video_counter = 0;
			//$scope.ExpireDate = $filter('date')(expiredate, 'yyyy-MM-dd HH:mm:ss');
			//$scope.RefreshTime = $filter('date')(refreshDate, 'yyyy-MM-dd HH:mm:ss');
			$scope.ExpireDate = $filter('date')(expiredate, 'yyyy-MM-dd HH:mm:ss');
			$scope.RefreshTime = $filter('date')(refreshDate, 'yyyy-MM-dd HH:mm:ss');
			$scope.Token = $cookies.get('token');
			$scope.RefreshOn = currentTimeTimestamp;
			var i = 0;
			var logoutIdleCount = 0;

			var stimatedExpiredTime = (2700 + (3600 * 2)); // 1 hr estimate + 2hours  (including payload delay and other stuff)
			$scope.onTimeout = function() {
        $scope.RefreshOn++;
        mytimeout = $timeout($scope.onTimeout,1000);
        //console.log($cookies.get('LoginTime'))
        //console.log(RefreshTimeInt - $scope.RefreshOn)
        //console.log(GetLoginTime)
        //console.log('100 -> ' + i)
        //console.log(OAuthToken.getRefreshToken())
        // Forced logout if idle in 1 hour
        if(logoutIdleCount > stimatedExpiredTime) {
        	$.ajax({
	    			url  : GlobalConstant.logoutPage,
	    			type : 'get',
	    			'success' : function(data) {
	    				if(data == 200) {
	    					$window.location.href =  GlobalConstant.loginPage;
	    				}
	    			}
  				});
        }
        // console.log('logoutIdleCount')
        //console.log(logoutIdleCount +'/'+ stimatedExpiredTime)
        logoutIdleCount++;

        if (angular.element($('#pmvCameraModalNew')).is(':visible')) {
        	logoutIdleCount = 0;
        }

        if(i > 99) {
        	// RefreshTimeInt =  parseInt ($cookies.get('LoginTime'));
        	currentTime = new Date();
					$scope.RefreshOn = Math.round(currentTime.getTime() / 1000);
					// GetExpireTime =  parseInt($cookies.get('exp'));

					// RefreshTimeInt = parseInt(parseInt($cookies.get('LoginTime')) + (GetExpireTime - timeOffset));
        	i = 0;
        	// //console.log('redifined ==========================================')
        }
        i++;

      	if(flag) {
        	if ($scope.RefreshOn >= RefreshTimeInt) {
	        	//refreshToken
	    			//Try new refresher
						OAuth.getRefreshToken();
						// //console.log('isAuthenticated')
						// //console.log(OAuth.isAuthenticated())
						var RefresherData =  OAuthToken.getToken();
						// //console.log(RefresherData)
	    			if(OAuth.isAuthenticated()) {
	    				// flag = false;
	    				i = 0;
	    				var token	= RefresherData.access_token;
				    	var expire = parseInt(RefresherData.expires_in);
				    	var refresh_token	= RefresherData.refresh_token;
				    	var email = $cookies.get('email');
							var SetDateforLogin = new Date();
		    			var LoginTime = parseInt(SetDateforLogin.getTime() / 1000);
		    			var ExpireTime = parseInt(SetDateforLogin.getTime() / 1000) + expire;
		    			var ExpireTimetoDate = new Date(ExpireTime * 1000);
		    			////console.log(ExpireTimetoDate);
		    			$cookies.put('token', token, { 'path':'/'});
		    			$cookies.put('LoginTime',LoginTime, {'path':'/' });
		    			// $cookies.put('IdleTime', ExpireTime, {'path':'/' });
		    			$cookies.put('exp', expire, {'path':'/' });
		    			$cookies.put('email', email, {'path':'/' });
		    			RefreshTimeInt = LoginTime + (expire - timeOffset);
		    			// GetLoginTime = LoginTime;
		    			// RefreshTimeInt = LoginTime + (expire - 3570);
		    			$.ajax({
			    			url  : GlobalConstant.tokenstorage,
			    			type : 'post',
			    			data : {token_refresh: refresh_token, token_access: token, username: email},
			    			success : function(token_id) {
			    				$cookies.put('token_id', token_id, {'path':'/' });
			    			}
			    		});
	    			}
	    			/*$.ajax({ //Get refresher data
		    			url  : GlobalConstant.refreshtoken,
		    			type : 'get',
		    			'async' : false,
		    			'dataType' : 'json',
		    			'success' : function(data) {
		    				 flag = false;

		    				//Fire refresher to api
						    var FormData = "client_id="+data.cid+"&client_secret="+data.cse+"&grant_type="+data.grantType+"&refresh_token="+data.refreshToken;
						    ////console.log(data)
						    $.get(data.apiUrl, FormData).done(function(response) {

								var token  		 	= response.access_token;
						    	var expire 		 	= parseInt(response.expires_in);
						    	var refresh_token	= response.refresh_token;
						    	var email 			= $cookies.get('email');

								var SetDateforLogin = new Date();
				    			var LoginTime = parseInt(SetDateforLogin.getTime() / 1000);
				    			var ExpireTime  	 = parseInt(SetDateforLogin.getTime() / 1000) + expire  ;
				    			var ExpireTimetoDate = new Date(ExpireTime * 1000);

				    			////console.log(ExpireTimetoDate);
				    			$cookies.put('token', token, { 'path':'/'});
				    			$cookies.put('LoginTime',LoginTime, {'path':'/' });
				    			// $cookies.put('IdleTime', ExpireTime, {'path':'/' });
				    			$cookies.put('exp', expire, {'path':'/' });
				    			$cookies.put('email', email, {'path':'/' });


				    			$.ajax({
					    			url  : GlobalConstant.tokenstorage,
					    			type : 'post',
					    			data : {token_refresh: refresh_token, token_access: token, username: email},
					    			success : function(token_id) {
					    				$cookies.put('token_id', token_id, {'path':'/' });

					    			}
					    		});


								//flag = true;

    						});

		    			}
    				}); */
		    	}
	    	}
	    	//Check if date was changed to past vs Login Time
	    	//console.log($scope.RefreshOn +'-'+ GetLoginTime)
	    	if($scope.RefreshOn < GetLoginTime) {
	    		//OAuth.getRefreshToken();
	    		// logout user
    			$.ajax({
	    			url  : GlobalConstant.logoutPage,
	    			type : 'get',
	    			'success' : function(data) {
	    				if(data == 200) {
	    					//$window.location.href =  GlobalConstant.loginPage;
	    				}
	    			}
  				});
	    	}
		  };
		  var mytimeout = $timeout($scope.onTimeout, 1000);

		} else {
			var current_location = $window.location.href;
			if(current_location.indexOf("my-account") != -1) {
				$.ajax({
    			url  : GlobalConstant.logoutPage,
    			type : 'get',
    			'success' : function(data) {
    				if(data == 200) {
    					$window.location.href =  GlobalConstant.loginPage;
    				}
    			}
			});
			}
		}

		//Check if Cookie is enabled
		function cookie () {
      var cookieEnable = navigator.cookieEnabled;
      if (typeof navigator.cookieEnabled === 'undefined' && !cookieEnable) {
        document.cookie = 'cookie-test';
        cookieEnable   = (document.cookie.indexOf('cookie-test') !== -1);
      }
      return cookieEnable;
    }
    if (!cookie()) {
    	if (!noCookiePage) {
    		$window.location.href =  GlobalConstant.loginPage;
    	}
    }





	}]);

	// /**** END GLOBAL Controller  ***********************************/

// /**** 5. BEGIN MENU  ***********************************/
	app.controller('LoginmenuController', ['GlobalConstant', 'GlobalSearch', 'ajaxService', '$scope', '$window', '$cookies', '$location', '$interval', '$http',
		function(GlobalConstant,GlobalSearch, ajaxService, $scope, $window,$cookies,$location, $interval, $http) {
		//Show User Navigation in menu
		var tokenKey = $cookies.get('token');
		var tokenExp = $cookies.get('expireToken');
		$scope.params = {access_token: tokenKey};
		$scope.isDashboard = false;
		$scope.isMyAccount = false;
		$scope.isMessages = false;
		var currentLocation = String(window.location);

		// hide/show top menu link
		if(currentLocation.search('/my-account/dashboard') != -1 || currentLocation.search('/employer/dashboard') != -1) {
			$scope.isDashboard = true;
		} else if(currentLocation.search('/my-account/messages') != -1 || currentLocation.search('/employer/messages') != -1) {
			$scope.isMessages = true;
		} else if(currentLocation.search('/my-account')) {
			$scope.isMyAccount = true;
		}

		$scope.val = 0; //Default value binded on menu function
		$scope.logged = function(value) {
			if (tokenKey != null) {
				return true;
			} else {
				return false;
			}
		}

		if(tokenKey) {
			if ($cookies.get('ut') == 'candidate') {
				$http.get(GlobalConstant.profileApi)
				.then(function(response) {
					var data = response.data.data;
          var randomColor = 0;
          var randomColorval = 0;
					// //console.log('data')
					// //console.log(data)
					$scope.docs = data.docs;
					$scope.profile_url = 'my-profile';
          // Add initial to be used in default image
          $scope.F_initial = data.first_name;
          $scope.F_initial = $scope.F_initial.substr(0, 1);

          $scope.L_initial = data.last_name;
          $scope.L_initial = $scope.L_initial.substr(0, 1);

          $scope.initial = $scope.F_initial + $scope.L_initial;

          // change default photo's background color
          if(randomColorval == 0) {
            randomColor =Math.random();
            if (randomColor >= 0 && randomColor < 0.2) {
              $scope.profile_color = "member-initials--sky";
            }
            else if (randomColor >= 0.2 && randomColor < 0.4) {
              $scope.profile_color = "member-initials--pvm-purple";
            }
            else if (randomColor >= 0.4 && randomColor < 0.6) {
              $scope.profile_color = "member-initials--pvm-green";
            }
            else if (randomColor >= 0.6 && randomColor < 0.8) {
              $scope.profile_color = "member-initials--pvm-red";
            }
            else if (randomColor >= 0.8 && randomColor < 1) {
              $scope.profile_color = "member-initials--pvm-yellow";
            }
            randomColorval = 1;
          }

			    if (Object.keys($scope.docs).length) {
            $scope.profile_image = $scope.docs.profile_image;
        	}

				});
				// Settimeout for every 5 seconds on notification count

			} else if($cookies.get('ut') == 'employer') {
				$scope.is_employer = true;
				ajaxService.getEmployerProfile().then(function(response) {
					var data = response.data.data;
          var randomColor = 0;
          var randomColorval = 0;

          $scope.profile_image = data.profile_picture_url;
         	$scope.profile_url = 'company/' + data.company.company_url;
         	$scope.account_type_string = data.account_type_string;


          // Add initial to be used in default image
          $scope.F_initial = data.first_name;
          $scope.F_initial = $scope.F_initial.substr(0, 1);

          $scope.L_initial = data.last_name;
          $scope.L_initial = $scope.L_initial.substr(0, 1);

          $scope.initial = $scope.F_initial + $scope.L_initial;

          // change default photo's background color
          if(randomColorval == 0) {
            randomColor =Math.random();
            if (randomColor >= 0 && randomColor < 0.2) {
              $scope.profile_color = "member-initials--sky";
            }
            else if (randomColor >= 0.2 && randomColor < 0.4) {
              $scope.profile_color = "member-initials--pvm-purple";
            }
            else if (randomColor >= 0.4 && randomColor < 0.6) {
              $scope.profile_color = "member-initials--pvm-green";
            }
            else if (randomColor >= 0.6 && randomColor < 0.8) {
              $scope.profile_color = "member-initials--pvm-red";
            }
            else if (randomColor >= 0.8 && randomColor < 1) {
              $scope.profile_color = "member-initials--pvm-yellow";
            }
            randomColorval = 1;
          }
				})
			}

			$scope.search = function() {
				var user_search = $scope.globalsearch;
				if(user_search) {
					window.location = base_url + 'job/search/#?q=' + user_search;
				} else {
					window.location = base_url + 'job/search/';
				}
				GlobalSearch.setSearchVal(user_search);
			}

			$scope.onTimeoutNotification = function() {
				$scope.params = {access_token: $cookies.get('token')};
				// //console.log('hb')
				// //console.log($scope.params)
				//$http({method: 'GET', params: $scope.params, url: GlobalConstant.HeartbeatApi})
				$http.get(GlobalConstant.HeartbeatApi)
				.then(function(response) {
	    		if(response.status == 200) {
	    			var data = response.data.data;
	    			$scope.count_nofications = (data.counters.notification > 0) ? data.counters.notification : "";
	    			$scope.count_messages = (data.counters.message > 0) ? data.counters.message : "";
	    			// $('.notification_count.notif').text($scope.count_nofications);
	    			// $('.notification_count.message').text($scope.count_messages);
    			}
				});
				// $timeout.cancel($scope.onTimeoutNotification)
			}

			$scope.onTimeoutNotification();
      $interval($scope.onTimeoutNotification,15000);

			$(".notificationLink").on('click',function() {
				if(!$(".notificationContainer.notif").is(':visible')) {
					// Get Notification Event list
	        $http.get(GlobalConstant.NotificationEventApi)
		    	.then(function(response) {
		    		if(response.status == 200) {
		    			$scope.notificationEvent = response.data.data;
		    		}
		    	});
				}
	    	$(".notificationContainer.message").hide();
				$(".notificationContainer.notif").fadeToggle(300);
				// if ($(".notificationContainer.message").is(':visible')) {
					// $(".notificationContainer.message").hide();
				// } else if($(".notificationContainer.setting").is(':visible')) {
				// 	$(".notificationContainer.setting").hide();
				// }

				// $(".notification_count.notif").fadeOut("slow");
				return false;
			});

			$(".messageLink").on('click',function() {
				// Get Notification Event list
				if(!$(".notificationContainer.message").is(':visible')) {
					$http.get(GlobalConstant.NotificationMessageApi)
		    	.then(function(response) {
		    		//console.log(response)
		    		if(response.status == 200) {
		    			$scope.notificationMessages = response.data.data;
		    		}
		    	});
				}
				// if ($(".notificationContainer.notif").is(':visible')) {
				$(".notificationContainer.notif").hide();
				// } else if($(".notificationContainer.setting").is(':visible')) {
				// 	$(".notificationContainer.setting").hide();
				// }
				$(".notificationContainer.message").fadeToggle(300);
				// $(".notification_count.message").fadeOut("slow");
				return false;
			});

			// Notication Event and Message link
    	$scope.notification_seen = function(id, url, type) {
    		if (url.indexOf('/') === 0) {
          url = url.substring(1);
        }

    		$http.get(GlobalConstant.NotificationApi +'/'+ id +'/seen')
	    	.then(function(response) {
	    		if(response.status == 204) {
	    			// Candidate or Employer redirect to messages page
	    			if($('body').hasClass('Candidate')) {
							window.location = base_url + url;
						} else {
							window.location = base_url + url;
						}
	    		}
    		});
  		}
		} // end tokenKey condition

		$scope.goToLink = function(e) {
			var elem = $(e.currentTarget);
			$window.location = elem.attr('href');
		}
		$scope.navigateUrl = function(e){
			window.location.href = e;
		};
		//Logout
		/*$scope.logout = function(value) {
			$.ajax({
    			url  : GlobalConstant.logoutPage,
    			type : 'get',
    			'success' : function(data) {
    				if(data == 200) {
    					$window.location.href =  base_url;
    				}
    			}
  		});*/
  		$scope.logout = function() {
  			var token = $cookies.get('api_token');
		    $http.get( window.location.origin + "/api/logout?token=" + token, {
		      headers: { 'Authorization': 'Bearer ' + token }
		    }).then(function(response) {
		      $window.location.href =  '/login';
		  });  
		}

	}]);
/**** END MENU  ***********************************/

	/* File Upload Service (Resume/Portfolio) */

	window.onload = function() {
    if(!XMLHttpRequest.prototype.sendAsBinary) {
      XMLHttpRequest.prototype.sendAsBinary = function(datastr) {
        function byteValue(x) {
          return x.charCodeAt(0) & 0xff;
        }
        var ords = Array.prototype.map.call(datastr, byteValue);
        var ui8a = new Uint8Array(ords);
        try{
          this.send(ui8a);
        }catch(e) {
          this.send(ui8a.buffer);
        }
      };
    }
  };

	app.factory('fileUploadService', ['GlobalConstant','$cookies', '$http', '$interval', '$timeout', '$window', 'ajaxService',
		function(GlobalConstant, $cookies, $http, $interval, $timeout, $window, ajaxService) {

		return {
			initParams : function($scope) {
				$scope.record_btn = false;
				$scope.record_again_btn = false;
				$scope.stop_btn = false;
				$scope.save_btn = false;
				$scope.change_btn = false;
				$scope.showSection1 = false;
				$scope.showSection2 = true;
				$scope.modal_percent = true;
        $scope.ondragoverout_image = false;
      	$scope.ondragover_image = true;
				$scope.record_btnRE = false;
				$scope.record_again_btnRE = false;
				$scope.stop_btnRE = false;
				$scope.save_btnRE = false;
				$scope.change_btnRE = false;
				$scope.showSection1RE = false;
				$scope.showSection2RE = true;
				$scope.modal_percentRE = true;
			 	$scope.ondragoverout_imageRE = false;
        $scope.ondragover_imageRE = true;
        $scope.guid_response = ""; //video upload status watch
        // $scope.guid_response_profile = ""; //video upload status watch
        $scope.profile_photo_uploaded = "";
        $scope.upload_init = 0;
        $scope.uploading_message = "";
	    	$scope.upload_code = 0;
			},

			buttonsHideShow : function($scope, a,b,c,d,e) {
				$scope.record_btn = a;
				$scope.record_again_btn = b;
				$scope.stop_btn = c;
				$scope.save_btn = d;
				$scope.change_btn = e;
				$scope.record_btnRE = a;
				$scope.record_again_btnRE = b;
				$scope.stop_btnRE = c;
				$scope.save_btnRE = d;
				$scope.change_btnRE = e;

				if($scope.modalId) {
					this.hideShowManual($scope, '#record_btn',b);
					this.hideShowManual($scope, '#take_photo_btn',a);
					this.hideShowManual($scope, '#record_again_btn',c);
					this.hideShowManual($scope, '#change_btn',d);
					this.hideShowManual($scope, '#save_btn',e);
				}
			},

			sectionsHideShow : function($scope, a,b) {
				$scope.showSection1 = a;
				$scope.showSection2 = b;
				$scope.showSection1RE = a;
				$scope.showSection2RE = b;

				if($scope.modalId) {
					this.hideShowManual($scope, '#section1-holder',a);
					this.hideShowManual($scope, '#section2-holder',b);
				}
				// that.sectionsHideShow($scope,true,false);
	    	// that.buttonsHideShow($scope, true,true,true,false,false);
			},

			hideShowManual : function($scope, elem, param) {
				if(param) {
					$($scope.modalId + ' ' +  elem).addClass('ng-hide');
				} else {
					$($scope.modalId + ' ' +  elem).removeClass('ng-hide');
				}
			},

			openModal : function($scope, elem, docFileType) {

				// console.log('OPEN MODAL: ', $(elem).find());
				this.initParams($scope);
				this.fileChange($scope);
				$scope.modalId = elem;

				if(elem) {
					$(elem).attr('data-docFileType', docFileType)
					$(elem).modal('show');
				} else {
					$('#pmvResumeModal').modal('show')
				}
			},
			openErrorModal : function(elem) {
				if(elem) {
					$(elem).modal('show');
				} else {
					$('#pmvErrorMsg').modal('show')
				}
			},

			fileChange : function($scope) {
				$scope.modal_percent_value = 0;
      	$scope.showSection1 = false;
      	$scope.showSection2 = true;
      	$scope.modal_percent = true;
      	$scope.ondragoverout_image = false;
      	$scope.ondragover_image = true;

      	if($('#section1-holder').hasClass('ng-hide')) {
      		$('#section1-holder').removeClass('ng-hide')
      		$('#section2-holder').addClass('ng-hide')
      		$('.modal_percent_new').addClass('ng-hide')
      		$('#ondragoverout_image').removeClass('ng-hide')
      		$('#ondragover_image').addClass('ng-hide')
      	}
			},
			/*
			$scope = angular scope
			elemId = Element id
			evt = drop/drop functionality
			docFileType = file type eg. resume, video, etc
			fileSizeLimit = file size limit (default 2mb)
			isAuthenticate = is user logged in
			*/
			uploadFile : function($scope, elemId, evt, docFileType, fileSizeLimit, isAuthenticate, origin) {
				if(!fileSizeLimit) fileSizeLimit = 2;
				// console.log("uploadFile1: ", docFileType, origin);
				// $scope.file_upload_modal = function(evt,elem_id) {
        var fileField = document.getElementById(elemId);
     	 	var file_folder = "";
       	var allowed_files = [];
      	switch(docFileType) {
      		case 'image' :
      		allowed_files = ['jpg','jpeg','png'];
      		file_folder = 'image';
      		break;
      		case 'cover_letter' :
      		allowed_files = ['doc', 'docx', 'pdf',  'xls', 'indd', 'eps', 'psd', 'mp4', 'xlsx', 'ppt', 'pptx' ];
      		// file_folder = 'resume'; // PQB-23 not fixed yet
  				file_folder = 'cover_letter';
      		case 'transcript' :
      		case 'portfolio' :
      		case 'resume' :
      		case 'application_question_answer' :
      		allowed_files = ['doc', 'docx', 'pdf',  'xls', 'indd', 'eps', 'psd', 'mp4', 'xlsx', 'ppt', 'pptx' ];
      		file_folder = docFileType;
      		break;
    		 	default:
    		 	allowed_files = ['doc', 'docx', 'pdf',  'xls', 'indd', 'eps', 'psd', 'mp4', 'xlsx', 'ppt', 'pptx' ];
    		 	file_folder = docFileType;
      	}

      	if(docFileType == 'application_question_answer') {
      		file_folder = 'resume';
      	}
      	// console.log(file_folder,333)

        var file_data = "";
        if (evt) {
          file_data = evt.dataTransfer.files[0];
        } else {
        	file_data = fileField.files[0];
        }
        // console.log("uploadFile2");

        var fileSize = parseFloat(file_data.size / (1024 * 1024)).toFixed(2)
        // Delete old file if user change file
        if($('#'+file_folder+'_save').attr('data-filename')) {
					var oldFile = $('#'+file_folder+'_save').attr('data-filename');
					var folder = $('#'+file_folder+'_save').attr('data-folder');
					$scope.delete_old_file(oldFile,folder);
				}

        var filename = file_data.name;
        var last_dot = filename.lastIndexOf('.');
        var ext = filename.substr(last_dot + 1).toLowerCase();

        if (allowed_files.indexOf(ext) == -1) {
          alert('Invalid file must be '+allowed_files.join(', ')+' extension');
          this.fileChange($scope);
          return false;
        } else if(fileSizeLimit && fileSize > fileSizeLimit) {
        	alert('File should not exceed '+fileSizeLimit+'mb in size.');
        	this.fileChange($scope);
      	 	return false;
        }

        if (angular.isDefined($cookies.get('obkey'))) {
        	var ob_key = $cookies.get('obkey');
        } else {
        	var ob_key = $cookies.get('ob_key');
        }

        // console.log("uploadFile3");

        var form_data = new FormData();
        form_data.append('file', file_data);
        var params = '?ob_key=' + ob_key + '&file_folder=' + file_folder;
        $scope.modal_file_percent_value = 0;
        var uploadUrl = GlobalConstant.FileUploadUrl + '/upload_submit';
        if(!isAuthenticate) {
        	uploadUrl = GlobalConstant.RegisterFileUpload;
        	if($('#FormStep2').is(':visible')) {
        		uploadUrl += '?not_profile=1';
        	}

        	if($('.formstep2 #pmvFileModalNew, .notImg #pmvFileModalNew').is(':visible')) {
        		uploadUrl += '?not_profile=1';
        	}
        }
        // console.log("uploadFile4: ", uploadUrl +  params);

        $.ajax({
          url: uploadUrl +  params,
          dataType: 'text',
          cache: false,
          contentType: false,
          processData: false,
          data: form_data,
          type: 'post',
          success: function(res) {
            // console.log("upload file:", res);
            res = JSON.parse(res);
            if (res.response == 200) {
              // console.log('global func Uploading Success');
              if(!evt) {
              	fileField.value = '';
              }
             	// alert(docFileType)
             	// console.log(file_folder)
              $cookies.put('uploadedFile', res.filename, {'path':'/' });
              $cookies.put('uploadedFolder', file_folder, {'path':'/' });
              $cookies.put('docFileTypeM', docFileType, {'path':'/' });


 							$scope.modal_percent = true;
 							$scope.showSection1 = true;
 							$scope.showSection2 = false;

 							// console.log("docFileType: ", docFileType);

 							$scope.uploadResponseText = '<h2>File has been uploaded.\Save or change file?\</h2>';
 							if(docFileType == 'image') {
 								$scope.classImg = 'img-h';
	 							var img = '<img class="'+$scope.classImg+'" src="assets/Uploads/Image/'+res.filename+'" >';
								$scope.uploadResponseText = '<div class="modal-image-container">'+img+'</div>';

 								if($('#section2-holder').hasClass('ng-hide')) {
 									$('#section2-holder').removeClass('ng-hide');
 									$('#section1-holder').addClass('ng-hide');

 									if($('#FormStep2').is(':visible')) {
 										$('#uploadResponseText').html('<img width="220" src="assets/Uploads/Image/'+res.filename+'" >'); // normal render
 									} else {
 										$('#uploadResponseText').html($scope.uploadResponseText); // render in circle
 									}
 								}
 								$('#save_btn').attr('data-targetElementId', '');
 							} else if(docFileType == 'resume') {
 								// $('#save_btn').attr('data-targetElementId', 'Form_my_file')
 								// console.log("upload RESUME");
 								$scope.targetElementId = 'Form_my_file';
 							} else if(docFileType == 'portfolio') {
 								$scope.targetElementId = 'Form_my_portfolio';
 								 // $('#save_btn').attr('data-targetElementId', 'Form_my_portfolio')
 							}
 							// console.log("uploadFile6");

            }
            // console.log("uploadFile7");
          },
          beforeSend: function() {
            $scope.modal_percent = false;
          },
          xhr: function() {
            var xhr = new window.XMLHttpRequest();
            xhr.upload.addEventListener("progress", function(evt) {
              if (evt.lengthComputable) {
                $scope.modal_percent_value = Math.ceil((evt.loaded / evt.total) * 100);
              }
            }, false);
            return xhr;
          },
        });
      },

	    save : function($scope, isAuthenticate, userType, origin) {
	    	// console.log("FILE SAVE: ", origin);
				var docFileType = $cookies.get('docFileTypeM');
				var obkey = $cookies.get('obkey');
				$('.modal').modal('hide');
				// if(!$scope.is_candidate_question) {
				// 	$scope.is_candidate_question = false;
				// }
				var uploadToCloud = GlobalConstant.FileUploadUrl + "/upload_to_cloud";
				if(isAuthenticate === false) {
					uploadToCloud = GlobalConstant.RegisterUploadToCloud;
				}

				if(userType && userType == 'employer_register') {
					if($cookies.get('azureContainer')) {
						obkey = $cookies.get('azureContainer');
					}
				} else if($cookies.get('cont_key') && $cookies.get('ob_key')) {
					obkey = $cookies.get('cont_key') + '/' + $cookies.get('ob_key');
				}
				// //console.log(userType)
				// console.log("apload: ", uploadToCloud, $cookies.get('uploadedFolder'));
				// console.log("apload filename: ", $cookies.get('uploadedFile'));
				// return false;

        $.ajax({
          url: uploadToCloud,
          method: 'post',
          data: {
            filename: $cookies.get('uploadedFile'),
            folder: $cookies.get('uploadedFolder'),
            obkey: obkey,
            is_candidate_question : $scope.is_candidate_question
          },
          dataType : 'json',
          async : false,
          success: function(data) {
          	var resUploadToCloud = data;
          	var resPVMDocUploaded = '';
          	// console.log('SAVE DOC UPLOAD return data: ', data);

          	// $scope.return_data = data;



            if (data.response == 200) {
              // Candidate edit profile page, updates those video/resume/supporting
              // docs buttons on edit profile page
             	if($('body.my-profile').length) {
             		 $http.get(GlobalConstant.profileApi)
		            .then(function(response) {
	                var data = response.data.data;
	                //Variables
	                angular.forEach(data, function(v,k) {
	                  $scope[k] = v;
	                })
		            });
             	}
            	$('.profile_img').attr('src', data.url)
              if(docFileType == 'image') {
              	// Employer Register page
              	var img = '<img class="'+$scope.classImg+'" src="'+data.data+'" >';
              	var imgStr = '<div class="modal-image-container">'+img+'</div>';

              	if($('#profileImageMessage').is(':visible')) {
              		$('#profileImageMessage').html(imgStr);
              	}
              	if($('#file_upload_msg').is(':visible')) {
              		$('#file_upload_msg').html('<img width="220" src="'+data.data+'" >');
              	}
              	if($('#file_upload_msg2').is(':visible')) {
              		$('#file_upload_msg2').html(imgStr);
              	}
              	// text field on the register steps form
              	$('.file-upload-input:visible').val(data.data);
              } else {
              	if(docFileType == 'resume') {
              		// $scope.fileType = 'resume';
              		var elemId = 'Form_my_file';
              	} else if(docFileType == 'portfolio') {
              		// $scope.fileType = 'portfolio';
              		// docFileType = 'supp';
              		var elemId = 'Form_my_portfolio';
              	} else if(docFileType == 'cover_letter') {
              		// $scope.fileType = 'cover_letter';
              	} else if(docFileType == 'transcript') {
              		// $scope.fileType = 'transcript';
              	}


              	if ($scope.application_objId) { // if from job appplication
              		// NEW API doc saving BEGIN
	              	var f_name = data.file_name;

	              	f_name = f_name.substr(f_name.lastIndexOf('.') + 1);
	              	var data = {data:
	              		{
	              			doc_url:data.url,
	              			doc_file_type: f_name,
	              			doc_type: docFileType,
	              			extra_data:[],
	              			job_application_id: $scope.application_objId,
	              			doc_filename: data.file_name
	              		}
	              	}

	              	// console.log("SEBENG!: ", data);
	              	ajaxService.postCandidateDoc(data).then(function(res){
			          		resUploadToCloud.id = res.id;
			          		$scope.return_uploaded_app_sq = resUploadToCloud; // SQ watch
			          		// console.log('nag apload ng sagot SQ: ', $scope.return_uploaded_app_sq);
	              	});
	              	// NEW API doc saving END
              	}

              	// still in development, separate returns of every origin of upload, these are watched scopes
		          	if (origin == 'standard_question_answer') { // app SQ answers
		          		// console.log("fota: ", resPVMDocUploaded);
		          		// resUploadToCloud.id = resPVMDocUploaded.id;
		          		// $scope.return_uploaded_app_sq = resUploadToCloud;
		          		// console.log('nag apload ng sagot SQ: ', $scope.return_uploaded_app_sq);
		          	} else if (origin == 'candidate_profile_edit_app') { // candidate docs upload
		          		$scope.return_uploaded_app_profile = {
		          			file_name:	resUploadToCloud.file_name,
		          			url: resUploadToCloud.url,
		          			doctype: docFileType
		          		};
		          		// console.log('nag apload ng payl sa profile: ', $scope.return_uploaded_app_profile);
		          	} else {
		          		$scope.return_data = resUploadToCloud;
		          	}

              }
            	alert('Data has been saved.');
            }
          }
        });
	    },

	    mobile_image_upload : function($scope) {

				var file_img = $('#mobile_image_upload')[0];
				var file = file_img.files[0];
				var formData = new FormData();
				formData.append('file',file);

        if(file.type != 'image/png' && file.type != 'image/jpg' && file.type != 'image/gif' && file.type != 'image/jpeg') {
          alert('Invalid file must be .png, .jpg, .gif extension');
          return false;
        }
				// $scope.mobile_agent_name = 'ios';
				// $scope.mobile_agent = true;
        var params = '?ob_key=' + $cookies.get('obkey');
        params += '&file_folder=image';
        params += '&is_mobile=' + $scope.mobile_agent_name;

        if($scope.mobile_agent) {
          $.ajax({
            type: "POST",
            url: GlobalConstant.FileUploadUrl + '/upload_submit_mobile' + params,
            dataType: 'json',
            data: formData,
            processData: false,  // tell jQuery not to process the data
            contentType: false,  // tell jQuery not to set contentType
	          beforeSend : function() {
	            $('#pmvImageModalNew').modal('hide');
	            $('#pmvImageModalMsg').find('.modal-body').text('Profile image saved. Please wait a few moment to update.')
	            .end().modal('show');
	          },
	          success : function(data) {
	            //console.log(data);
	            if(data) {
	              if(data.response == 200) {
	                $scope.profile_image = data.url;
	                $('#top_profile_image img').attr('src', data.url);
	              }
	            }
	          }
      		});
      	}
	  	},

	    mobile_resume_upload : function($scope) {
    	 	var fileField = document.getElementById("mobile_resume_upload");
    	 	if($scope.fileElemId) {
    	 		fileField = document.getElementById($scope.fileElemId);
    	 	}
        var file_data = fileField.files[0];
        var allowed_files = ['doc', 'docx', 'pdf', 'xls', 'indd', 'eps', 'psd', 'mp4', 'xlsx', 'ppt', 'pptx'];
        var filename = file_data.name;
        var last_dot = filename.lastIndexOf('.');
        var file_folder = 'resume';
        if($scope.docType) {
        	file_folder = $scope.docType;
        }
        var ext = filename.substr(last_dot + 1).toLowerCase();
        if (allowed_files.indexOf(ext) == -1) {
          alert('Invalid file must be .doc, .docx, .pdf, .xls, .indd, .eps, .psd, .mp4, .xlsx, .ppt, .pptx extension');
          return false;
        }
        var ob_key = $cookies.get('obkey');
        var form_data = new FormData();
        form_data.append('file', file_data);
        $scope.progressResumeValue = 0;
        $scope.progressPortfolioValue = 0;

        var data_process = 'data_progress';
        if($scope.progress_bar) {
        	data_process = $scope.progress_bar;
        }
        if ($('#'+data_process).hasClass('ng-hide')) {
          $('#'+data_process).removeClass('ng-hide');
        }

        var params = '?ob_key=' + ob_key + '&file_folder=' + file_folder;
        $.ajax({
          url: GlobalConstant.FileUploadUrl + '/upload_submit' + params,
          dataType: 'text',
          cache: false,
          contentType: false,
          processData: false,
          data: form_data,
          type: 'post',
          success: function(res) {
            var res = JSON.parse(res);
            //console.log(res)

            if (res.response == 200) {
              // alert('Uploading Success');
              if (!$('#'+data_process).hasClass('ng-hide')) {
                $scope.progressResumeValue = 0;
                $scope.progressPortfolioValue = 0;
                $('#'+data_process).addClass('ng-hide');
                fileField.value = '';
                $.ajax({
                  url: GlobalConstant.FileUploadUrl + '/upload_to_cloud',
                  type: 'post',
                  data: {
                    filename: res.filename,
                    folder: file_folder,
                    obkey: ob_key,
                    token_id: $cookies.get('token_id')
                  },
                  success: function(data) {
                  	//console.log(data)
                    if (data) {
                    	// Candidate edit profile page, updates those video/resume/supporting
											// docs buttons on edit profile page
                    	if($('body.my-profile').length) {
	                   		$http.get(GlobalConstant.profileApi)
						            .then(function(response) {
					                var data = response.data.data;
					                angular.forEach(data, function(v,k) {
					                	$scope[k] = v;
					                })
						            });
                   		}
                      alert('file saved.');
                    } else {
                      alert('Internal error.');
                    }
                    fileField.value = "";
                  }
                });
              }

            } else {
              alert('Internal error.')
            }
          },
          beforeSend: function() {
            $('#file_upload_msg').html('uploading to server please wait...');
          },
          xhr: function() {
            var xhr = new window.XMLHttpRequest();
            xhr.upload.addEventListener("progress", function(evt) {
              if (evt.lengthComputable) {
                var percentComplete = Math.ceil((evt.loaded / evt.total) * 100);
              	if(file_folder == 'resume') {
              		$scope.progressResumeValue = percentComplete;
              	} else if(file_folder == 'portfolio') {
              		 $scope.progressPortfolioValue = percentComplete;
              	}
              }
            }, false);

            // xhr.addEventListener("progress", function(evt) {
            //     if (evt.lengthComputable) {
            //         var percentComplete = evt.loaded / evt.total;
            //         //Do something with download progress
            //          //console.log('here');
            //          //console.log(percentComplete);
            //     }
            // }, false);

            return xhr;
          },
        });
	    },

		  mobile_portfolio_upload : function($scope) {
		 		var fileField = document.getElementById("mobile_portfolio_upload");
	      var file_data = fileField.files[0];
	      var allowed_files = ['doc', 'docx', 'pdf', 'xls', 'indd', 'eps', 'psd', 'mp4', 'xlsx', 'ppt', 'pptx'];
	      var filename = file_data.name;
	      var last_dot = filename.lastIndexOf('.');
	      var file_folder = 'portfolio';
	      var ext = filename.substr(last_dot + 1).toLowerCase();
	      if (allowed_files.indexOf(ext) == -1) {
	        alert('Invalid file must be .doc, .docx, .pdf,  .xls, .indd, .eps, .psd, .mp4, .xlsx, .ppt, .pptx extension');
	        return false;
	      }
	      var ob_key = $cookies.get('obkey');
	      var form_data = new FormData();
	      form_data.append('file', file_data);
	      $scope.progressPortfolioValue = 0;

	      if ($('#data_progress_portfolio').hasClass('ng-hide')) {
	        $('#data_progress_portfolio').removeClass('ng-hide');
	      }

	    	var params = '?ob_key=' + ob_key + '&file_folder=' + file_folder;
	      $.ajax({
	        url: GlobalConstant.accountPage + '/upload_submit' + params,
	        dataType: 'text',
	        cache: false,
	        contentType: false,
	        processData: false,
	        data: form_data,
	        type: 'post',
	        success: function(res) {
	          var res = JSON.parse(res);
	          if (res.response == 200) {
	            // alert('Uploading Success');
	            if (!$('#data_progress_portfolio').hasClass('ng-hide')) {
	              $scope.progressPortfolioValue = 0;
	              $('#data_progress_portfolio').addClass('ng-hide');
	              fileField.value = '';
	              $.ajax({
	                url: GlobalConstant.accountPage + '/upload_to_cloud',
	                type: 'post',
	                data: {
	                  filename: res.filename,
	                  folder: file_folder,
	                  obkey: ob_key,
	                  token_id: $cookies.get('token_id')
	                },
	                success: function(data) {
	                  if (data) {
	                  	// Candidate edit profile page, updates those video/resume/supporting
	      							// docs buttons on edit profile page
	                		if($('body.my-profile').length) {
						           	$http.get(GlobalConstant.profileApi)
									      .then(function(response) {
									        var data = response.data.data;
									        //Variables
									        angular.forEach(data, function(v,k) {
									          $scope[k] = v;
									        });
									      });
					           	}

	                    alert('file saved.');
	                  } else {
	                    alert('Internal error.');
	                  }
	                  fileField.value = "";
	                }
	              });
	            }
	          } else {
	            alert('Internal error.')
	          }
	        },
	        beforeSend: function() {
	          $('#file_upload_msg').html('uploading to server please wait...');
	        },
	        xhr: function() {
	          var xhr = new window.XMLHttpRequest();
	          xhr.upload.addEventListener("progress", function(evt) {
	            if (evt.lengthComputable) {
	              var percentComplete = Math.ceil((evt.loaded / evt.total) * 100);
	              $scope.progressPortfolioValue = percentComplete;
	            }
	          }, false);

	          // xhr.addEventListener("progress", function(evt) {
	          //   if (evt.lengthComputable) {
	          //     var percentComplete = evt.loaded / evt.total;
	          //     //Do something with download progress
	          //      ////console.log('here');
	          //      ////console.log(percentComplete);
	          //   }
	          // }, false);
	          return xhr;
	        },
	      });
	    },

	    uploadFileVideo : function($scope, file, params) {
        // //console.log(file); return false;
        // console.log("uploadFileVideo");
        var loaded = 0;
        var step = (1024*1024) * 2;
        var total = file.size;
        var start = 0;
        var progress = 0;
        var reader = new window.FileReader();

        reader.onload = function(e) {
          var xhr = new XMLHttpRequest();
          var upload = xhr.upload;

          upload.addEventListener('load',function() {
          	loaded += step;
            progress = Math.ceil((loaded/total) * 100);

             //console.log(e);
            if(progress > 100) {
              progress = 100;
            }

            // //console.log(progress)
            $scope.modal_percent_value = progress;
            if(loaded <= total) {
              blob = file.slice(loaded,loaded+step);
              reader.readAsBinaryString(blob);
            } else {
              loaded = total;
            }

            if($scope.modal_percent_value == 100) {
              var i = 0;
              var promise = $interval(function() {
                preview_new.src = 'assets/Uploads/' + $scope.folder_name + '/' + $scope.filename;
                if($scope.isSafari == false) {
                  preview_new.play();
                  $(preview_new).removeAttr('muted')
                }
                $('#save_btn').attr('data-save_type', 'video');
                $('#preview_new').attr('data-old_file', $scope.filename);
                $('#preview_new').attr('data-file_folder', $scope.folder_name);

                if($scope.isSafari == false) {
                  $scope.sectionsHideShow(true, false);
                  $scope.buttonsHideShow(true, true, true, false, false);
                } else {
                  $scope.video_source = preview_new.src;
                  $scope.saveVideo();
                }

                $interval.cancel(promise);
                if(i == 1) {
                	$interval.cancel(promise);
                }
                i++;
                   // hide percent
                	$scope.modal_percent = true;
              },3000);
            }
          },false);

          xhr.open("POST", GlobalConstant.FileUploadUrl + "/video_upload_submit" + params);
          xhr.setRequestHeader("Cache-Control", "no-cache");
          xhr.overrideMimeType("application/octet-stream");
          xhr.sendAsBinary(e.target.result);
        };
        var blob = file.slice(start,step);
        reader.readAsBinaryString(blob);
          //console.log()
      },
      video_upload_moli : function($scope, file_elm, evt) {
    	 	var fileField = document.getElementById(file_elm);
        $scope.modal_percent_value = 0;
        // Drag/Drop upload
        if (angular.isDefined(evt)) {
          fileField = evt.dataTransfer;
        }

        // delete old upload video
        if ($('#preview_new').attr('data-old_file')) {
          var filename = $('#preview_new').attr('data-old_file');
          var folder = $('#preview_new').attr('data-file_folder');
          //this.delete_old_file(filename, folder);
        }

				///Azure test
				var fileToUpload = fileField.files[0];
   			//Orig Version of file upload below, uncomment to activate
        var fileToUpload = fileField.files[0];
        var ob_key = $cookies.get('obkey');
        var d = new Date();
        var n = d.getTime();
        var splitFilename = fileToUpload.name.split('.');
        var fileExt =  splitFilename[splitFilename.length-1] ;
        var filename = n + '_' + fileToUpload.name.replace(/[^\w\s]/gi, '_') + '.'+fileExt;
        var upload_folder = 'Video';

        if ($scope.mobile_agent) {
          filename = 'camera_' + filename;
          upload_folder = 'Camera';
          // $('#mobile_camera_capture').attr('data-old_file', filename);
        }

        //var allowed_files = ['mp4', 'wma', 'mpg', 'mpeg', 'avi', 'mov'];
        var allowed_files = ['flv', 'mxf',  'gxf', 'ts', 'ps', '3gp', '3gpp',  'mpg', 'wmv',  'asf', 'avi', 'mp4',  'm4a',  'm4v',  'isma',  'ismv',  'dvr-ms',  'mkv',  'wav',  'mov']
        var last_dot = filename.lastIndexOf('.');
        var ext = filename.substr(last_dot + 1).toLowerCase();
        // //console.log(ext)
        // $scope.VideoUploadMsg = {"show": false, "message": "" }
        if (allowed_files.indexOf(ext) == -1) {
        	//$scope.VideoUploadMsg = {"show": true, "message": allowed_files.join(", ") }
          alert("Invalid file format. File extension must be one of these - "+allowed_files.join(", ")+" extension");
          return false;
        }

        var oneMb = 1048576;
        var videoSizeLimit = 1000;
        if(Math.ceil(fileToUpload.size / oneMb) > videoSizeLimit) {
          alert('Max video limit must be '+videoSizeLimit+'mb in size.');
           return false;
        }

        var rewrite_filename = filename.split(' ');
        rewrite_filename = rewrite_filename.join('_');
        var params = '?file_folder=' + upload_folder;
        params += '&filename=' + rewrite_filename;
        $scope.folder_name = upload_folder;
        $scope.filename = rewrite_filename;

        this.uploadFileVideo($scope, fileField.files[0], params);

        preview_new.src = '';
        preview_new.poster = '';
        // show percent;
        $scope.modal_percent = false;

        if ($('#modal_percent').hasClass('hidden')) {
          $('#modal_percent').removeClass('hidden');
        }
	    },
	    video_upload : function($scope, file_elm, evt, origin, data) {
	    	// console.log("STANDARD QUESTION VIDEO: ", $scope.upload_init);


	    	console.log("ORIGIN: ", $scope.upload_init, file_elm, evt, origin, data);
    		var fileField = document.getElementById(file_elm);
    		var validateFileSizeFlag = true;
        $scope.modal_percent_value = 0;

        // Drag/Drop upload
        if (angular.isDefined(evt)) {
          fileField = evt.dataTransfer;
        }

        // delete old upload video
        if ($('#preview_new').attr('data-old_file')) {
          var filename = $('#preview_new').attr('data-old_file');
          var folder = $('#preview_new').attr('data-file_folder');
          //this.delete_old_file(filename, folder);
        }
				///Azure test
				var fileToUpload = fileField.files[0];
				console.log("file to upload ", fileToUpload);
        var d = new Date();
        var n = d.getTime();
        var splitFilename = fileToUpload.name.split('.');

        var fileExt = splitFilename[splitFilename.length-1] ;
        var blobName = n + '_' + fileToUpload.name.replace(/[^a-z0-9\s]/gi, "").replace(/[_\s]/g, '-')+ '.'+fileExt;
        var containerName = $cookies.get('obkey');
				// console.log("made it! ", blobName, splitFilename);

        //Validate file format
        var allowed_files = ['flv', 'mxf',  'gxf', 'ts', 'ps', '3gp', '3gpp',  'mpg', 'wmv',  'asf', 'avi', 'mp4',  'm4a',  'm4v',  'isma',  'ismv',  'dvr-ms',  'mkv',  'wav',  'mov']
        var last_dot = blobName.lastIndexOf('.');
        var ext = blobName.substr(last_dot + 1).toLowerCase();

        if (allowed_files.indexOf(ext) == -1) {
        	$('.errorUpload').show();
          $('.errorUpload .text span').html("Invalid file format. File extension must be one of these - "+allowed_files.join(", ")+" extension")
					return false;
        }

        //Validate file size
        var oneMb = 1048576; // 1gb
        var uploadSizetoKilobyte = fileToUpload.size / 1000; // converting to KB
        var uploadSizetoMegabyte = uploadSizetoKilobyte / 1000; //converting to MB
        // var videoSizeLimit = 1024; // MB
        var videoSizeLimit = 1000; // MB
        console.log("video size: ", uploadSizetoMegabyte, uploadSizetoMegabyte / 1024);

        // if(Math.ceil(fileToUpload.size / oneMb) > videoSizeLimit) {
        if(uploadSizetoMegabyte > videoSizeLimit) { // limit to 80mb
          //alert('Max video limit must be '+videoSizeLimit+'mb in size.');
          $('.errorUpload').show();
          $('.errorUpload .text span').html('Max video limit is only 1gb.')
          validateFileSizeFlag = false;
          return false;
        } else {
        	console.log("File size validated");
        }

        var useragent = $window.navigator.userAgent;
        // console.log("made it 2! ", useragent);

        //Check origin of file upload to determine what API to use on video upload
        //Origin: Candidate edit profile page
      	console.log("postVideoUpload: ", fileToUpload);

      	if (validateFileSizeFlag) {
	      	$scope.uploading_message = "";
		    	$scope.uploading_message = "Please wait..";
		    	$scope.upload_init = 1;
		    	$scope.upload_code = 0;
		    	$scope.guid_response_profile = false

	        if (origin == 'candidate_profile_edit') {
	        	// console.log("BLAAM cndidate!");

	        	// old Arch BEGIN
	        	// var apiurl = GlobalConstant.APIRoot+'candidate/videodoc/icebreaker_video';
	        	// var data = {data:{'filename': blobName, 'user_agent_logs': useragent}} ;
	        	// this.AzureVideoUploader($scope, fileToUpload, apiurl, data, origin);
	        	// old Arch END

	        	ajaxService.postUpload(fileToUpload, 'video', '', '', useragent).then(function(response) {
	        		console.log("fileToUploaded: ", response, $scope.preview_img);

	        		if (response.success) {
								$scope.preview_img = 'loading';
	      				$scope.guid_response_profile = response.success;
			      		$scope.uploading_message = "Your video is now being prepared for publishing.."
		        		$timeout(function() {
			      			$('#pmvCameraModalNew .close').trigger('click');
			      			$scope.upload_init = 0;
			      		}, 3000);
	        		} else {
	        			$scope.uploading_message = "My apologies. An error has occured while the video is being uploaded. Please check if your internet connection is stable or contact our administrator/support. (Error code: " + response.code + ")";
	        		}
	        	});

					//Origin: Candidate application page, video questions
					} else if (origin == 'application') {
						// var apiurl = GlobalConstant.APIRoot+'candidate/videodoc/application_question';
						// angular.extend(data, {'user_agent_logs': useragent});
				     //    	var apidata = {
				     //    		data: data
				     //    	} ;

				     //    	this.AzureVideoUploader($scope, fileToUpload, apiurl, apidata);

	        	ajaxService.postUpload(fileToUpload, 'video', '', useragent).then(function(response) {
	        		console.log("fileToUploaded: ", response, $scope.preview_img);
	        		$timeout(function() {
		      			$('#pmvCameraModalNew .close').trigger('click');
		      			// $('.successUpload').hide();
		      		}, 1000)
	        	});
	        //Origin: Employer Edit Profile page.
	        } else if(origin == 'company_profile_edit') {
	        	var apiurl = GlobalConstant.APIRoot+'employer/videodoc/company_profile_video';
	        	var apidata = {data:{'filename': blobName, 'user_agent_logs': useragent}} ;
	        	this.AzureVideoUploader($scope, fileToUpload, apiurl, apidata, origin)

	        	ajaxService.postUpload(fileToUpload, 'video', '', '', useragent).then(function(response) {
	        		console.log("fileToUploaded: ", response, $scope.preview_img);
	        		$timeout(function() {
		      			$('#pmvCameraModalNew .close').trigger('click');
		      			// $('.successUpload').hide();
		      		}, 3000)
	        	});
	        //Origin: Employer create job, Job description.
	        } else if(origin == 'employer_jobs') {
	        	var apiurl = GlobalConstant.APIRoot+'employer/job/videodoc/job_video';
	        	var apidata = {data:{'filename': blobName, 'job_id': parseInt(data), 'user_agent_logs': useragent }} ;
	        	this.AzureVideoUploader($scope, fileToUpload, apiurl, apidata, origin)
	        //Origin: Redo Video page
	        } else if(origin == 'redo_video') {
	        	var apiurl = GlobalConstant.APIRoot+'video/'+data+'/redo';
	        	var apidata = {data:{ 'user_agent_logs': useragent }} ;
	        	this.AzureVideoUploader($scope, fileToUpload, apiurl, apidata, 'redo_video')

					} else if(origin == 'ref_document_standard_question') {
	        	var apiurl = GlobalConstant.APIRoot+'employer/job/videodoc/application_question';
	        	var apidata = {data:{'filename': blobName, 'job_id': parseInt(data.job_id), 'user_agent_logs': useragent, 'question_id': data.question_id }};

	        	ajaxService.postUpload(fileToUpload, 'video', '', '', useragent).then(function(response) {
	        		console.log("fileToUploaded: ", response, $scope.preview_img);
	        		$timeout(function() {
		      			$('#pmvCameraModalNew .close').trigger('click');
		      		}, 3000)
	        	});
	        	this.AzureVideoUploader($scope, fileToUpload, apiurl, apidata, 'ref_document_standard_question');
	        } else if(origin == 'standard_question_answer') {
	        	// var apiurl = GlobalConstant.CandidateRootApi + '/videodoc/application_question';
	        	// var apidata = {data:{'filename': blobName, 'application_id': data.application_id, 'question_id': data.question_id }};
	        	// this.AzureVideoUploader($scope, fileToUpload, apiurl, apidata, 'standard_question_answer');

	        	ajaxService.postUpload(fileToUpload, 'video', data.application_id, data.question_id, useragent).then(function(response) {
	        	// ajaxService.postUpload(fileToUpload, 'video', 123, data.question_id, useragent).then(function(response) {
	        		console.log("SQ answer fileToUploaded: ", response, $scope.preview_img);
	        		$scope.upload_code = response.code;

	        		if (response.success) {
	        			$scope.uploading_message = "Your video is now being prepared for publishing.."
		        		$scope.guid_response_sq_can = {
			    	 			// guid: blobName, // changed to filename
			    	 			question_id: data.question_id,
			    	 			answer_id: response.data.id
			    	 		};
			    	 		$scope.guid_response_sq_can.video_document = {
			    	 			doc_file_type:'',
			    	 			doc_filename: response.doc_filename,
			    	 			doc_url:'',
			    	 			doc_guid: response.id
			    	 		};
		        		$timeout(function() {
			      			$('#pmvCameraModalNew .close').trigger('click');
			      			// $('.successUpload').hide();
			      			$scope.upload_init = 0;
			      		}, 2000);
	        		} else {
	        			$scope.uploading_message = "My apologies. An error has occured while the video is being uploaded. Please check if your internet connection is stable or contact our administrator/support. (Error code: " + response.code + ")";
	        		}
	        	});

					} else {
					//Use old video IF there are video function	that not updated to REST API.
						this.video_upload_moli($scope, fileToUpload)
					}
      	}
	    },
	    AzureUploadResponseHandler : function($scope, data) {
	    	// console.log("Azure handler: ", data, $scope);
	    	//Set local storage for
    	 	localStorage.setItem('VideoUploadResponseData', JSON.stringify(data));
	    },
	    AzureVideoUploader : function($scope, file, apiURL, data, origin) {
	    	console.log("Azure origin and API: ", file, apiURL, data, origin);

	    	if (origin == 'ref_document_standard_question') { // initialize scope value, for SQ employer
	    		var guid_response_sq_emp = data.data;
	    		// console.log("SQ CREATE: ", guid_response_sq_emp);
	    	}

	    	$scope.guid_response = ""; //reset upload success indicator;
	    	$scope.guid_response_profile = "";
	    	var that = this;
	    	if (angular.isUndefined(apiURL) || angular.isUndefined(data)) {
	    		//console.log('API url and data not defined')
	    		return false;
	    	}

	    	//console.log(file)
	     	// Provides a Stream for a file in webpage, inheriting from NodeJS Readable stream.
		    var Stream = require('stream');
		    var util = require('util');
		    var Buffer = require('buffer').Buffer;

		    function FileStream(file, opt) {
		    	console.log("FileStream: ", file, opt);
		      Stream.Readable.call(this, opt);
		      this.fileReader = new FileReader(file);
		      this.file = file;
		      this.size = file.size;
		      this.chunkSize = 1024 * 1024 * 4; // 4MB
		      this.offset = 0;
		      var _me = this;

		      this.fileReader.onloadend = function loaded(event) {
		        var data = event.target.result;
		        var buf = Buffer.from(data);
		        _me.push(buf);
		      }
		    }

		    util.inherits(FileStream, Stream.Readable);
		    FileStream.prototype._read = function() {
		    	console.log("damn son");
		      if (this.offset > this.size) {
		        this.push(null);
		      } else {
		        var end = this.offset + this.chunkSize;
		        var slice = this.file.slice(this.offset, end);
		        this.fileReader.readAsArrayBuffer(slice);
		        this.offset = end;
		      }
		    }

		    var fileToUpload = file;
		    var d = new Date();
        var n = d.getTime();
        var splitFilename = fileToUpload.name.split('.');
        var fileExt =  splitFilename[splitFilename.length-1] ;

        var blobName = n + '_' + fileToUpload.name.replace(/[^a-z0-9\s]/gi, "").replace(/[_\s]/g, '-')+ '.'+fileExt;
        var containerName = $cookies.get('obkey');

		    $('.errorUpload').hide();
 				$('#pmvCameraModalNew  .preparing').show();
 				that.buttonsHideShow($scope, true,true,true,true,true);

			  //get SAS URL from PvM API
			  console.log("before submit AzureUpload: ", data);
	    	$http.post(apiURL,  data)
	    	.then(function(response) {
	    	 	//connected to api
	    	 	$('#pmvCameraModalNew  .preparing').hide();

	    	 	// console.log("GUID: ", response);
	    	 	var icebreakerguid = response.data.data.guid;

	    	 	if (origin == 'candidate_profile_edit' || origin == 'employer_jobs') {
	    	 		$scope.guid_response_profile = icebreakerguid;
	    	 		$cookies.put('icebreakerguid', icebreakerguid, {'path':'/' });
	    	 	}

	    	 	if (origin == 'ref_document_standard_question') {
	    	 		$scope.const_video = guid_response_sq_emp;
	    	 		$scope.const_video.video_document = {
	    	 			doc_file_type:'',
	    	 			doc_filename: guid_response_sq_emp.filename,
	    	 			doc_url:'',
	    	 			doc_guid: icebreakerguid
	    	 		};

	    	 		$scope.guid_response_sq_emp = $scope.const_video;

	    	 		// $scope.guid_response = icebreakerguid; // Role Appplication $scope?
	    	 		// console.log('ref_document_standard_question', $scope.guid_response_sq_emp);
	    	 	}

					if (origin == 'standard_question_answer') {
	    	 		$scope.guid_response_sq_can = {
	    	 			// guid: blobName, // changed to filename
	    	 			question_id: data.data.question_id
	    	 		};
	    	 		$scope.guid_response_sq_can.video_document = {
	    	 			doc_file_type:'',
	    	 			doc_filename: data.data.filename,
	    	 			doc_url:'',
	    	 			doc_guid: icebreakerguid
	    	 		};
	    	 	}

	    	 	//Set local storage for
	    	 	localStorage.setItem('icebreakerguid',icebreakerguid);
	    	 	var path = response.data.data.sas_url.split('?');
	    	 	var sasKey = path[1];
	    	 	var path2 = path[0].split('/');
	    	 	// var blobStorageUri = 'https://'+path2[2];

	    	 	var blobStorageUri = path2[2];

	    	 	//var containerName = $cookies.get('obkey');
	    	 	var containerName = path2[3]
	    	 	//console.log(containerName)
	    	 	var fileReader = new FileReader();
    			fileReader.readAsArrayBuffer(file);

	    		//Uploading file
	    		var blobService = AzureStorage.createBlobServiceWithSas(blobStorageUri, sasKey).withFilter(new AzureStorage.ExponentialRetryPolicyFilter());

	    		//File uploaded
	    		if (!blobService)
      		return;

      		$('#pmvCameraModalNew .progressContainer').show();
      		//connected to api
	    	 	$scope.preparing = false;

      		var fileStream = new FileStream(file);
			    // Make a smaller block size when uploading small blobs
			    var blockSize = file.size > 1024 * 1024 * 32 ? 1024 * 1024 * 4 : 1024 * 512;
			    var options = {
			      storeBlobContentMD5: false,
			      blockSize: blockSize
			    };

			    //console.log(options)
			    //console.log(blobService)
			    blobService.singleBlobPutThresholdInBytes = blockSize;
    			var finishedOrError = false;
    			var speedSummary = blobService.createBlockBlobFromStream(containerName, blobName, fileStream, file.size, options,
		      function (error, result, response) {
		        finishedOrError = true;
		        if (error) {
		          $scope.uploaderror = true;
		          $scope.errorMsg = 'Sorry, it looks like your internet connection dropped out, can you try uploading again';
		          $('.errorUpload').show();
		          $('.errorUpload .text span').html($scope.errorMsg)
		        } else {
		        	$('.finalize').show();
		        	$('.progressContainer').hide();
		        	//Not sure what this is but karan said to put it here
		        	$http.put(GlobalConstant.APIRoot+'video/'+icebreakerguid+'/uploaded',  {data:{'filename': blobName}})
		        	.then(function(response) {
		        		$('.finalize').hide();
		        		$('.successUpload').show();
		          	$('.progressContainer').hide();

		          	// console.log("upload Azure media response: ", response);
		          	if (response.status == 204) {
		          		that.AzureUploadResponseHandler ($scope, data);
		          		that.buttonsHideShow($scope, true,true,true,true,false);


		          		if (origin == 'candidate_profile_edit') {
					    	 		$scope.app_video_uploaded_success = 1;
					    	 	}

		          		// console.log("success: ", that);
		          		// console.log("UPLOAD PROFIL PIC ORIGIN: ", origin);

		          		$timeout(function() {
		          			$('#pmvCameraModalNew .close').trigger('click');
		          			$('.successUpload').hide();
		          		}, 3000)
		          	} else {
		          		// console.log("Something went wong ", response);
		          	}
		        	});
		        }
		      });

			    function refreshProgress () {
			      $timeout(function () {
			        if (!finishedOrError) {
			          var process = speedSummary.getCompletePercent();

			          //Create Progress bar using the variables below.
			          $scope.dynamic = Math.min(100, parseInt(process));
			          $scope.fileloader = false;

			          $('#pmvCameraModalNew .progressbar span').html($scope.dynamic + '%');
			          $('#pmvCameraModalNew .progressbar').css('width',  $scope.dynamic + '%')
			          if ($scope.dynamic == 100) {
			          	$('#pmvCameraModalNew .progressContainer').hide()
			          }
			          //console.log($scope.dynamic)
			          refreshProgress();
			        }
			      }, 200);
			    }

			    refreshProgress();
				},function(response) {
					//Check if there is a specified origin to pass error messages
					if (angular.isDefined(origin) ) {
						//console.log('defined origin')
						if (origin == 'redo_video' && response.status == 500) {
							$('.preparing').hide()
							$('.errorUpload').show();
							$('.errorUpload .text span').html('guid is either removed or invalid')
						}
					}
        });
	    },

     	//Save Recoded video
	    saveVideo : function($scope, origin, data) {
	    	console.log("RECORD VIDEO: ", data, origin);
	    	$scope.uploading_message = "";
	    	$scope.uploading_message = "Please wait..";
	    	$scope.upload_init = 1;
	    	$scope.upload_code = 0;
	    	$scope.guid_response_profile = false;

				var save_btn = $('#save_btn');
				var ob_key = $cookies.get('obkey');
				var folder_type = save_btn.attr('data-save_type');
				var doc_type = 'icebreaker_video';
				if($scope.doc_type) {
				 	doc_type = $scope.doc_type;
				}

				// console.log("folder_type: ", folder_type);

				if (folder_type == 'camera') {
					// show percent
					// if ($('#modal_percent').hasClass('hidden')) {
					//    $('#modal_percent').removeClass('hidden')
					// }
				 	filename = save_btn.attr('data-recorded');
					if (!filename) {
						return false;
					}

					console.log("recorded vid filename: ", filename);
					var useragent = $window.navigator.userAgent;
					//$scope.modal_percent = false;
					// New video upload process
					var videoblob = $scope.recordVideoSteam.getBlob();
					var fileToUpload = new File([videoblob], filename, {type: 'video/mp4', lastModified: Date.now()});

					console.log("recorded videoblob: ". videoblob);
					console.log("recroded filetoupload: ", fileToUpload);

					if (origin == 'candidate_profile_edit') {
						// var apiurl = GlobalConstant.APIRoot+'candidate/upload/video';
	        	// var apiurl = GlobalConstant.APIRoot+'candidate/videodoc/icebreaker_video';
	        	// var data = {data:{'filename': filename, 'user_agent_logs': useragent }};
	        	// this.AzureVideoUploader($scope, fileToUpload, apiurl, data, origin)

	        	// New Arch BEGIN
	        	ajaxService.postUpload(fileToUpload, 'video', '', '', useragent).then(function(response) {
	        		console.log("fileToUploaded: ", response, $scope.preview_img);

	        		if (response.success) {
	        			$scope.preview_img = "loading";
	        			$scope.guid_response_profile = response.success;
	        			$scope.uploading_message = "Your video is now being prepared for publishing.."
		        		$timeout(function() {
			      			$('#pmvCameraModalNew .close').trigger('click');
			      			$scope.upload_init = 0;
			      		}, 3000);
	        		} else {
	        			$scope.uploading_message = "My apologies. An error has occured while the video is being uploaded. Please check if your internet connection is stable or contact our administrator/support. (Error code: " + response.code + ")";
	        		}
	        	});
	        	// New Arch BEGIN
					} else if (origin == 'application') {
						var apiurl = GlobalConstant.APIRoot+'candidate/videodoc/application_question';
						angular.extend(data, {'user_agent_logs': useragent })
	        	var data = {
	        		data: data
	        	};

	        	this.AzureVideoUploader($scope, fileToUpload, apiurl, data, origin)
	        } else if(origin == 'company_profile_edit') {
						var apiurl = GlobalConstant.APIRoot+'employer/videodoc/company_profile_video';
	        	var data = {data:{'filename': filename, 'user_agent_logs': useragent }} ;

	        	this.AzureVideoUploader($scope, fileToUpload, apiurl, data, origin)
	        //Origin: Employer create job, Job description.

	        	// ajaxService.postUpload(fileToUpload, 'video', '', '', useragent).then(function(response) {
	        	// 	console.log("fileToUploaded: ", response, $scope.preview_img);
	        	// 	$timeout(function() {
		      		// 	$('#pmvCameraModalNew .close').trigger('click');
		      		// 	// $('.successUpload').hide();
		      		// }, 2000)
	        	// });
	        } else if(origin == 'employer_jobs') {
	        	var apiurl = GlobalConstant.APIRoot+'employer/job/videodoc/job_video';
	        	var apidata = {data:{'filename': filename, 'job_id': parseInt(data) , 'user_agent_logs': useragent }} ;

	        	this.AzureVideoUploader($scope, fileToUpload, apiurl, apidata, origin);
	        //Origin: Redo video page
	        } else if(origin == 'redo_video') {
	        	var apiurl = GlobalConstant.APIRoot+'video/'+data+'/redo';
	        	var apidata = {data:{ 'user_agent_logs': useragent  }} ;

	        	this.AzureVideoUploader($scope, fileToUpload, apiurl, apidata, 'redo_video');
					} else if(origin == 'ref_document_standard_question') {
	        	var apiurl = GlobalConstant.APIRoot+'employer/job/videodoc/application_question';
	        	var apidata = {data:{'filename': filename, 'job_id': parseInt(data.job_id), 'user_agent_logs': useragent, 'question_id': data.question_id }};
	        	this.AzureVideoUploader($scope, fileToUpload, apiurl, apidata, origin)

	        	ajaxService.postUpload(fileToUpload, 'video', '', '', useragent).then(function(response) {
	        		console.log("fileToUploaded: ", response, $scope.preview_img);
	        		$timeout(function() {
		      			$('#pmvCameraModalNew .close').trigger('click');
		      			// $('.successUpload').hide();
		      		}, 2000);
	        	});
					} else if(origin == 'standard_question_answer') {
	        	// var apiurl = GlobalConstant.CandidateRootApi + '/videodoc/application_question';
	        	// var apidata = {data:{'filename': filename, 'application_id': data.application_id, 'question_id': data.question_id }};

        		// this.AzureVideoUploader($scope, fileToUpload, apiurl, apidata, 'standard_question_answer');

        		ajaxService.postUpload(fileToUpload, 'video', data.application_id, data.question_id, useragent).then(function(response) {
	        		console.log("fileToUploaded: ", response, $scope.preview_img);

	        		if (response.success) {
			      		$scope.uploading_message = "Your video is now being prepared for publishing.."
		        		$scope.guid_response_sq_can = {
			    	 			// guid: blobName, // changed to filename
			    	 			question_id: data.question_id,
			    	 			answer_id: response.data.id
			    	 		};
			    	 		$scope.guid_response_sq_can.video_document = {
			    	 			doc_file_type:'',
			    	 			doc_filename: response.doc_filename,
			    	 			doc_url:'',
			    	 			doc_guid: response.id
			    	 		};
		        		$timeout(function() {
			      			$('#pmvCameraModalNew .close').trigger('click');
			      			// $('.successUpload').hide();
			      			$scope.upload_init = 0;
			      		}, 2000);

	        		} else {
	        			$scope.uploading_message = "My apologies. An error has occured while the video is being uploaded. Please check if your internet connection is stable or contact our administrator/support. (Error code: " + response.code + ")";
	        		}
	        	});
					}else{
						this.PostBlob($scope, $scope.recordAudio.getBlob(), $scope.recordVideoSteam.getBlob(), filename);
					}
					return false
				 // Save Uploaded Video
				} else if (folder_type == 'video') {
					// Browser not Safari
					if($scope.isSafari == false) {
						var fileField = document.getElementById("video_upload_modal_new");
						var filename = $('#preview_new').attr('src');
					} else {
						// Safari Browser
						var fileField = document.getElementById("video_upload_modal_new_safari");
						var filename = $scope.video_source;
					}

					var fileLastIndex = filename.lastIndexOf('/') + 1;
					 filename = filename.substr(fileLastIndex);

					if (!filename) {
					  return false;
					}

					var data = {
				    filename: filename,
				    doc_type: doc_type,
				    token_id: $cookies.get('token_id'),
				    user_type : $cookies.get('ut')
				  };

					if($scope.question_id) {
						data.question_id = $scope.question_id;
					}

					$.ajax({
				   	url: GlobalConstant.FileUploadUrl + '/save_uploaded_file',
				   	type: 'post',
			    		cache : false,
				   	data: data,
				   	success: function(data) {
					    if (data) {
					     	if($scope.nextStep == 'application_questions') {
		        		 	alert('Your video is being processed, You can click on continue to finish your application')
			        	} else {
		        		 	alert('Your video is currently being processed. You can keep browsing the website while it is loading.')
			        	}
					       $('#pmvCameraModalNew').modal('hide');
					    } else {
					      alert('Internal error.');
					    }

					    fileField.value = "";

				     	// "job/application page", in APPICATION QUESTIONS STEP,
				     	// put value on this, to pass the validation on continue button
	            if($scope.doc_type == 'question' && $scope.appQuestion) {
			           	$scope.appQuestion.answer[$scope.question_id] = true;
			           	$scope.last_id = data;
		           // Employer crete role
		           } else if($scope.doc_type == 'create role') {
		           	$scope.last_id = data;
		           }
					   }
					});
				}
    	},

		  mobile_video_upload : function($scope) {
				var fileField = document.getElementById("mobile_video_upload");
		    var fileToUpload = fileField.files[0];
		    var ob_key = $cookies.get('obkey');
		    var d = new Date();
		    var n = d.getTime();
		    var filename = n + '_' + fileToUpload.name;
		    var allowed_files = ['mp4', 'wma', 'mpg', 'mpeg', 'wmv', 'avi', 'mov'];
		    var last_dot = filename.lastIndexOf('.');
		    var ext = filename.substr(last_dot + 1).toLowerCase();

		    if (allowed_files.indexOf(ext) == -1) {
		    alert("Invalid Video file must be 'mp4','wma','mpg','mpeg','wav','avi' extension");
		    	return false;
		    }

		    var chunksize = 1000000 // 1MB
		    var chunks = Math.ceil(chunksize / fileToUpload.size);
		    chunks = chunks > 1 ? 1 : chunks;

		    if ($('#video_progress').hasClass('ng-hide')) {
		    	$('#video_progress').removeClass('ng-hide');
		    }

			  var uploadChunk = function(fileToUpload, chunk) {
			    var xhr = new XMLHttpRequest();
			    var uploadStatus = xhr.upload;

			    uploadStatus.addEventListener("progress", function(ev) {
			      if (ev.lengthComputable) {
				      var percent = Math.ceil((ev.loaded / ev.total) * 100);
				      $scope.progressValue = percent;
			      }
			    }, false);

			    uploadStatus.addEventListener("error", function(ev) {
			      $("#error").html(ev)
			    }, false);
			    uploadStatus.addEventListener("load", function(ev) {
			      $("#error").html("uploading file to server, please wait...")
			    }, false);

			    xhr.addEventListener('readystatechange', function(e) {
			      if (this.readyState === 4) {
				      $.ajax({
				        url: GlobalConstant.FileUploadUrl + '/save_uploaded_file',
				        type: 'post',
				        data: {
					        filename: filename,
					        doc_type: 'icebreaker_video',
					        ob_key: ob_key,
					        token_id: $cookies.get('token_id')
				        },
				        success: function(data) {
					        if (data) {
					          $scope.progressValue = 0;
					          $('#video_progress').addClass('ng-hide');
					          $('#video_placeholder').attr('src', 'themes/bbt/images/placeholder_encoding.png');
					          if($scope.nextStep == 'application_questions') {
							 				alert('Your video is being processed, You can click on continue to finish your application')
					        	} else {
					      		 	alert('Your video is currently being processed. You can keep browsing the website while it is loading.')
					        	}
					        } else {
					          alert('Internal error.');
					        }
					        fileField.value = "";
				        }
				      });
			    	}
		    	});

			    var start = chunksize * chunk;
			    var end = start + (chunksize - 1)
			    if (end >= fileToUpload.size) {
			      end = fileToUpload.size - 1;
			    }
			    var params = '?file_folder=video';
			    xhr.open("POST", GlobalConstant.FileUploadUrl + "/video_upload_submit" + params, true);
			    xhr.setRequestHeader("Cache-Control", "no-cache");
			    xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");
			    // xhr.setRequestHeader("Content-Type", "multipart/form-data");
			    // xhr.setRequestHeader("content-type","multipart/form-data; charset=utf-8; boundary=" + Math.random().toString().substr(2));
			    xhr.setRequestHeader("X-File-Name", filename);
			    xhr.setRequestHeader("X-File-Size", fileToUpload.size);
			    xhr.setRequestHeader("X-File-Type", fileToUpload.type);
			    xhr.setRequestHeader("Content-Range", start + "-" + end + "/" + fileToUpload.size);
			    xhr.send(fileToUpload);
			  }

		    for (var c = 0; c < chunks; c++) {
		    	uploadChunk(fileToUpload, c);
		    }
	  	},

	    startVideo : function($scope) {
				this.sectionsHideShow($scope, true, false);
      	this.buttonsHideShow($scope, true,true,true,false,false);
	      if ($('#preview_new').attr('src')) {
	        $('#preview_new').attr('src', '');
	        window.stream = '';
	      }

	      !window.stream && navigator.getUserMedia({
	        audio: true,
	        video: true
	      }, function(stream) {
	        window.stream = stream;
	        if(preview_new.length) {
        	 	preview_new[0].src = window.URL.createObjectURL(stream);
	        	//preview_new[0].play();
	        	preview_new[0].pause();
	        } else {
        	 	preview_new.src = window.URL.createObjectURL(stream);
	        	//preview_new.play();
	        	preview_new.pause();
	        }
	        return 1;
	      }, function(error) {
	        alert(JSON.stringify(error, null, '\t'));
	        return 0;
	      });

	       this.buttonsHideShow($scope, false,true,true,true,true);

	    },

	    recordVideo : function($scope) {
    	 	var onstream = function() {
    	 		if(preview_new.length) {
        	 	preview_new[0].src = window.URL.createObjectURL(stream);
	        	preview_new[0].play();
	        	// preview_new[0].muted = false;
	        } else {
      	 	 	preview_new.src = window.URL.createObjectURL(stream);
      			preview_new.play();
	        	// preview_new.muted = false;
	        }

	        $scope.recordAudio = RecordRTC(stream, {
	          // bufferSize: 16384,
	          onAudioProcessStarted: function() {
	            // if (!isFirefox) {
	            $scope.recordVideoSteam.startRecording();
	            //   }
	          }
	        });

	        $scope.recordVideoSteam = RecordRTC(stream, {
	          type: 'video'
	        });

        	$scope.recordAudio.startRecording();
      	}
	      !window.stream && navigator.getUserMedia({
	        audio: true,
	        video: true
	      }, function(stream) {
	        window.stream = stream;
	        onstream();
	      }, function(error) {
	        alert(JSON.stringify(error, null, '\t'));
	      });

	      window.stream && onstream();
	      this.buttonsHideShow($scope, true,true,false,true,true);
	    },

	    stopVideo : function($scope) {
	      $('#save_btn').attr('data-save_type', 'camera');
	      var fileName = Math.round(Math.random() * 99999999) + 99999999;
	      fileName = 'camera_' + fileName + '.mp4';
	      $('#save_btn').attr('data-recorded', fileName);
	      // reset percent to 0
	      $scope.modal_percent_value = 0;

	      $scope.recordAudio.stopRecording(function(audioUrl) {
	        if(preview_new.length) {
	        	preview_new[0].src = audioUrl;
	        } else {
	        	preview_new.src = audioUrl;
	        }

	        $scope.recordVideoSteam.stopRecording(function(videoUrl) {
	        	if(preview_new.length) {
	        		preview_new[0].muted = false;
	        	} else {
	        		preview_new.muted = false;
	        	}
						stream.stop();
						window.stream = '';
	        });
	      });

	      this.buttonsHideShow($scope, true,false,true,false,true);
	    },

     	videoUpload : function($scope, file_elm, evt) {
        	var fileField = document.getElementById(file_elm);
	        $scope.modal_percent_value = 0;
	        // Drag/Drop upload
	        if (evt) {
	          fileField = evt.dataTransfer;
	        }

	        // delete old upload video
	        if ($('#preview_new').attr('data-old_file')) {
	          var filename = $('#preview_new').attr('data-old_file');
	          var folder = $('#preview_new').attr('data-file_folder');
	          $scope.delete_old_file(filename, folder);
	        }

	        var fileToUpload = fileField.files[0];
	        var ob_key = $cookies.get('obkey');
	        var d = new Date();
	        var n = d.getTime();
	        var filename = n + '_' + fileToUpload.name;
	        var upload_folder = 'Video';

	        if ($scope.mobile_agent) {
	          filename = 'camera_' + filename;
	          upload_folder = 'Camera';
	          // $('#mobile_camera_capture').attr('data-old_file', filename);
	        } else {
	          // $('#Form_video_upload_modal').attr('data-old_file', filename);
	        }

	        var allowed_files = ['mp4', 'wma', 'mpg', 'mpeg', 'wmv', 'avi', 'mov'];
	        var last_dot = filename.lastIndexOf('.');
	        var ext = filename.substr(last_dot + 1).toLowerCase();

	        if (allowed_files.indexOf(ext) == -1) {
	          alert("Invalid Video file must be 'mp4','wma','mpg','mpeg','wav','avi' extension");
	          return false;
	        }

	        var oneMb = 1048576;
	        var videoSizeLimit = 150;
	        if(Math.ceil(fileToUpload.size / oneMb) > videoSizeLimit) {
	          alert('Max video limit must be '+videoSizeLimit+'mb in size.');
	          return false;
	        }


	        var chunksize = 1000000 // 1MB
	        var chunks = Math.ceil(chunksize / fileToUpload.size);
	        chunks = chunks > 1 ? 1 : chunks;
	        preview_new.src = '';
	        preview_new.poster = '';
	        // show percent;
	        $scope.modal_percent = false;

	        if ($('#modal_percent').hasClass('hidden')) {
	          $('#modal_percent').removeClass('hidden');
	        }

        	var uploadChunk = function(fileToUpload, chunk) {
          	var xhr = new XMLHttpRequest();
          	var uploadStatus = xhr.upload;
          	uploadStatus.addEventListener("progress", function(ev) {
	            if (ev.lengthComputable) {
	              // Percent progress
	              $scope.modal_percent_value = Math.ceil((ev.loaded / ev.total) * 100);
	            }
            }, false);

	          xhr.addEventListener('readystatechange', function(e) {
	            if (this.readyState === 4) {
	              var rewrite_filename = filename.split(' ');
	              rewrite_filename = rewrite_filename.join('_');
	              preview_new.src = 'assets/Uploads/' + upload_folder + '/' + rewrite_filename;

	              if($scope.isSafari == false) {
	                preview_new.play();
	                preview_new.muted = false;
	              }

	              $('#save_btn').attr('data-save_type', 'video');
	              $('#preview_new').attr('data-old_file', rewrite_filename);
	              $('#preview_new').attr('data-file_folder', upload_folder);

	              if($scope.isSafari == false) {
	                $scope.sectionsHideShow(true, false);
	                $scope.buttonsHideShow(true, true, true, false, false);
	              } else {
	                $scope.video_source = preview_new.src;
	                $scope.saveVideo();
	              }
	              // hide percent
	              $scope.modal_percent = true;
	            }
	        	});

	          var start = chunksize * chunk;
	          var end = start + (chunksize - 1)
	          if (end >= fileToUpload.size) {
	            end = fileToUpload.size - 1;
	          }
	          var params = '?file_folder=' + upload_folder;
	          // console.log(GlobalConstant.FileUploadUrl + "/video_upload_submit" + params);
	          // xhr.open("POST", GlobalConstant.accountPage + "/video_upload_submit" + params, true);
	          xhr.open("POST", GlobalConstant.FileUploadUrl + "/video_upload_submit" + params, true);
	          xhr.setRequestHeader("Cache-Control", "no-cache");
	          xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");

	          xhr.setRequestHeader("X-File-Name", filename);
	          xhr.setRequestHeader("X-File-Size", fileToUpload.size);
	          xhr.setRequestHeader("X-File-Type", fileToUpload.type);
	          xhr.setRequestHeader("Content-Range", start + "-" + end + "/" + fileToUpload.size);
	          xhr.send(fileToUpload);
      	}

        for (var c = 0; c < chunks; c++) {
          uploadChunk(fileToUpload, c);
        }
      },

	    changeVideo : function($scope) {
	    	// $scope.hidePreview();
				this.sectionsHideShow($scope, false,true);
				this.buttonsHideShow($scope, false,false,false,false,false);

				if ($('#preview_new').attr('data-old_file')) {
					var filename = $('#preview_new').attr('data-old_file');
					var folder = $('#preview_new').attr('data-file_folder');
					this.delete_old_file(filename, folder);
					$('#preview_new').attr('src', '');
				} else if($('#preview_img_new').attr('data-old_file')) {
					var filename = $('#preview_img_new').attr('data-old_file');
					var folder = $('#preview_img_new').attr('data-file_folder');
					this.delete_old_file(filename, folder);
				} else if($('#preview_img_newRE').attr('data-old_file')) {
					var filename = $('#preview_img_newRE').attr('data-old_file');
					var folder = $('#preview_img_newRE').attr('data-file_folder');
					this.delete_old_file(filename, folder);
				} else if(('#preview_img_new_safari').attr('data-old_file')) {
					var filename = $('#preview_img_new_safari').attr('data-old_file');
					var folder = $('#preview_img_new_safari').attr('data-file_folder');
					this.delete_old_file(filename, folder);
				}
	    },

	    delete_old_file : function(filename, folder) {
				$.ajax({
	        url: GlobalConstant.FileUploadUrl + "/delete_recorded_video",
	        method: 'post',
	        data: {
	          filename: filename,
	          file_folder: folder
	        },
	        success: function(data) {
	          // reset target attributes
						$('#preview').attr('data-old_file', "");
						$('#preview').attr('data-file_folder', "");
						$('#preview_img_new').attr('data-old_file', "");
						$('#preview_img_new').attr('data-file_folder', "");
						$('#resume_save').attr('data-folder','');
						$('#resume_save').attr('data-filename','');
						$('#image_save').attr('data-folder','');
						$('#image_save').attr('data-filename','');
						$('#portfolio_save').attr('data-folder','');
						$('#portfolio_save').attr('data-filename','');
	        }
      	});
	    },

	    PostBlob : function($scope, audioBlob, videoBlob, fileName) {
	    	if(!videoBlob) {
	    		alert('Failed saving blob data. Please check video/audio settings browser');
	    		this.changeVideo($scope)
	    		$scope.modal_percent = true;
	    		return false
	    	}

	      var formData = new FormData();
	      formData.append('filename', fileName);
	      formData.append('audio-blob', audioBlob);
	      formData.append('video-blob', videoBlob);
	      var params = "?ob_key=" + $cookies.get('obkey') +
	        "&doc_type=icebreaker_video" +
	        "&token_id=" + $cookies.get('token_id') +
	        "&file_folder=camera";

	      if($scope.question_id) {
	       	params += '&question_id='+$scope.question_id;
	      }

	      this.xhrVideo($scope, GlobalConstant.FileUploadUrl + "/camera_upload_submit" + params, formData, fileName, videoBlob);
    	},

    	xhrVideo : function($scope, url, formData, filename, videoBlob,  callback) {
	      var request = new XMLHttpRequest();
	      var uploadStatus = request.upload;

	      uploadStatus.addEventListener("progress", function(ev) {
	        if (ev.lengthComputable) {
	          $scope.modal_percent_value = Math.ceil((ev.loaded / ev.total) * 100);
	        }
	      }, false);

	      var that = this;
	      request.onreadystatechange = function() {
	        if (request.readyState == 4 && request.status == 200) {
	          // hide percent progress
	          //    if(!$('#modal_percent').hasClass('hidden')) {
	          //  $('#modal_percent').addClass('hidden');
	          // }
	          $scope.modal_percent = true;
	          if($('#pmvCameraModal').data('bs.modal')) {
	            $('#save').attr('data-recorded', filename);
	            $('#preview').attr('data-old_file', filename);
	            $('#preview').attr('data-file_folder', 'camera');
	          } else if($('#pmvCameraModalNew').data('bs.modal')) {
	            $('#save_btn').attr('data-recorded', filename);
	            $('#preview_new').attr('data-old_file', filename);
	            $('#preview_new').attr('data-file_folder', 'camera');
	          }

	          if (request.responseText == 500) {
	            alert('Error: Video not upload, please try again');
	            return false;
	          }

	          that.postBlobCallBack(filename, $scope);
	        }
	      };

	      request.open('POST', url);
	      request.send(formData);
    	},

    	postBlobCallBack : function(filename, $scope) {
	      var ob_key = $cookies.get('obkey');
	      var doc_type = 'icebreaker_video';
	      if($scope.doc_type) {
	      	doc_type = $scope.doc_type;
	      }
	      // var filename = $('#record').attr('data-recorded');

	      var data = {
      	 	filename: filename,
          ob_key: ob_key,
          doc_type: doc_type,
          token_id: $cookies.get('token_id'),
          user_type : $cookies.get('ut')
      	}
	       	// queston -> candiate
	       	// crete role -> employer
	      if($scope.doc_type == 'question' && $scope.question_id || $scope.doc_type == 'create role' && $scope.question_id) {
	      	data.question_id = $scope.question_id;
	      	if($scope.last_id) {
	      		data.last_id = $scope.last_id;
	      	}
	      }

	      // alert($scope.doc_type)
	      // alert($scope.question_id)
	      // alert($scope.last_id)

	      $.ajax({
	        url: GlobalConstant.FileUploadUrl + "/save_uploaded_file",
	        'type': 'post',
	        data: data,
	        success: function(data) {
	        	if($scope.nextStep == 'application_questions') {
	        		alert('Your video is being processed, You can click on continue to finish your application')
	        	} else {
	        		alert('Your video is currently being processed. You can keep browsing the website while it is loading.');
	        	}

	          //if($('#pmvCameraModal').data('bs.modal')) {
	            $('#save').attr('data-save_type', '')
	            $('#save').attr('data-recorded', '')
	            $('#pmvCameraModal').modal('hide');

	          // } else if($('#pmvCameraModalNew').data('bs.modal')) {
	            $('#save_btn').attr('data-save_type', '')
	            $('#save_btn').attr('data-recorded', '')
	            $('#pmvCameraModalNew').modal('hide');
	          // }

					   // Candate question
					   // "job/application page", in APPICATION QUESTIONS STEP,
						// put value on this, to pass the validation on continue button
	          if($scope.doc_type == 'question' && $scope.appQuestion) {
	           	$scope.appQuestion.answer[$scope.question_id] = true;
	           	$scope.last_id = data;

	           	// Employer crete role
	          } else if($scope.doc_type == 'create role') {
	           	$scope.last_id = data;
	          }
	        }
	      });
	    },

	    startVideoImage : function($scope) {
				var preview_img_new = document.getElementById('preview_img_new');
				if($('#pmvImageModalEmployerRegister').is(':visible')) {
	    		preview_img_new = document.getElementById('preview_img_newRE');
	    	}

				navigator.getUserMedia = navigator.getUserMedia || navigator.mediaDevices.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia || navigator.msGetUserMedia;
	      this.sectionsHideShow($scope, true,false);
	      this.buttonsHideShow($scope, false,true,true,true,true)

	      if ($('#preview_img_new').attr('src')) {
	        $('#preview_img_new').attr('src', '');
	        window.stream = '';
	      }

	      if ($('#preview_img_newRE').attr('src')) {
	        $('#preview_img_newRE').attr('src', '');
	        window.stream = '';
	      }

	      !window.stream && navigator.getUserMedia({
	        audio: false,
	        video: true
	      }, function(stream) {
	        window.stream = stream;
	        preview_img_new.src = window.URL.createObjectURL(stream);
	        preview_img_new.play();

	      }, function(error) {
	        alert(JSON.stringify(error, null, '\t'));
	      });
	    },

	    take_photo : function($scope) {
				var errorCallback = function(e) {
				};

        // Not showing vendor prefixes.
       	navigator.getUserMedia = navigator.getUserMedia || navigator.mediaDevices.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia || navigator.msGetUserMedia;
	      var video = document.querySelector('#preview_img_new');
	      var canvas = document.querySelector('#my_canvas');
	      var previewElm = $('#preview_img_new');
	      if($('#pmvImageModalEmployerRegister').is(':visible')) {
    		 	video = document.querySelector('#preview_img_newRE');
	      	canvas = document.querySelector('#my_canvasRE');
	      	previewElm = $('#preview_img_newRE');
	    	}

	      var ctx = canvas.getContext('2d');
	      var localMediaStream = null;
	      canvas.width = 320;
	      canvas.height = 240;
	      var snapshot = function() {
					ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
					// "image/png" works in Chrome.
					// $('#image_preview').attr('src', canvas.toDataURL('image/png'));
					previewElm.attr('src', "");
					previewElm.attr('poster', canvas.toDataURL('image/png'));
	        // $scope.base64Image = canvas.toDataURL('image/png');
					$scope.record_btn = true;
					$scope.record_again_btn = false;
					$scope.save_btn = false;
					// Employer register
					$scope.record_btnRE = true;
					$scope.record_again_btnRE = false;
					$scope.save_btnRE = false;

					if (window.stream) {
						//console.dir(stream)
						// stream.stop();
						stream.getVideoTracks()[0].stop()
						window.stream = "";
					}

					var selectAreaToCrop = function(c) {
	    	 		// //console.log(c);
		  			$scope.crop_data = c;
		  		}

			  	//Jcrop fix alignment
	        if(!$('#preview_img_new_holder').find('.jcrop-holder').length) {
	          $('#preview_img_new_holder').addClass('jcrop_adjust_margin');
	        }
	         //Jcrop fix alignment
	        if(!$('#preview_img_new_holderRE').find('.jcrop-holder').length) {
	          $('#preview_img_new_holderRE').addClass('jcrop_adjust_margin');
	        }

					$('#preview_img_new').Jcrop({
				    aspectRatio : 1/1,
				    setSelected : [20,20,250,220],
				    onChange : selectAreaToCrop,
				    minSize : [150,150]
		  		});
		  		$('#preview_img_new').css('border', '1px solid #ccc');

		  		$('#preview_img_newRE').Jcrop({
				    aspectRatio : 1/1,
				    setSelected : [20,20,250,220],
				    onChange : selectAreaToCrop,
				    minSize : [150,150]
		  		});
		  		$('#preview_img_newRE').css('border', '1px solid #ccc');
		    }

      	snapshot();
	    },

	    save_photo : function($scope) {
	    	var uploadfile_type = '';
	    	// console.log('save photo: ', $scope.crop_data);
	    	// return false;
				var imgArr = ['jpg','png','gif'];
	      if($('#preview_img_new').attr('poster')) {
	        var filename_path = $('#preview_img_new').attr('poster');
	        // console.log("photo file name path: ", filename_path);
	        var ext = filename_path.split('.').pop();
          ext = ext.toLowerCase();
	        var filename = filename_path.split('/').pop();
	        // console.log("photo file name: ", filename_path);
	        // Image File upload
	        if(imgArr.indexOf(ext) != -1) {

	        $.ajax({
	          type: "POST",
	          url: GlobalConstant.FileUploadUrl + '/crop_and_upload_to_cloud',
	          dataType: 'json',
	          data: {
	            filename : filename,
	            obkey : $cookies.get('obkey'),
	            folder : 'image',
	            cropdata : $scope.crop_data,
	            url_type : $scope.url_type
	          },
	          beforeSend : function() {
	            $('#pmvImageModalNew').modal('hide');
	            $('#pmvImageModalMsg').find('.modal-body').text('Profile image saved. Please wait a few moment to update.')
	            .end().modal('show');
	          },
	          success : function(data) {
	          	console.log('success: ',data);
	            if(data) {
	            	// console.log("profile photo uploaded: ", data, $scope.url_type);
	              if(data.response == 200) {
		              if($scope.url_type == 'logo_url') {
		               	// for company image
		              	$scope.logo_url = data.url;
		              	// remove the add button on the company logo image
		              	if($('.company_logo .add_photo_button').length) {
		              	 	$('.company_logo .add_photo_button').remove();
		              	}
		              } else {
		              	// for profile image url
		              	console.log("profile photo manifest");
	              	 	$scope.profile_image = data.url;
	              	 	$scope.profile_picture_url = data.url; // employer settings
            	  	 	$('#top_profile_image img').attr('src', data.url);
            	  	 	$('#employer_setting_page img').attr('src', data.url);
	              		$scope.profile_photo_uploaded = data;
	              	}
	              }
	            }
	          }
	        });

	         // Image taken from user's web camera
		      } else {
	          $.ajax({
		          type: "POST",
		          url: GlobalConstant.FileUploadUrl + '/take_photo_submit?ob_key=' + $cookies.get('obkey'),
		          dataType: 'text',
		          data: {
		            base64data : $('#preview_img_new').attr('poster'),
		            cropdata : $scope.crop_data,
		            url_type : $scope.url_type
		          },
		          beforeSend : function() {
		            $('#pmvImageModalNew').modal('hide');
		            $('#pmvImageModalMsg').find('.modal-body').text('Profile image saved. Please wait a few moment to update.')
		            .end().modal('show');
		          },
		          success : function(data) {
		            if(data) {
		              var data = JSON.parse(data);
		              if(data.response == 200) {
		              	if($scope.url_type == 'logo_url') {
		               		// for company image
		              	  $scope.logo_url = data.url;
		              	  // remove the add button on the company logo image
		              	  if($('.company_logo .add_photo_button').length) {
		              	 	  $('.company_logo .add_photo_button').remove();
		              	  }
		              	} else {
		              		// for profile image url
	              	 		$scope.profile_image = data.url;
	              	  	$('#top_profile_image img').attr('src', data.url);
	              	  	$('#employer_setting_page img').attr('src', data.url);
		              	}
		              }
		            }
		          }
		        });
	        }
	      }
	    },
	    // Employer Register
	    save_photoRE : function($scope) {
				var imgArr = ['jpg','png','gif'];
	      if($('#preview_img_newRE').attr('poster')) {
	        var filename_path = $('#preview_img_newRE').attr('poster');
	        var ext = filename_path.split('.').pop();
	        ext = ext.toLowerCase();
	        var filename = filename_path.split('/').pop();

	        // Image File upload
	        if(imgArr.indexOf(ext) != -1) {
		        $.ajax({
		          type: "POST",
		          url: GlobalConstant.FileUploadUrl + '/upload_to_cloud_register_employer',
		          dataType: 'json',
		          data: {
		            filename : filename,
		            obkey : $cookies.get('obkey'),
		            folder : 'image',
		            cropdata : $scope.crop_data
		          },
		          async : false,
		          beforeSend : function() {
		            $('#pmvImageModalEmployerRegister').modal('hide');
		            $('#pmvImageModalMsg').find('.modal-body').text('Profile image saved. Please wait a few moment to update.')
		            .end().modal('show');
		          },
		          success : function(data) {
		          	//console.log(data);
		            if(data) {
		             //console.log(data);
		              if(data.response == 200) {
		              	$scope.register_image = data.url;
		              }
		            }
		          }
		        });
	         // Image taken from user's web camera
	        } else {
	          $.ajax({
		          type: "POST",
		          url: GlobalConstant.FileUploadUrl + '/take_photo_submit_register_employer?ob_key=' + $cookies.get('obkey'),
		          dataType: 'text',
		          data: {
		            base64data : $('#preview_img_newRE').attr('poster'),
		            cropdata : $scope.crop_data,
		            is_crop : true
		          },
		          async : false,
		          beforeSend : function() {
		            $('#pmvImageModalEmployerRegister').modal('hide');
		            $('#pmvImageModalMsg').find('.modal-body').text('Profile image saved. Please wait a few moment to update.')
		            .end().modal('show');
		          },
		          success : function(data) {
		            if(data) {
		              var data = JSON.parse(data);
		              //console.log(data);
		              if(data.response == 200) {
		             		$scope.register_image = data.url;
		              }
		            }
		          }
	        	});
	        }
	      }
	    },

	    mobile_image_upload_register : function($scope) {
				var file_img = $('#'+ $scope.mobile_file_id)[0];
				var file = file_img.files[0];
				var formData = new FormData();
				formData.append('file',file);

        if(file.type != 'image/png' && file.type != 'image/jpg' && file.type != 'image/gif' && file.type != 'image/jpeg') {
          alert('Invalid file must be .png, .jpg, .gif extension');
          return false;
        }

				// $scope.mobile_agent_name = 'ios';
				// $scope.mobile_agent = true;
	      var params = '?ob_key=' + $cookies.get('obkey');
        params += '&file_folder=image';
        params += '&is_mobile=' + $scope.mobile_agent_name;
        params += '&employer_register=1';

        if($scope.mobile_agent) {
          $.ajax({
            type: "POST",
            url: GlobalConstant.FileUploadUrl + '/upload_submit_mobile' + params,
            dataType: 'json',
            data: formData,
            processData: false,  // tell jQuery not to process the data
            contentType: false,  // tell jQuery not to set contentType
           	async : false,
          	beforeSend : function() {
             	$('#pmvImageModalMsg').find('.modal-body').text('Image saved. Please wait a few moment to update.')
	            .end().modal('show');
          	},
	          success : function(data) {
	            //console.log(data);
	            if(data) {
	              if(data.response == 200) {
	                $scope.register_image = data.url;
	              }
	            }
	          }
        	});
        }
	    },

      saveBanner : function($scope) {
				var imgArr = ['jpg','png','gif'];
        var filename_path = $('#banner_img').attr('src');
        var ext = filename_path.split('.').pop();
        ext = ext.toLowerCase();
        var filename = filename_path.split('/').pop();

        // Image File upload
        if(imgArr.indexOf(ext) != -1) {
	        $.ajax({
	          type: "POST",
	          url: GlobalConstant.FileUploadUrl + '/upload_to_cloud',
	          dataType: 'json',
	          data: {
	            filename : filename,
	            obkey : $cookies.get('obkey'),
	            folder : 'image',
	            url_type : $scope.url_type
	          },
	          beforeSend : function() {
	            $('#companyBannerModal').modal('hide');
	            $('#pmvImageModalMsg').find('.modal-body').text('Banner image saved. Please wait a few moment to update.')
	            .end().modal('show');
	          },
	          success : function(data) {
	          	console.log('emp banner success: ',data);

	            if(data) {
	              if(data.response == 200) {
	                if($scope.url_type == 'company_banner_url') {
	               		// for company banner
	              	  $scope.company_banner_url = data.url;
	              	  // var bannerdata = {data : data.url};

	              	  // ajaxService.postEmployerImageUpload(bannerdata, 'change-banner-url').then(function(res){
	              	  // 	console.log("uploaded banner ", res)
	              	  // });

	              	  // $('#company_banner_holder .add_photo_button').remove();
	              	}
	              }
	            }
	          }
	        });
        }
	    },

	    new_image_upload_modal : function($scope, evt) {
	    	// console.log("profile photo uploading: ", $scope);
				var fileField = document.getElementById("image_upload_modal_new");

				if($('#pmvImageModalEmployerRegister').is(':visible')) {
					fileField = document.getElementById("image_upload_modal_newRE");
				}
	      var file_data = fileField.files[0];

	      // console.log("upload image: ", file_data);
	      // drag drop
	      if (evt) {
	        file_data = evt.dataTransfer.files[0];
	      }

	      // delete old file if exists
	      if($('#image_save').attr('data-filename')) {
	        var filename = $('#image_save').attr('data-filename');
	        var folder = $('#image_save').attr('data-folder');
	        $scope.delete_old_file(filename,folder);
	      }


	      var allowed_files = ['png', 'jpg', 'gif'];
	      var filename = file_data.name;
	      var last_dot = filename.lastIndexOf('.');
	      var file_folder = 'image';
	      var ext = filename.substr(last_dot + 1).toLowerCase();
	      if (allowed_files.indexOf(ext) == -1) {
	        alert('Invalid file must be .png, jpg. .gif extension');
	        return false;
	      }
	      var ob_key = $cookies.get('obkey');
	      var form_data = new FormData();
	      form_data.append('file', file_data);
	      var params = '?ob_key=' + ob_key;
	      params += '&file_folder=' + file_folder;
	      $scope.modal_file_percent_value = 0;
	      var that = this;

	      $.ajax({
	        url: GlobalConstant.FileUploadUrl + '/upload_submit' + params,
	        dataType: 'text',
	        cache: false,
	        contentType: false,
	        processData: false,
	        data: form_data,
	        type: 'post',
	        success: function(res) {
	          res = JSON.parse(res);
	          if (res.response == 200) {
	            fileField.value = '';
	            // hide percent image
	            $scope.modal_percent = true;
	            $scope.modal_percentRE = true;
	            $('#preview_img_new').attr('poster', 'assets/Uploads/Image/'+res.filename);
	            $('#preview_img_new').attr('data-old_file', res.filename);
	            $('#preview_img_new').attr('data-file_folder', 'image');
	            $scope.imagefilename = res.filename;

	            if($scope.isSafari) {
		            var selectAreaToCrop = function(c) {
	            	 	//console.log(c);
					  			$scope.crop_data = c;
					  		}
								$('#preview_img_new_safari').attr('src', 'assets/Uploads/Image/'+res.filename);
		            $('#preview_img_new_safari').attr('data-old_file', res.filename);
		            $('#preview_img_new_safari').attr('data-file_folder', 'image');

            		$('#preview_img_new_safari').Jcrop({
						      aspectRatio : 1/1,
						      setSelected : [20,20,250,220],
						      onChange : selectAreaToCrop,
						      // onSelect : that.selectAreaToCrop,
						      minSize : [150,150]
				  			});
					  		$('#preview_img_new_safari').css('border', '1px solid #ccc');
					  		$('.jcrop-holder').find('img').attr('src', 'assets/Uploads/Image/'+res.filename);

						  	// Register Employer page
					  	  $('#preview_img_newRE_safari').attr('poster', 'assets/Uploads/Image/'+res.filename);
		            $('#preview_img_newRE_safari').attr('data-old_file', res.filename);
		            $('#preview_img_newRE_safari').attr('data-file_folder', 'image');
             	 	$('#preview_img_newRE_safari').Jcrop({
							    aspectRatio : 1/1,
							    setSelected : [20,20,250,220],
							    onChange : selectAreaToCrop,
							     // onSelect : that.selectAreaToCrop,
							    minSize : [150,150]
				  			});
					  		$('#preview_img_newRE_safari').css('border', '1px solid #ccc');
					  		$('#pmvImageModalEmployerRegister .jcrop-holder').find('img').attr('src', 'assets/Uploads/Image/'+res.filename);
	            }

	            $('#preview_img_newRE').attr('poster', 'assets/Uploads/Image/'+res.filename);
	            $('#preview_img_newRE').attr('data-old_file', res.filename);
	            $('#preview_img_newRE').attr('data-file_folder', 'image');

	            that.sectionsHideShow($scope,true,false);
	            that.buttonsHideShow($scope, true,true,true,false,false);
	            that.hideShowManual($scope, '#stop_btn', true);
	          }
	        },
	        beforeSend: function() {
	          $scope.modal_percent_value = 0;
	          // show percent image
	          $scope.modal_percent = false;
	        },
	        xhr: function() {
	          var xhr = new window.XMLHttpRequest();
	          xhr.upload.addEventListener("progress", function(evt) {
	            if (evt.lengthComputable) {
	              $scope.modal_percent_value = Math.ceil((evt.loaded / evt.total) * 100);
	            }
	          }, false);

            xhr.addEventListener('readystatechange', function(e) {
            	if(this.readyState === 4) {
            	 	var selectAreaToCrop = function(c) {
	            	 	//console.log(c);
					  			$scope.crop_data = c;
					  		}

					  		//Jcrop fix alignment
				        if(!$('#preview_img_new_holder').find('.jcrop-holder').length) {
			        		$('#preview_img_new_holder').addClass('jcrop_adjust_margin');
				        }
				         //Jcrop fix alignment (register employer)
				        if(!$('#preview_img_new_holderRE').find('.jcrop-holder').length) {
				        	$('#preview_img_new_holderRE').addClass('jcrop_adjust_margin');
				        }

			        	if($scope.isSafari == false) {
			        		$('#preview_img_new').Jcrop({
							      aspectRatio : 1/1,
							      setSelected : [20,20,250,220],
							      onChange : selectAreaToCrop,
							      // onSelect : that.selectAreaToCrop,
							      minSize : [150,150]
						  		});
						  		$('#preview_img_new').css('border', '1px solid #ccc');
						  		// Employer register page
						  		$('#preview_img_newRE').Jcrop({
							      aspectRatio : 1/1,
							      setSelected : [20,20,250,220],
							      onChange : selectAreaToCrop,
							      // onSelect : that.selectAreaToCrop,
							      minSize : [150,150]
						  		});
				  				$('#preview_img_newRE').css('border', '1px solid #ccc');
				        }
	            }
            });
	          return xhr;
	        },
	      });

				var uploading_userType = $cookies.get('ut');

				if (uploading_userType != 'employer') {
					ajaxService.postImageUpload(file_data).then(function(res){
						// console.log('popo ', res);
						$('.head__profile-link img').attr('src', res.doc_url);
	  	  	 	$('#employer_setting_page img').attr('src', res.doc_url);
					});
				}
	    },

     	banner_image_upload : function($scope, evt) {
				var fileField = document.getElementById($scope.file_input_id);
	      var file_data = fileField.files[0];
	      // drag drop
	      if (evt) {
	        file_data = evt.dataTransfer.files[0];
	      }

	      // delete old file if exists
	      if($('#image_save').attr('data-filename')) {
	        $scope.delete_old_file($scope.old_file,$scope.folder);
	      }

	      var allowed_files = ['png', 'jpg', 'gif'];
	      var filename = file_data.name;
	      var last_dot = filename.lastIndexOf('.');
	      var file_folder = 'image';
	      var ext = filename.substr(last_dot + 1).toLowerCase();
	      if (allowed_files.indexOf(ext) == -1) {
	        alert('Invalid file must be .png, jpg. .gif extension');
	        return false;
	      }
	      var ob_key = $cookies.get('obkey');
	      var form_data = new FormData();
	      form_data.append('file', file_data);
	      var params = '?ob_key=' + ob_key;
      	params += '&file_folder=' + file_folder;
      	params += '&no_crop=1';
	      $scope.modal_file_percent_value = 0;
	      var that = this;

	      $.ajax({
	        url: GlobalConstant.FileUploadUrl + '/upload_submit' + params,
	        dataType: 'text',
	        cache: false,
	        contentType: false,
	        processData: false,
	        data: form_data,
	        type: 'post',
	        success: function(res) {
	          res = JSON.parse(res);
	          if (res.response == 200) {
	            fileField.value = '';
	            // hide percent image
	            $scope.modal_percent = true;
	            $scope.modal_percentRE = true;
	            $scope.old_file = res.filename;
	            $scope.folder = 'image';

	            if(res.w > res.h) {
	            	$('#banner_img').attr('width', '80%');
	            	$('#banner_img').attr('height', '');
	            } else {
	            	$('#banner_img').attr('width', '');
	            	$('#banner_img').attr('height', 240);
	            }

	            $('#banner_img').attr('src', 'assets/Uploads/Image/'+res.filename)
	            that.sectionsHideShow($scope,true,false);
	            that.buttonsHideShow($scope, true,true,true,false,false);
	            that.hideShowManual($scope, '#stop_btn', true);
	            //console.log(res);
	          }
	        },
	        beforeSend: function() {
	          $scope.modal_percent_value = 0;
	          // show percent image
	          $scope.modal_percent = false;
	        },
	        xhr: function() {
	          var xhr = new window.XMLHttpRequest();
	          xhr.upload.addEventListener("progress", function(evt) {
	            if (evt.lengthComputable) {
	              $scope.modal_percent_value = Math.ceil((evt.loaded / evt.total) * 100);
	            }
	          }, false);

            xhr.addEventListener('readystatechange', function(e) {
            	if(this.readyState === 4) {
            	}
            });

	          return xhr;
	        },
	      });
	    }
		} // end return
	}]);




	app.factory('ajaxService', ['GlobalConstant','$cookies', '$http', function(GlobalConstant, $cookies, $http) {
		var params = {access_token: $cookies.get('token')};
		return {
			getEmployerProfile : function() {
				// return $http.get(GlobalConstant.APIRoot+'employer/profile'); // Uncomment for live API call
				return $http.get(window.location.origin + '/js/minified/test-data/test_employer_setting_data.json');
			},
			postCandidateDoc : function(data) {
				return $http.post(GlobalConstant.APIRoot+'candidate/doc', data).then(function(response){
					return response.data.data;
				});
			},
			postImageUpload : function(data) {
        var form = new FormData();
        form.append("document", data);

        return $http.post(
          GlobalConstant.APIRoot + "candidate/upload/profile_image",
          form,
          {
            transformRequest: angular.identity,
            headers: {'Content-Type': undefined}
          }
        ).then(function(response) {
          return  response.data.data;
        });
      },
			postUpload : function(data, type, app_id, question_id, uagent) {
        var form = new FormData();
        form.append("document", data);
        form.append("job_application_object_id", app_id);
        form.append("question_id", question_id);
        form.append("user_agent_logs", uagent);

        console.log("holy before postUpload: ", form);
        return $http.post(
          GlobalConstant.APIRoot + "candidate/upload/" + type,
          form,
          {
            transformRequest: angular.identity,
            headers: {'Content-Type': undefined}
          }
        ).then(function(response) {
          return  response.data;
        }, function(error) {
        	return error.data;
        });
      },
      postEmployerImageUpload : function(data, type) {
				console.log('posting: ', type, data);
        return $http.put(GlobalConstant.APIRoot + "employer/company/" + type, data).then(function(response) {
        	console.log("emp img post result ", response);
          return  response.data.data;
        });
      }
		}
	}]);
})();