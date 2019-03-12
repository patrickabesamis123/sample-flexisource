@extends('layouts.candidate-profile')

@section('styles')
<link rel="stylesheet" href="css/helpers2.css" />
<link rel="stylesheet" href="css/responsive-media.css" />
@stop

@section('content')
<div class="row">
    <div id="candidate_profile_edit_content" class="candidate-profile-edit ng-scope">
        <div class="text-center splash ng-hide" ng-show="preload">
            <div class="cssload-container">
               <h3>Please wait.</h3>
               <h4>While we prepare this page for you.</h4>
               <div class="cssload-loading"><i></i><i></i><i></i><i></i></div>
            </div>
        </div>
        <div class="content-loader animate-show">
        <div class="alert alert-danger ng-binding ng-hide" role="alert" ng-show="error"></div>
            <div class="container-fluid">
               <div class="row">
                  <!-- ngIf: candidateFlashMessage -->
               </div>
            </div>
            <div id="ProfileTop" class="container-fluid">
               <div class="row">
                  <div class="container padb-30">
                     <!-- ngIf: !mobile_agent -->
                     <div class="col-md-2 ng-scope" id="phone_image">
                        <!-- ngIf: !profile_image -->
                        <!-- ngIf: profile_image -->
                        <div class="profile_image ng-scope" data-toggle="modal" data-target="#pmvImageModalNew">
                            <img ng-src="https://pvmlive.blob.core.windows.net/i8ban0sl/479a7d89f95c22de382d427104a89dd7.jpeg" class="img-circle " src="https://pvmlive.blob.core.windows.net/i8ban0sl/479a7d89f95c22de382d427104a89dd7.jpeg" width="137">
                            <img src="images/profile_camera_image.png" class="profile_image_camera" style="margin-top : -75px;margin-left : 55px;">
                        </div>
                        <!-- end ngIf: profile_image -->
                        <div class="padtb-10">
                           <a href="my-profile" class="pvm-green">View My Profile</a>
                        </div>
                     </div>
                     <!-- end ngIf: !mobile_agent -->
                     <div class="col-md-2 ng-hide" ng-show="mobile_agent">
                        <label for="mobile_image_upload" id="phone_image">
                           <!-- ngIf: !profile_image -->
                           <!-- ngIf: profile_image -->
                           <img ng-src="https://pvmlive.blob.core.windows.net/i8ban0sl/479a7d89f95c22de382d427104a89dd7.jpeg" class="img-circle ng-scope" src="https://pvmlive.blob.core.windows.net/i8ban0sl/479a7d89f95c22de382d427104a89dd7.jpeg" width="137">
                           <!-- end ngIf: profile_image -->
                           <input type="file" accept="image/*;capture=camera" id="mobile_image_upload" name="mobile_image_upload" ng-hide="true" class="ng-hide">
                        </label>
                        <div style="width:137px; padding-top:10px; text-align:center">
                           <a href="my-profile" class="pvm-green">View My Profile</a>
                        </div>
                     </div>

                     <div class="col-md-7 no-pad-r">

                        <!-- fullname edit - start -->
                        <div class="fullname">
                           <h3>
                              <div ng-hide="showNameInfo" toggleHide="fullName" toggleShow="fullNameEdit" class="fullName hideShow">
                                 <span class="capitalize_word pvm-cursor-pointer font-mont-bold ng-binding">Robin</span>
                                 <span class="capitalize_word pvm-cursor-pointer font-mont-bold ng-binding">Knight</span>
                                 <span class="nickname">
                                 <span class="pvm-cursor-pointer font-mont-bold ng-binding ng-hide" ng-show="nickname">()</span>
                                 </span>
                                 <a href="#" type="button" class="editfield">
                                 <span class="glyphicon pencil-icon"></span>
                                 </a>
                              </div>
                              <form role="form" name="editableName" style="display: none;" class="ng-pristine ng-valid ng-valid-required fullNameEdit">
                                 <div class="clearfix">
                                    <input name="first" type="text" value="Robin" class="profile_name-input ng-pristine ng-untouched ng-not-empty ng-valid ng-valid-required" placeholder="First Name" required="">
                                    <input type="text" value="Knight" class="profile_name-margin ng-pristine ng-untouched ng-not-empty ng-valid ng-valid-required" placeholder="Last Name" required="">
                                    <input type="text" class="profile_name-input ng-pristine ng-untouched ng-valid ng-empty" placeholder="Nickname">
                                 </div>
                                 <div class="buttons">
                                    <span class="editable-buttons hideShow" toggleHide="fullNameEdit" toggleShow="fullName">
                                      <button type="submit" class="btn btn-primary">
                                        <span class="glyphicon glyphicon-ok"></span>
                                      </button>
                                      <button type="button" class="btn btn-default">
                                        <span class="glyphicon glyphicon-remove"></span>
                                      </button>
                                    </span>
                                 </div>
                              </form>
                           </h3>
                        </div>
                        <!-- fullname edit - start -->

                        <!-- location edit - start -->
                        <div class="position">
                           <form editable-form="" name="editableLocation" autocomplete="off" class="ng-pristine ng-valid">
                              <div class="country hideShow" toggleHide="country" toggleShow="countryEdit">
                                 <span class="pvm-cursor-pointer editfield pvm-dark-gray ng-scope ng-binding editable">
                                 New Zealand
                                 </span>
                                 <a href="" type="button" class="editfield">
                                 <span class="glyphicon pencil-icon"></span>
                                 </a>
                                 <div class="pvm-cursor-pointer editfield pvm-dark-gray ng-scope ng-binding editable">
                                    Franklin, Auckland
                                 </div>
                              </div>
                              <div class="countryEdit" style="display: none;">
                                 <span class="editable-wrap editable-select ng-scope">
                                    <div class="editable-controls form-group">
                                       @include('test.country_dropdown')
                                       <div class="editable-error help-block ng-binding ng-hide"></div>
                                    </div>
                                 </span>
                                 <span class="locationAutoComplete">
                                    <span class="editable-wrap editable-text ng-scope">
                                       <div class="editable-controls form-group">
                                          <input type="text" name="area" class="editable-input form-control ng-pristine ng-valid ng-not-empty ng-touched" value="Franklin, Auckland">
                                          <div class="editable-error help-block ng-binding ng-hide"></div>
                                       </div>
                                    </span>
                                    <ul id="autoDataLocation" class="result" ng-hide="hideme" style="display:none">
                                       <!-- ngRepeat: (key, value) in areas -->
                                    </ul>
                                 </span>
                                 <span ng-hide="true" ng-click="editableLocation.$show()" class="pvm-cursor-pointer editfield pvm-dark-gray fieldDataid ng-scope ng-binding editable ng-hide" editable-text="preferred_location.data.id" e-name="areaid">
                                 65
                                 </span>
                                 <div class="buttons">
                                    <span class="editable-buttons hideShow" toggleHide="countryEdit" toggleShow="country">
                                      <button type="submit" class="btn btn-primary">
                                        <span class="glyphicon glyphicon-ok"></span>
                                      </button>
                                      <button type="button" class="btn btn-default">
                                        <span class="glyphicon glyphicon-remove"></span>
                                      </button>
                                    </span>
                                 </div>
                              </div>
                              <div class="form-check pull-left" style="vertical-align:middle;margin: 10px 0;">
                                <input class="form-check-input" type="checkbox" value="" id="relocateCheck">
                                <label class="form-check-label" for="relocateCheck" style="font-weight: normal;">
                                I am willing to relocate
                                </label>
                              </div>
                           </form>
                        </div>
                        <div class="clearfix"></div>
                        <!-- location edit - end -->

                        <div class="row details padb-20">
                           <div class="col-md-5">
                               <div class="row">
                                   <div class="col-md-12">
                                      <!-- mobile edit - start -->
                                      <span>
                                         <span class="col-md-3 details_title">Mobile:</span>
                                         <span class="col-md-9 candidate-top-fields-holder word-break no-padding mobile hideShow" toggleHide="mobile" toggleShow="mobileEdit">
                                         <a href="#" e-placeholder="Mobile" class="editfield ng-scope ng-binding editable editable-click">
                                         090000000021
                                         <span class="glyphicon pencil-icon"></span>
                                         </a>
                                         </span>
                                         <span class="col-md-9 candidate-top-fields-holder word-break no-padding mobileEdit" style="display: none;">
                                            <form class="form-inline editable-wrap editable-text ng-pristine ng-valid ng-scope" role="form" editable-form="$form" blur="cancel">
                                               <div class="editable-controls form-group">
                                                  <input type="text" class="top-mobile editable-input form-control ng-pristine ng-valid ng-not-empty ng-touched" placeholder="Mobile" value="090000000021">
                                                  <span class="editable-buttons hideShow" toggleHide="mobileEdit" toggleShow="mobile">
                                                  <button type="submit" class="btn btn-primary">
                                                  <span class="glyphicon glyphicon-ok"></span>
                                                  </button>
                                                  <button type="button" class="btn btn-default">
                                                  <span class="glyphicon glyphicon-remove"></span>
                                                  </button>
                                                  </span>
                                                  <div class="editable-error help-block ng-binding ng-hide"></div>
                                               </div>
                                            </form>
                                         </span>
                                      </span>
                                      <!-- mobile edit - end -->         
                                   </div>
                               </div>
                               <div class="row">
                                   <div class="col-md-12">
                                      <!-- phone edit - start -->
                                      <span>
                                         <span class="col-md-3 details_title">Phone:</span>
                                         <span class="col-md-9 candidate-top-fields-holder word-break no-padding phone">
                                         <a href="/my-profile/edit#" e-placeholder="Phone" editable-text="phone_number" e-class="top-phone" onaftersave="updateUser()" class="editfield ng-scope ng-binding editable editable-click hideShow">
                                         460000021
                                         <span class="glyphicon pencil-icon hideShow" toggleHide="phone" toggleShow="phoneEdit"></span>
                                         </a>
                                         </span>
                                         <span class="col-md-9 candidate-top-fields-holder word-break no-padding phoneEdit" style="display: none;">
                                            <form class="form-inline editable-wrap editable-text ng-pristine ng-valid ng-scope" role="form" blur="cancel">
                                               <div class="editable-controls form-group">
                                                  <input type="text" class="top-phone editable-input form-control" placeholder="Phone" value="460000021">
                                                  <span class="editable-buttons hideShow" toggleHide="phoneEdit" toggleShow="phone">
                                                  <button type="submit" class="btn btn-primary">
                                                  <span class="glyphicon glyphicon-ok"></span>
                                                  </button>
                                                  <button type="button" class="btn btn-default">
                                                  <span class="glyphicon glyphicon-remove"></span>
                                                  </button>
                                                  </span>
                                                  <div class="editable-error help-block ng-binding ng-hide"></div>
                                               </div>
                                            </form>
                                         </span>
                                      </span>
                                      <!-- phone edit - end -->         
                                   </div>
                               </div>
                               <div class="row">
                                   <div class="col-md-12">
                                      <!-- email edit - start -->
                                      <span>
                                      <span class="col-md-3 details_title">Email:</span>
                                      <span class="col-md-9 word-break no-padding ng-binding">
                                          rknight@previewmedev.co
                                      </span>
                                      </span>
                                      <!-- email edit - end -->
                                   </div>
                               </div>
                           </div>
                           <div class="col-md-7">
                                <div class="row">
                                    <div class="col-md-12">
                                        <!-- classification edit - start -->
                                        <span class="industryfield">
                                        <span class="col-md-3 details_title">Classification:</span>
                                        <span class="col-md-9 classification">
                                        <a href="/my-profile/edit#" editable-select="industry.id" onshow="loadIndustries()" e-ng-options="s.id as s.display_name for s in industries" onaftersave="updateUser()" class="editfield ng-scope ng-binding editable editable-click">
                                        Sales
                                        <span class="glyphicon pencil-icon hideShow" toggleHide="classification" toggleShow="classificationEdit"></span>
                                        </a>
                                        </span>
                                        <span class="col-md-9 classificationEdit" style="display: none;">
                                        <a href="#" class="editfield ng-scope ng-binding editable editable-click editable-hide">
                                        Sales
                                        <span class="glyphicon pencil-icon"></span>
                                        </a>
                                        <form class="form-inline editable-wrap editable-select" role="form" blur="cancel">
                                           <div class="editable-controls form-group">
                                              @include('test.classification_dropdown')
                                              <span class="editable-buttons hideShow" toggleHide="classificationEdit" toggleShow="classification">
                                              <button type="submit" class="btn btn-primary">
                                              <span class="glyphicon glyphicon-ok"></span>
                                              </button>
                                              <button type="button" class="btn btn-default">
                                              <span class="glyphicon glyphicon-remove"></span>
                                              </button>
                                              </span>
                                              <div class="editable-error help-block ng-binding ng-hide"></div>
                                           </div>
                                        </form>
                                        </span>
                                        </span>
                                        <!-- classification edit - end -->        
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <!-- sub-classification edit - start -->
                                        <span>
                                        <span data-toggle="tooltip" data-placement="top" tooltip="" 
                                        data-original-title="Sub-Classification" class="col-md-3 details_title ellipsis gray-tooltip ng-scope" style="padding-right:0px;">
                                        Sub-Classification:
                                        </span>
                                        <span class="col-md-9 sub-classification hideShow" toggleHide="sub-classification" toggleShow="sub-classificationEdit">
                                        <a href="#" class="editfield ng-scope ng-binding editable editable-click">
                                        Sales Representatives/Consultants
                                        <span class="glyphicon pencil-icon"></span>
                                        </a>
                                        </span>
                                        <span class="col-md-9 sub-classificationEdit" style="display: none;">
                                        <form class="form-inline editable-wrap editable-select ng-pristine ng-valid ng-scope" role="form" editable-form="$form" blur="cancel">
                                           <div class="editable-controls form-group">
                                              @include('test.sub-classification_dropdown')
                                              <span class="editable-buttons hideShow" toggleHide="sub-classificationEdit" toggleShow="sub-classification">
                                              <button type="submit" class="btn btn-primary">
                                              <span class="glyphicon glyphicon-ok"></span>
                                              </button>
                                              <button type="button" class="btn btn-default">
                                              <span class="glyphicon glyphicon-remove"></span>
                                              </button>
                                              </span>
                                              <div class="editable-error help-block ng-binding ng-hide"></div>
                                           </div>
                                        </form>
                                        </span>
                                        </span>
                                        <!-- sub-classification edit - end -->        
                                    </div>
                                </div>
                               <div class="row">
                                    <div class="col-md-12">
                                        <!-- salary edit - start -->
                                        <span>
                                         <form editable-form="" name="editableSalary" onaftersave="updateSalaryRange()" class="profileeditsalary ng-pristine ng-valid">
                                            <span class="col-md-3 details_title" style="padding-right:0px;">Salary Range:</span>
                                            <span class="col-md-9 candidate_top_salary_field word-break">
                                               <span e-placeholder="Min" editable-text="min_salary" e-name="min_salary" class="editfield ng-scope editable editable-empty" e-ng-keypress="numbersOnly()">
                                                  <!-- ngIf: min_salary !== null && max_salary !== null && min_salary !== 0 && max_salary !== 0 ||
                                                     min_salary !== null && max_salary == null ||
                                                     min_salary == null && max_salary !== null ||
                                                     min_salary == 0 && max_salary !== 0 ||
                                                     min_salary != 0 && max_salary == 0 -->
                                                  <!-- ngIf: min_salary == null && max_salary == null ||
                                                     min_salary == 0 && max_salary == 0 --><span ng-if="
                                                     min_salary == null &amp;&amp; max_salary == null ||
                                                     min_salary == 0 &amp;&amp; max_salary == 0 " class="ng-scope">
                                                  Add Salary
                                                  </span><!-- end ngIf: min_salary == null && max_salary == null ||
                                                     min_salary == 0 && max_salary == 0 -->
                                               </span>
                                               <span e-placeholder="Max" editable-text="max_salary" e-ng-keypress="numbersOnly()" class="editfield ng-scope editable editable-empty"></span>
                                               <a href="" type="button" class="editfield" ng-click="editableSalary.$show()" ng-show="!editableSalary.$visible">
                                               <span class="glyphicon lock-icon gray-tooltip ng-scope" title="This field will not be displayed on your public profile." data-toggle="tooltip" data-placement="top" tooltip=""></span>
                                               </a>
                                               <div class="buttons">
                                                  <span ng-show="editableSalary.$visible" class="ng-hide">
                                                  <button type="submit" class="btn btn-primary-bbt" ng-disabled="editableSalary.$waiting">
                                                  <span class="glyphicon glyphicon-ok"></span>
                                                  </button>
                                                  <button type="button" class="btn btn-default-bbt" ng-disabled="editableSalary.$waiting" ng-click="editableSalary.$cancel()">
                                                  <span class="glyphicon glyphicon-remove"></span>
                                                  </button>
                                                  </span>
                                               </div>
                                            </span>
                                         </form>
                                        </span>
                                        <div class="clearfix"></div>
                                        <!-- salary edit - end -->
                                    </div>
                                </div><!-- eof row -->
                           </div>
                        </div>
                     </div>
                     <div class="col-md-3" id="video_container">
                         <div class="row">
                           <div class="col-md-12">
                            <!-- <div ng-show="preview_img == true" class="ng-hide">
                               <img ng-src="themes/bbt/images/placeholder_vid.png" src="themes/bbt/images/placeholder_vid.png" width="275">
                               <a href="/my-profile/edit#" data-toggle="modal" style="top:53px;left:94px;" data-target="#pmvCameraModalNew" class="add_photo_button2 pvm-blue">Upload Video</a>
                               </div> -->
                            <!-- <div ng-show="preview_img == 'loading' " class="text-center ng-hide">
                               <img src="themes/bbt/images/ajax-loader-video.gif" style="width:106px;padding-bottom:10px">
                               <div style="margin-bottom: 25px">
                               We will notify you once your video has been uploaded. You can still use the full site while the video is processing
                               </div>
                               </div>
                               <div ng-show="preview_img == 'error' " class="text-center ng-binding ng-hide">
                               </div>
                               <div>
                               <small><a href="Tips for making the perfect video!" data-toggle="modal" data-target=".bs-modal-lg">Tips for making the perfect video!</a></small>
                               <div class="modal fade bs-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
                               <div class="modal-dialog modal-lg" role="document">
                               <div class="modal-content">
                               <div class="modal-header">
                               <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                               <h4 class="modal-title" id="myModalLabel">Tips to record the perfect video</h4>
                               </div>
                               <div class="modal-body">
                               <p>Visit the <a href="https://previewme.co/resources" target="_blank">blog</a> to watch examples of Profile videos.</p>
                               <iframe src="https://www.youtube.com/embed/hA-A_hWD8vs" allowfullscreen="" width="100%" height="500" frameborder="0"></iframe>
                               </div>
                               </div>
                               </div>
                               </div>
                               </div>
                               -->
                               <video id="myvideo" width="275" controls autoplay>
                                   <source src="/videos/1014676814-preview.mp4" type="video/mp4">
                                   <!-- <source src="/videos/1014676814-preview.mp4" type="video/ogg"> -->
                                   Your browser does not support the video tag.
                               </video>
                           </div>
                         </div>       
                     </div>
                  </div>
               </div><!-- eof row -->
            </div><!-- eof ProfileTop -->

            <div id="ProfileBottom" class="container-fluid">
               <div class="row">
                  <div class="container">
                     <div class="col-md-9 adjust-padding-right">
                        <div ng-show="ProfileUpdated" class="alert alert-success ng-hide" role="alert">
                           Profile Update
                           <button type="button" class="close" ng-click="disableAlert()" aria-label="Close"><span aria-hidden="true">×</span></button>
                        </div>

                        <!-- about edit - start -->
                        <div class="row aboutme">
                           <div class="col-md-12">
                              <h3 class="pvm-cursor-pointer" style="width:150px;">
                                 ABOUT ME
                                 <i class="glyphicon glyphicon-info-sign tooltip_btn ng-scope" data-toggle="tooltip" data-placement="top" tooltip="" data-original-title="Take this opportunity to introduce yourself and highlight what makes you unique. Think; personal and professional attributes, career goals, skills, achievements, sport, community, teamwork, languages..."></i>
                              </h3>
                              <div class="content">
                                 <div class="buttons about">
                                    <a href="#">
                                    <span class="glyphicon pencil-icon hideShow" toggleHide="about" toggleShow="aboutEdit"></span>
                                    </a>
                                    <div class="pvm-gray description_content ng-binding text-justify">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.<br><br>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?<br><br>At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat.</div>
                                 </div>
                                 <div class="qualification aboutEdit" style="display: none;">
                                    <span e-form="rowform1" class="editfield ng-scope editable" editable-textarea="long_description" e-name="long_description" e-rows="8" e-cols="100"></span>
                                    <span class="editable-wrap editable-textarea ng-scope">
                                       <div class="editable-controls form-group">
                                          <textarea name="long_description" rows="8" cols="100" class="editable-input form-control ng-pristine ng-valid ng-not-empty ng-touched">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.&#13;&#10;&#13;&#10;Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?&#13;&#10;&#13;&#10;At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat.</textarea>
                                          <div class="editable-error help-block ng-binding ng-hide" ng-show="$error" ng-bind="$error"></div>
                                       </div>
                                    </span>
                                    <form name="rowform1" class="form-buttons form-inline ng-pristine ng-valid">
                                       <div class="pull-right hideShow" toggleHide="aboutEdit" toggleShow="about" style="display: inline-flex;">
                                          <button type="submit" class="btn btn-primary-bbt">SAVE</button>
                                          <button type="button" class="btn-pvm btn-default-bbt">CANCEL</button>
                                       </div>
                                    </form>
                                 </div>
                                 <div class="clearfix"></div>
                              </div>
                           </div>
                        </div><!-- eof row -->
                        <!-- about - end -->

                        <!-- work experience - start -->
                        <h3 class="CPE-section-title">Work Experience</h3>
                        <div class="CPE-work-list">
                           <div class="CPE__work-item ng-scope work1">
                              <div>
                                 <div class="CPE-action-buttons">
                                    <i class="fa fa-pencil hideShow" toggleHide="work1" toggleShow="work1Edit" title="Update"></i>
                                    <i class="fa fa-trash-o" title="Delete" confirmed-click="deleteWork(history)" ng-confirm-click="Are you sure you want to delete this?"></i>
                                 </div>
                                 <h4 class="work-company-name ng-binding">Sales Company Inc.</h4>
                                 <h4 class="work-job-title ng-binding">Sales Rep | Contract</h4>
                                 <p class="work-completed ng-binding">May 2005 - June 2016 (11 year/s)</p>
                                 <p ng-show="history.salary > 0" class="work-salary ng-binding ng-hide">$ 0</p>
                                 <h4 class="CPE-section-subtitle">Key accountabilities</h4>
                                 <div class="work-responsibilities-list">
                                    <div class="work-responsibilities__item ng-scope">
                                       <span class="ng-binding">Sell Products</span>
                                       <span class="ar__details ng-scope">,&nbsp;</span>
                                    </div>
                                    <div class="work-responsibilities__item ng-scope">
                                       <span class="ng-binding">Sell Services</span>
                                    </div>
                                 </div>
                                 <h4 class="CPE-section-subtitle">Job in a nutshell</h4>
                                 <p class="work-description ng-binding text-justify">Sales representatives sell retail products, goods and services to customers. Sales representatives work with customers to find what they want, create solutions and ensure a smooth sales process. Sales representatives will work to find new sales leads, through business directories, client referrals, etc. Sometimes, sales representatives will focus on inside sales, which typically involves "cold calling" for new clients while in an office setting, or outside sales, which involves visiting clients in the field with new or existing clients. Often, there sales representatives will have a combination inside/outside sales job.</p>
                                 <ul class="work-classification-list">
                                    <li class="work-classification__item ng-scope">
                                       <h4 class="work-classification ng-binding">Sales</h4>
                                       <h4 class="work-sub-classification ng-binding">Sales Representatives/Consultants</h4>
                                    </li>
                                 </ul>
                              </div>
                           </div>
                           <div class="CPE__work-item ng-scope work1Edit" style="display: none;">
                              <form class="CPE-work-form ng-pristine ng-scope ng-invalid ng-invalid-required ng-valid-maxlength">
                                 <input type="text" placeholder="Company Name" class="pvm-input-text work-company-name work-company-name--form ng-pristine ng-untouched ng-empty ng-invalid ng-invalid-required" required="required" value="Sales Company Inc.">
                                 <input type="text" placeholder="Job / Role Title" class="pvm-input-text work-job-title work-job-title--form ng-pristine ng-untouched ng-empty ng-invalid ng-invalid-required" required="required" value="Sales Rep">
                                 @include('test.work_type_dropdown')
                                 <input type="text" id="history-salary" class="pvm-input-text work-salary work-salary--form ng-pristine ng-untouched ng-valid ng-empty ng-valid-maxlength" maxlength="8" placeholder="Salary (confidential and optional)" value="0">
                                 <input type="text" class="datepicker pvm-input-text mydatepicker work-start-date ng-pristine ng-untouched ng-empty ng-invalid ng-invalid-required" placeholder="Start Date" required="required" value="05-10-2005">
                                 <input type="text" class="datepicker pvm-input-text mydatepicker work-end-date ng-pristine ng-untouched ng-empty ng-invalid ng-invalid-required" placeholder="End Date" required="required" value="06-02-2016">
                                 <span class="form-check pull-left" style="position: relative;display: inline-block;width: 100%;line-height: 38px;">
                                 <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                                 <label class="form-check-label" for="defaultCheck1" style="font-weight: normal;">
                                 I currently work here
                                 </label>
                                 </span>
                                 <h4 class="CPE-section-subtitle">Key accountabilities </h4>
                                 <div class="work-responsibilities-list work-responsibilities-list--form">
                                    <div class="work-responsibilities__item work-responsibilities__item--form ng-scope">
                                       <input type="text" name="" class="pvm-input-text work-responsibilities ng-pristine ng-untouched ng-valid ng-empty" value="Sell Products">
                                       <i class="fa fa-close"></i>
                                       <input type="text" name="" class="pvm-input-text work-responsibilities ng-pristine ng-untouched ng-valid ng-empty" value="Sell Services">
                                       <i class="fa fa-close"></i>
                                    </div>
                                    <div class="work-responsibilities__item work-responsibilities__item--form work-responsibilities__item--more">
                                       <i class="fa fa-plus" title="Add accountabilities"> <span>Add Responbilities</span></i>
                                    </div>
                                 </div>
                                 <textarea placeholder="Job Description" class="pvm-textarea work-description work-description--form ng-pristine ng-untouched ng-valid ng-empty">Sales representatives sell retail products, goods and services to customers. Sales representatives work with customers to find what they want, create solutions and ensure a smooth sales process. Sales representatives will work to find new sales leads, through business directories, client referrals, etc. Sometimes, sales representatives will focus on inside sales, which typically involves "cold calling" for new clients while in an office setting, or outside sales, which involves visiting clients in the field with new or existing clients. Often, there sales representatives will have a combination inside/outside sales job.</textarea>
                                 <h4 class="CPE-section-subtitle">Classifications</h4>
                                 @include('test.classification2_dropdown')
                                 <h4 class="CPE-section-subtitle">Sub-classifications </h4>
                                 @include('test.sub-classification_dropdown')
                                 <div class="CPE-form-buttons hideShow" toggleHide="work1Edit" toggleShow="work1">
                                    <input type="submit" value="SAVE" class="action submit_wh btn btn-pvm btn-primary btn-mini">
                                    <a href="" ng-click="CancelWorkHistoryForm(history)" class="cancel_wh btn btn-pvm btn-default btn-mini">CANCEL</a>
                                 </div>
                              </form>
                           </div>
                           <div class="CPE__work-item ng-scope work2">
                              <div>
                                 <div class="CPE-action-buttons">
                                    <i class="fa fa-pencil hideShow" toggleHide="work2" toggleShow="work2Edit" title="Update" ng-click="openWorkHistoryEdit(history)"></i>
                                    <i class="fa fa-trash-o" title="Delete" confirmed-click="deleteWork(history)" ng-confirm-click="Are you sure you want to delete this?"></i>
                                 </div>
                                 <h4 class="work-company-name ng-binding">Acme Co.</h4>
                                 <h4 class="work-job-title ng-binding">Sales Manager | Contract</h4>
                                 <p class="work-completed ng-binding">June 2016 - Present (2 year/s)</p>
                                 <p class="work-salary ng-binding ng-hide">$ 0</p>
                                 <h4 class="CPE-section-subtitle">Key accountabilities</h4>
                                 <div class="work-responsibilities-list">
                                    <div class="work-responsibilities__item ng-scope">
                                       <span class="ng-binding">Analyze sales</span>
                                       <span class="ar__details ng-scope">,&nbsp;</span>
                                    </div>
                                    <div class="work-responsibilities__item ng-scope">
                                       <span class="ng-binding">Monitor customer</span>
                                    </div>
                                 </div>
                                 <h4 class="CPE-section-subtitle">Job in a nutshell</h4>
                                 <p class="work-description ng-binding text-justify">Collect and interpret complex data to target the most promising areas and determine the most effective sales strategies. They need to work with people in other departments and with customers, so they must be able to communicate clearly. When helping to make a sale, sales managers must listen and respond to the customer’s needs. Sales managers must be able to evaluate how sales staff perform and develop ways for struggling members to improve.</p>
                                 <ul class="work-classification-list">
                                    <li class="work-classification__item ng-scope">
                                       <h4 class="work-classification ng-binding">Sales</h4>
                                       <h4 class="work-sub-classification ng-binding">Sales Representatives/Consultants</h4>
                                    </li>
                                 </ul>
                              </div>
                           </div>
                           <div class="CPE__work-item ng-scope work2Edit" style="display: none;">
                              <form class="CPE-work-form ng-pristine ng-scope ng-invalid ng-invalid-required ng-valid-maxlength">
                                 <input type="text" placeholder="Company Name" class="pvm-input-text work-company-name work-company-name--form ng-pristine ng-untouched ng-empty ng-invalid ng-invalid-required" required="required" value="Sales Company Inc.">
                                 <input type="text" placeholder="Job / Role Title" class="pvm-input-text work-job-title work-job-title--form ng-pristine ng-untouched ng-empty ng-invalid ng-invalid-required" required="required" value="Sales Rep">
                                 @include('test.work_type_dropdown')
                                 <input type="text" id="history-salary" class="pvm-input-text work-salary work-salary--form ng-pristine ng-untouched ng-valid ng-empty ng-valid-maxlength" maxlength="8" placeholder="Salary (confidential and optional)" value="0">
                                 <input type="text" class="datepicker pvm-input-text mydatepicker work-start-date ng-pristine ng-untouched ng-empty ng-invalid ng-invalid-required" placeholder="Start Date" required="required" value="06-10-2016">
                                 <input type="text" class="datepicker pvm-input-text mydatepicker work-end-date ng-pristine ng-untouched ng-empty ng-invalid ng-invalid-required" placeholder="End Date" required="required" value="<?php echo date("m-d-Y");?>">
                                 <span class="form-check pull-left" style="position: relative;display: inline-block;width: 100%;line-height: 38px;">
                                 <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                                 <label class="form-check-label" for="defaultCheck1" style="font-weight: normal;">
                                 I currently work here
                                 </label>
                                 </span>
                                 <h4 class="CPE-section-subtitle">Key accountabilities </h4>
                                 <div class="work-responsibilities-list work-responsibilities-list--form">
                                    <div class="work-responsibilities__item work-responsibilities__item--form ng-scope" ng-repeat="accnt in history.key_accountabilities track by $index">
                                       <input type="text" name="" class="pvm-input-text work-responsibilities ng-pristine ng-untouched ng-valid ng-empty">
                                       <i class="fa fa-close"></i>
                                    </div>
                                    <div class="work-responsibilities__item work-responsibilities__item--form work-responsibilities__item--more">
                                       <i class="fa fa-plus" title="Add accountabilities"> <span>Add Responbilities</span></i>
                                    </div>
                                 </div>
                                 <textarea placeholder="Job Description" class="pvm-textarea work-description work-description--form ng-pristine ng-untouched ng-valid ng-empty">Collect and interpret complex data to target the most promising areas and determine the most effective sales strategies. They need to work with people in other departments and with customers, so they must be able to communicate clearly. When helping to make a sale, sales managers must listen and respond to the customer’s needs. Sales managers must be able to evaluate how sales staff perform and develop ways for struggling members to improve.</textarea>
                                 <h4 class="CPE-section-subtitle">Classifications</h4>
                                 @include('test.classification2_dropdown')
                                 <h4 class="CPE-section-subtitle">Sub-classifications </h4>
                                 @include('test.sub-classification_dropdown')
                                 <div class="CPE-form-buttons hideShow" toggleHide="work2Edit" toggleShow="work2">
                                    <input type="submit" value="SAVE" class="action submit_wh btn btn-pvm btn-primary btn-mini">
                                    <a href="" ng-click="CancelWorkHistoryForm(history)" class="cancel_wh btn btn-pvm btn-default btn-mini">CANCEL</a>
                                 </div>
                              </form>
                           </div>
                           <div class="CPE__work-item ng-scope experienceNewEdit" style="display: none;">
                              <form class="CPE-work-form ng-pristine ng-scope ng-invalid ng-invalid-required ng-valid-maxlength">
                                 <input type="text" placeholder="Company Name" class="pvm-input-text work-company-name work-company-name--form ng-pristine ng-untouched ng-empty ng-invalid ng-invalid-required" required="required">
                                 <input type="text" placeholder="Job / Role Title" class="pvm-input-text work-job-title work-job-title--form ng-pristine ng-untouched ng-empty ng-invalid ng-invalid-required" required="required">
                                 @include('test.work_type_dropdown')
                                 <input type="text" id="history-salary" class="pvm-input-text work-salary work-salary--form ng-pristine ng-untouched ng-valid ng-empty ng-valid-maxlength" maxlength="8" placeholder="Salary (confidential and optional)">
                                 <input type="text" class="datepicker pvm-input-text mydatepicker work-start-date ng-pristine ng-untouched ng-empty ng-invalid ng-invalid-required" placeholder="Start Date" required="required">
                                 <input type="text" class="datepicker pvm-input-text mydatepicker work-end-date ng-pristine ng-untouched ng-empty ng-invalid ng-invalid-required" placeholder="End Date" ng-disabled="history.currently_work_here" required="required">
                                 <span class="form-check pull-left" style="position: relative;display: inline-block;width: 100%;line-height: 38px;">
                                 <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                                 <label class="form-check-label" for="defaultCheck1" style="font-weight: normal;">
                                 I currently work here
                                 </label>
                                 </span>
                                 <h4 class="CPE-section-subtitle">Key accountabilities </h4>
                                 <div class="work-responsibilities-list work-responsibilities-list--form">
                                    <div class="work-responsibilities__item work-responsibilities__item--form ng-scope" ng-repeat="accnt in history.key_accountabilities track by $index">
                                       <input type="text" name="" class="pvm-input-text work-responsibilities ng-pristine ng-untouched ng-valid ng-empty">
                                       <i class="fa fa-close"></i>
                                    </div>
                                    <div class="work-responsibilities__item work-responsibilities__item--form work-responsibilities__item--more">
                                       <i class="fa fa-plus" title="Add accountabilities"> <span>Add Responbilities</span></i>
                                    </div>
                                 </div>
                                 <textarea placeholder="Job Description" class="pvm-textarea work-description work-description--form ng-pristine ng-untouched ng-valid ng-empty"></textarea>
                                 <h4 class="CPE-section-subtitle">Classifications</h4>
                                 @include('test.classification2_dropdown')
                                 <div class="CPE-form-buttons hideShow" toggleHide="experienceNewEdit" toggleShow="experienceNew">
                                    <input type="submit" value="SAVE" class="action submit_wh btn btn-pvm btn-primary btn-mini">
                                    <a href="" ng-click="CancelWorkHistoryForm(history)" class="cancel_wh btn btn-pvm btn-default btn-mini">CANCEL</a>
                                 </div>
                              </form>
                           </div>
                        </div>
                        <a href="" class="btn-pvm btn-primary btn-mini CPE-add-button experienceNew hideShow" toggleHide="experienceNew" toggleShow="experienceNewEdit">Add Work Experience</a>
                        <!-- work experience - end -->

                        <!-- education - start -->
                        <h3 class="CPE-section-title">Education</h3>
                        <ul class="CPE-education-list">
                           <li class="CPE__education-item ng-scope">
                              <div class="CPE-education-display education1">
                                 <div class="CPE-action-buttons">
                                    <i class="fa fa-pencil hideShow" toggleHide="education1" toggleShow="education1Edit" title="Update"></i>
                                    <i class="fa fa-trash-o" title="Delete" confirmed-click="delete_education(education)" ng-confirm-click="Are you sure you want to delete this?"></i>
                                 </div>
                                 <h3 class="education-degree ng-binding">Bachelor's Degree Sales and Marketing</h3>
                                 <h3 class="education-university ng-binding">Alfriston College, Auckland, New Zealand</h3>
                                 <h4 class="education-completed ng-binding" ng-bind="education.completed_date | date : 'MMM, yyyy'">06-09-2005</h4>
                                 <h4 class="education-completed ng-hide">Currently studying</h4>
                                 <img class="education-image ng-scope" src="\images\schools\school_1.png">
                              </div>
                              <form class="CPE-education-form ng-pristine ng-valid ng-scope ng-valid-required education1Edit" style="display: none;">
                                 @include('test.education1_dropdown')
                                 <input type="text" placeholder="Other"  class="ng-pristine ng-untouched ng-valid ng-empty ng-hide">
                                 <div class="CPE-ed-qualification-con">
                                    <input type="text" placeholder="Field of study" class="pvm-input-text ed-qualification ng-pristine ng-untouched ng-valid ng-not-empty ng-valid-required" required="" value="Sales and Marketing">
                                 </div>
                                 <div class="CPE-ed-qualification-provider-con">
                                    <input type="text" placeholder="Education Provider" class="pvm-input-text ed-qualification-provider ng-pristine ng-untouched ng-valid ng-not-empty ng-valid-required" required="" value="Alfriston College, Auckland, New Zealand">
                                 </div>
                                 <input type="text" class="datepicker pvm-input-text mydatepicker education-completed education-completed--form ng-pristine ng-untouched ng-valid ng-not-empty ng-valid-required" placeholder="Completed Date" required="required" value="06-09-2005">
                                 <span class="form-check pull-left" style="position: relative;display: inline-block;width: 100%;line-height: 38px;">
                                 <input class="form-check-input" type="checkbox" value="" id="educationCheck1">
                                 <label class="form-check-label" for="educationCheck1" style="font-weight: normal;">
                                 I currently study here
                                 </label>
                                 </span>
                                 <div class="CPE-form-buttons hideShow" toggleHide="education1Edit" toggleShow="education1">
                                    <input type="submit" value="SAVE" class="btn btn-pvm btn-primary btn-mini">
                                    <a href="" ng-click="CancelEducationForm(education)" class="btn btn-pvm btn-default btn-mini">CANCEL</a>
                                 </div>
                              </form>
                           </li>
                           <li class="CPE__education-item ng-scope">
                              <div class="CPE-education-display education2">
                                 <div class="CPE-action-buttons">
                                    <i class="fa fa-pencil hideShow" toggleHide="education2" toggleShow="education2Edit" title="Update" ></i>
                                    <i class="fa fa-trash-o" title="Delete" confirmed-click="delete_education(education)" ng-confirm-click="Are you sure you want to delete this?"></i>
                                 </div>
                                 <h3 class="education-degree ng-binding">High School High School</h3>
                                 <h3 class="education-university ng-binding">James Hargest College</h3>
                                 <h4 class="education-completed ng-binding" ng-bind="education.completed_date | date : 'MMM, yyyy'">05-24-2002</h4>
                                 <h4 class="education-completed ng-hide">Currently studying</h4>
                                 <img class="education-image ng-scope" src="\images\schools\school_2.png">
                              </div>
                              <form class="CPE-education-form ng-pristine ng-valid ng-scope ng-valid-required education2Edit" style="display: none;">
                                 @include('test.education2_dropdown')
                                 <input type="text" placeholder="Other"  class="ng-pristine ng-untouched ng-valid ng-empty ng-hide">
                                 <div class="CPE-ed-qualification-con">
                                    <input type="text" placeholder="Field of study" class="pvm-input-text ed-qualification ng-pristine ng-untouched ng-valid ng-not-empty ng-valid-required" required="" value="High School">
                                 </div>
                                 <div class="CPE-ed-qualification-provider-con">
                                    <input type="text" placeholder="Education Provider" class="pvm-input-text ed-qualification-provider ng-pristine ng-untouched ng-valid ng-not-empty ng-valid-required" required="" value="James Hargest College">
                                 </div>
                                 <input type="text" class="datepicker pvm-input-text education-completed education-completed--form ng-pristine ng-untouched ng-valid ng-not-empty ng-valid-required" placeholder="Completed Date" required="required" value="05-24-2002">
                                 <span class="form-check pull-left" style="position: relative;display: inline-block;width: 100%;line-height: 38px;">
                                 <input class="form-check-input" type="checkbox" value="" id="educationCheck2">
                                 <label class="form-check-label" for="educationCheck2" style="font-weight: normal;">
                                 I currently study here
                                 </label>
                                 </span>
                                 <div class="CPE-form-buttons hideShow" toggleHide="education2Edit" toggleShow="education2">
                                    <input type="submit" value="SAVE" class="btn btn-pvm btn-primary btn-mini">
                                    <a href="" ng-click="CancelEducationForm(education)" class="btn btn-pvm btn-default btn-mini">CANCEL</a>
                                 </div>
                              </form>
                           </li>
                           <li class="CPE__education-item ng-scope education0Edit" style="display: none;">
                              <form class="CPE-education-form ng-pristine ng-valid ng-scope ng-valid-required">
                                 @include('test.education0_dropdown')
                                 <input type="text" placeholder="Other"  class="ng-pristine ng-untouched ng-valid ng-empty ng-hide">
                                 <div class="CPE-ed-qualification-con">
                                    <input type="text" placeholder="Field of study" class="pvm-input-text ed-qualification ng-pristine ng-untouched ng-valid ng-not-empty ng-valid-required" required="" value="">
                                 </div>
                                 <div class="CPE-ed-qualification-provider-con">
                                    <input type="text" placeholder="Education Provider" class="pvm-input-text ed-qualification-provider ng-pristine ng-untouched ng-valid ng-not-empty ng-valid-required" required="" value="">
                                 </div>
                                 <input type="text" class="datepicker pvm-input-text education-completed education-completed--form ng-pristine ng-untouched ng-valid ng-not-empty ng-valid-required" placeholder="Completed Date" required="required" value="">
                                 <span class="form-check pull-left" style="position: relative;display: inline-block;width: 100%;line-height: 38px;">
                                 <input class="form-check-input" type="checkbox" value="" id="educationCheck0">
                                 <label class="form-check-label" for="educationCheck0" style="font-weight: normal;">
                                 I currently study here
                                 </label>
                                 </span>
                                 <div class="CPE-form-buttons hideShow" toggleHide="education0Edit" toggleShow="education0">
                                    <input type="submit" value="SAVE" class="btn btn-pvm btn-primary btn-mini">
                                    <a href="" ng-click="CancelEducationForm(education)" class="btn btn-pvm btn-default btn-mini">CANCEL</a>
                                 </div>
                              </form>
                           </li>
                        </ul>
                        <a href="#" class="animate-show btn-pvm btn-primary btn-mini CPE-add-button education0 hideShow" toggleHide="education0" toggleShow="education0Edit">Add Education</a>
                        <!-- education - end -->
                        <div class="clearfix"></div>
                     </div>
                     
                     <!-- Other Scripts -->
                     <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
                     <link rel="stylesheet" href="/resources/demos/style.css">
                     <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
                     <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
                     <script>
                        $( function() {
                            $( ".datepicker" ).datepicker({ 
                                dateFormat: 'mm-dd-yy'
                            });
                        } );
                     </script>
                     <script type="text/javascript">
                        $( ".hideShow" ).click(function() {
                            var hideId = $(this).attr('toggleHide');
                            var showId = $(this).attr('toggleShow');
                            $( "."+hideId+"" ).hide();
                            $( "."+showId+"" ).show();
                            return false;   
                        });
                     </script>
                     <!-- EOF Other Scripts -->

                     <div class="col-md-3" id="right_side_profile">

                        <div class="add_your_con marginb-40">
                           <h3>ADD/UPDATE YOUR</h3>
                           <!-- video edit - start -->  
                           <div class="link_con text-left">
                              <form class="ng-pristine ng-valid" id="Form" action="#" method="post" enctype="multipart/form-data">
                                 <p id="Form_error" class="message " style="display: none"></p>
                                 <div class="col-md-8" style="border-right: 1px solid #ccc">
                                    <div id="Form_video_upload_Holder" class="field file">
                                       <span class="left">VIDEO</span>
                                    </div>
                                 </div>
                                 <div class="col-md-4 no-padding-r">
                                    <span class="glyphicon" style="padding:0px 10px;"></span>
                                    <span class="glyphicon pencil-icon pvm-cursor-pointer" id="Form_video_upload" style="margin-right:0; margin-left: 5px;" data-toggle="modal" data-target="#pmvCameraModalNew"></span>
                                    <label for="mobile_video_upload" ng-show="mobile_agent" class="ng-hide">
                                    <span class="glyphicon pencil-icon pvm-cursor-pointer" style="margin-right:0; margin-left: 5px;"></span>
                                    <input name="mobile_video_upload" id="mobile_video_upload" data-old_file="" type="file" accept="video/*" ng-hide="true" class="ng-hide">
                                    </label>
                                    <!-- ngIf: !docs.icebreaker_video.doc_id -->
                                 </div>
                                 <div class="Actions">
                                    <input name="action_doNothing" value="Submit button" class="action ng-hide" id="Form_action_doNothing" type="submit" ng-hide="true">
                                 </div>
                              </form>
                              <div class="progress-striped active ng-hide progress ng-isolate-scope" id="video_progress" animate="true" max="100" value="progressValue" type="success">
                                 <div class="progress-bar progress-bar-success" ng-class="type &amp;&amp; 'progress-bar-' + type" role="progressbar" aria-valuenow="" aria-valuemin="0" aria-valuemax="100" ng-style="{width: percent + '%'}" aria-valuetext="%" ng-transclude="" style=""></div>
                              </div>
                              <div class="clearfix"></div>
                           </div>
                           <!-- video edit - end -->
                           <!-- resume edit - start -->
                           <div class="link_con text-left">
                              <form id="Form" action="/bitbucket/previewme/my-account/" method="post" enctype="multipart/form-data" ng-submit="upload()" onsubmit="return false" class="ng-pristine ng-valid ng-invalid-required">
                                 <p id="Form_error" class="message" style="display: none"></p>
                                 <div class="col-md-8" style="border-right: 1px solid #ccc">
                                    <div id="Form_my_file_Holder" class="field file">
                                       <span class="left">RESUME</span>
                                    </div>
                                 </div>
                                 <div class="col-md-4 no-padding-r">
                                    <!-- <a class="custom-icon-eye" ng-href="" target="_blank"></a> -->
                                    <span class="glyphicon" style="padding:0px 10px;"></span>
                                    <span ng-hide="mobile_agent" class="glyphicon pencil-icon pvm-cursor-pointer" data-docfiletype="resume" style="margin-right:0; margin-left: 5px;" data-toggle="modal" data-target="#pmvFileModalNew"></span>
                                    <label for="mobile_resume_upload" ng-show="mobile_agent" class="ng-hide">
                                    <span class="glyphicon pencil-icon pvm-cursor-pointer" data-docfiletype="resume" style="margin-right:0; margin-left: 5px;">
                                    <input name="mobile_resume_upload" id="mobile_resume_upload" data-old_file="" type="file" ng-hide="true" class="ng-hide">
                                    </span>
                                    </label>
                                    <!-- ngIf: docs.resume.doc_id -->
                                    <!-- ngIf: !docs.resume.doc_id -->
                                    <span ng-if="!docs.resume.doc_id" class="glyphicon ng-scope" style="margin-left:5px"></span>
                                    <!-- end ngIf: !docs.resume.doc_id -->
                                 </div>
                                 <div class="Actions">
                                    <input type="submit" name="action_doNothing" value="Submit button" class="action ng-hide" id="Form_action_doNothing" ng-hide="true">
                                 </div>
                              </form>
                              <div class="progress-striped active ng-hide progress ng-isolate-scope" id="data_progress" animate="true" max="100" value="progressResumeValue" type="success">
                                 <div class="progress-bar progress-bar-success" ng-class="type &amp;&amp; 'progress-bar-' + type" role="progressbar" aria-valuenow="" aria-valuemin="0" aria-valuemax="100" ng-style="{width: percent + '%'}" aria-valuetext="%" ng-transclude="" style=""></div>
                              </div>
                              <div class="clearfix"></div>
                           </div>
                           <!-- resume edit - end -->
                           <!-- supporting docs edit - start -->
                           <div class="link_con text-left">
                              <div class="col-md-8" style="border-right: 1px solid #ccc">
                                 <div>
                                    <span>SUPPORTING DOCS</span>
                                 </div>
                              </div>
                              <div class="col-md-4 no-padding-r">
                                 <!-- <a class="custom-icon-eye" ng-href="" target="_blank"></a> -->
                                 <span class="glyphicon" style="padding:0px 10px;"></span>
                                 <span ng-hide="mobile_agent" class="glyphicon pencil-icon pvm-cursor-pointer" data-docfiletype="portfolio" style="margin-right:0; margin-left: 5px;" data-toggle="modal" data-target="#pmvFileModalNew"></span>
                                 <label for="mobile_portfolio_upload" class="ng-hide">
                                 <span class="glyphicon pencil-icon pvm-cursor-pointer" style="margin-right:0; margin-left: 5px;"></span>
                                 <input name="mobile_portfolio_upload" id="mobile_portfolio_upload" data-old_file="" type="file" ng-hide="true" class="ng-hide">
                                 </label>
                                 <span ng-if="!docs.portfolio.doc_id" class="glyphicon ng-scope" style="margin-left:5px"></span>
                              </div>
                              <div class="progress-striped active ng-hide progress ng-isolate-scope" id="data_progress_portfolio" animate="true" max="100" value="progressPortfolioValue" type="success">
                                 <div class="progress-bar progress-bar-success" ng-class="type &amp;&amp; 'progress-bar-' + type" role="progressbar" aria-valuenow="" aria-valuemin="0" aria-valuemax="100" ng-style="{width: percent + '%'}" aria-valuetext="%" ng-transclude="" style=""></div>
                              </div>
                              <div class="clearfix"></div>
                           </div>
                           <!-- supporting docs edit - end -->
                        </div>

                        <div class="reference_title">
                           <h3>References</h3>
                        </div>
                         
                        <!-- reference 1 edit - start -->
                        <div class="row ng-scope">
                           <div class="col-md-12">
                               <div id="ref_423" class="reference_con reference1">
                                  <div class="buttons">
                                     <a ng-confirm-click="Are you sure you want to delete this?" data-id="423" class="pull-right">
                                     <span class="glyphicon glyphicon-trash"></span>
                                     </a>
                                     <a href="#" type="button" class="editfield pull-right">
                                     <span class="glyphicon pencil-icon hideShow" toggleHide="reference1" toggleShow="reference1Edit"></span>
                                     </a>
                                  </div>
                                  <div class="ref_description_con">
                                     <span e-form="rowform" e-placeholder="Description" class="editfield white-space-pre-line ng-scope ng-binding editable" editable-textarea="reference.description" e-name="description">
                                     Reference 1
                                     </span>
                                  </div>
                                  <br>
                                  <div class="text-right">
                                     <span e-form="rowform" class="editfield pvm-blue ng-scope editable" e-placeholder="Employer name" editable-text="reference.employer_name" e-name="employer_name">
                                     <span class="ng-binding">Boss 1</span>
                                     </span>
                                  </div>
                                  <div class="text-right">
                                     <span editable-text="reference.company_name" e-placeholder="Company name" e-name="company_name" e-form="rowform" class="editfield ng-scope editable">
                                     <span class="ng-binding">Company ABC</span>
                                     </span>
                                     <br>
                                  </div>
                                  <div class="text-right">
                                     <span editable-text="reference.contact_email" e-placeholder="Email address" e-name="contact_email" e-form="rowform" class="editfield ng-scope editable">
                                     <span class="ng-binding">CompanyABC@gmail.com</span>
                                     </span>
                                     <br>
                                  </div>
                                  <div class="text-right">
                                     <span editable-text="reference.contact_phone" e-placeholder="Phone number" e-name="contact_phone" e-form="rowform" class="editfield ng-scope editable">
                                     <span class="ng-binding">3543636</span>
                                     </span>
                                  </div>
                                  <div class="clearfix"></div>
                               </div>
                               <div id="ReferenceForm" class="animate-show reference1Edit" style="display: none;">
                                  <form ng-submit="AddReference()" id="addReferenceForm" class="ng-pristine ng-valid">
                                     <div class="row">
                                        <div class="col-md-12">
                                           <textarea name="description" placeholder="Description" required="required">Reference 1</textarea>
                                        </div>
                                        <div class="col-md-12">
                                           <input name="employer_name" placeholder="Employer name" required="required" value="Boss 1">
                                        </div>
                                        <div class="col-md-12 ">
                                           <input type="text" name="company_name" placeholder="Company name" required="required" value="Company 1 ABC">
                                        </div>
                                        <div class="col-md-12 ">
                                           <input type="text" name="contact_email" placeholder="Email address" value="company2ABC@gmail.com">
                                        </div>
                                        <div class="col-md-12 ">
                                           <input type="text" name="contact_phone" placeholder="Phone number" value="756868678">
                                        </div>
                                        <div class="col-md-8 col-md-offset-4 pull-right hideShow" toggleHide="reference1Edit" toggleShow="reference1" style="display: flex;">
                                           <input type="submit" name="action_doNothing" value="Submit" class="action submit_wh col-md-6" id="Form_action_doNothing">
                                           <input type="button" ng-click="CancelReferenceForm()" class="cancel_wh col-md-6" value="Cancel">
                                        </div>
                                     </div>
                                  </form>
                               </div>
                           </div>
                        </div><!-- eof row -->
                        <!-- reference 1 edit - end -->

                        <!-- reference 2 edit - start -->
                        <div class="row ng-scope">
                            <div class="col-md-12">
                               <div id="ref_424" class="reference_con reference2">
                                  <div class="buttons">
                                     <a ng-confirm-click="Are you sure you want to delete this?" data-id="424" class="pull-right">
                                     <span class="glyphicon glyphicon-trash"></span>
                                     </a>
                                     <a href="" type="button" class="editfield pull-right">
                                     <span class="glyphicon pencil-icon hideShow" toggleHide="reference2" toggleShow="reference2Edit"></span>
                                     </a>
                                  </div>
                                  <div class="ref_description_con">
                                     <span e-form="rowform" e-placeholder="Description" class="editfield white-space-pre-line ng-scope ng-binding editable" editable-textarea="reference.description" e-name="description">
                                     Reference 2
                                     </span>
                                  </div>
                                  <br>
                                  <div class="text-right">
                                     <span e-form="rowform" class="editfield pvm-blue ng-scope editable" e-placeholder="Employer name" editable-text="reference.employer_name" e-name="employer_name">
                                     <span class="ng-binding">Boss 2</span>
                                     </span>
                                  </div>
                                  <div class="text-right">
                                     <span editable-text="reference.company_name" e-placeholder="Company name" e-name="company_name" e-form="rowform" class="editfield ng-scope editable">
                                     <span class="ng-binding">Company 2 ABC</span>
                                     </span>
                                     <br>
                                  </div>
                                  <div class="text-right">
                                     <span editable-text="reference.contact_email" e-placeholder="Email address" e-name="contact_email" e-form="rowform" class="editfield ng-scope editable">
                                     <span class="ng-binding">company2ABC@gmail.com</span>
                                     </span>
                                     <br>
                                  </div>
                                  <div class="text-right">
                                     <span editable-text="reference.contact_phone" e-placeholder="Phone number" e-name="contact_phone" e-form="rowform" class="editfield ng-scope editable">
                                     <span class="ng-binding">756868678</span>
                                     </span>
                                  </div>
                                  <div class="clearfix"></div>
                               </div>     
                            </div>    
                            <div id="ReferenceForm" class="animate-show reference2Edit" style="display: none;">
                               <form ng-submit="AddReference()" id="addReferenceForm" class="ng-pristine ng-valid">
                                  <div class="row">
                                     <div class="col-md-12">
                                        <textarea name="description" placeholder="Description" required="required">Reference 2</textarea>
                                     </div>
                                     <div class="col-md-12">
                                        <input name="employer_name" placeholder="Employer name" required="required" value="Boss 2">
                                     </div>
                                     <div class="col-md-12 ">
                                        <input type="text" name="company_name" placeholder="Company name" required="required" value="Company 2 ABC">
                                     </div>
                                     <div class="col-md-12 ">
                                        <input type="text" name="contact_email" placeholder="Email address" value="company2ABC@gmail.com">
                                     </div>
                                     <div class="col-md-12 ">
                                        <input type="text" name="contact_phone" placeholder="Phone number" value="756868678">
                                     </div>
                                     <div class="col-md-8 col-md-offset-4 pull-right hideShow" toggleHide="reference2Edit" toggleShow="reference2" style="display: flex;">
                                        <input type="submit" name="action_doNothing" value="Submit" class="action submit_wh col-md-6" id="Form_action_doNothing">
                                        <input type="button" ng-click="CancelReferenceForm()" class="cancel_wh col-md-6" value="Cancel">
                                     </div>
                                  </div>
                               </form>
                            </div>   
                        </div>
                        <!-- reference 2 edit - end -->
                         
                        <!-- add reference edit - start -->
                        <div class="addReferences reference">
                           <a href="" ng-click="AddReferenceForm()" class="animate-show hideShow" toggleHide="reference" toggleShow="referenceEdit">+ Add Reference</a>
                        </div>
                        <div id="ReferenceForm" class="animate-show referenceEdit" style="display: none;">
                           <form ng-submit="AddReference()" id="addReferenceForm" class="ng-pristine ng-valid">
                              <div class="row">
                                 <div class="col-md-12">
                                    <textarea name="description" placeholder="Description" required="required"></textarea>
                                 </div>
                                 <div class="col-md-12">
                                    <input name="employer_name" placeholder="Employer name" required="required" value="">
                                 </div>
                                 <div class="col-md-12 ">
                                    <input type="text" name="company_name" placeholder="Company name" required="required" value="">
                                 </div>
                                 <div class="col-md-12 ">
                                    <input type="text" name="contact_email" placeholder="Email address" value="">
                                 </div>
                                 <div class="col-md-12 ">
                                    <input type="text" name="contact_phone" placeholder="Phone number" value="">
                                 </div>
                                 <div class="col-md-8 col-md-offset-4 pull-right hideShow" toggleHide="referenceEdit" toggleShow="reference" style="display: flex;">
                                    <input type="submit" name="action_doNothing" value="Submit" class="action submit_wh col-md-6" id="Form_action_doNothing">
                                    <input type="button" ng-click="CancelReferenceForm()" class="cancel_wh col-md-6" value="Cancel">
                                 </div>
                              </div>
                           </form>
                        </div>
                        <!-- add reference edit - end -->

                     </div>

                  </div>
               </div><!-- eof row -->
            </div><!-- eof ProfileBottom -->

        </div><!-- eof content-loader -->

        <div id="pmvCameraModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
           <div class="modal-content" ondrop="dropVideoModal(event)" ondragover="allowDrop(event)">
              <div class="modal-header">
                 <button type="button" class="close" data-dismiss="modal">×</button>
                 <h4 class="modal-title">Record Camera or Upload Video</h4>
              </div>
              <div class="modal-body pvm-video-container col-md-12 col-sm-12 col-xs-12">
                 <div class="col-md-8 col-sm-12 col-xs-12">
                    <video id="preview" data-old_file="" data-file_folder="" controls="" data-ob_key="i8ban0sl" muted="" width="100"></video>
                    <div id="modal_percent" class="c100 small p0">
                       <span class="ng-binding">0%</span>
                       <div class="slice">
                          <div class="bar"></div>
                          <div class="fill"></div>
                       </div>
                    </div>
                 </div>
                 <div class="col-md-4 col-sm-12 col-xs-12">
                    <div style="height:120px;" id="browse_video" ng-show="mobile_agent == false">
                       <div id="Form_video_upload_Holder" class="field file">
                          <label class="btn" for="Form_video_upload_modal" style="color:#337ab7; cursor:pointer">Upload Video
                          <br><br>
                          <i class="glyphicon glyphicon-folder-open" style="font-size: 40px;"></i>
                          <input data-ob_key="" data-old_file="" name="video_upload_modal" class="file ng-pristine ng-valid ng-empty ng-touched ng-untouched ng-hide" id="Form_video_upload_modal" type="file" ng-hide="true">
                          </label>
                       </div>
                    </div>
                    <div ng-show="mobile_agent == false" style="height:120px; text-align:center" id="record_camera">
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
        </div><!-- eof pmvCameraModal -->

        <div id="pmvCameraModalNew" class="modal fade" role="dialog" style="display: none;">
        <div class="modal-dialog">
           <div class="modal-content modal-video-modal">
              <div class="x-buttom-container">
                 <span class="close x-button" data-dismiss="modal"></span>
              </div>
              <div class="modal-body pvm-video-container col-md-12 col-sm-12 col-xs-12" style="background: #fff">
                 <div ng-show="upload_init == 0 || !upload_init">
                    <div id="section1-holder" class="sections-holder" ng-hide="showSection1">
                       <div class="col-md-6 modal-image modal-image-left-con" ondrop="dropVideoModalNew(event)" ondragover="allowDrop(event)" ondragleave="leaveIt(event)">
                          <img src="images/drag_drop_img.png" ng-hide="ondragoverout_image" width="113px">
                          <img src="images/drag_drop_img_gray.png" class="ng-hide" width="113px">
                          <div class="text-label">
                             <h4 class="pvm-blue">Drag &amp; drop or upload your video</h4>
                             <div id="modal_percent_new" class="c100 small ng-hide p0">
                                <span class="ng-binding">0%</span>
                                <div class="slice">
                                   <div class="bar"></div>
                                   <div class="fill"></div>
                                </div>
                             </div>
                          </div>
                          <div>
                             <label class="modal-buttons" for="video_upload_modal_new">
                             BROWSE
                             <input name="video_upload_modal_new" id="video_upload_modal_new" data-old_file="" type="file" accept="video/mp4,video/x-m4v,video/*" style="margin-left:-9999px" class="ng-pristine ng-untouched ng-valid ng-not-empty">
                             </label>
                          </div>
                       </div>
                       <div class="col-md-6 modal-image">
                          <img src="images/record_video_img.png" width="113px">
                          <div class="text-label">
                             <h4 class="pvm-blue">Record a video</h4>
                          </div>
                          <div class="modal-button-right-con">
                             <p class="text-danger">Recording unavailable. see error below</p>
                          </div>
                       </div>
                       <div class="clearfix"></div>
                       <div class="little-note-yellow">
                          <i class="fa fa-info-circle" aria-hidden="true"></i>
                          File extension must be one of these - flv, mxf, gxf, ts, ps, 3gp, 3gpp, mpg, wmv, asf, avi, mp4, m4a, m4v, isma, ismv, dvr-ms, mkv, wav, mov
                       </div>
                    </div>
                    <div id="section2-holder" class="sections-holder ng-hide">
                       <div class="col-md-12 video-holder">
                          <video id="preview_new" class="video-elm" data-old_file="" data-file_folder="" controls="" data-ob_key="" muted="" src=""></video>
                          <div id="modal_percent_new" class="c100 small ng-hide p0">
                             <span class="ng-binding">0%</span>
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
                          <div class="preparing">
                             Preparing upload. Please wait...<br>
                             <strong>Please do not refresh or close this page</strong>
                          </div>
                          <div class="finalize">
                             Finalizing upload. Please wait...<br>
                             <strong>Please do not refresh or close this page </strong>
                          </div>
                          <div class="progressContainer">
                             <div class="text">Uploading. Please do not refresh or close this page </div>
                             <div class="progressBarOutside">
                                <div class="progressbar"> <span></span></div>
                             </div>
                          </div>
                          <div class="errorUpload alert alert-danger" style="display: block;">
                             <div class="text">
                                Failed with error: 
                                <span>
                                   <p class="text-danger">Camera not set</p>
                                </span>
                             </div>
                          </div>
                          <div class="successUpload alert alert-success" style="display: none;">
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
        </div><!-- eof pmvCameraModalNew -->

        <!-- Video Modal -->
        <div id="pmvCameraModalNew" class="modal fade" role="dialog">
        <div class="modal-dialog">
           <div class="modal-content modal-video-modal">
              <div class="x-buttom-container">
                 <span class="close x-button" data-dismiss="modal"></span>
              </div>
              <div class="modal-body pvm-video-container col-md-12 col-sm-12 col-xs-12">
                 <div id="section1-holder" class="sections-holder" ng-hide="showSection1">
                    <div class="col-md-6 modal-image modal-image-left-con" ondrop="dropVideoModalNew(event)" ondragover="allowDrop(event)" ondragleave="leaveIt(event)">
                       <img src="images/drag_drop_img.png" ng-hide="ondragoverout_image" width="113px">
                       <img src="images/drag_drop_img_gray.png" ng-hide="ondragover_image" class="ng-hide" width="113px">
                       <div class="text-label">
                          <h4 class="pvm-blue">Drag &amp; drop or upload your video2222</h4>
                          <div id="modal_percent_new" class="c100 small ng-hide p0" ng-hide="modal_percent">
                             <span class="ng-binding">0%</span>
                             <div class="slice">
                                <div class="bar"></div>
                                <div class="fill"></div>
                             </div>
                          </div>
                       </div>
                       <div>
                          <label class="modal-buttons" for="video_upload_modal_new">
                          BROWSE
                          <input name="video_upload_modal_new" id="video_upload_modal_new" ng-model="video_upload" data-old_file="" type="file" accept="video/*" style="margin-left:-9999px" class="ng-pristine ng-untouched ng-valid ng-not-empty">
                          </label>
                          <div class="little-note-yellow">
                             <i class="fa fa-info-circle" aria-hidden="true"></i>
                             File extension must be one of these - flv, mxf, gxf, ts, ps, 3gp, 3gpp, mpg, wmv, asf, avi, mp4, m4a, m4v, isma, ismv, dvr-ms, mkv, wav, mov
                          </div>
                       </div>
                    </div>
                    <div class="col-md-6 modal-image">
                       <img src="images/record_video_img.png" width="113px">
                       <div class="text-label">
                          <h4 class="pvm-blue">Record a video</h4>
                       </div>
                       <div class="modal-button-right-con">
                          <p class="text-danger">Recording unavailable. see error below</p>
                       </div>
                    </div>
                 </div>
                 <div id="section2-holder" class="sections-holder ng-hide" ng-hide="showSection2">
                    <div class="col-md-12 video-holder">
                       <video id="preview_new" class="video-elm" data-old_file="" data-file_folder="" controls="" data-ob_key="" muted=""></video>
                       <div id="modal_percent_new" class="c100 small ng-hide p0" ng-hide="modal_percent">
                          <span class="ng-binding">0%</span>
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
        </div><!-- eof pmvCameraModalNew -->

        <div id="pmvImageModalNew" class="modal fade" role="dialog">
        <div class="modal-dialog">
           <div class="modal-content modal-video-modal">
              <div class="x-buttom-container">
                 <span class="close x-button" data-dismiss="modal"></span>
              </div>
              <div class="modal-body pvm-video-container col-md-12 col-sm-12 col-xs-12">
                 <div id="section1-holder" class="sections-holder" ng-hide="showSection1">
                    <div class="col-md-6 modal-image modal-image-left-con" ondrop="dropImageModalNew(event)" ondragover="allowDrop(event)" ondragleave="leaveIt(event)">
                       <img src="themes/bbt/images/drag_drop_img.png" ng-hide="ondragoverout_image" width="113px">
                       <img src="themes/bbt/images/drag_drop_img_gray.png" ng-hide="ondragover_image" class="ng-hide" width="113px">
                       <div class="text-label">
                          <h4 class="pvm-blue">Drag &amp; drop or upload your image111</h4>
                          <div id="modal_percent_new" class="c100 small ng-hide p0" ng-hide="modal_percent">
                             <span class="ng-binding">0%</span>
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
                       <img src="themes/bbt/images/record_video_img.png" width="113px">
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
                       <video id="preview_img_new" class="video-elm" poster="" style="background-color:#fff" ng-hide="isSafari" data-old_file="" data-file_folder="" data-ob_key="" muted="" src=""></video>
                       <img id="preview_img_new_safari" style="background-color:#fff" ng-show="isSafari" class="ng-hide">
                       <canvas id="my_canvas" style="display:none;"></canvas>
                       <div id="modal_percent_new" class="c100 small ng-hide p0" ng-hide="modal_percent">
                          <span class="ng-binding">0%</span>
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
        </div><!-- eof pmvImageModalNew -->

        <div id="pmvImageModalEmployerRegister" class="modal fade" role="dialog">
        <div class="modal-dialog">
           <div class="modal-content modal-video-modal">
              <div class="x-buttom-container">
                 <span class="close x-button" data-dismiss="modal"></span>
              </div>
              <div class="modal-body pvm-video-container col-md-12 col-sm-12 col-xs-12">
                 <div id="section1-holder" class="sections-holder" ng-hide="showSection1RE">
                    <div class="col-md-6 modal-image modal-image-left-con" ondrop="dropImageModalNew(event)" ondragover="allowDrop(event)" ondragleave="leaveIt(event)">
                       <img src="themes/bbt/images/drag_drop_img.png" ng-hide="ondragoverout_imageRE" width="113px">
                       <img src="themes/bbt/images/drag_drop_img_gray.png" ng-hide="ondragover_imageRE" class="ng-hide" width="113px">
                       <div class="text-label">
                          <h4 class="pvm-blue">Drag &amp; drop or upload your image2222</h4>
                          <div id="modal_percent_new" class="c100 small ng-hide p0" ng-hide="modal_percentRE">
                             <span class="ng-binding">0%</span>
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
                       <img src="themes/bbt/images/record_video_img.png" width="113px">
                       <div class="text-label">
                          <h4 class="pvm-blue">Take a picture</h4>
                       </div>
                       <div class="modal-button-right-con">
                          <label class="modal-buttons" ng-click="startVideoImage()">START</label>
                       </div>
                    </div>
                 </div>
                 <div id="section2-holder" class="sections-holder ng-hide" ng-hide="showSection2RE">
                    <div class="col-md-12 video-holder" id="preview_img_new_holderRE">
                       <video ng-hide="isSafari" id="preview_img_newRE" class="video-elm" poster="" data-old_file="" data-file_folder="" data-ob_key="" muted="" height="240"></video>
                       <img id="preview_img_newRE_safari" style="background-color:#fff; height:240px" ng-show="isSafari" class="ng-hide">
                       <canvas id="my_canvasRE" style="display:none;"></canvas>
                       <div id="modal_percent_new" class="c100 small ng-hide p0" ng-hide="modal_percentRE">
                          <span class="ng-binding">0%</span>
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
        </div><!-- eof pmvImageModalEmployerRegister -->

        <!-- Resume / Docs Modal -->
        <div id="pmvFileModalNew" class="modal fade" role="dialog" data-docfiletype="resume" style="display: none;">
        <div class="modal-dialog">
           <div class="modal-content modal-video-modal">
              <div class="x-buttom-container">
                 <span class="close x-button" data-dismiss="modal"></span>
              </div>
              <div class="modal-body pvm-video-container col-md-12 col-sm-12 col-xs-12">
              <div id="section1-holder" class="sections-holder" ng-hide="showSection1">
                 <div class="col-md-12 modal-image">
                    <img src="images/drag_drop_img.png" width="113px">
                    <img src="images/drag_drop_img_gray.png" class="ng-hide" width="113px">
                    <div class="text-label">
                       <h4 class="pvm-blue">Drag &amp; drop or upload your file</h4>
                       <div id="modal_percent_new" class="c100 small ng-hide p0">
                          <span class="ng-binding">0%</span>
                          <div class="slice">
                             <div class="bar"></div>
                             <div class="fill"></div>
                          </div>
                       </div>
                    </div>
                    <div>
                       <label class="modal-buttons" for="file_upload">
                       BROWSE
                       <input name="file_upload" id="file_upload" data-old_file="" type="file" class="ng-pristine ng-untouched ng-valid ng-empty ng-hide">
                       </label>
                    </div>
                 </div>
              </div>
              <div id="section2-holder" class="sections-holder ng-hide">
                 <div class="col-md-12 video-holder">
                    <div id="uploadResponseText" class="ng-binding"></div>
                 </div>
                 <div class="col-md-12 buttons-holder">
                    <span class="video-buttons" id="change_btn"></span>
                    <span class="video-buttons" id="save_btn"></span>
                 </div>
              </div>
           </div>
        </div>
        </div>
        </div><!-- eof pmvFileModalNew -->

        <div id="pmvErrorMsg" class="modal fade" role="dialog">
        <div class="modal-dialog">
        <div class="modal-content">
           <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">×</button>
              <h4 class="modal-title text-danger">Error</h4>
           </div>
           <div class="modal-body pvm-video-container-error"></div>
           <div class="modal-footer">
              <button type="button" class="btn btn-default-bbt" data-dismiss="modal">Close</button>
           </div>
        </div>
        </div>
        </div><!-- eof pmvErrorMsg -->

        <div id="pmvImageModalMsg" class="modal fade" role="dialog">
        <div class="modal-dialog">
        <div class="modal-content">
           <div class="modal-body" style="padding:20px">Profile image saved. Please wait a few moment to update.</div>
           <div class="modal-footer" style="padding-top:10px;padding-bottom:10px">
              <button type="button" class="btn btn-default-bbt pvm-blue" data-dismiss="modal" style="border:none;">Close</button>
           </div>
        </div>
        </div>
        </div><!-- eof pmvImageModalMsg -->

        <div id="pmvResumeModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
        <div class="modal-content" ondrop="dropResumeModal(event)" ondragover="allowDrop(event)">
           <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">×</button>
              <h4 class="modal-title">Upload Resume</h4>
           </div>
           <div class="modal-body pvm-video-container col-md-12 col-sm-12 col-xs-12">
              <div class="col-md-8 col-sm-12 col-xs-12">
                 <div id="file_drag_drop">
                    <span>You can also drag and drop resume here.</span>
                    <div id="modal_percent_file" class="hidden c100 p small">
                       <span class="ng-binding">%</span>
                       <div class="slice">
                          <div class="bar"></div>
                          <div class="fill"></div>
                       </div>
                    </div>
                 </div>
              </div>
              <div class="col-md-4 col-sm-12 col-xs-12">
                 <div style="height:120px; margin-top:35px" id="browse_resume">
                    <div id="Form_video_upload_Holder" class="field file">
                       <label class="btn" for="Form_resume_upload_modal" style="color:#337ab7; cursor:pointer">Upload Resume
                       <br><br>
                       <i class="glyphicon glyphicon-folder-open" style="font-size: 40px;"></i>
                       <input data-ob_key="" data-old_file="" data-folder="resume" name="Form_resume_upload_modal" class="file ng-pristine ng-valid ng-empty ng-touched ng-untouched ng-hide" id="Form_resume_upload_modal" type="file" ng-hide="true">
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
        </div><!-- eof pmvResumeModal -->

        <div id="pmvPortfolioModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
        <div class="modal-content" ondrop="dropResumeModal(event)" ondragover="allowDrop(event)">
           <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">×</button>
              <h4 class="modal-title">Upload Portfolio</h4>
           </div>
           <div class="modal-body pvm-video-container col-md-12 col-sm-12 col-xs-12">
              <div class="col-md-8 col-sm-12 col-xs-12">
                 <div id="file_drag_drop">
                    <span>You can also drag and drop file here.</span>
                    <div id="modal_percent_file" class="hidden c100 p small">
                       <span class="ng-binding">%</span>
                       <div class="slice">
                          <div class="bar"></div>
                          <div class="fill"></div>
                       </div>
                    </div>
                 </div>
              </div>
              <div class="col-md-4 col-sm-12 col-xs-12">
                 <div style="height:120px; margin-top:35px" id="browse_resume">
                    <div id="Form_video_upload_Holder" class="field file">
                       <label class="btn" for="Form_portfolio_upload_modal" style="color:#337ab7; cursor:pointer">Upload Porfolio
                       <br><br>
                       <i class="glyphicon glyphicon-folder-open" style="font-size: 40px;"></i>
                       <input data-ob_key="" data-old_file="" data-folder="portfolio" name="Form_portfolio_upload_modal" class="file ng-pristine ng-valid ng-empty ng-touched ng-untouched ng-hide" id="Form_portfolio_upload_modal" type="file" ng-hide="true">
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
        </div><!-- eof pmvPortfolioModal -->

        <div id="pmvImageModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
        <div class="modal-content" ondrop="dropImageModal(event)" ondragover="allowDrop(event)">
           <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">×</button>
              <h4 class="modal-title">Upload Picture</h4>
           </div>
           <div class="modal-body pvm-video-container col-md-12 col-sm-12 col-xs-12">
              <div class="col-md-8 col-sm-12 col-xs-12">
                 <div id="file_drag_drop">
                    <span>You can also drag and drop your picture here.</span>
                    <div id="modal_percent_image" class="hidden c100 p small">
                       <span class="ng-binding">%</span>
                       <div class="slice">
                          <div class="bar"></div>
                          <div class="fill"></div>
                       </div>
                    </div>
                 </div>
              </div>
              <div class="col-md-4 col-sm-12 col-xs-12">
                 <div style="height:120px; margin-top:35px" id="browse_resume">
                    <div id="Form_video_upload_Holder" class="field file">
                       <label class="btn" for="Form_image_upload_modal" style="color:#337ab7; cursor:pointer">Upload Image
                       <br><br>
                       <i class="glyphicon glyphicon-folder-open" style="font-size: 40px;"></i>
                       <input data-ob_key="" data-old_file="" name="Form_image_upload_modal" class="file ng-pristine ng-valid ng-empty ng-touched ng-untouched ng-hide" id="Form_image_upload_modal" type="file" ng-hide="true">
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
        </div><!-- eof pmvImageModal -->

        <div id="companyBannerModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
        <div class="modal-content modal-video-modal">
           <div class="x-buttom-container">
              <span class="close x-button" data-dismiss="modal"></span>
           </div>
           <div class="modal-body pvm-video-container col-md-12 col-sm-12 col-xs-12">
              <div id="banner-section1-holder" class="banner-sections-holder" ng-hide="showSection1">
                 <div class="col-md-12 modal-image" ondrop="dropImageModalNew(event)" ondragover="allowDrop(event)" ondragleave="leaveIt(event)">
                    <img src="themes/bbt/images/drag_drop_img.png" ng-hide="ondragoverout_image" width="113px">
                    <img src="themes/bbt/images/drag_drop_img_gray.png" ng-hide="ondragover_image" class="ng-hide" width="113px">
                    <div class="text-label">
                       <h4 class="pvm-blue">Drag &amp; drop or upload your image333</h4>
                       <div id="modal_percent_new" class="c100 small ng-hide p0" ng-hide="modal_percent">
                          <span class="ng-binding">0%</span>
                          <div class="slice">
                             <div class="bar"></div>
                             <div class="fill"></div>
                          </div>
                       </div>
                    </div>
                    <div>
                       <label class="modal-buttons" for="banner_image_upload">
                       BROWSE
                       <input name="banner_image_upload" id="banner_image_upload" data-old_file="" type="file" accept="image/*" style="margin-left:-9999px">
                       </label>
                       <small style="position: absolute;width:100%;left:0;top:270px;">Recommended dimensions: 2000x221px</small>
                    </div>
                 </div>
              </div>
              <div id="banner-section2-holder" class="banner-sections-holder ng-hide" ng-hide="showSection2">
                 <div class="col-md-12 video-holder" id="banner_preview_img_new_holder">
                    <div style="height:240px;position:relative">
                       <img id="banner_img" ng-hide="video_preview">
                    </div>
                    <div id="banner_modal_percent_new" class="c100 small ng-hide p0" ng-hide="modal_percent">
                       <span class="ng-binding">0%</span>
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
        </div><!-- eof companyBannerModal -->
    </div>
</div><!-- eof row -->
@stop

@section('scripts')
<script type="text/javascript">
   $( ".hideShow" ).click(function() {
       var hideId = $(this).attr('toggleHide');
       var showId = $(this).attr('toggleShow');
       $( "."+hideId+"" ).hide();
       $( "."+showId+"" ).show();
       return false;   
   });
</script>
@stop
