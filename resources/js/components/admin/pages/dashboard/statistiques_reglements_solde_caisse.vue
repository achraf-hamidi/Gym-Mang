<template>
    <div class="col-md-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-header ">
                <div class="row">
                    <div class="col-md-12">
                        <div class="d-flex justify-content-between">
                            <h3 class="card-title mb-0">
                                
                                Statistiques des règlements des 3 derniers mois </h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div v-if="loaded && charts.sums">
                    <chart-pie  :background="charts.background" label="Somme total est " :labels="charts.months" :data="charts.sums"></chart-pie><br>
                    <div class="text-center mt-3">
                    <router-link  :to="{name: 'statistiques-reglements'}" class="afficher-plus" >
                        <span>Afficher tout</span>
                    </router-link>
                </div>
                </div>
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
            charts: {
                months: [],
                sums: [],
                background: [],
            },
            loaded: false,
            arr_background: ['#009c61', '#cc0099', '#cc9900', '#cc0033', '#0099cc', '#6600cc', '#66cc00', 'aqua', 'black', 'blue', 'fuchsia', 'gray', 'green',
                'lime', 'maroon', 'navy', 'olive', 'orange', 'purple',
                'silver', 'teal', 'white', 'yellow'
            ],
        }
    },
    mounted() {},
    methods: {
        StatistiquesActuel() {
            axios.get('/api-admin/dashboard/statistiques-reglements-solde-de-caisse').then((response) => {
                for (var i = 0; i < response.data.length; i++) {
                    this.charts.months.push(response.data[i].months)
                    this.charts.sums.push(parseFloat(response.data[i].sums))
                    this.charts.background.push(this.arr_background[i])
                }
                this.loaded = true
            }); 
        },
    },
    beforeMount() {
        this.StatistiquesActuel()
    },
    computed: {}
}

</script>
