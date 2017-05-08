<template>
  <div class="row">
      <div class="col-md-12">
          <div v-if="ifApplication" class="panel panel-default" style="padding: 10px">
            
              <h3>OSEBNI PODATKI</h3>
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
                  <label for="emso">EMŠO</label>
                  <input v-model.number="apl.emso" type="number" placeholder="EMŠO" class="form-control" id="emso" maxlength="13">
                </div>
                <div class="form-group col-md-6">
                  <label for="spol">Spol</label>
                  <v-select  v-model="apl.gender" :options="[{label: 'Moški', value: 'male'},{label: 'Ženska', value: 'female'}]"></v-select>
                </div>
              </div>

               <div class="row">
                <div class="form-group col-md-6">
                  <label for="datum_rojstva">Datum rojstva</label>
                  <datepicker v-model="apl.date_of_birth" format="d.M.yyyy" language="sl-si" class="form-control" id="datum_rojstva"></datepicker>
                </div>
                 <div class="form-group col-md-6">
                  <label for="drzava_rojstva">Država rojstva</label>
                  <div v-if="doRender">
                    <v-select v-model="apl.country_id" label="name" :options="sifrants.countries" :on-change="handleCountryOfBirth"></v-select>
                  </div>

                </div>
              </div>

              <div class="row">
                
               
                <div class="form-group col-md-6">
                 
                  <label for="kraj_rojstva">Kraj rojstva</label>
                    <div v-if="doRender">
                      <div v-if="formControl.enable_district_id">
                        <v-select  v-model="apl.district_id" label="name" :options="sifrants.districts"></v-select>
                      </div>
                      <div v-else>
                        <input v-model="apl.district_id.name" disabled="true" class="form-control">
                      </div>
                  </div>
                </div>
                <div class="form-group col-md-6">
                  <label for="drzava_rojstva">Državljanstvo</label>
                  <div v-if="doRender">
                    <v-select  v-model="apl.citizen_id" label="name" :options="sifrants.citizens"></v-select>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="form-group col-md-6">
                  <label for="ime">Kontaktni telefon</label>
                  <input v-model="apl.phone" placeholder="Kontaktni telefon" class="form-control" id="ime">
                </div>
                <div class="form-group col-md-6">
                  <label for="primmek">Email</label>
                  <input disabled type="email" v-model="apl.user.data.email" placeholder="Email" class="form-control" id="email">
                </div>
              </div>
              


              <hr />
              <h3>NASLOV STALNEGA PREBIVALIŠČA</h3>
              
              <div class="row">
                
                <div class="form-group col-md-6">
                  <label for="drzava_stalni_naslov">Država</label>
                  <div v-if="doRender">
                    <v-select  v-model="apl.drzava_stalni_naslov" label="name" value="id" :options="sifrants.countries" :on-change="handlePermanentAdress"></v-select>
                  </div>
                </div>
                <div class="form-group col-md-6">
                  <label for="drzava_stalni_naslov">Mesto</label>
                  <div v-if="doRender">
                    <div v-if="formControl.enable_permanent_city">
                    <v-select  v-model="apl.permanent_applications_cities_id" label="name" :options="sifrants.cities"></v-select>
                    </div>
                    <div v-else>
                      <input v-model="apl.permanent_applications_cities_id.name" disabled="true" class="form-control">
                    </div>
                    <!--<v-select  v-model="apl.permanent_applications_cities_id" label="name" :options="sifrants.cities"></v-select>-->
                  </div>
                </div>

                
              </div>
              <div class="row">
                <div class="form-group col-md-12">
                  <label for="naslov_stalni">Naslov</label>
                  <input v-model="apl.permanent_address" placeholder="Naslov" class="form-control" id="naslov_stalni">
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
                
                <div class="form-group col-md-6">
                  <label for="drzava_stalni_naslov">Država</label>
                  <div v-if="doRender">
                    <v-select  v-model="apl.drzava_send_naslov" label="name" :options="sifrants.countries" :on-change="handleMailingAdress"></v-select>
                  </div>
                </div>
                <div class="form-group col-md-6">
                  <label for="drzava_stalni_naslov">Mesto</label>
                  <div v-if="doRender">
                    <div v-if="formControl.enable_mailing_city">
                    <v-select  v-model="apl.mailing_applications_cities_id" label="name" :options="sifrants.cities"></v-select>
                    </div>
                    <div v-else>
                      <input v-model="apl.mailing_applications_cities_id.name" disabled="true" class="form-control">
                    </div>
                    <!--<v-select  v-model="apl.mailing_applications_cities_id" label="name" :options="sifrants.cities"></v-select>-->
                  </div>
                </div>
                
              </div>
              <div class="row">
                <div class="form-group col-md-12">
                  <label for="naslov_stalni">Naslov</label>
                  <input v-model="apl.mailing_address" placeholder="Naslov" class="form-control" id="naslov_stalni">
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
                  <label for="drzava_srednje_sole">Država</label>
                  <div v-if="doRender">
                    <v-select v-model="apl.drzava_srednje_sole" :on-change="checkMiddSchool"  label="name" :options="sifrants.countries"></v-select>
                  </div>
                </div>

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
              </div>
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
                <div class="form-group col-md-6">
                  <label for="srednja_sola">Pridobljeni poklic</label>
                  <div v-if="doRender">
                    <!--<div v-if="formControl.enableMidSchools">-->
                      <v-select v-model="apl.profession_id" label="name" :options="sifrants.professions"></v-select>
                    <!--</div>
                    <div v-else>
                      <input v-model="apl.middle_school_id.name" disabled="true" class="form-control">
                    </div>-->
                  </div>
                </div>

              </div>

              <hr />
              <h3>V skladu z razpisom se prijavljam na razpis</h3>

              <div v-for="(wish, index) in wishes">
                <div class="row">
                  <div class="col-md-12">
                    <h4 class="col-md-3">{{ index+1}}. želja</h4>
                    <label class="btn btn-danger col-md-offset-7 col-md-2" v-on:click="wishes.splice(index, 1)">Odstrani željo</label>
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
          apl: null,

          // apl: {
          //   drzava_srednje_sole: null
          // }
          
        }    
    },
    watch: {
      
      wishes: {
        handler: function (previousValue, currentValue) {
          
          
          if(this.updating) return;
          
          this.updating = true;
          this.updatePrograms();

          // prevent "infinite loop" cause of changes triggers watch again..
          setTimeout(function(){ this.updating=false; }.bind(this), 100);
          
        },
        deep: true
      } 
    },
    
    methods: {
    
      submit: function(apl) {
        //console.log(this.apl)
        //console.log(JSON.stringify(this.apl))
        this.apl.wishes = this.wishes;
        let send_apl = this.preprocessApplication();

        this.$http.post("api/applications", send_apl)
        .then(function(data) {
          console.log(data)
        }, function(err) {
          console.log(err);
        })

        //console.log(this.apl);
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
        console.log(JSON.stringify(this.wishes))
      },
      updatePrograms: function(index) {
        
        for (let w in this.wishes) {
          let ww = this.wishes[w]
          
          let progrs = [] 
          // filter programs
          if (ww.faculty != null) {
            
            for (let p in this.sifrants.facultyPrograms) {
              if (this.sifrants.facultyPrograms[p].faculty_id == ww.faculty.id)
                progrs.push(this.sifrants.facultyPrograms[p]);
            }
          }
          this.wishes[w].eligable_programs = progrs;
          if( progrs.indexOf(this.wishes[w].program) == -1) this.wishes[w].program = null;

        
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
      clearSifrants: function(apl) {
        apl.citizen = null;
        apl.education = null;
        apl.graduation = null;
        apl.nationality = null;
        apl.middle_school = null;
        apl.profession = null;
        apl.gender = null;
        return apl;
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

          if(parseInt(currentValue.id) != 705) {
            this.apl.permanent_applications_cities_id = {id:1, name:"NEZNANA POŠTA"}; // cities[0]
            this.formControl.enable_permanent_city = false;
          }else {
            this.apl.permanent_applications_cities_id = null;
            this.formControl.enable_permanent_city = true;
          }

        },
        handleMailingAdress: function(currentValue) {

          if(parseInt(currentValue.id) != 705) {
            this.apl.mailing_applications_cities_id = {id:1, name:"NEZNANA POŠTA"}; // cities[0]
            this.formControl.enable_mailing_city = false;
          }else {
            this.apl.mailing_applications_cities_id = null;
            this.formControl.enable_mailing_city = true;
          }

        },
        handleCountryOfBirth: function(currentValue) {

          console.log(currentValue);
          this.apl.country_id = currentValue;
          if(parseInt(currentValue.id) != 705) {
            this.apl.district_id = {id: 0, name: "TUJINA"}; // cities[0]
            this.formControl.enable_district_id = false;
          }else {
            this.apl.district_id = null;
            this.formControl.enable_district_id = true;
          }
        },
        preprocessApplication: function() {

          // ugly way to copy object
          let apl = JSON.parse(JSON.stringify(this.apl));

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
              //console.log(val);
            }
          }

          apl.gender = apl.gender.value;

          console.log("MAIL ADDR SAME "+this.send_address_same)
          if(this.send_address_same) {
            apl.mailing_address = apl.permanent_address;
            apl.mailing_applications_cities_id = apl.permanent_applications_cities_id;
            //todo drzava
          }
          apl.user_id = apl.user.data.id;

          delete apl.user;
          console.log("FINAL");
          console.log(apl);
          return apl;

        }

    },
    created: function(){
      this.add_wish();

      this.$http.get('/api/applications/active')
        .then(function(res){

          let application = res.data.data;
          console.log(application)
          // new application
          if (application.status == 'created') {
            application = this.clearSifrants(application) 
          }

          if( application.wishes != null) {
            this.wishes = wishes;
          }

          this.apl = application;
          this.ifApplication = true;

          this.$http.get('api/applications/sifranti')
            .then(function(res){
              console.log(res);
              this.sifrants = res.body;
              this.countries = this.sifrants.countries;
              
              // fill sifrants
              //this.apl.drzava_stalni_naslov = this.countries[0];

              this.doRender = true;    
            })
          
        })
    },
    mounted() {

      console.log('application  mounted.');
      //this.$router.push('404');
      //console.log("should redirect")
    }
  }
</script>
