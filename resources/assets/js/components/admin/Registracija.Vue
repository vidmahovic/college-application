<template>
  <div class="row">
    <div class="col-md-12">
      <div class="panel panel-body">
        <h2 style="margin-bottom: 15px;">Registracija zaposlenega</h2>
        <div class="row">
          <div class="col-md-4">
            <div class="form-group" v-bind:class="{'has-error': validation.email}">
              <label for="email">Email</label>
              <input type="email" v-model="params.email" name="email" placeholder="Email" class="form-control" id="email" v-on:blur="checkEmail()">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-4">
            <div class="form-group" v-bind:class="{'has-error': validation.pass}">
              <label for="geslo">Geslo (najmanj 8 znakov, vsaj en numerični)</label>
              <input type="password" v-model="params.password" placeholder="Geslo" class="form-control" id="geslo">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-4">
            <div class="form-group"  v-bind:class="{'has-error': validation.rePass}">
              <label for="geslo1">Ponovno geslo</label>
              <input type="password" v-model="rePassword" placeholder="Geslo" class="form-control" id="geslo1">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-4">
            <div class="form-group" v-bind:class="{'has-error': validation.name}">
              <label for="ime">Ime</label>
              <input type="text" v-model="params.name" placeholder="Ime" class="form-control" id="ime">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-4">
            <div class="form-group" v-bind:class="{'has-error': validation.surname}">
              <label for="priimek">Priimek</label>
              <input type="text" v-model="params.surname" placeholder="Priimek" class="form-control" id="priimek">
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
              <v-select v-model="params.faculty"  label="name" :options="testData"></v-select>
            </div>
          </div>
        </div>
        <button @click="submitRegistration" class="btn btn-primary button-registrationAdmin">Shrani zaposlenega</button>
        <div class="row">
          <div class="col-md-4">
            <p v-show="errMsg.length > 0" class="bg-danger" style="padding-left:10px; padding-right: 10px;padding-top: 10px; padding-bottom: 10px; margin-top: 15px;"> {{ errMsg }} </p>
          </div>
        </div>
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
          rePassword: '',
          errMsg: '',
          params: {
            password: '',
            email: '',
            name: '',
            surname: '',
            faculty: ''
          },
          validation: {
            name: false,
            surname: false,
            email: false,
            rePass: false,
            rePass: false
          },
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
        },
        checkEmail: function() {
          var patt = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
          if(this.params.email.length == 0 || !patt.test(this.params.email)){
            this.validation.email = true;
          }
          else {
            this.validation.email = false;
          }
        },
        submitRegistration: function(){
          var patt1 = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
          var patt = /[0-9]/;
          this.validation.name = (this.params.name.length == 0);
          this.validation.surname = (this.params.surname.length == 0);
          this.validation.email = (this.params.email.length == 0) || !patt1.test(this.params.email);
          this.validation.pass = (this.params.password.length < 7 || !patt.test(this.params.password));
          this.validation.rePass = (this.rePassword != this.params.password);

          if(this.validation.pass){
            this.errMsg = "Geslo ni dovolj močno. Uporabite vsaj 8 znakov, med katerimi mora biti vsaj en numeričen.";
            return;
          }
          else if(this.validation.rePass){
            this.errMsg = "Gesla se ne ujemata";
            return;
          }


          if(!this.validation.name && !this.validation.surname && !this.validation.email && !this.validation.pass && !this.validation.rePass){
            //ajax klic
            this.errMsg = '';
            console.log("Ajax klic");
          }
          else {
            this.errMsg = "Niste izpolnili vseh polj!";
          }
        }
      }
  }
</script>
