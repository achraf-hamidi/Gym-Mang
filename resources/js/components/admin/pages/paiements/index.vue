<template>
    <div class="main-panel">
          <div class="content-wrapper">
              <div class="row"> 
                <div class="col-md-4 grid-margin stretch-card">
                  <div class="card bg-primary text-black ">
                    <div class="card-body pb-0">
                      <div class="d-flex justify-content-between">
                        <h4 class="card-title mb-0">{{$t('content.pages.adherents.profile.revenu.topaid')}}</h4>
                        <p class="font-weight-semibold mb-0"></p>
                      </div>
                      <h3 class="font-weight-medium"> {{ TotalPaiements.toFixed(2)}} {{$t('content.text.dh')}}</h3>
                    </div>
                  </div>
                </div>
                <div class="col-md-4 grid-margin stretch-card ">
                  <div class="card bg-success text-black">
                    <div class="card-body pb-0">
                      <div class="d-flex justify-content-between">
                        <h4 class="card-title mb-0">{{$t('content.pages.adherents.profile.revenu.amount')}}</h4>
                        <p class="font-weight-semibold mb-0"> </p>
                      </div>
                      <h3 class="font-weight-medium mb-4"> {{total.toFixed(2)}} {{$t('content.text.dh')}}</h3>
                    </div>
                  </div>
                </div>
                <div class="col-md-4 grid-margin stretch-card">
                  <div class="card bg-danger text-white ">
                    <div class="card-body pb-0">
                      <div class="d-flex justify-content-between">
                        <h4 class="card-title mb-0">{{$t('content.pages.adherents.profile.revenu.rest')}}</h4>
                        <p class="font-weight-semibold mb-0"></p>
                      </div>
                      <h3 class="font-weight-medium">{{TotalPaiements.toFixed(2) - total.toFixed(2)}} {{$t('content.text.dh')}}</h3>
                    </div>
                  </div>
                </div> 
            </div>
            <div class="row">
               <div class="col-md-12 grid-margin stretch-card">
                  <div class="card">
                    <div class="card-body">
                      <h4 class="card-title">Recherche</h4>
                        <form @submit.prevent="filtrer($event)" class="forms-sample">
                            <div class="row"> 
                                <div class="col-6">
                                    <div class="form-group mr-b-0em" >
                                      <label class="form__label"> Adhérents</label>
                                      <select class="form-control"  v-model="data_filtrer.id_adherent" >
                                        <option value="" selected="true" >Tous</option>
                                        <option v-for="(adherent, index) in list_adherents" :value="adherent.id"> {{ adherent.nom }} </option>
                                      </select>
                                     </div>
                                </div> 
                                <div class="col-6">
                                  <div class="form-group mr-b-0em" >
                                      <label class="form__label">Date de à</label> <br>
                                      <date-picker style="width: 100%;" :show-time-panel="showTimeRangePanel" @close="handleRangeClose"  v-model="datetimePicker" range type="datetime" format="YYYY-MM-DD" ></date-picker>
                                  </div>
                                </div>
                                <div class="col-6">
                                    <button type="submit" class="btn btn-success mr-2">Filtrer</button>
                                    <button class="btn btn-light">{{ $t('content.bouton.annuler') }}</button>
                                </div>
                            </div>
                        </form>
                      </div>
                    </div>
                  </div>



            </div>
            <div class="row">
                <div class="col-lg-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                          <h4 class="card-title">Liste des paiements</h4>
                          <div class="">
                                <br><br> 
                                <table style="background : none !important; border : none !important; " id="data-packs" class="datatables table table-striped table-bordered table-hover">
                                  <thead class="thead-dark">
                                    <tr>
                                      <th>Code client</th>
                                      <th>Nom</th>
                                      <th>Date de paiement</th>
                                      <th>Montant payé</th>
                                    </tr>
                                  </thead>
                                  <tbody v-for="(abonner, index) in list_abonners">
                                    <tr v-for="(paiement, index) in abonner.paiements">
                                      <td> {{  abonner.adherent.code_client }} </td>
                                      <td> {{  abonner.adherent.nom }} </td>
                                      <td> {{  paiement.date_paiement }} </td>
                                      <td> {{  (paiement.prix).toFixed(2)}} {{$t('content.text.dh')}}</td>
                                    </tr>
                                  </tbody> 
                                </table>
                        </div>
                        

                        </div>
                    </div>
                </div>                    
            </div>
          </div>
      </div>
