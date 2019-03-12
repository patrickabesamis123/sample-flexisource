<h2 class="role__label role__label--full">Admin Emails & Notifcations</h2>
<div class="role__not-box role__not-box--lined">
  <span class="role__sublabel">Notifications</span>
  <label class="pvm-switch pvm-switch--lg-labeled">
    <input type="checkbox" id="" ng-model="NotAdminList.is_enabled">
    <span class="pvm-slider round"></span>
  </label>
</div>
<h5 class="role__not-title">Include emails about</h5>
<!--<div class="role__not-box">
  <span class="role__sublabel">Candidate Applications</span>
  <label class="pvm-switch pvm-switch--lg-labeled">
    <input type="checkbox" id="" ng-model="NotAdminList.candidate_applications_enabled">
    <span class="pvm-slider round"></span>
  </label>
  <select ng-model="candApp" ng-options="NotTimeframe as NotTimeframe.label for NotTimeframe in NotTimeframes track by NotTimeframe.value" class="pvm-select role__not-sel"></select>
</div>-->
<div class="role__not-box">
  <span class="role__sublabel">New candidates coming in</span>
  <label class="pvm-switch pvm-switch--lg-labeled">
    <input type="checkbox" id="" ng-model="NotAdminList.new_candidates_coming_in_enabled">
    <span class="pvm-slider round"></span>
  </label>
  <select ng-model="candComing" ng-options="NotTimeframe as NotTimeframe.label for NotTimeframe in NotTimeframes track by NotTimeframe.value" class="pvm-select role__not-sel"></select>
</div>
<div class="role__not-box">
  <span class="role__sublabel">Role expiry warning</span>
  <label class="pvm-switch pvm-switch--lg-labeled">
    <input type="checkbox" id="" ng-model="NotAdminList.role_expiry_warning">
    <span class="pvm-slider round"></span>
  </label>
</div>
<div class="role__not-box">
  <span class="role__sublabel">Role has expired from public</span>
  <label class="pvm-switch pvm-switch--lg-labeled">
    <input type="checkbox" id="" ng-model="NotAdminList.role_expired_from_public">
    <span class="pvm-slider round"></span>
  </label>
</div>
<div class="role__not-box">
  <span class="role__sublabel">Analytics available</span>
  <label class="pvm-switch pvm-switch--lg-labeled">
    <input type="checkbox" id="" ng-model="NotAdminList.analytics_available">
    <span class="pvm-slider round"></span>
  </label>
</div>
<div class="role__not-box">
  <span class="role__sublabel">Processing expiry warning</span>
  <label class="pvm-switch pvm-switch--lg-labeled">
    <input type="checkbox" id="" ng-model="NotAdminList.processing_expiry_warning">
    <span class="pvm-slider round"></span>
  </label>
</div>
<div class="role__not-box">
  <span class="role__sublabel">Processing has expired</span>
  <label class="pvm-switch pvm-switch--lg-labeled">
    <input type="checkbox" id="" ng-model="NotAdminList.processing_has_expired">
    <span class="pvm-slider round"></span>
  </label>
</div>
<div class="role__not-box">
  <span class="role__sublabel">Final Analytics available</span>
  <label class="pvm-switch pvm-switch--lg-labeled">
    <input type="checkbox" id="" ng-model="NotAdminList.final_analytics_available">
    <span class="pvm-slider round"></span>
  </label>
</div>