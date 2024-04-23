<template>
    <div class="main-panel">
        <div v-if="$can('Consulter les statistiques du chiffre d’affaires des abonnements vendus')" class="content-wrapper">

            <!-- note -->
         <div class="modal fade details_abnsVendus" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
               <div class="modal-content">
                  <div class="card-header ">
                     <div class="row">
                        <div class="col-md-12">
                           <div class="d-flex justify-content-between">
                              <h3 class="card-title mb-0"> 
                                 Détails des abonnements vendus par jour
                              </h3>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div ref="details_abnsVendusContainer" class="modal-body grid-margin modal-utilisateur ">
                    <div class="row mt-3 mb-3"> 
                        <div class="col-md-4">
                            <p>
                                <b>Année : </b><span>  {{ year }} </span>
                            </p>
                        </div>
                        <div class="col-md-4">
                            <p v-if="month != ''" >
                                <b>Mois : </b><span>  {{ options_months[parseInt(month -1 )].name  }} </span>
                            </p>
                        </div>
                    </div>
                
                     <div  class="mt-3 responsive-table " >
                        <div class="form-group mr-b-0em"><label class="form__label"><i class="mdi mdi-filter-outline"></i> {{$t('content.pages.parametrages.abonnements.liste.filtrer.titre')}} par jour</label> <input v-model="popup_search" :placeholder="$t('content.bouton.filtrer_recherche')" class="form-control"></div>

                        <table class="mt-2 datatables table table-striped table-bordered table-hover">
                           <thead>
                              <tr>
                                <th>Jour</th> 
                                <th>{{$t('content.pages.paiements.statistiques.format_tableau.tableau.montant_total') }}</th>
                              </tr>
                           </thead>
                           <tbody>
                              <tr v-for="(paiement, index) in filteredStatistiquesReglementsMonth"  >
                                 <td>
                                    {{ paiement.dayKey  }}<!--/{{ paiement.monthKey }}/{{ paiement.year  }}-->
                                </td>
                                 <td> {{ parseFloat(paiement.sums) }} {{$t('content.text.dh')}}</td>
                              </tr>
                           </tbody>
                        </table>
                        <div class="rows mt-5">
                            <div class="col-md-6">
                                <div class="d-flex align-items-center pb-2">
                                    <div class="dot-indicator bg-dot-primary mr-2"></div>
                                    <p class="mb-0 dot-font-size">Total est : <h4 class="font-weight-semibold font-size-semibold" style="margin: 0px; margin-left: 15px;">{{montantTotalMonth}} {{$t('content.text.dh')}}</h4></p>
                                </div>
                                
                                <div class="progress progress-md">
                                    <div class="progress-bar bg-dot-primary" role="progressbar" style="width: 100%"></div>
                                </div>
                            </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <!-- end note -->

            <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                    <div ref="formContainer" class="card">
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h1 class="card-title">
                                            <i class="mdi-style-content  mdi mdi-chart-arc"></i>
                                            <span class="titre"> Statistiques du chiffre d'affaires des abonnements vendus </span>
                                        </h1><br><br>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <form @submit.prevent="filtrer($event)" class="forms-sample">
                                            <div class="row">
                                                <!--<div class="col-md-4">
                                                    <div class="form-group mr-b-0em" :class="{ 'form-group--error': $v.data_filtrer.code_client.$error }">
                                                        <label class="form__label">{{$t('content.pages.paiements.statistiques.recherche.matricule.titre')}}</label>
                                                        <input class="form-control" v-model.trim="$v.data_filtrer.code_client.$model" @input="setCodeclient($event.target.value)" :placeholder="$t('content.pages.paiements.statistiques.recherche.matricule.titre')" />
                                                    </div>
                                                    <div v-if="$v.data_filtrer.code_client.$dirty">
                                                        <div class="error" v-if="!$v.data_filtrer.code_client.minLength">
                                                            {{ $t('validation.min.numeric', { attribute : $t('content.pages.paiements.statistiques.recherche.matricule.titre'), min : $v.data_filtrer.code_client.$params.minLength.min }) }}
                                                        </div>
                                                    </div>
                                                </div>-->
                                                <div class="col-md-4">
                                                <div class="form-group mr-b-0em">
                                                    <!-- <label class="form__label">Matricule ou Cin</label>
                                                     <input v-model.trim="value_id_adherent" placeholder="Matricule ou Cin" class="form-control"> -->
                                                     <label class="form__label">ID</label>
                                                     <input v-model="data_filtrer.id_empreinte" placeholder="ID" class="form-control">
                                                     <!-- v-model="data_filtrer.id_empreinte" -->
                                                </div>
                                                
                                            </div>
                                                <div class="col-md-4">
                                                <div class="form-group mr-b-0em">
                                                    <label class="form__label"> {{ $t('content.pages.abonnements.encours.recherche.abonnement') }}</label>
                                                    <!--<select class="form-control" v-model="data_filtrer.abonnement">
                                                        <option value="tous">Tous</option>
                                                        <option v-for="(abonnement, index) in abonnements" :value="abonnement.id"> {{ abonnement.libelle }} </option>
                                                    </select>-->

                                                    <multiselect v-model="data_filtrer.abonnement"  @input="setid_abonnement($event)" :options="abonnements" :custom-label="libeleAbonnement" placeholder="Recherche.." label="libelle" track-by="libelle"></multiselect>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group mr-b-0em">
                                                    <label class="form__label"> {{ $t('content.pages.abonnements.encours.recherche.pack') }}</label>
                                                    <!--<select class="form-control" v-model="data_filtrer.pack">
                                                        <option value="tous">Tous</option>
                                                        <option v-for="(pack, index) in packs" :value="pack.id">
                                                            {{ pack.description }} ( <span v-for="(acts) in pack.activities"> {{ acts.name }} </span> )
                                                        </option>
                                                    </select>-->

                                                    <multiselect v-model="data_filtrer.pack" :options="packs" :custom-label="libelePack" placeholder="Recherche.." label="description" track-by="description"></multiselect>

                                                </div>
                                            </div>
                                                <!--<div class="col-md-4">
                                                    <div class="form-group mr-b-0em">
                                                        <label class="form__label">
                                                            {{$t('content.pages.paiements.recharges.nouveau.inputs.matricule.titre')}}
                                                        </label>
                                                        <multiselect v-model.trim="value_id_adherent" :options="list_adherents" :custom-label="nameWithCodeClient" placeholder="Recherche.." label="code_client" track-by="code_client"></multiselect>
                                                    </div>
                                                </div>-->
                                            
                                                <!--<div class="col-6">
                                                    <div class="form-group mr-b-0em">
                                                        <label class="form__label"> {{$t('content.pages.paiements.statistiques.recherche.annee.titre')}}</label>
                                                        <multiselect v-model.trim="arr_years" tag-placeholder="Add this as new tag" placeholder="Années.." label="name" track-by="year_id" :options="options_years" :multiple="true" :taggable="true" @tag="addYears"></multiselect>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-group mr-b-0em">
                                                        <label class="form__label">{{$t('content.pages.paiements.statistiques.recherche.mois.titre')}}</label>
                                                        <multiselect v-model.trim="arr_months" tag-placeholder="Add this as new tag" :placeholder="$t('content.pages.paiements.statistiques.recherche.mois.titre')" label="name" track-by="month_id" :options="options_months" :multiple="true" :taggable="true" @tag="addMonths"></multiselect>
                                                    </div>
                                                </div>-->
                                                <div class="col-md-12">
                                                <div class="form-group mr-b-0em">
                                                    <label class="form__label"> Date du au</label> <br>
                                                    <date-picker style="width: 100%;" :show-time-panel="showTimeRangePanel" @close="handleRangeClose" v-model="datetimePicker" range type="date" format="DD/MM/YYYY"></date-picker>
                                                </div>
                                            </div>
                                                <div class="col-12 text-right">
                                                    <div class="form-group mr-b-0em">
                                                        <button type="submit" class="btn btn-success mr-2"> <i class="mdi mdi-magnify"></i> {{ $t('content.bouton.recherche') }}</button>
                                                        <a @click="clearDataInputs" href="javascript:void(0)" class="btn btn-light">{{ $t('content.bouton.annuler') }}</a>
                                                    </div><br><br>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="card-header ">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <h3>Tableau des abonnements vendus </h3>
                                                </div>
                                            </div>
                                        </div><br>
                                        <!--<div class="form-group mr-b-0em"><br>
                                            <label class="form__label"><i class="mdi mdi-filter-outline"></i> {{$t('content.pages.paiements.statistiques.format_tableau.filtrer.titre')}} </label> <input v-model="search_months" placeholder="Mois ou année ..." class="form-control">
                                        </div>-->
                                        <div v-if="filteredStatistiquesReglements.length > 0">
                                            <div style="overflow-x:auto;" class="tab-pane fade in active show">
                                                <table class="datatables table table-striped table-bordered table-hover">
                                                    <thead class="thead-dark">
                                                        <tr>
                                                            <th>{{$t('content.pages.paiements.statistiques.format_tableau.tableau.mois') }}</th>
                                                            <th>{{$t('content.pages.paiements.statistiques.format_tableau.tableau.annee') }}</th>
                                                            <th>{{$t('content.pages.paiements.statistiques.format_tableau.tableau.montant_total') }}</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr v-for="(sts, index) in filteredStatistiquesReglements">
                                                            <td>

                                                                <span class="months_clicable" title="Détials paiements" data-toggle="modal" data-target=".details_abnsVendus" @click="OpenModelDetailsPaiements(sts.monthKey, sts.year, 0 , index )" > {{ options_months[parseInt(sts.monthKey - 1)].name  }}  </span>

                                                                
                                                            </td>
                                                            <td> {{ sts.year }} </td>
                                                            <td> {{ parseFloat(sts.sums) }} {{$t('content.text.dh')}}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <!--<p>
                                                    <b>Total : </b> {{montantTotal}} {{$t('content.text.dh')}}
                                                </p>-->
                                                <div class="rows">
                                                    <div class="col-md-6">
                                                        <div class="d-flex align-items-center pb-2">
                                                            <div class="dot-indicator bg-dot-primary mr-2"></div>
                                                            <p class="mb-0 dot-font-size">Total est : <h4 class="font-weight-semibold font-size-semibold" style="margin: 0px; margin-left: 15px;">{{montantTotal}} {{$t('content.text.dh')}}</h4></p>
                                                        </div>
                                                        
                                                        <div class="progress progress-md">
                                                            <div class="progress-bar bg-dot-primary" role="progressbar" style="width: 100%"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div v-else class="aucune col-md-12">
                                            <i class="mdi-style mdi mdi-alert"></i> {{$t('content.alerts.aucune_info')}}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card-header ">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <h3>Graphique des abonnements vendus </h3>
                                                </div>
                                            </div>
                                        </div>
                                        <div><br>
                                            <chart-pie v-if="loaded" :background="charts.background" label="Somme total est " :labels="charts.months" :data="charts.sums"></chart-pie>
                                        </div>
                                    </div>
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
            datetimePicker: [new Date(new Date().getTime() - 7 * 24 * 60 * 60 * 1000), new Date()] ,
            data_filtrer: {
                code_client: null,
                id_empreinte:null,
                abonnement : [],
                pack : [],
                datetimes : []
            },
            showTimeRangePanel: false,
            list_adherents: [],
            value_id_adherent: null,
            formData: {},
            submitStatus: '',
            statistiques_reglements: [],
            search_months: '',
            charts: {
                months: [],
                sums: [],
                background: []
                
            },
            montantTotal: 0,
            loaded: false,

            options_months: [
                { name: 'Janvier', month_id: '01' },
                { name: 'Février', month_id: '02' },
                { name: 'Mars', month_id: '03' },
                { name: 'Avril', month_id: '04' },
                { name: 'Mai', month_id: '05' },
                { name: 'Juin', month_id: '06' },
                { name: 'Juillet', month_id: '07' },
                { name: 'Août', month_id: '08' },
                { name: 'Septembre', month_id: '09' },
                { name: 'Octobre', month_id: '10' },
                { name: 'Novembre', month_id: '11' },
                { name: 'Décembre', month_id: '12' },
            ],
            options_years: [
                /*{ name: '2018', year_id: 2018 },
                { name: '2019', year_id: 2019 },
                { name: '2020', year_id: 2020 },
                { name: '2021', year_id: 2021 },*/
            ],
            arr_background: ['#009c61', '#cc0099', '#cc9900', '#cc0033', '#0099cc', '#6600cc', '#66cc00', 'aqua', 'black', 'blue', 'fuchsia', 'gray', 'green',
                'lime', 'maroon', 'navy', 'olive', 'orange', 'purple',
                'silver', 'teal', 'white', 'yellow'
            ],
            arr_years: [],
            arr_months: [],
            packs: [],
            List_Packs : [],
            abonnements: [],
            details_abnsVendus  : [],
            montantTotalMonth: 0,
            popup_search : '',
            month : '',
            year : '',
        }
    },
    validations() {
        return {
            data_filtrer: {
                code_client: {
                    minLength: minLength(2)
                },
            },
        }
    },
    mounted() {
        ///console.log('Component mounted.')
    },
    methods: {
        setid_abonnement(value) { 
            let self = this
            this.packs = []
            this.packs =  this.List_Packs.filter( function(pack) { 
                return pack.id_abonnement == value.id 
            } )
         },
         libeleAbonnement({ nb_mois, libelle }) {
            return `${libelle} ( ${nb_mois} Mois )`
        },
        libelePack({ description, prix, activities }) {
            var all_activities = ''
            for (var i = 0; i < activities.length; i++)
                all_activities = activities[i].name + ', ' + all_activities
            return `${description} ( ${all_activities.replace(/,(?=\s*$)/, '')} )`
        },

        nameWithCodeClient({ code_client, nom }) {
            return `${code_client} -  ${nom} `
        },
        ListAdherents() {
            axios.get('/api-admin/list-adherents-has-abonners').then((response) => {
                this.list_adherents = response.data;
            });
        },
        addMonths(newTag) {
            const tag = {
                name: newTag,
                month_id: newTag.substring(0, 2) + Math.floor((Math.random() * 10000000))
            }
            this.options_months.push(tag)
            this.arr_months.push(tag)
        },
        addYears(newTag) {
            const tag = {
                name: newTag,
                year_id: newTag.substring(0, 2) + Math.floor((Math.random() * 10000000))
            }
            this.options_years.push(tag)
            this.arr_years.push(tag)
        },


        setCodeclient(value) {
            ///console.log(value)
            this.data_filtrer.code_client = value
            this.$v.data_filtrer.code_client.$touch()
        },
        StatistiquesReglements(data_filtrer) {

            this.$v.$touch()
            ///console.log(this.$v.$invalid)
            if (this.$v.$invalid) {
                this.submitStatus = 'ERROR'
            } else {
                if (typeof this.$refs.formContainer !== "undefined")
                    this.PluginLoader(false, this.$refs.formContainer)
                this.formData = new FormData();

                // if (this.value_id_adherent != null)
                //     this.formData.append("filtrer[code_client]", this.value_id_adherent);

              if (this.value_id_adherent != null)
                     this.formData.append("filtrer[id_empreinte]", this.value_id_adherent);



                //if (this.data_filtrer.code_client != null && this.data_filtrer.code_client != '')
                //    this.formData.append("filtrer[code_client]", this.data_filtrer.code_client);

                if (this.arr_years.length > 0) {
                    for (var i = 0; i < this.arr_years.length; i++) {
                        this.formData.append("arr_years[" + i + "]", this.arr_years[i]['year_id']);
                    }
                }

                if (this.arr_months.length > 0) {
                    for (var i = 0; i < this.arr_months.length; i++) {
                        this.formData.append("arr_months[" + i + "]", this.arr_months[i]['month_id']);
                    }
                }

                if (this.data_filtrer.abonnement != null && this.data_filtrer.abonnement.length !== 0) {
                    this.formData.append("filtrer[abonnement_id]", this.data_filtrer.abonnement.id);
                }
                if (this.data_filtrer.pack != null &&  this.data_filtrer.pack.length !== 0) {
                    this.formData.append("filtrer[pack_id]", this.data_filtrer.pack.id);
                }

                if (this.datetimePicker[0] != null && this.datetimePicker[1]) { 
                    this.formData.append("filtrer[date][from]", this.data_filtrer.datetimes[0]);
                    this.formData.append("filtrer[date][to]", this.data_filtrer.datetimes[1]);
                }
 

                ///console.log(this.arr_months)

                this.loaded = false

                this.charts.months.splice(0)
                this.charts.sums.splice(0)
                this.charts.background.splice(0)
                this.statistiques_reglements.splice(0)
                this.montantTotal = 0;

                const config = { headers: { 'content-type': 'multipart/form-data' } }
                axios.post('/api-admin/statistiques-abonnements-vendus', this.formData, config).then((response) => {


                    if (typeof response.data.adherent !== "undefined") {
                        if (response.data.adherent == "not_found") {
                            this.AlertResponseFalse("","Adhérent n'existe pas", "warning")

                            //break;
                            return false;
                        }
                    }else{
                        for (var i = 0; i < response.data.abonners_vendus.length; i++) {

                            //var month_french = this.options_months[parseInt(response.data.paiements[i].monthKey - 1)].name 
                            //this.charts.months.push(month_french)
                            this.charts.months.push(response.data.abonners_vendus[i].months)
                            this.charts.sums.push(parseFloat(response.data.abonners_vendus[i].sums))
                            this.charts.background.push(this.arr_background[i])
                            this.montantTotal =this.montantTotal + parseFloat(parseFloat(response.data.abonners_vendus[i].sums));
                        }
                        this.statistiques_reglements = response.data.abonners_vendus
                        this.loaded = true
                       
                    }

                    
                });
                ///console.log(this.charts.background)
            }
        },
        filtrer(event) {
            if (this.datetimePicker[0] != null && this.datetimePicker[1]) {
                const date = this.datetimePicker; 
                this.data_filtrer.datetimes = [date[0].toDateString(), date[1].toDateString()]
            }else{
                this.datetimePicker =  [new Date(new Date().getTime() - 7 * 24 * 60 * 60 * 1000), new Date()] ;
                const date = this.datetimePicker; 
                this.data_filtrer.datetimes = [date[0].toDateString(), date[1].toDateString()]
            }
            this.StatistiquesReglements(this.data_filtrer)
        },
        handleRangeClose() {
            this.showTimeRangePanel = false;
        },

        clearDataInputs() {
            this.arr_years = []
            this.arr_months = []
            this.value_id_adherent = null
            this.datetimePicker =  [new Date(new Date().getTime() - 7 * 24 * 60 * 60 * 1000), new Date()] ;
            this.datetimes = []
        },
        ListPacks() {
            axios.get('/api-admin/parametrages/packs').then((response) => {
                this.List_Packs = response.data;

            });
        },
        ListTypeAbonnements() {
            axios.get('/api-admin/parametrages/abonnements').then((response) => {
                ///console.log("data : " )
                                 ///console.log(response.data)
                this.abonnements = response.data;

            });
        },
        OpenModelDetailsPaiements(month, year, day, index){
            this.month = month
            this.year = year

            this.popup_search = ''
            if (typeof this.$refs.details_abnsVendusContainer !== "undefined")
                    this.PluginLoader(false, this.$refs.details_abnsVendusContainer)
                this.formData = new FormData();

                if (this.value_id_adherent != null)
                    this.formData.append("filtrer[code_client]", this.value_id_adherent);
                if (this.value_id_adherent != null)
                    this.formData.append("filtrer[id_empreinte]", this.value_id_adherent);
                    
                    
                this.formData.append("filtrer[year]", year);
                this.formData.append("filtrer[month]", month); 
                this.formData.append("filtrer[addSelectDay]", "true");

                if (this.data_filtrer.abonnement != null && this.data_filtrer.abonnement.length !== 0) {
                    this.formData.append("filtrer[abonnement_id]", this.data_filtrer.abonnement.id);
                }
                if (this.data_filtrer.pack != null &&  this.data_filtrer.pack.length !== 0) {
                    this.formData.append("filtrer[pack_id]", this.data_filtrer.pack.id);
                } 

                if (this.datetimePicker[0] != null && this.datetimePicker[1]) { 
                    this.formData.append("filtrer[date][from]", this.data_filtrer.datetimes[0]);
                    this.formData.append("filtrer[date][to]", this.data_filtrer.datetimes[1]);
                }


                 
                this.details_abnsVendus.splice(0)
                this.montantTotalMonth = 0;

                const config = { headers: { 'content-type': 'multipart/form-data' } }
                axios.post('/api-admin/statistiques-abonnements-vendus', this.formData, config).then((response) => {
                    
                    if (typeof response.data.adherent !== "undefined") {
                        if (response.data.adherent == "not_found") {
                           // console.log("hello")
                            this.AlertResponseFalse("", "Adhérent n'existe pas", "warning")
                           
                             return false;
                        }
                    }else{
                        for (var i = 0; i < response.data.abonners_vendus.length; i++) {  
                            this.montantTotalMonth =this.montantTotalMonth + parseFloat(parseFloat(response.data.abonners_vendus[i].sums));
                        }
                        this.details_abnsVendus = response.data.abonners_vendus
                      }

                    
                });
        }
    },
    beforeMount() {
        if (this.$can('Consulter les statistiques du chiffre d’affaires des abonnements vendus')) {
            this.ListTypeAbonnements();
            this.ListPacks();
            //this.ListAdherents()
            this.filtrer();
            var dt = new Date();
            this.options_years.push({ name: 2003, year_id: 2003 })

            for (var startYear = 2016; startYear <= dt.getFullYear(); startYear++) {
                this.options_years.push({ name: startYear, year_id: startYear })
            } 
        }
    },
    computed: {
        filteredStatistiquesReglements() {
            return this.statistiques_reglements.filter(reglement => {
                return reglement.months.toLowerCase().includes(this.search_months.toLowerCase())
            })
        },
        filteredStatistiquesReglementsMonth() {
            return this.details_abnsVendus.filter(vendus => {
                return vendus.dayKey.toLowerCase().includes(this.popup_search.toLowerCase())
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




.card-title .titre {
    font-size: 30px !important;
    text-transform: none;
    font-weight: 600;
    position: relative;
    margin-left: 12px;
}

.card-title .titre:before {
    content: '';
    width: 100%;
    height: 5px;
    position: absolute;
    bottom: -15px;
    background: -webkit-linear-gradient(45deg, #ffbf36, #ff6028) !important;
    border-radius: 10px;
}

.border-1px {
    border: 1px solid #ccc !important;
    height: 100%;
    padding: 15px;
    padding-top: 35px;
}

</style>
