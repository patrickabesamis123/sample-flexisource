<div id="pmvCameraModalNew" class="modal fade" role="dialog">
  <div class="modal-dialog" >
    <div class="modal-content modal-video-modal">
      <div class="x-buttom-container">
        <span  class="close x-button" data-dismiss="modal"></span>
      </div>
      <div class="modal-body pvm-video-container col-md-12 col-sm-12 col-xs-12" style="background: #fff">
        <div ng-show="upload_init == 0 || !upload_init">
          <div id="section1-holder" class="sections-holder" ng-hide="showSection1">
            <div class="col-md-6 modal-image modal-image-left-con" ondrop="dropVideoModalNew(event)" ondragover="allowDrop(event)" ondragleave="leaveIt(event)">
              <img src="/images/drag_drop_img.png" width="113px" ng-hide="ondragoverout_image"/>
              <img src="/images/drag_drop_img_gray.png" width="113px" ng-hide="ondragover_image"/>
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
                <input name="video_upload_modal_new" id="video_upload_modal_new"  ng-model="video_upload" data-old_file="" type="file" accept="video/mp4,video/x-m4v,video/*" style="margin-left:-9999px">
                </label>
              </div>
            </div>
            <div class="col-md-6 modal-image">
              <img src="/images/record_video_img.png" width="113px" />
              <div class="text-label">
                <h4 class="pvm-blue">Record a video</h4>
              </div>
              <div class="modal-button-right-con">
                <label class="modal-buttons" ng-click="startVideo()" class="StartVideo">START</label>
              </div>
            </div>
            <div class="clearfix"></div>
            <div class="little-note-yellow">
              <i class="fa fa-info-circle" aria-hidden="true"></i>
              File extension must be one of these - flv, mxf, gxf, ts, ps, 3gp, 3gpp, mpg, wmv, asf, avi, mp4, m4a, m4v, isma, ismv, dvr-ms, mkv, wav, mov
            </div>
          </div>
          <div id="section2-holder" class="sections-holder" ng-hide="showSection2">
            <div class="col-md-12 video-holder">
              <video id="preview_new" class="video-elm" data-old_file="" data-file_folder="" controls data-ob_key="" muted></video>
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
          @include('includes.video_modal_status')
        </div>
        <div ng-show="upload_init == 1 && upload_init">
          <div style="margin: 0 auto;padding: 60px 0px;font-size: 18px;line-height: 28px;">
            @{{uploading_message}}
          </div>
        </div>
      </div>
    </div>
  </div>
</div>