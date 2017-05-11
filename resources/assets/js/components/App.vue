<template>
  <div>

    <!-- Navigation -->
    <nav class="navbar navbar-default navbar-static-top" role="navigation" style="height:30px">
        <div class="navbar-header">
            <a class="navbar-brand">Vpis</a>
        </div>
        <div v-if="user !== null" class="nav navbar-nav navbar-right" style="margin-right:20px">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <span class="glyphicon glyphicon-user"></span> 
                        <strong>{{ user.name || user.email }}</strong>
                        <span class="glyphicon glyphicon-chevron-down"></span>
                    </a>
                    <ul class="dropdown-menu header-menu" style="padding:0px">
                        <li><a data-toggle="modal" data-target="#myModal">Spremeni geslo</a></li>
                        <li><a v-on:click="logout">Izpis <span class="glyphicon glyphicon-log-in pull-right glyphicon-padding"></span></a></li>
                    </ul>
                </li>
            </div>
    </nav>



    <!-- Modal -->
    <div id="myModal" class="modal fade" role="dialog" ref="vuemodal">
      <div class="modal-dialog modal-sm">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h3 class="modal-title">Sprememba gesla</h3>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label for="staro">Vpišite staro geslo: </label>
                  <input type="password" class="form-control" name="staro" id="staro" v-model="staroGeslo" />
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label for="novo1">Vpišite novo geslo: </label>
                  <input type="password" class="form-control" name="novo1" id="novo1" v-model="novoGeslo" />
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label for="novo2">Ponovno vpišite novo geslo: </label>
                  <input type="password" class="form-control" name="novo2" id="novo2" v-model="novoGesloP" />
                </div>
              </div>
            </div>
            <div v-show="showMsg" class="alert" v-bind:class="{ 'alert-success': !gesloErr, 'alert-danger': gesloErr}" role="alert">{{ gesloMsg }}</div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Prekliči</button>
            <button type="button" class="btn btn-primary" v-on:click="spremeniGeslo">Shrani novo geslo</button>
          </div>
        </div>

      </div>
    </div>

    <div class="wrapper">
      <router-view keep-alive
                   transition
                   transition-mode="out-in">
      </router-view>
      <div id="app"></div>
    </div>
  </div>
</template>

<script>
  export default {
    name: 'App',
    data: function () {
      return {
        section: 'Head',
        version: '0.0.0',
        callingAPI: false,
        serverURI: 'http://10.110.1.10:8080',
        caller: this.$http,
        staroGeslo: '',
        novoGeslo: '',
        novoGesloP: '',
        gesloMsg: '',
        showMsg: false,
        gesloErr: false,
        loggedIn: false,
        user: null
      }
    },
    methods: {

      callAPI: function (method, url, data) {
        this.callingAPI = true;
        url = url || this.serverURI; // if no url is passed then inheret local server URI
        return this.caller({
          url: url,
          method: method,
          data: data
        })
      },
      logout: function () {

        this.user = null;

        if (window.localStorage) {
          window.localStorage.setItem('user', null);
          window.localStorage.setItem('token', null);
        }

        this.$router.push('/login');
      },

      spremeniGeslo: function() {
        if(this.novoGeslo == this.novoGesloP){
          this.$http.post("/api/user/password", {old_password: this.staroGeslo, new_password: this.novoGeslo})
            .then(function(res){
              this.showMsg = true;
              this.gesloErr = false;
              this.gesloMsg = "Geslo uspešno zamenjano!";
            }, function(err){
                this.showMsg = true;
                this.gesloErr = true;
                this.gesloMsg = "Staro geslo ni pravilno!";
            });
        }
        else {
          this.showMsg = true;
          this.gesloErr = true;
          this.gesloMsg = "Novi gesli se ne ujemata!";
        }
      },

      doSomethingOnHidden: function(){
        this.showMsg = false;
        this.gesloErr = false;
        this.gesloMsg = '';
        this.staroGeslo = '';
        this.novoGeslo = '';
        this.novoGesloP = '';
      }
    },
    mounted() {

      $(this.$refs.vuemodal).on("hidden.bs.modal", this.doSomethingOnHidden)

      let token = window.localStorage.getItem('token');
      let user = JSON.parse(window.localStorage.getItem('user'));

      if(token == null || token === 'undefined' || user == null) {
        this.$router.push('/login');
      }else {

        if(this.$route.path == '/') {
          this.$router.push(user.role)
        }
        // get user info
        this.user = user;      
       }
    }

  }
</script>
