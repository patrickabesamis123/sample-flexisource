import Vue from 'vue';
import Child from './Child';
import CandidateSidebar from './CandidateSidebar.vue';
import NavFooter from './NavFooter.vue';
import CandidateHeader from './CandidateHeader.vue';
import { HasError, AlertError, AlertSuccess } from 'vform';
// Components that are registered globaly.
[Child, CandidateSidebar, NavFooter, CandidateHeader, HasError, AlertError, AlertSuccess].forEach(
  Component => {
    Vue.component(Component.name, Component);
  },
);
