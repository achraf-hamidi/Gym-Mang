<template>
    <div class="main-panel">
        <div v-if="$can('Consulter les statistiques de nombre des abonnements vendus')" class="content-wrapper">
            <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                    <div ref="formContainer" class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <h1 class="card-title">
                                        <i class="mdi-style-content mdi mdi-chart-bar"></i>
                                        <span class="titre">
                                            Statistiques de nombre des abonnements vendus
                                        </span>
                                    </h1><br><br>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <form @submit.prevent="filtrer($event)" class="forms-sample">
                                        <div class="row">
                                            <!--<div class="col-12">
                                                <div class="form-group mr-b-0em">
                                                    <label class="form__label">Année</label>
                                                    <multiselect v-model.trim="arr_years" tag-placeholder="Add this as new tag" placeholder="Année" label="name" track-by="year_id" :options="options_years" :multiple="false" :taggable="true" @tag="addYears"></multiselect>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group mr-b-0em">
                                                    <label class="form__label">Mois ( vous pouvez séléctionner plusieurs mois )</label>
                                                    <multiselect v-model.trim="arr_months" tag-placeholder="Add this as new tag" placeholder="Mois ( vous pouvez séléctionner plusieurs mois )" label="name" track-by="month_id" :options="options_months" :multiple="true" :taggable="true" @tag="addMonths"></multiselect>
                                                </div>
                                            </div>-->
                                            <div class="col-md-12">
                                                    <div class="form-group mr-b-0em">
                                                        <label class="form__label">Date du au </label> <br>
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
                                <div class="col-6 ">
                                    <div class="card-header d-flex justify-content-between">
                                        <h4 class="card-title mb-0" style="color: #0b0b0b !important;">
                                             Statistiques des packs par année et mois
                                        </h4>
                                    </div>
                                    <div v-if="charts.packs.counts">
                                        <chart-bar v-if="loaded" :background="charts.packs.background" label="Nombre d'adhérents" :labels="charts.packs.description" :data="charts.packs.counts"></chart-bar>
                                    </div>
                                    <div v-else class="aucune col-md-12">
                                        <i class="mdi-style mdi mdi-alert"></i> {{$t('content.alerts.aucune_info')}}
                                    </div>
                                </div>
                                <div class="col-6 ">
                                    <div class="card-header d-flex justify-content-between">
                                        <h4 class="card-title mb-0" style="color: #0b0b0b !important;">
                                             Statistiques des abonnements  par année et mois
                                        </h4>
                                    </div>
                                    <div v-if="charts.abonnements.libelle">
                                        <chart-bar v-if="loaded" :background="charts.abonnements.background" label="Nombre d'adhérents" :labels="charts.abonnements.libelle" :data="charts.abonnements.counts"></chart-bar>
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
            formData: {},
            submitStatus: '',

            charts: {
                packs: {
                    description: [],
                    counts: [],
                    background: [],
                },
                abonnements: {
                    libelle: [],
                    counts: [],
                    background: [],
                },
                montantTotal: 0
            },
            loaded: false,

            options_years: [],
            arr_years: [],
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
            arr_months: [],
            arr_background: ['#009c61', '#cc0099', '#cc9900', '#cc0033', '#0099cc', '#6600cc', '#66cc00', 'aqua', 'black', 'blue', 'fuchsia', 'gray', 'green',
                'lime', 'maroon', 'navy', 'olive', 'orange', 'purple',
                'silver', 'teal', 'white', 'yellow'
            ],
            showTimeRangePanel : false
            
        }   
    },
    methods: {
        addYears(newTag) {
            const tag = {
                name: newTag,
                year_id: newTag.substring(0, 2) + Math.floor((Math.random() * 10000000))
            }
            this.options_years.push(tag)
            this.arr_years.push(tag)
        },

        addMonths(newTag) {
            const tag = {
                name: newTag,
                month_id: newTag.substring(0, 2) + Math.floor((Math.random() * 10000000))
            }
            this.options_months.push(tag)
            this.arr_months.push(tag)
        },


        StatistiquesAbonners() {

            if (typeof this.$refs.formContainer !== "undefined")  
                this.PluginLoader(false, this.$refs.formContainer)
            this.formData = new FormData();


            /*if (this.arr_years.length > 0) {
                for (var i = 0; i < this.arr_years.length; i++) {
                    this.formData.append("arr_years[" + i + "]", this.arr_years[i]['year_id']);
                }
            }

            if (this.arr_months.length > 0) {
                for (var i = 0; i < this.arr_months.length; i++) {
                    this.formData.append("arr_months[" + i + "]", this.arr_months[i]['month_id']);
                }
            }*/

            if (this.datetimePicker[0] != null && this.datetimePicker[1]) { 
                this.formData.append("filtrer[date][from]", this.datetimePicker[0].toDateString());
                this.formData.append("filtrer[date][to]", this.datetimePicker[1].toDateString());
            }else{
                this.datetimePicker =  [new Date(new Date().getTime() - 7 * 24 * 60 * 60 * 1000), new Date()] ;
                this.formData.append("filtrer[date][from]", this.datetimePicker[0].toDateString());
                this.formData.append("filtrer[date][to]", this.datetimePicker[1].toDateString());
            }


            this.loaded = false

            this.charts.packs.description.splice(0)
            this.charts.packs.counts.splice(0)
            this.charts.abonnements.libelle.splice(0)
            this.charts.abonnements.counts.splice(0)
            this.charts.packs.background.splice(0)
            this.charts.abonnements.background.splice(0)

            //this.charts.packs.montantTotal = 0;

            const config = { headers: { 'content-type': 'multipart/form-data' } }
            axios.post('/api-admin/abonners/statistiques', this.formData, config).then((response) => {

                //console.log( response.data.packs)
                for (var i = 0; i < response.data.packs.length; i++) {
                    this.charts.packs.description.push(response.data.packs[i].description + ' : ' + response.data.packs[i].month + '/' + response.data.packs[i].year)
                    this.charts.packs.counts.push(response.data.packs[i].counts)
                    this.charts.packs.background.push(this.arr_background[i])
                }
                for (var i = 0; i < response.data.abonnements.length; i++) {
                    this.charts.abonnements.libelle.push(response.data.abonnements[i].libelle + ' : ' + response.data.abonnements[i].month + '/' + response.data.abonnements[i].year)
                    this.charts.abonnements.counts.push(response.data.abonnements[i].counts)
                    this.charts.abonnements.background.push(this.arr_background[i])
                }
                this.loaded = true
            });

        },
        filtrer(event) {

            this.StatistiquesAbonners()
        },
        handleRangeClose() {
            this.showTimeRangePanel = false;
        },
         clearDataInputs(){
             this.datetimePicker =  [new Date(new Date().getTime() - 7 * 24 * 60 * 60 * 1000), new Date()] ;
        }

    },
    beforeMount() {
        if (this.$can('Consulter les statistiques de nombre des abonnements vendus')) {
            this.filtrer();
            var dt = new Date();
            for (var startYear = 2019; startYear <= dt.getFullYear(); startYear++) {
                this.options_years.push({ name: startYear, year_id: startYear })
            }
        }
        
        

        //this.options_months = ['01', '02', '03', '04', '05', '06', '07', '07', '09',
        //                        '10', '11', '12'
        //                        ]

        /*for (var startMonths = 1; startMonths <= 12 ; startMonths++) {
            if (startMonths <= 9 )
                this.options_months.push({ name: '0'+startMonths, month_id: '0'+startMonths })
            else
                this.options_months.push({ name: startMonths, month_id: startMonths })

        }*/
    },
    computed: {}
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



.card-header {
    padding: 15px !important;
    border-top: 4px solid #ff9c00;
    color: #fff !important;
}


h4,
h3,
h1,
h2 {
    color: #0b0b0b !important;
    text-transform: initial !important;
}

</style>
