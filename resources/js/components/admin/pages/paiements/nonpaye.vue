

<template>
   <div class="main-panel">
      <div v-if="$can('Consulter la liste des crédits')" class="content-wrapper">
         <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
               <div class="card">
                  <div ref="formContainer" class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                           <h1 class="card-title">
                              <i class="mdi-style-content mdi  mdi-cash"></i>
                              <span class="titre">Les crédits des  abonnements non payé </span>
                           </h1>
                           <br><br>
                        </div>
                        <div class="col-md-4">
                           <p class="text-right">
                              <b> {{count_abonnements}} Abonnements</b>
                           </p>
                        </div>
                     </div>
                    <div class="row">
                        <div class="col-md-12">
                           <form @submit.prevent="filtrer($event)" class="forms-sample">
                              <div class="row">
                                 <div class="col-md-6">
                                    <div class="form-group mr-b-0em">
                                       <label class="form__label">Nom et prénom</label>
                                       <input v-model="data_filtrer.nom" placeholder="Nom et prénom" class="form-control">
                                    </div>
                                 </div>
                                 <div class="col-md-6">
                                    <div class="form-group mr-b-0em">
                                       <label class="form__label">ID /CIN</label>
                                       <!-- <input v-model="data_filtrer.matricule" placeholder="ID ou Cin" class="form-control"> -->
                                       <input v-model="data_filtrer.matricule" placeholder="ID ou Cin" class="form-control"> 

                                    </div>
                                 </div>
                                 <div class="col-6">
                                    <div class="form-group mr-b-0em">
                                       <label class="form__label"> {{ $t('content.pages.abonnements.encours.recherche.abonnement') }}</label>
                                       <!--<select class="form-control" v-model="data_filtrer.abonnement">
                                          <option value="tous">Tous</option>
                                          <option v-for="(abonnement, index) in abonnements" :value="abonnement.id"> {{ abonnement.libelle }} </option>
                                          </select>-->
                                       <multiselect v-model="data_filtrer.abonnement" @input="setid_abonnement($event)"  :options="abonnements" :custom-label="libeleAbonnement" placeholder="Recherche.." label="libelle" track-by="libelle"></multiselect>
                                    </div>
                                 </div>
                                 <div class="col-6">
                                    <div class="form-group mr-b-0em">
                                       <label class="form__label"> {{ $t('content.pages.abonnements.encours.recherche.pack') }}</label>
                                       <!--<select class="form-control" v-model="data_filtrer.pack">
                                          <option value="tous">Tous</option>
                                          <option v-for="(pack, index) in packs" :value="pack.id">
                                              {{ pack.description }} ( <span v-for="(acts) in pack.activities"> {{ acts.name }} </span> )
                                          </option>
                                          </select>-->
                                       <multiselect v-model="data_filtrer.pack" :options="packs" :custom-label="libelePack" placeholder="Recherche.." label="description" track-by="description"></multiselect>
                                    </div>
                                 </div>
                                 <div class="col-12">
                                    <div class="form-group mr-b-0em">
                                       <label title="Date d'écheance" class="form__label"> Date du au</label> <br>
                                       <!--<date-picker style="width: 100%;"  v-model="data_filtrer.date_echeance" type="date" format="DD/MM/YYYY"></date-picker>-->
                                       <date-picker style="width: 100%;" :show-time-panel="showTimeRangePanel" @close="handleRangeClose" v-model="datetimePicker" range type="datetime" format="DD/MM/YYYY"></date-picker>
                                    </div>
                                 </div>
                                 <div class="col-6 text-left">
                                    <button type="button"  @click="clearDataInputs" class="btn btn-primary mr-2">{{$t('content.text.select_tout')}}</button>
                                 </div>
                                 <div class="col-6 text-right">
                                    <button type="submit" class="btn btn-success mr-2"> <i class="mdi mdi-magnify"></i> {{ $t('content.bouton.recherche') }}</button>
                                    <a  @click="clearDataInputs" href="javascript:void(0)" class="btn btn-light">{{ $t('content.bouton.annuler') }}</a>
                                 </div>
                              </div>
                           </form>
                        </div>
                    </div>
                    <div class="row mt-5">
                        <div class="col-md-4 grid-margin stretch-card">
                           <div class="border-none  bg-primary text-black ">
                              <div class="card-body ">
                                 <div class="d-flex justify-content-between">
                                    <h4 class="card-title mb-0">
                                        Total net à payer
                                    </h4>
                                    <p class="font-weight-semibold mb-0"></p>
                                 </div>
                                 <h3 class="font-weight-medium"> 
                                    {{montantTotalNetPayer}} {{$t('content.text.dh')}}
                                 </h3>
                              </div>
                           </div>
                        </div>
                        <div class="col-md-4 grid-margin stretch-card">
                           <div class="border-none  bg-success text-black ">
                              <div class="card-body ">
                                 <div class="d-flex justify-content-between">
                                    <h4 class="card-title mb-0">
                                        Total payé
                                    </h4>
                                    <p class="font-weight-semibold mb-0"></p>
                                 </div>
                                 <h3 class="font-weight-medium"> 
                                    {{montantTotal_Paye}} {{$t('content.text.dh')}}
                                 </h3>
                              </div>
                           </div>
                        </div>
                        <div class="col-md-4 grid-margin stretch-card">
                           <div class="border-none  bg-danger text-black ">
                              <div class="card-body ">
                                 <div class="d-flex justify-content-between">
                                    <h4 class="card-title mb-0">
                                       Total restant à payer
                                    </h4>
                                    <p class="font-weight-semibold mb-0"></p>
                                 </div>
                                 <h3 class="font-weight-medium"> 
                                    {{ parseFloat(montantTotalNetPayer - montantTotal_Paye).toFixed(2)}} {{$t('content.text.dh')}}
                                 </h3>
                              </div>
                           </div>
                        </div>
                    </div>
                     <div class="row">
                        <div v-if="abonnements_non_paye.length > 0" class="mt-4 col-md-12">
                           <div style="overflow-x:auto;" id="packs" class="tab-pane fade in active show">
                              <table id="data-packs" class="datatables table table-striped table-bordered table-hover">
                                 <thead class="thead-dark">
                                    <tr>
                                       <th>ID</th>
                                       <th>Nom et prénom</th>
                                       <th>Abonnement & Pack</th>
                                       <th>Date de fin</th>
                                       <th>Frais</th>
                                       <th>Net à payer</th>
                                       <th>Total payé </th>
                                       <th>Reste à payer </th>
                                        <th>Régler</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                    <tr v-for="(abonner, index) in abonnements_non_paye">
                                       <td>
                                          <router-link v-if="$can('Consulter la fiche d\'adhérent')" :to="{name: 'adherent', params:{code: abonner.id_empreinte }}">
                                             <a> {{ abonner.id_empreinte }} </a>
                                          </router-link>
                                          <span v-else>{{ abonner.id_empreinte }}</span>
                                       </td>
                                       <td>
                                          {{ abonner.nom }}
                                       </td>
                                       <td>
                                          <b>{{ abonner.libelle }}</b><br>
                                          <span> {{ abonner.description }}</span>
                                       </td>
                                       <td>
                                          {{ abonner.date_fin | formatDate }} 
                                       </td>
                                       <td> 
                                             {{ abonner.total_frais  }} {{$t('content.text.dh')}}
                                       </td>
                                       <td>
                                          {{ abonner.prix_ttc }} {{$t('content.text.dh')}}
                                       </td>
                                       <td>
                                          {{ abonner.sums }} {{$t('content.text.dh')}}
                                       </td>
                                       <td>
                                          {{ abonner.prix_ttc - abonner.sums }} {{$t('content.text.dh')}}
                                       </td>
                                       
                                       <td>
                                           <router-link v-if="$can('Régler les impayés')"    :to="{name: 'impayes', query : { adherent : `${abonner.code_client}`, id_abonnement :  `${abonner.id}` }}" class="btn btn-success mr-2">
                                             <i class="mdi mdi-cash-multiple"></i>  Régler
                                           </router-link> 

                                          <span title="Rappel de paiement" class="btn btn-success" @click="RappelPaiement(abonner)" > <i class=" mdi mdi-send"></i> Rappel</span>
                                             




                                       </td>
                                    </tr>
                                 </tbody>
                              </table>
                           </div>
                           <vue-pagination :pagination="pagination" @paginate="ListAbonnementsNonPaye(data_filtrer)" :offset="4"></vue-pagination>
                        </div>
                        <div v-else class="aucune col-md-12">
                           <i class="mdi-style mdi mdi-alert"></i> {{$t('content.alerts.aucune_info')}}
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div v-else class="content-wrapper">
         <havent-permission></havent-permission>
      </div>
   </div>
