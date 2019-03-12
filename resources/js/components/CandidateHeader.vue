<template>
  <header
    class="header pvm-header clear-float"
    ng-class="{'pvm-candidate': !is_employer}"
    role="banner"
    ng-controller="LoginmenuController"
    ng-cloak
  >
    <!-- start: logo -->
    <section class="pvm-logo-handler">
      <a href="/" class="brand" rel="home"> <img src="images/logo.png"/></a>
    </section>
    <!-- end: logo -->

    <!-- start: seach input -->
    <section class="pvm-search-handler pvm-phone-invisible">
      <input
        id="search_top"
        type="text"
        class="pvm-input-text pvm-search"
        placeholder="Search for jobs, companies, and more..."
        ng-model="globalsearch"
        ng-enter="search()"
      />
      <i class="fa fa-search" ng-click="search()" />
    </section>
    <!-- end: seach input -->

    <section class="pvm-nav-handler">
      <a
        href="/job/search"
        class="btn-pvm btn-primary pvm-phone-invisible"
        style="float:left; width: auto;"
        >Search Jobs</a
      >

      <!-- start: my profile -->
      <a
        id="top_profile_image"
        href="my-profile"
        data-ajax="false"
        title="Profile"
        ng-hide="!logged(val)"
        class="head__profile-link"
      >
        <img
          v-if="candidateProfile.profile_image"
          :src="candidateProfile.profile_image"
          class="img-circle pvm-profile-thumb"
        />
        <div
          v-else
          :class="candidateProfile.default_image.profile_color"
          class="randomInitialColor member-initials member-initials--nav"
        >
          {{ candidateProfile.default_image.initials }}
        </div>
      </a>
      <!-- end: my profile -->

      <!-- start: dashboard -->
      <router-link :to="{ name: 'dashboard' }" class="head__dash-link">
        <i class="fa fa-dashboard fa-tachometer-alt" />
      </router-link>
      <!-- end: dashboard -->

      <!-- start: notification event -->
      <span
        class="notificationLink head__notification-link"
        data-ajax="false"
        title="Notifications"
        ng-hide="!logged(val)"
        ng-init="headOpenNoti=false"
      >
        <span class="notification_count notif">{{ count_notifications }}</span>
        <i class="fa fa-bell" ng-click="headOpenNoti = !headOpenNoti" />
        <!--
          <ul class="head__notification-list" ng-show="headOpenNoti">
            <li class="head__notification-item head__notification-item--head">
              <h5>Notifications</h5>
              <span></span>
            </li>
            <li class="head__notification-item" ng-repeat="notification in notificationEvent.notifications" ng-class="{'seen' : notification.seen == true}">
              <a href="#" data-ajax="false" ng-click="notification_seen(notification.id, notification.target_url)" class="head__notification-item-link">
                <small class="head__notification-date">{{notification.date}}</small>
                <span class="head__notification-msg">{{notification.message}}</span>
              </a>
            </li>
            <li class="head__notification-item" v-if="notificationEvent">
              No notification event yet
            </li>
          </ul>
        -->
      </span>
      <!-- end: notification event -->

      <!-- start: notification messages -->
      <span
        class="messageLink head__message-link"
        data-ajax="false"
        title="Messages"
        ng-hide="!logged(val)"
        ng-init="headOpenMsg=false"
      >
        <span class="notification_count message">{{ count_messages }}</span>
        <i class="fa fa-comments" ng-click="headOpenMsg = !headOpenMsg" />
        <!--
          <ul class="head__message-list" ng-show="headOpenMsg">
            <li class="head__message-item head__message-item--head">
              <h5>Messages </h5>
              <span></span>
            </li>
            <li ng-repeat="notification in notificationMessages.notifications" ng-class="{'seen' : notification.seen == true}" class="head__message-item">
              <a href="#" data-ajax="false" ng-click="notification_seen(notification.id, notification.target_url)">
                <small class="head__message-date">{{notification.date}}</small>
                <span class="head__message-msg">{{notification.message}}</span>
              </a>
            </li>

              <li class="head__message-item" v-if="notificationMessages">
                No notification message yet
              </li>
          </ul>
        -->
      </span>
      <!-- end: notification messages -->

      <!-- start: dropdown -->
      <span
        class="setttingsLink head__settings-link"
        data-ajax="false"
        title="Messages"
        @click="onClickShowDropdown();"
      >
        <i class="fa fa-caret-down" />

        <ul v-show="showDropdown" class="head__setting-list">
          <li class="head__setting-item"><span class="arrow-up" /></li>

          <!-- start: edit my profile -->
          <li ng-hide="!logged(val)" class="head__setting-item">
            <a href="{$BaseHref}{$MyAccountLink}" class="Edit my Profile">Edit my Profile</a>
          </li>
          <!-- end: edit my profile -->

          <!-- start: resources -->
          <li class="head__setting-item">
            <a href="{$BaseHref}resources" title="Resources">Resources </a>
          </li>
          <!-- end: resources -->

          <!-- start: logout -->
          <li ng-hide="!logged(val)" class="head__setting-item">
            <a href="" ng-click="logout()" title="Logout">Logout</a>
          </li>
          <!-- end: logout -->
        </ul>
      </span>
      <!-- end: dropdown -->
    </section>
  </header>
</template>

<script>
export default {
  name: 'CandidateHeader',
  data: () => ({
    count_notifications: 69,
    count_messages: 96,
    notificationMessages: [],
    notificationEvent: [],
    showDropdown: false,
    candidateProfile: {
      profile_image: '',
      default_image: '',
    },
  }),
  created() {
    this.$parent.$on('candidateProfile', candidateProfile => {
      this.candidateProfile = candidateProfile;
    });
  },
  methods: {
    onClickShowDropdown: function() {
      if (this.showDropdown) {
        this.showDropdown = false;
        return;
      }
      this.showDropdown = true;
    },
  },
};
</script>
