<template>
  <div class="Candidate dashboard">
    <main id="CandidateDashboard" class="pvm-dashboard pvm-dashboard--candidate clear-float">
      <CandidateSidebar />
      <!-- start: dashboard section -->
      <section class="dash-right">
          <div class="row">
              <div class="col-md-12">

                <!-- start: profile-privacy | salutations | search -->
                <section class="dash-content dash-content--top">
                    <div class="row no-marginlr">
                        <div class="col-md-5 no-pad-lr">
                          <!-- start: salutations -->
                          <div v-show="salutation" class="dash-greetings">
                            <h3 class="dash__hi">Hi {{ candidateProfile.first_name }}!</h3>
                            <q class="dash__quote">{{ salutation.message }}</q>
                            <address class="dash__speaker">{{ salutation.author }}</address>
                            <img class="logo" src="images/footer-logo.png" />
                          </div>
                          <!-- end: salutations -->          
                        </div>
                        <div class="col-md-7 no-pad-lr">
                          <!-- start: search -->
                          <div id="NewHomeSearchContainer" class="row  dash-search">
                            <!-- start: search for role label -->
                            <div class="col-md-12">
                              <h4 class="pvm__title">Search for a role or an employer</h4>
                            </div>
                            <!-- end: search for role label -->
                            <!-- start: search box -->
                            <div class="col-md-12">
                              <div class="row">
                                <div class="container-fluid">
                                  <!-- start: keywords & classification input -->
                                  <div class="row">
                                    <!-- start: keywords input -->
                                    <div class="col-md-6">
                                      <input type="text" placeholder="Keywords" name="keywords" class="homesearchfield"/>
                                    </div>
                                    <!-- end: keywords input -->
                                    <!-- start: classification -->
                                    <div id="CassificationCont" class="col-md-6">
                                      <div class="togglethis homesearchfield">
                                        Classification
                                        <span class="caret"></span>
                                      </div>
                                      <!-- start: classification dropdown -->
                                      <div id="ClassificationMain" class="row">
                                        <!-- start: col-md-12 -->
                                        <div class="col-md-12" @mouseleave="hideSubClassifications();">
                                          <!-- start: select-classifications -->
                                          <div
                                            class="col-md-6 industry_multi_main"
                                            style="overflow-y: scroll"
                                            @mouseover="showSubClassifications();"
                                          >
                                            <!-- start: select classifications -->
                                            <div class="col-md-12 industry_title_top">SELECT CLASSIFICATIONS</div>
                                            <!-- end: select classifications -->
                                            <!-- start: classifications list div -->
                                            <div
                                              id="Classification"
                                              class="industry_multi_holder sliderContainer tse-scrollable"
                                            >
                                              <!-- start: classification -->
                                              <div id="ClassificationCont" class="tse-content">
                                                <!-- start: classification ul -->
                                                <ul class="industry_multi">
                                                  <!-- start: classification list -->
                                                  <li v-for="industry in industriesData" :key="industry.id" class="all_industry" @mouseover="hoverClassification(industry.sub);">
                                                    <label>
                                                      <input :value="industry.id" v-model="industries" type="checkbox" @click="checkUncheckAllSubClassifications(industry);"/>
                                                      {{ industry.display_name }}
                                                    </label>
                                                    <div class="clearfix"></div>
                                                  </li>
                                                  <!-- end: classification list -->
                                                </ul>
                                                <!-- end: classification ul -->
                                              </div>
                                              <!-- end: classification -->
                                            </div>
                                            <!-- end: classifications list div -->
                                          </div>
                                          <!-- end: classifications list div -->
                                          <!-- start: all sub-classifications -->
                                          <div id="sub-classification-col" class="col-md-6 subindustry_multi_main visi" style="overflow-y: scroll">
                                            <!-- start: sub classifications label -->
                                            <ul class="all_sub_checked_holder">
                                              <li><label style="width:190px">ALL SUB-CLASSIFICATIONS</label></li>
                                            </ul>
                                            <!-- start: sub classifications label -->
                                            <!-- start: sub industry div -->
                                            <div class="sub_industry_holder sliderContainer tse-scrollable">
                                              <!-- start: sub industry content -->
                                              <ul class="sub_industry_multi tse-content">
                                                <li v-for="subIndustry in subIndustries" :key="subIndustry.id">
                                                  <label>
                                                    <input :value="subIndustry.id" v-model="subIndustriesSelected" type="checkbox" />
                                                    {{ subIndustry.display_name }}
                                                  </label>
                                                  <div class="clearfix"></div>
                                                </li>
                                              </ul>
                                              <!-- end: sub industry content -->
                                            </div>
                                            <!-- end: sub industry div -->
                                          </div>
                                          <!-- end: all sub-classifications -->
                                        </div>
                                        <!-- end: col-md-12 -->
                                      </div>
                                      <!-- end: classification dropdown -->
                                    </div>
                                    <!-- end: classification -->
                                  </div>
                                  <!-- end: keywords & classification input -->

                                  <!-- start: location & search btn -->
                                  <div class="row">
                                    <!-- start: location input -->
                                    <div class="col-md-6">
                                      <select name="location_filter" data-live-search="true" data-width="100%" title="Location" />
                                    </div>
                                    <!-- end: location input -->
                                    <!-- start: search button -->
                                    <div class="col-md-6">
                                      <a href="" target="_blank" class="btn-pvm btn-secondary search-link">Search</a>
                                    </div>
                                    <!-- end: search button -->
                                  </div>
                                  <!-- end: location & search btn -->

                                  <!-- start: home new filter -->
                                  <div id="HomeNewFilter" class="row">
                                    <!-- start: col-md-12 -->
                                    <div class="col-md-12 padb-30">
                                      <hr />
                                      <!-- start: moreFilterContainer -->
                                      <div class="moreFilterContainer">
                                        <!-- start: more filters + -->
                                        <a v-show="filterButton" id="moreFilter" role="button" class="pvm__link" @click=" filterButton = false; toggleFilterDisplay = 'block';">
                                          <span>More filters +</span>
                                        </a>
                                        <!-- end: more filters + -->
                                        <!-- start: Hide filters -->
                                        <a v-show="!filterButton" id="hideFilter" role="button" class="pvm__link" @click=" filterButton = true; toggleFilterDisplay = 'none';">
                                          <span>Hide filters -</span>
                                        </a>
                                        <!-- end: Hide filters -->
                                      </div>
                                      <!-- end: moreFilterContainer -->
                                      <!-- start: toggleFilter -->
                                      <div id="toggleFilter" :style="{ display: toggleFilterDisplay }">
                                        <!-- start: work type filter container -->
                                        <div class="row FilterContainer">
                                          <!-- start: work type label -->
                                          <div class="col-md-2 padb-10"><h5>Work type</h5></div>
                                          <!-- end: work type label -->
                                          <!-- start: work-type-content -->
                                          <div class="col-md-10">
                                            <!-- start: work-types -->
                                            <ul id="WorkTypeList" class="list-inline">
                                              <!-- start: work-types list -->
                                              <li v-for="workType in workTypes" :key="workType.id">
                                                <!-- start: work type radio -->
                                                <div class="checkbox">
                                                  <label>
                                                    <input type="checkbox" name="work_types_filter[]" />
                                                    {{ workType.displayName }}
                                                  </label>
                                                </div>
                                                <!-- end: work type radio -->
                                              </li>
                                              <!-- end: work-types list -->
                                            </ul>
                                            <!-- end: work-types -->
                                          </div>
                                          <!-- end: work-type-content -->
                                        </div>
                                        <!-- end: work type filter container -->
                                        <!-- start: salary filter container -->
                                        <div class="row FilterContainer">
                                            <div class="col-md-2">
                                                <h5>Salary</h5>
                                            </div>
                                            <div class="col-md-10">
                                                <b style="margin-right:2.5%">$0k</b>
                                                <input id="salary_filter" type="text" /><b style="margin-left:2.5%">$200k</b>
                                            </div>
                                        </div>
                                        <div class="row FilterContainer">
                                            <div class="col-md-12">
                                                <a target="_blank" class="btn-pvm btn-primary btn-mini search-link2">Search</a>
                                                <a id="hideFilter" href="#" class="btn-pvm btn-default btn-mini cancel-link">Cancel</a>
                                            </div>
                                        </div>
                                        <!-- end: salary filter container -->
                                      </div>
                                      <!-- end: toggleFilter -->
                                    </div>
                                  </div>
                                  <!-- start: end new filter -->
                                </div>
                              </div>
                            </div>
                            <!-- end: search box -->
                          </div>
                          <!-- end: search -->            
                        </div>
                    </div>
                </section>
                <!-- end: profile-privacy | salutations | search -->  

              </div>
          </div>
          <div class="row">
              <div class="col-md-12">
                  
                <!-- start: your profile -->
                <section class="dash-content">
                  <div :class="{ 'dash-portlet--hide': yourProfileCard.hide }" class="pvm__portlet dash-profile">
                    <!-- start: your profile label -->
                    <h1 class="portlet__header portlet__header--nav">
                      Your Profile
                      <span angle-accordion="" type="follow">
                        <i v-if="yourProfileCard.accordion" class="fas fa-caret-up pvm-accordion" @click="yourProfileCard.hide = true; yourProfileCard.accordion = false;" />
                        <i v-else class="fas fa-caret-down pvm-accordion" @click="yourProfileCard.hide = false; yourProfileCard.accordion = true;" />
                      </span>
                    </h1>
                    <!-- end: your profile label -->

                    <!-- start: profile-content -->
                    <!-- #####################################
                    Remove "hidden" class. This one is dynamic 
                    ########################################-->

                    <div class="portlet__content hidden">
                      <!-- start: profile left pane -->
                      <section class="profile-left-pane">
                        <a href="my-profile" class="pvm__link profile__view">View</a>
                      </section>
                      <!-- end: profile left pane -->
                      <!-- start: profile right pane -->
                      <section class="profile-right-pane" style="margin-top:-1%;">
                        <!-- start: profile details -->
                        <div class="profile-details">
                          <h1 class="pvm__subheader profile__name">
                            {{ candidateProfile.first_name }} {{ candidateProfile.last_name }}
                          </h1>
                          <p class="profile__email">{{ candidateProfile.email }}</p>
                          <!-- start: about me -->
                          <p class="profile__about-me">
                            {{ candidateProfile.long_description.substring(0, 180) }}
                            <span v-if="candidateProfile.long_description.length > 180">...</span>
                          </p>
                          <!-- end: about me -->
                        </div>
                        <!-- end: profile details -->
                        <!-- start: spacing -->
                        <div class="profile-details profile-details--view" />
                        <div class="profile-details profile-details--view" />
                        <!-- end: spacing -->
                        <!-- start: profile request -->
                        <div class="profile-details profile-details--tablet" v-show="profileRequests.data.length > 0">
                          <h4 class="pvm__subheader profile__title">Profile Requests</h4>
                          <p class="profile__desc">
                            These companies have requested to view your PreviewMe profile.
                          </p>
                          <!-- start: profile request list -->
                          <ul class="profile-request-list">
                            <!-- start: profile request item -->
                            <li v-for="(profileRequest, index) in profileRequests.data" :key="profileRequest.id" class="profile-request__item">
                              <!-- start: profile request details -->
                              <a :href="'company/' + profileRequest.company_url">
                                <!-- start: profile request image -->
                                <img v-if="profileRequest.logo_url" :src="profileRequest.logo_url" class="request__company-logo" />
                                <div v-else :class="profileRequest.default_image.profile_color" class="member-initials request__company-logo">
                                  {{ profileRequest.default_image.initials }}
                                </div>
                                <!-- end: profile request image -->
                                <span class="request__company-name">{{ profileRequest.company_name }}</span>
                              </a>
                              <!-- end: profile request details -->
                              <!-- start: approve/disapprove -->
                              <!-- start: disapparove -->
                              <button type="button" class="btn-pvm btn-danger btn-square request__btn" @click="approveDisapproveProfileRequestApi(profileRequest.id, false, index);">
                                <i class="fa fa-times" />
                              </button>
                              <!-- end: disapprove -->
                              <!-- start: approve -->
                              <button type="button" class="btn-pvm btn-primary btn-square request__btn" style="border: 1px solid #007ed5 !important;" @click="approveDisapproveProfileRequestApi(profileRequest.id, true, index);">
                                  <i class="fa fa-check" />
                              </button>
                              <!-- end: approve -->
                              <!-- end: approve/disapprove -->
                            </li>
                            <!-- end: profile request item -->
                            <!-- start: view more -->
                            <button v-show="profileRequests.meta.current_page < profileRequests.meta.last_page" type="button" class="btn btn-link" @click="callCandidateProfileRequestApi(profileRequests.links.next);">
                              View more...
                            </button>
                            <!-- end: view more -->
                            <!--
                                <li class="profile-request__item">
                                <p class="profile__desc">Successfully Added.</p>
                                </li>
                            -->
                          </ul>
                          <!-- end: profile request list -->
                          <!-- start: buttons -->
                          <a href="my-profile" target="_blank" class="btn-pvm btn-primary btn-mini profile__edit-btn">View page</a>
                          <a href="my-profile/edit" target="_blank" class="btn-pvm btn-secondary btn-mini profile__edit-btn">Add/edit information</a>
                          <!-- end: buttons -->
                        </div>
                        <!-- end: profile request -->
                      </section>
                      <!-- end: profile right pane -->
                    </div>

                    <!-- #################################
                    This is static data
                    ####################################-->

                    <div class="portlet__content">
                        <div class="row no-marginlr">
                            <div class="col-lg-8">
                                <section class="profile-left-pane padb-30">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="profile-views">
                                              <div class="count"><p>32</p></div>
                                              <p>Profile Views</p>
                                            </div>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="profile-details profile-info">
                                                <div class="profile-pic">
                                                  <img class="profile__photo" src="https://pvmlive.blob.core.windows.net/c80qrmqr/solon.png"> 
                                                  <!-- <a href="my-profile" class="pvm__link profile__view">View</a> -->
                                                </div>
                                                <aside>
                                                  <h1 class="pvm__subheader profile__name">Solon Swaniawski</h1>
                                                  <p class="profile__email">destinee74@yahoo.com</p>
                                                  <p class="profile__about-me">Qui omnis suscipit sint quas ab quas ex. Nemo dolor est et ea quia qui qui. Culpa nobis accusamus pariatur incidunt. Cumque consectetur ab iste vitae. Dolores tempora est autem rat <span>...</span></p>
                                                </aside>
                                            </div>        
                                        </div>
                                    </div>
                                </section>        
                            </div><!-- eof row -->
                            <div class="col-lg-4">
                                <section class="profile-right-pane" style="margin-top: -1%;">  
                                    <div class="profile-details profile-details--tablet" style="">
                                        <h4 class="pvm__subheader profile__title">Profile Requests</h4>
                                        <p class="profile__desc">These companies have requested to view your PreviewMe profile.</p>
                                        <ul class="profile-request-list">
                                            <li class="profile-request__item">
                                                <a href="company/gutkowski-llc">
                                                <div class="member-initials request__company-logo member-initials--pvm-green">
                                                    GLLC
                                                </div><span class="request__company-name">Gutkowski LLC</span></a> <button class="btn-pvm btn-danger btn-square request__btn" type="button"><i class="fa fa-times"></i></button> <button class="btn-pvm btn-primary btn-square request__btn" style="border: 0;" type="button"><i class="fa fa-check"></i></button>
                                            </li>
                                            <li class="profile-request__item">
                                                <a href="company/schaden-ltd">
                                                <div class="member-initials request__company-logo member-initials--sky">
                                                    SL
                                                </div><span class="request__company-name">Schaden Ltd</span></a> <button class="btn-pvm btn-danger btn-square request__btn" type="button"><i class="fa fa-times"></i></button> <button class="btn-pvm btn-primary btn-square request__btn" style="border: 0;" type="button"><i class="fa fa-check"></i></button>
                                            </li>
                                            <li class="profile-request__item">
                                                <a href="company/klein-beer-and-cole">
                                                <div class="member-initials request__company-logo member-initials--sky">
                                                    KBC
                                                </div><span class="request__company-name">Klein, Beer and Cole</span></a> <button class="btn-pvm btn-danger btn-square request__btn" type="button"><i class="fa fa-times"></i></button> <button class="btn-pvm btn-primary btn-square request__btn" style="border: 0;" type="button"><i class="fa fa-check"></i></button>
                                            </li>
                                            <li class="profile-request__item">
                                                <a href="company/lind-plc">
                                                <div class="member-initials request__company-logo member-initials--pvm-green">
                                                    LPLC
                                                </div><span class="request__company-name">Lind PLC</span></a> <button class="btn-pvm btn-danger btn-square request__btn" type="button"><i class="fa fa-times"></i></button> <button class="btn-pvm btn-primary btn-square request__btn" style="border: 0;" type="button"><i class="fa fa-check"></i></button>
                                            </li>
                                            <li class="profile-request__item">
                                                <a href="company/greenholt-bradtke-and-fahey">
                                                <div class="member-initials request__company-logo member-initials--pvm-red">
                                                    GBF
                                                </div><span class="request__company-name">Greenholt, Bradtke and Fahey</span></a> <button class="btn-pvm btn-danger btn-square request__btn" type="button"><i class="fa fa-times"></i></button> <button class="btn-pvm btn-primary btn-square request__btn" style="border: 0;" type="button"><i class="fa fa-check"></i></button>
                                            </li>
                                            <!-- <li style="list-style: none"><button class="btn btn-link" style="" type="button">View more...</button></li> -->
                                        </ul>
                                        <div class="text-center">
                                          <ul class="pagination">
                                            <li><a href="#" class="active">1</a></li>
                                            <li><a href="#">2</a></li>
                                            <li><a href="#">3</a></li>
                                            <li><a href="#">4</a></li>
                                            <li><a href="#">5</a></li>
                                          </ul>
                                        </div>
                                    </div>
                                </section>        
                            </div>
                        </div><!-- eof row -->
                        <div class="row no-marginlr">
                            <div class="col-md-12">
                                <section class="profile-bottom-pane">
                                  <div class="wrap">
                                    <div class="view-status">
                                      <p>Video Views: <span>28</span></p>
                                      <!-- Status should only either be Private or Public. -->
                                      <p>Status: <span>Private</span></p>
                                    </div>
                                    <div>
                                      <a class="btn-pvm btn-primary btn-mini profile__edit-btn" href="my-profile" target="_blank">View page</a> 
                                      <a class="btn-pvm btn-secondary btn-mini profile__edit-btn" href="my-profile/edit" target="_blank">Add/edit information</a>
                                    </div>
                                  </div>
                                </section>        
                            </div>
                        </div><!-- eof row -->
                    </div>
                    <!-- end: profile-content -->

                    <!-- start: profile privacy -->
                    <div class="dash-profile-privacy">
                        <div class="row no-marginlr">
                            <div class="col-md-12">
                              <i class="fa fa-exclamation-circle" />
                              <p v-if="candidateProfile" class="profile__privacy-msg">
                                Profile is
                                <span v-if="candidateProfile.privacy.type === 'public'" class="profile__msg-bold">searchable</span>
                                <span v-else class="profile__msg-bold">not searchable</span> on PreviewMe, people outside of PreviewMe can
                                <span v-if="candidateProfile.privacy.type === 'public'" class="profile__msg-bold">view</span>
                                <span v-else class="profile__msg-bold">not view</span> your profile, and your profile
                                <span v-if="candidateProfile.privacy.settings.seo_enabled" class="profile__msg-bold">is</span>
                                <span v-else class="profile__msg-bold">is not</span> searchable on search engines.
                              </p>
                              <p v-else class="profile__privacy-msg">Please wait..</p>          
                            </div>
                        </div><!-- eof row -->
                    </div>
                    <!-- end: profile privacy -->
                    <div class="clearfix"></div>
                  </div>
                </section>
                <!-- end: your profile -->  
                  
              </div>
          </div>
          <div class="row">
              <div class="col-md-12">

                <!-- start: companies-you-follow -->
                <section class="dash-content grid2x3">
                    
                  <!-- start: companies you follow card -->
                  <div :class="{ 'dash-portlet--hide': companyFollowCard.hide }" class="pvm__portlet dash-follow grid2x3__row1-col1">
                      <!-- start: company you follow label -->
                      <h2 class="portlet__header">
                        Companies you follow
                        <!-- start: company-you-follow icon angle up/down -->
                        <span angle-accordion="" type="follow">
                          <i v-if="companyFollowCard.accordion" class="fas fa-caret-up pvm-accordion" 
                            @click=" companyFollowCard.hide = true; companyFollowCard.show = false; companyFollowCard.accordion = false; hasProfileCompletion.full = false;" />
                          <i v-else class="fas fa-caret-down pvm-accordion" @click="companyFollowCard.hide = false; companyFollowCard.show = true; companyFollowCard.accordion = true; hasProfileCompletion.full = true;"/>
                        </span>
                        <!-- end: company-you-follow icon angle up/down -->
                      </h2>
                      <!-- end: company you follow label -->
                      <!-- start: company-you-follow card -->
                      <div class="portlet__content">
                        <!-- start: company-list -->
                        <ul class="follow-companies-list">
                          <!-- start: company you follow card -->
                          <li v-for="company in companyFollow.data" v-show="companyFollow.data" :key="company.id" class="follow-companies__item">
                            <!-- start: company image -->
                            <a :href="'company/' + company.company_url">
                              <img v-if="company.logo_url" :src="company.logo_url" :title="company.company_name" class="follow__company-logo"/>
                              <div v-else :title="company.company_name" :class="company.default_image.profile_color" class="member-initials follow__company-logo">
                                {{ company.default_image.initials }}
                              </div>
                            </a>
                            <!-- end: company image -->
                          </li>
                          <!-- end: company you follow card -->
                          <!-- start: view more button -->
                          <li v-show="companyFollow.meta.current_page < companyFollow.meta.last_page" class="follow-companies__item follow-companies__item--remaining">
                            <button type="button" class="btn btn-link btn-lg" @click="callCompanyFollowApi(companyFollow.links.next);" >
                              (+{{ companyFollow.meta.total - companyFollow.meta.to }})
                            </button>
                          </li>
                          <!-- end: view more button -->
                        </ul>
                        <!-- end: company-list -->
                        <!-- start: company logs list -->
                        <ul v-if="companyLogs.data.length" id="companyLogs" class="follow-activities-list">
                          <li v-for="companyLog in companyLogs.data" :key="companyLog.id" class="follow-activities__item">
                            <p class="follow__activity">
                              <span class="follow__activity-bold follow__activity-bold--date">{{ companyLog.created_at }}</span>
                              {{ companyLog.company }} <span>posted a new listing for a </span>
                              <a :href="'job/listing/' + companyLog.job.object_id" class="follow__activity-bold follow__activity-bold--job">
                                {{ companyLog.job.job_title }}
                              </a>
                              | <a href="#" target="_blank">www.google.com</a> | <span>Location</span>
                            </p>
                          </li>
                        </ul>
                        <p v-else class="pvm__desc follow__activity">No logs available.</p>
                        <!-- start: view more button -->
                        <button
                          v-show="companyLogs.meta.current_page < companyLogs.meta.last_page"
                          type="button"
                          class="btn btn-link"
                          @click="callCompanyLogApi(companyLogs.links.next);"
                        >
                          View more...
                        </button>
                        <!-- end: view more button -->
                        <!-- end: company logs list -->
                      </div>
                      <!-- end: company-you-follow card -->
                  </div>
                    
                  <!-- ###########################################################

                    When Profile Completion is 100%, Add ".grid2x3__row2-col1-3" 
                    to make this div full width 

                    Note: It only applies to 2nd row

                  ############################################################ -->

                  <div :class="{ 'dash-portlet--hide': featuredForYouCard.hide, 'close-companiesyoufollow': companyFollowCard.hide }" class="pvm__portlet dash-feature dash-feature--partial grid2x3__row2-col1">
                    <!-- start: label -->
                    <h1 class="portlet__header">
                      Featured for you
                      <span angle-accordion="" type="follow">
                        <i v-if="featuredForYouCard.accordion" class="fas fa-caret-up pvm-accordion" 
                          @click=" featuredForYouCard.hide = true; featuredForYouCard.show = false; featuredForYouCard.accordion = false; hasProfileCompletion.onethird = false;"/>
                        <i v-else class="fas fa-caret-down pvm-accordion"
                          @click=" featuredForYouCard.hide = false; featuredForYouCard.show = true; featuredForYouCard.accordion = true; hasProfileCompletion.onethird = true;"/>
                      </span>
                    </h1>
                    <!-- end: label -->

                    <!-- start: content -->
                    <div class="portlet__content">
                      <h4 class="pvm__subheader dash__subheader">Pssst...</h4>
                      <p class="pvm__desc dash__desc">
                        Based on your profile as well as your applications to date, here are a few
                        opportunities that we don't want you to miss
                      </p>
                      <!-- start: list -->

                        <!--##############################################
                          REMOVE "feature-list-grid3" to have 2 columns 
                        ################################################-->

                        <ul
                          v-if="featuredForYouCard.show"
                          id="featureList"
                          class="pvm-video-list feature-list feature-list--grid3"
                        >
                        <!-- start: render list -->
                        <li
                          v-for="featuredJob in featuredJobs.data"
                          :key="featuredJob.job.object_id"
                          class="pvm-video__item feature__item"
                        >
                          <!-- start: banner -->
                          <div
                            v-if="featuredJob.company.banner_url"
                            :style="'background-image:url(' + featuredJob.company.banner_url + ')'"
                            class="feature__banner"
                          />
                          <div
                            v-else
                            class="feature__banner"
                            style="background-image: url(images/Default-Header.png)"
                          />
                          <!-- end: banner -->

                          <!-- start: company image -->
                          <img
                            v-if="featuredJob.company.logo_url"
                            :src="featuredJob.company.logo_url"
                            class="feature__company-logo"
                          />
                          <div
                            v-else
                            :class="featuredJob.company.default_image.profile_color"
                            class="member-initials feature__company-logo"
                          >
                            {{ featuredJob.company.default_image.initials }}
                          </div>
                          <!-- end: company image -->

                          <!-- start: details -->
                          <a :href="'job/listing/' + featuredJob.job.object_id" class="feature-details" target="_blank">
                            <div class="job__link">{{ featuredJob.job.title }}</div>
                            <div class="company__link" @click="'company/' + featuredJob.company.url;">
                              {{ featuredJob.company.name }}
                            </div>
                            <p class="job__label">{{ featuredJob.location }}</p>
                          </a>

                          <!-- start: hover of add to watchlist -->
                          <div class="feature-hover-details">
                            <!-- start: add to watchlist -->
                            <i
                              v-show="!featuredJob.job.watchlist"
                              class="fa"
                              @click="addToWatchList(featuredJob.job.id);"
                            >+</i>
                            <span v-show="!featuredJob.job.watchlist" class="pvm-video__watchlist-msg"
                              >Add to watchlist</span>
                            <!-- end: add to watchlist -->

                            <!-- start: successfully added -->
                            <i
                              v-show="featuredJob.job.watchlist"
                              class="fa fa-check"
                              @click="deleteToWatchList(featuredJob.job.id);"
                            />
                            <span v-show="featuredJob.job.watchlist" class="pvm-video__watchlist-msg"
                              >Successfully Added!</span
                            >
                            <!-- end: successfully added -->
                          </div>
                          <!-- end: hover of add to watchlist -->

                          <!-- end: details -->
                          <div class="pvm-video__cover" />
                        </li>
                        <!-- end: render list -->
                      </ul>
                      <p v-else>No featured list available.</p>
                      <!-- end: list -->
                      <!-- start: view more -->
                      <button
                        v-show="featuredJobs.meta.current_page < featuredJobs.meta.last_page"
                        type="button"
                        class="btn btn-link hidden"
                        @click="callJobFeaturedApi(featuredJobs.links.next);"
                      >
                        View more...
                      </button>
                      <!-- end: view more -->
                      <div class="text-center">
                        <ul class="pagination">
                          <li><a href="#" class="active">1</a></li>
                          <li><a href="#">2</a></li>
                          <li><a href="#">3</a></li>
                          <li><a href="#">4</a></li>
                          <li><a href="#">5</a></li>
                        </ul>
                      </div>
                    </div>
                    <!-- end: label -->
                  </div>
                    
                  <div class="dash-jobs grid2x3__row1-col2">
                    <!-- start: tabs -->
                    <ul class="pvm-tab-list dash-jobs-tab">
                      <!-- start: job applied tab -->
                      <li class="pvm-tab__item">
                        <button
                          :class="{
                            active:
                              jobApplicationTabs.active === jobAppliedSection.name ||
                              jobApplicationTabs.active === jobClosedDeclinedSection.name,
                          }"
                          class="pvm-tab__link"
                          @click="jobApplicationTabs.active = jobAppliedSection.name;"
                        >
                          Jobs Applied
                        </button>
                      </li>
                      <!-- end: job applied tab -->
                      <!-- start: watchlist tab -->
                      <li class="pvm-tab__item">
                        <button
                          :class="{ active: jobApplicationTabs.active === jobWatchlistSection.name }"
                          class="pvm-tab__link"
                          @click="jobApplicationTabs.active = jobWatchlistSection.name;"
                        >
                          Watchlist
                        </button>
                      </li>
                      <!-- end: watchlist tab -->
                    </ul>
                    <!-- end: tabs -->
                    <!-- start: jobs applied/watchlist/closed-declined section -->
                    <div class="pvm-tab-content dash-jobs-content">
                      <!-- start: jobs applied -->
                      <section
                        v-show="jobApplicationTabs.active === jobAppliedSection.name"
                        class="clear-float"
                      >
                        <!-- start: jobs applied list -->
                        <ul class="job-list">
                          <!-- end: jobs applied render list -->
                          <div v-if="jobsApplied.data.length > 0">
                            <li
                              v-for="jobApplied in jobsApplied.data"
                              :key="jobApplied.job_application.application_id"
                              class="job__item"
                            >
                              <!-- start: logo url -->
                              <img
                                v-if="jobApplied.company.logo_url"
                                :src="jobApplied.company.logo_url"
                                class="job__logo"
                              />
                              <div
                                v-else
                                :class="jobApplied.company.default_image.profile_color"
                                class="member-initials job__logo"
                              >
                                {{ jobApplied.company.default_image.initials }}
                              </div>
                              <!-- end: logo url -->

                              <!-- start: job details -->
                              <div class="job-details">
                                <a :href="'job/listing/' + jobApplied.job.object_id" class="job__link">{{
                                  jobApplied.job.job_title
                                }}</a>
                                <a :href="'company/' + jobApplied.company.url" class="company__link">{{
                                  jobApplied.company.name
                                }}</a>
                                <p class="job__date">
                                  <span class="job__label">Date applied: </span
                                  >{{ jobApplied.job_application.applied_date }}
                                </p>
                                <p class="job__date">
                                  <span class="job__label">Application status: </span
                                  >{{ jobApplied.job_application.app_status }}
                                </p>
                                <a
                                  :href="
                                    'my-job-applications/applied/' +
                                      jobApplied.job_application.application_id
                                  "
                                  target="_blank"
                                  class="btn-pvm btn-primary job__btn"
                                  >View my application</a
                                >
                              </div>
                              <!-- end: job details -->
                            </li>
                            <!-- start: view more -->
                            <!-- <button
                              v-show="jobsApplied.meta.current_page < jobsApplied.meta.last_page"
                              type="button"
                              class="btn btn-link"
                              @click="callJobsAppliedApi(jobsApplied.links.next);"
                            >
                              View more...
                            </button> -->
                            <div class="text-center">
                              <ul class="pagination">
                                <li><a href="#" class="active">1</a></li>
                                <li><a href="#">2</a></li>
                                <li><a href="#">3</a></li>
                                <li><a href="#">4</a></li>
                                <li><a href="#">5</a></li>
                              </ul>
                            </div>
                            <!-- end: view more -->
                          </div>
                          <!-- end: jobs applied render list -->
                          <li v-else class="job__item job__item--none">No job application available.</li>
                        </ul>
                        <!-- end: jobs applied list -->
                      </section>
                      <!-- end: jobs applied -->
                      <!-- start: watchlist -->
                      <section
                        v-show="jobApplicationTabs.active === jobWatchlistSection.name"
                        class="clear-float"
                      >
                        <!-- start: watchlist list -->
                        <div v-if="jobWatchlists.data.length > 0">
                          <ul class="job-list">
                            <li
                              v-for="jobWatchlist in jobWatchlists.data"
                              :key="jobWatchlist.job.object_id"
                              class="job__item"
                            >
                              <!-- start: logo url -->
                              <img
                                v-if="jobWatchlist.company.logo_url"
                                :src="jobWatchlist.company.logo_url"
                                class="job__logo"
                              />
                              <div
                                v-else
                                :class="jobWatchlist.company.default_image.profile_color"
                                class="member-initials job__logo"
                              >
                                {{ jobWatchlist.company.default_image.initials }}
                              </div>
                              <!-- end: logo url -->
                              <!-- start: job details -->
                              <div class="job-details">
                                <a
                                  :href="'job/listing/' + jobWatchlist.job.object_id"
                                  class="job__link"
                                  >{{ jobWatchlist.job.job_title }}</a
                                >
                                <a
                                  :href="'company/' + jobWatchlist.company.company_url"
                                  class="company__link"
                                  >{{ jobWatchlist.company.name }}</a
                                >
                                <p class="job__date">
                                  <span class="job__label">Expiration Date: </span>
                                  {{ jobWatchlist.job.expiry_date }}
                                </p>
                              </div>
                              <!-- end: job details -->
                            </li>
                            <!--
                              <li class="job__item job__item--none" ng-if="watchList.length <= 0">No watchlist
                                        available.</li>
                            -->
                          </ul>
                          <!-- start: view more -->

                          <!--####################################

                          I JUST ADD HIDDEN CLASS FOR DEMO PURPOSE 

                          #####################################-->

                          <button
                            v-show="jobWatchlists.meta.current_page < jobWatchlists.meta.last_page"
                            type="button"
                            class="btn btn-link hidden"
                            @click="callJobWatchlistApi(jobWatchlists.links.next);"
                          >
                            View more...
                          </button>
                          <div class="text-center">
                            <ul class="pagination">
                              <li><a href="#" class="active">1</a></li>
                              <li><a href="#">2</a></li>
                              <li><a href="#">3</a></li>
                              <li><a href="#">4</a></li>
                              <li><a href="#">5</a></li>
                            </ul>
                          </div>
                          <!-- end: view more -->
                        </div>
                        <!-- end: watchlist list -->
                        <p v-else>No watchlist available</p>
                      </section>
                      <!-- end: watchlist -->
                      <!-- start: closed-declined -->
                      <section
                        v-show="jobApplicationTabs.active === jobClosedDeclinedSection.name"
                        class="clear-float"
                      >
                        <!-- start: closed-declined list -->
                        <ul class="job-list hidden">
                          <div v-if="closedDeclinedJobs.data.length > 0">
                            <!-- start: closed-declined-render-list -->
                            <li
                              v-for="closedDeclinedJob in closedDeclinedJobs.data"
                              :key="closedDeclinedJob.job.object_id"
                              class="job__item"
                            >
                              <!-- start: images -->
                              <img
                                v-if="closedDeclinedJob.company.logo_url"
                                :src="closedDeclinedJob.company.logo_url"
                                class="job__logo"
                              />
                              <div
                                v-else
                                :class="closedDeclinedJob.company.default_image.profile_color"
                                class="member-initials job__logo"
                              >
                                {{ closedDeclinedJob.company.default_image.initials }}
                              </div>
                              <!-- end: images -->
                              <!-- start: job details -->
                              <div class="job-details">
                                <a
                                  :href="'job/listing/' + closedDeclinedJob.job.object_id"
                                  class="job__link"
                                  >{{ closedDeclinedJob.job.job_title }}</a
                                >
                                <a
                                  :href="'company/' + closedDeclinedJob.company.company_url"
                                  class="company__link"
                                  >{{ closedDeclinedJob.company.name }}</a
                                >
                              </div>
                              <!-- end: job details -->
                            </li>
                          </div>
                          <!-- end: closed-declined-render-list -->
                          <li v-else class="job__item job__item--none">
                            No declined or closed job available.
                          </li>
                        </ul>
                        <ul class="job-list">
                          <div>
                            <li class="job__item">
                              <div class="member-initials job__logo member-initials--pvm-yellow">DGH</div> 
                              <div class="job-details">
                                <a href="job/listing/JJO1OBMKM" class="job__link">Occupational Health Safety Technician</a>
                                <a href="company/undefined" class="company__link">Dickinson, Greenfelder and Homenick</a>
                                <p class="job__date"><span class="job__label">Date applied: </span>Mon, 12 Nov 2018</p>
                                <p class="job__date"><span class="job__label">Application status: </span>pending</p>
                                <a href="#" target="_blank" class="btn-pvm btn-primary job__btn">View my application</a>
                              </div>
                            </li>
                            <li class="job__item">
                              <div class="member-initials job__logo member-initials--pvm-purple">KZA</div>
                              <div class="job-details">
                                <a href="job/listing/J54GLOSM8" class="job__link">Health Technologist</a> 
                                <a href="company/undefined" class="company__link">Kuhic, Ziemann and Adams</a>
                                <p class="job__date"><span class="job__label">Date applied: </span>Mon, 12 Nov 2018</p>
                                <p class="job__date"><span class="job__label">Application status: </span>pending</p>
                                <a href="#" target="_blank" class="btn-pvm btn-primary job__btn">View my application</a>
                              </div>
                            </li>
                          </div>
                        </ul>
                        <!-- end: closed-declined list -->
                        <!-- start: view more -->

                        <!-- <button
                          v-show="
                            closedDeclinedJobs.meta.current_page < closedDeclinedJobs.meta.last_page
                          "
                          type="button"
                          class="btn btn-link"
                          @click="callClosedDeclinedJobApplicationApi(closedDeclinedJobs.links.next);"
                        >
                          View more...
                        </button> -->

                        <div class="text-center">
                            <ul class="pagination">
                            <li><a href="#" class="active">1</a></li>
                            <li><a href="#">2</a></li>
                            <li><a href="#">3</a></li>
                            <li><a href="#">4</a></li>
                            <li><a href="#">5</a></li>
                          </ul>
                        </div>
                        <!-- end: view more -->
                      </section>
                      <!-- end: closed-declined -->
                      <!-- start: links -->
                      <!-- start: see closed / past applications -->
                      <a
                        v-show="jobApplicationTabs.active === jobAppliedSection.name"
                        class="pvm__link application__link"
                        role="button"
                        @click="jobApplicationTabs.active = jobClosedDeclinedSection.name;"
                      >
                        See closed / past applications
                      </a>
                      <!-- end: see closed / past applications -->
                      <!-- start: see active applications -->
                      <a
                        v-show="jobApplicationTabs.active === jobClosedDeclinedSection.name"
                        class="pvm__link application__link"
                        role="button"
                        @click="jobApplicationTabs.active = jobAppliedSection.name;"
                      >
                        See active applications
                      </a>
                      <!-- end: see active applications -->
                      <!-- end: links -->
                    </div>
                    <!-- end: jobs applied/watchlist/closed-declined section -->
                  </div>
                    
                  <div class="pvm__portlet dash-profile-completion grid2x3__row2-col2">
                    <h4 class="portlet__header" style="margin-bottom: 0;">Profile Completion</h4>
                    <!-- start: note -->
                      <p class="completion__ai-note">
                        <i class="fa fa-exclamation-circle" /> Dramatically increase your visibility by
                        adding a recorded video profile
                      </p>
                      <!-- end: note -->
                    <!-- start: profile completion div -->
                    <div class="portlet__content profile-completion">
                      <!-- start: completion -->
                      <div class="completion-me hidden">
                        <!-- start: profile image -->
                        <img
                          v-if="candidateProfile.profile_image"
                          :src="candidateProfile.profile_image"
                          class="completion__photo"
                        />
                        <div
                          v-else
                          :class="candidateProfile.default_image.profile_color"
                          class="member-initials completion__photo"
                        >
                          {{ candidateProfile.default_image.initials }}
                        </div>
                        <!-- end: profile image -->

                        <!-- start: completion note -->
                        <div class="completion-my-note">
                          <a href="" class="pvm__link completion__name">{{
                            candidateProfile.first_name + ' ' + candidateProfile.last_name
                          }}</a>
                          <p class="completion__email">{{ candidateProfile.email }}</p>
                        </div>
                        <!-- end: completion note -->
                      </div>
                      <div class="completion-me"><img src="https://pvmlive.blob.core.windows.net/c80qrmqr/solon.png" class="completion__photo"> <div class="completion-my-note"><a href="" class="pvm__link completion__name">Solon Swaniawski</a> <p class="completion__email">destinee74@yahoo.com</p></div></div>
                      <!-- end: completion -->
                      <!-- start: profile completion list -->
                      <ul class="profile-completion-list">
                        <li class="profile-completion__item profile-completion__item--total">
                          <div
                            :class="
                              'pvm__donut' +
                                profileCompletion.completion +
                                ' pvm__md-donut profile__donut--total'
                            "
                          >
                            <div class="pvm__donut-chart interface__chart">
                              <div class="quad one" />
                              <div class="quad two" />
                              <div class="quad three" />
                              <div class="quad four" />
                              <div class="quad top" />
                              <div class="chart-center">
                                <span>{{ profileCompletion.completion }}%</span>
                              </div>
                            </div>
                          </div>
                        </li>
                        <!-- start: photo -->
                        <li
                          :class="{ 'profile-completion__item--done': profileCompletion.profile_image }"
                          class="profile-completion__item"
                        >
                          <i class="fa fa-user" />
                          <span class="pvm-phone-land-visible completion__label">Photo</span>
                        </li>
                        <!-- end: photo -->
                        <!-- start: profile video -->
                        <li
                          :class="{
                            'profile-completion__item--done': profileCompletion.icebreaker_video,
                          }"
                          class="profile-completion__item"
                        >
                          <i class="fa fa-video" />
                          <span class="pvm-phone-land-visible completion__label">Profile Video</span>
                        </li>
                        <!-- end: profile video -->
                        <!-- start: education -->
                        <li
                          :class="{ 'profile-completion__item--done': profileCompletion.education }"
                          class="profile-completion__item"
                        >
                          <i class="fa fa-graduation-cap" />
                          <span class="pvm-phone-land-visible completion__label">Education</span>
                        </li>
                        <!-- end: education -->
                        <!-- start: experience -->
                        <li
                          :class="{ 'profile-completion__item--done': profileCompletion.experience }"
                          class="profile-completion__item"
                        >
                          <i class="fa fa-briefcase" />
                          <span class="pvm-phone-land-visible completion__label">Experience</span>
                        </li>
                        <!-- end: experience -->
                      </ul>
                      <!-- end: profile completion list -->
                      <a
                        href=""
                        target="_blank"
                        class="btn-pvm btn-secondary btn-mini profile__edit-btn completion__btn"
                      >
                        Add / Edit Information</a
                      >
                    </div>
                    <!-- end: profile completion div -->
                  </div>

                  <div :class="{ 'dash-portlet--hide': companySuggestionsCard.hide, 'grid2x3__row3-col1-3': companyFollowCard.show && featuredForYouCard.show, 'close-companiesyoufollow': companyFollowCard.hide, 'close-featuredforyou': featuredForYouCard.hide,}" class="pvm__portlet dash-follow">
                    <!-- start: your profile label -->
                    <h1 class="portlet__header portlet__header--nav">
                      Suggested Companies
                      <span angle-accordion="" type="follow">
                        <i
                          v-if="companySuggestionsCard.accordion"
                          class="fas fa-caret-up pvm-accordion"
                          @click="
                            companySuggestionsCard.hide = true;
                            companySuggestionsCard.accordion = false;
                          "
                        />
                        <i
                          v-else
                          class="fas fa-caret-down pvm-accordion"
                          @click="
                            companySuggestionsCard.hide = false;
                            companySuggestionsCard.accordion = true;
                          "
                        />
                      </span>
                    </h1>
                    <!-- end: your profile label -->
                    <div class="portlet__content">
                      <!-- start: company suggestion -->
                        <h4 class="pvm__subheader dash__subheader">Pssst...</h4>
                        <p class="pvm__desc dash__desc">
                          Based on the companies you currently follow, here are a few additional suggestions
                          we think you may be interested in:
                        </p>

                        <!-- start: company suggestion card -->
                        <div v-if="companySuggestionsCard.show">
                          <ul
                            v-if="companySuggestions.data.length"
                            id="suggestsList"
                            class="pvm-video-list suggest-list grid3"
                          >
                            <!-- start: company suggestion list -->
                            <li
                              v-for="companySuggestion in companySuggestions.data"
                              :key="companySuggestion.id"
                              class="pvm-video__item suggest__item"
                            >
                              <!-- start: banner -->
                              <div v-if="!companySuggestion.company.video_url">
                                <div
                                  v-if="companySuggestion.company.banner_url"
                                  :style="
                                    'background-image: url(' + companySuggestion.company.banner_url + ')'
                                  "
                                  class="suggest__banner"
                                />
                                <div
                                  v-else
                                  class="suggest__banner"
                                  style="background-image: url(images/Default-Header.png)"
                                />
                              </div>
                              <!-- end: banner -->

                              <!-- start: video -->
                              <video
                                v-else
                                :id="'kabataan' + companySuggestion.company.id"
                                class="azuremediaplayer amp-default-skin suggest__video"
                                poster="images/video-preload.gif"
                                preload="none"
                                height="236"
                                width="100"
                              >
                                <source :src="companySuggestion.company.video_url" type="video/mp4" />
                              </video>
                              <!-- end: video -->

                              <!-- start: logo url -->
                              <a :href="'company/' + companySuggestion.company.url">
                                <img
                                  v-if="companySuggestion.company.logo_url"
                                  :src="companySuggestion.company.logo_url"
                                  class="suggest__company-logo"
                                />
                                <div
                                  v-else
                                  :class="companySuggestion.company.default_image.profile_color"
                                  class="member-initials suggest__company-logo"
                                >
                                  {{ companySuggestion.company.default_image.initials }}
                                </div>
                              </a>
                              <!-- end: logo url -->

                              <!-- start: details -->
                              <div class="suggest-details">
                                <a
                                  :href="'job/listing/' + companySuggestion.company.ob_key" class="suggest-details__link">
                                  <span class="job__link">{{ companySuggestion.company.name }}</span>
                                <p class="company__link">{{
                                  companySuggestion.industry
                                }}</p>
                                <p class="job__label">{{ companySuggestion.location }}</p>
                                </a>
                                <div class="suggest-hover-details">
                                  <i class="fa">+</i> 
                                  <span class="pvm-video__watchlist-msg">Follow</span> 
                                  <i class="fa fa-check" style="display: none;"></i> 
                                  <span class="pvm-video__watchlist-msg" style="display: none;">Successfully Followed!</span>
                                </div> 
                              </div>
                              <!-- end: details -->
                              <div class="pvm-video__cover" />
                            </li>
                            <!-- start: company suggestion list -->
                          </ul>
                          <p v-else class="suggest__item">No companies list available.</p>
                          <!-- start: view more -->
                          <button
                            v-show="companySuggestions.meta.current_page < companySuggestions.meta.last_page"
                            type="button"
                            class="btn btn-link hidden"
                            @click="callCompanySuggestionApi(companySuggestions.links.next);"
                          >
                            View more...
                          </button>
                          <!-- end: view more -->
                          <div class="text-center">
                            <ul class="pagination">
                              <li><a href="#" class="active">1</a></li>
                              <li><a href="#">2</a></li>
                              <li><a href="#">3</a></li>
                              <li><a href="#">4</a></li>
                              <li><a href="#">5</a></li>
                            </ul>
                          </div>
                        </div>
                        <!-- end: company suggestion card -->
                        <p v-else>Something went wrong while fetching this information.</p>
                        <!-- end: company suggestion -->
                    </div>
                  </div>

                  <!-- end: companies you follow card -->

                </section>
                <!-- end: jobs applied | watchlist | profile completion | -->
                <!-- end: companies-you-follow -->

                <!--
                start: extensions | jobs applied | watchlist | profile completion | featured for you
                -->

            </div>
          </div><!-- eof row -->

          <div class="clearfix"></div>

        </section>
        <!-- end: dashboard section -->
    </main>
  </div>
