<template>
    <div style="overflow: auto;" class="card">
        <div class="card-header ">
            <div class="row">
                <div class="col-md-12">
                    <div class="d-flex justify-content-between">
                        <h3 class="card-title mb-0">
                            {{ $t('content.pages.adherents.profile.historiques.paiements.titre') }}                            
                        </h3>
                        <a href="#"><small>{{$t('content.bouton.afficher_tout')}}</small></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body"> <br>
            <div v-if="filterAbonners.length > 0" class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>{{ $t('content.pages.adherents.profile.historiques.paiements.tableau.date_paiement') }}</th>
                            <th>{{ $t('content.pages.adherents.profile.historiques.paiements.tableau.prix') }}</th> 
                        </tr>
                    </thead>
                    <tbody v-for="(abonner, index) in filterAbonners">
                        <tr v-for="(paiement) in abonner.paiements">
                            <td> {{ paiement.date_paiement }} </td>
                            <td> {{ parseFloat(paiement.prix) }} {{$t('content.text.dh')}} </td>
                        </tr>
                    </tbody>
                </table>
                <!--<div class="total-paiement">
             <span> {{$t('content.pages.adherents.profile.historique.paiements.total')}} : </span> <span>  {{ total }} Dh </span>
          </div>-->
            </div>
            <div v-else class="aucune col-md-12">
                <i class="mdi-style mdi mdi-alert"></i> {{$t('content.alerts.aucune_info')}}
            </div>
        </div>
    </div>
</template>
<script>
export default {
    //  props: ['code'],
    data() {
        return {
            abonners: [],
            filterAbonners: [],
            montantTotal: 0
        }
    },
    mounted() {},
    methods: {
        allPaiements() {
            this.filterAbonners = this.abonners
        },
    },
    created: function() {
        this.eventProfile.$on('list-paiements', data => {
            this.abonners = data
            this.filterAbonners = this.abonners
        })
        this.eventProfile.$on('filtrer-paiements', data => {
            this.filterAbonners = this.abonners.filter(abonner => {
                return abonner.id == data
            })
        })
    },
    beforeMount() {},
    computed: {
        total() {
            return this.filterAbonners.reduce((acc, crypt) => {
                return crypt.paiements.reduce((accs, crypts) => {
                    acc = acc + crypts.prix
                    return parseFloat(acc)
                }, 0)
            }, 0)
        }
    }
}

</script>
