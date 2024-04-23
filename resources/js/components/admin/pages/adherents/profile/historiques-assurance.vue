<template>
    <div ref="formContainer" class="card">
        <div class="card-header ">
            <div class="row">
                <div class="col-md-12">
                    <div class="d-flex justify-content-between">
                        <h3 class="card-title mb-0"> Historique d'assurance </h3>
                         
                        <router-link v-if="code && $can('Consulter les details d’une assurance')"  style="padding : 0px!important;"   :to="{name: 'assurance-adherent', params : { code : `${code}` }}" class="nav-link">
                           Voir détails
                         </router-link>

                    </div>

                </div>
            </div>
        </div>
        <div class="card-body">
            <!--<div class="row">
                <div class="col-md-12">
                    <form @submit.prevent="filtrer($event)" class="forms-sample">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group mr-b-0em">
                                    <label class="form__label">{{$t('content.pages.adherents.badges.recherche.date')}} : </label> <br>
                                    <date-picker style="width: 100%;" :show-time-panel="showTimeRangePanel" @close="handleRangeClose" v-model="datetimePicker" range type="datetime" format="DD/MM/YYYY"></date-picker>
                                </div>
                            </div>
                            <div class="col-12 text-right">
                                <button type="submit" class="btn btn-success mr-2"> <i class="mdi mdi-magnify"></i> {{ $t('content.bouton.recherche') }}</button>
                                <a @click="clearDataInputs" href="javascript:void(0)" class="btn btn-light">{{ $t('content.bouton.annuler') }}</a>
                            </div>
                        </div>
                    </form><br>
                </div>
            </div>-->
            <div class="row">
                <div v-if="adherent_assurees.length > 0" class=" table-responsive col-md-12">
                    <table id="data-packs" class="datatables table table-striped table-bordered table-hover">
                        <thead class="thead-dark">
                            <tr>
                                 <th>Date de déclaration</th>
                                <th>Date de fin</th>
                                <th>Jours restants</th>
                                <th>Prix </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(assurance, index) in adherent_assurees">
                                 <td>
                                    {{ assurance.date_assuree | formatDate }}
                                </td>
                                <td>
                                    {{ assurance.date_fin | formatDate }}
                                </td>
                                <td>
                                     <label v-if="assurance.RestDays > 0" >
                                            {{ assurance.RestDays }} {{$t('content.text.jours')}}
                                    </label>
                                    <label v-else >
                                        {{$t('content.text.jours_terminer')}}
                                    </label>
                                </td>
                                <td>
                                    {{ assurance.prix }} {{$t('content.text.dh')}}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <!--<vue-pagination :pagination="pagination" @paginate="Assurances(data_filtrer)" :offset="4"></vue-pagination>-->
                </div>
                <div v-else class="aucune col-md-12">
                    <i class="mdi-style mdi mdi-alert"></i> {{$t('content.alerts.aucune_info')}}
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import { required, minLength, numeric, decimal, between, maxLength, email } from 'vuelidate/lib/validators'
import 'vue2-datepicker/index.css';
export default {
    props: ['code'],
    data() {
        return {
            adherent_assurees: [],
            datetimePicker: [new Date(new Date().getTime() - 1460 * 24 * 60 * 60 * 1000), new Date(new Date().getTime() + 1 * 24 * 60 * 60 * 1000)],
            showTimeRangePanel: false,
            formData: {},
            search: '',
            data_filtrer: {
                datetimes: [],
                code_client: null
            },
            pagination: [],
            submitStatus: '',
            index_row: 0
        }
    },
    mounted() {},
    methods: {
        Assurances() {
            if (typeof this.$refs.formContainer !== "undefined")
                this.PluginLoader(false, this.$refs.formContainer)
            //const current_page = (this.pagination.current_page) ? this.pagination.current_page : 1;
            //this.index_row = (this.pagination.current_page) ? ((this.pagination.current_page - 1) * 12) + 1 : 1;
            //console.log(' index_row :  ' + this.index_row)
            this.formData = new FormData();

            //if (this.datetimePicker != null) {
            //    this.formData.append("filtrer[date][from]", this.data_filtrer.datetimes[0]);
            //    this.formData.append("filtrer[date][to]", this.data_filtrer.datetimes[1]);
            //}

            this.formData.append("filtrer[take]", 8);

            const config = { headers: { 'content-type': 'multipart/form-data' } }
            axios.post('/api-admin/adherents/assurance/' + this.code , this.formData, config).then((response) => {
                this.adherent_assurees = response.data.assurances;
                //console.log(response.data)
                //this.pagination = response.data.assurances;
            });
            // }
        },
        filtrer(event) {
            if (this.datetimePicker != null) {
                const date = this.datetimePicker;
                this.data_filtrer.datetimes = [date[0].toDateString(), date[1].toDateString()]
            }
            this.pagination = []
            this.Assurances(this.data_filtrer)
        },
        handleRangeClose() {
            this.showTimeRangePanel = false;
        },
        clearDataInputs() {
            this.datetimePicker = [new Date(new Date().getTime() - 365 * 24 * 60 * 60 * 1000), new Date(new Date().getTime() + 1 * 24 * 60 * 60 * 1000)]
        }
    },
    beforeMount() {
        this.filtrer()
    },
}

</script>
<style>
.liste-abn-avant-terminer .dropdown-item.active,
.liste-abn-avant-terminer .dropdown-item:active {
    background-color: initial !important;
}

</style>
