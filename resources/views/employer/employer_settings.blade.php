@extends('layouts.home')

@section('styles')
@stop

@section('content')

<div class="container-fluid dashmain">
<div class="row ">
    <div class="col-md-3">
      <div class="row">
      @include('employer.employer_sidebar') 
    </div>
  </div>



  <div class="col-md-9 settings_container_holder employer-settings" ng-controller="EmployerSettings">

    <div class="settings_container">
      <div class="col-md-12" id="setting_top_holder">
        <h3 class="pvm-blue">YOUR SETTINGS</h3>
      </div>
      <div class="col-md-12">
        <div class="form-group ">
          <span class="col-md-4" style="margin-top:47px">PROFILE PICTURE</span>
          <div class="col-md-8">
            <span id="employer_setting_page" data-toggle="modal" data-target="#pmvImageModalNew">
              <img ng-if="profile_picture_url" src="@{{profile_picture_url}}" width="137" class="img-circle">
              <!-- <img ng-if="!profile_picture_url" ng-src="{$ThemeDir}/images/defaultPhoto.png" width="137" class="img-circle"> -->
              <span ng-if="!profile_picture_url" class="member-initials member-initials--lg @{{profile_defualtphoto_color}}">@{{initial}}</span>
              <a href="#" class="add_photo_button pvm-blue btn-pvm btn-mini btn-primary" style="margin-left:28px;margin-top:42px">Change Photo</a>
            </span>
          </div>
        </div>
      </div>

      <div class="col-md-12">
        <div class="col-md-12"><hr style="border:1px #ccc solid;"></div>
      </div>

      <div class="col-md-12">
        <div class="col-md-4">MY EMAIL ADDRESS</div>
        <div class="col-md-8">
          <a href="#" style="display:block;padding-bottom:10px">@{{email}}</a>
          <div id="WorkHistoryForm"  class="animate-show">
            <div id="msg" style="display:none"></div>
            <!-- <form ng-submit="OpenSecurityModal('changeEmail')"  id="changePassordForm"> -->
            <form  ng-submit="changeEmail()"  id="changeEmailForm"> <!-- ng-submit="changeEmail()"  -->
            
              <div class="row">
                <div class="col-md-12">
                  <div>
                    <input id="newEmail" type="email" name="email" placeholder="New email address" rows="3" required class="pvm-input-text">
                  </div>
                </div>
                <div class="col-md-12">
                  <div>
                    <input id="confirmEmail" type="email" name="email_confirm" required placeholder="Confirm new email address" class="filterQualification pvm-input-text" rows="3">
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="pull-right">
                    <input type="submit" name="action_doNothing" value="Update" class="action submit_wh btn-pvm btn-mini btn-secondary" id="Form_action_doNothing">
                    <button onclick="cancelSettings(this)" type="button" class="cancel_wh btn-pvm btn-mini btn-default">CANCEL</button>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
      <div class="col-md-12">
        <div class="col-md-12"><hr style="border:1px #ccc solid;"></div>
      </div>

      <div class="col-md-12">
        <div class="col-md-4">MY PASSWORD</div>

        <div class="col-md-8">
          <div id="WorkHistoryForm" class="animate-show">
            <div id="msg" style="display:none"></div>
            <!-- <form ng-submit="OpenSecurityModal('changePassword')"  id="changePassordForm"> -->
            <form ng-submit="changePassword()"  id="changePassordForm" name="changePassordForm"> <!-- ng-submit="changePassword()"  -->
              <div class="row">
              <div class="col-md-12 qualification_holder">
                <div>
                  <input type="password" name="current_password" ng-model="qualification_edu" placeholder="Current password" rows="3" required class="pvm-input-text">
                </div>
              </div>

              <div class="col-md-12">
                <div>
                  <input type="password" required name="password" placeholder="New password"  rows="3" class="pvm-input-text">
                </div>
              </div>
              <div class="col-md-12">
                <div>
                  <input type="password" required name="confirm_password" placeholder="Confirm new password" rows="3" class="pvm-input-text">
                </div>
              </div>
              <div class="col-md-12">
                <div class="pull-left">
                  <a href="register/forgot_password">Forgot your password</a>
                </div>
                <div class="pull-right">
                  <input type="submit"  name="action_doNothing" value="Update" class="action submit_wh btn-pvm btn-mini btn-secondary" id="Form_action_doNothing">
                  <button onclick="cancelSettings(this)" type="button" class="cancel_wh btn-pvm btn-mini btn-default">CANCEL</button>
                </div>
                <div class="clearfix"></div>
              </div>
              </div>
            </form>
          </div>
        </div>
      </div>

      <div class="col-md-12">
        <div class="col-md-12"><hr style="border:1px #ccc solid;"></div>
      </div>
      <div class="col-md-12">
        <!-- <form ng-submit="OpenSecurityModal('updateProfile')" id="employer_setting_form" > -->
        <form ng-submit="updateProfile()" id="employer_setting_form" > <!-- ng-submit="updateProfile()" -->
          <div class="form-group ">
            <span for="example-text-input" class="col-md-4 col-form-label">FIRST NAME</span>
            <div class="col-md-8">
              <div id="employer_setting_msg" style="display:none"></div>
              <input class="form-control" type="text" ng-model="first_name" placeholder="First name" name="first_name" class="pvm-input-text">
            </div>
          </div>
          <div class="form-group ">
            <span for="example-text-input" class="col-md-4 col-form-label">LAST NAME</span>
            <div class="col-md-8">
              <input class="form-control" type="text" ng-model="last_name" placeholder="Last name" name="last_name" class="pvm-input-text">
            </div>
          </div>
          <div class="form-group ">
            <span for="example-text-input" class="col-md-4 col-form-label">NICKNAME</span>
            <div class="col-md-8">
              <input class="form-control" type="text" ng-model="nickname" placeholder="Nickname" name="nickname" class="pvm-input-text">
            </div>
          </div>
          <div class="form-group ">
            <span for="example-text-input" class="col-md-4 col-form-label">PHONE NUMBER</span>
            <div class="col-md-8">
              <input class="form-control" type="text" ng-model="phone_number" placeholder="Phone number" name="phone" class="pvm-input-text">
            </div>
          </div>
          <div class="form-group ">
            <span for="example-text-input" class="col-md-4 col-form-label">MOBILE</span>
            <div class="col-md-8">
              <input class="form-control" type="text" ng-model="mobile_number" placeholder="Mobile" name="mobile" class="pvm-input-text">
            </div>
          </div>
          <div class="form-group ">
            <span for="example-text-input" class="col-md-4 col-form-label">WORK TITLE</span>
            <div class="col-md-8">
              <input class="form-control" type="text" ng-model="work_title" placeholder="Work title" name="work_title" class="pvm-input-text">
            </div>
          </div>
          <div class="form-group ">
            <span for="example-text-input" class="col-md-4 col-form-label">DEPARTMENT</span>
            <div class="col-md-8">
              <input class="form-control" type="text" ng-model="work_dept" placeholder="Work title" name="department" class="pvm-input-text">
            </div>
          </div>
          <div class="col-md-12">
            <div class="pull-right">
              <input type="submit"  name="action_doNothing" value="update" class="action submit_wh btn-pvm btn-mini btn-secondary" id="Form_action_doNothing">
              <button onclick="cancelSettings2(this)" type="button" class="cancel_wh btn-pvm btn-mini btn-default">CANCEL</button>
            </div>
          </div>
        </form>
      </div>

      <div class="clearfix"></div>

      <div class="col-md-12" ng-show="TeamAdminPermission" id="TeamAdminPermission">
        <div class="col-md-12"><hr style="border:1px #ccc solid;"></div>
        <div class="col-md-12 settingHead">
          <div class="row">
            <div class="col-md-6 comp-settings">
              <h3 class="pvm-blue">COMPANY SETTINGS</h3>
            </div>
            <div class="col-md-6 text-right comp-settings">
              <a href="/employer/settings" ng-click="showInviteModal()" class="InviteMember btn-pvm btn-tertiary">Invite Company Members</a>
            </div>
          </div>
        </div>
        <div class="col-md-12">
          <div class="row" >
            <div class="col-md-4">
              <span>COMPANY ADMINS</span>
            </div>
            <div class="col-md-8">
              <div class="row">
                <div class="col-md-12">
                  <div class="alert alert-warning" role="alert" ng-show="savechanges">
                    <strong>Warning!</strong> Please save your change once done editing
                  </div>
                  <div class="alert alert-success alert-dismissible" role="alert" ng-show="successsavechanges">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <strong>Success!</strong> New Admin is saved.
                  </div>
                </div>
              </div>

              <ul class="userList">
                <li ng-repeat="admins in TeamAdmins" class="member-item">
                  <img ng-src="@{{admins.profile_picture_url}}" ng-show="admins.profile_picture_url != ''  || admins.profile_picture_url != null " width="80" class="img-circle" ng-class="{'hide': admins.profile_picture_url == '' || admins.profile_picture_url == null}" on-error-src="{$ThemeDir}/images/defaultPhoto.png">
                  <div ng-show="admins.profile_picture_url == '' || admins.profile_picture_url == null" class="member-initials member-initials--tms @{{admins.profile_color}}">@{{admins.initial}}</div>
                  <h3 class="member-name member-name--first">@{{admins.first_name}}</h3>
                  <h3 class="member-name member-name--last">@{{admins.last_name}}</h3>
                  <a href="" class="removethis  btn-pvm btn-mini btn-transparent" ng-click="RemoveTeamMember( admins.id, admins.account_type_string )"><i class="fa fa-close"></i></a>
                </li>
              </ul>
              </div>
          </div>
        </div>
        <div class="col-md-12">
          <div class="row" >
            <div class="col-md-4 "></div>
            <div class="col-md-8">
              <input type="text" ng-model="searchmember" placeholder="Search Member" id="SearchMemberField" class="pvm-input-text">
              <div id="SearchMember" class="autoCompleteMe"  style="display:none">
              <ul class="userList">
                <li ng-repeat="data in TeamMembers | filter:searchmember   | limitTo:10 " >
                  <div class="container-fluid">
                    <div class="row">
                    <label for="memberList@{{data.id}}">
                      <div class="col-md-4 autoc-img-con">
                      <input type="checkbox" id="memberList@{{data.id}}" name="member" checklist-model="selectedmember" checklist-value="data" style="display:none;">
                        <img ng-src="@{{data.profile_picture_url}}" ng-show="data.profile_picture_url != ''   || data.profile_picture_url != null" ng-class="{'hide': data.profile_picture_url == '' || data.profile_picture_url == null}" class="img-circle" on-error-src="{$ThemeDir}/images/defaultPhoto.png">
                        <div ng-show="data.profile_picture_url == '' || data.profile_picture_url == null" class="member-initials member-initials--nav @{{data.profile_color}}">@{{data.initial}}</div>
                      </div>
                      <div class="col-md-8 autoc-name-con">
                        <span class="userName">@{{data.full_name}}</span>
                      </div>
                    </label>
                    </div>
                  </div>
                </li>
              </ul>

              </div>
              <div class="text-right">
                <button ng-click="SubmitMemberAsAdmin()" id="SubmitMemberAsAdmin" type="button" class="submit_wh btn-pvm btn-mini btn-primary">Add admin</button>
                <button  ng-click="CancelMemberAsAdmin()" type="button" class="cancel_wh btn-pvm btn-mini btn-default">CANCEL</button>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="clearfix"></div>

      <div class="col-md-12">
        <div class="col-md-12"><hr style="border:1px #ccc solid;"></div>
      </div>

      @include('employer.career_widget')

      <div class="col-md-12">
        <div class="col-md-12">
          <div class="row" id="DisableAccount">
            <div class="col-md-4">
              DISABLE MY ACCOUNT
            </div>
            <div class="col-md-8">
              By disabling my account I understand that it might take up to 48 hours to delete all my personal info from the website.<br><br>
              <button type="button" confirmed-click="disableAccount()" ng-confirm-click="Are you sure you want to disable your account?" class="action submit_wh pull-right btn-pvm btn-mini btn-danger">DISABLE MY ACCOUNT</button>
              <div class="clearfix"></div>
            </div>
          </div>
        </div>
      </div>
      <div class="clearfix"></div>
    </div>

    @include('employer.invite_member_modal')
    @include('home.video_photo_upload_modal')
    @include('home.security_login_modal')
  </div>
</div>

</div>
@stop

@section('scripts')
<script type="text/javascript" src="js/minified/login/login.min.js"></script>
<script type="text/javascript" src="js/minified/employers/sidebar.min.js"></script>
<script type="text/javascript" src="js/minified/employers/settings.min.js"></script>
<script type="text/javascript" src="js/spectrum.min.js"></script>
<script type="text/javascript" src="js/minified/employers_set-JS.min.js"></script>
@stop


