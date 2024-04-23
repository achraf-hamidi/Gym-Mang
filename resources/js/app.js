require('./bootstrap');
window.Vue = require('vue');

import Permissions from './mixins/Permissions';
Vue.mixin(Permissions);

import VueCharts from 'vue-chartjs'

import VueRouter from 'vue-router'
import VueInternationalization from 'vue-i18n';
import Locale from './vue-i18n-locales.generated';
import Vuelidate from 'vuelidate'
import 'vue2-datepicker/index.css';
import DatePicker from 'vue2-datepicker';
//import {en, fr, ar} from 'vuejs-datepicker/dist/locale'



// Import component
import VueLoading from 'vue-loading-overlay';
// Import stylesheet
import 'vue-loading-overlay/dist/vue-loading.css';

Vue.use(VueLoading);
Vue.component('loading', VueLoading)


import VueSimpleAlert from "vue-simple-alert";

Vue.use(VueSimpleAlert);

// print
import VueHtmlToPaper from 'vue-html-to-paper';


import InfiniteLoading from 'vue-infinite-loading';

Vue.use(InfiniteLoading);




import moment from 'moment';

Vue.filter('formatDate', function(value) { // convert date
    if (value) {
        return moment(String(value)).format('DD/MM/YYYY') // hh:mm
    }
});

Vue.filter('formatDateHeur', function(value) { // convert date
    if (value) {
        return moment(String(value)).format('DD/MM/YYYY HH:mm') // 
    }
});


let basePath= 'http://127.0.0.1:8000';

const options = {
    name: '_blank',
    specs: [
        'fullscreen=yes',
        'titlebar=yes',
        'scrollbars=yes'
    ],
    styles: [
        'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css',
        `${basePath}/assets/css/badge.css`,
        '@/assets/css/badge.css',
        './assets/css/badge.css',
    ],

}

Vue.use(VueHtmlToPaper, options);

// end print



//Vue.component('datepicker', Datepicker)

Vue.use(Vuelidate)

import Multiselect from 'vue-multiselect'

// register globally
Vue.component('multiselect', Multiselect)



import VueFormWizard from 'vue-form-wizard'
import 'vue-form-wizard/dist/vue-form-wizard.min.css'
Vue.use(VueFormWizard)

import QrcodeStream from "vue-qrcode-reader";

Vue.use(QrcodeStream);

import VueQrcodeReader from "vue-qrcode-reader";
 
Vue.use(VueQrcodeReader);



Vue.use(VueInternationalization);
const lang = document.documentElement.lang.substr(1, 2);
const i18n = new VueInternationalization({
    locale: lang,
    messages: Locale
});
console.log("lang " + lang)

Vue.component('date-picker', DatePicker)

if (lang == "en")
    require('vue2-datepicker/locale/en')
else if (lang == "fr")
    require('vue2-datepicker/locale/fr')
else if (lang == "ar")
    require('vue2-datepicker/locale/ar')
 
Vue.use(VueRouter)




const eventPresences = new Vue() // Single event hub
const eventTypeAbonnement = new Vue() // Single event hub
const eventTypeassurance = new Vue() // Single event hub
const eventActivities = new Vue()
const eventcategories = new Vue()
const eventservices = new Vue()
const eventRecettes = new Vue()
const eventDepences = new Vue()
const eventPromotions = new Vue()
const eventPacks = new Vue()
const eventEmpeches = new Vue()
const eventUtilisateurs = new Vue()
const eventAssuranceAdherent = new Vue()

const eventProfile = new Vue()

const eventRecharge = new Vue()
const eventAbonner = new Vue()
const countUnreadMessages = new Vue()

