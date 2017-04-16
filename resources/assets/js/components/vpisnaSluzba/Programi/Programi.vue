<template>
  <div class="row">
    <div class="col-md-2">
      <div class="panel panel-body">
        <h2>Filtri:</h2>
        <h4>Način študija</h4>
        <input type="radio" id="one" value="0" v-model="params.regular" v-on:click="regular1('0')">
        <label for="one">Izredni programi</label>
        <br>
        <input type="radio" id="two" value="1" v-model="params.regular" v-on:click="regular1('1')">
        <label for="two">Redni programi</label>
        <br>
        <h4>Vrsta programa</h4>
        <input type="radio" id="one1" value="0" v-model="params.type" v-on:click="type1('0')">
        <label for="one1">Univerzitetni</label>
        <br>
        <input type="radio" id="two2" value="1" v-model="params.type" v-on:click="type1('1')">
        <label for="two2">Visokošolski</label>
        <br>
        <input type="radio" id="three3" value="2" v-model="params.type" v-on:click="type1('2')">
        <label for="three3">Magistrski</label>
      </div>
    </div>
      <div class="col-md-10">
          <div class="panel panel-default">
              <div class="panel-body">
                <h2 style="text-align: center;">Tabela študijskih programov</h2>
                <datatable :columns="table_columns" :data="params" :data-store="ajax_store" filterable paginate></datatable>
              </div>
          </div>
      </div>
  </div>
</template>

<script>

import ajax_store from './ajax_store.js';

  export default {
    name: "VpisnaSluzbaProgrami",
    data: function(router){
      return {
        params: {
          regular: '',
          type: ''
        },
        table_columns: [
          {label: 'Fakulteta', field: 'faculty.name'},
          {label: 'Program', field: 'name'},
          {label: 'Vrsta programa',
            callback: function(row){
              if(row.type == 0){
                return "Univerzitetni program";
              }
              else if(row.type == 1){
                return "Visokošolski program";
              }
              else if(row.type == 2){
                return "Enovitni magisterski program"
              }
            }
          },
          {label: 'Način študija',
            callback: function(row){
              if(row.is_regular){
                return "Redni študij";
              }
              else {
                return "Izredni študij";
              }
            }
          },
          {label: 'Omejitev',
            callback: function(row){
              if(row.min_points == 0){
                return "Ni omejitve";
              }
              else{
                return row.min_points;
              }
            }
          },
          {label: 'Razpisanih mest', field: 'max_accept', align: 'center'},
          {label: 'Število prijavljenih'},
          {label: 'Število sprejetih'}
        ],
        ajax_store: ajax_store
      }
    },
    methods: {
      regular1: function(param){
        this.params = {
          regular: param,
          type: this.params.type
        };
      },
      type1: function(param){
        this.params = {
          regular: this.params.regular,
          type: param
        };
      }
    }
  }

</script>
