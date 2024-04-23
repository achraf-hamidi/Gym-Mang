<template>
    <div class="main-panel">
        <div v-if="$can('Se désabonner')" class="content-wrapper">
            <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                    <div ref="formContainer" class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <h1 class="card-title">
                                        <i class="mdi-style-content mdi mdi-block-helper"></i>
                                        <span class="titre"> {{ $t('content.pages.abonnements.desabonner.titre') }} </span>
                                    </h1><br><br>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <form @submit.prevent="filtrer($event)" class="forms-sample">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group mr-b-0em">
                                                    <label class="form__label">{{ $t('content.pages.abonnements.desabonner.recherche.date') }} (Optionnel) </label> <br>
                                                    <date-picker style="width: 100%;" :show-time-panel="showTimeRangePanel" @close="handleRangeClose" v-model="datetimePicker" range type="datetime" format="DD/MM/YYYY"></date-picker>
                                                </div>
                                            </div>
                                            <div class="col-12 text-right">
                                                <button type="submit" class="btn btn-success mr-2"> <i class="mdi mdi-magnify"></i> {{ $t('content.bouton.recherche') }}</button>
                                                <a  @click="clearDataInputs" href="javascript:void(0)" class="btn btn-light">{{ $t('content.bouton.annuler') }}</a>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group mr-b-0em"><br>
                                        <label class="form__label"><i class="mdi mdi-filter-outline"></i> {{ $t('content.pages.abonnements.desabonner.filtrer.titre') }}</label>
                                        <input v-model="search_adherent" :placeholder="$t('content.pages.abonnements.desabonner.filtrer.placeholder')" class="form-control">
                                    </div>
                                </div>
                                <div v-if="filteredAbonnementsSuspended.length > 0" class="col-md-12">
                                    <div style="overflow-x:auto;" id="packs" class="tab-pane fade in active show">
                                        <table id="data-packs" class="datatables table table-striped table-bordered table-hover">
                                            <thead class="thead-dark">
                                                <tr>
                                                    <th>{{ $t('content.pages.abonnements.desabonner.tableau.matricule') }}</th>
                                                    <th>{{ $t('content.pages.abonnements.desabonner.tableau.nom') }}</th>
                                                    <th>{{ $t('content.pages.abonnements.desabonner.tableau.date_debut') }}</th>
                                                    <th>{{ $t('content.pages.abonnements.desabonner.tableau.date_fin') }}</th>
                                                    <th>{{ $t('content.pages.abonnements.desabonner.tableau.suspendre_at') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="(abonner, index) in filteredAbonnementsSuspended">
                                                    <td>
                                                        <router-link v-if="$can('Profile adhérent')" :to="{name: 'adherent', params:{code: abonner.adherent.code_client }}">
                                                            <a> {{ abonner.adherent.code_client }} </a>
                                                        </router-link>
                                                        <span v-else>{{ abonner.adherent.code_client }}</span>
                                                    </td>
                                                    <td> {{ abonner.adherent.nom }} </td>
                                                    <td>{{ abonner.date_debut| formatDate  }}</td>
                                                    <td>{{ abonner.date_fin| formatDate  }}</td>
                                                    <td>{{ abonner.suspended_at| formatDate  }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <vue-pagination :pagination="pagination" @paginate="AbonnementsSuspended(data_filtrer)" :offset="4"></vue-pagination>
                                </div>
                                <div v-else class="aucune col-md-12">
                                    <i class="mdi-style mdi mdi-alert"></i> {{$t('content.alerts.aucune_info')}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div v-else class="content-wrapper">
            <havent-permission></havent-permission>
        </div>
    </div>
</template>
<script>
import 'vue2-datepicker/index.css';
export default {
    data() {
        return {
            lang: {
                formatLocale: {
                    firstDayOfWeek: 1,
                },
                monthBeforeYear: false,
            },
            datetimePicker: [null, null],
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
            abonnments_suspended: [],
            pagination: [],
            packs: [],
            abonnements: [],
            search_adherent: '',
            formData: {},
        }
    },
    mounted() {
        console.log('Component mounted.')
    },
    methods: {
        AbonnementsSuspended(data_filtrer) {
            if (typeof this.$refs.formContainer !== "undefined")  
                this.PluginLoader(false, this.$refs.formContainer)
            const current_page = (this.pagination.current_page) ? this.pagination.current_page : 1;
            this.formData = new FormData();
            if (this.datetimePicker[0] != null && this.datetimePicker[1]) { 
                this.formData.append("filtrer[date][from]", this.data_filtrer.datetimes[0]);
                this.formData.append("filtrer[date][to]", this.data_filtrer.datetimes[1]);
            }

            const config = { headers: { 'content-type': 'multipart/form-data' } }
            axios.post('/api-admin/abonners/suspend?page=' + current_page, this.formData, config).then((response) => {
                this.abonnments_suspended = response.data.data;
                this.pagination = response.data;
                console.log(this.pagination)
            });
        },
        RefreshAbonnementsSuspended(newAdherents) {
            if (newAdherents != null) {
                this.abonnments_suspended.unshift(newAdherents)
            }
        },
        filtrer(event) {
            if (this.datetimePicker[0] != null && this.datetimePicker[1]) {
                const date = this.datetimePicker;
                this.data_filtrer.datetimes = [date[0].toDateString(), date[1].toDateString()]
            }
            this.pagination = []
            this.AbonnementsSuspended(this.data_filtrer)
        },
        handleRangeClose() {
            this.showTimeRangePanel = false;
        },
        clearDataInputs(){
            this.datetimePicker = null // [new Date(new Date().getTime() - 1 * 24 * 60 * 60 * 1000), new Date(new Date().getTime() + 365 * 24 * 60 * 60 * 1000)] 
        }
    },
    created: function() {
        this.eventAbonner.$on('update', data => {
            if (data != null) {
                Vue.set(this.abonnments_suspended, data.index, data.abonnments_suspended)
            }
        })
    },
    beforeMount() {
        this.filtrer();
    },
    computed: {
        filteredAbonnementsSuspended() {
            return this.abonnments_suspended.filter(abonner => {
                return abonner.adherent.code_client.toLowerCase().includes(this.search_adherent.toLowerCase()) ||
                    abonner.adherent.cin.toLowerCase().includes(this.search_adherent.toLowerCase()) ||
                    abonner.adherent.nom.toString().toLowerCase().includes(this.search_adherent.toLowerCase()) ||
                    abonner.adherent.gender.toString().toLowerCase().includes(this.search_adherent.toLowerCase()) ||
                    abonner.adherent.email.toString().toLowerCase().includes(this.search_adherent.toLowerCase());
            })
        },
    }
}

</script>
<style>
.nav.nav-tabs li {
    margin-left: 8px;
    position: relative;
    margin-bottom: 15px;
}

.nav.nav-tabs li a {
    text-decoration: none;
}


.nav.nav-tabs li a.active:after {
    content: '';
    width: 100%;
    position: absolute;
    height: 2px;
    background: #000;
}

.number {
    width: 33.333333% !important;
    display: inline-block;
    margin-bottom: 15px;
}

.resActive {
    background-color: #00b000;
    color: #fff;
}


.line {
    margin-bottom: 5px;

    text-align: center;
    counter-increment: line;
    position: relative;
    padding-left: 40px;
    padding-right: 40px;
}

.line div {
    border: 1px solid #ccc;

}

.line div:before {

    content: counter(line);
    position: absolute;
    left: 6px;
    top: 0px;
    background: #000;
    color: #fff;
    width: 35px;
    height: 51px;
    display: flex;
    justify-content: center;
    align-items: center;

}

.line button {
    border-radius: 50%;
    width: 40px;
    height: 40px;
    margin: 4px;
    border: none;
    outline: none;
}

</style>
