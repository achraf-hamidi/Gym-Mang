<template>
    <div style="overflow: auto;" class="card">
        <div class="card-header ">
            <div class="row">
                <div class="col-md-12">
                    <div class="d-flex justify-content-between">
                        <h3 class="card-title mb-0">
                            {{ $t('content.pages.adherents.profile.historiques.paiements.titre') }}
                        </h3>
                        <!--<a href="javascript::void(0)" @click="allPaiements"><small>{{$t('content.bouton.afficher_tout')}}</small></a>-->
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body height-scroll"  :class="[ filterAbonners.length > 0 ? 'height-scroll' : '' ]"  >  
            <div v-if="filterAbonners.length > 0">
                <ul v-for="(abonner, index) in filterAbonners" class="timeline">
                    <li class="timeline-item" v-for="(paiement) in abonner.paiements">
                        <p class="timeline-content"> <b> {{ $t('content.pages.adherents.profile.historiques.paiements.tableau.date_paiement') }} </b>: {{ paiement.date_paiement | formatDate }} </p>
                        <p class="event-time">
                            <span>
                                <b>{{ $t('content.pages.adherents.profile.historiques.paiements.tableau.prix') }}</b> : {{ parseFloat(paiement.prix) }} {{$t('content.text.dh')}} </span>
                            </span>
                        </p>
                    </li>
                </ul>
                <div v-if="abonners.length > 0"  class="mt-5 text-center col-md-12">
                     <a :href="`/admin/reglements?adherent=${abonners[0].adherent.code_client}`" >Afficher tout </a>
                </div>
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
            console.log('id : ' + this.abonners[0].adherent.id)
              
        })
        this.eventProfile.$on('filtrer-paiements', data => {
            if (data == 'tous') { this.filterAbonners = this.abonners } else {
                this.filterAbonners = this.abonners.filter(abonner => {
                    return abonner.id == data
                })
            }
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
