<template>
<div class="container">
  <div class="panel panel-body">
    <div class="row">
      <div class="col-md-12">
        <router-link to="/enrollment_service/programi">Preglej študijske programe</router-link>
      </div>
    </div>
    <div class="row" style="margin-top: 30px;">
      <div class="col-md-12">
        <button class="btn btn-primary" @click="razvrsti">Razvrsti študente glede na vpis</button>
      </div>
    </div>
  </div>
</div>
</template>

<script>


  export default {
    name: "VpisnaSluzbaDashboard",
    methods: {
      razvrsti: function(){
        this.$http.get('/api/classify/eu')
          .then(function(){
            this.$http.get('/api/classify/foreign')
              .then(function(){
                console.log("Vse super!");
              })
          })


      }
    }
  }

</script>
