<div class="preview__handler preview__handler--email" ng-if="createEmailNot && createEmailNotAdmin">
    <img src="@{{companyDetails.logo_url}}" class="preview__logo-center">
    <p class="preview__email-body"  ng-bind-html="adminDaily.template"></p>
</div>

<div class="preview__handler preview__handler--email" ng-if="createEmailNot && createEmailNotCan">
    <img src="@{{companyDetails.logo_url}}" class="preview__logo-center">
    <h3 class="preview__email-subj" ng-if="displayEmail1">@{{NotCandidateTempList.application_received.subject}}</h3>
    <p class="preview__email-body" ng-if="displayEmail1" ng-bind-html="appReceivedSubj"></p>
    <h3 class="preview__email-subj" ng-if="displayEmail2">@{{NotCandidateTempList.long_list_to_short_list.subject}}</h3>
    <p class="preview__email-body" ng-if="displayEmail2" ng-bind-html="appLonglistSubj"></p>
    <h3 class="preview__email-subj" ng-if="displayEmail3">@{{NotCandidateTempList.short_list_to_interview.subject}}</h3>
    <p class="preview__email-body" ng-if="displayEmail3" ng-bind-html="appShortSubj"></p>
    <h3 class="preview__email-subj" ng-if="displayEmail4">@{{NotCandidateTempList.successful_employed.subject}}</h3>
    <p class="preview__email-body" ng-if="displayEmail4" ng-bind-html="appSuccessSubj"></p>
    <h3 class="preview__email-subj" ng-if="displayEmail5">@{{NotCandidateTempList.unsuccessful_application.subject}}</h3>
    <p class="preview__email-body" ng-if="displayEmail5" ng-bind-html="appUnsuccessSubj"></p>
    <h3 class="preview__email-subj" ng-if="displayEmail6">@{{NotCandidateTempList.interview_from_any.subject}}</h3>
    <p class="preview__email-body" ng-if="displayEmail6" ng-bind-html="appInterviewSubj"></p>
    <!--<h3 class="preview__email-subj">Your sincerely,</h3>
    <h3 class="preview__email-subj">@{{companyDetails.company_name}}</h3>-->
</div>
<img src="{$BaseHref}/themes/bbt/images/email-bg.png" width="100%">