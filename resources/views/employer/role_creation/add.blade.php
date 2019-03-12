@extends('layouts.employer')

@section('styles')
<link href="css/angucomplete.css?ver=1" rel="stylesheet">
@endsection

@section('content')

<main id="" class="emp-role-template clear-float" ng-controller="EmployerRoleTemplate">
    <section class="new-role__how clear-float" ng-cloak>
      <h1 class="new-role__how-title">How would you like to create your role?</h1>
      <div class="new-role__btn-handler flexbox-c">
        <a href="" class="btn-pvm btn-med btn-primary new-role__blank-btn" id="createRoleNameBtn"><i class="fa fa-file-o"></i>Create a new role</a>
        <a href="" class="btn-pvm btn-tertiary btn-med new-role__existing-btn" ng-click="shiftTemplate()">
          <i class="fa fa-folder-open"></i>
          <span ng-if="!companyTemplateOn">Choose from an existing role</span>
          <span ng-if="companyTemplateOn">Choose from PreviewMe template</span>
        </a>
      </div>
    </section>
    <section class="new-role__drafts" ng-if="!companyTemplateOn">
      <h2 class="new-role__label">Your Drafts</h2>
      <ul class="new-role__template-list grid4">
        <li class="img__loader-gif hidden" ng-show="!drafts">
          <img src="/images/preloader.gif" class="" width="30">
          <h4>Loading drafts</h4>
        </li>
        <li class="new-role__template-item new-role__template-item--draft" ng-repeat="draft in drafts | orderBy: '-date_created'">
          <h1 class="new-role__title">(@{{draft.job_title ? draft.job_title : 'Job title not found'}})</h1>
          <h2 class="new-role__sub-title">(@{{draft.industry_name}})</h2>
          <p class="new-role__desc">(@{{draft.job_description ? draft.job_description : 'No job description specified.' | ellipsis:160}})</p>
          <p class="new-role__sub-desc">Created on <span class="new-role__highlight">(@{{draft.created_on}})</span></p>
          <a href="#" class="btn-pvm btn-primary new-role__draft-con" ng-click="proceedToRoleCreation(draft.job_id)">Continue</a>
          <a href="#" class="new-role__delete" ng-click="deleteDraft(draft)"><i class="fa fa-trash"></i></a>
          <!--<span class="newrole__draft-label">Draft</span>-->
        </li>
      </ul>
      <!-- <a href="#" class="new-role__see-more">See more...</a> -->
      <p class="new-role__desc new-role__desc--center">
        Number of records: (@{{main_draft.total_records_in_current_page}}) out of (@{{main_draft.total_records}})
      </p>
      <div class="new-role__see-more">
        <span ng-click="movePage('p')" style="cursor: pointer;"><i class="fa fa-chevron-left"></i></span> <!-- previous -->
        <span> Page (@{{main_draft.current_page}}) </span>
        <span ng-click="movePage('n')" style="cursor: pointer;"><i class="fa fa-chevron-right"></i></span> <!-- next -->
      </div>
    </section>
    <section class="new-role__library">
      <h2 class="new-role__label new-role__label--center" ng-if="!companyTemplateOn">Or search our library</h2>
      <h2 class="new-role__label new-role__label--center" ng-if="companyTemplateOn">Your template library</h2>
      <div class="new-role__search-lib-con clear-float">
        <input type="text" class="pvm-input-text new-role__search-lib" ng-model="searchPvmTemplates.q" ng-enter="searchLibTemplate()">
        <a href="javascript::void()" class="btn-pvm btn-primary btn-square" ng-click="searchLibTemplate()"><i class="fa fa-search"></i></a>
      </div>
      <div class="new-role__left-nav pvm-tablet-land-invisible">
        <a href="#" class="new-role__class-link" ng-click="sortF('class')">Classifications<i class="fa" ng-class="{'fa-caret-up' : classMe, 'fa-caret-down' : !classMe}"></i></a>
        <a href="#" class="new-role__sort-link" ng-click="sortF('sort')">Sort<i class="fa" ng-class="{'fa-caret-up' : sortMe, 'fa-caret-down' : !sortMe}"></i></a>
        <div class="new-role__sort-box" ng-class="{'new-role__sort-box--class': classMe == true}" ng-if="sortMe || classMe">
          <ul class="new-role__sort-list" ng-if="sortMe">
            <li class="new-role__sort-item" ng-click="sortChange('all')" ng-class="{'new-role__sort-item--all' : sortCollection == 'all'}">All (100)</li>
            <li class="new-role__sort-item" ng-click="sortChange('popular')" ng-class="{'new-role__sort-item--all' : sortCollection == 'popular'}">Most popular</li>
            <li class="new-role__sort-item" ng-click="sortChange('newest')" ng-class="{'new-role__sort-item--all' : sortCollection == 'newest'}">Newest to oldest</li>
            <li class="new-role__sort-item" ng-click="sortChange('oldest')" ng-class="{'new-role__sort-item--all' : sortCollection == 'oldest'}">Oldest to newest</li>
            <li class="new-role__sort-item" ng-click="sortChange('alphabetical')" ng-class="{'new-role__sort-item--all' : sortCollection == 'alphabetical'}">Alphabetical</li>
          </ul>
          <ul class="new-role__sort-list" ng-if="classMe">
            <li class="new-role__sort-item new-role__sort-item--all">All (100)</li>
            <li class="new-role__sort-item">Classification 1 (10)</li>
            <li class="new-role__sort-item">Classification 2 (10)</li>
            <li class="new-role__sort-item">Classification 3 (10)</li>
          </ul>
        </div>
      </div>
      <div class="new-role__left-nav pvm-tablet-land-visible">
        <div class="new-role__sort-box">
          <h4 class="new-role__sub-label">Sort</h4>
          <ul class="new-role__sort-list">
            <li class="new-role__sort-item" ng-click="sortChange('all')" ng-class="{'new-role__sort-item--all' : sortCollection == 'all'}">All (100)</li>
            <li class="new-role__sort-item" ng-click="sortChange('popular')" ng-class="{'new-role__sort-item--all' : sortCollection == 'popular'}">Most popular</li>
            <li class="new-role__sort-item" ng-click="sortChange('newest')" ng-class="{'new-role__sort-item--all' : sortCollection == 'newest'}">Newest to oldest</li>
            <li class="new-role__sort-item" ng-click="sortChange('oldest')" ng-class="{'new-role__sort-item--all' : sortCollection == 'oldest'}">Oldest to newest</li>
            <li class="new-role__sort-item" ng-click="sortChange('alphabetical')" ng-class="{'new-role__sort-item--all' : sortCollection == 'alphabetical'}">Alphabetical</li>
          </ul>
          <h4 class="new-role__sub-label">Classifications</h4>
          <ul class="new-role__sort-list">
            <!-- <li class="new-role__sort-item new-role__sort-item--all">All (100)</li> -->
            <li class="new-role__sort-item" ng-repeat="ind in filterclassifications.industries" ng-click="classificationChange(ind.parent_industry_id)"
              ng-class="{'new-role__sort-item--all' : filterInd == ind.parent_industry_id}">(@{{ind.parent_industry_name}}) ((@{{ind.total}}))</li>
            <!-- <li class="new-role__sort-item">Classification 2 (10)</li>
            <li class="new-role__sort-item">Classification 3 (10)</li> -->
          </ul>
        </div>
      </div>
      <div class="new-role__library-box">
        <ul class="new-role__template-list new-role__template-list--avail grid3">
          <li class="img__loader-gif" ng-show="!jobTemplates">
            <img src="/images/preloader.gif" class="" width="30">
            <h4>Loading templates..</h4>
          </li>
          <li class="new-role__template-item" ng-repeat="templates in jobTemplates.records">
            <h1 class="new-role__title">(@{{templates.template_name}})</h1>
            <h2 class="new-role__sub-title">(@{{templates.parent_industry_name}})</h2>
              <p class="new-role__desc">(@{{templates.description ? templates.description : 'No description specified.' | ellipsis:160}})</p>
              <!--<p class="new-role__sub-desc" ng-if="!companyTemplateOn">Used <span class="new-role__highlight">(@{{templates.counter ? template.counter : 0}})</span> times</p>-->
              <p class="new-role__sub-desc" ng-if="!companyTemplateOn">
                Pre-application Questions <span class="new-role__highlight">(@{{templates.pre_approval_questions}})</span><br>
                Standard Questions <span class="new-role__warn">(@{{templates.standard_questions}})</span>
              </p>
              <p class="new-role__sub-desc" ng-if="companyTemplateOn">
                Created on <span class="new-role__highlight">(@{{templates.created_on}})</span><br>
                Created by <span class="new-role__highlight">(@{{templates.created_by}})</span>
              </p>
              <div class="btn-pvm-wrap">
                  <a href="" class="btn-pvm btn-primary btn-med new-role__use-btn" ng-click="showTempDetails(templates)">Use</a>
                  <!-- <a href="#" class="btn-pvm btn-secondary btn-med new-role__see-btn">See more</a> -->
                  <a href="" class="btn-pvm btn-secondary btn-med new-role__see-btn" ng-click="showModal(templates)">See more</a>
              </div>
          </li>
        </ul>
      </div>
    </section>
    <div class="modal fade modal_btn" id="CreateRoleModal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-body clear-float">
            <h4 class="new-role__modal-title">What's the name of the role?</h4>
            <input type="text" class="pvm-input-text new-role__name-text" ng-model="roleName">
            <a href="{{ url('employer/role-creation/add/employee') }}" class="btn-pvm btn-secondary btn-med" ng-click="saveRoleName()">Let's go!</a> 
          </div>
        </div>
      </div>
    </div>
    <!-- Modal Role Desc BEGIN -->
    <!-- <script type="text/ng-template" id="modal.html"> -->
    <div class="modal fade modal_btn new-role__template-modal" id="seeMoreRoleModal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-body modal-body--header">
            <h4 class="new-role__modal-title">(@{{modaldetails.job_title}})</h4>
          </div>
          <div class="modal-body">
            <ul class="new-role__temp-details-list">
              <li class="new-role__temp-details-item active" ng-class="{'active' : RDOverview}" ng-click="roleDetailsTab('Overview')">Overview</li>
              <li class="new-role__temp-details-item" ng-class="{'active' : RDResp}" ng-click="roleDetailsTab('Resp')">Role Responsibilities</li>
              <li class="new-role__temp-details-item" ng-class="{'active' : RDReq}" ng-click="roleDetailsTab('Req')">Role Requirements</li>
              <li class="new-role__temp-details-item" ng-class="{'active' : RDAppResp}" ng-click="roleDetailsTab('AppResp')">Application Content Requirements</li>
              <li class="new-role__temp-details-item" ng-class="{'active' : RDPreQ}" ng-click="roleDetailsTab('PreQ')">Pre-Application</li>
              <li class="new-role__temp-details-item new-role__temp-details-item--gray" ng-class="{'active' : RDStandard}">Standard Questions</li>
            </ul>
            <div class="new-role__left-pane">
              <p class="new-role__desc new-role__desc--up">Classification</p>
              <h1 class="new-role__title new-role__title--modal">(@{{modaldetails.industry.data.industry.display_name}})</h1>
              <p class="new-role__desc new-role__desc--up">Sub-Classification</p>
              <h1 class="new-role__title new-role__title--modal">(@{{modaldetails.industry.data.sub.display_name}})</h1>
              <p class="new-role__desc">(@{{modaldetails.job_brief}})</p>
              <a href="#" class="btn-pvm btn-secondary btn-mini new-role__use-modal-btn" ng-click="useTemplate(activetemplate.template_data)">Use this template</a> <!-- ng-click -->
              <p class="new-role__desc new-role__desc--up">Created on</p>
              <p class="new-role__desc new-role__desc--up new-role__highlight">(@{{activetemplate.recorded_date | date:'medium'}})</p>
              <p class="new-role__desc new-role__desc--up">Created by</p>
              <p class="new-role__desc new-role__desc--up new-role__highlight">(@{{activetemplate.created_by}})</p>
            </div>
            <div class="new-role__right-pane" ng-if="RDOverview">
              <img src="/images/default-banner.png" class="pvm-img">
              <div class="new-role__modal-ins">
                <h4 class="new-role__title">Overview</h4>
                <p class="new-role__desc" ng-bind-html="temp_job_desc"></p>
              </div>
            </div>
            <div class="new-role__right-pane" ng-if="RDResp">
              <div class="new-role__modal-ins">
                <h4 class="new-role__title">Responsibilities</h4>
                <ul class="new-role__det-list" ng-repeat="responsibility in modaldetails.accountabilities">
                  <li class="new-role__det-item">
                    <i class="fa fa-check"></i>
                    <span class="new-role__checklist-desc">(@{{responsibility.name}})</span>
                  </li>
                </ul>
              </div>
            </div>
            <div class="new-role__right-pane" ng-if="RDReq">
              <div class="new-role__modal-ins">
                <h4 class="new-role__title">Requirements</h4>
                <ul class="new-role__det-list">
                  <li class="new-role__det-item" ng-repeat="req in modaldetails.requirements">
                    <i class="fa fa-check"></i>
                    <span class="new-role__checklist-desc">(@{{req.name}})</span>
                  </li>
                </ul>
              </div>
            </div>
            <div class="new-role__right-pane" ng-if="RDAppResp">
              <div class="new-role__modal-ins">
                <h4 class="new-role__title">Application Content Requirements</h4>
                <!-- <p class="new-role__desc">Candidates wishing to apply for this role must submit:</p> -->
                <p class="new-role__desc">When building the role you can require any of the content below to be submitted as part of the candidate's application
                  <i class="fa fa-question pvm-tooltip" data-toggle="tooltip" data-placement="right" title="when selecting the Application Content Requirements, think about the role you are recruiting for and ensure the requirements are 'role appropriate'. For example, more often than not you will be able to recruit without a CV."></i>
                </p>
                <ul class="new-role__det-list new-role__det-list--req">
                  <li>Profile Application Requirements</li>
                  <li class="new-role__det-item">
                    <i class="fa fa-check"></i>
                    <!-- <i class="fa fa-close" ng-if="modaldetails.application_requirements.icebreaker_video != 'yes'"></i> -->
                    <span>Profile Video</span>
                  </li>
                  <li class="new-role__det-item">
                    <i class="fa fa-check"></i>
                    <!-- <i class="fa fa-close" ng-if="modaldetails.application_requirements.about_me != 'yes'"></i> -->
                    <span>About me</span>
                  </li>
                  <li class="new-role__det-item">
                    <i class="fa fa-check"></i>
                    <!-- <i class="fa fa-close" ng-if="modaldetails.application_requirements.work_experience != 'yes'"></i> -->
                    <span>Work History</span>
                  </li>
                  <li class="new-role__det-item">
                    <i class="fa fa-check"></i>
                    <!-- <i class="fa fa-close" ng-if="modaldetails.application_requirements.education != 'yes'"></i> -->
                    <span>Education</span>
                  </li>
                  <li class="new-role__det-item">
                    <i class="fa fa-check"></i>
                    <!-- <i class="fa fa-close" ng-if="modaldetails.application_requirements.language != 'yes'"></i> -->
                    <span>Languages</span>
                  </li>
                  <li class="new-role__det-item">
                    <i class="fa fa-check"></i>
                    <!-- <i class="fa fa-close" ng-if="modaldetails.application_requirements.references != 'yes'"></i> -->
                    <span>References</span>
                  </li>
                </ul>
  
                <ul class="new-role__det-list new-role__det-list--req">
                  <li>Documents Required</li>
                  <li class="new-role__det-item">
                    <i class="fa fa-check"></i>
                    <!-- <i class="fa fa-close" ng-if="modaldetails.application_requirements.resume != 'yes'"></i> -->
                    <span>Resume / CV</span>
                  </li>
                  <li class="new-role__det-item">
                    <i class="fa fa-check"></i>
                    <!-- <i class="fa fa-close" ng-if="modaldetails.application_requirements.cover_letter != 'yes'"></i> -->
                    <span>Cover letter</span>
                  </li>
                  <li class="new-role__det-item">
                    <i class="fa fa-check"></i>
                    <!-- <i class="fa fa-close" ng-if="modaldetails.application_requirements.supp != 'yes'"></i> -->
                    <span>Supporting Docs</span>
                  </li>
                  <li class="new-role__det-item">
                    <i class="fa fa-check"></i>
                    <!-- <i class="fa fa-close" ng-if="modaldetails.application_requirements.transcript != 'yes'"></i> -->
                    <span>Transcript</span>
                  </li>
                </ul>
              </div>
            </div>
            <div class="new-role__right-pane" ng-if="RDPreQ">
              <div class="new-role__modal-ins">
                <h4 class="new-role__title">Pre-application Questions</h4>
                <!-- <p class="new-role__desc"> These are the questions that have been set for candidates to answer in order to proceed with their application</p> -->
                <p class="new-role__desc"> We have a range of pre-application questions for you to choose from for this role. You can modify or remove these questions and / or create your own. You can also set the answers you will accept and set whether the wrong answer disqualifies the candidate from progressing into your recruitment pipeline.</p>
                <ul class="new-role__det-list" ng-repeat="preapp in modaldetails.questions.pre_apply">
                  <li class="new-role__det-item">
                    <i class="fa fa-check"></i>
                    <span class="new-role__checklist-desc">(@{{preapp.question}})</span>
                  </li>
                </ul>
              </div>
            </div>
            <div class="new-role__right-pane" ng-if="RDStandard">
              <div class="new-role__modal-ins">
                <h4 class="new-role__title">Standard Questions</h4>
                <p class="new-role__desc"> These are the questions that have been set for candidates to answer in order to proceed with their application</p>
                <table class="new-role__pre-app-table">
                  <thead></thead>
                  <tbody>
                    <tr class="new-role__pre-app-list" ng-repeat="stan in modaldetails.questions.application">
                      <td class="new-role__pre-app-item">
                        <span class="new-role__table-label pvm-phone-land-invisible">Questions</span>
                        <span class="new-role__table-desc">(@{{stan.question}})</span>
                        <span class="new-role__table-label new-role__table-label--half pvm-phone-land-invisible">Required Answer</span>
                        <span class="new-role__table-desc new-role__table-desc--half">Test</span>
                        <span class="new-role__table-label new-role__table-label--half pvm-phone-land-invisible">Disqualify if not match?</span>
                        <span class="new-role__table-desc new-role__table-desc--half"><i class="fa fa-check"></i></span>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  
    <!-- </script> -->
    <!-- Modal Role Desc END -->
  </main>

@endsection

@section('scripts')
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
