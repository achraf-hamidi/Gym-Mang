<template>
    <div class="main-panel">
        <div v-if="$can('Consulter les statistiques des recettes')" class="content-wrapper">
            <div class="row">

                 <!-- note -->
         <div class="modal fade details_recettes_month" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
               <div class="modal-content">
                  <div class="card-header ">
                     <div class="row">
                        <div class="col-md-12">
                           <div class="d-flex justify-content-between">
                              <h3 class="card-title mb-0"> 
                                 Détails des recettes par jour
                              </h3>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div ref="details_recettes_monthContainer" class="modal-body grid-margin modal-utilisateur ">
                    
                    <div class="row mt-3 mb-3">
                        <div class="col-md-4">
                            <p>
                                <b>Recettes : </b><span>  {{ nom_service }} </span>
                            </p>
                        </div>
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
                              <tr v-for="(paiement, index) in filteredStatistiquesRecettesMonth"  >
                                 <td>
                                    {{ paiement.dayKey  }}/{{ paiement.monthKey }}/{{ paiement.year  }}
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
                <div class="col-md-12 grid-margin stretch-card">
                    <div ref="formContainer" class="card">
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h1 class="card-title">
                                            <i class="mdi-style-content  mdi mdi-chart-arc"></i>
                                            <span class="titre"> Statistiques de recettes </span>
                                        </h1><br><br>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <form @submit.prevent="filtrer($event)" class="forms-sample">
                                            <div class="row">
                                                
                                           <div class="col-md-6">
                                                <div class="form-group mr-b-0em">
                                                    <label class="form__label"> Categories </label>
                                                    <multiselect v-model="data_filtrer.categorie" @input="setcategorie($event)"  :options="Categories" :custom-label="libeleNomCategorie" placeholder="Recherche.." label="id" track-by="id"  ></multiselect>
                                                </div> 
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group mr-b-0em">
                                                    <label class="form__label"> Services </label>
                                                    <multiselect v-model="data_filtrer.service"   :options="optionServices" :custom-label="libeleServices" placeholder="Recherche.." label="id_service" track-by="id_service"  ></multiselect>
                                                 </div> 
                                            </div>
                                                <!--<div class="col-6">
                                                    <div class="form-group mr-b-0em">
                                                        <label class="form__label"> Année</label>
                                                        <multiselect v-model.trim="arr_years" tag-placeholder="Add this as new tag" placeholder="Années.." label="name" track-by="year_id" :options="options_years" :multiple="true" :taggable="true" @tag="addYears"></multiselect>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-group mr-b-0em">
                                                        <label class="form__label">{{$t('content.pages.paiements.statistiques.recherche.mois.titre')}}</label>
                                                        <multiselect v-model.trim="arr_months" tag-placeholder="Add this as new tag" :placeholder="$t('content.pages.paiements.statistiques.recherche.mois.titre')" label="name" track-by="code_month" :options="options_months" :multiple="true" :taggable="true" @tag="addMonths"></multiselect>
                                                    </div>
                                                </div>-->
                                                <div class="col-md-12">
                                                    <div class="form-group mr-b-0em">
                                                        <label class="form__label">Date du au</label> <br>
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
                                                    <h3>Tableau des recettes</h3>
                                                </div>
                                            </div>
                                        </div><br>
                                        <div v-if="statistiques_recettes.length > 0">
                                            <div style="overflow-x:auto;" class="tab-pane fade in active show">
                                                <table class="datatables table table-striped table-bordered table-hover">
                                                    <thead class="thead-dark">
                                                        <tr>
                                                            <th>Recette </th>
                                                            <!--<th>Quantité</th>-->
                                                            <th>Mois</th>
                                                            <th>{{$t('content.pages.paiements.statistiques.format_tableau.tableau.annee') }}</th>
                                                            <th>Montant total payé</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr v-for="(sts, index) in statistiques_recettes">
                                                            <td> {{ sts.nom_service }} </td>
                                                            <!--<td> {{ sts.qte }} </td>-->
                                                            <td>
                                                                <span class="months_clicable" title="Détials paiements" data-toggle="modal" data-target=".details_recettes_month" @click="OpenModelDetailsRecettesMonth(sts.monthKey, sts.year, 0 , index, sts.nom_service )" > {{ options_months[parseInt(sts.monthKey - 1)].name  }}  </span>

                                                                
                                                            </td>
                                                            <td>
                                                             <!--{{ sts.months }}-->
                                                                 {{sts.year}}
                                                             </td>
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
                                        <div v-else class="aucune col-md-6">
                                            <i class="mdi-style mdi mdi-alert"></i> {{$t('content.alerts.aucune_info')}}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card-header ">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <h3>Graphique des recettes </h3>
                                                </div>
                                            </div>
                                        </div>
                                        <div><br>
                                            <chart-pie v-if="loaded"  :background="charts.background" :label="`Somme total est `" :labels="charts.labels" :data="charts.sums"></chart-pie>
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
                servicetyperecette : '',
                categorie : [] ,
                service : [],
                datetimes : []
            },
 
            formData: {},
            submitStatus: '',
            statistiques_recettes: [],
            search_months: '',
            popup_search : '',
            charts: {
                labels: [],
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
            ServicesTypeRecette : [],
            Services : [],
            Categories : [],
            optionServices : [],
            showTimeRangePanel: false,
            details_recettes_month  : [],
            montantTotalMonth: 0,
            month : '',
            year : '',
            nom_service : '',
        }
    }, 
    mounted() {
        console.log('Component mounted.')
    },
    methods: { 
        handleRangeClose() {
            this.showTimeRangePanel = false;
        },
         libeleNomCategorie({ nom }) {
            return `${nom}`
        },
        libeleServices({ nom_service, prix_service }) {
            return `${nom_service}, Prix : ${prix_service} Dh `
        },
        ListServicesTypeRecette() {
            axios.get('/api-admin/services-type-recette').then((response) => {
                console.log("response.data.recettes")
                console.log(response.data)
                this.ServicesTypeRecette = response.data.recettes;
                this.Categories = response.data.categories;
                console.log(this.ServicesTypeRecette)
            });
        },

        setcategorie(value) {
             
            this.data_filtrer.categorie = value
            this.data_filtrer.service = []



            this.optionServices = []
            if (this.data_filtrer.categorie != null) {
                this.optionServices = this.ServicesTypeRecette; 
                this.optionServices = this.optionServices.filter(service => {
                     return   service.id_categorie == this.data_filtrer.categorie.id 
                })
            }

            console.log(this.optionServices)

        },
        addMonths(newTag) {
            const tag = {
                name: newTag,
                code_month: newTag.substring(0, 2) + Math.floor((Math.random() * 10000000))
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
        StatistiquesRecettes(data_filtrer) {
  

                this.formData = new FormData();
 
                if (this.arr_years.length > 0) {
                    for (var i = 0; i < this.arr_years.length; i++) {
                        this.formData.append("arr_years[" + i + "]", this.arr_years[i]['year_id']);
                    }
                }

                if (this.arr_months.length > 0) {
                    for (var i = 0; i < this.arr_months.length; i++) {
                        this.formData.append("arr_months[" + i + "]", this.arr_months[i]['month_id']);
                    }
                }else{
                    this.formData.append("all_months", 'all');
                }
 
                if (this.data_filtrer.service != null && typeof this.data_filtrer.service.id_service !== "undefined"){
                console.log('service : ' + this.data_filtrer.service.id_service)
                this.formData.append("filtrer[service_id]", this.data_filtrer.service.id_service);
            }

            if (this.data_filtrer.categorie != null && typeof this.data_filtrer.categorie.id !== "undefined"){
                console.log(this.data_filtrer.categorie.length)
                console.log('here categorie_id : ' + this.data_filtrer.categorie.id)
                this.formData.append("filtrer[categorie_id]", this.data_filtrer.categorie.id);
            }


            if (this.datetimePicker[0] != null && this.datetimePicker[1]) { 
                    this.formData.append("filtrer[date][from]", this.data_filtrer.datetimes[0]);
                    this.formData.append("filtrer[date][to]", this.data_filtrer.datetimes[1]);
                }

                this.loaded = false

                this.charts.labels.splice(0)
                this.charts.sums.splice(0)
                this.charts.background.splice(0)
                this.montantTotal = 0;

                const config = { headers: { 'content-type': 'multipart/form-data' } }
                axios.post('/api-admin/dashboard/statistiques-recettes' , this.formData, config).then((response) => {
                    for (var i = 0; i < response.data.length; i++) {

                        //var month_french = this.options_months[parseInt(response.data.paiements[i].monthKey - 1)].name 
                        //this.charts.months.push(month_french)
                        this.charts.labels.push(response.data[i].nom_service)
                        this.charts.sums.push(parseFloat(response.data[i].sums))
                        this.charts.background.push(this.arr_background[i])
                        this.montantTotal =this.montantTotal + parseFloat(parseFloat(response.data[i].sums));

                        console.log(response.data[i].qte)
                    }
                    this.statistiques_recettes = response.data
                    this.loaded = true
                  });

                
             
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
            this.StatistiquesRecettes(this.data_filtrer)
        }, 

        clearDataInputs() {
            this.arr_years = []
            this.arr_months = [],
            this.datetimePicker =  [new Date(new Date().getTime() - 7 * 24 * 60 * 60 * 1000), new Date()] ;
            this.datetimes = []
         }, 
        OpenModelDetailsRecettesMonth(month, year, day, index, nom_service){
            this.month = month
            this.year = year
            this.nom_service = nom_service

            this.popup_search = ''

            if (typeof this.$refs.details_recettes_monthContainer !== "undefined")
                    this.PluginLoader(false, this.$refs.details_recettes_monthContainer)
                this.formData = new FormData();
 
                    
                this.formData.append("filtrer[year]", year);
                this.formData.append("filtrer[month]", month);
                this.formData.append("filtrer[addSelectDay]", "true");

                if (this.data_filtrer.service != null && typeof this.data_filtrer.service.id_service !== "undefined"){
                console.log('service : ' + this.data_filtrer.service.id_service)
                this.formData.append("filtrer[service_id]", this.data_filtrer.service.id_service);
            }

            if (this.data_filtrer.categorie != null && typeof this.data_filtrer.categorie.id !== "undefined"){
                console.log(this.data_filtrer.categorie.length)
                console.log('here categorie_id : ' + this.data_filtrer.categorie.id)
                this.formData.append("filtrer[categorie_id]", this.data_filtrer.categorie.id);
            }

            if (this.datetimePicker[0] != null && this.datetimePicker[1]) { 
                    this.formData.append("filtrer[date][from]", this.data_filtrer.datetimes[0]);
                    this.formData.append("filtrer[date][to]", this.data_filtrer.datetimes[1]);
                }

                 
                this.details_recettes_month.splice(0)
                this.montantTotalMonth = 0;

                const config = { headers: { 'content-type': 'multipart/form-data' } }
                axios.post('/api-admin/dashboard/statistiques-recettes', this.formData, config).then((response) => {
                     

                      for (var i = 0; i < response.data.length; i++) { 
                        this.montantTotalMonth =this.montantTotalMonth + parseFloat(parseFloat(response.data[i].sums));

                     }
                    this.details_recettes_month = response.data

                    
                });
        }
    },
    beforeMount() { 

        if (this.$can('Consulter les statistiques des recettes')) {

            this.ListServicesTypeRecette()
            this.filtrer();
            var dt = new Date();
            for (var startYear = 2016; startYear <= dt.getFullYear(); startYear++) {
                this.options_years.push({ name: startYear, year_id: startYear })
            }
        }
    },
    computed: {
        filteredStatistiquesRecettes() {
            return this.statistiques_recettes.filter(reglement => {
                //return reglement.months.toLowerCase().includes(this.search_months.toLowerCase())
            })
        },

        filteredStatistiquesRecettesMonth() {
            return this.details_recettes_month.filter(recette => {
                return recette.dayKey.toLowerCase().includes(this.popup_search.toLowerCase())
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
