<template>
    <div class="main-panel">
        <div v-if="$can('Régler les impayés')" class="content-wrapper">
            <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                    <div ref="formContainer" class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <h1 class="card-title">
                                         <i class="mdi-style-content mdi mdi-cash-multiple"></i>
                                        <span class="titre"> {{ $t('content.pages.paiements.impayes.titre') }} (Crédit) </span>
                                    </h1>
                                </div>
                            </div>
                            <!--<div class="row">
                                <div class="col-md-12">
                                    <form @submit.prevent="filtrer($event)" class="forms-sample">
                                        <div class="row"> 
                                            <div class="col-12">
                                                <div class="form-group mr-b-0em">
                                                    <label class="form__label">  Matricule ou CIN </label>
                                                    <input class="form-control" v-model="data_filtrer.matricule_cin"   placeholder="Matricule ou Cin" />
                                                </div>
                                            </div>
                                            <div class="col-12 text-right">
                                                <div class="form-group mr-b-0em">
                                                    <button type="submit" class="btn btn-success mr-2"> <i class="mdi mdi-magnify"></i> {{ $t('content.bouton.recherche') }}</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>-->
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" v-if="list_abonners[0]">
                <div class="col-md-4 grid-margin stretch-card">
                    <div class="border-none card bg-primary text-black ">
                        <div class="card-body pb-0">
                            <div class="d-flex justify-content-between">
                                <h4 class="card-title mb-0">Total net à payer  </h4>
                                <p class="font-weight-semibold mb-0"></p>
                            </div>
                            <h3 class="font-weight-medium"> {{ moyenne_abonnement }} {{$t('content.text.dh')}} </h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 grid-margin stretch-card ">
                    <div class="border-none card bg-success text-black">
                        <div class="card-body pb-0">
                            <div class="d-flex justify-content-between">
                                <h4 class="card-title mb-0">{{ $t('content.pages.paiements.impayes.revenu.montant_paye')}} </h4>
                                <p class="font-weight-semibold mb-0"> </p>
                            </div>
                            <h3 class="font-weight-medium mb-4"> {{ total_montant_paye }} {{$t('content.text.dh')}} </h3>
                        </div>
                    </div>
                </div>
                <!--<div class="col-md-4 grid-margin stretch-card">
                    <div class="border-none card bg-warning text-white ">
                        <div class="card-body pb-0">
                            <div class="d-flex justify-content-between">
                                <h4 class="card-title mb-0">
                                    {{ $t('content.pages.paiements.impayes.revenu.montant_retourne')}}
                                </h4>
                                <p class="font-weight-semibold mb-0"></p>
                            </div>
                            <h3 class="font-weight-medium">
                                {{ t_is_money }} {{$t('content.text.dh')}}
                            </h3>
                        </div>
                    </div>
                </div>-->
                <div class="col-md-4 grid-margin stretch-card">
                    <div class="border-none card bg-danger text-white ">
                        <div class="card-body pb-0">
                            <div class="d-flex justify-content-between">
                                <h4 class="card-title mb-0">{{ $t('content.pages.paiements.impayes.revenu.montant_rest')}} </h4>
                                <p class="font-weight-semibold mb-0"></p>
                            </div>
                            <h3 class="font-weight-medium">
                                {{ reste_a_paye }} {{$t('content.text.dh')}}
                            </h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" v-if="list_abonners[0]">
                <div class="col-lg-8 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-header ">
                            <div class="row">
                                <div class="col-md-6">
                                    <h3>{{ $t('content.pages.paiements.impayes.info_adherent.titre')}}</h3>
                                </div>
                                <div class="col-md-6">
                                    <h3>{{$t('content.pages.paiements.impayes.details_abonnement.titre')}}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <ul class="timeline">
                                        <li class="timeline-item"> 
                                            <p class="timeline-content"><b>Statut : </b>
                                                <span class="actif" v-if="list_abonners[0].adherent.is_valide" >
                                                    actif
                                                </span>
                                                <span class="inactif" v-else >  
                                                    inactif
                                                </span>
                                            </p>
                                                
                                        </li>

                                        <li class="timeline-item">
                                            <p class="timeline-content"><b>ID: </b>
                                                <router-link v-if="$can('Consulter la fiche d\'adhérent')" :to="{name: 'adherent', params:{code: list_abonners[0].adherent.id_empreinte }}">
                                                    <a> {{ list_abonners[0].adherent.id_empreinte }} </a>
                                                </router-link>
                                                <span v-else>{{ list_abonners[0].adherent.id_empreinte }}</span>
                                            </p>
                                        </li>
                                        <li class="timeline-item">
                                            <p class="timeline-content"><b>{{$t('content.pages.paiements.impayes.info_adherent.nom')}} : </b> {{ list_abonners[0].adherent.nom }} </p>
                                        </li>
                                        <li class="timeline-item">
                                            <p class="timeline-content"><b>{{$t('content.pages.paiements.impayes.info_adherent.email')}} : </b> {{ list_abonners[0].adherent.email }} </p>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-md-6">
                                    <ul class="timeline">
                                        <li class="timeline-item">
                                            <p class="timeline-content"><b>{{$t('content.pages.paiements.impayes.details_abonnement.type_abonnement')}} : </b> {{ list_abonners[0].abonnements[0].libelle }}, {{ list_abonners[0].abonnements[0].nb_mois }} {{$t('content.text.mois')}}</p>
                                        </li>
                                        <li class="timeline-item">
                                            <p class="timeline-content"><b>{{$t('content.pages.paiements.impayes.details_abonnement.type_pack')}} : </b> {{ list_abonners[0].packs[0].description }}, {{ list_abonners[0].packs[0].prix }} Dh
                                            </p>
                                        </li>
                                        <li class="timeline-item">
                                            <p class="timeline-content">
                                                <b>Activités : </b>
                                                <span v-for="(activitie, index) in list_abonners[0].packs[0].activities">
                                                    {{ activitie.name }} <span v-if="((index + 1) != list_abonners[0].packs[0].activities.length)">,</span>
                                                </span>
                                            </p>
                                        </li>
                                        <li v-if="list_abonners[0].suspend == 1" class="timeline-item">
                                            <p class="timeline-content"><b>{{$t('content.pages.paiements.impayes.details_abonnement.suspendre')}}: </b> {{ list_abonners[0].suspended_at | formatDate }}</p>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 grid-margin stretch-card width-100 regler">
                    <div class="card">
                        <div class="card-header ">
                            <div class="row">
                                <div class="col-md-12">
                                    <h3>{{$t('content.pages.paiements.impayes.regler.titre')}}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <form v-if='reste_a_paye > 0' @submit.prevent="ReglerAbonnerParAdherent($event)" class="forms-sample">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group mr-b-0em">
                                            <span>{{$t('content.pages.paiements.impayes.regler.inputs.payer.titre')}} </span>
                                            <span class="float-right"> {{ reste_a_paye }} {{$t('content.text.dh')}} </span>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group mr-b-0em" :class="{ 'form-group--error': $v.prixapayer.$error }">
                                            <input class="form-control" v-model.trim="$v.prixapayer.$model" @input="setPrixaPayer($event.target.value)" :placeholder="$t('content.pages.paiements.impayes.regler.inputs.payer.placeholder')" />
                                        </div>
                                        <div v-if="$v.prixapayer.$dirty">
                                            <div class="error" v-if="!$v.prixapayer.decimal">
                                                {{ $t('validation.numeric', { attribute : $t('content.pages.paiements.impayes.regler.inputs.payer.placeholder') }) }}
                                            </div>
                                            <div class="error" v-if="!$v.prixapayer.required">{{ $t('validation.required', { attribute : $t('content.pages.paiements.impayes.regler.inputs.payer.placeholder') }) }}</div>
                                            <div class="error" v-if="!$v.prixapayer.isThanZero || !$v.prixapayer.isThanRestaPaye">
                                                Vérifier le montant payé
                                            </div> 
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group mr-b-0em">
                                            <span>{{$t('content.pages.paiements.impayes.regler.reste')}} </span>
                                            <span class="float-right"> {{ ComputedInputRestPaye }} {{$t('content.text.dh')}} </span>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group mr-b-0em">
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="form-group mr-b-0em">
                                                        <button style="width : 100%;" type="submit" class="btn btn-success mr-2">Régler</button>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-group mr-b-0em">
                                                        <button style="width : 100%;" class="btn btn-light">{{ $t('content.bouton.annuler') }}</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <div v-else class="d-flex justify-content-center">
                                <img style="width : 50%;" src="/admin/payement-ok.png">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" v-if="list_abonners[0]">
                <div class="col-lg-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-header ">
                            <div class="row">
                                <div class="col-md-12">
                                    <h3>Informations abonnement</h3>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <br>
                                <table style="background : none !important; border : none !important; " id="data-packs" class="datatables table table-striped table-bordered table-hover">
                                    <tbody v-for="(abonner, index) in list_abonners">
                                        <tr style="background-color : #000; color : #fff;" class="tr-center">
                                            <th>{{$t('content.pages.paiements.impayes.details_reglement.tableau.date_debut') }}</th>
                                            <th>{{$t('content.pages.paiements.impayes.details_reglement.tableau.date_fin') }}</th>
                                            <th>Jours restants</th>
                                            <th>{{$t('content.pages.paiements.impayes.details_reglement.tableau.prix_pack_mois') }}</th>
                                            <th>Remise & Promo</th>
                                            <th>Frais</th>
                                            <th :title="`(${$t('content.pages.paiements.impayes.details_reglement.tableau.prix_pack_mois')} ) - (${$t('content.pages.paiements.impayes.details_reglement.tableau.remise_abn_promo')})`">{{$t('content.pages.paiements.impayes.details_reglement.tableau.net_paye') }}</th>
                                            <th>{{$t('content.pages.paiements.impayes.details_reglement.tableau.statut.titre') }}</th>
                                        </tr>
                                        <tr class="tr-center">
                                            <td> {{ abonner.date_debut | formatDate }} </td>
                                            <td> {{ abonner.date_fin | formatDate }} </td>
                                             

                                            <td :class="[ abonner.RestDays < 0 ? 'bg-red' : 'bg-green' ]" >
                                                        <span v-if="abonner.RestDays < 0">
                                        {{$t('content.text.jours_terminer')}}
                                    </span>
                                    <span v-else >
                                        {{ abonner.RestDays }} {{$t('content.text.jours')}}
                                    </span>


                                                    </td>


                                            <td>
                                                {{ tarif_pack }} {{$t('content.text.dh')}}
                                            </td>
                                            <td>
                                                 {{ total_remise }} {{$t('content.text.dh')}}
                                            </td>
                                            <td> {{ abonner.total_frais}} {{$t('content.text.dh')}}</td>
                                            <td :title="`(${$t('content.pages.paiements.impayes.details_reglement.tableau.prix_pack_mois')} ) - (${$t('content.pages.paiements.impayes.details_reglement.tableau.remise_abn_promo')})`">
                                                {{  parseFloat(moyenne_abonnement).toFixed(2)  }} {{$t('content.text.dh')}}
                                            </td>
                                            <td>
                                                <label v-if="Date.now() > new Date(abonner.date_fin)" class="badge badge-danger">
                                                    {{$t('content.pages.paiements.impayes.details_reglement.tableau.statut.expire')}}
                                                </label>
                                                <label v-else class="badge badge-success">{{$t('content.pages.paiements.impayes.details_reglement.tableau.statut.active')}}</label>
                                            </td>
                                        </tr>
                                        <tr style="background-color : rgb(157, 157, 157); color : #000;" class="tr-center" colspan="7">
                                            <th colspan="4">{{$t('content.pages.paiements.impayes.details_reglement.tableau.paiements.date_paiement')}}</th>
                                            <th colspan="4">{{$t('content.pages.paiements.impayes.details_reglement.tableau.paiements.montant_paye')}}</th>
                                        </tr>
                                        <tr class="tr-center" v-for="(paiement, index) in abonner.paiements" v-if="paiement.prix > 0">
                                            <td colspan="4"> {{ paiement.date_paiement | formatDate }} </td>
                                            <td colspan="4"> {{ parseFloat(paiement.prix).toFixed(2)}} {{$t('content.text.dh')}}</td>
                                        </tr>

                                        <tr class="tr-center border-none">
                                            <th class="unborde" colspan="3"></th>
                                            <th class="unborde" colspan="2"></th>
                                            <th colspan="2" style="background-color : rgb(157, 157, 157); color : #000;">Net à payer : </th>
                                            <th colspan="1" > {{ moyenne_abonnement }} {{$t('content.text.dh')}} </th>
                                        </tr>
                                        <tr class="tr-center border-none">
                                            <th class="unborde" colspan="3"></th>
                                            <th class="unborde" colspan="2"></th>
                                            <th colspan="2" style="background-color : rgb(157, 157, 157); color : #000;">Montant Total payé : </th>
                                            <th colspan="1" > {{ total_montant_paye }} {{$t('content.text.dh')}} </th>
                                        </tr>
                                        <tr class="tr-center border-none">
                                            <th class="unborde" colspan="3"></th>
                                            <th class="unborde" colspan="2"></th>
                                            <th colspan="2" style="background-color : rgb(157, 157, 157); color : #000;">Restant à payer : </th>
                                            <th colspan="1" > {{  reste_a_paye}} {{$t('content.text.dh')}} </th>
                                        </tr>


                                        <!--<tr class="tr-center border-none">
                                            <th class="unborde" colspan="2"></th>
                                            <th class="unborde" colspan="2"></th>
                                            <th colspan="2" style="background-color : rgb(157, 157, 157); color : #000;">{{$t('content.pages.paiements.impayes.details_reglement.tableau.calcule.total_paye_et_retour')}}</th>
                                            <th colspan="1" style="background-color : rgb(157, 157, 157); color : #000;">{{$t('content.pages.paiements.impayes.details_reglement.tableau.calcule.montant_caisse')}}</th>
                                        </tr>
                                        <tr class="tr-center border-none">
                                            <td class="unborde" colspan="2"></td>
                                            <td class="unborde" colspan="2"></td>
                                            <td colspan="2"> {{ total_montant_paye }} - {{ t_is_money}} </td>
                                            <td colspan="1"> {{ montant_sur_caisse }} {{$t('content.text.dh')}} </td>
                                        </tr>
                                        <tr class="tr-center border-none">
                                            <th class="unborde" colspan="2"></th>
                                            <th class="unborde" colspan="2"></th>
                                            <th colspan="2" style="background-color : rgb(157, 157, 157); color : #000;">{{$t('content.pages.paiements.impayes.details_reglement.tableau.calcule.net_paye_et_caisse')}}</th>
                                            <th colspan="1" style="background-color : rgb(157, 157, 157); color : #000;">{{$t('content.pages.paiements.impayes.details_reglement.tableau.calcule.reste_payer')}}</th>
                                        </tr>
                                        <tr class="tr-center border-none">
                                            <td class="unborde" colspan="2"></td>
                                            <td class="unborde" colspan="2"></td>
                                            <td colspan="2"> {{ parseFloat(moyenne_abonnement).toFixed(2)  }} - {{  parseFloat(montant_sur_caisse).toFixed(2) }} </td>
                                            <td colspan="1" class="all-paid" :class="{ 'resteExiste' : reste_a_paye > 0 }"> {{ reste_a_paye }} {{$t('content.text.dh')}} </td>
                                        </tr>
                                        <tr class="tr-break tr-center">
                                            <td colspan="3"> </td>
                                            <td colspan="3"> </td>
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
import { required, minLength, numeric, decimal, between, maxLength, email } from 'vuelidate/lib/validators'

