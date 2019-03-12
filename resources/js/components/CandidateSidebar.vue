<template>
  <section id="candidate-sidebar" class="pvm-side-nav pvm-side-nav--candidate clear-float" style="position: absolute; top: initial;">
    <div class="side-nav__nav-bar show-bar">
      <!-- start: nav list -->
      <ul class="side-nav__nav-list">
        <!-- start: profile -->
        <li class="side-nav__nav-item pvm-tablet-land-visible">
          <a href="my-profile" class="side-nav__link side-nav__link--profile">
            <img
              v-if="candidateProfile.profile_image"
              :src="candidateProfile.profile_image"
              class="img-circle side-nav__profile-img"
            />
            <div
              v-else
              :class="candidateProfile.default_image.profile_color"
              class="member-initials member-initials--lg side-nav__profile-img"
            >
              {{ candidateProfile.default_image.initials }}
            </div>
            <span class="side-nav__title">Profile</span>
          </a>
        </li>
        <!-- end: profile -->

        <!-- start: dashboard -->
        <li class="side-nav__nav-item">
          <router-link
            :to="{ name: 'dashboard' }"
            class="side-nav__link side-nav__link--dashboard"
            active-class="active"
          >
            <i class="fa fa-dashboard" />
            <span class="pvm-tablet-land-visible side-nav__title">Dashboard</span>
          </router-link>
        </li>
        <!-- end: dashboard -->

        <!-- start: drafts -->
        <!--
          <li class="side-nav__nav-item">
            <a href="my-job-applications/draft" class="side-nav__link side-nav__link-draft">
              <i class="fa fa-file-text-o" />
              <span class="pvm-tablet-land-visible side-nav__title">Drafts</span>
            </a>
          </li>
        -->
        <!-- end: drafts -->

        <!-- start: Applications -->
        <li class="side-nav__nav-item">
          <a href="my-job-applications" class="side-nav__link side-nav__link--job">
            <i class="fa fa-briefcase" />
            <span class="pvm-tablet-land-visible side-nav__title">Applications</span>
          </a>
        </li>
        <!-- end: Applications -->

        <!-- start: messages -->
        <li class="side-nav__nav-item">
          <a href="messages" class="side-nav__link side-nav__link--msg">
            <i class="fa fa-comments" />
            <span class="pvm-tablet-land-visible side-nav__title">Messages</span>
          </a>
        </li>
        <!-- end: messages -->

        <!-- start: analytics -->
        <li class="side-nav__nav-item">
          <a href="analytics" class="side-nav__link side-nav__link--ana">
            <i class="fa fa-line-chart" />
            <span class="pvm-tablet-land-visible side-nav__title">Analytics</span>
          </a>
        </li>
        <!-- end: analytics -->

        <!-- start: settings -->
        <li class="side-nav__nav-item">
          <a href="/candidate/settings/index" class="side-nav__link side-nav__link--settings">
            <i class="fa fa-gear" />
            <span class="pvm-tablet-land-visible side-nav__title">Settings</span>
          </a>
        </li>
        <!-- end: settings -->
      </ul>
      <!-- end: nav list -->
    </div>
  </section>
</template>

<script>
export default {
  name: 'CandidateSidebar',
  data: () => ({
    candidateProfile: {
      profile_image: '',
      default_image: '',
    },
  }),
  created() {
    /**
     * Since CandidateSidebar is child of Dashboard component
     * Then Dashboard Component is child of Child Component
     * Then Child Component to Candidate Component (the one that emits the data)
     * Thus, it became like this
     * (Current Component)->$parent(dashboard)->$parent(child)->$parent(candidate)
     */
    this.$parent.$parent.$parent.$on('candidateProfile', candidateProfile => {
      this.candidateProfile = candidateProfile;
    });
  },
  mounted() {
    /**
     * for sticky of the candidate sidebar menu
     * reference: https://bootsnipp.com/snippets/deydP
     */
    var candidateSidebar = $('#candidate-sidebar');
    var stickyStopper = $('.footer__copyright');

    var candidateSidebarTop = candidateSidebar.offset().top;
    var candidateSidebarOffset = 0;
    var candidateStopperPosition = stickyStopper.offset().top;
    var diff = candidateStopperPosition + candidateSidebarOffset;
    $(window).scroll(function() {
      var windowTop = $(window).scrollTop();

      if (candidateStopperPosition < windowTop) {
        candidateSidebar.css({ position: 'absolute', top: diff });
      } else if (candidateSidebarTop < windowTop + candidateSidebarOffset) {
        candidateSidebar.css({
          position: 'fixed',
          top: candidateSidebarOffset,
        });
      } else {
        candidateSidebar.css({ position: 'absolute', top: 'initial' });
      }
    });
  },
};
</script>
