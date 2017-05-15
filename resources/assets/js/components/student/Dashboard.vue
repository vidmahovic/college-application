<template>
  <div class="row">
      <div class="col-md-10 col-md-offset-1">
          <div class="panel panel-default">
            <div v-if="doRender" class="panel-body" >
              <div v-if="hasApplication">
              <h2>Imate aktivno vpisnico</h2>

                <div v-if="apl.status=='filed'" v-on:click="remove_application" class="btn btn-default">
                  Izbrisi oddano vpisnico
                </div>
                <div v-else="application.status=='created'" v-on:click="goto_application" class="btn btn-default">
                  Nadaljuj s prijavo
                </div>
                <div class="btn btn-primary pull-right" v-on:click="applicationPdf">Preglej</div>
              </div>
              <div v-else>
                <h2>Nimate aktivne vpisnice</h2>
                <span class="btn btn-default" v-on:click="goto_application">Začni vpisom</span>
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
          doRender: false,
          hasApplication: false
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
      remove_application: function() {
        this.$http.delete('/api/applications/'+this.apl.id)
        .then(function(res){

          this.hasApplication = false;
          this.$http.get('/api/applications/active')
          .then(function(res){
            this.apl = res.data.data;
          });

        }, function(err) {
          console.log(err);
        });
      },
      displayField: function(value) {

        if(value == null || value==='undefined') return '/';

        return String(value).replace("Č", "C");;

      },
      applicationPdf: function() {

        let apl = this.originalApplication;
        var doc = new jsPDF();

        //210 je visina, 297mm sirina
        doc.setLineWidth(0.1);
        doc.setFont("sans-serif");

        doc.setTextColor(99, 107, 111);
        doc.setFontSize(20);
        doc.text(100, 20, "Vpisnica", null, null, "center");
        //table header

        doc.setFontSize(11);
        doc.text(20,30, "RAZPIS ZA VPIS NA DODIPLOMSKE IN ENOVITE MAGISTRSKE ŠTUDIJSKE PROGRAME ")
        doc.text(20,40, "v študijskem letu 2017/2018");
        // - Univerza v Ljubljani, Univerza v Mariboru, Univerza na Primorskem, Univerza v Novi Gorici, javni in koncesionirani samostojni visokošolski
         // zavodi
        doc.text(20, 50, "Prijavni rok: Prvi prijavni rok");
        doc.text(20, 60, "Vpis v 1. letnik");

        const col1_start = 10,
          col1_text = 50,
          col2_start = 100,
          col2_text = 140,
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

        doc.text(col1_start,personalData_start+10, "Ime in Priimek:"); doc.text(col1_text,personalData_start+10, this.displayField(apl.applicant.data.name));
        //doc.text(100,50, "Priimek:"); doc.text(150,50,"Novak");

        doc.text(col1_start,personalData_start+20, "Emso:"); doc.text(col1_text,personalData_start+20, this.displayField(apl.emso));
        doc.text(col2_start,personalData_start+20, "Spol:"); doc.text(col2_text,personalData_start+20, this.displayField(this.translate_gender(apl.gender)));

        doc.text(col1_start,personalData_start+30, "Datum rojstva:"); doc.text(col1_text,personalData_start+30, String(date_of_birth));
        doc.text(col2_start,personalData_start+30, "Država rojstva:"); doc.text(col2_text,personalData_start+30, this.displayField(apl.birthCountry.name));

        doc.text(col1_start,personalData_start+40, "Kraj rojstva:"); doc.text(col1_text,personalData_start+40, this.displayField(apl.birthAddress.name));
        doc.text(col1_start,personalData_start+50, "Državljanstvo:"); doc.text(col1_text,personalData_start+50,this.displayField(apl.citizen.data.name));

        doc.text(col1_start,personalData_start+60, "Kontaktni telefon:"); doc.text(col1_text,personalData_start+60, this.displayField(apl.phone));
        doc.text(col2_start,personalData_start+60, "Email:"); doc.text(col2_text,personalData_start+60,this.displayField(apl.applicant.data.email));


        // NASLOV STLANEGA PREBIVALIŠČA
        const permanentAddr_start = personalData_start+70;
        doc.text(section_start, permanentAddr_start, "STALNI NASLOV");
        doc.line(line_start,permanentAddr_start+2,line_end,permanentAddr_start+2);


        doc.text(col1_start, permanentAddr_start+10, "Naslov: "); doc.text(col1_text, permanentAddr_start+10, this.displayField(apl.permanentAddress.name));

        doc.text(col1_start, permanentAddr_start+20, "Kraj: "); doc.text(col1_text, permanentAddr_start+20, this.displayField(apl.permanentAddress.name));
        doc.text(col2_start, permanentAddr_start+20, "Država: "); doc.text(col2_start+20, permanentAddr_start+20, this.displayField(apl.permanentCountry.name));

        // NASLOV STLANEGA PREBIVALIŠČA
        const mailingAddr_start = permanentAddr_start+40;
        doc.text(section_start, mailingAddr_start, "NASLOV ZA POŠILJANJE");
        doc.line(line_start,mailingAddr_start+2,line_end,mailingAddr_start+2);

        doc.text(col1_start, mailingAddr_start+10, "Naslov: "); doc.text(col1_text, mailingAddr_start+10, this.displayField(apl.mailingAddress.meta.address));

        doc.text(col1_start, mailingAddr_start+20, "Kraj: "); doc.text(col1_text, mailingAddr_start+20, this.displayField(apl.mailingAddress.data.name));
        doc.text(col2_start, mailingAddr_start+20, "Država: "); doc.text(col2_start+20, mailingAddr_start+20, this.displayField(apl.mailingCountry.data.name));

        // DOSEDANJA IZOBRAZBA
        const education_start = mailingAddr_start+40;
        doc.text(section_start, education_start, "DOSEDANJA IZOBRAZBA");
        doc.line(line_start,education_start+2,line_end,education_start+2);

        doc.text(col1_start, education_start+10, "Najvisja dosezena izobrazba"); doc.text(col2_start, education_start+10, this.displayField(apl.education.data.name));


        doc.text(col1_start, education_start+20, "Srednješolska izobrazba");

        doc.text(col1_start, education_start+30, "Srednja šola: ");  doc.text(col1_text, education_start+30, this.displayField(apl.middleSchool.data.name));
        doc.text(col1_start, education_start+40, "Nacin zakljucka: ");  doc.text(col1_text, education_start+40, this.displayField(apl.graduation.data.name));

        //doc.text(col1_start, education_start+40, "Država: ");  doc.text(col1_text, education_start+30, this.displayField(apl.middle_school_country));

        doc.addPage();
        page_count++;
        const wishes_start = 10;//education_start+50;
        doc.text(section_start, wishes_start, "V SKLADU Z RAZPISOM SE PRIJAVLJAM ZA ŠTUDIJ");
        doc.line(line_start,wishes_start+2,line_end,wishes_start+2);

        let wp = wishes_start+10;

        //handle wishes from active application
        let wishes = [];
        for(let w of ["firstWish","secondWish","thirdWish"]){
          if(w in apl) {

            let faculty = apl[w].data[0].faculty;
            let programs = [];
            for(let i in apl[w].data) {
              let nacin = "(redni)"
              if(!apl[w].data[i].is_regular) nacin="(izredni)"
              programs.push(apl[w].data[i].name+" "+nacin);
            }

            wishes.push({
              'faculty': faculty,
              'programs': programs
            });
          }
        }

        // Fill the wishes
        for(let i in wishes) {
          let w = wishes[i];

          doc.text(col1_start-5, wp, (parseInt(i)+1)+". želja"); wp +=10;
          doc.text(col1_start, wp, "Visokošolski zavod: "); doc.text(col1_text, wp, this.displayField(w.faculty.data.name));
          wp += 10;

          doc.text(col1_start, wp, "Študijski program: "); doc.text(col1_text, wp, this.displayField(w.programs[0]));
          wp += 10;

          if(w.programs.length > 1) {
            doc.text(col1_start, wp, "Študijski program: "); doc.text(col1_text, wp, this.displayField(w.programs[1]));
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

      },
      transformActiveApplication: function(apl) {

        let application = JSON.parse(JSON.stringify(apl));


        application['user'] = apl.applicant; //.data;

        let g = {};
        if (apl.gender==="male") g = {label: 'Moški', value: 'male'};
        else g = {label: 'Ženska', value: 'female'};
        application['country_id'] = apl.birthCountry;
        application['district_id'] = apl.birthAddress;
        application['gender'] =  g;
        application['citizen_id'] = apl.citizen.data;
        application['education_type_id'] = apl.education.data;
        application['graduation_type_id'] = apl.graduation.data;
        application['profession_id'] = apl.profession.data;
        application['middle_school_id'] = apl.middleSchool.data;

        application['permanent_address'] = apl.permanentAddress.pivot.address;
        application['permanent_applications_cities_id'] = apl.permanentAddress.name;
        application['permanent_country_id'] = apl.permanentCountry;

        application['mailing_address'] = apl.mailingAddress.meta.address;
        application['mailing_applications_cities_id'] = apl.mailingAddress.data.name;
        application['mailing_country_id'] = apl.mailingCountry.data;


        // bad copy of code should be done with for of loop throug ["firstWish","secondWish","thirdWish"]
        let wishes = [];
        if("firstWish" in apl) {
          console.log(apl.firstWish.data)

          let prog1 = apl.firstWish.data[0];
          let prog2 = null;
          if(apl.firstWish.data.length > 1)
            prog2 = apl.firstWish.data[1];

          wishes.push(
            {
              "faculty": apl.firstWish.data[0].faculty.data,
              "program": prog1,
              "program2": prog2,
              "module": null,
              "kraj": null,
              "regular": null,
              "is_double": false,
              "eligable_programs": [],
              "eligable_programs2": []

          });
        }

        if("secondWish" in apl) {

          let prog1 = apl.secondWish.data[0];
          let prog2 = null;
          if(apl.secondWish.data.length > 1)
            prog2 = apl.secondWish.data[1];

          wishes.push(
            {
              "faculty": apl.secondWish.data[0].faculty.data,
              "program": prog1,
              "program2": prog2,
              "module": null,
              "kraj": null,
              "regular": null,
              "is_double": false,
              "eligable_programs": [],
              "eligable_programs2": []

          })
        }

        if("thirdWish" in apl) {

          let prog1 = apl.thirdWish.data[0];
          let prog2 = null;
          if(apl.thirdWish.data.length > 1)
            prog2 = apl.thirdWish.data[1];

          wishes.push(
            {
              "faculty": apl.thirdWish.data[0].faculty.data,
              "program": prog1,
              "program2": prog2,
              "module": null,
              "kraj": null,
              "regular": null,
              "is_double": false,
              "eligable_programs": [],
              "eligable_programs2": []

          })
        }

        application['wishes'] = wishes;
        return application;
      }
    },
    created() {
      this.$http.get('/api/applications/active')
        .then(function(res){

          let application = res.data.data;
          this.originalApplication = application;
          if("id" in application){

            this.hasApplication = true;
            application = this.transformActiveApplication(application);

          }else {
            console.log("no active application");
          }
          this.apl = application;

          this.doRender = true;
          this.$root.studentApplication = application;

        }, function(err) {
          console.log(err);
        });


    },
    mounted() {
      console.log('Student dashboard mounted.');
    }
  }
</script>
