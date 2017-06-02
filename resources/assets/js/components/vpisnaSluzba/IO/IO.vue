<template>

  <div class="row">
      <div class="col-md-8 col-md-offset-2">
          <div class="panel panel-default">
              <div class="panel-heading">Uvoz podatkov</div>

              <div class="panel-body">
                <h3>Uvoz podatkov za splošno maturo</h3>
                <div>
                   
                  <div class="input-group">
                    <input type="file" @change="splosnaChange">
                    <span class="input-group-addon" id="basic-addon2" style="padding:0px;">
                    <div class="btn btn-success" v-on:click="submitSplosna">Uvoz</div>
                    </span>
                  </div>
                </div>

                <hr />
                <h3>Uvoz podatkoz za poklicno maturo</h3>
                <div>
                  <div class="input-group">
                    <input type="file" @change="poklicnaChange">
                    <span class="input-group-addon" id="basic-addon2" style="padding:0px;">
                    <div class="btn btn-success" v-on:click="submitPoklicna">Uvoz</div>
                    </span>
                  </div>
                </div>
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
          poklica: null
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
      poklicnaChange(e) {
        var files = e.target.files || e.dataTransfer.files;
        if (!files.length)
          return;
        this.createFile(files[0], 'poklicna');
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
      },
      submitPoklicna: function(status) {
         console.log(this.files.poklicna);

      }
     
    },
    mounted() {
      console.log('files component mounted.');
      //this.$router.push('404');
      //console.log("should redirect")
    }
  }
</script>
