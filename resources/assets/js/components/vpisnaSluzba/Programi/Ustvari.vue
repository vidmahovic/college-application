
<template>


  <div class="container">
    <div class="panel panel-body">
      <h1>{{ facultyName || "Ime fakultete"}}</h1>
      <h3>{{ programName || "Ime programa" }}</h3>
      <h4>{{ universityName || "Ime univerze" }}</h4>
      <form role="form" @submit.prevent="saveProgram">
        <div class="row marginB20">
          <div class="col-md-12">
            <h4 class="programSection">Osnovni podatki</h4>
            <label>Izberite fakulteto programa:</label>
            <v-select v-model="uFaculty" label="name" name="idFaculty" :options="allFaculties" :on-change="programChange"></v-select>

            <div class="row marginB15" style="margin-top: 15px;">
              <div class="col-md-12">
                <label for="nameProgram">Ime programa:</label>
                <input v-validate="'required'" type="text" id="nameProgram" name="name" v-model="programName" class="form-control">
                <p class="text-danger" v-if="errors.has('name')"> <!--{{errors.first('name')}} -->Ime programa je obvezen podatek!</p>
              </div>
            </div>
            <div class="row marginB15" style="margin-top: 15px;">
              <div class="col-md-12">
                <label for="idProgram">Id programa:</label>
                <input v-validate="'required'" type="text" name="id" id="idProgram" v-model="newProgram.id" class="form-control">
                <p class="text-danger" v-if="errors.has('id')"> <!--{{errors.first('name')}} -->Prosimo vnesite id programa</p>
              </div>
            </div>
            <div class="row marginB15" style="margin-top: 15px;">
              <div class="col-md-3">
                <input type="radio" name="type" id="two2" value="0" v-validate="'required|in:0,1,2'"  v-model="typeButton" v-on:click="type1('0')">
                <label for="two2">Univerzitetni program</label>
              </div>
              <div class="col-md-3">
                <input type="radio" id="two3" name="type" value="1" v-model="typeButton" v-on:click="type1('1')">
                <label for="two3">Visokošolski program</label>
              </div>
              <div class="col-md-3">
                <input type="radio" id="two4" name="type" value="2" v-model="typeButton" v-on:click="type1('2')">
                <label for="two4">Enovitni magisterski program</label>
              </div>
              <div class="col-md-12">
                <p class="text-danger" v-if="errors.has('type')">Prosimo označite eno od izbiro!</p>
              </div>
            </div>

            <div class="row">
              <div class="col-md-3">
                <input type="radio" id="one1" v-validate="'required|in:0,1'" name="is_regular" value="1" v-model="regularButton" v-on:click="regular('1')">
                <label for="one1">Redni program</label>
              </div>
              <div class="col-md-3">
                <input type="radio" id="one2" name="is_regular" value="0" v-model="regularButton" v-on:click="regular('0')">
                <label for="one2">Izredni program</label>
              </div>
              <div class="col-md-12">
                <p class="text-danger" v-if="errors.has('is_regular')"> <!--{{errors.first('name')}} -->Prosimo označite eno od izbiro!</p>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="checkbox">
                  <label><input type="checkbox" value="1" name="allow_double_degree"  v-model="newProgram.allow_double_degree">Dvopredmetni program</label>
                </div>
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
                <input v-validate="'required|numeric'" id="vpisnaEU" name="max_accepted" type="text" class="form-control inputWidth30" v-model="newProgram.max_accepted"/>
                <p class="text-danger" v-if="errors.has('max_accepted')"> <!--{{errors.first('name')}} -->Vnos mora biti število!</p>
              </div>
            </div>
            <div class="row marginB15">
              <div class="col-md-12">
                <label for="vpisnaTujci">Vpisna mesta - slovenci brez državljanstva in tujci (državljani izven EU)</label>
                <input v-validate="'required|numeric'" id="vpisnaTujci" name="max_accepted_foreign" type="text" class="form-control inputWidth30" v-model="newProgram.max_accepted_foreign"/>
                <p class="text-danger" v-if="errors.has('max_accepted_foreign')"> <!--{{errors.first('name')}} -->Vnos mora biti število!</p>
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
        <button type="submit" class="btn btn-primary" style="text-align: center;">Shrani program</button>
      </form>

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
        id: '',
        faculty: '',
        type: '',
        is_regular: '',
        max_accepted: 0,
        max_accepted_foreign: 0,
        allow_double_degree: ''
      }
    }
  },
  methods: {
    type1: function(param) {
      this.newProgram.type = param;
    },
    regular: function(param) {
      this.newProgram.is_regular = param == '1' ? true : false;
    },
    saveProgram: function() {

      this.$validator.validateAll();
      if (this.errors.any()) {
        console.log("VALIDATION FAILED")
        return;
      }

      this.newProgram.name = this.programName;

      var newProgram = this.newProgram;

      newProgram.allow_double_degree = (newProgram.allow_double_degree == '') ? false : true;

      console.log(newProgram);

      this.$http.post("api/programs/create", {name: newProgram.name,
                                              id: newProgram.id,
                                              faculty_id: newProgram.faculty,
                                              type: newProgram.type,
                                              is_regular: newProgram.is_regular,
                                              max_accepted: newProgram.max_accepted,
                                              max_accepted_foreign: newProgram.max_accepted_foreign,
                                              min_points: 0,
                                              allow_double_degree: newProgram.allow_double_degree})
        .then(function(res) {
          console.log(res);
        });


      // id, name, type = [0,1,2], faculty_id, allow_double_degree [boolean], is_regular[boolean], min_points, max_accepted, max_accpted_foreign
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
