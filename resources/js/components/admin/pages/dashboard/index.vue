<template>
    <div class="main-panel">
        <div v-if="$can('Tableau de bord')" class="content-wrapper">
            <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <h1 class="card-top-0 card-title">
                                        <i class="mdi-style-content  mdi mdi-view-dashboard"></i>
                                        <span class="titre">{{ $t('content.pages.dashboard.titre') }}</span>
                                    </h1>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div v-if="$can('Afficher le total des adhérents, Adhérents Actifs, Adhérents Inactifs')" class="row">
                <count></count>
            </div>
            <div class="row">
                <adherents v-if="$can('Afficher les derniers adhérents inscrits')"></adherents>
                <terminer v-if="$can('Afficher les derniers abonnements terminés')"></terminer>
            </div>
            <div class="row">
                
                <avant-terminer v-if="$can('Afficher les abonnements prochainement expirés')"></avant-terminer>
                
            </div>
            <div class="row">
                
                <abonnements-renouveles v-if="$can('Afficher les abonnements prochainement expirés')"></abonnements-renouveles>
                
            </div>
            <div class="row">
                 
                <statistiques-actuel v-if="$can('Afficher les statistiques des inscriptions des 3 derniers mois (Abonnements vendus)')"></statistiques-actuel>
                <statistiques-reglements-solde-caisse v-if="$can('Afficher les statistiques des règlements des 3 derniers mois')"></statistiques-reglements-solde-caisse>
                <statistiques-recettes v-if="$can('Afficher les recettes d\'aujourd\'hui')"></statistiques-recettes> 
                <statistiques-depences v-if="$can('Afficher les dépenses d\'aujourd\'hui')"></statistiques-depences> 
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
            terminers: []
        }
    },
    mounted() {
        //this.PluginLoader()
    },

}

</script>
