<section class="general-info middle-pane middle-pane--ra tab-pane" id="general-info">
    <div ng-show="role_app_tab_loader == 1" class="ar__loader-div ng-hide">
        <h3>Please wait.</h3>
        <h4>While we prepare this page for you.</h4>
        <div class="cssload-loading"><i></i><i></i><i></i><i></i></div>
    </div>

    {{-- REMOVE "hidden" class if incompelete submission --}}
    <div class="ar__disclaimer hidden">
        <i class="fa fa-info-circle"></i> <span class="ar__disclaimer-msg">This section must be completed and submitted in the same session</span>
    </div>
    <div ng-show="role_app_tab_loader == 0" class="">
        
        <!-- ngIf: active_tab == stepstab.showPre -->
        
        
        <!-- ngIf: active_tab == stepstab.showReq -->
        <div class="ar__main-div ng-scope" nng-if="active_tab == stepstab.showReq" ng-controller="TellUsCtrl" ng-show="tabs.showReq">
            <nav class="section-menu" @scroll="handleScroll" :class="{ 'sticky': scrolled }">
                <a href="#photo"><span class="section-menu__title">Photo</span><i class="fas fa-circle"></i></a>
                <a href="#general-details" title=""><span class="section-menu__title">General Details</span><i class="fas fa-circle"></i></a>
                <a href="#generic-profile-video"><span class="section-menu__title">Generic Profile Video</span><i class="fas fa-circle"></i></a>
                <a href="#education-history"><span class="section-menu__title">Education History</span><i class="fas fa-circle"></i></a>
                <a href="#work-experience"><span class="section-menu__title">Work Experience</span><i class="fas fa-circle"></i></a>
                <a href="#supporting-documents"><span class="section-menu__title">Supporting Documents</span><i class="fas fa-circle"></i></a>
                <a href="#references"><span class="section-menu__title">References</span><i class="fas fa-circle"></i></a>
            </nav>
            <div class="ar__tellus-content-div">
                <h1 class="ar__main-headers">General Profile Information</h1>
                <div class="ar__tellus-details-div">

                    <div class="ar__tellus-details-inner" id="photo"> 
                        <h5 class="ar__headers">photo</h5>
                        <div class="ar__tellus-general-div">
                            <div class="photo">
                                <!-- ngIf: !resProfile.docs.profile_image -->
                                <!-- ngIf: resProfile.docs.profile_image -->
                                <img class="photo__image" src="https://pvmlive.blob.core.windows.net/ggdtscc7/b9788a75c392ebe7c33ad7de9a7c727c.png"><!-- end ngIf: resProfile.docs.profile_image -->
                                <button class="btn-add" data-toggle="modal" data-target="#pmvImageModalNew">Upload Image</button>
                            </div>
                        </div>
                        <hr>
                    </div>
                
                    <div class="ar__tellus-details-inner" id="general-details">
                        <form class="ar__form ng-pristine ng-valid ng-valid-required" id="candidateForm" name="candidateForm" ng-submit="saveGenInfo()">
                            <h5 class="ar__headers">general details</h5>
                            <ul class="ar__gen-info-list">
                                <li class="ar__gen-info-item"><input class="pvm-input-text ng-pristine ng-untouched ng-not-empty ng-valid ng-valid-required" ng-model="resProfile.first_name" ng-required="!resProfile.first_name" placeholder="First name" type="text"></li>
                                <li class="ar__gen-info-item ar__gen-info-item--rt"><input class="pvm-input-text ng-pristine ng-untouched ng-not-empty ng-valid ng-valid-required" ng-model="resProfile.last_name" ng-required="!resProfile.last_name" placeholder="Last name" type="text"></li>
                                <li class="ar__gen-info-item"><input class="pvm-input-text ng-pristine ng-untouched ng-not-empty ng-valid ng-valid-required" ng-model="resProfile.email" ng-required="!resProfile.email" placeholder="Email Address" type="text"></li>
                                <li class="ar__gen-info-item ar__gen-info-item--rt"><input class="pvm-input-text ng-pristine ng-untouched ng-not-empty ng-valid ng-valid-required" ng-model="resProfile.phone_number" ng-required="!resProfile.phone_number" placeholder="Mobile" type="text"></li>
                                <li class="ar__gen-info-item"><input class="pvm-input-text" ng-model="resProfile.preferred_location.data.display_name" placeholder="Location" type="text"></li>
                                <li class="ar__gen-info-item ar__gen-info-item--rt"><input class="pvm-input-text" ng-model="resProfile.preferred_location.data.country.display_name" placeholder="Sublocation" type="text"></li>
                                <li class="ar__gen-info-item ar__gen-info-item--full">
                                    <label for="" class="text-label"><input type="checkbox" name="" id=""> I'm willing to relocate</label>
                                </li>
                                <li class="ar__gen-info-item ar__gen-info-item--full">
                                    <span class="ar__app-req ar__app-req--left ar__app-req--icon ar__app-req--about ng-hide" ng-show="company.application_requirements.about_me=='yes' &amp;&amp; (resProfile.long_description.length &lt;= 0 || resProfile.long_description == NULL)"></span>
                                    <div class="ar__tooltip ng-hide" ng-show="showPvmMessageBout">
                                        <span class="ar__app-req ar__app-req--left ar__app-req--icon ar__app-req--about ng-hide" ng-show="company.application_requirements.about_me=='yes' &amp;&amp; (resProfile.long_description.length &lt;= 0 || resProfile.long_description == NULL)"><i class="fa fa-close" ng-click="showPvmMessageBout=true"></i></span>
                                        <p class="pvm-arrow-msg"><span class="ar__app-req ar__app-req--left ar__app-req--icon ar__app-req--about ng-hide" ng-show="company.application_requirements.about_me=='yes' &amp;&amp; (resProfile.long_description.length &lt;= 0 || resProfile.long_description == NULL)">About me section is required by this role.</span></p>
                                        <div class="pvm-arrow-down">
                                            <span class="ar__app-req ar__app-req--left ar__app-req--icon ar__app-req--about ng-hide" ng-show="company.application_requirements.about_me=='yes' &amp;&amp; (resProfile.long_description.length &lt;= 0 || resProfile.long_description == NULL)"></span>
                                        </div>
                                    </div><span class="ar__app-req ar__app-req--left ar__app-req--icon ar__app-req--about ng-hide" ng-show="company.application_requirements.about_me=='yes' &amp;&amp; (resProfile.long_description.length &lt;= 0 || resProfile.long_description == NULL)"><i class="fa fa-asterisk" ng-click="showPvmMessageBout =! showPvmMessageBout" ng-mouseleave="showPvmMessageBout=false" ng-mouseover="showPvmMessageBout=true"></i></span> <span class="ar__app-req ar__app-req--left ar__app-req--icon ar__app-req--about" ng-show="company.application_requirements.about_me=='yes' &amp;&amp; (resProfile.long_description.length &gt; 0)"></span>
                                    <div class="ar__tooltip ng-hide" ng-show="showPvmMessageBout">
                                        <span class="ar__app-req ar__app-req--left ar__app-req--icon ar__app-req--about" ng-show="company.application_requirements.about_me=='yes' &amp;&amp; (resProfile.long_description.length &gt; 0)"><i class="fa fa-close" ng-click="showPvmMessageBout=true"></i></span>
                                        <p class="pvm-arrow-msg"><span class="ar__app-req ar__app-req--left ar__app-req--icon ar__app-req--about" ng-show="company.application_requirements.about_me=='yes' &amp;&amp; (resProfile.long_description.length &gt; 0)">You already have filled up this section and can proceed with the application but you're free to update this before moving to next step.</span></p>
                                        <div class="pvm-arrow-down">
                                            <span class="ar__app-req ar__app-req--left ar__app-req--icon ar__app-req--about" ng-show="company.application_requirements.about_me=='yes' &amp;&amp; (resProfile.long_description.length &gt; 0)"></span>
                                        </div>
                                    </div><span class="ar__app-req ar__app-req--left ar__app-req--icon ar__app-req--about" ng-show="company.application_requirements.about_me=='yes' &amp;&amp; (resProfile.long_description.length &gt; 0)"><i class="fa fa-exclamation-triangle hidden" ng-click="showPvmMessageBout =! showPvmMessageBout" ng-mouseleave="showPvmMessageBout=false" ng-mouseover="showPvmMessageBout=true"></i></span> 
                                    <textarea class="pvm-textarea ar__gen-info-about" ng-model="resProfile.long_description" placeholder="Take this opportunity to introduce yourself and highlight what makes you unique. Think personal and professional attributes, career goals, skills, achievements, sport, community, teamwork, languages..."></textarea>
                                </li>
                                <li class="ar__gen-info-item ar__gen-info-item--full ar__gen-info-item--rt"><i class="fa fa-spinner fa-spin pvm-spinner pvm-spinner--sm ng-hide" ng-show="loadGen"></i> 
                                    <button class="btn-pvm btn-mini btn-primary" name="Save" ng-disabled="loadGen" type="submit">Save</button>
                                    <input type="button" name="Cancel" value="Cancel" class="btn-pvm btn-mini btn-default">
                                </li>
                            </ul>
                            <hr>
                        </form>
                    </div>
                
                    <div class="ar__tellus-details-inner" id="generic-profile-video">
                        <h5 class="ar__headers">Generic Profile Video</h5>
                        <div class="ar__main-div ar__negate-margin ng-scope" ng-controller="MakeVideoCtrl" nng-if="active_tab == stepstab.showVideo">
                            <div class="ar__video-content-div" ng-hide="showVid">    
                                <div class="clearfix"></div>
                                <div class="video__big-thumbnail-div">
                                    <div class="jumbotron text-center">
                                        {{-- <h1>Start by choosing an existing video <br> or record a new one below!</h1> --}}

                                        {{-- video status = nothing --}}
                                        <h1>No video has been found yet. <br> Start by uploading a video <br> or record a new one below.</h1>
                                    </div>
                                    
                                    <div class="video__big-thumbnail-innner-div ng-hide" ng-show="showVideoLoding">
                                        <video height="500" poster="themes/bbt/images/video_preload.gif"></video>
                                    </div>
                                    <div class="text-center video__big-thumbnail-innner-div--success ng-hide" ng-show="VideoStatus == 'uploading'">
                                        <div>
                                            <h4>Uploaded file is now being processed</h4>
                                        </div>
                                        <div style="margin-bottom: 25px">
                                            Please do not refresh this page. There is no need to wait for the processing to finish. Go ahead and click Next.
                                        </div>
                                    </div>
                                </div>
                                <div style="font-size: 14px; line-height: 24px;">
                                    <a href="https://previewme.co/resources/icebreaker-video/" target="_blank">Tips to record the perfect video</a>
                                </div>
                                {{-- <div class="video__delete-button" ng-show="showDeleteVideo">
                                    <button class="btn-pvm btn-primary btn-mini" ng-click="deleteVideo()" value="Delete"><i class="fa fa-trash"></i> Delete</button>
                                </div> --}}
                            </div>
                        </div>

                        <div class="clearfix"></div>

                        <div class="ar__video-lib-div">
                            <div class="video__create-div">
                                <h5>Create a New Video</h5>
                                <div class="video__createrec-div">
                                    <div class="video__createrec-inner-div">
                                        <div class="clearfix video__createrec-details">
                                            <p class="video__createrec-details-p"><i class="fa fa-upload video__upload-logo"></i></p>
                                            <p class="video__createrec-details-p"></p>
                                            <div class="video__upload-label">
                                                Drag &amp; drop or upload your video
                                            </div>
                                            <p></p>
                                        </div><input class="btn-pvm btn-primary" name="" type="button" value="Browse" data-toggle="modal" data-target="#pmvCameraModalNew">
                                    </div>
                                    <div class="video__createrec-inner-div">
                                        <div class="clearfix video__createrec-details">
                                            <p class="video__createrec-details-p"><i class="fa fa-upload video__upload-logo"></i></p>
                                            <p class="video__createrec-details-p"></p>
                                            <div class="video__upload-label">
                                                Record a new video
                                            </div>
                                            <p></p>
                                        </div><input class="btn-pvm btn-primary" data-toggle="modal" name="" type="button" value="Start" data-toggle="modal" data-target="#pmvCameraModalNew">
                                    </div>
                                </div>
                            </div>
                            <div class="video__divider-div"></div>
                            {{-- <div class="video__create-div">
                                <h5>Choose from your video library</h5>
                                <div class="video__createrec-div video-lib-wrap">
                                    <div class="video-lib">
                                        <div class="video__choose-inner-div">
                                            <div class="clearfix video__choose-details">
                                                <i class="fa fa-play video__choose-logo"></i>
                                            </div>
                                            <p>junior-designer_application.mov</p>
                                        </div>
            
                                        <div class="video__choose-inner-div">
                                            <div class="clearfix video__choose-details">
                                                <i class="fa fa-play video__choose-logo"></i>
                                            </div>
                                            <p>senior-designer_application.mov</p>
                                        </div>
            
                                        <div class="video__choose-inner-div">
                                            <div class="clearfix video__choose-details">
                                                <i class="fa fa-play video__choose-logo"></i>
                                            </div>
                                            <p>my_third_icebreaking_video.mov</p>
                                        </div>
            
                                        <div class="video__choose-inner-div">
                                            <div class="clearfix video__choose-details">
                                                <i class="fa fa-play video__choose-logo"></i>
                                            </div>
                                            <p>web-designer-UIUX-application-video.mov</p>
                                        </div>
            
                                        <div class="video__choose-inner-div">
                                            <div class="clearfix video__choose-details">
                                                <i class="fa fa-play video__choose-logo"></i>
                                            </div>
                                            <p>old_but_gold.mov</p>
                                        </div>
            
                                        <div class="video__choose-inner-div">
                                            <div class="clearfix video__choose-details">
                                                <i class="fa fa-play video__choose-logo"></i>
                                            </div>
                                            <p>old_but_gold.mov</p>
                                        </div>
            
                                        <div class="video__choose-inner-div">
                                            <div class="clearfix video__choose-details">
                                                <i class="fa fa-play video__choose-logo"></i>
                                            </div>
                                            <p>old_but_gold.mov</p>
                                        </div>
            
                                        <div class="video__choose-inner-div">
                                            <div class="clearfix video__choose-details">
                                                <i class="fa fa-play video__choose-logo"></i>
                                            </div>
                                            <p>old_but_gold.mov</p>
                                        </div>
            
                                        <div class="video__choose-inner-div">
                                            <div class="clearfix video__choose-details">
                                                <i class="fa fa-play video__choose-logo"></i>
                                            </div>
                                            <p>old_but_gold.mov</p>
                                        </div>
            
                                        <div class="video__choose-inner-div">
                                            <div class="clearfix video__choose-details">
                                                <i class="fa fa-play video__choose-logo"></i>
                                            </div>
                                            <p>old_but_gold.mov</p>
                                        </div>
                                        <div class="clearfix"></div>
            
                                    </div>
                                </div>
                            </div> --}}
                            <div class="clearfix"></div>
                        </div>
                    </div>

                    <div class="ar__tellus-details-inner" id="education-history">
                        <h5 class="ar__headers">
                        Education History
                            <span class="ar__app-req ar__app-req--left ar__app-req--icon  ar__app-req--inline" ng-show="resProfile.qualifications.length > 0">
                                <div class="ar__tooltip ng-hide" ng-show="showPvmMessageEH">
                                    <i class="fa fa-close" ng-click="showPvmMessageEH=false"></i>
                                    <p class="pvm-arrow-msg">You already have education history and can proceed with the application but you're free to update this before moving to next step.</p>
                                    <div class="pvm-arrow-down"></div>
                                </div>
                                <i class="fa fa-exclamation-triangle hidden" ng-click="showPvmMessageEH =! showPvmMessageEH" ng-mouseover="showPvmMessageEH=true" ng-mouseleave="showPvmMessageEH=false"></i>
                            </span>
                        </h5>
                        <ul class="ar__edu-list">
                            <!-- ngRepeat: esp in resProfile.qualifications -->
                            <li class="ar__edu-item ng-scope" nng-repeat="esp in resProfile.qualifications">
                                
                                <div class="ar__edu-funcs">
                                    <button class="btn-link" @click="editEduc = !editEduc"><i class="fa fa-pencil" title="Update"></i></button>
                                    <i class="fa fa-trash-o" title="Delete" ng-hide="loadDelESP &amp;&amp; esp.id == loadDelESPId"></i>
                                    <i class="fa fa-spinner fa-spin ng-hide" title="Please wait..." ng-show="loadDelESP &amp;&amp; esp.id == loadDelESPId"></i>
                                </div>
                                <div :class="{'hidden': editEduc}">
                                    <h3 class="ar__edu-deg ar__edu-deg--full">Doctor of Medicine (M.D) Other Health</h3>
                                    <h3 class="ar__edu-university ar__edu-university--full">City Impact Church School (Secondary), North Shore, New Zealand</h3>
                                    <h4 class="ar__completed">20-11-2018</h4>
                                    <!-- ngIf: esp.qualification_provider.company_logo.length > 0 || esp.qualification_provider.company_logo.length != null -->
                                </div>

                                <div class="ar__edu-field">
                                    <form name="" class="form-edit" :class="{'hidden': !editEduc}">
                                        <div class="provider_holder">
                                            <input type="text" class="pvm-input-text" name="" placeholder="Education provider" value="City Impact Church School (Secondary), North Shore, New Zealand">
                                            <ul class="pvm-autocomplete-list auto_complete_education_edu ng-hide">
                                            <!-- ngRepeat: provider in selected_edu_providers | limitTo : 15 -->
                                            </ul>
                                        </div>
                                        <input type="text" class="pvm-input-text" name="" placeholder="Country" required>
                                        <select class="pvm-input-select tellus__general-textbox" required>
                                                <option value="" disabled>Academic Degree</option>
                                                <option label="High School" value="string:High School">High School</option>
                                                <option label="Associate's Degree" value="string:Associate's Degree">Associate's Degree</option>
                                                <option label="Bachelor's Degree" value="string:Bachelor's Degree">Bachelor's Degree</option>
                                                <option label="Master's Degree" value="string:Master's Degree">Master's Degree</option>
                                                <option label="Master of Business Administrtion (M.B.A)" value="string:Master of Business Administrtion (M.B.A)">Master of Business Administrtion (M.B.A)</option>
                                                <option label="Juris Doctor (J.D)" value="string:Juris Doctor (J.D)">Juris Doctor (J.D)</option>
                                                <option label="Doctor of Medicine (M.D)" value="string:Doctor of Medicine (M.D)" selected="selected">Doctor of Medicine (M.D)</option>
                                                <option label="Doctor of Philosophy (Ph.D)" value="string:Doctor of Philosophy (Ph.D)">Doctor of Philosophy (Ph.D)</option>
                                                <option label="Engineer's Degree" value="string:Engineer's Degree">Engineer's Degree</option>
                                                <option label="Other" value="string:Other">Other</option>
                                        </select>
                                        <div class="clearfix qualification_holder">
                                            <input type="text" class="pvm-input-text" name="" placeholder="Field of study" value="Other Medicine" ng-keyup="qualificationWatch()" data-id="1315" required>
                                            <ul class="pvm-autocomplete-list auto_complete_qualifications ng-hide">
                                            <!-- ngRepeat: q in eduQualifications | limitTo : 15 -->
                                            </ul>
                                        </div>
                                        <input type="text" class="pvm-input-text mydatepicker" placeholder="Completed Date">
                                        <label>
                                            <input type="checkbox" id="toggle-yes" name="toggle1" ng-value="true" ng-model="educationHistory.edi_current_study" value="true"> I currently study here
                                        </label>
                                        <div class="ar__edu-field ar__edu-field--btn" ng-show="esp.id == editEH">
                                            <i class="fa fa-spinner fa-spin pvm-spinner pvm-spinner--sm ng-hide" ng-show="loadEditESP"></i>
                                            <button type="submit" name="Save" class="btn-pvm btn-mini btn-primary" ng-disabled="loadEditESP">Save</button>
                                            <input type="button" @click="editEduc = !editEduc" name="Cancel" value="Cancel" class="btn-pvm btn-mini btn-default" ng-click="cancelESP()">
                                        </div>
                                    </form>
                                </div>

                                <div class="ar__edu-field">
                                    <form name="" class="form-add" :class="{'hidden': !showEduc}">
                                        <div class="provider_holder">
                                            <input type="text" class="pvm-input-text" name="" placeholder="Education provider" value="" required>
                                            <ul class="pvm-autocomplete-list auto_complete_education_edu ng-hide">
                                            <!-- ngRepeat: provider in selected_edu_providers | limitTo : 15 -->
                                            </ul>
                                        </div>
                                        <input type="text" class="pvm-input-text" name="" placeholder="Country" required>
                                        <select class="pvm-input-select tellus__general-textbox" required>
                                            <option value="" disabled selected>Academic Degree</option>
                                            <option label="High School" value="string:High School">High School</option>
                                            <option label="Associate's Degree" value="string:Associate's Degree">Doctor of Medicine (M.D)</option>
                                            <option label="Bachelor's Degree" value="string:Bachelor's Degree">Bachelor's Degree</option>
                                            <option label="Master's Degree" value="string:Master's Degree">Master's Degree</option>
                                            <option label="Master of Business Administrtion (M.B.A)" value="string:Master of Business Administrtion (M.B.A)">Master of Business Administrtion (M.B.A)</option>
                                            <option label="Juris Doctor (J.D)" value="string:Juris Doctor (J.D)">Juris Doctor (J.D)</option>
                                            <option label="Doctor of Medicine (M.D)" value="string:Doctor of Medicine (M.D)">Doctor of Medicine (M.D)</option>
                                            <option label="Doctor of Philosophy (Ph.D)" value="string:Doctor of Philosophy (Ph.D)">Doctor of Philosophy (Ph.D)</option>
                                            <option label="Engineer's Degree" value="string:Engineer's Degree">Engineer's Degree</option>
                                            <option label="Other" value="string:Other">Other</option>
                                        </select>
                                        <div class="clearfix qualification_holder">
                                            <input type="text" class="pvm-input-text" name="" placeholder="Field of study" value="" class="tellus__general-textbox ng-valid-required" ng-keyup="qualificationWatch()" data-id="1315" required>
                                            <ul class="pvm-autocomplete-list auto_complete_qualifications ng-hide">
                                            <!-- ngRepeat: q in eduQualifications | limitTo : 15 -->
                                            </ul>
                                        </div>
                                        <input type="text" class="pvm-input-text mydatepicker" placeholder="Completed Date">
                                        <label>
                                            <input type="checkbox" id="toggle-yes" name="toggle1" ng-value="true" ng-model="educationHistory.edi_current_study" value="true"> I currently study here
                                        </label>
                                        <div class="ar__edu-field ar__edu-field--btn" ng-show="esp.id == editEH">
                                            <i class="fa fa-spinner fa-spin pvm-spinner pvm-spinner--sm ng-hide" ng-show="loadEditESP"></i>
                                            <button type="submit" name="Save" class="btn-pvm btn-mini btn-primary" ng-disabled="loadEditESP">Save</button>
                                            <input type="button" @click="showEduc = !showEduc" name="Cancel" value="Cancel" class="btn-pvm btn-mini btn-default" ng-click="cancelESP()">
                                        </div>
                                    </form>
                                </div>
                            </li>
                            
                            <li class="ar__edu-item ar__edu-item--none ng-hide">
                                <span class="ar__app-req ng-hide" ng-show="company.application_requirements.education == 'yes' &amp;&amp; resProfile.qualifications.length <= 0"><i class="fa fa-exclamation"></i> Education History is required by this role.</span>
                            </li>
                        </ul>

                        <ul class="ar__edu-list ar__edu-list--add">
                            <li class="ar__edu-item ar__edu-item--r ar__edu-item--btn">
                                <div class="flexbox-c-c">
                                    <button class="btn-add" @click="showEduc = !showEduc" :class="{'hidden': showEduc || editEduc}"><i class="fa fa-plus"></i>Add Education</button>
                                </div>
                            </li>
                        </ul>
                    </div>
                
                    <div class="ar__tellus-details-inner" id="work-experience">
                        <h5 class="ar__headers">
                            Work Experience
                            <span class="ar__app-req ar__app-req--left ar__app-req--icon  ar__app-req--inline" ng-show="resProfile.work_history.length > 0">
                                <div class="ar__tooltip ng-hide" ng-show="showPvmMessageWH">
                                    <i class="fa fa-close" ng-click="showPvmMessageWH=false"></i>
                                    <p class="pvm-arrow-msg">You already have work experience and can proceed with the application but you're free to update this before moving to next step.</p>
                                    <div class="pvm-arrow-down"></div>
                                </div>
                                <i class="fa fa-exclamation-triangle hidden" ng-click="showPvmMessageWH =! showPvmMessageWH" ng-mouseover="showPvmMessageWH=true" ng-mouseleave="showPvmMessageWH=false"></i>
                            </span>
                        </h5>

                        <ul class="ar__wh-list">
                            <li class="ar__wh-item ng-scope" nng-repeat="wh in resProfile.work_history" ng-init="outerIndex = $index">
                                <div class="tellus__workexp-chevron">
                                    <button class="btn-link" @click="editWork = !editWork">
                                        <i class="fa fa-pencil" title="Update"></i>
                                    </button>
                                    <i class="fa fa-trash-o" title="Delete"></i>
                                    <i class="fa fa-spinner fa-spin ng-hide" title="Please wait..."></i>
                                </div>
                                
                                <div :class="{'hidden': editWork}">
                                    <h4 class="ar__wh-company-name ng-binding ng-scope" nng-if="( chvron != wh.id) || chvron == 0">ABC Law</h4>
                                    <h4 class="ar__wh-job-title ng-binding ng-scope" nng-if="( chvron != wh.id) || chvron == 0">Risk Manager</h4>
                                    <p class="ar__wh-completed ng-binding ng-scope" nng-if="( chvron != wh.id) || chvron == 0">July 2011 - March 2016 (4 year/s 8 month/s)</p>
                                    <p class="ar__wh-completed ng-binding ng-scope ng-hide">$ 0</p>
                                    <h4 class="ar__subheaders">Key accountabilities</h4>
                                    <ul class="ar__wh-accnt-list">
                                        <li class="ar__wh-accnt-item ar__wh-accnt-item--display ng-scope">
                                            <span class="ar__details ng-binding"> Conduct assessments to define and analyze possible risks</span>
                                        </li>
                                    </ul>

                                    <h4 class="ar__subheaders">Role in a nutshell</h4>
                                    <p class="ar__details ng-binding">Develop risk management controls and systems</p>

                                    <ul class="ar__wh-accnt-list">
                                        <li class="ar__wh-accnt-item ng-scope">
                                            <h4 class="ar__subheaders ng-binding">Call Centre &amp; Customer Service</h4>
                                            <h4 class="ar__details ng-binding">Sales - Inbound</h4>
                                        </li>
                                        <li class="ar__wh-accnt-item ar__wh-accnt-item--more"></li>
                                    </ul>
                                </div>
                                
                                <form name="" class="form-edit" :class="{'hidden': !editWork}">
                                    {{-- SHOW ON CLICK OF EDIT BUTTON --}}
                                        <input type="text" name="" class="pvm-input-text ar__wh-company-name ng-valid-required" value="ABC LAW">
                                        <input type="text" placeholder="Country" class="pvm-input-text" required="required">
                                        <input type="text" name="" class="pvm-input-text ng-valid-required" value="Risk Manager">
                                        <div class="flexbox-sb-c field-inline-2">
                                            <select name="work_type" ng-options="s.id as s.display_name for s in work_types_wh track by s.id" class="pvm-input-select ng-pristine ng-untouched ng-empty ng-invalid ng-invalid-required" ng-model="workHistory.work_type" ng-required="!workHistory.work_type" required="required"><option value="" disabled selected>Work Type</option><option label="Full time" value="1">Full time</option><option label="Part time" value="2">Part time</option><option label="Contract" value="3">Contract</option><option label="Casual" value="4">Casual</option><option label="Apprenticeship" value="5">Apprenticeship</option><option label="Internship" value="6">Internship</option><option label="Summer Clerk" value="7">Summer Clerk</option><option label="Graduate" value="8">Graduate</option><option label="Fixed Term" value="9">Fixed Term</option><option label="Temp" value="10">Temp</option><option label="Volunteer" value="11">Volunteer</option></select>
                                            <input type="number" name="salary" value="" placeholder="Salary" class="ar__wh-end-date mydatepicker pvm-input-text ng-pristine ng-untouched ng-valid ng-empty" ng-model="workHistory.salary">
                                        </div>
                                        <input type="text" placeholder="Start Date" class="ar__wh-start-date mydatepicker pvm-input-text ng-pristine ng-untouched ng-empty ng-invalid ng-invalid-required" ng-click="initDatePicker($event)" ng-model="workHistory.start_date" ng-required="!workHistory.start_date" required="required">
                                    <input type="text" placeholder="End Date " class="ar__wh-end-date mydatepicker pvm-input-text ng-pristine ng-untouched ng-valid ng-empty" ng-click="initDatePicker($event)" ng-model="workHistory.end_date" ng-disabled="currently_work_here">
                                        <label><input type="checkbox" ng-model="workHistory.currently_work_here" ng-true-value="true" ng-false-value="false" class="ng-pristine ng-untouched ng-valid ng-empty"> I currently work here</label>
                                        <h4 class="ar__subheaders">Key accountabilities </h4>
                                        <ul class="ar__wh-accnt-list">
                                            <li class="ar__wh-accnt-item ng-scope" ng-repeat="accnt in wh.key_accountabilities track by $index" ng-init="innerIndex = $index">
                                                <input type="text" name="" class="pvm-input-text ar__wh-accnt-text" value="Conduct assessments to define and analyze possible risks">
                                                <i class="fa fa-close" ng-click="delAcct(outerIndex, innerIndex)"></i>
                                            </li>
                                            <li class="ar__wh-accnt-item ar__wh-accnt-item--more">
                                                <i class="fa fa-plus ng-scope" ng-if="updateThisWorkhistory_id == wh.id" title="Add accountabilities" ng-click="AddMoreResponsiblity($index)"><span>Add</span></i><!-- end ngIf: updateThisWorkhistory_id == wh.id -->
                                            </li>
                                        </ul>
                                        <h4 class="ar__subheaders">Role in a nutshell</h4>
                                        <textarea placeholder="Role in a nutshell" ng-model="workHistory.description" class="pvm-textarea ar__wh-nutshell ng-pristine ng-untouched ng-valid ng-empty">Develop risk management controls and systems</textarea>
                                        <h4 class="ar__subheaders">Classification</h4>
                                        <select ng-model="myIndus" ng-change="changeSubIndustriesEdit()" ng-options="add_industry as add_industry.display_name for add_industry in all_industries track by add_industry.id" class="pvm-input-select">
                                            <option value="" class="" disabled selected>Please select a Classification..</option><option label="Accounting" value="20">Accounting</option><option label="Administration &amp; Office Support" value="21">Administration &amp; Office Support</option><option label="Advertising, Arts &amp; Media" value="22">Advertising, Arts &amp; Media</option><option label="Banking &amp; Financial Services" value="23">Banking &amp; Financial Services</option><option label="Call Centre &amp; Customer Service" value="24" selected>Call Centre &amp; Customer Service</option><option label="CEO &amp; General Management" value="25">CEO &amp; General Management</option><option label="Community Services &amp; Development" value="26">Community Services &amp; Development</option><option label="Construction" value="27">Construction</option><option label="Consulting &amp; Strategy" value="28">Consulting &amp; Strategy</option><option label="Design &amp; Architecture" value="29">Design &amp; Architecture</option><option label="Education &amp; Training" value="30">Education &amp; Training</option><option label="Engineering" value="31">Engineering</option><option label="Farming, Animals &amp; Conservation" value="32">Farming, Animals &amp; Conservation</option><option label="Government &amp; Defence" value="33">Government &amp; Defence</option><option label="Healthcare &amp; Medical" value="34">Healthcare &amp; Medical</option><option label="Hospitality &amp; Tourism" value="35">Hospitality &amp; Tourism</option><option label="Human Resources &amp; Recruitment" value="36">Human Resources &amp; Recruitment</option><option label="Information &amp; Communication Technology" value="37">Information &amp; Communication Technology</option><option label="Insurance &amp; Superannuation" value="38">Insurance &amp; Superannuation</option><option label="Legal" value="58">Legal</option><option label="Manufacturing, Transport &amp; Logistics" value="59">Manufacturing, Transport &amp; Logistics</option><option label="Marketing &amp; Communications" value="60">Marketing &amp; Communications</option><option label="Mining, Resources &amp; Energy" value="61">Mining, Resources &amp; Energy</option><option label="Real Estate &amp; Property" value="62">Real Estate &amp; Property</option><option label="Retail &amp; Consumer Products" value="63">Retail &amp; Consumer Products</option><option label="Sales" value="64">Sales</option><option label="Science &amp; Technology" value="65">Science &amp; Technology</option><option label="Self Employment" value="66">Self Employment</option><option label="Sport &amp; Recreation" value="67">Sport &amp; Recreation</option><option label="Trades &amp; Services" value="68">Trades &amp; Services</option></select>
                                        <h4 class="ar__subheaders">Sub Classification</h4>
                                        <select ng-model="mySubIndustry" ng-change="selectSubIndustryEdit()" ng-options="add_sub_industry as add_sub_industry.display_name for add_sub_industry in mySubIndus track by add_sub_industry.id" class="pvm-input-select">
                                            <option value="" class="" disabled selected>Please select a Sub Classification..</option>
                                            <option value="" class="" selected>Sales - Inbound</option>
                                        </select>
                                        <div class="ar__wh-item ar__wh-item--r ng-scope" ng-if="addWH == 1">
                                            <i class="fa fa-spinner fa-spin pvm-spinner pvm-spinner--sm ng-hide" ng-show="loadAddWH"></i>
                                            <button type="Submit" name="Save" class="btn-pvm btn-mini btn-primary" ng-disabled="loadAddWH">Save</button>
                                            <input type="button" @click="editWork = !editWork" name="Cancel" value="Cancel" class="btn-pvm btn-mini btn-default">
                                        </div>
                                </form>
                                
                                <div class="clearfix"></div>
                                {{-- ADD WORK HISTORY --}}
                                {{-- SHOW ON CLICK OF ADD WORK HISTORY BUTTON --}}
                                
                                <form name="" class="form-add" :class="{'hidden': !showWork}">
                                    <input type="text" name="" placeholder="Company Name" value="" ng-model="workHistory.company_name" ng-required="!workHistory.company__name" class="pvm-input-text" required="required">
                                    <input type="text" placeholder="Country" class="pvm-input-text" required="required">
                                    <input type="text" name="" placeholder="Job/Role Title" value="" class="pvm-input-text tellus__general-textbox ng-pristine ng-untouched ng-empty ng-invalid ng-invalid-required" ng-model="workHistory.job_title" ng-required="!workHistory.job_title" required="required">
                                    <div class="flexbox-sb-c field-inline-2">
                                        <select name="work_type" ng-options="s.id as s.display_name for s in work_types_wh track by s.id" class="pvm-input-select ng-pristine ng-untouched ng-empty ng-invalid ng-invalid-required" ng-model="workHistory.work_type" ng-required="!workHistory.work_type" required="required"><option value="" class="" disabled selected>Work Type</option><option label="Full time" value="1">Full time</option><option label="Part time" value="2">Part time</option><option label="Contract" value="3">Contract</option><option label="Casual" value="4">Casual</option><option label="Apprenticeship" value="5">Apprenticeship</option><option label="Internship" value="6">Internship</option><option label="Summer Clerk" value="7">Summer Clerk</option><option label="Graduate" value="8">Graduate</option><option label="Fixed Term" value="9">Fixed Term</option><option label="Temp" value="10">Temp</option><option label="Volunteer" value="11">Volunteer</option></select>
                                        <input type="number" name="salary" value="" placeholder="Salary" class="pvm-input-text ng-pristine ng-untouched ng-valid ng-empty" ng-model="workHistory.salary">
                                    </div>
                                    <input type="text" placeholder="Start Date" class="ar__wh-start-date mydatepicker pvm-input-text ng-pristine ng-untouched ng-empty ng-invalid ng-invalid-required" ng-click="initDatePicker($event)" ng-model="workHistory.start_date" ng-required="!workHistory.start_date" required="required">
                                    <input type="text" placeholder="End Date " class="ar__wh-end-date mydatepicker pvm-input-text ng-pristine ng-untouched ng-valid ng-empty" ng-click="initDatePicker($event)" ng-model="workHistory.end_date" ng-disabled="currently_work_here">
                                    <label><input type="checkbox" ng-model="workHistory.currently_work_here" ng-true-value="true" ng-false-value="false" class="ng-pristine ng-untouched ng-valid ng-empty"> I currently work here</label>
                                    
                                    <h4 class="ar__subheaders">Key accountabilities </h4>
                                    <ul class="ar__wh-accnt-list">
                                        <li class="ar__wh-accnt-item ar__wh-accnt-item--more">
                                            <i class="fa fa-plus" title="Add accountabilities" ng-click="AddMoreResponsiblity2()"><span>Add</span></i>
                                        </li>
                                    </ul>
                                    <h4 class="ar__subheaders">Role in a nutshell</h4>
                                    <textarea placeholder="Role in a nutshell" ng-model="workHistory.description" class="pvm-textarea ar__wh-nutshell ng-pristine ng-untouched ng-valid ng-empty"></textarea>
                                    <h4 class="ar__subheaders">Classification</h4>
                                    <select ng-model="addIndustry" ng-change="changeSubIndustriesAdd()" ng-options="add_industry as add_industry.display_name for add_industry in all_industries track by add_industry.id" class="pvm-input-select ng-pristine ng-untouched ng-valid ng-empty" required><option value="" disabled selected>Please select a Classification..</option><option label="Accounting" value="20">Accounting</option><option label="Administration &amp; Office Support" value="21">Administration &amp; Office Support</option><option label="Advertising, Arts &amp; Media" value="22">Advertising, Arts &amp; Media</option><option label="Banking &amp; Financial Services" value="23">Banking &amp; Financial Services</option><option label="Call Centre &amp; Customer Service" value="24">Call Centre &amp; Customer Service</option><option label="CEO &amp; General Management" value="25">CEO &amp; General Management</option><option label="Community Services &amp; Development" value="26">Community Services &amp; Development</option><option label="Construction" value="27">Construction</option><option label="Consulting &amp; Strategy" value="28">Consulting &amp; Strategy</option><option label="Design &amp; Architecture" value="29">Design &amp; Architecture</option><option label="Education &amp; Training" value="30">Education &amp; Training</option><option label="Engineering" value="31">Engineering</option><option label="Farming, Animals &amp; Conservation" value="32">Farming, Animals &amp; Conservation</option><option label="Government &amp; Defence" value="33">Government &amp; Defence</option><option label="Healthcare &amp; Medical" value="34">Healthcare &amp; Medical</option><option label="Hospitality &amp; Tourism" value="35">Hospitality &amp; Tourism</option><option label="Human Resources &amp; Recruitment" value="36">Human Resources &amp; Recruitment</option><option label="Information &amp; Communication Technology" value="37">Information &amp; Communication Technology</option><option label="Insurance &amp; Superannuation" value="38">Insurance &amp; Superannuation</option><option label="Legal" value="58">Legal</option><option label="Manufacturing, Transport &amp; Logistics" value="59">Manufacturing, Transport &amp; Logistics</option><option label="Marketing &amp; Communications" value="60">Marketing &amp; Communications</option><option label="Mining, Resources &amp; Energy" value="61">Mining, Resources &amp; Energy</option><option label="Real Estate &amp; Property" value="62">Real Estate &amp; Property</option><option label="Retail &amp; Consumer Products" value="63">Retail &amp; Consumer Products</option><option label="Sales" value="64">Sales</option><option label="Science &amp; Technology" value="65">Science &amp; Technology</option><option label="Self Employment" value="66">Self Employment</option><option label="Sport &amp; Recreation" value="67">Sport &amp; Recreation</option><option label="Trades &amp; Services" value="68">Trades &amp; Services</option></select>
                                    <h4 class="ar__subheaders">Sub Classification</h4>
                                    <select ng-model="addSubIndustry" ng-change="selectSubIndustryAdd()" ng-options="add_sub_industry as add_sub_industry.display_name for add_sub_industry in AddSubIndus track by add_sub_industry.id" class="pvm-input-select ng-pristine ng-untouched ng-valid ng-empty" required><option value="" class="" disabled selected>Please select a Sub Classification..</option></select>
                                    <div class="ar__wh-item ar__wh-item--r ng-scope" ng-if="addWH == 1">
                                        <i class="fa fa-spinner fa-spin pvm-spinner pvm-spinner--sm ng-hide" ng-show="loadAddWH"></i>
                                        <button type="Submit" name="Save" class="btn-pvm btn-mini btn-primary" ng-disabled="loadAddWH">Save</button>
                                        <input type="button" @click="showWork = !showWork" name="Cancel" value="Cancel" class="btn-pvm btn-mini btn-default">
                                    </div>
                                </form>
                            </li>
                            <li class="ar__wh-item ar__wh-item--none ng-hide" ng-show="resProfile.work_history.length <= 0">
                                <span class="ar__app-req ng-hide" ng-show="company.application_requirements.work_experience=='yes' &amp;&amp; resProfile.work_history.length <= 0"><i class="fa fa-exclamation"></i> Work History is required by this role.</span>
                            </li>
                            <li class="ar__wh-item ar__wh-item--r ar__wh-item--btn">
                                <label class="ar__wh-workforce ng-hide" ng-hide="resProfile.work_history.length > 0">
                                    <input type="checkbox" ng-change="newToWorkForce(newToWorkForceField)" ng-model="newToWorkForceField" class="ng-pristine ng-untouched ng-valid ng-empty"> &nbsp; I am new to workforce
                                </label>
                                <div class="flexbox-c-c">
                                    <button class="btn-add" @click="showWork = !showWork" :class="{'hidden': showWork || editWork }"><i class="fa fa-plus"></i>Add Work History</button>
                                </div>
                            </li>
                        </ul>
                    </div>

                    <div class="ar__tellus-details-inner" id="supporting-documents">
                        <h5 class="ar__headers">supporting documents</h5>

                        <div class="ar__tellus-general-div" ng-show="company.application_requirements.resume=='yes'">
                            <span class="ar__app-req ar__app-req--left ar__app-req--icon" ng-show="!candidate_docs.resume.doc_url">
                                <div class="ar__tooltip ng-hide" ng-show="showPvmMessageR">
                                    <i class="fa fa-close" ng-click="showPvmMessageR=true"></i>
                                    <p class="pvm-arrow-msg">Resumé is required by this role.</p>
                                    <div class="pvm-arrow-down"></div>
                                </div>
                                <i class="fa fa-asterisk" ng-click="showPvmMessageR =! showPvmMessageR" ng-mouseover="showPvmMessageR=true" ng-mouseleave="showPvmMessageR=false"></i>
                            </span>
                            <span class="ar__app-req ar__app-req--left ar__app-req--icon ng-hide" ng-show="candidate_docs.resume.doc_url">
                                <div class="ar__tooltip ng-hide" ng-show="showPvmMessageR">
                                    <i class="fa fa-close" ng-click="showPvmMessageR=true"></i>
                                    <p class="pvm-arrow-msg">You have previously uploaded resume and can proceed with the application but you're free to update this before moving to next step.</p>
                                    <div class="pvm-arrow-down"></div>
                                </div>
                                <i class="fa fa-exclamation-triangle hidden" ng-click="showPvmMessageR =! showPvmMessageR" ng-mouseover="showPvmMessageR=true" ng-mouseleave="showPvmMessageR=false"></i>
                            </span>
                            <p class="ar__tell-link ar__tell-link--none ng-scope" nng-if="!candidate_docs.resume.doc_url">Please upload Resumé.</p><!-- end ngIf: !candidate_docs.resume.doc_url -->
                            <button ng-click="uploadFile('resume', '')" class="btn-pvm btn-mini btn-primary tellus__upload-btn" data-toggle="modal" data-target="#pmvFileModalNew">Upload</button>
                        </div>

                        <div class="ar__tellus-general-div" ng-show="company.application_requirements.portfolio=='yes'">
                            <span class="ar__app-req ar__app-req--left ar__app-req--icon ng-hide" ng-show="candidate_docs.portfolio.doc_url">
                                <div class="ar__tooltip ng-hide" ng-show="showPvmMessageP">
                                    <i class="fa fa-close" ng-click="showPvmMessageP=false"></i>
                                    <p class="pvm-arrow-msg">You have previously uploaded portfolio and can proceed with the application but you're free to update this before moving to next step.</p>
                                    <div class="pvm-arrow-down"></div>
                                </div>
                                <i class="fa fa-exclamation-triangle hidden" ng-click="showPvmMessageP =! showPvmMessageP" ng-mouseover="showPvmMessageP=true" ng-mouseleave="showPvmMessageP=false"></i>
                            </span>
                            <span class="ar__app-req ar__app-req--left ar__app-req--icon" ng-show="!candidate_docs.portfolio.doc_url">
                                <div class="ar__tooltip ng-hide" ng-show="showPvmMessageP">
                                    <i class="fa fa-close" ng-click="showPvmMessageP=false"></i>
                                    <p class="pvm-arrow-msg">Portfolio is required by this role.</p>
                                    <div class="pvm-arrow-down"></div>
                                </div>
                                <i class="fa fa-asterisk" ng-click="showPvmMessageP =! showPvmMessageP" ng-mouseover="showPvmMessageP=true" ng-mouseleave="showPvmMessageP=false"></i>
                            </span>
                            <p class="ar__tell-link ar__tell-link--none ng-scope" nng-if="!candidate_docs.portfolio.doc_url" ng-show="company.application_requirements.portfolio=='yes'">Please upload portfolio.</p><!-- end ngIf: !candidate_docs.portfolio.doc_url -->
                            <button ng-click="uploadFile('portfolio', '')" class="btn-pvm btn-mini btn-primary tellus__upload-btn" data-toggle="modal" data-target="#pmvFileModalNew">Upload</button>
                        </div>

                        <div class="ar__tellus-general-div" ng-show="company.application_requirements.cover_letter=='yes'">
                            <span class="ar__app-req ar__app-req--left ar__app-req--icon" ng-show="!candidate_docs.cover_letter.doc_url">
                                <div class="ar__tooltip ng-hide" ng-show="showPvmMessageCL">
                                    <i class="fa fa-close" ng-click="showPvmMessageCL=false"></i>
                                    <p class="pvm-arrow-msg">Cover letter is required by this role.</p>
                                    <div class="pvm-arrow-down"></div>
                                </div>
                                <i class="fa fa-asterisk" ng-click="showPvmMessageCL =! showPvmMessageCL" ng-mouseover="showPvmMessageCL=true" ng-mouseleave="showPvmMessageCL=false"></i>
                            </span>
                            <span class="ar__app-req ar__app-req--left ar__app-req--icon ng-hide" ng-show="candidate_docs.cover_letter.doc_url">
                                <div class="ar__tooltip ng-hide" ng-show="showPvmMessageCL">
                                    <i class="fa fa-close" ng-click="showPvmMessageCL=false"></i>
                                    <p class="pvm-arrow-msg">You have previously uploaded cover letter and can proceed with the application but you're free to update this before moving to next step.</p>
                                    <div class="pvm-arrow-down"></div>
                                </div>
                                <i class="fa fa-exclamation-triangle hidden" ng-click="showPvmMessageCL =! showPvmMessageCL" ng-mouseover="showPvmMessageCL=true" ng-mouseleave="showPvmMessageCL=false"></i>
                            </span>
                            <p class="ar__tell-link ar__tell-link--none ng-scope" nng-if="!candidate_docs.cover_letter.doc_url">Please upload a Cover Letter.</p><!-- end ngIf: !candidate_docs.cover_letter.doc_url -->
                            <button ng-click="uploadFile('cover_letter', 'cover_letter')" class="btn-pvm btn-mini btn-primary tellus__upload-btn" data-toggle="modal" data-target="#pmvFileModalNew">Upload</button>
                        </div>

                        <div class="ar__tellus-general-div ar__tellus-general-div--none" ng-show="company.application_requirements.transcript=='yes'">
                            <span class="ar__app-req ar__app-req--left ar__app-req--icon" ng-show="!candidate_docs.transcript.doc_url">
                                <div class="ar__tooltip ng-hide" ng-show="showPvmMessageT">
                                    <i class="fa fa-close" ng-click="showPvmMessageT=false"></i>
                                    <p class="pvm-arrow-msg">Transcript is required by this role.</p>
                                    <div class="pvm-arrow-down"></div>
                                </div>
                                <i class="fa fa-asterisk" ng-click="showPvmMessageT =! showPvmMessageT" ng-mouseover="showPvmMessageT=true" ng-mouseleave="showPvmMessageT=false"></i>
                            </span>
                            <span class="ar__app-req ar__app-req--left ar__app-req--icon ng-hide" ng-show="candidate_docs.transcript.doc_url">
                                <div class="ar__tooltip ng-hide" ng-show="showPvmMessageT">
                                    <i class="fa fa-close" ng-click="showPvmMessageT=false"></i>
                                    <p class="pvm-arrow-msg">You have previously uploaded transcript and can proceed with the application but you're free to update this before moving to next step.</p>
                                    <div class="pvm-arrow-down"></div>
                                </div>
                                <i class="fa fa-exclamation-triangle hidden" ng-click="showPvmMessageT =! showPvmMessageT" ng-mouseover="showPvmMessageT=true" ng-mouseleave="showPvmMessageT=false"></i>
                            </span>
                            <a href="" class="ar__tell-link ng-binding"></a>
                            <p class="ar__tell-link ar__tell-link--none ng-scope" nng-if="!candidate_docs.transcript.doc_url">Please upload Transcript.</p><!-- end ngIf: !candidate_docs.transcript.doc_url -->
                            <button ng-click="uploadFile('transcript', 'transcript')" class="btn-pvm btn-mini btn-primary tellus__upload-btn" data-toggle="modal" data-target="#pmvFileModalNew">Upload</button>
                        </div>
                    </div>
                
                    <div class="ar__tellus-details-inner" id="references">
                        <h5 class="ar__headers">References
                            <span class="ar__app-req ar__app-req--left ar__app-req--icon  ar__app-req--inline" ng-show="references.length > 0">
                                <div class="ar__tooltip ng-hide" ng-show="showPvmMessageRef">
                                    <i class="fa fa-close" ng-click="showPvmMessageRef=false"></i>
                                    <p class="pvm-arrow-msg">You already have references and can proceed with the application but you're free to update this before moving to next step.</p>
                                    <div class="pvm-arrow-down"></div>
                                </div>
                                <i class="fa fa-exclamation-triangle hidden" ng-click="showPvmMessageRef =! showPvmMessageRef" ng-mouseover="showPvmMessageRef=true" ng-mouseleave="showPvmMessageRef=false"></i>
                            </span>
                        </h5>
                        <ul class="ar__ref-list">
                            <li class="ar__ref-item ng-scope" nng-repeat="ref in references">
                                <div class="ar__ref-funcs">
                                    <button class="btn-link" @click="editRef = !editRef">
                                        <i class="fa fa-pencil" title="Update"></i>
                                    </button>
                                    <i class="fa fa-trash-o" title="Delete" ng-click="deleteThisRef($index, ref.id)" ng-hide="loadDelRef &amp;&amp; ref.id == loadDelRefId"></i>
                                    <i class="fa fa-spinner fa-spin ng-hide" title="Please wait..." ng-show="loadDelRef &amp;&amp; ref.id == loadDelRefId"></i>
                                </div>
                                <div :class="{ 'hidden': editRef }">
                                    <p ng-bind-html="ref.description" class="ar__ref-desc ng-binding">I am description!</p>
                                    <p class="ar__ref-emp">
                                        <span class="ar__ref-emp-name ng-binding">Patrick</span>, 
                                        <span class="ar__ref-comp ng-binding">Preview Me</span><br>
                                        <span class="ar__ref-email ng-binding">mattw@previewme.co</span><br>
                                        <span class="ar__ref-phone ng-binding">09123456789</span>
                                    </p>
                                </div>
                                <form name="" class="form-edit" :class="{ 'hidden': !editRef }">
                                    <textarea placeholder="Description" class="pvm-textarea">I am description!</textarea>
                                    <input type="text" placeholder="Employer Name" class="pvm-input-text" value="Patrick">
                                    <input type="text" placeholder="Company" class="pvm-input-text" value="Preview Me">
                                    <input type="text" placeholder="Email Address" class="pvm-input-text" value="pat@previewme.co">
                                    <input type="text" placeholder="Contact Number" class="pvm-input-text" value="09123456789">
                                    <div class="ar__ref-item ar__ref-item--r">
                                        <i class="fa fa-spinner fa-spin pvm-spinner pvm-spinner--sm ng-hide" ng-show="loadAddRef"></i>
                                        <button type="submit" value="Save" class="btn-pvm btn-mini btn-primary" ng-disabled="loadAddRef">Save</button>
                                        <input type="button" @click="editRef = !editRef" name="Cancel" value="Cancel" class="btn-pvm btn-mini btn-default">
                                    </div>
                                </form>
                                <form name="" class="form-add" :class="{ 'hidden': !showRef }">
                                    <textarea placeholder="Description" class="pvm-textarea" required></textarea>
                                    <input type="text" placeholder="Employer Name" class="pvm-input-text" required>
                                    <input type="text" placeholder="Company" class="pvm-input-text" required>
                                    <input type="text" placeholder="Email Address" class="pvm-input-text">
                                    <input type="text" placeholder="Contact Number" class="pvm-input-text">
                                    <div class="ar__ref-item ar__ref-item--r">
                                        <i class="fa fa-spinner fa-spin pvm-spinner pvm-spinner--sm ng-hide" ng-show="loadAddRef"></i>
                                        <button type="submit" value="Save" class="btn-pvm btn-mini btn-primary" ng-disabled="loadAddRef">Save</button>
                                        <input type="button" @click="showRef = !showRef" name="Cancel" value="Cancel" class="btn-pvm btn-mini btn-default">
                                    </div>
                                </form>
                            </li>
                            <li class="ar__ref-item ar__ref-item--none ng-hide">
                                <span class="ar__app-req ng-hide" ng-show="company.application_requirements.references=='yes' &amp;&amp; resProfile.references.length <= 0"><i class="fa fa-exclamation"></i> Reference is required by this role.</span>
                            </li>
                            <li class="ar__ref-item ar__ref-item--r">
                                <div class="flexbox-c-c">
                                    <button class="btn-add" @click="showRef = !showRef" :class="{ 'hidden': showRef }"><i class="fa fa-plus"></i>Add Reference</button>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>