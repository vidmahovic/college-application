<template>

  <div class="row">
      <div class="col-md-8 col-md-offset-2">
          <div class="panel panel-default">
              <div class="panel-heading">Uvoz podatkov</div>

              <div class="panel-body">
                
                <!-- splosna matura -->
                <h3>Uvoz podatkov za splošno maturo</h3>
                <div>
                  <div>
                    <label> Maturanti</label>
                    <input type="file" name="general_matura" @change="splosnaChange">
                      
                    <label>Točke</label>
                    <input type="file" name="general_matura_subjects" @change="splosnaChange_tocke">
                  
                    <div v-show="files.splosna != null && files.splosna_tocke != null" class="btn btn-success" v-on:click="submitSplosna">Uvozi</div>
                  </div>
                  <p v-if="msgs.splosna.display" v-bind:class="{'bg-danger': msgs.splosna.error, 'bg-success': !msgs.splosna.error}" style="padding: 10px; width: 30%; margin-top: 15px;">
                  {{ msgs.splosna.msg }}
                  <div v-if="msgs.splosna.error">
                    
                      <ul>
                      <li v-for="e in msgs.splosna.errList">{{e.emso}} {{e.name}}</li>
                      </ul>
                    
                  </div>
                  <div v-if="splosnaInfo.candidates.all != null">
                  <label>Kandidati</label>
                  <table class="table">
                    <thead>
                      <tr>
                        <th>Vsi</th>
                        <th>Novi</th>
                        <th>Posodobljeni</th>
                        
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>{{splosnaInfo.candidates.all}}</td>
                        <td>{{splosnaInfo.candidates.new}}</td>
                        <td>{{splosnaInfo.candidates.updated}}</td>
                        
                      </tr>
                       
                    </tbody>
                    </table>
                    </div>
                </p>
                </div>

                <hr />
                <!-- poklicna matura -->
                <h3>Uvoz podatkoz za poklicno maturo</h3>
                <div>
                  <div>
                    <label>Maturanti</label>
                    <input type="file" @change="poklicnaChange">

                    <label>Točke</label>
                    <input type="file" @change="poklicnaChange_tocke">                    
                    <div v-show="files.poklicna != null && files.poklicna_tocke != null"  class="btn btn-success" v-on:click="submitPoklicna">Uvozi</div>
                    </span>
                  </div>
                </div>
                <p v-if="msgs.poklicna.display" v-bind:class="{'bg-danger': msgs.poklicna.error, 'bg-success': !msgs.poklicna.error}" style="padding: 10px; width: 30%; margin-top: 15px;">
                  {{ msgs.poklicna.msg }}
                  <div v-if="msgs.poklicna.error">
                    <div v-for="e in msgs.poklicna.errList">
                      {{e}}
                    </div>
                  </div>
                  <div v-if="poklicnaInfo.candidates.all != null">
                  <label>Kandidati</label>
                  <table class="table">
                    <thead>
                      <tr>
                        <th>Vsi</th>
                        <th>Novi</th>
                        <th>Posodobljeni</th>
                        
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>{{poklicnaInfo.candidates.all}}</td>
                        <td>{{poklicnaInfo.candidates.new}}</td>
                        <td>{{poklicnaInfo.candidates.updated}}</td>
                        
                      </tr>
                       
                    </tbody>
                    </table>
                    </div>
                </p>
      
              </div>

          </div>
      </div>
  </div>
</template>

<script>
  export default {
    name: 'vpisnaSluzbaIO',
    data: function(router) {
      return {
        files: {
          splosna: null,
          splosna_tocke: null,
          poklicna: null,
          poklicna_tocke: null

        },
        msgs: {
          splosna: {
            display: false,
            error: false,
            msg: "",
            errList : []
          },
          poklicna: {
            display: false,
            error:false,
            msg: "",
            errList : []
          }
        },
        splosnaInfo: {
          candidates: {
            all: null,
            new: null,
            updated: null
          }
        },
        poklicnaInfo: {
          candidates: {
            all: null,
            new: null,
            updated: null
          }
        }
        
      }
    },
    methods: {
      splosnaChange(e) {
        var files = e.target.files || e.dataTransfer.files;
        if (!files.length)
          return;
        this.createFile(files[0], 'splosna');
      },
      splosnaChange_tocke(e) {
        var files = e.target.files || e.dataTransfer.files;
        if (!files.length)
          return;
        this.createFile(files[0], 'splosna_tocke');
      },
      poklicnaChange(e) {
        var files = e.target.files || e.dataTransfer.files;
        if (!files.length)
          return;
        this.createFile(files[0], 'poklicna');
      },
      poklicnaChange_tocke(e) {
        var files = e.target.files || e.dataTransfer.files;
        if (!files.length)
          return;
        this.createFile(files[0], 'poklicna_tocke');
      },
      createFile(file, type) {
        var image = new Image();
        var reader = new FileReader();
        var vm = this;

        reader.onload = (e) => {
          vm.files[type] = e.target.result;
        };
        reader.readAsDataURL(file);
      },
      submitSplosna: function(status) {
        
        let splosna = this.files.splosna.split(",")[1];
        let splosna_tocke = this.files.splosna_tocke.split(",")[1]
        this.$http.post("api/upload/general-matura", {'general_matura': splosna, "general_matura_subjects": splosna_tocke})
        .then(function(response) {
              

            

          this.splosnaInfo = response.body.data;
          if(!this.isValidationOk(response.body.data)) {
            this.msgs.splosna.error = true;
            this.msgs.splosna.msg = "Napaka pri validaciji:"
            this.msgs.splosna.errList = response.body.data.errors.data;
          }else{
            this.msgs.splosna.error = false;  
            this.msgs.splosna.msg = "Podatki uspešno uvoženi";
            this.msgs.splosna.errList = [];   
          }
          this.msgs.splosna.display = true;
          
        },function(err) {
            
          this.msgs.splosna.display = true;
          this.msgs.splosna.error = true;
          this.msgs.splosna.msg = "Napaka pri uvozu datotek";
        });
      },
      submitPoklicna: function(status) {
        
        let poklicna = this.files.poklicna.split(",")[1];
        let poklicna_tocke = this.files.poklicna_tocke.split(",")[1];

        this.$http.post("api/upload/vocational-matura", {'vocational_matura': poklicna, 'vocational_matura_subjects': poklicna_tocke})
        .then(function(response) {
        

          this.poklicnaInfo = response.body.data;
          if(!this.isValidationOk(response.body.data)) {
            this.msgs.poklicna.error = true;
            this.msgs.poklicna.msg = "Napaka pri validaciji:"
            this.msgs.poklicna.errList = response.body.data.errors.data;
          }else{
            this.msgs.poklicna.error = false;  
            this.msgs.poklicna.msg = "Podatki uspešno uvoženi";
            this.msgs.poklicna.errList = [];   
          }
          this.msgs.poklicna.display = true;

        }, function(err) {
          this.msgs.poklicna.error = true;
          this.msgs.poklicna.msg = err.body.message;          
          this.msgs.poklicna.display = true;          
        });
      },
      isValidationOk: function(data) {

        if("errors" in data){
          if(data.errors.data.length > 0) return false;
        }
        return true;
      }
     
    },
    mounted() {
      console.log('files component mounted.');
      //this.$router.push('404');
      //console.log("should redirect")
    }
  }
</script>
