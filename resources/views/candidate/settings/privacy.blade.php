<!-- TAB 3 - PRIVACY /VISIBILITY SETTINGS -->
<style type="text/css">
    .read-link {
        float: right;
        margin-right: 5%;
    }
</style>

<article class="pvm-tab-page pvm-tab-page--privacy pvm-fadein pvm-animated " ng-show="tab3">

    <div class="pvm-tab-page-warning pvm-animated pvm-fadein" ng-if="privacySettingSelected.value === 'private' ">
        <a><i class="fa fa-exclamation-circle" aria-hidden="true"></i></a>

        <div>
            <p class="pvm-tab-page-warning__message notePrivate">Your profile is set to <strong>PRIVATE</strong> (our
                default setting).</p>
            <div class="orangeBoxPrivate">
                <p class="pvm-tab-page-warning__message">Only employers who you have granted permission to view (by
                    submitting an application for an opportunity to an employer registered on PreviewMe, through
                    PreviewMe or accepting a request by an employer registered on PreviewMe to view) can view your
                    profile.</p>
                <p class="pvm-tab-page-warning__message">People outside of PreviewMe <strong>cannot view</strong> your
                    profile and your profile <strong>is not</strong> searchable on search engines.</p>
                <p class="pvm-tab-page-warning__message">You can change these privacy settings anytime.</p>
                <p class="pvm-tab-page-warning__message">For information on how PreviewMe uses your data outside of how
                    you use it please refer to our Privacy Policy <a href="javascript:void(0)" data-href="/privacy-policy"
                        ng-click="gotoLink('/privacy-policy')">here</a>.</p>
            </div>

            <a href="#" class="show_hide read-link" data-content="toggle-text">Read Less</a><br>

            <script>
                $(".show_hide").on("click", function () {
                    if ($(".orangeBoxPrivate").is(':visible')) {
                        var txt = 'Read More';
                        var note = 'Your profile is set to <strong>PRIVATE</strong> (our default setting). People outside of PreviewMe <strong>cannot view</strong> your profile and your profile is not searchable on search engines.';
                    } else {
                        var txt = 'Read Less';
                        var note = 'Your profile is set to <strong>PRIVATE</strong> (our default setting).';
                    }

                    $(".show_hide").text(txt);
                    $(".notePrivate").html(note);
                    $('.orangeBoxPrivate').slideToggle(500);
                });
            </script>
        </div>
    </div>

    <div class="pvm-tab-page-warning pvm-animated pvm-fadein" ng-if="privacySettingSelected.value === 'public' ">
        <a><i class="fa fa-exclamation-circle" aria-hidden="true"></i></a>
        <div>
            <p class="pvm-tab-page-warning__message notePublic">Your profile is set to <strong>PUBLIC</strong>.</p>
            <div class="orangeBoxPublic">
                <p class="pvm-tab-page-warning__message">Employers on PreviewMe who have received an application for an
                    opportunity can view your profile. Employers who have not received an application for an
                    opportunity on PreviewMe can only see the content you have made available for viewing and must
                    request access to view any additional content directly with you.</p>
                <p class="pvm-tab-page-warning__message">People outside of PreviewMe <strong>can</strong> view your
                    profile <strong>(subject to your visibility restrictions)</strong> only when you share your Profile
                    URL Link <a href="<?php echo $baseUrl ?>me/@{{profileUrl}}" target="_blank">
                        <?php echo $baseUrl ?>me/@{{profileUrl}}</a> with those people.</p>
                <p class="pvm-tab-page-warning__message noteSEO">Your Profile <strong ng-if="privacySettingsData.settings.seo_enabled">is</strong><strong
                        ng-if="!privacySettingsData.settings.seo_enabled">is not</strong> searchable on search engines<span
                        ng-if="privacySettingsData.settings.seo_enabled"> (eg: Google, Yahoo!, Bing, etc)</span>.</p>
                <p class="pvm-tab-page-warning__message">You can change any of these settings anytime.</p>
                <p class="pvm-tab-page-warning__message">For information on how PreviewMe uses your data outside of how
                    you use it please refer to our Privacy Policy <a href="javascript:void(0)" data-href="/privacy-policy"
                        ng-click="gotoLink('/privacy-policy')">here</a>.</p>
            </div>
            <a href="#" class="show_hide read-link" data-content="toggle-text">Read Less</a><br>

            <script>
                $(".show_hide").on("click", function () {
                    if ($(".orangeBoxPublic").is(':visible')) {
                        var txt = 'Read More';
                        var note = 'Your profile is set to <strong>PUBLIC</strong>. People outside of PreviewMe <strong>can view</strong> your profile (subject to your visibility restrictions) only when you share your Profile URL Link http://previewme.co/me/profile_url with those people.<br><br>' + $(".noteSEO").html();
                    } else {
                        var noteSEO = $(".noteSEO").val();
                        var txt = 'Read Less';
                        var note = 'Your profile is set to <strong>PUBLIC</strong>.' + $(".noteSEO").val();
                    }

                    $(".show_hide").text(txt);
                    $(".notePublic").html(note);
                    $('.orangeBoxPublic').slideToggle(500);
                });
          </script>
        </div>
    </div>


    <h1 class="pvm__header settings__header settings__header--no-border">Privacy Controls</h1>
    <p class="settings__header__sub">Control who you want to be able to view your PreviewMe profile and adjust the
        visibility of what you want them to see below.</p>

    <div class="pvm-setting-item-profile-control clear-float">
        <span class="pvm-setting-item-profile-control__label">Your profile is: </span>

        <select class="pvm-setting-item-profile-control_option" ng-change="updatePrivacyGetSettingUpdate(privacySettingSelected)"
            ng-model="privacySettingSelected" class="pvm-select role__not-sel" ng-options="privacySetting as privacySetting.label for privacySetting in privacySettings track by privacySetting.value">
        </select>
        <a href="" ng-click="showHelperToggle()" class="pvm-setting__helper-link" ng-if="privacySettingSelected.value == 'private'"><i
                class="fa fa-exclamation-circle" aria-hidden="true"></i></a>
    </div>

    <!-- WHITELIST Start-->
    <div class="pvm-setting-item clear-float">
        <span class="pvm-setting-label pvm-animated pvm-fadein"> The companies/employers below have access to your
            profile in Private Mode. This is because you have manually entered the company on the whitelist or have
            accepted a request by a company/employer on PreviewMe to view your profile.</span>
        <div class="pvm-setting-privacy-company-block pvm-animated pvm-fadein">
            <ul class="pvm-setting-privacy-company-block__list clear-float">
                <li class="pvm-setting-privacy-company-block__list-item pvm-animated pvm-fadein" ng-repeat="approvedCompany in grantedCompanyItems">
                    <span>
                        @{{approvedCompany.companies.company_name}}
                    </span>
                    <a href="" ng-click="removeWhiteListed(approvedCompany.companies.id, $index, $event)"><i class="btn-remove-item"></i></a>
                </li>
            </ul>
        </div>
        <div class="pvm-setting-privacy-company-search">
            <div class="pvm-search-input-container">
                <a class="pvm-search-control" ng-if="privacySearchItemWhitelist.length>0 && privacySearchResultsWhitelist"
                    href="" ng-click="clearSearch('pvm-search-input-whitelist','whitelist')"><i class="fa fa-times-circle"
                        aria-hidden="true"></i></a>
                <a class="pvm-search-control" ng-if="!privacySearchItemWhitelist" href="" ng-click="searchComp(privacySearchItemWhitelist,'whitelist')"></a>
                <input name="privacySearchItemWhitelist" id="pvm-search-input-whitelist" ng-focus="scrollToCenter('pvm-search-input-whitelist')"
                    placeholder="Search Company / Employer" type="text" ng-model="privacySearchItemWhitelist" ng-enter="searchComp(privacySearchItemWhitelist,'whitelist')"
                    ng-change="searchComp(privacySearchItemWhitelist,'whitelist')" ng-model-options='{ debounce: 400 }' />
            </div>
            <ul class="pvm-search-result pvm-search-result--absolute">
                <li class="pvm-search-result__item" ng-repeat="searchResult in privacySearchResultsWhitelist | filter: companyFilter track by $index">
                    <a href="" ng-click="addWhitelistedCompany(searchResult,$index)" class="clear-float pvm-search-result__item__link">
                        <div ng-if="!searchResult.logo_url" class="randomInitialColor member-initials member-initials--md member-initials--@{{searchResult.color}}">
                            @{{searchResult.initials}}
                        </div>
                        <div ng-if="searchResult.logo_url" class="logo-container">
                            <img class="logo-img" src="@{{searchResult.logo_url}}" alt="@{{searchResult.company_name}}">
                        </div>
                        <span class="pvm-search-result__item__link__label" ng-bind="searchResult.company_name"></span>
                    </a>
                </li>
                <li class="pvm-search-result__item__no-result" ng-if="privacySearchItemWhitelist.length>0 && clearActiveWhitelisting && privacySearchResultsWhitelist.length == 0 && noResult2 == true">No
                    results found!</li>
            </ul>
        </div>

        <span class="pvm-setting-label">These companies have requested to view your PreviewMe profile.</span>
        <div class="pvm-setting-privacy-request-access">
            <ul class="pvm-search-result pvm-search-result--request-access">
                <li class="pvm-search-result__item pvm-search-result__item--bordered-top" ng-repeat="requestCompany in requestAccessCompanyItems">
                    <a href="" class="clear-float">
                        <div class="logo-container">
                            <img class="logo-img" ng-if="requestCompany.companies.logo_url != null" src="@{{requestCompany.companies.logo_url}}" alt="@{{requestCompany.companies.company_url}}">
                            <div ng-hide="requestCompany.companies.logo_url != null" class="randomInitialColor member-initials member-initials--md member-initials--@{{requestCompany.color}}" ng-bind="requestCompany.initials">
                            </div>
                        </div>
                        <span class="pvm-search-result__item__text-message" ng-bind="requestCompany.companies.company_name"></span>
                    </a>
                    <a href="" ng-click="allowWhiteList(requestCompany, $index)" class="pvm-search-result__item__accept"><i
                            class="fa fa-check" aria-hidden="true"></i></a>
                    <a href="" ng-click="declineWhiteList(requestCompany, $index)" class="pvm-search-result__item__decline"><i
                            class="fa fa-times" aria-hidden="true"></i></a>
                </li>
                <!-- IF NO REQUEST FOUND -->
                <li class="pvm-search-result__item pvm-search-result__item--no-request" ng-if="requestAccessCompanyItems.length === 0">
                    <span class="pvm-search-result__item__text-message pvm-search-result__item__text-message--no-data">No requests to consider</span>
                </li>
                <!-- END OF NO REQUEST FOUND -->
            </ul>
        </div>
    </div>
    <!-- WHITELIST End-->

    <!-- TOGGLE SETTING Start-->
    <div ng-if="privacySettingSelected.value === 'public'">
        <div class="pvm-setting-item pvm-setting-item--bordered-bottom clear-float pvm-animated pvm-fadein">
            <div class="pvm-setting-privacy-item clear-float">
                <span class="pvm-setting-privacy-item__label">Do you want to make your Profile searchable and visible
                    on public search engines?<br />(ie. on Google, Yahoo!, Bing, etc.)</span>
                <div class="pvm-setting-privacy-item__controls clear-float">
                    <div class="pvm-setting-privacy-item-public clear-float">
                        <span class="pvm-setting--controls-label"></span>
                        <div class="pvm-setting-switch-container clear-float">
                        </div>
                    </div>
                    <div class="pvm-setting-privacy-item-search-engine cleafix">
                        <span class="pvm-setting--controls-label"></span>
                        <div class="pvm-setting-switch-container clear-float">
                            <label class="pvm-switch pvm-switch--lg-labeled ">
                                <input type="checkbox" id="" ng-model="privacySettingsData.settings.seo_enabled"
                                    ng-change="seoSwitch(privacySettingsData.settings.seo_enabled)">
                                <span class="pvm-slider round"></span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- pvm-setting-item--bordered-bottom -->
        <div class="pvm-setting-privacy-item clear-float pvm-animated pvm-fadein isVisibleDesktop">
            <span class="pvm-setting-privacy-item__label"></span>
            <div class="pvm-setting-privacy-item__controls clear-float">
                <div class="pvm-setting-privacy-item-public clear-float">
                    <span class="pvm-setting--controls-label">Public</span>
                    <div class="pvm-setting-switch-container clear-float">
                    </div>
                </div>
                <div class="pvm-setting-privacy-item-search-engine cleafix">
                    <span class="pvm-setting--controls-label">Search Engine</span>
                    <div class="pvm-setting-switch-container clear-float">
                    </div>
                </div>
            </div>
        </div>
        <div class="pvm-setting-privacy-item clear-float pvm-animated pvm-fadein">
            <span class="pvm-setting-privacy-item__label">Show First Name </span>
            <div class="pvm-setting-privacy-item__controls clear-float">
                <div class="pvm-setting-privacy-item-public clear-float">
                    <span class="pvm-setting--controls-label isvisible-mobile">Public:</span>
                    <div class="pvm-setting-switch-container clear-float">
                        <label class="pvm-switch pvm-switch--lg-labeled">
                            <input type="checkbox" id="" ng-model="privacySettingsData.settings.first_name" ng-disabled="privacySettingsData.settings.seo_enabled"
                                ng-change="privacySettingItemSwitch()">
                            <span class="pvm-slider round" ng-class="{grey: privacySettingsData.settings.seo_enabled}"></span>
                        </label>
                    </div>
                </div>
                <div class="pvm-setting-privacy-item-search-engine cleafix">
                    <span class="pvm-setting--controls-label isvisible-mobile">Search Engine:</span>
                    <div class="pvm-setting-switch-container clear-float">

                        <label class="pvm-settings-check-uncheck">
                            <i ng-if="!privacySettingsData.settings.seo_enabled || !privacySettingsData.settings.first_name"
                                class="fa fa-circle" aria-hidden="true"></i>
                            <i ng-if="privacySettingsData.settings.seo_enabled && privacySettingsData.settings.first_name"
                                class="fa fa-check" aria-hidden="true"></i>
                        </label>
                    </div>
                </div>
            </div>
        </div>
        <div class="pvm-setting-privacy-item clear-float pvm-animated pvm-fadein">
            <span class="pvm-setting-privacy-item__label">Show Last Name </span>
            <div class="pvm-setting-privacy-item__controls clear-float">
                <div class="pvm-setting-privacy-item-public clear-float">
                    <span class="pvm-setting--controls-label isvisible-mobile">Public:</span>
                    <div class="pvm-setting-switch-container clear-float">
                        <label class="pvm-switch pvm-switch--lg-labeled">
                            <input type="checkbox" id="" ng-model="privacySettingsData.settings.last_name" ng-disabled="privacySettingsData.settings.seo_enabled"
                                ng-change="privacySettingItemSwitch()">
                            <span class="pvm-slider round" ng-class="{grey: privacySettingsData.settings.seo_enabled}"></span>
                        </label>
                    </div>
                </div>
                <div class="pvm-setting-privacy-item-search-engine cleafix">
                    <span class="pvm-setting--controls-label isvisible-mobile">Search Engine:</span>
                    <div class="pvm-setting-switch-container clear-float">

                        <label class="pvm-settings-check-uncheck">
                            <i ng-if="!privacySettingsData.settings.seo_enabled || !privacySettingsData.settings.last_name"
                                class="fa fa-circle" aria-hidden="true"></i>
                            <i ng-if="privacySettingsData.settings.seo_enabled && privacySettingsData.settings.last_name"
                                class="fa fa-check" aria-hidden="true"></i>
                        </label>
                    </div>
                </div>
            </div>
        </div>
        <div class="pvm-setting-privacy-item clear-float pvm-animated pvm-fadein">
            <span class="pvm-setting-privacy-item__label">Show Contact Number </span>
            <div class="pvm-setting-privacy-item__controls clear-float">
                <div class="pvm-setting-privacy-item-public clear-float">
                    <span class="pvm-setting--controls-label isvisible-mobile">Public:</span>
                    <div class="pvm-setting-switch-container clear-float">
                        <label class="pvm-switch pvm-switch--lg-labeled">
                            <input type="checkbox" id="" ng-model="privacySettingsData.settings.contact_number"
                                ng-disabled="privacySettingsData.settings.seo_enabled" ng-change="privacySettingItemSwitch()">
                            <span class="pvm-slider round" ng-class="{grey: privacySettingsData.settings.seo_enabled}"></span>
                        </label>
                    </div>
                </div>
                <div class="pvm-setting-privacy-item-search-engine cleafix">
                    <span class="pvm-setting--controls-label isvisible-mobile">Search Engine:</span>
                    <div class="pvm-setting-switch-container clear-float">

                        <label class="pvm-settings-check-uncheck">
                            <i ng-if="!privacySettingsData.settings.seo_enabled || !privacySettingsData.settings.contact_number"
                                class="fa fa-circle" aria-hidden="true"></i>
                            <i ng-if="privacySettingsData.settings.seo_enabled && privacySettingsData.settings.contact_number"
                                class="fa fa-check" aria-hidden="true"></i>
                        </label>
                    </div>
                </div>
            </div>
        </div>
        <div class="pvm-setting-privacy-item clear-float pvm-animated pvm-fadein">
            <span class="pvm-setting-privacy-item__label">Show Email Address</span>
            <div class="pvm-setting-privacy-item__controls clear-float">
                <div class="pvm-setting-privacy-item-public clear-float">
                    <span class="pvm-setting--controls-label isvisible-mobile">Public:</span>
                    <div class="pvm-setting-switch-container clear-float">
                        <label class="pvm-switch pvm-switch--lg-labeled ">
                            <input type="checkbox" id="" ng-model="privacySettingsData.settings.email" ng-disabled="privacySettingsData.settings.seo_enabled"
                                ng-change="privacySettingItemSwitch()">
                            <span class="pvm-slider round " ng-class="{grey: privacySettingsData.settings.seo_enabled}"></span>
                        </label>
                    </div>
                </div>
                <div class="pvm-setting-privacy-item-search-engine cleafix">
                    <span class="pvm-setting--controls-label isvisible-mobile">Search Engine:</span>
                    <div class="pvm-setting-switch-container clear-float">

                        <label class="pvm-settings-check-uncheck">
                            <i ng-if="!privacySettingsData.settings.seo_enabled || !privacySettingsData.settings.email"
                                class="fa fa-circle" aria-hidden="true"></i>
                            <i ng-if="privacySettingsData.settings.seo_enabled && privacySettingsData.settings.email"
                                class="fa fa-check" aria-hidden="true"></i>
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <div class="pvm-setting-privacy-item clear-float pvm-animated pvm-fadein">
            <span class="pvm-setting-privacy-item__label">Show Location (current) </span>
            <div class="pvm-setting-privacy-item__controls clear-float">
                <div class="pvm-setting-privacy-item-public clear-float">
                    <span class="pvm-setting--controls-label isvisible-mobile">Public:</span>
                    <div class="pvm-setting-switch-container clear-float">
                        <label class="pvm-switch pvm-switch--lg-labeled ">
                            <input type="checkbox" id="" ng-model="privacySettingsData.settings.location" ng-disabled="privacySettingsData.settings.seo_enabled"
                                ng-change="privacySettingItemSwitch()">
                            <span class="pvm-slider round" ng-class="{grey: privacySettingsData.settings.seo_enabled}"></span>
                        </label>
                    </div>
                </div>
                <div class="pvm-setting-privacy-item-search-engine cleafix">
                    <span class="pvm-setting--controls-label isvisible-mobile">Search Engine:</span>
                    <div class="pvm-setting-switch-container clear-float">

                        <label class="pvm-settings-check-uncheck">
                            <i ng-if="!privacySettingsData.settings.seo_enabled || !privacySettingsData.settings.location "
                                class="fa fa-circle" aria-hidden="true"></i>
                            <i ng-if="privacySettingsData.settings.seo_enabled && privacySettingsData.settings.location"
                                class="fa fa-check" aria-hidden="true"></i>
                        </label>
                    </div>
                </div>
            </div>
        </div>
        <div class="pvm-setting-privacy-item clear-float pvm-animated pvm-fadein" ng-disabled="privacySettingsData.settings.seo_enabled">
            <span class="pvm-setting-privacy-item__label">Show Preferred Industry & Sub-Industry </span>
            <div class="pvm-setting-privacy-item__controls clear-float">
                <div class="pvm-setting-privacy-item-public clear-float">
                    <span class="pvm-setting--controls-label isvisible-mobile">Public:</span>
                    <div class="pvm-setting-switch-container clear-float">
                        <label class="pvm-switch pvm-switch--lg-labeled ">
                            <input type="checkbox" id="" ng-model="privacySettingsData.settings.sub_industry"
                                ng-disabled="privacySettingsData.settings.seo_enabled" ng-change="privacySettingItemSwitch()">
                            <span class="pvm-slider round" ng-class="{grey: privacySettingsData.settings.seo_enabled}"></span>
                        </label>
                    </div>
                </div>
                <div class="pvm-setting-privacy-item-search-engine cleafix">
                    <span class="pvm-setting--controls-label isvisible-mobile">Search Engine:</span>
                    <div class="pvm-setting-switch-container clear-float">

                        <label class="pvm-settings-check-uncheck">
                            <i ng-if="!privacySettingsData.settings.seo_enabled || !privacySettingsData.settings.sub_industry"
                                class="fa fa-circle" aria-hidden="true"></i>
                            <i ng-if="privacySettingsData.settings.seo_enabled && privacySettingsData.settings.sub_industry"
                                class="fa fa-check" aria-hidden="true"></i>
                        </label>
                    </div>
                </div>
            </div>
        </div>
        <div class="pvm-setting-privacy-item clear-float pvm-animated pvm-fadein">
            <span class="pvm-setting-privacy-item__label">Show About Me</span>
            <div class="pvm-setting-privacy-item__controls clear-float">
                <div class="pvm-setting-privacy-item-public clear-float">
                    <span class="pvm-setting--controls-label isvisible-mobile">Public:</span>
                    <div class="pvm-setting-switch-container clear-float">
                        <label class="pvm-switch pvm-switch--lg-labeled ">
                            <input type="checkbox" id="" ng-model="privacySettingsData.settings.about_me" ng-disabled="privacySettingsData.settings.seo_enabled"
                                ng-change="privacySettingItemSwitch()">
                            <span class="pvm-slider round" ng-class="{grey: privacySettingsData.settings.seo_enabled}"></span>
                        </label>
                    </div>
                </div>
                <div class="pvm-setting-privacy-item-search-engine cleafix">
                    <span class="pvm-setting--controls-label isvisible-mobile">Search Engine:</span>
                    <div class="pvm-setting-switch-container clear-float">

                        <label class="pvm-settings-check-uncheck">
                            <i ng-if="!privacySettingsData.settings.seo_enabled || !privacySettingsData.settings.about_me"
                                class="fa fa-circle" aria-hidden="true"></i>
                            <i ng-if="privacySettingsData.settings.seo_enabled && privacySettingsData.settings.about_me"
                                class="fa fa-check" aria-hidden="true"></i>
                        </label>
                    </div>
                </div>
            </div>
        </div>
        <div class="pvm-setting-privacy-item clear-float pvm-animated pvm-fadein">
            <span class="pvm-setting-privacy-item__label">Show Profile Photo</span>
            <div class="pvm-setting-privacy-item__controls clear-float">
                <div class="pvm-setting-privacy-item-public clear-float">
                    <span class="pvm-setting--controls-label isvisible-mobile">Public:</span>
                    <div class="pvm-setting-switch-container clear-float">
                        <label class="pvm-switch pvm-switch--lg-labeled ">
                            <input type="checkbox" id="" ng-model="privacySettingsData.settings.profile_photo"
                                ng-disabled="privacySettingsData.settings.seo_enabled" ng-change="privacySettingItemSwitch()">
                            <span class="pvm-slider round" ng-class="{grey: privacySettingsData.settings.seo_enabled}"></span>
                        </label>
                    </div>
                </div>
                <div class="pvm-setting-privacy-item-search-engine cleafix">
                    <span class="pvm-setting--controls-label isvisible-mobile">Search Engine:</span>
                    <div class="pvm-setting-switch-container clear-float">

                        <label class="pvm-settings-check-uncheck">
                            <i ng-if="!privacySettingsData.settings.seo_enabled || !privacySettingsData.settings.profile_photo"
                                class="fa fa-circle" aria-hidden="true"></i>
                            <i ng-if="privacySettingsData.settings.seo_enabled && privacySettingsData.settings.profile_photo"
                                class="fa fa-check" aria-hidden="true"></i>
                        </label>
                    </div>
                </div>
            </div>
        </div>
        <div class="pvm-setting-privacy-item clear-float pvm-animated pvm-fadein">
            <span class="pvm-setting-privacy-item__label">Show Generic Profile Video</span>
            <div class="pvm-setting-privacy-item__controls clear-float">
                <div class="pvm-setting-privacy-item-public clear-float">
                    <span class="pvm-setting--controls-label isvisible-mobile">Public:</span>
                    <div class="pvm-setting-switch-container clear-float">
                        <label class="pvm-switch pvm-switch--lg-labeled ">
                            <input type="checkbox" id="" ng-model="privacySettingsData.settings.generic_video"
                                ng-disabled="privacySettingsData.settings.seo_enabled" ng-change="privacySettingItemSwitch()">
                            <span class="pvm-slider round" ng-class="{grey: privacySettingsData.settings.seo_enabled}"></span>
                        </label>
                    </div>
                </div>
                <div class="pvm-setting-privacy-item-search-engine cleafix">
                    <span class="pvm-setting--controls-label isvisible-mobile">Search Engine:</span>
                    <div class="pvm-setting-switch-container clear-float">
                        <label class="pvm-settings-check-uncheck">
                            <i ng-if="!privacySettingsData.settings.seo_enabled || !privacySettingsData.settings.generic_video"
                                class="fa fa-circle" aria-hidden="true"></i>
                            <i ng-if="privacySettingsData.settings.seo_enabled && privacySettingsData.settings.generic_video"
                                class="fa fa-check" aria-hidden="true"></i>
                        </label>
                    </div>
                </div>
            </div>
        </div>
        <div class="pvm-setting-privacy-item clear-float pvm-animated pvm-fadein">
            <span class="pvm-setting-privacy-item__label">Show Experience</span>
            <div class="pvm-setting-privacy-item__controls clear-float">
                <div class="pvm-setting-privacy-item-public clear-float">
                    <span class="pvm-setting--controls-label isvisible-mobile">Public:</span>
                    <div class="pvm-setting-switch-container clear-float">
                        <label class="pvm-switch pvm-switch--lg-labeled ">
                            <input type="checkbox" id="" ng-model="privacySettingsData.settings.experience" ng-disabled="privacySettingsData.settings.seo_enabled"
                                ng-change="privacySettingItemSwitch()">
                            <span class="pvm-slider round" ng-class="{grey: privacySettingsData.settings.seo_enabled}"></span>
                        </label>
                    </div>
                </div>
                <div class="pvm-setting-privacy-item-search-engine cleafix">
                    <span class="pvm-setting--controls-label isvisible-mobile">Search Engine:</span>
                    <div class="pvm-setting-switch-container clear-float">

                        <label class="pvm-settings-check-uncheck">
                            <i ng-if="!privacySettingsData.settings.seo_enabled || !privacySettingsData.settings.experience"
                                class="fa fa-circle" aria-hidden="true"></i>
                            <i ng-if="privacySettingsData.settings.seo_enabled && privacySettingsData.settings.experience"
                                class="fa fa-check" aria-hidden="true"></i>
                        </label>
                    </div>
                </div>
            </div>
        </div>
        <div class="pvm-setting-privacy-item clear-float pvm-animated pvm-fadein">
            <span class="pvm-setting-privacy-item__label">Show Education</span>
            <div class="pvm-setting-privacy-item__controls clear-float">
                <div class="pvm-setting-privacy-item-public clear-float">
                    <span class="pvm-setting--controls-label isvisible-mobile">Public:</span>
                    <div class="pvm-setting-switch-container clear-float">
                        <label class="pvm-switch pvm-switch--lg-labeled ">
                            <input type="checkbox" id="" ng-model="privacySettingsData.settings.education" ng-disabled="privacySettingsData.settings.seo_enabled"
                                ng-change="privacySettingItemSwitch()">
                            <span class="pvm-slider round" ng-class="{grey: privacySettingsData.settings.seo_enabled}"></span>
                        </label>
                    </div>
                </div>
                <div class="pvm-setting-privacy-item-search-engine cleafix">
                    <span class="pvm-setting--controls-label isvisible-mobile">Search Engine:</span>
                    <div class="pvm-setting-switch-container clear-float">

                        <label class="pvm-settings-check-uncheck">
                            <i ng-if="!privacySettingsData.settings.seo_enabled || !privacySettingsData.settings.education"
                                class="fa fa-circle" aria-hidden="true"></i>
                            <i ng-if="privacySettingsData.settings.seo_enabled && privacySettingsData.settings.education"
                                class="fa fa-check" aria-hidden="true"></i>
                        </label>
                    </div>
                </div>
            </div>
        </div>
        <div class="pvm-setting-privacy-item clear-float pvm-animated pvm-fadein">
            <span class="pvm-setting-privacy-item__label">Show References</span>
            <div class="pvm-setting-privacy-item__controls clear-float">
                <div class="pvm-setting-privacy-item-public clear-float">
                    <span class="pvm-setting--controls-label isvisible-mobile">Public:</span>
                    <div class="pvm-setting-switch-container clear-float">
                        <label class="pvm-switch pvm-switch--lg-labeled ">
                            <input type="checkbox" id="" ng-model="privacySettingsData.settings.references" ng-disabled="privacySettingsData.settings.seo_enabled"
                                ng-change="privacySettingItemSwitch()">
                            <span class="pvm-slider round" ng-class="{grey: privacySettingsData.settings.seo_enabled}"></span>
                        </label>
                    </div>
                </div>
                <div class="pvm-setting-privacy-item-search-engine cleafix">
                    <span class="pvm-setting--controls-label isvisible-mobile">Search Engine:</span>
                    <div class="pvm-setting-switch-container clear-float">

                        <label class="pvm-settings-check-uncheck">
                            <i ng-if="!privacySettingsData.settings.seo_enabled || !privacySettingsData.settings.references"
                                class="fa fa-circle" aria-hidden="true"></i>
                            <i ng-if="privacySettingsData.settings.seo_enabled && privacySettingsData.settings.references"
                                class="fa fa-check" aria-hidden="true"></i>
                        </label>
                    </div>
                </div>
            </div>
        </div>
        <div class="pvm-setting-privacy-item clear-float pvm-animated pvm-fadein">
            <span class="pvm-setting-privacy-item__label">Show Profile Resume</span>
            <div class="pvm-setting-privacy-item__controls clear-float">
                <div class="pvm-setting-privacy-item-public clear-float">
                    <span class="pvm-setting--controls-label isvisible-mobile">Public:</span>
                    <div class="pvm-setting-switch-container clear-float">
                        <label class="pvm-switch pvm-switch--lg-labeled ">
                            <input type="checkbox" id="" ng-model="privacySettingsData.settings.resume" ng-disabled="privacySettingsData.settings.seo_enabled"
                                ng-change="privacySettingItemSwitch()">
                            <span class="pvm-slider round" ng-class="{grey: privacySettingsData.settings.seo_enabled}"></span>
                        </label>
                    </div>
                </div>
                <div class="pvm-setting-privacy-item-search-engine cleafix">
                    <span class="pvm-setting--controls-label isvisible-mobile">Search Engine:</span>
                    <div class="pvm-setting-switch-container clear-float">

                        <label class="pvm-settings-check-uncheck">
                            <i ng-if="!privacySettingsData.settings.seo_enabled || !privacySettingsData.settings.resume"
                                class="fa fa-circle" aria-hidden="true"></i>
                            <i ng-if="privacySettingsData.settings.seo_enabled && privacySettingsData.settings.resume"
                                class="fa fa-check" aria-hidden="true"></i>
                        </label>
                    </div>
                </div>
            </div>
        </div>
        <div class="pvm-setting-privacy-item clear-float pvm-animated pvm-fadein">
            <span class="pvm-setting-privacy-item__label">Show Supporting Docs</span>
            <div class="pvm-setting-privacy-item__controls clear-float">
                <div class="pvm-setting-privacy-item-public clear-float">
                    <span class="pvm-setting--controls-label isvisible-mobile">Public:</span>
                    <div class="pvm-setting-switch-container clear-float">
                        <label class="pvm-switch pvm-switch--lg-labeled ">
                            <input type="checkbox" id="" ng-model="privacySettingsData.settings.supporting_docs"
                                ng-disabled="privacySettingsData.settings.seo_enabled" ng-change="privacySettingItemSwitch()">
                            <span class="pvm-slider round" ng-class="{grey: privacySettingsData.settings.seo_enabled}"></span>
                        </label>
                    </div>
                </div>
                <div class="pvm-setting-privacy-item-search-engine cleafix">
                    <span class="pvm-setting--controls-label isvisible-mobile">Search Engine:</span>
                    <div class="pvm-setting-switch-container clear-float">

                        <label class="pvm-settings-check-uncheck">
                            <i ng-if="!privacySettingsData.settings.seo_enabled || !privacySettingsData.settings.supporting_docs"
                                class="fa fa-circle" aria-hidden="true"></i>
                            <i ng-if="privacySettingsData.settings.seo_enabled && privacySettingsData.settings.supporting_docs"
                                class="fa fa-check" aria-hidden="true"></i>
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- TOGGLE SETTING End-->

    <!-- BLACKLIST Start -->
    <div class="pvm-setting-item clear-float">
        <span class="pvm-setting-label">Are there companies on PreviewMe you want to prevent from seeing or accessing
            your profile?<br /> (Note: This applies to employers who are logged in and you are ultimately responsible
            for sharing your URL with trusted recipients.)</span>
        <div class="pvm-setting-privacy-company-block">
            <ul class="pvm-setting-privacy-company-block__list clear-float">
                <li class="pvm-setting-privacy-company-block__list-item pvm-animated pvm-fadein" ng-repeat="blacklistedCompany in blockCompanyItems">
                    <span>
                        @{{blacklistedCompany.companies.company_name}}
                    </span>
                    <a href="" ng-click="unblockCompany(blacklistedCompany.companies, $index, $event)"><i class="btn-remove-item"></i></a>
                </li>
            </ul>
        </div>
        <div class="pvm-setting-privacy-company-search">
            <div class="pvm-search-input-container">
                <a class="pvm-search-control" ng-if="privacySearchItem.length>0 && clearActiveBlacklisting" href=""
                    ng-click="clearSearch('pvm-search-input','blacklist')"><i class="fa fa-times-circle" aria-hidden="true"></i></a>
                <a class="pvm-search-control" ng-if="!clearActiveBlacklisting" href="" ng-click="searchComp(privacySearchItem,'blacklist')">
                    <!--<i class="fa fa-search" aria-hidden="true"></i>--></a>
                <input name="privacySearchItem" id="pvm-search-input" ng-focus="scrollToCenter('pvm-search-input')"
                    placeholder="Search Company / Employer" type="text" ng-model="privacySearchItem" ng-enter="searchComp(privacySearchItem,'blacklist')"
                    ng-change="searchComp(privacySearchItem,'blacklist')" ng-model-options='{ debounce: 400 }' />
            </div>
            <ul class="pvm-search-result">
                <li class="pvm-search-result__item" ng-repeat="searchResult in privacySearchResults | filter: companyFilter track by $index">
                    <a href="" ng-click="addBlockedCompany(searchResult,$index)" class="clear-float pvm-search-result__item__link">
                        <div ng-if="!searchResult.logo_url" class="randomInitialColor member-initials member-initials--md member-initials--@{{searchResult.color}}">
                            @{{searchResult.initials}}
                        </div>
                        <div ng-if="searchResult.logo_url" class="logo-container">
                            <img class="logo-img" src="@{{searchResult.logo_url}}" alt="@{{searchResult.company_name}}">
                        </div>
                        <span class="pvm-search-result__item__link__label" ng-bind="searchResult.company_name"></span>
                    </a>
                </li>
                <li class="pvm-search-result__item__no-result" ng-if="privacySearchItem.length>0 && clearActiveBlacklisting && privacySearchResults.length == 0 && noResult == true">No
                    results found!</li>
            </ul>
        </div>
    </div>
    <!-- BLACKLIST End -->

    <div class="clear-float">
    </div>