const isLoading = false
const fullPage = true
const eventOpenMenuOnMobile = new Vue()
// Distribute to components using global mixin
Vue.mixin({
    data: function() {
        return {
            eventAssuranceAdherent : eventAssuranceAdherent,
            eventPresences: eventPresences,
            eventTypeAbonnement: eventTypeAbonnement,
            eventTypeassurance : eventTypeassurance,
            eventActivities: eventActivities,
            eventcategories: eventcategories,
            eventservices: eventservices,
            eventRecettes : eventRecettes ,
            eventDepences : eventDepences ,
            eventPromotions: eventPromotions,
            eventPacks: eventPacks,
            eventEmpeches: eventEmpeches,
            eventUtilisateurs: eventUtilisateurs,
            eventProfile: eventProfile,
            eventRecharge: eventRecharge,
            eventAbonner: eventAbonner,
            isLoading: isLoading, 
            fullPage: fullPage, 
            countUnreadMessages : countUnreadMessages,
            eventOpenMenuOnMobile : eventOpenMenuOnMobile
        }
    },
    methods: {
        DaysBtwDates: function(date1, date2) {
            // différence des heures
            var time_diff = date2.getTime() - date1.getTime();
            // différence de jours
            var days_Diff = time_diff / (1000 * 3600 * 24);
            // afficher la différences
            return parseFloat(days_Diff.toFixed(0));
        },
        AlertResponseTrue(_title, _text, _icon) {
            this.$fire({
                title: _title,
                text: _text,
                type: _icon,
                showCancelButton: false,
                confirmButtonColor: '#3085d6',
                confirmButtonText: this.$t('content.bouton.ok'),
            })
        },
        AlertResponseFalse(_title, _text, _icon) {
            this.$fire({
                title: _title,
                text: _text,
                type: _icon,
                showCancelButton: false,
                confirmButtonColor: '#3085d6',
                confirmButtonText: this.$t('content.bouton.ok'),
            })
        },
        AlertFire(action) {
            switch (action) {
                case 'add':
                    var fire_title = this.$t('content.alerts.ajout.message')
                    var fire_text = this.$t('content.alerts.ajout.sous_message')
                    var fire_confirm = this.$t('content.bouton.oui') + ', ' + this.$t('content.bouton.ajout');
                    var fire_cancle = this.$t('content.bouton.non') + ', ' + this.$t('content.bouton.annuler')
                    break
                case 'edit':
                    var fire_title = this.$t('content.alerts.modification.message')
                    var fire_text = this.$t('content.alerts.modification.sous_message')
                    var fire_confirm = this.$t('content.bouton.oui') + ', ' + this.$t('content.bouton.modifier');
                    var fire_cancle = this.$t('content.bouton.non') + ', ' + this.$t('content.bouton.annuler')
                    break
                case 'edit-adherent':
                    var fire_title = this.$t('content.alerts.modification_adherent.message')
                    var fire_text = '' //Les modifier pe pas avoir de la répétition dans la fiche
                    var fire_confirm = this.$t('content.bouton.oui') + ', ' + this.$t('content.bouton.modifier');
                    var fire_cancle = this.$t('content.bouton.non') + ', ' + this.$t('content.bouton.annuler')
                    break
                case 'delete':
                    var fire_title = this.$t('content.alerts.suppression.message')
                    var fire_text = this.$t('content.alerts.suppression.sous_message')
                    var fire_confirm = this.$t('content.bouton.oui') + ', ' + this.$t('content.bouton.supprimer');
                    var fire_cancle = this.$t('content.bouton.non') + ', ' + this.$t('content.bouton.annuler')
                    break
                case 'suspendre':
                    var fire_title = this.$t('content.alerts.suspendre.message')
                    var fire_text = this.$t('content.alerts.suspendre.sous_message')
                    var fire_confirm = this.$t('content.bouton.oui') + ', ' + this.$t('content.bouton.suspendre');
                    var fire_cancle = this.$t('content.bouton.non') + ', ' + this.$t('content.bouton.annuler')
                    break
                case 'regler':
                    var fire_title = this.$t('content.alerts.regler.message')
                    var fire_text = this.$t('content.alerts.regler.sous_message')
                    var fire_confirm = this.$t('content.bouton.oui') + ', ' + this.$t('content.bouton.regler');
                    var fire_cancle = this.$t('content.bouton.non') + ', ' + this.$t('content.bouton.annuler')
                    break
                case 'regler_recette':
                    var fire_title = this.$t('content.alerts.regler_recette.message')
                    var fire_text = this.$t('content.alerts.regler_recette.sous_message')
                    var fire_confirm = this.$t('content.bouton.oui') + ', ' + this.$t('content.bouton.regler');
                    var fire_cancle = this.$t('content.bouton.non') + ', ' + this.$t('content.bouton.annuler')
                    break
                case 'regler_depense':
                    var fire_title = this.$t('content.alerts.regler_depense.message')
                    var fire_text = this.$t('content.alerts.regler_depense.sous_message')
                    var fire_confirm = this.$t('content.bouton.oui') + ', ' + this.$t('content.bouton.regler');
                    var fire_cancle = this.$t('content.bouton.non') + ', ' + this.$t('content.bouton.annuler')
                    break
                case 'leave':
                    var fire_title = 'Les modifications ne sont pas enregistrés !'
                    var fire_text = 'Voulez vous vraiment quitter ? '
                    var fire_confirm = this.$t('content.bouton.oui')  
                    var fire_cancle = this.$t('content.bouton.non') 
                    break
                case 'presences':
                    var fire_title = 'Message presences'
                    var fire_text = 'Message presences '
                    var fire_confirm = this.$t('content.bouton.oui')  
                    var fire_cancle = this.$t('content.bouton.non') 
                    break
                case 'envoi_mail':
                    var fire_title = 'Vous êtes sûr de vouloir envoyer ?'
                    var fire_text = ''
                    var fire_confirm = this.$t('content.bouton.oui')  
                    var fire_cancle = this.$t('content.bouton.non') 
                    break
                case 'modifier_password':
                    var fire_title = 'Vous êtes sûr de vouloir modifier le mot de passe ?'
                    var fire_text = ''
                    var fire_confirm = this.$t('content.bouton.oui')  
                    var fire_cancle = this.$t('content.bouton.non') 
                    break
            }

            let _object = {
                title: fire_title,
                text: fire_text,
                type: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: fire_confirm,
                cancelButtonText: fire_cancle, 
               // allowOutsideClick : false
            }

            return _object;
        },
        PluginLoader(isfullpage, formContainer) {
            let loader = this.$loading.show({
                container: formContainer,
                loader: 'dots',
            });
            setTimeout(() => {
                loader.hide()
            }, 3000)
        }
    },
})

