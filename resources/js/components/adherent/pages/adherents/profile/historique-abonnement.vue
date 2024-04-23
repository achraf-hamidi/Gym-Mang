<template>
    <div style="overflow: auto;" class="card">
        <div class="card-header ">
            <div class="row">
                <div class="col-md-12">
                    <div class="d-flex justify-content-between">
                        <h3 class="card-title mb-0">{{$t('content.pages.adherents.profile.historiques.abonnements.titre')}}</h3>
                        <a href="#"><small>{{$t('content.bouton.afficher_tout')}}</small></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body"> <br>
            <div v-if="abonners.length > 0" class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                             <th>{{$t('content.pages.adherents.profile.historiques.abonnements.tableau.date_debut')}}</th>
                            <th>{{$t('content.pages.adherents.profile.historiques.abonnements.tableau.date_fin')}}</th>
                            <th>{{$t('content.pages.adherents.profile.historiques.abonnements.tableau.remise')}}</th>
                            <!--<th>Abonnement</th>
                                <th>Pack</th>-->
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(abonner, index) in abonners"  @click="ListePaiementsbyAbonner(abonner.id)">
                             <td> {{ abonner.date_debut }} </td>
                            <td> {{ abonner.date_fin }} </td>
                            <td> {{ parseFloat(abonner.remise) }} {{$t('content.text.dh')}}</td>
                            <!--<td> {{  abonner.abonnements[0].libelle }}  {{abonner.abonnements.length}} </td> 
                                <td> {{ abonner.packs[0].description }} {{abonner.packs.length}} </td>-->
                        </tr>
                    </tbody>
                </table>
            </div>
            <div v-else class="aucune col-md-12">
                <i class="mdi-style mdi mdi-alert"></i> {{$t('content.alerts.aucune_info')}}
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props: ['code'],
    data() {
        return {
            abonners: []
        }
    },
    mounted() {
        //console.log(this.code)
    },
    methods: {
        HistoriquesAbonners() {
            axios.get('/api-adherent/historiques-abonners/' + this.code).then(res => {
                this.abonners = res.data
                console.log(res.data)
                this.eventProfile.$emit('list-paiements', this.abonners)
                this.eventProfile.$emit('list-activities', this.abonners)
            });
        },
        ListePaiementsbyAbonner(abonnerID) {
            this.eventProfile.$emit('filtrer-paiements', abonnerID)
            this.eventProfile.$emit('filtrer-activities', abonnerID)
        }
    },
    beforeMount() {
        this.HistoriquesAbonners();
    },
}

</script>
