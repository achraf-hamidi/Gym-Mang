<template>
    <nav class="navbar default-layout col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
        <div class="text-center navbar-brand-wrapper d-flex align-items-top justify-content-center">
            <a class="navbar-brand brand-logo" href="#">
                <img src="/admin/logo2.png" alt="logo" /> </a>
            <a class="navbar-brand brand-logo-mini" href="#">
                <img src="/admin/logo2.png" alt="logo" /> </a>
        </div>
        <div class="navbar-menu-wrapper d-flex align-items-center">
            <ul class="navbar-nav">
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
                            </div>English
                        </a>
                        <a @click="Language('fr')" class="dropdown-item">
                            <div class="flag-icon-holder">
                                <i class="flag-icon flag-icon-fr"></i>
                            </div>French
                        </a>
                        <a @click="Language('ar')" class="dropdown-item">
                            <div class="flag-icon-holder">
                                <i class="flag-icon flag-icon-ae"></i>
                            </div>Arabic
                        </a>
                    </div>
                </li>
            </ul> 
            <ul class="navbar-nav ml-auto"> 
                <li class="nav-item dropdown d-none d-xl-inline-block user-dropdown">
                    <a class="nav-link dropdown-toggle" id="UserDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
                        <img class="img-xs rounded-circle" :src="`/clubi/public/admin/utilisateurs/photos/${user.image}`" alt="Profile image"> </a> 
                    <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="UserDropdown">
                        <div class="dropdown-header text-center">
                            <img class="img-md rounded-circle" :src="`/clubi/public/admin/utilisateurs/photos/${user.image}`" alt="Profile image">
                            <p class="mb-1 mt-3 font-weight-semibold">{{ user.name }}</p>
                            <p class="font-weight-light text-muted mb-0">{{ user.email }}</p>
                        </div>
                        <a class="dropdown-item" href="#" @click.prevent="logout">{{ $t('header.notifications.utilisateur.deconnexion') }}<i class="dropdown-item-icon ti-power-off"></i></a>
                    </div>
                </li>
            </ul>
            <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
                <span class="mdi mdi-menu"></span>
            </button>
        </div>
    </nav>
</template>
<script>
export default {
    props: ['user'],
    data() {
        return {
            language: 'English',
            flag: 'flag-icon-us',
            globale_code_client: '',
            avantFindate: [],
            terminers: [],
            promotions : [],
            datetimePicker: [new Date(new Date().getTime() - 24 * 60 * 60 * 1000), new Date(new Date().getTime() + 16 * 24 * 60 * 60 * 1000)],
            formData: {}
        }
    },
    beforeMount() {
        this.$i18n.locale  = "fr"
        this.LocalLanguage()
         
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
                this.language = 'English'
                this.flag = 'flag-icon-us'
            }
            if (this.$i18n.locale == 'fr') {
                this.language = 'French'
                this.flag = 'flag-icon-fr'
            }
            if (this.$i18n.locale == 'ar') {
                this.language = 'Arabic'
                this.flag = 'flag-icon-ae'
            }
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
         
    }
}

</script>
