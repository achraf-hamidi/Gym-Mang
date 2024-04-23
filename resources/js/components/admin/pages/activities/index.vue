<template>
    <div class="main-panel">
          <div class="content-wrapper">
            <div class="row">
              <add-pack @RefreshListPacks="RefreshlistPacks($event)" :options_activities="activities" :packs="packs"></add-pack>
              <add-activitie  @RefreshListActivities="RefreshlistActivities($event)" :activities="activities" ></add-activitie>              
            </div>
            <div class="row">
                <div class="col-lg-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                          <h4 class="card-title"> </h4>
                          <ul class="nav nav-tabs">
                            <li class="active"><a class="active" data-toggle="tab" href="#packs"><h4 class="card-title">{{ $t('content.pages.activities.pack.table.heading') }}</h4></a></li>
                            <li><a data-toggle="tab" href="#activities"><h4 class="card-title">{{ $t('content.pages.activities.activitie.table.heading') }}</h4></a></li>
                          </ul>
                          <div class="tab-content">
                            <div id="packs" class="tab-pane fade in active show">
                                <br><br>
                                <div class="form-group mr-b-0em"><label class="form__label">Recherche</label> <input v-model="search_pack" placeholder="Price..." class="form-control"></div>
                                <table id="data-packs" class="datatables table table-striped table-bordered table-hover">
                                  <thead class="thead-dark">
                                    <tr>
                                      <th>{{ $t('content.pages.activities.pack.table.description') }}</th>
                                      <th>{{ $t('content.pages.activities.pack.table.price') }}</th>
                                      <th>{{ $t('content.pages.activities.pack.table.activities') }}</th>
                                      <th>{{ $t('content.pages.activities.pack.table.status') }}</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <tr v-for="(pack, index) in filteredListPackages">
                                      <td> {{ pack.description.substr(0, 45)}} </td>
                                      <td>{{ pack.prix }} DH</td>
                                      <td>
                                            <span v-for="(activitie, index) in pack.activities" >{{ activitie.libelle }} <span v-if="((index + 1) != pack.activities.length)" >,</span>  </span> 
                                      </td>
                                      <td>
                                        <label class="badge badge-danger">Pending</label>
                                      </td>
                                    </tr>
                                    
                                  </tbody>
                                </table>
                                <!--<vue-pagination :pagination="paginationPacks" @paginate="ListPacks()" :offset="4"></vue-pagination>-->
                            </div>
                            <div id="activities" class="tab-pane fade">
                              <br><br>
                                
                                <div class="form-group mr-b-0em"><label class="form__label">Recherche</label> <input v-model="search_activitie" placeholder="Price..." class="form-control"></div>

                                <table id="data-activities" class="datatables table table-striped table-bordered table-hover">
                                  <thead class="thead-dark">
                                    <tr>
                                      <th>{{ $t('content.pages.activities.activitie.table.image') }}</th>
                                      <th>{{ $t('content.pages.activities.activitie.table.libelle') }}</th>
                                      <th>{{ $t('content.pages.activities.activitie.table.status') }}</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <tr v-for="(activitie, index) in filteredListActivities">
                                      <td><img v-if="activitie.image != null" :src="`/admin/activities/${activitie.image}`"></td>
                                      <td>{{ activitie.name }}</td>
                                      <td>
                                        <label class="">{{ $t('content.bouton.modifier') }}</label>
                                      </td>
                                    </tr>
                                  </tbody>
                                </table>
                                <vue-pagination :pagination="paginationActivities" @paginate="ListActivities()" :offset="4"></vue-pagination>
                            </div>
                          </div>
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
                paginationActivities : [],
                paginationPacks : [],
                activities : [],
                packs : [],
                search_pack :'',
                search_activitie :'',
            }
        },
        mounted() {
            console.log('Component mounted.')
        },
        methods : {
            ListActivities(){
                const current_page = (this.paginationActivities.current_page) ? this.paginationActivities.current_page :  1 ;
                axios.get('/api-admin/activities?page='+current_page).then((response)=>{  
                    this.activities = response.data.data;
                    this.paginationActivities = response.data;
                    console.log(this.paginationActivities)
                });
            },
            ListPacks(){
                const current_page = (this.paginationPacks.current_page) ? this.paginationPacks.current_page :  1 ;
                axios.get('/api-admin/packs?page='+current_page).then((response)=>{  
                    this.packs = response.data;
                    //this.paginationPacks = response.data;
                   // console.log(this.paginationPacks)
                });
            },
            RefreshlistPacks(newPack){
                if (newPack != null ) {
                    this.packs.unshift(newPack)
                }
            },  
            RefreshlistActivities(newActivitie){
                if (newActivitie != null ) {
                    this.activities.unshift(newActivitie)

                    
                }
            },       
        },
        beforeMount(){ 
            this.ListActivities();
            this.ListPacks();
        },
        computed: {
            filteredListPackages() {
              return this.packs.filter(pack => {
                return pack.description.toLowerCase().includes(this.search_pack.toLowerCase()) 
                || pack.prix.toString().includes(this.search_pack.toLowerCase()) ||  pack.activities.find(activitie => {
                    return activitie.libelle.toLowerCase().includes(this.search_pack.toLowerCase())

                }) ;
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