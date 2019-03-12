@extends('layouts.home')

@section('content')

<?php 
$baseUrl = "http://previewme.co/";
?>

<div ng-controller="CompanyController" id="PublicCompany" ng-cloak>
  <div class="text-center splash " ng-show="!company">
    <div class="cssload-container">
      <h3>Please wait.sss</h3>
      <h4>While we prepare this page for you.</h4>
      <div class="cssload-loading"><i></i><i></i><i></i><i></i></div>
    </div>
  </div>

  <div ng-show="company" class="container-fluid">
    <div class="row">
      <div ng-if="company.company_banner_url" class="company_banner" style="background-image: url('@{{company.company_banner_url}}');"></div>
      <div ng-if="!company.company_banner_url" class="company_banner" style="background-image: url('{$ThemeDir}/images/Default-Header.png');"></div>
    	<input type="hidden" id="slug-id" value="{$Slug}" />
    </div>

  	<div class="row"><!-- id="job-listing-top-con"  -->
  		<div class="company_logo container">
    		<div  class="col-md-2" >
    			<!-- <img ng-if="!company.logo_url" src="{$ThemeDir}/images/default_company_logo.png" height="150px" width="150px" class="img-circle" /> -->
          <div ng-if="company.logo_url == false" class="member-initials member-initials--lg @{{company.profile_color}}">@{{company.initial}}</div>
    			<img ng-if="company.logo_url" ng-src="@{{company.logo_url}}" height="150px" width="150px" class="img-circle" />
          <a ng-if="edit_company_profile" href="/company/edit/@{{company.id}}" class="pvm-green emp_profile_link " style="display:block" >Edit Company Profile</a>
    		</div>

    		<div id=" " class="col-md-10">
          <div class="row">
      			<div class="col-md-8 company_listing_top1">
      				<h3 class="pvm-blue">@{{company.company_name}}</h3>
      				<span class="position" style="font-weight:bold">
      					@{{company.industry.display_name}}
      				</span>
              <span class="position" ng-if="company.helper_text"  style="font-weight:bold">
                | @{{company.helper_text}}
              </span>
      				<div class="clearfix"></div>
      				<div class="company_top_labels">
      					<div class="col-md-6 details_title details_titles_con">
      						<span ng-if="company.num_of_employees" class="col-md-3 details_title">Size:</span>
      						<span ng-if="company.num_of_employees" class="col-md-9 ">@{{company.num_of_employees}} @{{company.num_of_employees_text}}</span>
      						<div ng-if="company.num_of_employees" class="clearfix"></div>
      						<span ng-if="company.founded" class="col-md-3 details_title">Founded:</span>
      						<span ng-if="company.founded" class="col-md-9"></span>
      						<div ng-if="company.founded" class="clearfix"></div>
      						<span ng-if="company.website_url" class="col-md-3 details_title">Website:</span>
      						<span ng-if="company.website_url" class="col-md-9"><a href="http://@{{company.website_url}}" class="pvm-gray" target="_blank">@{{company.website_url}}</a></span>
      						<div ng-if="company.website_url" class="clearfix"></div>
      						<span ng-if="company.company_phone" class="col-md-3 details_title">Phone:</span>
      						<span ng-if="company.company_phone" class="col-md-9">@{{company.company_phone}}</span>
      					</div>
      					<div class="col-md-6 details_titles_con">
      						<span ng-if="company.street_address" class="col-md-4 details_title details_title_r">Head Office:</span>
      						<span ng-if="company.street_address" class="col-md-8 no-padding-r">
        						<div>@{{company.street_address || ''}}</div>
                    <div>@{{company.location.display_name || ''}}</div>
        						<div>@{{company.location.country.display_name || ''}}</div>
      						</span>
      						<div class="clearfix"></div>
      					</div>
      				</div>
      			</div>

      			<div class="col-md-4 company_listing_top2">
      				<div id="com-follow-con" class="pull-right">
        				<div id="com-follow" class="pvm-blue">
        				  @{{followers}} @{{ $scope.follower_text}}
        				</div>
        				<a id="com-follow-btn" style="opacity:1;border-radius:0" class="btn pvm-blue-background pvm-white" ng-disabled="follow_link" ng-click="follow(company.id)">@{{followedText}}</a>
      				</div>
              <div class="clearfix"></div>
      			</div>
          </div>
    		</div>
  		</div>
  		<div class="clearfix"></div>
  	</div>

  	<div class="row" id="job-listing-content-con">
  		<div class="container">
  			<div  class="col-md-4">
  				<div class="job-listing-left-content-holder">
  					<div ng-show="showVideo">
  						<video id="vid1" class="azuremediaplayer amp-default-skin">
  					    <p class="amp-no-js">
  					        To view this video please enable JavaScript, and consider upgrading to a web browser that supports HTML5 video
  					    </p>
  						</video>
  					</div>
            <div ng-show="showVideoLoading">
              <img src="{$ThemeDir}/images/video_preload.gif" style="width:276px;padding-bottom:10px">
            </div>
  					<h4 class="pvm-blue">ABOUT US</h4>
            <div class="tse-scrollable company-about-us" ng-hide="!company.company_description" >
              <div class="pvm-gray tse-content description_content" ng-bind-html="company.company_description | newlines"></div>
            </div>
            <div ng-show="!company.company_description">No description provided.</div>
  				</div>
          <div >
            <h4 ng-if="company.company_branch_locations.length > 0">Offices</h4>
            <div class="tse-scrollable offices_wrapper">
              <ul ng-show="company.company_branch_locations.length > 0" class="tse-content">
                <li ng-repeat="location in company.company_branch_locations">
                  <i class="LocationIcoCompany"></i>
                  <span>@{{location.address}}</span>
                  <span>@{{location.phone_number}}</span>
                  <div class="clearfix"></div>
                </li>
              </ul>
            </div>
          </div>
  			</div>
  			<div class="col-md-8 com-right-container">
  				<div class="company-listing-right-content-holder" ng-if="extra_data.jobs.length > 0">
						<div class="col-md-12">
              <a href="/job-search#?company_name=@{{company.company_name}}" id="search_jobs" class="pull-right text-center">Search All @{{company.company_name}} Jobs &raquo;</a>
						</div>
  				</div>
  				<br><br>

  				<div class="con_right_content_holder" id="company_content">
  					<div class="row jobList" ng-if="extra_data.jobs.length > 0" ng-repeat="job in extra_data.jobs">
  						<div class="col-md-2">
                <a data-ajax="false" href="/job/listing/job-listing-sample">
                  <img ng-show="(job.company.logo_url != empty)" ng-src="@{{job.company.logo_url}}" class="img-circle img-responsive" width="120">
                  <div ng-show="(job.company.logo_url === empty)" class="member-initial member-initials--tms @{{job.profile_color}}">@{{job.initial}}</div>
                </a>
              </div>
              <div class="col-md-10">
                <div class="row">
                  <div class="col-md-9">
                    <a data-ajax="false" href="/job/listing/@{{job.object_id}}">
                      <small class="jobName">@{{job.job_title}}</small>
                    </a>
                    <div class="jobShortDescription" ng-bind-html="job.job_description | cut:true:300:'...'"></div>

                    <div class="clearfix"></div>
                    <div class="row jobsmaldeatils">
                      <div class="col-md-12">
                        <div class="pull-left jobSubDetails">
                          <i class="job-search-icons job-search-address-icon pull-left"></i>
                          <span class="pull-left search-content"> @{{job.company.company_name}} </span>
                        </div>
                        <div class="pull-left jobSubDetails">
                          <i class="job-search-icons job-search-marker-icon pull-left"> </i>
                          <span class="pull-left search-content search-content2">
                            @{{job.location.display_name}}<!-- <span ng-if="job.location.city_name">,</span> @{{job.location.suburb_name}} -->
                          </span>
                        </div>
                        <div class="pull-left jobSubDetails">
                          <i class="job-search-icons job-search-calendar-icon pull-left"></i>
                          <span class="pull-left search-content">
                            @{{job.published_date | date: 'EEE d MMM'}}
                          </span>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-3 buttonCont">
                 	  <div ng-repeat="seenjobs in seenJobs.jobs | filter: {object_id: job.object_id}:true "></div>
                    <div class="watchlistbutton jobbtn  " ng-click="seen($event, job.object_id)"    data-obj-id="@{{job.object_id}}" ng-class="{'pvm-blue' : job.seen }"  >
                      <i class="eye-caret glyphicon glyphicon-eye-open" ></i>
                      Watchlist
                    </div>
                    <div class="shareJobbutton jobbtn" data-toggle="modal" data-target="#share_@{{job.object_id}}">
                      <i class="ShareIco glyphicon "></i>
                      Share Job
                    </div>
                    <div id="share_@{{job.object_id}}" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
                      <div class="modal-dialog modal-sm shareMod" role="document">
                        <div class="modal-content">
                          <div class="container-fluid">
                            <div class="text-center shareContainer">
                              <h4>Where do you want to share <br> @{{job.job_title}} ( @{{job.object_id}} ) </h4>
                              <a href="javascript:void(0)" socialshare socialshare-provider="twitter" socialshare-text="@{{job.job_title}} @ @{{job.company_name}}" socialshare-url="{$BaseHref}job/listing/@{{job.object_id}}" class="fa fa-twitter-square"></a>
                              <a href="javascript:void(0)" socialshare="" socialshare-provider="facebook" socialshare-url="{$BaseHref}job/listing/@{{job.object_id}}" class="fa fa-facebook-square"></a>
                              <a href="javascript:void(0)" socialshare socialshare-provider="linkedin" socialshare-text="@{{job.job_title}} @ @{{job.company_name}}" socialshare-url="{$BaseHref}job/listing/@{{job.object_id}}" class="fa fa-linkedin-square"></a>
                              <a href="javascript:void(0)" socialshare socialshare-provider="email" socialshare-text="@{{job.job_title}} @ @{{job.company_name}}" socialshare-url="{$BaseHref}job/listing/@{{job.object_id}}" class="fa fa-envelope-square"></a>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="showJobbutton jobbtn" data-obj-id="@{{job.object_id}}" ng-click="showDetail( $event, job.object_id)" >
                      <i class="eye-caret glyphicon glyphicon-menu-down job@{{job.object_id}}" ></i>
                      View Job
                    </div>
                  </div>
                </div>
              </div>
              <div class="content-column partjob@{{job.object_id}} hide partjob"> <!-- Uncomment for dynamic data from API -->
                <!-- <div class="content-column partjobJCXLSZK57 hide partjob"> -->
                <div ng-include="jobSearchTemplate"></div>
                <div class="clearfix"></div>
                <div class="">
                  <div class="showJobbutton jobbtn"   >
                    <!-- <a data-ajax="false" href="{$BaseHref}job/listing/@{{job.object_id}}"> --> <!-- Uncomment for dynamic data from an API -->
                    <a data-ajax="false" href="/job/listing/@{{job.object_id}}" target=_BLANK>
                      <i class="glyphicon glyphicon-open"></i>
                      View Full Job
                    </a>
                  </div>
                </div>
              </div>
              <div class="clearfix"></div>
              <div class="col-md-12">
                <hr class="jobDivider">
              </div>
  					</div>
            <div class="row jobList" ng-if="extra_data.jobs.length === 0" ng-class="{'text-center' : extra_data.jobs.length === 0 }">
              <div  id="no_jobs_data">
                <img ng-if="!company.logo_url" src="{$ThemeDir}/images/default_company_logo.png" height="150px" width="150px" class="img-circle" />
                <img ng-if="company.logo_url" ng-src="@{{company.logo_url}}" height="150px" width="150px" class="img-circle" />
                <p>There are no positions available currently</p>
              </div>
            </div>
  				</div>

  			</div>
  		</div>
  	</div>
  </div>
</div>
@stop

@section('scripts')
<script type="text/javascript" src="js/minified/public/company.min.js"></script>
@stop