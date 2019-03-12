import Vue from 'vue';
import store from '~/store';
import router from '~/router';
import i18n from '~/plugins/i18n';
import App from '~/components/App';

import '~/plugins';
import '~/components';

/**
 * Import javascript libraries
 */
import '../../node_modules/bootstrap-slider/dist/bootstrap-slider.min.js';
import '../../node_modules/bootstrap-sass/assets/javascripts/bootstrap';
import '../../node_modules/alertifyjs/build/alertify';
import '../../node_modules/bootstrap-select/dist/js/bootstrap-select';
import '../../node_modules/lodash';

Vue.config.productionTip = false;

/**
 * This sets prefix path when useing axios (performing call)
 */
Vue.prototype.$apiUrl = '/api/';
axios.defaults.baseURL = Vue.prototype.$apiUrl;

/**
 * Resusable functionalities that can be used across vue components.
 */
Vue.mixin({
  /**
   * Please add prefix 'global' when creating reusable functionalities.
   * e.g. globalNameOfMethod
   */
  methods: {
    globalCreateDefaultImage: function(name) {
      var colors = [
        'member-initials--sky',
        'member-initials--pvm-purple',
        'member-initials--pvm-green',
        'member-initials--pvm-red',
        'member-initials--pvm-yellow',
      ];

      var initials = name.replace(/[^A-Z]/g, '');
      if (initials === '') {
        initials = name.substr(0, 1);
      }

      return {
        initials: initials,
        profile_color: colors[Math.floor(Math.random() * colors.length)],
      };
    },
  },
});

/* eslint-disable no-new */
new Vue({
  i18n,
  store,
  router,
  ...App,
});
