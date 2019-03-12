! function() {
  "use strict";
  var e = angular.module("app");
  $("body").data("base_url");
  e.controller("CreateRoleNotifications", ["GlobalConstant", "$scope", "$window", "$http", "$cookies", "$filter", "$timeout", "$compile", "$sce", "EmployerRoleHttp", function(e, t, a, i, o, s, l, p, n, d) {
      t.roleId = t.$parent.$parent.objURL.id, t.role_create_tab_loader = 1, d.getData(t.roleId).then(function(a) {
          if (t.roleCreate = a, a && (t.role_create_tab_loader = 0), t.roleCreate_watch = t.roleCreate, t.notEnableNots = !1, t.roleCreate_watch.job_title = t.roleCreate.job_title, t.roleCreate.report_date) var s = new Date(t.roleCreate.report_date);
          else var s = new Date;
          var l = s.getFullYear(),
              p = s.getDate(),
              d = s.getMonth();
          t.roleDayPass = {
              label: p,
              value: p
          }, t.roleYrPass = {
              label: l,
              value: l
          }, t.roleCreate_watch.report_date = d + 1 + "/" + t.roleDayPass.value + "/" + t.roleYrPass.value, "visibility" in t.roleCreate_watch && (t.roleCreate_watch.visibility_members = t.roleCreate_watch.visibility.members, t.roleCreate_watch.visibility_teams = t.roleCreate_watch.visibility.teams), t.bucketStepNot1 = !1, t.bucketStepNot2 = !1, t.bucketStepNot3 = !1, t.bucketStepNot4 = !1, t.bucketStepNot5 = !1, t.bucketStepNot6 = !1, t.displayEmail1 = !0, t.displayEmail2 = !1, t.displayEmail3 = !1, t.displayEmail4 = !1, t.displayEmail5 = !1, t.displayEmail6 = !1, t.NotTimeframes = [{
              value: "daily",
              label: "Daily"
          }, {
              value: "weekly",
              label: "Weekly"
          }, {
              value: "every_new_candidate ",
              label: "Every new candidate"
          // }], i.get(e.EmployerRootApi + "/company").then(function(e) { // Uncomment for live API call
          }], i.get(window.location.origin + '/js/minified/test-data/test_emp_create_role_company_data.json').then(function(e) {
              console.log("company", e.data.data), t.companyDetails = e.data.data
          }), t.saveNotSettings = function(t) {
              console.log("this shet", t), $.ajax({
                  url: window.location.origin + '/js/minified/test-data/test_emp_create_role_email_settings_data.json',
                  method: "post",
                  data: t,
                  headers: {
                      Authorization: "Bearer " + o.get("token")
                  },
                  async: !1,
                  success: function(e) {
                      console.log(e)
                  }
              })
          }, i.get(window.location.origin + '/js/minified/test-data/test_emp_create_role_email_settings_data.json').then(function(a) {
              t.NotAdminList = a.data.data, console.log("prk", t.NotAdminList);
              for (var o = 0; o < t.NotTimeframes.length; o++) t.NotTimeframes[o].value == t.NotAdminList.new_candidates_coming_in && (t.candComing = t.NotTimeframes[o]);
              t.$watch("candComing", function(a, o) {
                  console.log(a.value, t.NotAdminList), t.NotAdminList.new_candidates_coming_in = a.value, t.saveNotSettings(t.NotAdminList);
                  // i.get(e.EmployerRootApi + "/email/template?item=1&type=" + t.NotAdminList.new_candidates_coming_in).then(function(e) {
                  i.get(window.location.origin + '/js/minified/test-data/test_emp_create_role_new_candidate_data.json').then(function(e) {
                      console.log("adm", e.data.data), t.adminDaily = e.data.data, t.adminDaily.template = n.trustAsHtml(t.adminDaily.template)
                  })
              }), t.$watch("NotAdminList.is_enabled", function(e, a) {
                  e != a && (console.log(t.NotAdminList), t.saveNotSettings(t.NotAdminList))
              }), t.$watch("NotAdminList.candidate_applications_enabled", function(a, o) {
                  a != o && (t.saveNotSettings(t.NotAdminList), i.get(window.location.origin + '/js/minified/test-data/test_emp_create_role_daily_data.json').then(function(e) {
                      t.adminDaily = e.data.data, t.adminDaily.template = n.trustAsHtml(t.adminDaily.template)
                  }))
              }), t.$watch("NotAdminList.new_candidates_coming_in_enabled", function(a, o) {
                  a != o && (t.saveNotSettings(t.NotAdminList), i.get(window.location.origin + '/js/minified/test-data/test_emp_create_role_daily_data.json').then(function(e) {
                      console.log("adm", e.data.data), t.adminDaily = e.data.data, t.adminDaily.template = n.trustAsHtml(t.adminDaily.template)
                  }))
              }), t.$watch("NotAdminList.role_expiry_warning", function(a, o) {
                  a != o && (t.saveNotSettings(t.NotAdminList), i.get(window.location.origin + '/js/minified/test-data/test_emp_create_role_daily_data.json').then(function(e) {
                      t.adminDaily = e.data.data, t.adminDaily.template = n.trustAsHtml(t.adminDaily.template)
                  }))
              }), t.$watch("NotAdminList.role_expired_from_public", function(a, o) {
                  a != o && (t.saveNotSettings(t.NotAdminList), i.get(window.location.origin + '/js/minified/test-data/test_emp_create_role_daily_data.json').then(function(e) {
                      t.adminDaily = e.data.data, t.adminDaily.template = n.trustAsHtml(t.adminDaily.template)
                  }))
              }), t.$watch("NotAdminList.analytics_available", function(a, o) {
                  a != o && (t.saveNotSettings(t.NotAdminList), i.get(window.location.origin + '/js/minified/test-data/test_emp_create_role_daily_data.json').then(function(e) {
                      t.adminDaily = e.data.data, t.adminDaily.template = n.trustAsHtml(t.adminDaily.template)
                  }))
              }), t.$watch("NotAdminList.processing_expiry_warning", function(a, o) {
                  a != o && (t.saveNotSettings(t.NotAdminList), i.get(window.location.origin + '/js/minified/test-data/test_emp_create_role_daily_data.json').then(function(e) {
                      t.adminDaily = e.data.data, t.adminDaily.template = n.trustAsHtml(t.adminDaily.template)
                  }))
              }), t.$watch("NotAdminList.processing_has_expired", function(a, o) {
                  a != o && (t.saveNotSettings(t.NotAdminList), i.get(window.location.origin + '/js/minified/test-data/test_emp_create_role_daily_data.json').then(function(e) {
                      t.adminDaily = e.data.data, t.adminDaily.template = n.trustAsHtml(t.adminDaily.template)
                  }))
              }), t.$watch("NotAdminList.final_analytics_available", function(a, o) {
                  a != o && (t.saveNotSettings(t.NotAdminList), i.get(window.location.origin + '/js/minified/test-data/test_emp_create_role_daily_data.json').then(function(e) {
                      t.adminDaily = e.data.data, t.adminDaily.template = n.trustAsHtml(t.adminDaily.template)
                  }))
              })
          }), i.get(window.location.origin + '/js/minified/test-data/test_emp_create_role_daily_data.json').then(function(a) {
              console.log("jobid", t.roleCreate.id), t.NotCandidateTempList = a.data.data, console.log("prk2", t.NotCandidateTempList);
              t.setDisplay = function(e) {
                  1 == e ? (t.bucketStepNot1 = !t.bucketStepNot1, t.displayEmail1 = !0, t.displayEmail2 = !1, t.displayEmail3 = !1, t.displayEmail4 = !1, t.displayEmail5 = !1, t.displayEmail6 = !1) : 2 == e ? (t.bucketStepNot2 = !t.bucketStepNot2, t.displayEmail1 = !1, t.displayEmail2 = !0, t.displayEmail3 = !1, t.displayEmail4 = !1, t.displayEmail5 = !1, t.displayEmail6 = !1) : 3 == e ? (t.bucketStepNot3 = !t.bucketStepNot3, t.displayEmail1 = !1, t.displayEmail2 = !1, t.displayEmail3 = !0, t.displayEmail4 = !1, t.displayEmail5 = !1, t.displayEmail6 = !1) : 4 == e ? (t.bucketStepNot4 = !t.bucketStepNot4, t.displayEmail1 = !1, t.displayEmail2 = !1, t.displayEmail3 = !1, t.displayEmail4 = !0, t.displayEmail5 = !1, t.displayEmail6 = !1) : 5 == e ? (t.bucketStepNot5 = !t.bucketStepNot5, t.displayEmail1 = !1, t.displayEmail2 = !1, t.displayEmail3 = !1, t.displayEmail4 = !1, t.displayEmail5 = !0, t.displayEmail6 = !1) : 6 == e && (t.bucketStepNot6 = !t.bucketStepNot6, t.displayEmail1 = !1, t.displayEmail2 = !1, t.displayEmail3 = !1, t.displayEmail4 = !1, t.displayEmail5 = !1, t.displayEmail6 = !0)
              }, t.replacePs = function() {
                  t.appReceivedSubj = t.NotCandidateTempList.application_received.body, t.appReceivedSubj = t.appReceivedSubj.replace(/\r?\n|\r/g, "<br>"), t.appReceivedSubj = n.trustAsHtml(t.appReceivedSubj), t.NotCandidateTempList.application_received.body = t.NotCandidateTempList.application_received.body.replace(new RegExp("<p>", "g"), ""), t.NotCandidateTempList.application_received.body = t.NotCandidateTempList.application_received.body.replace(new RegExp("</p>", "g"), ""), t.NotCandidateTempList.application_received.body = t.NotCandidateTempList.application_received.body.replace(new RegExp("<br>", "g"), "\n"), t.appInterviewSubj = t.NotCandidateTempList.interview_from_any.body, t.appInterviewSubj = t.appInterviewSubj.replace(/\r?\n|\r/g, "<br>"), t.appInterviewSubj = n.trustAsHtml(t.appInterviewSubj), t.NotCandidateTempList.interview_from_any.body = t.NotCandidateTempList.interview_from_any.body.replace(new RegExp("<p>", "g"), ""), t.NotCandidateTempList.interview_from_any.body = t.NotCandidateTempList.interview_from_any.body.replace(new RegExp("</p>", "g"), ""), t.NotCandidateTempList.interview_from_any.body = t.NotCandidateTempList.interview_from_any.body.replace(new RegExp("<br>", "g"), "\n"), t.appLonglistSubj = t.NotCandidateTempList.long_list_to_short_list.body, t.appLonglistSubj = t.appLonglistSubj.replace(/\r?\n|\r/g, "<br>"), t.appLonglistSubj = n.trustAsHtml(t.appLonglistSubj), t.NotCandidateTempList.long_list_to_short_list.body = t.NotCandidateTempList.long_list_to_short_list.body.replace(new RegExp("<p>", "g"), ""), t.NotCandidateTempList.long_list_to_short_list.body = t.NotCandidateTempList.long_list_to_short_list.body.replace(new RegExp("</p>", "g"), ""), t.NotCandidateTempList.long_list_to_short_list.body = t.NotCandidateTempList.long_list_to_short_list.body.replace(new RegExp("<br>", "g"), "\n"), t.appShortSubj = t.NotCandidateTempList.short_list_to_interview.body, t.appShortSubj = t.appShortSubj.replace(/\r?\n|\r/g, "<br>"), t.appShortSubj = n.trustAsHtml(t.appShortSubj), t.NotCandidateTempList.short_list_to_interview.body = t.NotCandidateTempList.short_list_to_interview.body.replace(new RegExp("<p>", "g"), ""), t.NotCandidateTempList.short_list_to_interview.body = t.NotCandidateTempList.short_list_to_interview.body.replace(new RegExp("</p>", "g"), ""), t.NotCandidateTempList.short_list_to_interview.body = t.NotCandidateTempList.short_list_to_interview.body.replace(new RegExp("<br>", "g"), "\n"), t.appSuccessSubj = t.NotCandidateTempList.successful_employed.body, t.appSuccessSubj = t.appSuccessSubj.replace(/\r?\n|\r/g, "<br>"), t.appSuccessSubj = n.trustAsHtml(t.appSuccessSubj), t.NotCandidateTempList.successful_employed.body = t.NotCandidateTempList.successful_employed.body.replace(new RegExp("<p>", "g"), ""), t.NotCandidateTempList.successful_employed.body = t.NotCandidateTempList.successful_employed.body.replace(new RegExp("</p>", "g"), ""), t.NotCandidateTempList.successful_employed.body = t.NotCandidateTempList.successful_employed.body.replace(new RegExp("<br>", "g"), "\n"), t.appUnsuccessSubj = t.NotCandidateTempList.unsuccessful_application.body, t.appUnsuccessSubj = t.appUnsuccessSubj.replace(/\r?\n|\r/g, "<br>"), t.appUnsuccessSubj = n.trustAsHtml(t.appUnsuccessSubj), t.NotCandidateTempList.unsuccessful_application.body = t.NotCandidateTempList.unsuccessful_application.body.replace(new RegExp("<p>", "g"), ""), t.NotCandidateTempList.unsuccessful_application.body = t.NotCandidateTempList.unsuccessful_application.body.replace(new RegExp("</p>", "g"), ""), t.NotCandidateTempList.unsuccessful_application.body = t.NotCandidateTempList.unsuccessful_application.body.replace(new RegExp("<br>", "g"), "\n"), t.NotCandidateTempList.application_received.subject = t.NotCandidateTempList.application_received.subject.replace(new RegExp("<p>", "g"), ""), t.NotCandidateTempList.application_received.subject = t.NotCandidateTempList.application_received.subject.replace(new RegExp("</p>", "g"), ""), t.NotCandidateTempList.interview_from_any.subject = t.NotCandidateTempList.interview_from_any.subject.replace(new RegExp("<p>", "g"), ""), t.NotCandidateTempList.interview_from_any.subject = t.NotCandidateTempList.interview_from_any.subject.replace(new RegExp("</p>", "g"), ""), t.NotCandidateTempList.long_list_to_short_list.subject = t.NotCandidateTempList.long_list_to_short_list.subject.replace(new RegExp("<p>", "g"), ""), t.NotCandidateTempList.long_list_to_short_list.subject = t.NotCandidateTempList.long_list_to_short_list.subject.replace(new RegExp("</p>", "g"), ""), t.NotCandidateTempList.short_list_to_interview.subject = t.NotCandidateTempList.short_list_to_interview.subject.replace(new RegExp("<p>", "g"), ""), t.NotCandidateTempList.short_list_to_interview.subject = t.NotCandidateTempList.short_list_to_interview.subject.replace(new RegExp("</p>", "g"), ""), t.NotCandidateTempList.successful_employed.subject = t.NotCandidateTempList.successful_employed.subject.replace(new RegExp("<p>", "g"), ""), t.NotCandidateTempList.successful_employed.subject = t.NotCandidateTempList.successful_employed.subject.replace(new RegExp("</p>", "g"), ""), t.NotCandidateTempList.long_list_to_short_list.subject = t.NotCandidateTempList.long_list_to_short_list.subject.replace(new RegExp("<p>", "g"), ""), t.NotCandidateTempList.long_list_to_short_list.subject = t.NotCandidateTempList.long_list_to_short_list.subject.replace(new RegExp("</p>", "g"), ""), t.NotCandidateTempList.unsuccessful_application.subject = t.NotCandidateTempList.unsuccessful_application.subject.replace(new RegExp("<p>", "g"), ""), t.NotCandidateTempList.unsuccessful_application.subject = t.NotCandidateTempList.unsuccessful_application.subject.replace(new RegExp("</p>", "g"), "")
              }, t.replacePs(), console.log("no p", t.NotCandidateTempList), console.log("dud", t.NotCandidateTempList), t.saveNotTemplateSettings = function(a, i) {
                  console.log("dudwhut", t.NotCandidateTempList), console.log(a, i), a.item = i, a.body = "<p>" + a.body + "</p>", a.subject = "<p>" + a.subject + "</p>", t.appReceivedSubj = t.NotCandidateTempList.application_received.body, t.appReceivedSubj = t.appReceivedSubj.replace(/\r?\n|\r/g, "<br>"), t.appReceivedSubj = n.trustAsHtml(t.appReceivedSubj), console.log("done", a), $.ajax({
                      url: e.EmployerRootApi + "/email/template/candidate/" + t.roleCreate.id,
                      method: "post",
                      data: a,
                      headers: {
                          Authorization: "Bearer " + o.get("token")
                      },
                      async: !1,
                      success: function(e) {
                          console.log(e), t.replacePs()
                      }
                  })
              }
          })
      })
  }])
}();