@extends('layouts.candidate')
@section('styles')
<link href="css/candidate-settings.css" rel="stylesheet">
<link href="css/trackpad-scroll-emulator.min.css" rel="stylesheet">
@stop
@section('content')
<div class="section_container">
  <div class="dashsection whiteBg displaydashsection" id="Section1">
    <div class="row">
      <div class="col-md-4">
        <div class="animateSection">
          <div class="dashsection_title pull-left"> <span class="dash_inc">00</span> </div>
          <div class="pull-left dash_subTitlte"><span class="jobs-holder">JOBS</span> THAT YOU <br>APPLIED FOR</div>
          <div class="clearfix"></div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="animateSection">
          <div class="dashsection_title pull-left"> <span class="dash_inc">00</span></div>
          <div class="pull-left dash_subTitlte"><span class="jobs-holder">JOBS</span> IN YOUR<br>WATCHLIST</div>
          <div class="clearfix"></div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="animateSection last">
          <div class="dashsection_title pull-left"> <span class="dash_inc">00</span> </div>
          <div class="pull-left dash_subTitlte">NEW <span class="jobs-holder">JOBS</span> MATCH <br>YOUR CRITERIA</div>
          <div class="clearfix"></div>
        </div>
      </div>
    </div>
  </div>
  <div class=" job-application-section" id="job-application-holder">
    <ul class="nav nav-tabs" id="jobs_tab">
      <li class="job-applications-tab" id="applied_tab">
          <a href="#applied" data-toggle="tab" ng-click="jobContent('applied')">ACTIVE JOBS <span>(@{{activeCount}})</span></a>
      </li>
      <li class="job-applications-tab" id="draft_tab" ng-click="jobContent('draft')">
          <a href="#draft" data-toggle="tab">DRAFTS <span>(@{{draftCount}})</span></a>
      </li>
      <li class="job-applications-tab" id="expired_tab" ng-click="jobContent('expired')">
          <a href="#expired" data-toggle="tab">CLOSED JOBS <span>(@{{expiredCount}})</span></a>
      </li>
    </ul>
    <div class="tab-content col-md-12 tse-scrollable" id="application-contents" >
      <div class="text-center splashdata" ng-show="!jobApplicationActive">
        <img src="//themes/bbt/images/preloader.gif" width="30">
        <h4>Loading data</h4>
      </div>

      <div class="tse-content" ng-show="jobApplicationActive" >
        <div id="applied" class="tab-pane fade active in">
          <div ng-show="jobApplicationActive"  ng-if="jobApplicationActive.count > 0" class="jobList"
              ng-repeat="job in jobApplicationActive.jobs | orderBy : sortAppliedDate : true">
            <div class="col-md-2">
              <div class="JobCompany" style="height:100px; width:100px; display:flex; align-items:center">
                <img ng-if="job.job.job.company.logo_url" ng-src="@{{job.job.job.company.logo_url}}" class="img-circle" style="width:80px" />
                <span ng-if="!job.job.job.company.logo_url" class="member-initials member-initials--lg @{{job.job.job.company.profile_color}}">@{{job.job.job.company.initial}}</span>
                <!--  <div  class="img-circle pvm-blue-background" style="height:80px; width:80px; display:flex; align-items:center; line-height:14px;">
                    @{{job.job.company.company_name}}
                </div> -->
              </div>
            </div>
            <div class="col-md-8" style="border-right:1px #ccc solid;">
              <div class="row">
                <div class="col-md-12">
                  <span class="top">
                    <a data-ajax="false" href="/job/listing/@{{job.job.object_id}}">
                      <h4 class="jobName">
                        @{{job.job.job_title}}
                      </h4>
                    </a>
                    <div class="jobShortDescription" ng-bind-html="job.job.job_description"></div>
                  </span>
                </div>
              </div>
              <div class="row jobsmaldeatils">
                <div class="col-md-4 col-xs-12">
                  <i class="job-search-icons job-search-address-icon pull-left" style="width:15px;"> </i>
                  <span class="pull-left search-content">
                    @{{job.job.job.company.company_name}}
                  </span>
                  <div class="clearfix"></div>
                </div>
                <div class="col-md-8 col-xs-12">
                  <i class="job-search-icons job-search-marker-icon pull-left" style="width:15px;"></i>
                  <span class="pull-left search-content search-content2">9999
                    @{{job.job.job.location.display_name}}, @{{job.job.job.location.country[0].codeDisplayName}}
                  </span>
                  <div class="clearfix"></div>
                </div>
              </div>
            </div>
            <div class="col-md-2 jobsmaldeatils">
              <div>
                <strong style="color:black">Applied</strong><br>
                <span>@{{job.application.applied_date}}</span><br>
                <strong style="color:black">@{{job.job.expiredText}}</strong><br>
                <span class="pvm-red" ng-if="job.job.days_left < 6 || job.job.expiredText == 'Expired'">@{{job.job.expiry_date}}</span>
                <span ng-if="job.job.days_left > 6 && job.job.expiredText == 'Expires'">@{{job.job.expiry_date}}</span>
              </div>
              <div id="SearchPage">
                <a href="/job/listing/@{{job.job.object_id}}" class="showJobbutton btn">
                  View Job
           		  </a>
                <a href=""
                ng-click="jobContent('applied', job.application.application_id, false, job.job.isRedColor)"
                class="btn deletejobbutton" style="letter-spacing: 0px">
                    View Application
       		      </a>
              </div>
            </div>
            <div class="clearfix"></div>
          </div>
          <div  ng-show="jobApplicationActive" ng-if="jobApplicationActive.count == 0"><br><br>
            <p class="text-center">You don't have any active jobs in your list.</p>
          </div>
        </div>
        <div id="draft" class="tab-pane fade">
          <div class="text-center splashdata" ng-show="!jobApplicationDraft">
            <img src="//themes/bbt/images/preloader.gif" width="30">
            <h4>Loading data</h4>
          </div>

          <div ng-show="jobApplicationDraft"  ng-if="jobApplicationDraft.count > 0" class="jobList job_draft_item_@{{job.job.object_id}}" ng-repeat="job in jobApplicationDraft.jobs | orderBy : sortAppliedDate : true">
            <div class="col-md-2">
              <div class="JobCompany" style="height:100px; width:100px; display:flex; align-items:center">
                <img ng-if="job.job.job.company.logo_url" ng-src="@{{job.job.job.company.logo_url}}" class="img-circle" style="width:80px" />
                <span ng-if="!job.job.job.company.logo_url" class="member-initials member-initials--lg @{{job.job.job.company.profile_color}}">@{{job.job.job.company.initial}}</span>
                <!-- <div ng-if="!job.job.company.logo_url" class="img-circle pvm-blue-background" style="height:80px; width:80px; display:flex; align-items:center;line-height:14px;">
                    @{{job.job.company.company_name}}
                </div> -->
              </div>
            </div>
            <div class="col-md-8" style="border-right:1px #ccc solid;">
              <div class="row">
                <div class="col-md-12">
                  <span class="top">
                    <a data-ajax="false" href="#">
                      <h4 class="jobName">
                          @{{job.job.job_title}}
                      </h4>
                    </a>
                    <div class="jobShortDescription" ng-bind-html="job.job.job_description"></div>
                  </span>
                </div>
            </div>
            <div class="row jobsmaldeatils">
              <div class="col-md-4 col-xs-12">
                <i class="job-search-icons job-search-address-icon pull-left" style="width:15px;"></i>
                <span class="pull-left search-content">
                  @{{job.job.job.company.company_name}}
                </span>
                <div class="clearfix"></div>
              </div>
              <div class="col-md-8 col-xs-12">
                <i class="job-search-icons job-search-marker-icon pull-left" style="width:15px;"></i>
                <span class="pull-left search-content search-content2">
                  @{{job.job.job.location.display_name}}, @{{job.job.job.location.country[0].codeDisplayName}}
                </span>
                <div class="clearfix"></div>
              </div>
            </div>
          </div>
          <div class="col-md-2 jobsmaldeatils">
            <div>
              <strong style="color:black">@{{job.job.expiredText}}</strong><br>
              <span class="pvm-red" ng-if="job.job.days_left < 6 || job.job.expiredText == 'Expired'">@{{job.job.expiry_date}}</span>
              <span ng-if="job.job.days_left > 6 && job.job.expiredText == 'Expires'">@{{job.job.expiry_date}}</span>
            </div>
            <div id="SearchPage">
              <a href="/job/listing/@{{job.job.object_id}}" class="btn showJobbutton">
                View Job
              </a><br>
              <a href="/job/application?id=@{{job.application.application_id}}&job_id=@{{job.job.object_id}}&next_step=@{{job.application.next_step}}" class="btn deletejobbutton" ng-click="viewJob( job.job.object_id )">
                <i class="fa fa-pencil"></i> Continue
              </a>
              <!-- <a class="shareJobbutton btn" ng-click="deleteJob( job.job.object_id, job.application.application_id)">
                  <i class="glyphicon glyphicon-trash"></i><span class="del_text"> Delete Job</span>
              </a> -->
            </div>
          </div>
          <div class="clearfix"></div>
        </div>
        <div ng-show="jobApplicationDraft"  ng-if="jobApplicationDraft.count == 0"><br><br>
          <p class="text-center">You don't have any draft jobs in your list.</p>
        </div>
      </div>
      <div id="expired" class="tab-pane fade">
        <div class="text-center splashdata" ng-show="!jobApplicationExpired">
          <img src="//themes/bbt/images/preloader.gif" width="30">
          <h4>Loading data</h4>
        </div>

        <div ng-show="jobApplicationExpired"  ng-if="jobApplicationExpired.count > 0" class="jobList" ng-repeat="job in jobApplicationExpired.jobs | orderBy : sortAppliedDate : true">
          <div class="col-md-2">
            <div class="JobCompany" style="height:100px; width:100px; display:flex; align-items:center">
              <img ng-if="job.job.job.company.logo_url" ng-src="@{{job.job.job.company.logo_url}}" class="img-circle" style="width:80px" />
              <span ng-if="!job.job.job.company.logo_url" class="member-initials member-initials--lg @{{job.job.job.company.profile_color}}">@{{job.job.company.initial}}</span>
              <!-- <div ng-if="!job.job.company.logo_url" class="img-circle pvm-blue-background" style="height:80px; width:80px; display:flex; align-items:center;line-height:14px;">
                  @{{job.job.company.company_name}}
              </div> -->
            </div>
          </div>
          <div class="col-md-8" style="border-right:1px #ccc solid;">
            <div class="row">
              <div class="col-md-12">
                <span class="top">
                  <a data-ajax="false" href="#">
                    <h4 class="jobName">
                        @{{job.job.job_title}}
                    </h4>
                  </a>
                  <div class="jobShortDescription" ng-bind-html="job.job.job_description"></div>
                </span>
              </div>
            </div>
            <div class="row jobsmaldeatils">
              <div class="col-md-4">
                <i class="job-search-icons job-search-address-icon pull-left" style="width:15px;"></i>
                <span class="pull-left search-content">
                  @{{job.job.job.company.company_name}}
                </span>
                <div class="clearfix"></div>
              </div>
              <div class="col-md-4">
                <i class="job-search-icons job-search-marker-icon pull-left" style="width:15px;"></i>
                <span class="pull-left search-content search-content2">
                  @{{job.job.job.location.display_name}}, @{{job.job.job.location.country[0].codeDisplayName}}
                </span>
                <div class="clearfix"></div>
              </div>
              <div class="col-md-4"></div>
            </div>
          </div>
          <div class="col-md-2 jobsmaldeatils">
            <div>
              <strong style="color:black">@{{job.job.job_closing_reason}}</strong><br>
              <span class="pvm-red" ng-if="job.job.days_left < 6 || job.job.expiredText == 'Expired'">@{{job.job.expiry_date}}</span>
              <span ng-if="job.job.days_left > 6 && job.job.expiredText == 'Expires'">@{{job.job.expiry_date}}</span>
            </div>
            <div id="SearchPage">
              <a disabled href="#" class="deletejobbutton btn" ng-if="!job.job.report_generated">
                <i class="glyphicon analytics-icon" style="width:14px;height:12px;"></i>
                <span class="del_text">My Report</span>
              </a>
              <a href="/analytics" class="deletejobbutton btn" ng-if="job.job.report_generated">
                <i class="glyphicon analytics-icon" style="width:14px;height:12px;"></i>
                <span class="del_text">My Report</span>
              </a>
              <br>
              <div id="SearchPage">
                <a href="/job/listing/@{{job.job.object_id}}" class="showJobbutton btn">View Job</a>
                <a href=""
                ng-click="jobContent('applied', job.application.application_id, false, job.job.isRedColor)" class="btn deletejobbutton" style="letter-spacing: 0px">
                  View Application
                </a>
              </div>
            </div>
          </div>
          <div class="clearfix"></div>
        </div>
        <div ng-show="jobApplicationExpired" ng-if="jobApplicationExpired.count == 0"><br><br>
          <p class="text-center">You don't have any expired jobs in your list.</p>
        </div>
      </div>
      <div id="applied-application" class="tab-pane fade">
        <div class="text-center splashdata" ng-show="AllJobDetails.length == 0">
          <img src="//themes/bbt/images/preloader.gif" width="30">
          <h4>Loading data</h4>
        </div>
        <div class="col-md-12" ng-show="AllJobDetails.length != 0">
          <div  style="border-bottom:1px solid #ccc;padding:20px 0px;">
            <a href="" ng-click="jobContent('applied')" class="pvm-gray"><i class="glyphicon glyphicon-menu-left"></i> Back to all @{{current_tab}} Jobs</a>
          </div>
          <br>
          <div class="col-md-12 row" id="application-details-holder">
            <div class="col-md-4 @{{section1Border}}" id="application-details-sec1" style="padding-right:0px;padding-left:0px;">
              <div  class="navbar navbar-default">
                <ul  class="nav navbar-nav" id="applied-application-nav" style="width:100%">
                  <li ng-class="preapprovalActive" id="pre-approval"><a href="" ng-click="showQuestionsContent('pre-approval')">Pre-Approval Questions</a></li>
                  <li id="standard" ng-class="standardActive"><a href="" ng-click="showQuestionsContent('standard')">Standard Questions</a></li>
                </ul>
              </div>
              <div class="col-md-12" style="padding-left: 0px">
                <div class="my-job-section pvm-border-top-light-gray2">
                  <div class="JobCompany" style="height:100px; width:100px; display:flex; align-items:center">
                    <img ng-if="job.company.logo_url" ng-src="@{{job.company.logo_url}}" class="img-circle" style="width:100px" />
                    <span ng-if="!job.company.logo_url" class="member-initials member-initials--lg @{{job.company.profile_color}}">@{{job.company.initial}}</span>
                    <!-- <div ng-if="!job.company.logo_url" class="img-circle pvm-blue-background" style="height:100px; width:100px; display:flex; align-items:center; line-height:14px;">
                      <div style="width:100%">@{{job.company.company_name}}</div>
                    </div> -->
                  </div>
                  <h4 class="pvm-blue">@{{job.job_title}}</h4>
                  <p ng-bind-html="job.job_description"></p>
                </div>
                <div class="my-job-section">
                 	<div style="display:flex;padding:10px 0px;">
                    <i class="job-search-icons job-search-address-icon" style="margin-right:15px"></i>
                    <span class="search-content jobsmaldeatils">@{{job.company.company_name}}</span>
                  </div>
                  <div style="display:flex;padding:10px 0px;">
                    <i class="job-search-icons job-search-marker-icon" style="margin-right:15px"></i>
                      <span class="search-content search-content2 jobsmaldeatils" style="align-items:center">
                        @{{job.location.display_name}}
                      </span>
                  </div>
                </div>
                <div style="padding:15px 0px;">
                	<div>
                    <div><strong>Applied</strong></div>
                    <div style="padding-bottom:5px">
                    <span class="jobsmaldeatils">@{{application.applied_date_obj | date: 'EEE, d MMM yyyy'}}</span>
                    </div>
                    <div><strong>@{{expiredText}}</strong></div>
                    <div><span class="jobsmaldeatils @{{isRedColor}}">@{{job.expiry_date_obj | date: 'EEE, d MMM yyyy'}}</span></div>
                  </div><br>
                  <div id="SearchPage" style="width:150px">
                    <a href="/job/listing/@{{job.object_id}}" class="showJobbutton btn">View Job</a>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-8 @{{section2Border}}" id="application-details-sec2" >
            	<div id="pre-approval" ng-show="questionHideShow">
            		<h4 class="pvm-blue" style="margin-top:0;margin-bottom:30px;">Pre-Approval Questions</h4>
              		<table class="table hidden-xs">
                    <colgroup>
                			<col class="col-md-8">
                			<col class="col-md-4">
                    </colgroup>
                    <thead>
                			<tr class="pvm-gray2-background">
                				<th style="padding-left:20px">Questions</th>
                				<th style="font-family:'Montserrat-Light', Arial, serif">
                    				<div class="col-md-3">Yes</div>
                    				<div class="col-md-6">Developing</div>
                    				<div class="col-md-3">No</div>
                				</th>
                			</tr>
                    </thead>
                			<tr ng-repeat="item in application.pre_apply_questions">
                				<td style="padding-left:20px">@{{item.question}}</td>
                				<td colspan="3">
                					<ul>
                						<li  ng-repeat="(key, ans) in preApprovalAnswers"
                						ng-class="{'col-md-6' : key == 1, 'col-md-3' : key == 0 || key == 2}">
                							<img src="/images/blue.png" class="img-circle" ng-if="item.answer == ans " width="12"/>
                              <img src="/images/gray.png" class="img-circle" ng-if="item.answer != ans " width="12"/>
                						</li>
                					</ul>
                				</td>
                			</tr>
					        </table>
                  <ul class="visible-xs xs-Question">
                    <li ng-repeat="item in application.pre_apply_questions">
                      <h5>Question:</h5>
                      @{{item.question}}
                      <br>
                      <div class="row">
                        <div class="col-xs-3 text-center"><h5>Yes</h5></div>
                        <div class="col-xs-6 text-center"><h5>Developing</h5></div>
                        <div class="col-xs-3 text-center"><h5>No</h5></div>
                      </div>
                      <ul class="PreApplyAns">
                        <li  ng-repeat="(key, ans) in preApprovalAnswers" ng-class="{'col-xs-6' : key == 1, 'col-xs-3' : key == 0 || key == 2}">
                          <img src="/images/blue.png" class="img-circle" ng-if="item.answer == ans " width="12"/>

                          <img src="/images/gray.png" class="img-circle" ng-if="item.answer != ans " width="12"/>
                          <div class="clearfix"></div>
                        </li>
                      </ul>
                    </li>
                  </ul>
              	</div>
              	<div id="standard" ng-hide="questionHideShow">
                  <h4 class="pvm-blue" style="margin-top:0;margin-bottom:30px;">Standard Questions</h4>
                    <table class="table hidden-xs">
                      <colgroup>
                        <col class="col-md-8">
                        <col class="col-md-4">
                      </colgroup>
                      <thead>
                        <tr class="pvm-gray2-background">
                          <th style="padding-left:20px">Questions</th>
                          <th style="font-family:'Montserrat-Light', Arial, serif">Your Answers</th>
                        </tr>
                      </thead>
                      <tr ng-repeat="(key, item) in application.application_questions">
                        <td style="padding-left:20px">@{{item.question}}</td>
                        <td>
                          <span ng-if="item.answer_type == 'boolean' || item.answer_type == 'multiple_choice'" id="q_@{{key}}">
                            @{{item.answer}}
                          </span>
                          <div ng-if="item.answer_type == 'free_text'" class="tse-scrollable sliderContainer" id="qstin_@{{key}}" style="max-height: 300px;height: 100%!important;">
                            <div class="tse-content vertical ">
                              @{{item.answer}}
                            </div>
                          </div>
                          <div ng-if="item.answer_type == 'free_text'">
                            <script type="text/javascript">
                              $('.sliderContainer').TrackpadScrollEmulator();
                            </script>
                          </div>
                          <span ng-if="item.answer_type == 'file_upload'">
                            <a href="@{{item.answer.doc_url}}" target="_blank">Click here to preview the file</a>
                          </span>
                          <span ng-show="item.answer_type == 'video'">
                            <!-- <video id="@{{item.video_id}}" class="azuremediaplayer amp-default-skin" poster="/images/video_preload.gif" width="200"></video> -->
                            <video id="@{{item.video_id}}" class="azuremediaplayer amp-default-skin" width="200" ng-hide="!item.answer.doc_url"></video>
                            <div ng-show="!item.answer.doc_url" style="border: #b0b0b0 1px solid; padding: 25px; background: #ccc;">
                              Video is not yet ready. Please come back later.
                            </div>
                          </span>
                        </td>
                      </tr>
                    </table>
                    <style>
                      .sliderContainer .tse-scroll-content{
                          width: 200px;height: 100%!important;max-height: 300px;
                      }
                    </style>
                    <ul class="visible-xs xs-Question">
                      <li ng-repeat="item in application.application_questions">
                        <h5>Question:</h5>
                        @{{item.question}}
                        <br>

                        <h5>Your Answers</h5>
                        <span ng-if="item.answer_type == 'free_text' || item.answer_type == 'boolean' || item.answer_type == 'multiple_choice'">
                          @{{item.answer}}
                        </span>
                        <span ng-if="item.answer_type == 'file_upload'">
                          <a href="@{{item.answer.doc_url}}" target="_blank">Click here to preview the file</a>
                        </span>
                        <span ng-show="item.answer_type == 'video'">
                          <video id="@{{item.video_id}}" class="azuremediaplayer amp-default-skin" poster="/images/video_preload.gif" width="200"></video>
                        </span>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
            <div class="clearfix"></div>
        </div>
      </div>
    </div>
  </div>
</div>

@stop
