<template>
    <div class="col-md-8 grid-margin stretch-card">
        <div class="card">
            <div class="card-header ">
                <div class="row">
                    <div class="col-md-12">
                        <div class="d-flex justify-content-between">
                            <h3 class="card-title mb-0">
                                {{ $t('content.pages.adherents.profile.presences.titre') }}    
                            </h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body"> <br>
                <div class="row">
                    <div class="col-md-12">
                        <form @submit.prevent="PresencesAdherent($event)" class="forms-sample">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group mr-b-0em">
                                        <label class="form__label"> {{ $t('content.pages.adherents.profile.presences.recherche.date') }}    </label> <br>
                                        <date-picker style="width: 100%;" :show-time-panel="showTimeRangePanel" @close="handleRangeClose" v-model="datetimePicker" range type="datetime" format="YYYY-MM-DD"></date-picker>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-success mr-2"> <i class="mdi mdi-magnify"></i> {{ $t('content.bouton.recherche') }}</button>
                                    <a href="javascript:void(0)" class="btn btn-light">{{ $t('content.bouton.annuler') }}</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div><br> <br>
                <div>
                    <span><b> {{ $t('content.pages.adherents.profile.presences.visites') }}     :</b> </span> <span> {{ presences.length }} </span>
                </div>
                <div v-for="(presence, index) in presences" class="d-flex py-2 border-bottom">
                    <div class="wrapper">
                        <small class="text-muted"> {{ $t('content.pages.adherents.profile.presences.entrer') }}     : {{ presence.date_entrer }}</small>
                    </div>
                    <small class="text-muted ml-auto"> {{ $t('content.pages.adherents.profile.presences.sortier') }}     : {{ presence.date_sortier }}</small>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
 export default {
    props: ['code'],
    data() {
        return {
            lang: {
                formatLocale: {
                    firstDayOfWeek: 1,
                },
                monthBeforeYear: false,
            },
            datetimePicker: [new Date(new Date().getTime() - 10 * 24 * 60 * 60 * 1000), new Date(new Date().getTime() + 120 * 24 * 60 * 60 * 1000)],
            showTimeRangePanel: false,
            presences: [],
            data_filtrer: {
                datetimes: [],
            },
            formData: {}
        }
    },
    mounted() {
        console.log(this.code)
    },
    methods: {
        PresencesAdherent(code) {
            this.formData = new FormData(); 
            const config = { headers: { 'content-type': 'multipart/form-data' } }
            if (this.datetimePicker != null) {
                const date = this.datetimePicker;
                this.data_filtrer.datetimes = [date[0].toLocaleDateString(), date[1].toLocaleDateString()]
                this.formData.append("filtrer[date]", this.data_filtrer.datetimes);
            }
            axios.post('/api-adherent/presences/' + this.code, this.formData, config).then(res => {
                console.log(res.data) 
                this.presences = res.data
            });
        },
        handleRangeClose() {
            this.showTimeRangePanel = false;
        },
    },
    beforeMount() {
        this.PresencesAdherent(this.code);
    },
}

</script>
