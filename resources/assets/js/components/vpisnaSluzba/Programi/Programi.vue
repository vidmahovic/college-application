<template>
  <div class="enroll-container programi">
    <div class="row">
      <div class="col-md-offset-2 col-md-8">
        <div class="panel panel-body">
          <h2 class="programs-header">Kriteriji za študijske programe</h2>
          <h4>Iskanje fakultete:</h4>
          <v-select v-model="params.selectedFaculty" label="name" :on-change="changeFaculty" :options="faculties"></v-select>
          <h4>Iskanje programa:</h4>
          <v-select v-model="params.selectedProgram" label="name" :on-change="changeProgram" :options="programs"></v-select>
          <div class="row marginB10">
            <div class="col-md-5">
              <h4>Način študija</h4>
              <input type="radio" id="one" value="0" v-model="params.regular" v-on:click="regular1('0')">
              <label style="margin-right: 10px;" for="one">Izredni programi</label>

              <input type="radio" id="two" value="1" v-model="params.regular" v-on:click="regular1('1')">
              <label for="two">Redni programi</label>
            </div>
          </div>
          <div class="row">
            <div class="col-md-7">
              <h4>Vrsta programa</h4>
              <input type="radio" id="one1" value="0" v-model="params.type" v-on:click="type1('0')">
              <label style="margin-right: 10px;" for="one1">Univerzitetni</label>

              <input type="radio" id="two2" value="1" v-model="params.type" v-on:click="type1('1')">
              <label style="margin-right: 10px;" for="two2">Visokošolski</label>

              <input type="radio" id="three3" value="2" v-model="params.type" v-on:click="type1('2')">
              <label for="three3">Magistrski</label>
            </div>
          </div>

          <br>
          <button v-on:click="poenostavi" style="margin-top: 10px;" class="btn btn-link btn-xs">Poenostavi iskanje</button>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
          <div class="panel panel-default">
              <div class="panel-body">
                <button class="btn btn-primary" v-on:click="savePdf"><span class="glyphicon glyphicon-download-alt" aria-hidden="true"></span> PDF</button>
                <button class="btn btn-primary" v-on:click="newProgram"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Nov program</button>
                <h2 style="text-align: center;" class="programs-header">Tabela študijskih programov</h2>
                <datatable id="datatable" :columns="table_columns" :data="params" :data-store="ajax_store" class="programs-datatable" filterable paginate></datatable>
              </div>
          </div>
      </div>
    </div>
  </div>
</template>

<script>

import ajax_store from './ajax_store.js';


