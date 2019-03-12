<h2 class="role__label">Responsibilities<i class="fa fa-question pvm-tooltip" data-html="true" data-toggle="tooltip" data-placement="right" title=" Treat recruitment as an opportunity. Think critically about what the prospective employee will be doing and rank those activities as being primary or secondary responsibilities.<br><br> Primary Responsibilities are what the candidate will be doing on a day to day basis and are displayed in the role synopsis. Secondary Responsibilities are made visible when candidates click into the role. "></i></h2>
<!--<a href="#" class="btn-pvm btn-mini btn-primary role__pull-btn--gen">Pull from Existing</a>-->
<div class="role__inspirations" ng-init="insp = false">
<h3 class="role__sublabel">Stuck? Have some inspiration</h3>
<i class="fa" ng-click="insp = !insp" ng-class="{'fa-minus' : insp, 'fa-plus' : !insp}"></i>
<p class="role__subdesc" ng-show="insp">Here are some question suggestions. Simply drag & drop the snippets into your questions text box</p>
<ul class="role__inspiration-list" ng-show="insp">
    <li class="role__inspiration-item" ng-repeat="inspirationItem in inspirationList" ng-click="pushInspiration(inspirationItem)">@{{inspirationItem.name}}</li>
</ul>
<i class="fa fa-spinner fa-spin fa-3x fa-fw" ng-show="loading_insp_resp"></i>
<span class="role__shuffle" ng-show="insp" ng-click="shuffle_resp()">
    <i class="fa fa-random"></i>
</span>
</div>
<p class="role__sublabel">What will they do?</p>
<h6 class="role__sublabel role__sublabel--gray">(Presented in the Role Listing as "On a normal day you'll get to..")</h6>
<ul class="role__responsibilities-list">
    <li class="role__responsibilities-item" ng-repeat="myInspirationItem in myInspirationList">
        <textarea type="text" ng-model="myInspirationItem.name" class="role__resp-text" required></textarea>
        <label ng-repeat="respPriority in respPriorities" class="role__answers"
                ng-class="{'role__answers--yes' : respPriority.type_display_name == 'primary' , 'role__answers--no' : respPriority.type_display_name == 'secondary',
            'role__answers--answered' : respPriority.type_display_name == myInspirationItem.type}">
        <input type="radio" name="prioriti" ng-model="myInspirationItem.type" ng-value="respPriority.type_display_name" ng-click="changePriorities(myInspirationItem.type,myInspirationItem)"> @{{respPriority.type_display_name}}
        </label>
        <span class="role__close-btn"><i class="fa fa-close" ng-click="delMyInsp(myInspirationItem)"></i></span>
    </li>
</ul>
<a href="" class="btn-pvm btn-mini btn-primary role__add-resps" ng-click="addBlankResp()"><i class="fa fa-plus"></i> Add</a>