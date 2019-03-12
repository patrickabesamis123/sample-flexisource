(function () {
    'use strict';
    var app = angular.module('app');

    app.controller('EmployerTeams', ['GlobalConstant', '$scope', '$modal', '$window', '$http', '$cookies', '$filter', '$timeout', '$compile', '$location',
        function (GlobalConstant, $scope, $modal, $window, $http, $cookies, $filter, $timeout, $compile, $location) {

            $scope.team = {};
            $scope.team.members = [];
            $scope.team.team_admin = 0;

            $scope.token = $cookies.get('api_token');

            if ($scope.token != null) {
                var headerData = {
                    headers: {
                        'Authorization': 'Bearer ' + $scope.token
                    }
                };

                $http.get(window.location.origin + '/api/user-auth-data', headerData)
                    .then(response => {
                        if (response.status === 200) {
                            var user_data = response.data.data;
                            if (user_data.length > 0) {
                                let user_id = user_data[0].id;
                                let user_type = user_data[0].user_type;

                                if (user_type === 'employer') {
                                    let employer_id = user_data[0].employer.id;
                                    let company_id = user_data[0].employer.company.id;

                                    //Get Permission
                                    $http.get(window.location.origin + '/api/employer/permissions/' + employer_id)
                                        .then(response => {
                                            $scope.createTeam = response.data.create_new_teams
                                        });

                                    //Get All Team List
                                    $scope.getTeams = () => {
                                        $http.get(window.location.origin + '/api/company/teams/' + company_id + '/' + employer_id)
                                            .then(response => {
                                                if (response.status === 200) {
                                                    angular.element($('.listcontainer')).TrackpadScrollEmulator();
                                                    let rawData = response.data;

                                                    $scope.GetAllCompanyTeam = rawData;

                                                    //Paginate list
                                                    $scope.currentPageteam = 0;
                                                    $scope.pageSizeteam = 5;
                                                    $scope.nopageteam = false;
                                                    $scope.datateam = [];

                                                    function profile_color(list) {
                                                        // Add initial to be used in default image
                                                        var b = 1;
                                                        for (var a = 0; a < list.length; a++) {
                                                            for (var i = 0; i < list[a].members.length; i++) {
                                                                if (b >= 6) {
                                                                    b = 1;
                                                                }
                                                                list[a].members[i].full_name = list[a].members[i].first_name + " " + list[a].members[i].last_name;
                                                                $scope.F_initial = list[a].members[i].employer.first_name;
                                                                $scope.F_initial = $scope.F_initial.substr(0, 1);

                                                                $scope.L_initial = list[a].members[i].employer.last_name;
                                                                $scope.L_initial = $scope.L_initial.substr(0, 1);

                                                                list[a].members[i].employer.initial = $scope.F_initial + $scope.L_initial;

                                                                // change default photo's background color
                                                                if (!list[a].members[i].employer.profile_picture_url) {
                                                                    if (b == 1) {
                                                                        list[a].members[i].employer.profile_color = "member-initials--sky";
                                                                    } else if (b == 2) {
                                                                        list[a].members[i].employer.profile_color = "member-initials--pvm-purple";
                                                                    } else if (b == 3) {
                                                                        list[a].members[i].employer.profile_color = "member-initials--pvm-green";
                                                                    } else if (b == 4) {
                                                                        list[a].members[i].employer.profile_color = "member-initials--pvm-red";
                                                                    } else if (b == 5) {
                                                                        list[a].members[i].employer.profile_color = "member-initials--pvm-yellow";
                                                                    }
                                                                    b++;
                                                                }
                                                            }
                                                        }
                                                    }

                                                    profile_color(($scope.GetAllCompanyTeam));

                                                    $scope.getDatateam = () => {
                                                        return $filter('filter')($scope.GetAllCompanyTeam, $scope.searchteam)
                                                    }

                                                    $scope.numberOfPagesteam = () => {
                                                        return Math.ceil($scope.getDatateam().length / $scope.pageSizeteam);
                                                    }

                                                    $scope.nopageteam = true;
                                                    if (isNaN($scope.numberOfPagesteam()) == false) {
                                                        $scope.nopageteam = false;
                                                    } else {
                                                        $scope.nopageteam = true;
                                                    }

                                                    for (var i = 0; i < 65; i++) {
                                                        $scope.datateam.push("Item " + i);
                                                    }
                                                }
                                            }, response => {
                                                $scope.requirements_mgs = false;
                                                $scope.ErrorMsgs = response.data.errors;
                                            });
                                    }

                                    $scope.getTeams();

                                    //Get All member List
                                    $http.get(window.location.origin + '/api/company/team-members/' + company_id)
                                        .then(response => {
                                            if (response.status === 200) {
                                                $scope.GetAllCompanyMember = response.data;
                                                // Add initial to be used in default image
                                                var b = 1;
                                                for (var i = 0; i < $scope.GetAllCompanyMember.length; i++) {
                                                    if (b >= 6) {
                                                        b = 1;
                                                    }

                                                    $scope.GetAllCompanyMember[i].full_name = $scope.GetAllCompanyMember[i].first_name + " " + $scope.GetAllCompanyMember[i].last_name;
                                                    $scope.F_initial = $scope.GetAllCompanyMember[i].first_name;
                                                    $scope.F_initial = $scope.F_initial.substr(0, 1);

                                                    $scope.L_initial = $scope.GetAllCompanyMember[i].last_name;
                                                    $scope.L_initial = $scope.L_initial.substr(0, 1);

                                                    $scope.GetAllCompanyMember[i].initial = $scope.F_initial + $scope.L_initial;

                                                    // change default photo's background color
                                                    if ($scope.GetAllCompanyMember[i].profile_picture_url == null) {
                                                        if (b == 1) {
                                                            $scope.GetAllCompanyMember[i].profile_color = "member-initials--sky";
                                                        } else if (b == 2) {
                                                            $scope.GetAllCompanyMember[i].profile_color = "member-initials--pvm-purple";
                                                        } else if (b == 3) {
                                                            $scope.GetAllCompanyMember[i].profile_color = "member-initials--pvm-green";
                                                        } else if (b == 4) {
                                                            $scope.GetAllCompanyMember[i].profile_color = "member-initials--pvm-red";
                                                        } else if (b == 5) {
                                                            $scope.GetAllCompanyMember[i].profile_color = "member-initials--pvm-yellow";
                                                        }
                                                        b++;
                                                    }
                                                }
                                                //Paginate list
                                                $scope.currentPage = 0;
                                                $scope.pageSize = 10;
                                                $scope.searchmember = '';
                                                $scope.datamember = [];
                                                $scope.getData = function () {
                                                    return $filter('filter')($scope.GetAllCompanyMember, $scope.searchmember)
                                                }

                                                $scope.numberOfPages = function () {
                                                    return Math.ceil($scope.getData().length / $scope.pageSize);
                                                }

                                                $scope.nopagemember = true;
                                                if (isNaN($scope.numberOfPages()) == false) {
                                                    $scope.nopagemember = false;
                                                } else {
                                                    $scope.nopagemember = true;
                                                }

                                                for (var i = 0; i < 65; i++) {
                                                    $scope.datamember.push("Item " + i);
                                                }
                                            }
                                        }, response => {
                                            $scope.requirements_mgs = false;
                                            $scope.ErrorMsgs = response.data.errors;
                                        });

                                    //AddTeam
                                    $scope.CreateNewTeam = (team_id) => {
                                        $scope.publishing = true;

                                        //Create new team
                                        if (team_id == null) {
                                            // $http.post(GlobalConstant.APIRoot + 'employer/company/team', {data: $scope.team}) //Uncomment for live API call
                                            let data = {
                                                members: $scope.team.members,
                                                team_admin: $scope.team.team_admin,
                                                team_name: $scope.team.team_name,
                                                created_by_id: employer_id,
                                                company_id: company_id
                                            }
                                            data.team_admin = ($scope.team.team_admin) ? $scope.team.team_admin : employer_id;

                                            $http.post(window.location.origin + '/api/company/team/create', data)
                                                .then(response => {
                                                    if (response.status === 200) {
                                                        $scope.getTeams();
                                                        $scope.publishing = false;
                                                        $scope.successteam = true;
                                                        angular.element($('#newTeam')).slideToggle("slow");
                                                        //reset
                                                        $scope.team = {};
                                                        $scope.team.team_name = '';
                                                        $scope.team.members = [];
                                                        $scope.team.team_admin = 0
                                                    }
                                                }, (response) => {
                                                    $scope.failteam = true;
                                                    $scope.publishing = false;
                                                    $scope.error = response.data.message
                                                });
                                        } else {
                                            // $http.put(GlobalConstant.APIRoot + 'employer/company/team/' + team_id, {data: $scope.team}) //Uncomment for live API call
                                            // $http.get(window.location.origin + '/js/minified/test-data/test_team_data.json')
                                            let data = {
                                                members: $scope.team.members,
                                                team_admin: $scope.team.team_admin,
                                                team_name: $scope.team.team_name,
                                                created_by_id: employer_id,
                                                company_id: company_id
                                            }
                                            $http.put(window.location.origin + '/api/company/team/update/' + team_id, data)
                                                .then(response => {
                                                    if (response.status === 200) {
                                                        $scope.getTeams();
                                                        $scope.publishing = false;
                                                        $scope.successteam = false;
                                                        $scope.successteamupdate = true;
                                                        $scope.successteamupdateName = $scope.team.team_name

                                                        angular.element($('#newTeam')).slideToggle("slow");
                                                        //reset
                                                        $scope.team = {};
                                                        $scope.team.team_name = '';
                                                        $scope.team.members = [];
                                                        $scope.team.team_admin = 0
                                                        $scope.testId = null
                                                    }
                                                }, (response) => {
                                                    $scope.failteam = true;
                                                    $scope.publishing = false;
                                                    $scope.error = response.data.message
                                                });
                                        }

                                    }

                                }

                            }
                        }
                    }, (response) => {
                        if (response.status === 401) {
                            //Get Permission
                            $http.get(window.location.origin + '/js/minified/test-data/test_employer_setting_permission_data.json')
                                .then(function (response) {
                                    $scope.createTeam = response.data.create_new_teams
                                });

                            //Get All Team List
                            $scope.getTeams = function () {
                                // $http.get(GlobalConstant.APIRoot + 'employer/company/team') //Uncomment for live API call
                                $http.get(window.location.origin + '/js/minified/test-data/test_team_data.json')
                                    .then(function (response) {
                                        angular.element($('.listcontainer')).TrackpadScrollEmulator();

                                        $scope.GetAllCompanyTeam = response.data;

                                        //Paginate list
                                        $scope.currentPageteam = 0;
                                        $scope.pageSizeteam = 5;
                                        $scope.nopageteam = false;
                                        $scope.datateam = [];

                                        function profile_color(list) {
                                            // Add initial to be used in default image
                                            var b = 1;
                                            for (var a = 0; a < list.length; a++) {
                                                for (var i = 0; i < list[a].members.length; i++) {
                                                    if (b >= 6) {
                                                        b = 1;
                                                    }
                                                    list[a].members[i].full_name = list[a].members[i].first_name + " " + list[a].members[i].last_name;
                                                    $scope.F_initial = list[a].members[i].employer.first_name;
                                                    $scope.F_initial = $scope.F_initial.substr(0, 1);

                                                    $scope.L_initial = list[a].members[i].employer.last_name;
                                                    $scope.L_initial = $scope.L_initial.substr(0, 1);

                                                    list[a].members[i].employer.initial = $scope.F_initial + $scope.L_initial;

                                                    // change default photo's background color
                                                    if (!list[a].members[i].employer.profile_picture_url) {
                                                        if (b == 1) {
                                                            list[a].members[i].employer.profile_color = "member-initials--sky";
                                                        } else if (b == 2) {
                                                            list[a].members[i].employer.profile_color = "member-initials--pvm-purple";
                                                        } else if (b == 3) {
                                                            list[a].members[i].employer.profile_color = "member-initials--pvm-green";
                                                        } else if (b == 4) {
                                                            list[a].members[i].employer.profile_color = "member-initials--pvm-red";
                                                        } else if (b == 5) {
                                                            list[a].members[i].employer.profile_color = "member-initials--pvm-yellow";
                                                        }
                                                        b++;
                                                    }
                                                }
                                            }
                                        }

                                        profile_color(($scope.GetAllCompanyTeam));

                                        $scope.getDatateam = function () {
                                            return $filter('filter')($scope.GetAllCompanyTeam, $scope.searchteam)
                                        }

                                        $scope.numberOfPagesteam = function () {
                                            return Math.ceil($scope.getDatateam().length / $scope.pageSizeteam);
                                        }

                                        $scope.nopageteam = true;
                                        if (isNaN($scope.numberOfPagesteam()) == false) {
                                            $scope.nopageteam = false;
                                        } else {
                                            $scope.nopageteam = true;
                                        }

                                        for (var i = 0; i < 65; i++) {
                                            $scope.datateam.push("Item " + i);
                                        }
                                    }, function (response) {
                                        $scope.requirements_mgs = false;
                                        $scope.ErrorMsgs = response.data.errors;
                                    });
                            }

                            $scope.getTeams();

                            //Get All member List
                            $http.get(window.location.origin + '/js/minified/test-data/test_team_members_data.json')
                                .then(function (response) {
                                    $scope.GetAllCompanyMember = response.data;
                                    // Add initial to be used in default image
                                    var b = 1;
                                    for (var i = 0; i < $scope.GetAllCompanyMember.length; i++) {
                                        if (b >= 6) {
                                            b = 1;
                                        }

                                        $scope.GetAllCompanyMember[i].full_name = $scope.GetAllCompanyMember[i].first_name + " " + $scope.GetAllCompanyMember[i].last_name;
                                        $scope.F_initial = $scope.GetAllCompanyMember[i].first_name;
                                        $scope.F_initial = $scope.F_initial.substr(0, 1);

                                        $scope.L_initial = $scope.GetAllCompanyMember[i].last_name;
                                        $scope.L_initial = $scope.L_initial.substr(0, 1);

                                        $scope.GetAllCompanyMember[i].initial = $scope.F_initial + $scope.L_initial;

                                        // change default photo's background color
                                        if (!$scope.GetAllCompanyMember[i].profile_picture_url) {
                                            if (b == 1) {
                                                $scope.GetAllCompanyMember[i].profile_color = "member-initials--sky";
                                            } else if (b == 2) {
                                                $scope.GetAllCompanyMember[i].profile_color = "member-initials--pvm-purple";
                                            } else if (b == 3) {
                                                $scope.GetAllCompanyMember[i].profile_color = "member-initials--pvm-green";
                                            } else if (b == 4) {
                                                $scope.GetAllCompanyMember[i].profile_color = "member-initials--pvm-red";
                                            } else if (b == 5) {
                                                $scope.GetAllCompanyMember[i].profile_color = "member-initials--pvm-yellow";
                                            }
                                            b++;
                                        }
                                    }
                                    //Paginate list
                                    $scope.currentPage = 0;
                                    $scope.pageSize = 10;
                                    $scope.searchmember = '';
                                    $scope.datamember = [];
                                    $scope.getData = function () {
                                        return $filter('filter')($scope.GetAllCompanyMember, $scope.searchmember)
                                    }

                                    $scope.numberOfPages = function () {
                                        return Math.ceil($scope.getData().length / $scope.pageSize);
                                    }

                                    $scope.nopagemember = true;
                                    if (isNaN($scope.numberOfPages()) == false) {
                                        $scope.nopagemember = false;
                                    } else {
                                        $scope.nopagemember = true;
                                    }

                                    for (var i = 0; i < 65; i++) {
                                        $scope.datamember.push("Item " + i);
                                    }


                                }, function (response) {
                                    $scope.requirements_mgs = false;
                                    $scope.ErrorMsgs = response.data.errors;
                                });

                        }
                    });
            }

            $scope.newTeam = false;

            //Edit Team
            $scope.editTeam = (team) => {
                angular.element($('#newTeam:hidden')).slideToggle("slow");

                $scope.team = {};
                $scope.team.team_name = team.team_name;
                $scope.team.members = [];
                $scope.team.team_admin = 0
                $scope.testId = team.id

                angular.forEach(team.members, (v, k) => {
                    if (v.team_role == 'team_admin') {
                        $scope.team.team_admin = v.employer.id
                    }
                    if (v.team_role == 'team_member') {
                        $scope.team.members.push(v.employer.id)
                    }
                });

                if (angular.element($('#team_' + team.id).is(':visible'))) {
                    angular.element($('#team_' + team.id + ':visible')).slideToggle("slow")
                }

            }

            $scope.successdeleteteam = false;

            //Delete Team
            $scope.deleteTeam = (team_id) => {
                $http.delete(window.location.origin + '/api/company/team/delete/' + team_id)
                    .then(response => {
                        if (response.status === 200) {
                            $scope.successdeleteteam = true;
                            $scope.getTeams()
                        }
                    }, response => {
                        if (response.status === 400) {
                            console.log(response.message);
                        }
                    });
            }

            //Remove Member
            $scope.successdeletemember = false;
            $scope.removeMember = (team_id, member_id) => {
                $http.delete(window.location.origin + '/api/company/team-member/delete/' + team_id + '/' + member_id)
                    .then(response => {
                        if (response.status === 200) {
                            $scope.successdeletemember = true;
                            $scope.getTeams()
                        }
                    }, response => {
                        if (response.status === 400) {
                            console.log(response.message);
                        }
                    });
            }


            $scope.publishing = false;
            $scope.successteam = false;
            $scope.successteamupdate = false;
            $scope.failteam = false

            $scope.cancelTeam = () => {
                //clear for data on close form
                $scope.team = {};
                $scope.team.team_name = '';
                $scope.team.members = [];
                $scope.team.team_admin = 0;

                if (angular.isDefined($scope.testId)) {
                    angular.element($('#team_' + $scope.testId)).slideToggle("slow")
                } else {
                    $scope.testId = null;
                }

            }

            $scope.$watch('team', function (n, o) {

                if (n.team_admin != 0) {
                    $scope.team.team_admin = parseInt(n.team_admin);
                    $scope.searchmanager = ""
                }

                if (n.members.length != o.members.length) {
                    $scope.searchmember = ""
                }


            }, true);

            $scope.successInvite = false;
            $scope.failInvite = false;

            // Show modals
            // Invite Team Member
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

                // Process Modal Result
                modalInstance.result.then(function (data) {
                    $scope.user = data;
                    if (angular.isDefined($scope.user.first_name)) {
                        $scope.successInvite = true;
                        $scope.failInvite = false;

                        $scope.team.members.push($scope.user.id);
                        $scope.GetAllCompanyMember.push($scope.user)

                        if ($scope.GetAllCompanyMember.length > 0) {
                            var b = 1;
                            for (var i = 0; i < $scope.GetAllCompanyMember.length; i++) {
                                if (b >= 6) {
                                    b = 1;
                                }

                                $scope.GetAllCompanyMember[i].full_name = $scope.GetAllCompanyMember[i].first_name + " " + $scope.GetAllCompanyMember[i].last_name;
                                $scope.F_initial = $scope.GetAllCompanyMember[i].first_name;
                                $scope.F_initial = $scope.F_initial.substr(0, 1);

                                $scope.L_initial = $scope.GetAllCompanyMember[i].last_name;
                                $scope.L_initial = $scope.L_initial.substr(0, 1);

                                $scope.GetAllCompanyMember[i].initial = $scope.F_initial + $scope.L_initial;

                                // change default photo's background color
                                if ($scope.GetAllCompanyMember[i].profile_picture_url == null) {
                                    if (b == 1) {
                                        $scope.GetAllCompanyMember[i].profile_color = "member-initials--sky";
                                    } else if (b == 2) {
                                        $scope.GetAllCompanyMember[i].profile_color = "member-initials--pvm-purple";
                                    } else if (b == 3) {
                                        $scope.GetAllCompanyMember[i].profile_color = "member-initials--pvm-green";
                                    } else if (b == 4) {
                                        $scope.GetAllCompanyMember[i].profile_color = "member-initials--pvm-red";
                                    } else if (b == 5) {
                                        $scope.GetAllCompanyMember[i].profile_color = "member-initials--pvm-yellow";
                                    }
                                    b++;
                                }
                            }
                        }

                    } else {
                        $scope.failInvite = true;
                        $scope.successInvite = false;
                        delete $scope.user['username']
                    }

                }, function () {
                    $log.info('Modal dismissed at: ' + new Date());
                });
            }


            // Invite Team Admin
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

                    if (angular.isDefined($scope.user.first_name)) {
                        $scope.successInvite = true;
                        $scope.failInvite = false;
                        $scope.team.team_adminData = [];
                        $scope.team.team_admin = $scope.user.id;
                        $scope.GetAllCompanyMember.push($scope.user)

                        if ($scope.GetAllCompanyMember.length > 0) {
                            var b = 1;
                            for (var i = 0; i < $scope.GetAllCompanyMember.length; i++) {
                                if (b >= 6) {
                                    b = 1;
                                }

                                $scope.GetAllCompanyMember[i].full_name = $scope.GetAllCompanyMember[i].first_name + " " + $scope.GetAllCompanyMember[i].last_name;
                                $scope.F_initial = $scope.GetAllCompanyMember[i].first_name;
                                $scope.F_initial = $scope.F_initial.substr(0, 1);

                                $scope.L_initial = $scope.GetAllCompanyMember[i].last_name;
                                $scope.L_initial = $scope.L_initial.substr(0, 1);

                                $scope.GetAllCompanyMember[i].initial = $scope.F_initial + $scope.L_initial;

                                // change default photo's background color
                                if ($scope.GetAllCompanyMember[i].profile_picture_url == null) {
                                    if (b == 1) {
                                        $scope.GetAllCompanyMember[i].profile_color = "member-initials--sky";
                                    } else if (b == 2) {
                                        $scope.GetAllCompanyMember[i].profile_color = "member-initials--pvm-purple";
                                    } else if (b == 3) {
                                        $scope.GetAllCompanyMember[i].profile_color = "member-initials--pvm-green";
                                    } else if (b == 4) {
                                        $scope.GetAllCompanyMember[i].profile_color = "member-initials--pvm-red";
                                    } else if (b == 5) {
                                        $scope.GetAllCompanyMember[i].profile_color = "member-initials--pvm-yellow";
                                    }
                                    b++;
                                }
                            }
                        }

                    } else {
                        $scope.failInvite = true;
                        $scope.successInvite = false;
                        delete $scope.user['username']
                    }

                }, function () {
                    $log.info('Modal dismissed at: ' + new Date());
                });

            }

            $scope.buttons = {
                chosen: ""
            };
            $scope.submitting = false;

            $scope.removeSelectedMember = function (index) {
                $scope.team.members.splice(index, 1)
            }

            $scope.removeSelectedAdmin = function (index) {
                $scope.team.team_admin = 0;
            }

        }
    ]);


    angular.module('app').controller('MemberModalInstanceCtrl', ['GlobalConstant', '$scope', '$cookies', '$http', '$modalInstance', 'data',
        function (GlobalConstant, $scope, $cookies, $http, $modalInstance, data) {
            $scope.user = {
                first_name: '',
                last_name: '',
                email: '',
                account_type: 6
            };
            $scope.submitting = false;

            var token = $cookies.get('api_token');
            if (token != null) {
                var headerData = {
                    headers: {
                        'Authorization': 'Bearer ' + token
                    }
                };

                $http.get(window.location.origin + '/api/user-auth-data', headerData)
                    .then(response => {
                        if (response.status === 200) {
                            var user_data = response.data.data;
                            if (user_data.length > 0) {
                                let user_id = user_data[0].id;
                                let user_type = user_data[0].user_type;

                                if (user_type === 'employer') {
                                    let employer_id = user_data[0].employer.id;
                                    let company_id = user_data[0].employer.company.id;

                                    $scope.company_id = company_id;

                                }
                            }
                        }
                    });
            }

            $scope.ok = () => {
                $scope.submitting = true;
                //Submit invite for member
                // $http.post(GlobalConstant.EmployerRegisterMember, {
                let data = {
                    first_name: $scope.user.first_name,
                    last_name: $scope.user.last_name,
                    email: $scope.user.email
                }
                $http.post(window.location.origin + '/api/company/team-member/invite/' + $scope.company_id, data)
                    .then(response => {
                        $scope.submitting = false;
                        if (response.data != null) {
                            $modalInstance.close(response.data);
                        } else {
                            // $modalInstance.close(response.data.errors);
                        }

                    }, response => {
                        $scope.submitting = false;
                    });

            };

            $scope.cancel = () => {
                $modalInstance.dismiss('cancel');
            };
        }
    ]);

}());


