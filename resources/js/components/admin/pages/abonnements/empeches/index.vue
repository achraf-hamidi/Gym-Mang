<template>
    <div class="main-panel">
        <div v-if="$can('Consulter les absences')" class="content-wrapper">
            <div v-if="$can('Ajouter une absence')" class="row">
                <div class="col-md-12 float-right text-right">
                    <button @click="FormEmpty" type="button" class="btn btn-primary" data-toggle="modal" data-target=".bd-example-modal-lg">
                        <i class=" mdi mdi-plus"></i>
                       {{ $t('content.pages.abonnements.empeches.nouveau.titre') }}
                    </button>
                </div>
                <div class="col-md-12">
                    <add-empeche @RefreshListEmpeches="RefreshListEmpeches($event)"></add-empeche>
                </div>
            </div><br>
            <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <div ref="formContainer" class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <h1 class="card-title">
                                        <i class="mdi-style-content mdi mdi-timetable "></i>
                                        <span class="titre">  {{ $t('content.pages.abonnements.empeches.titre') }} </span>
                                    </h1><br><br>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <form @submit.prevent="filtrer($event)" class="forms-sample">
                                        <div class="row">
                                            <!--<div class="col-6">
                                                <div class="form-group mr-b-0em">
                                                    <label class="form__label"> {{ $t('content.pages.abonnements.empeches.liste.recherche.statut.titre') }}</label>
                                                    <select class="form-control" v-model="data_filtrer.is_valide">
                                                        <option value="tous"> {{ $t('content.pages.abonnements.empeches.liste.recherche.statut.tous') }}</option>
                                                        <option value="1"> {{ $t('content.pages.abonnements.empeches.liste.recherche.statut.valide') }} </option>
                                                        <option value="0"> {{ $t('content.pages.abonnements.empeches.liste.recherche.statut.bloque') }} </option>
                                                    </select>
                                                </div>
                                            </div>-->
                                            <div class="col-12">
                                                <div class="form-group mr-b-0em">
                                                    <label class="form__label"> {{ $t('content.pages.abonnements.empeches.liste.recherche.date') }}  </label> <br>
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
                                <!--<div class="col-md-12">
                                    <div class="form-group mr-b-0em"><br>
                                        <label class="form__label"><i class="mdi mdi-filter-outline"></i>  {{ $t('content.pages.abonnements.empeches.liste.filtrer.titre') }}</label>
                                        <input v-model="search_empeches_adherent" :placeholder="$t('content.pages.abonnements.empeches.liste.filtrer.placeholder')" class="form-control">
                                    </div>
                                </div>-->
                                <div v-if="filteredListEmpeches.length > 0" class="col-md-12 mt-5">
                                    <div style="overflow-x:auto;" id="packs" class="tab-pane fade in active show">
                                        <table id="data-packs" class="datatables table table-striped table-bordered table-hover">
                                            <thead class="thead-dark">
                                                <tr>

                                                    <th>{{ $t('content.pages.abonnements.empeches.liste.tableau.matricule') }} </th>
                                                    <th>{{ $t('content.pages.abonnements.empeches.liste.tableau.nom') }} </th>
                                                    <th>{{ $t('content.pages.abonnements.empeches.liste.tableau.empeche') }} </th>
                                                    <th>{{ $t('content.pages.abonnements.empeches.liste.tableau.date_declaration') }} </th>
                                                    <th>{{ $t('content.pages.abonnements.empeches.liste.tableau.debut_empeche') }} </th>
                                                    <th>{{ $t('content.pages.abonnements.empeches.liste.tableau.date_retour') }} </th>
                                                    <th>{{ $t('content.pages.abonnements.empeches.liste.tableau.nv_date_fin') }} </th>
                                                    <th>{{ $t('content.pages.abonnements.empeches.liste.tableau.nb_jours_declare') }} </th>
                                                    <th>{{ $t('content.pages.abonnements.empeches.liste.tableau.jours') }} </th>
                                                    <th>{{ $t('content.pages.abonnements.empeches.liste.tableau.statut') }} </th>
                                                    <th>{{ $t('content.pages.abonnements.empeches.liste.tableau.action') }} </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="(empeche, index) in filteredListEmpeches">
                                                    <td>
                                                        <router-link v-if="$can('Consulter la fiche d\'adhérent')" :to="{name: 'adherent', params:{code: empeche.abonner.adherent.code_client }}">
                                                            <a> {{ empeche.abonner.adherent.code_client }} </a>
                                                        </router-link>
                                                        <span v-else>{{ empeche.abonner.adherent.code_client }}</span>
                                                    </td>
                                                    <td> {{ empeche.abonner.adherent.nom }}</td>
                                                    <td> {{ empeche.empeche }} </td>
                                                    <td> {{ empeche.created_at | formatDate  }} </td>
                                                    <td> {{ empeche.date_absence | formatDate  }} </td>
                                                    <td> {{ empeche.date_retour | formatDate  }} </td>
                                                    <td> {{ empeche.date_fin | formatDate  }} </td>
                                                    <td> {{ empeche.nb_jours }} {{$t('content.text.jours')}}</td>
                                                    <td> 
                                                       <!-- {{ JoursRestant( empeche.abonner.date_fin, empeche.date_fin, empeche.nb_jours ) }} Jours-->
                                                        <p>
                                                            {{ empeche.abonner.RestDays  }} {{$t('content.text.jours')}}
                                                        </p>

                                                    </td>
                                                    <td :class="[dateCheck(empeche.date_absence,empeche.date_retour) == 'Expiré' ? 'bg-red' : '', dateCheck(empeche.date_absence,empeche.date_retour) == 'En attendant' ? 'bg-orange' : '' , dateCheck(empeche.date_absence,empeche.date_retour) == 'Active' ? 'bg-green' : '']">
                                                        <label class="badge " >
                                                            {{ dateCheck(empeche.date_absence,empeche.date_retour) }}
                                                        </label>
                                                    </td>
                                                    <td>
                                                        <span v-if="$can('Modifier une absence') && dateCheck(empeche.date_absence,empeche.date_retour) != 'Expiré'" data-toggle="modal" data-target=".bd-example-modal-lg" @click="EditEmpeche(empeche, index)" class="mdi-edit-btn"> <i class="mdi mdi-pen"></i> </span>

                                                        <span v-if="$can('Supprimer une absence')" @click="Delete(empeche.id, index)" class="mdi-delete-btn"> <i class="mdi mdi-delete-forever"></i> </span>

                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <vue-pagination :pagination="pagination" @paginate="ListEmpeches(data_filtrer)" :offset="4"></vue-pagination>
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
//import {en, fr, ar} from 'vuejs-datepicker/dist/locale'
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
            datetimePicker: [null, null], // [new Date(new Date().getTime() - 365 * 24 * 60 * 60 * 1000), new Date(new Date().getTime() + 365 * 24 * 60 * 60 * 1000)],
            showTimeRangePanel: false,

            state: {
                disabledDates: {
                    to: new Date(2020, 0, 5), // Disable all dates up to specific date
                    from: new Date(), // Disable all dates after specific date
                    days: [6, 0], // Disable Saturday's and Sunday's
                    // daysOfMonth: [29, 30, 31], // Disable 29th, 30th and 31st of each month
                    /* dates: [ // Disable an array of dates
                       new Date(2020, 9, 16),
                       new Date(2020, 9, 17),
                       new Date(2020, 9, 18)
                     ],*/
                    /* ranges: [{ // Disable dates in given ranges (exclusive).
                       from: new Date(2020, 11, 25),
                       to: new Date(2020, 11, 30)
                     }, {
                       from: new Date(2021, 1, 12),
                       to: new Date(2021, 2, 25)
                     }],*/
                    // a custom function that returns true if the date is disabled
                    // this can be used for wiring you own logic to disable a date if none
                    // of the above conditions serve your purpose
                    // this function should accept a date and return true if is disabled
                    /*customPredictor: function(date) {
                      // disables the date if it is a multiple of 5
                      if(date.getDate() % 4 == 0){
                        return true
                      }
                    }*/
                }
            },
            data_filtrer: {
                is_valide: 'tous',
                datetimes: [],
            },
            empeches: [],
            pagination: [],
            search_empeches_adherent: '',
            formData: {},

        }
    },
    mounted() {
        //console.log('Component mounted.')
    },
    methods: {
        ListEmpeches(data_filtrer) {
            if (typeof this.$refs.formContainer !== "undefined")  
                this.PluginLoader(false, this.$refs.formContainer)
            
            const current_page = (this.pagination.current_page) ? this.pagination.current_page : 1;
            this.formData = new FormData();
            if (this.data_filtrer.is_valide != 'tous')
                this.formData.append("filtrer[is_valide]", this.data_filtrer.is_valide);

            if (this.datetimePicker[0] != null && this.datetimePicker[1] != null) { 
                this.formData.append("filtrer[date][from]", this.data_filtrer.datetimes[0]);
                this.formData.append("filtrer[date][to]", this.data_filtrer.datetimes[1]);
            }

            const config = { headers: { 'content-type': 'multipart/form-data' } }
            axios.post('/api-admin/empeches?page=' + current_page, this.formData, config).then((response) => {
                this.empeches = response.data.data;
                this.pagination = response.data;
                //console.log(this.empeches)
            });
        },
        RefreshListEmpeches(newEmpeche) {
            if (newEmpeche != null) {
                this.empeches.unshift(newEmpeche)
            }
        },
        filtrer(event) {
            if (this.datetimePicker[0] != null && this.datetimePicker[1] != null) {
                const date = this.datetimePicker;
                this.data_filtrer.datetimes = [date[0].toDateString() , date[1].toDateString() ]
            }
            this.pagination = []
            this.ListEmpeches(this.data_filtrer)
        },
        handleRangeClose() {
            this.showTimeRangePanel = false;
        },

        JoursRestant(finAbonner, finEmpeche, days) {
            var day_start = new Date();
            var day_end = new Date(finEmpeche);
            var total_days = (day_end - day_start) / (1000 * 60 * 60 * 24);
            return Math.round(total_days + 1);
        },

        EditEmpeche(empeche, index) {
            this.eventEmpeches.$emit('edit', { "empeche": empeche, "index": index })
        },

        dateCheck(from, to) {
            var fDate, lDate, cDate;
            fDate = Date.parse(from);
            lDate = Date.parse(to);
            cDate = Date.parse(new Date);

            if (fDate > cDate) {
                return this.$t('content.pages.abonnements.empeches.liste.statut.attendant')
            }
            if (lDate <= cDate) {
                return this.$t('content.pages.abonnements.empeches.liste.statut.expire')
            }

            if ((cDate <= lDate && cDate >= fDate)) {
                return this.$t('content.pages.abonnements.empeches.liste.statut.active')
            }
        },

        FormEmpty() {
            this.eventEmpeches.$emit('empty')
        },
         clearDataInputs(){
            this.datetimePicker = [null,null] //[new Date(new Date().getTime() - 365 * 24 * 60 * 60 * 1000), new Date(new Date().getTime() + 365 * 24 * 60 * 60 * 1000)]
            this.data_filtrer.is_valide = "tous"
        },
        Delete(id_empeche, index) {
            this.$fire(
                this.AlertFire('delete')
            ).then((result) => {
                if (result.value) {
                    this.submitStatus = 'PENDING'
                    this.formData = new FormData();
                    this.formData.append('id_empeche', id_empeche);
                    const config = { headers: { 'content-type': 'multipart/form-data' } }
                    axios.post('/api-admin/empeche/destroy', this.formData, config).then(res => {
                            switch (res.data) {
                                case false:
                                    this.AlertResponseFalse("Absence", "Absence n'existe pas", "warning")
                                    break;
                                default:
                                    this.AlertResponseTrue("", "La suppression est effectué avec succès", "success");
                                    this.empeches.splice(index, 1)                                      
                                    break;
                            }
                        }).catch(e => {})
                        .finally(f => {
                            setTimeout(() => {
                                this.submitStatus = 'OK'
                            }, 500)
                        })
                }
            })
        },
    },
    created: function() {
        this.eventEmpeches.$on('update', data => {
            if (data != null) {
                Vue.set(this.empeches, data.index, data.empeche)
            }
        })
    },
    beforeMount() {
        if (this.$can('Consulter les absences')) 
            this.filtrer();
    },
    computed: {
        filteredListEmpeches() {
            //return this.empeches;
            return this.empeches.filter(search => {
              return search.empeche.toLowerCase().includes(this.search_empeches_adherent.toLowerCase()) ||
                     search.abonner.adherent.nom.toString().toLowerCase().includes(this.search_empeches_adherent.toLowerCase())  ;
                     //adherent.abonners[0].RestDays.toString().toLowerCase().includes(this.search_empeches_adherent.toLowerCase());
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


.Active {
    background: green;
}

.Panding {
    background: yellow;
}

.expire {
    background: red;
}



.mdi-style-content {
    background: -webkit-linear-gradient(45deg, #ffbf36, #ff6028) !important;
    background-clip: border-box;
-webkit-background-clip: text !important;
-webkit-text-fill-color: transparent !important;
    font-size: 55px;
    top: 15px;
    position: relative;
}

h1.card-title {
    position: relative;
    top: -30px;
}

</style>
