<template>
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card text-white">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <ul class="timeline">
                            <li class="timeline-item">
                                <p class="timeline-content"><b>Empeches : </b> {{ empeches.empeche }} </p>
                            </li>
                            <li class="timeline-item">
                                <p class="timeline-content"><b>Nombre de jours : </b> {{ empeches.nb_jours }} {{$t('content.text.jours')}}</p>
                            </li>
                            <li class="timeline-item">
                                <p class="timeline-content"><b>Date de déclaration : </b> {{ new Date(empeches.created_at).toLocaleDateString() }} </p>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-4">
                        <ul class="timeline">
                            <li class="timeline-item">
                                <p class="timeline-content"><b>Date d'absence : </b> {{ new Date(empeches.date_absence).toLocaleDateString() }} </p>
                            </li>
                            <li class="timeline-item">
                                <p class="timeline-content"><b>Date de retour : </b> {{ new Date(empeches.date_retour).toLocaleDateString() }} </p>
                            </li>
                            <li class="timeline-item">
                                <p class="timeline-content"><b>Nouvelle date fin d'abonnement : </b> {{ new Date(empeches.date_fin).toLocaleDateString() }} </p>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-4  ">
                        <span style="color : #000 !important;"> {{ dateCheck(empeches.date_absence,empeches.date_retour) }} </span>
                        <div v-if='Date.now() < new Date(empeches.date_retour)' class="d-flex justify-content-center">
                            <img style="width : 20%;" src="/admin/payement-ok.png">
                        </div>
                        <div v-else class="d-flex justify-content-center">
                            <img style="width : 20%;" src="/admin/not-completed.jpg">
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
                return "Panding";
            }
            if (lDate <= cDate) {
                return "expire";
            }

            if ((cDate <= lDate && cDate >= fDate)) {
                return "Active";
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
