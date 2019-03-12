<h2 class="role__label role__label--full">Candidate Emails & Notifcations</h2>
<ul class="role__not-buckets-list">
  <li class="role__not-buckets-item">
    <h5 class="role__not-title" ng-click="setDisplay(1)">Email: Confirmation that application has been received - candidate is in the long list.</h5>
    <!--<a href="#" class="btn-pvm btn-mini btn-primary role__pull-btn--not">Pull from Existing</a>-->
    <i class="fa" ng-class="{'fa-caret-up' : bucketStepNot1, 'fa-caret-down' : !bucketStepNot1}" ng-click="setDisplay(1)"></i>
    <div class="role__not-note"  ng-if="bucketStepNot1">
      <p class="role__description role__not-note-msg">Candidate receives this email after submitting their application for your role.</p>
      <ul class="role__note-steps-list">
        <li class="role__note-steps-item role__note-steps-item--2">
          <i class="fa fa-envelope-o"></i>
        </li>
        <li class="role__note-steps-item role__note-steps-item--1">
          <i class="fa fa-pencil"></i>
          <hr class="role__line">
        </li>
        <li class="role__note-steps-item role__note-steps-item--1">
          <i class="fa fa-user"></i>
          <hr class="role__line">
        </li>
      </ul>
    </div>
    <h5 class="role__sublabel" ng-if="bucketStepNot1">Email subject line</h5>
    <textarea ng-if="bucketStepNot1" class="role__not-subject" ng-model="NotCandidateTempList.application_received.subject">Thank you for your application!</textarea>
    <h5 ng-if="bucketStepNot1" class="role__sublabel">Email body</h5>
    <textarea ng-if="bucketStepNot1" class="role__not-body" ng-model="NotCandidateTempList.application_received.body"></textarea>
    <p ng-if="bucketStepNot1" class="role__description role__not-note-msg-sugg">Please use the exact codes below if you wish to add the candidate's name, job title and company name .</p>
    <p ng-if="bucketStepNot1" class="role__description role__not-note-msg-sugg role__not-note-msg-sugg--2">
      <span class="bbcodes">[CandidateFirstName]</span> - for candidate's first name<br>
      <span class="bbcodes">[CandidateLastName]</span> - for candidate's last name<br>
      <span class="bbcodes">[JobTitle]</span> - for job title<br>
      <span class="bbcodes">[[CompanyName]</span> - for company name</p>
    <a href="#" ng-if="bucketStepNot1" class="btn-pvm btn-mini btn-secondary role__add-pre-app" ng-click="saveNotTemplateSettings(NotCandidateTempList.application_received, 8)">Save</a>
  </li>
  <li class="role__not-buckets-item">
    <h5 class="role__not-title" ng-click="setDisplay(2)">Email: Candidate moves OUT OF the long list to another bucket (not rejected)</h5>
    <!--<a href="#" class="btn-pvm btn-mini btn-primary role__pull-btn--not">Pull from Existing</a>-->
    <i class="fa" ng-class="{'fa-caret-up' : bucketStepNot2, 'fa-caret-down' : !bucketStepNot2}" ng-click="setDisplay(2)"></i>
    <div class="role__not-note"  ng-if="bucketStepNot2">
      <p class="role__description role__not-note-msg">Candidate receives this email after submitting their application for your role.</p>
      <ul class="role__note-steps-list">
        <li class="role__note-steps-item role__note-steps-item--2">
          <i class="fa fa-envelope-o"></i>
        </li>
        <li class="role__note-steps-item role__note-steps-item--1">
          <i class="fa fa-pencil"></i>
          <hr class="role__line">
        </li>
        <li class="role__note-steps-item role__note-steps-item--1">
          <i class="fa fa-user"></i>
          <hr class="role__line">
        </li>
      </ul>
    </div>
    <h5 class="role__sublabel" ng-if="bucketStepNot2">Email subject line</h5>
    <textarea ng-if="bucketStepNot2" class="role__not-subject" ng-model="NotCandidateTempList.long_list_to_short_list.subject">Thank you for your application!</textarea>
    <h5 ng-if="bucketStepNot2" class="role__sublabel">Email body</h5>
    <textarea ng-if="bucketStepNot2" class="role__not-body" ng-model="NotCandidateTempList.long_list_to_short_list.body"></textarea>
    <p ng-if="bucketStepNot2" class="role__description role__not-note-msg-sugg">Please use the exact codes below if you wish to add the candidate's name, job title and company name.</p>
    <p ng-if="bucketStepNot2" class="role__description role__not-note-msg-sugg role__not-note-msg-sugg--2">
      <span class="bbcodes">[CandidateFirstName]</span> - for candidate's first name<br>
      <span class="bbcodes">[CandidateLastName]</span> - for candidate's last name<br>
      <span class="bbcodes">[JobTitle]</span> - for job title<br>
      <span class="bbcodes">[CompanyName]</span> - for company name</p>
    <a href="#" ng-if="bucketStepNot2" class="btn-pvm btn-mini btn-secondary role__add-pre-app" ng-click="saveNotTemplateSettings(NotCandidateTempList.long_list_to_short_list, 10)">Save</a>
  </li>
  <li class="role__not-buckets-item">
    <h5 class="role__not-title" ng-click="setDisplay(3)">Email: Candidate moves INTO the shortlist from any other bucket.</h5>
    <!--<a href="#" class="btn-pvm btn-mini btn-primary role__pull-btn--not">Pull from Existing</a>-->
    <i class="fa" ng-class="{'fa-caret-up' : bucketStepNot3, 'fa-caret-down' : !bucketStepNot3}" ng-click="setDisplay(3)"></i>
    <div class="role__not-note"  ng-if="bucketStepNot3">
      <p class="role__description role__not-note-msg">Candidate receives this email after submitting their application for your role.</p>
      <ul class="role__note-steps-list">
        <li class="role__note-steps-item role__note-steps-item--2">
          <i class="fa fa-envelope-o"></i>
        </li>
        <li class="role__note-steps-item role__note-steps-item--1">
          <i class="fa fa-pencil"></i>
          <hr class="role__line">
        </li>
        <li class="role__note-steps-item role__note-steps-item--1">
          <i class="fa fa-user"></i>
          <hr class="role__line">
        </li>
      </ul>
    </div>
    <h5 class="role__sublabel" ng-if="bucketStepNot3">Email subject line</h5>
    <textarea ng-if="bucketStepNot3" class="role__not-subject" ng-model="NotCandidateTempList.short_list_to_interview.subject">Thank you for your application!</textarea>
    <h5 ng-if="bucketStepNot3" class="role__sublabel">Email body</h5>
    <textarea ng-if="bucketStepNot3" class="role__not-body" ng-model="NotCandidateTempList.short_list_to_interview.body"></textarea>
    <p ng-if="bucketStepNot3" class="role__description role__not-note-msg-sugg">Please use the exact codes below if you wish to add the candidate's name, job title and company name.</p>
    <p ng-if="bucketStepNot3" class="role__description role__not-note-msg-sugg role__not-note-msg-sugg--2">
      <span class="bbcodes">[CandidateFirstName]</span> - for candidate's first name<br>
      <span class="bbcodes">[CandidateLastName]</span> - for candidate's last name<br>
      <span class="bbcodes">[JobTitle]</span> - for job title<br>
      <span class="bbcodes">[CompanyName]</span> - for company name</p>
    <a href="#" ng-if="bucketStepNot3" class="btn-pvm btn-mini btn-secondary role__add-pre-app" ng-click="saveNotTemplateSettings(NotCandidateTempList.short_list_to_interview, 9)">Save</a>
  </li>
  <li class="role__not-buckets-item">
    <h5 class="role__not-title" ng-click="setDisplay(6)">Email: Candidate moves INTO the interview bucket from any other bucket.</h5>
    <!--<a href="#" class="btn-pvm btn-mini btn-primary role__pull-btn--not">Pull from Existing</a>-->
    <i class="fa" ng-class="{'fa-caret-up' : bucketStepNot6, 'fa-caret-down' : !bucketStepNot6}" ng-click="setDisplay(6)"></i>
    <div class="role__not-note"  ng-if="bucketStepNot6">
      <p class="role__description role__not-note-msg">Candidate receives this email after submitting their application for your role.</p>
      <ul class="role__note-steps-list">
        <li class="role__note-steps-item role__note-steps-item--2">
          <i class="fa fa-envelope-o"></i>
        </li>
        <li class="role__note-steps-item role__note-steps-item--1">
          <i class="fa fa-pencil"></i>
          <hr class="role__line">
        </li>
        <li class="role__note-steps-item role__note-steps-item--1">
          <i class="fa fa-user"></i>
          <hr class="role__line">
        </li>
      </ul>
    </div>

    <h5 class="role__sublabel" ng-if="bucketStepNot6">Email subject line</h5>
    <textarea ng-if="bucketStepNot6" class="role__not-subject" ng-model="NotCandidateTempList.interview_from_any.subject">Thank you for your application!</textarea>
    <h5 ng-if="bucketStepNot6" class="role__sublabel">Email body</h5>
    <textarea ng-if="bucketStepNot6" class="role__not-body" ng-model="NotCandidateTempList.interview_from_any.body"></textarea>
    <p ng-if="bucketStepNot6" class="role__description role__not-note-msg-sugg">Please use the exact codes below if you wish to add the candidate's name, job title and company name.</p>
    <p ng-if="bucketStepNot6" class="role__description role__not-note-msg-sugg role__not-note-msg-sugg--2">
      <span class="bbcodes">[CandidateFirstName]</span> - for candidate's first name<br>
      <span class="bbcodes">[CandidateLastName]</span> - for candidate's last name<br>
      <span class="bbcodes">[JobTitle]</span> - for job title<br>
      <span class="bbcodes">[CompanyName]</span> - for company name
    </p>
    <a href="#" ng-if="bucketStepNot6" class="btn-pvm btn-mini btn-secondary role__add-pre-app" ng-click="saveNotTemplateSettings(NotCandidateTempList.interview_from_any, 11)">Save</a>
  </li>
  <li class="role__not-buckets-item">
    <h5 class="role__not-title" ng-click="setDisplay(4)">Email: Candidate moves INTO the hired bucket / application successful.</h5>
    <!--<a href="#" class="btn-pvm btn-mini btn-primary role__pull-btn--not">Pull from Existing</a>-->
    <i class="fa" ng-class="{'fa-caret-up' : bucketStepNot4, 'fa-caret-down' : !bucketStepNot4}" ng-click="setDisplay(4)"></i>
    <div class="role__not-note"  ng-if="bucketStepNot4">
      <p class="role__description role__not-note-msg">Candidate receives this email after submitting their application for your role.</p>
      <ul class="role__note-steps-list">
        <li class="role__note-steps-item role__note-steps-item--2">
          <i class="fa fa-envelope-o"></i>
        </li>
        <li class="role__note-steps-item role__note-steps-item--1">
          <i class="fa fa-pencil"></i>
          <hr class="role__line">
        </li>
        <li class="role__note-steps-item role__note-steps-item--1">
          <i class="fa fa-user"></i>
          <hr class="role__line">
        </li>
      </ul>
    </div>
    <h5 class="role__sublabel" ng-if="bucketStepNot4">Email subject line</h5>
    <textarea ng-if="bucketStepNot4" class="role__not-subject" ng-model="NotCandidateTempList.successful_employed.subject">Thank you for your application!</textarea>
    <h5 ng-if="bucketStepNot4" class="role__sublabel">Email body</h5>
    <textarea ng-if="bucketStepNot4" class="role__not-body" ng-model="NotCandidateTempList.successful_employed.body"></textarea>
    <p ng-if="bucketStepNot4" class="role__description role__not-note-msg-sugg">Please use the exact codes below if you wish to add the candidate's name, job title and company name.</p>
    <p ng-if="bucketStepNot4" class="role__description role__not-note-msg-sugg role__not-note-msg-sugg--2">
      <span class="bbcodes">[CandidateFirstName]</span> - for candidate's first name<br>
      <span class="bbcodes">[CandidateLastName]</span> - for candidate's last name<br>
      <span class="bbcodes">[JobTitle]</span> - for job title<br>
      <span class="bbcodes">[CompanyName]</span> - for company name
    </p>
    <a href="#" ng-if="bucketStepNot4" class="btn-pvm btn-mini btn-secondary role__add-pre-app" ng-click="saveNotTemplateSettings(NotCandidateTempList.successful_employed, 12)">Save</a>
  </li>
  <li class="role__not-buckets-item">
    <h5 class="role__not-title" ng-click="setDisplay(5)">Email: Candidate NOT hired / NOT Successful</h5>
    <!--<a href="#" class="btn-pvm btn-mini btn-primary role__pull-btn--not">Pull from Existing</a>-->
    <i class="fa" ng-class="{'fa-caret-up' : bucketStepNot5, 'fa-caret-down' : !bucketStepNot5}" ng-click="setDisplay(5)"></i>
    <div class="role__not-note"  ng-if="bucketStepNot5">
      <p class="role__description role__not-note-msg">Successful candidates receive this email.</p>
      <ul class="role__note-steps-list">
        <li class="role__note-steps-item role__note-steps-item--2">
          <i class="fa fa-envelope-o"></i>
        </li>
        <li class="role__note-steps-item role__note-steps-item--3">
          <i class="fa fa-trash"></i>
          <hr class="role__line">
        </li>
        <li class="role__note-steps-item role__note-steps-item--1">
          <i class="fa fa-user"></i>
          <hr class="role__line">
        </li>
      </ul>
    </div>
    <h5 class="role__sublabel" ng-if="bucketStepNot5">Email subject line</h5>
    <textarea ng-if="bucketStepNot5" class="role__not-subject" ng-model="NotCandidateTempList.unsuccessful_application.subject">Thank you for your application!</textarea>
    <h5 ng-if="bucketStepNot5" class="role__sublabel">Email body</h5>
    <textarea ng-if="bucketStepNot5" class="role__not-body" ng-model="NotCandidateTempList.unsuccessful_application.body"></textarea>
    <p ng-if="bucketStepNot5" class="role__description role__not-note-msg-sugg">Please use the exact codes below if you wish to add the candidate's name, job title and company name.</p>
    <p ng-if="bucketStepNot5" class="role__description role__not-note-msg-sugg role__not-note-msg-sugg--2">
      <span class="bbcodes">[CandidateFirstName]</span> - for candidate's first name<br>
      <span class="bbcodes">[CandidateLastName]</span> - for candidate's last name<br>
      <span class="bbcodes">[JobTitle]</span> - for job title<br>
      <span class="bbcodes">[CompanyName]</span> - for company name</p>
    <a href="#" ng-if="bucketStepNot5" class="btn-pvm btn-mini btn-secondary role__add-pre-app" ng-click="saveNotTemplateSettings(NotCandidateTempList.unsuccessful_application, 13)">Save</a>
  </li>
</ul>