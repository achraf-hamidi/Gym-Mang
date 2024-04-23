<template>
   <div class="main-panel">
      <div v-if="$can('Consulter les catégories des services') || $can('Consulter les services')" class="content-wrapper">
         <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
               <div class="card">
                  <div class="card-body">
                     <div class="row mb-5">
                        <div class="col-md-12">
                           <nav>
                              <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                 <a v-if="$can('Consulter les catégories des services')" class="nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">
                                    <h1 class="card-title" style="top: 0px!important;">
                                       <span class="titres">
                                       Catégories  
                                       </span>
                                    </h1>
                                 </a>
                                 <a v-if="$can('Consulter les services')" class="nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">
                                    <h1 class="card-title" style="top: 0px!important;">
                                       <span class="titres">
                                       Services
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
                              <div v-if="$can('Consulter les catégories des services')" class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                                 <div class="parametrages-tablette-mobile row">
                                    <add-categorie v-if="$can('Ajouter une catégorie') || $can('Modifier une catégorie')" @RefreshListcategories="RefreshListcategories($event)" :categories="categories"></add-categorie>
                                    <div class="col-md-8 d-flex align-items-stretch grid-margin">
                                       <div class="row flex-grow">
                                          <div class="col-12">
                                             <div class="card">
                                                <div class="card-header ">
                                                   <div class="row">
                                                      <div class="col-md-12">
                                                         <h3>Liste des catégories</h3>
                                                      </div>
                                                   </div>
                                                </div>
                                                <div class="card-body">
                                                   <div class="form-group mr-b-0em"><label class="form__label"><i class="mdi mdi-filter-outline"></i> Recherche</label> <input v-model="search_categorie" :placeholder="$t('content.bouton.filtrer_recherche')" class="form-control"></div>
                                                   <div v-if="filteredListcategories.length>0" style="overflow-x:auto;" id="services" class="tab-pane table-responsive fade in active show">
                                                      <table id="data-categories" class="datatables table table-striped table-bordered table-hover">
                                                         <thead class="thead-dark">
                                                            <tr>
                                                               <th>Nom</th>
                                                               <th>Description</th>
                                                               <th>Type</th>
                                                               <th>Action</th>
                                                            </tr>
                                                         </thead>
                                                         <tbody>
                                                            <tr v-for="(categorie, index) in filteredListcategories">
                                                               <td>{{ categorie.nom }}</td>
                                                               <td>{{ categorie.description }}</td>
                                                               <td>
                                                                  <span v-if="categorie.type_id == 1" >
                                                                  Recette
                                                                  </span>
                                                                  <span v-if="categorie.type_id == 2" >
                                                                  Dépences
                                                                  </span>
                                                               </td>
                                                               <td>
                                                                  <span  v-if="$can('Modifier une catégorie')" @click="Editcategorie(categorie, index)" class="mdi-edit-btn"> <i class="mdi mdi-pen"></i> </span>
                                                                  <span  v-if="$can('Supprimer une catégorie')" @click="Deletecategorie(categorie.id, index)" class="mdi-delete-btn"> <i class="mdi mdi-delete-forever"></i> </span>
                                                               </td>
                                                            </tr>
                                                         </tbody>
                                                      </table>
                                                      <vue-pagination :pagination="paginationcategories" @paginate="Listcategories()" :offset="4"></vue-pagination>
                                                   </div>
                                                   <div v-else class="aucune col-md-12">
                                                      <i class="mdi-style mdi mdi-alert"></i> Aucune information à afficher. 
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <div v-if="$can('Consulter les services')" class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                                 <div class="row parametrages-tablette-mobile">
                                    <add-service v-if="$can('Ajouter un service') || $can('Modifier un service')" @RefreshlistServices="RefreshlistServices($event)" :services="services" :options_categories="categories"></add-service>
                                    <div class="col-md-8 xd-flex align-items-stretch grid-margin">
                                       <div class="row flex-grow">
                                          <div class="col-12">
                                             <div class="card">
                                                <div class="card-header ">
                                                   <div class="row">
                                                      <div class="col-md-12">
                                                         <h3>Liste des services</h3>
                                                      </div>
                                                   </div>
                                                </div>
                                                <div class="card-body">
                                                   <div class="form-group mr-b-0em"><label class="form__label"><i class="mdi mdi-filter-outline"></i> Recherche</label> <input v-model="search_service" :placeholder="$t('content.bouton.filtrer_recherche')" class="form-control"></div>
                                                   <div v-if="filteredListServices.length>0" style="overflow-x:auto;" id="services" class="table-responsive tab-pane fade in active show">
                                                      <table style="width : 100%;" id="data-services" class="datatables table table-striped table-bordered table-hover">
                                                         <thead class="thead-dark">
                                                            <tr>
                                                               <th>
                                                                  Nom
                                                               </th>
                                                               <th>
                                                                  Déscription
                                                               </th>
                                                               <th>
                                                                  Prix 
                                                               </th>
                                                               <th>
                                                                  Catégorie
                                                               </th>
                                                               <th>
                                                                  Action
                                                               </th>
                                                            </tr>
                                                         </thead>
                                                         <tbody>
                                                            <tr v-for="(service, index) in filteredListServices">
                                                               <td> {{ service.nom}} </td>
                                                               <td>
                                                                  <span v-if="service.description != null && service.description != '' && service.description != 'null'" >{{ service.description.substr(0, 45)}} </span>
                                                               </td>
                                                               <td>{{ service.prix }} Dh</td>
                                                               <td>
                                                                  {{ service.categorie.nom }}
                                                                  <span v-if="service.categorie.type_id == 1" > (Recettes) </span>
                                                                  <span v-if="service.categorie.type_id == 2" > (Dépences) </span>
                                                               </td>
                                                               <td>
                                                                  <span v-if="$can('Modifier un service')" @click="EditService(service, index)" class="mdi-edit-btn"> <i class="mdi mdi-pen"></i> </span>
                                                                  <span v-if="$can('Supprimer un service')" @click="DeleteService(service.id, index)" class="mdi-delete-btn"> <i class="mdi mdi-delete-forever"></i> </span>
                                                               </td>
                                                            </tr>
                                                         </tbody>
                                                      </table>
                                                   </div>
                                                   <div v-else class="aucune col-md-12">
                                                      <i class="mdi-style mdi mdi-alert"></i> Aucune information à afficher. 
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
               paginationcategories: [],
               paginationservices: [],
               categories: [],
               services: [],
               search_service: '',
               search_categorie: '',
           }
       },
       mounted() {
           console.log('Component mounted.')
       },
       methods: {
           Listcategories() {
               const current_page = (this.paginationcategories.current_page) ? this.paginationcategories.current_page : 1;
               axios.get('/api-admin/parametrages/categories?page=' + current_page).then((response) => {
                   this.categories = response.data.data;
                   this.paginationcategories = response.data;
                   
               });
           },
           ListServices() {
               const current_page = (this.paginationservices.current_page) ? this.paginationservices.current_page : 1;
               axios.get('/api-admin/parametrages/services?page=' + current_page).then((response) => {
                   this.services = response.data;
                   //this.paginationservices = response.data;
                   // console.log(this.paginationservices)
                   console.log(response.data)
               });
           },
           RefreshlistServices(newService) {
               if (newService != null) {
                   this.services.unshift(newService)
               }
           },
           RefreshListcategories(newcategorie) {
               if (newcategorie != null) {
                   this.categories.unshift(newcategorie)
   
   
               }
           },
           Editcategorie(categorie, index) {
               this.eventcategories.$emit('edit', { "categorie": categorie, "index": index })
           },
           EditService(service, index) {
               this.eventservices.$emit('edit', { "service": service, "index": index })
           },
           Deletecategorie(categorie_id, index) {
               this.$fire(
                   this.AlertFire('delete')
               ).then((result) => {
                   if (result.value) {
                       this.submitStatus = 'PENDING'
                       this.formData = new FormData();
                       this.formData.append('categorie_id', categorie_id);
                       const config = { headers: { 'content-type': 'multipart/form-data' } }
                       axios.post('/api-admin/parametrages/destroy-categorie', this.formData, config).then(res => {
                           console.log(res.data)
                               switch (res.data) {
                                   case "relationship":
                                       this.AlertResponseFalse("", "Impossible de supprimer cet élément , car il existe encore des services affectés à cette catégorie", "warning")
                                       break;
                                   case false:
                                       this.AlertResponseFalse("", this.$t('content.alerts.categorie.n_existe'), "warning")
                                       break;
                                   default:
                                       this.AlertResponseTrue("",  this.$t('content.alerts.suppression.success') , "success");
                                       this.categories.splice(index, 1)
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
           DeleteService(service_id, index) {
               this.$fire(this.AlertFire('delete')).then((result) => {
                   if (result.value) {
                       this.submitStatus = 'PENDING'
                       this.formData = new FormData();
                       this.formData.append('service_id', service_id);
                       const config = { headers: { 'content-type': 'multipart/form-data' } }
                       axios.post('/api-admin/parametrages/destroy-service', this.formData, config).then(res => {
                               switch (res.data) {
                                   case "relationship":
                                       this.AlertResponseFalse("", "Impossible de supprimer cet élément , car il existe encore des recettes ou dépenses affectés à cet élement", "warning")
                                       break;
                                   case false:
                                       this.AlertResponseFalse("", this.$t('content.alerts.service.n_existe'), "warning")
                                       break;
                                   default:
                                       this.AlertResponseTrue("",  this.$t('content.alerts.suppression.success') , "success");
                                       this.services.splice(index, 1)
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
         if (this.$can('Consulter les catégories des services'))
            this.Listcategories();
         if (this.$can('Consulter les services'))
            this.ListServices();
       },
       created: function() {
           this.eventcategories.$on('update', data => {
               if (data != null) {
                   Vue.set(this.categories, data.index, data.categorie)
               }
           })
   
           this.eventservices.$on('update', data => {
               if (data != null) {
                   console.log(data)
                   Vue.set(this.services, data.index, data.service)
               }
           })
       },
       computed: {
           filteredListServices() {
               return this.services.filter(service => { 
                   return (service.nom.toString().includes(this.search_service.toLowerCase()) )
                   || ( service.description != null && service.description.toLowerCase().includes(this.search_service.toLowerCase()) )
               })
           },
           filteredListcategories() {
               return this.categories.filter(categorie => {
                   return categorie.nom.toLowerCase().includes(this.search_categorie.toLowerCase());
                  // || categorie.description.toLowerCase().includes(this.search_categorie.toLowerCase())
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