</template>


<script>
import { mapGetters } from 'vuex';
export default {
  name: 'Dashboard',
  layout: 'candidate',

  metaInfo() {
    return { title: this.$t('home') };
  },

  data: () => ({
    title: window.config.appName,
    salutation: {
      id: '',
      author: '',
      message: '',
    },
    companyFollow: {
      data: [],
      links: {},
      meta: {},
    },
    companyLogs: {
      data: [],
      links: {},
      meta: {},
    },
    companySuggestionsCard: {
      accordion: true,
      hide: false,
      show: true,
    },
    companySuggestions: {
      data: [],
      links: {},
      meta: {},
    },
    profileRequests: {
      data: [],
      links: {},
      meta: {},
    },
    companyFollowCard: {
      accordion: true,
      hide: false,
      show: true,
    },
    extensionCard: {
      accordion: true,
      hide: false,
    },
    profileCompletion: {
      icebreaker_video: false,
      profile_image: false,
      experience: false,
      education: false,
      completion: 0,
      profile_video: '',
    },
    yourProfileCard: {
      accordion: true,
      hide: false,
      show: true,
    },
    featuredForYouCard: {
      accordion: true,
      hide: false,
      show: true,
    },
    candidateProfile: {
      first_name: '',
      last_name: '',
      email: '',
      profile_image: '',
      long_description: '',
      privacy: {
        settings: [],
        type: '',
      },
      default_image: '',
    },
    featuredJobs: {
      data: [],
      links: {},
      meta: {},
    },
    jobApplicationTabs: {
      active: '',
    },
    jobWatchlists: {
      data: [],
      links: {},
      meta: {},
    },
    jobsApplied: {
      data: [],
      links: {},
      meta: {},
    },
    closedDeclinedJobs: {
      data: [],
      links: {},
      meta: {},
    },
    jobWatchlistSection: {
      name: 'watchlist',
    },
    jobAppliedSection: {
      name: 'job_applied',
    },
    jobClosedDeclinedSection: {
      name: 'closed_declined',
    },
    workTypes: {
      id: 0,
      displayName: '',
      slugName: '',
    },
    industriesData: {
      id: 0,
      display_name: '',
      slug_name: '',
      parent_id: 0,
      type: '',
      sub: [],
    },
    subIndustries: {
      id: 0,
      display_name: '',
      slug_name: '',
      parent_id: 0,
      type: '',
    },
    subIndustriesSelected: [],
    industries: [],
    filterButton: true,
    toggleFilterDisplay: 'hidden',

    hasProfileCompletion: {
      hide: false,
      show: true,
      full: true,
      onethird: false,
    }
  }),
  mounted() {
    $('#salary_filter').slider({
      min: 0,
      max: 200,
      value: [0, 200],
      focus: true,
      formatter: function(value) {
        var salary = function(salary) {
          return '$' + salary + 'k';
        };
        return salary(value[0]) + ' - ' + salary(value[1]);
      },
    });
    /**
     * For toggling classification filter
     */
    $('.togglethis').click(function() {
      $('#ClassificationMain').slideToggle(function() {
        if ($('#ClassificationMain').is(':visible')) {
          $('.togglethis').addClass('focusthis');
        } else if ($('#ClassificationMain').is(':hidden')) {
          $('.togglethis').removeClass('focusthis');
        }
      });
    });
  },
  created() {
    this.jobApplicationTabs.active = this.jobAppliedSection.name;
    this.callLocationApi();
    this.callWorkTypes();
    this.callCandidateProfileRequestApi();
    this.callJobsAppliedApi();
    this.callClosedDeclinedJobApplicationApi();
    this.callJobWatchlistApi();
    this.callProfileCompletionApi();
    this.callSalutationApi();
    this.callCompanyFollowApi();
    this.callCompanyLogApi();
    this.callCompanySuggestionApi();
    this.callJobFeaturedApi();
    this.callIndustriesApi();

    /**
     * this->$parent(child)->$parent(candidate [the one that emits the data])
     */
    this.$parent.$parent.$on('candidateProfile', candidateProfile => {
      this.candidateProfile = candidateProfile;
    });
  },
  computed: mapGetters({
    authenticated: 'auth/check',
  }),
  methods: {
    deleteToWatchList: function(jobId) {
      axios.delete('candidate/job/watchlist/' + jobId).then(() => {
        var index = _.findIndex(this.featuredJobs.data, function(data) {
          return data.job.id === jobId;
        });
        this.featuredJobs.data[index].job.watchlist = 0;
      });
    },
    addToWatchList: function(jobId) {
      axios.post('candidate/job/watchlist', { job_id: jobId }).then(() => {
        var index = _.findIndex(this.featuredJobs.data, function(data) {
          return data.job.id === jobId;
        });
        this.featuredJobs.data[index].job.watchlist = 1;
      });
    },
    checkUncheckAllSubClassifications: function(industry) {
      // uncheck all sub industries
      if (this.industries.includes(industry.id)) {
        _(industry.sub).forEach(subIndustry => {
          var index = this.subIndustriesSelected.indexOf(subIndustry.id);
          this.subIndustriesSelected.splice(index, 1);
        });
        return;
      }

      // check all sub industries
      _(industry.sub).forEach(subIndustry => {
        if (!this.subIndustriesSelected.includes(subIndustry.id)) {
          this.subIndustriesSelected.push(subIndustry.id);
        }
      });
    },
    /**
     * This shows the list of sub industries
     */
    hoverClassification: function(subIndustries) {
      this.subIndustries = subIndustries;
    },
    /**
     * This shows the sub industries section
     */
    showSubClassifications: function() {
      $('#sub-classification-col').removeClass('visi');
    },
    /**
     * This hides the sub industries section
     */
    hideSubClassifications: function() {
      $scope.onHoverSubIndustries = false;
      setTimeout(function() {
        if ($scope.onHoverSubIndustries == false) {
         $('.togglethis').trigger('click');
        }
      }, 1500);
    },
    approveDisapproveProfileRequestApi: function(id, enabled, index) {
      axios.put('candidate/profile/request/' + id, { enabled: enabled }).then(() => {
        this.profileRequests.data.splice(index, 1);
        if (enabled) {
          alertify.notify('Profile request approved.', 'success');
          return;
        }
        alertify.notify('Profile request disapproved.', 'success');
      });
    },

    callIndustriesApi: function() {
      axios.get('industries?type=all').then(response => {
        this.industriesData = response.data;
      });
    },
    callWorkTypes: function() {
      axios.get('work-types').then(response => {
        this.workTypes = response.data;
      });
    },
    callLocationApi: function() {
      axios.get('locations?type=search-display').then(function(response) {
        var html = '';
        /**
         * append the html manually since bootstrap-select loads first
         */
        _(response.data).forEach(function(location) {
          var locationName = location.parent_name + ', ' + location.display_name;
          html += "<option value='" + location.id + "'>" + locationName + '</option>';
        });
        $('select[name="location_filter"]').html(html);
        $('select[name="location_filter"]').selectpicker();
      });
    },
    callCandidateProfileRequestApi: function(link = 'candidate/profile/request') {
      axios.get(link).then(response => {
        _(response.data.data).forEach(
          function(profileRequest) {
            profileRequest.default_image = this.globalCreateDefaultImage(
              profileRequest.company_name,
            );
          }.bind(this),
        );
        this.populateViewMoreData('profileRequests', response.data);
      });
    },

    callClosedDeclinedJobApplicationApi: function(link = 'candidate/job/application/closed') {
      axios.get(link).then(response => {
        _(response.data.data).forEach(
          function(closedDeclined) {
            closedDeclined.company.default_image = this.globalCreateDefaultImage(
              closedDeclined.company.name,
            );
          }.bind(this),
        );

        this.populateViewMoreData('closedDeclinedJobs', response.data);
      });
    },

    callJobsAppliedApi: function(link = 'candidate/job/application/applied') {
      axios.get(link).then(response => {
        _(response.data.data).forEach(
          function(jobApplied) {
            jobApplied.company.default_image = this.globalCreateDefaultImage(
              jobApplied.company.name,
            );
          }.bind(this),
        );

        this.populateViewMoreData('jobsApplied', response.data);
      });
    },

    callJobWatchlistApi: function(link = 'candidate/job/watchlist') {
      axios.get(link).then(response => {
        _(response.data.data).forEach(
          function(watchlist) {
            watchlist.company.default_image = this.globalCreateDefaultImage(watchlist.company.name);
          }.bind(this),
        );

        this.populateViewMoreData('jobWatchlists', response.data);
      });
    },

    callJobFeaturedApi: function(link = 'candidate/job/featured') {
      axios.get(link).then(response => {
        _(response.data.data).forEach(
          function(featuredJob) {
            featuredJob.company.default_image = this.globalCreateDefaultImage(
              featuredJob.company.name,
            );
          }.bind(this),
        );

        this.populateViewMoreData('featuredJobs', response.data);
      });
    },

    callCompanySuggestionApi: function(link = 'candidate/company/suggestion') {
      axios.get(link).then(response => {
        _(response.data.data).forEach(
          function(companySuggestion) {
            companySuggestion.company.default_image = this.globalCreateDefaultImage(
              companySuggestion.company.name,
            );
          }.bind(this),
        );
        this.populateViewMoreData('companySuggestions', response.data);
      });
    },

    callProfileCompletionApi: function() {
      axios.get('candidate/profile/completion').then(response => {
        this.profileCompletion = response.data;
      });
    },
    /**
     * Call salutation api
     */
    callSalutationApi: function() {
      axios.get('salutations').then(response => {
        this.salutation = response.data;
      });
    },

    callCompanyFollowApi: function(link = 'candidate/company/follow') {
      axios.get(link).then(response => {
        _(response.data.data).forEach(
          function(companyFollowed) {
            companyFollowed.default_image = this.globalCreateDefaultImage(
              companyFollowed.company_name,
            );
          }.bind(this),
        );

        this.populateViewMoreData('companyFollow', response.data);
      });
    },

    callCompanyLogApi: function(link = 'candidate/company/log') {
      axios.get(link).then(response => {
        this.populateViewMoreData('companyLogs', response.data);
      });
    },

    /**
     * Populate the data for the view more implementation
     */
    populateViewMoreData: function(model, data) {
      if (this[model].data.length === 0) {
        this[model] = data;
      } else {
        this[model].data.push(...data.data);
        this[model].links = data.links;
        this[model].meta = data.meta;
      }
    },
  },
};
</script>
