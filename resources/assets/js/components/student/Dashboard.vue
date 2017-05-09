<template>
  <div class="row">
      <div class="col-md-10 col-md-offset-1">
          <div class="panel panel-default">
              <!--<div class="panel-heading">Moja prijave</div>-->

              <div class="panel-body" >
                <div v-if="hasApplication">
                <h2>Imate oddano vpisnico</h2>
                  
                      <div v-if="apl.status=='filled'" v-on:click="goto_application" class="btn btn-default">
                        Izbrisi in oddaj ponovno
                      </div>
                      <div v-else="application.status=='created'" v-on:click="goto_application" class="btn btn-default">
                        Nadaljuj s prijavo
                      </div>
                      <div class="btn btn-primary pull-right" v-on:click="applicationPdf">Preglej</div>
                 
                    </tr>
                
                </table>
                </div>
                <div v-else> 
                  <h2>Niste še oddali vpisnice</h2>
                  <span class="btn btn-default" v-on:click="goto_application">Izpolni vpisnico</span>
                  <td class="btn btn-primary pull-right" v-on:click="applicationPdf">Application pdf test</td>
                 
                </div> 
              </div>
              
          </div>
      </div>
  </div>
</template>

<script>
  export default {
    name: 'StudentDashboard',
    data: function(router) {
        return {
          section: 'Student',
          application: null,
          hasApplication: false,
          mock_apl: {"emso":1504993500099,"gender":"female","date_of_birth":"1991-05-02T22:00:00.000Z","phone":"141123456","country_id":9,"citizen_id":1,"district_id":0,"middle_school_id":9,"profession_id":50103,"education_type_id":16102,"graduation_type_id":1,"permanent_address":"Jabadu","mailing_address":"Slovenska","permanent_country_id":20,"mailing_country_id":705,"permanent_applications_cities_id":1,"mailing_applications_cities_id":1210,"wishes":[{"faculty_id":63,"programs_id":["VU00"]},{"faculty_id":18,"programs_id":["Q200","Q300"]}],"user_id":2}

        }    
    },
    methods: {
      goto_application: function(event, application) {
        this.$router.push('application')
      },
      translate_gender: function(val) {

        if(val === "female") return "Ženski";
        return "Moški";
      },
      displayField: function(value) {
        if(value == null || value==='undefined') return '/'

        return String(value);
      },
      applicationPdf: function(apl) {
        var doc = new jsPDF();
        
        //210 je visina, 297mm sirina
        doc.setLineWidth(0.1);
        doc.setFont("sans-serif");

        doc.setTextColor(99, 107, 111);
        doc.setFontSize(20);
        doc.text(100, 20, "Vpisnica", null, null, "center");
        //table header
        
        doc.setFontSize(12);
        doc.text(20,30, "RAZPIS ZA VPIS NA DODIPLOMSKE IN ENOVITE MAGISTRSKE ŠTUDIJSKE PROGRAME ")
        doc.text(20,40, "v študijskem letu 2017/2018");
        // - Univerza v Ljubljani, Univerza v Mariboru, Univerza na Primorskem, Univerza v Novi Gorici, javni in koncesionirani samostojni visokošolski
         // zavodi
        doc.text(20, 50, "Prijavni rok: Prvi prijavni rok");
        doc.text(20, 60, "Vpis v 1. letnik");
                  
        const col1_start = 20,
          col1_text = 60,
          col2_start = 110,
          col2_text = 150,
          section_start=20,
          line_start=8,
          line_end=200;
        let page_count = 1;

        // OSEBNI PODATKI
        const personalData_start=70;
        let date_of_birth = new Date(apl.date_of_birth);
        date_of_birth = date_of_birth.getDay()+"."+(date_of_birth.getMonth()+1)+"."+date_of_birth.getFullYear();
        
        doc.text(section_start, personalData_start, "OSEBNI PODATKI");
        doc.line(line_start,personalData_start+2,line_end,personalData_start+2);

        doc.text(col1_start,personalData_start+10, "Ime in Priimek:"); doc.text(col1_text,personalData_start+10, this.displayField(apl.name));
        //doc.text(100,50, "Priimek:"); doc.text(150,50,"Novak");
        
        doc.text(col1_start,personalData_start+20, "Emso:"); doc.text(col1_text,personalData_start+20, this.displayField(apl.emso));
        doc.text(col2_start,personalData_start+20, "Spol:"); doc.text(col2_text,personalData_start+20, this.displayField(this.translate_gender(apl.gender)));
        
        doc.text(col1_start,personalData_start+30, "Datum rojstva:"); doc.text(col1_text,personalData_start+30, String(date_of_birth));
        doc.text(col2_start,personalData_start+30, "Država rojstva:"); doc.text(col2_text,personalData_start+30, "Slovenija");
        
        doc.text(col1_start,personalData_start+40, "Kraj rojstva:"); doc.text(col1_text,personalData_start+40,"Jazne");
        doc.text(col2_start,personalData_start+40, "Državljanstvo:"); doc.text(col2_text,personalData_start+40,"Novak");
        
        doc.text(col1_start,personalData_start+50, "Kontaktni telefon:"); doc.text(col1_text,personalData_start+50,"Jazne");
        doc.text(col2_start,personalData_start+50, "Email:"); doc.text(col2_text,personalData_start+50,"Novak");
        
    
        // NASLOV STLANEGA PREBIVALIŠČA
        const permanentAddr_start = personalData_start+70;
        doc.text(section_start, permanentAddr_start, "STALNI NASLOV");
        doc.line(line_start,permanentAddr_start+2,line_end,permanentAddr_start+2);

        doc.text(col1_start, permanentAddr_start+10, "Naslov: "); doc.text(col1_text, permanentAddr_start+10, this.displayField(apl.permanent_address));

        doc.text(col1_start, permanentAddr_start+20, "Kraj: "); doc.text(col1_text, permanentAddr_start+20, this.displayField(apl.permanent_country_id));
        doc.text(col2_start, permanentAddr_start+20, "Država: "); doc.text(col2_text, permanentAddr_start+20, this.displayField(apl.permanent_applications_cities_id));

        // NASLOV STLANEGA PREBIVALIŠČA
        const mailingAddr_start = permanentAddr_start+40;
        doc.text(section_start, mailingAddr_start, "NASLOV ZA POŠILJANJE");
        doc.line(line_start,mailingAddr_start+2,line_end,mailingAddr_start+2);

        doc.text(col1_start, mailingAddr_start+10, "Naslov: "); doc.text(col1_text, mailingAddr_start+10, this.displayField(apl.mailing_address));

        doc.text(col1_start, mailingAddr_start+20, "Kraj: "); doc.text(col1_text, mailingAddr_start+20, this.displayField(apl.mailing_country_id));
        doc.text(col2_start, mailingAddr_start+20, "Država: "); doc.text(col2_text, mailingAddr_start+20, this.displayField(apl.mailing_applications_cities_id));        
        
        // DOSEDANJA IZOBRAZBA
        const education_start = mailingAddr_start+40;
        doc.text(section_start, education_start, "DOSEDANJA IZOBRAZBA");
        doc.line(line_start,education_start+2,line_end,education_start+2);

        doc.text(col1_start, education_start+10, "Najvisja dosezena izobrazba"); doc.text(col2_start, education_start+10, this.displayField(apl.education_type_id));

        doc.text(col1_start, education_start+20, "Srednješolska izobrazba"); 
        
        doc.text(col1_start, education_start+30, "Srednja šola: ");  doc.text(col1_text, education_start+30, this.displayField(apl.middle_school_id));
        doc.text(col2_start, education_start+30, "Nacin zakljucka: ");  doc.text(col2_text, education_start+30, this.displayField(apl.graduation_type_id));
        
        //doc.text(col1_start, education_start+40, "Država: ");  doc.text(col1_text, education_start+30, this.displayField(apl.middle_school_country));
        
        doc.addPage();
        page_count++;
        const wishes_start = 10;//education_start+50;
        doc.text(section_start, wishes_start, "V SKLADU Z RAZPISOM SE PRIJAVLJAM ZA ŠTUDIJ");
        doc.line(line_start,wishes_start+2,line_end,wishes_start+2);

        let wp = wishes_start+10;
        // Fill the wishes
        for(let i in apl.wishes) {
          let w = apl.wishes[i];

          doc.text(col1_start-10, wp, (parseInt(i)+1)+". želja"); wp +=10;
          doc.text(col1_start, wp, "Visokošolski zavod: "); doc.text(col1_text, wp, this.displayField(w.faculty_id));
          wp += 10;

          
          doc.text(col1_start, wp, "Študijski program: "); doc.text(col1_text, wp, this.displayField(w.programs_id[0]));
          wp += 10;

          if(w.programs_id.length > 1) {
            doc.text(col1_start, wp, "Študijski program: "); doc.text(col1_text, wp, this.displayField(w.programs_id[1]));
            wp += 10;
          }
          doc.line(line_start+10,wp+2,line_end-10,wp+2);
        }

        doc.text(section_start, wp+50, "Datum: "); doc.text(col2_text, wp+50, "Podpis: ")

        doc.setFontSize(10);
        //footer (oštevilčenje strani)
        for(var i = 1; i <= page_count; i++){
          doc.setPage(i).text(180, 277, "Stran "+ i +"/"+ page_count);
        }

        doc.output("datauri");

      }
    },
    created() {

      console.log(this.$parent);

      this.$http.get('/api/applications/active')
        .then(function(res){

          let application = res.data.data;
          console.log(application);
          if("id" in application){
            console.log("HAS ACTIVE")
            this.hasApplication = true;
          }else{
            console.log("no active application");

          }
          this.apl = application;
          this.$root.studentApplication = application;
          

        }, function(err) {
          //this.applicationPdf(this.mock_apl);
        });


    },
    mounted() {
      console.log('Student dashboard mounted.');
      //this.$router.push('404');
      //console.log("should redirect")
    }
  }
</script>