export default {
    data() {
        return {
            data_filtrer: {
                id_adherent: null,
                matricule_cin: ''
            },
            list_abonners: [],
            list_adherents: [],
            t_is_money: 0,
            search: '',
            saveIndex: -1,
            prixapayer: null,
            reste_a_paye: 0,
            moyenne_abonnement: 0,
            tarif_pack: 0,
            total_remise: 0,
            total_montant_paye: 0,
            montant_sur_caisse: 0,
            //options : [],
        }
    },
    mounted() {
        console.log('Component mounted.')
    },
    validations() {
        return {
            prixapayer: {
                decimal,
                required,
                async isThanZero(value) {
                    if (parseFloat(value) > 0) return true
                },
                async isThanRestaPaye(value) {
                    if (parseFloat(value) <= parseFloat(this.reste_a_paye)) return true
                }
            },
        }
    },
    methods: {
        nameWithCodeClient({ code_client, nom }) {
            return `${code_client} -  ${nom} `
        },
        setPrixaPayer(value) {
            this.prixapayer = value
            this.$v.prixapayer.$touch()
        },
        listAbonners() {
            if (typeof this.$refs.formContainer !== "undefined")
                this.PluginLoader(false, this.$refs.formContainer)
            this.formData = new FormData();
            //if (this.data_filtrer.id_adherent != null)
            //    this.formData.append("filtrer[id_adherent]", this.data_filtrer.id_adherent);

            if (this.data_filtrer.matricule_cin != '')
                this.formData.append("filtrer[matricule_cin]", this.data_filtrer.matricule_cin);

            const config = { headers: { 'content-type': 'multipart/form-data' } }
            axios.post('/api-admin/abonnement-impayes', this.formData, config).then((response) => {
                console.log( response.data)
                if (typeof response.data.adherent !== "undefined") {
                    this.AlertResponseFalse("",'Adhérent n\'existe pas', "warning");
                }else{ 
                    this.list_abonners = response.data.abonner; //.data;
                    this.t_is_money = parseFloat(response.data.t_is_money).toFixed(2); //.data;
                    this.MoyenneAbonnement(this.list_abonners[0])
                    this.TarifPack(this.list_abonners[0])
                    this.RemisePromo(this.list_abonners[0])
                    this.TotalMontantPaye(this.list_abonners[0].paiements)
                    this.RestantaPayer(this.list_abonners[0])
                    this.MontantSurCaisse(this.list_abonners[0].paiements)
                }

            });
        },
        listAbonnementByAdhrentMatricule(matricule_cin) {
              
            this.formData = new FormData(); 
            this.formData.append("filtrer[matricule_cin]", matricule_cin);

            if (this.$route.query.id_abonnement) {
                this.formData.append("filtrer[id_abonnement]", this.$route.query.id_abonnement);
            }

            const config = { headers: { 'content-type': 'multipart/form-data' } }
            axios.post('/api-admin/abonnement-impayes', this.formData, config).then((response) => {
                if (typeof response.data.adherent !== "undefined") {
                    this.AlertResponseFalse("",'Adhérent n\'existe pas', "warning");
                }else{ 
                    this.list_abonners = response.data.abonner; //.data;
                    this.t_is_money = parseFloat(response.data.t_is_money).toFixed(2); //.data;
                    this.data_filtrer.matricule_cin = this.list_abonners[0].adherent.code_client
                    
                    this.MoyenneAbonnement(this.list_abonners[0])
                    this.TarifPack(this.list_abonners[0])
                    this.RemisePromo(this.list_abonners[0]) 
                    this.TotalMontantPaye(this.list_abonners[0].paiements)
                    this.RestantaPayer(this.list_abonners[0])
                    this.MontantSurCaisse(this.list_abonners[0].paiements)
                }

            });
        },
        ReglerAbonnerParAdherent() {
            this.$v.$touch()
            if (this.$v.$invalid) {
                console.log("error")
            } else {
                this.$fire(this.AlertFire('regler')).then((result) => {
                    if (result.value) {
                        this.formData = new FormData();
                        if (this.list_abonners[0] != null){
                            this.formData.append("id_abonner", this.list_abonners[0].id);
                            this.formData.append("id_type_abonnement", this.list_abonners[0].abonnements[0].id);
                            this.formData.append("id_type_pack", this.list_abonners[0].packs[0].id);
                        }

                        if (this.$v.prixapayer.$model != 0 && this.$v.prixapayer.$model > 0 && parseFloat(this.$v.prixapayer.$model) <= parseFloat(this.reste_a_paye)) {
                            this.formData.append("prixapayer", this.$v.prixapayer.$model);
                            this.reste_a_paye = this.reste_a_paye - this.$v.prixapayer.$model
                        } else
                            return false;

                        if (this.data_filtrer.matricule_cin != '') {
                            console.log(this.data_filtrer.matricule_cin)
                            this.formData.append("matricule_cin", this.data_filtrer.matricule_cin);
                        }

                        if(this.$route.query.adherent){
                            this.formData.append("matricule_cin", this.$route.query.adherent);
                        }

                        if(this.$route.query.id_abonnement){
                            this.formData.append("id_abonner", this.$route.query.id_abonnement);
                        }
                        
                        const config = { headers: { 'content-type': 'multipart/form-data' } }
                        axios.post('/api-admin/paiements/store', this.formData, config).then((response) => {
                            if (response.data) {
                                this.AlertResponseTrue("", this.$t('content.alerts.regler.success'), "success")
                                this.prixapayer = 0;
                                this.list_abonners = null
                                this.list_abonners = response.data; //.data;

                                this.MoyenneAbonnement(this.list_abonners[0])
                                this.TarifPack(this.list_abonners[0])
                                this.RemisePromo(this.list_abonners[0]) 
                                this.TotalMontantPaye(this.list_abonners[0].paiements)
                                this.RestantaPayer(this.list_abonners[0])
                                this.MontantSurCaisse(this.list_abonners[0].paiements)

                    
                            } else {
                                this.AlertResponseFalse("", this.$t('content.alerts.adherents.ni_abonner'), "warning");
                            }
                        });
                    }
                })
            }
        },
        filtrer(event) {
            this.listAbonners(this.data_filtrer)
        },
        handleRangeClose() {
            this.showTimeRangePanel = false;
        },
        ListAdherents() {
            axios.get('/api-admin/list-adherents-has-abonners').then((response) => {
                this.list_adherents = response.data;
                // this.options = response.data;
            });
        },
        MoyenneAbonnement(abonner) {
            var promo = (abonner.packs[0].pivot.promo) ? abonner.packs[0].pivot.promo : 0
            //var moyenne = parseFloat(abonner.abonnements[0].nb_mois * abonner.packs[0].prix) - [parseFloat(abonner.remise) + parseFloat(promo)]
            var moyenne = abonner.prix_ttc
            this.moyenne_abonnement = parseFloat(moyenne).toFixed(2)
        },
        TarifPack(abonner) { // string
            //this.tarif_pack = parseFloat(abonner.packs[0].prix).toFixed(2) + ' * ' + abonner.abonnements[0].nb_mois + ' = ' + parseFloat(abonner.packs[0].prix * abonner.abonnements[0].nb_mois).toFixed(2)
            
            //this.tarif_pack = parseFloat(abonner.packs[0].prix * abonner.abonnements[0].nb_mois).toFixed(2)
            this.tarif_pack = parseFloat(abonner.packs[0].prix ).toFixed(2)
            // this.tarif_pack =  total
        },
        RemisePromo(abonner) { // string
            var promo = (abonner.packs[0].pivot.promo) ? abonner.packs[0].pivot.promo : 0
            
            //this.total_remise = abonner.remise + ' + ' + promo + ' = ' + [parseFloat(abonner.remise) + parseFloat(promo)]
            let remiseAndPromo= parseFloat(abonner.remise) + parseFloat(promo)
            this.total_remise = parseFloat(remiseAndPromo).toFixed(2) 
        },
        TotalMontantPaye(paiements) {
            var total_payer = paiements.reduce((acc, crypt) => {
                return acc + parseFloat(crypt.prix)
            }, 0);
             this.total_montant_paye = parseFloat(total_payer).toFixed(2)
        },
        RestantaPayer(abonner) {
            this.reste_a_paye = parseFloat(this.moyenne_abonnement - Math.abs(this.total_montant_paye - this.t_is_money)).toFixed(2);
            //return parseFloat(this.reste_a_paye.toFixed(2));
        },
        MontantSurCaisse(paiements) {
            this.montant_sur_caisse = parseFloat(this.total_montant_paye - this.t_is_money).toFixed(2)
        }
    },

    beforeMount() {
        if(this.$can('Régler les impayés'))
        {
            console.log(this.$route.query.adherent)
            if (this.$route.query.adherent) {
                this.listAbonnementByAdhrentMatricule(this.$route.query.adherent)
            } 
            
            this.ListAdherents()
        }
        
    },
    computed: {
        ComputedInputRestPaye() {
            return parseFloat(this.reste_a_paye - this.prixapayer).toFixed(2)
        }
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
