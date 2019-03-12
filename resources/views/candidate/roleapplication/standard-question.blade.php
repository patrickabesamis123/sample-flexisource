<section class="middle-pane middle-pane--ra tab-pane" id="standard-question">
    <div class="ar__loader-div hidden">
        <h3>Please wait.</h3>
        <h4>While we prepare this page for you.</h4>
        <div class="cssload-loading">
            <i></i><i></i><i></i><i></i>
        </div>
    </div>
    {{-- REMOVE "hidden" class if incompelete submission --}}
    <div class="ar__disclaimer hidden">
        <i class="fa fa-info-circle"></i> <span class="ar__disclaimer-msg">This section must be completed and submitted in the same session</span>
    </div>
    <div>
        <div class="ar__main-div">
            <div class="ar__quickquestion-content-div">
                <h1 class="ar__main-headers">Standard Questions</h1>
                <p>The following information is being collected to enable Tech Now to assess your suitability for this role and will be used for this purpose only. If you fail or refuse to provide the information requested, then your application may be rejected by Tech Now. If you provide false or inaccurate information then your application may be declined, or if you are employed by Tech Now, Tech Now may take appropriate action against you including dismissal.</p>
                <div class="ar__quickquestion-qlist">
                    <ul class="app__pre-apply-list">
                        <li class="app__pre-apply-item">
                            <div class="ar__quickquestion-qitem">
                                <span class="ar__quickquestion-qitem-number">1</span>
                                <p class="ar__quickquestion-qitem-item">Do you have extensive Adobe Creative Suite experience?</p>
                            </div>
                            <div class="ar__quickquestion-choices clear-float">
                                    <label class="role__answers role__answers--yes role__answers--answered " type="radio" value="yes"> yes</label>
                                    <label class="role__answers role__answers--no" type="radio" value="no"> no</label>
                                </div>
                            
                        </li>

                        <li class="app__pre-apply-item">
                            <div class="ar__quickquestion-qitem">
                                <span class="ar__quickquestion-qitem-number">2</span>
                                <p class="ar__quickquestion-qitem-item">Do you have permission to work in New Zealand?</p>
                            </div>
                            <div class="ar__quickquestion-choices clear-float">
                                <ul class="list-choices">
                                    <li>
                                        <label class="q-choices q-choices--selected">
                                            <input type="radio" name="" id="" class="hidden">
                                            <span class="letter">A</span>
                                            <span class="text">Citizenship</span>
                                        </label>
                                    </li>
            
                                    <li>
                                        <label class="q-choices">
                                            <input type="radio" name="" id="" class="hidden">
                                            <span class="letter">B</span>
                                            <span class="text">Permanent residence</span>
                                        </label>
                                    </li>
            
                                    <li>
                                        <label class="q-choices">
                                            <input type="radio" name="" id="" class="hidden">
                                            <span class="letter">C</span>
                                            <span class="text">Visa</span>
                                        </label>
                                    </li>
            
                                    <li>
                                        <label class="q-choices">
                                            <input type="radio" name="" id="" class="hidden">
                                            <span class="letter">D</span>
                                            <span class="text">None</span>
                                        </label>
                                    </li>
                                </ul>
                            </div>
                        </li>

                        <li class="app__pre-apply-item">
                            <div class="ar__quickquestion-qitem">
                                <span class="ar__quickquestion-qitem-number">3</span>
                                <p class="ar__quickquestion-qitem-item">Kamusta crush mo?</p>
                            </div>
                            <div class="ar__quickquestion-choices clear-float">  
                                <textarea name="" id="" class="ar__quickquestion-qans-text" placeholder="Type here..."></textarea>
                            </div>
                        </li>
                        
                        <li class="app__pre-apply-item">
                            <div class="ar__quickquestion-qitem">
                                <span class="ar__quickquestion-qitem-number">4</span>
                                <p class="ar__quickquestion-qitem-item">How would you handle a difficult client?</p>
                            </div>
                            <div class="ar__quickquestion-choices clear-float">  
                                <small class="note note--select">Select one method of answering.</small>                          
                                <label class="role__answers role__answers--yes" @click="isActive = !isActive" :class="{'role__answers--answered': isActive}">
                                    <input name="pre_7003" type="radio" value="yes"> Text
                                </label>
                                <label class="role__answers role__answers--no role__answers--answered"><input name="pre_7003" type="radio" value="Video"> Video</label> 
                                <div class="clearfix"></div>

                                {{-- Show on click of TEXT button --}}
                                {{-- <textarea name="" id="" class="ar__quickquestion-qans-text" placeholder="Type here..."></textarea> --}}
                                {{-- Show on click of VIDEO button --}}
                                <div class="app__standard-quest-list">
                                    <div class="ar__quickquestion-qans-container ng-scope">
                                        <div class="ar__quickquestion-qans ng-scope" ng-if="q.answer_type == 'video'">
                                            <div class="app__standard-qans--video">

                                                <a href="javascript:void(0)" class="btn-pvm btn-primary btn-mini qans__upload-icon" data-toggle="modal" data-target="#pmvCameraModalNew">
                                                    <i class="fa fa-upload"></i>
                                                </a>

                                                <div class="app__standar-qans--content">
                                                    <div ng-show="!q.answer_video.VideoStatus &amp;&amp; q.answer == ''" class="text-center video__big-thumbnail-inner-div">
                                                        <!-- <div><h4>Bababala</h4></div> -->
                                                        <div style="margin-bottom: 25px">
                                                            A video is required for this question. You may choose to upload an existing video file or record your own right away.
                                                        </div>
                                                        <div style="margin-bottom: 25px;font-size: 11px;">
                                                            <i>Note: if ever you would like to upload the same video content that you have used from previous questions, we recommend to change the video file name for more precise record keeping and to avoid technical difficulties.</i>
                                                        </div>
                                                    </div>
                                                    <div ng-show="q.answer_video.VideoStatus == 'processing_completed'" style="width: 50%;" class="ng-hide">
                                                        <video id="sq_video_3462" class="azuremediaplayer amp-default-skin" height="250">
                                                            <p class="amp-no-js">
                                                                To view this video please enable JavaScript, and consider upgrading to a web browser that supports HTML5 video
                                                            </p>
                                                        </video>
                                                    </div>
                                                    <div ng-show="q.answer_video.VideoStatus == 'uploading'" class="text-center video__big-thumbnail-inner-div--success ng-hide">
                                                        <div><h4>Uploaded file is now being processed</h4></div>
                                                        <div style="margin-bottom: 25px">
                                                            Please do not refresh this page. There is no need to wait for the processing to finish. You may click Submit if done answering.
                                                            <!-- <br /><br /><br /><br /><br />
                                                            <i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><br />
                                                            {{-- {{q.answer_video.encoding_job_status}} {{q.answer_video.encoding_progress + '%'}} --}}
                                                            <p ng-if="q.answer_video.encoding_progress == 100">Video is almost ready. Please wait for a few seconds..</p> -->
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="clearfix"></div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                        </li>
                        
                        <li class="app__pre-apply-item">
                            <div class="ar__quickquestion-qitem">
                                <span class="ar__quickquestion-qitem-number">5</span>
                                <p class="ar__quickquestion-qitem-item">If your personality is a colour what would it be and why?</p>
                            </div>
                            <div class="ar__quickquestion-choices clear-float">                            
                                <small class="note note--select">Select one method of answering.</small>
                                <label class="role__answers role__answers--yes" @click="isActive = !isActive" :class="{'role__answers--answered': isActive}">
                                    <input name="pre_7003" type="radio" value="Text"> Text
                                </label> 
                                <label class="role__answers">
                                    <input name="pre_7003" type="radio" value="Video"> Video
                                </label> 
                                <label class="role__answers role__answers--no role__answers--answered"><input name="pre_7003" type="radio" value="Document upload"> Document upload</label> 
                                <div class="clearfix"></div>
                                <div class="fileupload">
                                    <input id="uploadFile" placeholder="No file uploaded" disabled="disabled" />
                                    <label for="file-upload" class="custom-file-upload">Upload Document</label>
                                    <input id="file-upload" name='upload_cont_img' type="file" style="display:none;">
                                </div>

                                {{-- Show on click of TEXT button --}}
                                {{-- <textarea name="" id="" class="ar__quickquestion-qans-text" placeholder="Type here..."></textarea> --}}

                                {{-- Show on click of VIDEO button --}}
                                {{-- <div class="app__standard-quest-list">
                                    <div class="ar__quickquestion-qans-container ng-scope">
                                        <div class="ar__quickquestion-qans ng-scope" ng-if="q.answer_type == 'video'">
                                            <div class="app__standard-qans--video">

                                                <a href="javascript:void(0)" class="btn-pvm btn-primary btn-mini qans__upload-icon" ng-click="openVideoModalSQ(q.id,'question')">
                                                    <i class="fa fa-upload"></i>
                                                </a>

                                                <div class="app__standar-qans--content">
                                                    <div ng-show="!q.answer_video.VideoStatus &amp;&amp; q.answer == ''" class="text-center video__big-thumbnail-inner-div">
                                                        <!-- <div><h4>Bababala</h4></div> -->
                                                        <div style="margin-bottom: 25px">
                                                            A video is required for this question. You may choose to upload an existing video file or record your own right away.
                                                        </div>
                                                        <div style="margin-bottom: 25px;font-size: 11px;">
                                                            <i>Note: if ever you would like to upload the same video content that you have used from previous questions, we recommend to change the video file name for more precise record keeping and to avoid technical difficulties.</i>
                                                        </div>
                                                    </div>
                                                    <div ng-show="q.answer_video.VideoStatus == 'processing_completed'" style="width: 50%;" class="ng-hide">
                                                        <video id="sq_video_3462" class="azuremediaplayer amp-default-skin" height="250">
                                                            <p class="amp-no-js">
                                                                To view this video please enable JavaScript, and consider upgrading to a web browser that supports HTML5 video
                                                            </p>
                                                        </video>
                                                    </div>
                                                    <div ng-show="q.answer_video.VideoStatus == 'uploading'" class="text-center video__big-thumbnail-inner-div--success ng-hide">
                                                        <div><h4>Uploaded file is now being processed</h4></div>
                                                        <div style="margin-bottom: 25px">
                                                            Please do not refresh this page. There is no need to wait for the processing to finish. You may click Submit if done answering.
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="clearfix"></div>

                                            </div>
                                        </div>
                                    </div>
                                </div> --}}
                            </div>
                            <hr>
                        </li>
                        
                        <li class="app__pre-apply-item">
                            <div class="ar__quickquestion-choices clear-float">
                                <a href="javascript:void(0)" target="_blank" class="btn-pvm btn-primary" data-toggle="modal" data-target="#modal-preview-candidate">Preview Application</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

