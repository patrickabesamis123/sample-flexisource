@extends('layouts.candidate-profile')

@section('styles')
<link rel="stylesheet" href="css/helpers2.css" />
<link rel="stylesheet" href="css/responsive-media.css" />
@stop

@section('content')

<div class="row">
    <div id="candidate_profile_content" class="ng-scope" ng-cloak>
<!-- 
<div class="text-center splash  ng-hide" ng-show="preload">
    <div class="cssload-container">
     <h3>Please wait.</h3>
     <h4>While we prepare this page for you.</h4>
     <div class="cssload-loading"><i></i><i></i><i></i><i></i></div>
    </div>
</div> -->
<!-- 
<div class="container-fluid ng-hide" ng-show="candidateFlashMessage">
    <div class="row">
    ngIf: candidateFlashMessage
    </div>
</div> -->
        <div id="ProfileTop" class="container-fluid" ng-hide="preload">
            <div class="row">
                <div class="container padb-30">
                   <div class="col-md-2" id="phone_image">
                        <!-- ngIf: !profile_image -->
                        <!-- ngIf: profile_image -->
                        <img ng-src="https://pvmlive.blob.core.windows.net/i8ban0sl/479a7d89f95c22de382d427104a89dd7.jpeg" class="img-circle ng-scope" src="https://pvmlive.blob.core.windows.net/i8ban0sl/479a7d89f95c22de382d427104a89dd7.jpeg" width="137">
                        <!-- end ngIf: profile_image -->
                        <p class="padtb-10"><a href="/my-profile-edit" class="pvm-green">Edit My Profile</a></p>
                   </div>
                   <div class="col-md-7 no-pad-r">
                      <div class="fullname">
                         <h3 class="editable font-mont-bold ng-binding">
                            Robin Knight <!-- ngIf: nickname -->
                         </h3>
                      </div>
                      <span class="position editable ng-binding">
                         Franklin, Auckland
                         <!-- ngIf: preferred_location.data.display_name > 0 -->
                         New Zealand
                         <i class="willing-to-relocate-icon glyphicon gray-tooltip ng-scope ng-hide" style="width:20px;height:20px;vertical-align:middle;margin-left:5px;top:-2px" data-toggle="tooltip" data-placement="top" tooltip="" data-original-title="I am willing to relocate to another city"></i>
                      </span>
                      <br><br>
                       <div class="row details">
                         <div class="col-md-5">
                            <!-- ngIf: mobile_number --><span class="col-md-3 details_title ng-scope">Mobile:</span><!-- end ngIf: mobile_number -->
                            <!-- ngIf: mobile_number --><span class="col-md-9 word-break no-padding ng-binding ng-scope">090000000021</span><!-- end ngIf: mobile_number -->
                            <div class="clearfix"></div>
                            <!-- ngIf: phone_number --><span class="col-md-3 details_title ng-scope">Phone:</span><!-- end ngIf: phone_number -->
                            <!-- ngIf: phone_number --><span class="col-md-9 word-break no-padding ng-binding ng-scope">460000021</span><!-- end ngIf: phone_number -->
                            <div class="clearfix"></div>
                            <!-- ngIf: email --><span class="col-md-3 details_title ng-scope">Email:</span><!-- end ngIf: email -->
                            <!-- ngIf: email --><span class="col-md-9 word-break no-padding ng-binding ng-scope">rknight@previewmedev.co</span><!-- end ngIf: email -->
                         </div>
                         <div class="col-md-7">
                            <!-- ngIf: industry.industry_display_name --><span class="col-md-3 details_title details_title_r ng-scope">Classification:</span><!-- end ngIf: industry.industry_display_name -->
                            <!-- ngIf: industry.industry_display_name --><span class="col-md-9 ng-binding ng-scope">Sales</span><!-- end ngIf: industry.industry_display_name -->
                            <div class="clearfix"></div>
                            <!-- ngIf: industry.sub_industry.display_name --><span class="col-md-3 details_title details_title_r ellipsis gray-tooltip ng-scope" data-toggle="tooltip" data-placement="top" tooltip="" data-original-title="Sub-Classification">Sub-Classification:</span><!-- end ngIf: industry.sub_industry.display_name -->
                            <!-- ngIf: industry.sub_industry.display_name --><span class="col-md-9  ng-binding ng-scope">Sales Representatives/Consultants</span><!-- end ngIf: industry.sub_industry.display_name -->
                            <div class="clearfix"></div>
                            <!-- ngIf: min_salary !== null && max_salary !== null && min_salary !== 0 && max_salary !== 0 || min_salary !== null && max_salary == null || min_salary == null && max_salary !== null || min_salary == 0 && max_salary !== 0 || min_salary != 0 && max_salary == 0 -->
                            <span class="col-md-9 word-break">
                               <!-- ngIf: min_salary !== null && max_salary !== null && min_salary !== 0 && max_salary !== 0 || min_salary !== null && max_salary == null || min_salary == null && max_salary !== null || min_salary == 0 && max_salary !== 0 || min_salary != 0 && max_salary == 0 -->
                            </span>
                         </div>
                         <div class="clearfix"></div>
                       </div><!-- eof row -->
                       <div class="row details">
                           <div class="col-md-12 padb-20">
                               <span class="pvm-gray" style="padding-right:5px">Private URL:</span> <a href="/me/robin.knight1455" class="pvm-green ng-binding">https://previewme.co/me/robin.knight1455</a>
                           </div>
                           <div class="clearfix"></div>
                       </div><!-- eof row -->
                       <div class="clearfix"></div>
                   </div>
                   <div class="col-md-3">
                       <div class="row">
                           <div class="col-md-12">
                                <!--<div><img id="video_placeholder" src="images/placeholder_vid.png" width="275" data-toggle="modal" ng-click="open_camera()"></div> -->
                                <!--<video id="vid1" class="azuremediaplayer amp-default-skin">
                                <p class="amp-no-js">To view this video please enable JavaScript, and consider upgrading to a web browser that supports HTML5 video</p>
                                </video> -->
                                <video id="myvideo" width="275" controls autoplay>
                                <source src="/videos/1014676814-preview.mp4" type="video/mp4">
                                <!-- <source src="/videos/1014676814-preview.mp4" type="video/ogg"> -->
                                Your browser does not support the video tag.
                                </video>         
                           </div>
                       </div>
                       <div class="row">
                            <div class="col-md-12 hidden-md hidden-lg">
                                <div class="sidecolumn-holder">
                                     <div class="row no-marginlr">
                                        <div class="col-md-12 contact_watchlist_btn padt-10">
                                           <div class="col-md-12 marginb-10">
                                               <a href="/my-profile#" class="btn btn-contact" disabled="">CONTACT ME</a>
                                           </div>
                                           <div class="col-md-12 marginb-10">
                                              <a href="/my-profile#" class="btn btn-watchlist" disabled="">
                                                  <i class="glyphicon glyphicon-eye-open"></i> WATCHLIST
                                              </a>
                                           </div>
                                        </div>     
                                     </div><!-- eof row -->
                                     <div class="row no-marginlr">
                                        <div class="col-md-12 view_my_con text-center">
                                            <div class="col-md-12 view_my pvm-blue">
                                                <h3>VIEW MY...</h3>
                                            </div>
                                            <div class="col-md-12 view_my">
                                                <a href="/assets/Uploads/resume-sample.pdf" class="btn pvm-full-black ng-scope" style="padding:0px;" target="_blank">Resume</a>
                                            </div>
                                            <div class="col-md-12 view_my_portfolio">
                                                <a href="/my-profile#" class="btn  pvm-full-black ng-scope" style="padding:0px;" disabled="">SUPPORTING DOCS</a>
                                            </div>
                                        </div>
                                     </div><!-- eof row -->
                                </div><!-- eof sidecolumn-holder-top -->
                            </div>
                       </div><!-- eof row -->
                       
                      <!--
                      <div ng-show="preview_img == 'loading'">
                         <img src="images/video_preload.gif" style="width:276px;padding-bottom:10px">
                      </div>
                      <div class="row contact_watchlist_btn hidden-md hidden-lg">
                         <div class="col-sm-6 ">
                            <a href="#" class="btn btn-contact" disabled>CONTACT ME</a>
                         </div>
                         <div class="col-sm-6 ">
                            <a href="#" class="btn btn-watchlist" disabled>
                                <i class="glyphicon glyphicon-eye-open"></i> WATCHLIST
                            </a>
                         </div>
                      </div>
                      <div class="row">
                         <div class="col-md-12 view_my_con text-center hidden-md hidden-lg">
                            <div class="col-md-12 view_my pvm-blue">
                               <h3>VIEW MY...</h3>
                            </div>
                            <div class="col-md-12 view_my">
                               <a href="@{{resume.doc_url}}" ng-if="resume.doc_url" class=" pvm-full-black">RESUME</a>
                               <a href="#" class="btn  pvm-full-black" style="padding:0px;" disabled ng-if="!resume.doc_url">Resume</a>
                            </div>
                            <div class="col-md-3 col-md-offset-0 col-sm-8 col-sm-offset-4">
                               <div ng-show="preview_img == true">
                                  <img id="video_placeholder" src="/images/placeholder_vid.png" width="275" data-toggle="modal" ng-click="open_camera()">
                               </div>
                               <div ng-show="preview_img == false">
                                  <video id="vid1" class="azuremediaplayer amp-default-skin">
                                     <p class="amp-no-js">
                                        To view this video please enable JavaScript, and consider upgrading to a web browser that supports HTML5 video
                                     </p>
                                  </video>
                               </div>
                               <div ng-show="preview_img == 'loading'" class="text-center">
                                  <img src="/images/ajax-loader-video.gif" style="width:106px;padding-bottom:10px">
                                  <div style="margin-bottom: 25px">We will notify you once you video has uploaded. You can still use the full site while the video is processing.</div>
                               </div>
                               <div ng-show="preview_img == 'error' "  class="text-center">
                                  @{{errorVideo}}
                               </div>
                               <div class="row contact_watchlist_btn hidden-md hidden-lg">
                                  <div class="col-sm-6 ">
                                     <a href="#" class="btn btn-contact" disabled>CONTACT ME</a>
                                  </div>
                                  <div class="col-sm-6 ">
                                     <a href="#" class="btn btn-watchlist" disabled><i class="glyphicon glyphicon-eye-open">
                                     </i> WATCHLIST
                                     </a>
                                  </div>
                               </div>
                               <div class="row">
                                  <div class="col-md-12 view_my_con text-center hidden-md hidden-lg">
                                     <div class="col-md-12 view_my pvm-blue">
                                        <h3>VIEW MY...</h3>
                                     </div>
                                     <div class="col-md-12 view_my">
                                        <a href="@{{resume.doc_url}}" ng-if="resume.doc_url" class=" pvm-full-black">RESUME</a>
                                        <a href="#" class="btn  pvm-full-black" style="padding:0px;" disabled ng-if="!resume.doc_url">Resume</a>
                                     </div>
                                     <div class="col-md-12 view_my_portfolio">
                                        <a href="@{{portfolio.doc_url}}" ng-if="portfolio.doc_url" class="pvm-full-black">SUPPORTING DOCS</a>
                                        <a href="#" class="btn  pvm-full-black" style="padding:0px;" disabled ng-if="!portfolio.doc_url">SUPPORTING DOCS</a>
                                     </div>
                                  </div>
                               </div>
                               <div class="clearfix"></div>
                               <div class="col-md-12 view_my_portfolio">
                                  <a href="@{{portfolio.doc_url}}" ng-if="portfolio.doc_url" class="pvm-full-black">SUPPORTING DOCS</a>
                                  <a href="#" class="btn  pvm-full-black" style="padding:0px;" disabled ng-if="!portfolio.doc_url">SUPPORTING DOCS</a>
                               </div>
                            </div>
                         </div>
                         <div class="clearfix"></div>
                      </div> -->
                       
                   </div>
                </div>
            </div><!-- eof row -->
        </div>
        <div id="ProfileBottom" class="container-fluid">
                <div class="row">
                  <div class="container">
                     <div class="col-md-9 adjust-padding-right">
                        <div class="row aboutme">
                           <div class="col-md-12">
                              <h3>ABOUT ME</h3>
                              <br>
                              <div class="content description_content ng-binding">
                                  Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.<br><br>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?<br><br>At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat.
                               </div>
                           </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 line-divider"></div>
                        </div><!-- eof row -->
                        <div class="row workhistory">
                           <div class="col-md-4 padb-20">
                                <h3>Work Experience</h3>
                           </div>
                           <div class="col-md-8">
                                 <!-- ngRepeat: history in work_history | orderBy : sortDate : true --><!-- ngIf: work_history.length -->
                                 <div class="workhistory_repeat ng-scope">
                                    <div class="workhistory_item">
                                       <div class="title company_name">
                                          <div class="ng-binding">
                                             Sales Company Inc.
                                          </div>
                                       </div>
                                       <div class="job title job_title">
                                          <span class="title ng-binding">
                                          Sales Rep | Contract
                                          </span>
                                       </div>
                                       <div class="date_range">
                                          <span class="ng-binding">
                                          May 2005 - June 2016 (11 year/s)
                                          </span>
                                       </div>
                                       <div>
                                          <!-- ngIf: history.salary > 0 -->
                                       </div>
                                       <br>
                                       <!-- ngIf: history.key_accountabilities.length > 0 -->
                                       <div class="qualifitions_holder ng-scope">
                                          <div>Key Responsibilities</div>
                                          <span class="editfield ng-binding">
                                          Accountability 1, Accountability 2
                                          </span>
                                       </div>
                                       <!-- end ngIf: history.key_accountabilities.length > 0 -->
                                       <!-- ngIf: history.key_accountabilities.length > 0 --><br class="ng-scope"><!-- end ngIf: history.key_accountabilities.length > 0 -->
                                       <!-- ngIf: history.description -->
                                       <div class="ng-scope text-justify">
                                          <div>Job in a Nutshell</div>
                                          <span class="editfield ng-binding">
                                          Sales representatives sell retail products, goods and services to customers. Sales representatives work with customers to find what they want, create solutions and ensure a smooth sales process. Sales representatives will work to find new sales leads, through business directories, client referrals, etc. Sometimes, sales representatives will focus on inside sales, which typically involves "cold calling" for new clients while in an office setting, or outside sales, which involves visiting clients in the field with new or existing clients. Often, there sales representatives will have a combination inside/outside sales job.
                                          </span>
                                       </div>
                                       <!-- end ngIf: history.description -->
                                       <!-- ngIf: history.description --><br class="ng-scope"><!-- end ngIf: history.description -->
                                       <!-- ngIf: history.industries_display.length != 0 -->
                                       <div class="cut-line ng-scope"></div>
                                       <!-- end ngIf: history.industries_display.length != 0 -->
                                       <div>
                                          <!-- ngRepeat: (k,v) in history.industries_display -->
                                          <div class="ng-scope">
                                             <div class="ng-binding">Sales</div>
                                             <div class="editfield ng-binding" style="padding-bottom:8px">Sales Representatives/Consultants</div>
                                          </div>
                                          <!-- end ngRepeat: (k,v) in history.industries_display -->
                                       </div>
                                    </div>
                                 </div>
                                 <!-- end ngIf: work_history.length --><!-- end ngRepeat: history in work_history | orderBy : sortDate : true --><!-- ngIf: work_history.length -->
                                 <div class="workhistory_repeat ng-scope" >
                                    <div class="workhistory_item">
                                        <div class="title company_name">
                                          <div class="ng-binding">
                                             ACME CO.
                                          </div>
                                       </div>
                                       <div class="job title job_title">
                                          <span class="title ng-binding">
                                          Sales | Contract
                                          </span>
                                       </div>
                                       <div class="date_range">
                                          <span class="ng-binding">
                                          June 2016 - Present (2 year/s)
                                          </span>
                                       </div>
                                       <div>
                                          <!-- ngIf: history.salary > 0 -->
                                       </div>
                                       <br>
                                       <!-- ngIf: history.key_accountabilities.length > 0 -->
                                       <div class="qualifitions_holder ng-scope">
                                          <div>Key Responsibilities</div>
                                          <span class="editfield ng-binding">
                                            Analyze sales ,  Monitor customer
                                          </span>
                                       </div>
                                       <br class="ng-scope">
                                       <div class="ng-scope text-justify">
                                          <div>Job in a Nutshell</div>
                                          <span class="editfield ng-binding">
                                          Collect and interpret complex data to target the most promising areas and determine the most effective sales strategies. They need to work with people in other departments and with customers, so they must be able to communicate clearly. When helping to make a sale, sales managers must listen and respond to the customer's needs. Sales managers must be able to evaluate how sales staff perform and develop ways for struggling members to improve.
                                          </span>
                                       </div>
                                       <!-- end ngIf: history.key_accountabilities.length > 0 -->
                                       <!-- ngIf: history.key_accountabilities.length > 0 --><br class="ng-scope"><!-- end ngIf: history.key_accountabilities.length > 0 -->
                                       <!-- ngIf: history.description -->
                                       <!-- ngIf: history.description -->
                                       <!-- ngIf: history.industries_display.length != 0 -->
                                       <div>
                                          <!-- ngRepeat: (k,v) in history.industries_display -->
                                       </div>
                                    </div>
                                 </div>
                                 <!-- end ngIf: work_history.length --><!-- end ngRepeat: history in work_history | orderBy : sortDate : true -->
                                 <!-- ngIf: !work_history.length && new_to_workforce == false || !work_history.length && new_to_workforce == null -->
                                 <!-- ngIf: !work_history.length && new_to_workforce == true -->
                           </div>
                           <div class="clearfix"></div>
                        </div><!-- eof row -->
                        <div class="row">
                            <div class="col-md-12 line-divider"></div>
                        </div>
                        <div class="row workhistory">
                           <div class="col-md-4 padb-20">
                              <h3>Education</h3>
                           </div>
                           <div class="col-md-8">
                                <!-- ngRepeat: qualification in qualifications | orderBy : sortDate : true --><!-- ngIf: qualifications.length -->
                                <div class="work-exp-holder ng-scope">
                                <div>
                                   <div id="edu-listing" class="col-md-4 pull-right">
                                      <img class="ng-scope" src="\images\schools\school_1.png">
                                   </div>
                                   <div class="col-md-8 no-pad">
                                       <strong class="editfield ng-binding">Bachelor's Degree</strong>
                                   </div>
                                </div>
                                <div class="title">
                                   <span class="pvm-black ng-binding">
                                   Sales and Marketing
                                   </span>
                                </div>
                                <div class="date_range">
                                   <span class="pvm-blue ng-binding">Alfriston College, Auckland, New Zealand</span>
                                </div>
                                <div class="date_range">
                                   <span class="editable ng-binding">06-09-2005</span>
                                </div>
                                </div>
                                <!-- end ngIf: qualifications.length --><!-- end ngRepeat: qualification in qualifications | orderBy : sortDate : true --><!-- ngIf: qualifications.length -->
                                <div class="work-exp-holder ng-scope">
                                <div>
                                    <div id="edu-listing" class="col-md-4 pull-right">
                                      <img class="ng-scope" src="\images\schools\school_2.png">
                                   </div>
                                   <div class="col-md-8 no-pad">
                                      <strong class="editfield ng-binding">High School</strong>
                                   </div>
                                </div>
                                <div class="title">
                                   <span class="pvm-black ng-binding">
                                   High School
                                   </span>
                                </div>
                                <div class="date_range">
                                   <span class="pvm-blue ng-binding">James Hargest College</span>
                                </div>
                                <div class="date_range">
                                   <span class="editable ng-binding">05-24-2002</span>
                                </div>
                                </div>
                                <!-- end ngIf: qualifications.length --><!-- end ngRepeat: qualification in qualifications | orderBy : sortDate : true -->
                                <!-- ngIf: !qualifications.length -->
                           </div>
                        </div>
                     </div>
                     <div class="col-md-3">
                         <div class="sidecolumn-holder">
                             <div class="row no-marginlr">
                                <div class="col-md-12 contact_watchlist_btn hidden-xs hidden-sm padt-10">
                                   <div class="col-md-12 marginb-10">
                                       <a href="/my-profile#" class="btn btn-contact" disabled="">CONTACT ME</a>
                                   </div>
                                   <div class="col-md-12 marginb-10">
                                      <a href="/my-profile#" class="btn btn-watchlist" disabled="">
                                          <i class="glyphicon glyphicon-eye-open"></i> WATCHLIST
                                      </a>
                                   </div>
                                </div>     
                             </div><!-- eof row -->
                             <!--
                             <div class="row no-marginlr">
                                <div class="col-md-12 contact_watchlist_btn hidden-xs hidden-sm">
                                   <div class="col-md-12">
                                       <a href="/my-profile#" class="btn btn-contact" disabled="">CONTACT ME</a>
                                   </div>
                                   <div class="col-md-12">
                                      <a href="/my-profile#" class="btn btn-watchlist" disabled="">
                                          <i class="glyphicon glyphicon-eye-open"></i> WATCHLIST
                                      </a>
                                   </div>
                                </div>     
                             </div> -->
                             <div class="row no-marginlr">
                                <div class="col-md-12 view_my_con text-center hidden-xs hidden-sm">
                                    <div class="col-md-12 view_my pvm-blue">
                                        <h3>VIEW MY...</h3>
                                    </div>
                                    <div class="col-md-12 view_my">
                                        <a href="/assets/Uploads/resume-sample.pdf" class="btn pvm-full-black ng-scope" style="padding:0px;" target="_blank">Resume</a>
                                    </div>
                                    <div class="col-md-12 view_my_portfolio">
                                        <a href="/my-profile#" class="btn  pvm-full-black ng-scope" style="padding:0px;" disabled="">SUPPORTING DOCS</a>
                                    </div>
                                </div>
                             </div><!-- eof row -->
                             
                             <div class="row no-marginlr">
                                 <div class="col-md-12 line-divider hidden-sm hidden-xs"></div>
                             </div><!-- eof row -->
                             
                             <div class="row no-marginlr">
                                 <div class="reference_title">
                                     <h3>References</h3>
                                 </div>
                                <!-- ngRepeat: reference in references --><!-- ngIf: references.length -->
                                <div class="col-md-12 reference_con ng-scope">
                                    <div class="white-space-pre-line ng-binding">Reference 1</div>
                                    <div class="col-md-12 ref_emp_com text-right">
                                        <spam class="pvm-blue ng-binding">Boss 1</spam>
                                        <br>
                                        <spam class="ng-binding">Company ABC</spam>
                                        <br>
                                        <small class="ng-binding">3543636</small><br>
                                        <small class="ng-binding">CompanyABC@gmail.com</small>
                                    </div>
                                </div>     
                                <!-- end ngIf: references.length --><!-- end ngRepeat: reference in references --><!-- ngIf: references.length -->
                                <div class="col-md-12 reference_con ng-scope">
                                    <div class="white-space-pre-line ng-binding">Reference 2</div>
                                    <div class="col-md-12 ref_emp_com text-right">
                                        <spam class="pvm-blue ng-binding">Boss 2</spam>
                                        <br>
                                        <spam class="ng-binding">Company 2 ABC</spam>
                                        <br>
                                        <small class="ng-binding">756868678</small><br>
                                        <small class="ng-binding">company2ABC@gmail.com</small>
                                    </div>
                                </div>
                                <!-- end ngIf: references.length --><!-- end ngRepeat: reference in references -->
                                <!-- ngIf: !references.length --> 
                             </div><!-- eof row -->
                             <div class="clearfix"></div>
                         </div><!-- eof sidecolumn-holder -->
                     </div><!-- eof col-md-4 -->
                  </div>
                </div><!-- eof row -->
            </div>
   </div><!-- eof candidate_profile_content -->
</div><!-- eof row -->
    
@stop
    
@section('scripts')
@stop
