<template>
    <div class="main-panel">
        <div v-if="$can('Consulter les details d’une assurance')" class="content-wrapper">
            <div class="row">
                <div class="col-md-12 ">
                    <router-link class="float-right" v-if="$can('Assurances')" :to="{name: 'assurances'}">
                        Assurances
                    </router-link><br><br>
                </div>
                <div class="col-md-12 grid-margin stretch-card">
                    <div ref="formContainer" class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <h1 class="card-title">
                                        <i class="mdi-style-content mdi mdi-medical-bag"></i>
                                        <span class="titre">Historiques d'assurance</span>
                                    </h1><br><br>
                                </div>
                            </div>
                            <div class="row">
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
                                    </form><br> <br>
                                </div>
                            </div>
                            <div class="row">
                                <div v-if="adherent_assurees.length > 0" class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="d-flex flex-column">
                                                <div class="wrapper text-center">
                                                    <div class="text-center">
                                                        <img :src="`/clubi/public/admin/adherents/photos/${adherent.image}`" class="photo-adherent" style="width: 70%; height: 100%;">
                                                    </div>
                                                    <p class="preview-subject ellipsis font-weight-medium text-dark">
                                                        <router-link v-if="$can('Consulter la fiche d\'adhérent')" :to="{name: 'adherent', params:{code: adherent.code_client }}">
                                                            <span><b>Matricule : </b>{{ adherent.code_client }}</span>
                                                        </router-link>
                                                        <span v-else><b>Matricule : </b>{{ adherent.code_client }}</span>
                                                    </p>
                                                    <p class="preview-subject ellipsis font-weight-medium text-dark">
                                                        <b>Nom</b> : {{ adherent.nom }}
                                                    </p>
                                                    <!--<p class="preview-subject ellipsis font-weight-medium text-dark">
                                                        <b>Adresse Email</b> : {{ adherent.email }}
                                                    </p>-->
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-8 table-responsive ">
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
                                                            {{ assurance.date_assuree | formatDate  }}
                                                        </td>
                                                        <td>
                                                            {{ assurance.date_fin | formatDate  }}
                                                        </td>
                                                        <td>
                                                            {{ assurance.RestDays }} {{$t('content.text.jours')}}
                                                        </td>
                                                        <td>
                                                            {{ assurance.prix }} {{$t('content.text.dh')}}
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <vue-pagination :pagination="pagination" @paginate="Assurances(data_filtrer)" :offset="4"></vue-pagination>
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
import { required, minLength, numeric, decimal, between, maxLength, email } from 'vuelidate/lib/validators'
import 'vue2-datepicker/index.css';
export default {
    props: ['code'],
    data() {
        return {
            adherent_assurees: [],
            adherent: [],
            datetimePicker: [null, null],
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
            const current_page = (this.pagination.current_page) ? this.pagination.current_page : 1;
            this.index_row = (this.pagination.current_page) ? ((this.pagination.current_page - 1) * 12) + 1 : 1;
            //console.log(' index_row :  ' + this.index_row)
            this.formData = new FormData();

            
            if (this.datetimePicker[0] != null && this.datetimePicker[1] != null) { 
                this.formData.append("filtrer[date][from]", this.data_filtrer.datetimes[0]);
                this.formData.append("filtrer[date][to]", this.data_filtrer.datetimes[1]);
            }
            const config = { headers: { 'content-type': 'multipart/form-data' } }
            axios.post('/api-admin/adherents/assurance/' + this.code + '/?page=' + current_page, this.formData, config).then((response) => {
                this.adherent_assurees = response.data.assurances.data;
                this.adherent = response.data.adherent;
                this.pagination = response.data.assurances;
            });
            // }
        },
        filtrer(event) {
            if (this.datetimePicker[0] != null && this.datetimePicker[1] != null) {
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
            this.datetimePicker = [null, null] // [new Date(new Date().getTime() - 365 * 24 * 60 * 60 * 1000), new Date(new Date().getTime() + 1 * 24 * 60 * 60 * 1000)]
        }
    },
    beforeMount() {
        if (this.$can('Consulter les details d’une assurance')) 
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
