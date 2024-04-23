<template>
    <div class="col-md-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-header ">
                <div class="row">
                    <div class="col-md-12">
                        <div class="d-flex justify-content-between">
                            <h3 class="card-title mb-0">{{ $t('content.pages.adherents.profile.activities.titre') }}</h3>
                            <!--<a href="javascript::void(0)" @click="allActivities"><small>{{$t('content.bouton.afficher_tout')}}</small></a>-->
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body" :class="[ filterAbonners.length > 0 ? 'height-scroll' : '' ]">  
                <ul v-if="filterAbonners.length > 0" class="timeline">
                    <li class="timeline-item" v-for="(abonner, index) in filterAbonners">
                        <p class="timeline-content"> <b> {{ $t('content.pages.adherents.profile.activities.abonnement') }} {{ abonner.abonnements[0].libelle }}, {{ abonner.packs[0].description }} </b></p>
                        <p class="event-time">
                            <span v-for="(activitie, i) in abonner.packs[0].activities">
                                {{ activitie.name }} <span v-if="((i + 1) != abonner.packs[0].activities.length)">,</span>
                            </span>
                        </p>
                    </li>
                </ul>
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
            abonners: [],
            filterAbonners: []
        }
    },
    mounted() {},
    methods: {
        allActivities() {
            this.filterAbonners = this.abonners
        },
    },
    created: function() {
        this.eventProfile.$on('list-activities', data => {
            this.abonners = data
            this.filterAbonners = this.abonners
            console.log(this.abonners)
        })
        this.eventProfile.$on('filtrer-activities', data => {
            if (data == 'tous') { this.filterAbonners = this.abonners } 
            else {
                this.filterAbonners = this.abonners.filter(abonner => {
                    return abonner.id == data
                })
            }
        })
    },
    beforeMount() {},
    computed: {
        /* total () {
           return this.filterAbonners.reduce( (acc, crypt) => {
            return crypt.paiements.reduce( (accs, crypts) => { 
               acc =  acc + crypts.prix
                return parseFloat(acc).toFixed(2)
             }, 0)
            }, 0)
         }*/
    }
}

</script>
