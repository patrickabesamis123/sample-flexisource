<h2 class="role__label">Application Requirements</h2>
<div class="clearfix"></div>
<ul class="role__requirements-list">
  <div class="role__requirements-error-div" ng-hide="validated">Please choose at least one of the Application Requirements listed.</div>
  <li class="role__requirements-item">
    <h5 class="role__sublabel">Requirements for application:
      <i class="fa fa-question pvm-tooltip" data-toggle="tooltip" data-placement="right" title="Profile Application Requirements (data + video) goes beyond capturing the generic information ordinarily found in a CV. This content updates in real time as the candidates career develops so you always have your finger on the pulse and the most current data."></i>
    </h5>

    <ul class="role__required-app-list">
      <li class="role__required-app-item">
        <label class="role__requirement">
          <input type="checkbox" ng-model="roleCreate_watch.application_requirements.about_me" ng-true-value="'yes'" ng-false-value="'no'"  ng-click="updateInfo()"> About me
        </label>
      </li>
      <li class="role__required-app-item">
        <label class="role__requirement">
          <input type="checkbox" ng-model="roleCreate_watch.application_requirements.work_experience" ng-true-value="'yes'" ng-false-value="'no'"  ng-click="updateInfo()"> Work Experience
        </label>
      </li>
      <li class="role__required-app-item">
        <label class="role__requirement">
          <input type="checkbox" ng-model="roleCreate_watch.application_requirements.education" ng-true-value="'yes'" ng-false-value="'no'"  ng-click="updateInfo()"> Education
        </label>
      </li>
      <li class="role__required-app-item">
        <label class="role__requirement">
          <input type="checkbox" ng-model="roleCreate_watch.application_requirements.references" ng-true-value="'yes'" ng-false-value="'no'"  ng-click="updateInfo()"> References
        </label>
      </li>
      <li class="role__required-app-item">
        <label class="role__requirement">
          <input type="checkbox" ng-model="roleCreate_watch.application_requirements.icebreaker_video" ng-true-value="'yes'" ng-false-value="'no'" ng-click="updateInfo()"> Profile video
        </label>
      </li>
    </ul>
  </li>
  <li class="role__requirements-item">
    <h5 class="role__sublabel">Required Documents:
      <i class="fa fa-question pvm-tooltip" data-toggle="tooltip" data-placement="right" title=" The documents you select are saved into your PreviewMe account as part of the candidate's application for you to draw on at time."></i>
    </h5>
    <ul class="role__required-app-list">
      <li class="role__required-app-item">
        <label class="role__requirement">
          <input type="checkbox" ng-model="roleCreate_watch.application_requirements.resume" ng-true-value="'yes'" ng-false-value="'no'"  ng-click="updateInfo()"> Resume / CV
        </label>
      </li>
      <li class="role__required-app-item">
        <label class="role__requirement">
          <input type="checkbox" ng-model="roleCreate_watch.application_requirements.cover_letter" ng-true-value="'yes'" ng-false-value="'no'"  ng-click="updateInfo()"> Cover Letter
        </label>
      </li>
      <li class="role__required-app-item">
        <label class="role__requirement">
          <input type="checkbox" ng-model="roleCreate_watch.application_requirements.portfolio" ng-true-value="'yes'" ng-false-value="'no'"  ng-click="updateInfo()"> Portfolio
          <textarea class="role__req-text"></textarea>
        </label>
      </li>
      <li class="role__required-app-item">
        <label class="role__requirement">
          <input type="checkbox" ng-model="roleCreate_watch.application_requirements.transcript" ng-true-value="'yes'" ng-false-value="'no'"  ng-click="updateInfo()"> Transcript
        </label>
      </li>
    </ul>
  </li>
</ul>