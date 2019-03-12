@extends('layouts.home')

@section('styles')
<link rel="stylesheet" href="css/helpers2.css" />
<link rel="stylesheet" href="css/responsive-media.css" />
@stop

@section('content')

<?php 
$baseUrl = "http://previewme.co/";
?>

<div id="JobListing" ng-controller="JoblistingController" ng-cloak>
    <div class="text-center splash" ng-show="!joblisting">
        <div class="cssload-container">
            <h3>Please wait.</h3>
            <h4>While we prepare this page for you.</h4>
            <div class="cssload-loading"><i></i><i></i><i></i><i></i></div>
        </div>
    </div>
    <div ng-show="joblisting">
        <div ng-if="joblisting.company.company_banner_url" class="company_banner" style="background-image: url('@{{joblisting.company.company_banner_url}}');"></div>
        <div ng-if="!joblisting.company.company_banner_url" class="company_banner" style="background-image: url(''<?php echo $baseUrl; ?>''/images/Default-Header.png');"></div>
        <input type="hidden" id="job-listing-id" value="{$jobId}" />
        
        <div id="job-listing-top-con" class="container-fluid">
            <div class="row">
                <div class="container">
                    <div class="row">
                        <!-- logo -->
                        <div class="col-md-2 text-xs-center" id="job-listing-logo-con1">
                            <a href="{$BaseHref}company/@{{joblisting.company.company_url}}">
                            <img ng-if="joblisting.company.logo_url" class="img-circle" ng-src="@{{joblisting.company.logo_url}}" height="150px" width="150px" />
                            <!-- <img ng-if="!joblisting.company.logo_url" class="img-circle" src="{$ThemeDir}/images/default_company_logo.png" height="150px" width="150px" /> -->
                            <div ng-show="joblisting.company_logo_url == '' || joblisting.company_logo_url == false" class="member-initials member-initials--lg @{{joblisting.company.profile_color}}">@{{joblisting.company.initial}}</div>
                            </a>
                        </div>
                        <div class="col-md-5 text-xs-center" id="job-listing-title-con1">
                            <!-- job info1 -->
                            <h3 class="pvm-blue"><a href="/company/previewme" class="no-visited">@{{joblisting.company.company_name}}</a></h3>
                            <h4>@{{joblisting.job_title}}</h4>
                            <h5>@{{joblisting.company.industry.data.industry.display_name}}</h5>

                            <div class="col-md-12 job-listing-icons-con">
                                <div class="container-auto-align-center">
                                    <div class="job-listing-icons">
                                      <div class="image_con">
                                        <img class="job-listing-icon1" ng-src="http://<?php echo $_SERVER['SERVER_NAME']; ?>/images/job-listing-icon1.png" />
                                      </div>
                                      <p>
                                        <small>
                                          @{{joblisting.location.display_name || ''}}
                                          <span ng-if="joblisting.location.country.short_name">,</span>
                                          @{{joblisting.location.country.short_name || ''}}
                                        </small>
                                      </p>
                                    </div>
                                    <div class="job-listing-icons" ng-show="joblisting.is_salary_public && joblisting.salary_notes != null">
                                      <div class="image_con">
                                        <img class="job-listing-icon2" ng-src="http://<?php echo $_SERVER['SERVER_NAME']; ?>/images/job-listing-icon2.png" />
                                      </div>
                                       <p>
                                        <small>@{{joblisting.salary_notes}}</small>
                                      </p>
                                    </div>
                                    <div class="job-listing-icons" ng-if="joblisting.start_time || joblisting.finish_time || joblisting.flexible_hours">
                                      <div class="image_con">
                                        <img class="job-listing-icon3" ng-src="http://<?php echo $_SERVER['SERVER_NAME']; ?>/images/job-listing-icon3.png" />
                                      </div>
                                      <p>
                                        <small ng-if="joblisting.start_time || joblisting.finish_time">
                                            @{{joblisting.start_time}}
                                            <span ng-if="joblisting.finish_time"> - </span>
                                            @{{joblisting.finish_time}}
                                        </small>
                                        <small ng-if="joblisting.flexible_hours == true">
                                          Flexible
                                        </small>
                                      </p>
                                    </div>
                                    <div class="job-listing-icons">
                                      <div class="image_con">
                                        <img class="job-listing-icon2" ng-src="http://<?php echo $_SERVER['SERVER_NAME']; ?>/images/icons/parttime.png" />
                                      </div>
                                      <p>
                                        <small>@{{joblisting.role_type.display_name}}</small>
                                      </p>
                                    </div>
                                    <div class="job-listing-icons">
                                      <div class="image_con">
                                        <img class="job-listing-icon2" ng-src="http://<?php echo $_SERVER['SERVER_NAME']; ?>/images/icons/highPotential.png" />
                                      </div>
                                      <p>
                                        <small>@{{joblisting.experience_string}}</small>
                                      </p>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <!-- eof job info1 -->
                        </div>
                        <div class="col-md-5"></div>        
                    </div>
                </div>
            </div><!-- eof row1 -->
            <div class="clearfix"></div>
        </div>

        <div class="container-fluid" id="job-listing-content-con1">
          <div class="row">
            <div class="container">
                <div class="row">
                    <div class="col-md-7 padb-40" id="job-listing-buttons-holder">
                        <div class="row">
                                <div id="job_listed_con">
                                <div id="job_listed_holder">
                                  <div class="job_listed">
                                    <div>JOB LISTED</div>
                                    <div>@{{joblisting.created_date}}</div>
                                  </div>
                                  <div class="job_listed">
                                    <div>LISTING EXPIRES</div>
                                    <div>@{{joblisting.expiry_date}}</div>
                                  </div>
                                </div>
                                <br>
                                <div id="job_you_need_holder">
                                  <div class="job_listed">
                                    <p>FOR THIS JOB YOU WILL NEED:</p>
                                    <ul class="padding-l-zero">
                                      <li>
                                        <i class="glyphicon glyphicon-ok" ng-show="joblisting.application_requirements.icebreaker_video === 'yes'"></i>
                                        <i class="glyphicon glyphicon-remove " ng-show="joblisting.application_requirements.icebreaker_video === 'no' || !joblisting.application_requirements.icebreaker_video"></i>
                                        <span class="requirement-content">Profile Video</span>
                                      </li>
                                      <li>
                                        <i class="glyphicon glyphicon-ok" ng-show="joblisting.application_requirements.about_me === 'yes'"></i>
                                        <i class="glyphicon glyphicon-remove" ng-show="joblisting.application_requirements.about_me === 'no' || !joblisting.application_requirements.about_me"></i>
                                        <span class="requirement-content">General Details</span>
                                      </li>
                                      <li>
                                        <i class="glyphicon glyphicon-ok" ng-show="joblisting.application_requirements.portfolio === 'yes'"></i>
                                        <i class="glyphicon glyphicon-remove " ng-show="joblisting.application_requirements.portfolio === 'no' || !joblisting.application_requirements.portfolio"></i>
                                        <span class="requirement-content">Portfolio</span>
                                      </li>
                                      <li>
                                        <i class="glyphicon glyphicon-ok" ng-show="joblisting.application_requirements.references === 'yes'"></i>
                                        <i class="glyphicon glyphicon-remove " ng-show="joblisting.application_requirements.references === 'no' || !joblisting.application_requirements.references"></i>
                                        <span class="requirement-content">References</span>
                                      </li>
                                      <li>
                                        <i class="glyphicon glyphicon-ok" ng-show="joblisting.application_requirements.education === 'yes'"></i>
                                        <i class="glyphicon glyphicon-remove " ng-show="joblisting.application_requirements.education === 'no' || !joblisting.application_requirements.education"></i>
                                        <span class="requirement-content">Education</span>
                                      </li>
                                      <li>
                                        <i class="glyphicon glyphicon-ok" ng-show="joblisting.application_requirements.work_experience === 'yes'"></i>
                                        <i class="glyphicon glyphicon-remove " ng-show="joblisting.application_requirements.work_experience === 'no' || !joblisting.application_requirements.work_experience"></i>
                                        <span class="requirement-content">Work History/Experience</span>
                                      </li>
                                      <li>
                                        <i class="glyphicon glyphicon-ok " ng-show="joblisting.application_requirements.resume === 'yes'"></i>
                                        <i class="glyphicon glyphicon-remove " ng-show="joblisting.application_requirements.resume === 'no' || !joblisting.application_requirements.resume"></i>
                                        <span class="requirement-content">Resume</span>
                                      </li>
                                      <li>
                                        <i class="glyphicon glyphicon-ok " ng-show="joblisting.application_requirements.transcript === 'yes'"></i>
                                        <i class="glyphicon glyphicon-remove " ng-show="joblisting.application_requirements.transcript === 'no' || !joblisting.application_requirements.transcript"></i>
                                        <span class="requirement-content">Transcript</span>
                                      </li>
                                      <li>
                                        <i class="glyphicon glyphicon-ok " ng-show="joblisting.application_requirements.cover_letter === 'yes'"></i>
                                        <i class="glyphicon glyphicon-remove " ng-show="joblisting.application_requirements.cover_letter === 'no' || !joblisting.application_requirements.cover_letter"></i>
                                        <span class="requirement-content">Cover Letter</span>
                                      </li>
                                    </ul>
                                    <div class="text-center" ng-if="ut == 'candidate' || !ut">
                                      <a href="#" ng-if="!applied && joblisting.is_job_expired == false && joblisting.is_role_active == true" ng-click="ApplyJob()" class="job-listing-question-button btn  btn-see-profile">APPLY FOR THIS JOB</a>
                                      <a href="#" ng-if="applied && joblisting.is_job_expired == false && joblisting.is_role_active == true" class="gray-tooltip job-listing-question-button btn  btn-see-profile" disabled tooltip data-toggle="tooltip" data-original-title="You have already applied for the role. However if you have not fully completed your application, you can do so in your Dashboard (My Job Applications > Drafts).">APPLIED</a>
                                      <a href="#" ng-if="joblisting.is_job_expired == true" class="btn btn-expired" disabled>Expired</a>
                                      <a href="#" ng-if="joblisting.is_role_active == false && joblisting.is_job_expired == false" class=" btn btn-role-filled" disabled>Role Filled</a>
                                    </div>
                                    <div class="text-center" ng-if="ut == 'employer'">
                                      <a href="#" style="width:100%" disabled class="job-listing-question-button btn btn-see-profile">APPLY FOR THIS JOB</a>
                                    </div>
                                  </div>
                                </div>
                                <br>
                                <div id="job_you_need_holder">
                                    <div class="job_listed">
                                        <div class="text-center">
                                            <a href="#" ng-click="save_to_watchlist()" class="job-listing-question-button width-100  btn-save-to-watchlist"><i class="glyphicon glyphicon-eye-open watchlist_save"></i> @{{watchlist_text}}</a>
                                        </div>
                                        <div class="text-center">
                                            <div class="col-md-4 padding-l-zero padding-l-zero job-listing-btn-watchlist">
                                                <a href="javascript:void(0)" ng-click="openEmail()" class="job-listing-question-button width-100  btn-save-to-watchlist">EMAIL</a>
                                            </div>
                                            <div class="col-md-4 job-listing-btn-watchlist">
                                                <a href="#" ng-click="printJoblisting()" class="job-listing-question-button width-100  btn-save-to-watchlist">PRINT</a>
                                                <div ng-hide="true" id="joblisting-printTemplate" ng-include="joblistingPrintTemplate"></div>
                                            </div>
                                            <div class="col-md-4 padding-r-zero job-listing-btn-watchlist">
                                                <a  data-toggle="modal" data-target="#share_@{{joblisting.object_id}}" href="" class="job-listing-question-button width-100  btn-save-to-watchlist">SHARE</a>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                                </div><!-- eof job_listed_con -->
                                <div class="clearfix"></div>
                        </div><!-- eof row -->
                        <div class="row">
                            <div class="col-md-12">

                                <div class="job-listing-left-content-holder">
                                  <h3 class="pvm-blue">WE ARE LOOKING FOR</h3>
                                  <div ng-bind-html="joblisting.job_description"></div>
                                  <br>
                                  <div ng-show="showVideoTop">
                                    <video id="vid1" class="azuremediaplayer amp-default-skin" height="300">
                                      <p class="amp-no-js">To view this video please enable JavaScript, and consider upgrading to a web browser that supports HTML5 video</p>
                                    </video>
                                  </div>
                                  <div ng-show="showVideoLoding">
                                    <video poster="{$ThemeDir}/images/video_preload.gif"></video>
                                  </div>
                                </div>

                                <div class="job-listing-left-content-holder border-top" ng-if="joblisting.accountabilities.length">
                                  <div class="col-md-5 padding-l-zero">
                                    <h4>On a normal day you'll get to...</h4>
                                  </div>
                                  <div class="col-md-7 padding-l-zero">
                                    <ul class="listme">
                                      <li ng-repeat=" accountability in joblisting.accountabilities">@{{accountability.name}}</li>
                                    </ul>
                                  </div>
                                  <div class=clearfix></div>
                                </div>

                                <div class="job-listing-left-content-holder border-top" ng-if="joblisting.requirements.length">
                                  <div class="col-md-5 padding-l-zero">
                                    <h4>We are looking for someone who/with...</h4>
                                  </div>
                                  <div class="col-md-7 padding-l-zero">
                                    <ul class="listme">
                                      <li ng-repeat=" requirement in joblisting.requirements">@{{requirement.name}}</li>
                                    </ul>
                                  </div>
                                  <div class=clearfix></div>
                                </div>

                                <div class="job-listing-left-content-holder border-top" ng-if="joblisting.objectives.length">
                                  <div class="col-md-5 padding-l-zero">
                                    <h4>You will want to work with us because...</h4>
                                  </div>
                                  <div class="col-md-7 padding-l-zero">
                                    <ul class="listme">
                                      <li ng-repeat="objective in joblisting.objectives">@{{objective.name}}</li>
                                    </ul>
                                  </div>
                                  <div class=clearfix></div>
                                </div>

                                <!-- Company Benefits BEGIN -->
                                <div class="job-listing-left-content-holder" ng-if="joblisting.benefits.length">
                                  <h3 class="pvm-blue">COMPANY BENEFITS</h3>
                                </div>
                                <div class="job-listing-left-content-holder border-top" ng-if="joblisting.benefits.length">
                                  <div class="col-md-5 padding-l-zero">
                                    <h4>Company benefits include..</h4>
                                  </div>
                                  <div class="col-md-7 padding-l-zero">
                                    <ul class="listme">
                                      <li ng-repeat=" benefits in joblisting.benefits">@{{benefits.name}}</li>
                                    </ul>
                                  </div>
                                  <div class=clearfix></div>
                                </div>
                                <!-- Company Benefits END -->
                            </div>
                        </div><!-- eof row -->
                    </div>
                    <div class="col-md-5"></div>
                </div><!-- eof row -->
            </div><!-- eof container -->

            <div class="container-fluid" id="job-listing-about-employer-con">
              <div class="job-listing-container3 container">

                <h4>About @{{joblisting.company.company_name}}</h4>

                <div class="job-listing-row1">
                  <div class="pull-left " id="logo-con">
                    <a href="{$BaseHref}company/@{{joblisting.company.company_url}}">
                        <!-- <img ng-if="!joblisting.company.logo_url" ng-src="{$ThemeDir}/images/default_company_logo.png" width="70px" class="img-circle" /> -->
                      <span ng-if="!joblisting.company.logo_url" class="member-initials member-initials--lg @{{joblisting.company.profile_color}}">@{{joblisting.company.initial}}</span>
                        <img ng-if="joblisting.company.logo_url" ng-src="@{{joblisting.company.logo_url}}" width="70px" class="img-circle" />
                    </a>
                  </div>
                  <div class="pull-left about-employer-con" id="detail-con">
                    <h5 class="pvm-blue">
                      <a href="{$BaseHref}company/@{{joblisting.company.company_url}}">
                        @{{joblisting.company.company_name}}
                      </a>
                    </h5>
                    <p class="">
                      @{{joblisting.company.industry.data.industry.display_name}} | @{{joblisting.company.street_address}}
                      <span ng-if="joblisting.company.street_address && joblisting.company.street_address_2">,</span> @{{joblisting.company.street_address_2}}
                    </p>
                    <br>
                    <div class="col-md-12 padding-l-zero" id="size-website-con">
                      <div class="col-xs-2 padding-l-zero">Size:</div>
                      <div class="col-xs-10">@{{joblisting.company.num_of_employees}} Employees</div>
                      <div class="col-xs-2 padding-l-zero">Website:</div>
                      <div class="col-xs-10">
                        <a href="http://@{{company_website}}" target="_blank" style="color:#959595">@{{company_website}}</a>
                      </div>
                    </div>
                    <br><br><br>
                    <p ng-bind-html="joblisting.company.company_description | newlines"></p>
                  </div>
                  <div class="pull-left" id="video-con">
                    <div ng-show="showVideo">
                      <video id="vid2" class="azuremediaplayer amp-default-skin">
                        <p class="amp-no-js">
                            To view this video please enable JavaScript, and consider upgrading to a web browser that supports HTML5 video
                        </p>
                      </video>
                    </div>
                    <div ng-show="showVideoLoding">
                      <video poster="{$ThemeDir}/images/video_preload.gif" style="width:276px;padding-bottom:10px"></video>
                    </div>
                    <br><br>
                    <a href="#" class="job-listing-question-button width-100 btn-follow-us" ng-click=follow(joblisting.company.id)>@{{followedText}} (@{{joblisting.company_extra_data.followers}} followers)</a>
                    <a href="{$BaseHref}company/@{{joblisting.company.company_url}}" class="job-listing-question-button width-100 btn-see-profile"><i class="glyphicon glyphicon-eye-open"></i> See our full profile</a>
                  </div>
                  <div class="clearfix"></div>
                </div>
                <div class="job-listing-row2">
                  <div class="more_listing_holder">
                    <h4 class="pull-left">More Listing from @{{joblisting.company.company_name}}</h4>
                    <h5 class="pull-right"><a href="{$BaseHref}job/search#?company_name=@{{joblisting.company.company_name}}" class="pvm-white no-change-color no-visited">See all jobs listed by @{{joblisting.company.company_name}}</a></h5>
                  </div>
                  <div class="clearfix"></div>
                  <div class="row">
                    <div class="col-md-4 " ng-repeat="job in joblisting.company_extra_data.active_jobs.results.jobs">
                      <div class="col-md-12 more-listing pvm-black" style="height:339px;overflow:hidden">
                        <h3 class="pvm-blue" style="height:27px;overflow:hidden">
                          <a href="{$BaseHref}job/listing/@{{job.object_id}}" ng-bind-html="job.job_title_limit"></a>
                        </h3>
                          <p class="pvm-black" ng-bind-html="job.company_name_limit"></p>
                        <hr>
                          <p ng-bind-html="job.limit_description" style="height:100px;overflow:hidden;"></p>
                        <br>
                        <div class="col-md-6 pvm-gray padding-l-zero padding-r-zero" style="font-size:0.8em">
                          <div> @{{job.location.display_name}}
                          </div>
                          @{{job.display_date}}
                        </div>
                        <div class="col-md-6">
                          <a href="{$BaseHref}company/@{{joblisting.company.company_url}}">
                            <img ng-if="job.company_logo_url" ng-src="@{{job.company_logo_url}}" width="30px" class="pull-left img-circle" />
                            <img ng-if="!job.company_logo_url" ng-src="http://<?php echo $_SERVER['SERVER_NAME']; ?>/images/default_company_logo.png" width="30px" class="pull-left" />
                            <p style="width:75%;padding-left:5px;text-align:center;" class="pull-left">
                                <small style="text-transform:uppercase;" class="pvm-black" ng-bind-html="job.company_name_limit"></small>
                            </p>
                          </a>
                        </div>
                        <div class="clearfix"></div>
                      </div>
                    </div>
                  </div><!-- eof row -->
                    
                  <div class="clearfix"></div>
                    
                </div><!-- eof job-listing-row2 -->
              </div><!-- eof job-listing-container3 -->
            </div><!-- eof job-listing-about-employer-con -->

          </div><!-- eof row -->
        </div>
    </div>

    <div id="share_@{{joblisting.object_id}}" class="modal-me modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
        <div class="modal-dialog modal-sm shareMod" role="document">
            <div class="modal-content">
                <div class="container-fluid">
                    <div class="text-center shareContainer">
                        <h4>Where do you want to share <br> @{{joblisting.job_title}} ( @{{joblisting.object_id}} ) </h4>
                        <a href="javascript:void(0)" socialshare name="twitter" share-count socialshare-provider="twitter" socialshare-text="@{{joblisting.job_title}} @ @{{joblisting.company.company_name}}" socialshare-url="{$BaseHref}job/listing/@{{joblisting.object_id}}" class="fa fa-twitter-square"></a>
                        <a href="javascript:void(0)" socialshare="" name="facebook" share-count socialshare-provider="facebook" socialshare-url="{$BaseHref}job/listing/@{{joblisting.object_id}}" class="fa fa-facebook-square"></a>
                        <a href="javascript:void(0)" socialshare name="linkedin" share-count socialshare-provider="linkedin" socialshare-text="@{{joblisting.job_title}} @ @{{joblisting.company.company_name}}" socialshare-url="{$BaseHref}job/listing/@{{joblisting.object_id}}" class="fa fa-linkedin-square"></a>
                        <a href="javascript:void(0)" socialshare name="email" share-count socialshare-provider="email" socialshare-text="@{{joblisting.job_title}} @ @{{joblisting.company.company_name}}" socialshare-url="{$BaseHref}job/listing/@{{joblisting.object_id}}" class="fa fa-envelope-square"> </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

	<!-- modal -->
    <div id="joblistingEmailModal" class="modal fade" role="dialog">
        <div class="modal-dialog" >
            <div class="modal-content modal-email-joblisting-modal">
                <div class="x-buttom-container">
                    <span  class="close x-button" data-dismiss="modal"></span>
                </div>
                <div class="modal-body col-md-12 col-sm-12 col-xs-12">
                    <form ng-submit="joblistSendEmail()">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Your name</label>
                                <input type="text" class="form-control no-curved-border" ng-model="sender_name" required id="exampleInputEmail1" placeholder="Your name">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Your email</label>
                                <input type="email" class="form-control no-curved-border" ng-model="sender_email" required id="exampleInputEmail1" placeholder="Your email">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Your friend's name</label>
                                <input type="text" class="form-control no-curved-border" ng-model="receiver_name" required id="exampleInputEmail1" placeholder="Your friend's name">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Your friend's email</label>
                                <input type="email" class="form-control no-curved-border" ng-model="receiver_email" required id="exampleInputEmail1" placeholder="Your friend's email">
                            </div>
                            <div class="form-group" style="text-align:left">
                                <button type="submit" class="btn btn-default no-curved-border pvm-blue-background pvm-white">Send</button>
                                <small style="margin-left:10px" for="exampleInputEmail1">We care about <span class="pvm-blue">privacy</span> and will never give your details out</small>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
</div>

@stop

@section('scripts')
<script type="text/javascript" src="js/minified/login/job-listing.min.js"></script>
<script type="text/javascript" src="js/minified/login/login.min.js"></script>
@stop