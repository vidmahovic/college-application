<template>
  <div class="row">
      <div class="col-md-10 col-md-offset-1">
          <div class="panel panel-default">
              <!--<div class="panel-heading">Moja prijave</div>-->

              <div class="panel-body" >
                <div v-if="hasApplication">
                <h2>Imate oddano vpisnico</h2>
                <table class="table">
                  <thead>
                    <th>Datum oddaje</th>
                  </thead>
                  <tbody>
                    <tr>
                      <td>datum zacetka</td>
                      <td v-if="application.status=='filled'" v-on:click="goto_application" class="btn btn-default pull-right">
                        Izbrisi in oddaj ponovno
                      </td>
                      <td v-else="application.is_submited" v-on:click="goto_application" class="btn btn-default pull-right">
                        Nadaljuj s prijavo
                      </td>
                      <td class="btn btn-primary pull-right" v-on:click="applicationPdf">Preglej</td>
                 
                    </tr>
                  </tbody>
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
          hasApplication: false
        }    
    },
    methods: {
      goto_application: function(event, application) {
        this.$router.push('application')
      },
      displayField: function(value) {
        if(value == null || value==='undefined') return '/'

        return value;
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

                
        const col1_start = 20,
          col1_text = 60,
          col2_start = 110,
          col2_text = 150,
          section_start=20,
          line_start=8,
          line_end=200;

        // OSEBNI PODATKI
        const personalData_start=70;

        doc.text(section_start, personalData_start, "OSEBNI PODATKI");
        doc.line(line_start,personalData_start+2,line_end,personalData_start+2);

        doc.text(col1_start,personalData_start+10, "Ime in Priimek:"); doc.text(col1_text,personalData_start+10, this.displayField(apl.name));
        //doc.text(100,50, "Priimek:"); doc.text(150,50,"Novak");
        
        doc.text(col1_start,personalData_start+20, "Emso:"); doc.text(col1_text,personalData_start+20, this.displayField(apl.emso));
        doc.text(col2_start,personalData_start+20, "Spol:"); doc.text(col2_text,personalData_start+20, this.displayField(apl.gender));
        
        doc.text(col1_start,personalData_start+30, "Datum rojstva:"); doc.text(col1_text,personalData_start+30, this.displayField(apl.date_of_birth));
        doc.text(col2_start,personalData_start+30, "Država rojstva:"); doc.text(col2_text,personalData_start+30, "Slovenija");
        
        doc.text(col1_start,personalData_start+40, "Kraj rojstva:"); doc.text(col1_text,personalData_start+40,"Jazne");
        doc.text(col2_start,personalData_start+40, "Državljanstvo:"); doc.text(col2_text,personalData_start+40,"Novak");
        
        doc.text(col1_start,personalData_start+50, "Kontaktni telefon:"); doc.text(col1_text,personalData_start+50,"Jazne");
        doc.text(col2_start,personalData_start+50, "Email:"); doc.text(col2_text,personalData_start+50,"Novak");
        
    
        // NASLOV STLANEGA PREBIVALIŠČA
        const permanentAddr_start = personalData_start+70;
        doc.text(section_start, permanentAddr_start, "STALNI NASLOV");
        doc.line(line_start,permanentAddr_start+2,line_end,permanentAddr_start+2);


        
        

    
        //footer (oštevilčenje strani)
        for(var i = 1; i <= 1; i++){
          doc.setPage(i).text(277, 207, "Stran "+ i +"/"+ 1);
        }

        doc.output("datauri");

      }
    },
    created() {
      this.$http.get('/api/applications/active')
        .then(function(res){

          let application = res.body.data;
          if("id" in application){

          }else{
            console.log("no active application");

          }
          this.apl = application;
          
        });

    },
    mounted() {
      console.log('Student dashboard mounted.');
      //this.$router.push('404');
      //console.log("should redirect")
    }
  }
</script>
