<template>
    <div class="main-panel">
        <div v-if="$can('Consulter la liste des dépenses')" class="content-wrapper">
            <div v-if="$can('Ajouter une dépense')" class="row">
                <div class="col-md-12 float-right text-right">
                    <button @click="ClearInputs" type="button" class="btn btn-primary" data-toggle="modal" data-target=".bd-example-modal-lg"><i class=" mdi mdi-plus"></i>Ajouter une dépense</button>
                </div>
            </div><br>
            <div v-if="$can('Ajouter une dépense') || $can('Modifier une dépense')" class="col-md-12">
                <add-depence :Categories='Categories' :ServicesTypeDepence='ServicesTypeDepence' @RefreshListDepences="RefreshListDepences($event)"></add-depence>
            </div>
            <!-- Regler -->
        <div v-if="$can('Régler une dépense')" class="modal fade regler-depence" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
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
                                <div class="col-md-6">
                                    <div class="form-group mr-b-0em">
                                        <label class="form__label"> Dépense </label>
                                         <input readonly class="form-control" v-model.trim="$v.depence.nom_service.$model" @input="setnom_service($event.target.value)" placeholder="" />
                                    </div>
                                    <div v-if="$v.depence.nom_service.$dirty">
                                        <div class="error" v-if="!$v.depence.nom_service.required">{{ $t('validation.required', { attribute : 'Dépense' }) }}</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mr-b-0em" :class="{ 'form-group--error': $v.depence.montant.$error }">
                                        <label class="form__label">Montant de la dépense</label>
                                        <input readonly class="form-control" v-model.trim="$v.depence.montant.$model" @input="setmontant($event.target.value)" placeholder="Montant de la dépense" />
                                    </div> 
                                    <div v-if="$v.depence.montant.$dirty">
                                        <div class="error" v-if="!$v.depence.montant.required">{{ $t('validation.required', { attribute : 'Montant de la dépense' }) }}</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mr-b-0em" :class="{ 'form-group--error': $v.depence.rest_a_paye.$error }">
                                        <label class="form__label">Reste à payer</label>
                                        <input readonly class="form-control" v-model.trim="$v.depence.rest_a_paye.$model" @input="setrest_a_paye($event.target.value)" placeholder="Montant payé" />
                                    </div> 
                                </div> 
                                <div class="col-12">
                                    <p><b>Paiement</b></p>
                                </div> 
                                <div class="col-6">
                                    <div class="form-group mr-b-0em" :class="{ 'form-group--error': $v.depence.montant_paye.$error }">
                                        <label class="form__label">Montant payé</label>
                                        <input class="form-control" v-model.trim="$v.depence.montant_paye.$model" @input="setmontant_paye($event.target.value)" placeholder="Montant payé" />
                                    </div>  

                                    <div v-if="$v.depence.montant_paye.$dirty">
                                        <div class="error" v-if="!$v.depence.montant_paye.decimal || !$v.depence.montant_paye.plusDeZero">
                                            Vérifier le montant payé
                                        </div>
                                        <div class="error" v-if="!$v.depence.montant_paye.required">
                                            Champs obligatoire
                                        </div>
                                    <div class="error" v-if="!$v.depence.montant_paye.CheckRest_a_Payer">
                                         Le montant ajouté est supérieur au restant à payer 
                                    </div> 
                                </div>


                                </div> 
                                <div class="col-6">
                                    <div class="form-group mr-b-0em" :class="{ 'form-group--error': $v.depence.date_paiement.$error }">
                                        <label class="form__label">Date de paiement</label>
                                        <date-picker  format="DD/MM/YYYY HH:mm" style="width : 100%;" v-model.trim="$v.depence.date_paiement.$model" @change="setdate_paiement" type="datetime"></date-picker>
                                    </div>
                                    <div v-if="$v.depence.date_paiement.$dirty">
                                        <div class="error" v-if="!$v.depence.date_paiement.required">{{ $t('validation.required', { attribute : 'Date de paiement' }) }}</div>
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
        <div v-if="$can('Voir les détails d’une dépense')" class="modal fade note-depence" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
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
                    <div v-if="depence.note != '' && depence.note != null" >
                        <b>Note : </b>
                        <p>  {{ depence.note }}  </p>
                    </div>
                    <div v-if="depence.details_paiement" class="mt-3 responsive-table " >
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
                                <tr v-for="(paiement, index) in depence.details_paiement" >
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
         <div v-if="$can('Modifier une dépense')"  class="modal fade edit-note-depence" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
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
                     <div v-if="depence.old_note != '' && depence.old_note != null" >
                        <b>Note actuel: </b>
                        <p>  {{ depence.old_note }}  </p>
                     </div>
                     <div class="row">
                        <div class="col-md-12">
                           <form @submit.prevent="editnote($event)" class="forms-sample">
                              <div class="row">
                                 <div class="col-12">
                                    <div class="form-group mr-b-0em" >
                                        <label class="form__label">Note</label>
                                        <textarea rows="3" class="form-control" v-model.trim="depence.note" >
                                        </textarea> 
                                    </div> 
                                </div>  
                                 <div class="col-12 text-right">
                                    <button type="submit" class="btn btn-success mr-2"> <i class="mdi mdi-pen"></i> {{ $t('content.bouton.modifier') }}</button>
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
                                        <i class="mdi-style-content  mdi mdi-briefcase-upload"></i>
                                        <span class="titre"> Liste des dépenses </span>
                                    </h1><br><br>
                                </div>
                                <div class="col-md-6">
                                    <p   class="text-right">
                                       <b> {{count_depences}} Dépenses</b>
                                    </p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <form @submit.prevent="filtrer($event)" class="forms-sample">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group mr-b-0em" >
                                                   <label class="form__label">Nom </label>
                                                   <input class="form-control" v-model="data_filtrer.nom"  placeholder="Nom " />
                                                </div>
                                             </div>
                                            <div class="col-md-6">
                                                <div class="form-group mr-b-0em">
                                                    <label class="form__label"> Catégories </label>
                                                    <multiselect v-model="data_filtrer.categorie" @input="setcategorie($event)" :options="Categories" :custom-label="libeleNomCategorie" placeholder="Recherche.." label="id" track-by="id"  ></multiselect>
                                                </div> 
                                            </div>


                                            <div class="col-md-6">
                                                <div class="form-group mr-b-0em">
                                                    <label class="form__label"> Dépenses </label>
                                                    <multiselect v-model="data_filtrer.service"   :options="optionServices" :custom-label="libeleServices" placeholder="Recherche.." label="id_service" track-by="id_service"  ></multiselect>
                                                 </div> 
                                            </div> 
                                            <div class="col-6 mt-2">
                                                <div class="form-group mr-b-0em">
                                                    <label class="form__label">Réglements  </label> <br>
                                                    <select class="form-control" v-model="data_filtrer.is_payed">
                                                        <option value="tous">Tous</option>
                                                        <option value="0"> Impayés </option> 
                                                        <option value="1"> Payés </option> 
                                                    </select>
                                                </div>
                                            </div> 
                                            
                                            <div class="col-6 mt-2">
                                                <div class="form-group mr-b-0em">
                                                    <label class="form__label">{{ $t('content.pages.abonnements.encours.recherche.date') }}  </label> <br>
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
                                <div v-if="depences.length>0" class="col-md-12">
                                    <div style="overflow-x:auto;" id="packs" class="table-responsive tab-pane fade in active show">
                                        <table id="data-packs" class="datatables table table-striped table-bordered table-hover">
                                            <thead class="thead-dark">
                                                <tr>
                                                    <th>Nom </th>
                                                     <th>Dépenses</th>
                                                    <th>Date d'opération</th>
                                                    <th>Prix</th>
                                                    <th>Montant payé</th>
                                                    <th>Reste à payer</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody v-for="(depence, index) in depences">
                                                <tr> 
                                                    <td>
                                                       <span v-if="depence.nom != null && depence.nom !=''">
                                              {{ depence.nom }} 
                                           </span>
                                                   </td>
                                                    <td> 
                                                        <span v-if="depence.service" >
                                                            {{ depence.service.nom }} 
                                                        </span>
                                                    </td>
                                                    <td>
                                                        {{ depence.date_commande | formatDateHeur }}
                                                    </td>
                                                    <td> {{ depence.montant }} {{$t('content.text.dh')}}</td>
                                                    <td>
                                                        <span v-if="depence.depencepaiements" >
                                                            {{TotalDepencePaiements( depence.montant, depence.depencepaiements, depence.id)}} {{$t('content.text.dh')}}
                                                         </span>
                                                    </td>
                                                    <td :class="[ rest_a_paye[depence.id] > 0 ? 'bg-red' : 'bg-green' ]"> 
                                                        {{ rest_a_paye[depence.id] }} {{$t('content.text.dh')}}
                                                    </td>
                                                    <td class="text-left" >
                                                        <span title="Supprimer"  v-if="$can('Supprimer une dépense')" @click="Delete(depence.id, index)" class="mdi-delete-btn"> <i class="mdi mdi-delete-forever"></i> </span>
                                                        <span v-if="rest_a_paye[depence.id] > 0" >
                                                            <span title="Régler"   data-toggle="modal" data-target=".regler-depence" v-if="$can('Régler une dépense')" @click="OpenModelRegler(depence, rest_a_paye[depence.id])" class="mdi-regler-btn"> <i class="mdi mdi-cash-usd"></i> </span> 
                                                        </span>

                                                        <span title="Modifier"   data-toggle="modal" data-target=".edit-note-depence" v-if="$can('Modifier une dépense')" @click="OpenModelEditeNote(depence, index )" class="mdi-edit-btn"> <i class="mdi mdi-pen"></i> </span> 
                                                     

                                                            <span title="Voir détails de la dépense" data-toggle="modal" data-target=".note-depence" v-if="$can('Voir les détails d’une dépense')" @click="OpenModelNote(depence )" class="mdi-details-btn"> <i class="mdi mdi-note"></i> </span> 
                                                         
                                                        
                                           
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <vue-pagination :pagination="pagination" @paginate="ListDepences(data_filtrer)" :offset="4"></vue-pagination>
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
                 is_payed : 'tous', 
                type_client : 'tous',
             },
            depences: [],
            pagination: [],
            formData: {},
            paiements : [],
            rest_a_paye : [],
            ServicesTypeDepence : [],
            Services : [],
            Categories : [],
            depence: {
                id_depence : '',
                note : '',
                old_note : '',
                 nom_service : '', 
                montant : '', 
                montant_paye : 0, 
                date_paiement : new Date(),
                rest_a_paye : '',
                details_paiement : []
            },
            optionServices : [],
            count_depences : 0
            

 

        }
    },
    mounted() {
        console.log('Component mounted.')
    },
    validations() {
        return {
            
            depence: { 
                nom_service: {
                    required
                 },
                 id_depence : {
                    required
                 },
                montant: {
                    required,
                    decimal
                },
                montant_paye: {
                    required,
                    decimal, 
                    async CheckRest_a_Payer(value) {
                        if ( parseFloat(this.$v.depence.rest_a_paye.$model) >= value) return true
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
         libeleNomCategorie({ nom }) {
            return `${nom}`
        },

        setnom_service(value) {
            console.log(value)
            this.depence.nom_service = value
            this.$v.depence.nom_service.$touch()
         },
        setid_depence(value) {
            console.log(value)
            this.depence.id_depence = value
            this.$v.depence.id_depence.$touch()
         },
        setmontant(value) {
            console.log(value)
            this.depence.montant = value
            this.$v.depence.montant.$touch()
        },
        setmontant_paye(value) {
            console.log(value)
            this.depence.montant_paye = value
            this.$v.depence.montant_paye.$touch()
        },
        setrest_a_paye(value) {
            console.log(value)
            this.depence.rest_a_paye = value
            this.$v.depence.rest_a_paye.$touch()
        },
        setdate_paiement(value) {
            console.log(value)
            this.depence.date_paiement = value
            this.$v.depence.date_paiement.$touch()
        },
        libeleServices({ nom_service, prix_service }) {
            return `${nom_service}, Prix : ${prix_service} Dh `
        },
        ListServicesTypeDepence() {
            axios.get('/api-admin/services-type-depence').then((response) => { 
                this.ServicesTypeDepence = response.data.depences;
                this.Categories = response.data.categories;
                console.log(this.ServicesTypeDepence)
            });
        },

        setcategorie(value) {
             
            this.data_filtrer.categorie = value
            this.data_filtrer.service = []
            this.optionServices = []
            if (this.data_filtrer.categorie != null) {
                this.optionServices = this.ServicesTypeDepence; 
                this.optionServices = this.optionServices.filter(service => {
                     return   service.id_categorie == this.data_filtrer.categorie.id 
                })
            }

            console.log(this.optionServices)

        },


        ListDepences(data_filtrer) {
            if (typeof this.$refs.formContainer !== "undefined")  
                this.PluginLoader(false, this.$refs.formContainer)
            const current_page = (this.pagination.current_page) ? this.pagination.current_page : 1;
            this.formData = new FormData(); 

            if (this.data_filtrer.nom != null && this.data_filtrer.nom != '' ){
                    this.formData.append("filtrer[nom]", this.data_filtrer.nom);
               }

            /*if (this.data_filtrer.service.length !== 0){
                console.log('service : ' + this.data_filtrer.service.id_service)
                this.formData.append("filtrer[service_id]", this.data_filtrer.service.id_service);
            }

            if (this.data_filtrer.categorie.length !== 0){
                console.log('categorie_id : ' + this.data_filtrer.categorie.id)
                this.formData.append("filtrer[categorie_id]", this.data_filtrer.categorie.id);
            }*/

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
 

            if (this.datetimePicker[0] != null && this.datetimePicker[1] ){
                 this.formData.append("filtrer[date][from]", this.data_filtrer.datetimes[0]);
                this.formData.append("filtrer[date][to]", this.data_filtrer.datetimes[1]);
            }
            const config = { headers: { 'content-type': 'multipart/form-data' } }
            axios.post('/api-admin/depences?page=' + current_page, this.formData, config).then((response) => {
                 this.count_depences = response.data.depences.total;
                 this.depences = response.data.depences.data;
                this.pagination = response.data.depences;
                console.log(this.depences)
             });
        },
        RefreshListDepences(newDepences) {
            if (newDepences != null) {
                this.depences.unshift(newDepences)
            }
        },
        filtrer(event) {
            if (this.datetimePicker[0] != null && this.datetimePicker[1] ) {
                const date = this.datetimePicker; 
                this.data_filtrer.datetimes = [date[0].toDateString(), date[1].toDateString()]
            }
            this.pagination = []
             this.ListDepences(this.data_filtrer)
        },
        handleRangeClose() {
            this.showTimeRangePanel = false;
        },  

        Edit(depence, index) {
            this.eventDepences.$emit('edit', { "depence": depence, "index": index })
        },
        ClearInputs() {
            this.eventDepences.$emit('clear')
        },
        OpenModelRegler(depence, rest_a_paye){
             this.$v.depence.nom_service.$model = depence.service.nom

            this.depence.id_depence = depence.id
            this.$v.depence.montant.$model = depence.montant  
            this.$v.depence.rest_a_paye.$model = rest_a_paye
            this.$v.depence.montant_paye.$model = null  
            this.$v.depence.date_paiement.$model = new Date()  

            console.log(depence.id)
            console.log(  this.$v.depence.id_depence.$model )
        },
        OpenModelNote(depence){
             this.depence.note = depence.note 
             this.depence.details_paiement = depence.depencepaiements
        },
        OpenModelEditeNote(depence, index){
            this.depence.note = ''
                this.depence.old_note = depence.note 
               // this.depence.note = depence.note 
                this.depence.id_depence = depence.id
                this.depence.index = index
                //this.depence.details_paiement = depence.depencepaiements
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
                           this.formData.append('note', this.depence.note); 
                           this.formData.append('id_depence', this.depence.id_depence); 

                           const config = { headers: { 'content-type': 'multipart/form-data' } }
                           axios.post('/api-admin/depence/edit-note', this.formData, config).then(res => {
                                   switch (res.data.depence) {
                                       case false:
                                           this.AlertResponseFalse("depence", "Dépense n'existe pas", "warning")
                                           break;
                                       default:
                                           this.AlertResponseTrue("", this.$t('content.alerts.modification.success'), "success");
                                           //window.location.reload();
                                          this.depence.old_note = this.depence.note
                                          this.depence.note = ''
                                           $('.edit-note-depence').modal('hide');
                                          Vue.set(this.depences, this.depence.index, res.data.depence)

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
            if (this.$v.$invalid) {
                this.submitStatus = 'ERROR'
            } else {
                this.$fire(
                    this.AlertFire('regler_depense')
                ).then((result) => {
                    if (result.value) {
                        this.submitStatus = 'PENDING'
                        this.formData = new FormData();
                        this.formData.append('id_depence', this.$v.depence.id_depence.$model);
                        console.log("id : " + this.$v.depence.id_depence.$model)
                        this.formData.append('montant_paye', this.$v.depence.montant_paye.$model);
                        
                        this.formData.append('depence[date_paiement]', this.$v.depence.date_paiement.$model.toLocaleDateString()  );
                            this.formData.append('depence[time_paiement]', this.$v.depence.date_paiement.$model.toLocaleTimeString()  ); 

                        const config = { headers: { 'content-type': 'multipart/form-data' } }
                        axios.post('/api-admin/depence/regler', this.formData, config).then(res => {
                                switch (res.data) {
                                    case false:
                                        this.AlertResponseFalse("depence", "Dépense n'existe pas", "warning")
                                        break;
                                    default:
                                        this.AlertResponseTrue("", this.$t('content.alerts.regler.success') , "success");
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

        Delete(id_depence, index) {
            this.$fire(
                this.AlertFire('delete')
            ).then((result) => {
                if (result.value) {
                    this.submitStatus = 'PENDING'
                    this.formData = new FormData();
                    this.formData.append('id_depence', id_depence);
                    const config = { headers: { 'content-type': 'multipart/form-data' } }
                    axios.post('/api-admin/depence/destroy', this.formData, config).then(res => {
                            switch (res.data) {
                                case false:
                                    this.AlertResponseFalse("depence", "Dépense n'existe pas", "warning")
                                    break;
                                default:
                                    this.AlertResponseTrue("", "La suppression est effectué avec succès", "success");
                                    this.depences.splice(index, 1)
                                                                           
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
            this.data_filtrer.nom = ''
              this.data_filtrer.categorie = []
              this.data_filtrer.service = [] 
               this.ListDepences(this.data_filtrer)
         },
        TotalDepencePaiements(montant, paiements, depence_id){
            var total = 0.00;
            for (var i = 0; i < paiements.length; i++) {
                total += parseFloat(paiements[i].montant_paye)
            }
            if (paiements) {
                this.paiements[depence_id] = parseFloat(total).toFixed(2)
                this.rest_a_paye[depence_id] = parseFloat(montant - total).toFixed(2)
            }
            return parseFloat(total).toFixed(2);
        }

    },
    beforeMount() { 
        if (this.$can('Consulter la liste des dépenses')) {
            this.filtrer();  
            this.ListServicesTypeDepence()
              this.optionServices = this.ServicesTypeDepence; 
        }
    },
    created: function() {
        this.eventDepences.$on('update', data => {
            if (data != null) {
                 Vue.set(this.depences, data.index, data.depence)
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



.mdi-edit-btn {
    background: #8686ff;
    border-radius: 3px;
    padding: 3px 7px;
    color: #fff;
    cursor: pointer;
    font-size: 16px;
}

.mdi-delete-btn {
    background: #ff5656;
    border-radius: 3px;
    padding: 3px 7px;
    color: #fff;
    cursor: pointer;
    font-size: 16px;
}

.mdi-note-btn {
    background: #fcb919;
    border-radius: 3px;
    padding: 3px 7px;
    color: #fff;
    cursor: pointer;
    font-size: 16px;
}


.mdi-block-btn {

    background: #ff5656;
    border-radius: 3px;
    padding: 3px 7px;
    color: #fff;
    cursor: pointer;
    font-size: 16px;
}




</style>
