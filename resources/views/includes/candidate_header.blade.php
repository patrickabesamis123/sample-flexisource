<header class="header pvm-header clear-float" ng-class="{'pvm-candidate': !is_employer}" role="banner" ng-controller="LoginmenuController" ng-cloak>
  <section class="pvm-logo-handler">
    <a href="/" class="brand" rel="home" ng-click="goToLink($event)"><img src="/images/logo.png" title="PreviewMe"></a>
  </section>
  <section class="pvm-search-handler pvm-phone-invisible">
    <input type="text" class="pvm-input-text pvm-search" id="search_top" placeholder="Search for jobs, companies, and more..." ng-model="globalsearch" ng-enter="search()"/>
    <i class="fa fa-search" ng-click="search()"></i>
  </section>
  <section class="pvm-nav-handler">
    <a href="/settings#" ng-click="navigateUrl('/employer/add/job')" class="btn-pvm btn-primary" ng-show="is_employer" style="float:left; width: auto;">Create Roles</a>
    <a href="/job/search" class="btn-pvm btn-primary pvm-phone-invisible" ng-show="!is_employer" style="float:left; width: auto;">Search Jobs</a>
    <a href="/candidate/profile/12" data-ajax="false" title="Profile" class="head__profile-link">
      <div class="randomInitialColor member-initials member-initials--nav replace" >　</div>
      <img class="img-circle pvm-profile-thumb" src="/images/human-o.png">
    </a>
    <a href="/dashboard" ng-click="goToLink($event)" data-ajax="false" title="Dashboard" class="head__dash-link">
      <i class="fa fa-dashboard fa-tachometer-alt"></i>
    </a>
    <span class="notificationLink head__notification-link" title="Notifications">
      <!--<span class="notification_count notif">0</span>-->
      <i class="fa fa-bell" ng-click="headOpenNoti = !headOpenNoti"></i>
      <!--
      <ul class="head__notification-list" ng-show="headOpenNoti">
        <li class="head__notification-item head__notification-item--head">
          <h5>Notifications</h5>
          <span></span>
        </li>
        <li class="head__notification-item" ng-repeat="notification in notificationEvent.notifications" ng-class="{'seen' : notification.seen == true}">
          <a href="/settings#" data-ajax="false" ng-click="notification_seen(notification.id, notification.target_url)" class="head__notification-item-link">
            <small class="head__notification-date">notification.date</small>
            <span class="head__notification-msg">notification.message</span>
          </a>
        </li>
        <li class="head__notification-item" ng-if="notificationEvent.length == 0">
          No notification event yet
        </li>
      </ul>
      -->
    </span>

    <span class="messageLink head__message-link" title="Messages">
      <!--<span class="notification_count message">count_messages</span>-->
      <i class="fa fa-comments" ng-click="headOpenMsg = !headOpenMsg"></i>
      <!--
      <ul class="head__message-list" ng-show="headOpenMsg">
        <li class="head__message-item head__message-item--head">
          <h5>Messages </h5>
          <span></span>
        <li ng-repeat="notification in notificationMessages.notifications" ng-class="{'seen' : notification.seen == true}" class="head__message-item">
          <a href="/settings#" data-ajax="false" ng-click="notification_seen(notification.id, notification.target_url)">
            <small class="head__message-date">notification.date</small>
            <span class="head__message-msg">notification.message</span>
          </a>
        </li>
        <li class="head__message-item" ng-if="notificationMessages.length == 0">
          No notification message yet
        </li>
      </ul>
      -->
    </span>

    <span class="setttingsLink head__settings-link" data-ajax="false" title="Messages" ng-init="headOpenSet=false">
      <i class="fa fa-caret-down" ng-click="headOpenSet = !headOpenSet"></i>

      <ul class="head__setting-list" ng-show="headOpenSet">
        <li class="head__setting-item">
          <span class="arrow-up"></span>
        </li>
        
        <li class="head__setting-item">
          <a href="/my-profile/edit" ng-click="goToLink($event)" class="Edit my Profile">Edit my Profile</a>
        </li>
        
        <li class="head__setting-item">
          <a href="/resources" title="Resources">Resources</a>
        </li>
        <li class="head__setting-item">
          <a href="" ng-click="logout()" title="Logout">Logout</a>
        </li>
      </ul>
    </span>
  </section>
  <section class="pvm-search-handler pvm-phone-land-invisible">
    <input type="text" class="pvm-input-text pvm-search" id="search_top"  placeholder="Search for jobs, companies, and more..." ng-model="globalsearch" ng-enter="search()"/>
    <i class="fa fa-search" ng-click="search()"></i>
  </section>
</header>