

<template>
   <div class="main-panel">
      <div v-if="$can('Consulter la liste des recettes')" class="content-wrapper">
         <div v-if="$can('Ajouter une recette')" class="row">
            <div class="col-md-12 float-right text-right">
               <button @click="ClearInputs" type="button" class="btn btn-primary" data-toggle="modal" data-target=".bd-example-modal-lg"><i class=" mdi mdi-plus"></i>Ajouter une recette</button>
            </div>
         </div>
         <br>
         <div v-if="$can('Ajouter une recette') || $can('Modifier une recette')" class="col-md-12">
            <add-recette  :Categories="Categories"  :ServicesTypeRecette='ServicesTypeRecette' @RefreshListRecettes="RefreshListRecettes($event)"></add-recette>
         </div>
         <!-- Regler -->
        <div v-if="$can('Régler une recette')" class="modal fade regler-recette" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
               <div class="modal-content">
                  <div class="card-header ">
                     <div class="row">
                        <div class="col-md-12">
                           <div class="d-flex justify-content-between">
                              <h3 class="card-title mb-0"> 
                                 Régler
                              </h3>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="modal-body grid-margin modal-utilisateur ">
                     <form-wizard @on-complete="Regler($event)" title="" subtitle="" shape="circle" :back-button-text="$t('content.bouton.prev')" :next-button-text="$t('content.bouton.next')" :finish-button-text="$t('content.bouton.enregistrer')" color="#ff9c00e6">
                        <tab-content :title="$t('content.pages.adherents.add_modale.steps.infos')" icon="far fa-user">
                           <div class="row">
                              <div class="col-12">
                                 <p><b>Information de commande </b></p>
                              </div>
                              <!-- <div class="col-6">
                                 <div class="form-group mr-b-0em" :class="{ 'form-group--error': $v.reglement_recette.matricule.$error }">
                                    <label class="form__label">Matricule / CIN </label>
                                    <input readonly class="form-control" v-model.trim="$v.reglement_recette.matricule.$model" @input="setmatricule($event.target.value)" placeholder="Matricule / CIN" />
                                 </div>
                                 <div v-if="$v.reglement_recette.matricule.$dirty">
                                    <div class="error" v-if="!$v.reglement_recette.matricule.minLength">
                                       Entrer une valeur correct
                                    </div>
                                 </div>
                              </div> -->
                              <div class="col-6">
                                 <div class="form-group mr-b-0em" :class="{ 'form-group--error': $v.reglement_recette.matricule.$error }">
                                    <label class="form__label">ID </label>
                                    <input readonly class="form-control" v-model.trim="$v.reglement_recette.matricule.$model" @input="setmatricule($event.target.value)" placeholder="ID" />
                                 </div>
                                 <div v-if="$v.reglement_recette.matricule.$dirty">
                                    <div class="error" v-if="!$v.reglement_recette.matricule.minLength">
                                       Entrer une valeur correct
                                    </div>
                                 </div>
                              </div>
                              <div class="col-md-6">
                                 <div class="form-group mr-b-0em">
                                    <label class="form__label"> Recettes </label>
                                    <input readonly class="form-control" v-model.trim="$v.reglement_recette.nom_service.$model" @input="setnom_service($event.target.value)" placeholder="" />
                                 </div>
                                 <div v-if="$v.reglement_recette.nom_service.$dirty">
                                    <div class="error" v-if="!$v.reglement_recette.nom_service.required">{{ $t('validation.required', { attribute : 'recettes' }) }}</div>
                                 </div>
                              </div>
                              <div class="col-md-6">
                                 <div class="form-group mr-b-0em" :class="{ 'form-group--error': $v.reglement_recette.montant.$error }">
                                    <label class="form__label">Montant de la recette</label>
                                    <input readonly class="form-control" v-model.trim="$v.reglement_recette.montant.$model" @input="setmontant($event.target.value)" placeholder="Montant de la recette" />
                                 </div>
                                 <div v-if="$v.reglement_recette.montant.$dirty">
                                    <div class="error" v-if="!$v.reglement_recette.montant.required">{{ $t('validation.required', { attribute : 'Montant de la recette' }) }}</div>
                                 </div>
                              </div>
                              <div class="col-md-6">
                                 <div class="form-group mr-b-0em" :class="{ 'form-group--error': $v.reglement_recette.rest_a_paye.$error }">
                                    <label class="form__label">Restant à payer</label>
                                    <input readonly class="form-control" v-model.trim="$v.reglement_recette.rest_a_paye.$model" @input="setrest_a_paye($event.target.value)" placeholder="Montant payé" />
                                 </div>
                                 <div v-if="$v.reglement_recette.montant.$dirty">
                                    <div class="error" v-if="!$v.reglement_recette.montant.decimal">
                                       Entrer une valeur correct
                                    </div>
                                 </div>
                              </div>
                              <div class="col-12">
                                 <p><b>Paiement</b></p>
                              </div>
                              <div class="col-6">
                                 <div class="form-group mr-b-0em" :class="{ 'form-group--error': $v.reglement_recette.montant_paye.$error }">
                                    <label class="form__label">Montant payé</label>
                                    <input class="form-control" v-model.trim="$v.reglement_recette.montant_paye.$model" @input="setmontant_paye($event.target.value)" placeholder="Montant payé" />
                                 </div>
                                 <div v-if="$v.reglement_recette.montant_paye.$dirty">
                                    <div class="error" v-if="!$v.reglement_recette.montant_paye.decimal || !$v.reglement_recette.montant_paye.plusDeZero">
                                       Vérifier le montant payé
                                    </div>
                                    <div class="error" v-if="!$v.reglement_recette.montant_paye.required">
                                       Champs obligatoire
                                    </div>
                                    <div class="error" v-if="!$v.reglement_recette.montant_paye.CheckRest_a_Payer">
                                       Le montant ajouté est supérieur au restant à payer 
                                    </div> 
                                 </div>
                              </div>
                              <div class="col-6">
                                 <div class="form-group mr-b-0em" :class="{ 'form-group--error': $v.reglement_recette.date_paiement.$error }">
                                    <label class="form__label">Date de paiement</label>
                                    <date-picker format="DD/MM/YYYY HH:mm" style="width : 100%;" v-model.trim="$v.reglement_recette.date_paiement.$model" @change="setdate_paiement" type="datetime"></date-picker>
                                 </div>
                                 <div v-if="$v.reglement_recette.date_paiement.$dirty">
                                    <div class="error" v-if="!$v.reglement_recette.date_paiement.required">{{ $t('validation.required', { attribute : 'Date de paiement' }) }}</div>
                                 </div>
                              </div>
                           </div>
                        </tab-content>
                     </form-wizard>
                  </div>
               </div>
            </div>
         </div>
         <!-- end regler -->
         <!-- note -->
         <div v-if="$can('Voir les détails d’une recette')" class="modal fade note-recette" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
               <div class="modal-content">
                  <div class="card-header ">
                     <div class="row">
                        <div class="col-md-12">
                           <div class="d-flex justify-content-between">
                              <h3 class="card-title mb-0"> 
                                 Note
                              </h3>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="modal-body grid-margin modal-utilisateur ">
                     <div v-if="reglement_recette.note != '' && reglement_recette.note != null" >
                        <b>Note : </b>
                        <p>  {{ reglement_recette.note }}  </p>
                     </div>
                     <div v-if="reglement_recette.details_paiement" class="mt-3 responsive-table " >
                        <p>
                           <b>Paiements : </b>
                        </p>
                        <table class="mt-2 datatables table table-striped table-bordered table-hover">
                           <thead>
                              <tr>
                                 <th>Date de paiement</th>
                                 <th>Montant payé</th>
                              </tr>
                           </thead>
                           <tbody>
                              <tr v-for="(paiement, index) in reglement_recette.details_paiement" >
                                 <td>
                                    {{ paiement.date_paiement | formatDateHeur }}
                                 </td>
                                 <td>
                                    {{ paiement.montant_paye }} {{$t('content.text.dh')}}
                                 </td>
                              </tr>
                           </tbody>
                        </table>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <!-- end note -->

         <!-- edit note -->
         <div  v-if="$can('Modifier une recette')" class="modal fade edit-note-recette" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
               <div class="modal-content">
                  <div class="card-header ">
                     <div class="row">
                        <div class="col-md-12">
                           <div class="d-flex justify-content-between">
                              <h3 class="card-title mb-0"> 
                                 Modifier la note 
                              </h3>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="modal-body grid-margin modal-utilisateur ">
                     <div v-if="reglement_recette.old_note != '' && reglement_recette.old_note != null" >
                        <b>Note actuel: </b>
                        <p>  {{ reglement_recette.old_note }}  </p>
                     </div>
                     <div class="row">
                        <div class="col-md-12">
                           <form @submit.prevent="editnote($event)" class="forms-sample">
                              <div class="row">
                                 <div class="col-12">
                                    <div class="form-group mr-b-0em" >
                                        <label class="form__label">Note</label>
                                        <textarea rows="3" class="form-control" v-model.trim="reglement_recette.note" >
                                        </textarea> 
                                    </div> 
                                </div>  
                                 <div class="col-12 text-right">
                                    <button type="submit" class="btn btn-success mr-2">  <i class="mdi mdi-pen"></i> {{ $t('content.bouton.modifier') }}</button>
                                  </div>
                              </div>
                           </form>
                        </div>
                     </div>



                  </div>
               </div>
            </div>
         </div>
         <!-- end edit note -->
         <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
               <div ref="formContainer" class="card">
                  <div class="card-body">
                     <div class="row">
                        <div class="col-md-6">
                           <h1 class="card-title">
                              <i class="mdi-style-content  mdi mdi-briefcase-download"></i>
                              <span class="titre"> Liste des recettes</span>
                           </h1>
                           <br><br>
                        </div>
                        <div class="col-md-6">
                           <p   class="text-right">
                              <b> {{ count_recettes }} Recettes</b>
                           </p>
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-md-12">
                           <form @submit.prevent="filtrer($event)" class="forms-sample">
                              <div class="row">
                                 <div class="col-6">
                                    <div class="form-group mr-b-0em" >
                                       <label class="form__label">ID</label>
                                       <input class="form-control" v-model="data_filtrer.id_empeinte"  placeholder="ID" />
                                    </div>
                                 </div>
                                 <div class="col-6">
                                    <div class="form-group mr-b-0em" >
                                       <label class="form__label">Nom et prénom</label>
                                       <input class="form-control" v-model="data_filtrer.nom"  placeholder="Nom et prénom" />
                                    </div>
                                 </div>
                                 <div class="col-md-6">
                                    <div class="form-group mr-b-0em">
                                       <label class="form__label"> Catégorie </label>
                                       <multiselect v-model="data_filtrer.categorie" @input="setcategorie($event)"  :options="Categories" :custom-label="libeleNomCategorie" placeholder="Recherche.." label="id" track-by="id"  ></multiselect>
                                    </div>
                                 </div>
                                 <div class="col-md-6">
                                    <div class="form-group mr-b-0em">
                                       <label class="form__label"> Recette </label>
                                       <multiselect v-model="data_filtrer.service"   :options="optionServices" :custom-label="libeleServices" placeholder="Recherche.." label="id_service" track-by="id_service"  ></multiselect>
                                    </div>
                                 </div>
                                 
                                 <div class="col-md-6 mt-2">
                                    <div class="form-group mr-b-0em">
                                       <label class="form__label">Paiement </label> <br>
                                       <select class="form-control" v-model="data_filtrer.is_payed">
                                          <option value="tous">Tous</option>
                                          <option value="0"> Impayés </option>
                                          <option value="1"> Payés </option>
                                       </select>
                                    </div>
                                 </div>
                                 <div class="col-md-6 mt-2">
                                    <div class="form-group mr-b-0em">
                                       <label class="form__label">Client</label> <br>
                                       <select class="form-control" v-model="data_filtrer.type_client">
                                          <option value="tous">Tous</option>
                                          <option value="inside"> Client adhérent  </option>
                                          <option value="outside"> Client étranger  </option>
                                       </select>
                                    </div>
                                 </div>
                                 <div class="col-md-12 mt-2">
                                    <div class="form-group mr-b-0em">
                                       <label class="form__label">{{ $t('content.pages.abonnements.encours.recherche.date') }} </label> <br>
                                       <date-picker style="width: 100%;" :show-time-panel="showTimeRangePanel" @close="handleRangeClose" v-model="datetimePicker" range type="datetime" format="DD/MM/YYYY"></date-picker>
                                    </div>
                                 </div>
                                 <div class="col-6 text-left">
                                    <button type="button"  @click="clearDataInputs" class="btn btn-primary mr-2">{{$t('content.text.select_tout')}}</button>
                                 </div>
                                 <div class="col-6 text-right">
                                    <button type="submit" class="btn btn-success mr-2"> <i class="mdi mdi-magnify"></i> {{ $t('content.bouton.recherche') }}</button>
                                    <a @click="clearDataInputs" href="javascript:void(0)" class="btn btn-light">{{ $t('content.bouton.annuler') }}</a>
                                 </div>
                              </div>
                           </form>
                        </div>
                     </div>
                     <div class="row mt-5">
                        <div v-if="recettes.length>0" class="col-md-12">
                           <div style="overflow-x:auto;" id="packs" class="table-responsive  tab-pane fade in active show">
                              <table id="data-packs" class="  datatables table table-striped table-bordered table-hover">
                                 <thead class="thead-dark">
                                    <tr>
                                       <th>Client</th>
                                       <th>Nom et Prénom</th>
                                       <th>Recette </th>
                                       <th>Date d’opération</th>
                                       <th>Prix</th>
                                       <th>Montant payé</th>
                                       <th>Reste à payer</th>
                                       <th>Action</th>
                                    </tr>
                                 </thead>
                                 <tbody v-for="(recette, index) in recettes">
                                    <tr>
                                       <td> 
                                          <span v-if="recette.adherent" > 
                                              <router-link  style="padding : 0px!important;"   :to="{name: 'adherent', params : { code : `${recette.adherent.code_client}` }}" >
                                                {{ recette.adherent.code_client }} 
                                              </router-link>

                                          </span>
                                          <span style="color : red" v-else >
                                          Client étranger 
                                          </span>
                                       </td>
                                       <td>
                                           <span v-if="recette.nom != null && recette.nom !=''">
                                              {{ recette.nom }} 
                                           </span>
                                       </td>
                                       <td> 
                                          <span v-if="recette.service" >
                                          {{ recette.service.nom }} 
                                          </span>
                                       </td>
                                       <td>
                                          {{ recette.date_commande | formatDateHeur }}
                                       </td>
                                       <td> {{ recette.montant }} {{$t('content.text.dh')}}</td>
                                       <td>
                                          <span v-if="recette.recettepaiements" >
                                          {{TotalRecettePaiements( recette.montant, recette.recettepaiements, recette.id)}} {{$t('content.text.dh')}}
                                          </span>
                                       </td>
                                       <td :class="[ rest_a_paye[recette.id] > 0 ? 'bg-red' : 'bg-green' ]"> 
                                          {{ rest_a_paye[recette.id] }} {{$t('content.text.dh')}}
                                       </td>
                                       <td class="text-left" >
                                          <span  title="Supprimer" v-if="$can('Supprimer une recette')" @click="Delete(recette.id, index)" class="mdi-delete-btn"> <i class="mdi mdi-delete-forever"></i> </span>
                                          <span v-if="rest_a_paye[recette.id] > 0" >
                                          <span title="Régler" data-toggle="modal" data-target=".regler-recette" v-if="$can('Régler une recette')" @click="OpenModelRegler(recette, rest_a_paye[recette.id])" class="mdi-regler-btn"> <i class="mdi mdi-cash-usd"></i> </span> 
                                          </span>
                                          <span  >

                                             <span title="Modifier" data-toggle="modal" data-target=".edit-note-recette" v-if="$can('Modifier une recette')" @click="OpenModelEditeNote(recette, index )" class="mdi-edit-btn"> <i class="mdi mdi-pen"></i> </span> 

                                          <span title="Voir détails de la recette" data-toggle="modal" data-target=".note-recette" v-if="$can('Voir les détails d’une recette')" @click="OpenModelNote(recette )" class="mdi-details-btn"> <i class="mdi mdi-note"></i> </span> 
                                          </span>
                                           
                                       </td>
                                    </tr>
                                 </tbody>
                              </table>
                           </div>
                           <vue-pagination :pagination="pagination" @paginate="ListRecettes(data_filtrer)" :offset="4"></vue-pagination>
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
   import { required, minLength, numeric, decimal, between, maxLength, email } from 'vuelidate/lib/validators'
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
               datetimePicker:  [new Date(new Date().getTime() - 15 * 24 * 60 * 60 * 1000), new Date(new Date().getTime() + 2 * 24 * 60 * 60 * 1000)],
               showTimeRangePanel: false,
   
               state: {
                   disabledDates: {
                       to: new Date(2020, 0, 5), // Disable all dates up to specific date
                       from: new Date(), // Disable all dates after specific date
                       days: [6, 0], // Disable Saturday's and Sunday's
                   }
               },
               data_filtrer: {
                   categorie : [] ,
                   service : [],
                   datetimes: [],
                   matricule : '',
                   id_empreinte : '',
                   nom : '',
                   is_payed : 'tous', 
                   type_client : 'tous'
               },
               recettes: [],
               pagination: [],
               formData: {},
               paiements : [],
               rest_a_paye : [],
               Services : [],
               Categories : [],
               ServicesTypeRecette : [],
               reglement_recette: {
                   id_recette : '',
                   note : '',
                   old_note : '',
                   matricule : '', 
                   id_empreinte:'',
                   nom_service : '', 
                   montant : '', 
                   montant_paye : 0, 
                   date_paiement : new Date(),
                   rest_a_paye : '',
                   details_paiement : []
               },
               optionServices : [],
               count_recettes : 0
              
   
    
   
           }
       },
       mounted() {
           console.log('Component mounted.')
       },
       validations() {
           return {
               reglement_recette: { 
                   matricule: {
                        minLength : 2
                    },
                    nom_service: {
                       required
                    },
                    id_recette : {
                       required
                    },
                   montant: {
                       required,
                       decimal
                   },
                   montant_paye: {
                       required ,
                       decimal, 
                       async CheckRest_a_Payer(value) {
                           if ( parseFloat(this.$v.reglement_recette.rest_a_paye.$model) >= value) return true
                       },
                       async plusDeZero(value) {
                           if ( value > 0  ) return true
                       }
                   },
                   rest_a_paye : {
                       decimal
                   },
                   date_paiement: {
                       required
                   }, 
               }
           }
   
       },
       methods: {
           setmatricule(value) {
               console.log(value)
               this.reglement_recette.matricule = value
               this.$v.reglement_recette.matricule.$touch()
               this.reglement_recette.id_empreinte = value
               this.$v.reglement_recette.id_empreinte.$touch()
           },
           setnom_service(value) {
               console.log(value)
               this.reglement_recette.nom_service = value
               this.$v.reglement_recette.nom_service.$touch()
            },
           setid_recette(value) {
               console.log(value)
               this.reglement_recette.id_recette = value
               this.$v.reglement_recette.id_recette.$touch()
            },
           setmontant(value) {
               console.log(value)
               this.reglement_recette.montant = value
               this.$v.reglement_recette.montant.$touch()
           },
           setmontant_paye(value) {
               console.log(value)
               this.reglement_recette.montant_paye = value
               this.$v.reglement_recette.montant_paye.$touch()
           },
           setrest_a_paye(value) {
               console.log(value)
               this.reglement_recette.rest_a_paye = value
               this.$v.reglement_recette.rest_a_paye.$touch()
           },
           setdate_paiement(value) {
               console.log(value)
               this.reglement_recette.date_paiement = value
               this.$v.reglement_recette.date_paiement.$touch()
           },
            libeleNomCategorie({ nom }) {
               return `${nom}`
           },
           libeleServices({ nom_service, prix_service }) {
               return `${nom_service}, Prix : ${prix_service} Dh `
           },
           ListServicesTypeRecette() {
               axios.get('/api-admin/services-type-recette').then((response) => {
                   console.log("response.data.recettes")
                   console.log(response.data)
                   this.ServicesTypeRecette = response.data.recettes;
                   this.Categories = response.data.categories;
                   console.log(this.ServicesTypeRecette)
               });
           },
   
           setcategorie(value) {
                
               this.data_filtrer.categorie = value
               this.data_filtrer.service = []
   
   
   
               this.optionServices = []
               if (this.data_filtrer.categorie != null) {
                   this.optionServices = this.ServicesTypeRecette; 
                   this.optionServices = this.optionServices.filter(service => {
                        return   service.id_categorie == this.data_filtrer.categorie.id 
                   })
               }
   
               console.log(this.optionServices)
   
           },
   
   
           ListRecettes(data_filtrer) {

               if (typeof this.$route.query.adherent !== 'undefined') {
                  if( this.$route.query.adherent !=  null && this.$route.query.adherent != ''){
                     this.$router.push({name: 'recettes', query: {adherent : '' } })
                  }
               }  
               if (typeof this.$refs.formContainer !== "undefined")  
                   this.PluginLoader(false, this.$refs.formContainer)
               const current_page = (this.pagination.current_page) ? this.pagination.current_page : 1;
               this.formData = new FormData(); 
    
   
               if (this.data_filtrer.matricule != null && this.data_filtrer.matricule !=  ''){
                   //this.$router.push({name: 'recettes', query: {adherent : '' } })
                   this.formData.append("filtrer[matricule]", this.data_filtrer.matricule);
               }

               if (this.data_filtrer.id_empreinte != null && this.data_filtrer.id_empreinte !=  ''){
                   //this.$router.push({name: 'recettes', query: {adherent : '' } })
                   this.formData.append("filtrer[id_empreinte]", this.data_filtrer.id_empreinte);
               }
   
              
              
               if (this.data_filtrer.nom != null && this.data_filtrer.nom != '' ){
                    this.formData.append("filtrer[nom]", this.data_filtrer.nom);
               }

               if (this.data_filtrer.service != null && typeof this.data_filtrer.service.id_service !== "undefined"){
                   console.log('service : ' + this.data_filtrer.service.id_service)
                   this.formData.append("filtrer[service_id]", this.data_filtrer.service.id_service);
               }
   
               if (this.data_filtrer.categorie != null && typeof this.data_filtrer.categorie.id !== "undefined"){
                   console.log(this.data_filtrer.categorie.length)
                   console.log('here categorie_id : ' + this.data_filtrer.categorie.id)
                   this.formData.append("filtrer[categorie_id]", this.data_filtrer.categorie.id);
               }
   
               if (this.data_filtrer.is_payed != 'tous'){
                    this.formData.append("filtrer[is_payed]", this.data_filtrer.is_payed);
               }
   
               if (this.data_filtrer.type_client != 'tous'){
                    this.formData.append("filtrer[type_client]", this.data_filtrer.type_client);
               }
   
               if (this.datetimePicker[0] != null && this.datetimePicker[1]){
                    this.formData.append("filtrer[date][from]", this.data_filtrer.datetimes[0]);
                   this.formData.append("filtrer[date][to]", this.data_filtrer.datetimes[1]);
               }
               const config = { headers: { 'content-type': 'multipart/form-data' } }
               axios.post('/api-admin/recettes?page=' + current_page, this.formData, config).then((response) => {
                   this.count_recettes = response.data.recettes.total;
                    this.recettes = response.data.recettes.data;
                   this.pagination = response.data.recettes;
                   console.log(this.recettes)
                });
           },
           RefreshListRecettes(newRecettes) {
               if (newRecettes != null) {
                   this.recettes.unshift(newRecettes)
               }
           },
           filtrer(event) {
               if (this.datetimePicker[0] != null && this.datetimePicker[1]) {
                   console.log(this.datetimePicker)
                   const date = this.datetimePicker; 
                   this.data_filtrer.datetimes = [date[0].toDateString(), date[1].toDateString()]
               }
               this.pagination = []
                this.ListRecettes(this.data_filtrer)
           },
           handleRangeClose() {
               this.showTimeRangePanel = false;
           },  
   
           Edit(recette, index) {
               this.eventRecettes.$emit('edit', { "recette": recette, "index": index })
           },
           ClearInputs() {
               $('.wizard-footer-right .wizard-btn').prop("disabled",false);
               this.eventRecettes.$emit('clear')

           },
           OpenModelRegler(recette, rest_a_paye){
               $('.wizard-footer-right .wizard-btn').prop("disabled",false);
               if (recette.adherent) {
                   this.$v.reglement_recette.matricule.$model = recette.adherent.code_client 
               }
               this.$v.reglement_recette.nom_service.$model = recette.service.nom
   
               this.reglement_recette.id_recette = recette.id
               this.$v.reglement_recette.montant.$model = recette.montant  
               this.$v.reglement_recette.rest_a_paye.$model = rest_a_paye
               this.$v.reglement_recette.montant_paye.$model = 0  
               this.$v.reglement_recette.date_paiement.$model = new Date()  
   
               console.log(recette.id)
               console.log(  this.$v.reglement_recette.id_recette.$model )
           },
           OpenModelNote(recette){

                this.reglement_recette.note = recette.note 
                this.reglement_recette.details_paiement = recette.recettepaiements
           },
           OpenModelEditeNote(recette, index){
            this.reglement_recette.note = ''
                this.reglement_recette.old_note = recette.note 
               // this.reglement_recette.note = recette.note 
                this.reglement_recette.id_recette = recette.id
                this.reglement_recette.index = index
                //this.reglement_recette.details_paiement = recette.recettepaiements
           },

           editnote(event){

            //this.$v.$touch()
               //console.log(this.$v.$invalid)
               //if (!this.$v.$invalid) { 
                   this.$fire(
                       this.AlertFire('edit')
                   ).then((result) => {
                       if (result.value) {
                           this.submitStatus = 'PENDING'
                           this.formData = new FormData();
                           this.formData.append('note', this.reglement_recette.note); 
                           this.formData.append('id_recette', this.reglement_recette.id_recette); 

                           const config = { headers: { 'content-type': 'multipart/form-data' } }
                           axios.post('/api-admin/recette/edit-note', this.formData, config).then(res => {
                                   switch (res.data.recette) {
                                       case false:
                                           this.AlertResponseFalse("Recette", "Recette n'existe pas", "warning")
                                           break;
                                       default:
                                           this.AlertResponseTrue("", this.$t('content.alerts.modification.success'), "success");
                                           //window.location.reload();
                                          this.reglement_recette.old_note = this.reglement_recette.note
                                          this.reglement_recette.note = ''
                                           $('.edit-note-recette').modal('hide');
                                          Vue.set(this.recettes, this.reglement_recette.index, res.data.recette)

                                       break;
                                   }
                               }).catch(e => {})
                               .finally(f => {
                                   setTimeout(() => {
                                       this.submitStatus = 'OK'
                                   }, 500)
                               })
                       }
                   })
               //}
           }, 


           Regler(event){
    
   
               this.$v.$touch()
               console.log(this.$v.$invalid)
               if (!this.$v.$invalid) { 
                   this.$fire(
                       this.AlertFire('regler_recette')
                   ).then((result) => {
                       if (result.value) {
                           this.submitStatus = 'PENDING'
                           this.formData = new FormData();
                           this.formData.append('id_recette', this.$v.reglement_recette.id_recette.$model);
                            this.formData.append('montant_paye', this.$v.reglement_recette.montant_paye.$model);

                            this.formData.append('recette[date_paiement]', this.$v.reglement_recette.date_paiement.$model.toLocaleDateString()  );
                            this.formData.append('recette[time_paiement]', this.$v.reglement_recette.date_paiement.$model.toLocaleTimeString()  ); 

                           //this.formData.append('date_paiement', this.recette.date_paiement.$model.toDateString());
   
                           const config = { headers: { 'content-type': 'multipart/form-data' } }
                           axios.post('/api-admin/recette/regler', this.formData, config).then(res => {
                                   switch (res.data) {
                                       case false:
                                           this.AlertResponseFalse("Recette", "Recette n'existe pas", "warning")
                                           break;
                                       default:
                                           this.AlertResponseTrue("", this.$t('content.alerts.regler.success'), "success");
                                           window.location.reload();
                                       break;
                                   }
                               }).catch(e => {})
                               .finally(f => {
                                   setTimeout(() => {
                                       this.submitStatus = 'OK'
                                   }, 500)
                               })
                       }
                   })
               }
           },
   
           Delete(id_recette, index) {
               this.$fire(
                   this.AlertFire('delete')
               ).then((result) => {
                   if (result.value) {
                       this.submitStatus = 'PENDING'
                       this.formData = new FormData();
                       this.formData.append('id_recette', id_recette);
                       const config = { headers: { 'content-type': 'multipart/form-data' } }
                       axios.post('/api-admin/recette/destroy', this.formData, config).then(res => {
                               switch (res.data) {
                                   case false:
                                       this.AlertResponseFalse("Recette", "recette n'existe pas", "warning")
                                       break;
                                   default:
                                       this.AlertResponseTrue("", "La suppression est effectué avec succès", "success");
                                       this.recettes.splice(index, 1)
                                                                              
                                       break;
                               }
                           }).catch(e => {})
                           .finally(f => {
                               setTimeout(() => {
                                   this.submitStatus = 'OK'
                               }, 500)
                           })
                   }
               })
           },
           clearDataInputs() {
               this.datetimePicker = [new Date(new Date().getTime() - 15 * 24 * 60 * 60 * 1000), new Date(new Date().getTime() + 2 * 24 * 60 * 60 * 1000)]
               this.data_filtrer.is_payed = 'tous'
               this.data_filtrer.type_client = 'tous'
               this.data_filtrer.matricule = ''
               this.data_filtrer.id_empreinte = ''
               this.data_filtrer.nom = ''
               this.data_filtrer.categorie = []
               this.data_filtrer.service = []

               if (typeof this.$route.query.adherent !== 'undefined') {
                  if( this.$route.query.adherent !=  null && this.$route.query.adherent != ''){
                     this.$router.push({name: 'recettes', query: {adherent : '' } })
                  }
               }
               this.ListRecettes(this.data_filtrer)
            },
           TotalRecettePaiements(montant, paiements, recette_id){
               var total = 0.00;
               for (var i = 0; i < paiements.length; i++) {
                   total += parseFloat(paiements[i].montant_paye)
               }
               if (paiements) {
                   this.paiements[recette_id] = parseFloat(total).toFixed(2)
                   this.rest_a_paye[recette_id] = parseFloat(montant - total).toFixed(2)
               }
               return parseFloat(total).toFixed(2);
           }
   
       },
       beforeMount() {
         if (typeof this.$route.query.adherent !== 'undefined') {
            if( this.$route.query.adherent !=  null && this.$route.query.adherent != ''){
              this.data_filtrer.matricule  =  this.$route.query.adherent
            }
         } 
           if(this.$can('Consulter la liste des recettes'))
           {
            this.optionServices = this.ServicesTypeRecette;
            this.ListServicesTypeRecette()
            this.filtrer();   
           }
       },
       created: function() {
           this.eventRecettes.$on('update', data => {
               if (data != null) {
                    Vue.set(this.recettes, data.index, data.recette)
               }
           })
       }, 
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
   .btn-off {
   background-color: red;
   }
   .btn-on {
   background-color: green;
   }
   .sub-level {
   display: none;
   }
   .open:before {
   content: "\F140";
   }
   .hide:before {
   content: "\F142";
   }
   
</style>

