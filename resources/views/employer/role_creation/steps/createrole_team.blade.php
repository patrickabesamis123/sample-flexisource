<h2 class="role__label role__label--full">Build your team</h2>
<p class="role__sublabel">Assign team members</p>
<div class="role__team-box">
  <input type="text" class="pvm-input-text role__team-member-txt" id="SearchMemberField" ng-model="SearchMemberField" placeholder="Type here...">
  <div class="role__automplete" id="SearchMember">
    <ul class="role__team-members-list">
      <li class="role__team-members-item" ng-repeat="roleCompanyMemberItem in roleCompanyMemberList | filter: SearchMemberField | limitTo:10" ng-show="!roleCompanyMemberItem.isSelected">
        <input type="checkbox" name="selectTeam" checklist-model="selectedData" checklist-value="roleCompanyMemberItem.id" class="" id="teamList@{{roleCompanyMemberItem.id}}" ng-click="ddd(roleCompanyMemberItem)">
        <label for="teamList@{{roleCompanyMemberItem.id}}" class="role__team-name">
          <img src="@{{roleCompanyMemberItem.profile_picture_url}}" ng-if="roleCompanyMemberItem.profile_picture_url" class="role__team-img">
          <div class="member-initials" ng-if="!roleCompanyMemberItem.profile_picture_url" class="role__team-img" ng-class="roleCompanyMemberItem.profile_color">@{{roleCompanyMemberItem.initial}}</div>
          <span>@{{roleCompanyMemberItem.first_name}} @{{roleCompanyMemberItem.last_name}}</span>
        </label>
      </li>
    </ul>
  </div>
  <i class="fa fa-search"></i>
</div>
<p class="role__sublabel">Assign team</p>
<div class="role__team-box">
  <input type="text" class="pvm-input-text role__team-member-txt" id="SearchTeamField" ng-model="SearchTeamField" placeholder="Type here...">
  <div class="role__automplete" id="SearchTeam">
    <ul class="role__team-members-list">
      <li class="role__team-members-item" ng-repeat="roleCompanyTeamItem in GetAllCompanyTeam | filter: SearchTeamField | limitTo:10" ng-show="!roleCompanyTeamItem.isSelected">
        <input type="checkbox" name="selectTeam" checklist-model="selectedDataTeam" checklist-value="roleCompanyTeamItem.id" class="" id="teamList@{{roleCompanyTeamItem.id}}" ng-click="addTeam(roleCompanyTeamItem )">
        <label for="teamList@{{roleCompanyTeamItem.id}}" class="role__team-name">
          <img src="@{{roleCompanyTeamItem .profile_picture_url}}" ng-if="roleCompanyTeamItem.profile_picture_url" class="role__team-img">
          <div class="member-initials" ng-if="!roleCompanyTeamItem.profile_picture_url" class="role__team-img" ng-class="roleCompanyTeamItem .team_color">@{{roleCompanyTeamItem .initial}}</div>
          <span>@{{roleCompanyTeamItem .team_name}}</span>
        </label>
      </li>
    </ul>
  </div>
  <i class="fa fa-search"></i>
</div>
<p class="role__sublabel">Assign role manager</p>
<div class="role__team-box">
  <input type="text" class="pvm-input-text role__team-member-txt" id="SearchManagerField" ng-model="SearchManagerField" placeholder="Type here...">
  <div class="role__automplete" id="SearchManager">
    <ul class="role__team-members-list">
      <li class="role__team-members-item" ng-repeat="roleCompanyMemberItem in roleCompanyMemberList | filter:SearchManagerField | limitTo:10"  ng-show="SelectedJobManager.id != roleCompanyMemberItem.id">
        <input type="radio" ng-model="SelectedJobManager.id" ng-value="roleCompanyMemberItem.id" class="" id="managerList@{{roleCompanyMemberItem.id}}" ng-click="selectedMngr(roleCompanyMemberItem)">
        <label for="managerList@{{roleCompanyMemberItem.id}}" class="role__team-name">
          <img src="@{{roleCompanyMemberItem.profile_picture_url}}" ng-if="roleCompanyMemberItem.profile_picture_url" class="role__team-img">
          <div class="member-initials" ng-if="!roleCompanyMemberItem.profile_picture_url" class="role__team-img" ng-class="roleCompanyMemberItem.profile_color">@{{roleCompanyMemberItem.initial}}</div>
          <span>@{{roleCompanyMemberItem.first_name}} @{{roleCompanyMemberItem.last_name}}</span>
        </label>
      </li>
    </ul>
  </div>
  <i class="fa fa-search"></i>
</div>
<p class="role__sublabel">Invite new team members</p>
<ul class="role__invite-list">
  <li class="role__invite-item" ng-repeat="inviteMembersItem in inviteMembersList">
    <input type="text" class="pvm-input-text role__invite-email" placeholder="Email address" ng-model="inviteMembersItem.email" required>
    <input type="text" class="pvm-input-text role__invite-first-name" placeholder="First name" ng-model="inviteMembersItem.first_name" required>
    <input type="text" class="pvm-input-text role__invite-last-name" placeholder="Last name" ng-model="inviteMembersItem.last_name" required>
  </li>
</ul>
<a href="" ng-click="addNewItemMember()" class="role__add-invite-link"><i class="fa fa-plus"></i> Add another team member</a>
<a href="" ng-click="addMemberList(inviteMembersList)" class="btn-pvm btn-secondary btn-mini role__send-invite-link">Send Invitations</a> <span class="role__invite-msg">@{{inviteMsg}}</span>
<!--<p class="role__sublabel">Create and invite link</p>
<select class="pvm-select role__inv-exp">
  <option>Expires in 10 days</option>
</select>
<a href="" ng-click="addMemberList()" class="btn-pvm btn-secondary btn-mini role__create-invite-link">Create invite link</a>-->

<script>
  $(document).ready(function() {
    $('[data-toggle="tooltip"]').tooltip();
    function MemberDropdowFilter(field_element, display_element) {
      $(field_element).focusin(function() {
        $(this).keypress(function() {
          if ($(display_element).is(":hidden")) {
            $(display_element).slideToggle("slow");
          }
        });
      });

      $(field_element).focusout(function() {
        setTimeout(function() {
          $(display_element).slideToggle("slow");
        }, 500);
      });
    }
    $('#location').focusout(function() {
      if ($(this).val() == "") {
        $(this).addClass('safari-disabled')
      }
    });

    MemberDropdowFilter('#SearchMemberField', '#SearchMember');
    MemberDropdowFilter('#SearchTeamField', '#SearchTeam');
    MemberDropdowFilter('#SearchManagerField', '#SearchManager');
  });
</script>