if (userPermissions.length > 0) {
    console.log('userPermissions')
} else console.log('no userPermissions')


if (userPermissions.length > 0) {
    var routes = [{ 
            path: '/',
            name: 'default-dashboard',
            props: true,
            component: require('./components/admin/pages/dashboard/index.vue').default
        },
        {
            path: '/admin/tableau-de-bord',
            name: 'dashboard',
            props: true,
            component: require('./components/admin/pages/dashboard/index.vue').default
        },
        {
            path: '/admin/liste-adherents',
            name: 'adherents',
            props: true,
            component: require('./components/admin/pages/adherents/index.vue').default
        },
        {
            path: '/admin/fiche-adherent/:code',
            name: 'adherent',
            props: true,
            component: require('./components/admin/pages/adherents/profile/index.vue').default
        },
        {
            path: '/admin/badge-adherents',
            name: 'badge-adherents',
            props: true,
            component: require('./components/admin/pages/adherents/badge_adherents.vue').default
        },
        {
            path: '/admin/assurances',
            name: 'list-assurances',
            props: true,
            component: require('./components/admin/pages/adherents/assurances/index.vue').default
        },
        {
            path: '/admin/assurance-adherent/:code',
            name: 'assurance-adherent',
            props: true,
            component: require('./components/admin/pages/adherents/assurances/assurance_adherent.vue').default
        },
        {
            path: '/admin/nouvel-abonnement',
            name: 'nouveau-abonnement',
            props: true,
            component: require('./components/admin/pages/abonnements/nouveau_abonnement.vue').default
        },
        {
            path: '/admin/abonnements-actifs',
            name: 'abonnements-en-cours',
            props: true,
            component: require('./components/admin/pages/abonnements/encours.vue').default
        },
        {
            path: '/admin/abonnements-renouveles',
            name: 'abonnements-renouveles',
            props: true,
            component: require('./components/admin/pages/abonnements/abonnements_renouveler.vue').default
        },
        {
            path: '/admin/abonnements-inactifs',
            name: 'abonnements-termines',
            props: true,
            component: require('./components/admin/pages/abonnements/termines.vue').default
        },
        {
            path: '/admin/historique-abonnements/:code',
            name: 'historiques-abonnement',
            props: true,
            component: require('./components/admin/pages/abonnements/historiques_abonnement_by_adherent.vue').default
        },
        {
            path: '/admin/abonnements-prochainnement-expires',
            name: 'abonnements-avant-terminer',
            props: true,
            component: require('./components/admin/pages/abonnements/avant_terminer.vue').default
        },
        {
            path: '/admin/se-desabonner',
            name: 'se-desabonner',
            props: true,
            component: require('./components/admin/pages/abonnements/suspend.vue').default
        },
        {
            path: '/admin/statistique-de-nombre-des-abonnements-vendus',
            name: 'statistiques-abonnements',
            props: true,
            component: require('./components/admin/pages/abonnements/statistiques.vue').default
        },
        {
            path: '/admin/chiffre-affaires-des-abonnements-vendus',
            name: 'statistiques-abonnements-vendus',
            props: true,
            component: require('./components/admin/pages/abonnements/statistiques_total_abonnements_vendus.vue').default
        },
        {
            path: '/admin/absences',
            name: 'empeches',
            props: true,
            component: require('./components/admin/pages/abonnements/empeches/index.vue').default
        },
        {
            path: '/admin/reglements',
            name: 'reglements',
            props: true,
            component: require('./components/admin/pages/paiements/reglements.vue').default
        },
        {
            path: '/admin/impayes',
            name: 'impayes',
            props: true,
            component: require('./components/admin/pages/paiements/impayes.vue').default
        },
        {
            path: '/admin/credits',
            name: 'abonnements_non_paye',
            props: true,
            component: require('./components/admin/pages/paiements/nonpaye.vue').default
        },
        {
            path: '/admin/statistique-reglements',
            name: 'statistiques-reglements',
            props: true,
            component: require('./components/admin/pages/paiements/statistiques_reglements.vue').default
        },
        {
            path: '/admin/presences',
            name: 'presences',
            props: true,
            component: require('./components/admin/pages/presences/index.vue').default
        },
        {
            path: '/admin/historique-presences',
            name: 'historiques-presences',
            props: true,
            component: require('./components/admin/pages/presences/historiques.vue').default
        },
        {
            path: '/admin/parametrage/activities',
            name: 'activities',
            props: true,
            component: require('./components/admin/pages/parametrages/activities/index.vue').default
        },
        {
            path: '/admin/parametrage/services',
            name: 'services',
            props: true,
            component: require('./components/admin/pages/parametrages/services/index.vue').default
        },
        {
            path: '/admin/parametrage/abonnements',
            name: 'abonnements',
            props: true,
            component: require('./components/admin/pages/parametrages/abonnements/index.vue').default
        },
        {
            path: '/admin/parametrage/frais',
            name: 'assurances',
            props: true,
            component: require('./components/admin/pages/parametrages/assurances/index.vue').default
        },
        {
            path: '/admin/parametrage/promotions',
            name: 'promotions',
            props: true,
            component: require('./components/admin/pages/parametrages/promotions/index.vue').default
        },
        {
            path: '/admin/liste-utilisateurs',
            name: 'utilisateurs',
            props: true,
            component: require('./components/admin/pages/utilisateurs/index.vue').default
        },
        {
            path: '/admin/utilisateur/:email',
            name: 'profile-utilisateur',
            props: true,
            component: require('./components/admin/pages/utilisateurs/profile/index.vue').default
        },
        {
            path: '/admin/messagerie',
            name: 'messagerie',
            props: true,
            component: require('./components/admin/pages/utilisateurs/messagerie/index.vue').default
        },
        {
            path: '/admin/recharges',
            name: 'recharges',
            props: true,
            component: require('./components/admin/pages/recharges/index.vue').default
        },
        {
            path: '*',
            name: '404',
            props: true,
            component: require('./components/admin/pages/404/index.vue').default
        },
        {
            path: '/admin/recettes',
            name: 'recettes',
            props: true,
            component: require('./components/admin/pages/recettes/index.vue').default
        },
        {
            path: '/admin/depenses',
            name: 'depences',
            props: true,
            component: require('./components/admin/pages/depences/index.vue').default
        },
        {
            path: '/admin/statistique-depenses',
            name: 'statistiques-depences',
            props: true,
            component: require('./components/admin/pages/depences/statistiques_depences.vue').default
        },
        {
            path: '/admin/statistique-recettes',
            name: 'statistiques-recettes',
            props: true,
            component: require('./components/admin/pages/recettes/statistiques_recettes.vue').default
        },
        {
            path: '/admin/emails',
            name: 'email-manuel',
            props: true,
            component: require('./components/admin/pages/emails/index.vue').default
        },
    ]

} else {

    var routes = [{
            path: '/adherent/profile/:code',
            name: 'profile-adherent',
            props: true,
            component: require('./components/adherent/pages/adherents/profile/index.vue').default
        },
        {
            path: '*',
            name: 'notfound',
            props: true,
            component: require('./components/adherent/pages/notfound.vue').default
        }
    ]
}


