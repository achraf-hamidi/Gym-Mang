<template>
    <div class="main-panel">
        <div v-if="$can('Consulter l’historique des abonnements')" class="content-wrapper">
            <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <div ref="formContainer" class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h1 class="card-title">
                                        <i class="mdi-style-content mdi mdi mdi-history"></i>
                                        <span class="titre">Historique des abonnements</span>
                                    </h1><br><br>
                                </div>
                                <div class="col-md-6">
                                    <p v-if="abonnement_encours.length > 0" class="text-right">
                                       <b v-if="abonnement_encours[0].abonners.length > 0" > {{abonnement_encours[0].abonners.length}} Abonnements</b>
                                    </p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <form @submit.prevent="filtrer($event)" class="forms-sample">
                                        <div class="row">
                                             
                                            <div class="col-md-4">
                                                <div class="form-group mr-b-0em">
                                                    <label class="form__label"> {{ $t('content.pages.abonnements.encours.recherche.abonnement') }}</label>
                                                    <!--<select class="form-control" v-model="data_filtrer.abonnement">
                                                        <option value="tous">Tous</option>
                                                        <option v-for="(abonnement, index) in abonnements" :value="abonnement.id"> {{ abonnement.libelle }} </option>
                                                    </select>-->

                                                    <multiselect v-model="data_filtrer.abonnement" @input="setid_abonnement($event)"  :options="abonnements" :custom-label="libeleAbonnement" placeholder="Recherche.." label="libelle" track-by="libelle"></multiselect>
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
                                            <div class="col-md-4">
                                                <div class="form-group mr-b-0em">
                                                    <label class="form__label">Date du au</label> <br>
                                                    <date-picker style="width: 100%;" :show-time-panel="showTimeRangePanel" @close="handleRangeClose" v-model="datetimePicker" range type="datetime" format="DD/MM/YYYY"></date-picker>
                                                </div>
                                            </div>
                                            <div class="col-md-12 text-right">
                                               <button type="submit" class="btn btn-success mr-2"> <i class="mdi mdi-magnify"></i> {{ $t('content.bouton.recherche') }}</button>
                                                <a  @click="clearDataInputs" href="javascript:void(0)" class="btn btn-light">Vider les champs</a>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <hr>

                            


                            <div v-if="abonnement_encours.length > 0"  class="mt-5 row">
                                      <div class="col-md-4" >
                                         <p> <b>Matricule : </b> {{ abonnement_encours[0].code_client }} </p>
                                     </div>
                                     <div class="col-md-4" >
                                         <p> <b>Nom : </b> {{ abonnement_encours[0].nom }} </p>
                                     </div>
                                     <div class="col-md-4" >
                                         <p> <b>Email : </b> {{ abonnement_encours[0].email }} </p>
                                     </div> 
                             </div>

                             <div class="row mt-3">   


                                <div class="col-md-4 grid-margin stretch-card">
                        <div class="border-none card bg-primary text-black ">
                            <div class="card-body pb-0">
                                <div class="d-flex justify-content-between">
                                    <h4 class="card-title mb-0">
                                        Montant Total net à payer
                                    </h4>
                                    <p class="font-weight-semibold mb-0"></p>
                                </div>
                                <h3 class="font-weight-medium"> 
                                        {{montantTotalNetPayer}} {{$t('content.text.dh')}}
                                </h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 grid-margin stretch-card">
                        <div class="border-none card bg-success text-black ">
                            <div class="card-body pb-0">
                                <div class="d-flex justify-content-between">
                                    <h4 class="card-title mb-0">
                                        Montant Total payé
                                    </h4>
                                    <p class="font-weight-semibold mb-0"></p>
                                </div>
                                <h3 class="font-weight-medium"> 
                                        {{montantTotal_Paye}} {{$t('content.text.dh')}}
                                </h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 grid-margin stretch-card">
                        <div class="border-none card bg-danger text-black ">
                            <div class="card-body pb-0">
                                <div class="d-flex justify-content-between">
                                    <h4 class="card-title mb-0">
                                       Total restant à payer
                                    </h4>
                                    <p class="font-weight-semibold mb-0"></p>
                                </div>
                                <h3 class="font-weight-medium"> 
                                    {{ parseFloat(montantTotalNetPayer - montantTotal_Paye).toFixed(2)}} {{$t('content.text.dh')}}
                                </h3>
                            </div>
                        </div>
                    </div>

                            </div>


                            <div   class="row">
                                <div v-if="abonnement_encours.length > 0" class="col-md-12 mt-5">
                                    <div style="overflow-x:auto;" id="packs" class="tab-pane fade in active show">
                                        <table id="data-packs" class="datatables table table-striped table-bordered table-hover">
                                            <thead class="thead-dark">
                                                <tr> 
                                                    <th>{{$t('content.pages.abonnements.encours.tableau.date_debut') }}</th>
                                                    <th>{{$t('content.pages.abonnements.encours.tableau.date_fin') }}</th>
                                                    <th>{{$t('content.pages.abonnements.encours.tableau.jours') }}</th>
                                                     <th>
                                                     Abonnement & pack</th>
                                                     <th>Frais</th>
                                                     <th>Net à payer</th>
                                                    <th>Sommes Payé</th>
                                                    <th>Restant à payer</th>
                                                    <th>
                                                        Action
                                                    </th>
 
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="(abonner, index) in abonnement_encours[0].abonners"> 
                                                    <td >{{ abonner.date_debut | formatDate  }}</td>
                                                    <td >{{ abonner.date_fin | formatDate  }}</td>
                                                    <td :class="[ abonner.RestDays < 0 ? 'bg-red' : 'bg-green' ]" >
                                                        <span v-if="abonner.RestDays < 0">
                                        {{$t('content.text.jours_terminer')}}
                                    </span>
                                    <span v-else >
                                        {{ abonner.RestDays }} {{$t('content.text.jours')}}
                                    </span>


                                    </td>
                                    <td >
                                        <b v-if="abonner.abonnements[0]"> {{ abonner.abonnements[0].libelle }} </b><br>
                                    <span v-if="abonner.packs[0]"> {{ abonner.packs[0].description }}</span>
                                    </td> 
                                    <td> {{ abonner.total_frais  }} {{$t('content.text.dh')}}</td>
                                        <td> {{ abonner.prix_ttc  }} {{$t('content.text.dh')}}</td>
                            <td>
                                {{  abonner.sommes_paye }} {{$t('content.text.dh')}}
                            </td>
                            <td>
                                {{ abonner.prix_ttc - abonner.sommes_paye }} {{$t('content.text.dh')}}
                            </td>
                                                    <td> 

                                                         <router-link v-if="$can('Consulter l’historique des réglements')"  title="Historique des réglements "   :to="{name: 'reglements', query : { adherent : `${abonner.adherent.code_client}`, id_abonnement : `${abonner.id}` }}"  class="mdi-history-btn">
                                                        <i class="mdi mdi-cash-multiple"></i>
                                                        </router-link>

                                                         <span v-if="$can('Supprimer un abonnement')" title="Supprimer"   @click="SupprimerAbonnement( abonner.id , index)" class="mdi-delete-btn"> <i class="mdi mdi-delete-forever"></i> </span>

                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <vue-pagination :pagination="pagination" @paginate="AbonnementsEnCours(data_filtrer)" :offset="4"></vue-pagination>
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
     props: ['code'],
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
            data_filtrer: {
                abonnement : [],
                pack : [],
                datetimes: [],
                
            },
            abonnement_encours: [],
            pagination: [],
            packs: [],
            List_Packs : [],
            abonnements: [],
            count_adherents : 0,
            search_adherent: '',
            formData: {},
            montantTotalNetPayer : 0,
            montantTotal_Paye : 0,
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


        AbonnementsEnCours(data_filtrer) {
            if (typeof this.$refs.formContainer !== "undefined")  
                this.PluginLoader(false, this.$refs.formContainer)
            
            const current_page = (this.pagination.current_page) ? this.pagination.current_page : 1;
            this.formData = new FormData(); 


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

            if (this.code != '')
                this.formData.append("filtrer[matricule]", this.code);


            //this.formData.append("filtrer[symbole]", '<');

            const config = { headers: { 'content-type': 'multipart/form-data' } }
            axios.post('/api-admin/abonners/historiques-abonnements-by-adherent?page=' + current_page, this.formData, config).then((response) => {
                //this.abonnement_encours = response.data.data;
                //this.pagination = response.data;

                this.count_adherents = response.data.count_adherents;
                this.abonnement_encours = response.data.adherent.data;
                this.pagination = response.data.adherent;

                if (this.abonnement_encours[0]) {
                    for (var i = 0 ; i < this.abonnement_encours[0].abonners.length ; i++ ) {
                        var sommes_paye = this.abonnement_encours[0].abonners[i].paiements.reduce((n, {prix}) => n + parseFloat(prix) , 0);
                        this.abonnement_encours[0].abonners[i].sommes_paye =  sommes_paye
                    }

                    this.montantTotalNetPayer = parseFloat(this.abonnement_encours[0].abonners.reduce((n, {prix_ttc}) => n + parseFloat(prix_ttc)  , 0) ).toFixed(2);

                    this.montantTotal_Paye = parseFloat(this.abonnement_encours[0].abonners.reduce((n, {sommes_paye}) => n +  parseFloat(sommes_paye)  , 0)).toFixed(2);

                     //console.log('montantTotalNetPayer est : ' + this.montantTotalNetPayer)
                    //console.log('montantTotal_Paye est : ' + this.montantTotal_Paye)
                }else{
                     this.montantTotalNetPayer  = 0
                     this.montantTotal_Paye = 0
                }

            });
        },
        RefreshAbonnementsEnCours(newAdherents) {
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
            this.AbonnementsEnCours(this.data_filtrer)
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
                                        this.AlertResponseTrue("", "Abonnement supprimer avec succès", "success");
                                       window.location.reload();
                                       // this.abonnement_encours[0].abonners.splice(index, 1);
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
            this.datetimePicker = [null, null]
            this.data_filtrer.abonnement = []
            this.data_filtrer.pack = []
            
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
        if (this.$can('Consulter l’historique des abonnements')) {
            this.ListTypeAbonnements();
            this.ListPacks();
            this.filtrer();
        }
            
    },
    computed: {
        Filterabonnement_encours() {
            return this.abonnement_encours.filter(adherent => {
                return adherent.code_client.toLowerCase().includes(this.search_adherent.toLowerCase()) || 
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
