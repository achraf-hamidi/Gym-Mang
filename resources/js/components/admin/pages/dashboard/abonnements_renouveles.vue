<template>
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-header ">
                <div class="row">
                    <div class="col-md-12">
                        <div class="d-flex justify-content-between">
                            <h3 class="card-title mb-0">Derniers abonnements renouvelés </h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div  v-if="adherents.length>0" style="overflow-x:auto;" id="packs" class="tab-pane fade in active show">
                    <table  id="data-packs" class="datatables table table-striped table-bordered table-hover">
                        <thead class="thead-dark">
                            <tr>
                                
                                <th>Photo</th>
                                <th> ID </th> 
                                <!-- <th>{{ $t('content.pages.dashboard.adherents.tableau.matricule') }}</th> -->
                                <th>Nom   </th>
                                <th>Date de début   </th>
                                <th>Date de fin </th>
                                 <th>Jours restants</th>
                                <!--<th>{{ $t('content.pages.dashboard.adherents.tableau.genre') }}</th>-->
                            </tr>
                        </thead>
                        <tbody v-if="adherents">
                            <tr v-for="(adherent, index) in adherents"> 
                               
                                <td>
                                    <img class="photo-adherents"  v-if="adherent.image != null" :src="`/clubi/public/admin/adherents/photos/${adherent.image}`">
                                    <img class="photo-adherents"  v-else :src="`/clubi/public/admin/adherents/photos/${adherent.image}`">
                                </td>
                                <!-- <td>
                                    {{adherent.id_empreinte }}
                                </td> -->
                                <td>
                                    <router-link v-if="$can('Consulter la fiche d\'adhérent')" :to="{name: 'adherent', params:{code: adherent.id_empreinte }}">
                                        <a> {{ adherent.id_empreinte }} </a>
                                    </router-link>
                                    <span v-else>{{ adherent.id_empreinte }}</span>
                                </td>
                                <td>
                                    {{adherent.nom }}
                                </td>
                                <td >{{ adherent.abonners[0].date_debut | formatDate }}</td>
                                <td >{{ adherent.abonners[0].date_fin   | formatDate}}</td>
                                 <td >{{ adherent.abonners[0].RestDays }} j </td>
 

                                                    
                                <!--<td >
                                    <span >{{adherent.gender}}</span>
                                 </td>-->
                            </tr>
                        </tbody>
                    </table>
                    <div class="text-center m-3">
                        <router-link  :to="{name: 'abonnements-renouveles'}" class="afficher-plus" >
                        <span>Afficher tout</span>
                    </router-link>
                    </div>
                </div>
                <div v-else class="aucune col-md-12">
                        <i class="mdi-style mdi mdi-alert"></i> {{$t('content.alerts.aucune_info')}}
                    </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    //  props: ['code'],
    data() {
        return {
            adherents: []
        }
    },
    mounted() {},
    methods: {
        DernierAdherents() {
            axios.get('/api-admin/dashbaord/abonnements-renouveles').then((response) => {
                this.adherents = response.data;
            });
        },
    },
    beforeMount() {
        this.DernierAdherents()
    },
    computed: {}
}

</script>

<style>

.photo-adherents {
    width: 42px!important;
    height: 42px!important;
    object-fit: cover!important;
}

</style>