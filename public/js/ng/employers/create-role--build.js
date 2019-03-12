!function() {
  "use strict";
  var e=angular.module("app");
  $("body").data("base_url"),
  e.controller("CreateRoleBuild", ["$scope", "$window", "$cookies", "$filter", "$timeout", "$compile", "EmployerRoleHttp", "GlobalConstant", "$http", "$sce", "CreateRoleSvcs", "BuildTheRoleSvcs", function(e, t, a, r, i, n, o, l, s, c, u, _) {
      function p() {
          if(void 0===e.expRangeMax||void 0===e.expRangeMin)return e.roleExperience="", !1;
          e.roleExperience=e.expRangeMin.text+" - "+e.expRangeMax.text+"y"
      }
      function d(t) {
          var a=t.getDate(), r=t.getFullYear(), i=t.toLocaleString("en-us", {
              month: "long"
          }
          ), n=t.toLocaleString("en-us", {
              weekday: "long"
          }
          );
          e.roleJobListed=n+", "+a+" "+i+", "+r
      }
      function m() {
          ""!=e.start_time_hardcode&&e.start_time_hardcode||(e.start_time_hardcode="08:30"), ""!=e.end_time_hardcode&&e.end_time_hardcode||(e.end_time_hardcode="17:00"), i(function() {
              var t=r("filter")(e.start_time_list, {
                  value: e.start_time_hardcode
              }
              );
              if(0!=t.length)angular.forEach(t, function(t, a) {
                  var r=e.start_time_list.indexOf(t);
                  e.start_time=e.start_time_list[r], e.start_ampm=e.ampm[0]
              }
              );
              else {
                  var a=r("filter")(e.end_time_list, {
                      value: e.start_time_hardcode
                  }
                  );
                  if(angular.forEach(a, function(t, a) {
                      e.end_time_list.indexOf(t), e.start_ampm=e.ampm[1]
                  }
                  ), null!=e.end_time_hardcode) {
                      console.log("efennn ", e.end_time_hardcode);
                      var i=r("filter")(e.end_time_list, {
                          value: e.end_time_hardcode
                      }
                      , !0), n=r("filter")(e.start_time_list, {
                          text: i[0].text
                      }
                      , !0), o=e.start_time_list.indexOf(n[0]);
                      e.start_time=e.start_time_list[o]
                  }
              }
              var l=r("filter")(e.end_time_list, {
                  value: e.end_time_hardcode
              }
              );
              if(0!=l.length) {
                  angular.forEach(l, function(t, a) {
                      e.end_time_list.indexOf(t), e.end_ampm=e.ampm[1]
                  }
                  );
                  var i=r("filter")(e.end_time_list, {
                      value: e.end_time_hardcode
                  }
                  , !0), n=r("filter")(e.end_time_list, {
                      text: i[0].text
                  }
                  , !0), o=e.end_time_list.indexOf(n[0]);
                  e.finish_time=e.end_time_list[o]
              }
              else {
                  var s=r("filter")(e.start_time_list, {
                      value: e.end_time_hardcode
                  }
                  );
                  angular.forEach(s, function(t, a) {
                      var r=e.start_time_list.indexOf(t);
                      e.finish_time=e.start_time_list[r], e.end_ampm=e.ampm[1]
                  }
                  )
              }
          }
          , 1e3)
      }
      e.role_create_tab_loader=1, e.show_hourlyrate_desc=0, e.roleId=e.$parent.$parent.objURL.id, e.roleId||(e.roleId=a.get("jobObjectId")), a.get("loadTemplate"), e.roleTypesSel= {}
      , e.countries= {}
      , e.classifications= {}
      , e.role_dateexpiry="", e.autoLocation=[], e.roleTypeSelDisplay="", e.createRoleWorkingHours="", e.roleExperience="", e.roleLocationDisplay="", e.roleJobListed="", e.start_time_hardcode="", e.end_time_hardcode="";
      var y=["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sept", "Oct", "Nov", "Dec"], h=["Sun.", "Mon.", "Tue.", "Wed.", "Thu.", "Fri.", "Sat."];
      e.roleTypes=[ {
          name: "Full time", id: 1
      }
      , {
          name: "Part time", id: 2
      }
      , {
          name: "Contract", id: 3
      }
      , {
          name: "Casual", id: 4
      }
      , {
          name: "Volunteer", id: 11
      }
      , {
          name: "Apprenticeship", id: 5
      }
      , {
          name: "Internship", id: 6
      }
      , {
          name: "Summer clerk", id: 7
      }
      , {
          name: "Graduate", id: 8
      }
      , {
          name: "Fix term", id: 9
      }
      , {
          name: "Temp", id: 10
      }
      ], e.salaryType=[ {
          text: "Annual salary package", value: "Annual salary package"
      }
      , {
          text: "Annual & commission", value: "Annual & commission"
      }
      , {
          text: "Commission only", value: "Commission only"
      }
      , {
          text: "Other", value: "Other"
      }
      ], e.salaryRangeMin=[];
      for(var v=1e4;
      v<=2e5;
      v+=5e3) {
          var f=v.toString();
          if(f.length<=5)var b=f.substring(0, 2)+"K";
          else var b=f.substring(0, 3)+"K";
          var C= {
              text: b, value: v
          }
          ;
          e.salaryRangeMin.push(C)
      }
      e.salaryRangeMax=[];
      for(var v=15e3;
      v<=4e5;
      v+=5e3) {
          var f=v.toString();
          if(f.length<=5)var b=f.substring(0, 2)+"K";
          else var b=f.substring(0, 3)+"K";
          var C= {
              text: b, value: v
          }
          ;
          e.salaryRangeMax.push(C)
      }
      e.roleMonth=[ {
          label: "Jan", value: 1
      }
      , {
          label: "Feb", value: 2
      }
      , {
          label: "Mar", value: 3
      }
      , {
          label: "Apr", value: 4
      }
      , {
          label: "May", value: 5
      }
      , {
          label: "Jun", value: 6
      }
      , {
          label: "Jul", value: 7
      }
      , {
          label: "Aug", value: 8
      }
      , {
          label: "Sep", value: 9
      }
      , {
          label: "Oct", value: 10
      }
      , {
          label: "Nov", value: 11
      }
      , {
          label: "Dec", value: 12
      }
      ], e.roleDay=[];
      for(var v=1;
      v<=31;
      v++)e.roleDay.push( {
          label: v, value: v
      }
      );
      e.roleYear=[];
      var x=new Date;
      x=x.getFullYear();
      for(var v=0;
      v<=10;
      v++)e.roleYear.push( {
          label: x+v, value: x+v
      }
      );
      e.max_experience_list=[], e.min_experience_list=[ {
          text: "0", value: "0"
      }
      , {
          text: "1", value: "1"
      }
      , {
          text: "2", value: "2"
      }
      , {
          text: "3", value: "3"
      }
      , {
          text: "4", value: "4"
      }
      , {
          text: "5", value: "5"
      }
      , {
          text: "6", value: "6"
      }
      , {
          text: "7", value: "7"
      }
      , {
          text: "8", value: "8"
      }
      , {
          text: "9", value: "9"
      }
      , {
          text: "10", value: "10"
      }
      ], e.changeMinExp=function() {
          if(null!=e.expRangeMin||0==angular.isUndefined(e.expRangeMin)) {
              var t=parseInt(e.expRangeMin.value);
              e.max_experience_list=[], t<10&&(t+=1);
              for(var a=t;
              a<=10;
              a++) {
                  if(10==a)var r= {
                      text: "10+", value: a
                  }
                  ;
                  else var r= {
                      text: a, value: a
                  }
                  ;
                  e.max_experience_list.push(r)
              }
              p()
          }
      }
      , e.changeMaxExp=function() {
          p()
      }
      , e.shuffle_resp=function() {
          e.loading_insp_resp=!0, _.getShuffleResponsibilities(e.roleId).then(function(t) {
              e.preInspirationList=t.data, e.loading_insp_resp=!1
          }
          )
      }
      , e.shuffle_skills=function() {
          e.loading_insp_skills=!0, _.getShuffleSkills(e.roleId).then(function(t) {
              e.preInspirationList=t.data, e.loading_insp_skills=!1
          }
          )
      }
      ;
      var v=0;
      for(e.JobAvailabitily=[];
      v<31;
      ) {
          v++, f=1==v?v+" day": v+" days";
          var g=v;
          e.JobAvailabitily.push( {
              text: f, value: g
          }
          )
      }
      e.JobAvailabitily.push( {
          text: "45 days", value: 45
      }
      , {
          text: "60 days", value: 60
      }
      , {
          text: "90 days", value: 90
      }
      ), e.respPrioCheck=[], e.respPriorities=[ {
          value: 1, type_display_name: "Primary"
      }
      , {
          value: 2, type_display_name: "Secondary"
      }
      ], e.reqTypes=[ {
          value: "Primary", type_display_name: "Essential"
      }
      , {
          value: "Secondary", type_display_name: "Nice to have"
      }
      ], u.getEmployerProfile().then(function(e) {
          var t=e.azure_container_key, r=t.split("/");
          a.put("ob_key", r[1], {
              path: "/"
          }
          ), a.put("cont_key", r[0], {
              path: "/"
          }
          )
      }
      ), e.myInspirationList=[], e.roleCreate_watch= {
          job_title:"", role_type:"", working_days:[1, 2, 3, 4, 5], min_salary:0, max_salary:0, start_time:"", finish_time:"", flexible_hours:!1, industry:0, min_experience:0, max_experience:0, is_salary_public:!1, location: {
              country_id: 0, location: ""
          }
          , role_duration:0, salary_type:"", job_reason:"", job_meta: {}
          , job_video_url:"", benefits:[], lead_manage_team:"", application_requirements: {
              about_me: "", education: "", icebreaker_video: "", phone_number: "", portfolio: "", profile_image: "", references: "", resume: "", work_experience: "", cv: "", language: "", cover_letter: ""
          }
          , requirements:[], accountabilities:[], objectives:[], questions: {
              pre_apply: [], application: []
          }
          , search_helpers: {
              above_salary_band: "", flexible_working: "", high_potential_less_experience: "", part_time: ""
          }
          , visibility_members:[], visibility_teams:[]
      }
      , e.functiontofindIndexByKeyValue=function(e, t, a) {
          for(var r=0;
          r<e.length;
          r++)if(e[r][t]==a)return r;
          return null
      }
      , e.populateLocation=function(t) {
          var a=r("filter")(e.countries, t.country_id, !0), n=e.functiontofindIndexByKeyValue(e.countries, "id", a[0].id);
          e.country=e.countries[n];
          var o=t.location.split(" "), c=o[0].replace(/[^\w\s]/gi, "");
          s.get(l.APIRoot+"static/autocomplete/location?q="+c+"&country_id="+t.country_id).then(function(a) {
              0==a.data.data.length?e.searchLocation=t.display_name:angular.forEach(a.data.data, function(a, r) {
                  a.display_name===t.display_name?(e.searchLocation=t.display_name, i(function() {
                      e.LocationId=t.id
                  }
                  , 100)):(e.searchLocation=t.display_name, e.LocationId="")
              }
              )
          }
          )
      }
      , e.$watch("roleLocation", function(t, a) {
          e.country=t
      }
      ), e.doneTyping=function() {
          e.autoLocation=[], s.get(l.APIRoot+"static/autocomplete/location?q="+$("#location").val()+"&country_id="+e.country.id).then(function(t) {
              e.autoLocation=t.data.data;
              var a=$("#location").val();
              e.roleLocationDisplay=a+" , "+e.roleLocation.country_code.toUpperCase(), 0==e.autoLocation.length&&e.autoLocation.push( {
                  id: null, display_name: "No result"
              }
              ), i(function() {
                  angular.element($("#autoDataLocation")).is(":hidden")&&angular.element($("#autoDataLocation")).slideToggle("slow")
              }
              , 200)
          }
          )
      }
      , e.data="", e.getAutoCompleteData=function(t) {
          e.data=t, e.roleSubLocation=t.display_name, e.roleLocationDisplay=t.display_name+" , "+e.roleLocation.country_code.toUpperCase(), e.LocationId=t.id, $("#autoDataLocation").is(":visible")&&$("#autoDataLocation").slideToggle("slow"), R=0
      }
      ;
      var w, R=0;
      $("#location").on("keyup", function(t) {
          if($("#LocationId").val(null), t.which>=37&&t.which<=40||13==t.which) {
              var a=$("#autoDataLocation li");
              if(a.length)if(40==t.which)a.hasClass("selected_filter")?(R=$("#autoDataLocation li.selected_filter").prevAll().length+1, $("#autoDataLocation li").removeClass("selected_filter"), 0==$("#autoDataLocation li:eq("+R+")").nextAll().length&&(R=a.length-1), $("#autoDataLocation li:eq("+R+")").addClass("selected_filter")): (a.removeClass("selected_filter"), $("#autoDataLocation li:eq("+R+")").addClass("selected_filter"));
              else if(38==t.which)a.hasClass("selected_filter")&&(R--, R=R<=0?0: R, a.removeClass("selected_filter"), $("#autoDataLocation li:eq("+R+")").addClass("selected_filter"));
              else if(13==t.which) {
                  var r=$("#autoDataLocation li:eq("+R+")").find("a").text();
                  $("#location").val(r), $("#autoDataLocation").addClass("ng-hide"), R=0
              }
              return!1
          }
          i.cancel(w), w=i(e.doneTyping(), 10)
      }
      ), e.setReportDate=function() {
          var t=e.roleCreate.report_date?new Date(e.roleCreate.report_date): new Date, a=t.getFullYear(), r=t.getDate(), i=t.getMonth();
          d(t), e.roleDayPass= {
              label: r, value: r
          }
          , e.roleYrPass= {
              label: a, value: a
          }
          , angular.forEach(e.roleMonth, function(t, a) {
              e.roleMonth[a].value+1==i+1&&(e.roleMoPass= {
                  label: e.roleMonth[a].value+1, value: i+1
              }
              )
          }
          )
      }
      , e.InitParams=function(t) {
          e.roleCreate=t, "visibility"in e.roleCreate&&(e.roleCreate.visibility_members=e.roleCreate.visibility.members, e.roleCreate.visibility_teams=e.roleCreate.visibility.teams), e.contain_report_date_onload=e.roleCreate.report_date, e.setReportDate(), e.$watch("roleCreate_watch.immediate_start", function(t, a) {
              e.roleCreate.report_date=t?null: e.contain_report_date_onload, e.setReportDate()
          }
          ), e.start_time_hardcode=e.roleCreate.start_time, e.end_time_hardcode=e.roleCreate.finish_time, m(), e.$watchGroup(["roleDayPass", "roleMoPass", "roleYrPass"], function(t, a) {
              t!=a&&(e.roleCreate_watch.report_date=t[1].value+"/"+t[0].value+"/"+t[2].value, e.roleCreate.report_date=t[1].value+"/"+t[0].value+"/"+t[2].value, d(new Date(e.roleCreate.report_date)))
          }
          ), e.changeIndustry=function() {
              o.getSubIndustries(e.roleClassif.id).then(function(t) {
                  e.subclassifications=t, i(function() {
                      if(e.roleClassif&&e.subclassifications)for(var t=0;
                      t<e.subclassifications.length;
                      t++)e.subclassifications[t].id==e.roleCreate.industry.data.sub.id&&e.roleCreate.industry.data.sub&&(e.roleSubClassif=e.subclassifications[t])
                  }
                  , 800)
              }
              )
          }
          , o.getIndustries().then(function(t) {
              if(e.classifications=t, e.roleCreate.industry)for(var a=0;
              a<e.classifications.length;
              a++)e.classifications[a].id==e.roleCreate.industry.data.industry.id&&(e.roleClassif=e.classifications[a], e.changeIndustry());
              else e.roleClassif=""
          }
          ), o.getCountries().then(function(t) {
              if(e.countries=t, e.roleCreate.location) {
                  for(var a=0;
                  a<e.countries.length;
                  a++)if(e.countries[a].id==e.roleCreate.location.data.country.id)return e.roleLocation=e.countries[a], e.roleCreate_watch.location.country_id=e.countries[a].id, void e.populateLocation(e.roleCreate_watch.location)
              }
              else e.roleLocation=""
          }
          ), e.roleCreate.role_type?e.roleTypesSel=e.roleCreate.role_type.id:e.roleTypesSel=0, e.workDaysCheck=e.roleCreate.working_days, e.roleCreate_watch.working_days=e.workDaysCheck, s.get(window.location.origin + '/js/minified/test-data/test_emp_create_role_company_data.json').then(function(t) {  // s.get(l.EmployerRootApi+"/company").then(function(t) { // Uncomment fo live API
              e.companyDetails=t.data.data
          }
          );
          for(var a=0;
          a<e.salaryRangeMin.length;
          a++)e.salaryRangeMin[a].value==e.roleCreate.min_salary&&(e.salRangeMin=e.salaryRangeMin[a], e.roleCreate_watch.min_salary=e.salRangeMin);
          for(var a=0;
          a<e.salaryRangeMax.length;
          a++)e.salaryRangeMax[a].value==e.roleCreate.max_salary&&(e.salRangeMax=e.salaryRangeMax[a], e.roleCreate_watch.max_salary=e.salRangeMax);
          e.flexiHardcode=e.roleCreate.flexible_hours;
          for(var a=0;
          a<e.min_experience_list.length;
          a++)e.min_experience_list[a].text==e.roleCreate.min_experience&&(e.expRangeMin=e.min_experience_list[a], e.roleCreate_watch.min_experience=e.expRangeMin, e.changeMinExp());
          i(function() {
              for(var t=0;
              t<e.max_experience_list.length;
              t++)e.max_experience_list[t].value==e.roleCreate.max_experience&&(e.expRangeMax=e.max_experience_list[t], e.roleCreate_watch.max_experience=e.expRangeMax)
          }
          , 500), e.roleCreate_watch.is_salary_public=e.roleCreate.is_salary_public, e.roleCreate.location&&(e.roleSubLocation=e.roleCreate.location.data.display_name);
          for(var a=0;
          a<e.JobAvailabitily.length;
          a++)e.JobAvailabitily[a].value==e.roleCreate.role_duration&&(e.roleAvailability=e.JobAvailabitily[a], e.roleCreate_watch.role_duration=e.roleAvailability);
          for(var a=0;
          a<e.salaryType.length;
          a++)e.salaryType[a].value==e.roleCreate.salary_type&&(e.salType=e.salaryType[a], e.roleCreate_watch.salary_type=e.salType);
          angular.forEach(e.roleCreate.accountabilities, function(t, a) {
              e.myInspirationList[a]=t, e.myInspirationList[a].type=e.myInspirationList[a].type_display_name
          }
          ), angular.forEach(e.roleCreate.requirements, function(t, a) {
              e.roleCreate_watch.requirements[a]=t, e.roleCreate_watch.requirements[a].type=e.roleCreate_watch.requirements[a].type_display_name
          }
          ), angular.forEach(e.roleCreate.benefits, function(t, a) {
              e.roleCreate_watch.benefits[a]=t, e.roleCreate_watch.benefits[a].type=e.roleCreate_watch.benefits[a].type_display_name
          }
          ), angular.forEach(e.roleCreate.search_helpers, function(t, a) {
              "Flexible Working"==t.name?e.roleCreate_watch.search_helpers.flexible_working=t.type_display_name: "Going above salary band"==t.name?e.roleCreate_watch.search_helpers.above_salary_band=t.type_display_name: "Someone with high potential / less experience"==t.name?e.roleCreate_watch.search_helpers.high_potential_less_experience=t.type_display_name: "Part Time"==t.name&&(e.roleCreate_watch.search_helpers.part_time=t.type_display_name)
          }
          ), e.roleCreate.accountabilities=e.myInspirationList, e.roleCreate_watch.accountabilities.length>0&&(e.roleCreate_watch.accountabilities=e.roleCreate.accountabilities), e.roleCreate_watch.requirements=e.roleCreate.requirements, e.roleCreate_watch.benefits=e.roleCreate.benefits, e.roleCreate_watch.objectives=e.roleCreate.objectives, e.roleCreate_watch.application_requirements=e.roleCreate.application_requirements, e.roleCreate_watch.job_description=e.roleCreate.job_description, e.roleCreate_watch.job_description&&(e.job_description=e.roleCreate_watch.job_description.replace(/\r?\n|\r/g, "<br>")), e.previewDescR=e.job_description, e.roleCreate_watch.job_meta=e.roleCreate.job_meta, e.roleCreate_watch.questions.pre_apply=e.roleCreate.questions.pre_apply, e.roleCreate_watch.questions.application=e.roleCreate.questions.application, e.roleCreate_watch.immediate_start=e.roleCreate.immediate_start, e.roleCreate_watch.salary_notes=e.roleCreate.salary_notes, e.roleCreate_watch.role_type=e.roleCreate.role_type, e.roleCreate.job_meta.length<=0?(e.roleCreate_watch.job_meta= {}
          , e.roleCreate_watch.lead_manage_team="0", e.roleCreate_watch.job_reason=""):(e.roleCreate_watch.lead_manage_team=e.roleCreate.job_meta.lead_manage_team, e.roleCreate_watch.job_reason=e.roleCreate.job_meta.job_reason), e.previewDesc=function(t) {
              e.previewDescR=t, e.previewDescR=e.previewDescR.replace(/\r?\n|\r/g, "<br>")
          }
          , e.updateInfo=function() {
              e.$parent.$parent.empRoleMain=e.roleCreate_watch, t= {
                  about_me: "yes"==e.empRoleMain.application_requirements.about_me?"yes": "no", icebreaker_video: "yes"==e.empRoleMain.application_requirements.icebreaker_video?"yes": "no", work_experience: "yes"==e.empRoleMain.application_requirements.work_experience?"yes": "no", education: "yes"==e.empRoleMain.application_requirements.education?"yes": "no", references: "yes"==e.empRoleMain.application_requirements.references?"yes": "no", portfolio: "yes"==e.empRoleMain.application_requirements.portfolio?"yes": "no", resume: "yes"==e.empRoleMain.application_requirements.resume?"yes": "no", cover_letter: "yes"==e.empRoleMain.application_requirements.cover_letter?"yes": "no", supp: "yes"==e.empRoleMain.application_requirements.supp?"yes": "no", transcript: "yes"==e.empRoleMain.application_requirements.transcript?"yes": "no"
              }
              ;
              var a=[];
              angular.forEach(t, function(e, t) {
                  a.push(e)
              }
              ), e.validated=a.some(function(e) {
                  return"yes"==e
              }
              ), s.put(l.EmployerRootApi+"/job/"+e.roleId+"/application-requirements", {
                  data: t
              }
              ).then(function(e) {
                  return e.data.data
              }
              )
          }
          , e.$watchGroup(["roleCreate_watch.application_requirements.about_me", "roleCreate_watch.application_requirements.work_experience", "roleCreate_watch.application_requirements.education", "roleCreate_watch.application_requirements.references", "roleCreate_watch.application_requirements.icebreaker_video", "roleCreate_watch.application_requirements.cover_letter", "roleCreate_watch.application_requirements.resume", "$scope.empRoleMain.application_requirements.supp", "$scope.empRoleMain.application_requirements.transcript"], function(t, a) {
              t.indexOf("yes")>-1?(e.$parent.$parent.disablePublish=!1, e.$parent.$parent.appYes=!0): (e.$parent.$parent.disablePublish=!0, e.$parent.$parent.appYes=!1)
          }
          ), e.$watchGroup(["roleCreate_watch.role_type", "workDaysCheck", "start_time", "finish_time", "flexiHardcode", "salType", "roleCreate_watch.is_salary_public", "salRangeMin", "salRangeMax", "roleCreate_watch.lead_manage_team", "roleSubClassif", "roleAvailability", "roleLocation", "roleSubLocation", "roleCreate_watch.job_description", "expRangeMin", "expRangeMax", "roleName", "start_ampm", "end_ampm"], function(t, a) {
              if(t!==a) {
                  if(void 0!==t[2]&&void 0!==t[3]) {
                      var r=t[2].text+" "+e.start_ampm.text.toUpperCase(), i=t[3].text+" "+e.end_ampm.text.toUpperCase();
                      e.createRoleWorkingHours=r+" - "+i
                  }
                  if(void 0!==t[12]&&void 0!==t[13]&&(e.roleLocationDisplay=t[13]+" , "+e.roleLocation.country_code.toUpperCase()), t[0]&&(e.roleTypesSel=t[0], e.roleTypeSelDisplay=t[0].name?t[0].name:t[0].display_name, e.roleCreate_watch.role_type=t[0]), t[1]&&(e.roleCreate_watch.working_days=t[1]), t[2]&&(e.roleCreate_watch.start_time=t[2].value), t[3]&&(e.roleCreate_watch.finish_time=t[3].value), t[4]&&(e.roleCreate_watch.flexible_hours=t[4]), t[5]&&(e.roleCreate_watch.salary_type=t[5].value), t[6]&&(e.roleCreate_watch.is_salary_public=t[6]), t[7]&&(e.roleCreate_watch.min_salary=t[7].value), t[8]&&(e.roleCreate_watch.max_salary=t[8].value), t[9]&&(e.roleCreate_watch.lead_manage_team=t[9]), t[10]&&(e.roleCreate_watch.industry=t[10].id), t[11]) {
                      e.roleCreate_watch.role_duration=t[11].value;
                      var n=new Date;
                      n.setDate(n.getDate()+e.roleCreate_watch.role_duration);
                      var o=n.getMonth(), l=n.getFullYear(), s=n.getDay();
                      n=n.getDate(), e.role_dateexpiry=h[s]+" "+n+" "+y[o]+" "+l
                  }
                  t[12]&&(e.roleCreate_watch.location.country_id=t[12].id), t[13]&&(e.roleCreate_watch.location.location=t[13]), t[14]&&(e.roleCreate_watch.job_reason=t[14]), t[15]&&(e.roleCreate_watch.min_experience=t[15].value), t[16]&&(e.roleCreate_watch.max_experience=t[16].value), p(), t[17]&&(e.roleCreate_watch.job_title=t[17].value), e.$parent.$parent.empRoleMain=e.roleCreate_watch
              }
          }
          ), e.roleCreate_watch.job_title=t.job_title, e.$parent.$parent.empRoleMain&&(e.$parent.$parent.empRoleMain.job_title=e.roleCreate_watch.job_title), e.role_create_tab_loader=0
      }
      , i(function() {
          o.getData(e.roleId).then(function(t) {
              e.role_create_tab_loader=1, t&&e.InitParams(t)
          }
          )
      }
      , 2e3), e.workDaysCheck=[], e.updateSelected=function(e) {}
      , e.start_times=[ {
          text: "1:00", value: "01:00"
      }
      , {
          text: "1:30", value: "01:30"
      }
      , {
          text: "2:00", value: "02:00"
      }
      , {
          text: "2:30", value: "02:30"
      }
      , {
          text: "3:00", value: "03:00"
      }
      , {
          text: "3:30", value: "03:30"
      }
      , {
          text: "4:00", value: "04:00"
      }
      , {
          text: "4:30", value: "04:30"
      }
      , {
          text: "5:00", value: "05:00"
      }
      , {
          text: "5:30", value: "05:30"
      }
      , {
          text: "6:00", value: "06:00"
      }
      , {
          text: "6:30", value: "06:30"
      }
      , {
          text: "7:00", value: "07:00"
      }
      , {
          text: "7:30", value: "07:30"
      }
      , {
          text: "8:00", value: "08:00"
      }
      , {
          text: "8:30", value: "08:30"
      }
      , {
          text: "9:00", value: "09:00"
      }
      , {
          text: "9:30", value: "09:30"
      }
      , {
          text: "10:00", value: "10:00"
      }
      , {
          text: "10:30", value: "10:30"
      }
      , {
          text: "11:00", value: "11:00"
      }
      , {
          text: "11:30", value: "11:30"
      }
      , {
          text: "12:00", value: "12:00"
      }
      , {
          text: "12:30", value: "12:30"
      }
      ], e.start_time_list=e.start_times, e.end_times=[ {
          text: "1:00", value: "13:00"
      }
      , {
          text: "1:30", value: "13:30"
      }
      , {
          text: "2:00", value: "14:00"
      }
      , {
          text: "2:30", value: "14:30"
      }
      , {
          text: "3:00", value: "15:00"
      }
      , {
          text: "3:30", value: "15:30"
      }
      , {
          text: "4:00", value: "16:00"
      }
      , {
          text: "4:30", value: "16:30"
      }
      , {
          text: "5:00", value: "17:00"
      }
      , {
          text: "5:30", value: "17:30"
      }
      , {
          text: "6:00", value: "18:00"
      }
      , {
          text: "6:30", value: "18:30"
      }
      , {
          text: "7:00", value: "19:00"
      }
      , {
          text: "7:30", value: "19:30"
      }
      , {
          text: "8:00", value: "20:00"
      }
      , {
          text: "8:30", value: "20:30"
      }
      , {
          text: "9:00", value: "21:00"
      }
      , {
          text: "9:30", value: "21:30"
      }
      , {
          text: "10:00", value: "22:00"
      }
      , {
          text: "10:30", value: "22:30"
      }
      , {
          text: "11:00", value: "23:00"
      }
      , {
          text: "11:30", value: "23:30"
      }
      , {
          text: "12:00", value: "00:00"
      }
      , {
          text: "12:30", value: "00:30"
      }
      ], e.end_time_list=e.end_times, e.ampm=[ {
          text: "am", value: "am"
      }
      , {
          text: "pm", value: "pm"
      }
      ], e.ampmList=e.ampm, e.workdays=[ {
          id: 1, display_name: "Monday", substrdays: "Mon"
      }
      , {
          id: 2, display_name: "Tuesday", substrdays: "Tue"
      }
      , {
          id: 3, display_name: "Wednesday", substrdays: "Wed"
      }
      , {
          id: 4, display_name: "Thursday", substrdays: "Thu"
      }
      , {
          id: 5, display_name: "Friday", substrdays: "Fri"
      }
      , {
          id: 6, display_name: "Saturday", substrdays: "Sat"
      }
      , {
          id: 0, display_name: "Sunday", substrdays: "Sun"
      }
      ], e.$watchCollection("workDaysCheck", function(t, a) {
          if(t!=a)for(var r=0;
          r<e.workdays.length;
          r++)t.indexOf(e.workdays[r].id)>-1&&(e.workdays[r].active=!0)
      }
      // Uncomment for live API call
      // ), s.get(l.EmployerRootApi+"/suggestions/"+e.roleId+"/responsibilities").then(function(t) {
      ), s.get(window.location.origin + '/js/minified/test-data/test_emp_create_role_responsibilities_data.json').then(function(t) {
          e.inspirationList=t.data.data, e.$watchCollection("myInspirationList", function(t, a) {
              e.roleCreate_watch.accountabilities=t, e.$parent.$parent.empRoleMain=e.roleCreate_watch
          }
          ), e.pushInspiration=function(t) {
              var a=e.inspirationList.indexOf(t);
              e.inspirationList.splice(a, 1), t.type="Primary", t.type_display_name="Primary", e.myInspirationList.push(t)
          }
          , e.$watch("NotAdminList.is_enabled", function(t, a) {
              t!=a&&e.saveNotSettings(e.NotAdminList)
          }
          ), e.changePriorities=function(t, a) {
              var r=e.myInspirationList.indexOf(a);
              e.roleCreate_watch.accountabilities[r].type=t, e.roleCreate_watch.accountabilities[r].type_display_name=t
          }
          , e.addBlankResp=function() {
              var t= {
                  name: "", type: "Primary", type_display_name: "Primary"
              }
              ;
              e.myInspirationList.push(t)
          }
          , e.delMyInsp=function(t) {
              var a=e.myInspirationList.indexOf(t);
              e.myInspirationList.splice(a, 1), e.roleCreate_watch.accountabilities=e.myInspirationList
          }
      }
      // Uncomment for live API call
      // ), s.get(l.EmployerRootApi+"/suggestions/"+e.roleId+"/requirements").then(function(t) {        
      ), s.get(window.location.origin + '/js/minified/test-data/test_emp_create_role_requirements_data.json').then(function(t) {
          e.skillsinspirationList=t.data.data, e.mySkillsInspirationList=[], e.pushInspirationSkill=function(t) {
              var a=e.skillsinspirationList.indexOf(t);
              e.skillsinspirationList.splice(a, 1), t.type="Primary", t.type_display_name="Primary", e.roleCreate_watch.requirements.push(t)
          }
          , e.changePrioritiesSkill=function(t, a) {
              var r=e.roleCreate_watch.requirements.indexOf(a);
              e.roleCreate_watch.requirements[r].type=t, e.roleCreate_watch.requirements[r].type_display_name=t
          }
          , e.delMyInspSkillItem=function(t) {
              var a=e.roleCreate_watch.requirements.indexOf(t);
              a>-1&&e.roleCreate_watch.requirements.splice(a, 1)
          }
          , e.addBlankSkill=function() {
              var t= {
                  name: "", type: "Primary", type_display_name: "Primary"
              }
              ;
              e.roleCreate_watch.requirements.push(t)
          }
      }
      ), e.myBenList=[ {
          id: 1, label: "Company car", payable: 1
      }
      , {
          id: 2, label: "Mobile phone", payable: 2
      }
      ], e.myConList=[ {
          id: 1, label: "Yes", value: !0
      }
      , {
          id: 2, label: "No", value: !1
      }
      ], e.myConList2=[ {
          id: 1, label: "Yes", value: "Yes"
      }
      , {
          id: 2, label: "No", value: "No"
      }
      ], e.benefitsPayable=[ {
          value: "Paid by Employer", label: "paid"
      }
      , {
          value: "Selectable by Employee", label: "selectable"
      }
      ], e.myConsiderationList=[ {
          id: 1, label: "Flexible working hours", answer: !0
      }
      , {
          id: 2, label: "Part time", answer: !0
      }
      , {
          id: 3, label: "Going above salary band", answer: !1
      }
      , {
          id: 4, label: "Someone with high potential / less experience", answer: !0
      }
      ], e.changePrioritiesBen=function(t, a) {
          var r=e.roleCreate_watch.benefits.indexOf(a);
          e.roleCreate_watch.benefits[r].type=t, e.roleCreate_watch.benefits[r].type_display_name=t
      }
      , e.changeHelper=function(e, t) {}
      , e.delMyInspItem=function(t) {
          var a=e.roleCreate_watch.benefits.indexOf(t);
          e.roleCreate_watch.benefits.splice(a, 1)
      }
      , e.addBlankBen=function() {
          var t= {
              name: "", type: "Paid by Employer", type_display_name: "Paid by Employer"
          }
          ;
          e.roleCreate_watch.benefits.push(t)
      }
      , e.addBlankObj=function() {
          var t= {
              name: ""
          }
          ;
          e.roleCreate_watch.objectives.push(t)
      }
      , e.delMyObjItem=function(t) {
          var a=e.roleCreate_watch.objectives.indexOf(t);
          e.roleCreate_watch.objectives.splice(a, 1)
      }
      , e.reqForApps=["About me", "Work History", "Education History", "References", "Languages"], e.reqDocs=["CV", "Cover Letter", "Supporting Documents", "Transcript"]
  }
  ]),
  e.factory("EmployerRoleHttp", ["GlobalConstant", "$http", function(e, t) {
      return {
          getData:function(a) {
              // return t.get(e.EmployerRootApi+"/job/"+a).then(function(e) { // Uncomment for live API
              return t.get(window.location.origin + '/js/minified/test-data/test_emp_create_role_job_data.json').then(function(e) {
                  return e.data.data
              }
              )
          }
          , getIndustries:function() {
              // Uncomment for live API
              // return t.get(e.StaticOptionsApi+"/industries").then(function(e) {
              return t.get(window.location.origin + '/js/minified/test-data/test_emp_create_role_industries_data.json').then(function(e) {
                  return e.data.data
              }
              )
          }
          , getSubIndustries:function(a) {
              // Uncomment for live API
              // return t.get(e.StaticOptionsApi+"/industries/sub/"+a).then(function(e) {
              return t.get(window.location.origin + '/js/minified/test-data/test_emp_create_role_sub_classification_data.json').then(function(e) {
                  return e.data.data
              }
              )
          }
          , getCountries:function(a) {
              // Uncomment for live API
              // return t.get(e.StaticOptionsApi+"/countries").then(function(e) {
              return t.get(window.location.origin + '/js/minified/test-data/test_emp_create_role_countries_data.json').then(function(e) {
                  return e.data.data
              }
              )
          }
          , postData:function(a) {
              // Uncomment for live API
              //return t.post(e.EmployerRootApi+"/job", a).then(function(e) {
              return t.post(window.location.origin + '/js/minified/test-data/test_emp_create_role_job_data.json').then(function(e) {
                  return e.data.data
              }
              )
          }
          , getSuggestion:function(a) {
              return t.get(e.EmployerRootApi+"/suggestions/"+a+"/responsibilities").then(function(e) {
                  return e.data.data
              }
              )
          }
          , convertReportDate:function(e) {}
          , getVideoProgress:function(a) {
              return t.get(e.APIRoot+"video/"+a+"/status").then(function(e) {
                  return e.data.data
              }
              )
          }
      }
  }
  ]),
  e.factory("BuildTheRoleSvcs", ["GlobalConstant", "$http", function(e, t) {
      return {
          getShuffleResponsibilities:function(a) {
              return t.get(e.EmployerRootApi+"/suggestions/shuffle/"+a+"/responsibilities").then(function(e) {
                  return e.data.data
              }
              )
          }
          , getShuffleSkills:function(a) {
              return t.get(e.EmployerRootApi+"/suggestions/shuffle/"+a+"/requirements").then(function(e) {
                  return e.data.data
              }
              )
          }
      }
  }
  ])
}

();