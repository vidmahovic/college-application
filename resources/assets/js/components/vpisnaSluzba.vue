<template>
  <div>
    <!-- Define side navigation for Admin -->
    <div class="navbar-default sidebar" role="navigation">
      <div class="sidebar-nav navbar-collapse">
          <ul class="nav in" id="side-menu">
              <li>
                  <router-link to="/enrollment_service/programi">Programi</router-link>

              </li>
              <li>
                  <router-link to="/enrollment_service/prijavljeni">Pregled vpisanih študentov</router-link>

              </li>
              <li>
                  <router-link to="/enrollment_service/sprejeti">Seznam sprejetih študentov</router-link>

              </li>
              <li>
                  <router-link to="/enrollment_service/io">Uvoz podatkov</router-link>
              </li>
          </ul>
      </div>

    </div>
    <div>
        <router-view></router-view>
    </div>
  </div>

</template>

<script>


  export default {
    name: 'vpisnaSluzba',
    data: function(router) {
        return {
          section: 'Vpisna Sluzba'
        }
    },
    mounted() {
      console.log('referent dashboard mounted.');
      //this.$router.push('404');
      //console.log("should redirect")
    }
  }
</script>
