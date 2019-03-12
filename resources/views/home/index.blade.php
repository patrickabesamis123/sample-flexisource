@extends('layouts.home')

@section('styles')
<link rel="stylesheet" href="css/homepage.css?ver=1.5" />
<link rel="stylesheet" href="css/helpers2.css" />
<link rel="stylesheet" href="css/responsive-media.css" />
@stop

@section('content')

<div class="container-fluid">
    <div class="row">
        <div id="Homepagenew" class="col-md-12" ng-controller="HomeController">
            <div class="row">
                <div id="NewHomeBanner" ng-class="GBClass">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-8 col-md-offset-2 text-center">
                                <h1>We are the digital employment platform shaking up the recruitment process.</h1>
                                <h3 class="text-no-shadow">We have integrated employment opportunities with video and analytics to deliver more transparent user experiences and drive better employment outcomes. Sign up is free and easy.</h3>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 text-center">
                                <div class="BannerRegisterContainer">
                                    <a ng-click="goToLink($event)" href="/register" class="BannerRegister" data-ajax="false">Register for Free</a>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 text-center">
                                <div class="video-container-box">
                                    <video id="about_video" class="azuremediaplayer amp-default-skin">
                                        <p class="amp-no-js">To view this video please enable JavaScript, and consider upgrading to a web browser that supports HTML5 video</p>
                                    </video>
                                </div>    
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div><!-- eof row -->
            
            <div class="row">
                <div id="NewHomeSearchContainer" class="col-12">
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <h2>Search for a role or an employer</h2>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8 col-md-offset-2">
                            <div class="row">
                                <div class="container-fluid" ng-cloak>
                                    <form action="" ng-submit="SeachJob()">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <input type="text" placeholder="Keywords" name="s" ng-model="selectedParams.keyword" class="homesearchfield">
                                        </div> 
                                        <div class="col-md-3" id="CassificationCont">
                                            <div class="togglethis homesearchfield" data-toggle="dropdown"> 
                                                Classifications <span class="glyphicon glyphicon-triangle-bottom pull-right"></span>
                                            </div>
                                            <ul class="dropdown-menu multi-level col-md-6 industry_multi" id="ClassificationMain" style="display: none;">
                                                SELECT CLASSIFICATIONS
                                                <li ng-repeat="(key, value) in classifications" class="dropdown-submenu">
                                                    <div>
                                                        <input ng-change="selectClassification(value.id)" ng-true-value="'@{{value.id}}'" ng-false-value="''" ng-model="selectedIndustries" id="@{{value.id}}" class="class_inbox" type="checkbox">
                                                        <label for="@{{value.id}}" class="dropdown-toggle" data-toggle="dropdown">@{{value.display_name}}</label>
                                                    </div>
                                                     <ul class="dropdown-menu col-md-6 subindustry_multi_main tse-content" style="width: 220px;">
                                                        ALL SUB-CLASSIFICATIONS
                                                        <div style="height: 300px;overflow: scroll;">
                                                            <li ng-repeat="(key_sub, value_sub) in value.sub">
                                                                <input ng-change="selectSubClassification(value_sub.id)" ng-true-value="'@{{value_sub.id}}'" ng-false-value="''" ng-model="selectedIndustries" id="@{{value_sub.id}}" class="class_inbox" type="checkbox">
                                                                <label class="ng-binding">@{{value_sub.display_name}}</label>
                                                            </li>
                                                        </div>
                                                    </ul>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="locationAutoComplete">
                                                <input type="text" id="locationSearch" ng-model="searchLocation" placeholder="Location" style="color:#959595" autocomplete="off">
                                                <div class="sliderContainer tse-scrollable ng-hide" id="autoDataContainer">
                                                    <div class="tse-content">
                                                        <ul id="autoDataLocation" class="result ">
                                                            <li ng-repeat="(key, value) in autoLocation | filter:searchLocation">
                                                                <a href="/#" ng-click="" data-value="@{{value.id}}" class="autodata" style="display:block">@{{value.display_name}}</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="clearfix"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <input type="submit" value="Search" class="blue_btn" data-role="none">
                                        </div>
                                    </div><!-- eof row -->

                                    <div class="row">
                                        <div class="col-md-12 line-divider"></div>
                                    </div>

                                    <div class="row" id="HomeNewFilter">
                                        <div class="col-md-12">
                                            <div class="moreFilterContainer text-center">
                                                <a href="/#" id="moreFilter" ng-click="ShowHide()">
                                                <span ng-show="filterbutton">More filters +</span>
                                                <span ng-hide="filterbutton">Hide filters -</span>
                                                </a>
                                            </div>
                                            <div id="toggleFilter">
                                            <div class="row FilterContainer">
                                                <div class="col-md-2 padb-20">
                                                    <h5>Role type</h5>
                                                </div>
                                                <div class="col-md-10">
                                                    <ul id="WorkTypeList" class="list-inline">
                                                        <li class="ng-scope" ng-repeat="(key, val) in job_types">
                                                            <div class="roundedOne">
                                                                <div class="ui-checkbox">
                                                                    <label for="role_type_@{{val.id}}" for="role_type_@{{val.id}}" class="ui-btn ui-corner-all ui-btn-inherit ui-btn-icon-left ui-checkbox-off role_type_@{{val.id}}">
                                                                        @{{val.displayName}}
                                                                    </label>
                                                                    <input ng-true-value="'@{{value.id}}'" ng-false-value="''" ng-click="selectRoleType(val.id)" id="role_type_@{{val.id}}" type="checkbox">
                                                                </div>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="row FilterContainer">
                                                <div class="col-md-2 padb-20">
                                                    <h5>Salary</h5>
                                                </div>
                                                <div class="col-md-10" id="home_slider">
                                                    <div data-role="rangeslider" id="slider-range">
                                                        <input name="min_salary" id="min_salary" min="0" max="200000" step="1000" value="0" type="range" class="hideme" ng-model="min_salary" />
                                                        <input name="max_salary" id="max_salary" min="0" max="200000" step="1000" value="200000" type="range" class="hideme" ng-model="max_salary" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row" id="SubmitWithFilter">
                                                <div class="col-md-12">
                                                    <!--
                                                    <input type="submit" value="Search" class="blue_btn pull-right">
                                                    <input type="button" value="Cancel" class="pull-right cancel">
                                                    -->
                                                    <button type="submit" value="Search" class="btn blue_btn pull-right" data-role="none">Search</button>
                                                    <a href="#" class="btn pull-right cancel">Cancel</a>
                                                </div>    
                                                <div class="clearfix"></div>
                                            </div>
                                        </div>
                                        </div>
                                    </div><!-- eof row -->
                                        
                                    </form>
                                    
                                    </div>
                                </div><!-- eof row -->
                            </div>
                        </div>
                    </div>
            </div><!-- eof row -->
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="container-fluid">
                            <div class="row" id="TabContainer1">
                            <div class="col-md-12">
                                <div class="tabthis">
                                  <!-- Nav tabs -->
                                  <ul class="nav nav-tabs" role="tablist" id="Tab1">
                                    <li role="presentation" class="active"><a href="#tabber1" aria-controls="tabber1" role="tab" data-toggle="tab">Features for Employers</a></li>
                                    <li role="presentation"><a href="#tabber2" aria-controls="tabber2" role="tab" data-toggle="tab">Features for Candidates</a></li>
                                  </ul>
                                  <!-- Tab panes -->
                                   <div class="row tab-content">
                                    <div role="tabpanel" class="fade in tab-pane active tabs" id="tabber1">
                                        <div class="col-md-12">
                                        <h2>Features for employers</h2>
                                            <div id="carousel1"  class="carouselthis slide hidden-xs hidden-sm" data-ride="carousel">
                                                <div class="carousel-inner" role="listbox">
                                                    <div class="item" ng-class="{'active': key == 0}" ng-repeat="(key, val) in employerby5items" >
                                                        <div class="row">
                                                            <div class="col-md-2 " ng-class="{'active col-md-offset-1': skey == val.end - 5}" ng-repeat="(skey, sval) in EmployerSlider" ng-if="skey >= val.start && skey < val.end" >
                                                                <div class="content">
                                                                <div class="text-no-shadow contentCont">
                                                                <img src="@{{sval.imgpath}}" alt="" class="icon1" width="@{{sval.width}}" height="@{{sval.height}}">
                                                                 @{{sval.title}}
                                                                </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- previous and next button -->
                                                <a class="left carousel-control" data-target="#carousel1">
                                                    <i class="fa fa-angle-left"></i>
                                                    <span class="sr-only">Previous</span>
                                                </a>
                                                <a class="right carousel-control" data-target="#carousel1">
                                                     <i class="fa fa-angle-right"></i>
                                                    <span class="sr-only">Next</span>
                                                </a>
                                            </div>

                                            <div id="carouselmobile1"  class="carouselthis slide visible-xs visible-sm mobileslider" data-ride="carousel">
                                                <div class="carousel-inner" role="listbox">
                                                    <div class="item" ng-class="{active: key == 0}" data-item="key" ng-repeat="(key, val) in EmployerSlider">
                                                        <div class="content">
                                                        <div class="contentCont">
                                                        <img src="@{{val.imgpath}}" alt="" class="icon1" width="@{{val.width}}" height="@{{val.height}}">
                                                        @{{val.title}}
                                                        </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- previous and next button -->
                                                <a class="left carousel-control" data-target="#carouselmobile1">
                                                    <i class="fa fa-angle-left"></i>
                                                    <span class="sr-only">Previous</span>
                                                </a>
                                                <a class="right carousel-control" data-target="#carouselmobile1">
                                                     <i class="fa fa-angle-right"></i>
                                                    <span class="sr-only">Next</span>
                                                </a>
                                                <a class="slidetofirst hide" data-slide-to="0"  data-target="#carouselmobile1"></a>
                                            </div>
                                            <div class="row ViewFeaturesCont">
                                                <a href="/features/employers" class="ViewFeatures" data-ajax="false">View all Features</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div role="tabpanel" class="fade tab-pane tabs" id="tabber2">
                                        <div class="col-md-12">
                                        <h2>Features for Candidates</h2>
                                            <div id="carousel2"  class="carouselthis slide hidden-xs hidden-sm" data-ride="carousel">
                                                <div class="carousel-inner" role="listbox">
                                                    <div class="item" ng-class="{'active': key == 0}" ng-repeat="(key, val) in candidateby5items" >
                                                        <div class="row">
                                                            <div class="col-md-2 " ng-class="{'active col-md-offset-1': skey == val.end - 5}" ng-repeat="(skey, sval) in CandidateSlider" ng-if="skey >= val.start && skey < val.end" >
                                                                <div class="content">
                                                                <div class="contentCont">
                                                                <img src="@{{sval.imgpath}}" alt="" class="icon1" width="@{{sval.width}}" height="@{{sval.height}}">
                                                                 @{{sval.title}}
                                                                </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- previous and next button -->
                                                <a class="left carousel-control"  data-target="#carousel2" data-slide-to="0">
                                                    <i class="fa fa-angle-left"></i>
                                                    <span class="sr-only">Previous</span>
                                                </a>
                                                <a class="right carousel-control"     data-target="#carousel2" data-slide-to="1">
                                                     <i class="fa fa-angle-right"></i>
                                                    <span class="sr-only">Next</span>
                                                </a>
                                            </div>

                                            <div id="carouselmobile2"  class="carouselthis slide visible-xs visible-sm" data-ride="carousel">
                                                <div class="carousel-inner" role="listbox">
                                                    <div class="item  active">
                                                        <div class="content">
                                                        <div class="contentCont">
                                                        <img src="/images/homepage/iconset/cand-icon1@2x.png" alt="" class="icon1" width="53" height="51">
                                                        Video feature to showcase your personality, skills and experience
                                                        </div>
                                                        </div>
                                                    </div>
                                                    <div class="item">
                                                        <div class="content">
                                                        <div class="contentCont">
                                                            <img src="/images/homepage/iconset/cand-icon2@2x.png" alt="" class="icon1" width="45" height="37">
                                                            Receive feedback on all your applications
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="item">
                                                        <div class="content">
                                                        <div class="contentCont">
                                                        <img src="/images/homepage/iconset/cand-icon3@2x.png" alt="" class="icon1" width="44" height="42">
                                                        The dashboard allows you to track and manage all your applications
                                                        </div>
                                                        </div>
                                                    </div>
                                                    <div class="item">
                                                        <div class="content">
                                                        <div class="contentCont">
                                                            <img src="/images/homepage/iconset/cand-icon4@2x.png" alt="" class="icon1" width="64" height="54">
                                                            Intelligent algorithms to match and notify you so you never miss an opportunity
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="item">
                                                        <div class="content">
                                                        <div class="contentCont">
                                                            <img src="/images/homepage/iconset/cand-icon5@2x.png" alt="" class="icon1" width="73" height="26">
                                                            Faster to apply - one profile for all jobs
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="item">
                                                        <div class="content">
                                                        <img src="/images/homepage/iconset/cand-icon6@2x.png" alt="" class="icon1" width="43" height="48">
                                                        View employer profiles before you apply
                                                        </div>
                                                    </div>
                                                    <div class="item">
                                                        <div class="content">
                                                            <img src="/images/homepage/iconset/cand-icon7@2x.png" alt="" class="icon1" width="49" height="42">
                                                            Our service is completely free
                                                        </div>
                                                    </div>
                                                    <div class="item">
                                                        <div class="content">
                                                        <img src="/images/homepage/iconset/cand-icon1@2x.png" alt="" class="icon1" width="53" height="51">
                                                        Video feature to showcase your personality, skills and experience
                                                        </div>
                                                    </div>
                                                    <div class="item">
                                                        <div class="content">
                                                            <img src="/images/homepage/iconset/cand-icon2@2x.png" alt="" class="icon1" width="45" height="37">
                                                            Receive feedback on all your applications
                                                        </div>
                                                    </div>
                                                    <div class="item">
                                                        <div class="content">
                                                            <img src="/images/homepage/iconset/cand-icon3@2x.png" alt="" class="icon1" width="44" height="42">
                                                            The dashboard allows you to track and manage all your applications
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- previous and next button -->
                                                <a class="left carousel-control" data-target="#carouselmobile2">
                                                    <i class="fa fa-angle-left"></i>
                                                    <span class="sr-only">Previous</span>
                                                </a>
                                                <a class="right carousel-control" data-target="#carouselmobile2">
                                                     <i class="fa fa-angle-right"></i>
                                                    <span class="sr-only">Next</span>
                                                </a>
                                            </div>
                                            <div class="row ViewFeaturesCont">
                                                <a href="/features/candidates" class="ViewFeatures" data-ajax="false">View all Features</a>
                                            </div>
                                            </div>
                                        </div>
                                       </div>

                                    </div>
                                </div>
                            </div><!-- eof row -->
                            <div class="row">
                            <div class="col-md-12" id="FeaturedOppurtunities" ng-cloak>
                                <div>
                                    <h2>Featured opportunities</h2>
                                    <div class="FeaturedJobs">
                                    <div id="carousel3" class="carouselthis slide hidden-xs hidden-sm" data-ride="carousel">
                                        <div class="carousel-inner" role="listbox">
                                            <!-- ngRepeat: (key, val) in jobsby5items -->
                                            <div class="item ng-scope active">
                                                <div class="row">
                                                    <!-- ngRepeat: (skey, sval) in featuredJobs --><!-- ngIf: skey >= val.start && skey < val.end -->
                                                    <div class="col-md-2  ng-scope active col-md-offset-1">
                                                        <div class="content">
                                                            <div class="contentCont">
                                                                <a href="/job/listing/job-listing-sample" data-ajax="false">
                                                                <img ng-src="https://pvmlive.blob.core.windows.net/4io7e0o/8ztnl/1520803415_J001498_SocialCollateral_ProfilePictures_NR_2_(1).png" width="80" class="img-circle" on-error-src="images/defaultPhoto.png" title="PreviewMe" src="https://pvmlive.blob.core.windows.net/4io7e0o/8ztnl/1520803415_J001498_SocialCollateral_ProfilePictures_NR_2_(1).png">
                                                                <!-- ngIf: !sval.company_logo_url -->
                                                                </a>
                                                                <div class="JobName"><a href="/job/listing/job-listing-sample" data-ajax="false" class="ng-binding">Business  Manager 5 yrs exp</a></div>
                                                                <div class="joblocation"><a href="/job/listing/job-listing-sample" data-ajax="false" class="ng-binding">Hauraki, Auckland</a></div>
                                                            </div>
                                                        </div>
                                                    </div><!-- end ngIf: skey >= val.start && skey < val.end --><!-- end ngRepeat: (skey, sval) in featuredJobs --><!-- ngIf: skey >= val.start && skey < val.end -->
                                                    <div class="col-md-2  ng-scope">
                                                        <div class="content">
                                                            <div class="contentCont">
                                                                <a href="/job/listing/job-listing-sample" data-ajax="false">
                                                                <img ng-src="https://pvmlive.blob.core.windows.net/csrzu6j/dqqr1/1513118733_about_image-01.jpg" width="80" class="img-circle" on-error-src="images/defaultPhoto.png" title="Cactus Insurance" src="https://pvmlive.blob.core.windows.net/csrzu6j/dqqr1/1513118733_about_image-01.jpg">
                                                                <!-- ngIf: !sval.company_logo_url -->
                                                                </a>
                                                                <div class="JobName"><a href="/job/listing/job-listing-sample" data-ajax="false" class="ng-binding">Life Insurance Adviser</a></div>
                                                                <div class="joblocation"><a href="/job/listing/job-listing-sample" data-ajax="false" class="ng-binding">All Auckland</a></div>
                                                            </div>
                                                        </div>
                                                    </div><!-- end ngIf: skey >= val.start && skey < val.end --><!-- end ngRepeat: (skey, sval) in featuredJobs --><!-- ngIf: skey >= val.start && skey < val.end -->
                                                    <div class="col-md-2  ng-scope">
                                                        <div class="content">
                                                            <div class="contentCont">
                                                                <a href="/job/listing/job-listing-sample" data-ajax="false">
                                                                <img ng-src="https://pvmlive.blob.core.windows.net/csrzu6j/dqqr1/1513118733_about_image-01.jpg" width="80" class="img-circle" on-error-src="images/defaultPhoto.png" title="Cactus Insurance" src="https://pvmlive.blob.core.windows.net/csrzu6j/dqqr1/1513118733_about_image-01.jpg">
                                                                <!-- ngIf: !sval.company_logo_url -->
                                                                </a>
                                                                <div class="JobName"><a href="/job/listing/job-listing-sample" data-ajax="false" class="ng-binding">Sales Rep</a></div>
                                                                <div class="joblocation"><a href="/job/listing/job-listing-sample" data-ajax="false" class="ng-binding">Auckland</a></div>
                                                            </div>
                                                        </div>
                                                    </div><!-- end ngIf: skey >= val.start && skey < val.end --><!-- end ngRepeat: (skey, sval) in featuredJobs --><!-- ngIf: skey >= val.start && skey < val.end -->
                                                    <div class="col-md-2  ng-scope">
                                                        <div class="content">
                                                            <div class="contentCont">
                                                                <a href="/job/listing/job-listing-sample" data-ajax="false">
                                                                <img ng-src="https://pvmlive.blob.core.windows.net/p5gu648/rvpnc/1520483179_DLA.jpg" width="80" class="img-circle" on-error-src="images/defaultPhoto.png" title="DLA Piper New Zealand" src="https://pvmlive.blob.core.windows.net/p5gu648/rvpnc/1520483179_DLA.jpg">
                                                                <!-- ngIf: !sval.company_logo_url -->
                                                                </a>
                                                                <div class="JobName"><a href="/job/listing/job-listing-sample" data-ajax="false" class="ng-binding">Corporate Receptionist (Wellington)</a></div>
                                                                <div class="joblocation"><a href="/job/listing/job-listing-sample" data-ajax="false" class="ng-binding">Wellington Central, Wellington</a></div>
                                                            </div>
                                                        </div>
                                                    </div><!-- end ngIf: skey >= val.start && skey < val.end --><!-- end ngRepeat: (skey, sval) in featuredJobs --><!-- ngIf: skey >= val.start && skey < val.end -->
                                                    <div class="col-md-2  ng-scope">
                                                        <div class="content">
                                                            <div class="contentCont">
                                                                <a href="/job/listing/job-listing-sample" data-ajax="false">
                                                                <img ng-src="https://pvmlive.blob.core.windows.net/0c8rd0m/HavenLogo.png" width="80" class="img-circle" on-error-src="images/defaultPhoto.png" title="Haven Advisers &amp; Accountants" src="https://pvmlive.blob.core.windows.net/0c8rd0m/HavenLogo.png">
                                                                <!-- ngIf: !sval.company_logo_url -->
                                                                </a>
                                                                <div class="JobName"><a href="/job/listing/job-listing-sample" data-ajax="false" class="ng-binding">Financial Adviser - New to Industry</a></div>
                                                                <div class="joblocation"><a href="/job/listing/job-listing-sample" data-ajax="false" class="ng-binding">Hamilton, Waikato</a></div>
                                                            </div>
                                                        </div>
                                                    </div><!-- end ngIf: skey >= val.start && skey < val.end --><!-- end ngRepeat: (skey, sval) in featuredJobs --><!-- ngIf: skey >= val.start && skey < val.end --><!-- end ngRepeat: (skey, sval) in featuredJobs --><!-- ngIf: skey >= val.start && skey < val.end --><!-- end ngRepeat: (skey, sval) in featuredJobs --><!-- ngIf: skey >= val.start && skey < val.end --><!-- end ngRepeat: (skey, sval) in featuredJobs -->
                                                </div>
                                            </div><!-- end ngRepeat: (key, val) in jobsby5items -->
                                            <div class="item ng-scope">
                                                <div class="row">
                                                    <!-- ngRepeat: (skey, sval) in featuredJobs --><!-- ngIf: skey >= val.start && skey < val.end --><!-- end ngRepeat: (skey, sval) in featuredJobs --><!-- ngIf: skey >= val.start && skey < val.end --><!-- end ngRepeat: (skey, sval) in featuredJobs --><!-- ngIf: skey >= val.start && skey < val.end --><!-- end ngRepeat: (skey, sval) in featuredJobs --><!-- ngIf: skey >= val.start && skey < val.end --><!-- end ngRepeat: (skey, sval) in featuredJobs --><!-- ngIf: skey >= val.start && skey < val.end --><!-- end ngRepeat: (skey, sval) in featuredJobs --><!-- ngIf: skey >= val.start && skey < val.end -->
                                                    <div class="col-md-2  ng-scope active col-md-offset-1">
                                                        <div class="content">
                                                            <div class="contentCont">
                                                                <a href="/job/listing/job-listing-sample" data-ajax="false">
                                                                <img ng-src="https://pvmlive.blob.core.windows.net/0c8rd0m/HavenLogo.png" width="80" class="img-circle" on-error-src="images/defaultPhoto.png" title="Haven Advisers &amp; Accountants" src="https://pvmlive.blob.core.windows.net/0c8rd0m/HavenLogo.png">
                                                                <!-- ngIf: !sval.company_logo_url -->
                                                                </a>
                                                                <div class="JobName"><a href="/job/listing/job-listing-sample" data-ajax="false" class="ng-binding">Financial Adviser - New to Industry</a></div>
                                                                <div class="joblocation"><a href="/job/listing/job-listing-sample" data-ajax="false" class="ng-binding">All Wellington</a></div>
                                                            </div>
                                                        </div>
                                                    </div><!-- end ngIf: skey >= val.start && skey < val.end --><!-- end ngRepeat: (skey, sval) in featuredJobs --><!-- ngIf: skey >= val.start && skey < val.end -->
                                                    <div class="col-md-2  ng-scope">
                                                        <div class="content">
                                                            <div class="contentCont">
                                                                <a href="/job/listing/job-listing-sample" data-ajax="false">
                                                                <img ng-src="https://pvmlive.blob.core.windows.net/0c8rd0m/HavenLogo.png" width="80" class="img-circle" on-error-src="images/defaultPhoto.png" title="Haven Advisers &amp; Accountants" src="https://pvmlive.blob.core.windows.net/0c8rd0m/HavenLogo.png">
                                                                <!-- ngIf: !sval.company_logo_url -->
                                                                </a>
                                                                <div class="JobName"><a href="/job/listing/job-listing-sample" data-ajax="false" class="ng-binding">Financial Advice &amp; Sales</a></div>
                                                                <div class="joblocation"><a href="/job/listing/job-listing-sample" data-ajax="false" class="ng-binding">Christchurch, Canterbury</a></div>
                                                            </div>
                                                        </div>
                                                    </div><!-- end ngIf: skey >= val.start && skey < val.end --><!-- end ngRepeat: (skey, sval) in featuredJobs --><!-- ngIf: skey >= val.start && skey < val.end -->
                                                    <div class="col-md-2  ng-scope">
                                                        <div class="content">
                                                            <div class="contentCont">
                                                                <a href="/job/listing/job-listing-sample" data-ajax="false">
                                                                <img ng-src="https://pvmlive.blob.core.windows.net/0c8rd0m/HavenLogo.png" width="80" class="img-circle" on-error-src="images/defaultPhoto.png" title="Haven Advisers &amp; Accountants" src="https://pvmlive.blob.core.windows.net/0c8rd0m/HavenLogo.png">
                                                                <!-- ngIf: !sval.company_logo_url -->
                                                                </a>
                                                                <div class="JobName"><a href="/job/listing/job-listing-sample" data-ajax="false" class="ng-binding">Financial Advice &amp; Sales</a></div>
                                                                <div class="joblocation"><a href="/job/listing/job-listing-sample" data-ajax="false" class="ng-binding">Wellington</a></div>
                                                            </div>
                                                        </div>
                                                    </div><!-- end ngIf: skey >= val.start && skey < val.end --><!-- end ngRepeat: (skey, sval) in featuredJobs -->
                                                </div>
                                            </div><!-- end ngRepeat: (key, val) in jobsby5items -->
                                        </div>
                                        <!-- previous and next button -->
                                        <a class="left carousel-control ui-link" data-target="#carousel3" data-slide-to="0">
                                        <i class="fa fa-angle-left"></i>
                                        <span class="sr-only">Previous</span>
                                        </a>
                                        <a class="right carousel-control ui-link" data-target="#carousel3" data-slide-to="1">
                                        <i class="fa fa-angle-right"></i>
                                        <span class="sr-only">Next</span>
                                        </a>
                                    </div>

                                    <div class="row visible-xs visible-sm">
                                        <div class="col-md-12">
                                            <div id="carouselmobile3" class="carouselthis slide visible-xs visible-sm" data-ride="carousel">
                                                <div class="carousel-inner" role="listbox">
                                                    <div class="item" ng-class="{'active': featuredJob == featuredJobs[0]}" ng-repeat="featuredJob in featuredJobs">
                                                        <div class="content">
                                                            <div class="contentCont">
                                                                <a href="featuredJob.job_url" data-ajax="false">
                                                                    <img ng-src="featuredJob.company_logo_url" ng-class="{'hide': featuredJob.company_logo_url == null || featuredJob.company_logo_url == ''}" width="80" class="img-circle" on-error-src="images/defaultPhoto.png" title="featuredJob.company_name ">
                                                                    <img ng-src="images/defaultPhoto.png" ng-if="  featuredJob.company_logo_url == null || featuredJob.company_logo_url == ''  " width="80" class="img-circle" title="member.employer.first_name member.employer.last_name">
                                                                </a>
                                                                <div class="JobName"><a href="featuredJob.job_url" data-ajax="false">featuredJob.job_title</a></div>
                                                                <div class="joblocation"><a href="featuredJob.job_url" data-ajax="false">featuredJob.location.display_name</a></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- previous and next button -->
                                                <a class="left carousel-control" data-target="#carouselmobile3">
                                                    <i class="fa fa-angle-left"></i>
                                                    <span class="sr-only">Previous</span>
                                                </a>
                                                <a class="right carousel-control" data-target="#carouselmobile3">
                                                <i class="fa fa-angle-right"></i>
                                                <span class="sr-only">Next</span>
                                                </a>
                                            </div>
                                        </div>
                                    </div><!-- eof row -->

                                            <div class="row ViewjobsCont text-center">
                                                <a href="/job-search" class="Viewjobs" data-ajax="false">View more jobs</a>
                                            </div><!-- eof row -->
                                        </div>
                                    </div>

                                </div><!-- eof FeaturedOppurtunities -->
                            </div><!-- eof row -->
                            <div class="row">
                                <div class="col-md-12" id="Section5homepage">
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-md-12 subtitle text-center">Companies who use us</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="table">
                                                    <ul class="partners">
                                                        <li><img src="images/homepage/Deloitte-logo-white-bw.png" width="124" class="img-responsive"></li>
                                                        <li><img src="images/homepage/RMcV-Logo-Black-bw.png" width="165" class="img-responsive"></li>
                                                        <li><img src="images/homepage/KS_Logo_cmyk_15m100y-bw.png" width="138" class="img-responsive"></li>
                                                        <li><img src="images/homepage/HudsonGavinMartin-992x348-bw.png" width="79" class="img-responsive"></li>
                                                        <li><img src="images/homepage/TBAG-bw.png" width="110" class="img-responsive"></li>
                                                        <li><img src="images/homepage/job-listing-logo.png" width="78" class="img-responsive"></li>
                                                        <br>
                                                        <li><img src="images/homepage/Augusto_Logo_Strap_Black-RGB-bw.png" class="img-responsive" width="95"></li>
                                                        <li><img src="images/homepage/BBT_logo_CMYK_Red_On_Black-bw.png" class="img-responsive" width="60"></li>
                                                        <li><img src="images/homepage/CornerStore-Logo-Horiz-Strapline-RGB-bw.png" class="img-responsive" width="105"></li>
                                                        <li><img src="images/homepage/Haven_Logo_Update_Stacked-bw.png" class="img-responsive" width="87"></li>
                                                        <li><img src="images/homepage/NZME-logo-bw.png" class="img-responsive" width="92"></li>
                                                        <li><img src="images/homepage/NA_Circle-bw.png" class="img-responsive" width="52"></li>
                                                    </ul>
                                                </div><!-- eof table -->
                                            </div>
                                        </div><!-- eof row -->
                                    </div><!-- eof container -->
                                </div>
                            </div><!-- eof row -->
                            <div class="row">
                                <div id="HomeContact" class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-6 left text-center">
                                            <h1>Free and easy</h1>
                                            <img src="images/icon-home-1.png" class="img-responsive">
                                            <p>So what are you waiting for? <br>Sign up today!</p>
                                        </div>
                                        <div class="col-md-6 align-top">
                                            <div class="register-form-container" ng-controller="RegisterController" class="ng-scope">
                                            <!--<div class="register-form-container" ng-controller="RegisterController" ng-cloak> -->
                                                <h1>Sign up for FREE!</h1>
                                                <div class="divider"></div>
                                                <ul class="errmsg">
                                                    <li ng-repeat="(key, val) in ErrorMsgs">
                                                        <div ng-switch on="key">
                                                            <p class="alert alert-danger" ng-switch-when="first_name"><strong>First Name:</strong> val </p>
                                                            <p class="alert alert-danger" ng-switch-when="last_name"><strong>Last Name:</strong> val </p>
                                                            <p class="alert alert-danger" ng-switch-when="email"><strong>Email:</strong> val </p>
                                                            <p class="alert alert-danger" ng-switch-when="first" ng-if="val == 'Invalid password'">Password must be between 8 to 10 characters long and must contain at least one digit</p>
                                                            <p ng-switch-when="username"></p>
                                                            <p class="alert alert-danger" ng-switch-default>val </p>
                                                        </div>
                                                    </li> 
                                                </ul>

                                                <form id="Form" action="/home/" method="post" enctype="application/x-www-form-urlencoded" ng-submit="save()" onsubmit="return false">
                                                        <p id="Form_error" class="message" style="display: none"></p>
                                                        <fieldset>
                                                        <div class="signup-forms">    
                                                            <div id="Form_first_name_Holder" class="field text">
                                                                <div class="middleColumn">
                                                                <input type="text" name="first_name" class="text ng-pristine ng-untouched ng-empty ng-invalid ng-invalid-required" id="Form_first_name" required="required" aria-required="true" ng-model="first_name" placeholder="First name*">
                                                                <span class="asterisk asterisk1">*</span>
                                                                </div>
                                                            </div>
                                                            <div id="Form_last_name_Holder" class="field text nolabel">
                                                                <div class="middleColumn">
                                                                <input type="text" name="last_name" class="text nolabel ng-pristine ng-empty ng-invalid ng-invalid-required" id="Form_last_name" required="required" aria-required="true" ng-model="last_name" placeholder="Last name*">
                                                                <span class="asterisk asterisk2">*</span>
                                                                </div>
                                                            </div>
                                                            <div id="Form_email_Holder" class="field email text nolabel">
                                                                <div class="middleColumn">
                                                                <input type="email" name="email" class="email text nolabel ng-pristine ng-untouched ng-empty ng-valid-email ng-invalid ng-invalid-required" id="Form_email" required="required" aria-required="true" ng-model="email" placeholder="Email*">
                                                                <span class="asterisk asterisk3">*</span>
                                                                </div>
                                                            </div>
                                                            <div id="Form_first_password_Holder" class="field text password nolabel">
                                                                <div class="middleColumn">
                                                                <input type="password" name="first_password" class="text password nolabel ng-pristine ng-untouched ng-empty ng-invalid ng-invalid-required" id="Form_first_password" required="required" aria-required="true" ng-model="first_password" placeholder="password*" ng-blur="passwordHack($event)" autocomplete="off">
                                                                <span class="asterisk asterisk4">*</span>
                                                                </div>
                                                            </div>
                                                            <div id="Form_second_password_Holder" class="field text password nolabel">
                                                                <div class="middleColumn">
                                                                <input type="password" name="second_password" class="text password nolabel ng-pristine ng-untouched ng-empty ng-invalid ng-invalid-required" id="Form_second_password" required="required" aria-required="true" ng-model="second_password" placeholder="Confirm password*" autocomplete="off">
                                                                <span class="asterisk asterisk5">*</span>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div id="user_type_res" class="field">
                                                            <label class="left">I'm looking for...<span class="red">*</span></label>
                                                            <div class="middleColumn">
                                                                <ul name="user_type" class="optionset" id="Form_user_type" required="required" aria-required="true">
                                                                    <li class="odd valcandidate">
                                                                    <input type="radio" ng-change="updateUserType(user_type)" data-ng-model="user_type" v-model="user_type" value="candidate" class="radio ng-pristine ng-untouched ng-empty ng-invalid ng-invalid-required" name="user_type" checked="checked" id="Form_user_type_candidate" required="required">
                                                                    <label for="Form_user_type_candidate"><div class="check"></div><div class="text">A job</div></label>
                                                                    </li>
                                                                    <li class="even valemployer">
                                                                    <input type="radio" ng-change="updateUserType(user_type)" data-ng-model="user_type" v-model="user_type" value="employer" class="radio ng-pristine ng-untouched ng-empty ng-invalid ng-invalid-required" name="user_type" id="Form_user_type_employer" required="required">
                                                                    <label for="Form_user_type_employer"><div class="check"></div><div class="text">An employee</div></label>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="pvm-registration-checkbox-container">
                                                            <div class="pvm-registration--check-items clear-float">
                                                                <div class="pvm-registration--checkbox">
                                                                    <!-- ngIf: termsAndPolicies -->
                                                                    <i ng-if="termsAndPolicies" class="fa fa-check ng-scope" aria-hidden="true"></i>
                                                                    <input type="checkbox" ng-change="updateTermsAndPolicies(termsAndPolicies)" ng-model="termsAndPolicies" value="true" class="radio ng-pristine ng-untouched ng-empty ng-invalid ng-invalid-required" name="checkboxTermsAndPolicies" required="required">
                                                                </div>   
                                                                <div class="pvm-registration--text-content">
                                                                    <p>
                                                                    I understand &amp; accept the PreviewMe <a href="/terms-and-conditions" data-ajax="false">Terms of Service</a> &amp; <a href="/privacy-policy" data-ajax="false">Privacy Policy</a>
                                                                    </p>
                                                                </div>
                                                            </div>
                                                            <div class="pvm-registration--check-items clear-float ng-scope" ng-if="newsLetterState">
                                                                <div class="pvm-registration--checkbox">
                                                                    <!-- ngIf: subscribeLetter -->
                                                                    <i ng-if="subscribeLetter" class="fa fa-check ng-scope" aria-hidden="true"></i>
                                                                    <input type="checkbox" ng-change="updateNewsletter(subscribeLetter)" ng-model="subscribeLetter" class="radio ng-pristine ng-untouched ng-valid ng-empty" name="newsLetter">
                                                                </div>
                                                                <div class="pvm-registration--text-content">
                                                                    <p>I would like to subscribe to PreviewMe's newsletter</p>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    <input type="hidden" name="SecurityID" value="dad135c062b318b962f09d8e5d8918b537820122" class="hidden" id="Form_SecurityID">
                                                    <div class="clear"></div>
                                                    </fieldset>
                                                    <div class="Actions">
                                                        <input type="submit" name="action_doNothing" value="Sign Up" class="action" id="Form_action_doNothing" />
                                                    </div>
                                                </form>
                                                <div ng-hide="preload" class="loadme text-center ng-hide"><img src="/images/preloader.gif" height="40px"></div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- eof row -->
                            <div class="row" id="Testimonials">
                                <div class="col-md-6 left">
                                    <div class="testimonialContent">
                                    PreviewMe is definitely one to watch; an employment technology company which acknowledges the importance of chemistry and cultural fit as well as qualifications and experience.
                                    </div>
                                    <div class="testimonialAuthor">
                                    — LiveNews
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="testimonialContent">
                                    Arguably this is the most personal approach to recruitment available.
                                    </div>
                                    <div class="testimonialAuthor">
                                    — Voxy
                                    </div>
                                </div>
                            </div><!-- eof row -->
                            <div class="row" id="SocialShare" ng-controller="SocialShare">
                                <div class="col-md-6 linkedin">
                                    <div class="text-center left">
                                        <a href="https://www.linkedin.com/company/previewme" socialshare="" socialshare-provider="linkedin" socialshare-text="Previewme" socialshare-url="https://previewme.co/ " data-ajax="false">
                                        <i class="fa fa-linkedin"></i>
                                        Follow us on LinkedIn
                                        </a>
                                    </div>
                                </div>
                                <div class="col-md-6 facebook">
                                    <div class="text-center left">
                                        <a href="https://www.facebook.com/previewme/" socialshare="" socialshare-provider="facebook" socialshare-text="Previewme" socialshare-url="https://previewme.co/" data-ajax="false">
                                        <i class="fa fa-facebook"></i>
                                        Follow us on Facebook
                                        </a>
                                    </div>
                                </div>
                            </div><!-- eof row -->
                        </div>
                    </div><!-- eof row -->
                </div>
            </div>
        </div><!-- eof Homepagenew -->
    </div><!-- eof row -->