const router = new VueRouter({
    mode: 'history',
    routes,
    scrollBehavior() {
        document.getElementById('app').scrollIntoView({ behavior: 'smooth' });
    }

});

//Vue.component('dashboard', require('./components/admin/pages/dashboard.vue').default);

Vue.component('nav-header', require('./components/admin/layouts/nav-header.vue').default);
Vue.component('side-left', require('./components/admin/layouts/side-left.vue').default);
Vue.component('footer-component', require('./components/admin/layouts/footer.vue').default);
Vue.component('chart-bar', require('./components/admin/layouts/chartbar.vue').default);
Vue.component('chart-line', require('./components/admin/layouts/chartLine.vue').default);
Vue.component('chart-pie', require('./components/admin/layouts/chartPie.vue').default);

Vue.component('add-categorie', require('./components/admin/pages/parametrages/services/add_categorie.vue').default);
Vue.component('add-service', require('./components/admin/pages/parametrages/services/add_service.vue').default);


Vue.component('add-pack', require('./components/admin/pages/parametrages/activities/add_pack.vue').default);
Vue.component('add-activitie', require('./components/admin/pages/parametrages/activities/add_activitie.vue').default);
Vue.component('add-promotion', require('./components/admin/pages/parametrages/promotions/add_promotion.vue').default);

