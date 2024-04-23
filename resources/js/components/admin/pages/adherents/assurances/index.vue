

<template>
   <div class="main-panel">
      <div v-if="$can('Assurances')" class="content-wrapper">
         <div v-if="$can('Ajouter une assurance')" class="row">
                <div class="col-md-12 float-right text-right">
                    <button @click="FormEmpty" type="button" class="btn btn-primary" data-toggle="modal" data-target=".modal-assurance">
                        <i class=" mdi mdi-plus"></i>Ajouter une assurance
                    </button>
                </div>
                <div class="col-md-12">
                    <add-assuranceadherent @RefreshListAssurance="RefreshListAssurance($event)"></add-assuranceadherent>
                </div>
            </div><br>
         <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
               <div ref="formContainer" class="card">
                  <div class="card-body">
                     <div class="row">
                        <div class="col-md-6">
                           <h1 class="card-title">
                              <i class="mdi-style-content mdi mdi-medical-bag"></i>
                              <span class="titre">Assurances</span>
                           </h1>
                           <br><br>
                        </div>
                        <div class="col-md-6">
                           <p   class="text-right">
                              <b> {{count_adherents}} Assurances</b>
                           </p>
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-md-12">
                           <form @submit.prevent="filtrer($event)" class="forms-sample">
                              <div class="row">
                                 <!--<div class="col-6">
                                    <div class="form-group mr-b-0em" :class="{ 'form-group--error': $v.data_filtrer.code_client.$error }">
                                        <label class="form__label">{{ $t('content.pages.adherents.badges.recherche.matricule.titre') }} </label>
                                        <input class="form-control" v-model.trim="$v.data_filtrer.code_client.$model" @input="setCodeclient($event.target.value)" :placeholder="$t('content.pages.adherents.badges.recherche.matricule.placeholder')" />
                                    </div>
                                    <div v-if="$v.data_filtrer.code_client.$dirty">
                                        <div class="error" v-if="!$v.data_filtrer.code_client.minLength">
                                            {{ $t('validation.min.numeric', { attribute : $t('content.pages.adherents.badges.recherche.matricule.titre'), min : $v.data_filtrer.code_client.$params.minLength.min }) }}
                                        </div>
                                    </div>
                                    </div>-->
                                 <div class="col-md-4">
                                    <div class="form-group mr-b-0em">
                                       <label class="form__label">Nom et prénom</label>
                                       <input v-model="data_filtrer.nom" placeholder="Nom et prénom" class="form-control">
                                    </div>
                                 </div>
                                 <div class="col-md-4">
                                    <div class="form-group mr-b-0em">
                                       <label class="form__label">ID</label>
                                       <input v-model="data_filtrer.matricule" placeholder="Matricule" class="form-control">
                                    </div>
                                 </div>
                                 <div class="col-md-4">
                                    <div class="form-group mr-b-0em">
                                       <label class="form__label">CIN</label>
                                       <input v-model="data_filtrer.cin" placeholder="CIN" class="form-control">
                                    </div>
                                 </div>
                                 <div class="col-6">
                                    <div class="form-group mr-b-0em">
                                       <label class="form__label">Genre</label>
                                       <select class="form-control" v-model="data_filtrer.genre">
                                          <option value="tous">Tous</option>
                                                        <option :value="$t('content.text.homme')">{{$t('content.text.homme')}}</option>
                                                        <option :value="$t('content.text.femme')">{{$t('content.text.femme')}}</option>
                                       </select>
                                    </div>
                                 </div>
                                 <!--<div class="col-md-6">
                                    <div class="form-group mr-b-0em">
                                        <label class="form__label">{{ $t('content.pages.adherents.badges.recherche.matricule.titre') }} </label>
                                        <multiselect v-model.trim="value_id_adherent" :options="list_adherents" :custom-label="nameWithCodeClient" placeholder="Recherche.." label="code_client" track-by="code_client"></multiselect>
                                    </div>
                                    </div>-->
                                 <div class="col-6">
                                    <div class="form-group mr-b-0em">
                                       <label class="form__label">Date du au  </label> <br>
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
                     <div class="row "> 
                        <div v-if="adherents_assuree.length > 0" class="table-responsive mt-5 col-md-12">
                           <table id="data-packs" class=" datatables table table-striped table-bordered table-hover">
                              <thead class="thead-dark">
                                 <tr>
                                    <th>ID</th>
                                    <th>Nom</th>
                                    <th>Date de déclaration</th>
                                    <th>Date d'échéance </th>
                                    <th>Jours restants </th>
                                    <th>Prix </th>
                                    <th>Action</th>
                                 </tr>
                              </thead>
                              <tbody>
                                 <tr v-for="(adherent, index) in adherents_assuree">
                                    <td>
                                       <div v-if="$can('Consulter la fiche d\'adhérent')">
                                          <router-link  title="Fiche adhérent" :to="{name: 'adherent', params:{code: adherent.code_client }}">
                                             <span>{{ adherent.id_empreinte }}</span>
                                          </router-link>
                                       </div> 
                                       <div  v-else>
                                          <span>{{ adherent.id_empreinte }}</span>
                                       </div>
                                    </td>
                                    <td> 
                                       <span>{{ adherent.nom }}</span>
                                    </td>
                                    <td>
                                       {{ adherent.latest_assurance.date_assuree | formatDate  }}
                                    </td>
                                    <td>
                                       {{ adherent.latest_assurance.date_fin | formatDate  }}
                                    </td>
                                    <td>
                                       {{ adherent.latest_assurance.RestDays }} {{$t('content.text.jours')}}
                                    </td>
                                    <td>
                                       {{ adherent.latest_assurance.prix }} {{$t('content.text.dh')}}
                                    </td>
                                    <td>
                                       <span  title="Supprimer" v-if="$can('Supprimer une assurance') &&  adherent.latest_assurance" @click="SupprimerAssuranceAdherent( adherent.latest_assurance.id , index)" class="mdi-delete-btn"> <i class="mdi mdi-delete-forever"></i> </span>

                                       <span data-toggle="modal" data-target=".modal-assurance" title="Modifier" v-if="$can('Modifier une assurance') &&  adherent.latest_assurance" @click="ModifierAssurance(adherent, index )" class="mdi-edit-btn"> <i class="mdi mdi-pen"></i> </span>

                                        <router-link  v-if="$can('Consulter les details d’une assurance')"  title="Voir toutes les assurances" :to="{name: 'assurance-adherent', params:{code: adherent.code_client }}" class="mdi-details-btn"> <i class="mdi mdi-eye"></i>
                                          </router-link> 

                                    </td>
                                 </tr>
                              </tbody>
                           </table>
                           <vue-pagination :pagination="pagination" @paginate="Assurances(data_filtrer)" :offset="4"></vue-pagination>
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
       //  props: ['code'],
       data() {
           return {
               adherents_assuree: [],
               datetimePicker: [null, null], //[new Date(new Date().getTime() - 365 * 24 * 60 * 60 * 1000), new Date(new Date().getTime() + 1 * 24 * 60 * 60 * 1000)],
               showTimeRangePanel: false,
   
               formData: {},
               search: '',
   
               data_filtrer: {
                   datetimes: [],
                   code_client: null,
                   nom : '',
                   matricule : '',
                   cin : '',
                   genre : 'tous',
               },
               list_adherents: [],
               value_id_adherent: [],
               pagination: [],
               submitStatus: '',
               count_adherents : 0
           }
       },
       mounted() {}, 
       methods: {
           nameWithCodeClient({ code_client, nom }) {
               return `${code_client} -  ${nom} `
           },
           ListAdherents() {
               axios.get('/api-admin/list-adherents-has-abonners').then((response) => {
                   this.list_adherents = response.data;
               });
           }, 
           Assurances() {
               if (typeof this.$refs.formContainer !== "undefined")
                   this.PluginLoader(false, this.$refs.formContainer)
               const current_page = (this.pagination.current_page) ? this.pagination.current_page : 1;
   
               this.formData = new FormData();
               /*if (this.value_id_adherent.length !== 0 )
                       this.formData.append("filtrer[code_client]", this.value_id_adherent.code_client);*/
   
   
               if (this.data_filtrer.nom != '')
                   this.formData.append("filtrer[nom]", this.data_filtrer.nom);
   
               if (this.data_filtrer.cin != '')
                   this.formData.append("filtrer[cin]", this.data_filtrer.cin);
   
               if (this.data_filtrer.matricule != '')
                   this.formData.append("filtrer[matricule]", this.data_filtrer.matricule);
   
               if (this.data_filtrer.genre != 'tous')
                   this.formData.append("filtrer[genre]", this.data_filtrer.genre);
   
   
   
               if (this.datetimePicker[0] != null && this.datetimePicker[1]) {
                   this.formData.append("filtrer[date][from]", this.data_filtrer.datetimes[0]);
                   this.formData.append("filtrer[date][to]", this.data_filtrer.datetimes[1]);
               }
               const config = { headers: { 'content-type': 'multipart/form-data' } }
               axios.post('/api-admin/adherents/assurances?page=' + current_page, this.formData, config).then((response) => {
                   this.count_adherents = response.data.adherents.total;
                   this.adherents_assuree = response.data.adherents.data;
                   this.pagination = response.data.adherents;
               });
           },
           filtrer(event) {
               if (this.datetimePicker[0] != null && this.datetimePicker[1]) {
                   const date = this.datetimePicker;
                   this.data_filtrer.datetimes = [date[0].toDateString(), date[1].toDateString()]
               }
               this.pagination = []
               this.Assurances(this.data_filtrer)
           },
           SupprimerAssuranceAdherent(id_assurance, index) {
               this.$fire(
                       this.AlertFire('delete')
                   ).then((result) => {
                       if (result.value) {
                           this.submitStatus = 'PENDING'
                           this.formData = new FormData();
                           this.formData.append('id_assurance', id_assurance); 
                           const config = { headers: { 'content-type': 'multipart/form-data' } }
                           axios.post('/api-admin/adherents/supprimer-assurance-adherent', this.formData, config).then(res => {
                                   switch (res.data.etat) {
                                       case false:
                                           this.AlertResponseFalse("Assurance", "Assurance n'existe pas", "warning")
                                           
                                           break;
                                       default:
                                           this.AlertResponseTrue("", "Assurance supprimer avec succès", "success");
                                          // window.location.reload();
                                           this.adherents_assuree.splice(index, 1);
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
           handleRangeClose() {
               this.showTimeRangePanel = false;
           },
           clearDataInputs() {
               this.datetimePicker = [null, null] //[new Date(new Date().getTime() - 365 * 24 * 60 * 60 * 1000), new Date(new Date().getTime() + 1 * 24 * 60 * 60 * 1000)]
               //this.value_id_adherent = []
               this.data_filtrer.nom = ''
               this.data_filtrer.matricule = ''
               this.data_filtrer.cin = ''
               this.data_filtrer.genre = 'tous'
               this.data_filtrer.datetimes = []
               this.pagination = []
               this.data_filtrer.code_client = null
               this.Assurances(this.data_filtrer)
 

           },
           FormEmpty() {
            this.eventAssuranceAdherent.$emit('empty')
        },
        ModifierAssurance(adherent, index) {
            this.eventAssuranceAdherent.$emit('empty')
             this.eventAssuranceAdherent.$emit('edit', { "adherent": adherent, "index": index })
        },
        RefreshListAssurance(newAssurance) {
            if (newAssurance != null) {
                this.adherents_assuree.unshift(newAssurance)
            }
        },
         
       },
       beforeMount() {
           this.ListAdherents()
   
           this.filtrer()
       },
       created: function() {
        this.eventAssuranceAdherent.$on('update', data => {
            if (data != null) {
                Vue.set(this.adherents_assuree, data.index, data.assurance)
            }
        })
    },
       computed: {
           filtrerAdherentsAssuree() {
               return this.adherents_assuree.filter(adherents => {
                   return adherents.code_client.toLowerCase().includes(this.search.toLowerCase())
   
               })
           },
       }
   }
   
</script>
<style>
   .liste-abn-avant-terminer .dropdown-item.active,
   .liste-abn-avant-terminer .dropdown-item:active {
   background-color: initial !important;
   }
   .historiques-assurance {
   font-size: 28px;
   color: #ff6028 !important;
   }
</style>

