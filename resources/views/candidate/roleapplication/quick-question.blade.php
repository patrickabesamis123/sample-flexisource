<section class="middle-pane middle-pane--ra tab-pane active in" id="quick-question">
    <div ng-show="role_app_tab_loader == 1" class="ar__loader-div hidden">
        <h3>Please wait.</h3>
        <h4>While we prepare this page for you.</h4>
        <div class="cssload-loading"><i></i><i></i><i></i><i></i></div>
    </div>

    {{-- REMOVE "hidden" class if incompelete submission --}}
    <div class="ar__disclaimer hidden">
        <i class="fa fa-info-circle"></i> <span class="ar__disclaimer-msg">This section must be completed and submitted in the same session</span>
    </div>

    <div class="ar__main-div">
        <div class="ar__quickquestion-content-div">
            <h1 class="ar__main-headers">Pre-application Questions</h1>
            <div class="ar__quickquestion-qlist">
                <ul class="app__pre-apply-list">
                    <li class="app__pre-apply-item">
                        <div class="ar__quickquestion-qitem">
                            <span class="ar__quickquestion-qitem-number">1</span>
                            <p class="ar__quickquestion-qitem-item">Do you have experience working as an Accountant either in an advisory or internal capacity?</p>
                        </div>
                        <div class="ar__quickquestion-choices clear-float">                            
                            <label class="role__answers role__answers--yes role__answers--answered" @click="isActive = !isActive" :class="{'role__answers--answered': isActive}">
                                <input name="pre_7003" type="radio" value="yes"> yes
                            </label> 
                            <label class="role__answers role__answers--dev">
                                <input name="pre_7003" type="radio" value="developing"> developing
                            </label> <label class="role__answers role__answers--no"><input name="pre_7003" type="radio" value="no"> no</label> 
                        </div>
                        <hr>
                    </li>
                    <li class="app__pre-apply-item">
                        <div class="ar__quickquestion-qitem">
                            <span class="ar__quickquestion-qitem-number">2</span>
                            <p class="ar__quickquestion-qitem-item">Do you have thorough knowledge of accounting principles and procedures (GAAP and IFRS)?</p>
                        </div>
                        <div class="ar__quickquestion-choices clear-float">
                            
                            <label class="role__answers role__answers--yes">
                                <input name="pre_7004" type="radio" value="yes"> yes</label> 
                            <label class="role__answers role__answers--dev role__answers--answered"><input name="pre_7004" type="radio" value="developing"> developing</label> 
                            <label class="role__answers role__answers--no"><input name="pre_7004" type="radio" value="no"> no</label> 
                        </div>
                        <hr>
                    </li>
                    <li class="app__pre-apply-item">
                        <div class="ar__quickquestion-qitem">
                            <span class="ar__quickquestion-qitem-number">3</span>
                            <p class="ar__quickquestion-qitem-item">Please tell us what your GPA is for Term A paper?</p>
                        </div>
                        <div class="ar__quickquestion-choices clear-float">
                            <ul class="radio__options-list radio__options-list--gpa">
                                <li class="radio__options-item"><label class="role__answers"><input class=" ng-valid-required" name="267" type="radio" value="11"> A+</label></li>
                                <li class="radio__options-item"><label class="role__answers"><input class=" ng-valid-required" name="269" type="radio" value="10"> A</label></li>
                                <li class="radio__options-item"><label class="role__answers"><input class=" ng-valid-required" name="271" type="radio" value="9"> A-</label></li>
                                <li class="radio__options-item"><label class="role__answers"><input class=" ng-valid-required" name="273" type="radio" value="8"> B+</label></li>
                                <li class="radio__options-item"><label class="role__answers"><input class=" ng-valid-required" name="275" type="radio" value="7"> B</label></li>
                                <li class="radio__options-item"><label class="role__answers"><input class=" ng-valid-required" name="277" type="radio" value="6"> B-</label></li>
                                <li class="radio__options-item"><label class="role__answers"><input class=" ng-valid-required" name="279" type="radio" value="5"> C+</label></li>
                                <li class="radio__options-item"><label class="role__answers role__answers--answered"><input class=" ng-valid-required" name="281" type="radio" value="4"> C</label></li>
                                <li class="radio__options-item"><label class="role__answers"><input class=" ng-valid-required" name="283" type="radio" value="3"> C-</label></li>
                                <li class="radio__options-item"><label class="role__answers"><input class=" ng-valid-required" name="285" type="radio" value="2"> D</label></li>
                                <li class="radio__options-item"><label class="role__answers"><input class=" ng-valid-required" name="287" type="radio" value="1"> E</label></li>
                                <li class="radio__options-item"><label class="role__answers"><input class=" ng-valid-required" name="289" type="radio" value="0"> F</label></li>
                            </ul>
                            <ul class="ar__sub-list" nng-if="q.sub_questions &amp;&amp; (((q.type == 'gpa' || q.type == 'custom_pre_apply_1') &amp;&amp; promptCandidate) || (q.type != 'gpa' &amp;&amp; q.type != 'custom_pre_apply_1'))">
                                <li class="ar__sub-item" nng-repeat="subs in q.sub_questions">
                                    <p class="ar__quickquestion-qitem-item">If there is anything which has affected your grades please explain below</p>
                                    <textarea class="ar__quickquestion-qans-text ng-pristine ng-untouched ng-empty ng-invalid ng-invalid-required" ng-change="submit_preapply(subs.id, subs.answer, subs)" ng-model="subs.answer" placeholder="Type here.." required=""></textarea> <!-- ngIf: subs.type == 'custom_pre_apply_2_sub' -->
                                </li>
                            </ul>
                        </div>
                        <hr>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>
