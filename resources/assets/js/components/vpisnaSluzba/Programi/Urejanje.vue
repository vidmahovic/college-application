
<template>


  <div class="container">
    <div class="panel panel-body">
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
          <h1>TODO</h1>
        </div>
      </div>
      <button class="btn btn-danger" @click="deleteProgram">Brisanje programa</button>
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
            that.$router.push("/vpisna_sluzba/programi");
          }, 1000);

        }, function(err) {
          this.msgDel = "Prišlo je do napake. Prosimo poskusite znova.";
          this.resDelSucc = false;
          this.showResponseDel = true;
        })
    }
  },
  created: function() {
    //ker ne dela $on sem uporabil $root
    // this.$on('programdata', function(data){
    //   console.log(data);
    //   this.program_details = data;
    // });
    this.programDetails = this.$root.programData;
    console.log(this.programDetails)
    //console.log(this.$route.params);
  }
}

</script>
