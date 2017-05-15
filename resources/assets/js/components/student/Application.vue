<template>
  <div class="row">
      <div class="col-md-12">
          <div v-if="ifApplication" class="panel panel-default" style="padding: 10px">

            <h3>DRŽAVLJANSTVO</h3>
              <div class="row">

                <div class="form-group col-md-6">
                  <label for="drzava_rojstva">Državljanstvo</label>
                  <div v-if="doRender">
                    <v-select  v-model="apl.citizen_id" label="name" :on-change="handleCitizenship" :options="sifrants.citizens"></v-select>
                  </div>
                </div>
              </div>
              <hr />
          <div v-show="hasCitizenship">
            <h3>OSEBNI PODATKI</h3>
            <div class="row" v-show="needsEmso">
              <div class="form-group col-md-6" >
                <label for="emso">EMŠO</label>
                <div class="input-group">
                <input v-model.number="apl.emso" v-validate="'required|digits:13'" name="emso" type="number" placeholder="EMŠO" class="form-control" id="emso" maxlength="13">
                 <span class="input-group-addon" id="basic-addon2" style="padding:0px;">
                  <div class="btn btn-success" :disabled="errors.has('emso')" v-on:click="fillEMSOdata">Potrdi EMŠO</div>
                  </span>
                </div>
                <p class="text-danger" v-if="displayEmsoError">Vnešeni EMŠO ni pravilen</p>
                <p class="text-danger" v-if="errors.has('emso')">{{errors.first('emso')}} </p>
              </div>

            </div>

            <div class="row">
              <div class="form-group col-md-6">
                <label for="ime">Ime</label>
                <input disabled v-model="apl.user.data.name.split(' ')[0]" placeholder="Ime" class="form-control" id="ime">
              </div>
              <div class="form-group col-md-6">
                <label for="primmek">Priimek</label>
                <input disabled v-model="apl.user.data.name.split(' ')[1]" placeholder="Priimek" class="form-control" id="primmek">
              </div>
            </div>

            <div class="row">
              <div class="form-group col-md-6">
                <label for="spol">Spol {{ hasEmso }} {{ needsEmso }}</label>
                <input v-if="hasEmso && needsEmso" v-model="apl.gender.label" disabled="true" class="form-control">
                <v-select v-if="!needsEmso" v-model="apl.gender" :options="[{label: 'Moški', value: 'male'},{label: 'Ženska', value: 'female'}]"></v-select>
              </div>
              <div class="form-group col-md-6">
                <label for="datum_rojstva">Datum rojstva</label>
                <input v-if="hasEmso && needsEmso" v-model="apl.date_of_birth" disabled="true" class="form-control">

                <datepicker v-if="!needsEmso" v-model="apl.date_of_birth" format="d.M.yyyy" language="sl-si" class="form-control" id="datum_rojstva"></datepicker>
              </div>
            </div>

             <div class="row">
               <div class="form-group col-md-6">
                <label for="kraj_rojstva">Kraj rojstva</label>
                  <div v-if="doRender">
                    <div v-if="formControl.enable_district_id">
                      <v-select v-model="apl.district_id" label="name" :options="sifrants.districts"></v-select>
                    </div>
                    <div v-else>
                      <input v-model="apl.district_id.name" disabled="true" class="form-control">
                    </div>
                </div>
              </div>
               <div class="form-group col-md-6">
                <label for="drzava_rojstva">Država rojstva</label>
                <div v-if="doRender">
                  <v-select v-model="apl.country_id" label="name" :options="sifrants.countries" :on-change="handleCountryOfBirth"></v-select>
                </div>
              </div>
            </div>

            <div class="row">

              <!--<div class="form-group col-md-6">
                <label for="drzava_rojstva">Državljanstvo</label>
                <div v-if="doRender">
                  <v-select  v-model="apl.citizen_id" label="name" :options="sifrants.citizens"></v-select>
                </div>
              </div>
              -->
            </div>

            <div class="row">
              <div class="form-group col-md-6">
                <label for="ime">Kontaktni telefon</label>
                <input v-model="apl.phone" v-validate="'required|digits:9'" name="phone" placeholder="Kontaktni telefon" class="form-control" id="ime">
                <p class="text-danger" v-if="errors.has('phone')">{{errors.first('phone')}} </p>
              </div>
              <div class="form-group col-md-6">
                <label for="primmek">Email</label>
                <input disabled type="email" v-model="apl.user.data.email" placeholder="Email" class="form-control" id="email">
              </div>
            </div>

            <hr />
            <h3>NASLOV STALNEGA PREBIVALIŠČA</h3>

            <div class="row">
              <div class="form-group col-md-12">
                <label for="naslov_stalni">Naslov</label>
                <input v-model="apl.permanent_address" placeholder="Naslov" class="form-control" id="naslov_stalni">
              </div>
            </div>
            <div class="row">
              <div class="form-group col-md-6">
                <label for="drzava_stalni_naslov">Mesto</label>
                <div v-if="doRender">
                  <div v-if="formControl.enable_permanent_city">
                  <v-select  v-model="apl.permanent_applications_cities_id" label="name" :options="sifrants.cities"></v-select>
                  </div>
                  <div v-else>
                    <input v-model="apl.permanent_applications_cities_id.name" disabled="true" class="form-control">
                  </div>
                </div>
              </div>
              <div class="form-group col-md-6">
                <label for="drzava_stalni_naslov">Država</label>
                <div v-if="doRender">
                  <v-select  v-model="apl.permanent_country_id" label="name" value="id" :options="sifrants.countries" :on-change="handlePermanentAdress"></v-select>
                </div>
              </div>
            </div>

            <hr />
            <h3>NASLOV ZA POŠILJANJE</h3>

            <div class="row">
              <div class="form-group col-md-3">
                <label for="is_send_address_same">Je enak stalnemu naslovu</label>
                <input type="checkbox" id="is_send_address_same" v-model="send_address_same">
              </div>
            </div>

            <div v-if="!send_address_same">
                <div class="row">
              <div class="form-group col-md-12">
                <label for="naslov_stalni">Naslov</label>
                <input v-model="apl.mailing_address" placeholder="Naslov" class="form-control" id="naslov_stalni">
              </div>
            </div>
              <div class="row">

                <div class="form-group col-md-6">

                <label for="drzava_stalni_naslov">Mesto</label>
                <div v-if="doRender">
                  <div v-if="formControl.enable_mailing_city">
                  <v-select v-model="apl.mailing_applications_cities_id" label="name" :options="sifrants.cities"></v-select>
                  </div>
                  <div v-else>
                    <input v-model="apl.mailing_applications_cities_id.name" disabled="true" class="form-control">
                  </div>
                </div>
              </div>
              <div class="form-group col-md-6">
                <label for="drzava_stalni_naslov">Država</label>
                <div v-if="doRender">
                  <v-select  v-model="apl.mailing_country_id" label="name" :options="sifrants.countries" :on-change="handleMailingAdress"></v-select>
                </div>
              </div>

            </div>

            </div>


            <hr />
            <h3>DOSEDANJA IZOBRAZBA</h3>
            <div class="row">

              <div class="form-group col-md-12">
                <label for="dosedanja_izobrazba">KLASIUS SRV</label>
                <div v-if="doRender">
                    <v-select v-model="apl.education_type_id" label="name" :options="sifrants.education_types"></v-select>
                  </div>
              </div>
            </div>

            <hr />
            <h3>SREDNJEŠOLSKA IZOBRAZBA</h3>
            <div class="row">

            <div class="form-group col-md-6">
                <label for="srednja_sola">Srednja šola, ki sem jo obiskoval</label>
                <div v-if="doRender">
                  <div v-if="formControl.enableMidSchools">
                    <v-select v-model="apl.middle_school_id" label="name" :options="sifrants.middle_schooles"></v-select>
                  </div>
                  <div v-else>
                    <input v-model="apl.middle_school_id.name" disabled="true" class="form-control">
                  </div>
                </div>
              </div>
              <!--<div class="form-group col-md-6">
                <label for="drzava_srednje_sole">Država</label>
                <div v-if="doRender">
                  <v-select v-model="apl.drzava_srednje_sole" :on-change="checkMiddSchool"  label="name" :options="sifrants.countries"></v-select>
                </div>
              </div>
              -->

            </div>
            <div class="row">
               <div class="form-group col-md-6">
                <label for="nacin_srednje_sole">Način zaključka srednje šole</label>
                <div v-if="doRender">
                  <div v-if="formControl.enableMidSchools">
                  <v-select  v-model="apl.graduation_type_id" label="name" :options="sifrants.graduation_types"></v-select>
                  </div>
                  <div v-else>
                    <input v-model="apl.graduation_type_id.name" disabled="true" class="form-control">
                  </div>
                </div>
              </div>
              <div class="form-group col-md-6">
                <label for="srednja_sola">Pridobljeni poklic</label>
                <div v-if="doRender">
                    <v-select v-model="apl.profession_id" label="name" :options="sifrants.professions"></v-select>
                </div>
              </div>

            </div>

            <hr />
            <h3>V skladu z razpisom se prijavljam na razpis</h3>

            <div v-for="(wish, index) in wishes">
              <div class="row">
                <div class="col-md-12">
                  <label class="btn btn-danger pull-right" v-on:click="wishes.splice(index, 1)">Odstrani željo</label>
                  <div class="pull-left" style="cursor:pointer">
                    <div class="dropup" v-on:click="moveWishUp(index)">
                     <span class="caret"></span>
                    </div>
                    <div class="dropdown" v-on:click="moveWishDown(index)">
                        <span class="caret"></span>
                    </div>
                  </div>
                  <h4 >&nbsp;{{ index+1}}. želja</h4>

                </div>
              </div>
              <div class="row">
                <div class="form-group col-md-12">
                  <label for="faculty">Visokošolski zavod</label>
                  <div v-if="doRender">
                    <v-select v-model="wishes[index].faculty"  label="name" :options="sifrants.faculties"></v-select>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="form-group" v-bind:class="{'col-md-12': !wishes[index].is_double,
                                                'col-md-6': wishes[index].is_double }">
                  <label for="faculty">Program</label>
                  <div v-if="doRender && wishes[index].faculty != null">
                    <v-select  v-model="wishes[index].program" label="name" :options="wishes[index].eligable_programs"></v-select>
                  </div>
                </div>
                <div v-if="wishes[index].is_double "class="form-group col-md-6">
                  <label for="faculty">Program 2</label>
                  <div v-if="doRender" >
                    <v-select v-model="wishes[index].program2" label="name" :options="wishes[index].eligable_programs2"></v-select>
                  </div>
                </div>
              </div>

                <!--
                <div class="row">
                  <div class="form-group col-md-12">
                    <label for="kraj_studija">Kraj študija</label>
                    <div v-if="doRender">
                      <v-select  v-model="wishes[index].faks_kraj" label="name" :options="sifrants.cities"></v-select>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="form-group col-md-6">
                    <label for="nacin_studija">Način študija</label>
                    <div v-if="doRender">
                      <v-select  v-model="wishes[index].regular" :options="[{label: 'Redni', value: 1},{label: 'Izredni', value: 0}]"></v-select>
                    </div>
                  </div>
                </div>
                -->

              <hr />
              </div>
              <div :disabled="wishes.length >= 3" class="btn btn-success" v-on:click="add_wish">Dodaj željo</div>

              <hr />

              <div class="btn btn-default" v-on:click="submit('saved')">Shrani</div>
              <div class="btn btn-success" v-on:click="submit('filed')">Potrdi</div>
              <p v-show="showResponse" v-bind:class="{'bg-danger': !reqOk, 'bg-success': reqOk}" style="padding: 10px; width: 30%; margin-top: 15px;"> {{ backendMsg }} </p>
              </div>
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
          ifApplication: false,
          doRender: false,
          countries: null,
          send_address_same: false,
          wishes: [],
          formControl: {
            enableMidSchools: true,
            enable_permanent_city: true,
            enable_mailing_city: true,
            enable_district_id: true
          },
          updating: false,
          hasCitizenship: false,
          needsEmso: true,
          hasEmso: false,
          displayEmsoError: false,
          showResponse: false,
          reqOk: false,
          backendMsg: ""
        }
    },
    watch: {

      wishes: {
        handler: function (previousValue, currentValue) {

          if(this.updating ) return;

          this.updating = true;
          this.updatePrograms();

          // prevent "infinite loop" cause of changes triggers watch again..
          setTimeout(function(){ this.updating=false; }.bind(this), 100);

        },
        deep: true
      }
    },

    methods: {

      submit: function(status) {


        this.apl.wishes = this.wishes;
        let send_apl = this.preprocessApplication();
        send_apl['status'] = status;

        if("id" in this.apl) {
          this.update_aplication(send_apl);
        }else{
          this.submit_new(send_apl);
        }
      },
      submit_new: function(payload) {
        this.$http.post("api/applications", payload)
        .then(function(data) {
          this.reqOk = true;
          if(payload.status === "filed") {
            this.$router.push('/student');
          }else{
            this.showResponse = true;
            this.backendMsg = "Vloga uspešno shranjena"
          }

        }, function(err) {

          this.reqOk = false;
          console.log(err);
          if(parseInt(err.status) == 400) {
            this.showResponse = true;
            this.backendMsg = err.body.message;
          }
        })
      },
      update_aplication: function(payload) {
        this.$http.put("api/applications/"+payload.id, payload)
        .then(function(data) {
          this.reqOk = true;
          if(payload.status === "filed") {
            this.$router.push('/student');
          }else{
            this.showResponse = true;
            this.backendMsg = "Vloga uspešno shranjena"
          }
        }, function(err) {
          this.reqOk = false;
          if(parseInt(err.status) == 400) {
            this.showResponse = true;
            this.backendMsg = err.body.message;

          }
        })
      },
      add_wish: function(programs) {
        if( this.wishes.length >= 3) return;

        let w = {
              "faculty": null,
              "program": null,
              "program2": null,
              "module": null,
              "kraj": null,
              "regular": null,
              "is_double": false,
              "eligable_programs": [],
              "eligable_programs2": []
            };

        this.wishes.push(w);
      },
      updatePrograms: function(index) {

        for (let w in this.wishes) {
          let ww = this.wishes[w];
          let progrs = []
          // filter programs
          if (ww.faculty != null) {

            for (let p in this.sifrants.facultyPrograms) {
              if (this.sifrants.facultyPrograms[p].faculty_id == ww.faculty.id)
                progrs.push(this.sifrants.facultyPrograms[p]);
            }
          }
          this.wishes[w].eligable_programs = progrs;

          let p_ids = [];
          for(let i in progrs) {
            p_ids.push(progrs[i].id);
          }
          if( this.wishes[w].program != null && p_ids.indexOf(this.wishes[w].program.id) == -1 ) {
            this.wishes[w].program = null;
          }


          let program = this.wishes[w].program
          if( program !== null){
            this.wishes[w].is_double = program.allow_double_degree;

            let doublPrograms = [];
            for (let i in progrs) {
              if(progrs[i].allow_double_degree && progrs[i] !== program) doublPrograms.push(progrs[i]);
            }
            this.wishes[w].eligable_programs2 = doublPrograms;
          }

        }
      },
      moveWishUp: function(index) {

        if(index==0) return;

        let tmp = this.wishes[index-1];
        this.wishes.splice(index-1, 1);
        this.wishes.splice(index, 0, tmp);


      },
      moveWishDown: function(index) {

        if(index==this.wishes.length) return;

        let tmp = this.wishes[index+1];
        this.wishes.splice(index+1, 1);
        this.wishes.splice(index, 0, tmp);

      },
      handleCitizenship: function(currentValue) {

        this.apl.citizen_id = currentValue;

        this.hasCitizenship = true;
        console.log("DRZAVLJANSTVO SPREMEMBA")
        console.log(currentValue);

        if(currentValue.id == 1) {
          this.needsEmso = true;
          //this.hasEmso = false;
        }else{
          console.log("ni slovenia")
          this.needsEmso = false;
          //this.apl.gender = null;
          //this.apl.date_of_birth = null;
        }


      },
      fillEMSOdata: function() {

        let emso = String(this.apl.emso);

        if(emso.length != 13) {
          this.displayEmsoError=true;
          this.hasEmso = false;
          return;
        }

        let gender = emso.substring(7,10);
        if(parseInt(gender) == 500) {
          console.log("MALE")
          this.apl.gender = {label: 'Moški', value: 'male'};
        }else if(parseInt(gender) == 550) {
          this.apl.gender = {label: 'Ženska', value: 'female'};
        }else {
          this.displayEmsoError=true;
          this.hasEmso = false;
          return;
        }
        console.log(this.apl.gender)
        let day_ob = emso.substring(0,2),
          month_ob = emso.substring(2,4),
          year_ob = ""

        if(emso.charAt(4) === '9') {
          year_ob = "19"+emso.substring(5,7)
        }else{
          year_ob = "20"+emso.substring(5,7)
        }

        this.apl.date_of_birth= String(day_ob+"."+month_ob+"."+year_ob);//year_ob+"-"+month_ob+"-"+day_ob;
        console.log(this.apl.date_of_birth)
        this.displayEmsoError=false;
        this.hasEmso = true;
      },
      checkMiddSchool: function (currentValue) {

          // check if country is not slovenia => set other 2 fields
          if (parseInt(currentValue.id) != 705){
            this.apl.middle_school_id = {id: 9, name: "DRUGO"};
            this.apl.graduation_type_id = {id: 1, name: "PODATEK MANJKA"},
            this.formControl.enableMidSchools = false;
          }else{
            this.apl.middle_school_id = null;
            this.apl.graduation_type_id = null,
            this.formControl.enableMidSchools = true;
          }
        },
        handlePermanentAdress: function(currentValue) {

          this.apl.permanent_country_id = currentValue;
          if(parseInt(currentValue.id) != 705) {
            this.apl.permanent_applications_cities_id = {id:1, name:"NEZNANA POŠTA"}; // cities[0]
            this.formControl.enable_permanent_city = false;
          }else {

            if(this.apl.permanent_applications_cities_id.id == 1) this.apl.permanent_applications_cities_id = null;
            this.formControl.enable_permanent_city = true;
          }

        },
        handleMailingAdress: function(currentValue) {

          this.apl.mailing_country_id = currentValue;
          if(parseInt(currentValue.id) != 705) {
            this.apl.mailing_applications_cities_id = {id:1, name:"NEZNANA POŠTA"}; // cities[0]
            this.formControl.enable_mailing_city = false;
          }else {
             if(this.apl.mailing_applications_cities_id.id == 1) this.apl.mailing_applications_cities_id = null;

            //this.apl.mailing_applications_cities_id = null;
            this.formControl.enable_mailing_city = true;
          }

        },
        handleCountryOfBirth: function(currentValue) {

          this.apl.country_id = currentValue;
          if(parseInt(currentValue.id) != 705) {
            this.apl.district_id = {id: 0, name: "TUJINA"}; // cities[0]
            this.formControl.enable_district_id = false;
          }else {

            if(this.apl.district_id.id == 0) this.apl.district_id = null;

            this.formControl.enable_district_id = true;
          }
        },
        preprocessApplication: function() {

          console.log("preprocessApplication")
          console.log(this.apl.date_of_birth)
          // ugly way to copy object
          let apl = JSON.parse(JSON.stringify(this.apl));

          if( this.needsEmso && this.hasEmso){

            let dob = String(apl.date_of_birth);
            apl.date_of_birth = new Date(parseInt(dob.substring(6,8)), parseInt(dob.substring(3,5)), parseInt(dob.substring(0,2)));
          } else {
            apl.emso = "412345678901"
          }

          for(let w in apl.wishes) {
            let ww = apl.wishes[w];
            let prgs = [ww.program.id];
            if(ww.program2 != null) prgs.push(ww.program2.id);

            apl.wishes[w] = { 'faculty_id': ww.faculty.id,
                  'programs_id': prgs
                };
          }

          // extract ids
          for (var key in apl) {
            if (apl.hasOwnProperty(key) && key.indexOf('_id') > 0) {

              var val = apl[key];
              if(val != null)
                apl[key] = apl[key].id
            }
          }

          apl.gender = apl.gender.value;
          if(this.send_address_same) {
            apl.mailing_address = apl.permanent_address;
            apl.mailing_applications_cities_id = apl.permanent_applications_cities_id;
            apl.mailing_country_id = apl.permanent_country_id;
          }
          apl.user_id = apl.user.data.id;

          delete apl.user;
          return apl;

        }

    },
    created: function(){

      console.log("created applications")
      this.apl = this.$root.studentApplication;

      if(typeof this.apl === 'undefined') {
        this.$router.push('/student');
        return;
      }

      console.log(this.apl.status);

      if(this.apl.status == "saved") {
        console.log("saved")
        if(this.apl.citizen_id.id == 1) this.needsEmso = true;
        if(this.apl.emso != null) this.hasEmso = true;

        console.log("needsEmso= "+this.needsEmso);
        console.log("hasEmso= "+this.hasEmso);

        if(this.needsEmso && this.hasEmso) {
          let dob = String(this.apl.date_of_birth)

          this.apl.date_of_birth=dob.substring(8,10)+"."+dob.substring(5,7)+"."+dob.substring(0,4);
        }
      }


      this.$http.get('api/applications/sifranti')
        .then(function(res){
          this.sifrants = res.body;
          this.countries = this.sifrants.countries;

          this.wishes = this.apl.wishes;
          this.ifApplication = true;

          this.doRender = true;
        });
    },
    mounted() {
      console.log("application mounted");
    }
  }
</script>
