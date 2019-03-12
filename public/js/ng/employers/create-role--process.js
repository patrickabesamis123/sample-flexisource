/**
 * Created by domina on 11/14/2017.
 */
/**
 * Created by domina on 11/14/2017.
 */

(function() {
  'use strict';
  var app = angular.module('app');
  app.requires.push('ui.sortable');
  var base_url = $('body').data('base_url');

  app.controller('CreateRoleProcess', ['GlobalConstant', '$scope', '$window', '$http', '$cookies', '$filter', '$timeout', '$compile', 'EmployerRoleHttp',
    function (GlobalConstant, $scope, $window, $http, $cookies, $filter, $timeout, $compile, EmployerRoleHttp) {
      $scope.roleId = $scope.$parent.$parent.objURL.id;
      $scope.role_create_tab_loader = 1;
      if (!$scope.roleId) {
        $scope.roleId = $cookies.get('jobObjectId');
      }

      $scope.showAdd = false;
      $scope.showWarning = false;
      $scope.toSaveBucketList = [];

      $scope.roleCreateTeam = {
        "template": {
          "name": "",
          "save": false
        },
        "visibility_members": [],
        "visibility_teams": [],
        "workflow_steps": []
      };


      EmployerRoleHttp.getData($scope.roleId).then(function(res) {
        $scope.roleCreate = res;
        if (res) {
          $scope.role_create_tab_loader = 0;
        }

        $scope.roleName = $scope.roleCreate.job_title ? $scope.roleCreate.job_title : 'No Role name specified';
        $scope.roleCreate_watch = $scope.roleCreate;

        if($scope.roleCreate.report_date) {
          var d = new Date($scope.roleCreate.report_date);
        } else {
          var d = new Date();
        }
        //d = d.toDateString();
        var roleYrPass = d.getFullYear();
        var roleDayPass = d.getDate();
        var roleMoPass = d.getMonth();

        $scope.roleDayPass = {label: roleDayPass, value: roleDayPass};
        $scope.roleYrPass = {label: roleYrPass, value: roleYrPass};

        $scope.roleCreate_watch.report_date = (roleMoPass+1) + '/' + $scope.roleDayPass.value + '/' + $scope.roleYrPass.value;

        if("visibility" in $scope.roleCreate_watch) {
          $scope.roleCreate_watch.visibility_members = $scope.roleCreate.visibility.members;
          $scope.roleCreate_watch.visibility_teams = $scope.roleCreate.visibility.teams;
        }
        
        //console.log("from process",$scope.roleCreate);
        if($scope.roleCreate.job_manager) {
          $scope.isJobManager = true;
        } else {
          $scope.isJobManager = false;
        }
        //console.log("job_manager", $scope.isJobManager)

        $scope.workflowSteps = function() {
          $scope.bucketListDB = $scope.roleCreateTeam.workflow_steps;

          //console.log("for html", $scope.bucketListDB)

          $scope.checkBucketName = function(bucketName) {
            $scope.toSaveBucketList = [];
            var indexRe = 0;

            //check last valid bucket
            for (var index in $scope.bucketListDB) {
              if($scope.bucketListDB[index].slug_name == 'rejected') {
                indexRe = Number(index)
              }
            }

            //console.log(567,bucketName)
            if(typeof bucketName.name != 'undefined') {
              var index = $scope.bucketListDB.indexOf(bucketName);
              $scope.bucketListDB[index].showNewSteps = true;
              if(bucketName.name != "Create new" && bucketName.name != '') {
                //set enable = true to change color and to add to the bucket items
                $scope.bucketListDB[index] = {"id": bucketName.id, "order": bucketName.priority, name: bucketName.name, "slug_name": (bucketName.name).replace(" ", "-"), "blank": false, "enabled": true}
                //console.log("bucket",$scope.bucketListDB)
                $scope.showWarning = false;
                $scope.resort();
              } else if(bucketName.name == '') {
                $scope.showNewSteps = false;
                //console.log(44, bucketName);
                $scope.bucketListDB[index] = {"order" : bucketName.order, name : "Create new", "blank": false, "slug_name": "create_new", "blank": false, "enabled": false}
                $scope.showWarning = false;
                $scope.resort();
              } else if(bucketName.name == 'Create new') {
                //console.log(44567468795, bucketName);
                $scope.showNewSteps = false;
                $scope.bucketListDB[index] = {"order" : bucketName.order, name : "Create new", "blank": false, "slug_name": "create_new", "blank": false, "enabled": false}
                $scope.showWarning = false;
                $scope.resort();
              }

              for (var index in $scope.bucketListDB) {
                if($scope.bucketListDB[index].blank != true && $scope.bucketListDB[index].upHired != true && $scope.bucketListDB[index].name != "Create new") {
                  $scope.toSaveBucketList.push($scope.bucketListDB[index]);
                }
              }

              //$scope.roleCreateTeam.workflow_steps = $scope.bucketListDB;
              $scope.roleCreateTeam.workflow_steps = [];
              angular.forEach($scope.bucketListDB, function(val, key) {
                //console.log(val,8);
                var data = {
                  id: val.id,
                  name: val.name
                }

                $scope.roleCreateTeam.workflow_steps.push(data);
              });
              $scope.roleCreateTeam.visibility_members = [];
              $scope.roleCreateTeam.visibility_teams = [];
              //console.log("to save",$scope.roleCreateTeam)
              $scope.$parent.$parent.empRoleMain = $scope.roleCreate_watch;
              $scope.$parent.$parent.empRoleMainTeam = $scope.roleCreateTeam;
              //console.log($scope.bucketListDB,$scope.toSaveBucketList)
            } else {
              //console.log(bucketName);
              $scope.showNewSteps = false;
              $scope.bucketListDB[bucketName.order-1] = {"order" : bucketName.priority, name : "Create new", "blank": false, "slug_name": ("Create new").replace(" ", "-")}
            }
          }

          $scope.sortableOptions = {
            stop: function(e, ui) {
              var indexRe = 0;
              //console.log("maderfads", $scope.bucketListDB)
              if(ui.item.sortable.dropindex) {
                for (var index in $scope.bucketListDB) {
                  $scope.bucketListDB[index].order = Number(index) + 1;

                }
                if($scope.bucketListDB[ui.item.sortable.dropindex].name != 'Create new') {
                  $scope.showWarning == false;
                  //console.log($scope.bucketListDB[ui.item.sortable.dropindex],ui.item.sortable.dropindex)
                  $scope.bucketListDB[ui.item.sortable.dropindex] = {"id": $scope.bucketListDB[(ui.item.sortable.dropindex)].id, "order": $scope.bucketListDB[(ui.item.sortable.dropindex)+1].priority, name: $scope.bucketListDB[ui.item.sortable.dropindex].name, "blank": false, "enabled": true}
                  $scope.resort();
                  $scope.showWarning = false;

                  $scope.toSaveBucketList = [];
                  for (var index in $scope.bucketListDB) {
                    if($scope.bucketListDB[index].blank != true && $scope.bucketListDB[index].upHired != true && $scope.bucketListDB[index].name != "Create new") {
                      $scope.toSaveBucketList.push($scope.bucketListDB[index]);
                    }
                  }

                  //console.log($scope.toSaveBucketList, "fuck")
                  //}
                }
              }
              //logModels();
            },
            items: "li:not(.not-sortable)"
          };

          $scope.resort = function() {
            var keyTemp = 0;
            angular.forEach($scope.bucketListDB, function(val, key) {
              //var keyTemp;
              if($scope.bucketListDB[key].enabled) {
                keyTemp++;
                $scope.bucketListDB[key].order = keyTemp;
              }

              if($scope.bucketListDB[key].name != 'Create new') {
                if($scope.bucketListDB[key].order == 4 &&  ($scope.bucketListDB[key].id != 4 && $scope.bucketListDB[key].id != 5)) { // only id 6-10 (6-12) can be shuffled, 1=long list, 2=short list, 3=interview, 4=hired, 5=unsuccessful
                  $scope.bucketListDB[key].id = 6;
                } else if($scope.bucketListDB[key].order == 5 && ($scope.bucketListDB[key].id != 4 && $scope.bucketListDB[key].id != 5)) { // only id 6-10 (6-12) can be shuffled, 1=long list, 2=short list, 3=interview, 4=hired, 5=unsuccessful
                  $scope.bucketListDB[key].id = 7;
                } else if($scope.bucketListDB[key].order == 6 && ($scope.bucketListDB[key].id != 4 && $scope.bucketListDB[key].id != 5)) { // only id 6-10 (6-12) can be shuffled, 1=long list, 2=short list, 3=interview, 4=hired, 5=unsuccessful
                  $scope.bucketListDB[key].id = 8;
                } else if($scope.bucketListDB[key].order == 7 && ($scope.bucketListDB[key].id != 4 && $scope.bucketListDB[key].id != 5)) { // only id 6-10 (6-12) can be shuffled, 1=long list, 2=short list, 3=interview, 4=hired, 5=unsuccessful
                  $scope.bucketListDB[key].id = 9;
                } else if($scope.bucketListDB[key].order == 8 && ($scope.bucketListDB[key].id != 4 && $scope.bucketListDB[key].id != 5)) { // only id 6-10 (6-12) can be shuffled, 1=long list, 2=short list, 3=interview, 4=hired, 5=unsuccessful
                  $scope.bucketListDB[key].id = 10;
                }
              }
              
              /*if(!$scope.isJobManager) {
                if(val.slug_name == "job-manager-review") {
                  console.log(110,$scope.isJobManager);
                  $scope.bucketListDB[key].slug_name = "create_new";
                  $scope.bucketListDB[key].name = "Create new";
                  $scope.bucketListDB[key].id = 6;
                  $scope.bucketListDB[key].order = 6;
                  $scope.bucketListDB[key].priority = 6;
                }
                if(val.slug_name == "hired") {
                  $scope.bucketListDB[key].order = 4;
                  $scope.bucketListDB[key].priority = 4;
                  console.log($scope.bucketListDB[key],$scope.bucketListDB[key].order);
                }
                if(val.slug_name == "not-interested") {
                  $scope.bucketListDB[key].order = 5;
                  $scope.bucketListDB[key].priority = 5;
                  console.log(val.slug_name,$scope.roleCreateTeam.workflow_steps);
                }
              }*/
            });

            var keyTempDisabled = keyTemp;
            angular.forEach($scope.bucketListDB, function(val, key) {
              //var keyTemp;
              if(!($scope.bucketListDB[key].enabled)) {
                keyTempDisabled++;
                $scope.bucketListDB[key].order = keyTempDisabled;
              }
            });


            $scope.roleCreateTeam.workflow_steps = $scope.bucketListDB;
            //console.log("inside resort",$scope.bucketListDB)
            $scope.$parent.$parent.empRoleMain = $scope.roleCreate_watch;
            $scope.$parent.$parent.empRoleMainTeam = $scope.roleCreateTeam;
            //console.log(keyTempDisabled)
            //console.log ("bucketListparent",$scope.$parent.$parent.empRoleMain)
          }

          $scope.resort();
        }

        if("workflow_steps" in $scope.roleCreate) {
          console.log($scope.roleCreate.workflow_steps,99)
          if($scope.roleCreate.workflow_steps.length > 0) {
            $scope.roleCreateTeam.workflow_steps = $scope.roleCreate.workflow_steps;
            angular.forEach($scope.roleCreateTeam.workflow_steps, function(val, key) {
              if(val.id == 5) {
                $scope.roleCreateTeam.workflow_steps[key].name = "Not Interested";
                $scope.roleCreateTeam.workflow_steps[key].slug_name = "rejected";
              }
              if(val.name != "Create new") {
                $scope.roleCreateTeam.workflow_steps[key].enabled = true;
              } else {
                $scope.roleCreateTeam.workflow_steps[key].enabled = false;
              }
              $scope.roleCreateTeam.workflow_steps[key].showNewSteps = false;
            });
            console.log(35,$scope.roleCreateTeam)
            $scope.workflowSteps();
          } else {
            $http.get(GlobalConstant.EmployerRootApi + '/job/default-workflow-steps')
            .then(function(response) {
              $scope.roleCreateTeam.workflow_steps = response.data.data;
              if(!("enabled" in $scope.roleCreateTeam.workflow_steps)) {
                angular.forEach($scope.roleCreateTeam.workflow_steps, function(val, key) {
                  $scope.roleCreateTeam.workflow_steps[key].enabled;
                  if(val.name != "Create new") {
                    $scope.roleCreateTeam.workflow_steps[key].enabled = true;
                  } else {
                    $scope.roleCreateTeam.workflow_steps[key].enabled = false;
                  }
                });
              }

              $scope.workflowSteps();

            });
          }
        } else {
          if($scope.roleCreate.workflow_steps.length <= 0) {
            //$scope.roleCreateTeam.workflow_steps = $scope.roleCreate.workflow_steps;
            $http.get(GlobalConstant.EmployerRootApi + '/job/default-workflow-steps')
            .then(function(response) {
              console.log(response)
              $scope.roleCreateTeam.workflow_steps = response.data.data;
              $scope.workflowSteps();
            });
          }
        }

        $scope.roleCreate_watch.job_title = $scope.roleCreate.job_title;
        $scope.$parent.$parent.empRoleMain = $scope.roleCreate_watch;
      });

    }]);

}());