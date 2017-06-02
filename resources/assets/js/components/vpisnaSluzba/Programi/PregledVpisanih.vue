<template>
  <div class="container prijave">
    <div class="panel panel-body">
      <h3 style="text-align: center;">Seznam prijavljenih {{ params.programData.name || " na izbran program" }}</h3>
      <h4>Dodatni kriteriji iskanja: </h4>
      <div class="row">
        <div class="col-md-12">
          <h6>Državljanstvo</h6>
          <input type="radio" id="one" value="1" v-model="params.regular"  v-on:click="regular1('1')">
          <label style="margin-right: 15px;" for="one">Državljani Slovenije</label>

          <input type="radio" id="two" value="6" v-model="params.regular"  v-on:click="regular1('6')">
          <label style="margin-right: 15px;" for="two">Tujci EU</label>

          <input type="radio" id="three" value="3" v-model="params.regular" v-on:click="regular1('3')">
          <label style="margin-right: 15px;" for="three">Tujci izven EU</label>

          <input type="radio" id="four" value="4" v-model="params.regular" v-on:click="regular1('4')">
          <label style="margin-right: 15px;" for="four">Slovenci brez slovenskega državljanstva</label>
        </div>
      </div>
      <div class="row marginB40">
        <div v-if="role == 'referent'" class="col-md-12">
          <h6>Iskanje programa:</h6>
          <v-select v-model="params.programData" label="name" :options="referentPrograms" :on-change="spremeniProgram"></v-select>
        </div>
        <div class="col-md-12">
          <button v-on:click="savePdf1" class="btn btn-primary">Prenesi PDF</button>
        </div>
      </div>

      <div class="row">
        <div class="col-md-12">
          <datatable id="datatable" :columns="table_columns" :data="params" :data-store="prijavljeni_store" class="programs-datatable" paginate></datatable>
        </div>
      </div>


    </div>
  </div>
</template>

<script>
import prijavljeni_store from './prijavljeni_store.js';

function prijavljeniPdf(seznam) {
  var doc = new jsPDF('landscape');
  var header = ["#", "Ime in priimek", "Naslov", "Mesto", "Državljanstvo", "Način zaključka srednje šole"];

  //210 je visina, 297mm sirina
  doc.setLineWidth(0.1);
  doc.setFont("sans-serif");

  doc.setTextColor(99, 107, 111);
  doc.setFontSize(20);
  doc.text(148, 20, "Tabela prijavljenih študentov", null, null, "center");

  //table header
  doc.setFontSize(10);
  var x = 8;

  for(var i in header){
    var res = header[i].split(" ");
    if(i == 5){
      doc.text(x, 35, res[0]);
      doc.text(x, 40, res[1]);
    }
    else{
      doc.text(x, 40, header[i]);
    }

    if(i == 0){
      x += 6;
    }
    else if(i == 1 || i == 3 ){
      x += 40;
    }
    else if(i == 2){
      x += 60;
    }
    else if(i == 4 || i == 5){
      x += 30;
    }
  }
}

  export default {
    name: 'PregledVpisanih',
    data: function(router){
      return {
        programData: '',
        referentPrograms: [],
        role: '',
        faculty_id: '',
        params: {
          regular: '',
          programData: ''
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
    methods: {
      savePdf1: function(){
        prijavljeniPdf([]);
      },
      regular1: function(param){
        this.params = {
          regular: param,
          programData: this.params.programData
        };
      },
      spremeniProgram: function(val){
        this.params = {
          regular: this.params.regular,
          programData: val
        };
      }
    },
    created: function() {
      var user = JSON.parse(window.localStorage.getItem('user'));
      debugger;
      this.role = user.role;
      if(user.role == 'referent'){
        this.faculty_id = user.faculty.data.id;
      }
      else {
        this.params.programData = this.$root.programData;
        this.faculty_id = this.params.programData.faculty_id;
      }

      this.$http.get('/api/programs', {params: {filters: {faculty_id: this.faculty_id}}})
        .then(function(res){
          this.referentPrograms = res.data.data;
        })
      //ker ne dela $on sem uporabil $root
    }
  }



</script>
