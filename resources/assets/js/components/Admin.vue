<template>
  <div>
    <!-- Define side navigation for Admin -->
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
                  <router-link to="/referent">Referent</router-link>
              </li>
              <li>
                  <router-link to="/enrollment_service">Vpisna služba</router-link>
              </li>
          </ul>
      </div>

    </div>
    <div class="container">
        <router-view></router-view>
    </div>
  </div>
</template>

<script>
  export default {
    name: 'Admin',
    data: function(router) {
        return {
          section: 'Admin'
        }
    },
    mounted() {
      console.log('admin dashboard mounted.');
      //this.$router.push('404');
      //console.log("should redirect")
    }
  }
</script>
