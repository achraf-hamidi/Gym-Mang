<template>
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-header ">
                <div class="row">
                    <div class="col-md-12">
                        <div class="d-flex justify-content-between">
                            <h3 class="card-title mb-0">Derniers abonnements terminés </h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div v-if="terminers.length>0" style="overflow-x:auto;" id="packs" class="tab-pane fade in active show">
                    <table id="data-packs" class="datatables table table-striped table-bordered table-hover">
                        <thead class="thead-dark">
                            <tr>
                                
                                <th>Photo</th>
                                <th> ID</th>
                        
                                <th>Nom   </th>
                                <th>Date de début   </th>
                                <th>Date de fin </th>
                                <th>{{ $t('content.pages.dashboard.abonnement_terminer.tableau.jours') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(abonner, index) in terminers">
                                
                                <td>
                                    <img class="photo-adherents"  v-if="abonner.adherent.image != null" :src="`/admin/adherents/photos/${abonner.adherent.image}`">
                                    <img class="photo-adherents"  v-else :src="`/admin/adherents/photos/${abonner.adherent.image}`">
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
                                    {{abonner.adherent.nom}}
                                </td>
                                <td v-if="abonner">{{ abonner.date_debut | formatDate }}</td>
                                <td v-if="abonner">{{ abonner.date_fin | formatDate }}</td>
                                 <td v-if="abonner">{{ abonner.RestDays }} j  </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="text-center mt-3">
                    <router-link :to="{name: 'abonnements-termines'}" class="afficher-plus">
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
            terminers: []
        }
    },
    mounted() {},
    methods: {
        AbonnementsTerminers() {
            axios.get('/api-admin/dashboard/termines').then((response) => {
                this.terminers = response.data;
            });
        },
    },
    beforeMount() {
        this.AbonnementsTerminers()
    },
    computed: {}
}

</script>
