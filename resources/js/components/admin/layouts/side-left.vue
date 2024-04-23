<template>
    <nav class="sidebar sidebar-offcanvas" id="sidebar"  :class="[ (open_menu_mobile == true ? 'right_0' : 'right_270'), (hide_menu_mobile == true ? 'show' : 'hide') ]" >
        <ul style="margin-bottom: 100px !important; " class="nav">
            <div v-if="$can('Pointage des adhérents')" :class="[ access_to_camera == true ? 'display-block' : 'display-none'  ]" class="row">
                <div   class="col-lg-12">
                    <qrcode-stream  style="height: 140px; margin-bottom: 20px;" :camera="camera" @decode="onDecode" @init="onInit">
                      <div v-show="showScanConfirmation" class="scan-confirmation">
                        <i  class="mdi-style mdi mdi-check"></i>
                      </div>
                    </qrcode-stream>
                </div>
            </div>
            <!--<li style="display: none;" class="nav-item nav-profile">
                <a href="#" class="nav-link">
                    <div class="profile-image">
                        <img class="img-xs rounded-circle" :src="`/admin/utilisateurs/photos/${user.image}`" alt="profile image">
                        <div class="dot-indicator bg-success"></div>
                    </div>
                    <div class="text-wrapper">
                        <p class="profile-name"> {{ user.name }} </p>
                        <p class="designation" v-if="role">Admin</p>
                        <p class="designation" v-else>Assistant</p>
                    </div>
                </a>
            </li>
            <li class="nav-item nav-category">Main Menu</li>-->
            <li v-if="$can('Tableau de bord')" class="nav-item">
                <router-link   :to="{name: 'dashboard'}" class="nav-link">
                    <i class="mdi-style mdi mdi-view-dashboard"></i>
                    <span class="menu-title">{{ $t('side.menu.dashboard') }}</span>
                 </router-link>
            </li>
            <li v-if="$can('Gestions des adhérents')" class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
                    <i class="mdi-style mdi  mdi-account-multiple"></i>
                    <span class="menu-title">{{ $t('side.menu.adherents.titre') }}</span>
                    <i class="mdi mdi-chevron-right"></i>
                </a>
                <div class="collapse" id="ui-basic">
                    <ul class="nav flex-column sub-menu">
                        <li v-if="$can('Gestions des adhérents')" class="nav-item">
                            <router-link   :to="{name: 'adherents'}" class="nav-link">
                                <i class="mdi-style mdi  mdi-account-multiple-plus"></i>
                                <span>{{ $t('side.menu.adherents.liste') }}</span>
                            </router-link>
                           
                        </li>
                        <!--<li v-if="$can('Badges des adherents')" class="nav-item">
                            <router-link   :to="{name: 'badge-adherents'}" class="nav-link">
                                <i class="mdi-style mdi mdi-account-card-details"></i>
                                <span>{{ $t('side.menu.adherents.badges') }}</span>
                            </router-link>
                        </li>-->
                        <!-- <li v-if="$can('Assurances')" class="nav-item">
                            <router-link   :to="{name: 'list-assurances'}" class="nav-link">
                                <i class="mdi-style mdi mdi-medical-bag"></i>
                                <span>Assurances</span>
                            </router-link>
                         </li> -->
                    </ul>
                </div>
            </li>
            <li v-if="$can('Gestion des abonnements')" class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#gestion-abonnement" aria-expanded="false" aria-controls="gestion-abonnement">
                    <i class="mdi-style mdi mdi-account-convert"></i>
                    <span class="menu-title">{{ $t('side.menu.abonnements.titre') }}</span>
                    <i class="mdi mdi-chevron-right"></i>
                </a>
                <div class="collapse" id="gestion-abonnement">
                    <ul class="nav flex-column sub-menu">
                        <li v-if="$can('Ajouter un abonnement')" class="nav-item">
                            <router-link   :to="{name: 'nouveau-abonnement'}" class="nav-link">
                                <i class="mdi-style mdi mdi-playlist-plus"></i>
                                <span>{{ $t('side.menu.abonnements.nouveau') }}</span>
                            </router-link>
                        </li>
                        <li v-if="$can('Consulter les abonnement actifs')" class="nav-item">
                            <router-link   :to="{name: 'abonnements-en-cours'}" class="nav-link">
                                <i class="mdi-style mdi mdi-check"></i>
                                <span>{{ $t('side.menu.abonnements.encours') }}</span>
                            </router-link>
                        </li>
                        <li v-if="$can('Consulter les abonnements términés')" class="nav-item">
                            <router-link   :to="{name: 'abonnements-termines'}" class="nav-link">
                                <i class="mdi-style mdi mdi-clock-alert"></i>
                                <span> {{ $t('side.menu.abonnements.terminer') }}</span> 
                            </router-link>
                        </li>
                        <li v-if="$can('Consulter les abonnements renouvelés')" class="nav-item">
                            <router-link   :to="{name: 'abonnements-renouveles'}" class="nav-link">
                                <i class="mdi-style mdi mdi-clock-alert"></i>
                                <span> abonnements renouvelés</span> 
                            </router-link>
                        </li>
                        <!--<li v-if="$can('Se désabonner')" class="nav-item">
                            <router-link   :to="{name: 'se-desabonner'}" class="nav-link">
                                <i class="mdi-style mdi mdi-block-helper"></i>
                                <span>{{ $t('side.menu.abonnements.desabonner') }}</span>
                            </router-link>
                        </li>-->
                        <li v-if="$can('Consulter les absences')" class="nav-item">
                            <router-link   :to="{name: 'empeches'}" class="nav-link">
                                <i class="mdi-style mdi mdi-timetable"></i>
                                <!--mdi-sign-caution-->
                                <span>{{ $t('side.menu.abonnements.empeches') }}</span>
                            </router-link>
                        </li>
                        <li v-if="$can('Consulter les statistiques de nombre des abonnements vendus')" class="nav-item">
                            <router-link   :to="{name: 'statistiques-abonnements'}" class="nav-link">
                                <i class="mdi-style mdi mdi-chart-bar"></i>
                                <span>
                                    Nombre des abonnements vendus
                                </span>
                            </router-link>
                        </li>
                        <li v-if="$can('Consulter les statistiques du chiffre d’affaires des abonnements vendus')" class="nav-item">
                            <router-link   :to="{name: 'statistiques-abonnements-vendus'}" class="nav-link">
                                <i class="mdi-style mdi mdi-chart-arc"></i>
                                <span > Chiffre d'affaires des abonnements vendus </span>
                            </router-link>
                        </li>
                    </ul>
                </div>
            </li>
            <li v-if="$can('Gestion des paiements')" class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#gestion-paiements" aria-expanded="false" aria-controls="gestion-paiements">
                    <i class="mdi-style mdi  mdi-cash-multiple"></i>
                    <span class="menu-title">{{ $t('side.menu.paiements.titre') }}</span>
                    <i class="mdi mdi-chevron-right"></i>
                </a>
                <div class="collapse" id="gestion-paiements">
                    <ul class="nav flex-column sub-menu">
                        <!--<li v-if="$can('Les impayés')" class="nav-item">
                            <router-link   :to="{name: 'impayes'}" class="nav-link">
                                <i class="mdi-style mdi mdi-cash-usd"></i>
                                <span>{{ $t('side.menu.paiements.impayes') }}</span>
                            </router-link>
                        </li>-->
                        <li v-if="$can('Consulter la liste des crédits')" class="nav-item">
                            <router-link   :to="{name: 'abonnements_non_paye'}" class="nav-link">
                                 <i class="mdi-style mdi mdi-cash"></i>
                                <span>Crédit</span>
                            </router-link>
                        </li>
                        <li v-if="$can('Consulter l’historique des réglements')" class="nav-item">
                            <router-link   :to="{name: 'reglements'}" class="nav-link">
                                <i class="mdi-style mdi mdi-history"></i>
                                <span>{{ $t('side.menu.paiements.historiques') }}</span>
                            </router-link>
                        </li>
                        <!--<li v-if="$can('Recharges')" class="nav-item">
                            <router-link   :to="{name: 'recharges'}" class="nav-link">
                                <i class="mdi-style mdi mdi-cash-100"></i>
                                <span>{{ $t('side.menu.paiements.recharges') }}</span>
                            </router-link>
                        </li>-->
                        <li v-if="$can('Consulter les statistiques des réglements encaissés')" class="nav-item">
                            <router-link   :to="{name: 'statistiques-reglements'}" class="nav-link">
                                <i class="mdi-style mdi mdi-chart-arc"></i>
                                <span>
                                    Statistiques des règlements
                                </span>
                            </router-link>
                        </li>
                         
                    </ul>
                </div>
            </li>
            <li v-if="$can('Consulter la liste des recettes') || $can('Consulter la liste des dépenses')" class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#recettes-depences" aria-expanded="false" aria-controls="recettes-depences">
                    <i class="mdi-style mdi  mdi-cash-usd"></i>
                    <span class="menu-title">Recettes et Dépenses</span>
                    <i class="mdi mdi-chevron-right"></i>
                </a>
                <div class="collapse" id="recettes-depences">
                    <ul class="nav flex-column sub-menu">
                        <li  v-if="$can('Consulter la liste des recettes')" class="nav-item">
                            <router-link   :to="{name: 'recettes'}" class="nav-link">
                                <i class="mdi-style mdi mdi-briefcase-download"></i>
                                <span>Liste des recettes</span>
                            </router-link>
                        </li>
                        <li v-if="$can('Consulter les statistiques des recettes')" class="nav-item">
                            <router-link   :to="{name: 'statistiques-recettes'}" class="nav-link">
                                <i class="mdi-style mdi mdi-chart-arc"></i>
                                <span>Statistiques des recettes </span>
                            </router-link>
                        </li>
                        <li v-if="$can('Consulter la liste des dépenses')" class="nav-item">
                            <router-link   :to="{name: 'depences'}" class="nav-link">
                                <i class="mdi-style mdi mdi-briefcase-upload"></i>
                                <span>Liste des dépenses </span>
                            </router-link>
                        </li>
                        <li v-if="$can('Consulter les statistiques des dépenses')" class="nav-item">
                            <router-link   :to="{name: 'statistiques-depences'}" class="nav-link">
                                <i class="mdi-style mdi mdi-chart-arc"></i>
                                <span>Statistiques dépenses </span>
                            </router-link>
                        </li>
                    </ul>
                </div>
            </li>
            <li v-if="$can('Gestion des présences')" class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#gestion-presences" aria-expanded="false" aria-controls="gestion-presences">
                    <i class="mdi-style mdi mdi-clock "></i>
                    <span class="menu-title">{{ $t('side.menu.presences.titre') }}</span>
                    <i class="mdi mdi-chevron-right"></i>
                </a>
                <div class="collapse" id="gestion-presences">
                    <ul class="nav flex-column sub-menu">
                        <li v-if="$can('Pointage des adhérents')" class="nav-item">
                            <router-link   :to="{name: 'presences'}" class="nav-link">
                                <i class="mdi-style mdi mdi-login"></i>
                                <span >Pointage des adhérents </span>
                            </router-link>
                        </li>
                        <li v-if="$can('Consulter l’historique des présences')" class="nav-item">
                            <router-link   :to="{name: 'historiques-presences'}" class="nav-link">
                                <i class="mdi-style mdi mdi-history"></i>
                                <span > Historique des présences </span>
                            </router-link>
                        </li>
                    </ul>
                </div>
            </li>
            <li v-if="$can('Envoyer des emails')" class="nav-item">
                <router-link   :to="{name: 'email-manuel'}" class="nav-link">
                    <i class="mdi-style mdi-email mdi "></i>
                    <span class="menu-title">Emails</span>
                </router-link>
            </li>
            <li v-if="$can('Consulter la liste des utilisateurs')" class="nav-item">
                <router-link   :to="{name: 'utilisateurs'}" class="nav-link">
                    <i class="mdi-style mdi mdi-account-key"></i>
                    <span class="menu-title">{{ $t('side.menu.utilisateurs') }}</span>
                </router-link>
            </li>
            
            <li v-if="$can('Paramétrage')" class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#parametrages" aria-expanded="false" aria-controls="parametrages">
                    <i class="mdi-style mdi mdi-settings"></i>
                    <span class="menu-title">{{ $t('side.menu.parametrages.titre') }}</span>
                    <i class="mdi mdi-chevron-right"></i>
                </a>
                <div class="collapse" id="parametrages">
                    <ul class="nav flex-column sub-menu">
                        <li v-if="$can('Consulter les types d\'abonnement')" class="nav-item">
                            <router-link   :to="{name: 'abonnements'}" class="nav-link">
                                <i class="mdi-style mdi mdi-shape-plus"></i>
                                <span >{{ $t('side.menu.parametrages.abonnements') }}</span>
                            </router-link>
                        </li>
                        <li v-if="$can('Consulter les packs') || $can('Consulter les activités')" class="nav-item">
                            <router-link   :to="{name: 'activities'}" class="nav-link">
                                <i class="mdi-style mdi mdi-trophy"></i>
                                <span >{{ $t('side.menu.parametrages.activities') }}</span>
                            </router-link>
                        </li>
                        <li v-if="$can('Consulter les catégories des services') || $can('Consulter les services')" class="nav-item">
                            <router-link   :to="{name: 'services'}" class="nav-link">
                                <i class="mdi-style mdi mdi-store"></i>
                                <span >Catégories & Services</span>
                            </router-link>
                        </li>
                        <li v-if="$can('Consulter les promotions')" class="nav-item">
                            <router-link   :to="{name: 'promotions'}" class="nav-link">
                                <i class="mdi-style mdi mdi-bullhorn"></i>
                                <span >{{ $t('side.menu.parametrages.promotions') }}</span>
                            </router-link>
                        </li>
                        <li v-if="$can('Consulter les frais')" class="nav-item">
                            <router-link   :to="{name: 'assurances'}" class="nav-link">
                                <i class="mdi-style mdi mdi-currency-usd "></i>
                                <span >FRAIS</span>
                            </router-link>
                        </li>
                    </ul>
                </div>
            </li>
            <!--<li v-if="$can('Messagerie')" class="nav-item">
                <router-link   :to="{name: 'messagerie'}" class="nav-link">
                    <i class="mdi-style mdi mdi-wechat"></i>
                    <span class="menu-title">Messagerie</span>
                </router-link>
            </li>-->
        </ul>
    </nav>