</article>
<!-- End TAB 3 -->

</div>

<!-- MODAL FOR PUBLIC SETTINGS -->
<div class="pvm__modal-popup pvm__modal-popup--confirm" ng-class="{'pvm_modal_active': animateShowModal}" ng-if="tab3 && modalStatus && publicPrivateToggle">
    <div class="pvm__modal-popup__content">
        <a ahref="/settings#" ng-click="cancelModal()" class="close pvm-color-red"><i class="fa fa-times" aria-hidden="true"></i></a>
        <p>This feature enables you to share your Profile with people off PreviewMe. Please be careful with what you
            share and who you share it with. </p>
        <p>We encourage you to consider using the visibility controls below to protect your content.</p>
        <p>PreviewMe is not liable for disclosure of your Profile content to third parties (or third parties on-sharing
            your profile URL) when Public. </p>
        <div class="modal_btn_container">
            <button ng-click="aggreeUpdate('privatePublicSetting')" class="btn-pvm modal_btn modal_btn--green">I agree</button>
            <button ng-click="cancelModal()" class="btn-pvm modal_btn modal_btn--red">I decline</button>
        </div>
    </div>
</div>
<!-- END OF PUBLIC SETTINGS -->

<!-- MODAL FOR SEO ENABLING -->
<div class="pvm__modal-popup pvm__modal-popup--confirm" ng-class="{'pvm_modal_active': animateShowModal}" ng-if="tab3 && modalStatus && seoSwitchToggle">
    <div class="pvm__modal-popup__content">
        <a ahref="/settings#" ng-click="cancelModal()" class="close pvm-color-red"><i class="fa fa-times" aria-hidden="true"></i></a>
        <p>By enabling this function you are making your profile searchable on public search engines (eg: Google,
            Yahoo!, Bing, etc) and anyone can view all of your profile.</p>
        <p>Before enabling this feature please consider whether a mix of any of the other privacy controls that
            PreviewMe offers will suit you better and let you pursue opportunities in a way that gives you more control
            of your profile and protects your information.. For example, restricting visibility to some elements using
            the toggles below or utilising out 'Intros' feature (click <a href="">here</a> to find out more).</p>
        <p>PreviewMe is not liable for disclosure of your profile to third parties or how those third parties use your
            profile once they have obtained it when Search Engine mode is enabled.</p>
        <div class="modal_btn_container">
            <button ng-click="aggreeUpdate('seoSwitchSetting')" class="btn-pvm modal_btn modal_btn--green">I agree</button>
            <button ng-click="cancelModal()" class="btn-pvm modal_btn modal_btn--red">I decline</button>
        </div>
    </div>