</div>

@stop

@section('scripts')
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.min.js?ver=1.11.4"></script>
<!-- Commenting out the jquery mobile include will cause the checkboxes and slider on the job portion to be hidden. Otherwise, it will cause the search button to not work when clicked -->
<script src="//code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js?ver=1.4.5"></script> 
<script type="text/javascript" src="js/angucomplete.js?ver=1"></script>
<script type="text/javascript" src="js/minified/controllers/homepage.controller.min.js"></script>
<script type="text/javascript" src="js/minified/login/register.min.js?ver=3.3"></script>

<script type="text/javascript">
$(document).ready(function (){
    $('#Homepagenew #Form .Actions > div').removeClass();
    $('#Homepagenew #Form .Actions > div').text("");
//Register Page
    $('input[type=radio][name=user_type]').change(function() {
        // Candidate section
        if (this.value == 'candidate') {
            $('#Homepagenew .action').val('Sign up as a candidate');
            $('#Homepagenew .action').removeClass('submitblue whitetext');
            $('#Homepagenew .action').addClass('submityellow');
            
            $('form#Form').addClass('gtm-signup-candidate');
            $('form#Form').removeClass('gtm-signup-employer');
        }
        // Employer section
        else if (this.value == 'employer') {
            $('#Homepagenew .action').val('Sign up as an employer');
            $('#Homepagenew .action').addClass('submitblue whitetext');
            $('#Homepagenew .action').removeClass('submityellow');

            $('form#Form').addClass('gtm-signup-employer');
            $('form#Form').removeClass('gtm-signup-candidate');
        }
    });

});
</script>

@stop