</template>

<script>

export default {
    props: ['user'],
    data() {
        return {
            formData: {},
            submitStatus: null,
            role: '',
            open_menu_mobile : false,
            hide_menu_mobile : false,
            error: '',
            camera: 'auto',
            access_to_camera : false,
              result: null,
              showScanConfirmation: false
        }
    },
    mounted() {
        console.log('Component mounted. from ayoub')
        //console.log(window.Permissions)
        this.role = window.Role;

    },
    methods: {
        generateQrCode() {
            axios.get('/api-admin/generate-qrcode').then((response) => {
                console.log(response.data)
            });
        },
        //onDecode(decodeQrCode) {
        async onDecode (decodeQrCode) {
            console.log("hello")
            console.log(decodeQrCode)
            if (decodeQrCode != null && decodeQrCode != '') {
                this.formData = new FormData();
                this.formData.append('code_client', decodeQrCode);
                const config = { headers: { 'content-type': 'multipart/form-data' } }
                axios.post('/api-admin/manual-presence-or-qr', this.formData, config).then((response) => {
                    switch (response.data.check) {
                                               case "adherent en empeche":
                                                   this.AlertResponseFalse("", this.$t('content.alerts.adherents.absent'), "warning")
                                                   break;
                                               case "expiré":
                                                   this.AlertResponseFalse("", this.$t('content.alerts.adherents.ni_abonner'), "warning")
                                                   break;
                                               case "logged":
                                                   this.AlertResponseFalse("", "L’adhérent est déja ajouté", "warning")
                                                   break;
                                               case "adherent n'exist pas":
                                                   this.AlertResponseFalse("", this.$t('content.alerts.adherents.n_existe'), "warning")
                                                   break;
                                               default:
                                                   
                                                   const verbe = (response.data.type == 'entrer') ? this.$t('content.alerts.presences.entrer') : this.$t('content.alerts.presences.sortier')
                                                    
                                                   const _text = "L'adhérent est ajouté avec succès "
                                                   this.AlertResponseTrue("", _text, "success")

                                                   this.eventPresences.$emit('manual-presence-or-qr', response.data)

                                                   if (this.$router.name != 'presences') {
                                                    this.$router.push({name: 'presences' })
                                                   }


                                                   
                                                    break;
                                           }
                });
            }
            
            this.pause()
          await this.timeout(500)
          this.unpause()
        },
        async onInit (promise) {
      try {
        await promise 
        this.access_to_camera = true
      } catch (error) {
        if (error.name === 'NotAllowedError') {
          this.error = "ERROR: you need to grant camera access permission"
        } else if (error.name === 'NotFoundError') {
          this.error = "ERROR: no camera on this device"
        } else if (error.name === 'NotSupportedError') {
          this.error = "ERROR: secure context required (HTTPS, localhost)"
        } else if (error.name === 'NotReadableError') {
          this.error = "ERROR: is the camera already in use?"
        } else if (error.name === 'OverconstrainedError') {
          this.error = "ERROR: installed cameras are not suitable"
        } else if (error.name === 'StreamApiNotSupportedError') {
          this.error = "ERROR: Stream API is not supported in this browser"
        } else if (error.name === 'InsecureContextError') {
          this.error = 'ERROR: Camera access is only permitted in secure context. Use HTTPS or localhost rather than HTTP.';
        } else {
          this.error = `ERROR: Camera error (${error.name})`;
        }
        this.access_to_camera = false
      }finally {
        this.showScanConfirmation = this.camera === "off"
      }
      console.log(this.error)
    },
    unpause () {
      this.camera = 'auto'
    },

    pause () {
      this.camera = 'off'
    },

    timeout (ms) {
      return new Promise(resolve => {
        window.setTimeout(resolve, ms)
      })
    },

     
        assurance() {
            this.AlertResponseFalse("", "Cette page n'est pas disponible pour le moment", "warning");
        },
 


    },
     computed: {
        checkMenuMobile() {
            return this.open_menu_mobile
        }
    },
    watch: {
        '$route' () {
          console.log(this.$route)
            console.log('watch route : ')

          this.open_menu_mobile = false; //!this.open_menu_mobile

             this.eventOpenMenuOnMobile.$emit('open_menu_mobile',  this.open_menu_mobiles )
          
        }
      },

    created: function() {
        this.eventOpenMenuOnMobile.$on('open_menu_mobile', data => {
            console.log('open_menu_mobile : ' + data)
           this.open_menu_mobile = data

        })
    },

}

