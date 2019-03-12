<div class="preview__handler" nng-if="companyDetails" ng-cloak>
    <div class="preview__banner" style="background-image: url(@{{companyDetails.company_banner_url}});"></div>
    <section class="preview__content clear-float">
      <div class="preview__left">
        <img ng-src="@{{companyDetails.logo_url}}" class="preview__logo">
        <div class="preview__summ">
          <h2 class="preview__company-name">@{{companyDetails.company_name}}</h2>
          <h3 ng-bind-html="empRoleMain.job_title" class="preview__industry">(job title)</h3>
          <p class="preview__employees">@{{companyDetails.industry.data.industry.display_name}}</p>
        </div>
  
        <!-- start: icons -->
        <div class="preview__summ">
              <!-- start: build-right-icons-con -->
             <div class="col-md-12 build-right-icons-con" style="margin-left:-25px">
                  <!-- start: job-listing-icon1.png (location) -->
                  <div class="build-right-icons" style="width:18%!important;">
                    <div class="image_con">
                      <img class="build-right-icon" ng-src="images/job-listing-icon1.png" />
                    </div>
                    <p>
                      <small>
                        <span ng-bind-html="roleLocationDisplay">,</span>
                      </small>
                    </p>
                  </div>
                  <!-- end: job-listing-icon1.png (location) -->
  
                  <!-- start: job-listing-icon2.png (is_salary_public) -->
                  <div class="build-right-icons" style="width:18%!important;" ng-show="roleCreate_watch.is_salary_public">
                    <div class="image_con">
                      <img class="build-right-icon" ng-src="images/job-listing-icon2.png" />
                    </div>
                     <p>
                         <small>$@{{salRangeMin.text}} to $@{{salRangeMax.text}}</small>
                    </p>
                  </div>
                  <!-- end: job-listing-icon2.png (is_salary_public) -->
  
                  <!-- start: job-listing-icon3.png (work hours) -->
                  <div class="build-right-icons" style="width:18%!important;">
                    <div class="image_con">
                      <img class="build-right-icon" ng-src="images/job-listing-icon3.png" />
                    </div>
                    <p>
                      <small ng-bind-html="createRoleWorkingHours">8:30 AM<span> - </span>5:00 PM</small>
                      <small ng-if="joblisting.flexible_hours == true">
                        Flexible
                      </small>
                    </p>
                  </div>
                  <!-- end: job-listing-icon3.png (work hours) -->
  
                  <!-- start: parttime.png (role type) -->
                  <div class="build-right-icons" style="width:18%!important;">
                    <div class="image_con">
                      <img class="build-right-icon" ng-src="images/icons/parttime.png" />
                    </div>
                    <p ng-bind-html="roleTypeSelDisplay"></p>
                  </div>
                  <!-- end: parttime.png (role type) -->
  
                  <!-- start: highpotential.png (experience) -->
                  <div class="build-right-icons" style="width:18%!important;">
                    <div class="image_con">
                      <img class="build-right-icon" ng-src="images/icons/highPotential.png" />
                    </div>
                    <p ng-bind-html="roleExperience"><small></small></p>
                  </div>
                  <!-- end: highpotential.png (experience) -->
  
                  <div class="clearfix"></div>
                </div>
              <!-- start: build-right-icons-con -->
        </div>
        <!-- end: icons -->
      </div>
      
      <!-- start: preview__left preview__left--dim -->
      <div class="preview__left preview__left--dim">
        <h3 class="preview__jobs-header">We are looking for</h3>
        <p ng-bind-html="previewDescR"></p>
  
        <!-- start: on a normal you'll get to... -->
        <div class="row preview-rc-list">
                <!-- start: preview-rc-list label -->
                <div class="col-md-5">
                  <b>On a normal day you'll get to...</b>
                </div>
                <!-- end: preview-rc-list label -->
  
                <!-- start: preview-rc-list list-item -->
                <div class="col-md-7">
                  <ul class="list-item">
                   <li ng-repeat="resp in roleCreate_watch.accountabilities">@{{resp.name}}</li>
                  </ul>
                </div>
                <!-- end: preview-rc-list list-item -->
          </div>
        <!-- end: on a normal you'll get to... -->
  
         <!-- start: We are looking for someone who / with... -->
        <div class="row preview-rc-list">
                <!-- start: preview-rc-list label -->
                <div class="col-md-5">
                  <b>We are looking for someone who/with...</b>
                </div>
                <!-- end: preview-rc-list label -->
  
                <!-- start: preview-rc-list list-item -->
                <div class="col-md-7">
                  <ul class="list-item">
                    <li ng-repeat="resp in roleCreate_watch.requirements">@{{resp.name}}</li>
                  </ul>
                </div>
                <!-- end: preview-rc-list list-item -->
          </div>
         <!-- end: We are looking for someone who / with... -->
  
       <!-- start: You will want to work with us because... -->
        <div class="row preview-rc-list">
                <!-- start: preview-rc-list label -->
                <div class="col-md-5">
                  <b>You will want to work with us because...</b>
                </div>
                <!-- end: preview-rc-list label -->
  
                <!-- start: preview-rc-list list-item -->
                <div class="col-md-7">
                  <ul class="list-item">
                    <li ng-repeat="resp in roleCreate_watch.objectives">@{{resp.name}}</li>
                  </ul>
                </div>
                <!-- end: preview-rc-list list-item -->
          </div>
         <!-- end: You will want to work with us because... -->
  
        <!-- start: Company Benefits -->
        <h3 class="preview__jobs-header" ng-show="roleCreate_watch.benefits.length > 0">Company Benefits</h3>
        <p ng-if="!roleCreate_watch.benefits"> No benefits provided.</p>
        <!-- start: company-benefits-include-->
          <div class="row preview-rc-list" style="margin-top:10%!important;"  ng-show="roleCreate_watch.benefits.length > 0">
                <!-- start: preview-rc-list label -->
                <div class="col-md-5">
                  <b>Company benefits include...</b>
                </div>
                <!-- end: preview-rc-list label -->
  
                <!-- start: preview-rc-list list-item -->
                <div class="col-md-7">
                  <ul class="list-item">
                     <li ng-repeat="resp in roleCreate_watch.benefits">@{{resp.name}}</li>
                  </ul>
                </div>
                <!-- end: preview-rc-list list-item -->
          </div>
        <!-- end: company-benefits-include-->
        <!-- end: Company Benefits -->
  
        <!-- start: considerations -->
        <h3 class="preview__jobs-header" ng-if="roleCreate_watch.search_helpers.flexible_working == 'Yes' || roleCreate_watch.search_helpers.part_time == 'Yes' || roleCreate_watch.search_helpers.above_salary_band == 'Yes' || roleCreate_watch.search_helpers.high_potential_less_experience == 'Yes'">Considerations</h3>
          <div class="row preview-rc-list" style="margin-top:10%!important;" ng-show="roleCreate_watch.search_helpers.flexible_working" ng-if="roleCreate_watch.search_helpers.flexible_working == 'Yes' || roleCreate_watch.search_helpers.part_time == 'Yes' || roleCreate_watch.search_helpers.above_salary_band == 'Yes' || roleCreate_watch.search_helpers.high_potential_less_experience == 'Yes'">
                <!-- start: preview-rc-list label -->
                <div class="col-md-5">
                  <b>We will consider...</b>
                </div>
                <!-- end: preview-rc-list label -->
  
                <!-- start: preview-rc-list list-item -->
                <div class="col-md-7">
                  <ul class="list-item">
                       <li ng-if="roleCreate_watch.search_helpers.flexible_working == 'Yes'">Flexible working</li>
                       <li ng-if="roleCreate_watch.search_helpers.part_time == 'Yes'">Part time</li>
                       <li ng-if="roleCreate_watch.search_helpers.above_salary_band == 'Yes'">Above salary</li>
                       <li ng-if="roleCreate_watch.search_helpers.high_potential_less_experience == 'Yes'">High potential, less experience</li>
                  </ul>
                </div>
        <!-- end: considerations -->
      </div>
      <!-- end: preview__left preview__left--dim -->
  
      <!-- start: preview__right -->
      <div class="preview__right">
  
       <!-- start: job listed holder -->
      <div id="job_listed_holder">
       <!-- start: job listed -->
        <div class="job_listed">
          <div>JOB LISTED</div>
          <div><p ng-bind-html="roleJobListed"></p></div>
        </div>
        <!-- end: job listed -->
  
        <div class="job_listed">
          <div>LISTING EXPIRES</div>
          <div>@{{role_dateexpiry}}</div>
        </div>
      </div>
       <!-- end: job listed holder -->
  
        <!-- start: for this job you will need -->
         <div id="job_you_need_holder" style="margin-top:15px;">
                    <div class="job_listed">
                      <p>FOR THIS JOB YOU WILL NEED:</p>
                      <ul class="padding-l-zero">
                        <!-- start: profile-video -->
                        <li>
                          <i class="glyphicon glyphicon-ok " ng-show="roleCreate_watch.application_requirements.icebreaker_video == 'yes'" ng-if="roleCreate_watch.application_requirements.icebreaker_video == 'yes'"></i>
                          <i class="glyphicon glyphicon-remove " ng-show="roleCreate_watch.application_requirements.icebreaker_video === 'no' || !roleCreate_watch.application_requirements.icebreaker_video"></i>
                          <span class="requirement-content">Profile Video</span>
                        </li>
                        <!-- end: profile-video -->
  
                        <!-- start: about me -->
                        <li>
                          <i class="glyphicon glyphicon-ok" ng-show="roleCreate_watch.application_requirements.about_me === 'yes'"></i>
                          <i class="glyphicon glyphicon-remove" ng-show="roleCreate_watch.application_requirements.about_me === 'no' || !roleCreate_watch.application_requirements.about_me"></i>
                          <span class="requirement-content">About Me</span>
                        </li>
                        <!-- end: about me -->
  
                        <!-- start: porfolio -->
                        <li>
                          <i class="glyphicon glyphicon-ok " ng-show="roleCreate_watch.application_requirements.portfolio === 'yes'"></i>
                          <i class="glyphicon glyphicon-remove " ng-show="roleCreate_watch.application_requirements.portfolio === 'no' || !roleCreate_watch.application_requirements.portfolio"></i>
                          <span class="requirement-content">Portfolio</span>
                        </li>
                        <!-- end: porfolio -->
  
                        <!-- start: references -->
                        <li>
                          <i class="glyphicon glyphicon-ok " ng-show="roleCreate_watch.application_requirements.references === 'yes'"></i>
                          <i class="glyphicon glyphicon-remove " ng-show="roleCreate_watch.application_requirements.references === 'no' || !roleCreate_watch.application_requirements.references"></i>
                          <span class="requirement-content">References</span>
                        </li>
                        <!-- end: references -->
  
                        <!-- start: education -->
                        <li>
                          <i class="glyphicon glyphicon-ok " ng-show="roleCreate_watch.application_requirements.education === 'yes'"></i>
                          <i class="glyphicon glyphicon-remove " ng-show="roleCreate_watch.application_requirements.education === 'no' || !roleCreate_watch.application_requirements.education"></i>
                          <span class="requirement-content">Education</span>
                        </li>
                        <!-- end: education -->
  
                        <!-- start: work experience -->
                        <li>
                          <i class="glyphicon glyphicon-ok " ng-show="roleCreate_watch.application_requirements.work_experience === 'yes'"></i>
                          <i class="glyphicon glyphicon-remove " ng-show="roleCreate_watch.application_requirements.work_experience === 'no' || !roleCreate_watch.application_requirements.work_experience"></i>
                          <span class="requirement-content">Work History/Experience</span>
                        </li>
                        <!-- end: work experience -->
  
                        <!-- start: resume -->
                        <li>
                          <i class="glyphicon glyphicon-ok " ng-show="roleCreate_watch.application_requirements.resume === 'yes'"></i>
                          <i class="glyphicon glyphicon-remove " ng-show="roleCreate_watch.application_requirements.resume === 'no' || !roleCreate_watch.application_requirements.resume"></i>
                          <span class="requirement-content">Resume</span>
                        </li>
                        <!-- end: resume -->
  
                        <!-- start: transcript -->
                        <li>
                          <i class="glyphicon glyphicon-ok " ng-show="roleCreate_watch.application_requirements.transcript === 'yes'"></i>
                          <i class="glyphicon glyphicon-remove " ng-show="roleCreate_watch.application_requirements.transcript === 'no' || !roleCreate_watch.application_requirements.transcript"></i>
                          <span class="requirement-content">Transcript</span>
                        </li>
                        <!-- end: transcript -->
  
                        <!-- start: cover letter -->
                        <li>
                          <i class="glyphicon glyphicon-ok " ng-show="roleCreate_watch.application_requirements.cover_letter === 'yes'"></i>
                          <i class="glyphicon glyphicon-remove " ng-show="roleCreate_watch.application_requirements.cover_letter === 'no' || !roleCreate_watch.application_requirements.cover_letter"></i>
                          <span class="requirement-content">Cover Letter</span>
                        </li>
                        <!-- end: cover letter -->
                      </ul>
                    </div>
            </div>
            <!-- end: for this job you will need -->
      
      </div>
      <!-- end: preview__right -->
    </section>
  </div>