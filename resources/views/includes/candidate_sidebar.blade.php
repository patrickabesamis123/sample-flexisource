<!-- SIDEBAR -->
<section class="pvm-side-nav pvm-side-nav--candidate clear-float" id="candidate-sidebar" style="position:fixed; top:initial;">
  <div class="side-nav__nav-bar show-bar">
    <ul class="side-nav__nav-list">
      <li class="side-nav__nav-item  pvm-tablet-land-visible">
        <a href="/candidate/profile/12" class="side-nav__link side-nav__link--profile">
          <div class="member-initials member-initials--lg profile_color side-nav__profile-img"></div>
          <!--<img class="img-circle side-nav__profile-img" src="/images/human.png">-->
          <span class="side-nav__title">Profile</span>
        </a>
      </li>
      <li class="side-nav__nav-item ">
        <a href="/dashboard" class="side-nav__link side-nav__link--dashboard">
          <i class="fa fa-dashboard"></i>
          <span class="pvm-tablet-land-visible side-nav__title">Dashboard</span>
        </a>
      </li>
      <!--
      <li class="side-nav__nav-item">
        <a href="/my-job-applications#/draft" class="side-nav__link side-nav__link-draft">
          <i class="fa fa-file-text"></i>
          <span class="pvm-tablet-land-visible side-nav__title">Drafts</span>
        </a>
      </li>
      -->
      <li class="side-nav__nav-item @if (Request::segment(2) == 'job-applications') active @endif">
        <a href="/candidate/job-applications/" class="side-nav__link side-nav__link--job">
          <i class="fa fa-briefcase"></i>
          <span class="pvm-tablet-land-visible side-nav__title">Applications</span>
        </a>
      </li>
      <li class="side-nav__nav-item @if (Request::segment(1) == 'messages') active @endif">
        <a href="/candidate/messages" class="side-nav__link side-nav__link--msg">
          <i class="fa fa-comments"></i>
          <span class="pvm-tablet-land-visible side-nav__title">Messages</span>
        </a>
      </li>
      <li class="side-nav__nav-item @if (Request::segment(1) == 'analytics') active @endif">
        <a href="/candidate/analytics" class="side-nav__link side-nav__link--ana">
          <i class="fa fa-line-chart"></i>
          <span class="pvm-tablet-land-visible side-nav__title">Analytics</span>
        </a>
      </li>
      <li class="side-nav__nav-item @if (Request::segment(2) == 'settings') active @endif">
        <a href="/candidate/settings/index" class="side-nav__link side-nav__link--settings">
          <i class="fa fa-gear"></i>
          <span class="pvm-tablet-land-visible side-nav__title">Settings</span>
        </a>
      </li>
    </ul>
  </div>
</section>
