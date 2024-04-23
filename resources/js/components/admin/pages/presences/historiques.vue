<template>
    <div class="main-panel">
        <div v-if="$can('Consulter l’historique des présences')" class="content-wrapper">
            <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                    <div ref="formContainer" class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-8">
                                    <h1 class="card-title">
                                        <i class="mdi-style-content  mdi mdi-history"></i>
                                        <span class="titre"> Historique des présences 
                                       
                                        <span v-if="datetimePicker[0] != null && datetimePicker[1] != null" >
                                            {{datetimePicker[0] | formatDate}} - {{datetimePicker[1] | formatDate}}
                                        </span>
                                         </span>
                                    </h1><br><br>
                                </div>
                                <div class="col-md-4">
                                    <p  class="text-right">
                                       <b> {{count_presences}} Présences</b>
                                    </p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <form @submit.prevent="filtrer($event)" class="forms-sample">
                                        <div class="row">
                                            <div class="col-6">
                                                <div  class="form-group mr-b-0em">
                                                    <label class="form__label"> ID </label>
                                                    <!--<multiselect v-model="data_filtrer.value_id_adherent" :options="list_adherents" :custom-label="nameWithCodeClient" placeholder="Recherche.." label="code_client" track-by="code_client"></multiselect>-->
                                                    <input   class="form-control" v-model="data_filtrer.matricule_cin"   placeholder="ID" />
                                                </div> 
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group mr-b-0em">
                                                    <label class="form__label">{{ $t('content.pages.presences.historiques.recherche.date') }}</label> <br>
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
                            <div class="row">
                                <!--<div class="col-md-12">
                                    <div class="form-group mr-b-0em"><br>
                                        <label class="form__label"><i class="mdi mdi-filter-outline"></i> {{ $t('content.pages.presences.aujourdhui.filtrer.titre') }}</label>
                                        <input v-model="search_adherent" placeholder="Matricule, cin, nom & prénom, email..." class="form-control">
                                    </div>
                                </div>-->
                                <div v-if="filteredHistoriquesPresences.length>0" class="table-responsive col-md-12 mt-5">
                                    <table id="data-packs" class="datatables table table-striped table-bordered table-hover">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th>{{ $t('content.pages.presences.aujourdhui.tableau.matricule') }}</th>
                                                <th>{{ $t('content.pages.presences.aujourdhui.tableau.nom') }}</th>
                                                 <th>Abonnement / Pack</th>
                                                <th>{{ $t('content.pages.presences.aujourdhui.tableau.date_entrer') }}</th>
                                                <!--<th>{{ $t('content.pages.presences.aujourdhui.tableau.date_sortier') }}</th>-->
                                                <th>{{ $t('content.pages.presences.aujourdhui.tableau.jours') }}</th>
                                                <th>{{ $t('content.pages.presences.aujourdhui.tableau.statut') }}</th>
                                                <!--<th>{{ $t('content.pages.presences.aujourdhui.tableau.statut') }}</th>-->
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(presence, index) in filteredHistoriquesPresences">
                                                <td>
                                                    <router-link v-if="$can('Consulter la fiche d\'adhérent')" :to="{name: 'adherent', params:{code: presence.adherent.code_client }}">
                                                        <a> {{ presence.adherent.id_empreinte }} </a>
                                                    </router-link>
                                                    <span v-else>{{ presence.adherent.id_empreinte }}</span>
                                                </td>
                                                <td> {{ presence.adherent.nom }} </td>
                                                 <td> {{ presence.adherent.abonners[0].abonnements[0].libelle }}, {{ presence.adherent.abonners[0].packs[0].description }} </td>
                                                <td> {{ presence.date_entrer | formatDateHeur }} </td>
                                                <!--<td> {{ presence.date_sortier | formatDate }} </td>-->
                                                 <td> 
                                                     {{ presence.adherent.abonners[0].RestDays }} j 
                                                    <!--<label v-if="presence.adherent.abonners[0].RestDays > 0" >
                                                        {{ presence.adherent.abonners[0].RestDays }} j 
                                                    </label>
                                                    <label v-else >
                                                        {{$t('content.text.jours_terminer')}}
                                                    </label>-->
                                                </td>
                                                  <td>
                                                    <label v-if="presence.adherent.abonners[0].RestDays > 0" class="badge badge-success">
                                                        Actif
                                                    </label>
                                                    <label v-else class="badge badge-danger">
                                                        Inactif
                                                    </label>
                                                </td>
                                                <!--<td>
                                                    <label v-if="presence.date_sortier == null" class="badge badge-success">{{ $t('content.pages.presences.aujourdhui.statut.entrer') }}</label>
                                                    <label v-else class="badge badge-danger">{{ $t('content.pages.presences.aujourdhui.statut.sortier') }}</label>
                                                </td>-->
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div v-else class="aucune col-md-12">
                                    <i class="mdi-style mdi mdi-alert"></i> {{$t('content.alerts.aucune_info')}}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <vue-pagination :pagination="pagination" @paginate="HistoriquesPresences()" :offset="4"></vue-pagination>
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
export default {
    data() {
        return {
            lang: {
                formatLocale: {
                    firstDayOfWeek: 1,
                },
                monthBeforeYear: false,
            },
            datetimePicker: null, // [new Date(new Date().getTime() - 10 * 24 * 60 * 60 * 1000), new Date(new Date().getTime() + 1 * 24 * 60 * 60 * 1000)],
            showTimeRangePanel: false,
            pagination: [],
            historiques_presences: [],
            search_adherent: '',
            saveIndex: -1,
            data_filtrer: {
                datetimes: [],
                matricule_cin : '' ,
                id_empreinte:'',
                        },
            formData: {},
            count_presences : 0
        }
    },
    mounted() {
        console.log('Component mounted.')
    },
    methods: {
        HistoriquesPresences() {

            //if (this.data_filtrer.matricule_cin != '' || this.$route.query.matricule) {
            if (typeof this.$refs.formContainer !== "undefined")
                this.PluginLoader(false, this.$refs.formContainer)
            const current_page = (this.pagination.current_page) ? this.pagination.current_page : 1;

            this.formData = new FormData();
            //if (this.datetimePicker != null)
            //    this.formData.append("filtrer[date]", this.data_filtrer.datetimes);

            if(this.data_filtrer.matricule_cin != null && this.data_filtrer.matricule_cin != '') { 
                console.log("hello")
                this.$router.push({name: 'historiques-presences', query: {matricule : this.data_filtrer.matricule_cin } })
                   this.formData.append("filtrer[matricule]", this.data_filtrer.matricule_cin);
                   this.formData.append("filtrer[id_empreinte]", this.data_filtrer.id_empreinte);
                   
            }
            if( this.$route.query.matricule && this.$route.query.matricule != ''){
                console.log("hello")
                    this.data_filtrer.matricule_cin  =  this.$route.query.matricule
                    this.formData.append("filtrer[matricule]",  this.$route.query.matricule);
                    this.formData.append("filtrer[id_empreinte]",  this.$route.query.id_empreinte);
            } 

            if (this.datetimePicker[0] != null && this.datetimePicker[1] != null) { 
                this.formData.append("filtrer[date][from]", this.data_filtrer.datetimes[0]);
                this.formData.append("filtrer[date][to]", this.data_filtrer.datetimes[1]);
            }

            const config = { headers: { 'content-type': 'multipart/form-data' } }

            axios.post('/api-admin/historiques-presences?page=' + current_page, this.formData, config).then((response) => {
                this.historiques_presences = response.data.data;
                this.pagination = response.data;
                 this.count_presences = response.data.total;
                console.log(this.historiques_presences)
            })  ;
            //}
        },
        /*changeMatriculeValue(){
            if(this.data_filtrer.matricule_cin != '') {
                //this.$route.query.matricule = this.data_filtrer.matricule_cin   
            }
        }   ,*/
        filtrer(event) {
             if (this.datetimePicker[0] != null && this.datetimePicker[1] != null) {
                const date = this.datetimePicker;
                this.data_filtrer.datetimes = [date[0].toDateString(), date[1].toDateString()]
            }else{

                this.datetimePicker = [new Date(new Date().getTime() - 2 * 24 * 60 * 60 * 1000), new Date()]
                const date = this.datetimePicker;
                this.data_filtrer.datetimes = [date[0].toDateString(), date[1].toDateString()]
            }
            this.pagination = []
            this.HistoriquesPresences(this.data_filtrer)
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
            this.datetimePicker = [
                       // new Date(currYear, 0, 1), 
                        new Date(new Date().getTime() - 1 * 24 * 60 * 60 * 1000 ),
                        new Date(new Date().getTime() )
            ]
        }
    },
    beforeMount() {
        if (this.$can('Consulter l’historique des présences')) {
            this.selectedDate()
            this.filtrer();
        }
    },
    computed: {
        filteredHistoriquesPresences() {
            return this.historiques_presences.filter(presence => {
                return presence.adherent.code_client.toLowerCase().includes(this.search_adherent.toLowerCase()) || presence.adherent.cin.toLowerCase().includes(this.search_adherent.toLowerCase()) || presence.adherent.nom.toLowerCase().includes(this.search_adherent.toLowerCase()) || presence.adherent.email.toLowerCase().includes(this.search_adherent.toLowerCase())
            })
        }
    },
    created: function() {
        this.eventPresences.$on('manual-presence-or-qr', data => {
            if (data.type == 'sortier') {
                for (var i = 0; i < this.historiques_presences.length; i++) {
                    if (this.historiques_presences[i].date_entrer == data.presence.date_entrer && this.historiques_presences[i].date_sortier == null) {
                        this.saveIndex = i;
                    }
                }
                if (this.saveIndex != -1) {
                    this.historiques_presences[this.saveIndex].date_sortier = data.presence.date_sortier;
                }
            } else {
                this.historiques_presences.unshift(data.presence)
            }
        })
    },

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

</style>
