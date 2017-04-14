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
                  <input v-model.number="apl.emso" type="number" placeholder="EMŠO" class="form-control" id="emso" maxlength="13">
                </div>
                <div class="form-group col-md-6">
                  <label for="spol">Spol</label>
                  <v-select  v-model="apl.spol" :options="[{label: 'Moški', value: 'M'},{label: 'Ženska', value: 'Z'}]"></v-select>
                </div>
              </div>

               <div class="row">
                <div class="form-group col-md-6">
                  <label for="datum_rojstva">Datum rojstva</label>
                  <datepicker format="d.M.yyyy" language="sl-si" class="form-control" id="datum_rojstva"></datepicker>
                </div>
                <div class="form-group col-md-6">
                 
                  <label for="kraj_rojstva">Kraj rojstva</label>
                    <input v-model="apl.kraj_rojstva" placeholder="kraj rojstva" class="form-control" id="kraj_rojstva">
                </div>
              </div>

              <div class="row">
                
                <div class="form-group col-md-6">
                  <label for="drzava_rojstva">Država rojstva</label>
                  <div v-if="doRender">
                    <v-select  v-model="apl.drzavljanstvo" label="name" :options="sifrants.countries"></v-select>
                  </div>
                </div>

                <div class="form-group col-md-6">
                  <label for="drzava_rojstva">Državljanstvo</label>
                  <div v-if="doRender">
                    <v-select  v-model="apl.drzavljanstvo" label="name" :options="sifrants.citizens"></v-select>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="form-group col-md-6">
                  <label for="ime">Kontaktni telefon</label>
                  <input v-model="apl.telefon" placeholder="Kontaktni telefon" class="form-control" id="ime">
                </div>
                <div class="form-group col-md-6">
                  <label for="primmek">Email</label>
                  <input type="email" v-model="apl.email" placeholder="Email" class="form-control" id="email">
                </div>
              </div>
              


              <hr />
              <h3>NASLOV STALNEGA PREBIVALIŠČA</h3>
              
              <div class="row">
                
                <div class="form-group col-md-6">
                  <label for="drzava_stalni_naslov">Država</label>
                  <div v-if="doRender">
                    <v-select  v-model="apl.drzava_stalni_naslov" label="name" :options="sifrants.countries"></v-select>
                  </div>
                </div>

                
              </div>
              <div class="row">
                <div class="form-group col-md-12">
                  <label for="naslov_stalni">Naslov</label>
                  <input v-model="apl.naslov_stalni" placeholder="Naslov" class="form-control" id="naslov_stalni">
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
                    <v-select  v-model="apl.drzava_stalni_naslov" label="name" :options="sifrants.countries"></v-select>
                  </div>
                </div>

                
              </div>
              <div class="row">
                <div class="form-group col-md-12">
                  <label for="naslov_stalni">Naslov</label>
                  <input v-model="apl.naslov_stalni" placeholder="Naslov" class="form-control" id="naslov_stalni">
                </div>
              </div>
              </div>
              
              
              <hr />
              <h3>DOSEDANJA IZOBRAZBA</h3>
              <div class="row">
                
                <div class="form-group col-md-12">
                  <label for="dosedanja_izobrazba">KLASIUS SRV</label>
                  <div v-if="doRender">
                      <v-select  v-model="apl.dosedanja_izobrazba" label="name" :options="sifrants.education_types"></v-select>
                    </div>
                </div>
              </div>

              <hr />
              <h3>SREDNJEŠOLSKA IZOBRAZBA</h3>
              <div class="row">
              
                <div class="form-group col-md-6">
                  <label for="drzava_srednje_sole">Država</label>
                  <div v-if="doRender">
                    <v-select  v-model="apl.drzava_srednje_sole" label="name" :options="sifrants.countries"></v-select>
                  </div>
                </div>

                <div class="form-group col-md-6">
                  <label for="drzava_srednje_sole">Način zaključka srednje šole</label>
                  <div v-if="doRender">
                    <v-select  v-model="apl.nacin_srednje_sole" label="name" :options="sifrants.graduation_types"></v-select>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="form-group col-md-12">
                  <label for="srednja_sola">Srednja šola, ki sem jo obiskoval</label>
                  <div v-if="doRender">
                    <v-select  v-model="apl.srednja_sola" label="name" :options="sifrants.middle_schooles"></v-select>
                  </div>
                </div>

              </div>

              <h3>V skladu z razpisom se prijavljam na razpis</h3>

              <div v-for="(wish, index) in whishes">
                <div class="row">
                  <div class="col-md-12">
                    <h4 class="col-md-3">{{ index+1}}. želja</h4>
                    <label class="btn btn-danger col-md-offset-7 col-md-2" v-on:click="whishes.splice(index, 1)">Odstrani željo</label>
                  </div>
                </div>
                <div class="row">
                  <div class="form-group col-md-12">
                    <label for="faculty">Visokošolski zavod</label>
                    <div v-if="doRender">
                      <v-select  v-model="whishes[index].faculty" label="name" :options="sifrants.faculties"></v-select>
                    </div>
                  </div>
                </div> 

                <div class="row">
                  <div class="form-group col-md-12">
                    <label for="faculty">Program</label>
                    <div v-if="doRender">
                      <v-select  v-model="whishes[index].program" label="name" :options="sifrants.facultyPrograms"></v-select>
                    </div>
                  </div>
                </div> 

                <div class="row">
                  <div class="form-group col-md-12">
                    <label for="kraj_studija">Kraj študija</label>
                    <div v-if="doRender">
                      <v-select  v-model="whishes[index].faks_kraj" label="name" :options="sifrants.cities"></v-select>
                    </div>
                  </div>
                </div> 

                <div class="row">
                  <div class="form-group col-md-6">
                    <label for="nacin_studija">Način študija</label>
                    <div v-if="doRender">
                      <v-select  v-model="whishes[index].regular" :options="[{label: 'Redni', value: 1},{label: 'Izredni', value: 0}]"></v-select>
                    </div>
                  </div>
                </div> 


              <hr />
              </div>
              <div :disabled="whishes.length >= 3" class="btn btn-success" v-on:click="add_wish">Dodaj željo</div>

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
          doRender: false,
          countries: null,
          send_address_same: false,
          apl: {
            ime: null,
            priimek: "Novak",
            emso: null,
            spol: null
          },
          whishes: []
          
        }    
    },
    methods: {
      submit: function(apl) {
        console.log(JSON.stringify(this.apl))
      },
      add_wish: function(){
        if( this.whishes.length >= 3) return;

        let w = {
              "faculty": null,
              "program": null,
              "module": null,
              "kraj": null,
              "regular": null
            };
        
        this.whishes.push(w);
        console.log(JSON.stringify(this.whishes))
      }

    },
    created: function(){
      this.add_wish();
      this.$http.get('/api/application')
        .then(function(res){

          console.log(res);
          this.sifrants = res.body;
          this.countries = this.sifrants.countries;
          this.doRender = true;
        })
    },
    mounted() {
      console.log('application  mounted.');
      //this.$router.push('404');
      //console.log("should redirect")
    }
  }
</script>
