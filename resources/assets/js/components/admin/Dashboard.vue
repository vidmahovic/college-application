<template>

  <div class="row">
      <div class="col-md-8 col-md-offset-2">
          <div class="panel panel-default">
              <div class="panel-heading">Admin dashboard</div>

              <div class="panel-body">
                <router-link to="/admin/registracija">Registracija zaposlenega</router-link>
                  Dashboard component2!!!
              </div>

          </div>
      </div>
  </div>
</template>

<script>
  export default {
    name: 'AdminDashboard',
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