$(document).ready(function () {
    $('.sliderContainer').TrackpadScrollEmulator();

    //Toggle slider Create member form
    $('#formCreateTeam, #CancelTeam').click(function () {
        $('#newTeam').slideToggle("slow")
    })

    $('#closesMember').click(function () {
        $('#SearchMember:visible').slideToggle("slow")
    });

    $('#closesManager').click(function () {
        $('#SearchManager:visible').slideToggle("slow")
    });

    $(".selecteManager").on('click', function () {
        // in the handler, 'this' refers to the box clicked on
        var $box = $(this);
        if ($box.is(":checked")) {
            // the name of the box is retrieved using the .attr() method
            // as it is assumed and expected to be immutable
            var group = "input:checkbox[name='" + $box.attr("name") + "']";
            // the checked state of the group/box on the other hand will change
            // and the current value is retrieved using .prop() method
            $(group).prop("checked", false);
            $box.prop("checked", true);
        } else {
            $box.prop("checked", false);
        }
    });

    function MemberDropdowFilter(field_element, display_element) {
        $(field_element).focusin(function () {

            $(this).keypress(function () {
                if ($(display_element).is(":hidden")) {
                    $(display_element).slideToggle("slow");
                }
            })

        });

        $(field_element).focusout(function () {
            $(display_element).slideToggle("slow");
        });
    }

    MemberDropdowFilter('#SearchMemberField', '#SearchMember')
    MemberDropdowFilter('#SearchManagerField', '#SearchManager')

});