Vue.component('add-abonnement', require('./components/admin/pages/parametrages/abonnements/add_abonnement.vue').default);
Vue.component('list-abonnements', require('./components/admin/pages/parametrages/abonnements/listabonnements.vue').default);
Vue.component('add-empeche', require('./components/admin/pages/abonnements/empeches/add_empeche.vue').default);

Vue.component('add-assurance', require('./components/admin/pages/parametrages/assurances/add_assurance.vue').default);
Vue.component('list-assurances', require('./components/admin/pages/parametrages/assurances/listassurances.vue').default);
 
Vue.component('manual-presence', require('./components/admin/pages/presences/manualpresence.vue').default);


/*### Auth admin visite Adherenrs ## */
Vue.component('add-adherent', require('./components/admin/pages/adherents/add_adherent.vue').default);
Vue.component('abonnement-actuel', require('./components/admin/pages/adherents/profile/abonnement-actuel.vue').default);
Vue.component('historique-abonnement', require('./components/admin/pages/adherents/profile/historique-abonnement.vue').default);
Vue.component('info-personnelle', require('./components/admin/pages/adherents/profile/info-personnelle.vue').default);
Vue.component('paiements', require('./components/admin/pages/adherents/profile/paiements.vue').default);
Vue.component('historiques-assurance', require('./components/admin/pages/adherents/profile/historiques-assurance.vue').default);
Vue.component('presences', require('./components/admin/pages/adherents/profile/presences.vue').default);
Vue.component('qr-code', require('./components/admin/pages/adherents/profile/qr-code.vue').default);
Vue.component('revenu-paiements', require('./components/admin/pages/adherents/profile/revenu-paiements.vue').default);
Vue.component('activities', require('./components/admin/pages/adherents/profile/activities.vue').default);
Vue.component('empeches', require('./components/admin/pages/adherents/profile/empeches.vue').default)
Vue.component('recharges', require('./components/admin/pages/adherents/profile/recharges.vue').default)
Vue.component('children-parrinage', require('./components/admin/pages/adherents/profile/children_parrinage.vue').default)
Vue.component('historiques-recettes', require('./components/admin/pages/adherents/profile/historique-recettes.vue').default);
Vue.component('add-assuranceadherent', require('./components/admin/pages/adherents/assurances/add_assurance.vue').default);



