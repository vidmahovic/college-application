<template>
  <div>
    <div class="container prijave">
      <div class="panel panel-body">
        <h3 style="text-align: center;">Seznam sprejetih {{ params.programData.name || " na izbran program" }}</h3>
        <h4>Dodatni kriteriji iskanja: </h4>
        <div class="row">
          <div class="col-md-12">
            <h6>Državljanstvo</h6>
            <input type="radio" id="one" value="1" v-model="regular"  v-on:click="regular1('0')">
            <label style="margin-right: 15px;" for="one">Državljani Slovenije in EU</label>

            <input type="radio" id="two" value="6" v-model="regular"  v-on:click="regular1('1')">
            <label style="margin-right: 15px;" for="two">Tujci izven EU in slovenci brez slovenskega državljanstva</label>
          </div>
        </div>
        <div class="row marginB40">
          <div v-if="role != 'referent' && $route.name == 'Sprejeti1'" class="col-md-12">
            <h6>Filtriranje po fakulteti:</h6>
            <v-select v-model="params.facultyData" label="name" :options="faculties" :on-change="spremeniFakulteto"></v-select>
          </div>
          <div v-if="role == 'referent' || $route.name == 'Sprejeti1'" class="col-md-12">
            <h6>Iskanje programa:</h6>
            <v-select v-model="params.programData" label="name" :options="referentPrograms" :on-change="spremeniProgram"></v-select>
          </div>
          <div class="col-md-12 marginT20">
            <button v-on:click="savePdf1" class="btn btn-primary">Prenesi PDF</button>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <datatable id="datatable" :columns="table_columns" :data="params" :data-store="sprejeti_store" class="programs-datatable"></datatable>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import sprejeti_store from './sprejeti_store.js';

  export default {
    name: 'Sprejeti',
    data: function(router){
      return {
        role: '',
        faculty_id: '',
        regular: '',
        params: {
          programData: '',
          facultyData: ''
        },
        referentPrograms: [],
        faculties: [],
        faculty_id: '',
        table_columns: [
          {label: '#', field: 'id'},
          {label: 'Ime in priimek', field: 'applicant.data.name'},
          {label: 'Naslov', field: 'mailingAddress.meta.address'},
          {label: 'Mesto', field: 'mailingAddress.data.name'},
          {label: 'Število točk', field: 'mailingAddress.data.name'}

        ],
        sprejeti_store: sprejeti_store
      }
    },
    methods: {
      savePdf1: function(){
        var postData = {
          program_id: this.params.programData.id,
          faculty_id: this.params.facultyData.id
        };

        this.$http.get('/api/applications/accepted', {params: {filters: postData}})
          .then(function(res){
            //prijavljeniPdf(res.body.data);
          })

      },
      spremeniFakulteto: function(val){
        if(val == null){
          this.params = {
            facultyData: '',
            programData: this.params.programData
          };

          this.faculty_id = '';
        }
        else {
          this.params = {
            facultyData: val,
            programData: this.params.programData
          };

          this.faculty_id = val.id;
        }

        this.$http.get('/api/programs', {params: {filters: {faculty_id: this.faculty_id}}})
          .then(function(res){
            this.referentPrograms = res.data.data;
          });


      },
      spremeniProgram: function(val){
        if(val == null){
          this.params = {
            programData: '',
            facultyData: this.params.facultyData
          };
        }
        else {
          this.params = {
            programData: val,
            facultyData: this.params.facultyData
          };
        }
      },
      regular1: function(val){
        console.log(val);
      }
    },
    created: function(){
      var user = JSON.parse(window.localStorage.getItem('user'));
      this.role = user.role;

      if(user.role == 'referent'){
        this.faculty_id = user.faculty.data.id;
      }
      else if(this.$route.name == 'Sprejeti') {
        this.params.programData = this.$root.programData;
        this.faculty_id = this.params.programData.faculty_id;
      }

      if(this.$route.name == 'Sprejeti1'){
        this.$http.get('/api/faculties')
          .then(function(res){
            this.faculties = res.data.data;
          });
      }

      this.$http.get('/api/programs', {params: {filters: {faculty_id: this.faculty_id}}})
        .then(function(res){
          this.referentPrograms = res.data.data;
        });
    }
  }

</script>
