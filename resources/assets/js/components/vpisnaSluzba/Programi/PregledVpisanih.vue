<template>
<div>
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
        <div v-if="role != 'referent' || $route.name == 'PregledVpisanih1'" class="col-md-12">
          <h6>Filtriranje po fakulteti:</h6>
          <v-select v-model="params.facultyData" label="name" :options="faculties" :on-change="spremeniFakulteto"></v-select>
        </div>
        <div v-if="role == 'referent' || $route.name == 'PregledVpisanih1'" class="col-md-12">
          <h6>Iskanje programa:</h6>
          <v-select v-model="params.programData" label="name" :options="referentPrograms" :on-change="spremeniProgram"></v-select>
        </div>
        <div class="col-md-12 marginT20">
          <button v-on:click="savePdf1" class="btn btn-primary">Prenesi PDF</button>
        </div>
        <div class="col-md-12 marginT20">
          <button v-if="typeof ability_test == 'object'" data-toggle="modal" data-target="#myModal1" class="btn btn-primary btn-xs">Vpiši rezultate preizkusnega testa</button>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <datatable id="datatable" :columns="table_columns" :data="params" :data-store="prijavljeni_store" class="programs-datatable" paginate></datatable>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal -->
  <div v-if="typeof ability_test == 'object'" id="myModal1" class="modal fade" role="dialog" ref="vuemodal">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h3 class="modal-title">Vpis točk preizkusa sposobnosti</h3>
          <h5>Meje točk: {{ability_test.min_points}} - {{ability_test.max_points}}</h5>
        </div>
        <div class="modal-body">
          <table v-if="applied.length != 0" class="table">
            <thead>
              <tr>
                <th>#</th>
                <th>Emšo</th>
                <!--<th>Ime in priimek</th>-->
                <th>Število točk</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(item, index) in applied">
                <td>{{ item.application_id }}</td>
                <td>{{ item.application.emso }}</td>
                <!--<td>Denis Grabljevec</td>-->
                <td><input class="form-control" type="text" v-model="applied[index].points" /></td>
              </tr>
            </tbody>
          </table>
          <div v-show="showMsg" class="alert alert-danger" role="alert"> {{ msgTocke }}</div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Prekliči</button>
          <button type="button" class="btn btn-primary" @click="posljiTocke">Shrani podatke</button>
        </div>
      </div>

    </div>
  </div>

</div>
</template>

<script>
import prijavljeni_store from './prijavljeni_store.js';

