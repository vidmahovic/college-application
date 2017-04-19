<template>
  <div class="enroll-container">
    <div class="row">
      <div class="col-md-2">
        <div class="panel panel-body">
          <h2>Filtri:</h2>
          <h4>Iskanje programa:</h4>
          <input class="form-control" type="text" v-model="params.name" v-on:blur="name()" />
          <br>
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
          <br>
          <button v-on:click="poenostavi" style="margin-top: 10px;" class="btn btn-link btn-xs">Poenostavi iskanje</button>
        </div>
      </div>
        <div class="col-md-10">
            <div class="panel panel-default">
                <div class="panel-body">
                  <button class="btn btn-primary" v-on:click="savePdf">Shrani PDF</button>
                  <h2 style="text-align: center;">Tabela študijskih programov</h2>
                  <datatable id="datatable" :columns="table_columns" :data="params" :data-store="ajax_store" filterable paginate></datatable>
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
	var header = ["Fakulteta", "Program", "Vrsta programa", "Nacin študija", "Omejitev", "Razpisanih mest", "Število prijavljenih", "Število sprejetih"];
	//210 je visina, 297mm sirina
	doc.setLineWidth(0.1);
	doc.setFont("sans-serif");

	doc.setTextColor(99, 107, 111);
	doc.setFontSize(20);
	doc.text(148, 20, "Tabela študijskih programov", null, null, "center");

	//table header
	doc.setFontSize(12);

	var x = 15;
	for(var i in header){
    if(i == 2 || i == 5 || i == 6 || i == 7){
      var res = header[i].split(" ");
      doc.text(x, 30, res[0]);
      doc.text(x, 35, res[1]);
    }
    else {
      doc.text(x, 35, header[i]);
    }


    if(i == 0 || i == 1){
      x+=50;
    }
    else {
      x+=27;
    }
	}

	doc.line(15,37,282,37);

  // začetek vsebine

  var y = 42
  for(var i in data.data){
    x = 15;
    console.log(i);
    console.log();
    var tmp = data.data[i].faculty.data.name.split(" ");
    var tmpY = y;

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
    x+=50;

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
    x+=50;

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
    x+=27;

    if(data.data[i].is_regular){
      temp = "Redni študij";
    }
    else {
      temp = "Izredni študij";
    }
    doc.text(x, y, temp);
    x+=27;

    if(data.data[i].min_points == 0){
      temp =  "Ni omejitve";
    }
    else{
      temp = row.min_points;
    }
    doc.text(x, y, temp);
    x+=27;

    doc.text(x, y, data.data[i].max_accepted.toString());
    x+=27;

    //doc.text(x, 40, data.data[i].name);
    x+=27;

    doc.text(x, y, data.data[i].count_accepted.toString());
    x+=27;


    if(tmpY > tmpY1){
      if(tmpY + 33 < 210){
        doc.line(15,tmpY,282,tmpY);
        y = tmpY+6;
      }
      else {
        doc.addPage();
        y = 10;
      }

    }
    else {
      if(tmpY1 + 33 < 210){
        doc.line(15,tmpY1,282,tmpY1);
        y = tmpY1+6;
      }
      else {
        doc.addPage();
        y = 10;
      }
    }


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
          name: ''
        },
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
          {label: 'Razpisanih mest', field: 'max_accepted', align: 'center'},
          {label: 'Število prijavljenih'},
          {label: 'Število sprejetih', field: 'count_accepted'}
        ],
        ajax_store: ajax_store
      }
    },
    methods: {
      regular1: function(param){
        this.params = {
          regular: param,
          type: this.params.type,
          name: this.params.name.toUpperCase()
        };
      },
      type1: function(param){
        this.params = {
          regular: this.params.regular,
          type: param,
          name: this.params.name.toUpperCase()
        };
      },

      name: function(){
        this.params = {
          regular: this.params.regular,
          type: this.params.type,
          name: this.params.name.toUpperCase()
        };
      },

      savePdf: function(){
        this.$http.get("/api/programs", {params: {filters: this.params}})
          .then(function(res){
              programPdf(res.data);
          }, function(err){
              console.log(err);
          });
      },

      poenostavi: function(){
        this.params = {
          type: '',
          regular: '',
          name: ''
        };
      }
    }
  }

</script>
