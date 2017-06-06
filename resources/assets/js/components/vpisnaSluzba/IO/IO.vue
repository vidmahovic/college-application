<template>

  <div class="row">
      <div class="col-md-8 col-md-offset-2">
          <div class="panel panel-default">
              <div class="panel-heading">Uvoz podatkov</div>

              <div class="panel-body">
                <h3>Uvoz podatkov za splošno maturo</h3>
                <div>
                   
                  <div >

                  <!--<form method="post" action="/api/upload/general-matura" enctype="multipart/form-data"> -->
                    <label> Maturanti</label>
                      <input type="file" name="general_matura" @change="splosnaChange">
                      
                    <label>Točke</label>
                      <input type="file" name="general_matura_subjects" @change="splosnaChange_tocke">
                  
                    <!--<button type="submit" > Shrani</button>-->
                    <div class="btn btn-success" v-on:click="submitSplosna">Uvozi</div>
                  <!--</form>-->
                  </div>
                  <p v-show="msgs.splosna.display" v-bind:class="{'bg-danger': msgs.splosna.error, 'bg-success': !msgs.splosna.error}" style="padding: 10px; width: 30%; margin-top: 15px;">
                  {{ msgs.splosna.msg }}
                </p>
                </div>

                <hr />
                <h3>Uvoz podatkoz za poklicno maturo</h3>
                <div>
                  <div class="input-group">
                    <input type="file" @change="poklicnaChange">
                    <span class="input-group-addon" id="basic-addon2" style="padding:0px;">
                    <div class="btn btn-success" v-on:click="submitPoklicna">Uvozi</div>
                    </span>
                  </div>
                </div>
                <p v-show="msgs.poklicna.display" v-bind:class="{'bg-danger': msgs.poklicna.error, 'bg-success': !msgs.poklicna.error}" style="padding: 10px; width: 30%; margin-top: 15px;">
                  {{ msgs.poklicna.msg }}
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
          poklica: null,
          poklicna_tocke: null

        },
        msgs: {
          splosna: {
            display: false,
            error: false,
            msg: ""
          },
          poklicna: {
            display: false,
            error:false,
            msg: ""
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
        console.log(this.files.splosna);

        //todo kam treba postat
        
        
        this.$http.post("api/upload/general-matura", {'general_matura': this.files.splosna, "general_matura_subjects": this.files.splosna_tocke})
        .then(function(data) {
        this.msgs.splosna.error = false;
            this.msgs.splosna.msg = "Podatki uspešno uvoženi";          

          console.log(data);
        }, function(err) {
          this.msgs.splosna.error = true;
            this.msgs.splosna.msg = err.body.message;          
                
          console.log(err);
        })
      },
      submitPoklicna: function(status) {
        console.log(this.files.poklicna);
        //todo kam treba postat
        // this.$http.post("api/", this.files.splosna)
        // .then(function(data) {
        // this.msgs.poklicna.error = false;
            // this.msgs.poklicna.msg = "Podatki uspešno uvoženi";          
        
        //   console.log(data),
        // }, function(err) {
            // this.msgs.poklicna.error = true;
            // this.msgs.poklicna.msg = err.body.message;          
        //   console.log(err);
        // })
      }
     
    },
    mounted() {
      console.log('files component mounted.');
      //this.$router.push('404');
      //console.log("should redirect")
    }
  }
</script>
