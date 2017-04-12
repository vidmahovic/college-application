<template>
  <div>

    <!-- Navigation -->
    <nav class="navbar navbar-default navbar-static-top" role="navigation" style="height:30px">
        <div class="navbar-header">
            <a class="navbar-brand">Vpis</a>
        </div>
    </nav>

    <div class="wrapper">
      <router-view></router-view>
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
        caller: this.$http
      }
    },
    methods: {

      callAPI: function (method, url, data) {
        this.callingAPI = true
        url = url || this.serverURI // if no url is passed then inheret local server URI
        return this.caller({
          url: url,
          method: method,
          data: data
        })
      },
      logout: function () {
        this.$store.commit('SET_USER', null)
        this.$store.commit('SET_TOKEN', null)

        if (window.localStorage) {
          window.localStorage.setItem('user', null)
          window.localStorage.setItem('token', null)
        }

        this.$router.push('/login')
      }
    },
    mounted() {
    	this.$router.push('login')
    }

  }
</script>
