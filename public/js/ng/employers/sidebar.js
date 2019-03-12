(function() {
	'use strict';
	var app = angular.module('app' );

    app.controller('EmployerSidebar', ['GlobalConstant', 'ajaxService', '$scope', '$window', '$http', '$cookies', '$filter', '$timeout', '$compile', '$location',
        function(GlobalConstant, ajaxService, $scope, $window, $http, $cookies, $filter, $timeout, $compile, $location) {
            $scope.employerdata = [];

            var employer_uri = window.location.pathname.split('/').filter(function(el){ return !!el; }).pop();
            $scope.employer_uri = employer_uri;

            function getCookie(name) {
              var nameEQ = name + "=";
              var ca = document.cookie.split(';');
              for (var i = 0; i < ca.length; i++) {
                var c = ca[i];
                while (c.charAt(0) == ' ') c = c.substring(1, c.length);
                if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
              }
              return null;
            }
            
            var userToken = getCookie('api_token');
            
            if (userToken != '') {
                var headerData = {
                    headers: {
                        'Authorization': 'Bearer ' + userToken
                    }
                };
      
                $http.get(window.location.origin + '/api/user-auth-data', headerData).then(response => {
                    if (response.status === 200) {
                        var user_data = response.data.data;
                        if (user_data.length > 0) {
                            let user_id = user_data[0].id;
                            let user_type = user_data[0].user_type;
                            let employer_id = user_data[0].employer.id;

                            if (user_type === 'employer') {
                                $http.get(window.location.origin + '/api/employer/settings/' + employer_id).then(response => {
                                    if (response.status === 200) {
                                        var employer_data = response.data;

                                        if (employer_data.length > 0) {

                                            switch (employer_data[0].account_type.id) {
                                                case 5:
                                                    $scope.account_type_string = 'Company Admin';
                                                    break;
                                                case 6:
                                                    $scope.account_type_string = 'Company Member';
                                                    break;
                                                default:
                                                    $scope.account_type_string = 'Company Job Manager';
                                            }

                                            let edata = {
                                                account_type_string: $scope.account_type_string,
                                                id: employer_data[0].id,
                                                first_name: employer_data[0].user.first_name,
                                                last_name: employer_data[0].user.last_name,
                                                email: employer_data[0].user.email,
                                                company: {
                                                    id: employer_data[0].company.id,
                                                    company_name: employer_data[0].company.company_name,
                                                    status: employer_data[0].company.status,
                                                    num_of_employees: employer_data[0].company.num_of_employees,
                                                    logo_url: employer_data[0].company.logo_url,
                                                    website_url: employer_data[0].company.website_url,
                                                    company_phone: employer_data[0].company.company_phone,
                                                    company_fax: employer_data[0].company.company_fax,
                                                    industry: {
                                                        data: {
                                                            industry: {
                                                                id: employer_data[0].company.industry.id,
                                                                display_name: employer_data[0].company.industry.display_name
                                                            }
                                                        }
                                                    },
                                                    street_address: employer_data[0].company.street_address,
                                                    street_address_2: employer_data[0].company.street_address_2,
                                                    location: {
                                                        data: {
                                                            location: {
                                                                id: employer_data[0].company.location.id,
                                                                display_name: employer_data[0].company.location.display_name,
                                                                slug_name: employer_data[0].company.location.slug_name,
                                                                type: employer_data[0].company.location.type,
                                                                country: {
                                                                    id: (employer_data[0].company.location.country.count > 0) ? employer_data[0].company.location.country[0].id : '',
                                                                    display_name: (employer_data[0].company.location.country.count > 0) ? employer_data[0].company.location.country[0].display_name : '',
                                                                    short_name: (employer_data[0].company.location.country.count > 0) ? employer_data[0].company.location.country[0].codeDisplayName : ''
                                                                }
                                                            }
                                                        }
                                                    },
                                                    nz_business_num: employer_data[0].company.nz_business_num,
                                                    company_url: employer_data[0].company.company_url,
                                                    company_banner_url: employer_data[0].company.company_banner_url,
                                                    company_description: employer_data[0].company.company_description,
                                                    company_video: {
                                                        doc_file_type: (employer_data[0].company.hasOwnProperty('docs')) ? (employer_data[0].company.docs != null) ? employer_data[0].company.docs.doc_file_type : '' : '',
                                                        doc_url: (employer_data[0].company.hasOwnProperty('docs')) ? (employer_data[0].company.docs != null) ? employer_data[0].company.docs.doc_url : '' : '',
                                                        doc_filename: (employer_data[0].company.hasOwnProperty('docs')) ? (employer_data[0].company.docs != null) ? employer_data[0].company.docs.doc_filename : '' : ''
                                                    }
                                                },
                                                nickname: employer_data[0].nickname,
                                                phone_number: employer_data[0].phone_number,
                                                phone_extension: employer_data[0].phone_extension,
                                                mobile_number: employer_data[0].mobile_number,
                                                work_title: employer_data[0].work_title,
                                                work_dept: employer_data[0].work_dept,
                                                profile_picture_url: employer_data[0].profile_picture_url,
                                                azure_container_key: employer_data[0].company.ob_key + '/' + employer_data[0].user.ob_key
                                            }

                                            $scope.employerdata = edata;

                                            //Encode URI
                                            $scope.employerdata.company.company_url = encodeURIComponent($scope.employerdata.company.company_url);

                                            // Add initial to be used in default image
                                            $scope.F_initial = $scope.employerdata.first_name;
                                            $scope.F_initial = $scope.F_initial.substr(0, 1);

                                            $scope.L_initial = $scope.employerdata.last_name;
                                            $scope.L_initial = $scope.L_initial.substr(0, 1);

                                            $scope.employerdata.initial = $scope.F_initial + $scope.L_initial;

                                            if ($(".randomInitialColor").hasClass("member-initials--sky")) {
                                                $scope.employerdata.profile_color = "member-initials--sky";
                                            } else if ($(".randomInitialColor").hasClass("member-initials--pvm-purple")) {
                                                $scope.employerdata.profile_color = "member-initials--pvm-purple";
                                            } else if ($(".randomInitialColor").hasClass("member-initials--pvm-green")) {
                                                $scope.employerdata.profile_color = "member-initials--pvm-green";
                                            } else if ($(".randomInitialColor").hasClass("member-initials--pvm-red")) {
                                                $scope.employerdata.profile_color = "member-initials--pvm-red";
                                            } else if ($(".randomInitialColor").hasClass("member-initials--pvm-yellow")) {
                                                $scope.employerdata.profile_color = "member-initials--pvm-yellow";
                                            }

                                        }

                                    }
                                }, (response) => {
                                    if (response.status === 500) {
                                        console.log('Token Expire');
                                    }
                                });
                            }
                        }
                    }
                }, (response) => {
                    if (response.status === 401) {
                        ajaxService.getEmployerProfile().then(function (response) {
                            var data = response.data.data;
                            $scope.employerdata = data;

                            //Encode URI
                            $scope.employerdata.company.company_url = encodeURIComponent($scope.employerdata.company.company_url);

                            // Add initial to be used in default image
                            $scope.F_initial = $scope.employerdata.first_name;
                            $scope.F_initial = $scope.F_initial.substr(0, 1);

                            $scope.L_initial = $scope.employerdata.last_name;
                            $scope.L_initial = $scope.L_initial.substr(0, 1);

                            $scope.employerdata.initial = $scope.F_initial + $scope.L_initial;

                            if ($(".randomInitialColor").hasClass("member-initials--sky")) {
                                $scope.employerdata.profile_color = "member-initials--sky";
                            } else if ($(".randomInitialColor").hasClass("member-initials--pvm-purple")) {
                                $scope.employerdata.profile_color = "member-initials--pvm-purple";
                            } else if ($(".randomInitialColor").hasClass("member-initials--pvm-green")) {
                                $scope.employerdata.profile_color = "member-initials--pvm-green";
                            } else if ($(".randomInitialColor").hasClass("member-initials--pvm-red")) {
                                $scope.employerdata.profile_color = "member-initials--pvm-red";
                            } else if ($(".randomInitialColor").hasClass("member-initials--pvm-yellow")) {
                                $scope.employerdata.profile_color = "member-initials--pvm-yellow";
                            }

                        })
                    }
                });
            }

            // $http({
            //     method: 'GET',
            //     params: $scope.params,
            //     url: GlobalConstant.APIRoot+'employer/profile'
            // }).then(function(response) {
            //     var data = response.data.data;
            //     console.log('sidebar')
            //     console.log(data)
            //     $scope.employerdata = data;

            //     // console.log('dito')
            //     // console.log(data)


            // });

           
            

        }
    ]);

}());