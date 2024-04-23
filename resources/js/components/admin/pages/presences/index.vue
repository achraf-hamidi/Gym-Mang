<template>
    <div class="main-panel">
        <div v-if="$can('Pointage des adhérents')" class="content-wrapper">
            <div class="row">
                <manual-presence></manual-presence>
            </div> 
            <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-8">
                                    <h1 class="card-title">
                                        <i class="mdi-style-content  mdi mdi-login"></i>
                                        <span class="titre"> Les présences d’aujourd'hui  {{ datenow | formatDate }}  </span>
                                    </h1><br><br>
                                </div>
                                <div class="col-md-4">
                                    <p  class="text-right">
                                       <b> {{count_presences}} Présences</b>
                                    </p>
                                </div>
                            </div>
                            <div class="row">
                                <!--<div class="col-md-12">
                                    <div class="form-group mr-b-0em">
                                        <label class="form__label">{{ $t('content.pages.presences.aujourdhui.filtrer.titre') }}</label>
                                        <input v-model="search_adherent" :placeholder="$t('content.pages.presences.aujourdhui.filtrer.titre')" class="form-control">
                                    </div>
                                </div>-->
                                <div v-if="filteredListPresences.length>0" class=" table-responsive col-md-12 ">
                                    <table id="data-packs" class="datatables table table-striped table-bordered table-hover">
                                        <thead class="thead-dark">
                                            <tr>
                                                <!-- <th>{{ $t('content.pages.presences.aujourdhui.tableau.matricule') }}</th> -->
                                                <th>ID </th>
                                                <th>{{ $t('content.pages.presences.aujourdhui.tableau.nom') }}</th>
                                                <th>Abonnement / Pack</th>
                                                <th>{{ $t('content.pages.presences.aujourdhui.tableau.date_entrer') }}</th>
                                                <!--<th>{{ $t('content.pages.presences.aujourdhui.tableau.date_sortier') }}</th>-->
                                                <th>{{ $t('content.pages.presences.aujourdhui.tableau.jours') }}</th>
                                                
                                                <th>{{ $t('content.pages.presences.aujourdhui.tableau.statut') }}</th>
                                                <!--<th>{{ $t('content.pages.presences.aujourdhui.tableau.statut') }}</th>-->
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(presence, index) in filteredListPresences">
                                                <td>
                                                    <router-link v-if="$can('Consulter la fiche d\'adhérent')" :to="{name: 'adherent', params:{code: presence.adherent.code_client }}">
                                                        <a> {{ presence.adherent.id_empreinte }} </a>
                                                    </router-link>
                                                    <span v-else>{{ presence.adherent.id_empreinte }}</span>
                                                </td>
                                                <td> {{ presence.adherent.nom }} </td>
                                                <td> {{ presence.adherent.abonners[0].abonnements[0].libelle }}, {{ presence.adherent.abonners[0].packs[0].description }} </td>
                                                <td> {{ presence.date_entrer | formatDateHeur }} </td>
                                                <!--<td> {{ presence.date_sortier | formatDate }} </td>-->
                                                <td>  

                                                    {{ presence.adherent.abonners[0].RestDays }} j 
                                                 <!--<label v-if="presence.adherent.abonners[0].RestDays > 0" >
                                                        {{ presence.adherent.abonners[0].RestDays }} j 
                                                    </label>
                                                    <label v-else >
                                                        {{$t('content.text.jours_terminer')}}
                                                    </label>-->
                                                </td>


                                                

                                                <td>
                                                    <label v-if="presence.adherent.abonners[0].RestDays > 0" class="badge badge-success">
                                                        Actif
                                                    </label>
                                                    <label v-else class="badge badge-danger">
                                                        Inactif
                                                    </label>
                                                </td>

                                                <!--<td>
                                                    <label v-if="presence.date_sortier == null" class="badge badge-success">{{ $t('content.pages.presences.aujourdhui.statut.entrer') }}</label>
                                                    <label v-else class="badge badge-danger">{{$t('content.pages.presences.aujourdhui.statut.sortier') }}</label>
                                                </td>-->
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div v-else class="aucune col-md-12">
                                    <i class="mdi-style mdi mdi-alert"></i> {{$t('content.alerts.aucune_info')}}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <vue-pagination :pagination="pagination" @paginate="listPresences()" :offset="4"></vue-pagination>
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
    data() {
        return {
            pagination: [],
            list_presences: [],
            search_adherent: '',
            saveIndex: -1,
            count_presences : 0,
            datenow : new Date()
        }
    },
    mounted() {
        console.log('Component mounted.')
    },
    methods: {
        listPresences() {
            const current_page = (this.pagination.current_page) ? this.pagination.current_page : 1;
            axios.get('/api-admin/presences-aujourdhui?page=' + current_page).then((response) => {
                this.list_presences = response.data.data;
                this.count_presences = response.data.total;
                this.pagination = response.data;
            });
        },

    },
    beforeMount() {
        if (this.$can('Pointage des adhérents')) {
            this.listPresences();
        }
    },
    computed: {
        filteredListPresences() {
            return this.list_presences.filter(presence => {
                return presence.adherent.code_client.toLowerCase().includes(this.search_adherent.toLowerCase()) || 
               // presence.adherent.code_client.toLowerCase().includes(this.search_adherent.toLowerCase()) || 
                presence.adherent.nom.toLowerCase().includes(this.search_adherent.toLowerCase())
            })
        }
    },
    created: function() {
        this.eventPresences.$on('manual-presence-or-qr', data => {
            if (data.type == 'sortier') {
                for (var i = 0; i < this.list_presences.length; i++) {
                    if (this.list_presences[i].date_entrer == data.presence.date_entrer && this.list_presences[i].date_sortier == null) {
                        this.saveIndex = i;
                    }
                }
                if (this.saveIndex != -1) {
                    this.list_presences[this.saveIndex].date_sortier = data.presence.date_sortier;
                }
            } else {
                this.list_presences.unshift(data.presence)
            }
        })
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

</style>
