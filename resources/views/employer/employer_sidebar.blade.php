<div class="sidebar-nav" ng-controller="EmployerSidebar">
    <div class="navbar navbar-default" role="navigation">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <span class="visible-xs navbar-brand">@{{employerdata.first_name}}</span>
        </div>
        <div class="navbar-collapse collapse sidebar-navbar-collapse">
            <ul class="nav navbar-nav" id="sidenav01">
                <li class="user">
                    <!-- Uncomment for dynamic profile URL -->
                    <!-- <a href="/company/@{{employerdata.company.company_url}}" data-toggle="collapse" data-target="#toggleDemo0" data-parent="#sidenav01" class="collapsed "> -->
                    <a href="/company/previewme" data-toggle="collapse" data-target="#toggleDemo0" data-parent="#sidenav01"
                        class="collapsed ">
                        <div>
                            <!-- Uncomment line 20, then remove 21 if the session checking is in place for the header -->
                            <!-- <div class="member-initials member-initials--lg @{{employerdata.profile_color}}" ng-if="!employerdata.profile_picture_url">@{{employerdata.initial}}</div> -->
                            <div class="member-initials member-initials--lg member-initials--sky" ng-if="!employerdata.profile_picture_url">@{{employerdata.initial}}</div>
                            <img ng-src="@{{employerdata.profile_picture_url}}" class="img-circle profileImg " ng-if="employerdata.profile_picture_url"
                                on-error-src="/images/defaultPhoto.png">
                            <p ng-if="employerdata.first_name" style="margin-bottom:0px">@{{employerdata.first_name}}</p>
                            <p ng-if="employerdata.company.company_name" style="margin-bottom:0px;color:#A7A7A8;font-size:13px">@{{employerdata.company.company_name}}</p>
                            <p ng-if="employerdata.account_type_string" style="color:#A7A7A8;font-size:13px">@{{employerdata.account_type_string}}</p>
                        </div>
                    </a>
                </li>
                <!-- <li <% if $ClassMethod == 'Employer_Controller::dashboard' || $ClassMethod == 'Employer_Controller::jobs'%>class="active" <% end_if %>> -->
                <li ng-class="{'active': employer_uri === 'dashboard'}"><a href="/employer/dashboard"><span class="glyphicon dashboard-icon"></span>Dashboard</a></li>

                <li><a href="/company/@{{employerdata.company.company_url}}"><span class="glyphicon company-profile-icon"></span>Company
                        Profile</a></li>
                <!-- <li <% if  $ClassMethod == 'Employer_Controller::company_roles'%>class="active" <% end_if %>> -->
                <li><a href="/employer/company-roles"><span class="glyphicon jobs-and-roles-icon"></span>Company Roles</a></li>
                <!-- Analytics -->
                <!-- <li <% if  $ClassMethod == 'Employer_Controller::analytics'%>class="active" <% end_if %>> -->
                <li>
                    <a href="/employer/analytics">
                        <!-- <span class="glyphicon jobs-and-roles-icon"></span>Analytics -->
                        <span class="glyphicon fa fa-bar-chart-o"></span>Analytics
                    </a>
                </li>

                <!-- Candidate Pool -->
                <!-- <li <% if  $ClassMethod == 'Employer_Controller::candidatepool'%>class="active" <% end_if %>> -->
                <li>
                    <a href="/employer/candidatepool">
                        <span class="glyphicon fa fa-users"></span>Candidate Pool
                    </a>
                </li>
                <!-- <li <% if $ClassMethod == 'Employer_Controller::teams' %> class="active" <% end_if %>> -->
                <li ng-class="{'active': employer_uri === 'teams'}"><a href="/employer/teams"><span class="glyphicon teams-icon"></span>Teams</a></li>
                <li><a href="/employer/messages"><span class="glyphicon messages-icon"></span>Messages</a></li>
                <li ng-class="{'active': employer_uri === 'settings'}"><a href="/employer/settings"><span class="glyphicon settings-icon"></span>Settings</a></li>
            </ul>
        </div>
        <!--/.nav-collapse -->
    </div>
</div>
