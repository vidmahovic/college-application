<template>
  <div class="row">
      <div class="col-md-10">
          <div class="panel panel-default">
              <div class="panel-body">
                <h2 style="text-align: center;">Datatable</h2>
                <datatable :columns="table_columns" :data="table_rows" filterable paginate></datatable>
              </div>
          </div>
      </div>
      <div class="col-md-2">
        <div class="panel panel-body">
          <h2>Filtri:</h2>
          <h4>Način študija</h4>
          <input type="radio" id="one" value="0" v-model="regular" v-on:click="regular1('0')">
          <label for="one">Izredni programi</label>
          <br>
          <input type="radio" id="two" value="1" v-model="regular" v-on:click="regular1('1')">
          <label for="two">Redni programi</label>
          <br>
          <h4>Vrsta programa</h4>
          <input type="radio" id="one1" value="0" v-model="type" v-on:click="type1('0')">
          <label for="one1">Univerzitetni</label>
          <br>
          <input type="radio" id="two2" value="1" v-model="type" v-on:click="type1('1')">
          <label for="two2">Visokošolski</label>
          <br>
          <input type="radio" id="three3" value="2" v-model="type" v-on:click="type1('2')">
          <label for="three3">Magistrski</label>
        </div>
      </div>
  </div>
</template>

<script>

//import ajax_store from './ajax_store.js';

  export default {
    name: "VpisnaSluzbaDashboard",
    data: function(router){
      return {
        regular: '',
        type: '',
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
          {label: 'Razpisanih mest', field: 'max_accept', align: 'center'}
        ],
        table_rows: []
        //ajax_store: ajax_store
      }
    },
    methods: {
      regular1: function(param){
        this.$http.get('/api/programs', {params: {is_regular: param, type: this.type}})
          .then(function(res){
            this.table_rows = res.data.data;
          }, function(err){
            console.log(err);
          })
      },
      type1: function(param){
        this.$http.get('/api/programs', {params: {type: param, is_regular: this.regular}})
          .then(function(res){
            this.table_rows = res.data.data;
          }, function(err){
            console.log(err);
          })
      }
    },
    created: function(){
      this.$http.get('/api/programs')
        .then(function(res){
          this.table_rows = res.data.data;
        })
    }
  }

</script>
