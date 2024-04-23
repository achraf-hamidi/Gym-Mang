<template>
    <div class="main-panel">
        <div v-if="$can('Badges des adherents')" class="content-wrapper">
            <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                    <div ref="formContainer" class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <h1 class="card-title">
                                        <i class="mdi-style-content mdi  mdi-account-card-details"></i>
                                        <span class="titre"> {{ $t('content.pages.adherents.badges.titre') }}</span>
                                    </h1><br><br>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <form @submit.prevent="filtrer($event)" class="forms-sample">
                                        <div class="row">

                                            <div class="col-md-4">
                                                <div class="form-group mr-b-0em">
                                                    <label class="form__label">Nom et prénom</label>
                                                     <input v-model="data_filtrer.nom" placeholder="Nom et prénom" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group mr-b-0em">
                                                    <label class="form__label">Matricule</label>
                                                     <input v-model="data_filtrer.matricule" placeholder="Matricule" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group mr-b-0em">
                                                    <label class="form__label">CIN</label>
                                                     <input v-model="data_filtrer.cin" placeholder="CIN" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group mr-b-0em">
                                                    <label class="form__label">Genre</label>
                                                    <select class="form-control" v-model="data_filtrer.genre">
                                                        <option value="tous">Tous</option>
                                                        <option value="Homme">Homme</option>
                                                        <option value="Femme">Femme</option>
                                                    </select>
                                                </div>
                                            </div>



                                            <!---<div class="col-md-6">
                                                <div class="form-group mr-b-0em">
                                                    <label class="form__label">{{ $t('content.pages.adherents.badges.recherche.matricule.titre') }} </label>
                                                    <multiselect v-model.trim="value_id_adherent" :options="list_adherents" :custom-label="nameWithCodeClient" placeholder="Recherche.." label="code_client" track-by="code_client"></multiselect>
                                                </div>
                                            </div>-->
                                            <div class="col-6">
                                                <div class="form-group mr-b-0em">
                                                    <label class="form__label">{{$t('content.pages.adherents.badges.recherche.date')}} (Optionnel) : </label> <br>
                                                    <date-picker style="width: 100%;" :show-time-panel="showTimeRangePanel" @close="handleRangeClose" v-model="datetimePicker" range type="datetime" format="DD/MM/YYYY"></date-picker>
                                                </div>
                                            </div>
                                            <div class="col-12 text-right">
                                                <button type="submit" class="btn btn-success mr-2"> <i class="mdi mdi-magnify"></i> {{ $t('content.bouton.recherche') }}</button>
                                                <a @click="clearDataInputs" href="javascript:void(0)" class="btn btn-light">{{ $t('content.bouton.annuler') }}</a>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!--<div class="row">
                                <button @click="print">Print</button>
                            </div>-->
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group mr-b-0em"><br>
                                        <label class="form__label"><i class="mdi mdi-filter-outline"></i> {{ $t('content.pages.adherents.badges.filtrer.titre') }} </label>
                                        <input v-model="search_adherent" :placeholder="$t('content.pages.adherents.badges.filtrer.placeholder')" class="form-control">
                                    </div>
                                </div>
                                <div v-if="filteredBadgeAdherents.length > 0" class="col-md-12  " id="printBadges">
                                    <div class="adherent-qr-code row">
                                        <div class="col-md-4 mb-4" v-for="(adherent, index) in filteredBadgeAdherents">
                                            <div class="d-flex badge-style ">
                                                <div class="badges-info">
                                                    <img class="photo-adherent" :src="`/clubi/public/admin/adherents/photos/${adherent.image}`">
                                                    <div>
                                                        <p><b> {{ adherent.nom }}</b> </p>
                                                        <p><b> {{ adherent.email }}</b> </p>
                                                        <p> {{$t('content.pages.adherents.badges.matricule')}} : <b>{{ adherent.code_client }}</b> </p>
                                                    </div>
                                                </div>
                                                <div class="qr-code">
                                                    <div class="d-flex pl-4">
                                                        <img :src="`/clubi/public/admin/adherents/qr_code/${adherent.qr_code}.png`">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><br>
                                    <vue-pagination :pagination="pagination" @paginate="BadgeAdherents(data_filtrer)" :offset="4"></vue-pagination>
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
    data() {
        return {
            lang: {
                formatLocale: {
                    firstDayOfWeek: 1,
                },
                monthBeforeYear: false,
            },
            datetimePicker: [null, null], //[new Date(new Date().getTime() - 365 * 24 * 60 * 60 * 1000), new Date(new Date().getTime() + 1 * 24 * 60 * 60 * 1000)],
            showTimeRangePanel: false,

            state: {
                disabledDates: {
                    to: new Date(2020, 0, 5), // Disable all dates up to specific date
                    from: new Date(), // Disable all dates after specific date
                    days: [6, 0],
                }
            },
            data_filtrer: {
                datetimes: [],
                code_client: null,
                nom : '',
                matricule : '',
                cin : '',
                genre : 'tous',
            },
            adherents: [],
            pagination: [],
            search_adherent: '',
            formData: {},
            submitStatus: '',
            list_adherents: [],
            value_id_adherent: [],
        }
    }, 
    mounted() {
        console.log('Component mounted.')
    },
    methods: {
         nameWithCodeClient({ code_client, nom }) {
            return `${code_client} -  ${nom} `
        }, 
        ListAdherents() {
            axios.get('/api-admin/list-adherents-has-abonners').then((response) => {
                this.list_adherents = response.data;
            });
        }, 
        BadgeAdherents(data_filtrer) {
            //this.$v.$touch()
            //console.log(this.$v.$invalid)
            //if (this.$v.$invalid) {
            //    this.submitStatus = 'ERROR'
            //} else {
                if (typeof this.$refs.formContainer !== "undefined")
                    this.PluginLoader(false, this.$refs.formContainer)
                const current_page = (this.pagination.current_page) ? this.pagination.current_page : 1;

                this.formData = new FormData();
                ///if (this.value_id_adherent.length !== 0 )
                ///    this.formData.append("filtrer[code_client]", this.value_id_adherent.code_client);

                if (this.datetimePicker[0] != null && this.datetimePicker[1]) {
                    this.formData.append("filtrer[date][from]", this.data_filtrer.datetimes[0]);
                    this.formData.append("filtrer[date][to]", this.data_filtrer.datetimes[1]);
                }

                if (this.data_filtrer.nom != '')
                this.formData.append("filtrer[nom]", this.data_filtrer.nom);

            if (this.data_filtrer.cin != '')
                this.formData.append("filtrer[cin]", this.data_filtrer.cin);

            if (this.data_filtrer.matricule != '')
                this.formData.append("filtrer[matricule]", this.data_filtrer.matricule);

            if (this.data_filtrer.genre != 'tous')
                this.formData.append("filtrer[genre]", this.data_filtrer.genre);


                const config = { headers: { 'content-type': 'multipart/form-data' } }
                axios.post('/api-admin/adherents/badge?page=' + current_page, this.formData, config).then((response) => {
                    this.adherents = response.data.adherents.data;
                    this.pagination = response.data.adherents;
                });
            //}
        },
        filtrer(event) {
            if (this.datetimePicker[0] != null && this.datetimePicker[1]) {
                const date = this.datetimePicker;
                this.data_filtrer.datetimes = [date[0].toDateString(), date[1].toDateString()]
            }
            this.pagination = []
            this.BadgeAdherents(this.data_filtrer)
        },
        handleRangeClose() {
            this.showTimeRangePanel = false;
        },
        print() {
            // Pass the element id here
            this.$htmlToPaper('printBadges');
        },
        clearDataInputs() {
            this.datetimePicker = [null, null] //[new Date(new Date().getTime() - 365 * 24 * 60 * 60 * 1000), new Date(new Date().getTime() + 1 * 24 * 60 * 60 * 1000)]
              this.value_id_adherent = []
              this.data_filtrer.nom = ''
            this.data_filtrer.matricule = ''
            this.data_filtrer.cin = ''
            this.data_filtrer.genre = 'tous'
        }
    },
    beforeMount() {
        this.ListAdherents() 
        this.filtrer();
    },
    computed: {
        filteredBadgeAdherents() {
            return this.adherents.filter(adherent => {
                return adherent.code_client.toLowerCase().includes(this.search_adherent.toLowerCase()) ||
                    adherent.cin.toLowerCase().includes(this.search_adherent.toLowerCase()) ||
                    adherent.nom.toString().toLowerCase().includes(this.search_adherent.toLowerCase()) ||
                    adherent.gender.toString().toLowerCase().includes(this.search_adherent.toLowerCase()) ||
                    adherent.email.toString().toLowerCase().includes(this.search_adherent.toLowerCase()); // ||
                //adherent.abonners[0].RestDays.toString().toLowerCase().includes(this.search_adherent.toLowerCase());
            })
        },
    }
}

</script>
