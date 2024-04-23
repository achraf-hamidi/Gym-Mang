<template>
    <div class="main-panel" style="width : 100% !important;">
        <div class="content-wrapper" style="width : 100% !important;">
            <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <h1 class="card-top-0 card-title">
                                       <i class="mdi-style-content  mdi mdi-account"></i>
                                        <span class="titre">{{$t('content.pages.adherents.profile.titre')}}</span>
                                    </h1>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <auth-adherent-revenu-paiements v-if="revenu" :revenu="revenu" :code="code"></auth-adherent-revenu-paiements>
            <div class="row">
                <auth-adherent-abonnement-actuel v-if="details_abonner" :details_abonner="details_abonner" :code="code"></auth-adherent-abonnement-actuel>
                <auth-adherent-qr-code v-if="details_adherent" :details_adherent="details_adherent" :code="code"></auth-adherent-qr-code>
            </div>
            <div class="row" v-if="details_abonner && details_abonner.abonner && details_abonner.abonner.empeches[0]">
                <auth-adherent-empeches :code="code" :empeches="details_abonner.abonner.empeches[0]"> </auth-adherent-empeches>
            </div>
            <auth-adherent-info-personnelle v-if="details_adherent" :details_adherent="details_adherent" :code="code"></auth-adherent-info-personnelle>
            <div class="row">
                <div style="height: 450px;overflow: hidden;" class="col-md-8 grid-margin stretch-card">
                    <auth-adherent-historique-abonnement :code="code"></auth-adherent-historique-abonnement>
                </div>
                <div style="height: 450px;overflow: hidden;" class="col-md-4 grid-margin stretch-card">
                    <auth-adherent-paiements :code="code"></auth-adherent-paiements>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <auth-adherent-presences :code="code"></auth-adherent-presences>
                        <auth-adherent-activities :code='code'></auth-adherent-activities>
                    </div>
                </div>
            </div>
            <div class="row">
                <auth-adherent-recharges v-if="wallet" :code="code" :wallet="wallet"></auth-adherent-recharges>
            </div>
            <div class="row">
                <auth-adherent-children-parrinage v-if="details_adherent && details_adherent.children" :code="code" :children_parrinage="details_adherent.children"></auth-adherent-children-parrinage>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props: ['code'],
    data() {
        return {
            details_adherent: null,
            details_abonner: null,
            revenu: null,
            wallet: null,
        }
    },
    mounted() {
        console.log(this.code)
        this.DetailsAdherent(this.code);
    },
    methods: {
        DetailsAdherent(code) {
            axios.get('/api-adherent/details-adherent/' + this.code).then(res => {
                this.details_adherent = res.data.details_adherent
                this.details_abonner = res.data.details_abonner
                this.revenu = res.data.revenu
                this.wallet = res.data.wallet
            })
            /*.catch (err => {
                               alert("Adhérent n'existe pas")
                          }) */
        }
    },
    beforeMount() {
        //this.DetailsAdherent(this.code);
    },
}

</script>
<style>
h4,
h3,
h1 {
    font-size: 1.35rem !important;
}

/* Hide scrollbar for Chrome, Safari and Opera */
*::-webkit-scrollbar {
    display: none;
}

/* Hide scrollbar for IE, Edge and Firefox */
* {
    -ms-overflow-style: none;
    /* IE and Edge */
    scrollbar-width: none;
    /* Firefox */
}

.total-paiement {
    bottom: 15px;
    position: absolute;
    right: 20px;
}


.aucune.col-md-12 {
    display: flex;
    justify-content: center;
    align-items: center;
    font-size: 16px;
    color: #fd3232;
}

.aucune.col-md-12 .mdi-style {
 color: #fd3232;
}


.profile-adherent.card-title {
    top : 0px !important;
}

</style>