</script>
<style scoped>



.display-block {
    display : block !important;
}

.display-none {
    display : none !important;
}



.scan-confirmation {
  position: absolute;
  width: 100%;
  height: 100%;

  background-color: rgba(255, 255, 255, .8);

  display: flex;
   justify-content: center;
   align-items : center;
}

.scan-confirmation i {
    color : green;
    font-size : 60px;
}



.router-link-active:before {
    /* content: "";
position: absolute;
top: 0px;
left: 35px;
display: block;
height: 100%;
width: 2px;
background: #fff !important;*/
}


.mdi-style {
    color: #fff;
    font-size: 25px;
    margin-right: 10px;
}


.navbar.default-layout .navbar-brand-wrapper {
    background: -webkit-linear-gradient(45deg, #ff6028, #ffbf36) !important;
}


.nav-item .nav-link.router-link-active:after {
    content: '';
    position: absolute;
    width: 100%;
    left: 0px;
    top: 0px;
    background: #e37400;
    padding: 26px;
}

.sub-menu .nav-item .nav-link.router-link-active:after {

    width: 87% !important;
    left: 13% !important;
    padding: 23px !important;
    border-left: 2px solid #fff;
}

.nav-item .nav-link.router-link-active span,
.nav-item .nav-link.router-link-active i {
    z-index: 99;
}

.afficher-plus {
    text-align: center;
    width: 100% !important;
    position: relative;
    display: block;
}

</style>
