<template>
   <div class="main-panel">
      <div v-if="$can('Consulter les activités') || $can('Consulter les packs')" class="content-wrapper">
         <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
               <div class="card">
                  <div class="card-body">
                     <div class="row mb-5">
                        <div class="col-md-12"> 
                           <nav> 
                              <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                 <a  v-if="$can('Consulter les activités')"  class="nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">
                                    <h1 class="card-title" style="top: 0px!important;">
                                       <span class="titres">
                                       Les activités sportives 
                                       </span>
                                    </h1>
                                 </a>
                                 <a  v-if="$can('Consulter les packs')" class="nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">
                                    <h1 class="card-title" style="top: 0px!important;">
                                       <span class="titres">
                                       Packs
                                       </span>
                                    </h1>
                                 </a>
                              </div>
                           </nav>
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-md-12">
                           <div class="tab-content" id="nav-tabContent">
                              <div v-if="$can('Consulter les activités')" class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                                 <div class="parametrages-tablette-mobile row">
                                    <add-activitie v-if="$can('Ajouter une activité') || $can('Modifier une activité')"  @RefreshListActivities="RefreshlistActivities($event)" :activities="activities"></add-activitie>
                                    <div class="col-md-8 ">
                                       <div class="row flex-grow">
                                          <div class="col-12">
                                             <div class="card">
                                                <div class="card-header ">
                                                   <div class="row">
                                                      <div class="col-md-12">
                                                         <h3>Liste des activités </h3>
                                                      </div>
                                                   </div>
                                                </div>
                                                <div class="card-body">
                                                   <div class="form-group mr-b-0em"><label class="form__label"><i class="mdi mdi-filter-outline"></i> {{$t('content.pages.parametrages.pack_activities.activities.liste.filtrer.titre')}}</label> <input v-model="search_activitie" :placeholder="$t('content.bouton.filtrer_recherche')" class="form-control"></div>
                                                   <div v-if="filteredListActivities.length>0" style="overflow-x:auto;" id="packs" class="tab-pane fade in active show">
                                                      <table id="data-activities" class="datatables table table-striped table-bordered table-hover">
                                                         <thead class="thead-dark">
                                                            <tr>
                                                               <!--<th>{{$t('content.pages.parametrages.pack_activities.activities.liste.tableau.image')}}</th>-->
                                                               <th>Nom d'activité</th>
                                                               <th class="text-center">{{$t('content.pages.parametrages.pack_activities.activities.liste.tableau.action')}}</th>
                                                            </tr>
                                                         </thead>
                                                         <tbody>
                                                            <tr v-for="(activitie, index) in filteredListActivities">
                                                               <!--<td><img v-if="activitie.image != null" :src="`/admin/activities/${activitie.image}`"></td>-->
                                                               <td>{{ activitie.name }}</td>
                                                               <td class="text-center">
                                                                  <span   v-if="$can('Modifier une activité')" @click="EditActivitie(activitie, index)" class="mdi-edit-btn"> <i class="mdi mdi-pen"></i> </span>
                                                                  <span  v-if="$can('Supprimer une activité')" @click="DeleteActivitie(activitie.id, index)" class="mdi-delete-btn"> <i class="mdi mdi-delete-forever"></i> </span>
                                                               </td>
                                                            </tr>
                                                         </tbody>
                                                      </table>
                                                      <vue-pagination :pagination="paginationActivities" @paginate="ListActivities()" :offset="4"></vue-pagination>
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
                              </div>
                              <div v-if="$can('Consulter les packs')" class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                                 <div class="row parametrages-tablette-mobile">
                                    <add-pack v-if="$can('Ajouter un pack') || $can('Modifier un pack')"  @RefreshlistPacks="RefreshlistPacks($event)" :packs="packs" :options_activities="activities"></add-pack>
                                    <div class="col-md-8 ">
                                       <div class="row flex-grow">
                                          <div class="col-12">
                                             <div class="card">
                                                <div class="card-header ">
                                                   <div class="row">
                                                      <div class="col-md-12">
                                                         <h3>{{$t('content.pages.parametrages.pack_activities.packs.titre')}}</h3>
                                                      </div>
                                                   </div>
                                                </div>
                                                <div class="card-body">
                                                   <div class="form-group mr-b-0em"><label class="form__label"><i class="mdi mdi-filter-outline"></i> {{$t('content.pages.parametrages.pack_activities.packs.liste.filtrer.titre')}}</label> <input v-model="search_pack" :placeholder="$t('content.bouton.filtrer_recherche')" class="form-control"></div>
                                                   <div v-if="filteredListPackages.length>0" style="overflow-x:auto;" id="packs" class="tab-pane fade in active show">
                                                      <table id="data-packs" class="datatables table table-striped table-bordered table-hover">
                                                         <thead class="thead-dark">
                                                            <tr>
                                                               <th>
                                                                  Nom de pack
                                                               </th>
                                                               <th>
                                                                  Abonnement
                                                               </th>
                                                               <th>
                                                                  Activités
                                                               </th>
                                                               
                                                               <th>
                                                                  {{ $t('content.pages.parametrages.pack_activities.packs.liste.tableau.prix')}}
                                                               </th>
                                                               <th>
                                                                  {{$t('content.pages.parametrages.pack_activities.packs.liste.tableau.action')}}
                                                               </th>
                                                            </tr>
                                                         </thead>
                                                         <tbody>
                                                            <tr v-for="(pack, index) in filteredListPackages">
                                                               <td> {{ pack.description.substr(0, 45)}} </td>
                                                               <td>
                                                                  <span v-if="pack.abonnement">
                                                                     {{ pack.abonnement.libelle }}
                                                                     {{ pack.abonnement.nb_mois }}
                                                                  </span>
                                                                     
                                                               </td>
                                                               <td>
                                                                  <span v-for="(activitie, index) in pack.activities">{{ activitie.name }} <span v-if="((index + 1) != pack.activities.length)">,</span> </span>
                                                               </td>
                                                               <td>{{ pack.prix }} {{$t('content.text.dh')}}</td>
                                                               <td>
                                                                  <span v-if="$can('Modifier un pack')" @click="EditPack(pack, index)" class="mdi-edit-btn"> <i class="mdi mdi-pen"></i> </span>
                                                                  <span v-if="$can('Supprimer un pack')" @click="DeletePack(pack.id, index)" class="mdi-delete-btn"> <i class="mdi mdi-delete-forever"></i> </span>
                                                               </td>
                                                            </tr>
                                                         </tbody>
                                                      </table>
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
                              </div>
                           </div>
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
   export default {
       data() {
           return {
               paginationActivities: [],
               paginationPacks: [],
               activities: [],
               packs: [],
               search_pack: '',
               search_activitie: '',
           }
       },
       mounted() {
           console.log('Component mounted.')
       },
       methods: {
           ListActivities() {
               const current_page = (this.paginationActivities.current_page) ? this.paginationActivities.current_page : 1;
               axios.get('/api-admin/parametrages/activities?page=' + current_page).then((response) => {
                   this.activities = response.data.data;
                   this.paginationActivities = response.data;
                   console.log(this.paginationActivities)
               });
           },
           ListPacks() {
               const current_page = (this.paginationPacks.current_page) ? this.paginationPacks.current_page : 1;
               axios.get('/api-admin/parametrages/packs?page=' + current_page).then((response) => {
                   this.packs = response.data;
                   //this.paginationPacks = response.data;
                   // console.log(this.paginationPacks)
               });
           },
           RefreshlistPacks(newPack) {
               if (newPack != null) {
                   this.packs.unshift(newPack)
               }
           },
           RefreshlistActivities(newActivitie) {
               if (newActivitie != null) {
                   this.activities.unshift(newActivitie)
   
   
               }
           },
           EditActivitie(activitie, index) {
               this.eventActivities.$emit('edit', { "activitie": activitie, "index": index })
           },
           EditPack(pack, index) {
               this.eventPacks.$emit('edit', { "pack": pack, "index": index })
           },
           DeleteActivitie(activitie_id, index) {
               this.$fire(
                   this.AlertFire('delete')
               ).then((result) => {
                   if (result.value) {
                       this.submitStatus = 'PENDING'
                       this.formData = new FormData();
                       this.formData.append('activitie_id', activitie_id);
                       const config = { headers: { 'content-type': 'multipart/form-data' } }
                       axios.post('/api-admin/parametrages/destroy-activitie', this.formData, config).then(res => {
                               switch (res.data) {
                                   case "relationship":
                                       this.AlertResponseFalse("",this.$t('content.alerts.activitie.affecter') , "warning")
                                       break;
                                   case false:
                                       this.AlertResponseFalse("", this.$t('content.alerts.activitie.n_existe'), "warning")
                                       break;
                                   default:
                                       this.AlertResponseTrue("",  "La suppression est effectué avec succès" , "success");
                                       this.activities.splice(index, 1)
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
           DeletePack(pack_id, index) {
               this.$fire(this.AlertFire('delete')).then((result) => {
                   if (result.value) {
                       this.submitStatus = 'PENDING'
                       this.formData = new FormData();
                       this.formData.append('pack_id', pack_id);
                       const config = { headers: { 'content-type': 'multipart/form-data' } }
                       axios.post('/api-admin/parametrages/destroy-pack', this.formData, config).then(res => {
                               switch (res.data) {
                                   case "relationship":
                                       this.AlertResponseFalse("", this.$t('content.alerts.pack.affecter'), "warning")
                                       break;
                                   case false:
                                       this.AlertResponseFalse("", this.$t('content.alerts.pack.n_existe'), "warning")
                                       break;
                                   default:
                                       this.AlertResponseTrue("",  "La suppression est effectué avec succès" , "success");
                                       this.activities.splice(index, 1)
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
       beforeMount() {
         if (this.$can('Consulter les activités'))
            this.ListActivities();
         if (this.$can('Consulter les packs'))
            this.ListPacks();
       },
       created: function() {
           this.eventActivities.$on('update', data => {
               if (data != null) {
                   Vue.set(this.activities, data.index, data.activitie)
               }
           })
   
           this.eventPacks.$on('update', data => {
               if (data != null) {
                   console.log(data)
                   Vue.set(this.packs, data.index, data.pack)
               }
           })
       },
       computed: {
           filteredListPackages() {
               return this.packs.filter(pack => {
                   return pack.description.toLowerCase().includes(this.search_pack.toLowerCase()) ||
                       pack.prix.toString().includes(this.search_pack.toLowerCase()) || pack.activities.find(activitie => {
                           return activitie.name.toLowerCase().includes(this.search_pack.toLowerCase())
   
                       });
               })
           },
           filteredListActivities() {
               return this.activities.filter(activitie => {
                   return activitie.name.toLowerCase().includes(this.search_activitie.toLowerCase())
               })
           }
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
</style>
