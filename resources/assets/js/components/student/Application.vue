<template>
  <div class="row">
      <div class="col-md-12">
          <div class="panel panel-default">
              

              <h3>OSEBNI PODATKI</h3>
              <div class="row">
                <div class="form-group col-md-6">
                  <label for="ime">Ime</label>
                  <input v-model="apl.ime" placeholder="Ime" class="form-control" id="ime">
                </div>
                <div class="form-group col-md-6">
                  <label for="primmek">Priimek</label>
                  <input v-model="apl.priimek" placeholder="Priimek" class="form-control" id="primmek">
                </div>
              </div>
              <div class="row">
                <div class="form-group col-md-6">
                  <label for="emso">EMŠO</label>
                  <input v-model.number="apl.emso" type="number" placeholder="EMŠO" class="form-control" id="emso">
                </div>
                <div class="form-group col-md-6">
                  <label for="spol">Spol</label>
                  <select v-model="apl.spol" class="form-control">
                    <option disabled value="">Spol</option>
                    <option value="M">Moški</option>
                    <option value="Z">Ženska</option>
                    
                  </select>

                </div>
              </div>


              <hr />
              <h3>NASLOV STALNEGA PREBIVALIŠČA</h3>
              <div class="form-group">
                <label for="ime">Ime</label>
                <input v-model="apl.ime" placeholder="edit me" class="form-control" id="ime_input">
              </div>


              <hr />
              <h3>PODATKI O DRŽAVLJANSTVU</h3>
              <div class="form-group">
                <label for="ime">Ime</label>
                <input v-model="apl.ime" placeholder="edit me" class="form-control" id="ime_input">
              </div>


              <hr />

              <div class="btn btn-default">Shrani</div>
              <div class="btn btn-success" v-on:click="submit(apl)">Potrdi</div>
          </div>
      </div>
  </div>
</template>

<script>
  export default {
    name: 'Application',
    data: function(router) {
        return {
          section: 'Student',
          apl: {
            ime: null,
            priimek: "Novak",
            emso: null,
            spol: null
          }
          
        }    
    },
    methods: {
      submit: function(apl) {
        console.log(JSON.stringify(this.apl))
      }
    },
    mounted() {
      console.log('application  mounted.');
      //this.$router.push('404');
      //console.log("should redirect")
    }
  }
</script>
