@extends('layouts.home')

@section('styles')
@stop

@section('content')

<div class="container-fluid roles-page"  ng-cloak id="my_job_application_page">
	<div class="row">
	  <div class="col-md-3">
	  	<div class="row">
			@include('employer.employer_sidebar')
			</div>
		</div>
		<div class=" col-md-9 " ng-controller="EmployerCompanyRoles" id="EmployerCompanyRolesPage">
      <section class="roles-container">
        <ul class="nav nav-tabs roles__type-list" id="jobs_tab">
          <li class="roles__type-item pvm-tooltip-one" ng-class="{'active' : roleURLactive}" id="active_tab" ng-click="lazyJobActive(5)" titles="On-going roles"> <!-- Replace the argument on the lazyJobActive function with the company_id of the logged user -->
            <a href="#active" class="" data-toggle="tab" ng-click="jobContent('applied')" >
              ACTIVE ROLES <span>(@{{activeCount}})</span>
            </a>
          </li>
          <li class="roles__type-item" ng-class="{'active' : roleURLdraft}" id="draft_tab" ng-click="lazyJobDraft(5)"> <!-- Replace the argument on the lazyJobActive function with the company_id of the logged user -->
            <a href="#draft" data-toggle="tab">DRAFTS <span>(@{{draftCount}})</span></a>
          </li>
          <li class="roles__type-item pvm-tooltip-one" ng-class="{'active' : roleURLexpired}" id="expired_tab" ng-click="lazyJobExp(5)" titles="Roles that are no longer active"> <!-- variable for lazyJobExp() must be the company id -->
            <a href="#expired" data-toggle="tab">CLOSED ROLES <span>(@{{expiredCount}})</span></a>
          </li>
        </ul>
        <div class="roles-list-container tse-scrollable">
          <div class="tse-content">
            <section class="role-splasher" ng-show="preload">
              <h3>Please wait.</h3>
              <h4>While we prepare this page for you.</h4>
              <div class="cssload-loading"><i></i><i></i><i></i><i></i></div>
            </section>
            <div id="active" class="roles-pane tab-pane " ng-class="{'active' : roleURLactive}">
              <ul class="roles__list roles__list--active">
                <li ng-show="jobApplicationActive" ng-if="jobApplicationActiveJobDetails.length > 0"  class="roles__item" ng-repeat="job in jobApplicationActiveJobDetails | orderBy : sortExpiredDate : true">
                  <section class="role__head">
                    <a href="/job/listing/@{{job.object_id}}" class="role__title" title="View @{{job.job_title}}">@{{job.job_title}}</a>
                    <div class="role__action-container">
                      <a href="/employer/job/add/employee#?id=@{{job.id}}&edit=1" class="" title="Edit Role">
                        <i class="fa fa-pencil"></i>
                      </a>
                      <a href="/employer/manage-talent?id=@{{job.id}}" title="Manage Role">
                        <i class="fa fa-suitcase"></i>
                      </a>
                      <i class="fa fa-close" ng-click="CloseDrop(job.id)" title="Close Role"></i>
                      <ul class="role__close-msg-list hide" id="close_role_@{{job.id}}">
                        <li class="role__close-msg-item">
                          <a href="" confirmed-click="deleteRole('Role filled', job.id, job.object_id)" ng-confirm-click="You are about to close this role. All candidates who are not in the hired bucket will be moved to 'Not Successful' bucket. You can still review the last state of your recruits by going to CLOSED ROLES > View Archive TMS. &#13;&#13; Are you sure you want to close this role?" class="role__close-confirm-link">Role Filled</a>
                        </li>
                        <li class="role__close-msg-item">
                          <a href="" confirmed-click="deleteRole('Role filled elsewhere', job.id, job.object_id)" ng-confirm-click="You are about to close this role. All candidates who are not in the hired bucket will be moved to 'Not Successful' bucket. You can still review the last state of your recruits by going to CLOSED ROLES > View Archive TMS. &#13;&#13; Are you sure you want to close this role?" class="role__close-confirm-link">Role Filled elsewhere</a>
                        </li>
                        <li class="role__close-msg-item">
                          <a href="" confirmed-click="deleteRole('Withdrawn', job.id, job.object_id)" ng-confirm-click="You are about to close this role. All candidates who are not in the hired bucket will be moved to 'Not Successful' bucket. You can still review the last state of your recruits by going to CLOSED ROLES > View Archive TMS. &#13;&#13; Are you sure you want to close this role?" class="role__close-confirm-link">Withdrawn</a>
                        </li>
                      </ul>
                    </div>
                  </section>
                  <section class="role__details-container clear-float">
                    <div class="role__details">
                      <div class="role__details-div">
                        <h4 class="role__det-label">Creator</h4>
                        <p class="role__det-value">@{{job.creator}}</p>
                      </div>
                      <div class="role__details-div">
                        <h4 class="role__det-label">Role Manager</h4>
                        <p class="role__det-value">@{{job.manager}}
                          <span class="role__det-value" ng-if="!job.manager">No manager assigned.</span>
                        </p>
                      </div>
                      <div class="role__details-div">
                        <h4 class="role__det-label">Location</h4>
                        <p class="role__det-value">@{{job.location}}</p>
                      </div>
                      <div class="role__details-div">
                        <h4 class="role__det-label">Published</h4>
                        <p class="role__det-value">@{{job.date_created | date: 'EEE, d MMM yyyy'}}</p>
                      </div>
                      <div class="role__details-div">
                        <h4 class="role__det-label">Expiration</h4>
                        <p class="role__det-value">
                          @{{job.expiry_date | date: 'EEE, d MMM yyyy'}}
                          <span class="role__remaining-days" ng-if="job.expiry_days_left > 0" ng-class="{'role__remaining-days--near' : job.expiry_days_left <= 5 && job.expiry_days_left > 0}">@{{job.expiry_days_left}} day<span ng-if="job.expiry_days_left > 1">s</span> left</span>
                          <span class="role__remaining-days" ng-if="job.expiry_days_left == 0" ng-class="{'role__remaining-days--none' : job.expiry_days_left == 0}">expired</span>
                        </p>
                      </div>
                      <div class="role__details-div">
                        <h4 class="role__det-label">Will Automatically close on</h4>
                        <p class="role__det-value">
                          <span ng-if="!job.closing_date || !job.auto_close">Not applicable.</span>
                          <span ng-if="job.closing_date && job.auto_close">
                            @{{job.closing_date | date: 'EEE, d MMM yyyy'}}
                            <span class="role__remaining-days"> @{{job.closing_days_left}} day
                              <span ng-if="job.closing_days_left > 1">s</span> left
                            </span>
                          </span>
                        </p>
                      </div>

                      <div class="role__details-div">
                        <h4 class="role__det-label">Other members managing this role:</h4>
                        <div class="role__det-value">
                          <ul class="role__team-members-list">
                            <li ng-repeat="member in jobApplicationActiveOtherTeamMembers" class="role__team-members-item">
                              <img ng-src="@{{member.profile_picture_url}}" ng-class="{'hide': member.profile_picture_url == null || member.profile_picture_url == ''}" class="img-circle member-initials--nav" on-error-src="{$ThemeDir}/images/defaultPhoto.png" title="@{{member.first_name}} @{{member.last_name}}">
                              <div ng-if="member.profile_picture_url == null || member.profile_picture_url == ''" class="member-initials member-initials--nav @{{member.profile_color}}" title="@{{member.first_name}} @{{member.last_name}}">@{{member.initial}}</div>
                            </li>
                          </ul>
                        </div>
                      </div>
                      <div class="role__details-div role__details-div--team">
                        <h4 class="role__det-label">Team/s managing this role:</h4>
                        <div class="role__det-value role__det-value--flex">
                          <ul class="role__team-members-list clear-float" ng-repeat="team in jobApplicationActiveOtherTeams" ng-if="jobApplicationActiveOtherTeams.length > 0">
                            <span class="role__team-name">@{{team.team_name}}</span>
                            <li ng-repeat="member in jobApplicationActiveOtherTeamMembers" class="role__team-members-item">
                              <img ng-src="@{{member.profile_picture_url}}" ng-class="{'hide': member.profile_picture_url == null || member.profile_picture_url == ''}" class="img-circle member-initials--nav"
                                   title="@{{member.first_name}} @{{member.last_name}}">
                              <span ng-if="!member.profile_picture_url" class="member-initials member-initials--nav @{{member.profile_color}}" title="@{{member.first_name}} @{{member.last_name}}">@{{member.initial}}</span>
                            </li>
                          </ul>
                          <p ng-if="jobApplicationActiveOtherTeams == 0">No team available.</p>
                        </div>
                      </div>
                    </div>
                    <div class="role__numbers">
                      <div class="role__details-div">
                        <h4 class="role__det-label">Total Applicants</h4>
                        <p class="role__det-numbers">@{{job.total_applicants}}</p>
                      </div>
                      <div class="role__details-div">
                        <h4 class="role__det-label">Did not pass pre-application questions</h4>
                        <p class="role__det-numbers">@{{job.failed_pre_approval}}</p>
                      </div>
                    </div>
                  </section>
                </li>
                <li ng-if="jobApplicationActive.count <= 0">
                  <p class="">You don't have any active roles in your list.</p>
                </li>
              </ul>
            </div>
            <div id="draft" class="roles-pane tab-pane " ng-class="{'active' : roleURLdraft}">
              <ul class="roles__list roles__list--draft">
                <li ng-show="jobApplicationDraft" ng-if="jobApplicationDraftJobDetails.length > 0"  class="roles__item" ng-repeat="job in jobApplicationDraftJobDetails | orderBy : sortExpiredDate : true"> 
                  <section class="role__head">
                    <a href="/job/listing/@{{job.object_id}}" class="role__title" title="View @{{job.job_title}}">@{{job.job_title}}</a>
                    <div class="role__action-container">
                      <a href="/employer/job/add/employee?id=@{{job.id}}&draft=1" class="" title="Continue">
                        <i class="fa fa-pencil"></i>
                      </a>
                      <a class="" confirmed-click="deleteJob(job.id)" ng-confirm-click="Are you sure you want to remove this role?" title="Delete draft role">
                        <i class="fa fa-trash"></i>
                      </a>
                    </div>
                  </section>
                  <section class="role__details-container clear-float">
                    <div class="role__details">
                      <div class="role__details-div">
                        <h4 class="role__det-label">Creator</h4>
                        <p class="role__det-value">@{{job.creator}}</p>
                      </div>
                      <div class="role__details-div">
                        <h4 class="role__det-label">Role Manager</h4>
                        <p class="role__det-value">@{{job.manager}}
                          <span class="role__det-value" ng-if="!job.manager">No manager assigned.</span>
                        </p>
                      </div>
                      <div class="role__details-div">
                        <h4 class="role__det-label">Location</h4>
                        <p class="role__det-value">@{{job.location}}</p>
                      </div>
                      <div class="role__details-div">
                        <h4 class="role__det-label">Created</h4>
                        <p class="role__det-value">@{{job.date_created | date: 'EEE, d MMM yyyy'}}</p>
                      </div>
                      <!--
                      <div class="role__details-div">
                        <h4 class="role__det-label">Expiration</h4>
                        <p class="role__det-value" ng-if="job.expiry_date">
                          @{{job.expiry_date}}
                          <span class="role__remaining-days" ng-if="job.expiry_days_left > 0" ng-class="{'role__remaining-days--near' : job.expiry_days_left <= 5 && job.expiry_days_left > 0}">@{{job.expiry_days_left}} day<span ng-if="job.expiry_days_left > 1">s</span> left</span>
                          <span class="role__remaining-days" ng-if="job.expiry_days_left == 0" ng-class="{'role__remaining-days--none' : job.expiry_days_left == 0}">expired</span>
                        </p>
                        <p class="role__det-value" ng-if="!job.expiry_date">Role is not published yet.</p>
                      </div>
                      <div class="role__details-div">
                        <h4 class="role__det-label">Will Automatically close on</h4>
                        <p class="role__det-value">
                          @{{job.closing_date}}
                          <span ng-if="!job.closing_date">Not applicable.</span>
                          <span ng-if="job.closing_date" class="role__remaining-days">@{{job.closing_days_left}} day<span ng-if="job.closing_days_left > 1">s</span> left</span>
                        </p>
                      </div> -->

                      <div class="role__details-div">
                        <h4 class="role__det-label">Other members managing this role:</h4>
                        <p class="role__det-value">
                        <ul class="role__team-members-list">
                          <li ng-repeat="member in jobApplicationDraftOtherTeamMembers" class="role__team-members-item">
                            <img ng-src="@{{member.profile_picture_url}}" ng-class="{'hide': member.profile_picture_url == null || member.profile_picture_url == ''}" class="img-circle member-initials--nav" on-error-src="{$ThemeDir}/images/defaultPhoto.png" title="@{{member.first_name}} @{{member.last_name}}">
                            <div ng-if="member.profile_picture_url == null || member.profile_picture_url == ''" class="member-initials member-initials--nav @{{member.profile_color}}" title="@{{member.first_name}} @{{member.last_name}}">@{{member.initial}}</div>
                          </li>
                        </ul>
                        </p>
                      </div>
                      <div class="role__details-div role__details-div--team">
                        <h4 class="role__det-label">Team/s managing this role:</h4>
                        <div class="role__det-value role__det-value--flex">
                          <ul class="role__team-members-list clear-float" ng-repeat="team in jobApplicationDraftOtherTeams" ng-if="jobApplicationDraftOtherTeams.length > 0">
                            <span class="role__team-name">@{{team.team_name}}</span>
                            <li ng-repeat="member in team.members" class="role__team-members-item">
                              <img ng-src="@{{member.profile_picture_url}}" ng-class="{'hide': member.profile_picture_url == null || member.profile_picture_url == ''}" class="img-circle member-initials--nav"
                                   title="@{{member.first_name}} @{{member.last_name}}">
                              <span ng-if="!member.profile_picture_url" class="member-initials member-initials--nav @{{member.profile_color}}" title="@{{member.first_name}} @{{member.last_name}}">@{{member.initial}}</span>
                            </li>
                          </ul>
                          <p ng-if="jobApplicationDraftOtherTeams.length == 0">No team available.</p>
                        </div>
                      </div>
                    </div>
                    <!-- <div class="role__numbers">
                      <div class="role__details-div">
                        <h4 class="role__det-label">Total Applicants</h4>
                        <p class="role__det-numbers">@{{job.total_applicants}}</p>
                      </div>
                      <div class="role__details-div">
                        <h4 class="role__det-label">Did not pass pre-approval questions</h4>
                        <p class="role__det-numbers">@{{job.failed_pre-approval}}</p>
                      </div>
                    </div> -->
                  </section>
                </li>
                <li ng-if="jobApplicationDraft.count <= 0">
                  <p class="">You don't have any draft roles in your list.</p>
                </li>
              </ul>
            </div>
            <div id="expired" class="roles-pane tab-pane " ng-class="{'active' : roleURLexp}">
              <ul class="roles__list roles__list--close">
                <li ng-show="jobApplicationExpired" ng-if="jobApplicationExpiredJobDetails.length > 0"  class="roles__item" ng-repeat="job in jobApplicationExpiredJobDetails | orderBy : sortExpiredDate : true">
                  <section class="role__head">
                    <a href="/job/listing/@{{job.object_id}}" class="role__title" title="View @{{job.job_title}}">@{{job.job_title}}</a>
                    <div class="role__action-container">
                      <a href="/employer/manage-talent?id=@{{job.id}}" title="View TMS Report">
                        <i class="fa fa-binoculars"></i>
                      </a>
                    </div>
                  </section>
                  <section class="role__details-container clear-float">
                    <div class="role__details">
                      <div class="role__details-div">
                        <h4 class="role__det-label">Creator</h4>
                        <p class="role__det-value">@{{job.creator}}</p>
                      </div>
                      <div class="role__details-div">
                        <h4 class="role__det-label">Role Manager</h4>
                        <p class="role__det-value">@{{job.manager}}
                          <span class="role__det-value" ng-if="!job.manager">No manager assigned.</span>
                        </p>
                      </div>
                      <div class="role__details-div">
                        <h4 class="role__det-label">Location</h4>
                        <p class="role__det-value">@{{job.location}}</p>
                      </div>
                      <div class="role__details-div">
                        <h4 class="role__det-label">Published</h4>
                        <p class="role__det-value">@{{job.date_created | date: 'EEE, d MMM yyyy'}}</p>
                      </div>
                      <div class="role__details-div" ng-switch="job.expiredNotice">
                        <h4 class="role__det-label">Expiration</h4>
                        <p class="role__det-value" ng-if="job.expiry_date" ng-switch-when="0">
                          @{{job.expiry_date | date: 'EEE, d MMM yyyy'}}
                          <span class="role__remaining-days" ng-if="job.expiry_days_left > 0" ng-class="{'role__remaining-days--near' : job.expiry_days_left <= 5 && job.expiry_days_left > 0}">@{{job.expiry_days_left}} day<span ng-if="job.expiry_days_left > 1">s</span> left</span>
                          <span class="role__remaining-days" ng-if="job.expiry_days_left == 0" ng-class="{'role__remaining-days--none' : job.expiry_days_left == 0}">expired</span>
                        </p>
                        <p class="role__det-value" ng-switch-when="1">
                          Role closed before the expiration date
                        </p>
                      </div>
                      <div class="role__details-div">
                        <h4 class="role__det-label">Closed</h4>
                        <p class="role__det-value">
                          <!-- <span ng-if="job.closing_date != null">@{{job.closed_date}}</span> -->
                          <span>@{{job.closed_date | date: 'EEE, d MMM yyyy'}}</span>
                          (@{{job.job_closing_reason}})
                          <span class="role__remaining-days" ng-if="job.closedNotice == 1" ng-class="{'role__remaining-days--none' : job.closedNotice == 1}">closed</span>
                        </p>
                      </div>

                       <div class="role__details-div">
                        <h4 class="role__det-label">Other members managing this role:</h4>
                        <div class="role__det-value">
                          <ul class="role__team-members-list">
                            <li ng-repeat="member in job.other_members" class="role__team-members-item">
                              <img ng-src="@{{member.profile_picture_url}}" ng-class="{'hide': member.profile_picture_url == null || member.profile_picture_url == ''}" class="img-circle member-initials--nav" on-error-src="{$ThemeDir}/images/defaultPhoto.png" title="@{{member.first_name}} @{{member.last_name}}">
                              <div ng-if="member.profile_picture_url == null || member.profile_picture_url == ''" class="member-initials member-initials--nav @{{member.profile_color}}" title="@{{member.first_name}} @{{member.last_name}}">@{{member.initial}}</div>
                            </li>
                          </ul>
                        </div>
                      </div>
                      <!--
                      <div class="role__details-div">
                        <h4 class="role__det-label">Other members managing this role:</h4>
                        <p class="role__det-value">
                          <img class="img-circle role__applicant-img" height="35" ng-show="applicant.candidate.docs.profile_image != false" ng-src="https://previewmedev.blob.core.windows.net/qe07arh9/1498178665_OG25HJ0.jpg" width="35" src="https://previewmedev.blob.core.windows.net/qe07arh9/1498178665_OG25HJ0.jpg">
                        </p>
                      </div> -->

                      <div class="role__details-div role__details-div--team">
                        <h4 class="role__det-label">Team/s managing this role:</h4>
                        <div class="role__det-value role__det-value--flex">
                          <ul class="role__team-members-list clear-float" ng-repeat="team in jobApplicationExpiredOtherTeams" ng-if="jobApplicationExpiredOtherTeams.length > 0">
                            <span class="role__team-name">@{{team.team_name}}</span>
                            <li ng-repeat="member in jobApplicationExpiredOtherTeamMembers" class="role__team-members-item">
                              <img ng-src="@{{member.profile_picture_url}}" ng-class="{'hide': member.profile_picture_url == null || member.profile_picture_url == ''}" class="img-circle member-initials--nav"
                                   title="@{{member.first_name}} @{{member.last_name}}">
                              <span ng-if="!member.profile_picture_url" class="member-initials member-initials--nav @{{member.profile_color}}" title="@{{member.first_name}} @{{member.last_name}}">@{{member.initial}}</span>
                            </li>
                          </ul>
                          <p ng-if="jobApplicationExpiredOtherTeams.length == 0">No team available.</p>
                        </div>
                      </div>
                    </div>
                    <div class="role__numbers">
                      <div class="role__details-div">
                        <h4 class="role__det-label">Total Applicants</h4>
                        <p class="role__det-numbers">@{{job.total_applicants}}</p>
                      </div>
                      <div class="role__details-div">
                        <h4 class="role__det-label">Did not pass pre-approval questions</h4>
                        <p class="role__det-numbers">@{{job.failed_pre-approval}}</p>
                      </div>
                    </div>
                  </section>
                </li>
                <li ng-if="jobApplicationExpired.count <= 0">
                  <p class="">You don't have any closed roles in your list.</p>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </section>
			<div class="section_container">

			</div>

		</div>
	</div>
</div>

@stop

@section('scripts')
<script type="text/javascript" src="js/minified/login/login.min.js"></script>
<script type="text/javascript" src="js/minified/employers/sidebar.min.js"></script>
<script type="text/javascript" src="js/minified/employers/company.roles.min.js"></script>
@stop
