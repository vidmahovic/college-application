<template>
  <div class="container prijave">
    <div class="panel panel-body">
      <h3 style="text-align: center;">Seznam prijavljenih {{ programData.name || " na izbran program" }}</h3>
      <h4>Dodatni kriteriji iskanja: </h4>
      <div class="row">
        <div class="col-md-12">
          <h6>Državljanstvo</h6>
          <input type="radio" id="one" value="0" v-model="params.regular">
          <label style="margin-right: 15px;" for="one">Državljani Slovenije</label>

          <input type="radio" id="two" value="1" v-model="params.regular">
          <label style="margin-right: 15px;" for="two">Tujci EU</label>

          <input type="radio" id="three" value="2" v-model="params.regular">
          <label style="margin-right: 15px;" for="three">Tujci izven EU</label>

          <input type="radio" id="four" value="3" v-model="params.regular">
          <label style="margin-right: 15px;" for="four">Slovenci brez slovenskega državljanstva</label>
        </div>
      </div>
      <div class="row marginB40">
        <div class="col-md-12">
          <h6>Iskanje programa:</h6>
          <v-select v-model="params.selectedProgram" label="name" :options="referentPrograms"></v-select>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <datatable id="datatable" :columns="table_columns" :data="programData.id" :data-store="prijavljeni_store" class="programs-datatable" paginate></datatable>
        </div>
      </div>


    </div>
  </div>
</template>

<script>
import prijavljeni_store from './prijavljeni_store.js';

  export default {
    name: 'PregledVpisanih',
    data: function(router){
      return {
        programData: '',
        referentPrograms: [],
        params: {
          regular: '',
          selectedProgram: ''
        },
        table_columns: [
          {label: '#', field: 'id'},
          {label: 'Ime in priimek', field: 'applicant.data.name'},
          {label: 'Naslov', field: 'mailingAddress.meta.address'},
          {label: 'Mesto', field: 'mailingAddress.data.name'},
          {label: 'Državljanstvo', field: 'citizen.data.name'},
          {label: 'Način zaključka srednje šole', field: 'graduation.data.name'}

        ],
        prijavljeni_store: prijavljeni_store
      }
    },
    created: function() {
      this.programData = this.$root.programData;

      this.$http.get('/api/programs', {params: {filters: {faculty_id: this.programData.faculty_id}}})
        .then(function(res){
          this.referentPrograms = res.data.data;
        })
      //ker ne dela $on sem uporabil $root
    }
  }


</script>
