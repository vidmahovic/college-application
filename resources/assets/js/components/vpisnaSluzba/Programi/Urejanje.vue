
<template>


  <div v-if="doRender" class="container">
    <div class="panel panel-body" >
      <h1>{{ programDetails.name }}</h1>
      <div class="row marginB20">
        <div class="col-md-12">
          <h4 class="programSection">Osnovni podatki</h4>
          <p class="program-text">{{ programDetails.faculty.data.university.data.name }}</p>
          <p>{{ programDetails.faculty.data.name }}</p>
          <p class="program-text">{{ programDetails.type == 0 ?  "Univerzitetni program" : (programDetails.type == 1 ? "Visokošolski program" : (programDetails.type == 2 ? "Enovitni magisterski program" : "Ni podatka")) }}</p>
          <p class="program-text">{{ programDetails.is_regular == 0 ? "Izredni študij" : "Redni študij" }} </p>
        </div>
      </div>
      <div class="row marginB20">
        <div class="col-md-12">
          <h4 class="programSection">Vpisna mesta programa</h4>
          <div class="row marginB15">
            <div class="col-md-12">
              <label for="vpisnaEU">Vpisna mesta - slovenski državljani in državljani EU</label>
              <input id="vpisnaEU" name="vpisnaEU" type="text" class="form-control inputWidth30" v-model="programDetails.max_accepted"/>
            </div>
          </div>
          <div class="row marginB15">
            <div class="col-md-12">
              <label for="vpisnaTujci">Vpisna mesta - slovenci brez državljanstva in tujci (državljani izven EU)</label>
              <input id="vpisnaTujci" name="vpisnaTujci" type="text" class="form-control inputWidth30" v-model="programDetails.max_accepted_foreiqn"/>
            </div>
          </div>
          <button @click="sendPoints" class="btn btn-primary btn-xs">Shrani spremembe</button>
          <p v-show="showResponse" v-bind:class="{'bg-danger': !resSucc, 'bg-success': resSucc}" style="padding: 10px; width: 30%; margin-top: 15px;"> {{ msg }} </p>
        </div>
      </div>
      <div class="row marginB20">
        <div class="col-md-12">
          <h4 class="programSection">Vpisni pogoji in izračun točk</h4>
          
          <div class="row" v-for="(cond, index) in programDetails.enrollmentConditions.data" style="margin-bottom:10px;">
            <div v-bind:class="{ 'col-md-3': 'id' in cond, 'col-md-8': !('id' in cond)}">
            
            <div v-if="'id' in cond">
              {{ sap.types[cond.type]}} <br /> {{ sap.names[cond.name]}}
            </div>
            <div v-else class="row">
              <div class="col-md-6">
              <v-select v-model="cond.type" :options="sap.types"></v-select>
              </div>
              <div class="col-md-6">
               <v-select v-model="cond.name" :options="sap.names"></v-select>
               </div>
            </div>
            </div>
            <div class="col-md-3">
            <div class="input-group">
              <input v-model.number="cond.weight" name="weight" type="number" placeholder="Utež" class="form-control" id="weight" >
              <span class="input-group-addon" id="basic-addon2" style="padding:0px;">
                <div class="btn btn-danger" v-on:click="programDetails.enrollmentConditions.data.splice(index, 1)">Odstrani</div>
              </span>
            </div>
            </div>
          </div>
          <div class="row">
            <button class="btn btn-default" @click="addCondition">Dodaj pogoj</button>
          </div>
        </div>
      </div>
      <button class="btn btn-primary" @click="updateConditions">Shrani pogoje</button>
      <button class="btn btn-danger pull-right" @click="deleteProgram">Brisanje programa</button>
      <p v-show="showConditionsResponse" v-bind:class="{'bg-danger': conditionsError, 'bg-success': !conditionsError}" style="padding: 10px; width: 30%; margin-top: 15px;">
        {{ conditionMsg }}
      </p>
      <p v-show="showResponseDel" v-bind:class="{'bg-danger': !resDelSucc, 'bg-success': resDelSucc}" style="padding: 10px; width: 30%; margin-top: 15px;"> {{ msgDel }} </p>
    </div>

  </div>

