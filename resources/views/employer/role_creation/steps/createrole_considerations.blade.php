<h2 class="role__label">Considerations and Benefits</h2>
<!--<a href="#" class="btn-pvm btn-mini btn-primary role__pull-btn--gen">Pull from Existing</a>-->
<p class="role__sublabel">
  Why would the ideal candidate want this role?
  <button type="button" class="glyphicon glyphicon-info-sign tooltip_btn" data-toggle="tooltip" data-placement="right" title=" Sell the role! Think about career growth opportunity? Bonus’? Team environment? You are creating more than just a job."></button>
</p>
<h6 class="role__sublabel role__sublabel--gray">(Presented in the Role Listing as "You will want to work with us because..")</h6>
<div class="role__con" ng-repeat="objective in roleCreate_watch.objectives">
  <textarea class="role__reason" ng-model="objective.name" required></textarea>
  <span class="role__close-btn" ng-click="delMyObjItem(objective)"><i class="fa fa-close"></i></span>
</div>
<a href="" class="btn-pvm btn-mini btn-primary role__add-reasons" ng-click="addBlankObj()"><i class="fa fa-plus"></i> Add</a>
<p class="role__sublabel">Company benefits (For all company roles)</p>
<h6 class="role__sublabel role__sublabel--gray">(Presented in the Role Listing as "Company benefits include..")</h6>
<!--<a href="#" class="btn-pvm btn-mini btn-primary role__pull-btn--consi">Pull from Existing</a>-->

<ul class="role__perks-list">
  <li class="role__perks-item" ng-repeat="benefit in roleCreate_watch.benefits">
    <textarea type="text" ng-model="benefit.name" class="role__resp-text" required></textarea>
    <label ng-repeat="benefitPayable in benefitsPayable" class="role__answers"
           ng-class="{'role__answers--yes' : benefitPayable.value == 1 , 'role__answers--no' : benefitPayable.value == 2,
       'role__answers--answered' : benefitPayable.value == benefit.type}">
      <input type="radio" name="prioriti" ng-model="benefit.type" ng-value="benefitPayable.value" ng-change="changePrioritiesBen(benefit.type, benefit)"> @{{benefitPayable.label}}
    </label>
    <span class="role__close-btn" ng-click="delMyInspItem(benefit)"><i class="fa fa-close"></i></span>
  </li>
</ul>
<a href="" class="btn-pvm btn-mini btn-primary role__add-reasons" ng-click="addBlankBen()"><i class="fa fa-plus"></i> Add</a>

<p class="role__sublabel">To increase the candidate pool will you consider:</p>
<ul class="role__consideration-list">
  <li class="role__consideration-item">
    <span class="role__consideration">Flexible working</span>
    <label ng-repeat="myConItem in myConList2" class="role__answers"
           ng-class="{'role__answers--yes' : myConItem.value == 'Yes' , 'role__answers--no' : myConItem.value == 'No',
       'role__answers--answered' : myConItem.value == roleCreate_watch.search_helpers.flexible_working}">
      <input type="radio" name="consAns" ng-model="roleCreate_watch.search_helpers.flexible_working" ng-value="myConItem.label" ng-change="changeHelper(roleCreate_watch.search_helpers.flexible_working,myConItem)"> @{{myConItem.label}}
    </label>
  </li>
  <li class="role__consideration-item">
    <span class="role__consideration">Part time</span>
    <label ng-repeat="myConItem in myConList2" class="role__answers"
           ng-class="{'role__answers--yes' : myConItem.value == 'Yes' , 'role__answers--no' : myConItem.value == 'No',
       'role__answers--answered' : myConItem.value == roleCreate_watch.search_helpers.part_time}">
      <input type="radio" name="consAns" ng-model="roleCreate_watch.search_helpers.part_time" ng-value="myConItem.label" ng-change="changeHelper(roleCreate_watch.search_helpers.part_time,myConItem)"> @{{myConItem.label}}
    </label>
  </li>
  <li class="role__consideration-item">
    <span class="role__consideration">Going above salary band</span>
    <label ng-repeat="myConItem in myConList2" class="role__answers"
           ng-class="{'role__answers--yes' : myConItem.value == 'Yes' , 'role__answers--no' : myConItem.value == 'No',
       'role__answers--answered' : myConItem.value == roleCreate_watch.search_helpers.above_salary_band}">
      <input type="radio" name="consAns" ng-model="roleCreate_watch.search_helpers.above_salary_band" ng-value="myConItem.label" ng-change="changeHelper(roleCreate_watch.search_helpers.above_salary_band,myConItem)"> @{{myConItem.label}}
    </label>
  </li>
  <li class="role__consideration-item">
    <span class="role__consideration">Someone with high potential / less experience</span>
    <label ng-repeat="myConItem in myConList2" class="role__answers"
           ng-class="{'role__answers--yes' : myConItem.value == 'Yes' , 'role__answers--no' : myConItem.value == 'No',
       'role__answers--answered' : myConItem.value == roleCreate_watch.search_helpers.high_potential_less_experience}">
      <input type="radio" name="consAns" ng-model="roleCreate_watch.search_helpers.high_potential_less_experience" ng-value="myConItem.label" ng-change="changeHelper(roleCreate_watch.search_helpers.high_potential_less_experience,myConItem)"> @{{myConItem.label}}
    </label>
  </li>
</ul>
