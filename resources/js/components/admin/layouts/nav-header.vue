<template>
    <nav class="navbar default-layout col-lg-12 col-12 p-0 fixed-top d-flex flex-row">

        <div v-if="$can('Tableau de bord')" class="text-center navbar-brand-wrapper d-flex align-items-top justify-content-center">
            <a style="padding : 0px !important;" class="navbar-brand brand-logo" href="/admin/tableau-de-bord">
                <img  class="width-logo"  src="/admin/logo-transparent.png" alt="logo" /> </a>
            <a style="padding : 0px !important;" class="navbar-brand brand-logo-mini" href="/admin/tableau-de-bord">
                <img  class="width-logo-mobile"  src="/admin/logo-transparent.png" alt="logo" /> </a>
        </div>
        <div v-else class="text-center navbar-brand-wrapper d-flex align-items-top justify-content-center">
            <a style="padding : 0px !important;" class="navbar-brand brand-logo" href="javascript:void(0);">
                <img  class="width-logo"  src="/admin/logo-transparent.png" alt="logo" /> </a>
            <a style="padding : 0px !important;" class="navbar-brand brand-logo-mini" href="javascript:void(0);">
                <img  class="width-logo-mobile"  src="/admin/logo-transparent.png" alt="logo" /> </a>
        </div>

        <div class="navbar-menu-wrapper d-flex align-items-center">
            <!--<ul class="navbar-nav">
                <li class="nav-item dropdown language-dropdown">
                    <a class="nav-link dropdown-toggle px-2 d-flex align-items-center" id="LanguageDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
                        <div class="d-inline-flex mr-0 mr-md-3">
                            <div class="flag-icon-holder">
                                <i class="flag-icon " :class="flag"></i>
                            </div>
                        </div>
                        <span class="profile-text font-weight-medium d-none d-md-block">{{ language }}</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-left navbar-dropdown py-2" aria-labelledby="LanguageDropdown">
                        <a @click="Language('en')" class="dropdown-item">
                            <div class="flag-icon-holder">
                                <i class="flag-icon flag-icon-us"></i>
                            </div>{{ $t('header.lang.anglais') }}
                        </a>
                        <a @click="Language('fr')" class="dropdown-item">
                            <div class="flag-icon-holder">
                                <i class="flag-icon flag-icon-fr"></i>
                            </div>{{ $t('header.lang.francais') }}
                        </a>
                        <a @click="Language('ar')" class="dropdown-item">
                            <div class="flag-icon-holder">
                                <i class="flag-icon flag-icon-ae"></i>
                            </div>{{ $t('header.lang.arabe') }}
                        </a>
                    </div>
                </li>
            </ul>-->
            <div v-if="$can('Consulter la fiche d\'adhérent')" class="input-search-by-matricule" >
                <div style="display: flex;justify-content: center;align-items: center;">
                    <!--<span style="width : 100%;margin-right : 15px; " :title="$t('header.recherche.titre')"> {{ $t('header.recherche.titre') }} : </span> -->
                    <input v-on:keyup.enter="ProfileAdherent($event)" class="form-control" v-model.trim="globale_code_client" placeholder="Rechercher un adhérent par ID /CIN" />
                </div>
            </div>
            <div v-if="$can('Ajouter un abonnement')" class="btn-nouvel-abonnement" >
                <div style="display: flex;justify-content: center;align-items: center;">
                   <router-link :to="{name: 'nouveau-abonnement'}" class="btn btn-primary">
                                <i class=" mdi mdi-plus"></i>
                                <span>{{ $t('side.menu.abonnements.nouveau') }}</span>
                            </router-link>

                     
                </div>
            </div>

            <div v-if="$can('Pointage des adhérents')" class="btn-presence" >
                <div style="display: flex;justify-content: center;align-items: center;">
                   <router-link :to="{name: 'presences'}" class="btn btn-success">
                                <i class=" mdi mdi-plus"></i>
                                <span>Présence</span>
                            </router-link>

                     
                </div>
            </div>
            <ul class="navbar-nav ml-auto">
                <!--<li v-if="$can('Abonnement avant terminés')" class="nav-item dropdown">
                    <a class="nav-link count-indicator" id="messageDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
                        <i class="mdi mdi-wechat"></i>
                        <span class="count bg-success">{{ messages_unread }}</span>
                    </a> 
                </li>-->

                <li  v-if="$can('Afficher les notifications des dates d\'écheance')" class="nav-item dropdown">
                    <a class="nav-link count-indicator" id="notificationDropdown" href="#" data-toggle="dropdown">
                        <i class="mdi mdi-bell-ring"></i>
                        <span class="count">{{ abonnements_non_paye.length }} </span>
                    </a>
                    <div style="overflow: scroll !important;" class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list pb-0" aria-labelledby="notificationDropdown">
                        <a class="justify-content-between  dropdown-item py-3 border-bottom">
                            <p class="mb-0 font-weight-medium float-left">
                                Date d'écheance des abonnements non payés 
                            </p>
                            <span v-if="$can('Consulter la liste des crédits')" class="badge badge-pill badge-primary float-right text-right">
                                <router-link :to="{name: 'abonnements_non_paye'}">
                                    <span style="color : #fff !important;">Afficher tout</span>
                                </router-link>
                            </span>
                        </a>
                        <a v-for="(non_paye, index) in abonnements_non_paye" class="dropdown-item preview-item">
                            <div class="preview-thumbnail">
                                <img :src="`/clubi/public/admin/adherents/photos/${non_paye.image}`" alt="image" class="img-sm profile-pic">
                            </div>
                            <div class="preview-item-content flex-grow py-2">
                                <p class="preview-subject ellipsis font-weight-medium text-dark">
                                     
                                     <a style="color: #0030E0;"  v-if="$can('Consulter la fiche d\'adhérent')"   :href="$router.resolve({name: 'impayes', query : { adherent : `${non_paye.code_client}`, id_abonnement : `${non_paye.id_abonner}` }}).href" class="nav-link">
                                       <span><b>{{ non_paye.code_client }}, {{ non_paye.nom }}</b></span>
                                     </a>
                                    <span v-else> 
                                        <b>{{ non_paye.code_client }}, {{ non_paye.nom }}</b>
                                    </span>
                                </p>
                                <p class="font-weight-light small-text">
                                    <span><b style="font-weight: bold !important;"> 
                                    Date écheance : </b>{{ non_paye.paiament_date_echeance | formatDate }}</span>,
                                    <span><b style="font-weight: bold !important;"> 
                                    Reste à payer :</b> {{ non_paye.prix_ttc - non_paye.sums }} Dhs</span>
                                </p>
                            </div>
                        </a>
                    </div>
                </li>


                <li v-if="$can('Afficher les notifications des abonnements prochainnement expirés')" class="nav-item dropdown">
                    <a class="nav-link count-indicator" id="messageDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
                        <i class="mdi mdi-bell-ring"></i>
                        <span class="count bg-success">{{ avantFindate.length }}</span>
                    </a>
                    <div style="overflow: scroll !important;" class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list pb-0" aria-labelledby="messageDropdown">
                        <a class="justify-content-between dropdown-item py-3">
                            <p class="mb-0 font-weight-medium float-left">
                                Liste des abonnements expirés dans 5 jours 
                            </p>
                            <span v-if="$can('Consulter les abonnements prochainement expirés')"  class="badge badge-pill badge-primary float-right">
                                <router-link :to="{name: 'abonnements-avant-terminer'}">
                                    <span style="color : #fff !important;">Afficher tout</span>
                                </router-link>
                            </span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a v-for="(abonner, index) in avantFindate" class="dropdown-item preview-item">
                            <div class="preview-thumbnail">
                                <img :src="`/clubi/public/admin/adherents/photos/${abonner.adherent.image}`" alt="image" class="img-sm profile-pic">
                            </div>
                            <div class="preview-item-content flex-grow py-2">
                                <p class="preview-subject ellipsis font-weight-medium text-dark">
                                    <a v-if="$can('Consulter la fiche d\'adhérent')" :href="$router.resolve({name: 'adherent', params:{code: abonner.adherent.code_client } }).href">
                                        <span><b>{{ abonner.adherent.code_client }}, {{ abonner.adherent.nom }}</b></span>
                                    </a> 
                                    <span v-else>
                                        <b>{{ abonner.adherent.code_client }}, {{ abonner.adherent.nom }}</b>
                                    </span>
                                </p>
                                <p class="font-weight-light small-text">
                                    <span><b style="font-weight: bold !important;">{{ $t('header.notifications.abonnement_avant_terminer.date_fin') }} : </b>{{ abonner.date_fin | formatDate }}</span>,
                                    <span><b style="font-weight: bold !important;">Jours restants :</b> {{ abonner.RestDays }} </span>
                                </p>
                            </div>
                        </a>
                    </div>
                </li>
                <li v-if="$can('Afficher les notifications des abonnements terminés')" class="nav-item dropdown">
                    <a class="nav-link count-indicator" id="notificationDropdown" href="#" data-toggle="dropdown">
                        <i class="mdi mdi-bell-ring"></i>
                        <span class="count">{{ terminers.length }} </span>
                    </a>
                    <div style="overflow: scroll !important;" class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list pb-0" aria-labelledby="notificationDropdown">
                        <a class="justify-content-between  dropdown-item py-3 border-bottom">
                            <p class="mb-0 font-weight-medium float-left">
                                Les derniers abonnements terminés 
                            </p>
                            <span v-if="$can('Consulter les abonnements términés')" class="badge badge-pill badge-primary float-right text-right">
                                <router-link :to="{name: 'abonnements-termines'}">
                                    <span style="color : #fff !important;">Afficher tout</span>
                                </router-link>
                            </span>
                        </a>
                        <a v-for="(abonner, index) in terminers" class="dropdown-item preview-item">
                            <div class="preview-thumbnail">
                                <img :src="`/clubi/public/admin/adherents/photos/${abonner.adherent.image}`" alt="image" class="img-sm profile-pic">
                            </div>
                            <div class="preview-item-content flex-grow py-2">
                                <p class="preview-subject ellipsis font-weight-medium text-dark">
                                    <a v-if="$can('Consulter la fiche d\'adhérent')" :href="$router.resolve({name: 'adherent', params:{code: abonner.adherent.id_empreinte } }).href">
                                        <span><b>{{ abonner.adherent.id_empreinte }}, {{ abonner.adherent.nom }}</b></span>
                                    </a>

                                    <span v-else>
                                        <b>{{ abonner.adherent.id_empreinte }}, {{ abonner.adherent.nom }}</b>
                                    </span>
                                </p>
                                <p class="font-weight-light small-text">
                                    <span><b style="font-weight: bold !important;"> {{ $t('header.notifications.abonnement_terminer.date_fin') }} : </b>{{ abonner.date_fin | formatDate }}</span>,
                                    <span><b style="font-weight: bold !important;"> Jours restants :</b> {{ abonner.RestDays }}</span>
                                </p>
                            </div>
                        </a>
                    </div>
                </li>
                <!--<li v-if="$can('Promotions')" class="nav-item dropdown">
                    <a class="nav-link count-indicator" id="messageDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
                        <i class="mdi mdi-bullhorn"></i>
                        <span class="count bg-success"> {{ promotions.length }} </span>
                    </a>
                    <div style="overflow: scroll !important;" class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list pb-0" aria-labelledby="messageDropdown">
                        <a class="justify-content-between dropdown-item py-3">
                            <p class="mb-0 font-weight-medium float-left"> {{ $t('header.notifications.promotions.titre') }}</p>
                            <span class="badge badge-pill badge-primary float-right">
                                <router-link :to="{name: 'promotions'}">
                                    <span style="color : #fff !important;">Afficher tout</span>
                                </router-link>
                            </span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a v-for="(promotion, index) in promotions" class="dropdown-item preview-item">
                            <div class="preview-thumbnail">
                                <img :src="`/admin/promotions/${promotion.image}`" alt="image" class="img-sm profile-pic">
                            </div>
                            <div class="preview-item-content flex-grow py-2">
                                <p class="preview-subject ellipsis font-weight-medium text-dark">
                                    <span>
                                        <b>{{ promotion.description }}</b>
                                    </span>
                                </p>
                                <p class="font-weight-light small-text">
                                    <span><b style="font-weight: bold !important;"> {{ $t('header.notifications.promotions.date_fin') }} : </b>{{ promotion.date_fin }}</span>
                                </p>
                            </div>
                        </a>
                    </div>
                </li>-->
                <li class="nav-item dropdown  d-xl-inline-block user-dropdown">
                    <a class="nav-link dropdown-toggle" id="UserDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
                        <img class="img-xs rounded-circle" :src="`/clubi/public/admin/utilisateurs/photos/${user.image}`" alt="Profile image"> </a>
                    <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="UserDropdown">
                        <div class="dropdown-header text-center">
                            <img class="img-md rounded-circle" :src="`/clubi/public/admin/utilisateurs/photos/${user.image}`" alt="Profile image">
                            <p class="mb-1 mt-3 font-weight-semibold">{{ user.name }}</p>
                            <p class="font-weight-light text-muted mb-0">{{ user.email }}</p>
                        </div>
                        <a v-if="$can('Consulter le profil personnel')" class="dropdown-item" :href="$router.resolve({name: 'profile-utilisateur', params :{email: user.email } }).href">
                            Profil
                        </a> 
                        <a class="dropdown-item" href="#" @click.prevent="logout">
                            {{ $t('header.notifications.utilisateur.deconnexion') }}<i class="dropdown-item-icon ti-power-off"></i>
                        </a>
                    </div>
                </li>
            </ul>
            <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas" @click="OpenMenuOnMobile" >
                <span class="mdi mdi-menu"></span>
            </button>
        </div>
    </nav>