</template>


<style>
  .programSection {
    margin-bottom: 15px;
  }

  .programSection:after{
    display: block;
    content: '';
    height: 5px;
    border-bottom: 1px solid #000;
  }

  .program-text {
    margin-bottom: 0px;
  }

  .inputWidth30 {
    width: 30%;
  }

</style>

<script>
//za $on $emit
//import {eventBus} from '../../../app.js';

export default {
  name: "VpisnaSluzbaProgramiUrejanje",
  data: function(router){
    return {
      programDetails: {},
      msg: '',
      msgDel: '',
      showResponse: false,
      showResponseDel: false,
      resDelSucc: false,
      resSucc: true,
      doRender: false,
      sap: {},

      showConditionsResponse: false

    }
  },
  methods: {
    sendPoints: function() {
      this.$http.post("api/programs/update/"+this.programDetails.id, {max_accepted: this.programDetails.max_accepted, max_accepted_foreign: this.programDetails.max_accepted_foreiqn})
        .then(function(data) {
          this.resSucc = true;
          this.showResponse = true;
          this.msg = "Uspešno shranjeno!";
        }, function(err) {
          this.resSucc = false;
          this.showResponse = true;
          this.msg = "Podatki se niso uspešno shranili. Poskusite znova."
        })
    },
    deleteProgram: function(){
      this.$http.delete("api/programs/"+this.programDetails.id)
        .then(function(res){
          this.msgDel = "Program je uspešno izbrisan.";
          this.resDelSucc = true;
          this.showResponseDel = true;
          var that = this;
          setTimeout(function() {
            that.$router.push("/enrollment_service/programi");
          }, 1000);

        }, function(err) {
          this.msgDel = "Prišlo je do napake. Prosimo poskusite znova.";
          this.resDelSucc = false;
          this.showResponseDel = true;
        })
    },
    updateConditions: function() {

      let updateProgram = JSON.parse(JSON.stringify(this.programDetails));

      for(let c of updateProgram.enrollmentConditions.data){

        if(!('id' in c)) {
          c.name = this.sap.names.indexOf(c.name)
          c.type = this.sap.types.indexOf(c.type)
        }
      }

      // ker dobim enrolmentConditions, poslat je treba pa conditions -.-
      updateProgram.conditions = updateProgram.enrollmentConditions;
      delete updateProgram.enrollmentConditions;

      

      this.$http.post("api/programs/"+this.programDetails.id+"/conditions", updateProgram)
        .then(function(data) {
          this.conditions = false;
          this.conditionMsg = "Pogoji uspešno shranjeni";
          this.showConditionsResponse = true;
          console.log(data)
        }, function(err) {
          
            console.log(err);
            this.conditionsError = true;
            //this.conditionsErrors = JSON.parse(err.body.message).conditions;
            this.conditionMsg = JSON.parse(err.body.message);
            this.showConditionsResponse = true;
          
            
        });

      
    },
    addCondition: function() {

      let cond = {
        conditions_subject_id: null,
        faculty_program_id: null,
        name: "",
        type: "",
        weight: 0,
        faculty_program_id: this.programDetails.id
      };

      this.programDetails.enrollmentConditions.data.push(cond);
    }
  },
  created: function() {
    //ker ne dela $on sem uporabil $root
    // this.$on('programdata', function(data){
    //   console.log(data);
    //   this.program_details = data;
    // });
    this.programDetails = this.$root.programData;
    
    if(typeof this.$root.programData == 'undefined') {
      console.log("no data")
      
      this.$http.get("api/subjectsAndProfessions/")
        .then(function(data) {
          
          console.log(data);
          this.sap = data.body;
          this.$http.get("api/programs/"+this.$route.params.id)
            .then(function(data) {

              this.programDetails = data.body.data;
            
              this.doRender = true;
              console.log(this.programDetails);
            }, function(err) {
              console.log(err);
            });
        }, function(err) {
          console.log(err);
        })
    


    
    }else{
      this.doRender = true;
      console.log(this.programDetails);
    }

    
    
  }
}

</script>
