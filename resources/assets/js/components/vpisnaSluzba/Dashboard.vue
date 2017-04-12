<template>
  <div class="row">
      <div class="col-md-10 col-md-offset-1">
          <div class="panel panel-default">
              <div class="panel-body">
                <h2 style="text-align: center;">Datatable</h2>
                <datatable :columns="table_columns" :data="table_rows" filterable paginate></datatable>
              </div>
          </div>
      </div>
  </div>
</template>

<script>

  export default {
    name: "VpisnaSluzbaDashboard",
    data: function(router){
      return {
        table_columns: [
          {label: 'First Name', field: 'first_name',filterable: true},
          {label: 'Last Name', field: 'last_name'},
          {label: 'Age', field: 'age'}
        ],
        table_rows: [
          {
            first_name: "Denis",
            last_name: "Grabljevec",
            age: 24
          },
          {
            first_name: "Nejc",
            last_name: "Ambrožič",
            age: 23
          },
          {
            first_name: "Jure",
            last_name: "Habjan",
            age: 24
          }
        ]
      }
    }
  }

</script>
