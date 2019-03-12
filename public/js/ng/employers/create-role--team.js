! function() {
  "use strict";
  var e = angular.module("app");
  e.requires.push("angucomplete");
  $("body").data("base_url");
  e.controller("CreateRoleTeam", ["GlobalConstant", "$scope", "$window", "$http", "$cookies", "$filter", "$timeout", "$compile", "EmployerRoleHttp", function(e, a, r, t, i, l, m, o, n) {
      a.roleId = a.$parent.$parent.objURL.id, a.role_create_tab_loader = 1, a.roleId || (a.roleId = i.get("jobObjectId")), a.inviteMembersList = [{
          email: "",
          last_name: "",
          first_name: ""
      }, {
          email: "",
          last_name: "",
          first_name: ""
      }], a.selectedData = [], a.selectedTeams = [], a.selectedDataTeam = [], a.selectedDataMngr = [], a.SearchMemberField = [], a.SearchTeamField = [], a.SearchManagerField = [], a.selectedMembers = [], a.selectedManager = [], a.SelectedJobManager = [], a.inviteMsg = "";
      var s = ["member-initials--sky", "member-initials--pvm-purple", "member-initials--pvm-green", "member-initials--pvm-red", "member-initials--pvm-yellow"];
      a.roleCreateTeam = {
          template: {
              name: "",
              save: !1
          },
          visibility_members: [],
          visibility_teams: [],
          workflow_steps: []
      }, n.getData(a.roleId).then(function(r) {
          if (a.roleCreate = r, r && (a.role_create_tab_loader = 0), a.roleName = a.roleCreate.job_title ? a.roleCreate.job_title : "No Role name specified", a.roleCreate_watch = a.roleCreate, a.roleManager = a.roleCreate_watch.job_manager, a.roleCreate.report_date) var i = new Date(a.roleCreate.report_date);
          else var i = new Date;
          var l = i.getFullYear(),
              m = i.getDate(),
              o = i.getMonth();
          if (a.roleDayPass = {
                  label: m,
                  value: m
              }, a.roleYrPass = {
                  label: l,
                  value: l
              }, a.roleCreate_watch.report_date = o + 1 + "/" + a.roleDayPass.value + "/" + a.roleYrPass.value, void 0 !== a.roleCreate.visibility.teams ? a.roleCreateTeam.visibility_teams = a.roleCreate.visibility.teams : a.roleCreateTeam.visibility_teams = [], void 0 !== a.roleCreate.visibility.members ? a.roleCreateTeam.visibility_members = a.roleCreate.visibility.members : a.roleCreateTeam.visibility_members = [], a.roleCreateTeam.workflow_steps = a.roleCreate.workflow_steps, "job_manager" in a.roleCreate && (a.roleCreateTeam.job_manager = a.roleCreate.job_manager), a.roleCreateTeam.industry = a.roleCreate.industry, a.roleCreateTeam.workflow_steps = a.roleCreate.workflow_steps, a.roleCreateTeam)
              if (angular.isDefined(a.roleCreateTeam.job_manager) && null != a.roleCreateTeam.job_manager)
                  if (angular.isDefined(a.roleCreateTeam.job_manager.id)) {
                      if (a.SelectedJobManager.id = a.roleCreateTeam.job_manager.id, null != a.roleCreateTeam.job_manager) {
                          var n = a.roleCreateTeam.job_manager.first_name;
                          n = n.substr(0, 1);
                          var p = a.roleCreateTeam.job_manager.last_name;
                          p = p.substr(0, 1), a.roleCreateTeam.job_manager.initial = n + p, a.roleCreateTeam.job_manager.profile_color = "member-initials--sky"
                      }
                  } else a.SelectedJobManager.id = null;
          else a.SelectedJobManager.id = null;
          a.$parent.$parent.empRoleMainTeam = a.roleCreateTeam, t.get(window.location.origin + '/js/minified/test-data/test_emp_create_role_member_data.json').then(function(e) { // t.get(e.APIRoot + "employer/company/member").then(function(e) { // Uncomment for live API call
              a.roleCompanyMemberList = e.data.data, a.roleCompanyMemberListforMngr = e.data.data, a.selectedData = a.roleCreateTeam.visibility_members;
              var r = 1;
              angular.forEach(a.roleCompanyMemberList, function(e, t) {
                  a.roleCompanyMemberList[t].full_name = "", a.roleCompanyMemberList[t].profile_color = "", r >= 6 && (r = 1), a.roleCompanyMemberList[t].full_name = a.roleCompanyMemberList[t].first_name + " " + a.roleCompanyMemberList[t].last_name, a.F_initial = a.roleCompanyMemberList[t].first_name, a.F_initial = a.F_initial.substr(0, 1), a.L_initial = a.roleCompanyMemberList[t].last_name, a.L_initial = a.L_initial.substr(0, 1), a.roleCompanyMemberList[t].initial = a.F_initial + a.L_initial, a.roleCompanyMemberList[t].profile_picture_url || (1 == r ? a.roleCompanyMemberList[t].profile_color = "member-initials--sky" : 2 == r ? a.roleCompanyMemberList[t].profile_color = "member-initials--pvm-purple" : 3 == r ? a.roleCompanyMemberList[t].profile_color = "member-initials--pvm-green" : 4 == r ? a.roleCompanyMemberList[t].profile_color = "member-initials--pvm-red" : 5 == r && (a.roleCompanyMemberList[t].profile_color = "member-initials--pvm-yellow"), r++), a.selectedData && a.selectedData.indexOf(a.roleCompanyMemberList[t].id) > -1 && a.selectedMembers.push(e)
              }), angular.forEach(a.selectedMembers, function(e, r) {
                  if (a.roleCompanyMemberList.indexOf(e) > -1) {
                      var t = a.roleCompanyMemberList.indexOf(e);
                      a.roleCompanyMemberList[t].isSelected = !0
                  } else a.roleCompanyMemberList[t].isSelected = !1
              }), a.ddd = function(e) {
                  a.selectedMembers.push(e), angular.forEach(a.selectedMembers, function(e, r) {
                      a.roleCreateTeam.visibility_members.indexOf(a.selectedMembers[r].id) <= -1 && a.roleCreateTeam.visibility_members.push(a.selectedMembers[r].id)
                  }), a.$parent.$parent.empRoleMainTeam = a.roleCreateTeam
              }, a.selectedMngr = function(e) {
                  a.SelectedJobManager.id = e.id, a.roleManager = e, a.roleCreateTeam.visibility_members.indexOf(e.id), a.roleCreateTeam.job_manager = e.id, a.$parent.$parent.empRoleMainTeam = a.roleCreateTeam, a.$parent.$parent.empRoleMainTeam = a.roleCreateTeam
              }, a.RemoveTeamMember = function(e, r) {
                  if ("team" == r) {
                      if (-1 != e.id) {
                          var t = a.selectedTeams.indexOf(e),
                              i = a.GetAllCompanyTeam.indexOf(e),
                              l = a.roleCreateTeam.visibility_teams.indexOf(e.id);
                          a.selectedTeams.splice(t, 1), a.GetAllCompanyTeam[i].isSelected = !1, a.roleCreateTeam.visibility_teams.splice(l, 1), a.$parent.$parent.empRoleMainTeam = a.roleCreateTeam
                      }
                  } else if ("member" == r) {
                      var t = a.selectedMembers.indexOf(e);
                      a.selectedMembers.splice(t, 1), a.roleCompanyMemberList[t].isSelected = !1, a.roleCreateTeam.visibility_members = a.selectedData, a.selectedData = [], angular.forEach(a.selectedMembers, function(e, r) {
                          a.selectedData.push(a.selectedMembers[r].id)
                      }), a.roleCreateTeam.visibility_members = a.selectedData, a.$parent.$parent.empRoleMainTeam = a.roleCreateTeam
                  } else "manager" == r && (a.SelectedJobManager.id = null, a.roleCreateTeam.job_manager = null, a.roleManager = {}, a.$parent.$parent.empRoleMainTeam = a.roleCreateTeam)
              }
          }), // t.get(e.APIRoot + "employer/company/team").then(function(e) {
              t.get(window.location.origin + '/js/minified/test-data/test_emp_create_role_team_data.json').then(function(e) {
              window.location.origin + '/js/minified/test-data/test_emp_create_role_countries_data.json'
              a.GetAllCompanyTeam = e.data.data, a.selectedDataTeam = a.roleCreateTeam.visibility_teams;
              for (var r = 1, t = 0; t < a.GetAllCompanyTeam.length; t++) {
                  for (var i = 0; i < a.GetAllCompanyTeam[t].members.length; i++) r >= 6 && (r = 1), a.F_initial = a.GetAllCompanyTeam[t].members[i].employer.first_name, a.F_initial = a.F_initial.substr(0, 1), a.L_initial = a.GetAllCompanyTeam[t].members[i].employer.last_name, a.L_initial = a.L_initial.substr(0, 1), a.GetAllCompanyTeam[t].members[i].employer.initial = a.F_initial + a.L_initial, a.GetAllCompanyTeam[t].members[i].employer.profile_picture_url || (1 == r ? a.GetAllCompanyTeam[t].members[i].employer.profile_color = "member-initials--sky" : 2 == r ? a.GetAllCompanyTeam[t].members[i].employer.profile_color = "member-initials--pvm-purple" : 3 == r ? a.GetAllCompanyTeam[t].members[i].employer.profile_color = "member-initials--pvm-green" : 4 == r ? a.GetAllCompanyTeam[t].members[i].employer.profile_color = "member-initials--pvm-red" : 5 == r && (a.GetAllCompanyTeam[t].members[i].employer.profile_color = "member-initials--pvm-yellow"), r++);
                  a.team_initial = a.GetAllCompanyTeam[t].team_name, a.team_initial = a.team_initial.replace(/[^A-Z]/g, ""), a.GetAllCompanyTeam[t].initial = a.team_initial;
                  var l = s[Math.floor(Math.random() * s.length)];
                  a.GetAllCompanyTeam[t].team_color = l, a.selectedDataTeam && a.selectedDataTeam.indexOf(a.GetAllCompanyTeam[t].id) > -1 && a.selectedTeams.push(a.GetAllCompanyTeam[t])
              }
              angular.forEach(a.selectedTeams, function(e, r) {
                  var t = a.GetAllCompanyTeam.indexOf(e);
                  a.GetAllCompanyTeam.indexOf(e) > -1 ? a.GetAllCompanyTeam[t].isSelected = !0 : a.GetAllCompanyTeam[t].isSelected = !1
              }), a.addTeam = function(e) {
                  a.selectedTeams.push(e);
                  var r = a.GetAllCompanyTeam.indexOf(e);
                  a.GetAllCompanyTeam[r].isSelected = !0, a.roleCreateTeam.visibility_teams.indexOf(e.id) <= -1 && a.roleCreateTeam.visibility_teams.push(e.id), null != a.roleCreateTeam.job_manager && "object" == typeof a.roleCreateTeam.job_manager && (a.$parent.$parent.empRoleMainTeam.job_manager = a.roleCreateTeam.job_manager.id), a.$parent.$parent.empRoleMainTeam = a.roleCreateTeam
              }
          }), a.roleCreate_watch.job_title = a.roleCreate.job_title
      }), a.roleMemList = [], a.roleMemSelected = [], a.addNewItemMember = function() {
          a.inviteMembersList.push({
              email: "",
              last_name: "",
              first_name: ""
          })
      }, a.addMemberList = function(r) {
          angular.forEach(r, function(i, l) {
              r[l].account_type = 6, t.post(e.EmployerRegisterMember, {
                  data: r[l]
              }).then(function(e) {
                  if (null != e.data.data) {
                      a.inviteMsg = "Invitation has been sent!", a.roleCompanyMemberList.push(e.data.data);
                      for (var r = 1, t = 0; t < a.roleCompanyMemberList.length; t++) a.roleCompanyMemberList[t].full_name = "", a.roleCompanyMemberList[t].profile_color = "", r >= 6 && (r = 1), a.roleCompanyMemberList[t].full_name = a.roleCompanyMemberList[t].first_name + " " + a.roleCompanyMemberList[t].last_name, a.F_initial = a.roleCompanyMemberList[t].first_name, a.F_initial = a.F_initial.substr(0, 1), a.L_initial = a.roleCompanyMemberList[t].last_name, a.L_initial = a.L_initial.substr(0, 1), a.roleCompanyMemberList[t].initial = a.F_initial + a.L_initial, a.roleCompanyMemberList[t].profile_picture_url || (1 == r ? a.roleCompanyMemberList[t].profile_color = "member-initials--sky" : 2 == r ? a.roleCompanyMemberList[t].profile_color = "member-initials--pvm-purple" : 3 == r ? a.roleCompanyMemberList[t].profile_color = "member-initials--pvm-green" : 4 == r ? a.roleCompanyMemberList[t].profile_color = "member-initials--pvm-red" : 5 == r && (a.roleCompanyMemberList[t].profile_color = "member-initials--pvm-yellow"), r++)
                  }
              })
          })
      }
  }]), e.factory("EmployerRoleHttp", ["GlobalConstant", "$http", function(e, a) {
      return {
          getData: function(r) {
              // return a.get(e.EmployerRootApi + "/job/" + r).then(function(e) {
              return a.get(window.location.origin + '/js/minified/test-data/test_emp_create_role_job_data.json').then(function(e) {
                  return e.data.data
              })
          },
          getIndustries: function() {
              // return a.get(e.StaticOptionsApi + "/industries").then(function(e) {
              return a.get(window.location.origin + '/js/minified/test-data/test_emp_create_role_industries_data.json').then(function(e) {
                  return e.data.data
              })
          },
          getSubIndustries: function(r) {
              return a.get(e.StaticOptionsApi + "/industries/sub/" + r).then(function(e) {
                  return e.data.data
              })
          },
          getCountries: function(r) {
              
              // return a.get(e.StaticOptionsApi + "/countries").then(function(e) {
              return a.get(window.location.origin + '/js/minified/test-data/test_emp_create_role_countries_data.json').then(function(e) {
                  return e.data.data
              })
          },
          postData: function(r) {
              
              // return a.post(e.EmployerRootApi + "/job", r).then(function(e) {
              return a.post(window.location.origin + '/js/minified/test-data/test_emp_create_role_job_data.json').then(function(e) {
                  return e.data.data
              })
          }
      }
  }])
}();