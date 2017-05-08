
<template>


  <div class="container">
    <div class="panel panel-body">
      <h1>{{ facultyName || "Ime fakultete"}}</h1>
      <h3>{{ programName || "Ime programa" }}</h3>
      <h4>{{ universityName || "Ime univerze" }}</h4>
      <div class="row marginB20">
        <div class="col-md-12">
          <h4 class="programSection">Osnovni podatki</h4>
          <label>Izberite fakulteto programa:</label>
          <v-select v-model="uFaculty" label="name" :options="allFaculties" :on-change="programChange"></v-select>
          <div class="row marginB15" style="margin-top: 15px;">
            <div class="col-md-12">
              <label for="nameProgram">Ime programa:</label>
              <input type="text" id="nameProgram" v-model="programName" class="form-control">
            </div>
          </div>
          <div class="row marginB15" style="margin-top: 15px;">
            <div class="col-md-3">
              <input type="radio" id="two2" value="0" v-model="typeButton" v-on:click="type1('0')">
              <label for="two2">Univerzitetni program</label>
            </div>
            <div class="col-md-3">
              <input type="radio" id="two3" value="1" v-model="typeButton" v-on:click="type1('1')">
              <label for="two3">Visokošolski program</label>
            </div>
            <div class="col-md-3">
              <input type="radio" id="two4" value="2" v-model="typeButton" v-on:click="type1('2')">
              <label for="two4">Enovitni magisterski program</label>
            </div>
          </div>
          <div class="row">
            <div class="col-md-3">
              <input type="radio" id="one1" value="1" v-model="regularButton" v-on:click="regular('1')">
              <label for="one1">Redni program</label>
            </div>
            <div class="col-md-3">
              <input type="radio" id="one2" value="0" v-model="regularButton" v-on:click="regular('0')">
              <label for="one2">Izredni program</label>
            </div>
          </div>
        </div>
      </div>
      <div class="row marginB20">
        <div class="col-md-12">
          <h4 class="programSection">Vpisna mesta programa</h4>
          <div class="row marginB15">
            <div class="col-md-12">
              <label for="vpisnaEU">Vpisna mesta - slovenski državljani in državljani EU</label>
              <input id="vpisnaEU" name="vpisnaEU" type="text" class="form-control inputWidth30" v-model="newProgram.max_accepted"/>
            </div>
          </div>
          <div class="row marginB15">
            <div class="col-md-12">
              <label for="vpisnaTujci">Vpisna mesta - slovenci brez državljanstva in tujci (državljani izven EU)</label>
              <input id="vpisnaTujci" name="vpisnaTujci" type="text" class="form-control inputWidth30" v-model="newProgram.max_accepted_foreign"/>
            </div>
          </div>
        </div>
      </div>
      <div class="row marginB20">
        <div class="col-md-12">
          <h4 class="programSection">Vpisni pogoji in izračun točk</h4>
          <h1>TODO</h1>
        </div>
      </div>
      <button class="btn btn-primary" style="text-align: center;" @click="saveProgram">Shrani program</button>
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
  name: "VpisnaSluzbaProgramiUstvari",
  data: function(router){
    return {
      allFaculties: [],
      typeButton: '',
      regularButton: '',
      programName: '',
      uFaculty: null,
      facultyName: '',
      universityName: '',
      newProgram: {
        name: '',
        faculty: '',
        type: '',
        regular: '',
        max_accepted: 0,
        max_accepted_foreign: 0
      }
    }
  },
  methods: {
    type1: function(param) {
      this.newProgram.type = param;
    },
    regular: function(param) {
      this.newProgram.regular = param;
    },
    saveProgram: function() {
      this.newProgram.name = this.programName;
      console.log(this.newProgram);
      // this.$http.post("api/programs/create", {newProgram})
      //   .then(function(res) {
      //     console.log(res);
      //   });
    },
    programChange: function(param) {
      if(param == null){
        this.facultyName = '';
        this.universityName = '';
        this.newProgram.faculty = '';
      }
      else {
        this.facultyName = param.name;
        this.universityName = param.university.data.name;
        this.newProgram.faculty = param.id;
      }
    }
  },
  created: function(){
    this.$http.get("/api/faculties")
      .then(function(res){
        this.allFaculties = res.data.data;
      });
  }
}

</script>
