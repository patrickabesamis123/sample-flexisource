@extends('layouts.candidate-profile')
@section('styles')
@stop
@section('content')
<div ng-controller="CandidateController" ng-cloak id="candidate_profile_edit_content" class="candidate-profile-edit">
  <div class="text-center splash " ng-show="preload">
    <div class="cssload-container">
      <h3>Please wait.</h3>
      <h4>While we prepare this page for you.</h4>
      <div class="cssload-loading"><i></i><i></i><i></i><i></i></div>
    </div>
  </div>
  <div class="content-loader animate-show" ng-show="contentloader">
    <div class="alert alert-danger" role="alert" ng-show="error">@{{error}}</div>
    <div class="container-fluid">
      <div class="row">
        <div class="alert alert-warning alert-dismissible dismissible-custom" role="alert" ng-if="candidateFlashMessage">
          <div class="container">
            <div class="col-md-10" ng-bind-html="candidateFlashMessage"></div>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          </div>
        </div>
      </div>
    </div>
    <div class="container-fluid" id="ProfileTop">
      <div class="row">
        <div class="container">
          <div class="col-md-2" id="phone_image" ng-if="!mobile_agent">
            <div ng-if="!profile_image" class="profile_image_empty"  data-toggle="modal" data-target="#pmvImageModalNew">
              <img ng-src="/images/defaultPhoto.png" width="137" class="img-circle">
              <a href="" class="add_photo_button pvm-blue">+ Add Photo</a>
            </div>
            <div ng-if="profile_image" class="profile_image" data-toggle="modal" data-target="#pmvImageModalNew">
              <img ng-src="@{{profile_image}}" class="img-circle " width="137" >
              <img src="/images/profile_camera_image.png" class="profile_image_camera"
                style="margin-top : -75px;margin-left : 55px;">
            </div>
            <div style="width:137px; padding-top:10px; text-align:center">
              <a href="/candidate/profile" class="pvm-green">View My Profile</a>
            </div>
          </div>
          <div class="col-md-2" ng-show="mobile_agent">
            <label for="mobile_image_upload" id="phone_image">
            <img ng-src="/images/defaultPhoto.png" width="137" class="img-circle" ng-if="!profile_image">
            <img ng-src="@{{profile_image}}" class="img-circle" width="137" ng-if="profile_image">
            <input type="file" accept="image/*;capture=camera" id="mobile_image_upload" name="mobile_image_upload" ng-hide="true">
            </label>
            <div style="width:137px; padding-top:10px; text-align:center">
              <a href="/my-profile" class="pvm-green">View My Profile</a>
            </div>
          </div>
          <div class="col-md-7" style="padding-right: 0px;">
            <div class="fullname">
              <h3>
                <div ng-hide="showNameInfo">
                  <span ng-click="showuserForm()">
                    <span class="capitalize_word pvm-cursor-pointer font-mont-bold">@{{first_name}}</span >
                    <span class="capitalize_word pvm-cursor-pointer font-mont-bold">@{{last_name}}</span >
                    <span class="nickname">
                      <span class="pvm-cursor-pointer font-mont-bold" ng-show="nickname">(@{{nickname}})</span>
                    </span >
                    <a href="" type="button" class="editfield">
                      <span class="glyphicon pencil-icon"></span>
                    </a>
                  </span>
                </div>
                <form role="form" name="editableName" editable-form onaftersave="updateUserName()" ng-show="showNameInfo">
                  <div class="clearfix">
                    <input name="first" type="text" class="profile_name-input" ng-model="first_name" placeholder="First Name" required>
                    <input type="text" class="profile_name-margin" ng-model="last_name" placeholder="Last Name" required>
                    <input type="text" class="profile_name-input" ng-model="nickname" placeholder="Nickname">
                  </div>
                  <!-- <p ng-show="space_validator">Spaces on fields are not allowed</p> -->
                  <div class="buttons">
                    <span>
                      <button type="submit" class="btn btn-primary-bbt" ng-disabled="editableName.$waiting">
                      <span class="glyphicon glyphicon-ok"></span>
                      </button>
                      <!-- <button type="button" class="btn btn-default-bbt" ng-disabled="editableName.$waiting" ng-click="editableName.$cancel"> -->
                      <button type="button" class="btn btn-default-bbt" ng-disabled="editableName.$waiting" ng-click="resetUsername(this)">
                      <span class="glyphicon glyphicon-remove"></span>
                      </button>
                    </span>
                  </div >
                </form>
              </h3>
            </div>
            <div class="position">

              <form editable-form="" name="editableLocation" onaftersave="updateLocation($data)" autocomplete="off"  class="ng-pristine ng-valid ng-valid-required">
                <span ng-click="editableLocation.$show()" class="pvm-cursor-pointer editfield pvm-dark-gray" editable-select="preferred_location.data.country.id"  e-name="country" onshow="LoadCountries()" e-required  e-ng-options="s.id as s.display_name for s in countries">
                @{{ preferred_location.data.country.display_name || 'Add Location' }}
                </span>
                <a href="" type="button" class="editfield" ng-click="editableLocation.$show()" ng-show="!editableLocation.$visible">
                <span class="glyphicon pencil-icon"></span>
                </a>
                <span class="locationAutoComplete"  >
                  <div ng-click="editableLocation.$show()" class="pvm-cursor-pointer editfield pvm-dark-gray " editable-text="preferred_location.data.display_name" e-name="area" e-ng-change="GetAreas($data, preferred_location.data.country.id)"  >
                    @{{ preferred_location.data.display_name || '' }}
                  </div>
                  <ul id="autoDataLocation" class="result" ng-hide="hideme" style="display:none">
                    <li ng-repeat="(key, value) in areas">
                      <a href="" data-value="@{{value.id}}" ng-click="getAutoCompleteData( value  )" class="autodata" style="display:block">@{{value.display_name}}</a>
                    </li>
                  </ul>
                </span>
                <span ng-hide="true" ng-click="editableLocation.$show()" class="pvm-cursor-pointer editfield pvm-dark-gray fieldDataid" editable-text="preferred_location.data.id" e-name="areaid"  >
                @{{ preferred_location.data.id || '' }}
                </span>
                <span ng-show="!editableLocation.$visible" style="vertical-align:middle">
                <i class="glyphicon willing-to-relocate-checkbox pvm-cursor-pointer"
                  ng-class="relocateClass" ng-click="willingToRelocate()"></i>
                <small style="vertical-align:top"> I am willing to relocate</small>
                </span>
                <div class="buttons">
                  <span ng-show="editableLocation.$visible">
                  <button type="submit" class="btn btn-primary-bbt" ng-disabled="editableLocation.$waiting">
                  <span class="glyphicon glyphicon-ok"></span>
                  </button>
                  <button type="button" class="btn btn-default-bbt" ng-disabled="editableLocation.$waiting" ng-click="editableLocation.$cancel()">
                  <span class="glyphicon glyphicon-remove"></span>
                  </button>
                  </span>
                </div >



              </form>

            </div>
            <div class="row details">
              <div class="col-md-5">
                <span>
                <span class="col-md-3 details_title">Mobile:</span>
                <span class="col-md-9 candidate-top-fields-holder word-break no-padding">
                <a href="" e-placeholder="Mobile" editable-text="mobile_number" e-class="top-mobile" onaftersave="updateCandidateOnly()" class="editfield">
                @{{mobile_number || "Add Mobile Number"}}
                <span class="glyphicon pencil-icon"></span>
                </a>
                </span>
                </span>
                <span>
                <span class="col-md-3 details_title">Phone:</span>
                <span class="col-md-9 candidate-top-fields-holder word-break no-padding">
                <a href="" e-placeholder="Phone" editable-text="phone_number" e-class="top-phone" onaftersave="updateCandidateOnly()" class="editfield">
                @{{phone_number || "Add Phone Number" }}
                <span class="glyphicon pencil-icon"></span>
                </a>
                </span>
                </span>
                <span ng-show="email">
                <span class="col-md-3 details_title">Email:</span>
                <span class="col-md-9 word-break no-padding">
                @{{email}}
                </span>
                </span>
              </div>
              <div class="col-md-7">
                <span class="industryfield">
                <span class="col-md-3 details_title">Classification:</span>
                <span class="col-md-9 ">
                <a href="" editable-select="industry.id" onshow="loadIndustries()"
                  e-ng-options="s.id as s.display_name for s in industries" onaftersave="updateUser()" class="editfield">
                @{{industry.industry_display_name || "Add Industry"}}
                <span class="glyphicon pencil-icon"></span>
                </a>
                </span>
                </span>
                <span>
                <span data-toggle="tooltip" data-placement="top" tooltip="" data-original-title="
                  Sub-Classification" class="col-md-3 details_title ellipsis gray-tooltip" style="padding-right:0px;">
                Sub-Classification:
                </span>
                <span class="col-md-9">
                <a href="" editable-select="industry.sub_industry.id"  onshow="loadSubIndustries()"
                  onaftersave="updateUser()" class="editfield" e-class="candidate_sub_industries"
                  e-ng-options="s.id as s.display_name for s in subIndustries">
                @{{industry.sub_industry.display_name  || "Add Sub Industry" }}
                <span class="glyphicon pencil-icon"></span>
                </a>
                </span>
                </span>
                <span>
                  <div class="clearfix"></div>
                  <form editable-form name="editableSalary"  onaftersave="updateSalaryRange()" class="profileeditsalary"  >
                    <span class="col-md-3 details_title" style="padding-right:0px;">Salary Range:</span>
                    <span class="col-md-9 candidate_top_salary_field word-break">
                      <span e-placeholder="Min" editable-text="min_salary" editable-text="first_name" e-name="min_salary"  class="editfield" e-ng-keypress="numbersOnly()">
                      <span style="color:#ccc" ng-if="
                        min_salary !== null && max_salary !== null && min_salary !== 0 && max_salary !== 0 ||
                        min_salary !== null && max_salary == null ||
                        min_salary == null && max_salary !== null ||
                        min_salary == 0 && max_salary !== 0 ||
                        min_salary != 0 && max_salary == 0 ">
                      @{{ ( min_salary | currency :"$":0 )}} - @{{ (max_salary | currency :"$":0) }}
                      </span>
                      <span ng-if="
                        min_salary == null && max_salary == null ||
                        min_salary == 0 && max_salary == 0 ">
                      Add Salary
                      </span>
                      </span>
                      <span e-placeholder="Max" editable-text="max_salary" e-ng-keypress="numbersOnly()" class="editfield"></span>
                      <a href type="button" class="editfield" ng-click="editableSalary.$show" ng-show="!editableSalary.$visible">
                      <span class="glyphicon lock-icon gray-tooltip" title="This field will not be displayed on your public profile." data-toggle="tooltip" data-placement="top" tooltip ></span>
                      </a>
                      <div class="buttons">
                        <span ng-show="editableSalary.$visible">
                        <button type="submit" class="btn btn-primary-bbt" ng-disabled="editableSalary.$waiting">
                        <span class="glyphicon glyphicon-ok"></span>
                        </button>
                        <button type="button" class="btn btn-default-bbt" ng-disabled="editableSalary.$waiting" ng-click="editableSalary.$cancel">
                        <span class="glyphicon glyphicon-remove"></span>
                        </button>
                        </span>
                      </div>
                    </span>
                  </form>
                </span>
              </div>
            </div>
          </div>
          <div class="col-md-3" id="video_container">
            <div ng-show="preview_img == true">
              <img  ng-src="/images/placeholder_vid.png" width="275" >
              <a href="" data-toggle="modal" style="top:53px;left:94px;" data-target="#pmvCameraModalNew" class="add_photo_button2 pvm-blue">Upload Video</a>
            </div>
            <div ng-show="preview_img == false">
              <video id="vid1" class="azuremediaplayer amp-default-skin" controls >
                <p class="amp-no-js">
                  To view this video please enable JavaScript, and consider upgrading to a web browser that supports HTML5 video
                </p>
              </video>
            </div>
            <div ng-show="preview_img == 'loading' "  class="text-center">
              <img src="/images/ajax-loader-video.gif" style="width:106px;padding-bottom:10px">
              <div style="margin-bottom: 25px">
                We will notify you once your video has been uploaded. You can still use the full site while the video is processing
              </div>
            </div>
            <div ng-show="preview_img == 'error' "  class="text-center">
              @{{errorVideo}}
            </div>
            <div>
              <small><a href="Tips for making the perfect video!" data-toggle="modal" data-target=".bs-modal-lg">Tips for making the perfect video!</a></small>
              <div class="modal fade bs-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
                <div class="modal-dialog modal-lg" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                      <h4 class="modal-title" id="myModalLabel">Tips to record the perfect video</h4>
                    </div>
                    <div class="modal-body">
                      <p>Visit the <a  href="/resources" target="_blank">blog</a> to watch examples of Profile videos.</p>
                      <iframe width="100%" height="500" src="https://www.youtube.com/embed/hA-A_hWD8vs" frameborder="0" allowfullscreen></iframe>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="container-fluid" id="ProfileBottom">
      <div class="row">
        <div class="container">
          <div class="col-md-9" id="ProfileBottom_r_con">
            <div ng-show="ProfileUpdated" class="alert alert-success" role="alert">
              Profile Update
              <button type="button" class="close" ng-click="disableAlert()" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="row aboutme">
              <div class="col-md-12" style="padding-right:0px;">
                <h3 ng-click="rowform1.$show()" class="pvm-cursor-pointer" style="width:150px;">
                  ABOUT ME
                  <i   class="glyphicon glyphicon-info-sign tooltip_btn"
                    data-toggle="tooltip" data-placement="top"
                    tooltip
                    data-original-title="Take this opportunity to introduce yourself and highlight what makes you unique. Think; personal and professional attributes, career goals, skills, achievements, sport, community, teamwork, languages..."
                    ></i>
                </h3>
                <div class="content">
                  <div class="buttons" ng-show="!rowform1.$visible">
                    <a href="" ng-click="rowform1.$show()">
                    <span class="glyphicon pencil-icon"></span>
                    </a>
                    <span class="pvm-gray description_content" ng-bind-html="long_description | newlines"></span>
                  </div>
                  <div class="qualification">
                    <span e-form="rowform1" class="editfield" editable-textarea="long_description" e-name="long_description" e-rows="8" e-cols="100"></span>
                  </div>
                  <form editable-form name="rowform1" onbeforesave="updateUserAbout($data)" ng-show="rowform1.$visible" class="form-buttons form-inline">
                    <div class="pull-right">
                      <button type="submit" ng-disabled="rowform.$waiting" class="btn btn-primary-bbt">SAVE</button>
                      <button type="button" ng-disabled="rowform.$waiting" ng-click="rowform1.$cancel()" class="btn-pvm btn-default-bbt">CANCEL</button>
                    </div>
                    <div class="clearfix"></div>
                  </form>
                </div>
              </div>
            </div>
            <h3 class="CPE-section-title">Work Experience</h3>
            <ul class="CPE-work-list">
              <li class="CPE__work-item" ng-repeat="history in work_history | orderBy : sortDate : true" ng-if="work_history.length">
                <div ng-hide="(showWorkHistoryForm && history.isWHID == history.id) || history.isWHID == 0">
                  <div class="CPE-action-buttons">
                    <i class="fa fa-pencil" title="Update" ng-click="openWorkHistoryEdit(history)"></i>
                    <i class="fa fa-trash-o" title="Delete" confirmed-click="deleteWork(history)" ng-confirm-click="Are you sure you want to delete this?"></i>
                  </div>
                  <h4 class="work-company-name">@{{history.company_name}}</h4>
                  <h4 class="work-job-title">@{{history.job_title}} | @{{history.work_type.displayName}}</h4>
                  <p ng-bind="history.display_date" class="work-completed"></p>
                  <p ng-show="history.salary > 0" class="work-salary">$ @{{history.salary}}</p>
                  <h4 class="CPE-section-subtitle" ng-show="history.key_accountabilities.length > 0">Key Accountabilities</h4>
                  <ul class="work-responsibilities-list">
                    <li class="work-responsibilities__item" ng-repeat="accnt in history.key_accountabilities track by $index">
                      <span class="">@{{history.key_accountabilities[$index]}}</span><span ng-if="[$index] < (history.key_accountabilities.length-1)" class="ar__details">,&nbsp;</span>
                    </li>
                  </ul>
                  <h4 class="CPE-section-subtitle" ng-show="history.description.length > 0">Job in a nutshell</h4>
                  <p class="work-description">@{{history.description}}</p>
                  <ul class="work-classification-list">
                    <li class="work-classification__item" ng-repeat="(key, value) in history.industries_display">
                      <h4 class="work-classification">@{{key}}</h4>
                      <h4 class="work-sub-classification">@{{value}}</h4>
                    </li>
                  </ul>
                </div>
                <form ng-submit="AddWorkHistory(history)" ng-if="showWorkHistoryForm" ng-show="history.isWHID == 0 || history.isWHID == history.id" class="CPE-work-form">
                  <input type="text" ng-required="!history.company_name" ng-model="history.company_name" placeholder="Company Name" class="pvm-input-text work-company-name work-company-name--form">
                  <input type="text" ng-required="!history.job_title" ng-model="history.job_title" placeholder="Job / Role Title" class="pvm-input-text work-job-title work-job-title--form">
                  <select ng-options="s.id as s.display_name for s in work_types_wh track by s.id" class="pvm-select work-type" ng-model="history.work_type" ng-required="!history.work_type">
                    <option value="">Work Type</option>
                  </select>
                  <input type="text" ng-model="history.salary" class="pvm-input-text work-salary work-salary--form" placeholder="Salary (confidential and optional)">
                  <input type="text" ng-required="!history.start_date" ng-click="initDatePicker($event)" ng-model="history.start_date" class="pvm-input-text mydatepicker work-start-date" placeholder="Start Date">
                  <input type="text" ng-required="!history.currently_work_here" ng-click="initDatePicker($event)" ng-model="history.end_date" class="pvm-input-text mydatepicker work-end-date" placeholder="End Date" ng-disabled="history.currently_work_here">
                  <label class="work-is-present pvm-checkbox">
                  <input type="checkbox" ng-model="history.currently_work_here" ng-true-value="true" ng-false-value="false">
                  <i class="fa fa-check" ng-show="history.currently_work_here"></i>
                  <span>I currently work here</span>
                  </label>
                  <h4 class="CPE-section-subtitle">Key accountabilities </h4>
                  <ul class="work-responsibilities-list work-responsibilities-list--form">
                    <li class="work-responsibilities__item work-responsibilities__item--form" ng-repeat="accnt in history.key_accountabilities track by $index">
                      <input type="text" name="" ng-model="history.key_accountabilities[$index]" class="pvm-input-text work-responsibilities">
                      <i class="fa fa-close" ng-click="delAcct(history, [$index])"></i>
                    </li>
                    <li class="work-responsibilities__item work-responsibilities__item--form work-responsibilities__item--more">
                      <i class="fa fa-plus" title="Add accountabilities" ng-click="AddMoreResponsiblity([$index])"> <span>Add Responbilities</span></i>
                    </li>
                  </ul>
                  <textarea ng-model="history.description" placeholder="Job Description" class="pvm-textarea work-description work-description--form"></textarea>
                  <h4 class="CPE-section-subtitle">Classifications </h4>
                  <select class="pvm-select" ng-options="industry.id as industry.display_name for industry in all_industries" ng-model="history.industrySelect" ng-change="showSubIndustries(history.industrySelect)">
                    <option>Select Classification</option>
                  </select>
                  <h4 class="CPE-section-subtitle" ng-if="sub_industries">Sub-classifications </h4>
                  <select class="pvm-select" ng-options="sub_industry.id as sub_industry.display_name for sub_industry in sub_industries" ng-if="showSubClassification" ng-model="history.sub_industrySelect" ng-required="history.industrySelect">
                    <option>Select Sub Classification</option>
                  </select>
                  <div class="CPE-form-buttons">
                    <input type="submit" value="SAVE" class="action submit_wh btn btn-pvm btn-primary btn-mini">
                    <a href="" ng-click="CancelWorkHistoryForm(history)"  class="cancel_wh btn btn-pvm btn-default btn-mini">CANCEL</a>
                  </div>
                </form>
              </li>
              <li ng-if="!work_history.length" class="CPE__work-item">You haven't uploaded any work experience yet</li>
            </ul>
            <!-- <label class="work-is-present pvm-checkbox" ng-if="!work_history.length">
            <input type="checkbox" ng-change="newToWorkForce(newToWorkForceField)" ng-model="newToWorkForceField">
            <i class="fa fa-check" ng-show="newToWorkForceField"></i>
            <span>I currently work here</span>
            </label> -->
            <a href="" ng-click="AddWorkHistoryForm()" class="btn-pvm btn-primary btn-mini CPE-add-button" ng-hide="showWorkHistoryForm">Add Work Experience</a>
            <h3 class="CPE-section-title">Education</h3>
            <ul class="CPE-education-list">
              <li class="CPE__education-item" ng-repeat="education in educations | orderBy : sortDate : true" ng-if="educations.length">
                <div ng-hide="(showEducationForm && education.isEdID == education.id) || education.isEdID == 0" class="CPE-education-display">
                  <div class="CPE-action-buttons">
                    <i class="fa fa-pencil" title="Update" ng-click="openEducationEdit(education)"></i>
                    <i class="fa fa-trash-o" title="Delete" confirmed-click="delete_education(education)" ng-confirm-click="Are you sure you want to delete this?"></i>
                  </div>
                  <h3 class="education-degree">@{{education.degree + ' ' + education.qualification.display_name}}</h3>
                  <h3 class="education-university">@{{education.qualification_provider.provider_display_name}}</h3>
                  <h4 class="education-completed" ng-bind="education.completed_date | date : 'dd-MM-yyyy'" ng-show="education.completed_date != null"></h4>
                  <h4 class="education-completed" ng-show="education.completed_date == null">Currently studying</h4>
                  <img ng-src="@{{education.qualification_provider.company_logo}}" ng-if="education.qualification_provider.company_logo.length > 0 || education.qualification_provider.company_logo.length != null" class="education-image">
                </div>
                <form ng-submit="AddEducation(education)" ng-if="showEducationForm" ng-show="education.isEdID == 0 || education.isEdID == education.id" class="CPE-education-form">
                  <select class="pvm-select" ng-options="degree.value as degree.name for degree in getDegrees" ng-model="education.degree" ng-required="!education.degree">
                    <option selected="selected">Select a degree</option>
                  </select>
                  <input type="text" ng-model="education.otherDegree" placeholder="Other" ng-show="education.degree=='Other'">
                  <div class="CPE-ed-qualification-con">
                    <input type="text" ng-model="education.qualification.display_name" placeholder="Field of study" class="pvm-input-text ed-qualification" required ng-keyup="autoCompleteQualificationEdit(education)">
                    <ul class="CPE__ed-qualification-list pvm-autocomplete-list" ng-show="education.activeID && education.autocomplete == 'qualification'">
                      <li ng-repeat="q in eduQualifications | limitTo : 10" class="CPE__ed-qualification-item pvm-autocomplete-item" ng-click="selectFOS(q, education)">@{{q.display_name}}</li>
                    </ul>
                  </div>
                  <div class="CPE-ed-qualification-provider-con">
                    <input type="text" ng-model="education.qualification_provider.provider_display_name" placeholder="Education Provider" class="pvm-input-text ed-qualification-provider" required ng-keyup="autoCompleteQualificationProEdit(education)">
                    <ul class="CPE__ed-qualification-provider-list pvm-autocomplete-list" ng-show="education.activeID && education.autocomplete == 'provider'">
                      <li ng-repeat="qp in qualificationProviders | filter: education.qualification_provider.provider_display_name | limitTo : 10" class="CPE__ed-qualification-provider-item pvm-autocomplete-item" ng-click="selectProvider(qp, education)">@{{qp.provider_display_name}}</li>
                    </ul>
                  </div>
                  <input type="text" ng-model="education.completed_date" class="pvm-input-text mydatepicker education-completed education-completed--form" ng-click="initDatePicker($event)" placeholder="Completed Date" ng-required="!education.edi_current_study" ng-disabled="education.edi_current_study">
                  <label class="ed-is-present pvm-checkbox">
                  <input type="checkbox" ng-model="education.edi_current_study" ng-true-value="true" ng-false-value="false">
                  <i class="fa fa-check" ng-show="education.edi_current_study"></i>
                  <span>I currently study here</span>
                  </label>
                  <div class="CPE-form-buttons">
                    <input type="submit" value="SAVE" class="btn btn-pvm btn-primary btn-mini">
                    <a href="" ng-click="CancelEducationForm(education)" class="btn btn-pvm btn-default btn-mini">CANCEL</a>
                  </div>
                </form>
              </li>
              <li class="CPE__education-item" ng-if="!educations.length">You haven't uploaded any education yet</li>
            </ul>
            <a href="" ng-click="AddEducationForm()" class="animate-show btn-pvm btn-primary btn-mini CPE-add-button">Add Education</a>
          </div>
          <div class="col-md-3 container" id="right_side_profile" style="padding-right:0px;">
            <div class="add_your_con">
              <h3>ADD/UPDATE YOUR</h3>
              <!-- VIDEO FILE -->
              <div class="link_con text-left">
                <form ondrop="dropVideo(event)" ondragover="allowDrop(event)" class="ng-pristine ng-valid" id="Form" action="/bitbucket/previewme/my-account/" method="post" enctype="multipart/form-data" ng-submit="video_upload()" onsubmit="return false">
                  <p id="Form_error" class="message " style="display: none"></p>
                  <div class="col-md-8" style="border-right: 1px solid #ccc">
                    <div id="Form_video_upload_Holder" class="field file">
                      <span class="left" >VIDEO</span>
                    </div>
                  </div>
                  <div class="col-md-4 no-padding-r">
                    <span class="glyphicon" style="padding:0px 10px;"></span>
                    <!-- desktop -->
                    <span ng-hide="mobile_agent" class="glyphicon pencil-icon pvm-cursor-pointer" id="Form_video_upload" style="margin-right:0; margin-left: 5px;"></span>
                    <!-- mobile -->
                    <label for="mobile_video_upload" ng-show="mobile_agent">
                    <span class="glyphicon pencil-icon pvm-cursor-pointer" style="margin-right:0; margin-left: 5px;"></span>
                    <input name="mobile_video_upload" id="mobile_video_upload"  data-old_file="" type="file" accept="video/*" ng-hide="true">
                    </label>
                    <span ng-if="docs.icebreaker_video.doc_id" class="glyphicon glyphicon-trash pvm-cursor-pointer" onclick="deleteProfileDoc(this)" data-type="video" style="margin-left:5px"></span>
                    <span ng-if="!docs.icebreaker_video.doc_id" class="glyphicon"  style="margin-left:5px"></span>
                  </div>
                  <div class="Actions">
                    <input name="action_doNothing" value="Submit button" class="action" id="Form_action_doNothing" type="submit" ng-hide="true">
                  </div>
                </form>
                <progressbar id="video_progress" class="progress-striped active ng-hide" animate="true" max="100" value="progressValue" type="success"></progressbar>
                <div class="clearfix"></div>
              </div>
              <!-- RESUME FILE -->
              <div class="link_con text-left">
                <form ondrop="dropResume(event)" ondragover="allowDrop(event)" id="Form" action="/bitbucket/previewme/my-account/" method="post" enctype="multipart/form-data" ng-submit="upload()" onsubmit="return false" class="ng-pristine ng-valid ng-invalid-required">
                  <p id="Form_error" class="message" style="display: none"></p>
                  <div class="col-md-8" style="border-right: 1px solid #ccc">
                    <div id="Form_my_file_Holder" class="field file">
                      <span class="left">RESUME</span>
                    </div>
                  </div>
                  <div class="col-md-4 no-padding-r">
                    <a class="custom-icon-eye" ng-href="@{{docs.resume.doc_url}}" target="_blank"></a>
                    <!-- desktop -->
                    <span ng-hide="mobile_agent" class="glyphicon pencil-icon pvm-cursor-pointer" data-docFileType="resume" ng-click="open_file_modal($event)" style="margin-right:0; margin-left: 5px;"></span>
                    <!-- mobile -->
                    <label for="mobile_resume_upload" ng-show="mobile_agent">
                    <span  class="glyphicon pencil-icon pvm-cursor-pointer" data-docFileType="resume"  style="margin-right:0; margin-left: 5px;" data-docFileType="resume">
                    <input name="mobile_resume_upload" id="mobile_resume_upload" data-old_file="" type="file" ng-hide="true">
                    </span>
                    </label>
                    <span ng-if="docs.resume.doc_id" class="glyphicon glyphicon-trash pvm-cursor-pointer" data-type="resume" onclick="deleteProfileDoc(this)" style="margin-left:5px"></span>
                    <span ng-if="!docs.resume.doc_id" class="glyphicon"  style="margin-left:5px"></span>
                  </div>
                  <div class="Actions">
                    <input type="submit" name="action_doNothing" value="Submit button" class="action" id="Form_action_doNothing" ng-hide="true">
                  </div>
                </form>
                <progressbar id="data_progress" class="progress-striped active ng-hide" animate="true" max="100" value="progressResumeValue" type="success"></progressbar>
                <div class="clearfix"></div>
              </div>
              <div class="link_con text-left">
                <div class="col-md-8" style="border-right: 1px solid #ccc">
                  <div>
                    <span>SUPPORTING DOCS</span>
                  </div>
                </div>
                <div class="col-md-4 no-padding-r">
                  <a class="custom-icon-eye" ng-href="@{{docs.portfolio.doc_url}}" target="_blank"></a>
                  <!-- desktop -->
                  <span ng-hide="mobile_agent" class="glyphicon pencil-icon pvm-cursor-pointer" data-docFileType="portfolio" ng-click="open_file_modal($event)" style="margin-right:0; margin-left: 5px;"></span>
                  <!-- mobile -->
                  <label for="mobile_portfolio_upload" ng-show="mobile_agent">
                  <span class="glyphicon pencil-icon pvm-cursor-pointer" style="margin-right:0; margin-left: 5px;"></span>
                  <input name="mobile_portfolio_upload" id="mobile_portfolio_upload" data-old_file="" type="file" ng-hide="true">
                  </label>
                  <span  ng-if="docs.portfolio.doc_id" class="glyphicon glyphicon-trash pvm-cursor-pointer" data-type="portfolio" onclick="deleteProfileDoc(this)" style="margin-left:5px"></span>
                  <span ng-if="!docs.portfolio.doc_id" class="glyphicon"  style="margin-left:5px"></span>
                </div>
                <progressbar id="data_progress_portfolio" class="progress-striped active ng-hide" animate="true" max="100" value="progressPortfolioValue" type="success"></progressbar>
                <div class="clearfix"></div>
              </div>
            </div>
            <hr style="border:1px solid #6f6e6d">
            <div class="reference_title">
              <h3>References</h3>
            </div>
            <div class="row" style="padding-left:15px; padding-right:15px;" ng-repeat="reference in references" ng-if="references.length">
              <div id="ref_@{{reference.id}}" class="reference_con">
                <div class="buttons" ng-show="!rowform.$visible">
                  <a href="" confirmed-click="deleteReference( reference.id )" ng-confirm-click="Are you sure you want to delete this?"  data-id="@{{reference.id}}" class="pull-right" >
                  <span class="glyphicon glyphicon-trash"></span>
                  </a>
                  <a href="" type="button"  class="editfield pull-right" ng-click="rowform.$show()">
                  <span class="glyphicon pencil-icon"></span>
                  </a>
                </div>
                <div class="ref_description_con">
                  <span e-form="rowform" e-placeholder="Description" class="editfield white-space-pre-line" editable-textarea="reference.description" e-name="description">
                  @{{reference.description}}
                  </span>
                </div>
                <br>
                <div class="text-right">
                  <span e-form="rowform" class="editfield pvm-blue" e-placeholder="Employer name" editable-text="reference.employer_name" e-name="employer_name">
                  <span >@{{reference.employer_name}}</span>
                  </span>
                </div>
                <div class="text-right">
                  <span editable-text="reference.companyName" e-placeholder="Company name" e-name="company_name" e-form="rowform" class=" editfield">
                  <span >@{{reference.companyName}}</span>
                  </span>
                  <br>
                </div>
                <div class="text-right">
                  <span editable-text="reference.contactEmail" e-placeholder="Email address" e-name="contact_email" e-form="rowform"  class="editfield">
                  <span >@{{reference.contactEmail}}</span>
                  </span>
                  <br>
                </div>
                <div class="text-right">
                  <span editable-text="reference.contact_phone" e-placeholder="Phone number" e-name="contact_phone" e-form="rowform"  class="editfield">
                  <span >@{{reference.contact_phone}}</span>
                  </span>
                </div>
                <div class="clearfix"></div>
                <form editable-form name="rowform" onbeforesave="EditReference($data, reference.id)" ng-show="rowform.$visible" class="form-buttons form-inline">
                  <div class="pull-right" id="editRefBntHolder">
                    <button type="submit" ng-disabled="rowform.$waiting" class="btn btn-primary-bbt btn btn-pvm btn-primary">
                    SAVE
                    </button>
                    <button type="button" ng-disabled="rowform.$waiting" ng-click="rowform.$cancel()" class="btn btn-default-bbt btn btn-pvm btn-default">
                    CANCEL
                    </button>
                  </div>
                </form>
              </div>
            </div>
            <div class="col-md-12 text-center" ng-if="!references.length">You haven't uploaded any references yet</div>
            <!-- form -->
            <div id="ReferenceForm" ng-show="showReferenceForm" class="animate-show">
              <form ng-submit="AddReference()" id="addReferenceForm">
                <div class="row">
                  <div class="col-md-12">
                    <textarea  name="description" placeholder="Description" required="required"></textarea>
                  </div>
                  <div class="col-md-12">
                    <input  name="employer_name" placeholder="Employer name" required="required">
                  </div>
                  <div class="col-md-12 ">
                    <input type="text"  name="company_name" placeholder="Company name" required="required">
                  </div>
                  <div class="col-md-12 ">
                    <input type="text"  name="contact_email" placeholder="Email address">
                  </div>
                  <div class="col-md-12 ">
                    <input type="text"  name="contact_phone" placeholder="Phone number" >
                  </div>
                  <div class="col-md-8 col-md-offset-4 pull-right">
                    <input type="submit" name="action_doNothing" value="Submit" class="action submit_wh col-md-6" id="Form_action_doNothing">
                    <input type="button" ng-click="CancelReferenceForm()"  class="cancel_wh col-md-6" value="Cancel">
                  </div>
                </div>
              </form>
            </div>
            <div class="clearfix"></div>
            <div class="addReferences"><a href="" ng-click="AddReferenceForm()" class="animate-show">+ Add Reference</a></div>
            <!-- end form -->
          </div>
        </div>
      </div>
    </div>
  </div>
  @include('includes.candidate_modals')
</div>
@stop
@section('scripts')
@stop