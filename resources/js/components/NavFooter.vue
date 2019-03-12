<template>
  <footer id="footer" role="contentinfo">
    <section class="pvm-footer">
      <!-- start: logo -->
      <a href="/" class="pvm-gray-logo" rel="home">
        <img id="footerLogo" src="/images/footer-logo.png" title="previewme" />
      </a>
      <!-- end: logo -->

      <ul class="footer-list clear-float">
        <!-- start: candidates -->
        <li class="footer-item">
          <h5>For Candidates</h5>
          <a data-ajax="false" href="features/benefits/candidates" class="footer__link">Features</a>
        </li>
        <!-- end: candidates -->

        <!-- start: employers -->
        <li class="footer-item">
          <h5>For Employers</h5>
          <a data-ajax="false" href="features/benefits/employers" class="footer__link">Features</a>
        </li>
        <!-- end: employers -->

        <li class="footer-item footer-item--up">
          <a data-ajax="false" href="about-us" class="footer__link">ABOUT US</a>
          <a data-ajax="false" href="contact-us" class="footer__link">CONTACT US</a>
          <a data-ajax="false" href="pricing" class="footer__link">PRICING</a>
          <a data-ajax="false" href="our-partners" class="footer__link">PARTNERS</a>
        </li>

        <li class="footer-item footer-item--up">
          <a data-ajax="false" href="faq" class="footer__link">FAQ</a>
          <a data-ajax="false" href="job/search" class="footer__link">JOB SEARCH</a>
          <a data-ajax="false" href="help" class="footer__link">HELP</a>
          <a data-ajax="false" href="resources" class="footer__link">CONTENT</a>
        </li>
      </ul>

      <p class="footer__copyright">
        &copy; 2016 PREVIEWME All rights reserved
        <a href="privacy-policy" data-ajax="false">Privacy Policy</a>
        <a href="terms-and-conditions" data-ajax="false">T’s and C’s</a>
      </p>
    </section>
  </footer>
</template>

<script>
export default {
  name: 'NavFooter',
  mounted() {
    this.initTawkTo();
  },
  methods: {
    initTawkTo: function() {
      (function() {
        var s1 = document.createElement('script'),
          s0 = document.getElementsByTagName('script')[0];
        s1.async = true;
        s1.src = 'https://embed.tawk.to/58d330f3f97dd14875f59a3d/default';
        s1.charset = 'UTF-8';
        s1.setAttribute('crossorigin', '*');
        s0.parentNode.insertBefore(s1, s0);
      })();
    },
  },
};
</script>
