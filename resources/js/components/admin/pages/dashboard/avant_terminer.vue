<template>
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-header ">
                <div class="row">
                    <div class="col-md-12">
                        <div class="d-flex justify-content-between">
                            <h3 class="card-title mb-0">
                                Abonnements prochainement expirés
                            </h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div v-if="avantFindate.length>0" style="overflow-x:auto;" id="packs" class="tab-pane fade in active show">
                    <table id="data-packs" class="datatables table table-striped table-bordered table-hover">
                        <thead class="thead-dark">
                            <tr>
                                
                                <th>Photo</th>
                                <th> ID</th>
                                <!-- <th>{{ $t('content.pages.dashboard.abonnement_avant_terminer.tableau.matricule') }}</th> -->
                                <th>Nom</th>
                                <!--<th>{{ $t('content.pages.dashboard.abonnement_avant_terminer.tableau.date_debut') }}</th>-->
                                
                                 <th>Date de fin </th>
                                <th>{{ $t('content.pages.dashboard.abonnement_avant_terminer.tableau.jours') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(abonner, index) in avantFindate">
                                
                                <td>
                                    <img class="photo-adherents"  v-if="abonner.adherent.image != null" :src="`/admin/adherents/photos/${abonner.adherent.image}`">
                                    <img class="photo-adherents"  v-else :src="`/admin/adherents/photos/${abonner.adherent.image}`">
                                </td>
                                <!-- <td>
                                    {{abonner.adherent.id_empreinte }}
                                </td> -->
                                <td>
                                    <router-link v-if="$can('Consulter la fiche d\'adhérent')" :to="{name: 'adherent', params:{code: abonner.adherent.id_empreinte }}">
                                        {{ abonner.adherent.id_empreinte }}
                                    </router-link>
                                    <span v-else>{{ abonner.adherent.id_empreinte }}</span>
                                </td>
                                <td v-if="abonner">{{ abonner.adherent.nom }}</td>
                                <!--<td v-if="abonner">{{ abonner.date_debut | formatDate }}</td>-->
                                <td v-if="abonner">{{ abonner.date_fin | formatDate }}</td>
                                <td v-if="abonner">{{ abonner.RestDays }} j   </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="text-center mt-3">
                    <router-link :to="{name: 'abonnements-avant-terminer'}" class="afficher-plus">
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
            avantFindate: [],
            datetimePicker: [new Date(new Date().getTime() - 24 * 60 * 60 * 1000), new Date(new Date().getTime() + 4 * 24 * 60 * 60 * 1000)],
            formData: {}
        }
    },
    mounted() {},
    methods: {
        AbonnementsAvantFinDate() {
            this.formData = new FormData();
            const config = { headers: { 'content-type': 'multipart/form-data' } }

            //if (this.datetimePicker != null) {
            const date = this.datetimePicker;


            console.log( date[0].toDateString())
             console.log( "date : b")
             console.log( date[1].toDateString())


            this.formData.append("filtrer[date][from]", date[0].toDateString());
            this.formData.append("filtrer[date][to]", date[1].toDateString());

            //}

            axios.post('/api-admin/dashboard/avant-fin-date?take=8', this.formData, this.config).then((response) => {
                this.avantFindate = response.data;
            });
        },
        selectedDate() {
            var d = new Date();
            var currMonth = d.getMonth();
            var currDay = d.getDate();
            var currYear = d.getFullYear();
            this.datetimePicker = [new Date(new Date().getTime() - 24 * 60 * 60 * 1000), new Date(new Date().getTime() + 16 * 24 * 60 * 60 * 1000)]
        }
    },
    beforeMount() {
        //this.selectedDate()
        this.AbonnementsAvantFinDate()
    },

    computed: {}
}

</script>
