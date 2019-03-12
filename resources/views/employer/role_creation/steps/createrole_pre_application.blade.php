<form>
    <h2 class="role__label">Pre-Approval Questions</h2>
    <!--<a href="#" class="btn-pvm btn-mini btn-primary role__pull-btn--pre-app">Pull from Existing</a>-->
    <p class="role__description">Optional. When a candidate applies for your job, if they “fail” any of your pre-approval questions, they will not be able to proceed with their application. Make sure your questions are direct. You may choose more than one required answer.</p>
    <div class="role__inspirations" ng-init="insp = false">
        <h3 class="role__sublabel">Stuck? Have some inspiration</h3>
        <i class="fa" ng-click="insp = !insp" ng-class="{'fa-minus' : insp, 'fa-plus' : !insp}"></i>
        <p class="role__subdesc" ng-show="insp">Here are some question suggestions. Simply drag & drop the snippets into your questions text box</p>
        <ul class="role__inspiration-list" ng-show="insp">
        <li class="role__inspiration-item" ng-repeat="inspirationItem in preInspirationList" ng-click="pushInspirationPre(inspirationItem)">@{{inspirationItem.name}}</li>
        </ul>
        <i class="fa fa-spinner fa-spin fa-3x fa-fw" ng-show="loading_insp"></i>
        <span class="role__shuffle" ng-show="insp" ng-click="shuffle_preapp()">
        <i class="fa fa-random"></i>
    </span>
    </div>
    <div class="role__bespoke" ng-init="bespoke = false">
        <h3 class="role__sublabel">Bespoke Subscription only questions</h3>
        <i class="fa" ng-click="bespoke = !bespoke" ng-class="{'fa-minus' : insp, 'fa-plus' : !insp}"></i>
        <p class="role__subdesc" ng-show="bespoke">Here are some more in-depth questions that you may want to ask your candidates.</p>
        <ul class="role__bespoke-list" ng-show="bespoke">
        <li class="role__bespoke-item" ng-repeat="beSpokeTagItem in beSpokeTagList">
            <span ng-click="pushBespoke(beSpokeTagItem, beSpokeTagItem.beSpokeUnique)">@{{beSpokeTagItem.tag_label}}</span>
            <div class="bespoke__tooltip" ng-show="beSpokeTagItem.beSpokeUniqueShow">
                <i class="fa fa-close" ng-click="closeBeSpoke($index)"></i>
            <p class="pvm-arrow-msg">You already have add this as pre-application question. Please check your list below.</p>
            <div class="pvm-arrow-down"></div>
            </div>
        </li>
        </ul>
        <!--<span class="role__shuffle" ng-show="bespoke">
        <i class="fa fa-random"></i>
        </span> rca 237-->
    </div>
    <ul class="role__QandA-list">
        <li class="role__QandA-item" ng-repeat="PreApprovalQuestion in PreApprovalQuestions" ng-mouseleave="checkMyBack()">
        <span class="role__QandA">Q.</span>
        <span class="role__QandA-details">
            <textarea class="role__questions" ng-model="PreApprovalQuestion.question" ng-blur="checkMyBack()"></textarea>
        </span>
        <span class="role__QandA">A.</span>
        <span class="role__QandA-details">@{{PreApIdealAnswer[PreApprovalQuestion.id]}}
            <h5 class="role__sublabel role__sublabel--answers" ng-if="PreApprovalQuestion.type == 'custom_pre_apply_1' || PreApprovalQuestion.type == 'gpa'">@{{PreApprovalQuestion.answer_label}}</h5>
    
            <select ng-model="PreApprovalQuestion.GPAval" ng-show="PreApprovalQuestion.type=='custom_pre_apply_1' || PreApprovalQuestion.type == 'gpa'" ng-change="changeGPA(PreApprovalQuestion.GPAval, $index)" ng-options="GPAItem.value as GPAItem.label for GPAItem in GPAList" class="pvm-select role__GPA-list" ng-blur="checkMyBack()"></select>
    
            <label ng-repeat="level in levels" ng-if="PreApprovalQuestion.type!='custom_pre_apply_1' && PreApprovalQuestion.type != 'gpa' && PreApprovalQuestion.type!='custom_pre_apply_2'" class="role__answers"
                    ng-class="{'role__answers--yes' :level == 'yes' , 'role__answers--no' :level == 'no', 'role__answers--dev' :level == 'developing', 'role__answers--answered' : (level =='yes' && PreApprovalQuestion.levelYes) || (level =='developing' && PreApprovalQuestion.levelDev) || (level =='no' && PreApprovalQuestion.levelNo)}">
            <input type="checkbox" checklist-model="PreApprovalQuestion.ideal_answer" checklist-value="level" ng-blur="checkMyBack()"> @{{level}}
            </label>
            <label class="role__disqualify-can role__disqualify-can--full" ng-if="PreApprovalQuestion.type=='custom_pre_apply_1' || PreApprovalQuestion.type == 'gpa'" ng-show="PreApprovalQuestion.sub_questions">
            <input type="checkbox" ng-model="PreApprovalQuestion.condition" ng-checked="PreApprovalQuestion.condition" ng-blur="checkMyBack()"><span> Prompt candidate to explain grades. </span>
            </label>
    
            <div class="r-zslider" ng-if="PreApprovalQuestion.type == 'custom_pre_apply_2'">
            <rzslider
                rz-slider-model="PreApprovalQuestion.slider.min"
                rz-slider-options="PreApprovalQuestion.slider.options" ng-model="PreApprovalQuestion.ideal_answer[0]" title="">
            </rzslider>
            </div>
    
            <label class="role__disqualify-can" ng-if="PreApprovalQuestion.type!='custom_pre_apply_1' && PreApprovalQuestion.type != 'gpa'">
            <input type="checkbox" ng-model="PreApprovalQuestion.decides_outcome" ng-checked="PreApprovalQuestion.decides_outcome" ng-blur="checkMyBack()"> Disqualify candidate if answer doesn't match
            </label>
    
            <ul ng-show="PreApprovalQuestion.condition && PreApprovalQuestion.type == 'gpa' && PreApprovalQuestion.type != 'custom_pre_apply_2'">
            <li ng-repeat="subQuestion in PreApprovalQuestion.sub_questions">
                <span class="role__QandA role__QandA--sub">Q.</span>
                <span class="role__QandA-details role__QandA-details--sub">
                <textarea class="role__questions" ng-blur="checkMyBack()">@{{subQuestion.question}}</textarea>
                </span>
                <span class="role__QandA role__QandA--sub">A.</span>
                <span class="role__QandA-details role__QandA-details--sub">
                <label class="role__disqualify-can role__disqualify-can--inline role__disqualify-can--one" ng-repeat="mychoice in subQuestion.mychoices">
                    <input type="checkbox" checklist-model="mychoice.ideal_answerR" ng-checked="mychoice.appear" checklist-value="mychoice.label" ng-blur="checkMyBack()"> @{{mychoice.label}}
                </label>
                </span>
            </li>
            </ul>
    
            <!-- BeSpoke sub question slider BEGIN -->
            <ul ng-show="PreApprovalQuestion.type == 'custom_pre_apply_2' && PreApprovalQuestion.sub_questions">
            <li ng-repeat="subQuestion_slider in PreApprovalQuestion.sub_questions">
                <span class="role__QandA role__QandA--sub">Q. </span>
                <span class="role__QandA-details role__QandA-details--sub">
                <textarea class="role__questions" ng-blur="checkMyBack()">@{{subQuestion_slider.question}}</textarea>
                </span>
                <span class="role__QandA role__QandA--sub">A.</span>
                <div class="r-zslider">
                <rzslider
                    rz-slider-model="subQuestion_slider.slider.min"
                    rz-slider-options="subQuestion_slider.slider.options" ng-model="subQuestion_slider.ideal_answer" title="">
                </rzslider>
                </div>
    
            </li>
            </ul>
            <!-- BeSpoke sub question slider END -->
            <label class="role__disqualify-can role__disqualify-can--full" ng-if="PreApprovalQuestion.type=='custom_pre_apply_1' || PreApprovalQuestion.type == 'gpa'">
            <input type="checkbox" ng-model="PreApprovalQuestion.decides_outcome" ng-checked="PreApprovalQuestion.decides_outcome" ng-blur="checkMyBack()"> Disqualify candidates who do not meet your preferred minimum GPA.
    
            </label>
        </span>
        <span class="role__close-btn"><i class="fa fa-close" ng-click="deleteQuestion(PreApprovalQuestion)"></i></span>
        </li>
        <!--<li class="role__QandA-item" ng-repeat="beSpokeMyItem in beSpokeMyList">
        <span class="role__QandA">Q.</span>
        <span class="role__QandA-details">
            <textarea class="role__questions" ng-model="beSpokeMyItem.question_data.question"></textarea>
        </span>
        <span class="role__QandA">A.</span>
        <span class="role__QandA-details">
            <h5 class="role__sublabel role__sublabel--answers">@{{beSpokeMyItem.question_data.answer_label}}</h5>
            <select ng-model="GPAListToSel" ng-options="GPAItem as GPAItem.label for GPAItem in GPAList track by GPAItem.value" class="pvm-select role__GPA-list" ng-if="beSpokeMyItem.q == 'GPA'"></select>
            <select ng-model="SkillrangeItemSel" ng-options="SkillrangeItem as SkillrangeItem.label for SkillrangeItem in Skillrange track by SkillrangeItem.value" class="pvm-select role__GPA-list" ng-if="beSpokeMyItem.q == 'Comm Skills'"></select>
            <label class="role__disqualify-can">
            <input type="checkbox" ng-model="beSpokeMyItem.question_data.decides_outcome"> @{{beSpokeMyItem.decides_outcome_label}}
            </label>
            <label class="role__disqualify-can role__disqualify-can--full" ng-if="beSpokeMyItem.q == 'GPA'">
            <input type="checkbox" ng-model="beSpokeMyItem.question_data.isSubOpen"><span>Prompt candidate to explain grades.</span>
            </label>
            <label class="role__disqualify-can role__disqualify-can--full" ng-if="beSpokeMyItem.q == 'Comm Skills'">
            <input type="checkbox" ng-model="beSpokeMyItem.question_data.isSubOpen"><span>Prompt candidate to explain answer.</span>
            </label>
            <ul ng-if="beSpokeMyItem.question_data.isSubOpen">
            <li ng-repeat="subQuestion in beSpokeMyItem.question_data.sub_questions">
                <span class="role__QandA role__QandA--sub">Q.</span>
                <span class="role__QandA-details role__QandA-details--sub">
                <textarea class="role__questions">@{{subQuestion.question}}</textarea>
                </span>
                <span class="role__QandA role__QandA--sub">A.</span>
                <span class="role__QandA-details role__QandA-details--sub">
                <label class="role__disqualify-can role__disqualify-can--inline" ng-repeat="requiredAn in requiredAns">
                    <input type="checkbox" checklist-model="subQuestion.requiredAnsSel" checklist-value="requiredAn.label"> @{{requiredAn.label}}
                </label>
                </span>
            </li>
            </ul>
        </span>
        <span class="role__close-btn" ng-click="removeFromMyList(beSpokeMyItem)"><i class="fa fa-close"></i></span>
        </li>
        <li class="role__QandA-item">
        <span class="role__QandA">Q.</span>
        <span class="role__QandA-details">
            <textarea class="role__questions">Do you have permission to work in [country of role]</textarea>
        </span>
        <span class="role__QandA">A.</span>
        <span class="role__QandA-details">
            <h5 class="role__sublabel role__sublabel--answers">Set your preferred work permissions:</h5>
            <label class="role__answers-mult" ng-repeat="workPerm in workPerms">
            <input type="checkbox" checklist-model="workPermSel" checklist-value="workPerm"> @{{workPerm}}
            </label>
            <label class="role__disqualify-can role__disqualify-can--full">
            <input type="checkbox" ng-model="disqualifyPre"> Disqualify candidates who are not permitted to work in your role’s selected country.
            </label>
            <label class="role__disqualify-can role__disqualify-can--full">
            <input type="checkbox" ng-model="isVisaType"> If candidate selects “Visa” prompt them to specify their Visa type..
            </label>
            <span class="role__QandA role__QandA--sub">Q.</span>
            <span class="role__QandA-details role__QandA-details--sub">
            <textarea class="role__questions">Please specify the type of Visa you have.</textarea>
            </span>
            <span class="role__QandA role__QandA--sub">A.</span>
            <span class="role__QandA-details role__QandA-details--sub">
            <label class="role__disqualify-can role__disqualify-can--inline">
                <input type="checkbox" ng-model="isText"> Text
            </label>
            <label class="role__disqualify-can role__disqualify-can--inline">
                <input type="checkbox" ng-model="isVideo"> Video
            </label>
            </span>
        </span>
        <span class="role__close-btn"><i class="fa fa-close"></i></span>
        </li>-->
    </ul>
    <a href="" class="btn-pvm btn-mini btn-primary role__add-pre-app" ng-click="addBlankPreApp()">Add</a>
    
    </form>