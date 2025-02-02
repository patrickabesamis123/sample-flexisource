/**
 * Created by domina on 9/25/2017.
 * PAJ sprint
 */

(function () {
    'use strict';

    var app = angular.module('app');
    var base_url = $('body').data('base_url');

    app.controller('WebWidgetCtrl', ['GlobalConstant', 'fileUploadService', '$scope', '$cookies', '$window', '$http', '$filter', '$timeout', '$location', 'OAuth', 'OAuthToken', '$rootScope', '$modal', '$log',
        function (GlobalConstant, fileUploadService, $scope, $cookies, $window, $http, $filter, $timeout, $location, OAuth, OAuthToken, $rootScope, $modal, $log) {

            $scope.pvmEnableJSIMsg = false;
            $scope.pvmEnableJSIShow = false;
            $scope.pvmEnableJSIReq = false;
            $scope.pvmEnableJSI = false;
            $scope.pvmEmail = false;

            $scope.token = $cookies.get('api_token');

            if ($scope.token != '') {
                var headerData = {
                    headers: {
                        'Authorization': 'Bearer ' + $scope.token
                    }
                };

                $http.get(window.location.origin + '/api/user-auth-data', headerData).then(response => {
                    if (response.status === 200) {
                        var user_data = response.data.data;
                        if (user_data.length > 0) {
                            let user_id = user_data[0].id;
                            let user_type = user_data[0].user_type;
                            let employer_id = user_data[0].employer.id;
                            let company_id = user_data[0].employer.company.id;

                            $scope.employer_id = employer_id;
                            $scope.company_id = company_id;
                            $scope.user_id = user_id;

                            // Watch the Changes on the Enable Career Widget Toggle Button
                            $scope.$watch('pvmEnableJSI', (newVal, oldVal) => {
                                if (newVal != oldVal) {
                                    if (newVal === true) {
                                        $scope.pvmEnableJSIReq = true;
                                        $scope.pvmEmail = true;

                                        $.ajax({
                                            // url: GlobalConstant.EmployerRootApi + "/tools/javascript/request",
                                            url: window.location.origin + '/api/employer/js-request/' + $scope.employer_id,
                                            method: 'POST',
                                            headers: {
                                                'Authorization': 'Bearer ' + $scope.token
                                            },
                                            async: false,
                                            success: (response) => {
                                                console.log(response);
                                            }
                                        });
                                    }
                                }
                            });

                            $.ajax({
                                // url: GlobalConstant.EmployerRootApi + '/tools/javascript/status',
                                url: window.location.origin + '/api/employer/js-status/' + $scope.employer_id,
                                method: 'GET',
                                headers: {
                                    'Authorization': 'Bearer ' + $scope.token
                                },
                                async: false,
                                success: (response) => {

                                    // For Members Only
                                    $scope.requestMyJS = () => {
                                        $scope.pvmEmail = true;
                                        alert("Your request has been submitted!")

                                        $.ajax({
                                            // url: GlobalConstant.EmployerRootApi + "/tools/javascript/request",
                                            url: window.location.origin + '/api/employer/js-request/' + $scope.employer_id,
                                            method: 'POST',
                                            headers: {
                                                'Authorization': 'Bearer ' + $scope.token
                                            },
                                            async: false,
                                            success: (response) => {
                                                console.log(response);
                                            }
                                        });
                                    }

                                    if (response.message === "Enabled") {
                                        $scope.pvmEnableJSI = true;
                                        $scope.pvmEnableJSIReq = false;
                                        $scope.pvmEnableJSIShow = true;
                                        $scope.pvmEmail = false;

                                        // $.getJSON("https://" + ApiDomain + "/api/v1/integration/javascript/" + response.data + "/config", function (data) {
                                        $.getJSON(window.location.origin + "/api/employer/js-config/" + response.data.company_id, (data) => {

                                            $scope.myFonts = [];
                                            $scope.myColumn = [{
                                                    label: "Single line",
                                                    value: 1
                                                },
                                                {
                                                    label: "2-column",
                                                    value: 2
                                                },
                                                {
                                                    label: "3-column",
                                                    value: 3
                                                }
                                            ];

                                            $scope.fontSize = [
                                                "9px", "10px", "12px", "13px", "14px", "16px", "18px", "20px", "22px", "24px", "26px", "28px", "36px", "48px", "72px",
                                            ];

                                            if (!data[0].hasOwnProperty('config')) {
                                                $scope.embedAttrsArrDefault = {
                                                    "job_title": {
                                                        "color": "#00aeed",
                                                        "family": "Montserrat-Regular",
                                                        "family_file": "",
                                                        "size": "18px"
                                                    },
                                                    "job_desc": {
                                                        "color": "#5a5a5a",
                                                        "family": "Montserrat-Regular",
                                                        "family_file": "",
                                                        "size": "13px"
                                                    },
                                                    "video": true,
                                                    "desc": true,
                                                    "logo": true,
                                                    "groupings": "none"
                                                };
                                                var adminStyleConfig = $scope.embedAttrsArrDefault;
                                            } else {
                                                var adminStyleConfig = JSON.parse(data[0].config);
                                            }

                                            /***Set Google Fonts***/
                                            $.getJSON("https://www.googleapis.com/webfonts/v1/webfonts?key=AIzaSyCroo2nediDAIdQZVUXX4D37bxD2Tm5eAM", function (data) {
                                                var googleFonts, fontFile;

                                                for (var a = 0; a < data.items.length; a++) {
                                                    fontFile = data.items[a].files;
                                                    for (var name in fontFile) {
                                                        if (fontFile.hasOwnProperty(name)) {
                                                            if (name == "regular" || name == "Regular") {
                                                                googleFonts = {
                                                                    "family": data.items[a].family,
                                                                    "file": fontFile[name]
                                                                }
                                                                $scope.myFonts.push(googleFonts);
                                                            }
                                                        }
                                                    }
                                                }
                                            });

                                            for (var x = 0; x < $scope.myColumn.length; x++) {
                                                if (adminStyleConfig.layout) {
                                                    if ($scope.myColumn[x].value == adminStyleConfig.layout.column) {
                                                        $scope.pvmEnableCol = $scope.myColumn[x];
                                                        break;
                                                    }
                                                } else {
                                                    $scope.pvmEnableCol = {
                                                        label: "Single line",
                                                        value: 1
                                                    };
                                                }
                                            }

                                            $scope.jobTitleColor = adminStyleConfig.job_title.color;
                                            $scope.jobDescColor = adminStyleConfig.job_desc.color;
                                            $scope.pvmEnableLogojs = adminStyleConfig.logo;
                                            $scope.pvmEnableVidjs = adminStyleConfig.video;
                                            $scope.pvmEnableDescjs = adminStyleConfig.desc;
                                            $scope.groupJobItem = adminStyleConfig.groupings;
                                            $scope.jobTitleFontSize = adminStyleConfig.job_title.size;
                                            $scope.jobDescFontSize = adminStyleConfig.job_desc.size;
                                            $scope.jobTitleFontFam = adminStyleConfig.job_title.family_file;
                                            $scope.jobDescFontFam = adminStyleConfig.job_desc.family_file;
                                            $scope.groupJobItem = adminStyleConfig.groupings;

                                            $scope.pvmEnableVid = $scope.pvmEnableVidjs;
                                            $scope.pvmEnableLogo = $scope.pvmEnableLogojs;
                                            $scope.pvmEnableDesc = $scope.pvmEnableDescjs;

                                            /****** color picker ******/
                                            $(".js-int__color-picker--title").spectrum({
                                                color: $scope.jobTitleColor,
                                                change: function (color) {
                                                    $("#jobTitleColor").val(color.toHexString());
                                                    $scope.jobTitleColor = color.toHexString();
                                                }
                                            });

                                            $(".js-int__color-picker--desc").spectrum({
                                                color: $scope.jobDescColor,
                                                change: function (color) {
                                                    $("#jobDescColor").val(color.toHexString());
                                                    $scope.jobDescColor = color.toHexString();
                                                }
                                            });
                                            /****** color picker ******/

                                            $scope.embedAttrsArr = {
                                                "layout": {
                                                    "column": $scope.pvmEnableCol.value
                                                },
                                                "job_title": {
                                                    "color": $scope.jobDescColor,
                                                    "family_file": $scope.jobTitleFontFam.family,
                                                    "family_file": $scope.jobTitleFontFam,
                                                    "size": $scope.jobTitleFontSize
                                                },
                                                "job_desc": {
                                                    "color": $scope.jobDescColor,
                                                    "family_file": $scope.jobDescFontFam.family,
                                                    "family_file": $scope.jobDescFontFam,
                                                    "size": $scope.jobDescFontSize
                                                },
                                                "video": $scope.pvmEnableVidjs,
                                                "desc": $scope.pvmEnableDescjs,
                                                "logo": $scope.pvmEnableLogojs,
                                                "groupings": $scope.groupJobItem
                                            };

                                            $scope.$watch('pvmEnableVid', (newVal, oldVal) => {
                                                if (newVal != oldVal) {
                                                    $scope.embedAttrsArr = {
                                                        "layout": {
                                                            "column": $scope.pvmEnableCol.value
                                                        },
                                                        "job_title": {
                                                            "color": $scope.jobTitleColor,
                                                            "family": $scope.jobTitleFontFam.family,
                                                            "family_file": $scope.jobTitleFontFam,
                                                            "size": $scope.jobTitleFontSize
                                                        },
                                                        "job_desc": {
                                                            "color": $scope.jobDescColor,
                                                            "family": $scope.jobDescFontFam.family,
                                                            "family_file": $scope.jobDescFontFam,
                                                            "size": $scope.jobDescFontSize
                                                        },
                                                        "video": newVal,
                                                        "desc": $scope.pvmEnableDesc,
                                                        "logo": $scope.pvmEnableLogo,
                                                        "groupings": $scope.groupJobItem
                                                    };
                                                    $scope.embedAttrs = "company_id=" + response.data.company_id + "&config=" + JSON.stringify($scope.embedAttrsArr);
                                                    $.ajax({
                                                        // url: GlobalConstant.EmployerRootApi + "/tools/javascript/config/",
                                                        url: window.location.origin + "/api/employer/js-config/" + response.data.company_id,
                                                        method: 'POST',
                                                        data: $scope.embedAttrs,
                                                        headers: {
                                                            'Authorization': 'Bearer ' + $scope.token
                                                        },
                                                        async: false,
                                                        success: (response) => {
                                                            $timeout(() => {
                                                                loadMyRoles("");
                                                            }, 1200);
                                                        }
                                                    });
                                                }
                                            });

                                            $scope.$watch('pvmEnableDesc', function (newVal, oldVal) {
                                                if (newVal != oldVal) {
                                                    $scope.embedAttrsArr = {
                                                        "layout": {
                                                            "column": $scope.pvmEnableCol.value
                                                        },
                                                        "job_title": {
                                                            "color": $scope.jobTitleColor,
                                                            "family": $scope.jobTitleFontFam.family,
                                                            "family_file": $scope.jobTitleFontFam,
                                                            "size": $scope.jobTitleFontSize
                                                        },
                                                        "job_desc": {
                                                            "color": $scope.jobDescColor,
                                                            "family": $scope.jobDescFontFam.family,
                                                            "family_file": $scope.jobDescFontFam,
                                                            "size": $scope.jobDescFontSize
                                                        },
                                                        "video": $scope.pvmEnableVid,
                                                        "desc": newVal,
                                                        "logo": $scope.pvmEnableLogo,
                                                        "groupings": $scope.groupJobItem
                                                    };

                                                    $scope.embedAttrs = "company_id=" + response.data.company_id + "&config=" + JSON.stringify($scope.embedAttrsArr);
                                                    $.ajax({
                                                        // url: GlobalConstant.EmployerRootApi + "/tools/javascript/config/",
                                                        url: window.location.origin + "/api/employer/js-config/" + response.data.company_id,
                                                        method: 'POST',
                                                        data: $scope.embedAttrs,
                                                        headers: {
                                                            'Authorization': 'Bearer ' + $scope.token
                                                        },
                                                        async: false,
                                                        success: (response) => {
                                                            $timeout(() => {
                                                                loadMyRoles("");
                                                            }, 1200);
                                                        }
                                                    });
                                                }
                                            });

                                            $scope.$watch('pvmEnableCol', function (newVal, oldVal) {
                                                if (newVal != oldVal) {
                                                    $scope.embedAttrsArr = {
                                                        "layout": {
                                                            "column": newVal.value
                                                        },
                                                        "job_title": {
                                                            "color": $scope.jobTitleColor,
                                                            "family": $scope.jobTitleFontFam.family,
                                                            "family_file": $scope.jobTitleFontFam,
                                                            "size": $scope.jobTitleFontSize
                                                        },
                                                        "job_desc": {
                                                            "color": $scope.jobDescColor,
                                                            "family": $scope.jobDescFontFam.family,
                                                            "family_file": $scope.jobDescFontFam,
                                                            "size": $scope.jobDescFontSize
                                                        },
                                                        "video": $scope.pvmEnableVid,
                                                        "desc": $scope.pvmEnableDesc,
                                                        "logo": $scope.pvmEnableLogo,
                                                        "groupings": $scope.groupJobItem
                                                    };

                                                    $scope.embedAttrs = "company_id=" + response.data.company_id + "&config=" + JSON.stringify($scope.embedAttrsArr);
                                                    $.ajax({
                                                        // url: GlobalConstant.EmployerRootApi + "/tools/javascript/config/",
                                                        url: window.location.origin + "/api/employer/js-config/" + response.data.company_id,
                                                        method: 'POST',
                                                        data: $scope.embedAttrs,
                                                        headers: {
                                                            'Authorization': 'Bearer ' + $scope.token
                                                        },
                                                        async: false,
                                                        success: (response) => {
                                                            $timeout(() => {
                                                                loadMyRoles("");
                                                            }, 1200);
                                                        }
                                                    });
                                                }
                                            });

                                            $scope.$watch('pvmEnableLogo', function (newVal, oldVal) {
                                                if (newVal != oldVal) {
                                                    $scope.embedAttrsArr = {
                                                        "layout": {
                                                            "column": $scope.pvmEnableCol.value
                                                        },
                                                        "job_title": {
                                                            "color": $scope.jobTitleColor,
                                                            "family": $scope.jobTitleFontFam.family,
                                                            "family_file": $scope.jobTitleFontFam,
                                                            "size": $scope.jobTitleFontSize
                                                        },
                                                        "job_desc": {
                                                            "color": $scope.jobDescColor,
                                                            "family": $scope.jobDescFontFam.family,
                                                            "family_file": $scope.jobDescFontFam,
                                                            "size": $scope.jobDescFontSize
                                                        },
                                                        "video": $scope.pvmEnableVid,
                                                        "desc": $scope.pvmEnableDesc,
                                                        "logo": newVal,
                                                        "groupings": $scope.groupJobItem
                                                    };

                                                    $scope.embedAttrs = "company_id=" + response.data.company_id + "&config=" + JSON.stringify($scope.embedAttrsArr);
                                                    $.ajax({
                                                        // url: GlobalConstant.EmployerRootApi + "/tools/javascript/config/",
                                                        url: window.location.origin + "/api/employer/js-config/" + response.data.company_id,
                                                        method: 'POST',
                                                        data: $scope.embedAttrs,
                                                        headers: {
                                                            'Authorization': 'Bearer ' + $scope.token
                                                        },
                                                        async: false,
                                                        success: (response) => {
                                                            $timeout(() => {
                                                                loadMyRoles("");
                                                            }, 1200);
                                                        }
                                                    });
                                                }
                                            });

                                            $scope.$watch('groupJobItem', function (newVal, oldVal) {
                                                //console.log(newVal + ' ' + oldVal);
                                                if (newVal != oldVal) {
                                                    $scope.embedAttrsArr = {
                                                        "layout": {
                                                            "column": $scope.pvmEnableCol.value
                                                        },
                                                        "job_title": {
                                                            "color": $scope.jobTitleColor,
                                                            "family": $scope.jobTitleFontFam.family,
                                                            "family_file": $scope.jobTitleFontFam,
                                                            "size": $scope.jobTitleFontSize
                                                        },
                                                        "job_desc": {
                                                            "color": $scope.jobDescColor,
                                                            "family": $scope.jobDescFontFam.family,
                                                            "family_file": $scope.jobDescFontFam,
                                                            "size": $scope.jobDescFontSize
                                                        },
                                                        "video": $scope.pvmEnableVidjs,
                                                        "logo": $scope.pvmEnableLogojs,
                                                        "desc": $scope.pvmEnableDesc,
                                                        "groupings": newVal
                                                    };

                                                    $scope.embedAttrs = "company_id=" + response.data.company_id + "&config=" + JSON.stringify($scope.embedAttrsArr);
                                                    $.ajax({
                                                        // url: GlobalConstant.EmployerRootApi + "/tools/javascript/config/",
                                                        url: window.location.origin + "/api/employer/js-config/" + response.data.company_id,
                                                        method: 'POST',
                                                        data: $scope.embedAttrs,
                                                        headers: {
                                                            'Authorization': 'Bearer ' + $scope.token
                                                        },
                                                        async: false,
                                                        success: (response) => {
                                                            $timeout(() => {
                                                                loadMyRoles("");
                                                            }, 1200);
                                                        }
                                                    });
                                                }
                                            });

                                            $scope.$watch('jobTitleFontSize', function (newVal, oldVal) {
                                                if (newVal != oldVal) {
                                                    $scope.embedAttrsArr = {
                                                        "layout": {
                                                            "column": $scope.pvmEnableCol.value
                                                        },
                                                        "job_title": {
                                                            "color": $scope.jobTitleColor,
                                                            "family": $scope.jobTitleFontFam.family,
                                                            "family_file": $scope.jobTitleFontFam,
                                                            "size": newVal
                                                        },
                                                        "job_desc": {
                                                            "color": $scope.jobDescColor,
                                                            "family": $scope.jobDescFontFam.family,
                                                            "family_file": $scope.jobDescFontFam,
                                                            "size": $scope.jobDescFontSize
                                                        },
                                                        "video": $scope.pvmEnableVidjs,
                                                        "desc": $scope.pvmEnableDesc,
                                                        "logo": $scope.pvmEnableLogojs,
                                                        "groupings": $scope.groupJobItem
                                                    };

                                                    $scope.embedAttrs = "company_id=" + response.data.company_id + "&config=" + JSON.stringify($scope.embedAttrsArr);
                                                    $.ajax({
                                                        // url: GlobalConstant.EmployerRootApi + "/tools/javascript/config/",
                                                        url: window.location.origin + "/api/employer/js-config/" + response.data.company_id,
                                                        method: 'POST',
                                                        data: $scope.embedAttrs,
                                                        headers: {
                                                            'Authorization': 'Bearer ' + $scope.token
                                                        },
                                                        async: false,
                                                        success: (response) => {
                                                            $timeout(() => {
                                                                loadMyRoles("");
                                                            }, 1200);
                                                        }
                                                    });
                                                }
                                            });

                                            $scope.$watch('jobTitleFontFam', function (newVal, oldVal) {
                                                if (newVal != oldVal) {
                                                    $scope.embedAttrsArr = {
                                                        "layout": {
                                                            "column": $scope.pvmEnableCol.value
                                                        },
                                                        "job_title": {
                                                            "color": $scope.jobTitleColor,
                                                            "family": $scope.jobTitleFontFam.family,
                                                            "family_file": $scope.jobTitleFontFam,
                                                            "size": $scope.jobTitleFontSize
                                                        },
                                                        "job_desc": {
                                                            "color": $scope.jobDescColor,
                                                            "family": $scope.jobDescFontSize,
                                                            "family_file": $scope.jobDescFontFam,
                                                            "size": $scope.jobDescFontSize
                                                        },
                                                        "video": $scope.pvmEnableVidjs,
                                                        "desc": $scope.pvmEnableDesc,
                                                        "logo": $scope.pvmEnableLogojs,
                                                        "groupings": $scope.groupJobItem
                                                    };

                                                    $scope.embedAttrs = "company_id=" + response.data.company_id + "&config=" + JSON.stringify($scope.embedAttrsArr);
                                                    $.ajax({
                                                        // url: GlobalConstant.EmployerRootApi + "/tools/javascript/config/",
                                                        url: window.location.origin + "/api/employer/js-config/" + response.data.company_id,
                                                        method: 'POST',
                                                        data: $scope.embedAttrs,
                                                        headers: {
                                                            'Authorization': 'Bearer ' + $scope.token
                                                        },
                                                        async: false,
                                                        success: (response) => {
                                                            $timeout(() => {
                                                                loadMyRoles("");
                                                            }, 1200);
                                                        }
                                                    });
                                                }
                                            });

                                            $scope.$watch('jobDescFontFam', function (newVal, oldVal) {
                                                if (newVal != oldVal) {
                                                    $scope.embedAttrsArr = {
                                                        "layout": {
                                                            "column": $scope.pvmEnableCol.value
                                                        },
                                                        "job_title": {
                                                            "color": $scope.jobTitleColor,
                                                            "family": $scope.jobTitleFontFam.family,
                                                            "family_file": $scope.jobTitleFontFam,
                                                            "size": $scope.jobTitleFontSize
                                                        },
                                                        "job_desc": {
                                                            "color": $scope.jobDescColor,
                                                            "family": $scope.jobDescFontFam.family,
                                                            "family_file": $scope.jobDescFontFam,
                                                            "size": $scope.jobDescFontSize
                                                        },
                                                        "video": $scope.pvmEnableVidjs,
                                                        "desc": $scope.pvmEnableDesc,
                                                        "logo": $scope.pvmEnableLogojs,
                                                        "groupings": $scope.groupJobItem
                                                    };

                                                    $scope.embedAttrs = "company_id=" + response.data.company_id + "&config=" + JSON.stringify($scope.embedAttrsArr);
                                                    $.ajax({
                                                        // url: GlobalConstant.EmployerRootApi + "/tools/javascript/config/",
                                                        url: window.location.origin + "/api/employer/js-config/" + response.data.company_id,
                                                        method: 'POST',
                                                        data: $scope.embedAttrs,
                                                        headers: {
                                                            'Authorization': 'Bearer ' + $scope.token
                                                        },
                                                        async: false,
                                                        success: (response) => {
                                                            $timeout(() => {
                                                                loadMyRoles("");
                                                            }, 1200);
                                                        }
                                                    });
                                                }
                                            });

                                            $scope.$watch('jobDescFontSize', function (newVal, oldVal) {
                                                if (newVal != oldVal) {
                                                    $scope.embedAttrsArr = {
                                                        "layout": {
                                                            "column": $scope.pvmEnableCol.value
                                                        },
                                                        "job_title": {
                                                            "color": $scope.jobTitleColor,
                                                            "family": $scope.jobTitleFontFam.family,
                                                            "family_file": $scope.jobTitleFontFam,
                                                            "size": $scope.jobTitleFontSize
                                                        },
                                                        "job_desc": {
                                                            "color": $scope.jobDescColor,
                                                            "family": $scope.jobDescFontFam.family,
                                                            "family_file": $scope.jobDescFontFam,
                                                            "size": newVal
                                                        },
                                                        "video": $scope.pvmEnableVidjs,
                                                        "desc": $scope.pvmEnableDesc,
                                                        "logo": $scope.pvmEnableLogojs,
                                                        "groupings": $scope.groupJobItem
                                                    };

                                                    $scope.embedAttrs = "company_id=" + response.data.company_id + "&config=" + JSON.stringify($scope.embedAttrsArr);
                                                    $.ajax({
                                                        // url: GlobalConstant.EmployerRootApi + "/tools/javascript/config/",
                                                        url: window.location.origin + "/api/employer/js-config/" + response.data.company_id,
                                                        method: 'POST',
                                                        data: $scope.embedAttrs,
                                                        headers: {
                                                            'Authorization': 'Bearer ' + $scope.token
                                                        },
                                                        async: false,
                                                        success: (response) => {
                                                            $timeout(() => {
                                                                loadMyRoles("");
                                                            }, 1200);
                                                        }
                                                    });
                                                }
                                            });

                                            $scope.$watch('jobTitleColor', function (newVal, oldVal) {
                                                if (newVal != oldVal) {
                                                    $scope.embedAttrsArr = {
                                                        "layout": {
                                                            "column": $scope.pvmEnableCol.value
                                                        },
                                                        "job_title": {
                                                            "color": newVal,
                                                            "family": $scope.jobTitleFontFam.family,
                                                            "family_file": $scope.jobTitleFontFam,
                                                            "size": $scope.jobTitleFontSize
                                                        },
                                                        "job_desc": {
                                                            "color": $scope.jobDescColor,
                                                            "family": $scope.jobDescFontFam.family,
                                                            "family_file": $scope.jobDescFontFam,
                                                            "size": $scope.jobDescFontSize
                                                        },
                                                        "video": $scope.pvmEnableVidjs,
                                                        "desc": $scope.pvmEnableDesc,
                                                        "logo": $scope.pvmEnableLogojs,
                                                        "groupings": $scope.groupJobItem
                                                    };

                                                    $scope.embedAttrs = "company_id=" + response.data.company_id + "&config=" + JSON.stringify($scope.embedAttrsArr);
                                                    $.ajax({
                                                        // url: GlobalConstant.EmployerRootApi + "/tools/javascript/config/",
                                                        url: window.location.origin + "/api/employer/js-config/" + response.data.company_id,
                                                        method: 'POST',
                                                        data: $scope.embedAttrs,
                                                        headers: {
                                                            'Authorization': 'Bearer ' + $scope.token
                                                        },
                                                        async: false,
                                                        success: (response) => {
                                                            $timeout(() => {
                                                                loadMyRoles("");
                                                            }, 1200);
                                                        }
                                                    });
                                                }
                                            });

                                            $scope.$watch('jobDescColor', function (newVal, oldVal) {
                                                if (newVal != oldVal) {
                                                    $scope.embedAttrsArr = {
                                                        "layout": {
                                                            "column": $scope.pvmEnableCol.value
                                                        },
                                                        "job_title": {
                                                            "color": $scope.jobTitleColor,
                                                            "family": $scope.jobTitleFontFam.family,
                                                            "family_file": $scope.jobTitleFontFam,
                                                            "size": $scope.jobTitleFontSize
                                                        },
                                                        "job_desc": {
                                                            "color": newVal,
                                                            "family": $scope.jobDescFontFam.family,
                                                            "family_file": $scope.jobDescFontFam,
                                                            "size": $scope.jobDescFontSize
                                                        },
                                                        "video": $scope.pvmEnableVidjs,
                                                        "desc": $scope.pvmEnableDesc,
                                                        "logo": $scope.pvmEnableLogojs,
                                                        "groupings": $scope.groupJobItem
                                                    };

                                                    $scope.embedAttrs = "company_id=" + response.data.company_id + "&config=" + JSON.stringify($scope.embedAttrsArr);
                                                    $.ajax({
                                                        // url: GlobalConstant.EmployerRootApi + "/tools/javascript/config/",
                                                        url: window.location.origin + "/api/employer/js-config/" + response.data.company_id,
                                                        method: 'POST',
                                                        data: $scope.embedAttrs,
                                                        headers: {
                                                            'Authorization': 'Bearer ' + $scope.token
                                                        },
                                                        async: false,
                                                        success: (response) => {
                                                            $timeout(() => {
                                                                loadMyRoles("");
                                                            }, 1200);
                                                        }
                                                    });
                                                }
                                            });
                                        });

                                        // function loadMyRoles(mySearch) {}

                                        function loadMyRoles(mySearch) {
                                            var css_link = $("<link>", {
                                                rel: "stylesheet",
                                                type: "text/css",
                                                href: window.location.origin + "/css/google-font.min.css"
                                            });

                                            css_link.appendTo('head');
                                            // $.getJSON("https://" + ApiDomain + "/api/v1/integration/javascript/" + response.data + "/config", function (data) {
                                            $.getJSON(window.location.origin + "/api/employer/js-config/" + response.data.company_id, (data) => {

                                                if (!data[0].hasOwnProperty('config')) {
                                                    var myStyleConfig = $scope.embedAttrsArrDefault;
                                                } else {
                                                    var myStyleConfig = JSON.parse(data[0].config);
                                                }

                                                var myTemplate = "";
                                                myTemplate += "<div class='my-pvm-job-list clr'>";
                                                myTemplate += " <section class='MJL-handler'>";
                                                //myTemplate += "   <img id='pvmCompanylogo' class='pvmJS__company-logo'>"; as per J 5/7/18
                                                myTemplate += "   <div class='pvmJS__search-box'>";
                                                myTemplate += "     <input type='text' id='pvmSearchMyJobs' class='pvmJS__search'>";
                                                myTemplate += "     <span id='pvmSearchMyJobsBtn'><i class='fa fa-search'></i></span>";
                                                myTemplate += "   </div>";
                                                myTemplate += "   <div id='pvmGetMyJobs'>";
                                                myTemplate += "   </div>";
                                                // myTemplate += "   <img src='" + window.location.origin + "/images/previewme-logo.png' id='pvmLogoFooter' class='pvmJS__pvm-logo'>";
                                                myTemplate += " </section>";
                                                myTemplate += "</div>";

                                                // load job template
                                                // $.getJSON("https://" + ApiDomain + "/api/v1/jobs/search/widget?q=" + mySearch + "&group_by=" + myStyleConfig.groupings + "&cid=" + response.data.company_id + "&groups=true", function (data) {
                                                $.getJSON(window.location.origin + "/api/job/search-widget?q=" + mySearch + "&group_by=" + myStyleConfig.groupings + "&cid=" + response.data.company_id + "&groups=true", (data) => {
                                                    // var myJoblist = data.data.results;
                                                    var groupings_title = myStyleConfig.groupings.charAt(0).toUpperCase() + myStyleConfig.groupings.slice(1);
                                                    var myJoblist = {
                                                        groups: [{
                                                            jobs: data,
                                                            group: 'Group By: ' + groupings_title
                                                        }]
                                                    }
                                                    var myItems = "";

                                                    if (myJoblist.groups.length > 0) {
                                                        if (myJoblist.groups[0].jobs.length > 0) {
                                                            $(".js-int__preview-handler").html(myTemplate);
                                                            /* checking mother box's width */
                                                            var cutDesc = 200;
                                                            var columnCut = 1;
                                                            $("#whatismysize").html($(".my-pvm-job-list").width());
                                                            if ($(".my-pvm-job-list").width() >= 667 && $(".my-pvm-job-list").width() < 1024) {
                                                                $(".my-pvm-job-list").addClass("my-pvm-job-list--667");
                                                            } else if ($(".my-pvm-job-list").width() >= 1024 && $(".my-pvm-job-list").width() < 1440) {
                                                                $(".my-pvm-job-list").addClass("my-pvm-job-list--1024");
                                                                cutDesc = 280;
                                                            } else if ($(".my-pvm-job-list").width() >= 1440) {
                                                                $(".my-pvm-job-list").addClass("my-pvm-job-list--1440");
                                                            }
                                                            //Declare font face
                                                            if ($("#pvmGoogleFont").length <= 0) {
                                                                $("head").append("<style id='pvmGoogleFont'></style>");
                                                            }

                                                            if (myJoblist.groups[0].jobs[0].company.logo_url != null) {
                                                                $("#pvmCompanylogo").attr("src", myJoblist.groups[0].jobs[0].company.logo_url);
                                                            } else {
                                                                $("#pvmCompanylogo").attr("src", "/images/default_company_logo.png");
                                                            }

                                                            /* *** IF YOU WILL NEW CLASS, MAKE SURE TO PUT THAT NEXT TO THE LAST CLASS *** */

                                                            for (var a = 0; a < myJoblist.groups.length; a++) {

                                                                myItems += "<h3 class='pvmJS__group-title'>" + myJoblist.groups[a].group + "</h3>";
                                                                myItems += "<ul class='pvmJS__job-list'>";

                                                                myItems += "<li class='pvmJS__job-item'> ";
                                                                for (var i = 0; i < myJoblist.groups[a].jobs.length; i++) {
                                                                    if ($scope.pvmEnableCol.value == 1) {
                                                                        if (!myStyleConfig.desc) { // if show desc is on / off
                                                                            myItems += "<div class='pvmJS__job-col pvmJS__no-desc'>";
                                                                        } else {
                                                                            myItems += "<div class='pvmJS__job-col'>"; // item's box - needs to group based on column requirement
                                                                        }
                                                                        myItems += "  <img src='"
                                                                        if (myJoblist.groups[a].jobs[i].company.logo_url) {
                                                                            myItems += myJoblist.groups[a].jobs[i].company.logo_url;
                                                                        } else {
                                                                            myItems += window.location.origin + "/images/default_company_logo.png";
                                                                        }
                                                                        myItems += "' class='pvmJS__logo'>";
                                                                        myItems += "  <div class='pvmJS__job-details'>";
                                                                    } else if ($scope.pvmEnableCol.value == 2) {
                                                                        columnCut = 2;

                                                                        if (!myStyleConfig.desc) { // if show desc is on / off
                                                                            myItems += "<div class='pvmJS__job-col pvmJS__job-col--2 pvmJS__no-desc'>";
                                                                        } else {
                                                                            myItems += "<div class='pvmJS__job-col pvmJS__job-col--2'>"; // item's box - needs to group based on column requirement
                                                                        }
                                                                        myItems += "  <div class='pvmJS__job-details'>";
                                                                        /*include image inside pvmJS__job-details for 2 columns and up*/
                                                                        myItems += "  <img src='"
                                                                        if (myJoblist.groups[a].jobs[i].company.logo_url) {
                                                                            myItems += myJoblist.groups[a].jobs[i].company.logo_url;
                                                                        } else {
                                                                            myItems += window.location.origin + "/images/default_company_logo.png";
                                                                        }
                                                                        myItems += "' class='pvmJS__logo pvmJS__logo--sm'>";
                                                                    } else if ($scope.pvmEnableCol.value == 3) {
                                                                        columnCut = 3;
                                                                        if (!myStyleConfig.desc) { // if show desc is on / off
                                                                            myItems += "<div class='pvmJS__job-col pvmJS__job-col--3 pvmJS__no-desc'>";
                                                                        } else {
                                                                            myItems += "<div class='pvmJS__job-col pvmJS__job-col--3'>"; // item's box - needs to group based on column requirement
                                                                        }
                                                                        myItems += "  <div class='pvmJS__job-details'>";

                                                                        /*include image inside pvmJS__job-details for 2 columns and up*/
                                                                        myItems += "  <img src='"
                                                                        if (myJoblist.groups[a].jobs[i].company.logo_url) {
                                                                            myItems += myJoblist.groups[a].jobs[i].company.logo_url;
                                                                        } else {
                                                                            myItems += window.location.origin + "/images/default_company_logo.png";
                                                                        }
                                                                        myItems += "' class='pvmJS__logo pvmJS__logo--sm'>";
                                                                    }

                                                                    myItems += "    <a href='#' class='pvmJS__job-title'>" + myJoblist.groups[a].jobs[i].job_title + "</a>";
                                                                    myItems += "    <div class='pvmJS__link-handler'>";
                                                                    myItems += "      <a href='#'  id='expandDesc' class='pvmJS__watch-link'><i class='fa fa-chevron-down'></i></a>";
                                                                    // myItems += "      <a href='" + window.location.origin + myJoblist.groups[a].jobs[i].job_url + "?tpl=1' target='_blank' class='pvmJS__share-link'><i class='fa fa-share-alt'></i></a>";
                                                                    myItems += "      <a href='" + window.location.origin + '/job/' + myJoblist.groups[a].jobs[i].object_id + "?tpl=1' target='_blank' class='pvmJS__share-link'><i class='fa fa-share-alt'></i></a>";
                                                                    myItems += "    </div>";
                                                                    myItems += "    <div class='pvmJS__det-handler'>";

                                                                    if (myStyleConfig.desc) { // if show desc is on
                                                                        myItems += "      <p class='pvmJS__job-desc ";
                                                                        if (myJoblist.groups[a].jobs[i].job_description) {
                                                                            if ($scope.pvmEnableCol.value > 1) {
                                                                                myItems += " pvmJS__job-desc--column "
                                                                            }
                                                                            if ((myJoblist.groups[a].jobs[i].job_description).length > (cutDesc + 1)) {
                                                                                myItems += " partial "
                                                                                if (!myJoblist.groups[a].jobs[i].job_video_url) {
                                                                                    myItems += " pvmJS__job-desc--vid-none "
                                                                                }
                                                                                myItems += "'>" + (myJoblist.groups[a].jobs[i].job_description).substr(0, cutDesc) + "...</p>";

                                                                                myItems += " <p class='pvmJS__job-desc full "
                                                                                if (!myJoblist.groups[a].jobs[i].job_video_url) {
                                                                                    myItems += " pvmJS__job-desc--vid-none "
                                                                                }
                                                                                myItems += "'>" + myJoblist.groups[a].jobs[i].job_description + "</p>";
                                                                            } else {
                                                                                if (!myJoblist.groups[a].jobs[i].job_video_url) {
                                                                                    myItems += " pvmJS__job-desc--vid-none "
                                                                                }
                                                                                myItems += "'>" + myJoblist.groups[a].jobs[i].job_description + "</p>";
                                                                            }
                                                                        } else {
                                                                            myItems += " '> No description provided.</p>";
                                                                        }
                                                                    }

                                                                    if (myJoblist.groups[a].jobs[i].job_meta_video_url.length > 0) {
                                                                        if (myJoblist.groups[a].jobs[i].job_meta_video_url[0].hasOwnProperty('meta_value')) {
                                                                            myItems += "    <span class='pvmJS__video-con pvmJS__video-con--with'>";
                                                                            myItems += "      <video id='pvm-" + myJoblist.groups[a].jobs[i].object_id + "' src='" + myJoblist.groups[a].jobs[i].job_meta_video_url[0].meta_value + "' class='azuremediaplayer amp-default-skin pvmJS__videos' poster='images/video_preload.gif' height='80' width='100' preload='none'></video>"
                                                                            myItems += "    </span>"
                                                                        }
                                                                    } else {
                                                                        myItems += "    <span class='pvmJS__video-con pvmJS__video-con--none'></span>";
                                                                    }

                                                                    myItems += "    </div>";
                                                                    myItems += "    <div class='pvmJS__other-details'>";
                                                                    myItems += "      <span class='pvmJS__location'><i class='fa fa-map-marker'></i>" + myJoblist.groups[a].jobs[i].location.display_name + "</span>";
                                                                    myItems += "      <span class='pvmJS__date-posted'><i class='fa fa-calendar'></i>" + $filter('date')(new Date(myJoblist.groups[a].jobs[i].published_date), 'EEE d MMM') + "</span>";
                                                                    myItems += "      <span class='pvmJS__job-type'><i class='fa fa-adjust'></i>" + myJoblist.groups[a].jobs[i].role_type.displayName + "</span>";
                                                                    myItems += "    </div>";
                                                                    myItems += "    <div class='pvmJS__apply'>";
                                                                    myItems += "      <a href='" + window.location.origin + '/job/details/' + myJoblist.groups[a].jobs[i].object_id + "' target='_blank' class='pvmJS__apply-btn'>Apply</a>";
                                                                    myItems += "    </div>";
                                                                    myItems += "  </div>";
                                                                    myItems += "</div>"; // item's box - needs to group based on column requirement

                                                                    if ((i + 1) % columnCut == 0) {
                                                                        myItems += "</li><li class='pvmJS__job-item'>";
                                                                    }
                                                                }
                                                                myItems += "</li>";
                                                                myItems += "</ul>";
                                                            }
                                                            $("#pvmGetMyJobs").html(myItems);

                                                            $(".pvmJS__watch-link, .pvmJS__job-title").click(function (e) {
                                                                e.preventDefault();
                                                                $(this).children(".fa").toggleClass("fa-chevron-down fa-chevron-up");
                                                                $(this).next().children(".pvmJS__watch-link").children(".fa").toggleClass("fa-chevron-down fa-chevron-up");

                                                                if ($(this).closest(".pvmJS__job-details").children(".pvmJS__apply").css("display") == "none") {
                                                                    $(this).closest(".pvmJS__job-details").children(".pvmJS__det-handler").children(".pvmJS__job-desc.full").show();
                                                                    $(this).closest(".pvmJS__job-details").children(".pvmJS__det-handler").children(".pvmJS__job-desc.partial").hide();
                                                                    $(this).closest(".pvmJS__job-details").children(".pvmJS__apply").show("slow");
                                                                } else {
                                                                    $(this).closest(".pvmJS__job-details").children(".pvmJS__det-handler").children(".pvmJS__job-desc.full").hide();
                                                                    $(this).closest(".pvmJS__job-details").children(".pvmJS__det-handler").children(".pvmJS__job-desc.partial").show();
                                                                    $(this).closest(".pvmJS__job-details").children(".pvmJS__apply").hide("slow");
                                                                }
                                                            });

                                                            $("#pvmSearchMyJobsBtn").click(function () {
                                                                loadMyRoles($("#pvmSearchMyJobs").val());
                                                            });

                                                            $("#pvmSearchMyJobs").keypress(function (e) {
                                                                if (e.which == 13) {
                                                                    loadMyRoles($("#pvmSearchMyJobs").val());
                                                                }
                                                            });

                                                            /* SET Video */
                                                            $(".pvmJS__videos").each(function () {
                                                                var id = this.id;
                                                                var src = $("#" + id).attr('src');

                                                                var myPlayer = amp(id, {
                                                                    "techOrder": ["azureHtml5JS", "flashSS", "silverlightSS", "html5"],
                                                                    "nativeControlsForTouch": false,
                                                                    autoplay: false,
                                                                    controls: true,
                                                                    width: "322",
                                                                    height: "181",
                                                                    logo: {
                                                                        "enabled": false
                                                                    },
                                                                    poster: ""
                                                                }, function () {});
                                                                myPlayer.src([{
                                                                    src: src,
                                                                    type: "application/vnd.ms-sstr+xml"
                                                                }]);
                                                            });

                                                            //Job title styling
                                                            $(".pvmJS__job-title").css({
                                                                "color": myStyleConfig.job_title.color,
                                                                "font-size": myStyleConfig.job_title.size,
                                                                "font-family": '"' + myStyleConfig.job_title.family + '", Arial'
                                                            });

                                                            //Job des styling
                                                            $(".pvmJS__job-desc").css({
                                                                "color": myStyleConfig.job_desc.color,
                                                                "font-size": myStyleConfig.job_desc.size,
                                                                "font-family": '"' + myStyleConfig.job_desc.family + '", Arial'
                                                            });

                                                            //Enable logo
                                                            if (myStyleConfig.logo == true) {
                                                                $(".pvmJS__logo").removeClass("pvmJS__logo--off");
                                                                $(".pvmJS__job-details").removeClass("pvmJS__job-details--logo-off");
                                                            } else {
                                                                $(".pvmJS__logo").addClass("pvmJS__logo--off");
                                                                $(".pvmJS__job-details").addClass("pvmJS__job-details--logo-off");
                                                            }
                                                            //Enable vid
                                                            if (myStyleConfig.video == true) {
                                                                $(".pvmJS__video-con").addClass("pvmJS__video-con--on");
                                                                $(".pvmJS__video-con").removeClass("pvmJS__video-con--off");
                                                                $(".pvmJS__job-desc").removeClass("pvmJS__job-desc--vid-off");
                                                            } else {
                                                                $(".pvmJS__video-con").removeClass("pvmJS__video-con--on");
                                                                $(".pvmJS__video-con").addClass("pvmJS__video-con--off");
                                                                $(".pvmJS__job-desc").addClass("pvmJS__job-desc--vid-off");
                                                            }

                                                            //Enable desc
                                                            if (myStyleConfig.job_desc == true) {
                                                                $(".pvmJS__desc-con").addClass("pvmJS__desc-con--on");
                                                                $(".pvmJS__desc-con").removeClass("pvmJS__desc-con--off");
                                                                $(".pvmJS__job-desc").removeClass("pvmJS__job-desc--vid-off");
                                                            } else {
                                                                $(".pvmJS__video-con").removeClass("pvmJS__video-con--on");
                                                                $(".pvmJS__video-con").addClass("pvmJS__video-con--off");
                                                                $(".pvmJS__job-desc").addClass("pvmJS__job-desc--vid-off");
                                                            }

                                                            //Groupings
                                                            if (myStyleConfig.groupings == "none") {
                                                                $(".pvmJS__group-title").removeClass("pvmJS__group-title--groupings-on");
                                                            } else if (myStyleConfig.groupings == "location") {
                                                                //$(".pvmJS__group-title").text("Auckland");

                                                                $(".pvmJS__group-title").addClass("pvmJS__group-title--groupings-on");
                                                            } else if (myStyleConfig.groupings == "department") {
                                                                //$(".pvmJS__group-title").text("Accounting");
                                                                $(".pvmJS__group-title").addClass("pvmJS__group-title--groupings-on");
                                                            }
                                                        } else {
                                                            console.log("no Jobs!")
                                                        }
                                                    } else {
                                                        console.log("no Jobs!")
                                                    }
                                                    //end of job list query
                                                });
                                                $("#pvmLogoFooter").attr("src", window.location.origin + "/images/previewme-logo.png");

                                                //}); .load
                                            });
                                        }

                                        loadMyRoles("");

                                        /***Set Embed code***/
                                        function JSembedCodeFunc() {
                                            var JSembedStr;

                                            JSembedStr = "<script src='" + window.location.origin + "/js/embed.js' id='pvmEmbedJS'></script>";
                                            JSembedStr += "<script type='text/javascript' charset='utf-8' id='pvmIdJS' company='" + response.data.company_id + "'>";
                                            JSembedStr += "</script>";
                                            JSembedStr += "<div id='myPVMJobListHandler'></div>";

                                            $("#pvmEmbedJSCode").text(JSembedStr);
                                        }

                                        JSembedCodeFunc();

                                    }

                                }
                            });

                        }
                    }
                }, (response) => {
                    if (response.status === 401) {

                    }
                });
            }

        }
    ]);
}());

