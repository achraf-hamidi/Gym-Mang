<template>
    <div class="main-panel">
        <div v-if="$can('Gestions des adhérents')" class="content-wrapper">
            <!--<div v-if="$can('Ajouter un adhérent')" class="row">
                <div class="col-md-12 float-right text-right">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bd-example-modal-lg"> <i class=" mdi mdi-plus"></i> {{ $t('content.pages.adherents.liste.nouveau') }} </button>
                </div>
                <div class="col-md-12">
                    <add-adherent @RefreshListAdherents="RefreshListAdherents($event)"></add-adherent>
                </div>
            </div><br>-->
            <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <div ref="formContainer" class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h1 class="card-title">
                                        <i class="mdi-style-content mdi  mdi-account-multiple-plus"></i>
                                        <span class="titre"> {{ $t('content.pages.adherents.liste.titre') }} </span>
                                    </h1><br><br>
                                </div>
                                <div class="col-md-6">
                                    <p class="text-right">
                                        <b> {{ count_adherents }} Adhérents</b>
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
                                                    <input v-model="data_filtrer.nom" placeholder="Nom et prénom"
                                                        class="form-control">
                                                </div>
                                            </div>
                                            <!-- <div class="col-md-4">
                                                <div class="form-group mr-b-0em">
                                                    <label class="form__label">Matricule</label>
                                                    <input v-model="data_filtrer.matricule" placeholder="Matricule"
                                                        class="form-control">
                                                </div>
                                            </div> -->
                                            <div class="col-md-4">
                                                <div class="form-group mr-b-0em">
                                                    <label class="form__label">ID </label>
                                                    <input v-model="data_filtrer.id_empreinte" placeholder="ID "
                                                        class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group mr-b-0em">
                                                    <label class="form__label">CIN</label>
                                                    <input v-model="data_filtrer.cin" placeholder="CIN"
                                                        class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="form-group mr-b-0em">
                                                    <label class="form__label">Genre</label>
                                                    <select class="form-control" v-model="data_filtrer.genre">
                                                        <option value="tous">Tous</option>
                                                        <option :value="$t('content.text.homme')">
                                                            {{ $t('content.text.homme') }}</option>
                                                        <option :value="$t('content.text.femme')">
                                                            {{ $t('content.text.femme') }}</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="form-group mr-b-0em">
                                                    <label class="form__label">{{
                                                        $t('content.pages.adherents.liste.recherche.statut.titre')
                                                    }}</label>
                                                    <select class="form-control" v-model="data_filtrer.is_valide">
                                                        <option value="tous">{{
                                                            $t('content.pages.adherents.liste.recherche.statut.tous') }}
                                                        </option>
                                                        <option value="1">{{
                                                            $t('content.pages.adherents.liste.recherche.statut.valide') }}
                                                        </option>
                                                        <option value="0">{{
                                                            $t('content.pages.adherents.liste.recherche.statut.bloque') }}
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group mr-b-0em">
                                                    <label class="form__label">Date du au </label> <br>
                                                    <date-picker format="DD/MM/YYYY" style="width: 100%;"
                                                        :show-time-panel="showTimeRangePanel" @close="handleRangeClose"
                                                        v-model="datetimePicker" range type="datetime"></date-picker>
                                                </div>
                                            </div>
                                            <div class="col-6 text-left">
                                                <button type="button" @click="clearDataInputs"
                                                    class="btn btn-primary mr-2">{{ $t('content.text.select_tout') }}</button>
                                            </div>
                                            <div class="col-6 text-right">
                                                <button type="submit" class="btn btn-success mr-2"> <i
                                                        class="mdi mdi-magnify"></i> {{ $t('content.bouton.recherche')
                                                        }}</button>
                                                <a @click="clearDataInputs" href="javascript:void(0)"
                                                    class="btn btn-light">{{ $t('content.bouton.annuler') }}</a>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="row">
                                <!--<div class="col-md-12"><br>
                                    <div class="form-group mr-b-0em">
                                        <label class="form__label"><i class="mdi mdi-filter-outline"></i> {{ $t('content.pages.adherents.liste.filtrer.titre') }}</label>
                                        <input v-model="search_adherent" :placeholder="$t('content.pages.adherents.liste.filtrer.placeholder')" class="form-control">
                                    </div>
                                </div>-->
                                <div v-if="filteredListAdherents.length > 0" class="mt-5 col-md-12 ">
                                    <div style="overflow-x:auto;" id="packs" class="tab-pane fade in active show">
                                        <table id="data-packs"
                                            class="datatables table table-striped table-bordered table-hover">
                                            <thead class="thead-dark">
                                                <tr>
                                                    
                                                    <th>Photo</th>
                                                    <!-- <th> ID</th> -->
                                                    <th> ID  </th>
                                                    <!-- <th>{{ $t('content.pages.adherents.liste.tableau.matricule') }}</th> -->

                                                    <!--<th>{{ $t('content.pages.adherents.liste.tableau.cin') }}</th>-->
                                                    <th>{{ $t('content.pages.adherents.liste.tableau.nom') }}</th>
                                                    <th>{{ $t('content.pages.adherents.liste.tableau.email') }}</th>
                                                    <th>{{ $t('content.pages.adherents.liste.tableau.tele') }}</th>
                                                    <!--<th>{{ $t('content.pages.adherents.liste.tableau.date_naiss') }}</th>-->
                                                    <th>Date d'inscription</th>
                                                    <th>{{ $t('content.pages.adherents.liste.tableau.genre') }}</th>
                                                    <th>{{ $t('content.pages.adherents.liste.tableau.statut') }}</th>
                                                    <th>
                                                        Action
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="(adherent, index) in filteredListAdherents">
                                                    
                                                    <td>

                                                        <img class="photo-adherents" v-if="adherent.image != null"
                                                            :src="`/clubi/public/admin/adherents/photos/${adherent.image}`">
                                                        <img class="photo-adherents" v-else
                                                            :src="`/clubi/public/admin/adherents/photos/${adherent.image}`">

                                                        <!--<img style="border-radius : unset!important;" :src="`/admin/adherents/qr_code/${adherent.qr_code}.png`"> -->
                                                    </td>
                                                    <!-- <td> {{ adherent.id }} </td> -->
                                                    
                                                    <td>
                                                        <router-link v-if="$can('Consulter la fiche d\'adhérent')"
                                                            :to="{ name: 'adherent', params: { code: adherent.code_client } }">
                                                            {{ adherent.id_empreinte }}
                                                        </router-link>
                                                        <span v-else>{{ adherent.id_empreinte }}</span>
                                                    </td>

                                                    <td> {{ adherent.nom }} </td>
                                                    <td> {{ adherent.email }} </td>
                                                    <td> {{ adherent.tele }} </td>
                                                    <!--<td>{{ adherent.date_naiss | formatDate  }}</td>-->
                                                    <td>{{ adherent.created_at | formatDate }}</td>
                                                    <td v-if="adherent">
                                                        <span
                                                            v-if="adherent.gender == 'Homme'">{{ $t('content.text.homme_H') }}</span>
                                                        <span v-else>{{ $t('content.text.femme_F') }}</span>
                                                    </td>
                                                    <td>
                                                         <label v-if="adherent.AbonnementActif == 1"
                                                            class="badge badge-success">{{
                                                                $t('content.pages.adherents.liste.recherche.statut.valide')
                                                            }}</label>
                                                        <label v-else class="badge badge-danger">{{
                                                            $t('content.pages.adherents.liste.recherche.statut.bloque')
                                                        }}</label>
                                                    </td>
                                                    <td>
                                                        <span title="Supprimer" v-if="$can('Supprimer un adhérent')"
                                                            @click="SupprimerAdherent(adherent.id)"
                                                            class="mdi-delete-btn"> <i class="mdi mdi-delete-forever"></i>
                                                        </span>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <vue-pagination :pagination="pagination" @paginate="ListAdherents(data_filtrer)"
                                        :offset="4"></vue-pagination>
                                </div>
                                <div v-else class="aucune col-md-12">
                                    <i class="mdi-style mdi mdi-alert"></i> {{ $t('content.alerts.aucune_info') }}
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
            datetimePicker: [null, null], // [new Date(new Date().getTime() - 365 * 24 * 60 * 60 * 1000), new Date(new Date().getTime() + 1 * 24 * 60 * 60 * 1000)],
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
                nom: '',
                matricule: '',
                id_empreinte: '',
                cin: '',
                genre: 'tous',
            },
            adherents: [],
            pagination: [],
            search_adherent: '',
            formData: {},
            count_adherents: 0,
        }
    },
    mounted() {
        console.log('Component mounted.')
    },
    methods: {
        ListAdherents(data_filtrer) {
            if (typeof this.$refs.formContainer !== "undefined")
                this.PluginLoader(false, this.$refs.formContainer)
            const current_page = (this.pagination.current_page) ? this.pagination.current_page : 1;
            this.formData = new FormData();
            if (this.data_filtrer.nom != '')
                this.formData.append("filtrer[nom]", this.data_filtrer.nom);

            if (this.data_filtrer.cin != '')
                this.formData.append("filtrer[cin]", this.data_filtrer.cin);

            //if (this.data_filtrer.id_empreinte != '')
                this.formData.append("filtrer[id_empreinte]", this.data_filtrer.id_empreinte);

            if (this.data_filtrer.matricule != '')
                this.formData.append("filtrer[matricule]", this.data_filtrer.matricule);

            if (this.data_filtrer.genre != 'tous')
                this.formData.append("filtrer[genre]", this.data_filtrer.genre);

            if (this.data_filtrer.is_valide != 'tous')
                this.formData.append("filtrer[is_valide]", this.data_filtrer.is_valide);

            console.log(this.formData) 

            if (this.datetimePicker[0] != null && this.datetimePicker[1]) {
                this.formData.append("filtrer[date][from]", this.data_filtrer.datetimes[0]);
                this.formData.append("filtrer[date][to]", this.data_filtrer.datetimes[1]);
            }
            const config = { headers: { 'content-type': 'multipart/form-data' } }
            axios.post('/api-admin/adherents?page=' + current_page, this.formData, config).then((response) => {
                this.count_adherents = response.data.adherent.total;
                this.adherents = response.data.adherent.data;
                this.pagination = response.data.adherent;
                console.log(response.data)
            });
        },
        RefreshListAdherents(newAdherents) {
            if (newAdherents != null) {
                this.adherents.unshift(newAdherents)
            }
        },
        filtrer(event) {
            if (this.datetimePicker[0] != null && this.datetimePicker[1]) {
                const date = this.datetimePicker;
                this.data_filtrer.datetimes = [date[0].toDateString(), date[1].toDateString()]
            }
            this.pagination = []
            this.ListAdherents(this.data_filtrer)
        },
        handleRangeClose() {
            this.showTimeRangePanel = false;
        },

        clearDataInputs() {
            this.datetimePicker = [null, null] //[new Date(new Date().getTime() - 365 * 24 * 60 * 60 * 1000), new Date(new Date().getTime() + 1 * 24 * 60 * 60 * 1000)]
            this.data_filtrer.is_valide = "tous"
            this.data_filtrer.nom = ''
            this.data_filtrer.matricule = ''
            this.data_filtrer.id_empreinte = ''
            this.data_filtrer.cin = ''
            this.data_filtrer.genre = 'tous'
            this.pagination = []
            this.ListAdherents(this.data_filtrer)
        },

        SupprimerAdherent(id_adherent) {
            this.$fire(
                this.AlertFire('delete')
            ).then((result) => {
                if (result.value) {
                    this.submitStatus = 'PENDING'
                    this.formData = new FormData();
                    this.formData.append('id_adherent', id_adherent);
                    const config = { headers: { 'content-type': 'multipart/form-data' } }
                    axios.post('/api-admin/adherent/supprimer-adherent', this.formData, config).then(res => {
                        switch (res.data.etat) {
                            case false:
                                this.AlertResponseFalse("Adhérent", "Adhérent n'existe pas", "warning")
                                break;
                            default:
                                this.AlertResponseTrue("", "La suppression est effectué avec succès", "success");
                                window.location.reload();
                                break;
                        }
                    }).catch(e => { })
                        .finally(f => {
                            setTimeout(() => {
                                this.submitStatus = 'OK'
                            }, 500)
                        })
                }
            })
        }

    },
    beforeMount() {
        if (this.$can('Gestions des adhérents'))
            this.filtrer();

    },
    computed: {
        filteredListAdherents() {
            return this.adherents.filter(adherent => {
                return adherent.code_client.toLowerCase().includes(this.search_adherent.toLowerCase()) ||
                    adherent.cin.toLowerCase().includes(this.search_adherent.toLowerCase()) ||
                    adherent.id_empreinte.toLowerCase().includes(this.search_adherent.toLowerCase()) ||
                    adherent.nom.toString().toLowerCase().includes(this.search_adherent.toLowerCase()) ||
                    adherent.gender.toString().toLowerCase().includes(this.search_adherent.toLowerCase()) ||
                    adherent.email.toString().toLowerCase().includes(this.search_adherent.toLowerCase()); // ||
                //adherent.abonners[0].RestDays.toString().toLowerCase().includes(this.search_adherent.toLowerCase());
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
}</style>
