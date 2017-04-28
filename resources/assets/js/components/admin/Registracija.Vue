<template>
  <div class="row">
    <div class="col-md-12">
      <div class="panel panel-body">
        <h2 style="margin-bottom: 15px;">Registracija zaposlenega</h2>
        <form>
          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" placeholder="Email" class="form-control" id="email">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <label for="geslo">Geslo (najmanj 8 znakov, vsaj en numerični)</label>
                <input type="password" placeholder="Geslo" class="form-control" id="geslo">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <label for="geslo1">Ponovno geslo</label>
                <input type="password" placeholder="Geslo" class="form-control" id="geslo1">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <label for="ime">Ime</label>
                <input type="text" placeholder="Ime" class="form-control" id="ime">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <label for="priimek">Priimek</label>
                <input type="text" placeholder="Priimek" class="form-control" id="priimek">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <h4>Izberi način zaposlenega</h4>
            </div>
          </div>
          <div class="row">
            <div class="col-md-2">
              <input type="radio" id="two2" value="0" v-model="radioButton" v-on:click="type1('0')">
              <label for="two2">Služba za vpis</label>
            </div>
            <div class="col-md-2">
              <input type="radio" id="two3" value="1" v-model="radioButton" v-on:click="type1('1')">
              <label for="two3">Študentski referat</label>
            </div>
          </div>
          <div v-if="showFaculties">
            <div class="row">
              <div class="col-md-6">
                <h4>Izberite fakulteto za zaposlenega</h4>
              </div>
            </div>
            <div class="row">
              <div class="col-md-4">
                <v-select v-model="faculty"  label="name" :options="testData"></v-select>
              </div>
            </div>
          </div>
          <button type="submit" class="btn btn-primary">Shrani zaposlenega</button>
        </form>
      </div>
    </div>
  </div>

</template>

<script>
  export default {
    name: 'Registracija',
    data: function(router) {
        return {
          radioButton: '',
          faculty: '',
          testData: [
            'Fakulteta za računalništvo in informatiko',
            'Fakulteta za elektrotehniko',
            'Fakulteta za kemijo in kemijsko tehnologijo',
            'Filozofska fakulteta'
          ],
          showFaculties: false
        }
      },
      methods: {
        type1: function(param){
          if(param == '1'){
            this.showFaculties = true;
          }
          else {
            this.showFaculties = false;
          }
        }
      }
  }
</script>
