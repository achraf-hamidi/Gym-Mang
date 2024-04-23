<template>
    <div class="main-panel">
        <div v-if="$can('Consulter les abonnements prochainement expirés')" class="content-wrapper">
            <!---->
            <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <h1 class="card-title">
                                        <i class="mdi-style-content mdi mdi mdi-check"></i>
                                        <span class="titre">Abonnements au moins 5 jours avant la date fin</span>
                                    </h1><br><br>
                                </div>
                            </div>
                            <!--<div class="row">
                                <div class="col-md-12">
                                    <form @submit.prevent="filtrer($event)" class="forms-sample">
                                        <div class="row">
                                            <div class="col-4">
                                                <div class="form-group mr-b-0em">
                                                    <label class="form__label"> Type d'abonnement</label>
                                                    <select class="form-control" v-model="data_filtrer.abonnement_id">
                                                        <option value="">Tous</option>
                                                        <option v-for="(abonnement, index) in abonnements" :value="abonnement.id"> {{ abonnement.libelle }} </option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="form-group mr-b-0em">
                                                    <label class="form__label"> Type de pack</label>
                                                    <select class="form-control" v-model="data_filtrer.pack_id">
                                                        <option value="">Tous</option>
                                                        <option v-for="(pack, index) in packs" :value="pack.id">
                                                            {{ pack.description }} ( <span v-for="(acts) in pack.activities"> {{ acts.name }} </span> )
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="form-group mr-b-0em">
                                                    <label class="form__label">Date du au</label> <br>
                                                    <date-picker style="width: 100%;" :show-time-panel="showTimeRangePanel" @close="handleRangeClose" v-model="datetimePicker" range type="datetime" format="YYYY-MM-DD"></date-picker>
                                                </div>
                                            </div>
                                            <div class="col-12 text-right">
                                                <button type="submit" class="btn btn-success mr-2"> <i class="mdi mdi-magnify"></i> Recherche</button>
                                                <button class="btn btn-light">{{ $t('content.bouton.annuler') }}</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>-->
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group mr-b-0em"><br>
                                        <label class="form__label"><i class="mdi mdi-filter-outline"></i> Filtrer</label>
                                        <input v-model="search" placeholder="Matricule, cin, nom & prénom, email, genre..." class="form-control">
                                    </div>
                                </div>
                                <div v-if="filteredAbonnements.length > 0" class="col-md-12">
                                    <ul class="navbar-nav ml-auto">
                                        <li class="nav-item dropdown">
                                            <div class="liste-abn-avant-terminer preview-list pb-0">
                                                <a v-for="(abonner, index) in filteredAbonnements" class="dropdown-item preview-item align-items-center justify-content-center">
                                                    <div class="preview-thumbnail">
                                                        <img :src="`/clubi/public/admin/adherents/photos/${abonner.adherent.image}`" alt="image" class="img-sm profile-pic">
                                                    </div>
                                                    <div class="preview-item-content flex-grow py-2">
                                                        <p class="preview-subject ellipsis font-weight-medium text-dark">
                                                            <router-link v-if="$can('Consulter la fiche d\'adhérent')" :to="{name: 'adherent', params:{code: abonner.adherent.code_client }}">
                                                                <span><b>{{ abonner.adherent.code_client }}, {{ abonner.adherent.nom }}</b></span>
                                                            </router-link>
                                                            <span v-else>
                                                                <b>{{ abonner.adherent.code_client }}, {{ abonner.adherent.nom }}</b>
                                                            </span>
                                                            
                                                        </p>
                                                        <p class="font-weight-light small-text">
                                                            <span><b style="font-weight: bold !important;">Date fin : </b>{{ abonner.date_fin | formatDate  }}</span>,
                                                            <span><b style="font-weight: bold !important;">Jours restant :</b> {{ abonner.RestDays }} {{$t('content.text.jours')}}</span>
                                                        </p>
                                                        <p>
                                                            <span>
                                                                <b>Paiements :</b> 
                                                                <span v-if="abonner.completed_paiement == 1">  
                                                                    Payé
                                                                </span> 
                                                                <span v-else>
                                                                    Pas encore payé 
                                                                </span>
                                                            </span>
                                                        </p>
                                                    </div>
                                                    <div>
                                                        <a v-if="abonner.completed_paiement == 0" class="btn btn-success mr-2" :href="`/api-admin/rappel-de-paiement/${abonner.id}`" >Rappel de paiement</a>
                                                     </div>
                                                </a>
                                            </div>
                                        </li>
                                    </ul>
                                    <!--<vue-pagination :pagination="pagination" @paginate="AbonnementsAvantFinDate(data_filtrer)" :offset="4"></vue-pagination>-->
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
export default {
    //  props: ['code'],
    data() {
        return {
            avantFindate: [],
            datetimePicker: [new Date(new Date().getTime() - 2 * 60 * 60 * 1000), new Date(new Date().getTime() + 4 * 24 * 60 * 60 * 1000)],
            formData: {},
            search: ''
        }
    },
    mounted() {},
    methods: {
        AbonnementsAvantFinDate() {
            // const current_page = (this.pagination.current_page) ? this.pagination.current_page : 1;

            this.formData = new FormData();
            const config = { headers: { 'content-type': 'multipart/form-data' } }

            if (this.datetimePicker[0] != null && this.datetimePicker[1]) {
            const date = this.datetimePicker;
            var datetimes = [date[0].toDateString(), date[1].toDateString()]
            this.formData.append("filtrer[date][from]", date[0].toDateString());
            this.formData.append("filtrer[date][to]", date[1].toDateString() );
            }

            axios.post('/api-admin/dashboard/avant-fin-date?take=all', this.formData, this.config).then((response) => {
                this.avantFindate = response.data;
            });
        },
    },
    beforeMount() {
        if (this.$can('Consulter les abonnements prochainement expirés'))
            this.AbonnementsAvantFinDate()
    },
    computed: {
        filteredAbonnements() {
            return this.avantFindate.filter(abonner => {
                return abonner.adherent.code_client.toLowerCase().includes(this.search.toLowerCase()) ||
                    abonner.adherent.nom.toString().toLowerCase().includes(this.search.toLowerCase()) ||
                    abonner.adherent.gender.toString().toLowerCase().includes(this.search.toLowerCase()) ||
                    abonner.adherent.email.toString().toLowerCase().includes(this.search.toLowerCase()) ||
                    abonner.adherent.cin.toString().toLowerCase().includes(this.search.toLowerCase())

            })
        },
    }
}

</script>
<style>
.liste-abn-avant-terminer .dropdown-item.active,
.liste-abn-avant-terminer .dropdown-item:active {
    background-color: initial !important;
}

</style>
