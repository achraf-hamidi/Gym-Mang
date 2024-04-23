<template>
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card text-white">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12 mb-4">
                       <h5>Absence
                       </h5>
                    </div> 
                </div>
                <div class="row">
                    <div class="col-6">
                        <ul class="timeline">
                            <li class="timeline-item">
                                <p class="timeline-content"><b>Motif : </b> {{ empeches.empeche }} </p>
                            </li>
                            <li class="timeline-item">
                                <p class="timeline-content"><b>Nombre de jours : </b> {{ empeches.nb_jours }} </p>
                            </li>
                            <li class="timeline-item">
                                <p class="timeline-content"><b>Date de déclaration : </b> {{ empeches.created_at | formatDate  }} </p>
                            </li>
                            <li class="timeline-item">
                                <p class="timeline-content"><b>Date d'absence : </b> {{ empeches.date_absence | formatDate  }} </p>
                            </li>
                        </ul>
                    </div>
                    <div class="col-6">
                        <ul class="timeline">
                            
                            <li class="timeline-item">
                                <p class="timeline-content"><b>Date de retour : </b> {{ empeches.date_retour | formatDate  }} </p>
                            </li>
                            <li class="timeline-item">
                                <p class="timeline-content"><b>Ancienne date fin d'abonnement : </b> {{ empeches.old_date_fin_abonnement | formatDate  }} </p>
                            </li>
                            <li class="timeline-item">
                                <p class="timeline-content"><b>Nouvelle date fin d'abonnement : </b> {{ empeches.date_fin | formatDate  }} </p>
                            </li>
                            <li class="timeline-item">
                                <p class="timeline-content">
                                    <b>Statut : </b> <span style="color : #000 !important;"> {{ dateCheck(empeches.date_absence,empeches.date_retour) }} </span> 
                                </p>
                            </li>
                        </ul>
                    </div> 
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</template>
<script>
export default {
    props: ['code', 'empeches'],
    data() {
        return {
            // abonnement : []
            message: null
        }
    },

    methods: {
        /*RevenuPaiements(code){
           axios.get('/api-admin/abonnement-actuel/'+this.code).then(res => {
               console.log(res.data)
               this.details_abonner = res.data
           });
        }*/
        dateCheck() {
            var fDate, lDate, cDate;
            fDate = Date.parse(this.empeches.date_absence);
            lDate = Date.parse(this.empeches.date_retour);
            cDate = Date.parse(new Date);

  
            if (fDate > cDate) {
                return this.$t('content.pages.abonnements.empeches.liste.statut.attendant')
            }
            if (lDate <= cDate) {
                return this.$t('content.pages.abonnements.empeches.liste.statut.expire')
            }

            if ((cDate <= lDate && cDate >= fDate)) {
                return this.$t('content.pages.abonnements.empeches.liste.statut.active')
            }

        }
    },
    created() {
        console.log('created:', this.empeches)
    },
    mounted() {
        console.log('mounted:', this.empeches)
    },
    beforeUpdate() {
        console.log('beforeUpdate:', this.empeches)
        // this.dateCheck() 
    },
}

</script>
