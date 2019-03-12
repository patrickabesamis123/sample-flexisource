<section class="TMS-applicants-view clear-float">
    <div class="TMS-applicants-showfilter-div" ng-click="toggleFilter()">
        <div class="showfilter-left--div">
        <span>
            <div><i class="fa fa-filter"></i> FILTERS</div>
            <small ng-if="filterTags.Education.length > 0">
            <ul class="showfilter-span-textmod">
                <li class="showfilter-li-header" style="">Education Providers:  </li>
                <li class="showfilter-li-items" ng-click="removeFilteredItem(filterTags.Education, espfil, 'esp')" ng-repeat="espfil in filterTags.Education">
                <span>@{{espfil}}</span>
                <i class="fa fa-close"></i>
                </li>
            </ul>
            <div class="clearfix"></div>
            </small>
            <small ng-if="filterTags.Gender > 0">@{{'  Gender: (' +  filterTags.Gender + ') '}}</small>
            <small ng-if="filterTags.Languages > 0">@{{'  Languages: (' +  filterTags.Languages + ') '}}</small>
            <small ng-if="filterTags.GPA.length > 0">
            <ul class="showfilter-span-textmod">
                <li class="showfilter-li-header" style="">GPA:  </li>
                <li class="showfilter-li-items" ng-click="removeFilteredItem(filterTags.gpa_id, gpafil, 'gpa')" ng-repeat="gpafil in filterTags.GPA">
                <span>@{{gpafil}}</span>
                <i class="fa fa-close"></i>
                </li>
            </ul>
            <div class="clearfix"></div>
            </small>
            <small ng-if="filterTags.Locations.length > 0">
            <ul class="showfilter-span-textmod">
                <li class="showfilter-li-header" style="">Locations:  </li>
                <li class="showfilter-li-items" ng-click="removeFilteredItem(filterTags.Locations, locfil, 'loc')" ng-repeat="locfil in filterTags.Locations">
                <span>@{{locfil}}</span>
                <i class="fa fa-close"></i>
                </li>
            </ul>
            <div class="clearfix"></div>
            </small>
            <small ng-if="filterTags.Experience.length > 0">
            <ul class="showfilter-span-textmod">
                <li class="showfilter-li-header" style="">Experience:  </li>
                <li class="showfilter-li-items" ng-click="removeFilteredItem(filterTags.Experience, expfil, 'exp')" ng-repeat="expfil in filterTags.Experience">
                <span>@{{expfil + ' yrs'}}</span>
                <i class="fa fa-close"></i>
                </li>
            </ul>
            <div class="clearfix"></div>
            </small>
            <small ng-if="filterTags.Star.length > 0">
            <ul class="showfilter-span-textmod">
                <li class="showfilter-li-header" style="">Ratings:  </li>
                <li class="showfilter-li-items" ng-click="removeFilteredItem(filterTags.Star, starfil, 'star')" ng-repeat="starfil in filterTags.Star">
                <i class="fa fa-star"></i>
                <span>@{{starfil}}</span>
                <i class="fa fa-close"></i>
                </li>
            </ul>
            <div class="clearfix"></div>
            </small>
        </span>
        </div>
        <div class="showfilter-right--div" title="Apply Filter">
        <span ng-click="ApplyFilter()" ng-show="!applyingFilters">
            <i class="fa fa-refresh"></i>
        </span>
        <span ng-show="applyingFilters">
            <i class="fa fa-spinner fa-pulse"></i>
        </span>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="TMS-applicants-filter-container-div" ng-show="showFilter">
        <div class="applicants-filter-left-div">
        <div class="TMS-applicants-filter-inner-div" ng-show="tmsfilter.esp">
            <label class="filter__main-item filterTitle--violet pvm-checkbox" ng-click="checkChildren('esp')">
            <input type="checkbox" class="filtercheckbox job-filter__sub-checkbox" ng-model="isSelectedEsp" ng-true-value="true" ng-false-value="false" ng-change="checkChildren('esp')" />
            <i class="fa fa-check" ng-show="isSelectedEsp"></i>
            <h5 class="job-filter__header">Education Providers</h5>
            </label>
            <div class="tse-scrollable filter-sub-div" id="prime_esp">
            <ul class="tse-content filter-sub-ul">
                <li class="filter-sub-li" ng-repeat="esp in tmsfilter.esp">
                <label class="job-filter__checkbox pvm-checkbox">
                    <input type="checkbox" class="check-floatleft__i" ng-model="esp.selected" ng-true-value="true" ng-false-value="false" ng-change="optionToggled('esp')" />
                    <i class="fa fa-check" ng-show="esp.selected"></i>
                    <span class="check-floatleft__i">@{{esp.name}}</span>
                </label>
                </li>
            </ul>
            </div>
        </div>

        <div class="TMS-applicants-filter-inner-div" ng-show="tmsfilter.gpa_id">
            <label class="filter__main-item filterTitle--blue pvm-checkbox" ng-click="checkChildren('gpa')">
            <input type="checkbox" class="filtercheckbox job-filter__sub-checkbox" ng-model="isSelectedGPA" ng-true-value="true" ng-false-value="false" ng-change="checkChildren('gpa')" />
            <i class="fa fa-check" ng-show="isSelectedGPA"></i>
            <h5 class="job-filter__header">GPA</h5>
            </label>
            <div class="tse-scrollable filter-sub-div">
            <ul class="tse-content filter-sub-ul">
                <li class="filter-sub-li" ng-repeat="gpa in tmsfilter.gpa_id">
                <label class="job-filter__checkbox pvm-checkbox">
                    <input type="checkbox" class="check-floatleft__i" ng-model="gpa.selected" ng-true-value="true" ng-false-value="false" ng-change="optionToggled('gpa')"/>
                    <i class="fa fa-check" ng-show="gpa.selected"></i>
                    <span class="check-floatleft__i">@{{gpa.name}}</span>
                </label>
                </li>
            </ul>
            </div>
        </div>

        <div class="TMS-applicants-filter-inner-div" ng-show="tmsfilter.work_experience_in_years">
            <label class="filter__main-item filterTitle--blue pvm-checkbox" ng-click="checkChildren('exp')">
            <input type="checkbox" class="filtercheckbox job-filter__sub-checkbox" ng-model="isSelectedExperience" ng-true-value="true" ng-false-value="false" ng-change="checkChildren('exp')" />
            <i class="fa fa-check" ng-show="isSelectedExperience"></i>
            <h5 class="job-filter__header">Work Experience (years)</h5>
            </label>
            <div class="tse-scrollable filter-sub-div">
            <ul class="tse-content filter-sub-ul">
                <li class="filter-sub-li" ng-repeat="exp in tmsfilter.work_experience_in_years">
                <label class="job-filter__checkbox pvm-checkbox">
                    <input type="checkbox" class="check-floatleft__i" ng-model="exp.selected" ng-true-value="true" ng-false-value="false" ng-change="optionToggled('exp')"/>
                    <i class="fa fa-check" ng-show="exp.selected"></i>
                    <span class="check-floatleft__i">@{{exp.name}}</span>
                </label>
                </li>
            </ul>
            </div>
        </div>

        <div class="TMS-applicants-filter-inner-div" ng-show="tmsfilter.ratings">
            <label class="filter__main-item filterTitle--orange pvm-checkbox" ng-click="checkChildren('exp')">
            <input type="checkbox" class="filtercheckbox job-filter__sub-checkbox" ng-model="isSelectedStar" ng-true-value="true" ng-false-value="false" ng-change="checkChildren('star')" />
            <i class="fa fa-check" ng-show="isSelectedStar"></i>
            <h5 class="job-filter__header">Ratings</h5>
            </label>
            <div class="tse-scrollable filter-sub-div">
            <ul class="tse-content filter-sub-ul">
                <li class="filter-sub-li" ng-repeat="star in tmsfilter.ratings">
                <label class="job-filter__checkbox pvm-checkbox">
                    <input type="checkbox" class="check-floatleft__i" ng-model="star.selected" ng-true-value="true" ng-false-value="false" ng-change="optionToggled('star')"/>
                    <i class="fa fa-check" ng-show="star.selected"></i>
                    <span class="check-floatleft__i">@{{star.name}}</span>
                </label>
                </li>
            </ul>
            </div>
        </div>

        <div class="TMS-applicants-filter-inner-div" ng-show="tmsfilter.locations">
            <label class="filter__main-item filterTitle--green pvm-checkbox" ng-click="checkChildren('location')">
            <input type="checkbox" class="filtercheckbox job-filter__sub-checkbox" ng-model="isSelectedLocation" ng-true-value="true" ng-false-value="false" ng-change="checkChildren('location')" />
            <i class="fa fa-check" ng-show="isSelectedLocation"></i>
            <h5 class="job-filter__header">Locations</h5>
            </label>
            <div class="tse-scrollable filter-sub-div" id="prime_loc">
            <ul class="tse-content filter-sub-ul">
                <li class="filter-sub-li" ng-repeat="location in tmsfilter.locations">
                <label class="job-filter__checkbox pvm-checkbox">
                    <input type="checkbox" class="check-floatleft__i" ng-model="location.selected" ng-true-value="true" ng-false-value="false" ng-change="optionToggled('location')"/>
                    <i class="fa fa-check" ng-show="location.selected"></i>
                    <span class="check-floatleft__i">@{{location.name}}</span>
                </label>
                </li>
            </ul>
            </div>
        </div>


        <div class="clearfix"></div>
        </div>

        <div class="applicants-filter-right-div">
        <div class="TMS-applicants-filter-control-div">
            <div>
            <button class="btn-pvm btn-primary btn-mini filterapply-btn--width" ng-click="ApplyFilter()">
                Apply
            </button>
            <button class="btn-pvm btn-default btn-mini filterapply-btn--width" ng-click="filterClearAll()">Clear All</button>
            </div>
            <div>
            <p class="filter-control-inner-p">
                <i>Note: Filters vary on each bucke/step that you are currently viewing. Also, filter options are dynamic and will only appear depending on the applicants' data on that bucket/step.</i>
            </p>
            </div>
        </div>
        </div>
        <div class="clearfix"></div>
    </div>
</section>