<template>
  <div class="row">
      <div class="col-md-8 col-md-offset-2">
          <div class="panel panel-default">
              <div class="panel-heading">Referen dashboard</div>

              <div class="panel-body">
                  <button style="padding-left: 0px; padding-right: 0px;" type="button" @click="redirect" class="btn btn-link">Preglej prijavljene</button>
              </div>

          </div>
      </div>
  </div>
</template>

<script>
  export default {
    name: 'ReferentDashboard',
    data: function(router) {
        return {
          section: 'Referent'
        }
    },
    methods: {
      redirect: function(){
        this.$router.push("/referent/pregled_vpisanih");
      }
    },
    mounted() {
      console.log('referent dashboard mounted.');
      //this.$router.push('404');
      //console.log("should redirect")
    }
  }
</script>
