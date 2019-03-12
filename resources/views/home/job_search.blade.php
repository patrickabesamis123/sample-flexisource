@extends('layouts.home')

@section('styles')
<link rel="stylesheet" href="css/helpers2.css" />
<link rel="stylesheet" href="css/responsive-media.css" />
@stop

@section('content')

<?php
$baseUrl = "http://previewme.co/";
?>

<script type="text/javascript">var switchTo5x=true;</script>
<script type="text/javascript" src="{$ThemeDir}/js/buttons.js"></script>
<script type="text/javascript">stLight.options({publisher: "599a161e-f7fe-4fc0-b53c-ac3298e81b55", doNotHash: false, doNotCopy: false, hashAddressBar: false});</script>

<div id="SearchPage" ng-controller="JobSearchController" ng-cloak class="job-list-page">
    <div class="container-fluid">
        <div class="row">
          <div id="job-search-head-image">
            <div class="container">
              <div class="row search_container">
                <form class="ng-pristine ng-valid" method="get" ng-submit="searchJob()">
                  <div class="col-md-12 HomeSearch">
                    <div class="row">
                      <div class="col-sm-10 col-xs-8 searchfield">
                        <div class="input-group">
                          <span class="input-group-addon" id="sizing-addon2">
                            <span class="glyphicon glyphicon-search "></span>
                          </span>
                          <div>
                            <input class="form-control" ng-model="searchJobId" placeholder="find your right fit... Search a job, companies and more..." type="text">
                          </div>
                        </div>
                        <div class="clearfix"></div>
                      </div>
                      <div class="col-sm-2 col-xs-4">
                        <button class="searchButton ui-btn ui-shadow ui-corner-all" type="submit" style="width : 100%">
                            SEARCH
                        </button>
                      </div>
                    </div>
                  </div>
                </form>
              </div>
              </div>
            </div>
        </div>
        <div class="row searchCounter">
            <div class="col-md-12 text-center">
              <h3 ng-show="jobSearch.length == 0">Searching jobs that suits you. please wait.</h3>
              <h3 ng-show="jobSearch != 0">
                We have <strong>@{{jobSearch.num_found}}</strong>
                <span ng-if="jobSearch.num_found == 1">result</span>
                <span ng-if="jobSearch.num_found != 1">results</span>
                for you to consider
              </h3>
            </div>
        </div>
        <div class="row searchItems">
            <div class="container">
              <div class="row">
                <div class="col-md-12">
                  <ul id="SearchTags">
                    <li ng-show=" searchDetails[0].q">
                      <span  >
                        <div>
                          @{{searchDetails[0].q}}
                          <a ng-click="removeTag('q', 'v')" class="removetag">x</a>
                        </div>
                      </span>
                    </li>
                    <li  ng-show=" searchDetails[0].company_name ">
                      <span>
                        <div>
                          @{{searchDetails[0].company_name}}
                          @{{v}}
                          <a ng-click="removeTag('company_name', 'v')" class="removetag">x</a>
                        </div>
                      </span>
                    </li>
                    <li ng-repeat="( key, value) in selectedParams" ng-show="value.length != 0 && key == 'role_type'">
                      <span ng-repeat="(k, v) in  value">
                        <div ng-repeat="type in job_types | filter: {id: v}:true">
                          @{{type.display_name}}
                          <a ng-click="removeTag(key, v)" class="removetag">x</a>
                        </div>
                      </span>
                    </li>
                    <li ng-repeat="( key, value) in selectedParams" ng-show="value.length != 0 && key == 'industry'">
                      <span ng-repeat="(k, v) in  value">
                        <div ng-repeat="type in industries | filter: {id: v}:true">
                          @{{type.display_name}}
                          <a ng-click="removeTag(key, v)" class="removetag">x</a>
                        </div>
                      </span>
                    </li>
                    <li ng-repeat="( key, value) in selectedParams" ng-show="value.length != 0 && key == 'sub_industry' ">
                      <span ng-repeat="(k, v) in value" >
                        <span ng-repeat="type in industries">
                          <div ng-repeat="subs in type.sub  | filter: {id: v}:true">
                            @{{subs.display_name}}
                            <a ng-click="removeTag(key, v)" class="removetag">x</a>
                          </div>
                        </span>
                       </span>
                    </li>
                    <li ng-repeat="( key, value) in selectedParams" ng-show="value.length != 0 && key == 'state'">
                      <span ng-repeat="(k, v) in  value">
                        <div ng-repeat="type in locations | filter: {id: v}:true">
                          @{{type.display_name}}
                          <a ng-click="removeTag(key, v)" class="removetag">x</a>
                        </div>
                      </span>
                    </li>
                    <li ng-repeat="( key, value) in selectedParams" ng-show="value.length != 0 && key == 'area' ">
                      <span ng-repeat="(k, v) in value" >
                         <span ng-repeat="states in locations">
                            <span ng-repeat="location in states.location">
                              <div ng-repeat="area in location.area  | filter: {id: v}:true">
                                @{{area.display_name}}
                                <a ng-click="removeTag(key, v)" class="removetag">x</a>
                              </div>
                            </span>
                         </span>
                       </span>
                    </li>
                    <li ng-show="selectedParams.min_salary != null && selectedParams.max_salary != null">
                      <div>
                        <span ng-show="selectedParams.min_salary != null ">@{{selectedParams.min_salary | nearestK}} - </span>
                        <span >@{{selectedParams.max_salary | nearestK }}</span>
                        <a ng-click="removeTag(['min_salary','max_salary' ], v)" class="removetag">x</a>
                      </div>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div id="job-search-container" class="padb-60">
            <div class="container">
                <div class="row">
                    <div class="col-md-3">
                        <section class="job-filter-section">
                          <h2 class="tertiary-title job-filter__title">Search Filters</h2>
                          <ul class="job-filter__main-list">
                            <li class="job-filter__main-item" ng-class="{'active': selectedMainFilter}">
                              <a class="job-filter__subtitle" ng-click="selectedMainFilter = !selectedMainFilter">
                                <i class="fa fa-gear"></i>
                                <span>Classification</span>
                                <i class="fa fa-angle-down"></i>
                              </a>
                              <div class="tse-scrollable job-filter__scroll">
                                <ul id="menuLocation" class="job-filter__sub-list tse-content">
                                  <!-- Add Repeat -->
                                  <li ng-repeat="industry in industries" ng-class="{'activeitem': activeItem === industry.id }" class="job-filter__sub-item">
                                    <input checklist-model="selectedParams.industry" checklist-value="industry.id" class="filtercheckbox job-filter__sub-checkbox" id="industry_@{{industry.id}}" name="industry" type="checkbox" ng-click="uncheckSubs(industry.id, 'industry')"/>
                                    <label ng-click="filterIndustries( industry.id )" class="job-filter__sub-label">
                                      @{{industry.display_name}}
                                      <span ng-repeat="data in filter.industry | filter: {parent_id: industry.id}:true ">(@{{data.count}})</span>
                                      <span ng-show="(filter.industry|filter:{parent_id: industry.id}:true).length == 0">(0)</span>
                                    </label>
                                  </li>
                                </ul>
                              </div>
                            </li>
                            <li class="job-filter__main-item" ng-class="{'active': selectedMainFilter2}">
                              <a class="job-filter__subtitle" ng-click="selectedMainFilter2 = !selectedMainFilter2">
                                <i class="fa fa-clock-o"></i>
                                <span>Role Type</span>
                                <i class="fa fa-angle-down"></i>
                              </a>
                              <div class="job-filter__scroll tse-scrollable">
                                <ul id="menu2" class="job-filter__sub-list tse-content">
                                  <li ng-repeat="role_type in job_types" class="job-filter__sub-item">
                                    <div>
                                      <input checklist-model="selectedParams.role_type" checklist-value="role_type.id" id="role_type_@{{role_type.id}}" name="worktype" type="checkbox" class="filtercheckbox job-filter__sub-checkbox">
                                      <label for="role_type_@{{role_type.id}}" class="job-filter__sub-label">
                                        @{{role_type.display_name}}
                                      </label>
                                    </div>
                                  </li>
                                </ul>
                              </div>
                            </li>
                            <li class="job-filter__main-item" ng-class="{'active': selectedMainFilter3}">
                              <a class="job-filter__subtitle" ng-click="selectedMainFilter3 = !selectedMainFilter3">
                                <i class="fa fa-map-marker"></i>
                                <span>Location</span>
                                <i class="fa fa-angle-down"></i>
                              </a>
                              <div class="job-filter__scroll tse-scrollable">
                                <ul id="menuLocationC" class="job-filter__sub-list tse-content">
                                  <li ng-repeat="locationC in locationCountry" ng-class="{'activeitem': activeLocation === locationC.id, 'active': selectedSubFilter && locationC.code_slug_name == slug_loc}" class="job-filter__sub-item job-filter__sub-item--nz" ng-if="locationC.code_slug_name == 'nz'">
                                    <!--<input checklist-model="selectedParams.state" checklist-value="location.id" id="region_@{{locationC.id}}" name="location"  type="checkbox" class="filtercheckbox job-filter__sub-checkbox" ng-click="uncheckSubs(locationC.id, 'location')">-->
                                    <div ng-click="filterCountry(locationC.code_slug_name)" class="job-filter__sub-label">
                                      @{{locationC.display_name}}
                                      <span>(@{{locationC.total}})</span> <i class="fa fa-spinner fa-spin" ng-if="loadCountry"></i>
                                    </div>
                                    <i class="fa fa-angle-down"></i>

                                    <ul id="menuLocation" class="job-filter__sub-list tse-content" ng-if="locations && ((locationC.code_slug_name == slug_loc) && selectedSubFilter)">
                                      <li ng-repeat="location in locations" ng-class="{'activeitem': activeLocation === location.id}" class="job-filter__sub-item">
                                        <span class="job-filter__sub-label">
                                          <input checklist-model="selectedParams.state" checklist-value="location.id" id="region_@{{location.id}}" name="location"  type="checkbox" class="filtercheckbox job-filter__sub-checkbox" ng-click="uncheckSubs(location.id, 'location', locationC.code_slug_name)">
                                          @{{location.display_name}}
                                          <span>(@{{location.total}})</span>
                                        </span>

                                        <ul class="job-filter__sub-area-list tse-content" ng-if="locations && ((locationC.code_slug_name == slug_loc) && selectedSubFilter)">
                                          <li ng-repeat="area in location.location[0].area">
                                            <input checklist-model="selectedParams.area" checklist-value="area.id" id="city@{{area.id}}" name="region" type="checkbox" class="filtercheckbox" ng-click="FindParent(location.id,'location')">
                                            <span>@{{area.display_name}}</span>
                                            <span>(@{{area.total}})</span>
                                          </li>
                                        </ul>
                                      </li>
                                    </ul>
                                  </li>
                                  <li ng-repeat="locationC in locationCountry" ng-class="{'activeitem': activeLocation === locationC.id, 'active': selectedSubFilter && locationC.code_slug_name == slug_loc}" class="job-filter__sub-item" ng-if="locationC.code_slug_name != 'nz'">
                                    <!--<input checklist-model="selectedParams.state" checklist-value="location.id" id="region_@{{locationC.id}}" name="location"  type="checkbox" class="filtercheckbox job-filter__sub-checkbox" ng-click="uncheckSubs(locationC.id, 'location')">-->
                                    <div ng-click="filterCountry(locationC.code_slug_name)" class="job-filter__sub-label">
                                      @{{locationC.display_name}}
                                      <span ng-repeat="data in filter.state | filter: {parent_id: locationC.id}:true ">(@{{data.count}})</span>
                                      <span ng-show="(filter.state | filter: {parent_id: locationC.id}:true).length == 0">(0)</span> <i class="fa fa-spinner fa-spin" ng-if="loadCountry"></i>
                                    </div>
                                    <i class="fa fa-angle-down"></i>

                                    <ul id="menuLocation" class="job-filter__sub-list tse-content" ng-if="locations && ((locationC.code_slug_name == slug_loc && loadcity) && selectedSubFilter)">
                                      <li ng-repeat="location in locations" ng-class="{'activeitem': activeLocation === location.id}" class="job-filter__sub-item">
                                        <span class="job-filter__sub-label">
                                          <input checklist-model="selectedParams.state" checklist-value="location.id" id="region_@{{location.id}}" name="location"  type="checkbox" class="filtercheckbox job-filter__sub-checkbox" ng-click="uncheckSubs(location.id, 'location', locationC.code_slug_name)">
                                          @{{location.display_name}}
                                          <span>(@{{location.total}})</span>
                                        </span>

                                        <ul class="job-filter__sub-area-list tse-content" ng-if="locations && ((locationC.code_slug_name == slug_loc) && selectedSubFilter)">
                                          <li ng-repeat="area in location.location[0].area">
                                            <input checklist-model="selectedParams.area" checklist-value="area.id" id="city@{{area.id}}" name="region" type="checkbox" class="filtercheckbox" ng-click="FindParent(location.id,'location')">
                                            <span>@{{area.display_name}}</span>
                                            <span>(@{{area.total}})</span>
                                          </li>
                                        </ul>
                                      </li>
                                    </ul>
                                  </li>
                                </ul>
                              </div>
                            </li>
                            <li class="job-filter__main-item" ng-class="{'active': selectedMainFilter4}">
                              <a class="job-filter__subtitle" ng-click="selectedMainFilter4 = !selectedMainFilter4">
                                <i class="fa fa-dollar"></i>
                                <span>Salary</span>
                                <i class="fa fa-angle-down"></i>
                              </a>
                              <div class="tse-scrollable job-filter__scroll">
                                <ul class="job-filter__sub-list tse-content">
                                  <li class="job-filter__sub-item clear-float">
                                    <div class="slideholder">
                                      <h3 class="job-filter__sub-label">Salary Range</h3>
                                      <rzslider rz-slider-model="slider.minValue"
                                                rz-slider-high="slider.maxValue"
                                                rz-slider-options="slider.options">
                                      </rzslider>
                                    </div>
                                    <a href="" ng-click="UpdateSalary()" class="btn-pvm btn-primary btn-mini job-filter__range-btn">APPLY</a>
                                  </li>
                                </ul>
                              </div>
                            </li>
                          </ul>
                        </section>
                    <!-- <div class="Sidebar"></div> -->
                    </div><!-- eof col-md-3 -->
                    <div class="col-md-9" id="left-container">
                        <div class="ContainAllFilter">
                          <div class="row">
                            <div class="col-md-12">
                                <ul>
                                <li class="pull-right" id="filter_by">
                                  SORT BY
                                  <span class="glyphicon glyphicon-menu-down" id="caret_icon"></span>
                                  <ul class="filterOption dropdow" style="display:none">
                                    <li ng-click="SortJobSearch('job')"><a href="" >Job</a></li>
                                    <li ng-click="SortJobSearch( 'company' )"><a href="" >Employer</a></li>
                                  </ul>
                                </li>
                                </ul>
                                <div class="clearfix"></div>
                                <hr class="jobDivider">
                            </div>
                          </div>
                          <div class="row nojob">
                            <div class="col-md-12" ng-show="( jobSearch.results.jobs.length == 0 )"> No Jobs found</div>
                            <div class="col-md-12" ng-show="( jobSearch.results.companies.length == 0 && jobSearch.results.jobs.length == 0 )"> No Jobs and Company found. </div>
                          </div>
                          <div class="text-center splash " ng-show="jobSearch == 0">
                            <div class="cssload-container">
                              <h3>Please wait.</h3>
                              <h4>While we prepare the search results.</h4>
                              <div class="cssload-loading"><i></i><i></i><i></i><i></i></div>
                            </div>
                          </div>

                            <ul class="SearchedItems" ng-show="jobSearch != 0">
                            <!-- Jobs/Roles BEGIN -->
                            <li ng-style="jobstyle">
                              <div class="row jobList" ng-repeat="job in jobSearch.results.jobs.data" ng-show="( jobSearch.num_found != 0 )" ng-if="company.company_name != '' || company.company_name.length > 0">

                                <div class="col-md-2 text-center company_logo">
                                  <!-- <a data-ajax="false" href="{$BaseHref}job/listing/@{{job.object_id}}" class="text-xs-center"> --> <!-- Uncomment for live API call -->
                                    <a data-ajax="false" href="/job/listing/job-listing-sample" class="text-xs-center">
                                    <!-- <img ng-show="!job.company_logo_url" src="{$ThemeDir}/images/default_company_logo.png"  class="img-circle img-responsive JobCompany" width="120"> -->
                                    <div ng-show="(job.company_logo_url == false)" class="member-initials member-initials--lg @{{job.profile_color}}">@{{job.initial}}</div>
                                    <img ng-show="(job.company_logo_url != false)" ng-src="@{{job.company_logo_url}}" class="img-circle img-responsive"  width="120">
                                  </a>
                                </div>
                                <div class="col-md-10">
                                  <div class="row">
                                    <div class="col-md-9 text-xs-center">
                                      <div class="text-sm-center text-md-left  job_name">
                                        <!-- <a data-ajax="false" href="{$BaseHref}job/listing/@{{job.object_id}}"> --> <!-- Uncomment for live API call -->
                                        <a data-ajax="false" href="/job/listing/job-listing-sample">
                                        <small class="jobName">@{{job.job_title}}</small>
                                        </a>
                                      </div>
                                      <div ng-if="job.description[0]" class="jobShortDescription" ng-bind-html="job.description | cuts:true:300:'...' "></div>
                                      <div ng-if="!job.description[0]" class="jobShortDescription job-nodesc">
                                        No job description provided.
                                      </div>
                                     <!--  <div class="jobShortDescription" ng-bind-html="job.description[0]"></div> -->
                                      <div class="clearfix"></div>
                                      <div class="row jobsmaldeatils">
                                        <div class="col-md-12">
                                          <div class="pull-left jobSubDetails pvm-top5">
                                            <i class="job-search-icons job-search-address-icon pull-left"></i>
                                            @{{job.company_name}}
                                          </div>
                                          <div class="pull-left jobSubDetails pvm-top5" ng-show="job.location.display_name">
                                            <i class="job-search-icons job-search-marker-icon pull-left"></i>
                                            @{{job.location.display_name}}
                                          </div>
                                          <div class="pull-left jobSubDetails pvm-top5">
                                            <i class="job-search-icons job-search-calendar-icon pull-left"></i>
                                            @{{job.display_date}}
                                          </div>
                                          <div class="pull-left jobSubDetails pvm-top5">
                                            <i class="pull-left job-search-icons2 job-search-parttime-icon "></i>
                                            @{{job.role_type}}
                                          </div>
                                          <div class="pull-left jobSubDetails pvm-top5">
                                            <i class="pull-left job-search-icons2 job-search-salary-icon" ng-hide="job.salary_notes == '' "></i>
                                            @{{job.salary_notes}}
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="col-md-3 buttonCont">
                                      <div ng-repeat="seenjobs in seenJobs.jobs | filter: {object_id: job.object_id}:true "></div>
                                      <div class="watchlistbutton jobbtn  " ng-click="seen($event, job.object_id)"    data-obj-id="@{{job.object_id}}" ng-class="{'pvm-blue' : job.seen }"  >
                                        <i class="eye-caret glyphicon glyphicon-eye-open" ></i>
                                        <span ng-show="!job.seen">Watchlist</span>
                                        <span ng-show="job.seen">Watching</span>
                                      </div>
                                      <div class="shareJobbutton jobbtn" data-toggle="modal" data-target="#share_@{{job.object_id}}">
                                        <i class="ShareIco glyphicon"></i>
                                        Share Job
                                      </div>

                                      <div id="share_@{{job.object_id}}" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
                                        <div class="modal-dialog modal-sm shareMod" role="document">
                                          <div class="modal-content">
                                            <div class="container-fluid">
                                              <div class="text-center shareContainer">
                                                <h4>Where do you want to share <br> @{{job.job_title}} ( @{{job.object_id}} ) </h4>
                                                <a href="javascript:void(0)" id="@{{job.object_id}}" share-count socialshare socialshare-provider="twitter" socialshare-text="@{{job.job_title}} @ @{{job.company_name}}" socialshare-url="{$BaseHref}job/listing/@{{job.object_id}}" class="fa fa-twitter-square"></a>
                                                <a href="javascript:void(0)" id="@{{job.object_id}}" share-count socialshare="" socialshare-provider="facebook" socialshare-url="{$BaseHref}job/listing/@{{job.object_id}}" class="fa fa-facebook-square"></a>
                                                <a href="javascript:void(0)" id="@{{job.object_id}}" share-count socialshare socialshare-provider="linkedin" socialshare-text="@{{job.job_title}} @ @{{job.company_name}}" socialshare-url="{$BaseHref}job/listing/@{{job.object_id}}" class="fa fa-linkedin-square"></a>
                                                <a href="javascript:void(0)" id="@{{job.object_id}}" share-count socialshare socialshare-provider="email" socialshare-text="@{{job.job_title}} @ @{{job.company_name}}" socialshare-url="{$BaseHref}job/listing/@{{job.object_id}}" class="fa fa-envelope-square"></a>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                      </div>

                                      <div class="showJobbutton jobbtn" data-obj-id="@{{job.object_id}}"   ng-click="showDetail( $event, job.object_id)" >
                                        <i class="eye-caret glyphicon glyphicon-menu-down job@{{job.object_id}}" ></i>
                                        View Job
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <div class="content-column partjob@{{job.object_id}} hide partjob">
                                  <!-- job search template -->
                                  <div ng-include="jobSearchTemplate"></div>
                                  <div class="clearfix"></div>
                                  <div class="">
                                    <div class="showJobbutton jobbtn"   >
                                      <a data-ajax="false" href="/job/listing/job-listing-sample" target=_BLANK>
                                        <i class="glyphicon glyphicon-open"></i>
                                        View Full Job
                                      </a>
                                    </div>
                                  </div>
                                </div>
                                <div class="clearfix"></div>
                                <div class="col-md-12">
                                  <hr class="jobDivider">
                                </div>
                              </div>
                            </li>
                            <!-- Jobs/Roles END -->
                            <!-- Company/Employer BEGIN -->
                            <li ng-style="companystyle">
                              <div class="row CompanyList" ng-repeat="company in jobSearch.results.companies" ng-show="( jobSearch.results.companies.length != 0)" ng-if="company.company_name != '' || company.company_name.length > 0">
                                <div class="col-md-2 text-center company_logo">
                                  <!-- <a data-ajax="false" href="/company/previewme"> --> <!-- Uncomment for live API call -->
                                  <a data-ajax="false" href="/company/previewme">
                                    <!-- <img src="{$ThemeDir}/images/default_company_logo.png" ng-show="company.company_logo_url == ''" class="img-circle JobCompany img-responsive" width="120">  --><!-- IB -->
                                    <div ng-show="(company.company_logo_url == false)" class="member-initials member-initials--lg @{{company.profile_color}}">@{{company.initial}}</div>
                                    <img ng-src="@{{company.company_logo_url}}" ng-class="{'hide': !company.company_logo_url}" class="img-circle JobCompany img-responsive" width="120">
                                  </a>
                                </div>
                                <div class="col-md-10">
                                  <div class="row">
                                    <div class="col-md-9">
                                      <!-- <a data-ajax="false" href="{$BaseHref}company/@{{company.encode_company_url}}" class="pull-left"> -->  <!-- Uncomment for live API call -->
                                        <a data-ajax="false" href="/company/previewme" class="pull-left">
                                        <small class="jobName">
                                          @{{company.company_name}}
                                        </small>
                                      </a>
                                      <div class="itemType">Employer</div>
                                      <div class="clearfix"></div>
                                      <div class="jobShortDescription"  >
                                        @{{company.company_about_us | cut:true:300:'...'}}
                                      </div>

                                      <div class="clearfix"></div>
                                      <div class="row jobsmaldeatils">
                                        <div class="col-md-12">
                                          <div class="pull-left jobSubDetails">
                                            <i class="job-search-icons job-search-marker-icon pull-left"> </i>
                                            <span class="pull-left search-content search-content2">
                                              @{{company.location.display_name}}
                                            </span>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="col-md-3 buttonCont">
                                      <div id="comp_@{{company.id}}" class="watchlistbutton jobbtn  "  ng-click="follow(company.id)" >
                                        <span class="f_@{{company.id}}" style="display: none">Unfollow</span>
                                        <span class="uf_@{{company.id}}" style="display: block">Follow</span>
                                      </div>
                                      <div class="showJobbutton jobbtn ViewCompany"    >
                                        <!-- <a href="{$BaseHref}company/@{{company.company_url}}" data-ajax="false"> View Employer</a> --> <!-- Uncomment for live API call -->
                                        <a href="/company/previewme" data-ajax="false"> View Employer</a>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </li>
                            <!-- Company/Employer END -->
                            </ul>

                          <div class=" job-search-row" id="pagi-con" ng-show="( paginatelength.length != 0 )">
                            <div id="pagi-holder">
                              <a href="" ng-click="first( jobSearch.pagination.limit )" class="paginatebtn" ng-class="{'not-active': jobSearch.pagination.offset == 0}">&laquo;</a>
                              <a href="" ng-click="prev( jobSearch.pagination.limit )" class="paginatebtn" ng-class="{'not-active': jobSearch.pagination.offset == 0}">&lsaquo;</a>
                              <ul class="paginatejob">
                                <li ng-repeat="(val, key) in paginatelength" ng-if="((key + 3) >= jobSearch.pagination.offset)"><!-- jobSearch.pagination.limit -->
                                  <a href="" ng-click="gotooffset(   val + 1   ) " ng-class="activeClass( val + 1 )" >@{{val + 1}}</a>
                                </li>
                              </ul>
                              <a href="" ng-click="next(jobSearch.pagination.limit)" class="paginatebtn" ng-class="{'not-active': jobSearch.pagination.more_present == false}">&rsaquo;</a>
                              <a href="" class="paginatebtn" ng-click="last( jobSearch.num_found / jobSearch.pagination.limit,   jobSearch.pagination.limit )" ng-class="{'not-active': jobSearch.pagination.more_present == false}">&raquo;</a>
                            </div>
                          </div>
                        </div>
                    </div><!-- eof col-md-9 -->
                    <div class="clearfix"></div>
                </div><!-- eof row -->
            </div>    
        </div><!-- eof row -->
    </div>
</div>
@stop

@section('scripts')
<script type="text/javascript" src="js/minified/login/job-search.min.js"></script>
@stop