$(document).ready(function () {
    /*** Responsiveness ***/
    function respondToMe() {
        if ($(".js-int__preview-handler").innerWidth() > "1025") {
            $(".pvmJS__videos").css({
                "height": "180px",
                "width": "330px"
            });

        } else if ($(".js-int__preview-handler").innerWidth() >= "741" && $(".js-int__preview-handler").innerWidth() <= "1024") {
            $(".pvmJS__job-details").css({
                "width": "84.95%"
            });
            $(".pvmJS__videos").css({
                "height": "160px",
                "min-width": "190px",
                "width": "290px"
            });

        } else if ($(".js-int__preview-handler").innerWidth() <= "740") {
            $(".pvmJS__job-details").css({
                "width": "76.5%"
            });
            $(".pvmJS__videos").css({
                "height": "100px",
                "min-width": "160px",
                "width": "170px"
            });
            $(".pvmJS__logo").css({
                "margin": "0px 5px 0px"
            });
            $(".pvmJS__job-desc").css({
                "width": "60%"
            });
        }
    }
    respondToMe();

    $(window).resize(function () {
        respondToMe();
    });
});

$('.js-int__embed-code-area').focus(function (e) {
    e.target.select();
    $(e.target).one('mouseup', function (e) {
        e.preventDefault();
    });
});
