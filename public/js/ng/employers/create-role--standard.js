! function() {
  "use strict";
  var e = angular.module("app");
  $("body").data("base_url");
  e.controller("CreateRoleStandard", ["GlobalConstant", "$scope", "$window", "$http", "$cookies", "$filter", "$timeout", "$compile", "EmployerRoleHttp", "fileUploadService", "MultiVideoTracker", "StandardQuestionSvcs", function(e, t, o, a, n, i, r, s, l, c, d, p) {
      function u() {
          angular.forEach(t.roleCreate_watch.questions.application, function(e, o) {
              var a = n.getObject("empsq");
              if (console.log("video doc: empty? ", e), e.video_document.doc_url) console.log("parsing already uploaded videos ", e.id), e.video_document.VideoStatus = "", t.renderVideo(e.video_document.doc_url, e.id);
              else if (console.log("parsing newly uploaded videos ", e.id), a)
                  for (var i = 0; i < JSON.parse(a).length; i++) JSON.parse(a)[i].qid == e.id && (e.video_document.encoding_progress = 0, e.video_document.encoding_job_status = "", e.video_document.VideoStatus = "uploading", e.video_document.doc_guid = JSON.parse(a)[i].qguid, _(e.video_document, e.id))
          }), console.log("done parsing all questions")
      }

      function _(e, o) {
          var a = e.doc_guid;
          d.getVideoStatus(a).then(function(a) {
              "processing_completed" != a.video_status ? (e.encoding_progress = a.encoding_progress ? a.encoding_progress : 0, e.encoding_job_status = a.encoding_job_status ? a.encoding_job_status : "Preparing..", _(e, o)) : (e.VideoStatus = "", t.renderVideo(a.streaming_url, o))
          })
      }
      t.role_create_tab_loader = 1, t.player_arr = [], t.levels = ["yes", "no"], t.$on("$destroy", function() {
          angular.forEach(t.player_arr, function(e, t) {
              e.myPlayer.dispose()
          })
      });
      var h = null;
      t.sq_guid = [], t.roleId = t.$parent.$parent.objURL.id, t.roleId || (t.roleId = n.get("jobObjectId")), t.renderVideo = function(e, o) {
          var a = "vid_container_" + o;
          document.getElementById(a), document.getElementById("vid_outercon_" + o);
          r(function() {
              h = amp(a, {
                  nativeControlsForTouch: !1,
                  autoplay: !1,
                  controls: !0,
                  width: "100%",
                  logo: {
                      enabled: !1
                  },
                  poster: ""
              }, function() {
                  console.log("video ready")
              }), t.player_arr.push({
                  id: o,
                  myPlayer: h
              }), angular.forEach(t.player_arr, function(t, a) {
                  t.id == o && t.myPlayer.src([{
                      src: e,
                      type: "application/vnd.ms-sstr+xml"
                  }])
              }), h = null
          }, 500)
      }, t.$watch("guid_response_sq_emp", function(e, o) {
          console.log("guid_response_sq_emp", e), e && angular.forEach(t.roleCreate_watch.questions.application, function(o, a) {
              if (o.id == e.question_id) {
                  o.video_document = e.video_document;
                  var i = n.getObject("empsq");
                  console.log("Stored Cookie: ", i), n.remove("empsq"), t.sq_guid.push({
                      qid: e.question_id,
                      qguid: e.video_document.doc_guid
                  }), n.putObject("empsq", JSON.stringify(t.sq_guid)), o.video_document.encoding_progress = 0, o.video_document.encoding_job_status = "", o.video_document.VideoStatus = "uploading", o.video_document.doc_guid = e.video_document.doc_guid, _(o.video_document, e.question_id)
              }
          })
      }), // a.get(e.EmployerRootApi + "/company").then(function(e) { // Uncomment for live API call
          a.get(window.location.origin + '/js/minified/test-data/test_emp_create_role_company_data.json').then(function(e) {
          t.companyDetails = e.data.data
      }), t.showVideoTop = !1, t.showVideoLoding = !0, t.openVideoModal = function(e, o) {
          if (e.id) t.$parent.$parent.singlesq_ref_docId = e.id, $("#pmvCameraModalNew").modal("show");
          else {
              var a = {
                  data: e
              };
              a.data.question && "" != a.data.question || (a.data.question = "(Kindly refer to the video)"), 0 != a.data.answer_type.length && a.data.answer_type || (a.data.answer_type = ["free_text"]), console.log("openVideoModal: ", a), p.postAplicationQ(t.roleId, a).then(function(e) {
                  e && (console.log("SQ SAVED after video: ", e), t.roleCreate_watch.questions.application[o].id = e.id, t.$parent.$parent.singlesq_ref_docId = e.id, $("#pmvCameraModalNew").modal("show"))
              })
          }
      }, t.uploadReference = function(e, o) {
          if (o.id) t.$parent.$parent.fieldIndex = e, t.$parent.$parent.StandardQuestions = t.roleCreate_watch.questions.application[e], console.log("parent SQ: ", t.$parent.$parent.StandardQuestions), c.openModal(t, ".formstep2 #pmvFileModalNew", "resume");
          else {
              var a = {
                  data: o
              };
              a.data.question && "" != a.data.question || (a.data.question = "(Kindly refer to the document)"), 0 != a.data.answer_type.length && a.data.answer_type || (a.data.answer_type = ["free_text"]), p.postAplicationQ(t.roleId, a).then(function(o) {
                  o && (t.roleCreate_watch.questions.application[e].id = o.id, console.log("UPLOAD REFERENCE: ", o), t.$parent.$parent.StandardQuestions = o, t.$parent.$parent.singlesq_ref_docId = o.id, t.$parent.$parent.fieldIndex = e, c.openModal(t, ".formstep2 #pmvFileModalNew", "resume"))
              })
          }
      }, t.$watch("$parent.$parent.getSQ_docs", function(e, o) {
          angular.forEach(t.roleCreate_watch.questions.application, function(t, o) {
              e.id == t.id && (t.question_document = e.question_document)
          })
      }), t.saveSingleQuestion = function(e, o) {
          var a = e;
          t.single_save = {}, t.$parent.$parent.sectionsHideShow(0, 1);
          for (var n = 0; n < t.roleCreate_watch.questions.application.length; n++)
              if (n == a) return t.single_save = t.roleCreate_watch.questions.application[n], console.log("single save! ", t.single_save), "vid" == o ? t.openVideoModal(t.single_save, a) : t.uploadReference(a, t.single_save), !0
      }, t.answerChoices = [{
          id: 1,
          label: "Yes/No",
          value: "boolean"
      }, {
          id: 2,
          label: "Multiple choice",
          value: "multiple_choice"
      }, {
          id: 4,
          label: "Document upload",
          value: "file_upload"
      }, {
          id: 4,
          label: "Video",
          value: "video"
      }, {
          id: 5,
          label: "Text",
          value: "free_text"
      }], t.answerChoicesDB = [{
          id: 11,
          label: "Yes/No"
      }, {
          id: 12,
          label: "Multiple choice"
      }, {
          id: 13,
          label: "Video upload"
      }, {
          id: 14,
          label: "Document upload"
      }], t.abc = ["A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z"], t.answerMultDB = [{
          id: 11,
          answer: "Yes/No"
      }, {
          id: 12,
          answer: "Multiple choice"
      }, {
          id: 13,
          answer: "Video upload"
      }, {
          id: 14,
          answer: "Document upload"
      }], t.answerChoiceSelMum = [{
          id: 1,
          answerChoiceSel: []
      }], t.answerChoicesArr = [], t.beSpokeMyList = [], t.roleCreate_watch = {
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
              language: "",
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
      }, t.answerType = [], r(function() {
          l.getData(t.roleId).then(function(o) {
              if (t.roleCreate = o, console.log("GETDATE SQ: ", o), o && (t.role_create_tab_loader = 0), t.roleCreate_watch = t.roleCreate, console.log("pcku", t.roleCreate_watch), t.sq_view = t.roleCreate_watch.questions.application, console.log("SQ Main get: ", t.sq_view), t.roleCreate.report_date) var n = new Date(t.roleCreate.report_date);
              else var n = new Date;
              var i = n.getFullYear(),
                  r = n.getDate(),
                  s = n.getMonth();
              t.roleDayPass = {
                  label: r,
                  value: r
              }, t.roleYrPass = {
                  label: i,
                  value: i
              }, t.roleCreate_watch.report_date = s + 1 + "/" + t.roleDayPass.value + "/" + t.roleYrPass.value, t.roleName = t.roleCreate.job_title, t.roleCreate_watch.questions.pre_apply = t.roleCreate.questions.pre_apply, t.roleCreate_watch.questions.application = t.roleCreate.questions.application, "visibility" in t.roleCreate_watch && (t.roleCreate_watch.visibility_members = t.roleCreate_watch.visibility.members, t.roleCreate_watch.visibility_teams = t.roleCreate_watch.visibility.teams);
              for (var l = 0; l < t.roleCreate_watch.questions.application.length; l++)
                  if ("answer_choices" in t.roleCreate_watch.questions.application[l]) {
                      t.roleCreate_watch.questions.application[l].answer_choicesDisplay = [];
                      for (var c = 0; c < t.roleCreate_watch.questions.application[l].answer_choices.length; c++) t.roleCreate_watch.questions.application[l].answer_choicesDisplay.push({
                          value: t.roleCreate_watch.questions.application[l].answer_choices[c]
                      })
                  }
              console.log("Initiating videos if there is any"), u(), a.get(window.location.origin + '/js/minified/test-data/test_emp_create_role_standard_data.json').then(function(e) { //a.get(e.EmployerRootApi + "/suggestions/" + t.roleId + "/standard_questions").then(function(e) { // Uncomment for live API
                  t.preInspirationList = e.data.data, t.pushInspirationStan = function(e) {
                      var o = t.preInspirationList.indexOf(e);
                      t.preInspirationList.splice(o, 1);
                      var a = {
                          question: e.name,
                          question_type: "",
                          answer_choices: [],
                          answer_choicesDisplay: [],
                          answer_type: []
                      };
                      t.roleCreate_watch.questions.application.push(a)
                  }
              }), t.$watchCollection("setDeclaration", function(o, n) {
                  o != n && "true" == o && a.get(e.JobsApi + "/declaration/employer/" + t.roleId).then(function(e) {
                      var o = {
                          question: e.data.data,
                          answer_type: ["boolean"],
                          question_type: "comp_declaration"
                      };
                      t.roleCreate_watch.questions.application.unshift(o), console.log("ADD comp declare: ", t.roleCreate_watch.questions.application)
                  })
              }), t.$watchCollection("setDeclarationCan", function(o, n) {
                  o != n && "true" == o && a.get(e.JobsApi + "/declaration/candidate/" + t.roleId).then(function(e) {
                      var o = {
                          question: e.data.data,
                          answer_type: ["boolean"],
                          question_type: "can_declaration"
                      };
                      t.roleCreate_watch.questions.application.push(o)
                  })
              }), t.changeStandard = function(e, o) {
                  t.$parent.$parent.empRoleMain = t.roleCreate_watch
              }, t.addBlankStandard = function() {
                  var e = {
                      question: "",
                      answer_type: [],
                      answer_choices: [],
                      answer_choicesDisplay: [],
                      question_type: ""
                  };
                  t.roleCreate_watch.questions.application.push(e)
              }, t.deleteQuestion = function(o) {
                  var n = t.roleCreate_watch.questions.application.indexOf(o);
                  t.roleCreate_watch.questions.application.splice(n, 1), t.roleId.length > 0 && "undefined" != t.roleId | void 0 != t.roleId && a.delete(e.EmployerRootApi + "/job/" + t.roleId + "/questions/application/single/" + o.id).then(function(e) {})
              }, t.checkMyBack = function(e) {
                  var o = t.roleCreate_watch.questions.application.indexOf(e);
                  if (t.roleCreate_watch.questions.application[o].answer_choices = [], e.answer_type.indexOf("multiple_choice") > -1)
                      for (var a = 0; a < e.answer_choicesDisplay.length; a++) t.roleCreate_watch.questions.application[o].answer_choices[a] = e.answer_choicesDisplay[a].value;
                  t.$parent.$parent.empRoleMain = t.roleCreate_watch, angular.forEach(t.roleCreate_watch.questions.pre_apply, function(e, o) {
                      "deciding_factor_type" in t.roleCreate_watch.questions.pre_apply[o] || (t.roleCreate_watch.questions.pre_apply[o].deciding_factor_type = "")
                  })
              }, t.addAnswerMultDB = function(e) {
                  var o = t.roleCreate_watch.questions.application.indexOf(e),
                      a = {
                          value: ""
                      };
                  "answer_choicesDisplay" in t.roleCreate_watch.questions.application[o] || (t.roleCreate_watch.questions.application[o].answer_choicesDisplay = []), t.roleCreate_watch.questions.application[o].answer_choicesDisplay.push(a)
              }, t.deleteChoices = function(e, o) {
                  var a = t.roleCreate_watch.questions.application.indexOf(e),
                      n = t.roleCreate_watch.questions.application[a].answer_choicesDisplay.indexOf(o);
                  t.roleCreate_watch.questions.application[a].answer_choicesDisplay.splice(n, 1)
              };
              for (var d = 0; d < t.answerChoicesDB.length; d++) t.answerChoicesArr.push(t.answerChoicesDB[d].label);
              for (var d = 0; d < t.answerChoices.length; d++) t.answerChoicesArr.indexOf(t.answerChoices[d].label) > -1 ? t.answerChoices[d].disabled = !1 : t.answerChoices[d].disabled = !0;
              // a.get(e.EmployerRootApi + "/job/" + t.roleId + "/questions/pre-apply/bespoke").then(function(e) { // Uncomment for live API call
              a.get(window.location.origin + '/js/minified/test-data/test_emp_create_role_bespoke_data.json').then(function(e) {
                  t.beSpokeTagList = e.data.data
              }), t.pushBespoke = function(e) {
                  e.question_data.question_type = "", t.roleCreate_watch.questions.application.push(e.question_data), t.$parent.$parent.empRoleMain = t.roleCreate_watch
              }, t.roleCreate_watch.job_title = t.roleCreate.job_title, t.$parent.$parent.empRoleMain = t.roleCreate_watch
          })
      }, 500)
  }]), e.factory("MultiVideoTracker", ["GlobalConstant", "$http", function(e, t) {
      return {
          getVideoStatus: function(o) {
              return t.get(e.APIRoot + "video/" + o + "/status").then(function(e) {
                  return e.data.data
              })
          }
      }
  }]), e.factory("StandardQuestionSvcs", ["GlobalConstant", "$http", function(e, t) {
      return {
          postAplicationQ: function(o, a) {
              return console.log("AKO BA TO postAplicationQ Tae: ", o, a), t.post(e.EmployerRootApi + "/job/" + o + "/questions/application/single", a).then(function(e) {
                  return e.data.data
              })
          }
      }
  }]), e.factory("EmployerRoleHttp", ["GlobalConstant", "$http", function(e, t) {
      return {
          getData: function(o) {
              return t.get(e.EmployerRootApi + "/job/" + o).then(function(e) {
                  return e.data.data
              })
          },
          getIndustries: function() {
              return t.get(e.StaticOptionsApi + "/industries").then(function(e) {
                  return e.data.data
              })
          },
          getSubIndustries: function(o) {
              return t.get(e.StaticOptionsApi + "/industries/sub/" + o).then(function(e) {
                  return e.data.data
              })
          },
          getCountries: function(o) {
              return t.get(e.StaticOptionsApi + "/countries").then(function(e) {
                  return e.data.data
              })
          },
          postData: function(o) {
              return t.post(e.EmployerRootApi + "/job", o).then(function(e) {
                  return e.data.data
              })
          }
      }
  }])
}();