</div>
<!-- END OF SEO ENABLING -->

<!-- MODAL FOR PRIVACY SETTINGS -->
<div class="pvm__modal-popup pvm__modal-popup--confirm" ng-class="{'pvm_modal_active': animateShowModal}" ng-if="tab3 && modalStatus && showHelper">
    <div class="pvm__modal-popup__content">
        <a ahref="/settings#" ng-click="cancelModal()" class="close pvm-color-red"><i class="fa fa-times" aria-hidden="true"></i></a>
        <p>Private mode is our default setting for you.</p>
        <p>We take your privacy seriously and this gives you the ultimate control over your profile. </p>
        <p>Employers registered on PreviewMe who have received an application from you through PreviewMe have access to
            your profile and if an employer on PreviewMe who you have not submitted an application to does somehow get
            hold of your URL they must submit a request to view directly to you (which you can accept, reject and
            revoke at anytime). </p>
        <div class="modal_btn_container">
            <button ng-click="cancelModal()" class="btn-pvm modal_btn modal_btn--red">Close</button>
        </div>
    </div>
</div>
<!-- END OF PRIVACY SETTINGS -->

<!-- MODAL FOR STATUS CHANGES -->
<div class="pvm__modal-popup pvm__modal-popup--confirm" ng-class="{'pvm_modal_active': animateShowModal}" ng-if="tab3 && modalStatus && showDataStatusAlert">
    <div class="pvm__modal-popup__content">
        <a ahref="/settings#" ng-click="cancelModal()" class="close pvm-color-red"><i class="fa fa-times" aria-hidden="true"></i></a>
        <p>You haven't clicked on Confirm Changes yet. Discard changes?</p>
        <div class="modal_btn_container">
            <button ng-click="updateBeforeLeave('yes')" class="btn-pvm modal_btn modal_btn--green">Yes</button>
            <button ng-click="updateBeforeLeave('cancel')" class="btn-pvm modal_btn modal_btn--red">Cancel</button>
        </div>
    </div>
</div>
<!-- END OF STATUS CHANGES -->

<div class="pvm__modal-popup pvm__modal-popup--confirm" ng-class="{'pvm_modal_active': animateShowModal}" ng-if="tab3 && modalStatus && messageModal">
    <div class="pvm__modal-popup__content pvm__modal-popup__content--large">
        <a ahref="/settings#" ng-click="cancelModal()" class="close pvm-color-red"><i class="fa fa-times" aria-hidden="true"></i></a>
        <div class="modal_btn_container">
            <button ng-click="cancelModal()" class="btn-pvm modal_btn modal_btn--red">Close</button>
        </div>
    </div>
</div>
<!-- End TAB 3 -->
