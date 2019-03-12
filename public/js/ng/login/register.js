(function () {
	'use strict';
	var app = angular.module('app');
	var base_url = $('body').data('base_url');

	//get query string by key
	function getUrlParameter(param, dummyPath) {
		var sPageURL = dummyPath || window.location.search.substring(1),
			sURLVariables = sPageURL.split(/[&||?]/),
			res;
		for (var i = 0; i < sURLVariables.length; i += 1) {
			var paramName = sURLVariables[i],
				sParameterName = (paramName || '').split('=');

			if (sParameterName[0] === param) {
				res = sParameterName[1];
			}
		}
		return res;
	}

	var httpOrHttps = "https://";
	if (typeof HTTP_OR_HTTPS !== 'undefined')
		httpOrHttps = HTTP_OR_HTTPS;

	//Constant
	app.constant('registerConfig', {
		apiUrl: httpOrHttps + ApiDomain + '/api/v1/ua/register',
		confirmApi: httpOrHttps + ApiDomain + '/api/v1/ua/register/confirm_token/',
		redirectPage: base_url + 'register/confirm/',
		redirectLocation: base_url + 'register/location/',
		userType: base_url + 'test.json',
		tokenstorage: base_url + 'refresher/token_storage',

		RegisterPage: base_url + 'register/',
		EmployerRegisterStep1: base_url + 'register/employer/',
		EmployerFileUpload: base_url + 'register/upload_submit',

		APIRoot: httpOrHttps + ApiDomain + '/api/v1/',

		EmployerUAProfile: httpOrHttps + ApiDomain + '/api/v1/employer/ua/profile',
		CandidateUAProfile: httpOrHttps + ApiDomain + '/api/v1/candidate/ua/profile',
		EmployerUACompany: httpOrHttps + ApiDomain + '/api/v1/employer/ua/company',
		EmployerUAMember: httpOrHttps + ApiDomain + '/api/v1/employer/ua/company/member',

		profileApi: httpOrHttps + ApiDomain + '/api/v1/candidate/profile',
		CheckUserType: httpOrHttps + ApiDomain + '/api/v1/user-type-check',

		//Static API
		StaticOptions: httpOrHttps + ApiDomain + '/api/v1/static/options/',
		StaticOptionIndustryApi: httpOrHttps + ApiDomain + '/api/v1/static/options/industries',
		StaticOptionSubIndustryApi: httpOrHttps + ApiDomain + '/api/v1/static/options/industries/sub',
		StaticOptionLocationsApi: httpOrHttps + ApiDomain + '/api/v1/static/options/locations',
		StaticOptionNationalitiesApi: httpOrHttps + ApiDomain + '/api/v1/static/options/nationalities',
		StaticOptionWorkTypeApi: httpOrHttps + ApiDomain + '/api/v1/static/options/work_type',
		StaticOptionsApi: httpOrHttps + ApiDomain + '/api/v1/static/options',
		StaticOptionsQualificationProvidersApi: httpOrHttps + ApiDomain + '/api/v1/static/options/qualification_providers',

		//Reset Password
		ResetPasswordApi: httpOrHttps + ApiDomain + '/api/v1/ua/set-forgot-password',
		ForgotPasswordApi: httpOrHttps + ApiDomain + '/api/v1/ua/request-forgot-password',
	});




	//Create Register Controller
	app.controller('RegisterController', ['registerConfig', 'fileUploadService', '$scope', '$window', '$http', '$cookies', '$location', '$timeout', 'OAuth', 'OAuthToken', function (registerConfig, fileUploadService, $scope, $window, $http, $cookies, $location, $timeout, OAuth, OAuthToken) {
		$scope.termsAndPolicies = false;
		$scope.subscribeLetter = false;

		// modal close event listeners
		$('#pmvCameraModal, #pmvCameraModalNew, #pmvImageModalNew, #pmvFileModalNew, #pmvImageModalEmployerRegister').on('hidden.bs.modal', function () {
			// stop/unseen video stream
			if (window.stream) {
				stream.getVideoTracks()[0].stop();
				window.stream = "";
			}
			// reset buttons/sections/percent
			fileUploadService.initParams($scope);


			// reset preview video
			$('#preview_new').attr('src', '');
			$('#preview_img_new').attr('src', '');
		})

		$scope.newsLetterState = false;
		$scope.updateNewsletter = function (data) {
			$scope.subscribeLetter = data;
		}

		$scope.mobile_agent = (/android|webos|iphone|ipad|ipod|blackberry|iemobile|opera mini/i.test(navigator.userAgent.toLowerCase()));
		$scope.mobile_agent_name = false;
		if ($scope.mobile_agent) {
			if ((/iphone|ipad|ipod/i.test(navigator.userAgent.toLowerCase()))) {
				$scope.mobile_agent_name = 'ios';
			} else {
				$scope.mobile_agent_name = 'android';
			}
		}


		$scope.isSafari = Object.prototype.toString.call(window.HTMLElement).indexOf('Constructor') > 0;
		$scope.crop_data = {
			w: 240,
			h: 240,
			x: 80,
			y: 0
		};

		$scope.number_of_employees = [
			'1 - 5', '6 - 19', '20 - 49', '50 - 99', '100 - 499', '500 - 999', '1000 - 2999', '3000 - 4999', ' 5000 - 9999', '10000 +'
		];


		if ($scope.isSafari) {
			$('.left2').css('left', '135px');
			$('.left2').next().css('letter-spacing', '0.2px');
		}

		$scope.passwordOnEnter = function (e) {
			if (e.keyCode == 13) {
				$scope.setPassword();
			}
		}

		$('#termsServiceModal').css('display', 'none');

		$scope.showTerms = function () {
			$('#termsServiceModal').css('display', 'block');
			$timeout(function () {
				$('#termsServiceModal').addClass('pvm_modal_active');
			}, 300);
		};
		$(document).on("click", "#termsServiceModal-x-btn", function (e) {
			e.preventDefault();
			$('#termsServiceModal').removeClass('pvm_modal_active');
			$timeout(function () {
				$('#termsServiceModal').css('display', 'none');
			}, 500);
		});

		$(document).on("click", "#termsServiceModal-close-btn", function () {
			$('#termsServiceModal').removeClass('pvm_modal_active');
			$timeout(function () {
				$('#termsServiceModal').css('display', 'none');
			}, 500);
		});
		$('#privacyPolicyModal').css('display', 'none');
		$scope.showPrivacy = function () {
			$('#privacyPolicyModal').css('display', 'block');
			$timeout(function () {
				$('#privacyPolicyModal').addClass('pvm_modal_active');
			}, 300);
		}
		$(document).on("click", "#privacyPolicyModal-x-btn", function (e) {
			e.preventDefault();
			$('#privacyPolicyModal').removeClass('pvm_modal_active');
			$timeout(function () {
				$('#privacyPolicyModal').css('display', 'none');
			}, 500);
		});
		$(document).on("click", "#privacyPolicyModal-close-btn", function () {
			$('#privacyPolicyModal').removeClass('pvm_modal_active');
			$timeout(function () {
				$('#privacyPolicyModal').css('display', 'none');
			}, 500);
		});
		$(document).on('click', '.btn-toggler-container .btn-toggler', function (e) {
			var $parent = $(this).parent('.btn-toggler-container');
			if ($parent.hasClass('active')) {
				$parent.removeClass('active');
			} else {
				$parent.addClass('active')
			}
		})



		$scope.setPassword = function () {
			var data = {
				"data":
				{
					"password": $scope.password1,
					"confirm_password": $scope.password2,
					"client_id": "2_19ycww5xb15wsog4og840wkw08w4ccc8coowcgc80ksocsg4wo"
				}
			};
			var query_string = {};
			var query = window.location.search.substring(1);
			var vars = query.split("&");
			for (var i = 0; i < vars.length; i++) {
				var pair = vars[i].split("=");
				// If first entry with this name
				if (typeof query_string[pair[0]] === "undefined") {
					query_string[pair[0]] = decodeURIComponent(pair[1]);
					// If second entry with this name
				} else if (typeof query_string[pair[0]] === "string") {
					var arr = [query_string[pair[0]], decodeURIComponent(pair[1])];
					query_string[pair[0]] = arr;
					// If third or later entry with this name
				} else {
					query_string[pair[0]].push(decodeURIComponent(pair[1]));
				}
			}


			if (query_string.key) {

				$http({
					url: registerConfig.APIRoot + 'employer/ua/member/set_password',
					method: 'put',
					data: data,
					headers: {
						'Content-Type': 'application/json',
						'X-Custom-Auth': query_string.key
					}
				}).then(function (response) {

					var data = response.data;
					var email = query_string.email;
					var expire = 3600;
					// var expire = parseInt ( OAuthToken.getToken().expires_in )  - 3500;
					var SetDateforLogin = new Date();
					var LoginTime = parseInt(SetDateforLogin.getTime() / 1000);
					var ExpireTime = parseInt(SetDateforLogin.getTime() / 1000) + expire;
					var ExpireTimetoDate = new Date(ExpireTime * 1000);
					//Store all data needed to cookies
					$cookies.put('token', data.access_token, { 'path': '/' });
					$cookies.put('LoginTime', LoginTime, { 'path': '/' });
					$cookies.put('exp', expire, { 'path': '/' });
					//need for refresher
					$cookies.put('email', $scope.email, { 'path': '/' });
					$cookies.put('ut', 'employer', { 'path': '/' });

					OAuthToken.setToken(data)

					$.ajax({
						url: registerConfig.tokenstorage,
						type: 'post',
						data: {
							token_refresh: data.refresh_token,
							token_access: data.access_token,
							username: email
						},
						success: function (token_id) {

							$cookies.put('token_id', token_id, {
								'path': '/'
							});
						}
					}).done(function () {
						window.location = base_url + 'employer/dashboard';

					});
				});

			}

		}


		$scope.passwordHack = function (e) {
			e.preventDefault();
			var obj = $(e.target);


			if ($scope.second_password) {
				obj.addClass('ng-touched');
			} else {

				var i = 0;
				var remove_ng_touched = setInterval(function () {
					if (i > 8) {
						clearInterval(remove_ng_touched);
					}
					obj.removeClass('ng-touched');
					i++
				}, 50)

			}
		}

		$scope.updateUserType = function (UType) {
			if (UType == 'candidate') {
				$scope.newsLetterState = true;
			} else {
				$scope.newsLetterState = false;
			}
		}

		if ($('#Form_user_type_candidate').is(':visible')) {
			$('#Form_action_doNothing').attr('disabled', 'disabled');
			$('#Form_action_doNothing').css("cssText", "background-color: #a9a9a9 !important;border: 1px solid #909090 !important;");
		}
		$scope.updateTermsAndPolicies = function (data) {
			if (data == true) {
				$('#Form_action_doNothing').removeAttr('disabled');
				$('#Form_action_doNothing').removeAttr('style');
				$('#Form_action_doNothing').removeAttr('style');
			} else {
				$('#Form_action_doNothing').attr('disabled', 'disabled');
				$('#Form_action_doNothing').css("cssText", "background-color: #a9a9a9 !important;border: 1px solid #909090 !important;");
			}
		}

		$('#Form input[type="text"], #Form input[type="email"], #Form input[type="password"],  .required').blur(function () {
			var obj = $(this);
			if (obj.attr('data-has-error')) {
				return false
			}
			if ($.trim(obj.val())) {
				obj.next().css('display', 'none');
				//console.log(obj.closest('.asterisk '))
			} else {
				obj.next().css('display', '');
			}

			if (obj.hasClass('ng-untouched')) {
				obj.removeClass('ng-untouched');
				obj.addClass('ng-touched');
			}

			if (obj.attr('name') == 'second_password') {
				if ($('input[name="first_password"]').val() != "" && obj.val() == $('input[name="first_password"]').val()) {
					$('input[name="first_password"]').removeClass('ng-touched')
					$('input[name="first_password"]').addClass('ng-untouched')
				} else {

					if (!$('input[name="first_password"]').hasClass('ng-touched')) {
						$('input[name="first_password"]').addClass('ng-touched');
					}

				}
			}

		});

		$('input[type="text"], input[type="email"], input[type="password"]').focus(function () {
			var obj = $(this);
			if (obj.hasClass('ng-touched')) {
				obj.removeClass('ng-touched');
				obj.addClass('ng-untouched');
			}
		})

		$scope.preload = true;


		$scope.withHashLocation = function (location) {
			if (window.location.hash) {
				var hash = window.location.hash.substring(1);
				hash = hash.replace(/^\/|\/$/g, '');
				$cookies.put('redirectBack', hash, { 'path': '/' });
				$window.location.href = location + '#/' + hash;
			} else {
				$window.location.href = location;
			}
		}


		//Save Function Candidate
		$scope.save = function () {
			$scope.preload = false;
			//Candidate registration process

			//convert data to json string
			$scope.allData = JSON.stringify({
				email: $scope.email,
				username: $scope.email,
				user_type: $scope.user_type,
				first_name: $scope.first_name,
				last_name: $scope.last_name,
				newsletter: $scope.subscribeLetter,
				plainPassword: {
					first: $scope.first_password,
					second: $scope.second_password
				},
			});

			//Submit Data
			$http.post(registerConfig.apiUrl, $scope.allData)
				.then(function (response) {
					$cookies.put('aa_token', response.data.data.aa_token, { 'path': '/' });
					//Success Condition
					if ($scope.user_type == 'candidate') {
						var ob_key = response.data.data.ob_key;
						$cookies.put('ob_key', ob_key, { 'path': '/' });
						$scope.withHashLocation(registerConfig.redirectLocation)
						$scope.preload = true;
					} else if ($scope.user_type == 'employer') {
						var cont_key = response.data.data.azure_container_key;
						var azureContainer = cont_key.split('/')
						$cookies.put('ob_key', azureContainer[1], { 'path': '/' });
						$cookies.put('cont_key', azureContainer[0], { 'path': '/' });
						$cookies.put('azureContainer', cont_key, { 'path': '/' });
						var register_user_info = '{"first_name": "' + $scope.first_name + '", "last_name" : "' + $scope.last_name + '", "email" : "' + $scope.email + '"}';
						$cookies.put('register_user_info', register_user_info);
						$window.location.href = registerConfig.EmployerRegisterStep1;
					}
				}, function (response) {
					$scope.ErrorMsgs = response.data.errors;
					$scope.preload = true;
				});
		};

		$scope.reset_password = function () {
			var token = $('#Form_token').val();
			var pass = $scope.first_password;
			var formData = { data: { "token": token, "password": pass } };
			$scope.preload = false;

			$http({
				url: registerConfig.ResetPasswordApi,
				method: 'post',
				data: formData,
				headers: { 'Content-Type': 'application/json' }
			})
				.then(function (response) {
					alert('Success');
					$window.location.href = base_url + 'login';

				}, function (response) {
					$scope.preload = true;
					alert('some error');

				});
		}

		$scope.forgot_password = function () {
			var pass = $scope.first_password;
			var formData = { data: { "email": $scope.email } };
			$scope.preload = false;

			$http({
				url: registerConfig.ForgotPasswordApi,
				method: 'post',
				data: formData,
				headers: { 'Content-Type': 'application/json' }
			})
				.then(function (response) {
					$scope.preload = true;
					alert('Email sent. Please check your email, to reset your password.')

				}, function (response) {
					alert('some error');

				});
		}


		//Save Function Employer

		$scope.ValidatePage = function () {
			var ob_key = $cookies.get('ob_key');

			if (angular.isUndefined(ob_key) == true) {
				$window.location.href = registerConfig.RegisterPage;
			} else if (ob_key == 'removed') {
				$('.triggerLast').trigger('click');
			}
		}

		$scope.confirmEmployerRegistration = function () {
			$('#Register_employer').addClass('confirm-registration')
			$('.triggerLast').trigger('click');
			$('html, body').animate({ scrollTop: 0 }, 'fast');
		}

		$scope.removeOB = function () {
			$cookies.remove('ob_key', { 'path': '/' });
		}

		$scope.hidecity = true;
		$scope.hidesuburb = true;
		$scope.loadcity = true;
		$scope.loadsuburb = true;
		$scope.subIndustryLoader = true;
		$scope.subIndustryEl = true;
		//Get Industries
		$scope.industries = [];
		$http.get(registerConfig.StaticOptionIndustryApi).then(function (response) {
			$scope.industries = response.data.data;
		});

		//Get Region
		$scope.regions = [];
		$http.get(registerConfig.StaticOptionLocationsApi + '/regions').then(function (response) {
			$scope.regions = response.data.data;
		});


		//Watch region field change value and get value to populate next dropdown
		$scope.$watch('region', function (newVal, oldVal) {
			if (angular.isUndefined(newVal) == false) {
				var id = newVal;
				$scope.loadcity = false;
				$http.get(registerConfig.StaticOptionLocationsApi + '/cities/' + id).then(function (response) {
					$scope.cities = response.data.data;
					$scope.hidecity = false;
					$scope.loadcity = true;
				});
			}

		});

		$scope.subIndustries = []
		$scope.loadSubIndustries = function (parent_id) {
			$scope.subIndustryLoader = false;
			$http.get(registerConfig.StaticOptionSubIndustryApi + '/' + parent_id)
				.then(function (response) {
					$scope.subIndustries = response.data.data;
					$scope.subIndustryLoader = true;
					$scope.subIndustryEl = false;
				});


		}

		$scope.$watch('industries_step2', function (newVal, oldVal) {
			if (newVal) {
				$scope.loadSubIndustries(newVal);
			}
		});

		//Watch city field change value and get value to populate next dropdown
		$scope.$watch('city', function (newVal, oldVal) {
			if (angular.isUndefined(newVal) == false) {
				var id = newVal;
				$scope.loadsuburb = false;
				$http.get(registerConfig.StaticOptionLocationsApi + '/suburbs/' + id).then(function (response) {
					$scope.suburbs = response.data.data;
					$scope.hidesuburb = false;
					$scope.loadsuburb = true;
				});
			}

		});

		$scope.numbersOnly = function (evt) {
			evt = (evt) ? evt : window.event;
			var charCode = (evt.which) ? evt.which : evt.keyCode;
			if (isNaN(String.fromCharCode(charCode))) {
				evt.preventDefault();
			}
		}

		//Image Upload

		$scope.upload = function (FieldId, dataProgress, UploadMessage) {
			var fileField = document.getElementById(FieldId);

			var file_data = fileField.files[0];
			var size = parseFloat(file_data.size / (1024 * 1024)).toFixed(2)

			var allowed_files = ['jpg', 'jpeg', 'png'];
			var filename = file_data.name;
			var last_dot = filename.lastIndexOf('.');
			var file_folder = 'image';

			var fileObj = $('#' + FieldId);

			var ext = filename.substr(last_dot + 1).toLowerCase();
			if (allowed_files.indexOf(ext) == -1) {
				alert('Invalid file must be .jpg, .jpeg .png extension');
				fileObj.next().attr('data-has-error', true)
				return false;

			} else if (size > 2) {
				alert('Image should not exceed 2mb');
				fileObj.next().attr('data-has-error', true)
				return false;

			}
			fileObj.next().attr('data-has-error', '')

			var ob_key = $cookies.get('cont_key');
			var ob_key2 = $cookies.get('ob_key');
			var form_data = new FormData();
			form_data.append('file', file_data);
			$scope.progressResumeValue = 0;

			if ($(dataProgress).hasClass('ng-hide')) {
				$(dataProgress).removeClass('ng-hide');
			}

			var params = '?ob_key=' + ob_key + '&ob_key2=' + ob_key2 + '&file_folder=' + file_folder;
			$.ajax({
				url: registerConfig.EmployerFileUpload + '/upload_submit' + params,
				dataType: 'text',
				cache: false,
				contentType: false,
				processData: false,
				data: form_data,
				type: 'post',
				success: function (res) {

					$scope.image_url = res;

					if (!$(dataProgress).hasClass('ng-hide')) {
						$scope.progressResumeValue = 0;
						$(dataProgress).addClass('ng-hide');
						fileField.value = '';
					}

					$(UploadMessage).html('<img src="' + $scope.image_url + '"    class="img-responsive img-circle" >');

				},
				beforeSend: function () {
					$(UploadMessage).html('uploading to server please wait...');
				},
				xhr: function () {
					var xhr = new window.XMLHttpRequest();
					xhr.upload.addEventListener("progress", function (evt) {
						if (evt.lengthComputable) {
							var percentComplete = Math.ceil((evt.loaded / evt.total) * 100);
							$scope.progressResumeValue = percentComplete;
						}
					}, false);
					return xhr;
				},
			});
		}

		$("#Form_my_file").change(function () {
			$scope.upload('Form_my_file', '#data_progress', '#file_upload_msg');
		});

		$("#Form_my_file2").change(function () {
			$scope.upload('Form_my_file2', '#data_progress2', '#file_upload_msg2');
		});

		$('#image_upload_modal_newRE').change(function () {
			$scope.new_image_upload_modal();
		});

		// emploer register mobile image upload
		$('#mobile_profileImage, #mobile_Form_my_file, #mobile_Form_my_file2').change(function () {
			$scope.mobile_file_id = $(this).attr('id');
			fileUploadService.mobile_image_upload_register($scope);

			// Employer Register page
			var img = '<img class="img-circle" src="' + $scope.register_image + '" >';
			if ($('#profileImageMessage').is(':visible')) {
				$('#profileImageMessage').html(img);
			}
			if ($('#file_upload_msg').is(':visible')) {
				$('#file_upload_msg').html(img);
			}
			if ($('#file_upload_msg2').is(':visible')) {
				$('#file_upload_msg2').html(img);
			}

			// text field on the register steps form
			$('.file-upload-input:visible').val($scope.register_image);

		})

		/**** Location ****/
		//Get Countries

		$scope.disableLocation = true;

		$http.get(registerConfig.StaticOptions + 'countries')
			.then(function (response) {
				$scope.countries = response.data.data
				$scope.hidecounty = false
			});


		$scope.$watch('country', function (newVal, oldVal) {
			if (angular.isDefined(newVal)) {
				$scope.disableLocation = false;
			} else {
				$scope.searchLocation = ''
				$scope.disableLocation = true;
			}
			if (!$('#autoDataLocation').hasClass('ng-hide')) {
				$('#autoDataLocation').addClass('ng-hide');
			}
		})

		var typingTimer;  //timer identifier
		var doneTypingInterval = 10;
		var idx = 0;
		$('#location').on('keyup', function (e) {
			$('#LocationId').val(null);
			if (e.which >= 37 && e.which <= 40 || e.which == 13) {

				var li = $('#autoDataLocation li');

				if (li.length) {

					if (e.which == 40) {

						if (!li.hasClass('selected_filter')) {
							li.removeClass('selected_filter');
							$('#autoDataLocation li:eq(' + idx + ')').addClass('selected_filter')

						} else {
							idx = $('#autoDataLocation li.selected_filter').prevAll().length + 1;
							$('#autoDataLocation li').removeClass('selected_filter');

							if ($('#autoDataLocation li:eq(' + idx + ')').nextAll().length == 0) {
								idx = li.length - 1;
							}

							$('#autoDataLocation li:eq(' + idx + ')').addClass('selected_filter')
						}
					} else if (e.which == 38) {
						if (li.hasClass('selected_filter')) {
							idx--;
							idx = idx <= 0 ? 0 : idx;
							li.removeClass('selected_filter');
							$('#autoDataLocation li:eq(' + idx + ')').addClass('selected_filter')
						}
					} else if (e.which == 13) {
						var userOption = $('#autoDataLocation li:eq(' + idx + ')').find('a').text();
						$('#location').val(userOption);
						$('#autoDataLocation').addClass('ng-hide');
						idx = 0;
					}

				}

				return false;
			}
			$timeout.cancel(typingTimer);
			typingTimer = $timeout(doneTyping, doneTypingInterval);
		});

		$scope.searchLocation = ''
		$scope.data = ''
		$scope.getAutoCompleteData = function (data) {
			$scope.data = data
			$scope.searchLocation = data.display_name;
			$scope.LocationId = data.id;
			if (!$('#autoDataLocation').hasClass('ng-hide')) {
				$('#autoDataLocation').addClass('ng-hide');
			}

			idx = 0;
		}

		$scope.$watch('searchLocation', function (newVal, oldVal) {
			if (newVal && $scope.data.display_name != newVal) {
				$scope.LocationId = null;
			} else {
				$scope.LocationId = $scope.data.id
			}
		});

		//user is "finished typing," do something
		function doneTyping() {

			$scope.autoLocation = [];
			$http.get(registerConfig.APIRoot + 'static/autocomplete/location?q=' + $('#location').val() + '&country_id=' + $scope.country.id)
				.then(function (response) {
					$scope.autoLocation = response.data.data;

					if (!$scope.autoLocation.length) {
						$('#autoDataLocation').addClass('ng-hide');
					} else {
						$('#autoDataLocation').removeClass('ng-hide');
					}
				});

		}
		/***End Location**/

		//Step 1
		$scope.SubmitEmployerStep1 = function () {
			$scope.step1data = [];

			$scope.preload = false;
			var formData = {};
			// get user input from the form
			$('#Step1Form').serializeArray().map(function (item) {
				formData[item.name] = item.value;
			});

			var aa_token = $cookies.get('aa_token');
			var image_url = $('#Step1Form .file-upload-input').val();

			formData['profile_picture_url'] = image_url;

			// this will show on the review content step
			$scope.profile_picture = '<div>' + $('#Step1Form #profileImageMessage').html() + '</div>';


			$http({
				url: registerConfig.EmployerUAProfile,
				method: 'put',
				data: { data: formData },
				headers: {
					'Content-Type': 'application/json',
					'X-Custom-Auth': aa_token
				},
			})
				.then(function (response) {
					$('.triggerNext').trigger('click');

					var register_user_info = JSON.parse($cookies.get('register_user_info'));
					formData['email'] = register_user_info.email;
					formData['first_name'] = register_user_info.first_name;
					formData['last_name'] = register_user_info.last_name;

					$scope.step1data.push(formData);
					$scope.preload = true;
					$('html, body').animate({ scrollTop: 0 }, 'fast');
				}, function (response) {
					$scope.loadsuburb = true;
					$scope.ErrorMsgs = response.data.errors;
				});
		} //Step 1 End

		//Step 2
		$scope.SubmitEmployerStep2 = function () {
			$scope.step2data = [];
			var formData = {};

			// get user input from the form
			$('#Step2Form').serializeArray().map(function (item) {
				formData[item.name] = item.value;
				switch (item.name) {
					case 'industry_step2':
						formData[item.name] = parseInt(item.value);
						break;
					case 'subindustry_step2':
						formData[item.name] = parseInt(item.value);
						break;
					case 'industries_step2':
						if ($scope.subindustry_step2) {
							formData[item.name] = parseInt($scope.subindustry_step2);
						} else {
							formData[item.name] = parseInt($scope.industries_step2);
						}

						break;
					default:

				}

				delete formData['region'];
				delete formData['cities'];
				delete formData['suburbs'];
			});

			if ($scope.LocationId != null) {

				var preferred_location = $scope.LocationId
			} else {

				if ($scope.searchLocation != '') {
					var preferred_location = { country_id: $scope.country.id, location: $scope.searchLocation }
				} else {
					var preferred_location = $scope.country.id
				}

			}
			var image_url = $('#Step2Form .file-upload-input').val();
			// angular.extend( formData, {location: preferred_location, industry: $scope.industries_step2, logo_url: $scope.image_url } );
			angular.extend(formData, {
				location: preferred_location,
				industry: $scope.industries_step2,
				logo_url: image_url,

			});

			var DisplayFormData = {};

			$scope.company_picture = $('#Step2Form #file_upload_msg').html();

			$('#Step2Form').serializeArray().map(function (item) {
				DisplayFormData[item.name] = item.value;
			});
			// angular.extend( DisplayFormData, { logo_url: $scope.image_url } );
			angular.extend(DisplayFormData, {
				logo_url: image_url,
				display_country: $scope.country.display_name,
				display_location: $scope.searchLocation
			});

			formData['logo_url'] = image_url;
			var aa_token = $cookies.get('aa_token');

			$http({
				url: registerConfig.EmployerUACompany,
				method: 'put',
				data: { data: formData },
				headers: {
					'Content-Type': 'application/json',
					'X-Custom-Auth': aa_token
				},
			})
				.then(function (response) {
					$('.triggerNext').trigger('click');
					$scope.step2data.push(DisplayFormData);
					$scope.loadSubIndustries($scope.step2data[0].industry_step2)
					$('html, body').animate({ scrollTop: 0 }, 'fast');
				}, function (response) {
					alert('some error');
				});
		} //Step 2 End

		//Step 3
		$scope.hideme = true;
		$scope.newstep3 = [];

		$scope.resetfields = function () {
			$scope.account_type = null;
			$scope.step3_first_name = null;
			$scope.step3_last_name = null;
			$scope.step3_email = null;
			$scope.step3_nickname = null;
			$scope.step3_phone_number = null;
			$scope.step3_phone_extension = null;
			$scope.step3_mobile_number = null;
			$scope.step3_work_title = null;
			$scope.step3_work_dept = null;
			$scope.step3_work_dept = null;
			$scope.image_url = null;

			angular.element($('#FormStep3')).find('.file-upload-input').val("");
			angular.element($('#FormStep3')).find('#file_upload_msg2').html("");
		}
		$scope.buttons = { chosen: "" };
		$scope.SubmitEmployerStep3 = function () {
			var formData = {};
			var image_url = $('#Step3Form .file-upload-input').val();

			// get user input from the form
			$('#Step3Form').serializeArray().map(function (item) {
				formData[item.name] = item.value;
				if (item.name == 'profile_picture_url') {
					formData[item.name] = image_url;
				}
			});

			var aa_token = $cookies.get('aa_token');
			$http({
				url: registerConfig.EmployerUAMember,
				method: 'post',
				data: { data: formData },
				headers: {
					'Content-Type': 'application/json',
					'X-Custom-Auth': aa_token
				},
			}).then(function (response) {
				$scope.hideme = false;
				$scope.newstep3.push(formData);

				if ($scope.buttons.chosen == 'addmore') {
					$scope.resetfields();
				} else {
					$scope.resetfields();
					$('.triggerNext').trigger('click');
				}
				$('html, body').animate({ scrollTop: 0 }, 'fast');

			}, function (response) {
				alert('some error');
			});

		} //Step3 End


		$('input:radio').click(function () {
			if ($('.left2').is(":visible")) {
				$('.left2').css('display', 'none');
			}
		});

		document.dropFileModalNew = function (ev) {
			ev.preventDefault();
			var elemId = $(this).attr('id');
			var event = ev;
			var docFileType = $('#pmvFileModalNew').attr('data-docFileType');
			var fileSizeLimit = 2;
			var isAuthenticate = false;

			if ($cookies.get('ob_key') && typeof $cookies.get('ob_key') == 'undefined') {
				$cookies.put('obkey', $cookies.get('ob_key'), { 'path': '/' });
			}

			fileUploadService.uploadFile($scope, elemId, event, docFileType, fileSizeLimit, isAuthenticate);
		}

		document.allowDrop = function (ev) {
			ev.preventDefault();
			$scope.ondragoverout_image = true;
			$scope.ondragover_image = false;
		}

		document.leaveIt = function (ev) {
			ev.preventDefault();
			$scope.ondragoverout_image = false;
			$scope.ondragover_image = true;
		}


		// Video Modal buttons
		$scope.record_btn = false;
		$scope.record_again_btn = false;
		$scope.stop_btn = false;
		$scope.save_btn = false;
		$scope.change_btn = false;
		// Video Modal Sections
		$scope.showSection1 = false;
		$scope.showSection2 = true;

		$scope.modal_percent = true;


		$scope.buttonsHideShow = function (a, b, c, d, e) {
			$scope.record_btn = a;
			$scope.record_again_btn = b;
			$scope.stop_btn = c;
			$scope.save_btn = d;
			$scope.change_btn = e;
		}

		$scope.sectionsHideShow = function (a, b) {
			$scope.showSection1 = a;
			$scope.showSection2 = b;
		}

		$scope.open_file_modal = function (ev) {
			ev.preventDefault()
			var obj = $(ev.target);
			var docFileType = obj.attr('data-docFileType');

			if ($cookies.get('ob_key')) {
				$cookies.put('obkey', $cookies.get('ob_key'), { 'path': '/' });
			}

			fileUploadService.openModal($scope, '#pmvImageModalEmployerRegister', docFileType);
		}

		$("#file_upload").change(function () {
			var elemId = $(this).attr('id');
			var event = false;
			var docFileType = $('#pmvFileModalNew').attr('data-docFileType');
			var fileSizeLimit = 2;
			var isAuthenticate = false;

			fileUploadService.uploadFile($scope, elemId, event, docFileType, fileSizeLimit, isAuthenticate);
		});

		$scope.file_save = function (e) {
			var elem = $(e.currentTarget);
			fileUploadService.save($scope, false, 'employer_register');
		}

		$scope.file_change = function () {
			fileUploadService.fileChange($scope);
		}

		$scope.changeVideo = function () {
			fileUploadService.changeVideo($scope);
		}

		function checkBrowsers() {
			var nVer = navigator.appVersion;
			var nAgt = navigator.userAgent;
			$scope.browserName = navigator.appName;
			var fullVersion = '' + parseFloat(navigator.appVersion);
			var majorVersion = parseInt(navigator.appVersion, 10);
			var nameOffset, verOffset, ix;

			// In Opera, the true version is after "Opera" or after "Version"
			if ((verOffset = nAgt.indexOf("Opera")) != -1) {
				$scope.browserName = "Opera";
				fullVersion = nAgt.substring(verOffset + 6);
				if ((verOffset = nAgt.indexOf("Version")) != -1)
					fullVersion = nAgt.substring(verOffset + 8);
			}
			// In MSIE, the true version is after "MSIE" in userAgent
			else if ((verOffset = nAgt.indexOf("MSIE")) != -1) {
				$scope.browserName = "IE";
				fullVersion = nAgt.substring(verOffset + 5);
			}
			// In Chrome, the true version is after "Chrome"
			else if ((verOffset = nAgt.indexOf("Chrome")) != -1) {
				$scope.browserName = "Chrome";
				fullVersion = nAgt.substring(verOffset + 7);
			}
			// In Safari, the true version is after "Safari" or after "Version"
			else if ((verOffset = nAgt.indexOf("Safari")) != -1) {
				$scope.browserName = "Safari";
				fullVersion = nAgt.substring(verOffset + 7);
				if ((verOffset = nAgt.indexOf("Version")) != -1)
					fullVersion = nAgt.substring(verOffset + 8);
			}
			// In Firefox, the true version is after "Firefox"
			else if ((verOffset = nAgt.indexOf("Firefox")) != -1) {
				$scope.browserName = "Firefox";
				fullVersion = nAgt.substring(verOffset + 8);
			}
			// In most other browsers, "name/version" is at the end of userAgent
			else if ((nameOffset = nAgt.lastIndexOf(' ') + 1) <
				(verOffset = nAgt.lastIndexOf('/'))) {
				$scope.browserName = nAgt.substring(nameOffset, verOffset);
				fullVersion = nAgt.substring(verOffset + 1);
				if (browserName.toLowerCase() == browserName.toUpperCase()) {
					$scope.browserName = navigator.appName;
				}
			}
			// trim the fullVersion string at semicolon/space if present
			if ((ix = fullVersion.indexOf(";")) != -1)
				fullVersion = fullVersion.substring(0, ix);
			if ((ix = fullVersion.indexOf(" ")) != -1)
				fullVersion = fullVersion.substring(0, ix);

			majorVersion = parseInt('' + fullVersion, 10);
			if (isNaN(majorVersion)) {
				fullVersion = '' + parseFloat(navigator.appVersion);
				majorVersion = parseInt(navigator.appVersion, 10);
			}

			$('body').addClass($scope.browserName + ' ' + $scope.browserName + '-' + majorVersion);
		}

		$scope.startVideoImage = function () {
			checkBrowsers();
			if ($scope.isSafari || $scope.browserName == "Safari") {
				alert('Oh oh this feature is not yet supported by your browser. Drag and drop an image instead, or use Chrome, Firefox or Microsoft Edge to capture an image using your webcam.');
			} else {
				fileUploadService.startVideoImage($scope);
			}

		}

		$scope.take_photo = function () {
			fileUploadService.take_photo($scope);
		}

		$scope.take_photo_again = function () {
			window.stream = '';
			fileUploadService.startVideoImage($scope);
		}

		$scope.save_photoRE = function () {
			fileUploadService.save_photoRE($scope);

			var img = '<img class="img-circle" src="' + $scope.register_image + '" >';

			if ($('#profileImageMessage').is(':visible')) {
				$('#profileImageMessage').html(img);
			}
			if ($('#file_upload_msg').is(':visible')) {
				$('#file_upload_msg').html(img);
			}
			if ($('#file_upload_msg2').is(':visible')) {
				$('#file_upload_msg2').html(img);
			}
			$('.file-upload-input:visible').val($scope.register_image);
		}

		$scope.new_image_upload_modal = function (evt) {
			fileUploadService.new_image_upload_modal($scope, evt);
		}
	}]);

	app.controller('RegisterLocationController', ['registerConfig', '$scope', '$window', '$http', '$cookies', '$timeout', function (registerConfig, $scope, $window, $http, $cookies, $timeout) {

		$scope.hidecounty = true;
		$scope.hidecity = true;
		$scope.hidesuburb = true;
		$scope.loadcity = true;
		$scope.loadsuburb = true;
		$scope.hideroletype = true;
		$scope.loadsubindustry = true;
		$scope.loadprovider = true;
		$scope.hidesubindustry = true;
		$scope.hideme = true

		var ob_key = $cookies.get('ob_key');
		var aa_token = $cookies.get('aa_token');



		function autopopulateIndustry(industry) {
			//Selected Industry
			var selected_industry = $filter('filter')($scope.industries, industry.id);
			angular.forEach(selected_industry, function (val, key) {
				var index = $scope.industries.indexOf(val);
				$scope.selectedIndustry = $scope.industries[index];
			});

		}

		$scope.industries = [];
		$http.get(registerConfig.StaticOptionIndustryApi).then(function (response) {
			$scope.industries = response.data.data;
			if ($cookies.get('JobId') != null) {
				autopopulateIndustry($scope.JobData.industry.data.industry);
			}
			else if ($cookies.get('loadTemplate') != null && $cookies.get('JobId') == null) {
				autopopulateIndustry($scope.JobData.template_data.industry.industry)
			}
		});



		//Watch city field change value and get value to populate next dropdown
		$scope.$watch('selectedIndustry', function (newVal, oldVal) {
			if (angular.isUndefined(newVal) == false) {

				var id = newVal.id;
				$scope.loadsubindustry = false;
				$scope.hidesubindustry = true;
				$http.get(registerConfig.StaticOptionSubIndustryApi + '/' + id).then(function (response) {
					$scope.subIndustry = response.data.data;
					$scope.hidesubindustry = false;
					$scope.loadsubindustry = true;

				});
			}
		});


		$http.get(registerConfig.StaticOptionsQualificationProvidersApi).then(function (response) {
			$scope.qualificationProviders = response.data.data;
		});


		$(document).on("click", ".addSelectedProvider", function (event) {
			var obj = $(this);
			obj.parents('.provider_container_con').find('input[type="text"]').val(obj.text())
			obj.parent().addClass('ng-hide')
		});

		$(document).on("keyup", ".filterQualification", function (event) {
			var obj = $(this);
			var value = obj.val();
			value = value.toLowerCase();


			var objContainer = obj.parents('.provider_container_con');
			var targetAutoComplete = objContainer.find('.auto_complete_education');
			if (targetAutoComplete.hasClass('ng-hide')) {
				targetAutoComplete.removeClass('ng-hide')
			}

			targetAutoComplete.find('li').each(function (k, v) {
				var li = $(v);
				var text = li.text();
				text = text.toLowerCase();
				if (text.indexOf(value) == -1) {
					li.hide();
				} else {
					li.show();
				}

			})
			if (!targetAutoComplete.find('li:visible').length) {

				if (!targetAutoComplete.hasClass('ng-hide')) {
					targetAutoComplete.addClass('ng-hide')

				}

			}



		});


		// Modal close event

		$(document).on("click", ".addNewProvider", function (event) {
			var strElement = '<div class="provider_container_con">\
				  						<div class="col-md-5" class="">\
		                    <input type="text" name="job_description[]" class="filterQualification" rows="3">\
		                </div><a class="add addNewProvider" >\
		                 <div class="col-md-7 row">\
                            <a class="add addNewProvider col-md-1"><span>+</span></a>\
                            <a class="add removeNewProvider col-md-1"><span>-</span></a>\
                        </div>\
		                <div class="clearfix"></div>\
		                <ul class="auto_complete_education ng-hide">';

			angular.forEach($scope.qualificationProviders, function (v, k) {
				strElement += '<li class="addSelectedProvider">';
				strElement += v.provider_display_name;
				strElement += '</li">';
			})

			strElement += '</ul></div>';

			$('#provider_container').append(strElement)


		});

		$(document).on("click", ".removeNewProvider", function (event) {

			$(this).parents('.provider_container_con').remove()
		});


		/**** Location ****/
		//Get Countries

		$scope.disableLocation = true;

		$http.get(registerConfig.StaticOptions + 'countries')
			.then(function (response) {
				$scope.countries = response.data.data
				$scope.hidecounty = false
			});


		$scope.$watch('country', function (newVal, oldVal) {
			if (angular.isDefined(newVal)) {
				$scope.searchLocation = ''
				$scope.LocationId = ''
				$scope.disableLocation = false;
			} else {
				$scope.searchLocation = ''
				$scope.LocationId = ''
				$scope.disableLocation = true;
			}
			if (!$('#autoDataLocation').hasClass('ng-hide')) {
				$('#autoDataLocation').addClass('ng-hide');
			}

		})

		var typingTimer;  //timer identifier
		var doneTypingInterval = 10;
		var idx = 0;
		$('#location').on('keyup', function (e) {

			$('#LocationId').val(null);
			if (e.which >= 37 && e.which <= 40 || e.which == 13) {

				var li = $('#autoDataLocation li');

				if (li.length) {

					if (e.which == 40) {

						if (!li.hasClass('selected_filter')) {
							li.removeClass('selected_filter');
							$('#autoDataLocation li:eq(' + idx + ')').addClass('selected_filter')

						} else {
							idx = $('#autoDataLocation li.selected_filter').prevAll().length + 1;
							$('#autoDataLocation li').removeClass('selected_filter');

							if ($('#autoDataLocation li:eq(' + idx + ')').nextAll().length == 0) {
								idx = li.length - 1;
							}

							$('#autoDataLocation li:eq(' + idx + ')').addClass('selected_filter')
						}
					} else if (e.which == 38) {
						if (li.hasClass('selected_filter')) {
							idx--;
							idx = idx <= 0 ? 0 : idx;
							li.removeClass('selected_filter');
							$('#autoDataLocation li:eq(' + idx + ')').addClass('selected_filter')
						}
					} else if (e.which == 13) {
						var userOption = $('#autoDataLocation li:eq(' + idx + ')').find('a').text();
						$('#location').val(userOption);
						$('#autoDataLocation').addClass('ng-hide');
						idx = 0;
					}

				}

				return false;
			}
			$timeout.cancel(typingTimer);
			typingTimer = $timeout(doneTyping, doneTypingInterval);
		});

		$scope.searchLocation = ''
		$scope.data = ''
		$scope.getAutoCompleteData = function (data) {

			$scope.data = data

			$scope.searchLocation = data.display_name;
			$scope.LocationId = data.id;
			if (!$('#autoDataLocation').hasClass('ng-hide')) {
				$('#autoDataLocation').addClass('ng-hide');
			}

			idx = 0;
		}

		$scope.$watch('searchLocation', function (newVal, oldVal) {
			if (newVal && $scope.data.display_name != newVal) {
				$scope.LocationId = null;
			} else {
				$scope.LocationId = $scope.data.id
			}


		});

		function doneTyping() {
			$scope.autoLocation = [];

			$http.get(registerConfig.APIRoot + 'static/autocomplete/location?q=' + $('#location').val() + '&country_id=' + $scope.country.id)
				.then(function (response) {
					$scope.autoLocation = response.data.data;
					if (!$scope.autoLocation.length) {
						$('#autoDataLocation').addClass('ng-hide');
					} else {
						$('#autoDataLocation').removeClass('ng-hide');
					}
				});

		}

		$scope.RegisterLocationSubmit = function () {
			var formData = [];
			$('#locationForm').serializeArray().map(function (item) {
				formData[item.name] = item.value;
			});
			if ($scope.LocationId != '' && $scope.searchLocation != '') {
				if ($scope.LocationId == null && $scope.searchLocation != null) {
					var newLocation = { country_id: $scope.country.id, location: $scope.searchLocation }
				} else {
					var newLocation = $scope.LocationId
				}
			} else {
				if ($scope.searchLocation != '') {
					var newLocation = { country_id: $scope.country.id, location: $scope.searchLocation }
				} else {
					var newLocation = $scope.country.id
				}

			}

			var industry = formData.subindustry != "" ? formData.subindustry : formData.industry;
			var preferred_location = newLocation;
			var qualification_provider = $('#locationForm').find('input[name="job_description[]"]')
			var qualification_provider_array = [];

			qualification_provider.each(function (k, v) {
				var keepGoing = true;
				var obj = $(v);
				var val = obj.val();
				val = val.toLowerCase();
				angular.forEach($scope.qualificationProviders, function (v1) {
					var provider = v1.provider_display_name;
					provider = provider.toLowerCase();
					if (provider == val) {
						qualification_provider_array.push(v1.id);
						keepGoing = false;
					}
				})
				if (keepGoing && obj.val()) {
					qualification_provider_array.push(obj.val())
				}

			})

			var data = {
				"data": {
					"industry": industry,
					"preferred_location": preferred_location,
					"qualification_provider": qualification_provider_array
				}
			}

			$http({
				url: registerConfig.CandidateUAProfile,
				method: 'put',
				data: data,
				headers: {
					'Content-Type': 'application/json',
					'X-Custom-Auth': aa_token
				},
			})
				.then(function (response) {
					$window.location.href = registerConfig.redirectPage;
				}, function (response) {
				});
		}

	}]);

	//Confirm Registration
	app.controller('RegisterConfirmController', ['registerConfig', '$scope', '$location', '$http', '$cookies', '$window', 'OAuth', 'OAuthToken', function (registerConfig, $scope, $location, $http, $cookies, $window, OAuth, OAuthToken) {
		var tokenid = getUrlParameter('token');
		var confirmUrl = registerConfig.confirmApi + tokenid;
		confirmUrl += '?client_id=' + '2_19ycww5xb15wsog4og840wkw08w4ccc8coowcgc80ksocsg4wo';
		confirmUrl += '&client_secret=' + '3z7ljdasp7mso4oc080w4sgw08kcoo0ook4ok0ok8g0ooogkss';
		$scope.preload = false;

		$http.post(confirmUrl)
			.then(function (response) {
				var data = response.data;
				$scope.preload = true;
				$scope.expire = data.expires_in;
				$scope.token = data.access_token;
				OAuthToken.setToken(data);
				$scope.refresh_token = data.refresh_token;
				$scope.loginUser();
			}, function (response) {
				//Error Condition
				$scope.title = "Error!"
				$scope.msg = response.data.message
				$scope.preload = true;

			});


		if ($cookies.get('ut')) {
			$scope.userType = $cookies.get('ut');
		}

		if ($cookies.get('company_url')) {
			$scope.company_url = $cookies.get('company_url');

		}

		$scope.loginUser = function () {
			var SetDateforLogin = new Date();
			var LoginTime = parseInt(SetDateforLogin.getTime() / 1000);
			var ExpireTime = parseInt(SetDateforLogin.getTime() / 1000) + $scope.expire;
			var ExpireTimetoDate = new Date(ExpireTime * 1000);

			//Store all data needed to cookies
			$cookies.put('token', $scope.token, { 'path': '/' });
			$cookies.put('LoginTime', LoginTime, { 'path': '/' });
			$cookies.put('exp', $scope.expire, { 'path': '/' });

			$http.get(registerConfig.CheckUserType).then(function (response) {

				var userType = response.data.data;
				var refresh_token = $scope.refresh_token;
				var token = $scope.token;
				$scope.userType = userType;

				$cookies.put('ut', userType, { 'path': '/' });

				if (userType == 'candidate') {



					//get ob_key for candidate
					$scope.params = { access_token: $cookies.get('token') };
					$http.get(registerConfig.profileApi)
						.then(function (response) {
							var data = response.data.data;
							$scope.email = data.email;
							$cookies.put('obkey', response.data.data.ob_key, { 'path': '/' });
						});


					$.ajax({
						url: registerConfig.tokenstorage,
						type: 'post',
						data: { token_refresh: refresh_token, token_access: token, username: $scope.email },
						success: function (token_id) {
							$cookies.put('token_id', token_id, { 'path': '/' });

						}
					}).done(function () {
						$scope.preload = true;
						$('#dashBoardLink').attr('href', base_url + 'dashboard');
						$('#editProfileLink').attr('href', base_url + 'my-profile/edit');
					});





				} else if (userType == 'employer') {



					$.ajax({
						url: registerConfig.tokenstorage,
						type: 'post',
						data: { token_refresh: refresh_token, token_access: token, username: $scope.email },
						success: function (token_id) {
							$cookies.put('token_id', token_id, { 'path': '/' });
							$http.get(registerConfig.APIRoot + 'employer/profile')
								.then(function (response) {
									var data = response.data.data;
									$cookies.put('company_url', data.company.company_url, { 'path': '/' });
									$scope.company_url = data.company.company_url;

									location.reload();
								}, function () {
									alert('error')
								});
						}
					}).done(function () {
						$scope.preload = true;
						$scope.title = 'Thanks for signing up!';
						$scope.msg = 'You are now ready to start recruiting talent, what would you like to do now? CREATE AND PUBLISH A ROLE TAKE ME TO MY COMPANY PROFILE TAKE ME TO MY DASHBOARD ';
						$scope.dashboardLink = 'employer/dashboard';
					});
				}

				if (angular.isDefined($cookies.get('redirectBack'))) {
					$window.location.href = $cookies.get('redirectBack');
					$cookies.remove('redirectBack', { 'path': '/' });
				}

			});

		}
	}]);
}());