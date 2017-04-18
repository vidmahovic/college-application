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
              <p v-show="showResponse" class="bg-danger" style="padding-top: 10px; padding-bottom: 10px; margin-top: 15px;"> {{ response }} </p>
            </form>

          </div>
        </div>
      </div>
  </div>
</template>

<script>
module.exports = {
  props: ['user'],
  name: 'Login',
  data: function (router) {
    return {
      section: 'Login',
      loading: '',
      username: '',
      password: '',
      response: '',
      showResponse: false
    }
  },
  methods: {
      checkCreds: function () {

        // Mock user login..username => role: student | admin | referent | vpisna_sluzba

        this.$http.post('api/login', {email: this.username, password: this.password})
          .then(function(res){
            // let user = {
            //   name: this.username,
            //   loggedIn: true
            // };
            let user = res.body.data
            this.$parent.user = user;
            
            console.log(res);

            window.localStorage.setItem('user', JSON.stringify(user));
            window.localStorage.setItem('token', res.body.meta.api_token);

            this.$router.push('/'+user.role);

          }, function(err){
            this.showResponse = true;
            if(err.status == 423){
              this.response = "Vaš IP naslov je začasno zaklenjen."
            }
            else {
              this.response = "Uporabniško ime ali geslo ni pravilno.";
            }
          });

    },
    mounted() {
      console.log("login mounted")
    }

  }
}

</script>