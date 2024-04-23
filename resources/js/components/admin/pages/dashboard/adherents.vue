<template>
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-header ">
                <div class="row">
                    <div class="col-md-12">
                        <div class="d-flex justify-content-between">
                            <h3 class="card-title mb-0">Derniers adhérents inscrits </h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div  v-if="abonners.length>0" style="overflow-x:auto;" id="packs" class="tab-pane fade in active show">
                    <table  id="data-packs" class="datatables table table-striped table-bordered table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th>Photo</th>
                                <th> ID </th> 
<!--                                 
                                <th>{{ $t('content.pages.dashboard.adherents.tableau.matricule') }}</th> -->
                                <th>Nom   </th>
                                <th>Date de début   </th>
                                <th>Date de fin </th>
                                 <th>Jours restants</th>
                                <!--<th>{{ $t('content.pages.dashboard.adherents.tableau.genre') }}</th>-->
                            </tr>
                        </thead>
                        <tbody v-if="abonners">
                            <tr v-for="(abonner, index) in abonners"> 
                                
                                <td>
                                    <img class="photo-adherents" v-if="abonner.adherent.image != null" :src="'/clubi/public/admin/adherents/photos/' + abonner.adherent.image">
                                    <img class="photo-adherents"  v-else :src="`/clubi/public/admin/adherents/photos/${abonner.adherent.image}`">
                                </td>
                                <!-- <td>
                                    {{abonner.adherent.id_empreinte }}
                                </td> -->
                                <td>
                                    <router-link v-if="$can('Consulter la fiche d\'adhérent')" :to="{name: 'adherent', params:{code: abonner.adherent.id_empreinte }}">
                                        <a> {{ abonner.adherent.id_empreinte }} </a>
                                    </router-link>
                                    <span v-else>{{ abonner.adherent.id_empreinte }}</span>
                                </td>
                                <td>
                                    {{abonner.adherent.nom }}
                                </td>
                                <td >{{ abonner.date_debut | formatDate }}</td>
                                <td >{{ abonner.date_fin   | formatDate}}</td>
                                 <td >{{ abonner.RestDays }} j </td>
 

                                                    
                                <!--<td >
                                    <span >{{adherent.gender}}</span>
                                 </td>-->
                            </tr>
                        </tbody>
                    </table>
                    <div class="text-center m-3">
                        <router-link  :to="{name: 'adherents'}" class="afficher-plus" >
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
            abonners: []
        }
    },
    mounted() {},
    methods: {
        DernierAdherents() {
            axios.get('/api-admin/dashbaord/adherents').then((response) => {
                this.abonners = response.data;
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