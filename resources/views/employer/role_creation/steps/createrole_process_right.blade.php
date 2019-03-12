<ul ui-sortable="sortableOptions" class="role__bucket-list" id="bucketSortable" ng-model="bucketListDB">
        <li class="ui-state-default role__bucket-item" ng-repeat="bucketItem in bucketListDB" ng-class="{'role__bucket-item--blank' : bucketItem.name == 'Create new', 'not-sortable' : bucketItem.forced || bucketItem.id == 5 || bucketItem.slug_name == 'create_new' || bucketItem.slug_name == 'create-new'}">
          <h1 class="role__bucket-number" ng-click="bucketItem.showNewSteps=true">@{{bucketItem.order}}</h1>
          <p class="role__bucket-desc" ng-hide="bucketItem.showNewSteps">@{{bucketItem.name}}</p>
          <!--<h1 class="role__bucket-number--add"><i class="fa fa-plus" ng-show="!showNewSteps"></i><span ng-show="showNewSteps">@{{bucketItem.order}}</span></h1>
          <p class="role__bucket-desc--add" ng-show="!showNewSteps">Add Stage</p>
          <input type="text" class="pvm-input-text role__bucket-stage" ng-class="{'role__bucket-stage--show':showNewSteps}" ng-model="bucketItem.name" ng-blur="checkBucketName(bucketItem)">-->
          <input type="text" class="pvm-input-text role__bucket-stage" ng-show="bucketItem.showNewSteps" ng-model="bucketItem.name" ng-blur="checkBucketName(bucketItem)">
          <i class="fa fa-close" ng-click="bucketItem.showNewSteps=false" ng-show="bucketItem.showNewSteps"></i>
        </li>
      </ul>
      <p class="role__subdesc">* You must rename the "Create new" custom bucket first before you can move it.</p>