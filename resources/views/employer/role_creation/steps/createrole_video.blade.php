<div class="ar__main-div ar__negate-margin">
        <div class="ar__video-content-div">
            <h1>
                Make a quick video
                <span>(Optional)</span>
                <i class="fa fa-question pvm-tooltip" data-html="true" data-toggle="tooltip" data-placement="right" title="Take 30 seconds and create a video telling prospective candidates what the role is about and showing them who you are. You just wrote the script – now put a face to it…"></i>
            </h1>
            <div class="video__big-thumbnail-div">
                <div class="video__big-thumbnail-innner-divs">
                    <div ng-show="VideoStatus == 'nothing'" style="padding: 220px 12vw;">
                        <h4>No video has been found yet. Start by uploading a video or record a new one below.</h4>
                    </div>
                    <div id="role_video_container">
                    </div>
                        <!-- <video id="vid1" class="azuremediaplayer amp-default-skin" height="500">
                  <p class="amp-no-js">To view this video please enable JavaScript, and consider upgrading to a web browser that supports HTML5 video</p>
                </video> -->
            <div ng-show="showVideoLoding" style="padding: 0 7vw;">
                <video poster="{$ThemeDir}/images/video_preload.gif" height="500"></video>
            </div>
            <div ng-show="VideoStatus == 'uploading'"  class="text-center" style="padding: 140px 12vw;">
                  <!-- <img src="{$ThemeDir}/images/ajax-loader-video.gif" style="width:106px;padding-bottom:10px"> -->
    
                  <div>
                      <h4>Video is uploading and being encoded..</h4>
                  </div>
                  <div style="margin-bottom: 25px">
                      "You do not need to wait on this page while your video is ‘processing’."
                      <br /><br /><br /><br /><br />
                      <i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><br />
                      @{{encoding_job_status}} @{{encoding_progress + '%'}}
                      <p ng-if="encoding_progress == 100">Video is almost ready. Please wait for a few seconds..</p>
                  </div>
              </div>
                </div>
            </div>
        </div>
    
        <div class="ar__video-lib-div">
            <div class="video__create-div">
                <h5>Create a New Video</h5>
                <div class="video__createrec-div">
                    <div class="video__createrec-inner-div">
                        <div class="clearfix video__createrec-details">
                            <p class="video__createrec-details-p"><i class="fa fa-upload video__upload-logo"></i></p>
                            <p class="video__createrec-details-p"><div class="video__upload-label">Drag & drop or upload your video</div></p>
                        </div>
                        <input type="button" ng-click="openVideoModal()" value="Browse" class="btn-pvm btn-primary">
                        <!-- <a href="javascript:void(0)" class="file-upload-button" ng-click="openVideoModal('create role')">Upload/Record a video</a> -->
    
                    </div>
                    <div class="video__createrec-inner-div">
                        <div class="clearfix video__createrec-details">
                            <p class="video__createrec-details-p"><i class="fa fa-upload video__upload-logo"></i></p>
                            <p class="video__createrec-details-p"><div class="video__upload-label">Record a new video</div></p>
                        </div>
                        <input type="button" name="" value="Start" data-toggle="modal" data-target="#pmvCameraModalNew" ng-click="startVideo()" class="btn-pvm btn-primary">
                    </div>
                </div>
            </div>
            <div class="video__divider-div"></div>
            <div class="video__create-div">
                &nbsp;
                <!-- <h5>Choose from your video library</h5>
                <div class="video__createrec-div">
                    <div class="video__createrec-inner-overflow">
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
                </div> -->
    
            </div>
            <div class="clearfix"></div>
        </div>
    </div>