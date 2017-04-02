<template>
  <div>
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
          </ul>
      </div>
       
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Admin dashboard</div>

                    <div class="panel-body">
                        Dashboard component2!!!
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
  </div>
</template>

<script>
  export default {
    name: 'Admin Dashboard',
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
