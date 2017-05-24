<template>
  <div class="container prijave">
    <div class="panel panel-body">
      <h3 style="text-align: center;">Seznam prijavljenih {{ programData.name }}</h3>
      <h5>Dodatni kriteriji iskanja: </h5>
      <datatable id="datatable" :columns="table_columns" :data="programData.id" :data-store="prijavljeni_store" class="programs-datatable" filterable paginate></datatable>
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
      //ker ne dela $on sem uporabil $root
    }
  }


</script>
