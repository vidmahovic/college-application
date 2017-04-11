<template>
  <div class="container container-table">
      <div class="row vertical-10p">
        <div class="container">
          <div class="text-center col-md-4 col-sm-offset-2">
            <!-- errors -->
            <!-- login form -->
            <form class="ui form loginForm"  @submit.prevent="checkCreds">

              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                <input class="form-control" name="username" placeholder="Username" type="text" v-model="username">
              </div>

              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                <input class="form-control" name="password" placeholder="Password" type="password" v-model="password">
              </div>
              <button type="submit" class="btn btn-primary">Login</button>
            </form>
            
          </div>
        </div>
      </div>
  </div>
</template>

<script>
module.exports = {
	name: 'Login',
 	data: function (router) {
		return {
			section: 'Login',
			loading: '',
			username: '',
			password: '',
			response: ''
		}
	},
	methods: {
    	checkCreds: function () {

        // Mock user login..username => role: student | admin | referent
        this.$router.push('/'+this.username)
    		
    },
    mounted() {
    	console.log("login mounted")
    }
    
  }
}
</script>