</template>

<script>

    export default {
        data() {
            return {
               lang: {
                  formatLocale: {
                    firstDayOfWeek: 1,
                  },
                  monthBeforeYear: false,
                },
                datetimePicker: [null, null],
                showTimeRangePanel: false,
                data_filtrer : {
                     id_adherent : null,
                    datetimes : [],
                },
                pagination : [],
                list_abonners : [],
                list_adherents : [],
                search :'',
                saveIndex : -1,
             }
        },
        mounted() {
            console.log('Component mounted.')
        },
        methods : {
            listAbonners(){
               //const current_page = (this.pagination.current_page) ? this.pagination.current_page :  1 ;
                this.formData = new FormData(); 
                 
                if (this.data_filtrer.id_adherent != null) 
                    this.formData.append("filtrer[id_adherent]", this.data_filtrer.id_adherent);

                if (this.datetimePicker[0] != null && this.datetimePicker[1]) {
                   const date = this.datetimePicker;
                   this.data_filtrer.datetimes = [ date[0].toLocaleDateString() , date[1].toLocaleDateString()]
                   this.formData.append("filtrer[date]", this.data_filtrer.datetimes);
                }
                const config  = {  headers: { 'content-type': 'multipart/form-data' }   }
                axios.post('/api-admin/list-paiements', this.formData, config ).then((response)=>{  
                    this.list_abonners = response.data ; //.data;
                   // this.pagination = response.data;
                   console.log(response.data)
                });
            },
            filtrer(event){
               // this.pagination = []
                this.listAbonners(this.data_filtrer) 
            } , 
            handleRangeClose() {
              this.showTimeRangePanel = false;
            },
             ListAdherents() {
             axios.get('/api-admin/list-adherents-has-paiements' ).then((response)=>{  
                    this.list_adherents = response.data;
                    
                });
            },
		    },
        beforeMount(){ 
            this.listAbonners();
            this.ListAdherents()
        },
        computed: {
          total () {
             return this.list_abonners.reduce( (acc, abonner) => { 
                return abonner.paiements.reduce( (accs, crypts) => { 
                    acc = parseFloat(acc) + parseFloat(crypts.prix)
                    return acc
                 }, 0)
             }, 0)
          },
          TotalPaiements () {
            return this.list_abonners.reduce( (acc, abonner) => {
                const promo = (abonner.promotion) ? abonner.promotion.remise : 0 ;
                if (this.data_filtrer.id_adherent != null && this.data_filtrer.id_adherent != "") {
                  return parseFloat(( (abonner.packs[0].prix  ) - ( abonner.remise + promo )));
                  //return parseFloat(( (abonner.packs[0].prix * abonner.abonnements[0].nb_mois ) - ( abonner.remise + promo )));
                }else {
                  return parseFloat(acc + ( (abonner.packs[0].prix  ) - ( abonner.remise + promo )));
                  //return parseFloat(acc + ( (abonner.packs[0].prix * abonner.abonnements[0].nb_mois ) - ( abonner.remise + promo )));
                }
            }, 0)
          }
        },
        created: function () {
          /*this.eventHub.$on('update', data => {
              if (data.type == 'sortier') {
                for (var i = 0 ; i < this.list_abonners.length ; i++) {
                    if (this.list_abonners[i].date_entrer == data.presence.date_entrer && this.list_abonners[i].date_sortier == null ) {
                          this.saveIndex = i ;
                    }              
                }
                if (this.saveIndex != -1) {
                     this.list_abonners[this.saveIndex].date_sortier = data.presence.date_sortier;
                } 
              }else {
                this.list_abonners.unshift(data.presence)
              }
           })*/
        },


    }
</script> 

<style>

.nav.nav-tabs li {
    margin-left : 8px;
    position : relative;
    margin-bottom : 15px;
}
.nav.nav-tabs li a {
    text-decoration : none;
}


.nav.nav-tabs li a.active:after { 
content: '';
width: 100%;
position: absolute;
height: 2px;
background: #000;
}

</style>

