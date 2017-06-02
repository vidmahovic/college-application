<template>

  <div class="row">
      <div class="col-md-8 col-md-offset-2">
          <div class="panel panel-default">
              <div class="panel-heading">Uvoz podatkov</div>

              <div class="panel-body">
                <h3>Uvoz podatkov za splošno maturo</h3>
                <div>
                   
                  <div class="input-group">
                    <!--<input name="splosna" type="file" placeholder="Uvoz podatkov splosne mature" class="form-control" id="splosna" v-model="splosna" >-->
                    <input type="file" @change="onFileChange">
                    <span class="input-group-addon" id="basic-addon2" style="padding:0px;">
                    <div class="btn btn-success" v-on:click="submitSplosna">Uvoz</div>
                    </span>
                  </div>
                   <!--<file-upload title="Add upload files"></file-upload>-->
                   

                </div>

                <hr />
                <h3>Uvoz podatkoz za poklicno maturo</h3>
                <div>
                  fileschooser
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
        image: ''
      }
    },
    methods: {
      onFileChange(e) {
        var files = e.target.files || e.dataTransfer.files;
        if (!files.length)
          return;
        this.createFile(files[0]);
      },
    createFile(file) {
      var image = new Image();
      var reader = new FileReader();
      var vm = this;

      reader.onload = (e) => {
        vm.image = e.target.result;
      };
      reader.readAsDataURL(file);
    },
    removeImage: function (e) {
      this.image = '';
    },
  

      submitSplosna: function(status) {

        //todo post this.image?
        
      },
     
    },
    mounted() {
      console.log('files component mounted.');
      //this.$router.push('404');
      //console.log("should redirect")
    }
  }
</script>
