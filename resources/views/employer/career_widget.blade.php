<section class="emp-set-js-int clear-float" ng-controller="WebWidgetCtrl">
  <h3 class="js-int__title">Career Widget</h3>
  <div class="js-int__con">
    <p class="js-int__enable-js" ng-show="account_type_string == 'Company Admin' && !pvmEnableJSI">
      <span>Enable Career Widget</span>
      <label class="pvm-switch pvm-switch--lg-labeled" title="Enable Career Widget">
        <input type="checkbox" ng-model="pvmEnableJSI" ng-checked="pvmEnableJSI">
        <span class="pvm-slider round"></span>
      </label>
    </p>
    <p class="js-int__enable-js" ng-show="!pvmEnableJSIReq && pvmEnableJSI">
      Your Career Widget is currently enabled. If you want to disable this feature please email us at support@previewme.co
    </p>
    <p class="js-int__enable-js" ng-show="pvmEnableJSIReq && pvmEnableJSI">
      Your Career Widget is currently under request. If you want to disable this feature please email us at support@previewme.co
    </p>
    <p class="js-int__enable-js" ng-show="account_type_string == 'Company Member' && pvmEmail && !pvmEnableJSI">
      An email to admin has been requested to enable this feature.
    </p>
  </div>
  <div class="js-int__con--no-access" ng-if="account_type_string == 'Company Member' && !pvmEnableJSI">
    <i class="fa fa-lock"></i>
    <p class="js-int__no-access-msg">You must request a Company Admin to enable this feature.</p>
    <a href="" class="js-int__req-access-btn btn-pvm btn-primary btn-mini" ng-if="!pvmEmail" ng-click="requestMyJS()">Request access to Career Widget</a>
    <span class="js-int__req-access-btn btn-pvm btn-default btn-mini" ng-if="pvmEmail">Request submitted</span>
  </div>
  <div class="js-int__editor-con clear-float" ng-show="pvmEnableJSI && !pvmEnableJSIReq && account_type_string == 'Company Admin'">
    <section class="js-int__layout-attr">
      <h4 class="js-int__editor-title">Layout Editor</h4>
      <h3 class="js-int__editor-title js-int__editor-title--sub">Column</h3>
      <select ng-model="pvmEnableCol" ng-options="column.label for column in myColumn track by column.value" class="pvm-select js-int__column"></select>
      <p class="js-int__editor-desc clear-float">
        <span class="js-int__editor-title js-int__editor-title--sub">Logo</span>
        <label class="pvm-switch pvm-switch--lg-labeled" title="Enable Career Widget">
          <input type="checkbox" id="pvmEnableLogo" ng-model="pvmEnableLogo" ng-checked="pvmEnableLogojs">
          <span class="pvm-slider round"></span>
        </label>
      </p>
      <p class="js-int__editor-desc">
        <span class="js-int__editor-title js-int__editor-title--sub">Video</span>
        <label class="pvm-switch pvm-switch--lg-labeled" title="Enable Career Widget">
          <input type="checkbox" id="pvmEnableVid" ng-model="pvmEnableVid" ng-checked="pvmEnableVidjs">
          <span class="pvm-slider round"></span>
        </label>
      </p>
      <h4 class="js-int__editor-title js-int__editor-title--sub">Grouping</h4>
      <ul class="js-int__grouping-list">
        <li class="js-int__grouping-item clear-float">
          <div class="js-int__group-desc-con js-int__group-desc-con--sm">
            <label class="pvm-radio-design">
              <input type="radio" class="pvm-radio" ng-model="groupJobItem" name="groupJobItem" id="groupJobItem" value="none">
              <span class="pvm-radio-holder"></span>
            </label>
          </div>
          <div class="js-int__group-desc-con">
            <h5 class="js-int__group-label">None</h5>
            <p class="js-int__group-desc">Simple option that lets you show a list of your job openings.</p>
          </div>
        </li>
        <li class="js-int__grouping-item clear-float">
          <div class="js-int__group-desc-con js-int__group-desc-con--sm">
            <label class="pvm-radio-design">
              <input type="radio" class="pvm-radio" ng-model="groupJobItem" name="groupJobItem" id="groupJobItem" value="location">
              <span class="pvm-radio-holder"></span>
            </label>
          </div>
          <div class="js-int__group-desc-con">
            <h5 class="js-int__group-label">By Location</h5>
            <p class="js-int__group-desc">Have job openings in different locations? List them accordingly.</p>
          </div>
        </li>
        <li class="js-int__grouping-item clear-float">
          <div class="js-int__group-desc-con js-int__group-desc-con--sm">
            <label class="pvm-radio-design">
              <input type="radio" class="pvm-radio" ng-model="groupJobItem" name="groupJobItem" id="groupJobItem" value="department">
              <span class="pvm-radio-holder"></span>
            </label>
          </div>
          <div class="js-int__group-desc-con">
            <h5 class="js-int__group-label">By Department</h5>
            <p class="js-int__group-desc">If you have openings in several departments this option will help guide candidates to the right place.</p>
          </div>
        </li>
      </ul>
      <h4 class="js-int__editor-title js-int__editor-title--sub">Job Title</h4>
      <select ng-model="jobTitleFontFam" id="jobTitleFontFam" ng-options="font.family for font in myFonts track by font.file" class="pvm-select js-int__font-fam"></select>
      <select ng-model="jobTitleFontSize" id="jobTitleFontSize" ng-options="item for item in fontSize" class="pvm-select js-int__font-size"></select>
      <input type="text" class="js-int__color-picker js-int__color-picker--title">
      <input type="text" class="js-int__color-picker-val" id="jobTitleColor" ng-model="jobTitleColor">
      <h4 class="js-int__editor-title js-int__editor-title--sub">Job Description</h4>
      <label class="pvm-switch pvm-switch--lg-labeled" title="Enable Career Widget">
        <input type="checkbox" id="pvmEnableDesc" ng-model="pvmEnableDesc" ng-checked="pvmEnableDescjs">
        <span class="pvm-slider round"></span>
      </label>
      <select ng-model="jobDescFontFam" id="jobDescFontFam" ng-options="font.family for font in myFonts track by font.file" class="pvm-select js-int__font-fam"></select>
      <select ng-model="jobDescFontSize" id="jobDescFontSize" ng-options="item for item in fontSize" class="pvm-select js-int__font-size"></select>
      <input type="text" class="js-int__color-picker js-int__color-picker--desc">
      <input type="text" class="js-int__color-picker-val" id="jobDescColor" ng-model="jobDescColor">
    </section>
    <section class="js-int__preview-con">
      <h4 class="js-int__editor-title js-int__editor-title--sub">Preview</h4>
      <p class="js-int__disclaimer">The PrevieMe job listing web widget depends on the container size of HTML element on your site (where you will be embedding the generated code below). The container size of this preview is <span id="whatismysize"></span>px wide.</p>
      <div class="js-int__preview-handler"></div>
    </section>
  </div>
  <div class="js-int__embed-con" ng-show="pvmEnableJSI && !pvmEnableJSIReq && account_type_string == 'Company Admin'">
    <h3 class="js-int__embed-title">Ready to embed? Get the code</h3>
    <textarea class="js-int__embed-code-area" id="pvmEmbedJSCode"></textarea>
  </div>
</section>