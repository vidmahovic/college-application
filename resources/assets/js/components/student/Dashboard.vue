<template>
  <div class="row">
      <div class="col-md-10 col-md-offset-1">
          <div class="panel panel-default">
              <!--<div class="panel-heading">Moja prijave</div>-->

              <div class="panel-body" >
                <h2 v-if="application.is_submited">Imate oddano vpisnico</h2>
                <table class="table">
                  <thead>
                    <th>Datum oddaje</th>
                  </thead>
                  <tbody>
                    <tr>
                      <td>{{ application.time_started }}</td>
                      <td v-if="application.is_submited" v-on:click="goto_application(application)" class="btn btn-default pull-right">
                        Izbrisi in oddaj ponovno
                      </td>
                      <td v-else="application.is_submited" v-on:click="goto_application(application)" class="btn btn-default pull-right">
                        Nadaljuj s prijavo
                      </td>
                      <td class="btn btn-primary pull-right">Preglej</td>
                 
                    </tr>
                  </tbody>
                </table>
                  
              </div>
              
          </div>
      </div>
  </div>
</template>

<script>
  export default {
    name: 'StudentDashboard',
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
    methods: {
      goto_application: function(event, application) {
        this.$router.push('application')
      }
    },
    mounted() {
      console.log('Student dashboard mounted.');
      //this.$router.push('404');
      //console.log("should redirect")
    }
  }
</script>
