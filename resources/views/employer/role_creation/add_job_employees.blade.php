@extends('layouts.employer')

@section('styles')
<link href="css/angucomplete.css?ver=1" rel="stylesheet">
@endsection

@section('content')

<main id="employer-core" class="emp-new-role formstep2 clear-float" ng-controller="EmployerCreateRole">
  <form ng-show="isitPublic == false" id="createRoleForm" name="createRoleForm" ng-submit="checkNext()" novalidate>
    <section id="top_pane" ng-show="isitPublic == false" class="top-pane">
      <i class="fa fa-pencil name" ng-show="changeName" ng-click="changeName = !changeName"></i>
      <i class="fa fa-save name" ng-show="!changeName" ng-click="changeRoleTitle();"></i>
      <input type="text" ng-model="empRoleMain.job_title" class="role__title" ng-class="{'role__title--disabled' : changeName}" ng-disabled="changeName">
      <span class="role__btn-handler pvm-tablet-visible">
        <button href="#" class="btn-pvm btn-mini btn-default role__publish-btn" ng-click="publishRole()" ng-disabled="disablePublish && !appYes" ng-class="{'role__publish-btn--on' : disablePublish == false}"><i class="fa fa-rocket"></i>  Publish role</button>
        <a href="#" class="btn-pvm btn-mini btn-tertiary role__save-btn" ng-click="saveDraft()"><i class="fa fa-save"></i> Save and finish later</a>
      </span>
    </section>
    <section ng-show="isitPublic == false" class="left-pane" ng-cloak>
      <h2 class="role__where-am-i pvm-md-desktop-visible" ng-click="mobileNav = !mobileNav"><i class="fa fa-caret-down"></i> (@{{whereAmI}}) </h2>
      <div class="role__steps-handler">
        <ul class="role__steps-list role__steps-list--old-desk" ng-show="mobileNav">
          <li class="role__steps-item" ng-click="leftNavCallf('build', 'Gen Info')" ng-class="{'active': createBuild,'active role__steps-item--build': createBuild}">
            <span class="role__steps-title">Build the role <i class="fa" ng-class="{'fa-caret-up' : createBuild, 'fa-caret-down' : !createBuild}"></i></span>
            <ul class="role__build-role-list" ng-show="createBuild">
              <li class="role__build-role-item" ng-click="leftNavCallf('build', 'Gen Info')" ng-class="{'active': createBuildGen}">General Information <span>*</span></li>
              <li class="role__build-role-item" ng-click="leftNavCallf('build', 'Resp')" ng-class="{'active': createBuildResp}">Responsibilities <span>*</span></li>
              <li class="role__build-role-item" ng-click="leftNavCallf('build', 'Req')" ng-class="{'active': createBuildReq}"> Skills Requirements</li>
              <li class="role__build-role-item" ng-click="leftNavCallf('build', 'Benefits')" ng-class="{'active': createBuildBen}">Considerations and Benefits </li>
              <li class="role__build-role-item" ng-click="leftNavCallf('build', 'Application')" ng-class="{'active': createBuildAppReq}">Application Requirements <span>*</span></li>
            </ul>
          </li>
          <li class="role__steps-item" ng-click="leftNavCallf('vid', '')" ng-class="{'active': createRoleVid}"><span class="role__steps-title">Create role video</span></li>
          <li class="role__steps-item" ng-click="leftNavCallf('preapp', '')" ng-class="{'active': createPreApp}"><span class="role__steps-title">Pre-application Questions</span></li>
          <li class="role__steps-item" ng-click="leftNavCallf('stan', '')" ng-class="{'active': createStandard}"><span class="role__steps-title">Standard Questions</span></li>
          <li class="role__steps-item" ng-click="leftNavCallf('team', '')" ng-class="{'active': createTeamMngt}"><span class="role__steps-title">Team management</span></li>
          <li class="role__steps-item" ng-click="leftNavCallf('process', '')" ng-class="{'active': createProcess}"><span class="role__steps-title">Process Customisation</span></li>
          <li class="role__steps-item" ng-click="leftNavCallf('email', 'Admin')" ng-class="{'active': createEmailNot,'active role__steps-item--build': createEmailNot}">
            <span class="role__steps-title">Emails and Notifications <i class="fa" ng-class="{'fa-caret-up' : createEmailNot, 'fa-caret-down' : !createEmailNot}"></i></span>
            <ul class="role__build-role-list" ng-show="createEmailNot">
              <li class="role__build-role-item" ng-click="leftNavCallf('email', 'Admin')" ng-class="{'active': createEmailNotAdmin}">Admin Emails & Notifications</li>
              <li class="role__build-role-item" ng-click="leftNavCallf('email', 'Candidate')" ng-class="{'active': createEmailNotCan}">Candidate Emails & Notifications</li>
            </ul>
          </li>
          <li class="role__steps-item" ng-click="leftNavCallf('int', '')" ng-class="{'active': createIntegration}"><span class="role__steps-title">Integration</span></li>
        </ul>
      </div>
    </section>
    <ng-form id="createBuildBenfrm" name="createBuildBenfrm" novalidate>
      <div class="clear-float " ng-if="createBuild && createBuildBen" ng-controller="CreateRoleBuild">
        <div ng-show="role_create_tab_loader == 1" class="role__loader-div">
          <h3>Please wait.</h3>
          <h4>While we prepare this page for you.</h4>
          <div class="cssload-loading"><i></i><i></i><i></i><i></i></div>
        </div>
        <div ng-show="role_create_tab_loader == 0">
          <section class="middle-pane" ng-cloak>
            <div class="role__build-content">
                @include('employer.role_creation.steps.createrole_considerations')
            </div>
          </section>
          <section class="right-pane">
              @include('employer.role_creation.steps.createrole_buildright')
          </section>
        </div>
      </div>
    </ng-form>
    <ng-form id="createBuildGenfrm" name="createBuildGenfrm" ng-submit="checkNext()" method="POST" novalidate="">
      <div class="clear-float " ng-if="createBuild && createBuildGen" ng-controller="CreateRoleBuild">
        <div ng-show="role_create_tab_loader == 1" class="role__loader-div">
          <h3>Please wait.</h3>
          <h4>While we prepare this page for you.</h4>
          <div class="cssload-loading"><i></i><i></i><i></i><i></i></div>
        </div>
        {{-- Changed "role_create_tab_loader == 0" --}}
        <div ng-show="role_create_tab_loader == 0">
          <section class="middle-pane" ng-cloak>
            <div class="role__build-content">
                @include('employer.role_creation.steps.createrole_build')
            </div>
          </section>
          <section class="right-pane">
            @include('employer.role_creation.steps.createrole_buildright')
          </section>
        </div>
      </div>
    </ng-form>
    <ng-form id="createBuildRespfrm" name="createBuildRespfrm" novalidate>
      <div class="clear-float " ng-if="createBuild && createBuildResp" ng-controller="CreateRoleBuild">
        <div ng-show="role_create_tab_loader == 1" class="role__loader-div">
          <h3>Please wait.</h3>
          <h4>While we prepare this page for you.</h4>
          <div class="cssload-loading"><i></i><i></i><i></i><i></i></div>
        </div>
        <div ng-show="role_create_tab_loader == 0">
          <section class="middle-pane" ng-cloak>
            <div class="role__build-content">@include('employer.role_creation.steps.createrole_responsibilities')</div>
          </section>
          <section class="right-pane">
              @include('employer.role_creation.steps.createrole_buildright')
          </section>
        </div>
      </div>
    </ng-form>
    <ng-form id="createBuildAppReqfrm" name="createBuildAppReqfrm" novalidate>
      <div class="clear-float " ng-if="createBuild && createBuildAppReq" ng-controller="CreateRoleBuild">
        <div ng-show="role_create_tab_loader == 1" class="role__loader-div">
          <h3>Please wait.</h3>
          <h4>While we prepare this page for you.</h4>
          <div class="cssload-loading"><i></i><i></i><i></i><i></i></div>
        </div>
        <div ng-show="role_create_tab_loader == 0">
          <section class="middle-pane" ng-cloak>
            <div class="role__build-content">
                @include('employer.role_creation.steps.createrole_app_requirements')
            </div>
          </section>
          <section class="right-pane">
              @include('employer.role_creation.steps.createrole_buildright')
          </section>
        </div>
      </div>
    </ng-form>
    <ng-form id="createBuildReqfrm" name="createBuildReqfrm" novalidate>
      <div class="clear-float " ng-if="createBuild && createBuildReq" ng-controller="CreateRoleBuild">
        <div ng-show="role_create_tab_loader == 1" class="role__loader-div">
          <h3>Please wait.</h3>
          <h4>While we prepare this page for you.</h4>
          <div class="cssload-loading"><i></i><i></i><i></i><i></i></div>
        </div>
        <div ng-show="role_create_tab_loader == 0">
          <section class="middle-pane" ng-cloak>
            <div class="role__build-content">
              @include('employer.role_creation.steps.createrole_requirements')
            </div>
          </section>
          <section class="right-pane">
              @include('employer.role_creation.steps.createrole_buildright')
          </section>
        </div>
      </div>
    </ng-form>

    <div ng-show="isitPublic == false" class="clear-float emp-new-role--can " ng-if="createRoleVid" ng-controller="CreateRoleVideo">
      <div ng-show="role_create_tab_loader == 1" class="role__loader-div">
        <h3>Please wait.</h3>
        <h4>While we prepare this page for you.</h4>
        <div class="cssload-loading"><i></i><i></i><i></i><i></i></div>
      </div>
      <div ng-show="role_create_tab_loader == 0">
        <section class="middle-pane ar__negate_middlepane-property middle-pane--ra" ng-cloak>
          <div class="role__pre-approval-content pvm__negate-padding">
              @include('employer.role_creation.steps.createrole_video')
          </div>
        </section>
        <section class="right-pane"></section>
      </div>
    </div>
    <div ng-show="isitPublic == false" class="clear-float " ng-if="createPreApp" ng-controller="CreateRolePreApp">
      <div ng-show="role_create_tab_loader == 1" class="role__loader-div">
        <h3>Please wait.</h3>
        <h4>While we prepare this page for you.</h4>
        <div class="cssload-loading"><i></i><i></i><i></i><i></i></div>
      </div>
      <div ng-show="role_create_tab_loader == 0">
        <section class="middle-pane" ng-cloak>
          <div class="role__pre-approval-content">
            @include('employer.role_creation.steps.createrole_pre_application')
          </div>
        </section>
        <section class="right-pane">
            @include('employer.role_creation.steps.createrole_pre_application_right')
        </section>
      </div>
    </div>
    <div ng-show="isitPublic == false" class="clear-float " ng-if="createStandard" ng-controller="CreateRoleStandard">
      <div ng-show="role_create_tab_loader == 1" class="role__loader-div">
        <h3>Please wait.</h3>
        <h4>While we prepare this page for you.</h4>
        <div class="cssload-loading"><i></i><i></i><i></i><i></i></div>
      </div>
      <div ng-show="role_create_tab_loader == 0">
        <section class="middle-pane" ng-cloak>
          <div class="role__standard-content">
              @include('employer.role_creation.steps.createrole_standard')
          </div>
        </section>
        <section class="right-pane">
          @include('employer.role_creation.steps.createrole_pre_application_right')
        </section>
      </div>
    </div>
    <div ng-show="isitPublic == false" class="clear-float " ng-if="createTeamMngt" ng-controller="CreateRoleTeam">
      <div ng-show="role_create_tab_loader == 1" class="role__loader-div">
        <h3>Please wait.</h3>
        <h4>While we prepare this page for you.</h4>
        <div class="cssload-loading"><i></i><i></i><i></i><i></i></div>
      </div>
      <div ng-show="role_create_tab_loader == 0">
        <section class="middle-pane" ng-cloak>
          <div class="role__team-content">
              @include('employer.role_creation.steps.createrole_team')
          </div>
        </section>
        <section class="right-pane">
          <div class="role__process-preview">
              @include('employer.role_creation.steps.createrole_teamright')
          </div>
        </section>
      </div>
    </div>
    <div ng-show="isitPublic == false" class="clear-float " ng-if="createProcess" ng-controller="CreateRoleProcess">
      <div ng-show="role_create_tab_loader == 1" class="role__loader-div">
        <h3>Please wait.</h3>
        <h4>While we prepare this page for you.</h4>
        <div class="cssload-loading"><i></i><i></i><i></i><i></i></div>
      </div>
      <div ng-show="role_create_tab_loader == 0">
        <section class="middle-pane" ng-cloak>
          <div class="role__process-content">
              @include('employer.role_creation.steps.createrole_process')
          </div>
        </section>
        <section class="right-pane">
          <div class="role__process-preview">
              @include('employer.role_creation.steps.createrole_process_right')
          </div>
        </section>
      </div>
    </div>
    <div ng-show="isitPublic == false" class="clear-float " ng-if="createEmailNot && createEmailNotAdmin" ng-controller="CreateRoleNotifications">
      <div ng-show="role_create_tab_loader == 1" class="role__loader-div">
        <h3>Please wait.</h3>
        <h4>While we prepare this page for you.</h4>
        <div class="cssload-loading"><i></i><i></i><i></i><i></i></div>
      </div>
      <div ng-show="role_create_tab_loader == 0">
        <section class="middle-pane" ng-cloak>
          <div class="role__email-not-content">
              @include('employer.role_creation.steps.createrole_emailnot_admin')
          </div>
        </section>
        <section class="right-pane">
          @include('employer.role_creation.steps.createrole_emailnot_candidate_right')
        </section>
      </div>
    </div>
    <div ng-show="isitPublic == false" class="clear-float " ng-if="createEmailNot && createEmailNotCan" ng-controller="CreateRoleNotifications">
      <div ng-show="role_create_tab_loader == 1" class="role__loader-div">
        <h3>Please wait.</h3>
        <h4>While we prepare this page for you.</h4>
        <div class="cssload-loading"><i></i><i></i><i></i><i></i></div>
      </div>
      <div ng-show="role_create_tab_loader == 0">
        <section class="middle-pane" ng-cloak>
          <div class="role__email-not-content">
              @include('employer.role_creation.steps.createrole_emailnot_candidate')
          </div>
        </section>
        <section class="right-pane">
          @include('employer.role_creation.steps.createrole_emailnot_candidate_right')
        </section>
      </div>
    </div>
    <div ng-show="isitPublic == false" class="clear-float " ng-if="createIntegration" ng-controller="CreateRoleIntegration">
      <div ng-show="role_create_tab_loader == 1" class="role__loader-div">
        <h3>Please wait.</h3>
        <h4>While we prepare this page for you.</h4>
        <div class="cssload-loading"><i></i><i></i><i></i><i></i></div>
      </div>
      <div ng-show="role_create_tab_loader == 0">
        <div class="role__loader-div">
          <h3>Integrations coming soon!</h3>
          <h4>We are still working on this feature.</h4>
        </div>
        <!--<section class="middle-pane" ng-cloak>
          <div class="role__int-content"><% include CreateRole_Integration %></div>
        </section>
        <section class="right-pane"></section>-->
      </div>
    </div>
    <section class="bottom-pane pvm-tablet-invisible" ng-show="isitPublic == false">
      <a href="#" class="btn-pvm btn-mini btn-primary role__prev-btn" ng-click="checkPrev()"><i class="fa fa-arrow-left"></i></a>
      <span class="role__btn-handler">
        <a href="#" class="btn-pvm btn-mini btn-default role__publish-btn"><i class="fa fa-rocket"></i> </a>
        <a href="#" class="btn-pvm btn-mini btn-tertiary role__save-btn"><i class="fa fa-save"></i> </a>
      </span>
      <a href="#" class="btn-pvm btn-mini btn-primary role__next-btn" ng-click="checkNext()"><i class="fa fa-arrow-right"></i> </a>
    </section>

    <section class="bottom-pane pvm-tablet-visible" ng-show="isitPublic == false">
      <a href="#" class="btn-pvm btn-mini btn-primary role__prev-btn" ng-click="checkPrev()" ng-if="showPrevBtn">
        <i class="fa fa-arrow-left"></i> Previous
      </a>
      <span class="role__btn-handler">
        <!-- <a href="#" class="btn-pvm btn-mini btn-default role__publish-btn" ng-click="publishRole()" ng-disabled="disablePublish"><i class="fa fa-rocket"></i> Publish role</a> -->
        <div class="role__btn-msg" ng-show="gotIt && !disablePublish && showAwesome && appYes">
          <h5>Awesome!</h5>
          <p>You've completed the Build a Role section. You can launch your role at any point from now on by clicking this button or the one on the top bar.</p>
          <a href="#" class="btn-pvm btn-mini btn-primary role__btn-msg-ok" ng-click="gotIt=false">Got it!</a>
          <label class="role__btn-never-show">
            <input type="checkbox" ng-click="showAwesome = false"> Never show again
          </label>
          <div class="pvm-arrow-down"></div>
        </div>
        <button class="btn-pvm btn-mini btn-default role__publish-btn" ng-click="publishRole()" ng-disabled="disablePublish && !appYes" ng-class="{'role__publish-btn--on' : disablePublish == false && appYes}"><i class="fa fa-rocket"></i> Publish role</button>
        <a href="#" class="btn-pvm btn-mini btn-tertiary role__save-btn" ng-click="saveDraft()"><i class="fa fa-save"></i> Save and finish later</a>
      </span>
      <!-- <a href="#" class="btn-pvm btn-mini btn-primary role__next-btn" ng-click="checkNext()"><i class="fa fa-arrow-right"></i> next</a> -->
      <!-- <button type="submit" class="btn-pvm btn-mini btn-primary role__next-btn"><i class="fa fa-arrow-right"></i> next</button> -->
      <button type="submit" class="btn-pvm btn-mini btn-primary role__next-btn" ng-click="checkNext($scope.currentForm)"><i class="fa fa-arrow-right"></i> Next</button>
    </section>
  </form>
  @include('employer.role_creation.candidate_modal')
  <section ng-show="isitPublic == true" class="role__published" ng-show="isitPublic == true">
    <h1>Your role has been published!</h1>
    <h4>
      <i class="img__loader-gif" ng-show="!empRoleMain.job_title">
        <img src="{$BaseHref}/themes/bbt/images/preloader.gif" width="30">
      </i>
      <a href="{$BaseHref}job/search/">(@{{empRoleMain.job_title}})</a>
    </h4>
    <h5>
      Share it and let them know!
    </h5>
    <div ng-show="jobid_share">
      <a href="#" socialshare name="twitter" share-count socialshare-provider="twitter" socialshare-text="(@{{empRoleMain.job_title}})" socialshare-url="{$BaseHref}job/listing/(@{{jobid_share}})" class="fa fa-twitter-square"></a>

      <a href="#" socialshare="" name="facebook" share-count socialshare-provider="facebook" socialshare-url="{$BaseHref}job/listing/(@{{jobid_share}})" class="fa fa-facebook-square"></a>

      <a href="#" socialshare name="linkedin" share-count socialshare-provider="linkedin" socialshare-text="(@{{empRoleMain.job_title}}) @ (@{{companyDetails.company.company_name}})" socialshare-url="{$BaseHref}job/listing/(@{{jobid_share}})" class="fa fa-linkedin-square"></a>
    </div>
    <div ng-show="!jobid_share">
      <i class="img__loader-gif">
        <img src="{$BaseHref}/themes/bbt/images/preloader.gif" width="30">
      </i>
    </div>

    <!-- <a href="#" socialshare name="email" share-count socialshare-provider="email" socialshare-text="(@{{joblisting.job_title}}) @ (@{{joblisting.company_name}})" socialshare-url="{$BaseHref}job/listing/(@{{joblisting.object_id}})" class="fa fa-envelope-square"> </a> -->

    <div ng-show="jobid_share">
      <a href="{$BaseHref}employer/dashboard" class="btn-pvm btn-primary btn-mini">Go to Dashboard</a>
    </div>
  </section>