</template>
<script>
   //import {en, fr, ar} from 'vuejs-datepicker/dist/locale'
   import 'vue2-datepicker/index.css';
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
               data_filtrer: {
                   abonnement : [],
                   pack : [],
                   nom : '',
                   matricule : '',
                   id_empreinte:'',
                   date_echeance : []
                },
               abonnements_non_paye: [],
               abonnements_non_paye_dash : [],
               pagination: [],
               packs: [],
               List_Packs: [],
               abonnements: [],
               search_adherent: '',
               formData: {},
               count_abonnements :  0,
               montantTotalNetPayer : 0,
               montantTotal_Paye : 0,
           }
       },
       mounted() {
           console.log('Component mounted.')
       },
       methods: {
         setid_abonnement(value) { 
            let self = this
            this.packs = []
            this.packs =  this.List_Packs.filter( function(pack) { 
                return pack.id_abonnement == value.id 
            } )
         },
           libeleAbonnement({ nb_mois, libelle }) {
               return `${libelle} ( ${nb_mois} Mois )`
           },
           libelePack({ description, prix, activities }) {
               var all_activities = ''
               for (var i = 0; i < activities.length; i++)
                   all_activities = activities[i].name + ', ' + all_activities
               return `${description} ( ${all_activities.replace(/,(?=\s*$)/, '')} )`
           },
           ListPacks() {
               axios.get('/api-admin/parametrages/packs').then((response) => {
                   this.List_Packs = response.data;
   
               });
           },
           ListTypeAbonnements() {
               axios.get('/api-admin/parametrages/abonnements').then((response) => {
                   console.log("data : " )
                                    console.log(response.data)
                   this.abonnements = response.data;
   
               });
           },
           RappelPaiement(abonner){ 
            if(abonner.email != '' && abonner.email != null) {
                this.$fire(this.AlertFire('envoi_mail')).then((result) => {
                    if (result.value) 
                        window.location.href = "/api-admin/rappel-de-paiement/"+abonner.id
                });
            }else{
                this.AlertResponseFalse("", "L'e-mail est vide", "warning");
            }

        },
           ListAbonnementsNonPaye(data_filtrer) {
               if (typeof this.$refs.formContainer !== "undefined")  
                   this.PluginLoader(false, this.$refs.formContainer)
               const current_page = (this.pagination.current_page) ? this.pagination.current_page : 1;
               this.formData = new FormData();
               if (this.data_filtrer.nom != '')
                   this.formData.append("filtrer[nom]", this.data_filtrer.nom);
   
                

               if(this.data_filtrer.matricule != null && this.data_filtrer.matricule != '') { 
                   console.log("hello")
                   this.$router.push({name: 'abonnements_non_paye', query: {adherent : this.data_filtrer.matricule } })
                      this.formData.append("filtrer[matricule]", this.data_filtrer.matricule);
               }
               if( this.$route.query.adherent && this.$route.query.adherent != ''){
                   console.log("hello")
                       this.data_filtrer.matricule  =  this.$route.query.adherent
                       this.formData.append("filtrer[matricule]",  this.$route.query.adherent);
               } 



              /* if (this.data_filtrer.matricule != '')
                   this.formData.append("filtrer[matricule]", this.data_filtrer.matricule);
   
               if (this.$route.query.adherent) {
                   this.data_filtrer.matricule = this.$route.query.adherent
                   this.formData.append("filtrer[matricule]", this.$route.query.adherent); 
               }*/
   
                if (this.data_filtrer.abonnement.length !== 0) {
                   console.log('test')
                   this.formData.append("filtrer[abonnement_id]", this.data_filtrer.abonnement.id);
               }
               if (this.data_filtrer.pack.length !== 0)
                   this.formData.append("filtrer[pack_id]", this.data_filtrer.pack.id);
   
               /*if (this.data_filtrer.date_echeance  !=null )
                   this.formData.append("filtrer[date_echeance]", this.data_filtrer.date_echeance.toDateString());
                   */
   
               if (this.datetimePicker[0] != null && this.datetimePicker[1]) {
                   const date = this.datetimePicker; 
                   this.data_filtrer.date_echeance = [date[0].toDateString(), date[1].toDateString()]
                   this.formData.append("filtrer[date][from]", this.data_filtrer.date_echeance[0]);
                   this.formData.append("filtrer[date][to]", this.data_filtrer.date_echeance[1]);
               }
   
               //console.log(this.data_filtrer.date_echeance.toDateString())
   
               const config = { headers: { 'content-type': 'multipart/form-data' } }
               axios.post('/api-admin/list-abonnements-non-paye?page=' + current_page, this.formData, config).then((response) => {
                   console.log( response.data)
                   this.count_abonnements = response.data.abonnements_non_paye.total;
                   this.abonnements_non_paye = response.data.abonnements_non_paye.data;
                   this.abonnements_non_paye_dash = response.data.abonnements_non_paye_dash;
                   this.pagination = response.data.abonnements_non_paye;
   
                   this.montantTotalNetPayer = parseFloat(this.abonnements_non_paye_dash.reduce((n, {prix_ttc}) => n + parseFloat(prix_ttc)  , 0) ).toFixed(2);
   
                   this.montantTotal_Paye = parseFloat(this.abonnements_non_paye_dash.reduce((n, {sums}) => n +  parseFloat(sums)  , 0)).toFixed(2);
   
                   console.log('montantTotalNetPayer est : ' + this.montantTotalNetPayer)
                   console.log('montantTotal_Paye est : ' + this.montantTotal_Paye)
   
                });
           },  
           filtrer(event) { 
               this.pagination = []
               this.ListAbonnementsNonPaye(this.data_filtrer)
           },
   
           clearDataInputs(){ 
                this.data_filtrer.nom = ''
               this.data_filtrer.matricule = ''
               this.data_filtrer.id_empreinte = ''
               this.data_filtrer.abonnement = []
               this.data_filtrer.pack = []
               this.datetimePicker = [null, null]
               this.ListAbonnementsNonPaye(this.data_filtrer)
            },
            handleRangeClose() {
               this.showTimeRangePanel = false;
           },
           handleRangeClose() {
               this.showTimeRangePanel = false;
           }, 
       },
       beforeMount() {
         if (this.$can('Consulter la liste des crédits')) {
               this.ListTypeAbonnements();
              this.ListPacks();
              this.filtrer(); 
         }
   
       },
       computed: { 
       }
   }
   
</script>
<style>
   .nav.nav-tabs li {
   margin-left: 8px;
   position: relative;
   margin-bottom: 15px;
   }
   .nav.nav-tabs li a {
   text-decoration: none;
   }
   .nav.nav-tabs li a.active:after {
   content: '';
   width: 100%;
   position: absolute;
   height: 2px;
   background: #000;
   }
   .number {
   width: 33.333333% !important;
   display: inline-block;
   margin-bottom: 15px;
   }
   .resActive {
   background-color: #00b000;
   color: #fff;
   }
   .line {
   margin-bottom: 5px;
   text-align: center;
   counter-increment: line;
   position: relative;
   padding-left: 40px;
   padding-right: 40px;
   }
   .line div {
   border: 1px solid #ccc;
   }
   .line div:before {
   content: counter(line);
   position: absolute;
   left: 6px;
   top: 0px;
   background: #000;
   color: #fff;
   width: 35px;
   height: 51px;
   display: flex;
   justify-content: center;
   align-items: center;
   }
   .line button {
   border-radius: 50%;
   width: 40px;
   height: 40px;
   margin: 4px;
   border: none;
   outline: none;
   }
</style>

