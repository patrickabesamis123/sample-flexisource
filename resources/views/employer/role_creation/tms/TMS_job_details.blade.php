<section class="TMS-job-details clear-float" ng-hide="preload" ng-cloak>
    <!-- <div ng-if="JobData.job_status == 'closed'" class="TMS__closed-job"> -->
    <div id="TMS__Notification-head" ng-hide="isClosedDate" class="TMS__closed-job">
    <p class="TMS__closed-job-msg" ng-class="{'hide-notice': closeJobReportNotice == true}">You are viewing a closed role.</p>
    <!-- <i class="fa fa-question" ng-click="closeJobReportNotice = !closeJobReportNotice"></i> -->
    </div>
    <a class="pvm-link TMS__back-link" href="employer/company-roles">&laquo; Back to Company Roles</a>
    <h4 class="secondary-subtitle">Job Id: @{{JobData.object_id}}</h4>
    <a href="/job/listing/@{{JobData.object_id}}" class="primary-title primary-title--bold pvm-link">@{{JobData.job_title}}</a>
    <div class="TMS__btn-con">
    <a href="javascript:void(0)" class="TMS__edit-btn btn-pvm btn-mini btn-secondary" ng-click="EditRole(JobData.id)" ng-show="isClosedDate"><!--<i class="fa fa-pencil"></i>--> Edit</a>
    {{-- <a href="javascript:void(0)" class=" TMS__edit-btn btn-pvm btn-mini btn-info" data-toggle="modal" data-target="#modalGuest">Invite Guest</a> --}}
    <a href="javascript:void(0)" class="TMS__close-btn btn-pvm btn-mini btn-danger" ng-click="CloseDrop()" ng-show="isClosedDate"><!--<i class="fa fa-close"></i>--> Close</a>
    <ul ng-hide="cdrop" class="TMS__close-role-list">
        <li class="TMS__close-role-item">
        <a href="javascript:void(0)" class="TMS__close-role-link" confirmed-click="deleteRole('Role filled')" ng-confirm-click="You are about to close this role. All candidates who are not in the hired bucket will be moved to 'Not Successful' bucket. You can still review the last state of your recruits by going to CLOSED ROLES > View Archive TMS. &#13;&#13; Are you sure you want to close this role?">Role Filled</a>
        </li>
        <li class="TMS__close-role-item">
        <a href="javascript:void(0)" class="TMS__close-role-link" confirmed-click="deleteRole('Role filled elsewhere')" ng-confirm-click="You are about to close this role. All candidates who are not in the hired bucket will be moved to 'Not Successful' bucket. You can still review the last state of your recruits by going to CLOSED ROLES > View Archive TMS. &#13;&#13; Are you sure you want to close this role?">Role Filled elsewhere</a>
        </li>
        <li class="TMS__close-role-item">
        <a href="javascript:void(0)" class="TMS__close-role-link" confirmed-click="deleteRole('Withdrawn')" ng-confirm-click="You are about to close this role. All candidates who are not in the hired bucket will be moved to 'Not Successful' bucket. You can still review the last state of your recruits by going to CLOSED ROLES > View Archive TMS. &#13;&#13; Are you sure you want to close this role?">Withdrawn</a>
        </li>
    </ul>
    </div>
    <section class="tms-toggle">
        <div class="tms-toggle__wrap">
            <div class="TMS-job-desc">
                <ul class="TMS__mngt-list">
                    <li class="TMS__mngt-item">
                    <span class="TMS__mngt-label">Role Creator</span>
                    <p class="TMS__mngt-value">@{{JobData.created_by.first_name}} @{{JobData.created_by.last_name}}</p>
                    </li>
                    <li class="TMS__mngt-item">
                    <span class="TMS__mngt-label">Role Manager</span>
                    <p class="TMS__mngt-value">@{{JobData.job_manager.first_name}} @{{JobData.job_manager.last_name}}</p>
                    </li>
                    <li class="TMS__mngt-item">
                    <span class="TMS__mngt-label">Location</span>
                    <p class="TMS__mngt-value">@{{JobData.location.data.display_name}}, @{{JobData.location.data.country.display_name}}</p>
                    </li>
                    <li class="TMS__mngt-item">
                    <span class="TMS__mngt-label">Published</span>
                    <p class="TMS__mngt-value">@{{JobData.published_date}}</p>
                    </li>
                </ul>
                <div class="TMS-job-summary">
                    <ul class="TMS__job-summary-list clear-float">
                    <li class="TMS__job-summary-item">
                        <h2 class="TMS__job-summary-header">@{{JobCounts.total_number_of_applicants}}</h2>
                        <p class="TMS__job-summary-desc">Total number of applicants</p>
                    </li>
                    <li class="TMS__job-summary-item">
                        <h2 class="TMS__job-summary-header">@{{JobCounts.failed_in_pre_apply}}</h2>
                        <p class="TMS__job-summary-desc">Did not pass pre-application questions</p>
                    </li>
                    </ul>
                </div>
            </div>
            <div class="TMS-other-details">
                <ul class="TMS__mngt-list">
                    <li class="TMS__mngt-item" ng-switch="isExpiredDate">
                    <span class="TMS__mngt-label">Expiration</span>
                    <p class="TMS__mngt-value" ng-switch-when="1">
                        <span class="TMS__role-date">@{{JobData.expiry_date}}</span>
                        <span class="TMS__remaining-days">@{{JobData.expiry_days_left}} days left</span>
                    </p>
                    <p class="TMS__mngt-value" ng-switch-when="0">
                        <span class="TMS__role-date" ng-show="isExpiredNotice">@{{JobData.expiry_date}}</span>
                        <span class="TMS__remaining-days--none" ng-show="isExpiredNotice">expired</span>
                        <span class="TMS__role-date" ng-if="closingLevel > 1 || isExpiredNotice == 0">Role closed before expiration</span>
                    </p>

                    <select ng-model="expExtension" ng-options="eexp.value as eexp.text for eexp in RoleExt" ng-change="changeNumberOfDays('extend', expExtension)" class="TMS__extend-role" ng-show="isExpiredDate"></select>
                    <a class="TMS__role-ext btn-pvm btn-mini btn-primary" ng-click="extendDates('extend')" ng-show="isExpiredDate">Extend</a>
                    </li>
                    <li class="TMS__mngt-item">
                    <span class="TMS__mngt-label" ng-class="{'invisible' : JobData.closing_date == null || isClosedDate == 0}">
                        Automatically close on
                        <i class="fa fa-info" ng-if="JobData.closing_date != null" data-toggle="tooltip" data-placement="right" title="The days between Expiration and Closing is provided for you to process your candidates (Note: you can start processing candidates at any time as they apply while the role is live).
                        When Auto-close is switched to ‘On’, PreviewMe will automatically close the role for you on the scheduled date. You can extend the closing date if you need more time processing your candidates. Once the role is closed on the scheduled date, all candidates who are not in the ‘Hired’ bucket will be moved to the ‘Not Successful bucket’ and notified accordingly. Closing the role releases more Analytics about the role, it’s cut through to market and engagement. When Auto-close is switched to ‘Off’, you have to manually close the role. Until the role is closed, not all of the role’s Analytics will be available."></i>
                        <label class="pvm-switch pvm-switch--small" title="Auto close this role" ng-if="JobData.closing_date != null">
                        <input type="checkbox" ng-model="JobData.auto_close">
                        <span class="pvm-slider round"></span>
                        </label>
                    </span>
                    <p class="TMS__mngt-value" ng-if="isClosedDate == 1" ng-class="{'invisible' : JobData.closing_date == null || !JobData.auto_close}">
                    <!-- <p class="TMS__mngt-value" ng-if="isClosedDate == 1"> -->
                        <span class="TMS__role-date">@{{JobData.closing_date}}</span>
                        <span class="TMS__remaining-days" ng-class="{'invisible' : JobData.closing_date == null}">@{{JobData.closing_days_left}} days left</span>
                    </p>
                    <span class="TMS__mngt-label" ng-if="isClosedDate == 0">CLOSED</span>
                    <p class="TMS__mngt-value" ng-if="isClosedDate == 0">
                        <span class="TMS__role-date">@{{JobData.closing_date ? JobData.closing_date : ''}}</span>
                        <span class="TMS__remaining-days--none">closed</span>
                        <span class="TMS__role-date">(@{{JobData.closing_reason ? JobData.closing_reason : '--'}})</span>
                    </p>
                    <select ng-model="closeExtension" ng-options="eclose.value as eclose.text for eclose in RoleExt" ng-change="changeNumberOfDays('closing', closeExtension)" class="TMS__extend-role" ng-class="{'invisible' : JobData.closing_date == null || !JobData.auto_close}" ng-show="isClosedDate"></select>
                    <a class="TMS__role-ext btn-pvm btn-mini btn-primary" ng-class="{'invisible' : JobData.closing_date == null || !JobData.auto_close}" ng-click="extendDates('closing')" ng-show="isClosedDate">Extend</a>
                    </li>
                </ul>
                <ul class="TMS__team-list">
                    <li class="TMS__team-item">
                    <span class="TMS__team-name">Other Members</span>
                    <ul class="TMS__team-members-list">
                        <li ng-repeat="member in teams.members" class="TMS__team-members-item">
                        <img ng-src="@{{member.profile_picture_url}}" ng-class="{'hide': member.profile_picture_url == null || member.profile_picture_url == ''}" class="img-circle member-initials--autoc" on-error-src="/images/defaultPhoto.png" title="@{{member.first_name}} @{{member.last_name}}">
                        <div ng-if="member.profile_picture_url == null || member.profile_picture_url == ''" class="member-initials member-initials--autoc @{{member.profile_color}}" title="@{{member.first_name}} @{{member.last_name}}">@{{member.initial}}</div>
                        <p ng-show="member.team_role == 'team_admin' " class="TMS__team-manager">(Manager)</p>
                        </li>
                    </ul>
                    </li>
                    <li class="TMS__team-item TMS__team-item--team">
                    <span class="TMS__team-name">Team/s managing this role</span>
                    <div class="TMS__flex-team">
                        <ul class="TMS__team-members-list clear-float" ng-repeat="team in teams.teams" ng-if="teams.teams.length > 0">
                        <span class="TMS__team-name--team">@{{team.team_name}}</span>
                        <li ng-repeat="member in team.members" class="TMS__team-members-item">
                            <img ng-src="@{{member.employer.profile_picture_url}}" ng-class="{'hide': member.employer.profile_picture_url == null || member.employer.profile_picture_url == ''}" class="img-circle member-initials--autoc"
                                title="@{{member.employer.first_name}} @{{member.employer.last_name}}">
                            <span ng-if="!member.employer.profile_picture_url" class="member-initials member-initials--autoc @{{member.employer.profile_color}}" title="@{{member.employer.first_name}} @{{member.employer.last_name}}">@{{member.employer.initial}}</span>
                            <p ng-show="member.team_role == 'team_admin' " class="TMS__team-manager">Manager</p>
                        </li>
                        </ul>
                        <p ng-if="teams.teams.length == 0">No team available</p>
                    </div>
                    </li>
                </ul>
                <!-- <a href="#" class="TMS__view-all-link">View all MEMBERS AND TEAMS &raquo;</a> -->
            </div>
        </div>
        <div class="tms-toggle__btn-wrap">
            <button class="btn btn-info btn-toggle" id="btn-toggle" onclick="myFunction()">- Hide</button>
        </div>
    </section>
</section>