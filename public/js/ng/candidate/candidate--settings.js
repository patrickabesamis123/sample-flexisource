(function () {
    'use strict';
    var app = angular.module('app');
    var jcropImage = "";
    var base_url = $('body').data('base_url');
    app.controller('CandidateSettingsController', ['GlobalConstant', 'fileUploadService', 'CandidateSettingsSvcs', '$parse', '$scope', '$cookies', '$window', '$http', '$filter', '$timeout', '$interval', '$location', 'OAuth', 'OAuthToken', '$rootScope', '$modal', '$log',
        function (GlobalConstant, fileUploadService, CandidateSettingsSvcs, $parse, $scope, $cookies, $window, $http, $filter, $timeout, $interval, $location, OAuth, OAuthToken, $rootScope, $modal, $log) {
            // changed jquery datepicker default date format
            var token = $cookies.get('api_token');
            var token_id = $cookies.get('token_id');
            var messageScrollCounter = 1;
            var getHash = window.location.hash.substring(1);

            // Get the Email Address of the Login User Candidate
            $http.get(window.location.origin + '/api/user-auth-data', {
                    headers: {
                        'Authorization': 'Bearer ' + token
                    }
                })
                .then(response => {
                    if (response.status === 200) {
                        let userData = response.data.data[0];
                        $scope.candidateEmail = userData.email;

                        $http.get(window.location.origin + '/api/candidate/info/' + userData.id).then(response => {
                            if (response.status === 200) {
                                $scope.profileUrl = response.data.profile_url;
                                $scope.userId = response.data.user_id;
                            }
                        });

                    }
                });

            $scope.changeEmail = (data) => {
                if (data.newEmail != data.confirmEmail) {
                    console.log('New Email Address does not match');
                    return false;
                }

                var modalInstance = $modal.open({
                    templateUrl: 'loginModal',
                    controller: 'LoginModalInstanceController',
                    resolve: {
                        actionType: () => {
                            return 'change-email'
                        },
                        emailData: () => {
                            return data
                        },
                        passwordData: () => {},
                        profileUrlData: () => {}
                    }
                });

                // Process Modal Result
                modalInstance.result.then(data => {
                    $scope.candidateEmail = data.email;
                    $('#changeEmailForm').find('input').removeClass('ng-touched');
                    $('#changeEmailForm').find('input').not(':submit').val("");
                }, () => {
                    $log.info('Modal dismissed at: ' + new Date());
                });

            }

            $scope.changePassword = (data) => {
                if (data.newPassword != data.confirmPassword) {
                    console.log('New Password does not match');
                    return false;
                }

                var modalInstance = $modal.open({
                    templateUrl: 'loginModal',
                    controller: 'LoginModalInstanceController',
                    resolve: {
                        actionType: () => {
                            return 'change-password'
                        },
                        emailData: () => {},
                        passwordData: () => {
                            return data
                        },
                        profileUrlData: () => {}
                    }
                });

                //Process Modal Result
                modalInstance.result.then(data => {
                    $('#changePasswordForm').find('input').removeClass('ng-touched');
                    $('#changePasswordForm').find('input').not(':submit').val("");
                }, () => {
                    $log.info('Modal dismissed at: ' + new Date());
                });

            }

            $scope.changeProfileUrl = (data) => {
                var modalInstance = $modal.open({
                    templateUrl: 'loginModal',
                    controller: 'LoginModalInstanceController',
                    resolve: {
                        actionType: () => {
                            return 'change-profile-url'
                        },
                        emailData: () => {},
                        passwordData: () => {},
                        profileUrlData: () => {
                            return data
                        }
                    }
                });

                //Process Modal Result
                modalInstance.result.then(data => {
                    $scope.profileUrl = data.profile_url;
                    $('#profileUrlForm').find('input').removeClass('ng-touched');
                    $('#profileUrlForm').find('input').not(':submit').val("");
                }, () => {
                    $log.info('Modal dismissed at: ' + new Date());
                });

            }

            // Disable Candidate
            $scope.disable_account = () => {
                $http.get(window.location.origin + '/api/candidate/account-settings/update-status/' + $scope.userId, {
                    headers: {
                        'Authorization': 'Bearer ' + token
                    }
                }).then(response => {
                    if (response.status === 200) {
                        alert('Account is disabled!');

                        $.ajax({
                            url: window.location.origin + '/api/logout',
                            headers: {
                                'Authorization': 'Bearer ' + token
                            },
                            data: {
                                token: token
                            },
                            method: 'GET',
                            success: (response) => {
                                if (response.success) {
                                    $window.location.href = window.location.origin + '/login';
                                }
                            },
                        });
                    }
                });
            }

            //Tabs
            var tab = $cookies.get('activeTab');
            $scope.linkTemp = null;
            if (tab == undefined) {
                $cookies.put('activeTab', 'tab1');
                $scope.tab1 = true;
                $scope.tab2 = false;
                $scope.tab3 = false;
            }
            if (tab === 'tab1') {
                $scope.tab1 = true;
                $scope.tab2 = false;
                $scope.tab3 = false;
            } else if (tab === 'tab2') {
                $scope.tab1 = false;
                $scope.tab2 = true;
                $scope.tab3 = false;
            } else if (tab === 'tab3') {
                $scope.tab1 = false;
                $scope.tab2 = false;
                $scope.tab3 = true;
            } else {
                $scope.tab1 = true;
                $scope.tab2 = false;
                $scope.tab3 = false;
            }
            $scope.privacyLoader = true;
            $scope.privacyLoaderBlacklist = true;
            $scope.communicationLoader = true;
            $scope.saveStatus = true;
            $scope.showDataStatusAlert = false;
            //Communication Settings
            $scope.communicationSettingData = {
                label: "Weekly",
                value: 'weekly'
            };
            $scope.comRoleOppProfileFrequency = {
                label: "Weekly",
                value: 'weekly'
            };
            $scope.newslettersFrequency = {
                label: "Weekly",
                value: 'weekly'
            };
            $scope.frequencyOptions = [{
                    label: "When published",
                    value: 'when_published'
                },
                {
                    label: "Weekly",
                    value: 'weekly'
                },
                {
                    label: "Fortnightly",
                    value: 'fortnightly'
                },
                {
                    label: "Monthly",
                    value: 'monthly'
                }
            ];
            //Privacy/Visibility Settings
            $scope.getDataPrivacySettings = [];
            $scope.privacySettingsData = {
                "type": "public",
                "settings": {
                    "seo_enabled": false,
                    "first_name": false,
                    "last_name": false,
                    "contact_number": false,
                    "email": false,
                    "location": false,
                    "about_me": false,
                    "profile_photo": false,
                    "generic_video": false,
                    "experience": false,
                    "education": false,
                    "references": false,
                    "resume": false,
                    "industry": false,
                    "sub_industry": false,
                    "supporting_docs": false
                }
            };

            $scope.modalStatus = false;
            $scope.animateShowModal = false;
            $scope.storeProfilePrivacyData = [];
            $scope.publicPrivateToggle = false;
            $scope.tempSeoSwitchData = null;
            $scope.showHelper = false;
            $scope.messageModal = false;

            $scope.privacyTouched = false;
            $scope.privacyFNamePublicSwitch = false;
            $scope.privacyFNameSearchEnginCheck = false;
            $scope.privacyLNamePublicSwitch = false;
            $scope.privacyLNameSearchEngine = false;
            $scope.privacySettingSelected = {
                value: "private"
            };
            $scope.privacySettings = [{
                    "label": "Private",
                    value: "private"
                },
                {
                    "label": "Public",
                    value: "public"
                }
            ];
            $scope.grantedCompanyItems = []
            $scope.requestAccessCompanyItems = []
            $scope.blockCompanyItems = [];
            $scope.privacySearchItem = "";
            $scope.privacySearchResults = [];

            $scope.privacySearchItemWhitelist = "";
            $scope.privacySearchResultsWhitelist = [];

            $scope.color = "";
            $scope.privacySearchResultsWhitelist = false;
            $scope.clearActiveBlacklisting = false;
            $scope.noResult = false;
            $scope.messageBlock = [];
            $scope.itemFalse = false;

            // Communication Settings Functions
            $scope.initCommunicationSettings = () => {

                $http.get(window.location.origin + '/api/user-auth-data', {
                        headers: {
                            'Authorization': 'Bearer ' + token
                        }
                    })
                    .then(response => {
                        if (response.status === 200) {
                            let userData = response.data.data[0];
                            $scope.candidateEmail = userData.email;

                            $http.get(window.location.origin + '/api/candidate/info/' + userData.id).then(response => {
                                if (response.status === 200) {
                                    $scope.userId = response.data.user_id;

                                    // Get Email Settings
                                    $http.get(window.location.origin + '/api/candidate/communication-settings/email/' + $scope.userId, {
                                        headers: {
                                            'Authorization': 'Bearer ' + token
                                        }
                                    }).then(res => {
                                        $scope.communicationSettingData.email_settings = res.data;
                                        $scope.communicationSettingData.email_settings.direct_messages = ($scope.communicationSettingData.email_settings.direct_messages === 1) ? true : false;
                                        $scope.communicationSettingData.email_settings.profile_metrics = ($scope.communicationSettingData.email_settings.profile_metrics === 1) ? true : false;
                                        $scope.communicationSettingData.email_settings.newsletters = ($scope.communicationSettingData.email_settings.newsletters === 1) ? true : false;
                                        $scope.communicationSettingData.email_settings.view_profile = ($scope.communicationSettingData.email_settings.view_profile === 1) ? true : false;
                                        $scope.communicationLoader = false;
                                    });

                                    // Get Notification Settings
                                    $http.get(window.location.origin + '/api/candidate/communication-settings/notification/' + $scope.userId, {
                                        headers: {
                                            'Authorization': 'Bearer ' + token
                                        }
                                    }).then(res => {
                                        $scope.communicationSettingData.notification_settings = res.data;
                                        $scope.communicationSettingData.notification_settings.direct_messages = ($scope.communicationSettingData.notification_settings.direct_messages === 1) ? true : false;
                                        $scope.communicationSettingData.notification_settings.new_roles = ($scope.communicationSettingData.notification_settings.new_roles === 1) ? true : false;
                                        $scope.communicationSettingData.notification_settings.view_profile = ($scope.communicationSettingData.notification_settings.view_profile === 1) ? true : false;
                                        $scope.communicationLoader = false;
                                    });
                                }
                            });

                        }
                    });

            };
            $scope.initCommunicationSettings();
            // $scope.updateCommunicationSelect = function (data, selectModelName) {
            //     if (selectModelName == 'profile_metrics_frequency') {
            //         $scope.communicationSettingData.email_settings.profile_metrics_frequency = data.value;
            //         $scope.comRoleOppProfileFrequency = {
            //             value: data.value
            //         }
            //     } else if (selectModelName == 'new_roles_frequency') {
            //         $scope.communicationSettingData.notification_settings.new_roles_frequency = data.value;
            //         $scope.comOpportunityNotifRequency = {
            //             value: data.value
            //         }
            //     } else if (selectModelName == 'newsletters_frequency') {
            //         $scope.communicationSettingData.email_settings.newsletters_frequency = data.value;
            //         $scope.newslettersFrequency = {
            //             value: data.value
            //         }
            //     }
            //     $scope.updateCommunicationSetting();
            // }
            // $scope.updateCommunicationSetting = function () {
            //     CandidateSettingsSvcs.postCommunicationSetting({
            //             data: $scope.communicationSettingData
            //         })
            //         .then(function (res) {})
            //         .catch(function (err) {
            //             alert('Something went wrong while fetching /saving your information.');
            //         });
            // }

            // Email Direct Messages
            $scope.$watch('communicationSettingData.email_settings.direct_messages', (newVal, oldVal) => {
                if (newVal != oldVal) {
                    $http.get(window.location.origin + '/api/user-auth-data', {
                            headers: {
                                'Authorization': 'Bearer ' + token
                            }
                        })
                        .then(response => {
                            if (response.status === 200) {
                                let userData = response.data.data[0];
                                $scope.candidateEmail = userData.email;

                                $http.get(window.location.origin + '/api/candidate/info/' + userData.id).then(response => {
                                    if (response.status === 200) {
                                        $scope.candidateId = response.data.id;

                                        // Save Settings
                                        let data = {
                                            candidate_id: $scope.candidateId,
                                            direct_messages: (newVal) ? 1 : 0,
                                            profile_metrics: ($scope.communicationSettingData.email_settings.profile_metrics) ? 1 : 0,
                                            profile_metrics_frequency: $scope.communicationSettingData.email_settings.profile_metrics_frequency,
                                            newsletters: ($scope.communicationSettingData.email_settings.newsletters) ? 1 : 0,
                                            newsletters_frequency: $scope.communicationSettingData.email_settings.newsletters_frequency,
                                            view_profile: ($scope.communicationSettingData.email_settings.view_profile) ? 1 : 0
                                        }

                                        $http.put(window.location.origin + '/api/candidate/communication-settings/email/update', data, {
                                            headers: {
                                                'Authorization': 'Bearer ' + token
                                            }
                                        }).then(res => {
                                            if (res.status === 200) {
                                                // console.log(res.data.message);
                                            }
                                        });
                                    }
                                });

                            }
                        });

                }
            });

            // Email Profile Metrics
            $scope.$watch('communicationSettingData.email_settings.profile_metrics', (newVal, oldVal) => {
                if (newVal != oldVal) {
                    $http.get(window.location.origin + '/api/user-auth-data', {
                            headers: {
                                'Authorization': 'Bearer ' + token
                            }
                        })
                        .then(response => {
                            if (response.status === 200) {
                                let userData = response.data.data[0];
                                $scope.candidateEmail = userData.email;

                                $http.get(window.location.origin + '/api/candidate/info/' + userData.id).then(response => {
                                    if (response.status === 200) {
                                        $scope.candidateId = response.data.id;

                                        // Save Settings
                                        let data = {
                                            candidate_id: $scope.candidateId,
                                            direct_messages: ($scope.communicationSettingData.email_settings.direct_messages) ? 1 : 0,
                                            profile_metrics: (newVal) ? 1 : 0,
                                            profile_metrics_frequency: $scope.communicationSettingData.email_settings.profile_metrics_frequency,
                                            newsletters: ($scope.communicationSettingData.email_settings.newsletters) ? 1 : 0,
                                            newsletters_frequency: $scope.communicationSettingData.email_settings.newsletters_frequency,
                                            view_profile: ($scope.communicationSettingData.email_settings.view_profile) ? 1 : 0
                                        }

                                        $http.put(window.location.origin + '/api/candidate/communication-settings/email/update', data, {
                                            headers: {
                                                'Authorization': 'Bearer ' + token
                                            }
                                        }).then(res => {
                                            if (res.status === 200) {
                                                // console.log(res.data.message);
                                            }
                                        });
                                    }
                                });

                            }
                        });

                }
            });

            // Email Profile Metrics Frequency
            $scope.$watch('communicationSettingData.email_settings.profile_metrics_frequency', (newVal, oldVal) => {
                if (newVal != oldVal) {
                    $http.get(window.location.origin + '/api/user-auth-data', {
                            headers: {
                                'Authorization': 'Bearer ' + token
                            }
                        })
                        .then(response => {
                            if (response.status === 200) {
                                let userData = response.data.data[0];
                                $scope.candidateEmail = userData.email;

                                $http.get(window.location.origin + '/api/candidate/info/' + userData.id).then(response => {
                                    if (response.status === 200) {
                                        $scope.candidateId = response.data.id;

                                        // Save Settings
                                        let data = {
                                            candidate_id: $scope.candidateId,
                                            direct_messages: ($scope.communicationSettingData.email_settings.direct_messages) ? 1 : 0,
                                            profile_metrics: ($scope.communicationSettingData.email_settings.profile_metrics) ? 1 : 0,
                                            profile_metrics_frequency: newVal,
                                            newsletters: ($scope.communicationSettingData.email_settings.newsletters) ? 1 : 0,
                                            newsletters_frequency: $scope.communicationSettingData.email_settings.newsletters_frequency,
                                            view_profile: ($scope.communicationSettingData.email_settings.view_profile) ? 1 : 0
                                        }

                                        $http.put(window.location.origin + '/api/candidate/communication-settings/email/update', data, {
                                            headers: {
                                                'Authorization': 'Bearer ' + token
                                            }
                                        }).then(res => {
                                            if (res.status === 200) {
                                                // console.log(res.data.message);
                                            }
                                        });
                                    }
                                });

                            }
                        });

                }
            });

            // Email Newsletter
            $scope.$watch('communicationSettingData.email_settings.newsletters', (newVal, oldVal) => {
                if (newVal != oldVal) {
                    $http.get(window.location.origin + '/api/user-auth-data', {
                            headers: {
                                'Authorization': 'Bearer ' + token
                            }
                        })
                        .then(response => {
                            if (response.status === 200) {
                                let userData = response.data.data[0];
                                $scope.candidateEmail = userData.email;

                                $http.get(window.location.origin + '/api/candidate/info/' + userData.id).then(response => {
                                    if (response.status === 200) {
                                        $scope.candidateId = response.data.id;

                                        // Save Settings
                                        let data = {
                                            candidate_id: $scope.candidateId,
                                            direct_messages: ($scope.communicationSettingData.email_settings.direct_messages) ? 1 : 0,
                                            profile_metrics: ($scope.communicationSettingData.email_settings.profile_metrics) ? 1 : 0,
                                            profile_metrics_frequency: $scope.communicationSettingData.email_settings.profile_metrics_frequency,
                                            newsletters: (newVal) ? 1 : 0,
                                            newsletters_frequency: $scope.communicationSettingData.email_settings.newsletters_frequency,
                                            view_profile: ($scope.communicationSettingData.email_settings.view_profile) ? 1 : 0
                                        }

                                        $http.put(window.location.origin + '/api/candidate/communication-settings/email/update', data, {
                                            headers: {
                                                'Authorization': 'Bearer ' + token
                                            }
                                        }).then(res => {
                                            if (res.status === 200) {
                                                // console.log(res.data.message);
                                            }
                                        });
                                    }
                                });

                            }
                        });

                }
            });

            // Email Newsletter Frequency
            $scope.$watch('communicationSettingData.email_settings.newsletters_frequency', (newVal, oldVal) => {
                if (newVal != oldVal) {
                    $http.get(window.location.origin + '/api/user-auth-data', {
                            headers: {
                                'Authorization': 'Bearer ' + token
                            }
                        })
                        .then(response => {
                            if (response.status === 200) {
                                let userData = response.data.data[0];
                                $scope.candidateEmail = userData.email;

                                $http.get(window.location.origin + '/api/candidate/info/' + userData.id).then(response => {
                                    if (response.status === 200) {
                                        $scope.candidateId = response.data.id;

                                        // Save Settings
                                        let data = {
                                            candidate_id: $scope.candidateId,
                                            direct_messages: ($scope.communicationSettingData.email_settings.direct_messages) ? 1 : 0,
                                            profile_metrics: ($scope.communicationSettingData.email_settings.profile_metrics) ? 1 : 0,
                                            profile_metrics_frequency: $scope.communicationSettingData.email_settings.profile_metrics_frequency,
                                            newsletters: ($scope.communicationSettingData.email_settings.newsletters) ? 1 : 0,
                                            newsletters_frequency: newVal,
                                            view_profile: ($scope.communicationSettingData.email_settings.view_profile) ? 1 : 0
                                        }

                                        $http.put(window.location.origin + '/api/candidate/communication-settings/email/update', data, {
                                            headers: {
                                                'Authorization': 'Bearer ' + token
                                            }
                                        }).then(res => {
                                            if (res.status === 200) {
                                                // console.log(res.data.message);
                                            }
                                        });
                                    }
                                });

                            }
                        });

                }
            });

            // Email View Profile
            $scope.$watch('communicationSettingData.email_settings.view_profile', (newVal, oldVal) => {
                if (newVal != oldVal) {
                    $http.get(window.location.origin + '/api/user-auth-data', {
                            headers: {
                                'Authorization': 'Bearer ' + token
                            }
                        })
                        .then(response => {
                            if (response.status === 200) {
                                let userData = response.data.data[0];
                                $scope.candidateEmail = userData.email;

                                $http.get(window.location.origin + '/api/candidate/info/' + userData.id).then(response => {
                                    if (response.status === 200) {
                                        $scope.candidateId = response.data.id;

                                        // Save Settings
                                        let data = {
                                            candidate_id: $scope.candidateId,
                                            direct_messages: ($scope.communicationSettingData.email_settings.direct_messages) ? 1 : 0,
                                            profile_metrics: ($scope.communicationSettingData.email_settings.profile_metrics) ? 1 : 0,
                                            profile_metrics_frequency: $scope.communicationSettingData.email_settings.profile_metrics_frequency,
                                            newsletters: ($scope.communicationSettingData.email_settings.newsletters) ? 1 : 0,
                                            newsletters_frequency: $scope.communicationSettingData.email_settings.newsletters_frequency,
                                            view_profile: (newVal) ? 1 : 0
                                        }

                                        $http.put(window.location.origin + '/api/candidate/communication-settings/email/update', data, {
                                            headers: {
                                                'Authorization': 'Bearer ' + token
                                            }
                                        }).then(res => {
                                            if (res.status === 200) {
                                                // console.log(res.data.message);
                                            }
                                        });
                                    }
                                });

                            }
                        });

                }
            });

            // Notification Direct Messages
            $scope.$watch('communicationSettingData.notification_settings.direct_messages', (newVal, oldVal) => {
                if (newVal != oldVal) {
                    $http.get(window.location.origin + '/api/user-auth-data', {
                            headers: {
                                'Authorization': 'Bearer ' + token
                            }
                        })
                        .then(response => {
                            if (response.status === 200) {
                                let userData = response.data.data[0];
                                $scope.candidateEmail = userData.email;

                                $http.get(window.location.origin + '/api/candidate/info/' + userData.id).then(response => {
                                    if (response.status === 200) {
                                        $scope.candidateId = response.data.id;

                                        // Save Settings
                                        let data = {
                                            candidate_id: $scope.candidateId,
                                            direct_messages: (newVal) ? 1 : 0,
                                            new_roles: ($scope.communicationSettingData.notification_settings.new_roles) ? 1 : 0,
                                            new_roles_frequency: $scope.communicationSettingData.notification_settings.new_roles_frequency,
                                            view_profile: ($scope.communicationSettingData.notification_settings.view_profile) ? 1 : 0
                                        }

                                        $http.put(window.location.origin + '/api/candidate/communication-settings/notification/update', data, {
                                            headers: {
                                                'Authorization': 'Bearer ' + token
                                            }
                                        }).then(res => {
                                            if (res.status === 200) {
                                                // console.log(res.data.message);
                                            }
                                        });
                                    }
                                });

                            }
                        });

                }
            });

            // Notification New Roles
            $scope.$watch('communicationSettingData.notification_settings.new_roles', (newVal, oldVal) => {
                if (newVal != oldVal) {
                    $http.get(window.location.origin + '/api/user-auth-data', {
                            headers: {
                                'Authorization': 'Bearer ' + token
                            }
                        })
                        .then(response => {
                            if (response.status === 200) {
                                let userData = response.data.data[0];
                                $scope.candidateEmail = userData.email;

                                $http.get(window.location.origin + '/api/candidate/info/' + userData.id).then(response => {
                                    if (response.status === 200) {
                                        $scope.candidateId = response.data.id;

                                        // Save Settings
                                        let data = {
                                            candidate_id: $scope.candidateId,
                                            direct_messages: ($scope.communicationSettingData.notification_settings.direct_messages) ? 1 : 0,
                                            new_roles: (newVal) ? 1 : 0,
                                            new_roles_frequency: $scope.communicationSettingData.notification_settings.new_roles_frequency,
                                            view_profile: ($scope.communicationSettingData.notification_settings.view_profile) ? 1 : 0
                                        }

                                        $http.put(window.location.origin + '/api/candidate/communication-settings/notification/update', data, {
                                            headers: {
                                                'Authorization': 'Bearer ' + token
                                            }
                                        }).then(res => {
                                            if (res.status === 200) {
                                                // console.log(res.data.message);
                                            }
                                        });
                                    }
                                });

                            }
                        });

                }
            });

            // Notification New Roles Frequency
            $scope.$watch('communicationSettingData.notification_settings.new_roles_frequency', (newVal, oldVal) => {
                if (newVal != oldVal) {
                    $http.get(window.location.origin + '/api/user-auth-data', {
                            headers: {
                                'Authorization': 'Bearer ' + token
                            }
                        })
                        .then(response => {
                            if (response.status === 200) {
                                let userData = response.data.data[0];
                                $scope.candidateEmail = userData.email;

                                $http.get(window.location.origin + '/api/candidate/info/' + userData.id).then(response => {
                                    if (response.status === 200) {
                                        $scope.candidateId = response.data.id;

                                        // Save Settings
                                        let data = {
                                            candidate_id: $scope.candidateId,
                                            direct_messages: ($scope.communicationSettingData.notification_settings.direct_messages) ? 1 : 0,
                                            new_roles: ($scope.communicationSettingData.notification_settings.new_roles) ? 1 : 0,
                                            new_roles_frequency: newVal,
                                            view_profile: ($scope.communicationSettingData.notification_settings.view_profile) ? 1 : 0
                                        }

                                        $http.put(window.location.origin + '/api/candidate/communication-settings/notification/update', data, {
                                            headers: {
                                                'Authorization': 'Bearer ' + token
                                            }
                                        }).then(res => {
                                            if (res.status === 200) {
                                                // console.log(res.data.message);
                                            }
                                        });
                                    }
                                });

                            }
                        });

                }
            });

            // Notification View Profile
            $scope.$watch('communicationSettingData.notification_settings.view_profile', (newVal, oldVal) => {
                if (newVal != oldVal) {
                    $http.get(window.location.origin + '/api/user-auth-data', {
                            headers: {
                                'Authorization': 'Bearer ' + token
                            }
                        })
                        .then(response => {
                            if (response.status === 200) {
                                let userData = response.data.data[0];
                                $scope.candidateEmail = userData.email;

                                $http.get(window.location.origin + '/api/candidate/info/' + userData.id).then(response => {
                                    if (response.status === 200) {
                                        $scope.candidateId = response.data.id;

                                        // Save Settings
                                        let data = {
                                            candidate_id: $scope.candidateId,
                                            direct_messages: ($scope.communicationSettingData.notification_settings.direct_messages) ? 1 : 0,
                                            new_roles: ($scope.communicationSettingData.notification_settings.new_roles) ? 1 : 0,
                                            new_roles_frequency: $scope.communicationSettingData.notification_settings.new_roles_frequency,
                                            view_profile: (newVal) ? 1 : 0
                                        }

                                        $http.put(window.location.origin + '/api/candidate/communication-settings/notification/update', data, {
                                            headers: {
                                                'Authorization': 'Bearer ' + token
                                            }
                                        }).then(res => {
                                            if (res.status === 200) {
                                                // console.log(res.data.message);
                                            }
                                        });
                                    }
                                });

                            }
                        });

                }
            });

            //Privacy Settings Functions
            $scope.getWhiteListingInit = () => {
                $http.get(window.location.origin + '/api/user-auth-data', {
                        headers: {
                            'Authorization': 'Bearer ' + token
                        }
                    })
                    .then(response => {
                        if (response.status === 200) {
                            let userData = response.data.data[0];
                            $scope.candidateEmail = userData.email;

                            $http.get(window.location.origin + '/api/candidate/info/' + userData.id).then(response => {
                                if (response.status === 200) {
                                    $scope.candidateId = response.data.id;

                                    $http.get(window.location.origin + '/api/candidate/whitelisted-companies/request/' + $scope.candidateId, {
                                        headers: {
                                            'Authorization': 'Bearer ' + token
                                        }
                                    }).then(res => {
                                        if (res.status === 200) {
                                            $scope.requestAccessCompanyItems = [];
                                            angular.forEach(res.data, function (value, key) {
                                                value['color'] = $scope.randomColor(value.companies.company_name);
                                                value['initials'] = $scope.generateInitials(value.companies.company_name);
                                                $scope.requestAccessCompanyItems.push(value);
                                            });
                                        }
                                    });
                                }
                            });

                        }
                    });
            }

            $scope.initPrivacySettings = () => {
                $scope.blockCompanyItems = [];
                $scope.blockCompanyItemsTemp = [];
                $scope.privacyLoaderBlacklist = true;

                $http.get(window.location.origin + '/api/user-auth-data', {
                        headers: {
                            'Authorization': 'Bearer ' + token
                        }
                    })
                    .then(response => {
                        if (response.status === 200) {
                            let userData = response.data.data[0];
                            $scope.candidateEmail = userData.email;

                            // Get Candidate Info
                            $http.get(window.location.origin + '/api/candidate/info/' + userData.id).then(response => {
                                if (response.status === 200) {
                                    $scope.profileUrl = response.data.profile_url;
                                }
                            });

                            // Get Settings
                            $http.get(window.location.origin + '/api/candidate/privacy-settings/' + userData.id, {
                                headers: {
                                    'Authorization': 'Bearer ' + token
                                }
                            }).then(res => {
                                if (res.status === 200) {
                                    $scope.privacyLoader = false;
                                    $scope.privacySettingsData = res.data;
                                    $scope.privacySettingSelected.value = res.data.type;
                                    $scope.messageBlock = res.data.statements;
                                    if ($scope.messageBlock) {
                                        $scope.messageBlock = $scope.messageBlock.slice(0, $scope.messageBlock.length - 1);
                                    }
                                }
                            });

                            // Get Approved Whitelist Companies
                            $http.get(window.location.origin + '/api/candidate/info/' + userData.id).then(response => {
                                if (response.status === 200) {
                                    $scope.candidateId = response.data.id;

                                    $http.get(window.location.origin + '/api/candidate/whitelisted-companies/' + $scope.candidateId, {
                                        headers: {
                                            'Authorization': 'Bearer ' + token
                                        }
                                    }).then(res => {
                                        if (res.status === 200) {
                                            $scope.grantedCompanyItems = res.data;
                                        }
                                    });
                                }
                            });

                            // Get Approved Blacklist Companies
                            $http.get(window.location.origin + '/api/candidate/info/' + userData.id).then(response => {
                                if (response.status === 200) {
                                    $scope.candidateId = response.data.id;

                                    $http.get(window.location.origin + '/api/candidate/blacklisted-companies/' + $scope.candidateId, {
                                        headers: {
                                            'Authorization': 'Bearer ' + token
                                        }
                                    }).then(res => {
                                        if (res.status === 200) {
                                            $scope.blockCompanyItems = res.data;
                                            $scope.privacyLoaderBlacklist = false;
                                        }
                                    });
                                }
                            });

                        }
                    });

                $scope.getWhiteListingInit();

            }

            $scope.filterWhiteListed = function (newWhilistItem) {
                angular.forEach(newWhilistItem, function (newItem, $index) {
                    angular.forEach($scope.grantedCompanyItems, function (granted) {
                        if (newItem.id == granted.id) {
                            $scope.newWhilistItem.splice($index, 1);
                        }
                    });
                });
                return newWhilistItem;
            }

            $scope.watchWhilelist = function () {
                $scope.newWhilistItem = [];
                var arrayLength;
                $interval(function () {
                    $scope.newWhilistItem = [];
                    CandidateSettingsSvcs.getPrivacySettingWhiteListRequest()
                        .then(function (res) {
                            angular.forEach(res, function (value, key) {
                                value['color'] = $scope.randomColor(value.company_name);
                                value['initials'] = $scope.generateInitials(value.company_name);
                                $scope.newWhilistItem.push(value);
                            });
                            $scope.requestAccessCompanyItems = $scope.filterWhiteListed($scope.newWhilistItem);
                        });
                }, 15000);
            }

            $scope.initPrivacySettings();
            $scope.watchWhilelist();

            $scope.updatePrivacySettings = () => {
                $http.get(window.location.origin + '/api/user-auth-data', {
                        headers: {
                            'Authorization': 'Bearer ' + token
                        }
                    })
                    .then(response => {
                        if (response.status === 200) {
                            let userData = response.data.data[0];
                            let data = $scope.privacySettingsData;

                            // Check if data has candidate_id
                            if (data.hasOwnProperty('candidate_id')) {
                                let data = {
                                    candidate_id: $scope.privacySettingsData.candidate_id,
                                    type: $scope.privacySettingsData.type,
                                    settings: {
                                        "seo_enabled": $scope.privacySettingsData.settings.seo_enabled,
                                        "first_name": $scope.privacySettingsData.settings.first_name,
                                        "last_name": $scope.privacySettingsData.settings.last_name,
                                        "contact_number": $scope.privacySettingsData.settings.contact_number,
                                        "email": $scope.privacySettingsData.settings.email,
                                        "location": $scope.privacySettingsData.settings.location,
                                        "about_me": $scope.privacySettingsData.settings.about_me,
                                        "industry": $scope.privacySettingsData.settings.industry,
                                        "sub_industry": $scope.privacySettingsData.settings.sub_industry,
                                        "profile_photo": $scope.privacySettingsData.settings.profile_photo,
                                        "generic_video": $scope.privacySettingsData.settings.generic_video,
                                        "experience": $scope.privacySettingsData.settings.experience,
                                        "education": $scope.privacySettingsData.settings.education,
                                        "references": $scope.privacySettingsData.settings.references,
                                        "resume": $scope.privacySettingsData.settings.resume,
                                        "supporting_docs": $scope.privacySettingsData.settings.supporting_docs
                                    }
                                }

                                // Save Settings
                                $http.put(window.location.origin + '/api/candidate/privacy-settings/update', data, {
                                    headers: {
                                        'Authorization': 'Bearer ' + token
                                    }
                                }).then(res => {
                                    if (res.status === 200) {
                                        $scope.privacyLoader = false;
                                        $scope.messageBlock = res.data.data;
                                        $scope.errorData = true;
                                        if ($scope.messageBlock) {
                                            $scope.messageBlock = $scope.messageBlock.slice(0, $scope.messageBlock.length - 1);
                                        }
                                    }
                                }).catch(err => {
                                    $scope.privacyLoader = false;
                                    $scope.errorData = false;
                                });

                                return false;
                            }

                            $http.get(window.location.origin + '/api/candidate/info/' + userData.id).then(res => {
                                if (res.status === 200) {
                                    let data = {
                                        candidate_id: res.data.id,
                                        type: $scope.privacySettingsData.type,
                                        settings: {
                                            "seo_enabled": $scope.privacySettingsData.settings.seo_enabled,
                                            "first_name": $scope.privacySettingsData.settings.first_name,
                                            "last_name": $scope.privacySettingsData.settings.last_name,
                                            "contact_number": $scope.privacySettingsData.settings.contact_number,
                                            "email": $scope.privacySettingsData.settings.email,
                                            "location": $scope.privacySettingsData.settings.location,
                                            "about_me": $scope.privacySettingsData.settings.about_me,
                                            "industry": $scope.privacySettingsData.settings.industry,
                                            "sub_industry": $scope.privacySettingsData.settings.sub_industry,
                                            "profile_photo": $scope.privacySettingsData.settings.profile_photo,
                                            "generic_video": $scope.privacySettingsData.settings.generic_video,
                                            "experience": $scope.privacySettingsData.settings.experience,
                                            "education": $scope.privacySettingsData.settings.education,
                                            "references": $scope.privacySettingsData.settings.references,
                                            "resume": $scope.privacySettingsData.settings.resume,
                                            "supporting_docs": $scope.privacySettingsData.settings.supporting_docs
                                        }
                                    }

                                    // Save Settings
                                    $http.put(window.location.origin + '/api/candidate/privacy-settings/update', data, {
                                        headers: {
                                            'Authorization': 'Bearer ' + token
                                        }
                                    }).then(res => {
                                        if (res.status === 200) {
                                            $scope.privacyLoader = false;
                                            $scope.messageBlock = res.data.data;
                                            $scope.errorData = true;
                                            if ($scope.messageBlock) {
                                                $scope.messageBlock = $scope.messageBlock.slice(0, $scope.messageBlock.length - 1);
                                            }
                                        }
                                    }).catch(err => {
                                        $scope.privacyLoader = false;
                                        $scope.errorData = false;
                                    });
                                }
                            });

                        }
                    });
            };

            $scope.privacySettingItemSwitch = function () {
                // Call the Update Privacy Settings Function
                $scope.updatePrivacySettings();
            };

            $scope.privacySettingItemSwitchNull = function () {
                $scope.itemFalse = false;
            };

            $scope.updatePrivacyGetSettingUpdate = (data) => {
                // PUBLIC
                if (data.value === 'public') {
                    $scope.privacySettingSelected = {
                        value: "private"
                    };
                    $scope.modalStatus = true;
                    $scope.publicPrivateToggle = true;
                    $scope.storeProfilePrivacyData = data;
                    $timeout(() => {
                        $scope.animateShowModal = true;
                    }, 100);

                    return false;
                }

                // PRIVATE
                $scope.privacySettingSelected = {
                    value: "private"
                };
                $scope.profilePrivacySettingUpdate(data);

                // Call the Update Privacy Settings Function
                $scope.updatePrivacySettings();

            }

            $scope.seoSwitch = function (data) {
                $scope.seoSwitchToggle = true;
                if (data === true) {
                    $scope.tempSeoSwitchData = data;
                    $scope.privacySettingsData.settings.seo_enabled = false;
                    $scope.modalStatus = true;
                    $timeout(function () {
                        $scope.animateShowModal = true;
                    }, 100);
                } else {
                    $scope.privacySettingsData.settings.seo_enabled = data;
                    $scope.privacySettingItemSwitch();
                }
            }

            // PUBLIC|PRIVATE|SEO UPDATE STATUS 
            $scope.aggreeUpdate = (e) => {
                if (e === 'privatePublicSetting') {
                    $scope.privacySettingSelected = $scope.storeProfilePrivacyData;
                    $scope.profilePrivacySettingUpdate($scope.storeProfilePrivacyData);
                    $scope.privacyTouched = true;
                }
                if (e === 'seoSwitchSetting') {
                    $scope.privacySettingsData.settings.seo_enabled = true;
                    $scope.privacySettingItemSwitch();
                }
                $timeout(() => {
                    $scope.modalStatus = false;
                    $scope.publicPrivateToggle = false;
                    $scope.seoSwitchToggle = false;
                    $scope.showDataStatusAlert = false;
                }, 1000);
                $timeout(() => {
                    $scope.animateShowModal = false;
                }, 100);

                // Call the Update Privacy Settings Function
                $scope.updatePrivacySettings();

            }

            $scope.showHelperToggle = function () {
                $scope.publicPrivateToggle = false;
                $scope.showHelper = true;
                $scope.modalStatus = true;
                $timeout(function () {
                    $scope.animateShowModal = true;
                }, 100);
            }
            $scope.cancelModal = function () {
                $scope.privacyLoader = false;
                $timeout(function () {
                    $scope.modalStatus = false;
                    $scope.publicPrivateToggle = false;
                    $scope.seoSwitchToggle = false;
                    $scope.showHelper = false;
                    $scope.showDataStatusAlert = false;
                    $scope.messageModal = false;
                }, 1200);
                $timeout(function () {
                    $scope.animateShowModal = false;
                }, 100);
            }
            $scope.profilePrivacySettingUpdate = function (data) {
                $scope.privacySettingsData.type = data.value;
            }

            //Privacy Whitelisting
            $scope.allowWhiteList = (company, $index) => {
                $scope.privacyTouched = true;

                $http.get(window.location.origin + '/api/user-auth-data', {
                        headers: {
                            'Authorization': 'Bearer ' + token
                        }
                    })
                    .then(response => {
                        if (response.status === 200) {
                            let userData = response.data.data[0];

                            $http.get(window.location.origin + '/api/candidate/info/' + userData.id).then(res => {
                                if (res.status === 200) {
                                    $scope.candidate_id = res.data.id;

                                    let data = {
                                        candidate_id: $scope.candidate_id,
                                        company_id: company.companies.id
                                    }

                                    // Save Settings
                                    $http.put(window.location.origin + '/api/candidate/whitelisted-companies/allow', data, {
                                        headers: {
                                            'Authorization': 'Bearer ' + token
                                        }
                                    }).then(res => {
                                        if (res.status === 200) {
                                            $scope.grantedCompanyItems.push(company);
                                            $scope.requestAccessCompanyItems.splice($index, 1);
                                        }
                                    }).catch(err => {});
                                }
                            });

                        }
                    });

            };

            $scope.declineWhiteList = (company, $index) => {
                $http.get(window.location.origin + '/api/user-auth-data', {
                        headers: {
                            'Authorization': 'Bearer ' + token
                        }
                    })
                    .then(response => {
                        if (response.status === 200) {
                            let userData = response.data.data[0];

                            $http.get(window.location.origin + '/api/candidate/info/' + userData.id).then(res => {
                                if (res.status === 200) {
                                    $scope.candidate_id = res.data.id;

                                    let data = {
                                        candidate_id: $scope.candidate_id,
                                        company_id: company.companies.id
                                    }

                                    // Save Settings
                                    $http.put(window.location.origin + '/api/candidate/whitelisted-companies/decline', data, {
                                        headers: {
                                            'Authorization': 'Bearer ' + token
                                        }
                                    }).then(res => {
                                        if (res.status === 200) {
                                            $scope.requestAccessCompanyItems.splice($index, 1);
                                        }
                                    }).catch(err => {});
                                }
                            });

                        }
                    });

            };

            $scope.removeWhiteListed = (compId, $index, $event) => {
                $scope.grantedCompanyItems.splice($index, 1);
                $scope.privacyTouched = true;

                $http.get(window.location.origin + '/api/user-auth-data', {
                        headers: {
                            'Authorization': 'Bearer ' + token
                        }
                    })
                    .then(response => {
                        if (response.status === 200) {
                            let userData = response.data.data[0];

                            $http.get(window.location.origin + '/api/candidate/info/' + userData.id).then(res => {
                                if (res.status === 200) {
                                    $scope.candidate_id = res.data.id;

                                    let data = {
                                        candidate_id: $scope.candidate_id,
                                        company_ids: $scope.whiteListIdGenerator($scope.grantedCompanyItems)
                                    }

                                    // Save Settings
                                    $http.put(window.location.origin + '/api/candidate/whitelisted-companies/store', data, {
                                        headers: {
                                            'Authorization': 'Bearer ' + token
                                        }
                                    }).then(res => {
                                        if (res.status === 200) {
                                            $scope.privacyLoader = false;
                                            $scope.errorData = true;
                                        }
                                    }).catch(err => {
                                        $scope.privacyLoader = false;
                                        $scope.errorData = false;
                                    });
                                }
                            });

                        }
                    });

            };

            $scope.addWhitelistedCompany = (data, index) => {
                $scope.companyIdsWhiteList = [];
                $scope.grantedCompanyItems.push({
                    companies: data
                });

                angular.forEach($scope.grantedCompanyItems, (value, key) => {
                    $scope.companyIdsWhiteList.push(value.companies.id);
                });

                $scope.privacySearchResultsWhitelist.splice(index, 1);

                $http.get(window.location.origin + '/api/user-auth-data', {
                        headers: {
                            'Authorization': 'Bearer ' + token
                        }
                    })
                    .then(response => {
                        if (response.status === 200) {
                            let userData = response.data.data[0];

                            $http.get(window.location.origin + '/api/candidate/info/' + userData.id).then(res => {
                                if (res.status === 200) {
                                    $scope.candidate_id = res.data.id;

                                    let data = {
                                        candidate_id: $scope.candidate_id,
                                        company_ids: $scope.whiteListIdGenerator($scope.grantedCompanyItems)
                                    }

                                    // Save Settings
                                    $http.put(window.location.origin + '/api/candidate/whitelisted-companies/store', data, {
                                        headers: {
                                            'Authorization': 'Bearer ' + token
                                        }
                                    }).then(res => {
                                        if (res.status === 200) {
                                            $scope.privacyLoader = false;
                                            $scope.errorData = true;
                                        }
                                    }).catch(err => {
                                        $scope.privacyLoader = false;
                                        $scope.errorData = false;
                                    });
                                }
                            });

                        }
                    });

                $scope.privacySearchItemWhitelist = "";
                $scope.privacySearchResultsWhitelist = [];

            };

            $scope.addBlockedCompany = (data, index) => {
                var companyIds = [];
                $scope.blockCompanyItems.push({
                    companies: data
                });

                angular.forEach($scope.blockCompanyItems, function (value, key) {
                    companyIds.push(value.companies.id);
                });

                $scope.privacySearchResults.splice(index, 1);

                $http.get(window.location.origin + '/api/user-auth-data', {
                        headers: {
                            'Authorization': 'Bearer ' + token
                        }
                    })
                    .then(response => {
                        if (response.status === 200) {
                            let userData = response.data.data[0];

                            $http.get(window.location.origin + '/api/candidate/info/' + userData.id).then(res => {
                                if (res.status === 200) {
                                    $scope.candidate_id = res.data.id;

                                    let data = {
                                        candidate_id: $scope.candidate_id,
                                        company_ids: companyIds
                                    }

                                    // Save Settings
                                    $http.put(window.location.origin + '/api/candidate/blacklisted-companies/store', data, {
                                        headers: {
                                            'Authorization': 'Bearer ' + token
                                        }
                                    }).then(res => {
                                        if (res.status === 200) {
                                            $scope.errorData = true;
                                        }
                                    }).catch(err => {
                                        $scope.saveStatus = true;
                                        $scope.errorData = false;
                                    });
                                }
                            });

                        }
                    });

                $scope.privacySearchResults = [];
                $scope.privacySearchItem = "";

            };

            $scope.unblockCompany = (data, index, event) => {
                if ($scope.privacySearchResults.length > 0) {
                    $scope.privacySearchResults.push(data);
                }

                var i = $scope.blockCompanyItems.findIndex(item => {
                    if (item.companies.id === data.id) {
                        return data;
                    } else {
                        return null;
                    }
                });

                $scope.blockCompanyItems.splice(i, 1);
                $scope.privacyTouched = true;

                var companyIds = [];

                angular.forEach($scope.blockCompanyItems, (value, key) => {
                    companyIds.push(value.companies.id);
                });

                $http.get(window.location.origin + '/api/user-auth-data', {
                        headers: {
                            'Authorization': 'Bearer ' + token
                        }
                    })
                    .then(response => {
                        if (response.status === 200) {
                            let userData = response.data.data[0];

                            $http.get(window.location.origin + '/api/candidate/info/' + userData.id).then(res => {
                                if (res.status === 200) {
                                    $scope.candidate_id = res.data.id;

                                    let data = {
                                        candidate_id: $scope.candidate_id,
                                        company_ids: companyIds
                                    }

                                    // Save Settings
                                    $http.put(window.location.origin + '/api/candidate/blacklisted-companies/store', data, {
                                        headers: {
                                            'Authorization': 'Bearer ' + token
                                        }
                                    }).then(res => {
                                        if (res.status === 200) {
                                            $scope.errorData = true;
                                        }
                                    }).catch(err => {
                                        $scope.saveStatus = true;
                                        $scope.errorData = false;
                                    });
                                }
                            });

                        }
                    });

            }

            // Clear Company Search
            $scope.clearSearch = (e, type) => {
                document.getElementById(e).value = "";

                if (type === 'whitelist') {
                    $scope.clearActiveWhitelisting = false;
                    $scope.privacySearchItemWhitelist = null;
                    $scope.privacySearchResultsWhitelist = [];
                }
                if (type === 'blacklist') {
                    $scope.privacySearchItem = null;
                    $scope.privacySearchResults = [];
                    $scope.clearActiveBlacklisting = false;
                }
            }

            // Search Company
            $scope.searchComp = (e, type) => {
                var checkInput = document.getElementById("pvm-search-input").value;

                // WHITELIST
                if (type === 'whitelist') {
                    $scope.privacySearchResultsWhitelist = [];
                    $scope.clearActiveWhitelisting = true;
                    var whitelistingResult = [];

                    $http.get(window.location.origin + '/api/user-auth-data', {
                            headers: {
                                'Authorization': 'Bearer ' + token
                            }
                        })
                        .then(response => {
                            if (response.status === 200) {
                                let userData = response.data.data[0];

                                $http.get(window.location.origin + '/api/company/all/active').then(res => {
                                    if (res.status === 200) {
                                        if (res.data.length > 0) {
                                            angular.forEach(res.data, (value, key) => {
                                                value['color'] = $scope.randomColor(value.company_name);
                                                value['initials'] = $scope.generateInitials(value.company_name);
                                                whitelistingResult.push(value);
                                            });

                                            if (whitelistingResult.length > 0) {
                                                for (var index = 0; index < whitelistingResult.length; index++) {
                                                    for (var i = 0; i < $scope.grantedCompanyItems.length; i++) {
                                                        if ($scope.grantedCompanyItems[i].companies.id === whitelistingResult[index].id) {
                                                            whitelistingResult[index].drop = true;
                                                        }
                                                    }
                                                }
                                            } else {
                                                $scope.noResult2 = true;
                                                $scope.privacySearchResultsWhitelist = [];
                                            }
                                            $scope.noResult2 = false;
                                        } else {
                                            $scope.noResult2 = true;
                                        }

                                        $scope.companyFilter = {
                                            company_name: e
                                        };

                                        $scope.privacySearchResultsWhitelist = $scope.cleanFiltered(whitelistingResult);

                                        if ($scope.cleanFiltered(whitelistingResult).length === 0) {
                                            $scope.noResult2 = true;
                                        } else {
                                            $scope.noResult2 = false;
                                        }
                                    }
                                });

                            }
                        });

                }

                if (type == 'blacklist') {
                    $scope.privacySearchResults = [];
                    $scope.noResult = false;
                    $scope.clearActiveBlacklisting = true;
                    var blacklistResult = [];

                    $http.get(window.location.origin + '/api/user-auth-data', {
                            headers: {
                                'Authorization': 'Bearer ' + token
                            }
                        })
                        .then(response => {
                            if (response.status === 200) {
                                let userData = response.data.data[0];

                                $http.get(window.location.origin + '/api/company/all/active').then(res => {
                                    if (res.status === 200) {
                                        if (res.data.length > 0) {
                                            angular.forEach(res.data, (value, key) => {
                                                value['color'] = $scope.randomColor(value.company_name);
                                                value['initials'] = $scope.generateInitials(value.company_name);
                                                blacklistResult.push(value);
                                            });

                                            if (blacklistResult.length > 0) {
                                                for (var index = 0; index < blacklistResult.length; index++) {
                                                    for (var i = 0; i < $scope.blockCompanyItems.length; i++) {
                                                        if ($scope.blockCompanyItems[i].companies.id === blacklistResult[index].id) {
                                                            blacklistResult[index].drop = true;
                                                        }
                                                    }
                                                }
                                                $scope.noResult = false;
                                                $scope.privacySearchResults = blacklistResult;
                                            } else {
                                                $scope.noResult2 = true;
                                                $scope.privacySearchResults = [];
                                            }
                                            $scope.noResult2 = false;
                                        } else {
                                            $scope.noResult2 = true;
                                        }

                                        $scope.companyFilter = {
                                            company_name: e
                                        };

                                        $scope.privacySearchResults = $scope.cleanFiltered(blacklistResult);
                                        if ($scope.cleanFiltered(blacklistResult).length === 0) {
                                            $scope.noResult2 = true;
                                        } else {
                                            $scope.noResult2 = false;
                                        }
                                    }
                                });

                            }
                        });

                }
            };

            $scope.cleanFiltered = (array) => {
                var newArray = [];
                for (var i = 0; i < array.length; i++) {
                    if (array[i].drop !== true) {
                        newArray.push(array[i]);
                    }
                }
                return newArray;
            }

            $scope.masterSaveData = function () {
                $scope.noResult = false;
                $scope.noResult2 = false;

                // CandidateSettingsSvcs.putPrivacySetting({data:$scope.privacySettingsData})
                // .then(function(res){
                //   $scope.messageBlock  = res.data.data.statements;
                //   if($scope.messageBlock) {
                //     $scope.messageBlock = $scope.messageBlock.slice(0, $scope.messageBlock.length-1);
                //   }
                //   $scope.errorData.push(true);
                // })
                // .catch(function(err){
                //   $scope.privacyLoader = false;
                //   $scope.errorData.push(false);
                // });



                CandidateSettingsSvcs.postWhiteListed({
                        data: {
                            company_ids: $scope.whiteListIdGenerator($scope.grantedCompanyItems)
                        }
                    })
                    .then(function (res) {
                        $scope.privacyLoader = false;
                        $scope.errorData.push(true);
                    })
                    .catch(function (err) {
                        $scope.privacyLoader = false;
                        $scope.errorData.push(false);
                    })
                var interval = $interval(function () {
                    if ($scope.errorData.length == 4) {
                        $interval.cancel(interval);

                        $scope.saveStatus = true;
                        $scope.privacyTouched = false;
                        $scope.privacyLoader = false;
                        for (var i = 0; i < $scope.errorData.length; i++) {
                            if ($scope.errorData[i] == false) {
                                // alert('Something went wrong while saving your data.');
                                if (confirm("Something went wrong while saving your data.\n\n Do you still want to save changes?")) {
                                    $scope.masterSaveData();
                                }
                                break;
                            }
                        }
                    }
                }, 100);
            };

            $scope.updateBeforeLeave = function (action) {
                if (action == 'yes') {
                    if ($scope.linkTemp !== 'logout') {
                        window.location.href = $scope.linkTemp;
                    } else {
                        $scope.logout();
                    }
                    var tab = $cookies.get('activeTab')
                    $scope.updateTab(tab);
                    $scope.initPrivacySettings();
                } else {
                    $cookies.put('activeTab', 'tab3');
                    $scope.linkTemp = null;
                    $scope.scrollToCenter('btn-confirm-changes');
                    // $scope.updateTab('tab3');
                }
                $timeout(function () {
                    $scope.modalStatus = false;
                    $scope.showDataStatusAlert = false;
                }, 1200);
                $timeout(function () {
                    $scope.animateShowModal = false;
                }, 100);
            };
            $scope.showMessageModal = function () {
                $scope.modalStatus = true;
                $scope.messageModal = true;

                $timeout(function () {
                    $scope.animateShowModal = true;
                }, 300);
            }

            //** Helper functions */
            //Generate Initials
            $scope.generateInitials = function (company_name) {
                var splitName = company_name.split(" ");
                if (splitName.length > 1 && splitName[1] != "") {
                    return splitName[0][0] + splitName[1][0];
                } else {
                    return company_name[0] + company_name[1]
                }
            }
            //Generate Random Color
            $scope.randomColor = function (initials) {
                var colorArr = ['sky', 'pvm-orange', 'pvm-yellow', 'pvm-green', 'pvm-red', 'pvm-purple']
                var string = ['AB7-C1|D/W', 'E_F&28;GX', 'JK*L$93S', 'M%0OP4(Z', 'NP!5QI.R', 'Y@6T,UZV)'];
                var index;
                var initialsString = initials.replace(/\s/g, '').toUpperCase();
                for (var i = 0; i < string.length; i++) {
                    if (string[i].includes(initialsString[initialsString.length - 1]) === true) {
                        index = i;
                        break;
                    }
                }
                return colorArr[index];
            }
            //Simple Scroll 
            $scope.scrollToCenter = function (e) {
                var elem = document.getElementById(e);
                var currentPos = document.documentElement.scrollTop
                if (e == 'btn-confirm-changes') {
                    $('html, body').animate({
                        scrollTop: $(document).height()
                    }, 'slow');
                } else {
                    if (elem.getBoundingClientRect().bottom > 600) {
                        $('html, body').animate({
                            scrollTop: currentPos + 300
                        }, 'slow');
                    }
                }

            }
            $scope.filterMessage = function (message) {
                var m = message.split('[').join(' <strong>');
                return m.split(']').join('</strong>');
            }
            document.onkeyup = function (evt) {
                var $this = $scope;
                if (evt.keyCode === 27) {
                    $scope.cancelModal();
                }
            }
            //For tabs
            $scope.updateTab = function (tab) {
                $cookies.put('activeTab', tab);

                if (tab === 'tab1') {
                    $scope.tab1 = true;
                    $scope.tab2 = false;
                    $scope.tab3 = false;
                } else if (tab === 'tab2') {
                    $scope.tab1 = false;
                    $scope.tab2 = true;
                    $scope.tab3 = false;
                } else if (tab === 'tab3') {
                    $scope.tab1 = false;
                    $scope.tab2 = false;
                    $scope.tab3 = true;
                    $scope.getWhiteListingInit();
                } else {
                    $scope.tab1 = true;
                    $scope.tab2 = false;
                    $scope.tab3 = false;
                }

            }
            $scope.gotoLink = (link) => {

                if ($scope.privacyTouched == true) {
                    $scope.seoSwitchToggle = false;
                    $timeout(function () {
                        $scope.showDataStatusAlert = true;
                        $scope.modalStatus = true;
                    }, 100);
                    $timeout(function () {
                        $scope.animateShowModal = true;
                    }, 200);

                    $scope.linkTemp = link;
                } else {
                    if (link === 'logout') {
                        $scope.logout();
                    } else {
                        window.location.href = window.location.origin + link;
                    }
                }
            }
            // $scope.leaving = function() {
            //     // $(window).bind('beforeunload', function(e){
            //     //   if($scope.privacyTouched == true) {
            //     //       return 'You haven\'t clicked on Confirm Changes yet. Discard changes?';
            //     //   }
            //     // });
            //   var linksDefault = document.getElementsByTagName('a');
            //   var filteredLinks = [];
            //   angular.forEach(linksDefault,function(link){
            //     if(link.getAttribute('href') !=='javascript:void(0)' || link.getAttribute('href') == null) {
            //         var getLink = link.getAttribute('href');
            //         link.setAttribute('href','javascript:void(0)');
            //         link.setAttribute('data-href',getLink);
            //     }
            //     if(link.getAttribute('ng-click') == 'logout()') {
            //       console.log(link);
            //       $(link).css('display','none');
            //       $(link).parent('li').append('<a href="javascript:void(0)" id="btnLogout">Logout</a>');
            //       $(document).on('click','#btnLogout',function(e){
            //         $scope.gotoLink('logout'); 
            //       })
            //     }
            //   });
            //   $('a').on('click',function(e){
            //     e.preventDefault();
            //     var hrefLink = $(this).attr('href');
            //     var link = $(this).attr("data-href");
            //     var keyWord = "";
            //     if(link && hrefLink =='javascript:void(0)') {
            //       $scope.gotoLink(link);
            //     }else {
            //       $scope.gotoLink(hrefLink);  
            //     }
            //   });
            //   //Search bar top header
            //   var keyWord = $(".pvm-search-handler #search_top").val();
            //   $(".pvm-search-handler").find("i").css('display','none');
            //   $(".pvm-search-handler").append('<a href="javascript:void(0)" id="btnSearchNow"><i class="fa fa-search"></i></a>');
            //   $(document).on('click','#btnSearchNow',function(e){
            //     $scope.gotoLink(base_url+'job/search/#?q='+$(".pvm-search-handler #search_top").val());
            //   });

            // }

            $scope.whiteListIdGenerator = (companies) => {
                var company_ids = [];
                angular.forEach(companies, (company) => {
                    company_ids.push(company.companies.id);
                });
                return company_ids;
            }

            // $scope.leaving();
            //Filter results front
            // $scope.filterResult = function(filterBlock) {
            //   if($scope.filterBlacklist) {
            //     $scope.blockCompanyItemsTemp = [];
            //     angular.forEach($scope.blockCompanyItems,function(item){
            //         if((item.company_name.toUpperCase()).includes($scope.filterBlacklist.toUpperCase())) {
            //           $scope.blockCompanyItemsTemp.push(item);
            //         }
            //     });
            //   }else {
            //     $scope.blockCompanyItemsTemp = $scope.blockCompanyItems;
            //   }
            // };
            $scope.logout = function () {
                $.ajax({
                    url: GlobalConstant.logoutPage,
                    type: 'get',
                    'success': function (data) {
                        if (data == 200) {
                            $window.location.href = base_url;
                        }
                    }
                });
            }
        }
    ]);

    app.controller('LoginModalInstanceController', ['GlobalConstant', '$scope', '$cookies', '$http', '$modalInstance', '$location', 'emailData', 'passwordData', 'profileUrlData', 'actionType',
        function (GlobalConstant, $scope, $cookies, $http, $modalInstance, $location, emailData, passwordData, profileUrlData, actionType) {

            var token = $cookies.get('api_token');
            $scope.actionType = actionType;
            $scope.emailData = emailData;
            $scope.passwordData = passwordData;
            $scope.profileUrlData = profileUrlData;

            $scope.validatelogin = (login) => {
                $http.get(window.location.origin + '/api/user-auth-data', {
                        headers: {
                            'Authorization': 'Bearer ' + token
                        }
                    })
                    .then(response => {
                        if (response.status === 200) {
                            let userData = response.data.data[0];
                            let userEmail = userData.email;
                            let userId = userData.id;

                            if (userEmail != login.email) {
                                console.log('Invalid Credentials');
                                return false;
                            }

                            let data = {
                                email: login.email,
                                password: login.password
                            };

                            // Candidate Login
                            $http.post(window.location.origin + '/api/login', data).then(response => {
                                if (response.status === 200) {

                                    // Update Candidate Email Address
                                    if ($scope.actionType === 'change-email') {
                                        let edata = {
                                            email: login.email,
                                            new_email: $scope.emailData.newEmail
                                        }

                                        $http.put(window.location.origin + '/api/candidate/account-settings/update-email', edata, {
                                            headers: {
                                                'Authorization': 'Bearer ' + token
                                            }
                                        }).then(response => {
                                            if (response.status === 200) {
                                                let data = {
                                                    email: $scope.emailData.newEmail
                                                }
                                                $modalInstance.close(data);
                                            }
                                        });
                                    }

                                    // Update Candidate Password
                                    if ($scope.actionType === 'change-password') {

                                        let loginData = {
                                            email: userEmail,
                                            password: $scope.passwordData.currentPassword
                                        }

                                        $http.post(window.location.origin + '/api/login', loginData).then(response => {
                                            if (response.status === 200) {
                                                let pdata = {
                                                    candidate_id: userId,
                                                    new_password: $scope.passwordData.newPassword
                                                }

                                                $http.put(window.location.origin + '/api/candidate/account-settings/update-password', pdata, {
                                                    headers: {
                                                        'Authorization': 'Bearer ' + token
                                                    }
                                                }).then(response => {
                                                    if (response.status === 200) {
                                                        $modalInstance.close(null);
                                                    }
                                                });
                                            }
                                        });

                                    }

                                    // Update Candidate Profile Url
                                    if ($scope.actionType === 'change-profile-url') {
                                        let pUdata = {
                                            candidate_id: userId,
                                            new_profile_url: $scope.profileUrlData.new_profile_url
                                        }

                                        $http.put(window.location.origin + '/api/candidate/account-settings/update-profile-url', pUdata, {
                                            headers: {
                                                'Authorization': 'Bearer ' + token
                                            }
                                        }).then(response => {
                                            if (response.status === 200) {
                                                let data = {
                                                    profile_url: $scope.profileUrlData.new_profile_url
                                                }
                                                $modalInstance.close(data);
                                            }
                                        });
                                    }

                                }
                            });

                        }
                    });

            };

            // Close Login Modal
            $scope.closeModal = () => {
                $modalInstance.close(null);
            };

        }
    ]);

    ///Services
    app.factory('CandidateSettingsSvcs', ['GlobalConstant', '$http', '$cookies', function (GlobalConstant, $http, $cookies) {
        return {
            getCompany: function (key) {
                var SearchOption = {}
                if ($cookies.get('token')) {
                    var token = $cookies.get('token');
                    angular.extend(SearchOption, {
                        headers: {
                            'Authorization': 'Bearer ' + token
                        }
                    })
                } else {
                    var token = null
                }
                return $.get(GlobalConstant.CandidateRootApi + '/company/search/' + key + '?access_token=' + token, {})
                    .then(function (res) {
                        return res.data;
                    });
            },
            getBlacklistedComp: function () {
                var token = $cookies.get('token');
                var header = {};
                if (token) {
                    angular.extend(header, {
                        headers: {
                            'Authorization': 'Bearer ' + token,
                            'Content-Type': 'application/json'
                        }
                    })
                }
                return $.get(GlobalConstant.CandidateRootApi + '/settings/privacy/blacklist?access_token=' + token, {}, header)
                    .then(function (res) {
                        return res;
                    })
            },
            getPrivacySetting: function (key) {
                var token = $cookies.get('token');
                //getting an error when using $http.get
                return $.get(GlobalConstant.CandidateRootApi + '/settings/privacy?access_token=' + token, {})
                    .then(function (res) {
                        return res.data;
                    });
            },
            getPrivacySettingWhiteListRequest: function () {
                var token = $cookies.get('token');
                return $.get(GlobalConstant.CandidateRootApi + '/settings/privacy/whitelist/requested?access_token=' + token, {})
                    .then(function (res) {
                        return res.data;
                    });
            },
            getPrivacySettingWhitelistApproved: function () {
                var token = $cookies.get('token');
                return $.get(GlobalConstant.CandidateRootApi + '/settings/privacy/whitelist?access_token=' + token, {})
                    .then(function (res) {
                        return res;
                    });
            },
            putApproveWhiteList: function (data) {
                var token = $cookies.get('token');
                var header = {};
                if (token) {
                    angular.extend(header, {
                        headers: {
                            'Authorization': 'Bearer ' + token,
                            'Content-Type': 'application/json'
                        }
                    })
                }
                return $http.put(GlobalConstant.CandidateRootApi + '/settings/privacy/whitelist/approval', data, header)
                    .then(function (res) {
                        return res;
                    });
            },
            putRemoveWhitelisted: function (compId) {
                var token = $cookies.get('token');
                var header = {};
                if (token) {
                    angular.extend(header, {
                        headers: {
                            'Authorization': 'Bearer ' + token,
                            'Content-Type': 'application/json'
                        }
                    })
                }
                return $http.put(GlobalConstant.CandidateRootApi + '/settings/privacy/whitelist/remove/' + compId, {}, header)
                    .then(function (res) {
                        return res;
                    })
            },
            putPrivacySetting: function (data) {
                var token = $cookies.get('token');
                var header = {};
                if (token) {
                    angular.extend(header, {
                        headers: {
                            'Authorization': 'Bearer ' + token,
                            'Content-Type': 'application/json'
                        }
                    })
                }
                return $http.put(GlobalConstant.CandidateRootApi + '/settings/privacy', data, header)
                    .then(function (res) {
                        return res;
                    })
            },
            postCommunicationSetting: function (data) {
                var token = $cookies.get('token');
                var header = {};
                if (token) {
                    angular.extend(header, {
                        headers: {
                            'Authorization': 'Bearer ' + token,
                            'Content-Type': 'application/json'
                        }
                    })
                }
                return $http.post(GlobalConstant.CandidateRootApi + '/settings/communication', data, header)
                    .then(function (res) {
                        return res;
                    })
            },
            postSaveBlacklisted: function (data) {
                var token = $cookies.get('token');
                var header = {};
                if (token) {
                    angular.extend(header, {
                        headers: {
                            'Authorization': 'Bearer ' + token,
                            'Content-Type': 'application/json'
                        }
                    })
                }
                return $http.post(GlobalConstant.CandidateRootApi + '/settings/privacy/blacklist', data, header)
                    .then(function (res) {
                        return res;
                    })
            },
            postWhiteListed: function (data) {
                var token = $cookies.get('token');
                var header = {};
                if (token) {
                    angular.extend(header, {
                        headers: {
                            'Authorization': 'Bearer ' + token,
                            'Content-Type': 'application/json'
                        }
                    })
                }
                return $http.post(GlobalConstant.CandidateRootApi + '/settings/privacy/whitelist', data, header)
                    .then(function (res) {
                        return res;
                    })
            }
        }
    }]);

}());
