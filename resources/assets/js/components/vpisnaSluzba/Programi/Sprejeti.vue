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

function prijavljeniPdf(data, params) {
  var doc = new jsPDF('landscape');
  var header = ["#", "St. prijave", "Ime in priimek", "Naslov", "Mesto", "Točke"];

  //210 je visina, 297mm sirina
  doc.setLineWidth(0.1);
  doc.setFont("sans-serif");

  doc.setTextColor(99, 107, 111);
  doc.setFontSize(20);
  doc.text(148, 20, "Tabela sprejetih študentov", null, null, "center");

  /*doc.setFontSize(7);
  var tmp1 = params.facultyData.name.replace("Č", "C").replace("Š", "S");
  doc.text(148, 25, tmp1, null, null, "center");

  tmp1 = params.programData.name.replace("Č", "C").replace("Š", "S");
  doc.text(148, 30, tmp1, null, null, "center");*/

  //table header
  doc.setFontSize(10);
  var x = 10;

  for(var i in header){

    doc.text(x, 40, header[i].replace("č", "c").replace("Š", "S"));

    if(i == 0){
      x += 10;
    }
    else if(i == 1){
      x += 35;
    }
    else if(i == 2){
      x+=60;
    }
    else if(i == 3){
      x += 60;
    }
    else if(i == 5){
      x += 50;
    }
    else if(i == 4){
      x += 70;
    }
  }

  // začetek vsebine
  var y = 47
  var counter = 1;
  var totalPages = 1;
  doc.setFontSize(9);
  for(var i in data){
    x = 10;
    doc.text(x, y, counter.toString());

    x += 10;
    var tmp = data[i].id.toString();

    doc.text(x, y, tmp);

    x += 35;

    tmp = data[i].applicant.data.name.replace("Č", "C");

    doc.text(x, y, tmp);

    x += 60;

    tmp = data[i].mailingAddress.meta.address.replace("Č", "C");

    doc.text(x, y, tmp);

    x += 60;

    tmp = data[i].mailingAddress.data.name.replace("Č", "C");

    doc.text(x, y, tmp);

    x += 70;

    doc.text(x, y, data[i].acceptedWish.meta.points.toString());

    x += 50;

    var tmpY = y;
    var tmpY1 = y;

    if(tmpY > tmpY1){
      if(tmpY + 33 < 210){
        doc.line(6,tmpY+3,289,tmpY+3);
        y = tmpY+9;
      }
      else {
        doc.addPage();
        totalPages++;
        y = 10;
      }

    }
    else {
      if(tmpY1 + 33 < 210){
        doc.line(6,tmpY1+3,289,tmpY1+3);
        y = tmpY1+9;
      }
      else {
        doc.addPage();
        totalPages++;
        y = 10;
      }
    }

    counter++;

  }

  //footer (oštevilčenje strani)
  for(var i = 1; i <= totalPages; i++){
    doc.setPage(i).text(277, 207, "Stran "+ i +"/"+ totalPages);
  }

  doc.output('dataurlnewwindow');
}

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
          facultyData: '',
          regular: ''
        },
        referentPrograms: [],
        faculties: [],
        faculty_id: '',
        table_columns: [
          {label: '#', field:'couter'},
          {label: 'Prijava', field: 'id'},
          {label: 'Ime in priimek', field: 'applicant.data.name'},
          {label: 'Naslov', field: 'mailingAddress.meta.address'},
          {label: 'Mesto', field: 'mailingAddress.data.name'},
          {label: 'Število točk', callback: function(row){
            console.log(row.params);
          }}

        ],
        sprejeti_store: sprejeti_store
      }
    },
    methods: {
      savePdf1: function(){
        var postData = {
          accepted_program: this.params.programData.id,
          accepted_faculty: this.params.facultyData.id
        };

        this.$http.get('/api/applications/accepted', {params: {filters: postData}})
          .then(function(res){
            if(this.regular == '0'){
              prijavljeniPdf(res.data.data.eu.data);
            }
            else if(this.regular == '1'){
              prijavljeniPdf(res.data.data.other.data);
            }
            else {
              var tmp = res.data.data.eu.data.concat(res.data.data.other.data);
              prijavljeniPdf(tmp);
            }
          })

      },
      spremeniFakulteto: function(val){
        if(val == null){
          this.params = {
            facultyData: '',
            programData: this.params.programData,
            regular: this.params.regular
          };

          this.faculty_id = '';
        }
        else {
          this.params = {
            facultyData: val,
            programData: this.params.programData,
            regular: this.params.regular
          };

          this.faculty_id = val.id;
        }
        this.$root.test = this.params;

        this.$http.get('/api/programs', {params: {filters: {faculty_id: this.faculty_id}}})
          .then(function(res){
            this.referentPrograms = res.data.data;
          });


      },
      spremeniProgram: function(val){
        if(val == null){
          this.params = {
            programData: '',
            facultyData: this.params.facultyData,
            regular: this.params.regular
          };
        }
        else {
          this.params = {
            programData: val,
            facultyData: this.params.facultyData,
            regular: this.params.regular
          };
        }

        this.$root.test = this.params;
      },
      regular1: function(val){
        this.params = {
          programData: this.params.programData,
          facultyData: this.params.facultyData,
          regular: val
        };

        this.$root.test = this.params;
      }
    },
    created: function(){
      this.$root.test = {};
      var user = JSON.parse(window.localStorage.getItem('user'));
      this.role = user.role;

      if(user.role == 'referent'){
        this.faculty_id = user.faculty.data.id;
      }
      else if(this.$route.name == 'Sprejeti') {
        this.params.programData = this.$root.programData;
        this.$root.test = this.params;
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
