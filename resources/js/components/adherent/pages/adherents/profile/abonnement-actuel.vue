<template>
    <div class="col-md-8 grid-margin stretch-card average-price-card">
        <div style="background: rgb(9, 0, 55) none repeat scroll 0% 0%;" class="card text-white">
            <div v-if="details_abonner && details_abonner.abonner" class="card-body">
                <div v-if="details_abonner.abonner.suspend == 0" class="d-flex justify-content-between pb-2 align-items-center">
                    <h2 class="font-weight-semibold mb-0" style="color : #fff !important;">{{$t('content.pages.adherents.profile.abonnement_actuel.titre')}}</h2>
                    <span>
                        <span v-if="Date.now() > new Date(details_abonner.abonner.date_fin)">
                            {{$t('content.pages.adherents.profile.abonnement_actuel.details.expire')}} :
                        </span>
                        {{ details_abonner.abonner.RestDays }} {{$t('content.pages.adherents.profile.abonnement_actuel.details.jours')}}
                    </span>
                    <span v-if="Date.now() > new Date(details_abonner.abonner.date_fin)" >
                        <router-link :to="{path: '/nouveau-abonnement', query:{matricule: code }}">
                            Renouvler
                        </router-link>
                    </span>
                </div>
                <div v-else style="background: #f74f4fe6 none repeat scroll 0% 0%;padding: 10px;border-radius: 5px;" class="d-flex justify-content-between pb-2 align-items-center">
                    <h2 class="font-weight-semibold mb-0" style="color : #fff !important;">
                        {{$t('content.pages.adherents.profile.abonnement_actuel.details.suspendre')}} 
                    </h2>
                    <span>
                        {{ details_abonner.abonner.suspended_at }}
                    </span>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="d-flex w-100  mt-4">
                            <p class="text-white mb-0 font-weight-semibold">{{$t('content.pages.adherents.profile.abonnement_actuel.details.date_debut')}}  : </p>
                            <div class="wrapper ml-auto d-flex align-items-center">
                                <p class="text-white font-weight-semibold mb-0"> {{ details_abonner.abonner.date_debut }} </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex w-100  mt-4">
                            <p class="text-white mb-0 font-weight-semibold">
                            {{$t('content.pages.adherents.profile.abonnement_actuel.details.date_fin')}} 
                             : </p>
                            <div class="wrapper ml-auto d-flex align-items-center">
                                <p class="text-white font-weight-semibold mb-0"> {{ details_abonner.abonner.date_fin }} </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex w-100  mt-4">
                            <p class="text-white mb-0 font-weight-semibold">
                            {{$t('content.pages.adherents.profile.abonnement_actuel.details.abonnement')}}  : </p>
                            <div class="wrapper ml-auto d-flex align-items-center">
                                <p class="text-white font-weight-semibold mb-0"> {{ details_abonner.abonnement.libelle }} </p>
                                <p class="text-white ml-1 mb-0"> ( {{ details_abonner.abonnement.nb_mois }} {{$t('content.text.mois')}} )</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex w-100  mt-4">
                            <p class="text-white mb-0 font-weight-semibold">{{$t('content.pages.adherents.profile.abonnement_actuel.details.packs')}}  : </p>
                            <div class="wrapper ml-auto d-flex align-items-center">
                                <p class="text-white font-weight-semibold mb-0"> {{ details_abonner.pack.description }} </p>
                                <p class="text-white ml-1 mb-0"> ( {{ parseFloat(details_abonner.pack.prix).toFixed(2) }} {{$t('content.text.dh')}} )</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex w-100  mt-4">
                            <p class="text-white mb-0 font-weight-semibold">{{$t('content.pages.adherents.profile.abonnement_actuel.details.remise')}}  : </p>
                            <div class="wrapper ml-auto d-flex align-items-center">
                                <p class="text-white font-weight-semibold mb-0"> {{ parseFloat(RemisePromo).toFixed(2) }} </p>
                                <p class="text-white ml-1 mb-0">{{$t('content.text.dh')}}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex w-100  mt-4">
                            <p class="text-white mb-0 font-weight-semibold">{{$t('content.pages.adherents.profile.abonnement_actuel.details.net_paye')}}  : </p>
                            <div class="wrapper ml-auto d-flex align-items-center">
                                <p class="text-white font-weight-semibold mb-0"> {{ NetPaye }} </p>
                                <p class="text-white ml-1 mb-0"> {{$t('content.text.dh')}}</p>
                            </div>
                        </div>
                    </div>
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
    props: ['code', 'details_abonner'],
    data() {
        return {
            // abonnement : []
        }
    },

    methods: {
        /*RevenuPaiements(code){
           axios.get('/api-admin/abonnement-actuel/'+this.code).then(res => {
               console.log(res.data)
               this.details_abonner = res.data
           });
        }*/
    },
    created() {
        console.log('created:', this.details_abonner)
    },
    mounted() {
        console.log('mounted:', this.details_abonner)
    },
    beforeUpdate() {
        console.log('beforeUpdate:', this.details_abonner)
    },
    computed: {
        RemisePromo() {
            //console.log(this.details_abonner.promotions)
            /*if (this.details_abonner.promotions) 
              return this.details_abonner.abonner.remise + this.details_abonner.promotions.remise;
            else
              return this.details_abonner.abonner.remise ;*/
            return this.details_abonner.abonner.remise + this.details_abonner.pack.pivot.promo;

        },
        NetPaye() {
            /*if (this.details_abonner.promotions) 
              return (this.details_abonner.abonnement.nb_mois * this.details_abonner.pack.prix) - (this.details_abonner.abonner.remise + this.details_abonner.promotions.remise)  ;
            else
              return (this.details_abonner.abonnement.nb_mois * this.details_abonner.pack.prix) - this.details_abonner.abonner.remise ;*/
            return parseFloat(parseFloat(  this.details_abonner.pack.prix) - parseFloat(this.details_abonner.abonner.remise + this.details_abonner.pack.pivot.promo)).toFixed(2);
            //return parseFloat(parseFloat(this.details_abonner.abonnement.nb_mois * this.details_abonner.pack.prix) - parseFloat(this.details_abonner.abonner.remise + this.details_abonner.pack.pivot.promo)).toFixed(2);
        }
    }
}

</script>
