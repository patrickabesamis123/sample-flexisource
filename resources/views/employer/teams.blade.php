@extends('layouts.home')

@section('styles')
@stop

@section('content')

<div class="container-fluid" id="EmployerTeamContainer" ng-cloak>
    <div class="row">
        <div class="col-md-3">
            <div class="row">
                @include('employer.employer_sidebar')
            </div>
        </div>
        <div class="col-md-9" ng-controller="EmployerTeams">
            <div id="EmployerTeams">
                <!-- error msg   -->
                <div class="alert alert-success alert-dismissible" ng-show="successInvite" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <strong>Success!</strong> @{{user.first_name}} @{{user.last_name}} was successfully invited!
                </div>

                <div class="alert alert-danger alert-dismissible" ng-show="failInvite" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <strong>Error Found!</strong>
                    <ul>
                        <li ng-repeat="(key, value) in user">
                            @{{value}}
                        </li>
                    </ul>
                </div>

                <div class="alert alert-success alert-dismissible" ng-show="successdeleteteam" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <strong>Success!</strong> The team has been deleted.
                </div>

                <div class="alert alert-success alert-dismissible" ng-show="successdeletemember" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <strong>Member is successfully removed</strong>
                </div>

                <div class="alert alert-success alert-dismissible" ng-show="successteam" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <strong>Team is successfully created</strong>
                </div>

                <div class="alert alert-success alert-dismissible" ng-show="successteamupdate" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <strong>@{{successteamupdateName}} has been successfully updated</strong>
                </div>

                <div class="alert alert-danger alert-dismissible" ng-show="failteam" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <strong>Error Found!</strong> @{{error}}
                </div>

                <!-- error msg f -->
                <div class="sliderContainer" style="min-width: 100%">
                    <div class="">
                        <div class="row">
                            <div class="col-md-6">
                                <h3 class="page_title_blue">MY TEAMS</h3>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-6"><button class="pull-right createNewTeam btn-pvm btn-primary"
                                            type="button" id="formCreateTeam">Create a New Team</button></div>
                                    <div class="col-md-6"><input type="text" ng-model="searchteam" placeholder="Search Team"
                                            class="pull-right pvm-input-text pvm-search-team"></div>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <hr class="divider">
                        <div class="row" id="newTeam" style="display:none">
                            <div class="col-md-12">
                                <div class="createNewTeamContainer">
                                    <form ng-submit="CreateNewTeam( testId )">
                                        <h3 class="secondary-title">Create a New Team</h3>
                                        <hr>
                                        <input type="text" ng-model="team.team_name" placeholder="Team Name"
                                            ng-required="true" class="team-textbox">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <h4 class="primary-subtitle">Select Team Members</h4>
                                            </div>
                                            <div class="col-md-6 text-right">
                                                <button type="button" class="editTeam btn-pvm btn-mini btn-tertiary"
                                                    ng-click="showInviteModal()">Invite Team Members</button>
                                            </div>
                                        </div>

                                        <!-- Preview Added Team members-->
                                        <ul class="PreviewTeamMembers member-list">
                                            <li ng-repeat="(key, value) in team.members" class="col-md-2 member-item">
                                                <div class=" text-center" ng-repeat="list in GetAllCompanyMember | filter: {'id':value}:true">
                                                    <img ng-src="@{{list.profile_picture_url}}" ng-class="{'hide': list.profile_picture_url === ''  || list.profile_picture_url === null} "
                                                        width="80" class="img-circle" on-error-src="images/defaultPhoto.png">
                                                    <div ng-show="list.profile_picture_url == ''  || list.profile_picture_url == null"
                                                        class="member-initials member-initials--tms @{{list.profile_color}}">@{{list.initial}}</div>
                                                    <h3 class="member-name member-name--first">@{{list.first_name}}</h3>
                                                    <h3 class="member-name member-name--last">@{{list.last_name}}</h3>
                                                    <a href="" ng-click="removeSelectedMember(key)" class="remove btn-pvm btn-mini btn-transparent"><i
                                                            class="fa fa-close"></i></a>
                                                </div>
                                            </li>
                                            <li class="clearfix"></li>
                                        </ul>
                                        <!-- Preview Added Team members-->
                                        <div class="clearfix"></div>

                                        <!-- Team Member section -->
                                        <div class="row">
                                            <div class="col-md-12 relative_me">
                                                <input type="text" ng-model="searchmember" placeholder="Search members"
                                                    id="SearchMemberField" class="team-textbox">
                                                <div id="SearchMember" style="display:none">
                                                    <ul class="userList">
                                                        <li ng-repeat="data in GetAllCompanyMember | filter:searchmember | limitTo: 10 ">
                                                            <div class="container-fluid">
                                                                <div class="row">
                                                                    <label for="member-list@{{data.id}}">
                                                                        <div class="col-md-2 no-padding">
                                                                            <img ng-src="@{{data.profile_picture_url}}"
                                                                                ng-show="data.profile_picture_url != ''   || data.profile_picture_url != null"
                                                                                class="img-circle" on-error-src="images/defaultPhoto.png">
                                                                            <div ng-show="data.profile_picture_url == '' || data.profile_picture_url == null"
                                                                                class="member-initials member-initials--autoc @{{data.profile_color}}">@{{data.initial}}</div>
                                                                        </div>
                                                                        <div class="col-md-10">
                                                                            <span class="userName">@{{data.full_name}}</span>
                                                                            <input type="checkbox" id="member-list@{{data.id}}"
                                                                                name="member" checklist-model="team.members"
                                                                                checklist-value="data.id" class="selectedMember">
                                                                        </div>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </li>

                                                    </ul>
                                                    <div ng-show="(GetAllCompanyMember | filter:searchmember).length == 0">No
                                                        results</div>
                                                    <div class="clearfix"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Team Member section -->

                                        <!-- Team Manager section -->
                                        <div class="row">
                                            <div class="col-md-6">
                                                <h4 class="primary-subtitle">Select Team Admin</h4>
                                            </div>
                                            <div class="col-md-6 text-right">
                                                <button class=" editTeam btn-pvm btn-mini btn-tertiary" ng-click="showInviteManagerModal()">Invite
                                                    Team Admin</button>
                                            </div>
                                        </div>

                                        <ul class="PreviewTeamMembers member-list">
                                            <li class="col-md-2 member-item">
                                                <div class=" text-center" ng-repeat="list in GetAllCompanyMember | filter: {'id':team.team_admin}:true">
                                                    <img ng-src="@{{list.profile_picture_url}}" ng-show="list.profile_picture_url != ''  || list.profile_picture_url != null "
                                                        width="80" class="img-circle hide" on-error-src="images/defaultPhoto.png">
                                                    <div ng-show="list.profile_picture_url == ''  || list.profile_picture_url == null"
                                                        class="member-initials member-initials--tms @{{list.profile_color}}">@{{list.initial}}</div>
                                                    <h3 class="member-name member-name--first">@{{list.first_name}}</h3>
                                                    <h3 class="member-name member-name--last">@{{list.last_name}}</h3>
                                                    <a href="" ng-click="removeSelectedAdmin(key)" class="remove btn-pvm btn-mini btn-transparent"><i
                                                            class="fa fa-close"></i></a>
                                                </div>
                                            </li>
                                            <li class="clearfix"></li>
                                        </ul>

                                        <div class="clearfix"></div>
                                        <!-- Team Member section -->
                                        <div class="row">
                                            <div class="col-md-12">
                                                <input type="text" ng-model="searchmanager" placeholder="Search members"
                                                    id="SearchManagerField" class="team-textbox">
                                                <div id="SearchManager" style="display:none">

                                                    <ul class="userList">
                                                        <li ng-repeat="data in GetAllCompanyMember | filter:searchmanager |  limitTo:10">
                                                            <div class="container-fluid">
                                                                <div class="row">
                                                                    <label for="managerList@{{data.id}}">
                                                                        <div class="col-md-2">
                                                                            <img ng-src="@{{data.profile_picture_url}}"
                                                                                ng-show="data.profile_picture_url != ''   || data.profile_picture_url != null"
                                                                                ng-class="{'hide': data.profile_picture_url == '' || data.profile_picture_url == null}"
                                                                                class="img-circle" on-error-src="images/defaultPhoto.png">

                                                                            <div ng-show="data.profile_picture_url == '' || data.profile_picture_url == null"
                                                                                class="member-initials member-initials--autoc @{{data.profile_color}}">@{{data.initial}}</div>
                                                                        </div>
                                                                        <div class="col-md-10">
                                                                            <span class="userName">@{{data.full_name}}</span>
                                                                            <input type="radio" id="managerList@{{data.id}}"
                                                                                name="member" ng-model="team.team_admin"
                                                                                value="@{{data.id | number }}" class="selectedMember">

                                                                        </div>
                                                                    </label>
                                                                </div>
                                                            </div>


                                                        </li>
                                                    </ul>
                                                    <div class="clearfix"></div>
                                                    <div ng-show="(GetAllCompanyMember | filter:searchmanager).length == 0">No
                                                        results</div>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="button-container">
                                            <div class="row">
                                                <div class="col-md-4 col-md-offset-8 ">

                                                    <button type="button" id="CancelTeam" class="btn pull-right NewTeamCancel btn-pvm btn-mini btn-default"
                                                        ng-click="cancelTeam();">Cancel</button>
                                                    <button type="submit" class="btn  pull-right NewTeamSubmit btn-pvm btn-mini btn-primary"
                                                        name="Save">Save</button>
                                                    <div ng-show="publishing" class="text-center"><img src="images/preloader.gif"
                                                            width="45"> </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Team Member section -->
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="text-center splash " ng-show="!GetAllCompanyTeam">
                            <div class="cssload-container">
                                <h3>Please wait.</h3>
                                <h4>While we prepare the results.</h4>
                                <div class="cssload-loading"><i></i><i></i><i></i><i></i></div>
                            </div>
                        </div>

                        <!-- Repeat Teams -->
                        <div ng-repeat="team in GetAllCompanyTeam | filter: {team_name: searchteam}" ng-show="GetAllCompanyTeam.length != 0"
                            id="team_@{{team.id}}">
                            <div class="row titleContainer">
                                <div class="col-md-6">
                                    <h3 class="teamName">@{{team.team_name}}</h3>
                                </div>
                                <div class="col-md-6">
                                    <span ng-show="@{{team.modify}}">
                                        <a href="/employer/teams#" class="pull-right deleteTeam btn-pvm btn-mini btn-danger btn-square"
                                            confirmed-click="deleteTeam(team.id)" ng-confirm-click="Are you sure you want to delete this?">Delete</a>
                                        <button type="button" class="pull-right editTeam btn-pvm btn-secondary btn-mini"
                                            ng-click="editTeam(team)">Edit</button>
                                        <div class="clearfix"></div>
                                    </span>
                                </div>
                            </div>

                            <ul class="member-list">
                                <li ng-repeat="member in team.members" class="col-md-2 member-item">
                                    <div class="text-center">
                                        <div class="image">
                                            <img src="@{{member.employer.profile_picture_url}} " ng-show="member.employer.profile_picture_url != ''  || member.employer.profile_picture_url != null "
                                                width="80" class="img-circle" ng-class="{'hide': member.employer.profile_picture_url == '' || member.employer.profile_picture_url == null}"
                                                on-error-src="images/defaultPhoto.png">
                                            <div ng-show="member.employer.profile_picture_url == ''  || member.employer.profile_picture_url == null"
                                                class="member-initials member-initials--tms @{{member.employer.profile_color}}">@{{member.employer.initial}}</div>
                                        </div>
                                        <h3 class="member-name member-name--first">@{{member.employer.first_name}}</h3>
                                        <h3 class="member-name member-name--last">@{{member.employer.last_name}}</h3>
                                        <h4 class="member-role" ng-show=" member.team_role == 'team_admin'">Team Admin</h4>
                                        <h4 class="member-role" ng-show=" member.team_role == 'team_member'">Member</h4>

                                        <div class="text-center" ng-show="team.permissions.modify">
                                            <a href="" confirmed-click="removeMember(team.id, member.employer.id)"
                                                ng-confirm-click="Are you sure you want to delete this?" class="remove btn-pvm btn-mini btn-transparent"><i
                                                    class="fa fa-close"></i></a>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                            <hr class="divider">
                        </div>
                        <div ng-show="GetAllCompanyTeam.length == 0">
                            No teams registered.
                        </div>
                        <!-- Repeat Teams -->
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>


@include('employer.invite_member_modal')
@include('employer.invite_manager_modal')

@stop

@section('scripts')
<script type="text/javascript" src="js/minified/login/login.min.js"></script>
<script type="text/javascript" src="js/minified/employers/sidebar.min.js"></script>
<script type="text/javascript" src="js/minified/employers/teams.min.js"></script>
@stop
