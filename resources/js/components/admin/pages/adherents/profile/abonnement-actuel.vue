<template>
    <div class="col-md-6 grid-margin stretch-card average-price-card">
        <div class="border-none abonnement-actule card text-white">
            <div v-if="details_abonner && details_abonner.abonner" class="card-body">
                <div v-if="details_abonner.abonner.suspend == 0" class="d-flex justify-content-between pb-2 align-items-center">
                    <h2 class="font-weight-semibold mb-0" style="color : #fff !important;">{{$t('content.pages.adherents.profile.abonnement_actuel.titre')}}</h2>
                    
                    
                </div>
                <div v-else style="background: #f74f4fe6 none repeat scroll 0% 0%;padding: 10px;border-radius: 5px;" class="d-flex justify-content-between pb-2 align-items-center">
                    <h2 class="font-weight-semibold mb-0" style="color : #fff !important;">
                        {{$t('content.pages.adherents.profile.abonnement_actuel.details.suspendre')}} 
                    </h2>
                    <span>
                        {{ details_abonner.abonner.suspended_at | formatDate  }}
                    </span>
                </div>
                <div class="row height-100">
                    <div class="col-md-12">
                        <div class="d-flex w-100  mt-4">
                            <p class="text-white mb-0 font-weight-semibold">Date de début : </p>
                            <div class="wrapper ml-auto d-flex align-items-center">
                                <p class="text-white font-weight-semibolds mb-0"> {{ details_abonner.abonner.date_debut | formatDate }} </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="d-flex w-100  mt-4">
                            <p class="text-white mb-0 font-weight-semibold">
                            Date de fin : </p>
                            <div class="wrapper ml-auto d-flex align-items-center">
                                <p class="text-white font-weight-semibolds mb-0"> {{ details_abonner.abonner.date_fin | formatDate }} </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="d-flex w-100  mt-4">
                            <p class="text-white mb-0 font-weight-semibold">
                            Jours restants : </p>
                            <div class="wrapper ml-auto d-flex align-items-center">

                                <p class="text-white font-weight-semibolds mb-0">
                                    <span v-if="details_abonner.abonner.RestDays < 0">
                                        {{$t('content.text.jours_terminer')}}
                                    </span>
                                    <span v-else >
                                        {{ details_abonner.abonner.RestDays }} {{$t('content.text.jours')}}
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>

                    
                    <div class="col-md-12">
                        <div class="d-flex w-100  mt-4">
                            <p class="text-white mb-0 font-weight-semibold">
                            {{$t('content.pages.adherents.profile.abonnement_actuel.details.abonnement')}}  : </p>
                            <div class="wrapper ml-auto d-flex align-items-center">
                                <p class="text-white font-weight-semibolds mb-0"> {{ details_abonner.abonnement.libelle }} </p>
                                <p class="text-white ml-1 mb-0"> ( {{ details_abonner.abonnement.nb_mois }} {{ $t('content.text.mois') }} )</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="d-flex w-100  mt-4">
                            <p class="text-white mb-0 font-weight-semibold">Pack : </p>
                            <div class="wrapper ml-auto d-flex align-items-center">
                                <p class="text-white font-weight-semibolds mb-0"> {{ details_abonner.pack.description }} </p>
                                <p class="text-white ml-1 mb-0"> ( {{ parseFloat(details_abonner.pack.prix).toFixed(2) }} {{$t('content.text.dh')}} )</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="d-flex w-100  mt-4">
                            <p class="text-white mb-0 font-weight-semibold">{{$t('content.pages.adherents.profile.abonnement_actuel.details.remise')}}  : </p>
                            <div class="wrapper ml-auto d-flex align-items-center">
                                <p class="text-white font-weight-semibolds mb-0"> {{ parseFloat(RemisePromo).toFixed(2) }} </p>
                                <p class="text-white ml-1 mb-0">{{$t('content.text.dh')}}</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-12">
                        <div class="d-flex w-100  mt-4">
                            <p class="text-white mb-0 font-weight-semibold">Les frais ajoutés   : </p>
                            <div class="wrapper ml-auto d-flex align-items-center"> 

                                <div v-if="details_abonner.abonner.frais" >
                                    <span v-for="(frais, index) in details_abonner.abonner.frais">
                                    <span> {{ frais.NomFrais }} ,</span>
                                </span>
                                </div> 
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="d-flex w-100  mt-4">
                            <p class="text-white mb-0 font-weight-semibold">Total des frais  : </p>
                            <div class="wrapper ml-auto d-flex align-items-center">
                                <p class="text-white font-weight-semibolds mb-0"> {{ parseFloat(details_abonner.abonner.total_frais).toFixed(2) }} </p>
                                <p class="text-white ml-1 mb-0">{{$t('content.text.dh')}}</p>
                            </div>
                        </div>
                    </div>


                    <div class="col-md-12">
                        <div class="d-flex w-100  mt-4">
                            <p class="text-white mb-0 font-weight-semibold">{{$t('content.pages.adherents.profile.abonnement_actuel.details.net_paye')}}  : </p>
                            <div class="wrapper ml-auto d-flex align-items-center">
                                <p class="text-white font-weight-semibolds mb-0"> {{ NetPaye }} </p>
                                <p class="text-white ml-1 mb-0"> {{$t('content.text.dh')}}</p>
                            </div>
                        </div>
                    </div>
                    <div class="mt-5 text-left col-md-12">
                        <!-- v-if="Date.now() > new Date(details_abonner.abonner.date_fin)" -->
                        <span  >
                            
                        </span>
                    </div>
                     

                    <div class="col-md-12">
                        <div class="row"> 
                                 <div class="col-12">
                                    <div class="form-group mr-b-0em">
                                        <router-link class="btn-width-100 btn btn-danger"  :to="{name: 'nouveau-abonnement', query:{matricule: code }}">
                                Renouveler un abonnement
                            </router-link>
                                    </div>
                                </div>
                                <div v-if="reste_a_payer > 0" class="col-md-12">
                                    <div  class="row">
                                    
                                <div class="col-6">
                                    <div class="form-group mr-b-0em"> 
                                         <router-link v-if="$can('Régler les impayés')"  :to="{name: 'impayes', query : { adherent : `${code}` }}" class="btn-width-100 btn btn-success ">
                                           Régler le paiement
                                         </router-link>
                                    </div>
                                </div>
                                <!--:class="[(reste_a_payer > 0 && $can('Régler les impayés')) ? 'col-6' : 'col-12' ]"-->
                                <div class="col-6">
                                    <div class="form-group mr-b-0em">
                                        <span class="btn-width-100 btn btn-success " @click="RappelPaiement(details_abonner.abonner.id, details_abonner.abonner.adherent)" > <i class=" mdi mdi-send"></i> Rappel de paiement</span>
                                    </div>
                                </div>
                                 </div>
                                </div>
                             
                     </div>
                    </div>

                </div>
            </div>
            <div v-else class="aucune col-md-12" style="color : #fff !important;">
                <i class="mdi-style mdi mdi-alert" style="color : #fff !important;"></i> {{$t('content.alerts.aucune_info')}}
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props: ['code', 'details_abonner', 'reste_a_payer'],
    data() {
        return {
            // abonnement : []
        }
    },

    methods: {
        /*RevenuPaiements(code){
           axios.get('/api-admin/abonnement-actuel/'+this.code).then(res => {
               ///console.log(res.data)
               this.details_abonner = res.data
           });
        }*/
        RappelPaiement(id_abonner, adherent) {
            if(adherent.email != '' && adherent.email != null) {
                this.$fire(this.AlertFire('envoi_mail')).then((result) => {
                    if (result.value) 
                        window.location.href = "/api-admin/rappel-de-paiement/"+id_abonner
                });
            }else{
                this.AlertResponseFalse("", "L'e-mail est vide", "warning");
            }

            
        }
    },
    created() {
        ///console.log('created:', this.details_abonner)
    },
    mounted() {
         ///console.log(this.details_abonner)
    },
    beforeUpdate() {
        ///console.log('beforeUpdate:', this.details_abonner)
    },
    computed: {
        RemisePromo() { 
            return [ parseFloat( this.details_abonner.abonner.remise ) + parseFloat(this.details_abonner.pack.pivot.promo) ]
        },
        NetPaye() { 
            //return (parseFloat(this.details_abonner.abonnement.nb_mois * this.details_abonner.pack.prix) -  this.RemisePromo ) + this.details_abonner.abonner.total_frais
            return this.details_abonner.abonner.prix_ttc
        }
    }
}

</script>
