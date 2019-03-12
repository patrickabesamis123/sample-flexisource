<!-- TAB 2 - COMUNICATION SETTINGS -->
<article class="pvm-tab-page pvm-fadein pvm-animated cleafix" ng-if="tab2">
    <h1 class="pvm__header settings__header">Emails & Messages</h1>

    <!-- DIRECT MESSAGES -->
    <div class="pvm-setting-item clear-float">
        <span class="pvm-setting-label pvm-setting-label--comm">Do you want to be emailed by PreviewMe when you receive
            direct messages from employers?</span>
        <div class="pvm-setting-switch-container">
            <label class="pvm-switch pvm-switch--lg-labeled pvm-switch--float-right">
                <input type="checkbox" id="" ng-model="communicationSettingData.email_settings.direct_messages" ng-checked="communicationSettingData.email_settings.direct_messages">
                <span class="pvm-slider round"></span>
            </label>
            <span class="pvm-switch-label" ng-if="communicationSettingData.email_settings.direct_messages">Enabled</span>
            <span class="pvm-switch-label" ng-if="!communicationSettingData.email_settings.direct_messages">Disabled</span>
        </div>
    </div>
    <!-- END OF DIRECT MESSAGES -->

    <!-- PROFILE METRICS -->
    <div class="pvm-setting-item clear-float">
        <span class="pvm-setting-label pvm-setting-label--comm">Do you want to be emailed by PreviewMe about new roles
            and opportunities based on your Profile metrics?</span>
        <div class="pvm-setting-switch-container clear-float">
            <label class="pvm-switch pvm-switch--lg-labeled pvm-switch--float-right">
                <input type="checkbox" id="" ng-model="communicationSettingData.email_settings.profile_metrics" ng-checked="communicationSettingData.email_settings.profile_metrics">
                <span class="pvm-slider round"></span>
            </label>
            <span class="pvm-switch-label" ng-if="communicationSettingData.email_settings.profile_metrics">Enabled</span>
            <span class="pvm-switch-label" ng-if="!communicationSettingData.email_settings.profile_metrics">Disabled</span>
        </div>
        <div class="pvm-setting-frequency-select pvm-animated pvm-fadein" ng-if="communicationSettingData.email_settings.profile_metrics">
            <span class="frequency-label">Frequency:</span>
            <select class="pvm-select role__not-sel pvm-select--float-left  ng-pristine ng-untouched ng-valid ng-not-empty" ng-model="communicationSettingData.email_settings.profile_metrics_frequency">
                <option label="When published" value="when_published">When published</option>
                <option label="Weekly" value="weekly" selected="selected">Weekly</option>
                <option label="Fortnightly" value="fortnightly">Fortnightly</option>
                <option label="Monthly" value="monthly">Monthly</option>
            </select>
        </div>
    </div>
    <!-- END OF PROFILE METRICS -->

    <!-- NEWS LETTERS -->
    <div class="pvm-setting-item clear-float">
        <span class="pvm-setting-label pvm-setting-label--comm">Do you want to be emailed by PreviewMe about updates,
            messages and newsletters specific to PreviewMe? <br /> (Note: You will always receive emails about any
            updates to our Policies, and Terms and Conditions).</span>
        <div class="pvm-setting-switch-container">
            <label class="pvm-switch pvm-switch--lg-labeled pvm-switch--float-right">
                <input type="checkbox" id="" ng-model="communicationSettingData.email_settings.newsletters" ng-checked="communicationSettingData.email_settings.newsletters">
                <span class="pvm-slider round"></span>
            </label>
            <span class="pvm-switch-label" ng-if="communicationSettingData.email_settings.newsletters">Enabled</span>
            <span class="pvm-switch-label" ng-if="!communicationSettingData.email_settings.newsletters">Disabled</span>
        </div>
        <div class="pvm-setting-frequency-select pvm-animated pvm-fadein" ng-if="communicationSettingData.email_settings.newsletters">
            <span class="frequency-label">Frequency:</span>
            <select class="pvm-select role__not-sel pvm-select--float-left  ng-pristine ng-untouched ng-valid ng-not-empty" ng-model="communicationSettingData.email_settings.newsletters_frequency">
                <option label="When published" value="when_published">When published</option>
                <option label="Weekly" value="weekly" selected="selected">Weekly</option>
                <option label="Fortnightly" value="fortnightly">Fortnightly</option>
                <option label="Monthly" value="monthly">Monthly</option>
            </select>
        </div>
    </div>
    <!-- END OF NEWS LETTERS -->

    <!-- VIEW PROFILE -->
    <div class="pvm-setting-item clear-float">
        <span class="pvm-setting-label pvm-setting-label--comm">Do you want to be emailed by PreviewMe when employers
            on PreviewMe submit a request to view your profile? <br /> (Note: This applies when your profile is set to
            Private).</span>
        <div class="pvm-setting-switch-container">
            <label class="pvm-switch pvm-switch--lg-labeled pvm-switch--float-right">
                <input type="checkbox" id="" ng-model="communicationSettingData.email_settings.view_profile" ng-checked="communicationSettingData.email_settings.view_profile">
                <span class="pvm-slider round"></span>
            </label>
            <span class="pvm-switch-label" ng-if="communicationSettingData.email_settings.view_profile">Enabled</span>
            <span class="pvm-switch-label" ng-if="!communicationSettingData.email_settings.view_profile">Disabled</span>
        </div>
    </div>
    <!-- END OF VIEW PROFILE -->

    <!-- DIRECT MESSAGES -->
    <h1 class="pvm__header settings__header settings__header--margin-top">Notifications (PreviewMe web-notifications)</h1>
    <div class="pvm-setting-item clear-float">
        <span class="pvm-setting-label pvm-setting-label--comm">Do you want to be notified by PreviewMe via alerts when
            you receive direct messages from employers?</span>
        <div class="pvm-setting-switch-container">
            <label class="pvm-switch pvm-switch--lg-labeled pvm-switch--float-right">
                <input type="checkbox" id="" ng-model="communicationSettingData.notification_settings.direct_messages" ng-checked="communicationSettingData.notification_settings.direct_messages">
                <span class="pvm-slider round"></span>
            </label>
            <span class="pvm-switch-label" ng-if="communicationSettingData.notification_settings.direct_messages">Enabled</span>
            <span class="pvm-switch-label" ng-if="!communicationSettingData.notification_settings.direct_messages">Disabled</span>
        </div>
    </div>
    <!-- END OF DIRECT MESSAGES -->

    <!-- NEW ROLES -->
    <div class="pvm-setting-item clear-float">  
        <span class="pvm-setting-label pvm-setting-label--comm">Do you want to be notified by PreviewMe via alerts
            about new roles and opportunities based on your Profile metrics?</span>
        <div class="pvm-setting-switch-container clear-float">
            <label class="pvm-switch pvm-switch--lg-labeled pvm-switch--float-right">
                <input type="checkbox" id="" ng-model="communicationSettingData.notification_settings.new_roles" ng-checked="communicationSettingData.notification_settings.new_roles">
                <span class="pvm-slider round"></span>
            </label>
            <span class="pvm-switch-label" ng-if="communicationSettingData.notification_settings.new_roles">Enabled</span>
            <span class="pvm-switch-label" ng-if="!communicationSettingData.notification_settings.new_roles">Disabled</span>

        </div>
        <div class="pvm-setting-frequency-select pvm-animated pvm-fadein" ng-if="communicationSettingData.notification_settings.new_roles">
            <span class="frequency-label">Frequency:</span>
            <select class="pvm-select role__not-sel pvm-select--float-left  ng-pristine ng-untouched ng-valid ng-not-empty" ng-model="communicationSettingData.notification_settings.new_roles_frequency">
                <option label="When published" value="when_published">When published</option>
                <option label="Weekly" value="weekly" selected="selected">Weekly</option>
                <option label="Fortnightly" value="fortnightly">Fortnightly</option>
                <option label="Monthly" value="monthly">Monthly</option>
            </select>
        </div>
    </div>
    <!-- END OF NEW ROLES -->

    <!-- VIEW PROFILE -->
    <div class="pvm-setting-item clear-float">
        <span class="pvm-setting-label pvm-setting-label--comm">Do you want to be notified by PreviewMe via alerts when
            employers on PreviewMe submit a request to view your profile?</span>
        <div class="pvm-setting-switch-container clear-float">
            <label class="pvm-switch pvm-switch--lg-labeled pvm-switch--float-right">
                <input type="checkbox" id="" ng-model="communicationSettingData.notification_settings.view_profile" ng-checked="communicationSettingData.notification_settings.view_profile">
                <span class="pvm-slider round"></span>
            </label>
            <span class="pvm-switch-label" ng-if="communicationSettingData.notification_settings.view_profile">Enabled</span>
            <span class="pvm-switch-label" ng-if="!communicationSettingData.notification_settings.view_profile">Disabled</span>
        </div>
    </div>
    <!-- END OF VIEW PROFILE -->

</article>
<!-- End TAB 2 -->