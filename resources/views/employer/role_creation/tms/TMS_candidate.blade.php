<section class="TMS-applicants-view clear-float">
    <div class="TMS-right-tab">
        <section class="TMS__filters">
            <input type="text" ng-model="searchApplicants" class="pvm-input-text TMS__search-applicants" placeholder="Search by name or work industry" ng-enter="findInApplicants(searchApplicants)" ng-change="isSearchBlank(searchApplicants)">
            <button ng-click="findInApplicants(searchApplicants)" class="btn-pvm btn-primary btn-square"><i class="fa fa-search"></i></button>
            <select ng-model="sortMyApplicants" ng-options="sort.key as sort.value for sort in sortMyApplicantsOpt" class="pvm-select TMS__sort-applicants" ng-change="newOrder(sortMyApplicants)">
                <option>Sort by</option>
            </select>
        </section>
        <section class="TMS-splasher" ng-show="getApplicants_notloaded">
            <h3>Please wait.</h3>
            <h4>Applicants are being retrieved.</h4>
            <div class="cssload-loading"><i></i><i></i><i></i><i></i></div>
        </section>
        <!-- <div class="" id="tab@{{list.stepid}}" ng-repeat="list in tmsSteps.applicantlist" role="tabpanel"> -->
        <div id="tab@{{tmsSteps.applicantlist.stepid}}" role="tabpanel">
            <ul id="TMS_expand_card" class="TMS__applicant-list clear-float" ng-if="tmsSteps.applicantlist.applicants.length != 0">
                <li class="expander" id="expandedSection@{{tmsSteps.applicantlist.stepid}}" ng-show="showMyProfile && showExpand">
                    <span class="TMS__next-prev-applicants" ng-repeat="nextPrevList in nextPrev" ng-if="userPublicProfile[0].id == nextPrevList.current">
                        <span><i class="fa fa-caret-left" ng-if="nextPrevList.prev != 0 || nextPrevList.prev != ''" ng-click="expandme(nextPrevList.prev, list.stepid, nextPrevList.prev_obj, false, $event)" title="Previous Applicant"></i> Previous candidate</span>
                        <div>
                            <span>Next candidate <i class="fa fa-caret-right" ng-if="nextPrevList.next != 0" ng-click="expandme(nextPrevList.next, tmsSteps.applicantlist.stepid, nextPrevList.next_obj, false, $event)" title="Next Applicant"></i></span>
                            <a href="javascript:void(0)" class="unexpand" ng-click="unexpandme(tmsSteps.applicantlist.stepid, userPublicProfile[0].id)"><i class="fa fa-close"></i></a>
                        </div>
                    </span>
                    
                    <section class="TMS__profile-identity clear-float">
                        <div class="TMS__profile-photo">
                        <img class="img-circle" height="140" ng-show="userPublicProfile[0].data.docs.profile_image" ng-src="@{{userPublicProfile[0].data.docs.profile_image}}" width="140">
                        <div ng-show="!userPublicProfile[0].data.docs.profile_image" class="member-initials member-initials--tms-large @{{userPublicProfile[0].data.profile_color}}">@{{userPublicProfile[0].data.initial}}</div>
                        </div>
                        <div class="TMS__profile-summary">
                        <h3 class="applicant__name applicant-name">@{{userPublicProfile[0].data.first_name}} @{{userPublicProfile[0].data.last_name}}</h3>
                        <h3 class="applicant__name applicant-name--nickname" ng-show="nickname">@{{userPublicProfile[0].data.nickname}}</h3>
                        <h4 class="applicant-location" ng-show="userPublicProfile[0].data.preferred_location.data.display_name || userPublicProfile[0].data.preferred_location.data.country.display_name">
                            <i class="fa fa-map-marker"></i>
                            <span>@{{userPublicProfile[0].data.preferred_location.data.display_name}}<span ng-show="userPublicProfile[0].data.preferred_location.data.country.display_name">,</span> @{{userPublicProfile[0].data.preferred_location.data.country.display_name}}</span>
                        </h4>
                        <h4 ng-show="userPublicProfile[0].data.phone_number" class="applicant-phone">
                            <i class="fa fa-phone"></i>
                            <span>@{{userPublicProfile[0].data.phone_number}}</span>
                        </h4>
                        <h4 ng-show="userPublicProfile[0].data.mobile_number" class="applicant-mobile">
                            <!-- <i class="fa fa-mobile"></i> -->
                            <span>@{{userPublicProfile[0].data.mobile_number}}</span>
                        </h4>
                        <h4 ng-show="userPublicProfile[0].data.email" class="applicant-email">
                            <i class="fa fa-envelope-o"></i>
                            <span>@{{userPublicProfile[0].data.email}}</span>
                        </h4>
                        <h4 ng-show="userPublicProfile[0].data.industry.data.industry.display_name" class="applicant-industry">
                            <i class="fa fa-building-o"></i>
                            <span>@{{userPublicProfile[0].data.industry.data.industry.display_name}}</span>
                            <span ng-show="userPublicProfile[0].data.industry.data.industry.display_name">- @{{userPublicProfile[0].data.industry.data.sub.display_name}}</span>
                        </h4>
                        </div>
                        {{-- <div class="TMS__profile-vid-box">
                            <div id="VideoContainer">
                            </div>
                            <div class="profile-vid-box--inner" ng-show="noVideoURL">
                                <div class="vid-box-message--core">
                                <i class="fa fa-film"></i>
                                No Video found.
                                </div>
                            </div>
                        </div> --}}
                    </section>
                    <section class="TMS__profile-navs clear-float">
                        <div class="TMS__profile-vid-box">
                            <div id="VideoContainer">
                            </div>
                            <div class="profile-vid-box--inner" ng-show="noVideoURL">
                                <div class="vid-box-message--core">
                                <i class="fa fa-film"></i>
                                No Video found.
                                </div>
                            </div>
                        </div>
                        <ul class="applicant__section-list">
                            <li class="applicant__section-item active" ng-click="hidePreviews(false)"><a data-toggle="tab" href="#tabs-1">About me and<br>Work Experience</a></li>
                            <li class="applicant__section-item" ng-click="hidePreviews(false)"><a data-toggle="tab" href="#tabs-2">Education and <br> References</a></li>
                            <li class="applicant__section-item" ng-click="hidePreviews(false)"><a data-toggle="tab" href="#tabs-3">Pre-Approval <br> Questions</a></li>
                            <li class="applicant__section-item" ng-click="hidePreviews(false)"><a data-toggle="tab" href="#tabs-4">Standard <br> Questions</a></li>
                            <li class="applicant__section-item applicant__section-item--single" ng-click="hidePreviews(true)"><a data-toggle="tab" href="#tabs-5">Documents <br></a></li>
                        </ul>
                        <div class="tab-content">
                            <div id="tabs-1" class="tab-pane fade in active tse-scrollable" ng-hide="previewDocs || previewRes">
                                
                                <div class="tse-content">
                                <h2 class="TMS__applicant-header" ng-show="userPublicProfile[0].data.long_description">About Me</h2>
                                <p class="applicant__about" ng-bind-html="userPublicProfile[0].data.long_description"></p>
                                <h2 class="TMS__applicant-header" ng-show="userPublicProfile[0].data.work_history.length != 0">Work Experience</h2>
                                <ul class="applicant__work-exp-list">
                                    <li class="applicant__work-exp-item" ng-repeat="work in userPublicProfile[0].data.work_history | orderBy: work.filterdate:true " ng-show="userPublicProfile[0].data.work_history.length != 0">
                                    <h3 class="applicant__job-header">
                                        @{{work.job_title}} |
                                        <span class="applicant__work-details">@{{work.display_date}} @{{work.work_type.display_name}}</span>
                                    </h3>
                                    <h4 class="applicant__employer">@{{work.company_name}}</h4>
                                    <h5 class="applicant__title">Key Responsibilities</h5>
                                    <ul class="applicant__resposibility-list">
                                        <li ng-repeat="(key, value) in work.key_accountabilities" class="applicant__resposibility-item">@{{value}}</li>
                                    </ul>
                                    <div class="">
                                        <h5 class="applicant__title">Job in a Nutshell</h5>
                                        <p class="applicant__work-desc" ng-bind-html="work.description"></p>
                                    </div>
                                    <ul class="applicant__indus-list">
                                        <li ng-repeat="(key, value) in work.industries_display" class="applicant__indus-item">
                                        <h5 class="applicant__title applicant__title--industry">@{{key}}</h5>
                                        <p class="applicant__indus-value">@{{value}}</p>
                                        </li>
                                    </ul>
                                    </li>
                                </ul>
                                <p ng-if="userPublicProfile[0].data.work_history.length == 0  && userPublicProfile[0].data.new_to_workforce == false" class="applicant__no-data">No work history available.</p>
                                <p ng-if="userPublicProfile[0].data.work_history.length == 0 && userPublicProfile[0].data.new_to_workforce == true" class="applicant__no-data">New to the workforce</p>
                                </div>
                            </div>

                            <div id="tabs-2" class="tab-pane fade tse-scrollable" ng-hide="previewDocs || previewRes">
                                <div class="tse-content">
                                <h2 class="TMS__applicant-header">Education</h2>
                                <ul class="applicant__educ-list">
                                    <li class="applicant__educ-item clear-float" ng-repeat="education in userPublicProfile[0].data.qualifications  " ng-show="userPublicProfile[0].data.qualifications.length != 0">
                                    <div class="TMS__educ-holder">
                                        <h3 class="applicant__educ-header">
                                        @{{education.degree}} |
                                        <span class="applicant__educ-details">@{{education.qualification.display_name}}</span>
                                        </h3>
                                        <h4 class="applicant__esp">@{{education.qualification_provider.provider_display_name}} - @{{education.completed_date | date:"dd-MM-yyyy"}} @{{education.completed_date == null ? 'Currently studying' : ''}}</h4>
                                    </div>
                                    <img src="@{{education.qualification_provider.company_logo}}" ng-show="education.qualification_provider.company_logo" class="img-responsive applicant_esp-image">
                                    </li>
                                </ul>
                                <p ng-show="userPublicProfile[0].data.qualifications.length == 0" class="applicant__no-data">No education available</p>
                                <h2 class="TMS__applicant-header" ng-show="userPublicProfile[0].data.references != 0">References</h2>
                                <ul class="applicant__reference-list">
                                    <li ng-repeat="ref in userPublicProfile[0].data.references" class="applicant__reference-item">
                                    <p class="applicant__ref-title">@{{ref.description}}</p>
                                    <p class="applicant__ref-name">@{{ref.employer_name}}</p>
                                    <p class="applicant__ref-company">@{{ref.company_name}}</p>
                                    <p class="applicant__ref-email">@{{ref.contact_email}}</p>
                                    <p class="applicant__ref-phone">@{{ref.contact_phone}}</p>
                                    </li>
                                </ul>
                                </div>
                            </div>

                            <div id="tabs-3" class="tab-pane fade tse-scrollable" ng-hide="previewDocs || previewRes">
                                <div class="tse-content">
                                <p ng-show="questions.pre_apply_questions.length == 0" class="applicant__no-data">No Pre-approval question available.</p>
                                <div class="tse-content" ng-show="questions.pre_apply_questions.length != 0">
                                    <h2 class="TMS__applicant-header">Pre-Approval Questions</h2>
                                    <table class="table table-responsive TMS__questions-table">
                                    <thead class="TMS__questions-head">
                                    <tr>
                                        <th class="TMS__questions-header">Questions</th>
                                        <th class="">Answers</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr ng-repeat="answer in questions.pre_apply_questions">
                                        <td class="TMS__answers-td">@{{answer.question}}</td>
                                        <td class="TMS__answers-td"> @{{answer.answer}} </td>
                                    </tr>
                                    </tbody>
                                    </table>
                                </div>
                                </div>
                            </div>

                            <div id="tabs-4" class="tab-pane fade tse-scrollable" ng-hide="previewDocs || previewRes">
                                <div class="tse-content">
                                <p ng-show="questions.application_questions.length == 0" class="applicant__no-data">No Standard question available.</p>
                                <div class="" ng-show="questions.application_questions.length != 0">
                                    <h2 class="TMS__applicant-header">Standard Questions</h2>
                                    <table class="table table-responsive TMS__questions-table">
                                    <thead class="TMS__questions-head">
                                    <tr>
                                        <th class="TMS__questions-header--standard">Questions</th>
                                        <th class="">@{{userPublicProfile[0].data.first_name}}'s Answers</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr ng-repeat="answer in questions.application_questions">
                                        <td class="TMS__answers-td">@{{answer.question}} </td>
                                        <td>
                                        <div class="TMS__answers-td" ng-if="answer.type === 'free_text'">@{{answer.answer}}</div>
                                        <div ng-if="answer.type === 'boolean'">@{{answer.answer}}</div>
                                        <div class="TMS__answers-td" ng-if="answer.type === 'multiple_choice'">@{{answer.answer}}</div>
                                        <div ng-if="answer.type === 'file_upload'" class="TMS__questions-con">
                                            <a href="@{{answer.answer.doc_url | trustAsResourceUrl}}" class="TMS__questions-file-link--print">@{{answer.answer.doc_filename}}</a>
                                            <iframe src="@{{answer.answer.doc_url | trustAsResourceUrl}}" class="TMS__questions-file-link printAnswer" id="printAnswer@{{userPublicProfile[0].id}}" frameborder="0">@{{answer.answer.doc_filename}}</iframe>
                                        </div>
                                        <div ng-if="answer.type === 'video'">
                                            <div id="video_answer_con@{{answer.video_id}}_@{{tmsSteps.applicantlist.stepid}}" class="hideOnPrint">
                                            <video id="video_answer_@{{answer.video_id}}_@{{tmsSteps.applicantlist.stepid}}" class="azuremediaplayer amp-default-skin" poster="/images/video_preload.gif" width="200"></video>
                                            </div>
                                            <p class="printOnly"><strong>Video not available on print.</strong></p>
                                        </div>
                                        </td>
                                    </tr>
                                    </tbody>
                                    </table>
                                </div>
                                </div>
                            </div>
                            <div id="tabs-5" class="tab-pane fade tse-scrollable">
                                <div class="tse-content">
                                <p ng-show="!userPublicProfile[0].docs.resume.doc_url && !userPublicProfile[0].docs.portfolio.doc_url" class="applicant__no-data">No Documents provided available.</p>
                                <h2 class="TMS__applicant-header">Documents</h2>
                                <a href="javascript:void(0)" class="TMS__applicant-sub-tab" ng-class="{active : previewRes}" ng-click="showPreviewRes()">Resume</a>
                                <a href="javascript:void(0)" class="TMS__applicant-sub-tab" ng-class="{active : previewDocs}" ng-click="showPreviewDocs()">Supporting Documents</a>
                                <a href="javascript:void(0)" class="TMS__applicant-sub-tab" ng-class="{active : previewTrans}" ng-click="showPreviewTrans()">Transcript</a>
                                <a href="javascript:void(0)" class="TMS__applicant-sub-tab" ng-class="{active : previewCover}" ng-click="showPreviewCover()">Cover Letter </a>

                                <div class="TMS__applicant-preview-docs" ng-class="{active : previewRes && userPublicProfile[0].docs.resume.doc_url}">
                                    <h2 class="TMS__applicant-header TMS__applicant-header--sub">Resume</h2> Please click the file name to download the file.
                                    <a target="_blank" href="@{{applicant_resume_url | trustAsResourceUrl}}" ng-if="previewRes && userPublicProfile[0].docs.resume.doc_url" class="TMS__link">@{{userPublicProfile[0].docs.resume.doc_filename}}</a>

                                    <!-- <a target="_blank" href="@{{userPublicProfile[0].docs.resume.doc_url | trustAsResourceUrl}}" ng-if="previewRes && userPublicProfile[0].docs.resume.doc_url" class="TMS__link">@{{userPublicProfile[0].docs.resume.doc_filename}}</a> -->
                                    <div id="candidate_resume_div"></div>
                                    <!-- <iframe src="@{{resume | trustAsResourceUrl}}" class="printRes" id="printRes@{{userPublicProfile[0].id}}" frameborder="0" onLoad="top.scrollTo(0,0);">Resume</iframe> -->

                                </div>
                                <div class="TMS__applicant-preview-docs" ng-class="{active : previewDocs && userPublicProfile[0].docs.portfolio.doc_url}">
                                    <h2 class="TMS__applicant-header TMS__applicant-header--sub">Supporting Documents</h2> Please click the file name to download the file.
                                    <a target="_blank" href="@{{applicant_portfolio_url | trustAsResourceUrl}}" ng-if="previewDocs && userPublicProfile[0].docs.portfolio.doc_url" class="TMS__link">@{{userPublicProfile[0].docs.portfolio.doc_filename}}</a>

                                    <!-- <a target="_blank" href="@{{userPublicProfile[0].docs.portfolio.doc_url | trustAsResourceUrl}}" ng-if="previewDocs && userPublicProfile[0].docs.portfolio.doc_url" class="TMS__link">@{{userPublicProfile[0].docs.portfolio.doc_filename}}</a> -->
                                    <div id="candidate_portfolio_div"></div>
                                    <!-- <iframe src="@{{docs_candidate.portfolio | trustAsResourceUrl}}" frameborder="0" class="printDocs" id="printDocs@{{userPublicProfile[0].id}}" onLoad="top.scrollTo(0,0);">Supporting Docs.</iframe> -->

                                </div>
                                <div class="TMS__applicant-preview-docs" ng-class="{active : previewTrans && userPublicProfile[0].docs.transcript.doc_url}" style="position: absolute; top:100px;">
                                    <h2 class="TMS__applicant-header TMS__applicant-header--sub">Transcript</h2> Please click the file name to download the file.
                                    <a target="_blank" href="@{{applicant_transcript_url | trustAsResourceUrl}}" ng-if="previewTrans && userPublicProfile[0].docs.transcript.doc_url" class="TMS__link">@{{userPublicProfile[0].docs.transcript.doc_filename}}</a>

                                    <!-- <a target="_blank" href="@{{userPublicProfile[0].docs.transcript.doc_url | trustAsResourceUrl}}" ng-if="previewTrans && userPublicProfile[0].docs.transcript.doc_url" class="TMS__link">@{{userPublicProfile[0].docs.transcript.doc_filename}}</a> -->
                                    <div id="candidate_transcript_div"></div>
                                    <!-- <iframe src="@{{docs_candidate.transcript | trustAsResourceUrl}}" frameborder="0" class="printTrans" id="printTrans@{{userPublicProfile[0].id}}" onLoad="top.scrollTo(0,0);">Transcript</iframe> -->

                                </div>

                                <div class="TMS__applicant-preview-docs" ng-class="{active : previewCover && userPublicProfile[0].docs.cover_letter.doc_url}" style="position: absolute; top:100px;">
                                    <h2 class="TMS__applicant-header TMS__applicant-header--sub">Cover Letter</h2> Please click the file name to download the file.
                                    <a target="_blank" href="@{{applicant_cover_letter_url | trustAsResourceUrl}}" ng-if="previewCover && userPublicProfile[0].docs.cover_letter.doc_url" class="TMS__link">@{{userPublicProfile[0].docs.cover_letter.doc_filename}}</a>

                                    <!-- <a target="_blank" href="@{{userPublicProfile[0].docs.cover_letter.doc_url | trustAsResourceUrl}}" ng-if="previewCover && userPublicProfile[0].docs.cover_letter.doc_url" class="TMS__link">@{{userPublicProfile[0].docs.cover_letter.doc_filename}}</a> -->
                                    <div id="candidate_coverletter_div"></div>
                                    <!-- <iframe src="@{{docs_candidate.cover | trustAsResourceUrl}}" frameborder="0" class="printCover" id="printCover@{{userPublicProfile[0].id}}" onLoad="top.scrollTo(0,0);">Cover Letter</iframe> -->
                                </div>

                                </div>
                            </div>
                            
                        </div>

                    </section>
                    <section class="TMS__profile-actions clear-float">
                        <div ng-repeat="applicants in tmsSteps.applicantlist.applicants" ng-if="applicants.id == userPublicProfile[0].id">
                            <section class="TMS__profile-section noborder-t">
                                <input type="text" ng-if="JobData.job_status == 'closed' || JobData.job_status == 'withdraw' || JobData.job_status == 'hired'" ng-repeat="buckItem in tmsSteps.steps| filter:tmsSteps.applicantlist.stepid" ng-value="buckItem.name" disabled="disabled">
                                <p class="gpa gpa--blue"><span>GPA:</span> @{{applicant.custom_gpa.value ? applicant.custom_gpa.value : '--'}}</p>
                                <h4>Rate @{{userPublicProfile[0].data.first_name}}</h4>

                                <p class="unrated">Unrated</p>

                                {{--##############################

                                SHOW "rateby" WHEN THERE IS RATING  

                                ##############################--}}
                                <div class="rateby">
                                    <div class="hidden">
                                        <p class="rateby__ave">@{{candidate_rating.average_rating}} <span class="star">★</span></p>
                                        <p>@{{'(' + candidate_rating.total_emp_rated + ')'}}</p>
                                    </div>
                                </div>
                                <div class="applicant__rate-div rateby">
                                    <div class="TMS-rating-star-div">
                                        <fieldset class="rating">
                                            <input type="radio" id="star5" class="rating-star--radio" name="rating" ng-value="5" ng-model="star" ng-change="rate_candidate(this, userPublicProfile[0].id, JobData.object_id)"/><label id="starlabel5" class = "full rating-star--label" for="star5" title="Impeccable! - 5 stars"></label>

                                            <input type="radio" id="star4half" class="rating-star--radio" name="rating" ng-value="4.5" ng-model="star" ng-change="rate_candidate(this, userPublicProfile[0].id, JobData.object_id)" /><label id="starlabel4half" class="half rating-star--label" for="star4half" title="Pretty damn good! - 4.5 stars"></label>

                                            <input type="radio" id="star4" class="rating-star--radio" name="rating" ng-value="4" ng-model="star" ng-change="rate_candidate(this, userPublicProfile[0].id, JobData.object_id)" /><label id="starlabel4" class = "full rating-star--label" for="star4" title="Good! - 4 stars"></label>

                                            <input type="radio" id="star3half" class="rating-star--radio" name="rating" value="3.5" ng-model="star" ng-change="rate_candidate(this, userPublicProfile[0].id, JobData.object_id)" /><label id="starlabel3half" class="half rating-star--label" for="star3half" title="Nice! - 3.5 stars"></label>

                                            <input type="radio" id="star3" class="rating-star--radio" name="rating" value="3" ng-model="star" ng-change="rate_candidate(this, userPublicProfile[0].id, JobData.object_id)" /><label id="starlabel3" class = "full rating-star--label" for="star3" title="Yeah alright - 3 stars"></label>

                                            <input type="radio" id="star2half" class="rating-star--radio" name="rating" value="2.5" ng-model="star" ng-change="rate_candidate(this, userPublicProfile[0].id, JobData.object_id)" /><label id="starlabel2half" class="half rating-star--label" for="star2half" title="Meh - 2.5 stars"></label>

                                            <input type="radio" id="star2" class="rating-star--radio" name="rating" value="2" ng-model="star" ng-change="rate_candidate(this, userPublicProfile[0].id, JobData.object_id)" /><label id="starlabel2" class = "full rating-star--label" for="star2" title="Kinda bad - 2 stars"></label>

                                            <input type="radio" id="star1half" class="rating-star--radio" name="rating" value="1.5" ng-model="star" ng-change="rate_candidate(this, userPublicProfile[0].id, JobData.object_id)" /><label id="starlabel1half" class="half rating-star--label" for="star1half" title="Meh - 1.5 stars"></label>

                                            <input type="radio" id="star1" class="rating-star--radio" name="rating" value="1" ng-model="star" ng-change="rate_candidate(this, userPublicProfile[0].id, JobData.object_id)" /><label id="starlabel1" class = "full rating-star--label" for="star1" title="Uh oh! - 1 star"></label>

                                            <input type="radio" id="starhalf" class="rating-star--radio" name="rating" value=".5" ng-model="star" ng-change="rate_candidate(this, userPublicProfile[0].id, JobData.object_id)" /><label id="starlabelhalf" class="half rating-star--label" for="starhalf" title="Sucks big time! - 0.5 stars"></label>
                                        </fieldset>
                                    </div>
                                </div>
                            </section>
                            <section class="TMS__profile-section">
                                <select class="TMS__applicant-status-select pvm-select" ng-if="JobData.job_status != 'closed' && JobData.job_status != 'withdrawn' && JobData.job_status != 'hired'" ng-model="selectmove[applicants.id]" ng-change="update(applicants.object_id, applicants.id, tmsSteps.applicantlist.stepid, [applicants.first_name, applicants.last_name]);" ng-options="item as item.name for item in tmsSteps.steps track by item.id">
                                    <option value="">select</option>
                                </select>
                            </section>
                            <section class="TMS__profile-section">
                                <div class="TMS__profile-info-div flexbox">
                                    {{-- <div class="applicant__qualification applicant__qualification--exp green" data-html="true" data-toggle="tooltip" data-placement="left">
                                    <h2>
                                        <span>@{{candidate_gpa ? candidate_gpa : '--'}}</span>
                                    </h2>
                                    <p>GPA</p>
                                    </div> --}}

                                    <div class="applicant__qualification applicant__qualification--exp" ng-class="{green: applicants.application.color_panels.experience == 1 , orange: applicants.application.color_panels.experience == 2 , red: applicants.application.color_panels.experience == 0}" data-html="true" data-toggle="tooltip" data-placement="left" title="<strong>Green:</strong> candidate has the required number of years of experience in the actual role classification.<br><br><strong>Orange:</strong> candidate has less experience in the role classification than required, or candidate has the required number of years of experience in a different classification.<br><br><strong>Red: </strong>candidate does not have the required experience.<br>">
                                    <h2>
                                        <span>@{{candidate_workexp ? candidate_workexp : 0}}</span>
                                    </h2>
                                    <p>EXPERIENCE</p>
                                    </div>

                                    <div class="applicant__qualification applicant__qualification--loc" ng-class="{green: applicants.application.color_panels.location == 1 , orange: applicants.application.color_panels.location == 2 , red: applicants.application.color_panels.location == 0}"data-html="true" data-toggle="tooltip" data-placement="left" title="<strong>Green:</strong> candidate lives in the city where the role is located.<br><br><strong>Orange:</strong> candidate lives in the region where the role is located and/or is willing to relocate.<br><br><strong>Red:</strong> candidate does not live in the region where the role is located and does not want to relocate.<br><br>">
                                    <h2>
                                        <span><i class="fa fa-globe"></i></span>
                                    </h2>
                                    <p>LOCATION</p>
                                    </div>

                                    <div class="applicant__qualification applicant__qualification--req noborder" ng-class="{green: applicants.application.color_panels.requirements == 1 , orange: applicants.application.color_panels.requirements == 2 , red: applicants.application.color_panels.requirements == 0}" data-html="true" data-toggle="tooltip" data-placement="left" title="Candidate meets the profile requirements.<br><br>">
                                    <h2>
                                        <span><i class="fa fa-check"></i></span>
                                    </h2>
                                    <p>REQUIREMENTS</p>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </section>

                            <section class="TMS__profile-section">
                                <a href="" ng-click="printMe(applicants.candidate.id)" class="TMS__action-links TMS__action-links--print"><i class="fa fa-print"></i>Print</a>
                                <a href="/me/@{{userPublicProfile[0].data.profile_url}}" class="TMS__action-links TMS__action-links--profile" target="_blank" ng-show="applicants.candidate.profile_url.length != null || applicants.candidate.profile_url.length != ''" title="Print Candidate Profile"><i class="fa fa-user"></i>PROFILE</a>
                            </section>
                            <!--<a href="" class="TMS__action-links TMS__action-links--resume" ng-click="showPreviewRes()" ng-show="applicants.candidate.docs.resume.doc_url" title="View Resume"><i class="fa fa-file-text"></i>Resume</a>
                            <a href="" class="TMS__action-links TMS__action-links--docs" ng-click="showPreviewDocs()" ng-show="applicants.candidate.docs.portfolio.length != 0" title="View Supporting Docs"><i class="fa fa-files-o"></i>DOCS</a>-->
                            <h3 class="TMS__applicant-note-header" id="TMS-Note">Notes</h3>
                            <div class="TMS__applicant-notes">
                                <ul class="TMS__applicant-note-list" ng-class="{'TMS__applicant-note-list--scroll' : (appNotes[0].data.notes.length > 2)}">
                                <li class="TMS__applicant-note-item">
                                    <p class="TMS__applicant-note"><i>@{{applicants.first_name}} applied for this role on:</i></p>
                                    <p class="TMS__applicant-note-date">@{{applicants.date_applied}}</p>
                                </li>
                                <li ng-repeat="note in appNotes[0].data.notes" class="TMS__applicant-note-item">
                                    <i class="fa fa-trash" confirmed-click="deleteNotes(applicants.object_id ,note.id)" ng-confirm-click="Are you sure you want to delete this?"  ></i>
                                    <p class="TMS__applicant-note">@{{note.note}}</p>
                                    <p class="TMS__applicant-note-job-title">@{{note.job_title}}</p>
                                    <p class="TMS__applicant-note-writer">@{{note.made_by.first_name}} @{{note.made_by.last_name}}</p>
                                    <p class="TMS__applicant-note-date">@{{note.date | date: 'longDate' }}</p>
                                </li>
                                </ul>
                            </div>
                            <div id="NotesSection"></div>
                            <form ng-submit="expandedNotes(applicants.id,   applicants.object_id, tmsSteps.applicantlist.stepid)" >
                                <div  ng-hide="notemsg" class="alert alert-success alert-dismissible" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <strong>Success!</strong> Note saved.
                                </div>
                                <textarea class="TMS__note-area" ng-model="savenotes[applicants.id]" placeholder="Add a note..." auto-resize></textarea>
                                <div class="text-right">
                                    <button type="button" class="btn-pvm btn-default btn-mini" ng-click="cancelNote(applicants.id)">Cancel</button>
                                    <input type="submit" value="Save" class="btn-pvm btn-primary btn-mini">
                                </div>
                            </form>
                        </div>
                    </section>
                    <div class="clearfix"></div>
                </li>

                    <!-- <li id="app@{{applicant.id}}" class="TMS__applicant-item" ng-repeat="applicant in list.applicants"> -->
                <li id="app@{{applicant.id}}" class="TMS__applicant-item" ng-repeat="applicant in tmsSteps.applicantlist.applicants">
                    <!-- <span class="TMS__print-loading" ng-class="{active : isDetailOn && activeCandidate == applicant.id}"> -->
                    <span class="applicant-item-link clear-float">
                        <span class="TMS__applicant-more-link" ng-click="expandme(applicant, tmsSteps.applicantlist.stepid, applicant.object_id, false, $event)">Read more <i class="icon-plus">&plus;</i></span>
                        <section class="TMS__applicant-identity" ng-click="expandme(applicant, tmsSteps.applicantlist.stepid, applicant.object_id, false, $event)">
                            <div class="applicant-item-drag" title="Drag and Drop to any bucket">
                                <img class="img-circle TMS__applicant-img" height="80" ng-show="applicant.docs.profile_image" ng-src="@{{applicant.docs.profile_image}}" width="80" ng-center-anchor="false" ng-drag="draggableCan" ng-drag-data="[applicant.object_id, tmsSteps.applicantlist.stepid, applicant.id]" ng-drag-success="onDragComplete($data,$event)" data-allow-transform="false" data-scroll-offset="true">
                                <div ng-show="!applicant.docs.profile_image" class="TMS__applicant-img member-initials member-initials--tms @{{applicant.profile_color}}" ng-center-anchor="false" ng-drag="draggableCan" ng-drag-data="[applicant.object_id, tmsSteps.applicantlist.stepid, applicant.id]" ng-drag-success="onDragComplete($data,$event)" data-allow-transform="false" data-scroll-offset="true">@{{applicant.initial}}</div>
                                <div ng-show="applicant.docs.profile_image == false " class="applicant-item-dummy TMS__applicant-img member-initials member-initials--tms @{{applicant.profile_color}}">@{{applicant.initial}}</div>
                            </div>
                            <h4 class="TMS__applicant-name">@{{applicant.first_name}} @{{applicant.last_name}}</h4>
                            <h5 class="TMS__applicant-rating" ng-show="applicant.ratings.total_emp_rated > 0">
                                <div class="TMS-ratingrated-div">
                                <div class="TMS-rating-ave-div">
                                    @{{applicant.ratings.average_rating}}
                                </div>
                                <div class="TMS-rating-star-div">
                                    <p>
                                    <div class="TMS-rating-star-con">
                                        <div class="TMS-star-top" ng-style="applicant.ratings.star_shade_width">
                                        <span>★</span><span>★</span><span>★</span><span>★</span><span>★</span>
                                        </div>
                                        <div class="TMS-star-bottom">
                                        <span>★</span><span>★</span><span>★</span><span>★</span><span>★</span>
                                        </div>
                                    </div>
                                    </p>
                                    <p>
                                    <span><i class="fa fa-user"></i> @{{'('+ applicant.ratings.total_emp_rated +')'}}</span>
                                    </p>
                                </div>
                                <div class="clearfix"></div>
                                </div>
                            </h5>
                            <p class="gpa gpa--blue"><span>GPA:</span> @{{applicant.custom_gpa.value ? applicant.custom_gpa.value : '--'}}</p>
                            <h5 class="TMS__applicant-work-exp">@{{applicant.application.experience}}</h5>

                            {{--##############################

                            SHOW "rateby" WHEN THERE IS RATING  

                            ##############################--}}

                            <div class="rateby hidden">
                                <p class="rateby__user">5 <span class="star">&starf;</span></p>
                                <span class="rateby__line">|</span>
                                <p class="rateby__ave">3.5 <span class="star">&starf;</span></p>
                                <p>@{{'(' + candidate_rating.total_emp_rated + ')'}}</p>
                            </div>

                            <div class="TMS__applicant-rating" ng-show="applicant.ratings.total_emp_rated == 0">
                                <!-- <i class="fa fa-star-o" style="font-size: 28px;"></i> -->
                                <span>Be the first to rate!</span>
                            </div>
                        </section>
                        {{-- <section class="viewby hidden">
                            <p>Viewed by</p>
                            <ul class="viewby__list">
                                <li class="viewby__list-item"></li>
                                <li class="viewby__list-item"></li>
                                <li class="viewby__list-item"></li>
                                <li class="viewby__list-item"></li>
                                <li class="viewby__list-item">+5</li>
                            </ul>
                        </section> --}}
                        <section class="TMS__applicant-qualifications">
                            
                            <input type="text" ng-if="JobData.job_status == 'closed' || JobData.job_status == 'withdraw' || JobData.job_status == 'hired'" ng-repeat="buckItem in tmsSteps.steps| filter:tmsSteps.applicantlist.stepid" ng-value="buckItem.name" disabled="disabled">
                            <div class="TMS-qualification-stat clear-float">

                                {{-- <div class="TMS-qualified TMS-qualified-req clear-float green" data-html="true" data-toggle="tooltip" data-placement="top" title="Candidate meets the profile requirements.<br><br>">
                                <h3>@{{applicant.custom_gpa.value ? applicant.custom_gpa.value : '--'}}</h3>
                                <small>GPA</small>
                                </div> --}}

                                <div class="TMS-qualified TMS-qualified-exp" ng-class="{green: applicant.application.color_panels.experience == 1 , orange: applicant.application.color_panels.experience == 2 , red: applicant.application.color_panels.experience == 0}" data-html="true" data-toggle="tooltip" data-placement="top" title="<strong>Green:</strong> candidate has the required number of years of experience in the actual role classification.<br><br><strong>Orange:</strong> candidate has less experience in the role classification than required, or candidate has the required number of years of experience in a different classification.<br><br><strong>Red: </strong>candidate does not have the required experience.<br>">
                                <h3>@{{applicant.application.work_exp.years}}</h3>
                                <small>EXP</small>
                                </div>

                                <div class="TMS-qualified TMS-qualified-loc" ng-class="{green: applicant.application.color_panels.location == 1 , orange: applicant.application.color_panels.location == 2 , red: applicant.application.color_panels.location == 0}" data-html="true" data-toggle="tooltip" data-placement="top" title="<strong>Green:</strong> candidate lives in the city where the role is located.<br><br><strong>Orange:</strong> candidate lives in the region where the role is located and/or is willing to relocate.<br><br><strong>Red:</strong> candidate does not live in the region where the role is located and does not want to relocate.<br><br>">
                                <h3><i class="fa fa-globe"></i></h3>
                                <small>LOC</small>
                                </div>

                                <div class="TMS-qualified TMS-qualified-req clear-float" ng-class="{green: applicant.application.color_panels.requirements == 1 ,orange: applicant.application.color_panels.requirements == 2 ,red: applicant.application.color_panels.requirements == 0}" data-html="true" data-toggle="tooltip" data-placement="top" title="Candidate meets the profile requirements.<br><br>">
                                <h3><i class="fa fa-check"></i></h3>
                                <small>REQ</small>
                                </div>

                            </div>

                            <select class="TMS__applicant-status pvm-textarea" ng-click="stopExpand()" ng-if="JobData.job_status != 'closed' && JobData.job_status != 'withdrawn' && JobData.job_status != 'hired'" ng-change="update(applicant.object_id, applicant.id, tmsSteps.applicantlist.stepid, [applicant.first_name, applicant.last_name]);" ng-model="selectmove[applicant.id]" ng-options="item as item.name for item in tmsSteps.steps track by item.id">
                                <option value="">select</option>
                            </select>
                            
                            <div class="TMS__team-actions clear-float">
                                <a href="#" class="TMS__team-action-links" ng-click="expandme(applicant.candidate, tmsSteps.applicantlist.stepid, applicant.object_id, true, $event, false)" title="Print @{{applicant.first_name}}'s Profile">
                                <i class="fa fa-print"></i>
                                <ul>
                                    <li></li>
                                    <li></li>
                                </ul>
                                </a>
                                <a href="{$BaseURL}employer/messages/#new_thread/@{{applicant.profile_url}}" class="TMS__team-action-links" title="Message @{{applicant.first_name}}">
                                <i class="fa fa-comments"></i>
                                </a>
                                <a href="#" class="TMS__team-action-links" ng-click="expandme(applicant.candidate, tmsSteps.applicantlist.stepid, applicant.object_id, false, $event, true)" title="Notes for @{{applicant.first_name}}">
                                <i class="fa fa-pencil-square">
                                    <span ng-show="applicant.notes_count != 0" class="TMS-note-count">@{{applicant.notes_count}}</span>
                                </i>
                                </a>
                                <a href="#" data-toggle="modal" data-target="#vidModal" ng-click="loadVideo(applicant.candidate, $event)" class="TMS__team-action-links TMS__team-action-links--vid" ng-if="applicant.docs.icebreaker_video.doc_url.length != 0" title="Play @{{applicant.first_name}}'s Video">
                                <i class="fa fa-play" ng-hide="videoLoaded"></i>
                                <i class="fa fa-spinner fa-spin" ng-show="videoLoaded"></i>
                                </a>
                                <p ng-if="applicant.docs.icebreaker_video.doc_url.length == 0" class="TMS__team-action-links TMS__team-action-links--disabled" title="No Video Available.">
                                <i class="fa fa-play"></i>
                                </p>
                                <a href="@{{applicant.docs.resume.doc_url}}" ng-if="applicant.docs.resume.doc_url" class="TMS__team-action-links" target="_blank" title="View @{{applicant.first_name}}'s Resume">
                                <i class="fa fa-file-text-o"></i>
                                </a>
                                <p ng-if="!applicant.docs.resume.doc_url" class="TMS__team-action-links TMS__team-action-links--disabled" title="No Resume Available.">
                                <i class="fa fa-file-text-o"></i>
                                </p>
                            </div>
                            
                        </section>
                    </span>
                </li>
            </ul>
            <div ng-show="candidatenoretrieved">
                No Applicants retrieved.
            </div>

            <a ng-click="LoadMore(tmsSteps.applicantlist.scrolling.offset + tmsSteps.applicantlist.scrolling.limit, tmsSteps.applicantlist.stepid)" ng-show="tmsSteps.applicantlist.scrolling.more_present" class="TMS__more-applicant clear-float">Load More</a>
            <div ng-show="tmsSteps.applicantlist.applicantCount == 0">No Applicants assigned on this section</div>
        </div>
        <section ng-show="tms_failedstatus">
        <!-- <div style="float:left;"><i class="fa fa-exclamation"></i></div> -->
        <!-- <div style="float:left;"> -->
            <p>Something went wrong. Failed to retrieve the applicant list. </p>
            <p>Kindly ask for assistance.</p>
        <!-- </div> -->
        <!-- <div class="clearfix"></div> -->
        </section>
    </div>
</section>