/*### Recettes & Dépences ###*/
Vue.component('add-recette', require('./components/admin/pages/recettes/add_recette.vue').default);
Vue.component('add-depence', require('./components/admin/pages/depences/add_depence.vue').default);
//Vue.component('add-adherent', require('./components/admin/pages/adherents/add_adherent.vue').default);


Vue.component('main-component', require('./components/main.vue').default);

Vue.component('add-utilisateur', require('./components/admin/pages/utilisateurs/add_utilisateur.vue').default);
Vue.component('modifier-password', require('./components/admin/pages/utilisateurs/profile/modifier-password.vue').default);



Vue.component('add-recharge', require('./components/admin/pages/recharges/add_recharge.vue').default);


Vue.component('terminer', require('./components/admin/pages/dashboard/terminer.vue').default);
Vue.component('count', require('./components/admin/pages/dashboard/count.vue').default);
Vue.component('statistiques-actuel', require('./components/admin/pages/dashboard/statistiques_actuel.vue').default);
Vue.component('statistiques-reglements-solde-caisse', require('./components/admin/pages/dashboard/statistiques_reglements_solde_caisse.vue').default);

Vue.component('statistiques-recettes', require('./components/admin/pages/dashboard/statistiques_recettes.vue').default);
Vue.component('statistiques-depences', require('./components/admin/pages/dashboard/statistiques_depences.vue').default);
Vue.component('adherents', require('./components/admin/pages/dashboard/adherents.vue').default);
Vue.component('avant-terminer', require('./components/admin/pages/dashboard/avant_terminer.vue').default);
Vue.component('abonnements-renouveles', require('./components/admin/pages/dashboard/abonnements_renouveles.vue').default);

 
Vue.component('update-abonner', require('./components/admin/pages/abonnements/update_abonner.vue').default);



Vue.component('vue-pagination', require('./components/admin/layouts/paginate.vue').default);
Vue.component('havent-permission', require('./components/admin/pages/havent_permission.vue').default);






/*### Auth Adherenrs ## */
Vue.component('auth-adherent-abonnement-actuel', require('./components/adherent/pages/adherents/profile/abonnement-actuel.vue').default);
Vue.component('auth-adherent-historique-abonnement', require('./components/adherent/pages/adherents/profile/historique-abonnement.vue').default);
Vue.component('auth-adherent-info-personnelle', require('./components/adherent/pages/adherents/profile/info-personnelle.vue').default);
Vue.component('auth-adherent-paiements', require('./components/adherent/pages/adherents/profile/paiements.vue').default);
Vue.component('auth-adherent-presences', require('./components/adherent/pages/adherents/profile/presences.vue').default);
Vue.component('auth-adherent-qr-code', require('./components/adherent/pages/adherents/profile/qr-code.vue').default);
Vue.component('auth-adherent-revenu-paiements', require('./components/adherent/pages/adherents/profile/revenu-paiements.vue').default);
Vue.component('auth-adherent-activities', require('./components/adherent/pages/adherents/profile/activities.vue').default);
Vue.component('auth-adherent-empeches', require('./components/adherent/pages/adherents/profile/empeches.vue').default)
Vue.component('auth-adherent-recharges', require('./components/adherent/pages/adherents/profile/recharges.vue').default)
Vue.component('auth-adherent-children-parrinage', require('./components/adherent/pages/adherents/profile/children_parrinage.vue').default)


Vue.component('auth-adherent-nav-header', require('./components/adherent/layouts/nav-header.vue').default);
Vue.component('auth-adherent-side-left', require('./components/adherent/layouts/side-left.vue').default);
Vue.component('auth-adherent-footer-component', require('./components/adherent/layouts/footer.vue').default);



const app = new Vue({
    el: '#app',
    router,
    i18n,
});