</main>

@endsection

@section('scripts')
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.min.js?ver=1.11.4"></script>
<script src="js/jquery/customFileUpload.js?ver=1"></script>
<script type="text/javascript" src="js/minified/employers/sidebar.min.js"></script>
<script type="text/javascript" src="js/minified/employers/company.roles.min.js"></script>

<script type="text/javascript" src="js/angular/angucomplete.js?ver=1.0"></script>
<script type="text/javascript" src="js/angular/sortable.min.js?ver=1.0"></script>

<script type="text/javascript" src="js/minified/employers/role-template.min.js"></script>
<script type="text/javascript" src="js/ng/employers/create-role.js"></script>
<script type="text/javascript" src="js/minified/employers/create-role--build.min.js"></script>
<script type="text/javascript" src="js/minified/employers/create-role--video.min.js"></script>
<script type="text/javascript" src="js/minified/employers/create-role--preApp.min.js"></script>
<script type="text/javascript" src="js/minified/employers/create-role--standard.min.js"></script>
<script type="text/javascript" src="js/minified/employers/create-role--team.min.js"></script>
<script type="text/javascript" src="js/minified/employers/create-role--process.min.js"></script>
<script type="text/javascript" src="js/minified/employers/create-role--notifications.min.js"></script>
<script type="text/javascript" src="js/minified/employers/create-role--integration.min.js"></script>

@endsection
