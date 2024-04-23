<template>
    <div class="main-panel">
        <div v-if="$can('Consulter l’historique des réglements')" class="content-wrapper">
            <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                    <div ref="formContainer" class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <h1 class="card-title">
                                        <i class="mdi-style-content mdi mdi-history"></i>
                                        <span class="titre">
                                            {{ $t('side.menu.paiements.historiques') }}
                                        </span>
                                    </h1><br><br>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <form @submit.prevent="filtrer($event)" class="forms-sample">
                                        <div class="row">
                                            <!--<div class="col-6">
                                                <div class="form-group mr-b-0em">
                                                    <label class="form__label"> {{$t('content.pages.paiements.historiques.recherche.adherents') }}</label>
                                                    <select class="form-control" v-model="data_filtrer.id_adherent">
                                                        <option value="tous" selected="true">Tous</option>
                                                        <option v-for="(adherent, index) in list_adherents" :value="adherent.id"> {{ adherent.code_client }}, {{ adherent.nom }} </option>
                                                    </select>
                                                </div>
                                            </div>-->
                                            <div class="col-12">
                                                <div  class="form-group mr-b-0em">
                                                    <label class="form__label"> ID / CIN </label>
                                                    <!--<multiselect v-model="data_filtrer.value_id_adherent" :options="list_adherents" :custom-label="nameWithCodeClient" placeholder="Recherche.." label="code_client" track-by="code_client"></multiselect>-->
                                                    <input class="form-control" v-model="data_filtrer.matricule_cin"   placeholder="ID ou Cin" />
                                                </div> 
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group mr-b-0em">
                                                    <label class="form__label"> Sélectionnez </label>
                                                    <select class="form-control" v-model="data_filtrer.order">
                                                        <option value="all">{{$t('content.pages.paiements.historiques.recherche.ordre.tous')}}</option>
                                                        <option value="desc-first">{{$t('content.pages.paiements.historiques.recherche.ordre.derniers_abonnement')}}</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group mr-b-0em">
                                                    <label class="form__label">Date du au </label> <br>
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
                        </div>
                    </div>
                </div>
            </div>
            <div  v-if="list_abonners.length>0" class="row">
                <div class="col-md-4 grid-margin stretch-card">
                    <div class="border-none card bg-primary text-black ">
                        <div class="card-body pb-0">
                            <div class="d-flex justify-content-between">
                                <h4 class="card-title mb-0">{{ $t('content.pages.paiements.historiques.revenu.net_paye') }}</h4>
                                <p class="font-weight-semibold mb-0"></p>
                            </div>
                            <h3 class="font-weight-medium"> {{ TotalPaiements }} {{$t('content.text.dh')}}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 grid-margin stretch-card ">
                    <div class="border-none card bg-success text-black">
                        <div class="card-body pb-0">
                            <div class="d-flex justify-content-between">
                                <h4 class="card-title mb-0">{{ $t('content.pages.paiements.historiques.revenu.montant_paye')}} </h4>
                                <p class="font-weight-semibold mb-0"> </p>
                            </div>
                            <h3 class="font-weight-medium mb-4"> {{ parseFloat(MontanPayes).toFixed(2) }} {{$t('content.text.dh')}}</h3>
                        </div>
                    </div>
                </div>
                <!--<div class="col-md-4 grid-margin stretch-card ">
                    <div class="border-none card bg-warning text-black">
                        <div class="card-body pb-0">
                            <div class="d-flex justify-content-between">
                                <h4 class="card-title mb-0">
                                    {{ $t('content.pages.paiements.historiques.revenu.montant_retourne')}}
                                </h4>
                                <p class="font-weight-semibold mb-0"> </p>
                            </div>
                            <h3 class="font-weight-medium mb-4"> {{totalMontantRetourner}} {{$t('content.text.dh')}}</h3>
                        </div>
                    </div>
                </div>-->
                <div class="col-md-4 grid-margin stretch-card">
                    <div class="border-none card bg-danger text-white ">
                        <div class="card-body pb-0">
                            <div class="d-flex justify-content-between">
                                <h4 class="card-title mb-0">{{ $t('content.pages.paiements.historiques.revenu.montant_rest')}} </h4>
                                <p class="font-weight-semibold mb-0"></p>
                            </div>
                            <h3 class="font-weight-medium">{{ totalRestaPayer() }} {{$t('content.text.dh')}}</h3>
                        </div>
                    </div>
                </div>
            </div>

            <div v-if="list_abonners.length>0"  class="row">
                <div class="col-lg-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-header ">
                            <div class="row">
                                <div class="col-md-4">
                                    <h3>{{ $t('content.pages.paiements.historiques.info_adherent.titre')}}</h3>
                                </div>
                            </div>
                        </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <ul class="timeline">
                                    <li class="timeline-item">
                                        <p class="timeline-content"><b>ID : </b>
                                            <router-link v-if="$can('Consulter la fiche d\'adhérent')" :to="{name: 'adherent', params:{code: list_abonners[0].adherent.id_empreinte }}">
                                                <a> {{ list_abonners[0].adherent.id_empreinte }} </a>
                                            </router-link>
                                            <span v-else>{{ list_abonners[0].adherent.id_empreinte }}</span>
                                        </p>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-4">
                                <ul class="timeline">
                                    <li class="timeline-item">
                                        <p class="timeline-content"><b>{{$t('content.pages.paiements.historiques.info_adherent.nom')}} : </b> {{ list_abonners[0].adherent.nom }} </p>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-4">
                                <ul class="timeline">
                                    <li class="timeline-item">
                                        <p class="timeline-content"><b>Email : </b> {{ list_abonners[0].adherent.email }} </p>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

            <div class="row" v-for="(abonner, index) in list_abonners">
                <div class="col-lg-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-header ">
                            <div class="row">
                                <!--<div class="col-md-4">
                                    <h3>{{ $t('content.pages.paiements.historiques.info_adherent.titre')}}</h3>
                                </div>-->
                                <div class="col-md-12">
                                    <h3>{{$t('content.pages.paiements.historiques.details_abonnement.titre')}} <a href="#">#{{abonner.id}}</a>
                                    </h3>
                                </div> 
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <!--<div class="col-md-4">
                                    <ul class="timeline">
                                        <li class="timeline-item">
                                            <p class="timeline-content"><b>{{$t('content.pages.paiements.historiques.info_adherent.matricule')}} : </b>
                                                <router-link v-if="$can('Profile adhérent')" :to="{name: 'adherent', params:{code: abonner.adherent.code_client }}">
                                                    <a> {{ abonner.adherent.code_client }} </a>
                                                </router-link>
                                                <span v-else>{{ abonner.adherent.code_client }}</span>
                                            </p>
                                        </li>
                                        <li class="timeline-item">
                                            <p class="timeline-content"><b>{{$t('content.pages.paiements.historiques.info_adherent.nom')}} : </b> {{ abonner.adherent.nom }} </p>
                                        </li>
                                        <li class="timeline-item">
                                            <p class="timeline-content"><b>Email : </b> {{ abonner.adherent.email }} </p>
                                        </li>
                                    </ul>
                                </div>-->
                                <div class="col-md-6">
                                    <ul class="timeline">
                                        <li class="timeline-item">
                                            <p class="timeline-content"><b>{{$t('content.pages.paiements.historiques.details_abonnement.type_abonnement')}} : </b> {{ abonner.abonnements[0].libelle }}, {{ abonner.abonnements[0].nb_mois }} {{$t('content.text.mois')}}</p>
                                        </li>
                                        <li class="timeline-item">
                                            <p class="timeline-content"><b>{{$t('content.pages.paiements.historiques.details_abonnement.type_pack')}} : </b> {{ abonner.packs[0].description }}, {{ abonner.packs[0].prix }} Dh</p>
                                        </li>
                                        <li class="timeline-item">
                                            <p class="timeline-content">
                                                <b>{{$t('content.pages.paiements.historiques.details_abonnement.activities')}} : </b>
                                                <span v-for="(activitie, index) in abonner.packs[0].activities">
                                                    {{ activitie.name }} <span v-if="((index + 1) != abonner.packs[0].activities.length)">,</span>
                                                </span>
                                            </p>
                                        </li>
                                        <li v-if="abonner.suspend == 1" class="timeline-item">
                                            <p class="timeline-content"><b>{{$t('content.pages.paiements.historiques.details_abonnement.suspendre')}} : </b> {{ abonner.suspended_at | formatDate }}</p>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-md-6">
                                    <ul class="timeline">
                                        <li class="timeline-item">
                                            <p class="timeline-content"><b>Date de début : </b> 
                                                {{ abonner.date_debut | formatDate }}
                                            </p>
                                        </li>
                                        <li class="timeline-item">
                                            <p class="timeline-content"><b>Date de fin : </b> 
                                                {{ abonner.date_fin | formatDate }}
                                            </p>
                                        </li>
                                        <li class="timeline-item">
                                            <p class="timeline-content"><b>Paiements : </b> 
                                                <span v-if='RestPayerChaqueAbonner(abonner) > 0'>
                                                    Pas encore payé
                                                </span>
                                                <span  v-else >
                                                    Payé
                                                </span>
                                            </p>
                                        </li>
                                    </ul>
                                </div> 
                            </div><br>
                            <div class="table-responsive">
                                <br>
                                <table style="background : none !important; border : none !important; " id="data-packs" class="datatables table table-striped table-bordered table-hover">
                                    <tbody class="tr-center">
                                        <tr style="background-color : #000; color : #fff;">
                                            <th>{{$t('content.pages.paiements.historiques.details_reglement.tableau.date_debut') }}</th>
                                            <th>{{$t('content.pages.paiements.historiques.details_reglement.tableau.date_fin') }}</th>
                                            <th>{{$t('content.pages.paiements.historiques.details_reglement.tableau.prix_pack_mois') }}</th>
                                            <th>{{$t('content.pages.paiements.historiques.details_reglement.tableau.remise_abn_promo') }}</th>
                                            <th>Frais</th>
                                            <th :title="`(${$t('content.pages.paiements.historiques.details_reglement.tableau.prix_pack_mois')} ) - (${$t('content.pages.paiements.historiques.details_reglement.tableau.remise_abn_promo')})`">{{$t('content.pages.paiements.historiques.details_reglement.tableau.net_paye') }}</th>
                                            <th>{{$t('content.pages.paiements.historiques.details_reglement.tableau.statut.titre') }}</th>
                                        </tr>
                                        <tr class="tr-center">
                                            <td> {{ abonner.date_debut | formatDate }} </td>
                                            <td> {{ abonner.date_fin | formatDate }} </td>
                                            <td>
                                                {{ PackFoisMois(abonner) }} {{$t('content.text.dh')}}
                                            </td>
                                            <td>
                                                {{ RemisePromo(abonner) }} {{$t('content.text.dh')}}
                                            </td>
                                             <td> {{ abonner.total_frais}} {{$t('content.text.dh')}}</td>
                                            <td :title="`(${$t('content.pages.paiements.historiques.details_reglement.tableau.prix_pack_mois')} ) - (${$t('content.pages.paiements.historiques.details_reglement.tableau.remise_abn_promo')})`">
                                                {{ MoyenneAbonnement(abonner) }} {{$t('content.text.dh')}}
                                            </td>
                                            <td>
                                                <label v-if="Date.now() > new Date(abonner.date_fin)" class="badge badge-danger">
                                                    {{$t('content.pages.paiements.historiques.details_reglement.tableau.statut.expire')}}
                                                </label>
                                                <label v-else class="badge badge-success">{{$t('content.pages.paiements.historiques.details_reglement.tableau.statut.active')}}</label>
                                            </td>
                                        </tr>
                                        <tr style="background-color : rgb(157, 157, 157); color : #000;" class="tr-center" colspan="6">
                                            <th colspan="3">{{$t('content.pages.paiements.historiques.details_reglement.tableau.paiements.date_paiement')}}</th>
                                            <th colspan="2">{{$t('content.pages.paiements.historiques.details_reglement.tableau.paiements.montant_paye')}}</th>
                                            <th  colspan="2" >
                                                Action
                                            </th>
                                        </tr>
                                        <tr class="tr-center" v-for="(paiement, index) in abonner.paiements" v-if="paiement.prix > 0">
                                            <td colspan="3"> {{ paiement.date_paiement | formatDate }} </td>
                                            <td colspan="2"> {{ parseFloat(paiement.prix).toFixed(2) }} {{$t('content.text.dh')}}</td>
                                            <th  colspan="2" >    
                                                <span title="Supprimer" v-if="$can('Supprimer un paiement')" @click="SupprimerPaiement( paiement.id,  )" class="mdi-delete-btn"> <i class="mdi mdi-delete-forever"></i> </span>
                                            </th>
                                        </tr>

                                        <tr class="tr-center border-none">
                                            <th class="unborde" colspan="2"></th>
                                            <th class="unborde" colspan="2"></th>
                                            <th colspan="2" style="background-color : rgb(157, 157, 157); color : #000;">Net à payer :</th>
                                            <th colspan="1" > {{ MoyenneAbonnement(abonner) }} {{$t('content.text.dh')}} </th>
                                        </tr>

                                        <tr class="tr-center border-none">
                                            <th class="unborde" colspan="2"></th>
                                            <th class="unborde" colspan="2"></th>
                                            <th colspan="2" style="background-color : rgb(157, 157, 157); color : #000;">Montant Total payé : </th>
                                            <th colspan="1" > {{ MontantSurCaisse(abonner) }}  {{$t('content.text.dh')}} </th>
                                        </tr>
                                        <tr class="tr-center border-none">
                                            <th class="unborde" colspan="2"></th>
                                            <th class="unborde" colspan="2"></th>
                                            <th colspan="2" style="background-color : rgb(157, 157, 157); color : #000;">Restant à payer : </th>
                                            <th colspan="1" > {{ RestPayerChaqueAbonner(abonner) }} {{$t('content.text.dh')}} </th>
                                        </tr>


                                        <!--<tr class="tr-center border-none">
                                            <th class="unborde" colspan="2"></th>
                                            <th class="unborde" colspan="1"></th>
                                            <th colspan="2" style="background-color : rgb(157, 157, 157); color : #000;">{{$t('content.pages.paiements.historiques.details_reglement.tableau.calcule.total_paye_et_retour')}}</th>
                                            <th colspan="1" style="background-color : rgb(157, 157, 157); color : #000;">{{$t('content.pages.paiements.historiques.details_reglement.tableau.calcule.montant_caisse')}}</th>
                                        </tr>
                                        <tr class="tr-center border-none">
                                            <td class="unborde" colspan="2"></td>
                                            <td class="unborde" colspan="1"></td>
                                            <td colspan="2"> {{ parseFloat(TotalPaiementsAbonner(abonner.paiements)).toFixed(2) }} - {{ parseFloat(MontantRetourner(abonner.is_moneys)).toFixed(2) }} </td>
                                            <td colspan="1"> {{ MontantSurCaisse(abonner) }} {{$t('content.text.dh')}} </td>
                                        </tr>
                                        <tr class="tr-center border-none">
                                            <th class="unborde" colspan="2"></th>
                                            <th class="unborde" colspan="1"></th>
                                            <th colspan="2" style="background-color : rgb(157, 157, 157); color : #000;">{{$t('content.pages.paiements.historiques.details_reglement.tableau.calcule.net_paye_et_caisse')}}</th>
                                            <th colspan="1" style="background-color : rgb(157, 157, 157); color : #000;">{{$t('content.pages.paiements.historiques.details_reglement.tableau.calcule.reste_payer')}}</th>
                                        </tr>
                                        <tr class="tr-center border-none">
                                            <td class="unborde" colspan="2"></td>
                                            <td class="unborde" colspan="1"></td>
                                            <td colspan="2"> {{ MoyenneAbonnement(abonner) }} - {{ MontantSurCaisse(abonner) }} </td>
                                            <td colspan="1"> {{ RestPayerChaqueAbonner(abonner) }} {{$t('content.text.dh')}} </td>
                                        </tr>-->
                                    </tbody>
                                </table>
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
            datetimePicker: [null,null], // [new Date(new Date().getTime() - 365 * 24 * 60 * 60 * 1000), new Date(new Date().getTime() + 1 * 24 * 60 * 60 * 1000)],
            showTimeRangePanel: false,
            data_filtrer: {
                id_adherent: 'tous',
                order: '',
                datetimes: [],
                value_id_adherent : [], 
                matricule_cin : ''
            },
            pagination: [],
            list_abonners: [],
            list_adherents: [],
            search: '',
            saveIndex: -1,
        }
    },
    mounted() {
        console.log('Component mounted.')
    },
    methods: {
        nameWithCodeClient({ code_client, nom }) {
            return `${code_client} -  ${nom} `
        },
        listAbonners() {
            if (this.data_filtrer.matricule_cin != '' ) {
            if (typeof this.$refs.formContainer !== "undefined")
                this.PluginLoader(false, this.$refs.formContainer)
            this.formData = new FormData();

            //if (this.data_filtrer.id_adherent != 'tous')
            //    this.formData.append("filtrer[id_adherent]", this.data_filtrer.id_adherent);

            if (this.data_filtrer.matricule_cin != '' ) {
                this.formData.append("filtrer[matricule_cin]", this.data_filtrer.matricule_cin);
                console.log("matricule_cin : " + this.data_filtrer.matricule_cin)
            }
            if(this.$route.query.adherent){
                this.formData.append("filtrer[id_adherent]", this.$route.query.adherent);
            }

            if(this.$route.query.id_abonnement){
                console.log('id_abonnement : ' + this.$route.query.id_abonnement)
                this.formData.append("filtrer[id_abonnement]", this.$route.query.id_abonnement);
            }

            if (this.data_filtrer.order != null && this.data_filtrer.order != "")
                this.formData.append("filtrer[order]", this.data_filtrer.order);

            if (this.datetimePicker[0] != null && this.datetimePicker[1]) {
                const date = this.datetimePicker;
                this.data_filtrer.datetimes = [date[0].toDateString(), date[1].toDateString()]
                this.formData.append("filtrer[date][from]", this.data_filtrer.datetimes[0]);
                this.formData.append("filtrer[date][to]", this.data_filtrer.datetimes[1]);
            }
            const config = { headers: { 'content-type': 'multipart/form-data' } }
            axios.post('/api-admin/historiques-regelements', this.formData, config).then((response) => {
                if (typeof response.data.adherent !== "undefined") {
                    this.AlertResponseFalse("", 'Adhérent n\'existe pas', "warning");
                 }else{
                    this.list_abonners = response.data; //.data;
                 }
                

                
            });
        }
        },
         listReglementsAbonnmentByAdherent(matricule_cin) {
             
            this.formData = new FormData();
 
            this.formData.append("filtrer[matricule_cin]", matricule_cin); 
            this.data_filtrer.matricule_cin = matricule_cin

            if(this.$route.query.id_abonnement){
                console.log('id_abonnement : ' + this.$route.query.id_abonnement)

                this.formData.append("filtrer[id_abonnement]", this.$route.query.id_abonnement);
            }

           /* if (this.data_filtrer.order != null && this.data_filtrer.order != "")
                this.formData.append("filtrer[order]", this.data_filtrer.order);

            if (this.datetimePicker[0] != null && this.datetimePicker[1]) {
                const date = this.datetimePicker;
                this.data_filtrer.datetimes = [date[0].toDateString(), date[1].toDateString()]
                this.formData.append("filtrer[date][from]", this.data_filtrer.datetimes[0]);
                this.formData.append("filtrer[date][to]", this.data_filtrer.datetimes[1]);
            }*/
            const config = { headers: { 'content-type': 'multipart/form-data' } }
            axios.post('/api-admin/historiques-regelements', this.formData, config).then((response) => {
                if (typeof response.data.adherent !== "undefined") {
                    this.AlertResponseFalse("",'Adhérent n\'existe pas', "warning");
                }else{
                    this.list_abonners = response.data; //.data;
                }
            });
        },
        filtrer(event) {
            // this.pagination = []
            this.listAbonners(this.data_filtrer)
        },
        handleRangeClose() {
            this.showTimeRangePanel = false;
        },
        ListAdherents() {    
            axios.get('/api-admin/list-adherents-has-abonners').then((response) => {
                this.list_adherents = response.data;

            });
        },
        MoyenneAbonnement(abonner) {
            //var promo = (abonner.packs[0].pivot.promo) ? abonner.packs[0].pivot.promo : 0;
            //var moyenne = parseFloat(abonner.abonnements[0].nb_mois * abonner.packs[0].prix) - [parseFloat(abonner.remise) + parseFloat(promo)]
            var moyenne = abonner.prix_ttc 
            return parseFloat(moyenne).toFixed(2)
        },
        PackFoisMois(abonner) {
            //return parseFloat(abonner.packs[0].prix).toFixed(2) + ' * ' + abonner.abonnements[0].nb_mois + '// = ' + parseFloat(abonner.packs[0].prix * abonner.abonnements[0].nb_mois).toFixed(2)
            return parseFloat(abonner.packs[0].prix ).toFixed(2)
            //return parseFloat(abonner.packs[0].prix * abonner.abonnements[0].nb_mois).toFixed(2)
        },
        RemisePromo(abonner) {
            var promo = (abonner.packs[0].pivot.promo) ? abonner.packs[0].pivot.promo : 0;
            //return abonner.remise + ' + ' + promo + ' = ' + [parseFloat(abonner.remise) + parseFloat(promo)]
            return parseFloat(abonner.remise) + parseFloat(promo)
        },
        TotalPaiementsAbonner(paiements) {
            return paiements.reduce((acc, crypt) => {
                return acc + parseFloat(crypt.prix)
            }, 0)
        },
        MontantRetourner(is_moneys) {
            return is_moneys.reduce((acc, crypt) => {
                return acc + parseFloat(crypt.prix)
            }, 0)
        },
        RestantaPayer(abonner) {
            return parseFloat(this.MoyenneAbonnement(abonner) - (this.TotalPaiementsAbonner(abonner.paiements) - this.MontantRetourner(abonner.is_moneys))).toFixed(2);
        },
        MontantSurCaisse(abonner) {
            var total_paiement = parseFloat(this.TotalPaiementsAbonner(abonner.paiements))
            var montant_retourner = parseFloat(this.MontantRetourner(abonner.is_moneys))
            return parseFloat(total_paiement - montant_retourner).toFixed(2)

        },

        totalRestaPayer() {
            return parseFloat(this.TotalPaiements - (parseFloat(this.MontanPayes) - this.totalMontantRetourner)).toFixed(2)
        },

        RestPayerChaqueAbonner(abonner) {
            return parseFloat(this.MoyenneAbonnement(abonner) - Math.abs(this.MontantSurCaisse(abonner))).toFixed(2)
        },

        clearDataInputs() {
            //this.datetimePicker = [new Date(new Date().getTime() - 365 * 24 * 60 * 60 * 1000), new Date(new Date().getTime() + 1 * 24 * 60 * 60 * 1000)]
            this.datetimePicker =  [null, null] //[new Date(currYear, 0, 1), new Date(currYear, currMonth, currDay)]
            this.data_filtrer.value_id_adherent = []
            this.data_filtrer.order = ""
        },
        selectedDate() {
            var d = new Date();
            var currMonth = d.getMonth();
            var currDay = d.getDate();
            var currYear = d.getFullYear();
            this.datetimePicker = [null, null] // [new Date(currYear, 0, 1), new Date(new Date().getTime() + 1 * 24 * 60 * 60 * 1000)]
        },
        SupprimerPaiement(id_paiement) {
            this.$fire(
                    this.AlertFire('delete')
                ).then((result) => {
                    if (result.value) {
                        this.submitStatus = 'PENDING'
                        this.formData = new FormData();
                        this.formData.append('id_paiement', id_paiement); 
                        const config = { headers: { 'content-type': 'multipart/form-data' } }
                        axios.post('/api-admin/paiement/supprimer-paiement', this.formData, config).then(res => {
                                switch (res.data.etat) {
                                    case false:
                                        this.AlertResponseFalse("Paiement", "Paiement n'existe pas", "warning")
                                        break;
                                    default:
                                        this.AlertResponseTrue("", "La suppression est effectué avec succès", "success");
                                        window.location.href = '/admin/reglements?adherent=' + this.list_abonners[0].adherent.code_client ;
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
        }
    },
    beforeMount() {
        if (this.$can('Consulter l’historique des réglements')) {
            this.selectedDate()
            console.log(this.$route.query.adherent)
            if (this.$route.query.adherent) {
                this.listReglementsAbonnmentByAdherent(this.$route.query.adherent)
            } 
        } 

    },
    computed: {
        MontanPayes() {
            if (typeof this.list_abonners.length != "undefined") {
                return this.list_abonners.reduce((acc, abonner) => {
                    return abonner.paiements.reduce((accs, crypts) => {
                        acc = parseFloat(acc) + parseFloat(crypts.prix)
                        return acc
                    }, 0)
                }, 0)
            } else
                return 0;
        },
        totalMontantRetourner() {

            var total = 0.00;
            for (var i = 0; i < this.list_abonners.length; i++) {
                for (var j = 0; j < this.list_abonners[i].is_moneys.length; j++) {
                    total += parseFloat(this.list_abonners[i].is_moneys[j].prix)
                }
            }
            return parseFloat(total).toFixed(2);

        },
        TotalPaiements() {

            var total = 0.00;
            for (var i = 0; i < this.list_abonners.length; i++) {
                //total += parseFloat(this.list_abonners[i].packs[0].prix * this.list_abonners[i].abonnements[0].nb_mois) - [parseFloat(this.list_abonners[i].remise) + parseFloat(this.list_abonners[i].packs[0].pivot.promo)]
                total += this.list_abonners[i].prix_ttc
            }
            return parseFloat(total).toFixed(2);
        },

    },
    created: function() {},


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


.tr-center td,
.tr-center th {
    text-align: center;
}


.tr-break,
.tr-break td,
.border-none {
    background: none !important;
    border: none !important;
}

.border-none .unborde,
.border-none .unborde {
    border: none !important;
}


.resteExiste {
    background: #ff5151 !important
}

.all-paid {
    background: #00bd00;
}

</style>
