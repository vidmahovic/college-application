<template>
  <div class="row">
      <div class="col-md-10 col-md-offset-1">
          <div class="panel panel-default">
              <div class="panel-body">
                <h2 style="text-align: center;">Datatable</h2>
                <datatable :columns="table_columns" :data="table_rows" :data-store="ajax_store" filterable paginate></datatable>
              </div>
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
    created: function(){
      this.$http.get('/api/programs')
        .then(function(res){
          this.table_rows = res.data.data;
        })
    }
  }

</script>
