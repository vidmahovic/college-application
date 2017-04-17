<template>
  <div>

    <!-- Navigation -->
    <nav class="navbar navbar-default navbar-static-top" role="navigation" style="height:30px">
        <div class="navbar-header">
            <a class="navbar-brand">Vpis</a>
        </div>
        <div v-if="user.loggedIn" class="nav navbar-nav navbar-right" style="margin-right:20px">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <span class="glyphicon glyphicon-user"></span> 
                        <strong>{{ user.name }}</strong>
                        <span class="glyphicon glyphicon-chevron-down"></span>
                    </a>
                    <ul class="dropdown-menu" style="padding:0px">

                        <!--<li class="divider"></li>-->
                        <li>
                            <div class="navbar-login navbar-login-session">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <p>
                                            <a  v-on:click="logout" class="btn btn-danger btn-block">Izpis <span class="glyphicon glyphicon-log-in pull-right"></span></a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </li>
            </div>
    </nav>

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
        user: {
          loggedIn: false
        }
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

        this.user = {
          loggedIn: false
        };
        //this.$store.commit('SET_USER', null);
        //this.$store.commit('SET_TOKEN', null);

        if (window.localStorage) {
          window.localStorage.setItem('user', null);
          window.localStorage.setItem('token', null);
        }

        this.$router.push('/login')
      }
    },
    mounted() {
    	//this.$router.push('login')
    }

  }
</script>
