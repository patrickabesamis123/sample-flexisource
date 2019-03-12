@extends('layouts.roleapplication')

@section('styles')
    <link rel="stylesheet" href="@{{ asset('css/jquery.datetimepicker.min.css?ver=1')}}" />
@endsection

@section('content')

<main id="" class="emp-new-role emp-new-role--can clear-float" ng-controller="RoleAppMainCtrl" ng-cloak>
  <section ng-show="!isPassed && !isFailed" class="clearfix ar__company-top--header">
    <img ng-if="!company.company.logo_url || company.company.logo_url == null" class="ar__company-logo--title pvm-phone-invisible" src="/images/company_profile_photo_dummy.png">
    <img ng-if="company.company.logo_url" class="ar__company-logo--title pvm-phone-invisible" src="@{{company.company.logo_url}}">
    <h1 class="role__title ar__company-name--title">@{{company.job_title}}</h1>
  </section>
  <section ng-show="!isPassed && !isFailed" class="top-pane floated">
    <!-- <div class="company_banner" style="background-image: url('/images/Default-Header.png');"> -->
    <div class="limited" style="background-image: url(@{{company.company.company_banner_url}});" ng-if="company.company.company_banner_url"></div>
    <div class="limited" style="background-image: url('/images/Default-Header.png');" ng-if="!company.company.company_banner_url || company.company.company_banner_url == null || company.company.company_banner_url == ''"></div>
  </section>
  <section ng-show="!isPassed && !isFailed" class="left-pane">
    <!-- <h2 class="role__where-am-i pvm-md-desktop-visible" ng-click="mobileNav = !mobileNav"><i class="fa fa-caret-down"></i> @{{whereAmI}} </h2> -->
    <div class="role__steps-handler">
      <div class="ar__company-logo-div">
        <img ng-if="company.company.logo_url" class="company__logo-img " src="@{{company.company.logo_url}}">
        <img ng-if="!company.company.logo_url" class="company__logo-img " src="/images/pvm-mini-white.png">
      </div>
      <div class="ar__company-info-div">
        <p class="ar__company-name pvm_blue">@{{company.company.company_name}}</p>
        <p class="ar__company-location pvm-tablet-land-invisible">@{{company.company.location.data.display_name}}, @{{company.company.location.data.country.display_name}}</p>
        <p class="ar__company-location pvm-tablet-land-visible">@{{company.company.location.data.display_name}}<br> @{{company.company.location.data.country.display_name}}</p>
      </div>
      <ul class="role__steps-list pvm-tablet-land-invisible">
        <li class="role__steps-item main__nav-active" ng-class="{ 'active' : active_tab == stepstab.showPre}" ng-show="tabs.showPre">
          <span class="role__steps-title">Quick Questions</span>
          <i class="fa fa-angle-right"></i>
        </li>
        <li class="role__steps-item" ng-class="{ 'active' : active_tab == stepstab.showReq}" ng-show="tabs.showReq">
          <span class="role__steps-title">Tell Us About Yourself</span>
          <i class="fa fa-angle-right"></i>
        </li>
        <li class="role__steps-item" ng-if="isVideoRequired == 'yes'" ng-class="{ 'active' : active_tab == stepstab.showVideo}" ng-show="tabs.showVideo">
          <span class="role__steps-title">Make A Quick Video</span>
          <i class="fa fa-angle-right"></i>
        </li>
        <li class="role__steps-item" ng-class="{ 'active' : active_tab == stepstab.showStan}" ng-show="tabs.showStan">
          <span class="role__steps-title">Standard Questions</span>
        </li>
      </ul>
      <ul class="role__steps-list pvm-tablet-land-visible">
        <li class="role__steps-item main__nav-active" ng-class="{ 'active' : active_tab == stepstab.showPre}" ng-show="tabs.showPre">
          <span class="role__steps-title">Quick Questions</span>
          <div class="pvm-arrow-right"></div>
        </li>
        <li class="role__steps-item" ng-class="{ 'active' : active_tab == stepstab.showReq}" ng-show="tabs.showReq">
          <span class="role__steps-title">Tell Us About Yourself</span>
          <div class="pvm-arrow-right"></div>
        </li>
        <li class="role__steps-item" ng-if="isVideoRequired == 'yes'" ng-class="{ 'active' : active_tab == stepstab.showVideo}" ng-show="tabs.showVideo">
          <span class="role__steps-title">Make A Quick Video</span>
          <div class="pvm-arrow-right"></div>
        </li>
        <li class="role__steps-item" ng-class="{ 'active' : active_tab == stepstab.showStan}" ng-show="tabs.showStan">
          <span class="role__steps-title">Standard Questions</span>
          <div class="pvm-arrow-right"></div>
        </li>
      </ul>
    </div>
  </section>
  <section ng-show="!isPassed && !isFailed" class="middle-pane middle-pane--ra" ng-class="{'ar__main-declaration--div' : active_tab == stepstab.showDec}">
    <div ng-show="role_app_tab_loader == 1" class="ar__loader-div">
      <h3>Please wait.</h3>
      <h4>While we prepare this page for you.</h4>
      <div class="cssload-loading"><i></i><i></i><i></i><i></i></div>
    </div>
    <div ng-show="role_app_tab_loader == 0" class="ar__disclaimer">
      <i class="fa fa-info-circle"></i>
      <span class="ar__disclaimer-msg">This section must be completed and submitted in the same session</span>
    </div>
    <div ng-show="role_app_tab_loader == 0">
      <!-- Quick question BEGIN -->
      <div class="ar__main-div" ng-if="active_tab == stepstab.showPre" ng-controller="QuickQuestionCtrl" ng-show="tabs.showPre">
        <ng-form name="PreApplyForm" novalidate>
          <!--<div class="ar__quickquestion-purplebox-div">
            <div class="ar__purple-box-div">
                <div class="box__float_lefts"><i class="fa fa-user"></i></div>
                <div class="box__float_lefts"><p>have you applied for a role on previewme before? login to your account.</p></div>
                <div class="box__float_rights"><i class="fa fa-close"></i></div>
                <div class="clearfix"></div>
            </div>
            </div>-->
          <div class="ar__quickquestion-content-div">
            <h1 class="ar__main-headers">Quick questions</h1>
            @{{pre_apply.mychoices}}
            <div class="ar__quickquestion-qlist">
              <ul ng-if="api_status == 200" class="app__pre-apply-list">
                <li ng-repeat="q in pre_apply" class="app__pre-apply-item">
                  <div class="ar__quickquestion-qitem">
                    <span class="ar__quickquestion-qitem-number">@{{ $index + 1}}</span>
                    <p class="ar__quickquestion-qitem-item">@{{q.question}}</p>
                  </div>
                  <div class="ar__quickquestion-choices clear-float">
                    <label ng-repeat="level in levels" class="role__answers" ng-if="q.type == 'basic' || q.type == '' || !q.type"
                      ng-class="{'role__answers--yes' :level == 'yes' , 'role__answers--no' :level == 'no', 'role__answers--dev' :level == 'developing', 'role__answers--answered' : (level =='yes' && q.levelYes) || (level =='developing' && q.levelDev) || (level =='no' && q.levelNo)}"
                      >
                    <input type="radio" name="@{{'pre_' + q.id}}" ng-model="q.answer" ng-value="level" ng-change="submit_preapply(q.id, q.answer, q)"> @{{level}}
                    </label>
                    <ul class="radio__options-list" ng-class="{'radio__options-list--gpa' : q.type == 'custom_pre_apply_1' || q.type == 'gpa'}" ng-if="q.type == 'custom_pre_apply_1' || q.type == 'gpa'">
                      <li ng-repeat="choices in q.mychoices" class="radio__options-item">
                        <label ng-click="submit_preapply(q.id, q.answer, q)" class="role__answers" ng-class="{'role__answers--yes' :level == 'yes' , 'role__answers--no' :level == 'no', 'role__answers--dev' :level == 'developing', 'role__answers--answered' : choices.value == gpaWhat}">
                        <input type="radio" ng-value="choices.value" ng-model="q.answer" ng-required> @{{choices.label}}
                        </label>
                      </li>
                    </ul>
                    <div class="r-zslider" ng-if="q.type == 'custom_pre_apply_2'">
                      <rzslider
                        rz-slider-model="q.slider.min"
                        rz-slider-options="q.slider.options" ng-model="q.answer" title="">
                      </rzslider>
                    </div>
                    <ul ng-if="q.sub_questions && (((q.type == 'gpa' || q.type == 'custom_pre_apply_1') && promptCandidate) || (q.type != 'gpa' && q.type != 'custom_pre_apply_1'))" class="ar__sub-list">
                      <li ng-repeat="subs in q.sub_questions" class="ar__sub-item">
                        <p class="ar__quickquestion-qitem-item">@{{subs.question}}</p>
                        <textarea class="ar__quickquestion-qans-text" ng-model="subs.answer" ng-change="submit_preapply(subs.id, subs.answer, subs)" required placeholder="Type here.."></textarea>
                        <div class="r-zslider" ng-if="subs.type == 'custom_pre_apply_2_sub'">
                          <rzslider
                            rz-slider-model="subs.slider.min"
                            rz-slider-options="subs.slider.options" ng-model="subs.answer" title="">
                          </rzslider>
                        </div>
                      </li>
                    </ul>
                  </div>
                  <hr>
                </li>
              </ul>
              <p ng-if="api_status != 200">This step has been completed.</p>
            </div>
          </div>
        </ng-form>
      </div>
      <!-- Quick question END -->
      <!-- CANDIDATE PROFILE BEGIN -->
      <div class="ar__main-div" ng-if="active_tab == stepstab.showReq" ng-controller="TellUsCtrl" ng-show="tabs.showReq">
        <!-- <div class="ar__tellus-content-div" ng-show="showGeneralInfo"> -->
        <div class="ar__tellus-content-div">
          <h1 class="ar__main-headers">Tell us about yourself</h1>
          <div class="ar__tellus-details-div">
            <!-- <div class="ar__tellus-details-inner" ng-hide="showAbout"> -->
            <div class="ar__tellus-details-inner">
              <form name="candidateForm" ng-submit="saveGenInfo()" class="ar__form">
                <h5 class="ar__headers">general details</h5>
                <ul class="ar__gen-info-list">
                  <li class="ar__gen-info-item">
                    <input type="text" placeholder="First name" class="pvm-input-text" ng-model="resProfile.first_name" ng-required="!resProfile.first_name">
                  </li>
                  <li class="ar__gen-info-item ar__gen-info-item--rt">
                    <input type="text" placeholder="Last name" ng-model="resProfile.last_name"  ng-required="!resProfile.last_name" class="pvm-input-text">
                  </li>
                  <li class="ar__gen-info-item">
                    <input type="text" placeholder="Email Address" class="pvm-input-text" ng-model="resProfile.email"  ng-required="!resProfile.email">
                  </li>
                  <li class="ar__gen-info-item ar__gen-info-item--rt">
                    <input type="text" placeholder="Mobile" class="pvm-input-text" ng-model="resProfile.phone_number" ng-required="!resProfile.phone_number">
                  </li>
                  <li class="ar__gen-info-item">
                    <input type="text" placeholder="Location" class="pvm-input-text" ng-model="resProfile.preferred_location.data.display_name">
                  </li>
                  <li class="ar__gen-info-item ar__gen-info-item--rt">
                    <input type="text" placeholder="Location 2" class="pvm-input-text" ng-model="resProfile.preferred_location.data.country.display_name">
                  </li>
                  <li class="ar__gen-info-item ar__gen-info-item--full">
                    <span class="ar__app-req ar__app-req--left ar__app-req--icon ar__app-req--about" ng-show="company.application_requirements.about_me=='yes' && (resProfile.long_description.length <= 0 || resProfile.long_description == NULL)">
                      <div class="ar__tooltip" ng-show="showPvmMessageBout">
                        <i class="fa fa-close" ng-click="showPvmMessageBout=true"></i>
                        <p class="pvm-arrow-msg">About me section is required by this role.</p>
                        <div class="pvm-arrow-down"></div>
                      </div>
                      <i class="fa fa-asterisk" ng-click="showPvmMessageBout =! showPvmMessageBout" ng-mouseover="showPvmMessageBout=true" ng-mouseleave="showPvmMessageBout=false"></i>
                    </span>
                    <span class="ar__app-req ar__app-req--left ar__app-req--icon ar__app-req--about" ng-show="company.application_requirements.about_me=='yes' && (resProfile.long_description.length > 0)">
                      <div class="ar__tooltip" ng-show="showPvmMessageBout">
                        <i class="fa fa-close" ng-click="showPvmMessageBout=true"></i>
                        <p class="pvm-arrow-msg">You already have filled up this section and can proceed with the application but you're free to update this before moving to next step.</p>
                        <div class="pvm-arrow-down"></div>
                      </div>
                      <i class="fa fa-exclamation-triangle" ng-click="showPvmMessageBout =! showPvmMessageBout" ng-mouseover="showPvmMessageBout=true" ng-mouseleave="showPvmMessageBout=false"></i>
                    </span>
                    <textarea placeholder="Take this opportunity to introduce yourself and highlight what makes you unique. Think personal and professional attributes, career goals, skills, achievements, sport, community, teamwork, languages..." ng-model="resProfile.long_description" class="pvm-textarea ar__gen-info-about"></textarea>
                  </li>
                  <li class="ar__gen-info-item ar__gen-info-item--full ar__gen-info-item--rt">
                    <i class="fa fa-spinner fa-spin pvm-spinner pvm-spinner--sm" ng-show="loadGen"></i>
                    <button type="submit" name="Save" class="btn-pvm btn-mini btn-primary" ng-disabled="loadGen">Save</button>
                  </li>
                </ul>
                <hr>
              </form>
            </div>
            <!-- <div class="ar__tellus-details-inner" ng-hide="showEd"> -->
            <div class="ar__tellus-details-inner" ng-show="company.application_requirements.education == 'yes'">
              <h5 class="ar__headers">
                Education History
                <span class="ar__app-req ar__app-req--left ar__app-req--icon  ar__app-req--inline" ng-show="resProfile.qualifications.length > 0">
                  <div class="ar__tooltip" ng-show="showPvmMessageEH">
                    <i class="fa fa-close" ng-click="showPvmMessageEH=false"></i>
                    <p class="pvm-arrow-msg">You already have education history and can proceed with the application but you're free to update this before moving to next step.</p>
                    <div class="pvm-arrow-down"></div>
                  </div>
                  <i class="fa fa-exclamation-triangle" ng-click="showPvmMessageEH =! showPvmMessageEH" ng-mouseover="showPvmMessageEH=true" ng-mouseleave="showPvmMessageEH=false"></i>
                </span>
              </h5>
              <ul class="ar__edu-list">
                <li class="ar__edu-item" ng-repeat="esp in resProfile.qualifications">
                  <div class="ar__edu-funcs">
                    <i class="fa fa-pencil" title="Update" ng-click="EditThisEH(esp)"></i>
                    <i class="fa fa-trash-o" title="Delete" ng-click="DeleteThisEH($index, esp.id)" ng-hide="loadDelESP && esp.id == loadDelESPId"></i>
                    <i class="fa fa-spinner fa-spin" title="Please wait..." ng-show="loadDelESP && esp.id == loadDelESPId"></i>
                  </div>
                  <div ng-hide="esp.id == editEH">
                    <h3 class="ar__edu-deg" ng-class="{'ar__edu-deg--full' : esp.qualification_provider.company_logo.length < 0 || esp.qualification_provider.company_logo.length == null}">@{{esp.degree + ' ' + esp.qualification.display_name}}</h3>
                    <h3 class="ar__edu-university" ng-class="{'ar__edu-university--full' : esp.qualification_provider.company_logo.length < 0 || esp.qualification_provider.company_logo.length == null}">@{{esp.qualification_provider.provider_display_name}}</h3>
                    <h4 class="ar__completed" ng-bind="esp.completed_date | date : 'MMM, yyyy'" ng-show="esp.completed_date != null"></h4>
                    <h4 class="ar__completed" ng-show="esp.completed_date == null">Currently studying</h4>
                    <img ng-src="@{{esp.qualification_provider.company_logo}}" ng-if="esp.qualification_provider.company_logo.length > 0 || esp.qualification_provider.company_logo.length != null" class="arr__edu-img">
                  </div>
                  <div class="ar__edu-field" ng-if="esp.id == editEH">
                    <form ng-submit="editESP(esp.id)" name="editMyEH">
                      <select class="tellus__general-textbox" ng-options="degree.value as degree.name for degree in getDegrees" ng-model="educationHistory.degree" ng-required="!educationHistory.degree">
                        <option selected="selected">Select a degree</option>
                      </select>
                      <div class="clearfix qualification_holder">
                        <input type="text" name="" placeholder="Field of study" value="" class="tellus__general-textbox" ng-keyup="qualificationWatch()" data-id="@{{esp.id}}" ng-model="educationHistory.qualification" ng-required="!educationHistory.qualification">
                        <ul class="pvm-autocomplete-list auto_complete_qualifications ng-hide">
                          <li data-id="@{{q.id}}" ng-repeat="q in eduQualifications | limitTo : 15" class="addAqualification pvm-autocomplete-item" ng-click="selectFOS(q.display_name, q.id)">@{{q.display_name}}</li>
                        </ul>
                      </div>
                      <div class="provider_holder">
                        <input type="text" name="" placeholder="Education provider" value="" ng-keyup="filterQualification(educationHistory.qualification_povider)" ng-model="educationHistory.qualification_povider" ng-required="!educationHistory.qualification_povider">
                        <ul class="pvm-autocomplete-list auto_complete_education_edu ng-hide">
                          <li data-id="@{{provider.id}}" ng-repeat="provider in selected_edu_providers | limitTo : 15" class="pvm-autocomplete-item addSelectedProvider" ng-click="selectedProvider(provider.provider_display_name,provider.id)">@{{provider.provider_display_name}}</li>
                        </ul>
                      </div>
                      <input type="text" name="" placeholder="Date Completion" ng-click="initDatePicker($event)" ng-model="educationHistory.completed_date" class="tellus__general-textbox mydatepicker" ng-disabled="educationHistory.edi_current_study">
                      <label>
                      <input type="checkbox" id="toggle-yes" name="toggle1" ng-value="true" ng-model="educationHistory.edi_current_study"> I currently study here
                      </label>
                      <div class="ar__edu-field ar__edu-field--btn" ng-show="esp.id == editEH">
                        <i class="fa fa-spinner fa-spin pvm-spinner pvm-spinner--sm" ng-show="loadEditESP"></i>
                        <button type="submit" name="Save" class="btn-pvm btn-mini btn-primary" ng-disabled="loadEditESP">Save</button>
                        <input type="button" name="Cancel" value="Cancel" class="btn-pvm btn-mini btn-default" ng-click="cancelESP()">
                      </div>
                    </form>
                  </div>
                </li>
                <li class="ar__edu-item ar__edu-item--none" ng-show="resProfile.qualifications.length <= 0">
                  <span class="ar__app-req" ng-show="company.application_requirements.education == 'yes' && resProfile.qualifications.length <= 0"><i class="fa fa-exclamation"></i> Education History is required by this role.</span>
                </li>
              </ul>
              <ul class="ar__edu-list ar__edu-list--add">
                <li class="ar__edu-item ar__edu-item--add" ng-if="addESP == 1">
                  <form ng-submit="saveNewESP()" name="addMyEH">
                    <select class="tellus__general-textbox" ng-options="degree as degree.value for degree in getDegrees track by degree.value" ng-model="educationHistory.degree" ng-required="!educationHistory.degree">
                      <option selected="selected">Select a degree</option>
                    </select>
                    <div class="clearfix qualification_holder">
                      <input type="text" name="" placeholder="Field of study" value="" class="tellus__general-textbox" ng-keyup="qualificationWatch()" data-id="@{{esp.id}}" ng-model="educationHistory.qualification" ng-required="!educationHistory.qualification">
                      <ul class="pvm-autocomplete-list auto_complete_qualifications ng-hide">
                        <li data-id="@{{q.id}}" ng-repeat="q in eduQualifications | limitTo : 15" class="addAqualification pvm-autocomplete-item" ng-click="selectFOS(q.display_name, q.id)">@{{q.display_name}}</li>
                      </ul>
                    </div>
                    <div class="provider_holder">
                      <input type="text" name="" placeholder="Education provider" value="" ng-keyup="filterQualification(educationHistory.qualification_povider)" ng-model="educationHistory.qualification_povider" ng-required="!educationHistory.qualification_povider">
                      <ul class="pvm-autocomplete-list auto_complete_education_edu ng-hide">
                        <li data-id="@{{provider.id}}" ng-repeat="provider in selected_edu_providers | limitTo : 15" class="pvm-autocomplete-item addSelectedProvider" ng-click="selectedProvider(provider.provider_display_name,provider.id)">@{{provider.provider_display_name}}</li>
                      </ul>
                    </div>
                    <input type="text" name="" placeholder="Date Completion" ng-click="initDatePicker($event)" ng-model="educationHistory.completed_date" class="tellus__general-textbox mydatepicker" ng-disabled="educationHistory.edi_current_study">
                    <label>
                    <input type="checkbox" id="toggle-yes" name="toggle1" ng-value="true" ng-model="educationHistory.edi_current_study"> I currently study here
                    </label>
                    <div class="ar__edu-item ar__edu-item--r">
                      <i class="fa fa-spinner fa-spin pvm-spinner pvm-spinner--sm" ng-show="loadAddESP"></i>
                      <button type="submit" name="Save" class="btn-pvm btn-mini btn-primary" ng-disabled="loadAddESP">Save</button>
                      <input type="button" name="Cancel" value="Cancel" class="btn-pvm btn-mini btn-default" ng-click="toggleAddESP()">
                    </div>
                  </form>
                </li>
                <li class="ar__edu-item ar__edu-item--r  ar__edu-item--btn">
                  <input type="button" name="Save" value="Add Education" class="btn-pvm btn-mini btn-primary" ng-disabled="addESP == 1" ng-click="toggleAddESP()">
                </li>
              </ul>
            </div>
            <!-- Work History List BEGIN -->
            <div class="ar__tellus-details-inner" ng-show="company.application_requirements.work_experience == 'yes'">
              <h5 class="ar__headers">
                Work Experience
                <span class="ar__app-req ar__app-req--left ar__app-req--icon  ar__app-req--inline" ng-show="resProfile.work_history.length > 0">
                  <div class="ar__tooltip" ng-show="showPvmMessageWH">
                    <i class="fa fa-close" ng-click="showPvmMessageWH=false"></i>
                    <p class="pvm-arrow-msg">You already have work experience and can proceed with the application but you're free to update this before moving to next step.</p>
                    <div class="pvm-arrow-down"></div>
                  </div>
                  <i class="fa fa-exclamation-triangle" ng-click="showPvmMessageWH =! showPvmMessageWH" ng-mouseover="showPvmMessageWH=true" ng-mouseleave="showPvmMessageWH=false"></i>
                </span>
              </h5>
              <ul class="ar__wh-list">
                <li class="ar__wh-item" ng-repeat="wh in resProfile.work_history" ng-init="outerIndex = $index">
                  <div class="tellus__workexp-chevron">
                    <i class="fa fa-pencil" title="Update" ng-click="EditThisWH(wh.id)"></i>
                    <i class="fa fa-trash-o" title="Delete" ng-click="DeleteThisWH($index, wh.id)" ng-hide="loadDelWH && wh.id == loadDelWHId"></i>
                    <i class="fa fa-spinner fa-spin" title="Please wait..." ng-show="loadDelWH && wh.id == loadDelWHId"></i>
                  </div>
                  <!-- VIEW WORK HISTORY FORM BEGIN -->
                  <div ng-hide="!updateThisWorkhistory && chvron == wh.id">
                    <h4 class="ar__wh-company-name" ng-if="( chvron != wh.id) || chvron == 0">@{{wh.company_name}}</h4>
                    <h4 class="ar__wh-job-title" ng-if="( chvron != wh.id) || chvron == 0">@{{wh.job_title}}</h4>
                    <p ng-bind="wh.display_date" class="ar__wh-completed" ng-if="( chvron != wh.id) || chvron == 0"></p>
                    <p ng-if="( chvron != wh.id) || chvron == 0" ng-show="wh.salary > 0" class="ar__wh-completed">$ @{{wh.salary}}</p>
                    <h4 class="ar__subheaders" ng-show="wh.key_accountabilities.length > 0">
                      Key accountabilities
                    </h4>
                    <ul class="ar__wh-accnt-list">
                      <li class="ar__wh-accnt-item ar__wh-accnt-item--display" ng-repeat="accnt in wh.key_accountabilities track by $index">
                        <span class="ar__details"> @{{wh.key_accountabilities[$index]}}</span><span ng-if="[$index] < (wh.key_accountabilities.length-1)" class="ar__details">,&nbsp;</span>
                      </li>
                    </ul>
                    <h4 class="ar__subheaders" ng-show="wh.description.length > 0">Job in a nutshell</h4>
                    <p class="ar__details">@{{wh.description}}</p>
                    <ul class="ar__wh-accnt-list">
                      <li class="ar__wh-accnt-item" ng-repeat="(key, value) in wh.industries_display">
                        <h4 class="ar__subheaders">@{{key}}</h4>
                        <h4 class="ar__details">@{{value}}</h4>
                      </li>
                      <li class="ar__wh-accnt-item ar__wh-accnt-item--more">
                        <button class="btn-pvm btn-mini btn_pvm-violet elem_float-r" ng-if="updateThisWorkhistory_id == wh.id" ng-click="AddMoreResponsiblity($index)">Add more</button>
                        <span ng-if="maxLimitReachedCreate == 10">Max limit reached</span>
                      </li>
                    </ul>
                  </div>
                  <!-- VIEW HISTORY FORM END -->
                  <!-- EDIT WORK HISTORY FORM BEGIN -->
                  <form ng-submit="UpdateThisWH(wh, wh.id)" name="editMyWH">
                    <div ng-if="!updateThisWorkhistory && chvron == wh.id">
                      <input type="text" name="" class="pvm-input-text ar__wh-company-name" ng-class="{'tellus__update-fields' : updateThisWorkhistory_id != wh.id}" ng-disabled="updateThisWorkhistory && updateThisWorkhistory_id != wh.id" ng-model="wh.company_name" ng-required="!wh.company_name">
                      <input type="text" name=""" class="pvm-input-text ar__wh-job-title" ng-class="{'tellus__update-fields' : updateThisWorkhistory_id != wh.id}" ng-disabled="updateThisWorkhistory && updateThisWorkhistory_id != wh.id" ng-model="wh.job_title" ng-required="!wh.job_title">
                      <input type="text" placeholder="Start Date" class="pvm-input-text ar__wh-work-range mydatepicker" ng-click="initDatePicker($event)" ng-model="wh.start_date">
                      <input type="text" placeholder="End Date " class="pvm-input-text ar__wh-work-range mydatepicker" ng-click="initDatePicker($event)" ng-model="wh.end_date">
                      <!-- <input type="text" class="pvm-input-text ar__wh-salary-input" ng-model="wh.salary" ng-required="!wh.salary" placeholder="Salary (Confidential and optional)"> -->
                      <!-- 05/03/2018 Req by Johnny, salary is not required -->
                      <input type="text" class="pvm-input-text ar__wh-salary-input" ng-model="wh.salary" placeholder="Salary (Confidential and optional)">
                      <!-- 05/03/2018 Req by Johnny, salary is not required -->
                      <h4 class="ar__subheaders">Key accountabilities </h4>
                      <ul class="ar__wh-accnt-list">
                        <li class="ar__wh-accnt-item" ng-repeat="accnt in wh.key_accountabilities track by $index" ng-init="innerIndex = $index">
                          <input type="text" name="" ng-model="wh.key_accountabilities[$index]" class="pvm-input-text ar__wh-accnt-text">
                          <i class="fa fa-close" ng-click="delAcct(outerIndex, innerIndex)"></i>
                        </li>
                        <li class="ar__wh-accnt-item ar__wh-accnt-item--more">
                          <i class="fa fa-plus" ng-if="updateThisWorkhistory_id == wh.id" title="Add accountabilities" ng-click="AddMoreResponsiblity($index)"><span>Add</span></i>
                          <span ng-if="maxLimitReachedCreate == 10">Max limit reached.</span>
                        </li>
                      </ul>
                      <h4 class="ar__subheaders">Job in a nutshell</h4>
                      <textarea ng-model="wh.description" class="pvm-textarea" auto-resize></textarea>
                      <ul class="ar__wh-accnt-list">
                        <li class="ar__wh-accnt-item" ng-repeat="(key, value) in wh.industries_display">
                          <h4 class="ar__subheaders">
                            Current Classification: @{{'(' + key + ')'}}
                          </h4>
                          <h4 class="ar__details">
                            Current Sub Classification: @{{'(' + value + ')'}}
                          </h4>
                        </li>
                      </ul>
                      <h4 class="ar__subheaders">
                        Classification
                      </h4>
                      <select ng-model="myIndus" ng-change="changeSubIndustriesEdit()" ng-options="add_industry as add_industry.display_name for add_industry in all_industries track by add_industry.id" class="pvm-input-select">
                        <option value="">Please select a Classification..</option>
                      </select>
                      <h4 class="ar__subheaders">Sub Classification</h4>
                      <select ng-model="mySubIndustry" ng-change="selectSubIndustryEdit()" ng-options="add_sub_industry as add_sub_industry.display_name for add_sub_industry in mySubIndus track by add_sub_industry.id" class="pvm-input-select">
                        <option value="">Please select a Sub Classification..</option>
                      </select>
                    </div>
                    <div class="ar__wh-item ar__wh-item--r" ng-if="!updateThisWorkhistory && chvron == wh.id">
                      <i class="fa fa-spinner fa-spin pvm-spinner pvm-spinner--sm" ng-show="loadEditWH"></i>
                      <button type="submit" name="Save" class="btn-pvm btn-mini btn-primary" ng-disabled="loadEditWH">Save</button>
                      <input type="button" name="Cancel" value="Cancel" class="btn-pvm btn-mini btn-default" ng-click="CancelEditWH(wh.id)">
                    </div>
                  </form>
                  <!-- EDIT WORK HISTORY FORM END -->
                </li>
                <li class="ar__wh-item" ng-if="addWH == 1">
                  <!-- ADD WORK HISTORY BEGIN -->
                  <form ng-submit="saveNewWork()" name="addMyWH">
                    <input type="text" name="" placeholder="Company Name" value="" ng-model="workHistory.company_name" ng-required="!workHistory.company__name" class="pvm-input-text">
                    <div class="clearfix">
                      <input type="text" name="" placeholder="Job/Role Title" value="" class="pvm-input-text tellus__general-textbox" ng-model="workHistory.job_title" ng-required="!workHistory.job_title">
                      <select name="work_type" ng-options="s.id as s.display_name for s in work_types_wh track by s.id" class="pvm-input-select" ng-model="workHistory.work_type" ng-required="!workHistory.work_type">
                        <option value="">Work Type</option>
                      </select>
                    </div>
                    <input type="text" placeholder="Start Date" class="ar__wh-start-date mydatepicker pvm-input-text" ng-click="initDatePicker($event)" ng-model="workHistory.start_date" ng-required="!workHistory.start_date">
                    <input type="text" placeholder="End Date " class="ar__wh-end-date mydatepicker pvm-input-text" ng-click="initDatePicker($event)" ng-model="workHistory.end_date" ng-disabled="currently_work_here">
                    <label><input type="checkbox" ng-model="workHistory.currently_work_here" ng-true-value="true" ng-false-value="false"> I currently work here</label>
                    <input type="number" name="salary" value="@{{workHistory.salary}}" placeholder="Salary" class="pvm-input-text" ng-model="workHistory.salary">
                    <h4 class="ar__subheaders">Key accountabilities </h4>
                    <ul class="ar__wh-accnt-list">
                      <li class="ar__wh-accnt-item" ng-repeat="accnt in workHistory.key_accountabilities track by $index">
                        <input type="text" name="" ng-model="workHistory.key_accountabilities[$index]" class="pvm-input-text ar__wh-accnt-text">
                        <i class="fa fa-close" ng-click="delAcct2(workHistory.key_accountabilities)"></i>
                      </li>
                      <li class="ar__wh-accnt-item ar__wh-accnt-item--more">
                        <i class="fa fa-plus" title="Add accountabilities" ng-click="AddMoreResponsiblity2()"><span>Add</span></i>
                      </li>
                    </ul>
                    <textarea placeholder="Job in a nutshell" ng-model="workHistory.description" class="pvm-textarea ar__wh-nutshell"></textarea>
                    <h4 class="ar__subheaders">Classification</h4>
                    <select ng-model="addIndustry" ng-change="changeSubIndustriesAdd()" ng-options="add_industry as add_industry.display_name for add_industry in all_industries track by add_industry.id" class="pvm-input-select">
                      <option value="">Please select a Classification..</option>
                    </select>
                    <h4 class="ar__subheaders">Sub Classification</h4>
                    <select ng-model="addSubIndustry" ng-change="selectSubIndustryAdd()" ng-options="add_sub_industry as add_sub_industry.display_name for add_sub_industry in AddSubIndus track by add_sub_industry.id" class="pvm-input-select">
                      <option value="">Please select a Sub Classification..</option>
                    </select>
                    <div class="ar__wh-item ar__wh-item--r" ng-if="addWH == 1">
                      <i class="fa fa-spinner fa-spin pvm-spinner pvm-spinner--sm" ng-show="loadAddWH"></i>
                      <button type="Submit" name="Save" class="btn-pvm btn-mini btn-primary" ng-disabled="loadAddWH">Save</button>
                      <input type="button" name="Cancel" value="Cancel" class="btn-pvm btn-mini btn-default" ng-click="toggleAddWH()">
                    </div>
                  </form>
                  <!-- ADD WORK HISTORY END -->
                </li>
                <li class="ar__wh-item ar__wh-item--none" ng-show="resProfile.work_history.length <= 0">
                  <span class="ar__app-req" ng-show="company.application_requirements.work_experience=='yes' && resProfile.work_history.length <= 0"><i class="fa fa-exclamation"></i> Work History is required by this role.</span>
                </li>
                <li class="ar__wh-item ar__wh-item--r ar__wh-item--btn">
                  <label class="ar__wh-workforce" ng-hide="resProfile.work_history.length > 0">
                  <input type="checkbox" ng-change="newToWorkForce(newToWorkForceField)" ng-model="newToWorkForceField"> &nbsp; I am new to workforce
                  </label>
                  <input type="button" name="Save" value="Add Work History" class="btn-pvm btn-mini btn-primary" ng-disabled="addWH == 1 || newToWorkForceField" ng-click="toggleAddWH()">
                </li>
              </ul>
            </div>
            <!-- Work History List END -->
            <div class="ar__tellus-details-inner" ng-show="company.application_requirements.references == 'yes'">
              <h5 class="ar__headers">
                References
                <span class="ar__app-req ar__app-req--left ar__app-req--icon  ar__app-req--inline" ng-show="references.length > 0">
                  <div class="ar__tooltip" ng-show="showPvmMessageRef">
                    <i class="fa fa-close" ng-click="showPvmMessageRef=false"></i>
                    <p class="pvm-arrow-msg">You already have references and can proceed with the application but you're free to update this before moving to next step.</p>
                    <div class="pvm-arrow-down"></div>
                  </div>
                  <i class="fa fa-exclamation-triangle" ng-click="showPvmMessageRef =! showPvmMessageRef" ng-mouseover="showPvmMessageRef=true" ng-mouseleave="showPvmMessageRef=false"></i>
                </span>
              </h5>
              <ul class="ar__ref-list">
                <li class="ar__ref-item" ng-repeat="ref in references">
                  <div class="ar__ref-funcs">
                    <i class="fa fa-pencil" title="Update" ng-click="editThisRef($index)"></i>
                    <i class="fa fa-trash-o" title="Delete" ng-click="deleteThisRef($index, ref.id)" ng-hide="loadDelRef && ref.id == loadDelRefId"></i>
                    <i class="fa fa-spinner fa-spin" title="Please wait..." ng-show="loadDelRef && ref.id == loadDelRefId"></i>
                  </div>
                  <div ng-hide="ref.id == editRef">
                    <p ng-bind-html="ref.description" class="ar__ref-desc"></p>
                    <p class="ar__ref-emp">
                      <span class="ar__ref-emp-name">@{{ref.employer_name}}</span>, <span class="ar__ref-comp">@{{ref.company_name}}</span><br>
                      <span class="ar__ref-email">@{{ref.contact_email}}</span><br>
                      <span class="ar__ref-phone">@{{ref.contact_phone}}</span>
                    </p>
                  </div>
                  <form ng-submit="editReference(ref)" name="editMyRef">
                    <div ng-if="ref.id == editRef">
                      <textarea placeholder="Description" ng-model="ref.description" class="pvm-textarea ar__ref-desc-edit" ng-required="!ref.description"></textarea>
                      <input type="text" placeholder="Employer Name" ng-model="ref.employer_name" ng-required="!ref.employer_name" class="pvm-input-text">
                      <input type="text" placeholder="Company" ng-model="ref.company_name" class="pvm-input-text">
                      <input type="text" placeholder="Email Address" ng-model="ref.contact_email" class="pvm-input-text">
                      <input type="text" placeholder="Contact Number" ng-model="ref.contact_phone" class="pvm-input-text">
                    </div>
                    <div class="ar__ref-item ar__ref-item--r" ng-if="ref.id == editRef">
                      <i class="fa fa-spinner fa-spin pvm-spinner pvm-spinner--sm" ng-show="loadEditRef"></i>
                      <button type="submit" name="Save" class="btn-pvm btn-mini btn-primary" ng-disabled="loadEditRef">Save</button>
                      <input type="button" name="Cancel" value="Cancel" class="btn-pvm btn-mini btn-default" ng-click="cancelRef()">
                    </div>
                  </form>
                </li>
                <li class="ar__ref-item" ng-show="showRef">
                  <form ng-submit="AddReference()" name="addMyRef">
                    <textarea placeholder="Description" ng-model="postreference.description" ng-required="!postreference.description" class="pvm-textarea"></textarea>
                    <input type="text" placeholder="Employer Name" ng-model="postreference.employer_name" ng-required="!postreference.employer_name" class="pvm-input-text">
                    <input type="text" placeholder="Company" ng-model="postreference.company_name" ng-required="!postreference.company__name" class="pvm-input-text">
                    <input type="text" placeholder="Email Address" ng-model="postreference.contact_email" class="pvm-input-text">
                    <input type="text" placeholder="Contact Number" ng-model="postreference.contact_phone" class="pvm-input-text">
                    <div class="ar__ref-item ar__ref-item--r" ng-show="showRef">
                      <i class="fa fa-spinner fa-spin pvm-spinner pvm-spinner--sm" ng-show="loadAddRef"></i>
                      <button type="submit" value="Save" class="btn-pvm btn-mini btn-primary" ng-disabled="loadAddRef">Save</button>
                      <input type="button" name="Cancel" value="Cancel" class="btn-pvm btn-mini btn-default" ng-click="showRef=false">
                    </div>
                  </form>
                </li>
                <li class="ar__ref-item ar__ref-item--none" ng-show="references.length <= 0">
                  <span class="ar__app-req" ng-show="company.application_requirements.references=='yes' && resProfile.references.length <= 0"><i class="fa fa-exclamation"></i> Reference is required by this role.</span>
                </li>
                <li class="ar__ref-item ar__ref-item--r">
                  <input type="button" name="Save" value="Add Reference" class="btn-pvm btn-mini btn-primary" ng-click="showRef=true" ng-disabled="showRef">
                </li>
              </ul>
            </div>
          </div>
        </div>
        <!-- <div class="ar__tellus-content-div" ng-show="showUploadss"> -->
        <div class="ar__tellus-content-div">
          <!-- <div class="ar__tellus-content-div"> -->
          <h1 class="ar__main-headers">Show us your..</h1>
          <div class="ar__tellus-details-div">
            <div class="ar__tellus-details-inner" ng-hide="showProfileImgs">
              <!-- <div class="ar__tellus-details-inner"> -->
              <h5 class="ar__headers">
                photo
                <!-- <span class="ar__app-req" ng-show="company.application_requirements.profile_image=='yes' && resProfile.docs.profile_image <= 0"><i class="fa fa-exclamation"></i> Profile photo is required by this role.</span> -->
              </h5>
              <div class="ar__tellus-general-div">
                <div class="clearfix">
                  <div ng-if="!resProfile.docs.profile_image" class="member-initials member-initials--lg @{{profile_img_color}}">@{{profile_img_initial}}</div>
                  <img ng-if="resProfile.docs.profile_image" ng-src="@{{resProfile.docs.profile_image}}" class="tellus__upload-thumbnail">
                  <input type="button" name="upload_photo" value="Upload" class="btn-pvm btn-mini btn-primary tellus__upload-btn" data-toggle="modal" data-target="#pmvImageModalNew">
                  <!-- <input id="test_aplod" type="file" name="document" value="test Upload" onchange="angular.element(this).scope().aplod(this)">
                    <img id="test_aplod_img" src="" height="200" alt="Image preview..."> -->
                </div>
              </div>
              <hr>
            </div>
            <!-- <div class="ar__tellus-details-inner" ng-show="showUploadDocs"> -->
            <div class="ar__tellus-details-inner" ng-show="company.application_requirements.resume=='yes' || company.application_requirements.portfolio=='yes' || company.application_requirements.portfolio=='yes' || company.application_requirements.transcript=='yes'">
              <!-- <div class="ar__tellus-details-inner"> -->
              <h5 class="ar__headers">
                supporting documents
                <!--<span class="ar__app-req" ng-show="(company.application_requirements.resume=='yes' || company.application_requirements.portfolio=='yes' || company.application_requirements.cover_letter=='yes' || company.application_requirements.transcript=='yes')
                  && (!candidate_docs.resume.doc_url || !candidate_docs.portfolio.doc_url|| !candidate_docs.cover_letter.doc_url || !candidate_docs.transcript.doc_url)"><i class="fa fa-exclamation"></i> Please check required Document/s below</span>-->
              </h5>
              <div class="ar__tellus-general-div" ng-show="company.application_requirements.resume=='yes'">
                <span class="ar__app-req ar__app-req--left ar__app-req--icon" ng-show="!candidate_docs.resume.doc_url">
                  <div class="ar__tooltip" ng-show="showPvmMessageR">
                    <i class="fa fa-close" ng-click="showPvmMessageR=true"></i>
                    <p class="pvm-arrow-msg">Resumé is required by this role.</p>
                    <div class="pvm-arrow-down"></div>
                  </div>
                  <i class="fa fa-asterisk" ng-click="showPvmMessageR =! showPvmMessageR" ng-mouseover="showPvmMessageR=true" ng-mouseleave="showPvmMessageR=false"></i>
                </span>
                <span class="ar__app-req ar__app-req--left ar__app-req--icon" ng-show="candidate_docs.resume.doc_url">
                  <div class="ar__tooltip" ng-show="showPvmMessageR">
                    <i class="fa fa-close" ng-click="showPvmMessageR=true"></i>
                    <p class="pvm-arrow-msg">You  have previously uploaded resume and can proceed with the application but you're free to update this before moving to next step.</p>
                    <div class="pvm-arrow-down"></div>
                  </div>
                  <i class="fa fa-exclamation-triangle" ng-click="showPvmMessageR =! showPvmMessageR" ng-mouseover="showPvmMessageR=true" ng-mouseleave="showPvmMessageR=false"></i>
                </span>
                <a href="@{{candidate_docs.resume.doc_url}}" ng-if="candidate_docs.resume.doc_url" class="ar__tell-link">@{{candidate_docs.resume.doc_filename}}</a>
                <p class="ar__tell-link ar__tell-link--none" ng-if="!candidate_docs.resume.doc_url">
                  Please upload Resumé.
                </p>
                <button ng-click="uploadFile('resume', '')" class="btn-pvm btn-mini btn-primary tellus__upload-btn">Upload</button>
              </div>
              <div class="ar__tellus-general-div" ng-show="company.application_requirements.portfolio=='yes'">
                <span class="ar__app-req ar__app-req--left ar__app-req--icon" ng-show="candidate_docs.portfolio.doc_url">
                  <div class="ar__tooltip" ng-show="showPvmMessageP">
                    <i class="fa fa-close" ng-click="showPvmMessageP=false"></i>
                    <p class="pvm-arrow-msg">You have previously uploaded portfolio and can proceed with the application but you're free to update this before moving to next step.</p>
                    <div class="pvm-arrow-down"></div>
                  </div>
                  <i class="fa fa-exclamation-triangle" ng-click="showPvmMessageP =! showPvmMessageP" ng-mouseover="showPvmMessageP=true" ng-mouseleave="showPvmMessageP=false"></i>
                </span>
                <span class="ar__app-req ar__app-req--left ar__app-req--icon" ng-show="!candidate_docs.portfolio.doc_url">
                  <div class="ar__tooltip" ng-show="showPvmMessageP">
                    <i class="fa fa-close" ng-click="showPvmMessageP=false"></i>
                    <p class="pvm-arrow-msg">Portfolio is required by this role.</p>
                    <div class="pvm-arrow-down"></div>
                  </div>
                  <i class="fa fa-asterisk" ng-click="showPvmMessageP =! showPvmMessageP" ng-mouseover="showPvmMessageP=true" ng-mouseleave="showPvmMessageP=false"></i>
                </span>
                <a href="@{{candidate_docs.portfolio.doc_url}}" ng-if="candidate_docs.portfolio.doc_url" class="ar__tell-link">@{{candidate_docs.portfolio.doc_filename}}</a>
                <p class="ar__tell-link ar__tell-link--none" ng-if="!candidate_docs.portfolio.doc_url" ng-show="company.application_requirements.portfolio=='yes'">
                  Please upload portfolio.
                </p>
                <button ng-click="uploadFile('portfolio', '')" class="btn-pvm btn-mini btn-primary tellus__upload-btn">Upload</button>
              </div>
              <div class="ar__tellus-general-div" ng-show="company.application_requirements.cover_letter=='yes'">
                <span class="ar__app-req ar__app-req--left ar__app-req--icon" ng-show="!candidate_docs.cover_letter.doc_url">
                  <div class="ar__tooltip" ng-show="showPvmMessageCL">
                    <i class="fa fa-close" ng-click="showPvmMessageCL=false"></i>
                    <p class="pvm-arrow-msg">Cover letter is required by this role.</p>
                    <div class="pvm-arrow-down"></div>
                  </div>
                  <i class="fa fa-asterisk" ng-click="showPvmMessageCL =! showPvmMessageCL" ng-mouseover="showPvmMessageCL=true" ng-mouseleave="showPvmMessageCL=false"></i>
                </span>
                <span class="ar__app-req ar__app-req--left ar__app-req--icon" ng-show="candidate_docs.cover_letter.doc_url">
                  <div class="ar__tooltip" ng-show="showPvmMessageCL">
                    <i class="fa fa-close" ng-click="showPvmMessageCL=false"></i>
                    <p class="pvm-arrow-msg">You have previously uploaded cover letter and can proceed with the application but you're free to update this before moving to next step.</p>
                    <div class="pvm-arrow-down"></div>
                  </div>
                  <i class="fa fa-exclamation-triangle" ng-click="showPvmMessageCL =! showPvmMessageCL" ng-mouseover="showPvmMessageCL=true" ng-mouseleave="showPvmMessageCL=false"></i>
                </span>
                <a href="@{{candidate_docs.cover_letter.doc_url}}" ng-if="candidate_docs.cover_letter.doc_url" class="ar__tell-link">@{{candidate_docs.cover_letter.doc_filename}}</a>
                <p class="ar__tell-link ar__tell-link--none" ng-if="!candidate_docs.cover_letter.doc_url">
                  Please upload a Cover Letter.
                </p>
                <button ng-click="uploadFile('cover_letter', 'cover_letter')" class="btn-pvm btn-mini btn-primary tellus__upload-btn">Upload</button>
                <!-- <input type="button" value="Cover" ng-click="uploadFile('cover')" class="btn-pvm btn-mini btn-primary tellus__upload-btn"> -->
              </div>
              <div class="ar__tellus-general-div ar__tellus-general-div--none" ng-show="company.application_requirements.transcript=='yes'">
                <span class="ar__app-req ar__app-req--left ar__app-req--icon" ng-show="!candidate_docs.transcript.doc_url">
                  <div class="ar__tooltip" ng-show="showPvmMessageT">
                    <i class="fa fa-close" ng-click="showPvmMessageT=false"></i>
                    <p class="pvm-arrow-msg">Transcript is required by this role.</p>
                    <div class="pvm-arrow-down"></div>
                  </div>
                  <i class="fa fa-asterisk" ng-click="showPvmMessageT =! showPvmMessageT" ng-mouseover="showPvmMessageT=true" ng-mouseleave="showPvmMessageT=false"></i>
                </span>
                <span class="ar__app-req ar__app-req--left ar__app-req--icon" ng-show="candidate_docs.transcript.doc_url">
                  <div class="ar__tooltip" ng-show="showPvmMessageT">
                    <i class="fa fa-close" ng-click="showPvmMessageT=false"></i>
                    <p class="pvm-arrow-msg">You have previously uploaded transcript and can proceed with the application but you're free to update this before moving to next step.</p>
                    <div class="pvm-arrow-down"></div>
                  </div>
                  <i class="fa fa-exclamation-triangle" ng-click="showPvmMessageT =! showPvmMessageT" ng-mouseover="showPvmMessageT=true" ng-mouseleave="showPvmMessageT=false"></i>
                </span>
                <a href="@{{candidate_docs.transcript.doc_url}}" class="ar__tell-link">@{{candidate_docs.transcript.doc_filename}}</a>
                <p class="ar__tell-link ar__tell-link--none" ng-if="!candidate_docs.transcript.doc_url">Please upload Transcript.</p>
                <button ng-click="uploadFile('transcript', 'transcript')" class="btn-pvm btn-mini btn-primary tellus__upload-btn">Upload</button>
              </div>
            </div>
          </div>
        </div>
        <div class="cleafix"></div>
        <!-- <div class="ar__proceed-notification-div" ng-if="requirements_check.length == 0">
          Your profile is complete to the standard required by the employer.
          Click "Next" to proceed.
          </div> -->
      </div>
      <!-- CANDIDATE PROFILE END -->
      <!-- Make a quick video BEGIN -->
      <div class="ar__main-div ar__negate-margin" ng-if="active_tab == stepstab.showVideo" ng-controller="MakeVideoCtrl">
        <div class="ar__video-content-div" ng-hide="showVid">
          <!-- <div class="ar__video-content-div"> -->
          <!-- <h1>Make a quick video</h1> -->
          <h1>
            Let's make your generic profile video!
          </h1>
          <div class="video__big-thumbnail-div">
            <div class="video__big-thumbnail-innner-div" ng-show="VideoStatus == 'nothing'">
              <div>
                <h4>No video has been found yet. Start by uploading a video or record a new one below.</h4>
              </div>
            </div>
            <div ng-show="VideoStatus == ''">
              <video id="profile_video" class="azuremediaplayer amp-default-skin" height="500">
                <p class="amp-no-js">
                  To view this video please enable JavaScript, and consider upgrading to a web browser that supports HTML5 video
                </p>
              </video>
            </div>
            <div ng-show="showVideoLoding" class="video__big-thumbnail-innner-div">
              <video poster="/images/video_preload.gif" height="500"></video>
            </div>
            <div ng-show="VideoStatus == 'uploading'" class="text-center video__big-thumbnail-innner-div--success">
              <!-- <i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><br /> -->
              <div>
                <h4>Uploaded file is now being processed</h4>
              </div>
              <div style="margin-bottom: 25px">
                Please do not refresh this page. There is no need to wait for the processing to finish. Go ahead and click Next.
                <!-- <br /><br /><br /><br /><br />
                  <i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><br />
                  @{{encoding_job_status}} @{{encoding_progress + '%'}}
                  <p ng-if="encoding_progress == 100">Video is almost ready. Please wait for a few seconds..</p> -->
              </div>
            </div>
          </div>
          <div style="font-size: 14px; line-height: 24px;">
            <a href="https://previewme.co/resources" target="_blank">
            Tips to record the perfect video
            </a>
          </div>
          <div class="video__delete-button" ng-show="showDeleteVideo">
            <button value="Delete" ng-click="deleteVideo()" class="btn-pvm btn-primary">
            <i class="fa fa-trash"></i>
            Delete
            </button>
          </div>
        </div>
        <div class="ar__video-lib-div" ng-hide="showVid">
          <!-- <div class="ar__video-lib-div"> -->
          <div class="video__create-div">
            <h5>Create a New Video</h5>
            <div class="video__createrec-div">
              <div class="video__createrec-inner-div">
                <div class="clearfix video__createrec-details">
                  <p class="video__createrec-details-p"><i class="fa fa-upload video__upload-logo"></i></p>
                  <p class="video__createrec-details-p">
                  <div class="video__upload-label">Drag & drop or upload your video</div>
                  </p>
                </div>
                <input type="button" name="" value="Browse" ng-click="openVideoModal()" class="btn-pvm btn-primary">
              </div>
              <div class="video__createrec-inner-div">
                <div class="clearfix video__createrec-details">
                  <p class="video__createrec-details-p"><i class="fa fa-upload video__upload-logo"></i></p>
                  <p class="video__createrec-details-p">
                  <div class="video__upload-label">Record a new video</div>
                  </p>
                </div>
                <input type="button" name="" value="Start" data-toggle="modal" ng-click="startVideo()" class="btn-pvm btn-primary">
              </div>
            </div>
          </div>
          <div class="video__divider-div"></div>
          <!--  <div class="video__create-div">
            <h5>Choose from your video library</h5>
            <div class="video__createrec-div" style="overflow-y: auto;overflow-x: hidden;height: 7vw;">
                <div style="    width: 46vw;">
                    <div class="video__choose-inner-div">
                        <div class="clearfix video__choose-details">
                            <i class="fa fa-play video__choose-logo"></i>
                        </div>
                        <p>junior-designer_application.mov</p>
                    </div>
            
                    <div class="video__choose-inner-div">
                        <div class="clearfix video__choose-details">
                            <i class="fa fa-play video__choose-logo"></i>
                        </div>
                        <p>senior-designer_application.mov</p>
                    </div>
            
                    <div class="video__choose-inner-div">
                        <div class="clearfix video__choose-details">
                            <i class="fa fa-play video__choose-logo"></i>
                        </div>
                        <p>my_third_icebreaking_video.mov</p>
                    </div>
            
                    <div class="video__choose-inner-div">
                        <div class="clearfix video__choose-details">
                            <i class="fa fa-play video__choose-logo"></i>
                        </div>
                        <p>web-designer-UIUX-application-video.mov</p>
                    </div>
            
                    <div class="video__choose-inner-div">
                        <div class="clearfix video__choose-details">
                            <i class="fa fa-play video__choose-logo"></i>
                        </div>
                        <p>old_but_gold.mov</p>
                    </div>
            
                    <div class="video__choose-inner-div">
                        <div class="clearfix video__choose-details">
                            <i class="fa fa-play video__choose-logo"></i>
                        </div>
                        <p>old_but_gold.mov</p>
                    </div>
            
                    <div class="video__choose-inner-div">
                        <div class="clearfix video__choose-details">
                            <i class="fa fa-play video__choose-logo"></i>
                        </div>
                        <p>old_but_gold.mov</p>
                    </div>
            
                    <div class="video__choose-inner-div">
                        <div class="clearfix video__choose-details">
                            <i class="fa fa-play video__choose-logo"></i>
                        </div>
                        <p>old_but_gold.mov</p>
                    </div>
            
                    <div class="video__choose-inner-div">
                        <div class="clearfix video__choose-details">
                            <i class="fa fa-play video__choose-logo"></i>
                        </div>
                        <p>old_but_gold.mov</p>
                    </div>
            
                    <div class="video__choose-inner-div">
                        <div class="clearfix video__choose-details">
                            <i class="fa fa-play video__choose-logo"></i>
                        </div>
                        <p>old_but_gold.mov</p>
                    </div>
                    <div class="clearfix"></div>
            
                </div>
            </div>
            
            </div> -->
          <div class="clearfix"></div>
        </div>
        <!--    <div class="ar__proceed-notification-div" ng-if="showVid">
          A profile video is found. Click "Next" to proceed.
          </div> -->
      </div>
      <!-- Make a quick video END -->
      <!-- Standard Question BEGIN -->
      <div class="ar__main-div" ng-if="active_tab == stepstab.showStan" ng-controller="StandardQuestionCtrl" ng-show="tabs.showStan">
        <ng-form name="StandardQuestionForm" novalidate>
          <div class="ar__quickquestion-content-div">
            <h1>Standard questions</h1>
            <div class="ar__quickquestion-qlist">
              <ul class="app__standard-quest-list">
                <!-- Non bespoke questions BEGIN -->
                <!-- Company Declaration BEGIN -->
                <li ng-repeat="q1 in pre_standard" ng-if="q1.question_type == 'comp_declaration'" class="app__standard-quest-item">
                  <div class="ar__quickquestion-qitem" ng-if="q1.type != 'custom_pre_apply_2'">
                    <div class="ar__quickquestion-qitem-item">@{{q1.question}}</div>
                    <div class="clearfix"></div>
                  </div>
                </li>
                <!-- Company Declaration END -->
                <span class="app_standard-notice-span">
                <i class="fa fa-exclamation-circle"></i>
                <i>Note: For questions with multiple answer-types, changing answer-type from one to another will disregard the answer made from the first or current answer-type chosen.</i>
                </span>
                <li ng-repeat="q in pre_standard" ng-if="q.question_type != 'comp_declaration' && q.question_type != 'can_declaration'" ng-init="num = 0" class="app__standard-quest-item">
                  <div class="ar__quickquestion-qitem" ng-if="q.type != 'custom_pre_apply_2'">
                    <span class="ar__quickquestion-qitem-number">Q.</span>
                    <p class="ar__quickquestion-qitem-item">@{{q.question}}</p>
                    <div class="ar__standardq-videoitem-div">
                      <video id="@{{'vid_' + $index}}" class="azuremediaplayer amp-default-skin" height="250" width="250" ng-if="q.video_document.doc_url">
                        <!-- <video id="tae1" class="azuremediaplayer amp-default-skin" height="250"> -->
                        <p class="amp-no-js">To view this video please enable JavaScript, and consider upgrading to a web browser that supports HTML5 video</p>
                      </video>
                    </div>
                  </div>
                  <!-- for questions with multiple answer types -->
                  <div class="ar__quickquestion-qans-container" ng-if="q.answer_type.length > 1">
                    <div class="ar__quickquestion-qans">
                      <span class="ar__label">Please select below on how you would like to answer the question</span>
                      <div class="ar__sq-choices">
                        <label ng-repeat="qans in q.answer_type" class="ar__sq-choices-label">
                        <input type="radio" name="@{{'rad_' + q.id}}" ng-true-value="@{{qans}}" value="@{{qans}}" ng-model="q.choice" ng-change="clear_answertypes($event, this, q)" ng-checked="qans == q.choice">
                        @{{ qans == 'boolean' ? 'Yes or No' : '' }}
                        @{{ qans == 'free_text' ? 'Through text' : '' }}
                        @{{ qans == 'multiple_choice' ? 'Multiple Choice' : '' }}
                        @{{ qans == 'video' ? 'Upload a video' : '' }}
                        @{{ qans == 'file_upload' ? 'Upload a document' : '' }}
                        </label>
                      </div>
                      <ul class="radio__options-list radio__options-list--sq" ng-if="q.choice == 'boolean'">
                        <li class="radio__options-item">
                          <label ng-class="{'role__answers--answered' : q.answer == 'Yes'}"><input type="radio" id="A_@{{q.id}}" ng-click="submit_standard(q.id, q.answer)" name="@{{q.id}}" ng-model="q.answer" value="Yes"> Yes</label>
                        </li>
                        <li class="radio__options-item">
                          <label ng-class="{'role__answers--answered' : q.answer == 'No'}"><input type="radio" id="B_@{{q.id}}" ng-click="submit_standard(q.id, q.answer)" name="@{{q.id}}" ng-model="q.answer" value="No"> No </label>
                        </li>
                      </ul>
                      <div ng-if="q.choice == 'multiple_choice'">
                        <ul class="radio__options-list radio__options-list--sq">
                          <li ng-repeat="opt in q.answer_choices track by $index" class="radio__options-item radio__options-item--multiple">
                            <label class="ar__sq-radio-multiple">
                            <span class="ar__sq-radio-choice" ng-class="{'ar__sq-radio-choice--selected' : opt == q.answer}">@{{abc[$index]}}.</span>
                            <input type="radio" ng-attr-id="@{{'opt_' + ($index + 1)}}" name="@{{'opt_' + q.id}}" ng-change="submit_standard(q.id, q.answer)" ng-value="opt" ng-model="q.answer">
                            @{{opt}}
                            </label>
                          </li>
                        </ul>
                        <div class="clearfix"></div>
                      </div>
                      <div ng-if="q.choice == 'free_text'">
                        <textarea ng-model="q.answer" name="text" ng-blur="submit_standard(q.id, q.answer)" class="ar__quickquestion-qans-text pvm-textarea" required placeholder="Kindly type your answer here.."></textarea>
                      </div>
                      <div ng-if="q.choice == 'video'" class="ar__sq-mult-vid">
                        <a href="javascript:void(0)" class="btn-pvm btn-primary btn-mini qans__upload-icon" ng-click="openVideoModalSQ(q.id,'question')">
                        <i class="fa fa-upload"></i>
                        </a>
                        <div class="app__standard-qans--video">
                          <!-- <div class="qans__video-upload" ng-show="q.answer == ''">
                            <a href="javascript:void(0)" id="video_placeholder_@{{q.id}}" class="question_video" ng-click="openVideoModalSQ(q.id,'question')">
                                <i class="fa fa-play fa-5x"></i>
                                <span class="ar__sq-vid-label">Click here to upload / record a video</span>
                            </a>
                            </div> -->
                          <div ng-show="!q.answer_video.VideoStatus && q.answer == ''" class="text-center video__big-thumbnail-inner-div">
                            <!-- <div><h4>Bababala</h4></div> -->
                            <div style="margin-bottom: 25px">
                              A video is required for this question. You may choose to upload an existing video file or record your own right away.
                            </div>
                            <div style="margin-bottom: 25px;font-size: 11px;">
                              <i>Note: if ever you would like to upload the same video content that you have used from previous questions, we recommend to change the video file name for more precise record keeping and to avoid technical difficulties.</i>
                            </div>
                          </div>
                          <!-- <div class="qans__video-uploaded-div" ng-show="q.answer_video.VideoStatus == '' && q.answer != ''">
                            <video id="@{{'sq_video_' + q.id}}" class="azuremediaplayer amp-default-skin" height="250">
                                <p class="amp-no-js">
                                    To view this video please enable JavaScript, and consider upgrading to a web browser that supports HTML5 video
                                </p>
                            </video>
                            </div> -->
                          <div ng-show="q.answer_video.VideoStatus == 'processing_completed'"  style="width: 50%;">
                            <video id="@{{'sq_video_' + q.id}}" class="azuremediaplayer amp-default-skin" height="250">
                              <p class="amp-no-js">
                                To view this video please enable JavaScript, and consider upgrading to a web browser that supports HTML5 video
                              </p>
                            </video>
                          </div>
                          <!-- <div ng-show="q.answer_video.VideoStatus == 'uploading'" class="text-center video__big-thumbnail-inner-div">
                            <div>
                                <h4>Video is uploading and being encoded..</h4>
                            </div>
                            <div style="margin-bottom: 25px">
                                "Your video is ‘processing’. <br>As you continue with your application your video will be saved. Refreshing this page will lose all of your progress."
                                <br /><br /><br /><br /><br />
                                <i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><br />
                                @{{q.answer_video.encoding_job_status}} @{{q.answer_video.encoding_progress + '%'}}
                                <p ng-if="q.answer_video.encoding_progress == 100">Video is almost ready. Please wait for a few seconds..</p>
                            </div>
                            </div> -->
                          <div ng-show="q.answer_video.VideoStatus == 'uploading'" class="text-center video__big-thumbnail-inner-div--success">
                            <div>
                              <h4>Uploaded file is now being processed</h4>
                            </div>
                            <div style="margin-bottom: 25px">
                              Please do not refresh this page. There is no need to wait for the processing to finish. You may click Submit if done answering.
                              <!-- <br /><br /><br /><br /><br />
                                <i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><br />
                                @{{q.answer_video.encoding_job_status}} @{{q.answer_video.encoding_progress + '%'}}
                                <p ng-if="q.answer_video.encoding_progress == 100">Video is almost ready. Please wait for a few seconds..</p> -->
                            </div>
                          </div>
                          <div class="clearfix"></div>
                        </div>
                      </div>
                      <div ng-if="q.choice == 'file_upload'">
                        <a href="javascript:void(0)" class="qans__upload-icon btn-pvm btn-primary btn-mini" ng-click="uploadSQFile(q.id, 'application_question_answer')" style="margin-right: 15px;">Upload Document</a>
                        <a href="@{{q.answer.doc_url}}" class="qans__upload-icon" target="_blank" ng-if="q.answer && q.choice == 'file_upload'">
                        <i class="fa fa-file fa-5x "></i>
                        @{{q.answer.file_name}}
                        </a>
                      </div>
                    </div>
                  </div>
                  <!-- for questions with single answer type -->
                  <div class="ar__quickquestion-qans-container" ng-if="q.answer_type.length == 1">
                    <div class="ar__quickquestion-qans" ng-if="!q.answer_type || q.answer_type == 'free_text'">
                      <textarea ng-model="q.answer" name="text" ng-blur="submit_standard(q.id, q.answer)" class="ar__quickquestion-qans-text pvm-textarea" required placeholder="Kindly type your answer here.."></textarea>
                    </div>
                    <div class="ar__quickquestion-qans" ng-if="q.answer_type == 'multiple_choice'">
                      <ul class="radio__options-list radio__options-list--sq">
                        <li ng-repeat="choices in q.answer_choices track by $index" class="radio__options-item radio__options-item--multiple">
                          <label class="ar__sq-radio-multiple">
                          <span class="ar__sq-radio-choice" ng-class="{'ar__sq-radio-choice--selected' : choices == q.answer}">@{{abc[$index]}}.</span>
                          <input type="radio" ng-attr-id="@{{'rad_' + ($index + 1)}}" name="@{{'rad_' + q.id}}" ng-change="submit_standard(q.id, q.answer)" value="@{{choices}}" ng-model="q.answer">
                          @{{choices}}
                          </label>
                        </li>
                      </ul>
                      <div class="clearfix"></div>
                    </div>
                    <div class="ar__quickquestion-qans" ng-if="q.answer_type == 'boolean'">
                      <ul class="radio__options-list radio__options-list--sq">
                        <li>
                          <label ng-class="{'role__answers--answered' : q.answer == 'Yes'}">
                          <input type="radio" id="A_@{{q.id}}" ng-click="submit_standard(q.id, q.answer)" name="@{{q.id}}" ng-model="q.answer" value="Yes">Yes
                          </label>
                        </li>
                        <li>
                          <label ng-class="{'role__answers--answered' : q.answer == 'No'}">
                          <input type="radio" id="B_@{{q.id}}" ng-click="submit_standard(q.id, q.answer)" name="@{{q.id}}" ng-model="q.answer" value="No"> No
                          </label>
                        </li>
                      </ul>
                      <div class="clearfix"></div>
                    </div>
                    <div class="ar__quickquestion-qans" ng-if="q.answer_type == 'video'">
                      <div class="app__standard-qans--video">
                        <a href="javascript:void(0)" class="btn-pvm btn-primary btn-mini qans__upload-icon" ng-click="openVideoModalSQ(q.id,'question')">
                        <i class="fa fa-upload"></i>
                        </a>
                        <div class="app__standar-qans--content">
                          <div ng-show="!q.answer_video.VideoStatus && q.answer == ''" class="text-center video__big-thumbnail-inner-div">
                            <!-- <div><h4>Bababala</h4></div> -->
                            <div style="margin-bottom: 25px">
                              A video is required for this question. You may choose to upload an existing video file or record your own right away.
                            </div>
                            <div style="margin-bottom: 25px;font-size: 11px;">
                              <i>Note: if ever you would like to upload the same video content that you have used from previous questions, we recommend to change the video file name for more precise record keeping and to avoid technical difficulties.</i>
                            </div>
                          </div>
                          <div ng-show="q.answer_video.VideoStatus == 'processing_completed'"  style="width: 50%;">
                            <video id="@{{'sq_video_' + q.id}}" class="azuremediaplayer amp-default-skin" height="250">
                              <p class="amp-no-js">
                                To view this video please enable JavaScript, and consider upgrading to a web browser that supports HTML5 video
                              </p>
                            </video>
                          </div>
                          <div ng-show="q.answer_video.VideoStatus == 'uploading'" class="text-center video__big-thumbnail-inner-div--success">
                            <div>
                              <h4>Uploaded file is now being processed</h4>
                            </div>
                            <div style="margin-bottom: 25px">
                              Please do not refresh this page. There is no need to wait for the processing to finish. You may click Submit if done answering.
                              <!-- <br /><br /><br /><br /><br />
                                <i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><br />
                                @{{q.answer_video.encoding_job_status}} @{{q.answer_video.encoding_progress + '%'}}
                                <p ng-if="q.answer_video.encoding_progress == 100">Video is almost ready. Please wait for a few seconds..</p> -->
                            </div>
                          </div>
                        </div>
                        <div class="clearfix"></div>
                      </div>
                    </div>
                    <div class="ar__quickquestion-qans" ng-if="q.answer_type == 'file_upload'">
                      <a href="javascript:void(0)" class="qans__upload-icon btn-pvm btn-primary btn-mini" ng-click="uploadSQFile(q.id, 'application_question_answer')">Upload Document</a>
                      <a href="@{{q.answer.doc_url}}" class="qans__upload-icon" target="_blank" ng-if="q.answer">
                      <i class="fa fa-file fa-5x "></i>
                      @{{q.answer.file_name}}
                      </a>
                    </div>
                  </div>
                  <!-- SUBS BEGIN -->
                  <div ng-if="q.sub_questions" ng-repeat="subs in q.sub_questions">
                    <div ng-if="!subs.type || subs.type == 'text'">
                      <div class="ar__quickquestion-qitem">
                        <div class="ar__quickquestion-qitem-item">@{{subs.question}}</div>
                        <div class="clearfix"></div>
                      </div>
                      <div class="ar__quickquestion-qans-container">
                        <div class="ar__quickquestion-qans">
                          <input type="textarea" name="text" class="ar__quickquestion-qans-text" ng-model="subs.answer" required>
                        </div>
                      </div>
                    </div>
                    <div ng-if="subs.type == 'custom_pre_apply_1_sub' || subs.type == 'gpa'">
                      <div class="ar__quickquestion-qitem">
                        <div class="ar__quickquestion-qitem-item">@{{subs.question}}</div>
                        <div class="clearfix"></div>
                      </div>
                      <div class="ar__quickquestion-qans-container">
                        <div class="ar__quickquestion-qans">
                          <ul class="radio__options-list">
                            <li>
                              <input type="radio" id="toggle-aplus" checked ng-value="1" ng-model="subs.answer">
                              <label for="toggle-aplus">A+</label>
                            </li>
                            <li>
                              <input type="radio" id="toggle-a" ng-value="2" ng-model="subs.answer">
                              <label for="toggle-a">A</label>
                            </li>
                            <li>
                              <input type="radio" id="toggle-aminus" ng-value="3" ng-model="subs.answer">
                              <label for="toggle-aminus">A-</label>
                            </li>
                            <li>
                              <input type="radio" id="toggle-bplus" ng-value="4" ng-model="subs.answer">
                              <label for="toggle-bplus">B+</label>
                            </li>
                            <li>
                              <input type="radio" id="toggle-b" ng-value="5" ng-model="subs.answer">
                              <label for="toggle-b">B</label>
                            </li>
                            <li>
                              <input type="radio" id="toggle-bminus" ng-value="6" ng-model="subs.answer">
                              <label for="toggle-bminus">B-</label>
                            </li>
                            <li>
                              <input type="radio" id="toggle-cplus" ng-value="7" ng-model="subs.answer">
                              <label for="toggle-cplus">C+</label>
                            </li>
                            <li>
                              <input type="radio" id="toggle-c" ng-value="8" ng-model="subs.answer">
                              <label for="toggle-c">C</label>
                            </li>
                            <li>
                              <input type="radio" id="toggle-cminus" ng-value="9" ng-model="subs.answer">
                              <label for="toggle-cminus">C-</label>
                            </li>
                            <li>
                              <input type="radio" id="toggle-d" ng-value="10" ng-model="subs.answer">
                              <label for="toggle-d">D</label>
                            </li>
                            <li>
                              <input type="radio" id="toggle-e" ng-value="11" ng-model="subs.answer">
                              <label for="toggle-e">E</label>
                            </li>
                          </ul>
                          <div class="clearfix"></div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- SUBS END -->
                </li>
                <!-- Non bespoke questions END -->
                <!-- Bespoke questions BEGIN -->
                <li ng-repeat="slidah in slider_temp track by $index">
                  <div ng-if="slidah.type == 'parent'">
                    <div class="ar__quickquestion-qitem">
                      <div class="ar__quickquestion-qitem-number">@{{slidah.$index}}</div>
                      <div class="ar__quickquestion-qitem-item">@{{slidah.question}}</div>
                      <div class="clearfix"></div>
                    </div>
                    <div class="ar__quickquestion-qans">
                      <div class="squaredOne squaredOne-width">
                        <input type="checkbox" value="None" name="check2" checked />
                        <label for="">
                          <p><span>Verbal</span></p>
                        </label>
                      </div>
                      <!-- <span>Verbal</span> -->
                      <div class="r-zslider">
                        <rzslider
                          rz-slider-model="slidah.slider.min"
                          rz-slider-options="slidah.slider.options" ng-model="slidah.answer" title="">
                        </rzslider>
                      </div>
                      <div class="clearfix"></div>
                    </div>
                  </div>
                  <!-- SUBS BEGIN -->
                  <div ng-if="slidah.type == 'child'">
                    <div class="ar__quickquestion-qans">
                      <div class="squaredOne squaredOne-width">
                        <input type="checkbox" value="None" id="squaredOne_09" name="check2" checked />
                        <label for="squaredOne_09">
                          <p><span>@{{slidah.question}}</span></p>
                        </label>
                      </div>
                      <!-- <span>child @{{slidah.question}}</span> -->
                      <div class="r-zslider">
                        <rzslider
                          rz-slider-model="slidah.slider.min"
                          rz-slider-options="slidah.slider.options" title=""></rzslider>
                      </div>
                      <div class="clearfix"></div>
                    </div>
                  </div>
                  <!-- SUBS END -->
                </li>
                <!-- Bespoke questions END -->
              </ul>
            </div>
          </div>
        </ng-form>
      </div>
      <!-- Standard Question END -->
      <!-- Declaration BEGIN -->
      <div class="ar__main-div" ng-if="active_tab == stepstab.showDec" ng-controller="DeclarationCtrl">
        <div class="ar__main-inner-declaration--div">
          <div class="ar__declaration-content">
            <p style="font-size: 3vw; font-weight: 100; line-height: 52px; font-family: 'Rockwell-Light';">Just one more thing...</p>
          </div>
          <div class="ar__declaration-content">
            <!-- <p style="font-family: 'Rockwell-Light';">Create a new password for your account.</p> -->
          </div>
          <div class="ar__declaration-content">
            <form name="declarationFrm" novalidate>
              <div class="clearfix">
                <div style="float:left; margin-right: 10px;"><input type="checkbox" name="declare" ng-model="declare" ng-value="1" ></div>
                <div style="float:left; width: 57vw;"><span>@{{declaration.question}}</span></div>
              </div>
              <!-- <div class="ar_submit-btn">
                <button type="submit" class="btn-pvm btn-mini btn-tertiary role__save-btn" ng-disabled="notdeclared">
                    <i class="fa fa-arrow-circle-o-right"></i> Submit Application
                </button>
                </div>
                <div class="clearfix"></div> -->
            </form>
          </div>
        </div>
      </div>
      <!-- Declaration END -->
    </div>
  </section>
  <section ng-show="!isPassed && !isFailed" class="bottom-pane pvm-tablet-invisible">
    <a href="#" class="btn-pvm btn-mini btn-primary role__prev-btn" ng-click="checkPrev()"><i class="fa fa-arrow-left"></i></a>
    <span class="role__btn-handler">
    <a href="#" class="btn-pvm btn-mini btn-default role__publish-btn"><i class="fa fa-rocket"></i> </a>
    <a href="#" class="btn-pvm btn-mini btn-tertiary role__save-btn"><i class="fa fa-save"></i> </a>
    </span>
    <button class="btn-pvm btn-mini btn-primary role__next-btn" ng-click="checkNext()"><i class="fa fa-arrow-right"></i> </button>
  </section>
  <section ng-show="!isPassed && !isFailed" class="bottom-pane pvm-tablet-visible">
    <a href="#" class="btn-pvm btn-mini btn-primary role__prev-btn" ng-click="checkPrev()" ng-if="(active_tab > 1 && stepstab.showPre != 1) || (active_tab > 2 && stepstab.showPre == 1)">
    <i class="fa fa-arrow-left"></i> Previous
    </a>
    <span class="role__btn-handler">
      <!-- <a href="#" class="btn-pvm btn-mini btn-default role__publish-btn"><i class="fa fa-rocket"></i> Publish role</a> -->
      <!--<a href="{$BaseHref}dashboard" class="btn-pvm btn-mini btn-tertiary role__save-btn"><i class="fa fa-save"></i> Save and finish later</a>-->
    </span>
    <!-- <a href="#" class="btn-pvm btn-mini btn-primary role__next-btn" ng-click="checkNext('next')" ng-if="!readyForApply"><i class="fa fa-arrow-right"></i> next </a> -->
    <button class="btn-pvm btn-mini btn-primary role__next-btn" ng-click="checkNext('next')" ng-if="!readyForApply"><i class="fa fa-arrow-right"></i> next </button>
    <!-- <a href="#" class="btn-pvm btn-mini btn-default role__next-btn" ng-show="!readyForApply">
      <i class="fa fa-arrow-circle-o-right"></i> Submit Application
      </a> -->
    <!-- <a href="#" class="btn-pvm btn-mini btn-primary role__next-btn" ng-click="checkNext('submit')" ng-if="readyForApply && compDecl">
      <i class="fa fa-arrow-circle-o-right"></i> Submit Application
      </a> -->
    <button ng-click="checkNext('submit')" ng-if="readyForApply" class="btn-pvm btn-mini btn-primary role__next-btn" ng-disabled="notdeclared">
    <i class="fa fa-arrow-circle-o-right"></i> Submit Application
    </button>
  </section>
  <!-- MODALS BEGIN -->
  @include('includes.candidate_modal')
  <!-- MODALS END -->
  <section ng-show="!isPassed && isFailed" class="app__your-stat app__your-stat--rejected">
    <div>
      <h1>Thank you for applying.</h1>
      <p>Unfortunately you do not meet the employer’s criteria and cannot advance to the next stage of the application.</p>
      <a href="{$BaseHref}job/search" class="btn-pvm btn-tertiary btn-large btn-continue">Continue Search</a>
      <a href="{$BaseHref}dashboard" class="btn-pvm btn-tertiary btn-large btn-continue">Go to your Dashboard</a>
    </div>
  </section>
  <section ng-show="isPassed && !isFailed" class="app__your-stat app__your-stat--passed">
    <div>
      <h1>Thank you for applying!</h1>
      <a href="{$BaseHref}job/search" class="btn-pvm btn-tertiary btn-large btn-continue">Continue Search</a>
      <a href="{$BaseHref}dashboard" class="btn-pvm btn-tertiary btn-large btn-continue">Go to your Dashboard</a>
    </div>
  </section>
</main>

@endsection

@section('scripts')
    <!-- <script src="@{{ asset('js/jquery/jquery.datetimepicker.full.min.js?ver=1') }}"></script> -->
    <!-- <script src="@{{ asset('js/candidate/role-app.js') }}"></script> -->
    <script>
        /*
        $('.role-tabs .tab__link').click(function (e) {
            
            $(this).tab('show')
        });

        $('.mydatepicker').datetimepicker({
            timepicker: false,
            format: 'd-m-Y'
        });
        */
    </script>
@endsection