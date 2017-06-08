<template>

  <div v-if="doRender" class="container">
    <div class="panel panel-body" >
      <h1>Izračun točk</h1>

      <h3>Kandidat</h3>
      <table class="table">
	    <thead>
	      <tr>
	      	<th>Ime in priimek</th>
	        <th>Emšo</th>
	        <th>Državljanstvo</th>
	        <th>Način zaključka srednje šole</th>
	      </tr>
	    </thead>
	    <tbody>
	      <tr>
	      	<td>{{rowData.applicant.data.name}}</td>
	      	<td>{{rowData.emso}}</td>
	      	<td>{{rowData.citizen.data.name}}</td>
	      	<td>{{rowData.graduation.data.name}}</td>
	      </tr>
	       
	    </tbody>
	    </table>
      <hr />
      
      <table class="table table-striped">
	    <thead>
	      <tr>
	      	<th>Želja</th>
	        <th>Šifra</th>
	        <th>Ime programa</th>
	        <th>Točke</th>
	      </tr>
	    </thead>
	    <tbody>
	      <tr v-for="(w, index) in apl.wishes">
	      	<td>{{index+1}}</td>
	      	<td>{{w.id}}</td>
	      	<td>{{w.name}}</td>
	      	<td>{{w.pivot.points}}</td>
	      </tr>
	       
	    </tbody>
	  </table>
      
    </div>

  </div>

</template>


<script>

export default {
  name: "Calculation",
  data: function(router){
    return {
    	doRender: false
    }
  },
  methods: {
    sendPoints: function() {
    	console.log("method");
    }
  },
  created: function() {
    

  	console.log("Calculation")
  	console.log(this.$root.userApplicationPoints);

  	this.rowData = this.$root.userApplicationPoints;

      this.$http.get("api/applications/"+this.$root.userApplicationPoints.id+"/calculate")
        .then(function(data) {
        	console.log(data)

        	this.apl = data.body.application;

        	this.doRender = true;
        }, function(err) {
          console.log(err);
        })


  }
}

</script>
