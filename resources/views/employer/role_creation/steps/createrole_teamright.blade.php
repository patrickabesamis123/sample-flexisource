<h2 class="role__label role__label--full">Team Members</h2>
<ul class="role__member-list">
  <li class="role__member-item" ng-repeat="selectedMember in selectedMembers">
    <img src="@{{selectedMember.profile_picture_url}}" ng-if="selectedMember.profile_picture_url" class="role__team-img">
    <div class="role__team-img member-initials" ng-if="!selectedMember.profile_picture_url" ng-class="selectedMember.profile_color">@{{selectedMember.initial}}</div>
    <span class="role__member-name">@{{selectedMember.first_name}} @{{selectedMember.last_name}}</span><i class="fa fa-close role__close-btn" ng-click="RemoveTeamMember(selectedMember, 'member')"></i>
  </li>
</ul>
<h2 class="role__label role__label--full">Teams</h2>
<p ng-if="selectedTeams.length <= 0">No team provided.</p>
<ul class="role__member-list">
  <li class="role__member-item" ng-repeat="selectedTeam in selectedTeams">
    <span class="role__member-name">@{{selectedTeam.team_name}}</span><i class="fa fa-close role__close-btn" ng-click="RemoveTeamMember(selectedTeam, 'team')"></i>
  </li>
</ul>
<h2 class="role__label role__label--full">Role Manager</h2>
<p ng-if="!roleManager.id">No role manager provided.</p>
<ul class="role__member-list" ng-if="roleManager.id">
  <li class="role__member-item">
    <img src="@{{roleManager.profile_picture_url}}" ng-if="roleManager.profile_picture_url" class="role__team-img">
    <div class="member-initials" ng-if="!roleManager.profile_picture_url" class="role__team-img" ng-class="roleManager.profile_color">@{{roleManager.initial}}</div>
    <span class="role__member-name">@{{roleManager.first_name}} @{{roleManager.last_name}}</span>
  </li>
</ul>