<h2 class="role__label">General Information</h2>
<!--<a href="#" class="btn-pvm btn-mini btn-primary role__pull-btn--gen">Pull from Existing</a>-->
<section class="section">
  <p class="role__sublabel">
    Role in a nutshell (describe your role briefly):
    <i class="fa fa-question pvm-tooltip"  data-toggle="tooltip" data-placement="right" title=" You have articulated the elements of the role, now summarise it. Be short and sharp, this “in a nutshell” will be the first thing a prospective candidate will see as part of the role’s synopsis (along with your role video)."></i>
  </p>
  <!-- start: job description -->
  <p class="role__sublabel role__sublabel--gray">(Presented in the Role Listing under the “We are looking for“ section)</p>
  <textarea ng-model="roleCreate_watch.job_description" class="role__desc-text" name="roleDesc" ng-required="true" ng-keyup="previewDesc(roleCreate_watch.job_description)" required></textarea>
  <!-- end: job description -->
</section>

<section class="section">
  <!-- start: role type -->
  <p class="role__sublabel">Role type</p>
  <h6 class="role__sublabel role__sublabel--gray">Tick all that apply</h6>
  <ul class="role__role-types-list">
    <li class="role__role-types-item" ng-repeat="roleType in roleTypes">
      <label class="role__role-type">
        {{-- <input type="radio" ng-model="roleCreate_watch.role_type" ng-value="roleType" name="roletype"> @{{roleType.name}} --}}
        <input type="checkbox"> @{{roleType.name}}
      </label>
    </li>
  </ul>
  <!-- end: role type -->
</section>
<section class="section">
  <!-- start: days required -->
  <p class="role__sublabel">Days Required <span class="text-danger">*</span></p>
  <label ng-repeat="workday in workdays" class="role__answers"
        ng-class="{'role__answers--yes' : workday.substrdays == 'Mon' , 'role__answers--no' : workday.substrdays == 'Sun',
        'role__answers--answered' : workDaysCheck.indexOf(workday.id) > -1}">
    <input type="checkbox" checklist-model="workDaysCheck" checklist-value="workday.id"> (@{{workday.substrdays}})
  </label>
  <!-- end: days required -->

  <div class="flexbox">
    <!-- start: hours -->
    <p class="role__sublabel">Hours <span class="text-danger">*</span></p>
      <!-- start: start_time -->
    <select ng-model="start_time" class="pvm-select role__work-hrs role__work-hrs--time" ng-options="item as item.text for item in start_time_list track by item.value" required>
      <option value="">Select</option>
    </select>
      <!-- end: start_time -->

      <!-- start: start_apmpm -->
    <select ng-model="start_ampm" class="pvm-select role__work-hrs role__work-hrs--format" ng-options="item as item.text for item in ampm track by item.value" required>
      <option value="">Select</option>
    </select>
      <!-- end: start_apmpm -->

    <span class="role__to-label">to</span>
      
    <!-- start: finish_time -->
    <select ng-model="finish_time" class="pvm-select role__work-hrs role__work-hrs--time" ng-options="item as item.text for item in end_time_list track by item.value" required>
      <option value="">Select</option>
    </select>
    <!-- end: finish_time -->

    <!-- start: end_apm -->
    <select ng-model="end_ampm" class="pvm-select role__work-hrs role__work-hrs--format" ng-options="item as item.text for item in ampm track by item.value" required>
      <option value="">Select</option>
    </select>
    <!-- end: end_apm -->

    <label class="role__flexibile-hr">
      <input type="checkbox" ng-model="flexiHardcode" ng-value="true"> Flexible hours
    </label>
    <!-- end: hours -->
  </div>
</section>

<section class="section">
  <!-- start: salary type -->
  <div class="role__salary">
    <p class="role__sublabel">Salary type <span class="text-danger">*</span></p>
    <!-- start: salType -->
    <select ng-model="salType" class="pvm-select role__sal-type" ng-options="salary as salary.text for salary in salaryType track by salary.value" required>
      <option value="">Select</option>
    </select>
    <!-- end: salType -->

    <!-- start: is_salary_public -->
    <label class="role__published-role">
      Publish salary? <input type="checkbox" ng-model="roleCreate_watch.is_salary_public">
    </label>
    <span class="role__published-role" ng-show="roleCreate_watch.is_salary_public">Salary details displayed: <i class="fa fa-question pvm-tooltip" data-toggle="tooltip" data-placement="right" title="e.g. 40k - 50k commision"></i></span>
    <textarea ng-model="roleCreate_watch.salary_notes" ng-show="roleCreate_watch.is_salary_public"></textarea>
    <!-- end: is_salary_public -->
  </div>
  <!-- end: salary type -->

  <!-- start: salary range -->
  <div class="role__salary">
    <p class="role__sublabel">Salary range <span class="text-danger">*</span></p>
    <!-- start: salRangeMin -->
    <select ng-model="salRangeMin" class="pvm-select role__sal-range role__sal-range--min" ng-options="item as item.text for item in salaryRangeMin track by item.value" required>
      <option value="">Select</option>
    </select>
    <!-- end: salRangeMin -->

    <span class="role__to-label">to</span>

    <!-- start: salRangeMax -->
    <select ng-model="salRangeMax" class="pvm-select role__sal-range role__sal-range--max" ng-options="item as item.text for item in salaryRangeMax track by item.value" required>
      <option value="">Select</option>
    </select>
    <!-- end: salRangeMax -->

    <!-- start: roleHourlyRate -->
    <label class="role__consider-hr-rate">
      Consider hourly rate? <input type="checkbox" ng-model="roleHourlyRate" ng-checked="hourlyrate_textarea()">
    </label>
    <!-- end: roleHourlyRate -->
  </div>
  <!-- end: salary range -->
