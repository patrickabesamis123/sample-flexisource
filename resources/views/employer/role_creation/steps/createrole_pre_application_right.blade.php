<div class="preview__handler preview__handler--candidate">
    <div class="preview__banner" style="background-image: url(@{{companyDetails.company_banner_url}});"></div>
    <section class="preview__content clear-float">
        <div class="preview__left">
        <img src="@{{companyDetails.logo_url}}" class="preview__logo">
        <div class="preview__summ">
            <h2 class="preview__company-name">@{{companyDetails.company_name}}</h2>
            <h3 class="preview__industry">@{{companyDetails.industry.data.industry.display_name}}</h3>
        </div>
        <ul class="preview__app-tab-list">
            <li class="preview__app-tab-item active" ng-if="createPreApp">Pre-application questions</li>
            <li class="preview__app-tab-item active" ng-if="createStandard">Standard questions</li>
        </ul>
        </div>
        <div class="preview__right preview__right--app"  ng-if="createPreApp">
        <h3 class="preview__title">Pre-application Questions</h3>
        <ul class="preview__pre-app-list">
            <li ng-repeat="preapp in PreAprrovalQuestions" class="preview__pre-app-item">
            <span class="preview__question">@{{ $index + 1}} . @{{preapp.question}}</span>
            <label ng-repeat="level in levels" ng-if="preapp.answer_type!='custom_pre_apply_1'" class="role__answers"
                    ng-class="{'role__answers--yes' :level == 'yes' , 'role__answers--no' :level == 'no', 'role__answers--dev' :level == 'developing', 'role__answers--answered' : (level =='yes' && preapp .levelYes) || (level =='developing' && preapp .levelDev) || (level =='no' && preapp .levelNo)}">
                <input type="checkbox" checklist-model="preapp.ideal_answer" checklist-value="level" disabled> @{{level}}
            </label>
            </li>
        </ul>
        </div>
        <div class="preview__right preview__right--app"  ng-if="createStandard">
        <h3 class="preview__title">Standard Questions</h3>
        <ul class="preview__pre-app-list">
            <li ng-repeat="standard in roleCreate_watch.questions.application" class="preview__pre-app-item">
            <span class="preview__question">@{{standard.question}}</span>
            <div class="preview__question-con">
                <label ng-repeat="level in levels" ng-show="standard.answer_type.indexOf('boolean') > -1 && !standard.question_type" class="role__answers"
                        ng-class="{'role__answers--yes' :level == 'yes' , 'role__answers--no' :level == 'no', 'role__answers--dev' :level == 'developing', 'role__answers--answered' : (level =='yes' && standard.levelYes) || (level =='developing' && standard.levelDev) || (level =='no' && standard.levelNo)}">@{{level}}
                <input type="checkbox" checklist-model="standard.ideal_answer" checklist-value="level" disabled>
                </label>
            </div>
            <div class="preview__question-con">
                <label ng-repeat="level in standard.answer_choicesDisplay" ng-show="standard.answer_type.indexOf('multiple_choice') > -1 && level.value" class="role__answers"
                ng-class="{'role__answers--yes' :$index == 0 , 'role__answers--no' : ( $index + 1) == standard.answer_choicesDisplay.length, 'role__answers--dev' : level == 'developing'}">
                <input type="checkbox" checklist-model="standard.ideal_answer" checklist-value="level.value" disabled>@{{level.value}}
                </label>
                <button class="btn-pvm btn-primary btn-mini" ng-show="standard.answer_type.indexOf('file_upload') > -1">Upload</button>
            </div>
            <textarea class="" ng-show="standard.answer_type.indexOf('free_text') > -1"></textarea>
            <div class="preview__video" ng-show="standard.answer_type.indexOf('video') > -1"><i class="fa fa-play"></i></div>
            </li>
        </ul>
        </div>
    </section>
    
    </div>