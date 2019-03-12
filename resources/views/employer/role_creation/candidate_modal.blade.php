<div id="pmvCameraModal" class="modal fade" role="dialog">
    <div class="modal-dialog" >
      <div class="modal-content" ondrop="dropVideoModal(event)" ondragover="allowDrop(event)">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Record Camera or Upload Video</h4>
        </div>
        <div class="modal-body pvm-video-container col-md-12 col-sm-12 col-xs-12">
  
                <div class="col-md-8 col-sm-12 col-xs-12">
                     <video width="100" id="preview" data-old_file="" data-file_folder="" controls data-ob_key="" muted></video>
                      <div id="modal_percent" class=" c100 p@{{modal_percent_value}} small">
                      <span>@{{modal_percent_value}}%</span>
                      <div class="slice">
                          <div class="bar"></div>
                          <div class="fill"></div>
                      </div>
                  </div>
             </div>
  
             <div class="col-md-4 col-sm-12 col-xs-12">
                     <!-- show if desktop -->
                     <div style="height:120px;" id="browse_video" ng-show="mobile_agent == false">
                      <div id="Form_video_upload_Holder" class="field file" >
                              <label class="btn" for="Form_video_upload_modal" style="color:#337ab7; cursor:pointer">Upload Video
                              <br><br>
                              <i class="glyphicon glyphicon-folder-open" style="font-size: 40px;"></i>
                                  <input data-ob_key=""  data-old_file="" name="video_upload_modal" class="file ng-pristine ng-valid ng-empty ng-touched ng-untouched ng-hide" id="Form_video_upload_modal" type="file" ng-hide="true">
                              </label>
                      </div>
                     </div>
                     <!-- show if desktop -->
                     <div ng-show="mobile_agent == false" style="height:120px; text-align:center" id="record_camera">
                         <div>
                         <label class="btn" style="color:#337ab7">
                         Record Video<br><br>
                         <i class="glyphicon glyphicon-facetime-video" style="font-size: 40px;"></i>
                         </label>
                         </div>
  
                     </div>
                     <!-- show if mobile -->
                     <div ng-show="mobile_agent == true">
                         <label class="btn" for="mobile_camera_capture" style="color:#337ab7; cursor:pointer">Record or Upload a Video
                         <br><br>
                         <i class="glyphicon glyphicon-facetime-video" style="font-size: 40px;"></i>
                         <i class="glyphicon glyphicon-folder-open" style="font-size: 40px;padding-left:10px"></i>
                             <input name="mobile_camera_capture" id="mobile_camera_capture"  data-old_file="" type="file" accept="video/*" ng-hide="true">
                      </label>
                     </div>
             </div>
  
        </div>
  
        <div class="modal-footer">
               <button type="button" class="btn btn-danger ng-hide video_buttons" id="record" data-recorded="">Record</button>
              <button type="button" class="btn btn-default ng-hide video_buttons" id="stop" disabled>Stop</button>
                <button type="button" class="btn btn-default ng-hide video_buttons" id="save" disabled data-save_type="camera">Save</button>
        </div>
      </div>
    </div>
  </div>
  
  
  
  @include('employer.role_creation.video_modal')
  
  <div id="pmvCameraModalNew" class="modal fade" role="dialog">
    <div class="modal-dialog" >
      <div class="modal-content modal-video-modal">
        <div class="x-buttom-container">
          <span  class="close x-button" data-dismiss="modal"></span>
        </div>
  
        <div class="modal-body pvm-video-container col-md-12 col-sm-12 col-xs-12">
  
                <div id="section1-holder" class="sections-holder" ng-hide="showSection1">
                  <div class="col-md-6 modal-image modal-image-left-con" ondrop="dropVideoModalNew(event)" ondragover="allowDrop(event)" ondragleave="leaveIt(event)">
                      <img src="{$ThemeDir}/images/drag_drop_img.png" width="113px" ng-hide="ondragoverout_image"/>
                      <img src="{$ThemeDir}/images/drag_drop_img_gray.png" width="113px" ng-hide="ondragover_image"/>
                      <div class="text-label">
                          <h4 class="pvm-blue">Drag & drop or upload your video</h4>
                          <div id="modal_percent_new" class=" c100 p@{{modal_percent_value}} small" ng-hide="modal_percent">
                  <span>@{{modal_percent_value}}%</span>
                  <div class="slice">
                    <div class="bar"></div>
                    <div class="fill"></div>
                  </div>
                </div>
                      </div>
                      <div>
                          <label class="modal-buttons" for="video_upload_modal_new">
                          BROWSE
                          <input name="video_upload_modal_new" id="video_upload_modal_new"  ng-model="video_upload" data-old_file="" type="file" accept="video/*" style="margin-left:-9999px">
                          </label>
  
                      <div class="little-note-yellow">
                          <i class="fa fa-info-circle" aria-hidden="true"></i>
                          File extension must be one of these - flv, mxf, gxf, ts, ps, 3gp, 3gpp, mpg, wmv, asf, avi, mp4, m4a, m4v, isma, ismv, dvr-ms, mkv, wav, mov
                      </div>
                      </div>
                  </div>
                  <div class="col-md-6 modal-image">
                      <img src="{$ThemeDir}/images/record_video_img.png" width="113px" />
                      <div class="text-label">
                      <h4 class="pvm-blue">Record a video</h4>
                      </div>
                      <div class="modal-button-right-con">
                      <label class="modal-buttons" ng-click="startVideo()">START</label>
                      </div>
                  </div>
              </div>
  
              <div id="section2-holder" class="sections-holder" ng-hide="showSection2">
                  <div class="col-md-12 video-holder">
                      <video id="preview_new" class="video-elm" data-old_file="" data-file_folder="" controls data-ob_key="" muted>
  
                      </video>
                      <div id="modal_percent_new" class=" c100 p@{{modal_percent_value}} small" ng-hide="modal_percent">
                              <span>@{{modal_percent_value}}%</span>
                              <div class="slice">
                                  <div class="bar"></div>
                                  <div class="fill"></div>
                              </div>
                      </div>
                  </div>
                  <div class="col-md-12 buttons-holder">
  
                      <span class="video-buttons" ng-hide="stop_btn" id="stop_btn" ng-click="stopVideo()"></span>
                      <span class="video-buttons" ng-hide="record_btn" id="record_btn" ng-click="recordVideo()"></span>
                      <span class="video-buttons" ng-hide="record_again_btn" id="record_again_btn" ng-click="recordVideoAgain()"></span>
                      <span class="video-buttons" ng-hide="change_btn" id="change_btn" ng-click="changeVideo()"></span>
                      <span class="video-buttons" ng-hide="save_btn" id="save_btn" ng-click="saveVideo()"></span>
  
                  </div>
              </div>
  
  
        </div>
      </div>
    </div>
  </div>
  
  <div id="pmvImageModalNew" class="modal fade" role="dialog">
    <div class="modal-dialog" >
      <div class="modal-content modal-video-modal">
        <div class="x-buttom-container">
          <span  class="close x-button" data-dismiss="modal"></span>
        </div>
  
        <div class="modal-body pvm-video-container col-md-12 col-sm-12 col-xs-12">
  
                <div id="section1-holder" class="sections-holder" ng-hide="showSection1">
                  <div class="col-md-6 modal-image modal-image-left-con" ondrop="dropImageModalNew(event)" ondragover="allowDrop(event)" ondragleave="leaveIt(event)">
                      <img src="{$ThemeDir}/images/drag_drop_img.png" width="113px" ng-hide="ondragoverout_image"/>
                      <img src="{$ThemeDir}/images/drag_drop_img_gray.png" width="113px" ng-hide="ondragover_image"/>
                      <div class="text-label">
                          <h4 class="pvm-blue">Drag & drop or upload your image</h4>
                          <div id="modal_percent_new" class=" c100 p@{{modal_percent_value}} small" ng-hide="modal_percent">
                              <span>@{{modal_percent_value}}%</span>
                              <div class="slice">
                                  <div class="bar"></div>
                                  <div class="fill"></div>
                              </div>
                          </div>
                      </div>
                      <div>
                      <label class="modal-buttons" for="image_upload_modal_new">
                      BROWSE
                      <input name="image_upload_modal_new" id="image_upload_modal_new" data-old_file="" type="file" accept="image/*" style="margin-left:-9999px">
                      </label>
  
  
  
  
                      </div>
                      <span class="little-note little-note-yellow">Recommended dimensions: 150 x 150px</span>
                  </div>
                  <div class="col-md-6 modal-image">
                      <img src="{$ThemeDir}/images/record_video_img.png" width="113px" />
                      <div class="text-label">
                      <h4 class="pvm-blue">Take a picture</h4>
                      </div>
                      <div class="modal-button-right-con">
                      <label class="modal-buttons" ng-click="startVideoImage()">START</label>
                      </div>
                  </div>
              </div>
  
              <div id="section2-holder" class="sections-holder" ng-hide="showSection2">
                  <div class="col-md-12 video-holder" id="preview_img_new_holder">
                      <video id="preview_img_new" class="video-elm" poster="" style="background-color:#fff" ng-hide="isSafari" data-old_file="" data-file_folder="" data-ob_key="" muted>
                      </video>
  
                      <image id="preview_img_new_safari" style="background-color:#fff" ng-show="isSafari">
  
  
                      <canvas id="my_canvas" style="display:none;"></canvas>
                      <div id="modal_percent_new" class=" c100 p@{{modal_percent_value}} small" ng-hide="modal_percent">
                              <span>@{{modal_percent_value}}%</span>
                              <div class="slice">
                                  <div class="bar"></div>
                                  <div class="fill"></div>
                              </div>
                      </div>
                  </div>
                  <div class="col-md-12 buttons-holder">
  
                      <span class="video-buttons" ng-hide="stop_btn" id="stop_btn" ng-click="stop()"></span>
                      <span class="video-buttons" ng-hide="record_btn" id="take_photo_btn" ng-click="take_photo()"></span>
                      <span class="video-buttons" ng-hide="record_again_btn" id="record_again_btn" ng-click="take_photo_again()"></span>
                      <span class="video-buttons" ng-hide="change_btn" id="change_btn" ng-click="changeVideo()"></span>
                      <span class="video-buttons" ng-hide="save_btn" id="save_btn" ng-click="save_photo()"></span>
  
  
                  </div>
              </div>
  
  
        </div>
      </div>
    </div>
  </div>
  
  <div id="pmvImageModalEmployerRegister" class="modal fade" role="dialog">
    <div class="modal-dialog" >
      <div class="modal-content modal-video-modal">
        <div class="x-buttom-container">
          <span  class="close x-button" data-dismiss="modal"></span>
        </div>
  
        <div class="modal-body pvm-video-container col-md-12 col-sm-12 col-xs-12">
  
                <div id="section1-holder" class="sections-holder" ng-hide="showSection1RE">
                  <div class="col-md-6 modal-image modal-image-left-con" ondrop="dropImageModalNew(event)" ondragover="allowDrop(event)" ondragleave="leaveIt(event)">
                      <img src="{$ThemeDir}/images/drag_drop_img.png" width="113px" ng-hide="ondragoverout_imageRE"/>
                      <img src="{$ThemeDir}/images/drag_drop_img_gray.png" width="113px" ng-hide="ondragover_imageRE"/>
                      <div class="text-label">
                          <h4 class="pvm-blue">Drag & drop or upload your image</h4>
                          <div id="modal_percent_new" class=" c100 p@{{modal_percent_value}} small" ng-hide="modal_percentRE">
                              <span>@{{modal_percent_value}}%</span>
                              <div class="slice">
                                  <div class="bar"></div>
                                  <div class="fill"></div>
                              </div>
                          </div>
                      </div>
                      <div>
                      <label class="modal-buttons" for="image_upload_modal_newRE">
                      BROWSE
                      <input name="image_upload_modal_newRE" id="image_upload_modal_newRE" data-old_file="" type="file" accept="image/*" style="margin-left:9999px">
                      </label>
                      </div>
                      <small style="position: absolute;width:100%;left:0;top:270px;">Recommended dimensions: 150x150px</small>
                  </div>
                  <div class="col-md-6 modal-image">
                      <img src="{$ThemeDir}/images/record_video_img.png" width="113px" />
                      <div class="text-label">
                      <h4 class="pvm-blue">Take a picture</h4>
                      </div>
                      <div class="modal-button-right-con">
                      <label class="modal-buttons" ng-click="startVideoImage()">START</label>
                      </div>
                  </div>
              </div>
  
              <div id="section2-holder" class="sections-holder" ng-hide="showSection2RE">
                  <div class="col-md-12 video-holder" id="preview_img_new_holderRE">
                      <video  ng-hide="isSafari" id="preview_img_newRE" class="video-elm" poster="" height="240" data-old_file="" data-file_folder="" data-ob_key="" muted>
                      </video>
  
                      <image id="preview_img_newRE_safari" style="background-color:#fff; height:240px" ng-show="isSafari" >
  
                      <canvas id="my_canvasRE" style="display:none;"></canvas>
                      <div id="modal_percent_new" class=" c100 p@{{modal_percent_value}} small" ng-hide="modal_percentRE">
                              <span>@{{modal_percent_value}}%</span>
                              <div class="slice">
                                  <div class="bar"></div>
                                  <div class="fill"></div>
                              </div>
                      </div>
                  </div>
                  <div class="col-md-12 buttons-holder">
  
                      <span class="video-buttons" ng-hide="stop_btnRE" id="stop_btn" ng-click="stopRE()"></span>
                      <span class="video-buttons" ng-hide="record_btnRE" id="take_photo_btn" ng-click="take_photo()"></span>
                      <span class="video-buttons" ng-hide="record_again_btnRE" id="record_again_btn" ng-click="take_photo_again()"></span>
                      <span class="video-buttons" ng-hide="change_btnRE" id="change_btn" ng-click="changeVideo()"></span>
                      <span class="video-buttons" ng-hide="save_btnRE" id="save_btn" ng-click="save_photoRE()"></span>
  
                  </div>
              </div>
  
  
        </div>
      </div>
    </div>
  </div>
  
  
  
  
  
  <div id="pmvFileModalNew" class="modal fade" role="dialog">
    <div class="modal-dialog" >
      <div class="modal-content modal-video-modal">
        <div class="x-buttom-container">
          <span  class="close x-button" data-dismiss="modal"></span>
        </div>
  
        <div class="modal-body pvm-video-container col-md-12 col-sm-12 col-xs-12">
  
                <div id="section1-holder" class="sections-holder" ng-hide="showSection1">
  
                  <div class="col-md-12 modal-image" ondrop="dropFileModalNew(event)" ondragover="allowDrop(event)" ondragleave="leaveIt(event)">
                      <img src="{$ThemeDir}/images/drag_drop_img.png" width="113px" ng-hide="ondragoverout_image"/>
                      <img src="{$ThemeDir}/images/drag_drop_img_gray.png" width="113px" ng-hide="ondragover_image"/>
                      <div class="text-label">
                          <h4 class="pvm-blue">Drag & drop or upload your file</h4>
                          <div id="modal_percent_new" class=" c100 p@{{modal_percent_value}} small" ng-hide="modal_percent">
                              <span>@{{modal_percent_value}}%</span>
                              <div class="slice">
                                  <div class="bar"></div>
                                  <div class="fill"></div>
                              </div>
                          </div>
                      </div>
                      <div>
                      <label class="modal-buttons" for="file_upload">
                      BROWSE
                      <input name="file_upload" id="file_upload" ng-model="file_upload" data-old_file="" type="file" ng-hide="true">
                      </label>
                      </div>
                  </div>
  
              </div>
  
              <div id="section2-holder" class="sections-holder" ng-hide="showSection2">
                  <div class="col-md-12 video-holder">
                      <div id="uploadResponseText" ng-bind-html="uploadResponseText">
  
                      </div>
  
                  </div>
                  <div class="col-md-12 buttons-holder">
                      <span class="video-buttons" ng-hide="change_btn" id="change_btn" ng-click="file_change()"></span>
                      <span class="video-buttons" ng-hide="save_btn" id="save_btn" ng-click="file_save($event)"></span>
                  </div>
              </div>
  
  
        </div>
      </div>
    </div>
  </div>
  
  
  
  
  <div id="pmvErrorMsg" class="modal fade" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title text-danger">Error</h4>
        </div>
        <div class="modal-body pvm-video-container-error"></div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default-bbt" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
  
  <div id="pmvImageModalMsg" class="modal fade" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
  
        <div class="modal-body" style="padding:20px">Profile image saved. Please wait a few moment to update.</div>
        <div class="modal-footer" style="padding-top:10px;padding-bottom:10px">
          <button type="button" class="btn btn-default-bbt pvm-blue" data-dismiss="modal" style="border:none;">Close</button>
        </div>
      </div>
    </div>
  </div>
  
  
  
  <div id="pmvResumeModal" class="modal fade" role="dialog">
    <div class="modal-dialog" >
      <div class="modal-content" ondrop="dropResumeModal(event)" ondragover="allowDrop(event)">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Upload Resume</h4>
        </div>
        <div class="modal-body pvm-video-container col-md-12 col-sm-12 col-xs-12">
  
                <div class="col-md-8 col-sm-12 col-xs-12">
                     <div id="file_drag_drop">
                     <span>You can also drag and drop resume here.</span>
  
  
                      <div id="modal_percent_file" class="hidden c100 p@{{modal_file_percent_value}} small">
                      <span>@{{modal_file_percent_value}}%</span>
                      <div class="slice">
                          <div class="bar"></div>
                          <div class="fill"></div>
                      </div>
                  </div>
                  </div>
  
             </div>
  
             <div class="col-md-4 col-sm-12 col-xs-12">
                     <!-- show if desktop -->
                     <div style="height:120px; margin-top:35px" id="browse_resume">
                      <div id="Form_video_upload_Holder" class="field file">
                              <label class="btn" for="Form_resume_upload_modal" style="color:#337ab7; cursor:pointer">Upload Resume
                              <br><br>
                              <i class="glyphicon glyphicon-folder-open" style="font-size: 40px;"></i>
                                  <input data-ob_key=""  data-old_file="" data-folder="resume" name="Form_resume_upload_modal" class="file ng-pristine ng-valid ng-empty ng-touched ng-untouched ng-hide" id="Form_resume_upload_modal" type="file" ng-hide="true">
                              </label>
                      </div>
                     </div>
             </div>
  
        </div>
  
        <div class="modal-footer">
              <button type="button" class="btn btn-default-bbt ng-hide resume_buttons" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary-bbt ng-hide resume_buttons" data-dismiss="modal" data-filename="" data-folder="" id="resume_save" ng-click="save_file($event)">Save</button>
        </div>
      </div>
    </div>
  </div>
  
  <div id="pmvPortfolioModal" class="modal fade" role="dialog">
    <div class="modal-dialog" >
      <div class="modal-content" ondrop="dropResumeModal(event)" ondragover="allowDrop(event)">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Upload Portfolio</h4>
        </div>
        <div class="modal-body pvm-video-container col-md-12 col-sm-12 col-xs-12">
  
                <div class="col-md-8 col-sm-12 col-xs-12">
                     <div id="file_drag_drop">
                     <span>You can also drag and drop file here.</span>
  
  
                      <div id="modal_percent_file" class="hidden c100 p@{{modal_file_percent_value}} small">
                      <span>@{{modal_file_percent_value}}%</span>
                      <div class="slice">
                          <div class="bar"></div>
                          <div class="fill"></div>
                      </div>
                  </div>
                  </div>
  
             </div>
  
             <div class="col-md-4 col-sm-12 col-xs-12">
                     <!-- show if desktop -->
                     <div style="height:120px; margin-top:35px" id="browse_resume">
                      <div id="Form_video_upload_Holder" class="field file">
                              <label class="btn" for="Form_portfolio_upload_modal" style="color:#337ab7; cursor:pointer">Upload Porfolio
                              <br><br>
                              <i class="glyphicon glyphicon-folder-open" style="font-size: 40px;"></i>
                                  <input data-ob_key="" data-old_file=""  data-folder="portfolio" name="Form_portfolio_upload_modal" class="file ng-pristine ng-valid ng-empty ng-touched ng-untouched ng-hide" id="Form_portfolio_upload_modal" type="file" ng-hide="true">
                              </label>
                      </div>
                     </div>
             </div>
  
        </div>
  
        <div class="modal-footer">
              <button type="button" class="btn btn-default-bbt ng-hide resume_buttons" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary-bbt ng-hide resume_buttons" data-dismiss="modal" data-filename="" data-folder="" id="portfolio_save" ng-click="save_file($event)">Save</button>
        </div>
      </div>
    </div>
  </div>
  
  
  
  <div id="pmvImageModal" class="modal fade" role="dialog">
    <div class="modal-dialog" >
      <div class="modal-content" ondrop="dropImageModal(event)" ondragover="allowDrop(event)">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Upload Picture</h4>
        </div>
        <div class="modal-body pvm-video-container col-md-12 col-sm-12 col-xs-12">
  
                <div class="col-md-8 col-sm-12 col-xs-12">
                     <div id="file_drag_drop">
                     <span>You can also drag and drop your picture here.</span>
  
  
                      <div id="modal_percent_image" class="hidden c100 p@{{modal_file_percent_value}} small">
                      <span>@{{modal_file_percent_value}}%</span>
                      <div class="slice">
                          <div class="bar"></div>
                          <div class="fill"></div>
                      </div>
                  </div>
                  </div>
  
             </div>
  
             <div class="col-md-4 col-sm-12 col-xs-12">
                     <!-- show if desktop -->
                     <div style="height:120px; margin-top:35px" id="browse_resume">
                      <div id="Form_video_upload_Holder" class="field file">
                              <label class="btn" for="Form_image_upload_modal" style="color:#337ab7; cursor:pointer">Upload Image
                              <br><br>
                              <i class="glyphicon glyphicon-folder-open" style="font-size: 40px;"></i>
                                  <input data-ob_key=""  data-old_file="" name="Form_image_upload_modal" class="file ng-pristine ng-valid ng-empty ng-touched ng-untouched ng-hide" id="Form_image_upload_modal" type="file" ng-hide="true">
                              </label>
                      </div>
                     </div>
             </div>
  
        </div>
  
        <div class="modal-footer">
              <button type="button" class="btn btn-default-bbt ng-hide resume_buttons" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary-bbt ng-hide resume_buttons" data-dismiss="modal" data-filename="" data-folder="" id="image_save" ng-click="save_file($event)">Save</button>
        </div>
      </div>
    </div>
  </div>
  
  
  <div id="companyBannerModal" class="modal fade" role="dialog">
    <div class="modal-dialog" >
      <div class="modal-content modal-video-modal">
        <div class="x-buttom-container">
          <span  class="close x-button" data-dismiss="modal"></span>
        </div>
  
        <div class="modal-body pvm-video-container col-md-12 col-sm-12 col-xs-12">
  
                <div id="banner-section1-holder" class="banner-sections-holder" ng-hide="showSection1">
                  <div class="col-md-12 modal-image" ondrop="dropImageModalNew(event)" ondragover="allowDrop(event)" ondragleave="leaveIt(event)">
                      <img src="{$ThemeDir}/images/drag_drop_img.png" width="113px" ng-hide="ondragoverout_image"/>
                      <img src="{$ThemeDir}/images/drag_drop_img_gray.png" width="113px" ng-hide="ondragover_image"/>
                      <div class="text-label">
                          <h4 class="pvm-blue">Drag & drop or upload your image</h4>
                          <div id="modal_percent_new" class=" c100 p@{{modal_percent_value}} small" ng-hide="modal_percent">
                              <span>@{{modal_percent_value}}%</span>
                              <div class="slice">
                                  <div class="bar"></div>
                                  <div class="fill"></div>
                              </div>
                          </div>
                      </div>
                      <div>
                      <label class="modal-buttons" for="banner_image_upload">
                      BROWSE
                      <input name="banner_image_upload" id="banner_image_upload" data-old_file="" type="file" accept="image/*"
                      style="margin-left:-9999px">
                      </label>
                      <small style="position: absolute;width:100%;left:0;top:270px;">Recommended dimensions: 2000x221px</small>
                      </div>
                  </div>
  
              </div>
  
              <div id="banner-section2-holder" class="banner-sections-holder" ng-hide="showSection2">
                  <div class="col-md-12 video-holder" id="banner_preview_img_new_holder">
  
                          <div style="height:240px;position:relative">
                          <image id="banner_img"  ng-hide="video_preview" ng-src="@{{company_banner_url}}"/>
                          </div>
  
  
  
  
                          <div id="banner_modal_percent_new" class=" c100 p@{{modal_percent_value}} small" ng-hide="modal_percent">
                                  <span>@{{modal_percent_value}}%</span>
                                  <div class="slice">
                                      <div class="bar"></div>
                                      <div class="fill"></div>
                                  </div>
                          </div>
  
                  </div>
                  <div class="col-md-12 buttons-holder">
  
                      <span class="video-buttons" ng-hide="change_btn" id="banner_change_btn" ng-click="file_change()"></span>
                      <span class="video-buttons" ng-hide="save_btn" id="banner_save_btn" ng-click="saveBanner()"></span>
  
  
                  </div>
              </div>
  
  
        </div>
      </div>
    </div>
  </div>