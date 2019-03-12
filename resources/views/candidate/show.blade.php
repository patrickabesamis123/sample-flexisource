@extends('layouts.candidate-profile')
@section('styles')
@stop
@section('content')

<div ng-controller="CandidateProfileController"  id="candidate_profile_content" ng-cloak>
  <div class="text-center splash " ng-show="preload">
    <div class="cssload-container">
      <h3>Please wait.</h3>
      <h4>While we prepare this page for you.</h4>
      <div class="cssload-loading"><i></i><i></i><i></i><i></i></div>
    </div>
  </div>

  <div class="container-fluid" ng-show="candidateFlashMessage">
    <div class="row">
      <div class="alert alert-warning alert-dismissible dismissible-custom" role="alert" ng-if="candidateFlashMessage">
        <div class="container">
          <div class="col-md-10" ng-bind-html="candidateFlashMessage">
            </div>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          </div>
      </div>
    </div>
  </div>

  <div class="container-fluid" id="ProfileTop" ng-hide="preload">
    <div class="row">
      <div class="container">

        <div class="col-md-2 col-sm-4" id="phone_image">
          <img ng-src="/images/defaultPhoto.png" width="137" class="img-circle" ng-if="!profile_image">
          <img ng-src="@{{profile_image}}" class="img-circle" width="137" ng-if="profile_image">
          <div style="width:137px; padding-top:10px; text-align:center">
            <a href="/candidate/profile/edit" class="pvm-green" >Edit My Profile</a>
          </div>
        </div>
        <div class="col-md-7 col-sm-8" style="padding-right: 0px;">
          <div class="fullname">
            <h3 class="editable font-mont-bold">@{{first_name}} @{{last_name}} <span ng-if="nickname" class="font-mont-bold">(@{{nickname}})</span></h3>
          </div>
          <span class="position editable">
            @{{ preferred_location.data.display_name || '' }}
            <span ng-if="preferred_location > 0">, </span>
            @{{ preferred_location.data.country.display_name || '' }}
            <i ng-show="willing_to_relocate" class="willing-to-relocate-icon glyphicon gray-tooltip"
            style="width:20px;height:20px;vertical-align:middle;margin-left:5px;top:-2px"
            data-toggle="tooltip" data-placement="top"
            tooltip
            data-original-title="I am willing to relocate to another city"
            ></i>
          </span>
          <br><br>
          <div class="row details">
            <div class="col-md-5">
              <span class="col-md-3 details_title" ng-if="mobile_number">Mobile:</span>
              <span class="col-md-9 word-break no-padding" ng-if="mobile_number">@{{mobile_number}}</span>
              <div class="clearfix"></div>
              <span class="col-md-3 details_title" ng-if="phone_number">Phone:</span>
              <span class="col-md-9 word-break no-padding" ng-if="phone_number">@{{phone_number}}</span>
              <div class="clearfix"></div>
              <span class="col-md-3 details_title" ng-if="email">Email:</span>
              <span class="col-md-9 word-break no-padding" ng-if="email">@{{email}}</span>
            </div>
            <div class="col-md-7">
              <span class="col-md-3 details_title details_title_r" ng-if="industry.industry_display_name">Classification:</span>
              <span class="col-md-9" ng-if="industry.industry_display_name">@{{industry.industry_display_name}}</span>
              <div class="clearfix"></div>
              <span class="col-md-3 details_title details_title_r ellipsis gray-tooltip" data-toggle="tooltip" data-placement="top" tooltip="" data-original-title="
              Sub-Classification" ng-if="industry.sub_industry.display_name">Sub-Classification:</span>
              <span class="col-md-9 " ng-if="industry.sub_industry.display_name">@{{industry.sub_industry.display_name}}</span>
              <div class="clearfix"></div>
              <span class="col-md-3 details_title" ng-if="min_salary !== null && max_salary !== null && min_salary !== 0 && max_salary !== 0 || min_salary !== null && max_salary == null || min_salary == null && max_salary !== null || min_salary == 0 && max_salary !== 0 || min_salary != 0 && max_salary == 0" style="padding-right:0px; color:#ccc">Salary Range:</span>
              <span class="col-md-9 word-break" >
                <span  style="color: #ccc;" ng-Cloak ng-if="min_salary !== null && max_salary !== null && min_salary !== 0 && max_salary !== 0 || min_salary !== null && max_salary == null || min_salary == null && max_salary !== null || min_salary == 0 && max_salary !== 0 || min_salary != 0 && max_salary == 0 ">
                @{{ ( min_salary | currency :"$":0 )}} @{{blank_scope || '-'}} @{{ (max_salary | currency :"$":0) }} <a href="/me/@{{profile_url}}" class="glyphicon lock-icon gray-tooltip" style="width:11px; height:13px;" title="This field will not be displayed on your public profile." data-toggle="tooltip" data-placement="top" tooltip></a>
                </span>
              </span>
            </div>
            <div class="clearfix"></div>
            <div style="margin-left:14px;">
              <span class="pvm-gray" style="padding-right:5px">Private URL:</span>
              <a href="/me/@{{profile_url}}" class="pvm-green">/me/@{{profile_url}}</a>
            </div>
          </div>
        </div>
        <div class="col-md-3 col-md-offset-0 col-sm-8 col-sm-offset-4">
          <div ng-show="preview_img == true">
            <img id="video_placeholder" src="/images/placeholder_vid.png" width="275" data-toggle="modal" ng-click="open_camera()">
          </div>
          <div ng-show="preview_img == false">
            <video id="vid1" class="azuremediaplayer amp-default-skin">
              <p class="amp-no-js">
                To view this video please enable JavaScript, and consider upgrading to a web browser that supports HTML5 video
              </p>
            </video>
          </div>
          <div ng-show="preview_img == 'loading'">
            <img src="/images/video_preload.gif" style="width:276px;padding-bottom:10px">
          </div>
          <div class="row contact_watchlist_btn hidden-md hidden-lg "  >
            <div class="col-sm-6 ">
              <a href="#" class="btn btn-contact" disabled>CONTACT ME</a>
            </div>
            <div class="col-sm-6 ">
              <a href="#" class="btn btn-watchlist" disabled><i class="glyphicon glyphicon-eye-open">
              </i> WATCHLIST
              </a>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12 view_my_con text-center hidden-md hidden-lg"  >
              <div class="col-md-12 view_my pvm-blue">
                <h3>VIEW MY...</h3>
              </div>
              <div class="col-md-12 view_my">
                <a href="@{{resume.doc_url}}" ng-if="resume.doc_url" class=" pvm-full-black">RESUME</a>
                <a href="#" class="btn  pvm-full-black" style="padding:0px;" disabled ng-if="!resume.doc_url">Resume</a>
              </div>
              <div class="col-md-3 col-md-offset-0 col-sm-8 col-sm-offset-4">

                <div ng-show="preview_img == true">
                  <img id="video_placeholder" src="/images/placeholder_vid.png" width="275" data-toggle="modal" ng-click="open_camera()">
                </div>



                <div ng-show="preview_img == false">
                  <video id="vid1" class="azuremediaplayer amp-default-skin">
                      <p class="amp-no-js">
                          To view this video please enable JavaScript, and consider upgrading to a web browser that supports HTML5 video
                      </p>
                  </video>
                </div>

                <div ng-show="preview_img == 'loading'" class="text-center">
                            <img src="/images/ajax-loader-video.gif" style="width:106px;padding-bottom:10px">
                            <div style="margin-bottom: 25px">We will notify you once you video has uploaded. You can still use the full site while the video is processing.</div>
                          </div>

                <div ng-show="preview_img == 'error' "  class="text-center">
                            @{{errorVideo}}
                          </div>



                          <div class="row contact_watchlist_btn hidden-md hidden-lg "  >
                  <div class="col-sm-6 ">
                    <a href="#" class="btn btn-contact" disabled>CONTACT ME</a>
                  </div>
                  <div class="col-sm-6 ">

                    <a href="#" class="btn btn-watchlist" disabled><i class="glyphicon glyphicon-eye-open">
                    </i> WATCHLIST
                    </a>
                  </div>
                </div>

                <div class="row">
                <div class="col-md-12 view_my_con text-center hidden-md hidden-lg"  >
                    <div class="col-md-12 view_my pvm-blue"><h3>VIEW MY...</h3></div>
                    <div class="col-md-12 view_my">
                    <a href="@{{resume.doc_url}}" ng-if="resume.doc_url" class=" pvm-full-black">RESUME</a>
                    <a href="#" class="btn  pvm-full-black" style="padding:0px;" disabled ng-if="!resume.doc_url">Resume</a>
                    </div>
                    <div class="col-md-12 view_my_portfolio">
                    <a href="@{{portfolio.doc_url}}" ng-if="portfolio.doc_url" class="pvm-full-black">SUPPORTING DOCS</a>
                    <a href="#" class="btn  pvm-full-black" style="padding:0px;" disabled ng-if="!portfolio.doc_url">SUPPORTING DOCS</a>

                    </div>

                </div>
                </div>
                  <div class="clearfix"></div>

              <div class="col-md-12 view_my_portfolio">
                <a href="@{{portfolio.doc_url}}" ng-if="portfolio.doc_url" class="pvm-full-black">SUPPORTING DOCS</a>
                <a href="#" class="btn  pvm-full-black" style="padding:0px;" disabled ng-if="!portfolio.doc_url">SUPPORTING DOCS</a>
              </div>
            </div>
          </div>
          <div class="clearfix"></div>
        </div>

      </div>
    </div>
  </div><!-- End ProfileTop -->

  <div class="container-fluid" id="ProfileBottom" ng-hide="preload">
    <div class="row">
      <div class="container">
        <div class="col-md-9" id="ProfileBottom_r_con">
          <div class="row aboutme">
            <div class="col-md-12" style="padding-right:0px">
              <h3 style="margin-top:0px; margin-bottom:0px" >ABOUT ME</h3>
              <br>
              <div class=" content description_content" ng-bind-html="long_description | newlines"></div>
            </div>
          </div>
          <div class=" workhistory" style="border-top:1px solid #ccc" >
            <div class="col-md-4 no-padding" >
              <h3>Work Experience </h3>
            </div>
            <div class="col-md-8">
              <div class="row">
                <div class="workhistory_repeat " ng-repeat="history in work_history | orderBy : sortDate : true" ng-if="work_history.length">
                  <div class="workhistory_item">
                    <div class="title company_name" style="font-size :1.2em;">
                      <div class="col-md-8 no-padding">
                      @{{history.company_name}}
                      </div>
                      <div class="clearfix"></div>
                    </div>
                    <div class="job title job_title">
                      <span  class="title  pvm-blue">
                        @{{history.job_title}} | @{{history.work_type.displayName}}
                      </span>
                    </div>
                    <div class="date_range">
                      <span>
                        @{{history.display_date}}
                      </span>
                    </div>
                    <div>
                       <span class="editfield salary" ng-if="history.salary > 0" style="color:#ccc !important" >
                        @{{'$'+(history.salary | number)}}
                        <span class="glyphicon lock-icon gray-tooltip" title="This field will not be displayed on your public profile." data-toggle="tooltip" data-placement="top" tooltip></span>
                      </span>
                    </div>
                    <br>
                    <div class="qualifitions_holder" ng-if="history.key_accountabilities.length > 0">
                      <div>Key Accountabilities</div>
                      <span class="editfield">
                        @{{history.key_accountabilities.join(', ')}}
                      </span>
                    </div>
                    <br ng-if="history.key_accountabilities.length > 0">
                    <div ng-if="history.description">
                      <div>Job in a Nutshell</div>
                       <span class="editfield">
                        @{{history.description}}
                      </span>
                    </div>
                    <br ng-if="history.description">
                    <hr ng-if="history.industries_display.length != 0" style="width:100px; border:1px solid #eee; margin-left:0;margin-bottom:10px" >
                    <div>
                      <div ng-repeat="(k,v) in history.industries_display">
                        <div>@{{k}}</div>
                        <div class="editfield" style="padding-bottom:8px">@{{v}}</div>
                      </div>
                    </div>
                  </div>
                </div>
                <div ng-if="!work_history.length && new_to_workforce == false || !work_history.length && new_to_workforce == null" class="text-center">No work experience yet</div>
                <div ng-if="!work_history.length && new_to_workforce == true" class="text-center">I am new to workforce</div>
              </div>
            </div>
          </div>
          <div class="clearfix"></div>
          <br><br>
          <div class="workhistory" style="border-top:1px solid #ccc">
            <div class="col-md-4 no-padding">
              <h3>Education</h3>
            </div>
            <div class="col-md-8 no-padding">
              <div class="col-md-12 no-padding">
                <div class="  work-exp-holder" ng-repeat="qualification in qualifications | orderBy : sortDate : true" ng-if="qualifications.length">
                  <div>
                    <div class="col-md-8 no-padding">
                      <strong class="editfield" style="color:#545454 !important">@{{qualification.degree}}</strong>
                    </div>
                    <div class="col-md-4 no-padding" style="text-align:right; position:relative">
                      <img ng-if="qualification.qualification_provider.company_logo" style="width:100px; position:absolute; right:0" ng-src="@{{qualification.qualification_provider.company_logo}}"  />
                    </div>
                    <div class="clearfix"></div>
                  </div>
                  <div class="title">
                    <span class="pvm-black">
                      @{{qualification.qualification.display_name}}
                    </span>
                  </div>
                  <div class="date_range">
                    <span class="pvm-blue">@{{qualification.qualification_provider.provider_display_name}}</span>
                  </div>
                  <div class="date_range">
                    <span class="editable" ng-bind="qualification.completed_date | date : 'dd-MM-yyyy'">@{{qualification.completed_date}}</span>
                  </div>
                </div>
                <div ng-if="!qualifications.length" class="text-center">You haven't uploaded any education yet</div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-3" style="padding-right:0px;">
          <div class="col-md-12 contact_watchlist_btn hidden-xs hidden-sm" style="width:275px;">
            <div class="col-md-6 ">
              <a href="#" class="btn btn-contact pull-left" disabled>CONTACT ME</a>
            </div>
            <div class="col-md-6 ">
              <a href="#" class="btn btn-watchlist pull-right" disabled><i class="glyphicon glyphicon-eye-open">
              </i> WATCHLIST
              </a>
            </div>
          </div>
          <div class="col-md-12 view_my_con text-center hidden-xs hidden-sm" style="width:275px;">
            <div class="col-md-12 view_my pvm-blue"><h3>VIEW MY...</h3></div>
            <div class="col-md-12 view_my">
            <a href="@{{resume.doc_url}}" ng-if="resume.doc_url" class=" pvm-full-black">RESUME</a>
            <a href="#" class="btn  pvm-full-black" style="padding:0px;" disabled ng-if="!resume.doc_url">Resume</a>
            </div>
            <div class="col-md-12 view_my_portfolio">
              <a href="@{{portfolio.doc_url}}" ng-if="portfolio.doc_url" class="pvm-full-black">SUPPORTING DOCS</a>
              <a href="#" class="btn  pvm-full-black" style="padding:0px;" disabled ng-if="!portfolio.doc_url">SUPPORTING DOCS</a>
            </div>
          </div>
          <div class="clearfix"></div>
            <hr style="border:1px solid #ccc; width:275px;" class="hidden-sm hidden-xs divideme">
            <div class="reference_title">
              <h3>References</h3>
            </div>
            <div class="col-md-12 reference_con" ng-repeat="reference in references" ng-if="references.length" style="width:275px;">
              <div class="white-space-pre-line">@{{reference.description}}</div>
              <div class="col-md-12 ref_emp_com">
                <spam class="pull-right pvm-blue">@{{reference.employer_name}}</spam><br>
                <spam class="pull-right">@{{reference.companyName}}</spam><br>
                <small class="pull-right">@{{reference.contact_phone}}</small><br>
                <small class="pull-right">@{{reference.contactEmail}}</small>
              </div>
            </div>
            <div ng-if="!references.length" class="text-center">You haven't uploaded any references yet</div>
        </div>
      </div>
    </div>
  </div>
</div>



@stop
@section('scripts')
@stop
