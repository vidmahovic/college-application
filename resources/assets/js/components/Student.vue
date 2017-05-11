<template>
  <div>
    <!-- Define side navigation for Student -->
    <div class="navbar-default sidebar" role="navigation">
      <div class="sidebar-nav navbar-collapse">
          <ul class="nav in" id="side-menu">
              <li>
                  <router-link to="/student">Namizje</router-link>
              </li>
          </ul>
      </div>
    </div>
    <div class="container" style="width: 90%">
        <router-view></router-view>
    </div>
  </div>
</template>

<script>
  export default {
    name: 'Student',
    data: function(router) {
        return {
          section: 'Student',
          application: {
            time_started: '04.04.2016',
            is_submited: true,
            id: 3

          }
        }
    },
    mounted() {
      console.log('Student dashboard mounted.');
      //this.$router.push('404');
      //console.log("should redirect")
    }
  }
</script>
