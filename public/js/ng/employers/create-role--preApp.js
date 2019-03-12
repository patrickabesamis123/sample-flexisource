! function() {
  "use strict";
  var e = angular.module("app");
  $("body").data("base_url");
  e.controller("CreateRolePreApp", ["GlobalConstant", "$scope", "$window", "$http", "$cookies", "$filter", "$timeout", "$compile", "PreAppRoleHttp", function(e, o, a, s, t, l, n, r, i) {
      
      o.role_create_tab_loader = 1, o.roleId = o.$parent.$parent.objURL.id, o.roleId || (o.roleId = t.get("jobObjectId")), o.loading_insp = !1, o.levels = ["yes", "developing", "no"], o.workPerms = ["Citizenship", "Permanent residence", "Visa"], o.GPAList = [{
          value: 11,
          label: "A+"
      }, {
          value: 10,
          label: "A"
      }, {
          value: 9,
          label: "A-"
      }, {
          value: 8,
          label: "B+"
      }, {
          value: 7,
          label: "B"
      }, {
          value: 6,
          label: "B-"
      }, {
          value: 5,
          label: "C+"
      }, {
          value: 4,
          label: "C"
      }, {
          value: 3,
          label: "C-"
      }, {
          value: 2,
          label: "D"
      }, {
          value: 1,
          label: "E"
      }, {
          value: 0,
          label: "F"
      }], o.GPAListToSel = [], o.Skillrange = [{
          value: 1,
          label: "1"
      }, {
          value: 2,
          label: "2"
      }, {
          value: 3,
          label: "3"
      }, {
          value: 4,
          label: "4"
      }, {
          value: 5,
          label: "5"
      }, {
          value: 6,
          label: "6"
      }, {
          value: 7,
          label: "7"
      }, {
          value: 8,
          label: "8"
      }, {
          value: 9,
          label: "9"
      }, {
          value: 10,
          label: "10"
      }], o.skillLevel = [], o.reqForAppsSel = [], o.requiredAnsSel = [], o.reqDocsSel = [], o.workPermSel = [], o.beSpokeMyList = [], o.requiredAns = [{
          label: "text"
      }], o.isTextGPA = !1, o.roleCreate_watch = {
          job_title: "",
          role_type: "",
          working_days: [],
          min_salary: 0,
          max_salary: 0,
          start_time: "",
          finish_time: "",
          flexible_hours: !1,
          industry: 0,
          min_experience: 0,
          max_experience: 0,
          is_salary_public: !1,
          location: {
              country_id: 0,
              location: ""
          },
          lead_manage_team: !1,
          role_duration: 0,
          salary_type: "",
          job_reason: "",
          job_meta: {},
          job_video_url: "",
          benefits: [],
          application_requirements: {
              about_me: "",
              education: "",
              icebreaker_video: "",
              phone_number: "",
              portfolio: "",
              profile_image: "",
              references: "",
              resume: "",
              work_experience: "",
              cv: "",
              cover_letter: ""
          },
          requirements: [],
          accountabilities: [],
          objectives: [],
          questions: {
              pre_apply: [],
              application: []
          },
          search_helpers: {
              above_salary_band: "",
              flexible_working: "",
              high_potential_less_experience: "",
              part_time: ""
          }
      // Uncomment for live API call
      // }, o.PreApprovalQuestions = [], s.get(e.EmployerRootApi + "/company").then(function(e) {
      }, o.PreApprovalQuestions = [], s.get(window.location.origin + '/js/minified/test-data/test_emp_create_role_company_data.json').then(function(e) {
          o.companyDetails = e.data.data
      }), i.getData(o.roleId).then(function(a) {
          if (o.roleCreate = a, a && (o.role_create_tab_loader = 0), o.roleCreate_watch = o.roleCreate, o.roleCreate.report_date) var t = new Date(o.roleCreate.report_date);
          else var t = new Date;
          var l = t.getFullYear(),
              n = t.getDate(),
              r = t.getMonth();
          o.roleDayPass = {
              label: n,
              value: n
          }, o.roleYrPass = {
              label: l,
              value: l
          }, o.roleCreate_watch.report_date = r + 1 + "/" + o.roleDayPass.value + "/" + o.roleYrPass.value, "visibility" in o.roleCreate_watch && (o.roleCreate_watch.visibility_members = o.roleCreate_watch.visibility.members, o.roleCreate_watch.visibility_teams = o.roleCreate_watch.visibility.teams), s.get(window.location.origin + '/js/minified/test-data/test_emp_create_role_pre_application_data.json').then(function(e) { // Uncoment for live API call // s.get(e.EmployerRootApi + "/suggestions/" + o.roleId + "/pre_application_question").then(function(e) {
              o.preInspirationList = e.data.data, o.pushInspirationPre = function(e) {
                  var a = o.preInspirationList.indexOf(e),
                      s = [];
                  o.preInspirationList.splice(a, 1), s.push(o.levels);
                  var t = {
                      question: e.name,
                      ideal_answer: ["yes"],
                      deciding_factor_type: "",
                      decides_outcome: !1,
                      choices: s,
                      type: "basic"
                  };
                  o.PreApprovalQuestions.push(t), o.applyColor(), o.roleCreate_watch.questions.pre_apply = o.PreApprovalQuestions
              }
          }), o.shuffle_preapp = function() {
              console.log("HOLY SHIT"), o.loading_insp = !0, i.getShuffled(o.roleId).then(function(e) {
                  console.log("PRE APP SHAPOL: ", o.roleId, e), o.preInspirationList = e.data, o.loading_insp = !1
              })
          }, o.roleCreate_watch.questions.pre_apply.length <= 0 ? ("1" == o.roleCreate_watch.job_meta.lead_manage_team && angular.forEach(o.roleCreate_watch.requirements, function(e, a) {
              if ("Primary" == e.type_display_name) var s = "yes";
              else var s = "no";
              var t = [];
              t.push(o.levels);
              var l = {
                  question: e.name,
                  ideal_answer: [s],
                  deciding_factor_type: "",
                  decides_outcome: !1,
                  choices: t,
                  type: "basic"
              };
              o.PreApprovalQuestions.push(l)
          }), console.log("gea", o.PreApprovalQuestions), o.roleCreate_watch.questions.pre_apply = o.PreApprovalQuestions) : o.PreApprovalQuestions = o.roleCreate_watch.questions.pre_apply, angular.forEach(o.PreApprovalQuestions, function(e, a) {
              var s = o.PreApprovalQuestions[a].id;
              if ("custom_pre_apply_2" == e.type && (e.slider = {
                      min: e.ideal_answer[0] ? e.ideal_answer[0] : 0,
                      max: 10,
                      options: {
                          floor: 0,
                          ceil: 10,
                          id: e.id,
                          onEnd: function(e, a, s, t) {
                              o.preapp_slider_func(e, a, s, t)
                          }
                      }
                  }), "sub_questions" in o.PreApprovalQuestions[a] && (o.PreApprovalQuestions[a].condition = !0, 0 == o.PreApprovalQuestions[a].condition || angular.forEach(o.PreApprovalQuestions[a].sub_questions, function(s, t) {
                      if ("custom_pre_apply_2_sub" != s.type) {
                          o.PreApprovalQuestions[a].sub_questions[t].ideal_answer = [], o.PreApprovalQuestions[a].sub_questions[t].mychoices = [];
                          for (var l = 0; l < o.PreApprovalQuestions[a].sub_questions[t].choices.length; l++) o.PreApprovalQuestions[a].sub_questions[t].mychoices.push({
                              label: o.PreApprovalQuestions[a].sub_questions[t].choices[l],
                              appear: !0
                          });
                          for (var l = 0; l < o.PreApprovalQuestions[a].sub_questions[t].ideal_answer.length; l++) o.PreApprovalQuestions[a].sub_questions[t].choices.indexOf(o.PreApprovalQuestions[a].sub_questions[t].ideal_answer[l]) > -1 && o.PreApprovalQuestions[a].sub_questions[t].ideal_answerR.push({
                              label: o.PreApprovalQuestions[a].sub_questions[t].ideal_answer[l]
                          })
                      }
                      "custom_pre_apply_2_sub" == s.type && (s.slider = {
                          min: s.ideal_answer[0] ? s.ideal_answer[0] : 0,
                          max: 10,
                          options: {
                              floor: 0,
                              ceil: 10,
                              id: s.id,
                              onEnd: function(a, s, t, l) {
                                  o.preapp_slider_func_sub(a, s, t, l, e.id)
                              }
                          }
                      })
                  }), console.log(6, o.PreApprovalQuestions)), "gpa" != o.PreApprovalQuestions[a].type || "custom_pre_apply_1" != o.PreApprovalQuestions[a].type) {
                  o.PreApprovalQuestions[a].GPAval = [], o.PreApprovalQuestions[a].GPAval = o.PreApprovalQuestions[a].ideal_answer[0], console.log("first load", o.PreApprovalQuestions[a].ideal_answer);
                  var t = "PreApprovalQuestions[" + a + "].ideal_answer";
                  o.$watchCollection(t, function(e, s) {
                      console.log("now you see meee ", s, e), e && (e.indexOf("yes") > -1 ? (o.levelYes = !0, o.PreApprovalQuestions[a].levelYes = !0) : (o.levelYes = !1, o.PreApprovalQuestions[a].levelYes = !1), e.indexOf("developing") > -1 ? (o.levelDev = !0, o.PreApprovalQuestions[a].levelDev = !0) : (o.levelDev = !1, o.PreApprovalQuestions[a].levelDev = !1), e.indexOf("no") > -1 ? (o.levelNo = !0, o.PreApprovalQuestions[a].levelNo = !0) : (o.levelNo = !1, o.PreApprovalQuestions[a].levelNo = !1))
                  }), angular.forEach(o.GPAList, function(e, s) {
                      o.GPAList[s].value == o.PreApprovalQuestions[a].ideal_answer[0] && (o.PreApprovalQuestions[a].GPAval = e.value)
                  }), o.GPAListToSel[s] = o.PreApprovalQuestions[a].ideal_answer
              }
          }), o.changeGPA = function(e, a) {
              console.log(e), o.PreApprovalQuestions[a].GPAval = e, o.PreApprovalQuestions[a].ideal_answer = [], o.PreApprovalQuestions[a].ideal_answer.push(o.PreApprovalQuestions[a].GPAval), console.log(o.PreApprovalQuestions[a].ideal_answer, 888)
          }, o.addBlankPreApp = function() {
              var e = [];
              e.push(o.levels);
              var a = {
                  question: "",
                  type: "basic",
                  choices: e,
                  decides_outcome: !1,
                  ideal_answer: ["yes"],
                  deciding_factor_type: ""
              };
              o.PreApprovalQuestions.push(a), o.applyColor(), console.log("what am i add", o.PreApprovalQuestions)
          }, o.deleteQuestion = function(e) {
              console.log("delete pre app: ", e), console.log(o.PreApprovalQuestions), console.log(o.PreApprovalQuestions.indexOf(e));
              var a = o.PreApprovalQuestions.indexOf(e);
              o.PreApprovalQuestions.splice(a, 1)
          }, o.applyColor = function() {
              o.PreApprovalQuestions.length > 0 && angular.forEach(o.PreApprovalQuestions, function(e, a) {
                  var s = "PreApprovalQuestions[" + a + "].ideal_answer";
                  o.$watchCollection(s, function(e, s) {
                      e && (e.indexOf("yes") > -1 ? (o.levelYes = !0, o.PreApprovalQuestions[a].levelYes = !0) : (o.levelYes = !1, o.PreApprovalQuestions[a].levelYes = !1), e.indexOf("developing") > -1 ? (o.levelDev = !0, o.PreApprovalQuestions[a].levelDev = !0) : (o.levelDev = !1, o.PreApprovalQuestions[a].levelDev = !1), e.indexOf("no") > -1 ? (o.levelNo = !0, o.PreApprovalQuestions[a].levelNo = !0) : (o.levelNo = !1, o.PreApprovalQuestions[a].levelNo = !1))
                  })
              })
          }, o.applyColor(), o.roleCreate_watch.job_title = o.roleCreate.job_title, o.$parent.$parent.empRoleMain = o.roleCreate_watch, console.log("RES : ", o.roleCreate)
      }), o.preapp_slider_func = function(e, a, s, t) {
          console.log("Proficiency id: ", e), console.log("Proficiency value: ", a), console.log("tae ", o.PreApprovalQuestions), angular.forEach(o.PreApprovalQuestions, function(o, s) {
              console.log("parse ids: ", o.id, e), o.id == e && (o.ideal_answer[0] = a, o.choices = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10], console.log("inserted: ", o))
          }), console.log("mother scope: ", o.PreApprovalQuestions)
      }, o.preapp_slider_func_sub = function(e, a, s, t, l) {
          console.log("Proficiency id sub: ", e), console.log("Proficiency value sub: ", a), console.log("Parent key sub: ", l), angular.forEach(o.PreApprovalQuestions, function(o, s) {
              o.id == l && angular.forEach(o.sub_questions, function(o, s) {
                  console.log("SUB QUESTIONS: ", o.id, e), o.id == e && (o.ideal_answer[0] = a, o.choices = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10])
              })
          }), console.log("sub scope: ", o.PreApprovalQuestions)
      }, o.closeBeSpoke = function(e) {
          o.beSpokeTagList[e].beSpokeUniqueShow = !1
      }, o.pushBespoke = function(e) {
          console.log("PUSHED BSPOKE: ", e);
          var a = o.beSpokeTagList.indexOf(e);
          if (e.question_data.choices = [], 1 == e.beSpokeUnique) o.beSpokeTagList[a].beSpokeUniqueShow = !0;
          else {
              if (e.question_data.choices = [], "Do you want to know candidate's GPA?" == e.tag_label) {
                  e.q = "GPA", e.question_data.answer_type = "gpa", e.question_data.type = "gpa", e.question_data.answer_label = "Set your preferred minimum GPA", angular.forEach(o.GPAList, function(o, a) {
                      o.value == e.question_data.ideal_answer && (e.question_data.GPAval = [], e.question_data.GPAval.push(o.value))
                  });
                  for (var s = 0; s < o.GPAList.length; s++) {
                      for (var t = 0; t < e.question_data.ideal_answer.length; t++)
                          if (o.GPAList[s].value == e.question_data.ideal_answer[t]) {
                              e.question_data.GPAval = o.GPAList[s].value;
                              break
                          }
                      e.question_data.choices.push(o.GPAList[s].value)
                  }
                  angular.forEach(e.question_data.sub_questions, function(a, s) {
                      e.question_data.sub_questions[s].choices = [];
                      for (var t = 0; t < o.requiredAns.length; t++) e.question_data.sub_questions[s].choices.push(o.requiredAns[t].label);
                      e.question_data.sub_questions[s].ideal_answerR = [], e.question_data.sub_questions[s].mychoices = [];
                      for (var l = 0; l < e.question_data.sub_questions[s].choices.length; l++) e.question_data.sub_questions[s].mychoices.push({
                          label: e.question_data.sub_questions[s].choices[l],
                          appear: !0
                      });
                      for (var l = 0; l < e.question_data.sub_questions[s].ideal_answer.length; l++) "yes" == e.question_data.sub_questions[s].ideal_answer[l] && "basic" != e.question_data.type && (e.question_data.sub_questions[s].ideal_answer[l] = "text", console.log(5555, e.question_data.sub_questions[s].ideal_answer[l])), e.question_data.sub_questions[s].choices.indexOf(e.question_data.sub_questions[s].ideal_answer[l]) > -1 && e.question_data.sub_questions[s].ideal_answerR.push({
                          label: e.question_data.sub_questions[s].ideal_answer[l]
                      })
                  })
              } else if ("Explore communication skills?" == e.tag_label) {
                  e.q = "Comm Skills";
                  for (var s = 0; s < o.Skillrange.length; s++)
                      if (o.Skillrange[s].value == e.question_data.ideal_answer) {
                          o.SkillrangeItemSel = o.Skillrange[s];
                          break
                      }
              } else e.question_data.answer_label = "";
              e.question_data.condition = !1, e.question_data.type = e.question_data.answer_type, console.log("itemd", e), o.beSpokeTagList[a].beSpokeUnique = !0, o.beSpokeTagList[a].beSpokeUniqueShow = !1, e.question_data.decides_outcome_label = e.decides_outcome_label, o.PreApprovalQuestions.push(e.question_data), angular.forEach(o.PreApprovalQuestions, function(e, a) {
                  var s = "PreApprovalQuestions[" + a + "].condition";
                  o.$watch(s, function(e, s) {
                      console.log("cond", e), o.PreApprovalQuestions[a].GPAsub = !1, e != s && (o.PreApprovalQuestions[a].GPAsub = !!e, console.log("preapp no gpa sub", o.PreApprovalQuestions))
                  })
              })
          }
          console.log(o.beSpokeTagList, 8881)
      }, o.checkMyBack = function() {
          console.log("CHECK My Back"), o.roleCreate_watch.questions.pre_apply = o.PreApprovalQuestions, console.log(888, o.roleCreate_watch.questions.pre_apply), angular.forEach(o.roleCreate_watch.questions.pre_apply, function(e, a) {
              if ("deciding_factor_type" in o.roleCreate_watch.questions.pre_apply[a] || (o.roleCreate_watch.questions.pre_apply[a].deciding_factor_type = ""), !("sub_questions" in o.roleCreate_watch.questions.pre_apply[a])) {
                  o.roleCreate_watch.questions.pre_apply[a].GPAval, o.roleCreate_watch.questions.pre_apply[a].answer_label, o.roleCreate_watch.questions.pre_apply[a].answer_type, o.roleCreate_watch.questions.pre_apply[a].choices, o.roleCreate_watch.questions.pre_apply[a].condition, o.roleCreate_watch.questions.pre_apply[a].decides_outcome, o.roleCreate_watch.questions.pre_apply[a].deciding_factor_type, o.roleCreate_watch.questions.pre_apply[a].ideal_answer, o.roleCreate_watch.questions.pre_apply[a].levelDev, o.roleCreate_watch.questions.pre_apply[a].levelYes, o.roleCreate_watch.questions.pre_apply[a].levelNo, o.roleCreate_watch.questions.pre_apply[a].question, o.roleCreate_watch.questions.pre_apply[a].type;
                  angular.forEach(o.roleCreate_watch.questions.pre_apply[a].sub_questions, function(e, s) {
                      console.log(8, o.roleCreate_watch.questions.pre_apply), o.roleCreate_watch.questions.pre_apply[a].sub_questions[a].ideal_answer = [], angular.forEach(o.roleCreate_watch.questions.pre_apply[a].sub_questions[a].ideal_answer, function(e, s) {
                          o.roleCreate_watch.questions.pre_apply[a].sub_questions[a].ideal_answer.push(o.roleCreate_watch.questions.pre_apply[a].sub_questions[a].ideal_answer[s].label)
                      })
                  })
              }
          }), o.$parent.$parent.empRoleMain = o.roleCreate_watch, console.log("update pre-app", o.roleCreate_watch.questions.pre_apply)
          // Uncomment for live API  // }, o.checkMyBack(), o.PreAppOptions = [], s.get(e.EmployerRootApi + "/job/" + o.roleId + "/questions/pre-apply/bespoke").then(function(e) {
          }, o.checkMyBack(), o.PreAppOptions = [], s.get(window.location.origin + '/js/minified/test-data/test_emp_create_role_bespoke_data.json').then(function(e) {
          o.beSpokeTagList = e.data.data, console.log("GET BSPOKE LIST: ", o.beSpokeTagList), angular.forEach(o.beSpokeTagList, function(e, a) {
              if (o.beSpokeTagList[a].beSpokeUnique = !1, o.beSpokeTagList[a].beSpokeUniqueShow = !1, "custom_pre_apply_2" == e.question_data.answer_type) {
                  e.question_data.id = a, e.question_data.slider = {
                      min: e.question_data.ideal_answer[0],
                      max: 10,
                      options: {
                          floor: 0,
                          ceil: 10,
                          id: a,
                          onEnd: function(e, a, s, t) {
                              o.preapp_slider_func(e, a, s, t)
                          }
                      }
                  };
                  var s = a;
                  console.log("PARENT KEYSSS: ", s)
              }
              e.question_data.sub_questions.length > 0 && angular.forEach(e.question_data.sub_questions, function(e, s) {
                  console.log("LANG SUB: ", e), "custom_pre_apply_2_sub" == e.answer_type && (e.id = s, e.choices = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10], e.slider = {
                      min: e.ideal_answer[0],
                      max: 10,
                      options: {
                          floor: 0,
                          ceil: 10,
                          id: s,
                          onEnd: function(e, s, t, l) {
                              o.preapp_slider_func_sub(e, s, t, l, a)
                          }
                      }
                  }, console.log("KING INA: ", e))
              }), console.log("BSPOKE ID: ", a)
          })
      }), o.removeFromMyList = function(e) {
          var a = o.beSpokeMyList.indexOf(e);
          o.beSpokeMyList.splice(a, 1), o.beSpokeTagList.push(e)
      }
  }]), e.factory("PreAppRoleHttp", ["GlobalConstant", "$http", function(e, o) {
      return {
          getShuffled: function(a) {
              return console.log("getShuffled: ", a), o.get(window.location.origin + '/js/minified/test-data/test_emp_create_role_pre_application_data.json').then(function(e) {
                  return e.data.data
              })
          },
          getData: function(a) {
              // return o.get(e.EmployerRootApi + "/job/" + a).then(function(e) { // Uncomment for live API call
              return o.get(window.location.origin + '/js/minified/test-data/test_emp_create_role_job_data.json').then(function(e) {
                  return e.data.data
              })
          },
          getIndustries: function() {
              // Uncomment for live API
              // return o.get(e.StaticOptionsApi + "/industries").then(function(e) {
              return o.get(window.location.origin + '/js/minified/test-data/test_emp_create_role_industries_data.json').then(function(e) {
                  return e.data.data
              })
          },
          getSubIndustries: function(a) {
              return o.get(e.StaticOptionsApi + "/industries/sub/" + a).then(function(e) {
                  return e.data.data
              })
          },
          getCountries: function(a) {
              // Uncomment for live API
              // return o.get(e.StaticOptionsApi + "/countries").then(function(e) {
              return o.get(window.location.origin + '/js/minified/test-data/test_emp_create_role_countries_data.json').then(function(e) {
                  return e.data.data
              })
          },
          postData: function(a) {
              return o.post(e.EmployerRootApi + "/job", a).then(function(e) {
                  return e.data.data
              })
          }
      }
  }])
}();