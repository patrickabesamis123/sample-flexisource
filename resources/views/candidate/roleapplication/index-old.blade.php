@extends('layouts.roleapplication')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/jquery.datetimepicker.min.css?ver=1')}}" />
@endsection

@section('content')

<div class="container-fluidx" role="main">
    <div class="rowx">
        
        <main id="role-app" class="role-app emp-new-role emp-new-role--can clear-float ng-scope" ng-controller="RoleAppMainCtrl">
            <section class="ar__company-top--header flexbox-sb-c">
                <!-- ngIf: !company.company.logo_url || company.company.logo_url == null -->
                <!-- ngIf: company.company.logo_url -->
                <div class="fullwidth">
                    <img nng-if="company.company.logo_url" class="ar__company-logo--title pvm-phone-invisible ng-scope" src="https://pvmlive.blob.core.windows.net/4io7e0o/8ztnl/1520803415_J001498_SocialCollateral_ProfilePictures_NR_2_(1).png"><!-- end ngIf: company.company.logo_url -->
                    <h1 class="role__title ar__company-name--title ng-binding">Accountant (Business Advisory) 5+ exp</h1>
                </div>

                <button class="btn btn-save pull-right"><i class="fa fa-save"></i>Save &amp; Finish Later</button>
            </section>
            <section class="top-pane floated">
            <!-- ngIf: company.company.company_banner_url --><div class="limited ng-scope" style="background-image: url(https://pvmlive.blob.core.windows.net/4io7e0o/8ztnl/1520308690_PM_Home-4.jpg);" ng-iif="company.company.company_banner_url"></div><!-- end ngIf: company.company.company_banner_url -->
            <!-- ngIf: !company.company.company_banner_url || company.company.company_banner_url == null || company.company.company_banner_url == '' -->
            </section>

            <div class="role-tabs">
                <section class="left-pane" id="scrolled">
                    <div class="role__steps-handler">
                        <div class="ar__company-logo-div">
                            <!-- ngIf: company.company.logo_url --><img ng-iif="company.company.logo_url" class="company__logo-img  ng-scope" src="https://pvmlive.blob.core.windows.net/4io7e0o/8ztnl/1520803415_J001498_SocialCollateral_ProfilePictures_NR_2_(1).png"><!-- end ngIf: company.company.logo_url -->
                            <!-- ngIf: !company.company.logo_url -->
                        </div>
                        <div class="ar__company-info-div">
                            <p class="ar__company-name pvm_blue ng-binding">PreviewMe</p>
                            <p class="ar__company-location pvm-tablet-land-invisible ng-binding">Auckland, New Zealand</p>
                            <p class="ar__company-location pvm-tablet-land-visible ng-binding">Auckland<br> New Zealand</p>
                        </div>

                        <ul class="role__steps-list pvm-tablet-land-invisible">
                            <li class="role__steps-item active">
                                <a href="#quick-question" role="tab" class="tab__link">Pre-application Questions</a>
                                <i class="fa fa-angle-right"></i>
                            </li>
                            <li class="role__steps-item">
                                    <a href="#general-info" role="tab" class="tab__link">General Profile Information</a>
                                <i class="fa fa-angle-right"></i>
                            </li>
                            <li class="role__steps-item">
                                <a href="#standard-question" role="tab" class="tab__link">Standard Questions</a>
                            </li>
                        </ul>

                        <ul class="role__steps-list pvm-tablet-land-visible role__step-menu" id="role-menu">
                            <li class="role__steps-item active">
                                <a href="#quick-question" role="tab" class="tab__link">Pre-application Questions</a>
                                <div class="triangle-with-shadow"></div>
                            </li>
                            <li class="role__steps-item">
                                <a href="#general-info" role="tab" class="tab__link">General Profile Information</a>
                                <div class="triangle-with-shadow"></div>
                            </li>
                            <li class="role__steps-item">
                                <a href="#standard-question" role="tab" class="tab__link">Standard Questions</a>
                                <div class="triangle-with-shadow"></div>
                            </li>
                            <li class="role__steps-item" style="opacity: 0;">
                                <a href="#candidate-declaration" role="tab" class="tab__link">candidate-declaration</a>
                                <div class="triangle-with-shadow"></div>
                            </li>
                        </ul>
                    </div>
                </section>

                <div class="tab-content">
                    @include('candidate.roleapplication.quick-question')
                    @include('candidate.roleapplication.about-yourself')
                    @include('candidate.roleapplication.standard-question')
                </div>
            </div>

            <section class="bottom-pane pvm-tablet-invisible">
                <a href="/job/application?id=s5tQ3e3GiMSf53D5p3tQMqgC#" class="btn-pvm btn-mini btn-primary role__prev-btn" ng-click="checkPrev()"><i class="fa fa-arrow-left"></i></a>
                <span class="role__btn-handler">
                    <a href="/job/application?id=s5tQ3e3GiMSf53D5p3tQMqgC#" class="btn-pvm btn-mini btn-default role__publish-btn"><i class="fa fa-rocket"></i> </a>
                    <a href="/job/application?id=s5tQ3e3GiMSf53D5p3tQMqgC#" class="btn-pvm btn-mini btn-tertiary role__save-btn"><i class="fa fa-save"></i> </a>
                </span>
                <button class="btn-pvm btn-mini btn-primary role__next-btn" ng-click="checkNext()"><i class="fa fa-arrow-right"></i> </button>
            </section>

            <section class="bottom-pane pvm-tablet-visible flexbox-sb-c hidden-xs">
                <!-- ngIf: (active_tab > 1 && stepstab.showPre != 1) || (active_tab > 2 && stepstab.showPre == 1) -->
                <a href="#" class="btn-pvm btn-primary role__prev-btn ng-scope"><i class="fa fa-arrow-left"></i> Previous</a>
                <!-- end ngIf: (active_tab > 1 && stepstab.showPre != 1) || (active_tab > 2 && stepstab.showPre == 1) -->
                <button class="btn btn-save pull-right"><i class="fa fa-save"></i>Save &amp; Finish Later</button>
                <!-- ngIf: !readyForApply -->
                <button class="btn-pvm btn-primary role__next-btn ng-scope"><i class="fa fa-arrow-right"></i> next </button><!-- end ngIf: !readyForApply -->
                <!-- ngIf: readyForApply -->
            </section>
    
            <div id="pmvCameraModal" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content" ondrop="dropVideoModal(event)" ondragover="allowDrop(event)">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">×</button>
                            <h4 class="modal-title">Record Camera or Upload Video</h4>
                        </div>
                        <div class="modal-body pvm-video-container col-md-12 col-sm-12 col-xs-12">
                            <div class="col-md-8 col-sm-12 col-xs-12">
                                <video width="100" id="preview" data-old_file="" data-file_folder="" controls="" data-ob_key="" muted=""></video>
                                <div id="modal_percent" class="c100 p small">
                                    <span class="ng-binding">%</span>
                                    <div class="slice">
                                        <div class="bar"></div>
                                        <div class="fill"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12 col-xs-12">
                                <div style="height:120px;" id="browse_video" ng-show="mobile_agent == false" class="ng-hide">
                                    <div id="Form_video_upload_Holder" class="field file">
                                        <label class="btn" for="Form_video_upload_modal" style="color:#337ab7; cursor:pointer">Upload Video
                                            <br><br>
                                            <i class="glyphicon glyphicon-folder-open" style="font-size: 40px;"></i>
                                            <input data-ob_key="" data-old_file="" name="video_upload_modal" class="file ng-pristine ng-valid ng-empty ng-touched ng-untouched ng-hide" id="Form_video_upload_modal" type="file" ng-hide="true">
                                        </label>
                                    </div>
                                </div>
                                
                                <div ng-show="mobile_agent == false" style="height:120px; text-align:center" id="record_camera" class="ng-hide">
                                    <div>
                                        <label class="btn" style="color:#337ab7">
                                        Record Video<br><br>
                                        <i class="glyphicon glyphicon-facetime-video" style="font-size: 40px;"></i>
                                        </label>
                                    </div>
                                </div>
                                
                                <div ng-show="mobile_agent == true" class="ng-hide">
                                    <label class="btn" for="mobile_camera_capture" style="color:#337ab7; cursor:pointer">Record or Upload a Video
                                        <br><br>
                                        <i class="glyphicon glyphicon-facetime-video" style="font-size: 40px;"></i>
                                        <i class="glyphicon glyphicon-folder-open" style="font-size: 40px;padding-left:10px"></i>
                                        <input name="mobile_camera_capture" id="mobile_camera_capture" data-old_file="" type="file" accept="video/*" ng-hide="true" class="ng-hide">
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger ng-hide video_buttons" id="record" data-recorded="">Record</button>
                            <button type="button" class="btn btn-default ng-hide video_buttons" id="stop" disabled="">Stop</button>
                            <button type="button" class="btn btn-default ng-hide video_buttons" id="save" disabled="" data-save_type="camera">Save</button>
                        </div>
                    </div>
                </div>
            </div>
            
            <div id="pmvCameraModalNew" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content modal-video-modal">
                        <div class="x-buttom-container">
                            <span class="close x-button" data-dismiss="modal"></span>
                        </div>
                        <div class="modal-body pvm-video-container col-md-12 col-sm-12 col-xs-12" style="background: #fff">
                            <div ng-show="upload_init == 0 || !upload_init">
                                <div id="section1-holder" class="sections-holder" ng-hide="showSection1">
                                    <div class="col-md-6 modal-image modal-image-left-con" ondrop="dropVideoModalNew(event)" ondragover="allowDrop(event)" ondragleave="leaveIt(event)">
                                        <img src="{{ asset('images/drag_drop_img.png') }}" width="113px" ng-hide="ondragoverout_image">
                                        <img src="themes/bbt/images/drag_drop_img_gray.png" width="113px" ng-hide="ondragover_image" class="ng-hide">
                                        <div class="text-label">
                                            <h4 class="pvm-blue">Drag &amp; drop or upload your video</h4>
                                            <div id="modal_percent_new" class="c100 p small ng-hide" ng-hide="modal_percent">
                                                <span class="ng-binding">%</span>
                                                <div class="slice">
                                                    <div class="bar"></div>
                                                    <div class="fill"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div>
                                            <label class="modal-buttons" for="video_upload_modal_new">
                                                BROWSE
                                                <input name="video_upload_modal_new" id="video_upload_modal_new" ng-model="video_upload" data-old_file="" type="file" accept="video/mp4,video/x-m4v,video/*" style="margin-left:-9999px" class="ng-pristine ng-untouched ng-valid ng-empty">
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 modal-image">
                                        <img src="{{ asset('images/record_video_img.png') }}" width="113px">
                                        <div class="text-label">
                                            <h4 class="pvm-blue">Record a video</h4>
                                        </div>
                                        <div class="modal-button-right-con">
                                            <label class="modal-buttons" ng-click="startVideo()">START</label>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="little-note-yellow">
                                        <i class="fa fa-info-circle" aria-hidden="true"></i>
                                        File extension must be one of these - flv, mxf, gxf, ts, ps, 3gp, 3gpp, mpg, wmv, asf, avi, mp4, m4a, m4v, isma, ismv, dvr-ms, mkv, wav, mov
                                    </div>
                                </div>
                                <div id="section2-holder" class="sections-holder ng-hide" ng-hide="showSection2">
                                    <div class="col-md-12 video-holder">
                                        <video id="preview_new" class="video-elm" data-old_file="" data-file_folder="" controls="" data-ob_key="" muted=""></video>
                                        <div id="modal_percent_new" class="c100 p small ng-hide" ng-hide="modal_percent">
                                            <span class="ng-binding">%</span>
                                            <div class="slice">
                                                <div class="bar"></div>
                                                <div class="fill"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 buttons-holder">
                                        <span class="video-buttons ng-hide" ng-hide="stop_btn" id="stop_btn" ng-click="stopVideo()"></span>
                                        <span class="video-buttons" ng-hide="record_btn" id="record_btn" ng-click="recordVideo()"></span>
                                        <span class="video-buttons ng-hide" ng-hide="record_again_btn" id="record_again_btn" ng-click="recordVideoAgain()"></span>
                                        <span class="video-buttons" ng-hide="change_btn" id="change_btn" ng-click="changeVideo()"></span>
                                        <span class="video-buttons" ng-hide="save_btn" id="save_btn" ng-click="saveVideo()"></span>
                                    </div>
                                </div>
                                <div class="row">
                                    <style>
                                        .progressContainer {display: none;}
                                        #pmvCameraModalNew .modal-video-modal{height: 100%!important; min-height: 360px}
                                        .statusBar{background-color: #FFF; padding-bottom: 15px}
                                        .progressBarOutside {border: 1px solid #333; height: 25px; background-color: #FFF}
                                        .progressbar {height: 23px; background-color: #00afed; text-align: right; color: #FFF;width: 0px; padding-right: 15px}
                                        .preparing, .errorUpload, .successUpload, .finalize {display: none}
                                    </style>
                                    <div class="col-sm-12 statusBar text-center">
                                        <div class="preparing hidden">
                                        Preparing upload. Please wait...<br>
                                        <strong>Please do not refresh or close this page</strong>
                                        </div>
                                        <div class="finalize hidden">
                                            Finalizing upload. Please wait...<br>
                                            <strong>Please do not refresh or close this page </strong>
                                        </div>
                                        <div class="progressContainer hidden">
                                            <div class="text">Uploading. Please do not refresh or close this page </div>
                                            <div class="progressBarOutside">
                                                <div class="progressbar"> <span></span></div>
                                            </div>
                                        </div>
                                        <div class="errorUpload alert alert-danger hidden">
                                            <div class="text">Failed with error: <span></span></div>
                                        </div>
                                        <div class="successUpload alert alert-success hidden">
                                            <div class="text"><strong>Successful.</strong> The video will be encoded before it can be viewed.</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div ng-show="upload_init == 1 &amp;&amp; upload_init" class="ng-hide">
                                <div style="margin: 0 auto;padding: 60px 0px;font-size: 18px;line-height: 28px;" class="ng-binding">
                                
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div id="pmvCameraModalNew" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content modal-video-modal">
                        <div class="x-buttom-container">
                            <span class="close x-button" data-dismiss="modal"></span>
                        </div>
                        <div class="modal-body pvm-video-container col-md-12 col-sm-12 col-xs-12">
                            <div id="section1-holder" class="sections-holder" ng-hide="showSection1">
                                <div class="col-md-6 modal-image modal-image-left-con" ondrop="dropVideoModalNew(event)" ondragover="allowDrop(event)" ondragleave="leaveIt(event)">
                                    <img src="{{ asset('images/drag_drop_img.png') }}" width="113px" ng-hide="ondragoverout_image">
                                    <img src="themes/bbt/images/drag_drop_img_gray.png" width="113px" ng-hide="ondragover_image" class="ng-hide">
                                    <div class="text-label">
                                        <h4 class="pvm-blue">Drag &amp; drop or upload your video</h4>
                                        <div id="modal_percent_new" class="c100 p small ng-hide" ng-hide="modal_percent">
                                            <span class="ng-binding">%</span>
                                            <div class="slice">
                                                <div class="bar"></div>
                                                <div class="fill"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <label class="modal-buttons" for="video_upload_modal_new">
                                            BROWSE
                                            <input name="video_upload_modal_new" id="video_upload_modal_new" ng-model="video_upload" data-old_file="" type="file" accept="video/*" style="margin-left:-9999px" class="ng-pristine ng-untouched ng-valid ng-empty">
                                        </label>
                                        <div class="little-note-yellow">
                                            <i class="fa fa-info-circle" aria-hidden="true"></i>
                                            File extension must be one of these - flv, mxf, gxf, ts, ps, 3gp, 3gpp, mpg, wmv, asf, avi, mp4, m4a, m4v, isma, ismv, dvr-ms, mkv, wav, mov
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 modal-image">
                                    <img src="{{ asset('images/record_video_img.png') }}" width="113px">
                                    <div class="text-label">
                                        <h4 class="pvm-blue">Record a video</h4>
                                    </div>
                                    <div class="modal-button-right-con">
                                        <label class="modal-buttons" ng-click="startVideo()">START</label>
                                    </div>
                                </div>
                            </div>
                            
                            <div id="section2-holder" class="sections-holder ng-hide" nng-hide="showSection2">
                                <div class="col-md-12 video-holder">
                                    <video id="preview_new" class="video-elm" data-old_file="" data-file_folder="" controls="" data-ob_key="" muted="">
                                    </video>
                                    <div id="modal_percent_new" class="c100 p small ng-hide" ng-hide="modal_percent">
                                        <span class="ng-binding">%</span>
                                        <div class="slice">
                                            <div class="bar"></div>
                                            <div class="fill"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 buttons-holder">
                                    <span class="video-buttons ng-hide" ng-hide="stop_btn" id="stop_btn" ng-click="stopVideo()"></span>
                                    <span class="video-buttons" ng-hide="record_btn" id="record_btn" ng-click="recordVideo()"></span>
                                    <span class="video-buttons ng-hide" ng-hide="record_again_btn" id="record_again_btn" ng-click="recordVideoAgain()"></span>
                                    <span class="video-buttons" ng-hide="change_btn" id="change_btn" ng-click="changeVideo()"></span>
                                    <span class="video-buttons" ng-hide="save_btn" id="save_btn" ng-click="saveVideo()"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div id="pmvImageModalNew" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content modal-video-modal">
                        <div class="x-buttom-container">
                            <span class="close x-button" data-dismiss="modal"></span>
                        </div>
                        <div class="modal-body pvm-video-container col-md-12 col-sm-12 col-xs-12">
                            <div id="section1-holder" class="sections-holder" ng-hide="showSection1">
                                <div class="col-md-6 modal-image modal-image-left-con" ondrop="dropImageModalNew(event)" ondragover="allowDrop(event)" ondragleave="leaveIt(event)">
                                    <img src="{{ asset('images/drag_drop_img.png') }}" width="113px" ng-hide="ondragoverout_image">
                                    <img src="themes/bbt/images/drag_drop_img_gray.png" width="113px" ng-hide="ondragover_image" class="ng-hide">
                                    <div class="text-label">
                                        <h4 class="pvm-blue">Drag &amp; drop or upload your image</h4>
                                        <div id="modal_percent_new" class="c100 p small ng-hide" ng-hide="modal_percent">
                                            <span class="ng-binding">%</span>
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
                                    <img src="{{ asset('images/record_video_img.png') }}" width="113px">
                                    <div class="text-label">
                                        <h4 class="pvm-blue">Take a picture</h4>
                                    </div>
                                    <div class="modal-button-right-con">
                                        <label class="modal-buttons" ng-click="startVideoImage()">START</label>
                                    </div>
                                </div>
                            </div>
                            <div id="section2-holder" class="sections-holder ng-hide" ng-hide="showSection2">
                                <div class="col-md-12 video-holder" id="preview_img_new_holder">
                                    <video id="preview_img_new" class="video-elm" poster="" style="background-color:#fff" ng-hide="isSafari" data-old_file="" data-file_folder="" data-ob_key="" muted="">
                                    </video>
                                    <img id="preview_img_new_safari" style="background-color:#fff" ng-show="isSafari" class="ng-hide">
                                    <canvas id="my_canvas" style="display:none;"></canvas>
                                    <div id="modal_percent_new" class="c100 p small ng-hide" ng-hide="modal_percent">
                                        <span class="ng-binding">%</span>
                                        <div class="slice">
                                            <div class="bar"></div>
                                            <div class="fill"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 buttons-holder">
                                    <span class="video-buttons ng-hide" ng-hide="stop_btn" id="stop_btn" ng-click="stop()"></span>
                                    <span class="video-buttons" ng-hide="record_btn" id="take_photo_btn" ng-click="take_photo()"></span>
                                    <span class="video-buttons ng-hide" ng-hide="record_again_btn" id="record_again_btn" ng-click="take_photo_again()"></span>
                                    <span class="video-buttons" ng-hide="change_btn" id="change_btn" ng-click="changeVideo()"></span>
                                    <span class="video-buttons" ng-hide="save_btn" id="save_btn" ng-click="save_photo()"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div id="pmvImageModalEmployerRegister" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content modal-video-modal">
                        <div class="x-buttom-container">
                        <span class="close x-button" data-dismiss="modal"></span>
                        </div>
                        <div class="modal-body pvm-video-container col-md-12 col-sm-12 col-xs-12">
                            <div id="section1-holder" class="sections-holder" ng-hide="showSection1RE">
                                <div class="col-md-6 modal-image modal-image-left-con" ondrop="dropImageModalNew(event)" ondragover="allowDrop(event)" ondragleave="leaveIt(event)">
                                    <img src="{{ asset('images/drag_drop_img.png') }}" width="113px" ng-hide="ondragoverout_imageRE">
                                    <img src="themes/bbt/images/drag_drop_img_gray.png" width="113px" ng-hide="ondragover_imageRE">
                                    <div class="text-label">
                                        <h4 class="pvm-blue">Drag &amp; drop or upload your image</h4>
                                        <div id="modal_percent_new" class="c100 p small" ng-hide="modal_percentRE">
                                            <span class="ng-binding">%</span>
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
                                    <img src="{{ asset('images/record_video_img.png') }}" width="113px">
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
                                    <video ng-hide="isSafari" id="preview_img_newRE" class="video-elm" poster="" height="240" data-old_file="" data-file_folder="" data-ob_key="" muted="">
                                    </video>
                                    <img id="preview_img_newRE_safari" style="background-color:#fff; height:240px" ng-show="isSafari" class="ng-hide">
                                    <canvas id="my_canvasRE" style="display:none;"></canvas>
                                    <div id="modal_percent_new" class="c100 p small" ng-hide="modal_percentRE">
                                        <span class="ng-binding">%</span>
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
                <div class="modal-dialog">
                <div class="modal-content modal-video-modal">
                <div class="x-buttom-container">
                <span class="close x-button" data-dismiss="modal"></span>
                </div>
                <div class="modal-body pvm-video-container col-md-12 col-sm-12 col-xs-12">
                <div id="section1-holder" class="sections-holder" ng-hide="showSection1">
                <div class="col-md-12 modal-image" ondrop="dropFileModalNew(event)" ondragover="allowDrop(event)" ondragleave="leaveIt(event)">
                <img src="{{ asset('images/drag_drop_img.png') }}" width="113px" ng-hide="ondragoverout_image">
                <img src="themes/bbt/images/drag_drop_img_gray.png" width="113px" ng-hide="ondragover_image" class="ng-hide">
                <div class="text-label">
                <h4 class="pvm-blue">Drag &amp; drop or upload your file</h4>
                <div id="modal_percent_new" class="c100 p small ng-hide" ng-hide="modal_percent">
                <span class="ng-binding">%</span>
                <div class="slice">
                <div class="bar"></div>
                <div class="fill"></div>
                </div>
                </div>
                </div>
                <div>
                <label class="modal-buttons" for="file_upload">
                BROWSE
                <input name="file_upload" id="file_upload" ng-model="file_upload" data-old_file="" type="file" ng-hide="true" class="ng-pristine ng-untouched ng-valid ng-empty ng-hide">
                </label>
                </div>
                </div>
                </div>
                <div id="section2-holder" class="sections-holder ng-hide" ng-hide="showSection2">
                <div class="col-md-12 video-holder">
                <div id="uploadResponseText" ng-bind-html="uploadResponseText" class="ng-binding"></div>
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

            <div class="modal fade" id="pmvErrorMsg" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button class="close" data-dismiss="modal" type="button">×</button>
                            <h4 class="modal-title text-danger">Error</h4>
                        </div>
                        <div class="modal-body pvm-video-container-error"></div>
                        <div class="modal-footer">
                            <button class="btn btn-default-bbt" data-dismiss="modal" type="button">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="modal fade" id="pmvImageModalMsg" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-body" style="padding:20px">
                            Profile image saved. Please wait a few moment to update.
                        </div>
                        <div class="modal-footer" style="padding-top:10px;padding-bottom:10px">
                            <button class="btn btn-default-bbt pvm-blue" data-dismiss="modal" style="border:none;" type="button">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="modal fade" id="pmvResumeModal" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content" ondragover="allowDrop(event)" ondrop="dropResumeModal(event)">
                        <div class="modal-header">
                            <button class="close" data-dismiss="modal" type="button">×</button>
                            <h4 class="modal-title">Upload Resume</h4>
                        </div>
                        <div class="modal-body pvm-video-container col-md-12 col-sm-12 col-xs-12">
                            <div class="col-md-8 col-sm-12 col-xs-12">
                                <div id="file_drag_drop">
                                    <span>You can also drag and drop resume here.</span>
                                    <div class="hidden c100 p small" id="modal_percent_file">
                                        <span class="ng-binding">%</span>
                                        <div class="slice">
                                            <div class="bar"></div>
                                            <div class="fill"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12 col-xs-12">
                                <div id="browse_resume" style="height:120px; margin-top:35px">
                                    <div class="field file" id="Form_video_upload_Holder">
                                        <label class="btn" for="Form_resume_upload_modal" style="color:#337ab7; cursor:pointer">Upload Resume<br>
                                        <br>
                                        <i class="glyphicon glyphicon-folder-open" style="font-size: 40px;"></i> <input class="file ng-pristine ng-valid ng-empty ng-touched ng-untouched ng-hide" data-folder="resume" data-ob_key="" data-old_file="" id="Form_resume_upload_modal" name="Form_resume_upload_modal" type="file"></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-default-bbt ng-hide resume_buttons" data-dismiss="modal" type="button">Cancel</button> <button class="btn btn-primary-bbt ng-hide resume_buttons" data-dismiss="modal" data-filename="" data-folder="" id="resume_save" type="button">Save</button>
                        </div>
                    </div>
                </div>
            </div>
    
            <div class="modal fade" id="pmvPortfolioModal" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content" ondragover="allowDrop(event)" ondrop="dropResumeModal(event)">
                        <div class="modal-header">
                            <button class="close" data-dismiss="modal" type="button">×</button>
                            <h4 class="modal-title">Upload Portfolio</h4>
                        </div>
                        <div class="modal-body pvm-video-container col-md-12 col-sm-12 col-xs-12">
                            <div class="col-md-8 col-sm-12 col-xs-12">
                                <div id="file_drag_drop">
                                    <span>You can also drag and drop file here.</span>
                                    <div class="hidden c100 p small" id="modal_percent_file">
                                        <span class="ng-binding">%</span>
                                        <div class="slice">
                                            <div class="bar"></div>
                                            <div class="fill"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12 col-xs-12">
                                <div id="browse_resume" style="height:120px; margin-top:35px">
                                    <div class="field file" id="Form_video_upload_Holder">
                                        <label class="btn" for="Form_portfolio_upload_modal" style="color:#337ab7; cursor:pointer">Upload Porfolio<br>
                                        <br>
                                        <i class="glyphicon glyphicon-folder-open" style="font-size: 40px;"></i> <input class="file ng-pristine ng-valid ng-empty ng-touched ng-untouched ng-hide" data-folder="portfolio" data-ob_key="" data-old_file="" id="Form_portfolio_upload_modal" name="Form_portfolio_upload_modal" type="file"></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-default-bbt ng-hide resume_buttons" data-dismiss="modal" type="button">Cancel</button> <button class="btn btn-primary-bbt ng-hide resume_buttons" data-dismiss="modal" data-filename="" data-folder="" id="portfolio_save" type="button">Save</button>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="modal fade" id="pmvImageModal" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content" ondragover="allowDrop(event)" ondrop="dropImageModal(event)">
                        <div class="modal-header">
                            <button class="close" data-dismiss="modal" type="button">×</button>
                            <h4 class="modal-title">Upload Picture</h4>
                        </div>
                        <div class="modal-body pvm-video-container col-md-12 col-sm-12 col-xs-12">
                            <div class="col-md-8 col-sm-12 col-xs-12">
                                <div id="file_drag_drop">
                                    <span>You can also drag and drop your picture here.</span>
                                    <div class="hidden c100 p small" id="modal_percent_image">
                                        <span class="ng-binding">%</span>
                                        <div class="slice">
                                            <div class="bar"></div>
                                            <div class="fill"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12 col-xs-12">
                                <div id="browse_resume" style="height:120px; margin-top:35px">
                                    <div class="field file" id="Form_video_upload_Holder">
                                        <label class="btn" for="Form_image_upload_modal" style="color:#337ab7; cursor:pointer">Upload Image<br>
                                        <br>
                                        <i class="glyphicon glyphicon-folder-open" style="font-size: 40px;"></i> <input class="file ng-pristine ng-valid ng-empty ng-touched ng-untouched ng-hide" data-ob_key="" data-old_file="" id="Form_image_upload_modal" name="Form_image_upload_modal" type="file"></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-default-bbt ng-hide resume_buttons" data-dismiss="modal" type="button">Cancel</button> <button class="btn btn-primary-bbt ng-hide resume_buttons" data-dismiss="modal" data-filename="" data-folder="" id="image_save" type="button">Save</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="companyBannerModal" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content modal-video-modal">
                        <div class="x-buttom-container">
                            <span class="close x-button" data-dismiss="modal"></span>
                        </div>
                        <div class="modal-body pvm-video-container col-md-12 col-sm-12 col-xs-12">
                            <div class="banner-sections-holder" id="banner-section1-holder">
                                <div class="col-md-12 modal-image" ondragleave="leaveIt(event)" ondragover="allowDrop(event)" ondrop="dropImageModalNew(event)">
                                    <img src="{{ asset('images/drag_drop_img.png') }}" width="113px"> <img class="ng-hide" src="themes/bbt/images/drag_drop_img_gray.png" width="113px">
                                    <div class="text-label">
                                        <h4 class="pvm-blue">Drag &amp; drop or upload your image</h4>
                                        <div class="c100 p small ng-hide" id="modal_percent_new">
                                            <span class="ng-binding">%</span>
                                            <div class="slice">
                                                <div class="bar"></div>
                                                <div class="fill"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <label class="modal-buttons" for="banner_image_upload">BROWSE <input accept="image/*" data-old_file="" id="banner_image_upload" name="banner_image_upload" style="margin-left:-9999px" type="file"></label> <small style="position: absolute;width:100%;left:0;top:270px;">Recommended dimensions: 2000x221px</small>
                                    </div>
                                </div>
                            </div>
                            <div class="banner-sections-holder ng-hide" id="banner-section2-holder">
                                <div class="col-md-12 video-holder" id="banner_preview_img_new_holder">
                                    <div style="height:240px;position:relative"><img id="banner_img"></div>
                                    <div class="c100 p small ng-hide" id="banner_modal_percent_new">
                                        <span class="ng-binding">%</span>
                                        <div class="slice">
                                            <div class="bar"></div>
                                            <div class="fill"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 buttons-holder">
                                    <span class="video-buttons" id="banner_change_btn"></span> <span class="video-buttons" id="banner_save_btn"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    
            <section ng-show="!isPassed &amp;&amp; isFailed" class="app__your-stat app__your-stat--rejected ng-hide">
                <div>
                    <h1>Thank you for applying.</h1>
                    <p>Unfortunately you do not meet the employer’s criteria and cannot advance to the next stage of the application.</p>
                    <a href="https://previewme.co/job/search" class="btn-pvm btn-tertiary btn-large btn-continue">Continue Search</a>
                    <a href="https://previewme.co/dashboard" class="btn-pvm btn-tertiary btn-large btn-continue">Go to your Dashboard</a>
                </div>
            </section>
            <section ng-show="isPassed &amp;&amp; !isFailed" class="app__your-stat app__your-stat--passed ng-hide">
                <div>
                <h1>Thank you for applying!</h1>
                <a href="https://previewme.co/job/search" class="btn-pvm btn-tertiary btn-large btn-continue">Continue Search</a>
                <a href="https://previewme.co/dashboard" class="btn-pvm btn-tertiary btn-large btn-continue">Go to your Dashboard</a>
                </div>
            </section>

            <!-- Modal -->
            <div id="modal-preview-candidate" class="modal fade" role="dialog">
                <div class="modal-dialog">
            
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Application Preview</h4>
                        </div>
                        <div class="modal-body">
                            @include('candidate.roleapplication.preview')
                        </div>
                        <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>
            
                </div>
            </div>
        </main>
        
        <div aria-labelledby="mySmallModalLabel" class="modal fade" data-backdrop="static" data-keyboard="false" id="Loginmodal" role="dialog" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modalcontainer ng-scope">
                        <div class="col-md-10 col-md-offset-1">
                            <button aria-label="Close" class="close" type="button"><span aria-hidden="true">×</span></button>
                            <div class="row">
                                <div class="col-md-8 col-md-offset-2 text-center">
                                    <h3>Log into your account to continue</h3>
                                </div>
                            </div>
                            <div class="alert alert-danger ng-binding ng-hide" role="alert"></div>
                            <div id="result"></div>
                            <form action="/Login_Controller/LoginForm" class="ng-pristine ng-invalid ng-invalid-required" enctype="application/x-www-form-urlencoded" id="Form_LoginForm" method="post" name="Form_LoginForm" onsubmit="return false">
                                <p class="message" id="Form_LoginForm_error" style="display: none"></p>
                                <fieldset>
                                    <div class="field text nolabel" id="Form_LoginForm_email_Holder">
                                        <div class="middleColumn">
                                            <input aria-required="true" class="text nolabel ng-pristine ng-untouched ng-empty ng-invalid ng-invalid-required" id="Form_LoginForm_email" name="email" placeholder="EMAIL" required="required" type="text">
                                        </div>
                                    </div>
                                    <div class="field text password nolabel" id="Form_LoginForm_password_Holder">
                                        <div class="middleColumn">
                                            <input aria-required="true" autocomplete="off" class="text password nolabel ng-pristine ng-untouched ng-empty ng-invalid ng-invalid-required" id="Form_LoginForm_password" name="password" placeholder="PASSWORD" required="required" type="password">
                                        </div>
                                    </div><input class="hidden" id="Form_LoginForm_SecurityID" name="SecurityID" type="hidden" value="078dea0d463d5d88c558d51303e10b3f494eb5b1">
                                    <div class="clear"></div>
                                </fieldset>
                                <div class="Actions">
                                    <input class="action" id="Form_LoginForm_action_doSubmit" name="action_doSubmit" type="submit" value="Login">
                                </div>
                            </form>
                            <div class="text-center ordivider">
                                <div>
                                    or
                                </div>
                                <hr>
                            </div><button class="submitbluegreen text-center">Sign-up Today</button><br>
                            <div class="text-center">
                                <a class="text-center" href="https://previewme.co/register/password_forgot">Forgot Password?</a>
                            </div>
                            <div class="text-center ng-hide"><img src="https://previewme.co//themes/bbt/images/preloader.gif" width="25"></div><br>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</div>

@endsection

@section('scripts')
    <script src="{{ asset('js/jquery/jquery.datetimepicker.full.min.js?ver=1') }}"></script>
    <script src="{{ asset('js/candidate/role-app.js') }}"></script>
    <script>
        $('.role-tabs .tab__link').click(function (e) {
            
            $(this).tab('show')
        });

        $('.mydatepicker').datetimepicker({
            timepicker: false,
            format: 'd-m-Y'
        });
    </script>
@endsection