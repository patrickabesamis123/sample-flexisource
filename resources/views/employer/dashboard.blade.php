@extends('layouts.home')

@section('styles')
@stop

@section('content')
<div class="container-fluid dashmain dashboard-employer"  ng-cloak>
<div class="row">
  <div class="col-md-3">
    <div class="row">
			@include('employer.employer_sidebar') 
		</div>
	</div>
	<div class=" col-md-9" ng-controller="EmployerDashboard">
		<div class="section_container">
      <div class="pvm-green-background" style="margin-bottom: 10px;">
        <div class="whiteColor open_jobs">
        	<i class="fa fa-files-o"></i>
        	OPEN ROLES YOU ARE MANAGING
        </div>
        <div class="search_jobs">
        	<input type="text" name="search_roles" ng-model="searchRoles" placeholder="Search a role from the list below..">
        </div>
        <div class="clearfix"></div>
      </div>

			<div class="col-md-12 whiteBg emp-dash-container ">
				<div class="text-center splashdata" ng-show="!loadingJobs">
	        <img src="{$BaseHref}/themes/bbt/images/preloader.gif" width="30">
	        <h4>Loading data</h4>
				</div>
				<div class="tse-scrollable" id="jobs_container" ng-show="loadingJobs">
					<div class="table-responsive" ng-show="showJobs">
						<table class="table table-hover table-bordered tse-content">
							 <thead>
								 	<colgroup>
								 		<col width="15%">
								 		<col width="10%">
								 		<col width="10%">
								 		<col width="10%">
								 		<col width="10%">
								 		<col width="10%">
								 		<col width="20%">
								 		<col width="15%">
								  </colgroup>
						      <tr class="pvm-gray">
						        <th class="tcol_1">Role</th>
						        <th class="text-center">Long List</th>
						        <th class="text-center">Short List</th>
						        <th class="text-center">Interview</th>
						        <th class="text-center">Hire</th>
						        <th class="text-center">Not Successful</th>
						        <th class="text-center tcol_6">Listing Expiry</th>
						        <th class="text-center tcol_7">Team</th>
						      </tr>
						    </thead>
						    <tbody>

								<tr ng-repeat="job in GetJobs | filter:searchRoles">
									<td class="tcol_1">
									<a href="@{{base_url}}employer/manage-talent?id=@{{job.id}}">@{{job.job_title}} (@{{job.counters.passed_applicants}})</a>
									<div class="employer_role_location">@{{job.location.display_name}}</div>
									</td>
									<td class="text-center">@{{job.counters.long_list}}</td>
									<td class="text-center">@{{job.counters.short_list}}</td>
									<td class="text-center">@{{job.counters.interview}}</td>
									<td class="text-center">@{{job.counters.hired}}</td>
									<td class="text-center">@{{job.counters.rejected}}</td>
									<td class="text-center tcol_6" ng-class="{'pvm-red' : job.expiring_this_week == true}">@{{job.expiry_date}}</td>
									<td class="text-center tcol_7">
										<span id="top_profile_image" ng-repeat="member in job.members" title="@{{member.first_name}} @{{member.last_name}}" data-toggle="tooltip" data-placement="top" tooltip >
											<!--<img src="themes/bbt/images/defaultPhoto.png" ng-if="!member.profile_image" width="30"class="img-circle">-->

											<span ng-if="!member.profile_image" class="member-initials @{{member.profile_color}}">@{{member.initial}}</span>

											<a href="@{{member.profile_url}}">
												<img ng-src="@{{member.profile_image}}" ng-if="member.profile_image" width="30" class="img-circle" on-error-src="{$ThemeDir}/images/defaultPhoto.png"/>
											</a>
										</span>
									</td>
								</tr>
						      </tbody>
						</table>

					</div>
					<div ng-hide="showJobs">No Result.</div>
				</div>

			</div>

			<div class="col-md-12 em-dash2-conatainer">
				<div class="col-md-4 em-dash-orange-con" style="padding-right: 5px;">
					<div class="em-dash-orange pvm-white">
						<i class="fa fa-file-text-o"></i>MY DRAFTS
					</div>

					<div class="em-dash-content-con tse-scrollable" >

						<div class="text-center splashdata" ng-show="GetDraftJobs.length == 0">
			        <img src="{$BaseHref}/themes/bbt/images/preloader.gif" width="30">
			        <h4>Loading data</h4>
						</div>
						<div class="content no-result" ng-show="GetDraftJobs.jobs.length == 0">
							No Result
						</div>

						<table class="tse-content dash-my-drafts dash-table" cellpadding="10" ng-show="GetDraftJobs.length != 0">
							<tr ng-repeat="draft in GetDraftJobs.jobs">
								<td cellpadding="10">
                  <p class="job-title">@{{draft.job_title}}</p>
                  <a href="{$BaseHref}employer/job/add/employee?id=@{{draft.id}}&draft=1" class="btn-pvm btn-mini btn-tertiary">CONTINUE</a>
								</td>
							</tr>
						</table>
					</div>
				</div>

				<div class="col-md-4 em-dash-gray-con" style="padding-left: 5px;">
				<div class="em-dash-gray pvm-white">
					<i class="fa fa-hand-stop-o"></i>PAST ROLES
				</div>
					<div class="em-dash-content-con tse-scrollable">
						<div class="text-center splashdata" ng-show="GetExpiredJobs.length == 0">
			        <img src="{$BaseHref}/themes/bbt/images/preloader.gif" width="30">
			        <h4>Loading data</h4>
						</div>
						<div class="content no-result" ng-show="GetExpiredJobs.jobs.length == 0">
							No Result
						</div>
						<table class="tse-content dash-table" cellpadding="10" ng-show="GetExpiredJobs.jobs.length != 0">
							<tr ng-repeat="job in GetExpiredJobs.jobs" id="exp_@{{job.id}}">
								<td cellpadding="10">
                  <p class="job-title">@{{job.job_title}}</p>
                  <a href="#" class="btn-pvm btn-mini btn-danger" confirmed-click="deleteExpired(job.id)" ng-confirm-click="Are you sure you want to remove this role?">REMOVE</a>
								</td>
							</tr>
						</table>

						<div ng-show="GetExpiredJobs.length != 0" class="no-result">
							No Result
						</div>
					</div>
				</div>

				<div class="col-md-4 em-dash-gray-con">
				<div class="em-dash-blue pvm-white">
					<i class="fa fa-eye"></i>WATCHLIST
				</div>
					<div class="em-dash-content-con tse-scrollable">
						<div class="text-center splashdata" ng-show="GetWatchlistJobs.length == 0">
					    <img src="{$BaseHref}/themes/bbt/images/preloader.gif" width="30">
					    <h4>Loading data</h4>
						</div>

						<div class="content no-result" ng-show="GetWatchlistJobs.length == 0">
							No Result
						</div>

						<table class="tse-content dash-table" cellpadding="10" ng-show="GetWatchlistJobs.length != 0">
							<tr ng-repeat="job in GetWatchlistJobs">
								<td cellpadding="10">
									<div class="col-md-9 content">
									<a href="{$BaseHref}me/@{{job.profile_url}}">@{{job.first_name}} @{{job.last_name}}</a>
									<br>
									<small>@{{job.industry.industry}},
									@{{job.preferred_location}}</small>
									</div>
									<div style="position: relative;top: 50%;transform:translateY(70%);font-size:20px" class="col-md-3 text-center  no-curved-border" ng-class="{'pvm-blue' : job.seen == true}"><i ng-click="watchThis($event, job.profile_url)" data-index="@{{job.index}}" class="glyphicon glyphicon-eye-open watchlist_save pvm-cursor-pointer"></i></div>



								</td>
							</tr>
						</table>



					</div>

				</div>

			</div>


		</div>



	</div>
</div>
</div>
@stop

@section('scripts')
<script type="text/javascript" src="js/minified/login/login.min.js"></script>
<script type="text/javascript" src="js/minified/employers/sidebar.min.js"></script>
<script type="text/javascript" src="js/minified/employers/dashboard.min.js"></script>
@stop