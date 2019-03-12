<h2 class="role__label">
    Skills Requirements
    <i class="fa fa-question pvm-tooltip" data-html="true" data-toggle="tooltip" data-placement="right" title=" Where are your skill gaps (if any)? Think about what the minimum requirements are for individuals applying for the role to give you what you need. <br><br>Accurately identifying non-negotiable (must have) skills, experience, location etc helps ensure you only process the right candidates.<br><br>“Essential / non-negotiable” and “nice to have” requirements are automatically cloned to create the role’s pre-apply questions below. "></i>
</h2>
<!--<a href="#" class="btn-pvm btn-mini btn-primary role__pull-btn--gen">Pull from Existing</a>-->
<div class="role__inspirations" ng-init="insp = false">
<h3 class="role__sublabel">Stuck? Have some inspiration</h3>
<i class="fa" ng-click="insp = !insp" ng-class="{'fa-minus' : insp, 'fa-plus' : !insp}"></i>
<p class="role__subdesc" ng-show="insp">Here are some question suggestions. Simply drag & drop the snippets into your questions text box</p>
<ul class="role__inspiration-list" ng-show="insp">
    <li class="role__inspiration-item" ng-repeat="inspirationItem in skillsinspirationList" ng-click="pushInspirationSkill(inspirationItem)">@{{inspirationItem.name}}</li>
</ul>
<i class="fa fa-spinner fa-spin fa-3x fa-fw" ng-show="loading_insp_skills"></i>
<span class="role__shuffle" ng-show="insp" ng-click="shuffle_skills()">
    <i class="fa fa-random"></i>
</span>
</div>
<p class="role__sublabel">What do they need?</p>
<!-- <h6 class="role__sublabel role__sublabel--gray">(Presented in the Role Listing as "On a normal day you'll get to..")</h6> -->
<h6 class="role__sublabel role__sublabel--gray">(Presented in the Role as "We are looking for someone who/with..")</h6>
<ul class="role__responsibilities-list">
<li class="role__responsibilities-item" ng-repeat="skillRequirement in roleCreate_watch.requirements">
    <textarea type="text" ng-model="skillRequirement.name" class="role__resp-text" required></textarea>
    <label ng-repeat="reqType in reqTypes" class="role__answers"
            ng-class="{'role__answers--yes' : reqType.value == 'Primary' , 'role__answers--no' : reqType.value == 'Secondary',
        'role__answers--answered' : reqType.value == skillRequirement.type}">
    <input type="radio" name="prioriti" ng-model="skillRequirement.type" ng-value="reqType.value" ng-change="changePrioritiesSkill(skillRequirement.type, skillRequirement)"> @{{reqType.type_display_name}}
    </label>
    <span class="role__close-btn" ng-click="delMyInspSkillItem(skillRequirement)"><i class="fa fa-close"></i></span>
</li>
</ul>
<a href="" class="btn-pvm btn-mini btn-primary role__add-resps" ng-click="addBlankSkill()"><i class="fa fa-plus"></i> Add</a>