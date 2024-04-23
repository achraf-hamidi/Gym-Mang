<template>
    <div v-if="data.count" class="col-md-12 ">
<div class="row">
        <div class="col-md-4 grid-margin stretch-card ">
                        <div class="border-none cards bg-primary text-black">
                            <router-link   :to="{name: 'adherents'}" class="nav-link">
                            <div class="card-body pb-0">
                                <div class="d-flex justify-content-between">
                                    <h4 class="card-title mb-0">Total des adhérents</h4>
                                    <p class="font-weight-semibold mb-0"> </p>
                                </div>
                                <h3 class="font-weight-medium mb-4"> {{ data.count.adherents}}</h3>
                            </div>
                        </router-link>
                        </div>
                    </div>

                    <div class="col-md-4 grid-margin stretch-card "> 
                            
                        <div class="border-none cards bg-success text-black">
                            <router-link   :to="{name: 'abonnements-en-cours'}" class="nav-link">
                                <div class="card-body pb-0">
                                <div class="d-flex justify-content-between">
                                    <h4 class="card-title mb-0">Adhérents Actifs</h4>
                                    <p class="font-weight-semibold mb-0"> </p>
                                </div>
                                <h3 class="font-weight-medium mb-4"> {{ data.count.adherents_actif}}</h3>
                            </div>
                            </router-link>
                        </div>
                    </div>

                    <div class="col-md-4 grid-margin stretch-card ">
                        
                        <div class="border-none cards bg-danger text-black">
                            <router-link   :to="{name: 'abonnements-termines'}" class="nav-link">
                            <div class="card-body pb-0">
                                <div class="d-flex justify-content-between">
                                    <h4 class="card-title mb-0">Adhérents Inactifs</h4>
                                    <p class="font-weight-semibold mb-0"> </p>
                                </div>
                                <h3 class="font-weight-medium mb-4"> {{ data.count.adherents_inactif}}</h3>
                            </div>
                            </router-link>
                        </div>
                    
                    </div>

                </div>
            </div>
        <!--<div ref="formContainer" class="card">
            <div class="card-body">
                <div class="row">

                    



                    <div class="col-md-4">
                        <div class="d-flex align-items-center pb-2">
                            <div class="dot-indicator bg-dot-primary mr-2"></div>
                            <p class="mb-0 dot-font-size">Total des adhérents</p>
                        </div>
                        <h4 class="font-weight-semibold font-size-semibold">{{ data.count.adherents}}</h4>
                        <div class="progress progress-md">
                            <div class="progress-bar bg-dot-primary" role="progressbar" style="width: 100%"></div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="d-flex align-items-center pb-2">
                            <div class="dot-indicator bg-dot-success mr-2"></div>
                            <p class="mb-0 dot-font-size">Adhérents Actifs</p>
                        </div>
                        <h4 class="font-weight-semibold font-size-semibold">{{ data.count.adherents_actif}}</h4>
                        <div class="progress progress-md">
                            <div class="progress-bar bg-dot-success" role="progressbar" style="width: 100%"></div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="d-flex align-items-center pb-2">
                            <div class="dot-indicator bg-dot-danger mr-2"></div>
                            <p class="mb-0 dot-font-size">Adhérents Inactifs</p>
                        </div>
                        <h4 class="font-weight-semibold font-size-semibold">{{ data.count.adherents_inactif}}</h4>
                        <div class="progress progress-md">
                            <div class="progress-bar bg-dot-danger" role="progressbar" style="width: 100%"></div>
                        </div>
                    </div>

                   
                   
            </div>
        </div>
    </div>-->
</template>
<script>
export default {
    //  props: ['code'],
    data() {
        return {
            data: [],
            lang: {
                formatLocale: {
                    firstDayOfWeek: 1,
                },
                monthBeforeYear: false,
            },
            datetimePicker: null, // [new Date(new Date().getTime() - 1 * 24 * 60 * 60 * 1000), new Date(new Date().getTime() + 1 * 24 * 60 * 60 * 1000)],
            showTimeRangePanel: false,

            state: {
                disabledDates: {
                    to: new Date(2020, 0, 5), // Disable all dates up to specific date
                    from: new Date(), // Disable all dates after specific date
                    days: [6, 0], // Disable Saturday's and Sunday's
                }
            },
            data_filtrer: {
                datetimes: [],
            },
        }
    },
    mounted() {},
    methods: {
        DataCount() {
            if (typeof this.$refs.formContainer !== "undefined")
                this.PluginLoader(false, this.$refs.formContainer)

            this.formData = new FormData();

            if (this.datetimePicker != null) {
                const date = this.datetimePicker;
                this.formData.append("filtrer[date][from]", date[0].toDateString());
                this.formData.append("filtrer[date][to]", date[1].toDateString());
            }
            const config = { headers: { 'content-type': 'multipart/form-data' } }
            axios.post('/api-admin/dashbaord/count', this.formData, config).then((response) => {
                this.data = response.data;
            });
        },
        handleRangeClose() {
            this.showTimeRangePanel = false;
        },
        clearDataInputs() {
            this.selectedDate()
        },
        selectedDate() {
            var d = new Date();
            var currMonth = d.getMonth();
            var currDay = d.getDate();
            var currYear = d.getFullYear();
            this.datetimePicker = [new Date(currYear, 0, 1), new Date(currYear, currMonth, currDay)]
        },

    },
    beforeMount() {
        this.selectedDate()
        this.DataCount()
    },
    computed: {}
}

</script>
