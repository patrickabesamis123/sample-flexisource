import Vue from 'vue';

const Form_reset = new Vue({
	el: '#Form_reset',
    headers: {
      Authorization: 'Bearer' + '{{ app(\'request\')->input(\'token\') }}'
    },
    data: {
      first_password: '',
      second_password: '',
      token: '{{ app(\'request\')->input(\'token\') }}'
    },
    methods:{
      checkForm: function (e) {
        e.preventDefault();
        if (this.first_password === '') {
              alert('Password required!');
        } else if (this.second_password === '') {
              alert('Password confirmation required!');
        } else if (this.second_password != this.first_password) {
              alert('Passwords do not match!');
        } else {
        	axios({method: 'post', data: {token: encodeURIComponent(this.token), password: encodeURIComponent(this.first_password)}, url: '/api/reset'})
        	.then(res => {
	            if (res.data.success == false) {
	              alert(res.data.error);
	            } else {
	              window.location.href = "/login"
	            }
	        })
        	.catch(function (error) {
		    if (error.response) {
		      alert(error.response.data.error);
		    }});
        }
      }
    }
  });