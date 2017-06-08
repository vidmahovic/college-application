<template>
  <div>
    <!-- Define side navigation for Referent -->
    <div class="navbar-default sidebar" role="navigation">
      <div class="sidebar-nav navbar-collapse">
          <ul class="nav in" id="side-menu">
              <li>
                  <router-link to="/">"Logout"</router-link>

              </li>
              <li>
                  <router-link to="/student">Student</router-link>
              </li>
              <li>
                  <router-link to="/admin">admin</router-link>
              </li>
              <li>
                  <router-link to="/enrollment_service">Vpisna služba</router-link>
              </li>
          </ul>
      </div>

    </div>
    <div class="container" style="width:90%">
        <router-view></router-view>
    </div>
  </div>
</template>

<script>
  export default {
    name: 'Referent',
    data: function(router) {
        return {
          section: 'Referent'
        }
    },
    mounted() {
      console.log('referent dashboard mounted.');
      //this.$router.push('404');
      //console.log("should redirect")
    }
  }
</script>
