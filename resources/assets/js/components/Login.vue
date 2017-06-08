<template>
  <div class="container">
      <div class="row">
      <div class="col-md-6 col-md-offset-3">
        <div class="panel panel-login">
          <div class="panel-heading">
            <div class="row">
              <div class="col-xs-6">
                <a class="active" id="login-form-link">Prijava</a>
              </div>
              <div class="col-xs-6">
                <a id="register-form-link">Registracija</a>
              </div>
            </div>
            <hr>
          </div>
          <div class="panel-body">
            <div class="row">
              <div class="col-lg-12">
                <form id="login-form" role="form" style="display: block;"  @submit.prevent="checkCreds">
                  <div class="form-group">
                    <input class="form-control" name="username" placeholder="Uporabniško ime" type="text" v-model="login.username" tabindex="1">
                  </div>
                  <div class="form-group">
                    <input class="form-control" name="login_password" placeholder="Geslo" type="password" v-model="login.password" tabindex="2">
                  </div>
                  <p v-show="showResponse" class="bg-danger" style="padding-top: 10px; padding-bottom: 10px; margin-top: 15px;"> {{ response }} </p>
                  <!--
                  <div class="form-group text-center">
                    <input type="checkbox" tabindex="3" class="" name="remember" id="remember">
                    <label for="remember"> Remember Me</label>
                  </div>
                  -->
                  <div class="form-group">
                    <div class="row">
                      <div class="col-sm-6 col-sm-offset-3">
                        <input type="submit" name="login-submit" id="login-submit" tabindex="4" class="form-control btn btn-login" value="Prijavi">
                      </div>
                    </div>
                  </div>
                  <!--
                  <div class="form-group">
                    <div class="row">
                      <div class="col-lg-12">
                        <div class="text-center">
                          <a href="" tabindex="5" class="forgot-password">Forgot Password?</a>
                        </div>
                      </div>
                    </div>
                  </div>
                  -->
                </form>
                <form id="register-form" role="form" style="display: none;" @submit.prevent="doRegister">
                  <div class="form-group">
                    <input type="text" v-model="reg.name" v-validate="'required'" class="form-control" name="name" placeholder="Ime" tabindex="1">
                    <p class="text-danger" v-if="errors.has('name')"> <!--{{errors.first('name')}} -->Ime je obvezen podatek</p>
                  </div>
                  <div class="form-group">
                    <input type="text" v-model="reg.surname" v-validate="'required'" class="form-control" name="surname" placeholder="Priimek"  tabindex="1">
                     <p class="text-danger" v-if="errors.has('surname')"> <!--{{errors.first('surname')}} -->Priimek je obvezen podatek</p>
                  </div>
                  <!--
                  <div class="form-group">
                    <input type="text" v-model="reg.username" v-validate="'required'" class="form-control" name="username" placeholder="Uporabniško ime"  tabindex="1">
                     <p class="text-danger" v-if="errors.has('username')"> <!--{{errors.first('username')}} --><!--Uporabniško ime je obvezen podatek</p>
                  </div>
                  -->
                  <div class="form-group">
                    <input type="text" v-model="reg.email" v-validate="'required|email'" class="form-control" name="email" placeholder="Email" tabindex="2">
                    <p class="text-danger" v-if="errors.has('email')">{{ errors.first('email') }}</p>
                  </div>
                  <div class="form-group">
                    <input type="password" v-model="reg.pswd" v-validate="'required|min:8'" name="password" id="password" tabindex="2" class="form-control" placeholder="Geslo">
                    <p class="text-danger" v-if="errors.has('password')">{{ errors.first('password') }}</p>
                  </div>
                  <div class="form-group">
                    <input type="password" v-model="reg.repswd" v-validate="'required|confirmed:password'"  name="confirm-password" id="confirm-password" tabindex="2" class="form-control" placeholder="Potrdi geslo">
                    <p class="text-danger" v-if="errors.has('confirm-password')">{{ errors.first('confirm-password') }}</p>


                  </div>
                   <p v-show="registerError" class="bg-danger" style="padding-top: 10px; padding-bottom: 10px; margin-top: 15px;">  {{ registerMsg }} </p>

                  <div class="form-group">

                    <div class="row">
                      <div class="col-sm-6 col-sm-offset-3">
                        <input type="submit" name="register-submit" id="register-submit" tabindex="4" class="form-control btn btn-register" value="Registriraj">
                      </div>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
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
      login: {
        username: '',
        password: ''
      },
      reg: {
        name: null,
        surname: null,
        username: null,
        email: null,
        pswd: null,
        repswd: null
      },
      response: '',
      showResponse: false,
      registerError: false,
      registerMsg: ""
    }
  },
  methods: {
    checkCreds: function() {
        this.$http.post('api/login', {email: this.login.username, password: this.login.password})
          .then(function(res){
            let user = res.body.data
            // modify enrollment service => enrollment_service for url handeling
            if(user.role === 'enrollment service') {
              user.role = 'enrollment_service',
              console.log("enrollment service logged in")
            }

            this.$parent.user = user;
            this.$root.user = user;


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
      doRegister: function() {

        this.$validator.validateAll();
        if (this.errors.any()) {
          console.log("VALIDATION FAILED")
          return;
        }

        console.log(this.reg)

          //'name', 'email', 'password', 'confirm_password', 'username'
        this.$http.post('api/register', {username: this.reg.email, email: this.reg.email,
                                        name: this.reg.name+' '+this.reg.surname,
                                        password: this.reg.pswd, confirm_password: this.reg.repswd})
          .then(function(res){

            this.registerError = false;

            console.log(res);
          }, function(err){

            let errs = err.body.errors;
            Object.entries(errs).forEach(
              ([key, value]) => this.registerMsg = this.registerMsg.concat(value)

            );

            this.registerError = true;

            console.log(err);
          });

      }
    },
    mounted() {
      $('#login-form-link').click(function(e) {
      $("#login-form").delay(100).fadeIn(100);
      $("#register-form").fadeOut(100);
      $('#register-form-link').removeClass('active');
      $(this).addClass('active');
      e.preventDefault();
    });
    $('#register-form-link').click(function(e) {
      $("#register-form").delay(100).fadeIn(100);
      $("#login-form").fadeOut(100);
      $('#login-form-link').removeClass('active');
      $(this).addClass('active');
      e.preventDefault();
    });
  }
}

</script>
<style>

#login-form-link, #register-form-link{
  cursor: pointer;
};
.panel-login {
  border-color: #ccc;
  -webkit-box-shadow: 0px 2px 3px 0px rgba(0,0,0,0.2);
  -moz-box-shadow: 0px 2px 3px 0px rgba(0,0,0,0.2);
  box-shadow: 0px 2px 3px 0px rgba(0,0,0,0.2);
}
.panel-login>.panel-heading {
  color: #00415d;
  background-color: #fff;
  border-color: #fff;
  text-align:center;
}
.panel-login>.panel-heading a{
  text-decoration: none;
  color: #666;
  font-weight: bold;
  font-size: 15px;
  -webkit-transition: all 0.1s linear;
  -moz-transition: all 0.1s linear;
  transition: all 0.1s linear;
}
.panel-login>.panel-heading a.active{
  color: #029f5b;
  font-size: 18px;
}
.panel-login>.panel-heading hr{
  margin-top: 10px;
  margin-bottom: 0px;
  clear: both;
  border: 0;
  height: 1px;
  background-image: -webkit-linear-gradient(left,rgba(0, 0, 0, 0),rgba(0, 0, 0, 0.15),rgba(0, 0, 0, 0));
  background-image: -moz-linear-gradient(left,rgba(0,0,0,0),rgba(0,0,0,0.15),rgba(0,0,0,0));
  background-image: -ms-linear-gradient(left,rgba(0,0,0,0),rgba(0,0,0,0.15),rgba(0,0,0,0));
  background-image: -o-linear-gradient(left,rgba(0,0,0,0),rgba(0,0,0,0.15),rgba(0,0,0,0));
}
.panel-login input[type="text"],.panel-login input[type="email"],.panel-login input[type="password"] {
  height: 45px;
  border: 1px solid #ddd;
  font-size: 16px;
  -webkit-transition: all 0.1s linear;
  -moz-transition: all 0.1s linear;
  transition: all 0.1s linear;
}
.panel-login input:hover,
.panel-login input:focus {
  outline:none;
  -webkit-box-shadow: none;
  -moz-box-shadow: none;
  box-shadow: none;
  border-color: #ccc;
}
.btn-login {
  background-color: #59B2E0;
  outline: none;
  color: #fff;
  font-size: 14px;
  height: auto;
  font-weight: normal;
  padding: 14px 0;
  text-transform: uppercase;
  border-color: #59B2E6;
}
.btn-login:hover,
.btn-login:focus {
  color: #fff;
  background-color: #53A3CD;
  border-color: #53A3CD;
}
.forgot-password {
  text-decoration: underline;
  color: #888;
}
.forgot-password:hover,
.forgot-password:focus {
  text-decoration: underline;
  color: #666;
}
.btn-register {
  background-color: #1CB94E;
  outline: none;
  color: #fff;
  font-size: 14px;
  height: auto;
  font-weight: normal;
  padding: 14px 0;
  text-transform: uppercase;
  border-color: #1CB94A;
}
.btn-register:hover,
.btn-register:focus {
  color: #fff;
  background-color: #1CA347;
  border-color: #1CA347;
}


</style>
