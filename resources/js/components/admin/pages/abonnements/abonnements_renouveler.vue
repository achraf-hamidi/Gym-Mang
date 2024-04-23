<template>
    <div class="main-panel">
        <div v-if="$can('Consulter les abonnement actifs')" class="content-wrapper">
            <div v-if="$can('Ajouter un abonnement')" class="row">
                <div class="col-md-12 float-right text-right">
                     
                    <router-link  :to="{name: 'nouveau-abonnement'}" class="btn btn-primary">
                                <i class="mdi-style mdi mdi-playlist-plus"></i>
                                <span>{{ $t('side.menu.abonnements.nouveau') }}</span>
                            </router-link>
                </div>
                <div class="col-md-12">
                    <add-adherent @RefreshListAdherents="RefreshListAdherents($event)"></add-adherent>
                </div>
            </div><br> 
            <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <div ref="formContainer" class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h1 class="card-title">
                                        <i class="mdi-style-content mdi mdi mdi-check"></i>
                                        <span class="titre">Abonnements renouvelés</span>
                                    </h1><br><br>
                                </div>
                                <div class="col-md-6">
                                    <p   class="text-right">
                                       <b> {{ count_abonnement }} Abonnements</b>
                                    </p>
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
                                                    <label class="form__label">ID</label>
                                                     <!-- <input v-model="data_filtrer.matricule" placeholder="Matricule" class="form-control"> -->
                                                    <input v-model="data_filtrer.matricule" placeholder="Matricule" class="form-control"> 

                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group mr-b-0em">
                                                    <label class="form__label">CIN</label>
                                                     <input v-model="data_filtrer.cin" placeholder="CIN" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group mr-b-0em">
                                                    <label class="form__label">Genre</label>
                                                    <select class="form-control" v-model="data_filtrer.genre">
                                                        <option value="tous">Tous</option>
                                                        <option :value="$t('content.text.homme')">{{$t('content.text.homme')}}</option>
                                                        <option :value="$t('content.text.femme')">{{$t('content.text.femme')}}</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group mr-b-0em">
                                                    <label class="form__label"> {{ $t('content.pages.abonnements.encours.recherche.abonnement') }}</label>
                                                    <!--<select class="form-control" v-model="data_filtrer.abonnement">
                                                        <option value="tous">Tous</option>
                                                        <option v-for="(abonnement, index) in abonnements" :value="abonnement.id"> {{ abonnement.libelle }} </option>
                                                    </select>-->

                                                    <multiselect v-model="data_filtrer.abonnement" @input="setid_abonnement($event)" :options="abonnements" :custom-label="libeleAbonnement" placeholder="Recherche.." label="libelle" track-by="libelle"></multiselect>
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
                                            <div class="col-md-12">
                                                <div class="form-group mr-b-0em">
                                                    <label class="form__label">Date du au </label> <br>
                                                    <date-picker style="width: 100%;" :show-time-panel="showTimeRangePanel" @close="handleRangeClose" v-model="datetimePicker" range type="datetime" format="DD/MM/YYYY"></date-picker>
                                                </div>
                                            </div>
                                            <div class="col-6 text-left">
                                                <button type="button"  @click="clearDataInputs" class="btn btn-primary mr-2">{{$t('content.text.select_tout')}}</button>
                                             </div>
                                            <div class="col-6 text-right">
                                               <button type="submit" class="btn btn-success mr-2"> <i class="mdi mdi-magnify"></i> {{ $t('content.bouton.recherche') }}</button>
                                                <a  @click="clearDataInputs" href="javascript:void(0)" class="btn btn-light">Vider les champs</a>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <!--<div class="col-md-12">
                                    <div class="form-group mr-b-0em"><br>
                                        <label class="form__label"><i class="mdi mdi-filter-outline"></i> {{ $t('content.pages.abonnements.encours.filtrer.titre') }}</label>
                                        <input v-model="search_adherent" :placeholder="$t('content.pages.abonnements.encours.filtrer.placeholder')" class="form-control">
                                    </div>
                                </div>-->
                                <div v-if="filteredRenouvledAbonnements.length > 0" class="col-md-12 mt-5">
                                    <div style="overflow-x:auto;" id="packs" class="tab-pane fade in active show">
                                        <table id="data-packs" class="datatables table table-striped table-bordered table-hover">
                                            <thead class="thead-dark">
                                                <tr>
                                                    <th>{{$t('content.pages.abonnements.encours.tableau.matricule') }}</th>
                                                    <th>{{$t('content.pages.abonnements.encours.tableau.nom') }}</th>
                                                    <th>Date de début </th>
                                                    <th>Date de fin </th>
                                                    <th>Jours restants </th>
                                                    <th>{{$t('content.pages.abonnements.encours.tableau.type_abonnement') }}</th>
                                                    <th>{{$t('content.pages.abonnements.encours.tableau.type_pack') }}</th>
                                                    <th>
                                                        Net à payer
                                                    </th>
                                                    <th>
                                                        Action
                                                    </th>
                                                    <!--<th>{{$t('content.pages.abonnements.encours.tableau.statut') }}</th>
                                                    <th>{{$t('content.pages.abonnements.encours.tableau.action') }}</th> -->
 
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="(adherent, index) in filteredRenouvledAbonnements">
                                                    <td>
                                                        <router-link v-if="$can('Consulter la fiche d\'adhérent')" :to="{name: 'adherent', params:{code: adherent.code_client }}">
                                                            <a> {{ adherent.code_client }} </a>
                                                        </router-link>
                                                        <span v-else>{{ adherent.code_client }}</span>
                                                    </td>
                                                    <td> {{ adherent.nom }} </td>
                                                    <td v-if="adherent.abonners[0]">{{ adherent.abonners[0].date_debut | formatDate  }}</td>
                                                    <td v-if="adherent.abonners[0]">{{ adherent.abonners[0].date_fin | formatDate  }}</td>
                                                    <td v-if="adherent.abonners[0]">{{ adherent.abonners[0].RestDays }} j</td>
                                                    <td v-if="adherent.abonners[0].abonnements[0]">{{ adherent.abonners[0].abonnements[0].libelle }}</td>
                                                    <td v-if="adherent.abonners[0].packs[0]">{{ adherent.abonners[0].packs[0].description }}</td>
                                                    <td>
                                                        {{ parseFloat(adherent.abonners[0].prix_ttc).toFixed(2) }} {{$t('content.text.dh')}}
                                                    </td>
                                                    <td>    
                                                        <span  title="Supprimer" v-if="$can('Supprimer un abonnement') &&  adherent.abonners[0]" @click="SupprimerAbonnement( adherent.abonners[0].id , index)" class="mdi-delete-btn"> <i class="mdi mdi-delete-forever"></i> </span>
                                                    </td>
                                                    <!--<td>
                                                        <label v-if="adherent.abonners[0].RestDays > 0" class="badge badge-success">Active</label>
                                                        <label v-else class="badge badge-danger">Expiré</label>
                                                    </td>-->
                                                    <!--<td>
                                                        <span v-if="$can('Modifier abonnement')" data-toggle="modal" data-target=".bd-example-modal-lg" @click="Edit(adherent, index)" class="mdi-edit-btn"> <i class="mdi mdi-pen"></i> </span>
                                                        <span v-if="$can('Suspendre abonnement')"  @click="Suspend(adherent.abonners[0], index)" class="mdi-block-btn"> <i class="mdi mdi-block-helper"></i> </span>
                                                    </td>-->
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <vue-pagination :pagination="pagination" @paginate="RenouvledAbonnements(data_filtrer)" :offset="4"></vue-pagination>
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
            List_Packs : [],
            data_filtrer: {
                abonnement : [],
                pack : [],
                datetimes: [],
                 nom : '',
                matricule : '',
                cin : '',
                genre : 'tous',
            },
            abonnement_encours: [],
            pagination: [],
            packs: [],
            abonnements: [],
            count_abonnement : 0,
            search_adherent: '',
            formData: {},
        }
    },
    mounted() {
        //console.log('Component mounted.')
        // this.PluginLoader(false, this.$refs.formContainer)
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


        RenouvledAbonnements(data_filtrer) {
            if (typeof this.$refs.formContainer !== "undefined")  
                this.PluginLoader(false, this.$refs.formContainer)
            
            const current_page = (this.pagination.current_page) ? this.pagination.current_page : 1;
            this.formData = new FormData();

            if (this.data_filtrer.nom != '')
                this.formData.append("filtrer[nom]", this.data_filtrer.nom);

            if (this.data_filtrer.cin != '')
                this.formData.append("filtrer[cin]", this.data_filtrer.cin);

            if (this.data_filtrer.matricule != '')
                this.formData.append("filtrer[matricule]", this.data_filtrer.matricule);

            if (this.data_filtrer.genre != 'tous')
                this.formData.append("filtrer[genre]", this.data_filtrer.genre);


            if (this.data_filtrer.abonnement.length !== 0) {
                //console.log('test')
                this.formData.append("filtrer[abonnement_id]", this.data_filtrer.abonnement.id);
            }
            if (this.data_filtrer.pack.length !== 0)
                this.formData.append("filtrer[pack_id]", this.data_filtrer.pack.id);

            if (this.datetimePicker[0] != null && this.datetimePicker[1]) { 
                this.formData.append("filtrer[date][from]", this.data_filtrer.datetimes[0]);
                this.formData.append("filtrer[date][to]", this.data_filtrer.datetimes[1]);
            }


            this.formData.append("filtrer[symbole]", '>=');

            const config = { headers: { 'content-type': 'multipart/form-data' } }
            axios.post('/api-admin/abonners/abonnements_renouveler?page=' + current_page, this.formData, config).then((response) => {
                //this.abonnement_encours = response.data.data;
                //this.pagination = response.data;

                this.count_abonnement = response.data.adherent.total;
                this.abonnement_encours = response.data.adherent.data;
                this.pagination = response.data.adherent;

                //console.log(this.pagination)
            });
        },
        RefreshRenouvledAbonnements(newAdherents) {
            if (newAdherents != null) {
                this.abonnement_encours.unshift(newAdherents)
            } 
        },
        filtrer(event) {
            if (this.datetimePicker[0] != null && this.datetimePicker[1]) {
                const date = this.datetimePicker; 
                this.data_filtrer.datetimes = [date[0].toDateString(), date[1].toDateString()]
            }
            this.pagination = []
            this.RenouvledAbonnements(this.data_filtrer)
        },
        handleRangeClose() {
            this.showTimeRangePanel = false;
        },
        ListPacks() {
            axios.get('/api-admin/parametrages/packs').then((response) => {
                this.List_Packs = response.data;

            });
        },
        ListTypeAbonnements() {
            axios.get('/api-admin/parametrages/abonnements').then((response) => {
                //console.log("data : " )
                                 //console.log(response.data)
                this.abonnements = response.data;

            });
        },
        Edit(abonnement_encours, index) {
            this.eventAbonner.$emit('edit', { "abonnement_encours": abonnement_encours, "index": index })
        },
        Suspend(abonner, index) {
            this.$fire(this.AlertFire('suspendre')).then((result) => {
                if (result.value) {
                    this.formData = new FormData()
                    this.formData.append("id_abonner", abonner.id);
                    this.formData.append("id_adherent", abonner.adherent.id);
                    const config = { headers: { 'content-type': 'multipart/form-data' } }
                    axios.post('/api-admin/abonners/store-suspend', this.formData, config).then((response) => {
                        if (response.data) {
                            this.AlertResponseTrue("", this.$t('content.alerts.suspendre.success') , "success")
                            this.abonnement_encours.splice(index, 1);

                        } else {
                             this.AlertResponseFalse("",this.$t('content.alerts.adherents.ni_abonner'), "warning"); 
                        }
                    });
                }
            })
        },
        SupprimerAbonnement(id_abonner, index) {
            this.$fire(
                    this.AlertFire('delete')
                ).then((result) => {
                    if (result.value) {
                        this.submitStatus = 'PENDING'
                        this.formData = new FormData();
                        this.formData.append('id_abonner', id_abonner); 
                        const config = { headers: { 'content-type': 'multipart/form-data' } }
                        axios.post('/api-admin/abonner/supprimer-abonnement', this.formData, config).then(res => {
                                switch (res.data.etat) {
                                    case false:
                                        this.AlertResponseFalse("Abonnement", "Abonnement n'existe pas", "warning")
                                        
                                        break;
                                    default:
                                        this.AlertResponseTrue("", "La suppression est effectué avec succès", "success");
                                       // window.location.reload();
                                        this.abonnement_encours.splice(index, 1);
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
         clearDataInputs(){
            this.datetimePicker =  [new Date(new Date().getTime() - 2 * 24 * 60 * 60 * 1000), new Date(new Date().getTime() + 1 * 24 * 60 * 60 * 1000)]
            this.data_filtrer.abonnement = []
            this.data_filtrer.pack = []
            this.data_filtrer.nom = ''
            this.data_filtrer.matricule = ''
            this.data_filtrer.cin = ''
            this.data_filtrer.genre = 'tous'
            this.RenouvledAbonnements(this.data_filtrer)
        }

    },
    created: function() {
        this.eventAbonner.$on('update', data => {
            if (data != null) {
                Vue.set(this.abonnement_encours, data.index, data.abonnement_encours)
            }
        })
    },
    beforeMount() {
        if (this.$can('Consulter les abonnement actifs')) {
            this.ListTypeAbonnements();
            this.ListPacks();
            this.filtrer();
        }
    },
    computed: {
        filteredRenouvledAbonnements() {
            return this.abonnement_encours.filter(adherent => {
                return adherent.code_client.toLowerCase().includes(this.search_adherent.toLowerCase()) ||
                adherent.cin.toLowerCase().includes(this.search_adherent.toLowerCase()) ||
                    adherent.nom.toString().toLowerCase().includes(this.search_adherent.toLowerCase()) ||
                    adherent.gender.toString().toLowerCase().includes(this.search_adherent.toLowerCase()) ||
                    adherent.email.toString().toLowerCase().includes(this.search_adherent.toLowerCase()) ||
                    adherent.abonners[0].RestDays.toString().toLowerCase().includes(this.search_adherent.toLowerCase());
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