function programPdf(data){
	var doc = new jsPDF('landscape');
	var header = ["Fakulteta", "Program", "Vrsta programa", "Nacin študija", "Omejitev", "Razpisanih mest (EU)", "Razpisanih mest (tujci)", "Število prijavljenih (EU)", "Število prijavljenih (tujci)", "Število sprejetih (EU)", "Število sprejetih (tujci)"];
	//210 je visina, 297mm sirina
	doc.setLineWidth(0.1);
	doc.setFont("sans-serif");

	doc.setTextColor(99, 107, 111);
	doc.setFontSize(20);
	doc.text(148, 20, "Tabela študijskih programov", null, null, "center");

	//table header
	doc.setFontSize(10);
  doc.text(2, 40, "#");
	var x = 8;
	for(var i in header){
    var res = header[i].split(" ");

    if(i == 2) {
      doc.text(x, 35, res[0]);
      doc.text(x, 40, res[1]);
    }
    else if(i == 5 || i == 6) {
      doc.text(x, 35, res[0]);
      doc.text(x, 40, res[1]+" "+res[2]);
    }
    else if(i == 7 || i == 8 || i == 9 || i == 10){
      doc.text(x, 30, res[0]);
      doc.text(x, 35, res[1]);
      doc.text(x, 40, res[2]);
    }
    else {
      doc.text(x, 40, header[i]);
    }


    if(i == 0 || i == 1){
      x+=40;
    }
    else if(i == 2 || i == 3 || i == 4){
      x+=30;
    }
    else {
      x+=20;
    }
	}

	doc.line(8,42,289,42);

  // začetek vsebine
  var y = 47
  var counter = 1;
  var totalPages = 1;
  for(var i in data.data){
    x = 8;
    var tmp = data.data[i].faculty.data.name.split(" ");
    var tmpY = y;

    doc.setFontSize(9);
    doc.text(2, y, counter.toString());
    // ime fakultete
    for(var j = 0; j < tmp.length; j++){
      if(j+1 < tmp.length && tmp[j].length > 0 && tmp[j+1].length > 0 && (tmp[j+1].length < 3 || (tmp[j].length + tmp[j+1].length + 1) < 14)){
        tmp[j] = tmp[j].replace("Č", "C");
        tmp[j+1] = tmp[j+1].replace("Č", "C");

        doc.text(x, tmpY, tmp[j]+" "+tmp[j+1]);
        j++;
      }
      else {
        tmp[j] = tmp[j].replace("Č", "C");
        doc.text(x, tmpY, tmp[j]);
      }
      tmpY += 4;
    }
    x+=40;

    // ime programa
    tmp = data.data[i].name.split(" ");
    var tmpY1 = y;

    for(var j = 0; j < tmp.length; j++){
      if(j+1 < tmp.length && tmp[j].length > 0 && tmp[j+1].length > 0 && (tmp[j+1].length < 3 || (tmp[j].length + tmp[j+1].length + 1) < 14)){
        tmp[j] = tmp[j].replace("Č", "C");
        tmp[j+1] = tmp[j+1].replace("Č", "C");

        doc.text(x, tmpY1, tmp[j]+" "+tmp[j+1]);
        j++;
      }
      else {
        tmp[j] = tmp[j].replace("Č", "C");
        doc.text(x, tmpY1, tmp[j]);
      }
      tmpY1 += 4;
    }
    x+=40;

    var temp = "";
    if(data.data[i].type == 0){
      doc.text(x, y, "Univerzitetni");
      doc.text(x, y+4, "program");
    }
    else if(data.data[i].type == 1){
      temp =  "Visokošolski program";
      doc.text(x, y, "Visokošolski");
      doc.text(x, y+4, "program");
    }
    else if(data.data[i].type == 2){
      doc.text(x, y, "Enovitni");
      doc.text(x, y+4, "magisterski");
      doc.text(x, y+8, "program");
    }
    x+=30;

    if(data.data[i].is_regular){
      temp = "Redni študij";
    }
    else {
      temp = "Izredni študij";
    }
    doc.text(x, y, temp);
    x+=30;

    if(data.data[i].min_points == 0){
      temp =  "Ni omejitve";
    }
    else{
      temp = row.min_points;
    }
    doc.text(x, y, temp);
    x+=30;

    doc.text(x, y, data.data[i].max_accepted.toString());
    x+=20;

    doc.text(x, y, data.data[i].max_accepted_foreiqn.toString());
    x+=20;

    doc.text(x, y, data.data[i].count_enrolled.toString());
    x+=20;

    doc.text(x, y, data.data[i].count_enrolled_foreign.toString());
    x+=20;

    doc.text(x, y, data.data[i].count_accepted.toString());
    x+=20;

    doc.text(x, y, data.data[i].count_accepted_foreign.toString());
    x+=20;


    if(tmpY > tmpY1){
      if(tmpY + 33 < 210){
        doc.line(8,tmpY,289,tmpY);
        y = tmpY+6;
      }
      else {
        doc.addPage();
        totalPages++;
        y = 10;
      }

    }
    else {
      if(tmpY1 + 33 < 210){
        doc.line(8,tmpY1,289,tmpY1);
        y = tmpY1+6;
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

	doc.output("datauri");
}

  export default {
    name: "VpisnaSluzbaProgrami",
    data: function(router){
      return {
        params: {
          regular: '',
          type: '',
          selectedFaculty: '',
          selectedProgram: ''
        },
        faculties: [],
        programs: [],
        table_columns: [
          {label: 'Fakulteta', field: 'faculty.data.name'},
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
          {label: 'Razpisanih mest (EU)', field: 'max_accepted', align: 'center'},
          {label: 'Razpisanih mest (tujci)', field: 'max_accepted_foreiqn', align: 'center'},
          {label: 'Število prijavljenih (EU)', field: 'count_enrolled', align: 'center'},
          {label: 'Število prijavljenih (tujci)', field: 'count_enrolled_foreign', align: 'center'},
          {label: 'Število sprejetih (EU)', field: 'count_accepted', align: 'center'},
          {label: 'Število sprejetih (tujci)', field: 'count_accepted_foreign', align: 'center'},
          {label: '', component: 'edit-program'}
        ],
        ajax_store: ajax_store
      }
    },
    methods: {
      regular1: function(param){
        this.params = {
          regular: param,
          type: this.params.type,
          selectedFaculty: this.params.selectedFaculty,
          selectedProgram: this.params.selectedProgram
        };
      },
      type1: function(param){
        this.params = {
          regular: this.params.regular,
          type: param,
          selectedFaculty: this.params.selectedFaculty,
          selectedProgram: this.params.selectedProgram
        };
      },

      changeFaculty: function(val){
        this.params = {
          regular: this.params.regular,
          type: this.params.type,
          selectedFaculty: val,
          selectedProgram: this.params.selectedProgram
        };
      },

      changeProgram: function(val){
        this.params = {
          regular: this.params.regular,
          type: this.params.type,
          selectedFaculty: this.params.selectedFaculty,
          selectedProgram: val
        };
      },

      savePdf: function(){
        this.$http.get("/api/programs", {params: {filters: {type: this.params.type, regular: this.params.regular, faculty_id: this.params.selectedFaculty}}})
          .then(function(res){
              programPdf(res.data);
          }, function(err){
              console.log(err);
          });
      },
      newProgram: function() {
        this.$router.push("/enrollment_service/programi/ustvari");
      },
      poenostavi: function(){
        this.params = {
          type: '',
          regular: '',
          selectedFaculty: '',
          selectedProgram: ''
        };
      }
    },
    created: function() {
      this.$http.get('/api/faculties')
        .then(function(res){
          this.faculties = res.data.data;
        });

      this.$http.get('/api/programs')
        .then(function(res){
          this.programs = res.data.data;
        })
    }
  }

</script>
