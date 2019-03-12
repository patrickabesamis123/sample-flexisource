<header class="header pvm-header pvm-header--v2 clear-float" ng-class="{'pvm-candidate': !is_employer}" role="banner" ng-controller="LoginmenuController" ng-cloak>
    <section class="pvm-logo-handler">
      <a href="" class="brand" rel="home" ng-click="goToLink($event)"><img src="images/pvm-mini-white.png" title="$SiteConfig.Title"></a>
      <h1 class="pvm-page__title pvm-sm-desktop-visible" ng-if="!is_employer">Apply for this role</h1>
      <h1 class="pvm-page__title pvm-sm-desktop-visible" ng-if="is_employer">Create a role</h1>
    </section>
    <section class="pvm-search-handler pvm-phone-land-visible">
      <input type="text" class="pvm-input-text pvm-search" id="search_top"  placeholder="Search for jobs, companies, and more..." ng-model="globalsearch" ng-enter="search()"/>
      <i class="fa fa-search" ng-click="search()"></i>
    </section>
    <section class="pvm-nav-handler">
        {{-- change ng-if="is_employer" --}}
      <a href="/employer/add/job" class="btn-pvm btn-primary pvm-tablet-land-visible" ng-if="!is_employer" style="float:left; width: auto;"><i class="fa fa-pencil"></i> Create Role</a>
      <a href="/job/search" class="btn-pvm btn-primary pvm-tablet-land-visible" ng-if="is_employer" style="float:left; width: auto;">Search Jobs</a>
      <a href="/@{{profile_url}}" data-ajax="false" title="Profile" ng-hide="!logged(val)" class="head__profile-link">
        <div class="randomInitialColor member-initials member-initials--nav (@{{profile_color}})" ng-if="!profile_image">(@{{initial}})</div>
        <img ng-src="(@{{profile_image}})" class="img-circle pvm-profile-thumb" ng-if="profile_image" on-error-src="images/defaultPhoto.png">
      </a>
      <a href="/employer/dashboard" ng-click="goToLink($event)" data-ajax="false" title="Dashboard" class="head__dash-link">
        <i class="fa fa-dashboard fa-tachometer-alt"></i>
      </a>
      <span class="notificationLink head__notification-link" data-ajax="false" title="Notifications" ng-hide="!logged(val)" ng-init="headOpenNoti=false">
      <span class="notification_count notif">(@{{count_nofications}})</span>
        <i class="fa fa-bell" ng-click="headOpenNoti = !headOpenNoti"></i>
        <ul class="head__notification-list" ng-show="headOpenNoti">
          <li class="head__notification-item head__notification-item--head">
            <h5>Notifications</h5>
            <span></span>
          </li>
          <li class="head__notification-item" ng-repeat="notification in notificationEvent.notifications" ng-class="{'seen' : notification.seen == true}">
            <a href="#" data-ajax="false" ng-click="notification_seen(notification.id, notification.target_url)" class="head__notification-item-link">
              <small class="head__notification-date">(@{{notification.date}})</small>
              <span class="head__notification-msg">(@{{notification.message}})</span>
            </a>
          </li>
          <li class="head__notification-item" ng-if="notificationEvent.length == 0">
            No notification event yet
          </li>
        </ul>
      </span>

      <span class="messageLink head__message-link" data-ajax="false" title="Messages" ng-hide="!logged(val)" ng-init="headOpenMsg=false">
        <span class="notification_count message">(@{{count_messages}})</span>
        <i class="fa fa-comments" ng-click="headOpenMsg = !headOpenMsg"></i>
        <ul class="head__message-list" ng-show="headOpenMsg">
          <li class="head__message-item head__message-item--head">
            <h5>Messages </h5>
            <span></span>
          <li ng-repeat="notification in notificationMessages.notifications" ng-class="{'seen' : notification.seen == true}" class="head__message-item">
            <a href="#" data-ajax="false" ng-click="notification_seen(notification.id, notification.target_url)">
              <small class="head__message-date">(@{{notification.date}})</small>
              <span class="head__message-msg">(@{{notification.message}})</span>
            </a>
          </li>
          <li class="head__message-item" ng-if="notificationMessages.length == 0">
            No notification message yet
          </li>
        </ul>
      </span>

      <span class="setttingsLink head__settings-link" data-ajax="false" title="Messages" ng-init="headOpenSet=false">
        <i class="fa fa-caret-down" ng-click="headOpenSet = !headOpenSet"></i>

        <ul class="head__setting-list" ng-show="headOpenSet">
          <li class="head__setting-item">
            <span class="arrow-up"></span>
          </li>
          <% if $UserType == 'candidate' %>
            <li ng-hide="!logged(val)" class="head__setting-item">
              <a href="{}{$MyAccountLink}" ng-click="goToLink($event)" class="Edit my Profile">Edit my Profile</a>
            </li>
          <% else_if $UserType == 'employer' %>
            <li ng-hide="!logged(val)" ng-if="account_type_string == 'Company Admin'" class="head__setting-item">
            <a href="{}employer/company/edit" ng-click="goToLink($event)" title = "Edit your Company Profile">Edit your company profile</a>
           </li>
          <% end_if %>
          <li class="head__setting-item">
            <a href="{}resources" title="Resources">Resources </a>
          </li>
          <li ng-hide="!logged(val)" class="head__setting-item">
            <a href="" ng-click="logout()" title="Logout">Logout</a>
          </li>
        </ul>
      </span>
      <a href="{}/help" class="pvm-page__help">Help</a>
    </section>
    <section class="pvm-search-handler pvm-phone-land-invisible">
      <input type="text" class="pvm-input-text pvm-search" id="search_top"  placeholder="Search for jobs, companies, and more..." ng-model="globalsearch" ng-enter="search()"/>
      <i class="fa fa-search" ng-click="search()"></i>
    </section>
  </header>