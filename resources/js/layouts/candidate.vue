<template>
  <div><CandidateHeader /> <child /> <NavFooter /></div>
</template>

<script>
export default {
  name: 'CandidateLayout',
  created() {
    this.callCandidateProfileApi();
  },
  methods: {
    callCandidateProfileApi: function() {
      axios.get('candidate/profile').then(response => {
        var data = response.data;
        var fullName = data.first_name + ' ' + data.last_name;
        response.data.default_image = this.globalCreateDefaultImage(fullName);
        this.$emit('candidateProfile', response.data);
      });
    },
  },
};
</script>
