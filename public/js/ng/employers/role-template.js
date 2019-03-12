/**
 * Created by domina on 10/27/2017.
 */

(function() {
  'use strict';
  var app = angular.module('app');
  var base_url = $('body').data('base_url');

  // app.requires.push('angularModalService', 'ui.bootstrap.tpls', 'ui.bootstrap.modal');

  app.filter('ellipsis', function () {
    return function (text, length) {
      if (text.length > length) {
        return text.substr(0, length) + '...';
      }
      return text;
    }
  });


  app.controller('EmployerRoleTemplate', ['GlobalConstant', '$scope', '$window', '$http', '$cookies', '$filter', '$timeout', '$compile', '$sce', 'EmployerRoleHttpSvcs', 'CreateRoleSvcs',
  function (GlobalConstant, $scope, $window, $http, $cookies, $filter, $timeout, $compile, $sce, EmployerRoleHttpSvcs, CreateRoleSvcs) {
    $scope.roleName = "";
    $scope.sortMe = false;
    $scope.classMe = false;
    $scope.sort = 'all';
    $scope.sortCollection = $scope.sort;
    $scope.filterInd = '';
    $scope.filterIndustries = $scope.filterInd;
    $scope.jobTemplates = "";
    $cookies.remove('loadTemplate', { 'path':'/'});
    $cookies.remove('jobObjectId', { 'path':'/'});
    $scope.JobId = 0;

    $scope.RDOverview = true;
    $scope.RDResp = false;
    $scope.RDReq = false;
    $scope.RDAppResp = false;
    $scope.RDPreQ = false;
    $scope.RDStandard = false;
    $scope.companyTemplateOn = false;
    $scope.searchPvmTemplates = {
      q: '',
      sort: '',
      industry: '',
      type: 'public'
    };

    //pagination objects
    $scope.pages = {
      current: 0,
      total: 0,
      records_in_current: 0,
      total_records: 0
    };

    $scope.InitDrafts = function(page) {
      EmployerRoleHttpSvcs.getDrafts(page).then(function(res){
        $scope.main_draft = res;
        $scope.drafts = res.records;

        console.log("DRAFTS: ", $scope.main_draft);

        $scope.deleteDraft = function(draft) {
          var willDel = confirm("Are you sure you want to delete this draft?");
          if(willDel == true) {
            var index = $scope.drafts.indexOf(draft);
            $scope.drafts.splice(index, 1);
            EmployerRoleHttpSvcs.deleteDrafts(draft.job_id).then(function (res) {});
          }
        }
      });
    };
    $scope.InitDrafts(1);


    EmployerRoleHttpSvcs.getFilterClassifications($scope.searchPvmTemplates.type).then(function(res){
      $scope.filterclassifications = res;
    });

    $scope.movePage = function (type) {
      var from = parseInt($scope.main_draft.current_page);
      var to = 0;
      var total = parseInt($scope.main_draft.total_pages);

      if (type == 'n') {
        to = from + 1;
      } else {
        to = from - 1;
      }

      if (total >= to && to != 0) {
        $scope.InitDrafts(to);
      }
    };

    $scope.sortF = function(sortF) {
      if(sortF == 'sort') {
        $scope.sortMe = !$scope.sortMe;
        $scope.classMe = false;
      } else if(sortF == 'class') {
        $scope.classMe = !$scope.classMe;
        $scope.sortMe = false;
      }
    }

    $scope.roleDetailsTab = function(item) {
      if(item == 'Overview') {
        $scope.RDOverview = true;
        $scope.RDResp = false;
        $scope.RDReq = false;
        $scope.RDAppResp = false;
        $scope.RDPreQ = false;
        $scope.RDStandard = false;
      } else if (item == 'Resp') {
        $scope.RDOverview = false;
        $scope.RDResp = true;
        $scope.RDReq = false;
        $scope.RDAppResp = false;
        $scope.RDPreQ = false;
        $scope.RDStandard = false;
      } else if (item == 'Req') {
        $scope.RDOverview = false;
        $scope.RDResp = false;
        $scope.RDReq = true;
        $scope.RDAppResp = false;
        $scope.RDPreQ = false;
        $scope.RDStandard = false;
      } else if (item == 'AppResp') {
        $scope.RDOverview = false;
        $scope.RDResp = false;
        $scope.RDReq = false;
        $scope.RDAppResp = true;
        $scope.RDPreQ = false;
        $scope.RDStandard = false;
      } else if (item == 'PreQ') {
        $scope.RDOverview = false;
        $scope.RDResp = false;
        $scope.RDReq = false;
        $scope.RDAppResp = false;
        $scope.RDPreQ = true;
        $scope.RDStandard = false;
      } else if (item == 'Standard') {
        $scope.RDOverview = false;
        $scope.RDResp = false;
        $scope.RDReq = false;
        $scope.RDAppResp = false;
        $scope.RDPreQ = false;
        $scope.RDStandard = true;
      }
    }
    $scope.roleDetailsTab('Overview');

    $scope.shiftTemplate = function() {
      //change $scope.templateItem value
      $scope.companyTemplateOn = !$scope.companyTemplateOn;
      $scope.searchLibTemplate();
    }
    // $scope.shiftTemplate();

    $scope.saveRoleName = function() {
      // var data = { data: {
      //   "job_title":$scope.roleName,
      //   "role_type":1,
      //   "working_days":[1, 2, 3, 4, 5],
      //   "min_salary":0,
      //   "max_salary":0,
      //   "start_time":"",
      //   "finish_time":"",
      //   "flexible_hours":false,
      //   "industry":0,
      //   "min_experience":0,
      //   "max_experience":0,
      //   "is_salary_public":false,
      //   "location":{
      //      "country_id":1,
      //      "location":""
      //   },
      //   "lead_manage_team":false,
      //   "role_duration":5,
      //   "salary_type":"A",
      //   "salary_notes":"",
      //   "job_reason":"",
      //   "job_meta":{},
      //   "job_video_url":"",
      //   "benefits":[],
      //   "requirements":[],
      //   "accountabilities":[],
      //   "objectives":[],
      //   "search_helpers":{
      //      "flexible_working":"Yes",
      //      "part_time":"Yes",
      //      "above_salary_band":"Yes",
      //      "high_potential_less_experience":"Yes"
      //   }
      // }};
      var data = { data: {
        "job_title":$scope.roleName,
      }};


      // AJAX to save role name here with job id/role name returned
      EmployerRoleHttpSvcs.postRoleName(data).then(function(res){
        $scope.proceedToRoleCreation(res.id);
        $scope.JobId = res.id;
      });
      // then redirect to job/add/employee with id param
    }


    $scope.proceedToRoleCreation = function(data) {
      //window.location = window.location.origin + "/feature_create_role/previewme-frontend-live/index.php/employer/job/add/employee?id=" + data;
       window.location = window.location.origin + "/employer/job/add/employee?id=" + data;
    }

    $scope.searchLibTemplate = function ()  {
      $scope.jobTemplates = "";
      var data = {};
      var templateType = $scope.companyTemplateOn ? 'private' : 'public';

      $scope.searchPvmTemplates.type = templateType;
      EmployerRoleHttpSvcs.getPvmTemplates($scope.searchPvmTemplates).then(function (res) {
        $scope.jobTemplates = res;
      });
    };

    $scope.searchLibTemplate();

    $scope.sortChange = function (data) {
      $scope.sortCollection = data;
      $scope.searchPvmTemplates.sort = data;
      $scope.searchLibTemplate();
    };

    $scope.classificationChange = function (data) {
      $scope.filterInd = data;
      $scope.searchPvmTemplates.industry = data;
      $scope.searchLibTemplate();
    };

    $scope.showTempDetails = function(data) {
      //$("#seeMoreRoleModal").modal();

      EmployerRoleHttpSvcs.getModalDetails(data.template_id).then(function(res){
        $scope.application_requirements = [];
        if("old_job_id" in res) {
          res.old_job_id = data.old_job_id;
        }
        $scope.useTemplate(res.template_data);
      });

    }

    $scope.showModal = function(data) {
      $("#seeMoreRoleModal").modal();
      EmployerRoleHttpSvcs.getModalDetails(data.template_id).then(function(res){
        $scope.application_requirements = [];
        $scope.activetemplate = res;
        $scope.modaldetails = "";
        $scope.modaldetails = $scope.activetemplate.template_data;
        if("old_job_id" in data) {
          $scope.modaldetails.old_job_id = data.old_job_id;
        }
        console.log("heaven",$scope.modaldetails)
        $scope.temp_job_desc = $scope.modaldetails.job_description.replace(/\r?\n|\r/g, "<br>");
        $scope.temp_job_desc = $sce.trustAsHtml($scope.temp_job_desc)

        console.log("REQUIREMENTS: ", $scope.modaldetails.application_requirements);

        angular.forEach($scope.modaldetails.application_requirements, function(val, key){
          if(val == 'yes')   {
            $scope.application_requirements.push({
              name: key
            });
          }
        });
      });

      // ModalService.showModal({
      //   templateUrl: 'modal.html',
      //   controller: "ModalController"
      // }).then(function(modal) {
      //   console.log("mowdal");
      //   modal.element.modal();
      //   modal.close.then(function(result) {
      //       $scope.message = "You said " + result;
      //   });
      // });
    };

    $scope.useTemplate = function (data) {
      // $scope.JobId
      console.log(data)
      if(!("role_duration" in data)) {
        data.role_duration = 0;
      }
      if("location" in data) {
        if("id" in data.location.data) {
          data.location = data.location.data.id
        } else {
          data.location.country_id = data.location.data.country.id;
          if("display_name" in data.location.data) {
            data.location.location = data.location.data.display_name;
          } else {
            data.location.location = ""
          }
        }
      } else {
        data.location.country_id = 0;
        data.location.location = ""
      }

      if("industry" in data) {
        if("sub" in data.industry.data) {
          data.industry = data.industry.data.sub.id;
        } else if ("industry" in data.industry.data) {
          data.industry = data.industry.data.industry.id;
        } else {
          data.industry = 0;
        }
      }

      if("role_type" in data) {
        data.role_type = data.role_type.id;
      } else {
        data.role_type = 0;
      }

      if("accountabilities" in data) {
        angular.forEach(data.accountabilities, function(val, key) {
          data.accountabilities[key].type = data.accountabilities[key].type_display_name;
        });
      }

      if("requirements" in data) {
        angular.forEach(data.requirements, function(val, key) {
          data.requirements[key].type = data.requirements[key].type_display_name;
        });
      }

      if("benefits" in data) {
        angular.forEach(data.benefits, function(val, key) {
          data.benefits[key].type = data.benefits[key].type_display_name;
        });
      }

      if("objectives" in data) {
        angular.forEach(data.objectives, function(val, key) {
          data.objectives[key].type = data.objectives[key].type_display_name;
        });
      }

      if("search_helpers" in data) {
        angular.forEach(data.search_helpers, function(val, key) {
          data.search_helpers[key].type = data.search_helpers[key].type_display_name;
        });
      }

      //console.log("use template: ", data);
      //$cookies.put('loadTemplate', data, { 'path':'/'});

      EmployerRoleHttpSvcs.postRoleName({data: data}).then(function(res) {
        $scope.JobId = res.id;
        $timeout(function() {
          if (data.questions.pre_apply.length > 0) {
            CreateRoleSvcs.getGeneralInfo($scope.JobId).then(function (resp) {
              if (resp.questions.pre_apply.length > 0) {
                var wData = false;
              } else {
                var wData = true;
              }

              CreateRoleSvcs.savePreApply($scope.JobId, {data: data.questions.pre_apply}, wData).then(function (res) {
  console.log(res)
                CreateRoleSvcs.getGeneralInfo($scope.JobId).then(function (resp) {
                  console.log("after saving pre-app", resp)
                });

              });
            });
          }
        }, 500);
        $scope.proceedToRoleCreation(res.id);
      });
      //$window.location.href = base_url+'employer/job/add/employee';
    };

  }]);


  app.factory('EmployerRoleHttpSvcs', ['GlobalConstant', '$http', function (GlobalConstant, $http){
    return {
      // getDrafts: function () {
      //   return $http.get(GlobalConstant.EmployerRootApi + '/job/draft')
      //   .then(function (response){
      //     return response.data.data;
      //   });
      // },
      getDrafts: function (data) {
        return $http.get(GlobalConstant.JobsApi + '/drafts/all?page=' + data)
        .then(function (response){
          return response.data.data;
        });
      },
      deleteDrafts: function (data) {
        return $http.delete(GlobalConstant.JobsApi + '/draft/' + data)
        .then(function (response){
          return response.data.data;
        });
      },
      getPvmTemplates: function(data) {
        return $http.get(GlobalConstant.JobsApi + '/templates/search?q='+ data.q +'&industry='+ data.industry +'&sort='+ data.sort +'&type='+ data.type)
        .then(function (response){
          return response.data.data;
        });
      },
      getModalDetails: function(data) {
        return $http.get(GlobalConstant.JobsApi + '/template/'+ data)
        .then(function (response){
          return response.data.data;
        });
      },
      getFilterClassifications: function(data) {
        return $http.get(GlobalConstant.JobsApi + '/templates/industries/all?type=' + data)
        .then(function (response){
          return response.data.data;
        });
      },
      postRoleName: function (data) {
        return $http.post(GlobalConstant.EmployerRootApi + '/job', data)
        .then(function (response){
          return response.data.data;
        });
      }
    }
  }]);


  $(document).ready(function() {
    $("#createRoleNameBtn").click(function() {
      $("#CreateRoleModal").modal();
    });
    $(".new-role__see-btn").click(function() {
      console.log("mudal");
      $("#seeMoreRoleModal").modal();
    });
  });
}());/**
 * Created by domina on 10/27/2017.
 */