</section>

<section class="section">
  <!-- start: role management -->
  <p class="role__sublabel">Will this role involve leading/managing a team?
    <i class="fa fa-question pvm-tooltip" data-toggle="tooltip" data-placemnt="right" title="If the role leads or manages a team, consider asking questions to validate any candidate experience when building the  pre-apply and secondary questions below"></i>
  </p>
  <div class="role__involve-mngt">
    <label class="role__mgnt-ans">
      <input type="radio" ng-model="roleCreate_watch.lead_manage_team" name="chkManaging" value="1"> Yes
    </label>
    <label class="role__mgnt-ans">
      <input type="radio" ng-model="roleCreate_watch.lead_manage_team" name="chkManaging" value="0"> No
    </label>
  </div>
  <!-- end: role management -->
</section>

<section class="section">
  <!-- start: roleClassif && roleSubClassif-->
  <div class="role__classifications">
    <p class="role__sublabel">Classification <span class="text-danger">*</span></p>
    <!-- start: roleClassif -->
    <select ng-model="roleClassif" class="pvm-select role__classification" ng-change="changeIndustry()" ng-options="item as item.display_name for item in classifications track by item.id" required>
      <option value="">Select</option>
    </select>
    <!-- end: roleClassif -->
  </div>

  <div class="role__classifications">
    <p class="role__sublabel">Sub-classification <span class="text-danger">*</span></p>
    <!-- start: roleSubClassif -->
    <select ng-model="roleSubClassif" name="roleSubClassif" class="pvm-select role__classification role__classification--sub" ng-options="sub as sub.display_name for sub in subclassifications track by sub.id" required>
      <option value="">Select</option>
    </select>
    <!-- end: roleSubClassif -->
  </div>
  <!-- end: roleClassif && roleSubClassif-->

  <!-- start: expRangeMin && expRangemax -->
  <p class="role__sublabel">Experience (in years) <span class="text-danger">*</span></p>
  <select ng-model="expRangeMin" class="pvm-select role__exp-range role__exp-range--min" ng-change="changeMinExp()" ng-options="item as item.text for item in min_experience_list track by item.value" required ng-class="{'ng-invalid' : !expRangeMin}">
    <option value="">Select</option>
  </select>

  <span class="role__to-label">to</span>
  <select ng-model="expRangeMax" class="pvm-select role__exp-range role__exp-range--max" ng-change="changeMaxExp()" ng-options="item as item.text for item in max_experience_list track by item.value" required ng-class="{'ng-invalid' : !expRangeMax || expRangeMax == ''}">
    <option value="">Select</option>
  </select>
  <!-- end: expRangeMin && expRangemax -->
</section>

<section class="section">
  <!-- start: roleLocation && roleSubLocation -->
  <p class="role__sublabel">Location <span class="text-danger">*</span></p>
    
  <div class="role__locations">
  <!-- start: roleLocation -->
    <select ng-model="roleLocation" class="pvm-select role__location" ng-options="loc as loc.display_name for loc in countries track by loc.id" required>
      <option value="">Select</option>
    </select>
    <!-- end: roleLocation -->
  </div>

  <div class="role__locations">
  <!-- start: roleSubLocation -->
    <input id="location" ng-model="roleSubLocation" type="text" class="pvm-input-text role__location role__locations--sub" autocomplete="off" required>
    <input type="hidden" ng-model="LocationId" id="LocationId">
    <ul id="autoDataLocation" class="result" style="display:none">
      <li ng-repeat="(key, value) in autoLocation">
        <a href="" data-value="(@{{value.id}})" ng-click="getAutoCompleteData( value  )" class="autodata" style="display:block">(@{{value.display_name}})</a>
      </li>
    </ul>
    <!-- end: roleSubLocation -->
  </div>
  <!-- end: roleLocation && roleSubLocation -->
</section>

<section class="section">
  <!-- start: start_date -->
  <p class="role__sublabel">Start Date <span class="text-danger">*</span></p>
  <select ng-model="roleDayPass" ng-class="{'pvm-select--disabled' : roleCreate_watch.immediate_start}" class="pvm-select role__report-date " ng-options="item as item.label for item in roleDay track by item.value" required ng-disabled="roleCreate_watch.immediate_start">
    <option>Select</option>
  </select>
  <select ng-model="roleMoPass" ng-class="{'pvm-select--disabled' : roleCreate_watch.immediate_start}" class="pvm-select role__report-date" ng-options="item as item.label for item in roleMonth track by item.value" required ng-disabled="roleCreate_watch.immediate_start">
    <option>Select</option>
  </select>
  <select ng-model="roleYrPass" ng-class="{'pvm-select--disabled' : roleCreate_watch.immediate_start}" class="pvm-select role__report-date" ng-options="item as item.label for item in roleYear track by item.value" required ng-disabled="roleCreate_watch.immediate_start">
    <option>Select</option>
  </select>
  <label class="role__immediate">
    Immediate start? <input type="checkbox" ng-model="roleCreate_watch.immediate_start" name="immediateStart" ng-checked="roleCreate_watch.immediate_start">
  </label>
  <!-- end: start_date -->
</section>
<section class="section">
  <p class="role__sublabel">The role will be available for </p>
  <select ng-model="roleAvailability" class="pvm-select role__availability" ng-options="roledur as roledur.text for roledur in JobAvailabitily track by roledur.value" required>
    <option value="">Select</option>
  </select>
  <div class="role__availability_date">
    (@{{role_dateexpiry}})
  </div>
  <!--<div class="role__availability_date">
    (Role expire at 11:59 pm on this date.)
  </div>-->
</section>