function prijavljeniPdf(data) {
  var doc = new jsPDF('landscape');
  var header = ["#", "Ime in priimek", "Naslov", "Mesto", "Državljanstvo", "Nacin zakljucka srednje sole"];

  //210 je visina, 297mm sirina
  doc.setLineWidth(0.1);
  doc.setFont("sans-serif");

  doc.setTextColor(99, 107, 111);
  doc.setFontSize(20);
  doc.text(148, 20, "Tabela prijavljenih študentov", null, null, "center");

  //table header
  doc.setFontSize(10);
  var x = 5;

  for(var i in header){

    doc.text(x, 40, header[i]);

    if(i == 0){
      x += 6;
    }
    else if(i == 1){
      x += 35;
    }
    else if(i == 2){
      x+=45;
    }
    else if(i == 3){
      x += 50;
    }
    else if(i == 5){
      x += 50;
    }
    else if(i == 4){
      x += 93;
    }
  }

  // začetek vsebine
  var y = 47
  var counter = 1;
  var totalPages = 1;
  doc.setFontSize(9);
  for(var i in data){
    x = 5;
    doc.text(x, y, data[i].id.toString());

    x += 6;

    var tmp = data[i].applicant.data.name.replace("Č", "C");

    doc.text(x, y, tmp);

    x += 35;

    tmp = data[i].mailingAddress.meta.address.replace("Č", "C");

    doc.text(x, y, tmp);

    x += 45;

    tmp = data[i].mailingAddress.data.name.replace("Č", "C");

    doc.text(x, y, tmp);

    x += 50;

    tmp = data[i].citizen.data.name.replace("Č", "C");

    doc.text(x, y, tmp);

    x += 93;

    tmp = data[i].profession.data.name.replace("Č", "C");

    doc.text(x, y, data[i].profession.data.name);

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

  doc.output('dataurlnewwindow');
}

  export default {
    name: 'PregledVpisanih',
    data: function(router){
      return {
        programData: '',
        referentPrograms: [],
        result: [],
        role: '',
        faculty_id: '',
        faculties: [],
        showMsg: false,
        msgTocke: '',
        ability_test: false,
        applied: [],
        params: {
          regular: '',
          programData: '',
          facultyData: ''
        },
        table_columns: [
          {label: '#', field: 'id'},
          {label: 'Ime in priimek', field: 'applicant.data.name'},
          {label: 'Naslov', field: 'mailingAddress.meta.address'},
          {label: 'Mesto', field: 'mailingAddress.data.name'},
          {label: 'Državljanstvo', field: 'citizen.data.name'},
          {label: 'Način zaključka srednje šole', field: 'graduation.data.name'},
          {label: '', component: 'points_calculation'}

        ],
        prijavljeni_store: prijavljeni_store
      }
    },
    methods: {
      savePdf1: function(){
        var postData = {
          nationality_id: this.params.regular,
          program_id: this.params.programData.id,
          faculty_id: this.params.facultyData.id
        };

        this.$http.get('/api/applications', {params: {filters: postData}})
          .then(function(res){
            prijavljeniPdf(res.body.data);
          })

      },
      regular1: function(param){
        this.params = {
          regular: param,
          programData: this.params.programData,
          facultyData: this.params.facultyData
        };
        if(this.params.programData != undefined){
          this.$http.get('/api/program/'+this.params.programData.id+'/ability')
            .then(function(res){
              this.ability_test = res.data.ability_test;
              this.applied = res.data.applied;
              for(var i in this.applied){
                if(this.applied[i].points == -1){
                  this.applied[i].points = null;
                }
              }
            })
        }
      },
      spremeniFakulteto: function(val){
        if(val == null){
          this.params = {
            regular: this.params.regular,
            facultyData: '',
            programData: this.params.programData
          };

          this.faculty_id = '';
        }
        else {
          this.params = {
            regular: this.params.regular,
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
            regular: this.params.regular,
            programData: '',
            facultyData: this.params.facultyData
          };
        }
        else {
          this.params = {
            regular: this.params.regular,
            programData: val,
            facultyData: this.params.facultyData
          };
        }

        if(this.params.programData != undefined){
          this.$http.get('/api/program/'+this.params.programData.id+'/ability')
            .then(function(res){
              this.ability_test = res.data.ability_test;
              this.applied = res.data.applied;
              for(var i in this.applied){
                if(this.applied[i].points == -1){
                  this.applied[i].points = null;
                }
              }
            })
        }

      },
      posljiTocke: function(){
        var results1 = [];

        for(var i in this.applied){
          var tmp = {};

          tmp.aid = this.applied[i].application_id;
          if(this.applied[i].points == null || this.applied[i].points == ""){
            tmp.points = -1;
          }
          else {
            tmp.points = this.applied[i].points;
          }
          results1.push(tmp);
        }

        this.$http.post('/api/ability/'+this.params.programData.id, {results: results1})
          .then(function(res){
            this.msgTocke = "";
            this.showMsg = false;
          }, function(err){
            this.msgTocke = "Ni znotraj meja!";
            this.showMsg = true;
          })

      }
    },
    created: function() {
      var user = JSON.parse(window.localStorage.getItem('user'));
      this.role = user.role;

      if(user.role == 'referent'){
        this.faculty_id = user.faculty.data.id;
      }
      else if(this.$route.name == 'PregledVpisanih') {
        this.params.programData = this.$root.programData;
        this.faculty_id = this.params.programData.faculty_id;
      }

      if(this.$route.name != 'PregledVpisanih1'){
        this.$http.get('/api/program/'+this.params.programData.id+'/ability')
          .then(function(res){
            this.ability_test = res.data.ability_test;
            this.applied = res.data.applied;
            for(var i in this.applied){
              if(this.applied[i].points == -1){
                this.applied[i].points = null;
              }
            }
          })
      }
      else{
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