</template>
<script>
import {globalStore} from '../../../app.js'

export default {
    props: ['user'],
    data() {
        return {
            language: this.$t('header.lang.francais'),
            flag: 'flag-icon-us',
            globale_code_client: '',
            avantFindate: [],
            terminers: [],
            promotions: [],
            messages_unread : 0 ,
            datetimePicker: [new Date(new Date().getTime() - 24 * 60 * 60 * 1000), new Date(new Date().getTime() + 4 * 24 * 60 * 60 * 1000)],
            formData: {},
            data_filtrer: { 
                date_echeance : []
             },
            abonnements_non_paye: [],
            open_menu_mobiles : false
         }
    },
    beforeMount() {
        this.$i18n.locale = 'fr'
        this.LocalLanguage()
        if (this.$can('Consulter les abonnements prochainement expirés'))
            this.AbonnementsAvantFinDate()
        if (this.$can('Consulter les abonnements términés'))
            this.AbonnementsTerminers()  
        if (this.$can('Afficher les notifications des dates d\'écheance'))
            this.AbonnementsNonPaye()


         console.log("this.open_menu_mobile : " +  this.open_menu_mobile )

    },
    methods: {
        Language(lg) {
            axios.get('/api/set-locale/' + lg).then((response) => {
                const oldlg = this.$i18n.locale
                this.$i18n.locale = lg;
                this.LocalLanguage()
                if (lg == "ar" || oldlg == "ar") { window.location.reload() }
            })
        },
        LocalLanguage() {

            if (this.$i18n.locale == 'en') {
                this.language = this.$t('header.lang.anglais')
                this.flag = 'flag-icon-us'
            }
            if (this.$i18n.locale == 'fr') {
                this.language = this.$t('header.lang.francais')
                this.flag = 'flag-icon-fr'
            }
            if (this.$i18n.locale == 'ar') {
                this.language = this.$t('header.lang.arabe')
                this.flag = 'flag-icon-ae'
            }
        },
        ProfileAdherent(event) {
            const code = this.globale_code_client;
            //this.$router.push({name : 'adherent' , params : { code } })
            window.location.href = `/admin/fiche-adherent/${code}`
        },
        logout: function() {
            axios.post('/logout').then(response => {
                if (response.status === 302 || 401) {
                    window.location.href = '/login'
                } else {
                    // throw error and go to catch block
                }
            }).catch(error => {

            });
        },
        AbonnementsAvantFinDate() {
            this.formData = new FormData();
            const config = { headers: { 'content-type': 'multipart/form-data' } }
            //const date = this.datetimePicker;
            //var datetimes = [date[0].toDateString() , date[1].toDateString() ]
            //this.formData.append("filtrer[date]", datetimes);

            //if (this.datetimePicker != null) {
             const date = this.datetimePicker;
             console.log( date[0].toDateString())
             console.log( "date : a")
             console.log( date[1].toDateString())
            this.formData.append("filtrer[date][from]", date[0].toDateString());
            this.formData.append("filtrer[date][to]", date[1].toDateString());



            axios.post('/api-admin/dashboard/avant-fin-date?take=8', this.formData, this.config).then((response) => {
                this.avantFindate = response.data;
            });
        },
        AbonnementsTerminers() {
            axios.get('/api-admin/dashboard/termines').then((response) => {
                this.terminers = response.data;
            });
        },
        Promotions() {
            axios.get('/api-admin/dashbaord/promotions').then((response) => {
                this.promotions = response.data;
            });
        },

        AbonnementsNonPaye() {
            this.formData = new FormData();
            this.datetimePicker = [
                            new Date(new Date().getTime() - 360 * 60 * 60 * 1000), 
                            new Date(new Date().getTime() + 10 * 24 * 60 * 60 * 1000)
            ]
            const date = this.datetimePicker; 
            this.data_filtrer.date_echeance = [date[0].toDateString(), date[1].toDateString()]
            this.formData.append("filtrer[date][from]", this.data_filtrer.date_echeance[0]);
            this.formData.append("filtrer[date][to]", this.data_filtrer.date_echeance[1]);
            
            console.log("this.data_filtrer.date_echeance")
            console.log(this.data_filtrer.date_echeance)
            const config = { headers: { 'content-type': 'multipart/form-data' } }
            axios.post('/api-admin/dashboard-list-abonnements-non-paye', this.formData, config).then((response) => {
                this.abonnements_non_paye = response.data.abonnements_non_paye;
                console.log("response.data")
                console.log(response.data)
            });
        },
        MessagesUnread() {
            axios.get('/api-admin/dashbaord/messages-unread').then((response) => {
                this.messages_unread = response.data;
            });
        },
        OpenMenuOnMobile(){
            this.open_menu_mobiles = !this.open_menu_mobiles
             //console.log("this.open_menu_mobiles : " +  this.open_menu_mobiles )
             this.eventOpenMenuOnMobile.$emit('open_menu_mobile',  this.open_menu_mobiles )
        }
       
    },
    created: function() {
        this.countUnreadMessages.$on('edit', data => {
            if (data != null) {
                this.messages_unread -= data.count
            }
        })

        this.eventOpenMenuOnMobile.$on('open_menu_mobile', data => {
            this.open_menu_mobiles = data

        })
    },
}

</script>
