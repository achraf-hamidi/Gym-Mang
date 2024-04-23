<template>
    <div class="container-scroller">
        <!--<loading :active="isLoading" :can-cancel="false" :is-full-page="fullPage"></loading>-->
        <div v-if="!user.code_client">
            <nav-header :user="user"> </nav-header>
            <div class="container-fluid page-body-wrapper">
                <side-left :user="user"></side-left>
                <router-view> </router-view>
                
            </div>
            <!--<footer-component></footer-component>-->
        </div>
        <div v-else>
            <auth-adherent-nav-header :user="user"> </auth-adherent-nav-header>
            <div class="container-fluid page-body-wrapper">
                <router-view> </router-view>
            </div>
        </div>
        <button class="goTop" v-if="isVisible" @click="backToTop">
            <i title="Back to top" class="fa fa-angle-up" aria-hidden="true"></i>
        </button>
    </div>
</template>
<script>
export default {
    props: ['user'],
    data() {
        return {
            onLine: navigator.onLine,
            showBackOnline: false,
            isVisible: false
        }
    },
    mounted() {
        console.log('Component mounted.')
        window.addEventListener('online', this.updateOnlineStatus);
        window.addEventListener('offline', this.updateOnlineStatus);
        this.$nextTick(function() {
            this.initToTopButton();
        });
    },
    methods: {
        updateOnlineStatus(e) {
            const { type } = e;
            this.onLine = type === 'online';
        },
        initToTopButton: function() {
            $(document).bind('scroll', function() {
                var backToTopButton = $('.goTop');
                if ($(document).scrollTop() > 250) {
                    backToTopButton.addClass('isVisible');
                    this.isVisible = true;
                } else {
                    backToTopButton.removeClass('isVisible');
                    this.isVisible = false;
                }
            }.bind(this));
        },
        backToTop: function() {
            $('html,body').stop().animate({
                scrollTop: 0
            }, 'slow', 'swing');
        }

    },
    watch: {
        onLine(v) {
            if (v) {
                this.$alert('', 'Votre connexion internet est fonctionnelle', 'success')
                this.showBackOnline = true;
                setTimeout(() => { this.showBackOnline = false; }, 1000);
            } else
                this.$alert('', 'Opps !! Probléme de connexion internet', 'warning')
        },

    },
    beforeDestroy() {
        window.removeEventListener('online', this.updateOnlineStatus);
        window.removeEventListener('offline', this.updateOnlineStatus);
    },
    computed: {
        test() {
            console.log(this.isLoading)
        }
    }

}

</script>
<style>


.months_clicable {
   cursor: pointer;
color: #011481;
font-size: 14px;
}


.hide-headr-wizad .wizard-header {
    display : none ! important;
}

.form-group label, label {
  font-size: 0.79rem !important ;
   font-weight: bolder !important ;
}

.pagination {
    margin-top: 35px !important ;
}
.pagination li.active a{
    background-color : #00C9EB !important;
    border: 1px solid #00C9EB !important;
}


.img-sm {
    object-fit: cover !important;
}

.flex-1 img{
    width: 150px !important;
height: 150px;
object-fit: cover;

}



.page-404 .back-to-home{
  padding: 10px;
  background: #0b0b0b;
  border-radius: 4px;
}



.btn.btn-light {
background-color: #dedfdf!important;
border-color: #dedfdf!important;
}


.card-title .titre {
    line-height : 55px;
}

.card .card-body {
    padding: 1.25rem !important;
}


/* sidebar **/





.navbar.default-layout .navbar-brand-wrapper {
    background : linear-gradient(75deg, #0e5ba5,#1169ac , #1d95bf,#21a8c6, #5dcdd8) !important;
    background : -webkit-linear-gradient(75deg, #0e5ba5,#1169ac , #1d95bf,#21a8c6, #5dcdd8) !important;
}


 

.sub-menu .nav-item .nav-link.router-link-active:after {
padding: 25px !important;
}


.sidebar > .nav .nav-item:not(.hover-open) .collapse .sub-menu .nav-item .nav-link:before, .sidebar > .nav .nav-item:not(.hover-open) .collapsing .sub-menu .nav-item .nav-link:before {
    background : #1CB5E0;
    left: 35px;
}

.sidebar .nav-item .nav-link span:not(.menu-title) {
     
    display : block!important;
    word-wrap : break-word;
    white-space : normal;
    line-height : 18px;
    width: 170px;
    font-size : 13px;
}


.sidebar > .nav:not(.sub-menu) > .nav-item:hover:not(.nav-profile):not(.hover-open) > .nav-link:not([aria-expanded="true"]) { 
  width: 270px;
}
/*.sidebar , .navbar.default-layout .navbar-brand-wrapper{
    width : 270px !important ;
}

.navbar.default-layout .navbar-menu-wrapper {
    width : calc(100% - 270px) !important;
}
*/


.width-logo{
    width : 140px !important ;
}

/* end sidebar **/


.prix-total{
    font-size : 16px;
}

table th, table td {
    text-align : left !important;
}

table td {
    /*padding : 15px!important;*/
}

.font-size-semibold {
   font-size: 20px !important;
}

.dot-font-size{
    font-size : 16px;
}

.mx-table-date .today {
    background: #ececec;
}

 /*.mx-calendar-content{
    height : 100% !important;
}
.mx-calendar-content {
   overflow : hidden !important;
}**/

.btn-width-100{
    width : 100%;
}

.height-100 {
    height: 100%;
}
.mb-0-important{
    margin-bottom : 0px !important;
}


.bg-primary , .bg-success, .bg-danger {
    width: 100%;
    border-radius: 6px;
}


.bg-primary h4, .bg-primary h3 , .bg-success h4, .bg-success h3, .bg-danger h4, .bg-danger h3 {
    color : #fff !important;
}


.bg-primary, .bg-dot-primary, .btn-primary {

background: linear-gradient(80deg, #0030E0, #0073F8AB ) !important;
border: none !important;
}

.bg-success, .bg-dot-success, .btn-success {

background: linear-gradient(80deg, #0073F8E6, #1CB5E0D9) !important;
border: none !important;

}

.bg-danger , .bg-dot-danger, .btn-danger {

background: linear-gradient(80deg, #1CB5E0E6, #00C9EBCC) !important;
border: none !important;

}



.bg-warning {

    background: linear-gradient(45deg, #ffbf36, #ff6028) !important;
}

.abonnement-actule {
    background: linear-gradient(45deg, #5e7d8a, #324148) !important;
}


/****back to top ***/



.goTop {
    border-radius: 5px;
    background-color: #0b0b0b;
     position: fixed;
    width: 45px;
    height: 45px;
    display: block;
    right: 15px;
    bottom: 15px;
    border: none;
    opacity: 0;
    z-index: -1;

   
}

 .fa {
        color: white;
        font-size: 22px;
    }

    .goTop:hover {
        opacity: 1;
        background-color: #0b0b0b;
     }

.isVisible {
    opacity: .8;
    z-index: 4;
    transition: all .4s ease-in;
} 

/*
.main-panel  .content-wrapper {
    overflow:auto; 
    height : 100vh;
}*/

.main-panel {
    left: 270px;
position: relative;
}

.sidebar {
    position: fixed;
 
}

.sidebar > .nav {
    overflow-y: scroll !important;
  scrollbar-width: none !important; /* Firefox */
  -ms-overflow-style: none !important;  /* IE 10+ */

    height: 100vh !important; 
    padding-bottom: 200px;
 }

.sidebar > .nav::-webkit-scrollbar {
    width: 0px !important;
}



.bg-green {
    background-color : #0cb50c;
font-weight: 600;
text-align: center !important;
}
.bg-red {
    color: #fff !important;
background-color: #f84c4c;
font-weight: 600;
text-align: center !important;
}

.bg-orange{
  color: #fff !important;
background-color: #ffa500de;
font-weight: 600;
text-align: center !important;   
}

*{
    -ms-overflow-style: auto !important;
scrollbar-width: auto !important;
}

  body, .h1, .h2, .h3, .h4, .h5, .h6, h1, h2, h3, h4, h5, h6, .card-title, span, div, html, b, button, a, strong , p{
    font-family: "Montserrat", sans-serif !important;

 }



h1, h2, h3, h4, h5, h6{
    color : #011481 !important;
    font-weight: 600 !important;
    font-size: 18px !important;
}
 

.mdi-style-content {
  background: -webkit-linear-gradient(45deg, #011481, #0030E0, #0073F8) !important;
    background-clip: border-box;
  background-clip: border-box;
  -webkit-background-clip: text !important;
  -webkit-text-fill-color: transparent !important; 
}




.sidebar > .nav:not(.sub-menu) > .nav-item:hover:not(.nav-profile):not(.hover-open) > .nav-link:not([aria-expanded="true"]), .nav-item .nav-link.router-link-active:after {
    background: linear-gradient(75deg, #0e5ba5,#1169ac , #1d95bf,#21a8c6, #5dcdd8) !important;
background: -webkit-linear-gradient(75deg, #0e5ba5,#1169ac , #1d95bf,#21a8c6, #5dcdd8) !important;
}




.btn-primary {
  background-color: #1CB5E0!important;
  border-color: #1CB5E0!important;
}

.card-header {
   border-top: 4px solid #011481 !important;
}
/*.card .card-title, */ .card .card-header  h3 {
    /*text-transform: uppercase !important;*/
    font-size: 16px !important;
}


.vue-form-wizard .wizard-icon-circle .wizard-icon-container {
    background-color: #00C9EB !important;
}
.vue-form-wizard .wizard-icon-circle {
    border-color: #00C9EB !important;
}

.vue-form-wizard .navbar .navbar-nav > li > a.wizard-btn, .vue-form-wizard .wizard-btn {
    background-color: #00C9EB !important;
border-color: #00C9EB !important;
}


.vue-form-wizard span.stepTitle {
    color : #00C9EB !important;
    font-weight: 600 !important;
}

.vue-form-wizard .wizard-navigation .wizard-progress-with-circle .wizard-progress-bar {
    background-color: #00C9EB !important;
color: #00C9EB !important;
}


.afficher-plus {
    color : #0030E0!important;
}

.badge-primary {
color: #fff;
background-color: #000046;
padding: 6px 15px;
font-size: 10px;
font-weight: 600;
text-transform: uppercase;
}

a {
  color: #0030E0;
  }


 

.card-title .titres {
  font-size: 18px !important;
  text-transform: none;
  font-weight: 600;
  position: relative;
  margin-left: 12px;
}


.btn-presence {
        width: 30%;
        margin-left: 15px; 
    }
.btn-nouvel-abonnement {
    margin-left: 15px; 
    width: 30%;
}
.input-search-by-matricule {
    margin-left: 15px; 
    width: 40%;
}


.btn-presence a,  .btn-nouvel-abonnement a {
    width : 100%;
}

/*** Responsive ***/





@media only screen and (min-width: 1201px) and (max-width: 1258px) {
    .col-12.text-right .btn-add-edit, .col-12.text-right .btn.btn-light{
        width : 100% !important;
    }

    .col-12.text-right .btn.btn-light{
       margin-top : 15px !important;
    }
}

@media only screen and (max-width: 1200px) {
    .parametrages-tablette-mobile .col-md-4, .parametrages-tablette-mobile .col-md-8 {
        flex: 0 0 100% !important;
        max-width: 100% !important;
    }
}

@media only screen and (max-width: 1326px) {
    .btn-presence {
        width: 32%;
    }
    .btn-nouvel-abonnement {
        width: 32%;
    }
    .input-search-by-matricule {
        width: 36%;
    }
}

@media only screen and (max-width: 1090px) {
    .btn-presence {
        width: 50%;
    }
    .btn-nouvel-abonnement {
        width: 50%;
    }
    .input-search-by-matricule {
        display : none !important;
    }
}



@media only screen and  (max-width: 1300px) {

    .col-md-6, .col-6 {
        flex: 0 0 100% !important;
        max-width: 100% !important;
        margin-bottom : 25px !important ;
    }
}


@media only screen and  (min-width: 1067px) {
.bg-primary h4 , .bg-success h4, .bg-danger h4 {
    font-size: 18px !important;
    margin-bottom: 12px !important;
    text-align: center;
    width: 100%;
}
.bg-primary h3 , .bg-success h3, .bg-danger h3 {
    font-size : 32px !important;
}

.bg-primary .card-body , .bg-success .card-body, .bg-danger .card-body {
    text-align : center ! important;
}

}

@media only screen and  (max-width: 1066px)  and  (min-width: 991px) {
.bg-primary h4 , .bg-success h4, .bg-danger h4 {
    font-size: 18px !important;
    margin-bottom: 12px !important;
    text-align: center;
    width: 100%;
}
.bg-primary h3 , .bg-success h3, .bg-danger h3 {
    font-size : 26px !important;
}

.bg-primary .card-body , .bg-success .card-body, .bg-danger .card-body {
    text-align : center ! important;
}

}



@media only screen and (min-width : 992px) and (max-width : 1301px){
 

.forms-sample .col-6.text-left {
max-width : 33.33333% !important;
}
.forms-sample .col-6.text-right {
max-width : 66.66666% !important;
}

.forms-sample .col-6.text-left button {
width : 100%
}

.forms-sample .col-6.text-right button , .forms-sample .col-6.text-right a{
width : 48%
}

}



@media only screen and (max-width : 767px){

.forms-sample .col-6 {
max-width : 100%;
}

.forms-sample .col-6.text-right {
    display: flex;
}

.forms-sample .col-6.text-left button {
width : 100%
}

.forms-sample .col-6.text-right button , .forms-sample .col-6.text-right a{
width : 49%
}

}


@media only screen and (min-width : 768px) and (max-width : 991px){

.forms-sample .col-6.text-left {
max-width : 33.33333% !important;
}
.forms-sample .col-6.text-right {
max-width : 66.66666% !important;
}

.forms-sample .col-6.text-left button {
width : 100%
}

.forms-sample .col-6.text-right button , .forms-sample .col-6.text-right a{
width : 48%
}

}


/** info adherent **/



@media only screen and (min-width : 700px ) and (max-width : 1300px){

 

.info-adherent-tablette {
    display: flex;
}

.info-tablette {
    width : 100%;
}

.img-adherent {
    margin-right: 30px;
display: flex;
justify-content: center;
align-items: center;

}

}

@media only screen and (min-width : 800px ) and (max-width : 1300px){
   
    /*.flex-1 img{
        width : 100% !important;
    }*/
    .flex-1 {
        flex : 1 33% !important;
    }
    .img-adherent {
   
  align-items: baseline;
}
    
  .info-adherent-tablette p {
    font-size : 13px;
  }  

}

@media only screen and (min-width : 700px ) and (max-width : 799px){
 /*.flex-1 img{
        width : 100% !important;
    }*/
    .flex-1 {
        flex : 1 120%;
    }
    .flex-3 {
        margin-left : 40px;
    }
    .img-adherent {
   
  align-items: baseline;
}
    
  .info-adherent-tablette p {
    font-size : 14px;
  }  
.info-adherent-tablette span {
    display : block;
}

}

@media only screen and (max-width : 699px ) {
.info-adherent-tablette {
  display: block;
}
.img-adherent {
  margin-right: 0px;
  display: block;
  }
}

/** end info adherent **/


@media only screen and (max-width: 991px) {
.main-panel {
    left: 0px;
position: relative;
}


.bg-primary h4 , .bg-success h4, .bg-danger h4 {
    font-size: 18px !important;
    margin-bottom: 12px !important;
    text-align: center;
    width: 100%;
}
.bg-primary h3 , .bg-success h3, .bg-danger h3 {
    font-size : 28px !important;
}

.bg-primary .card-body , .bg-success .card-body, .bg-danger .card-body {
    text-align : center ! important;
}


.right_270 {
    right : -270px !important;
}
.right_0 {
    right : -0px !important;
}

.width-logo-mobile{
   width: 48% !important;
position: relative;
top: 3px;
}


}


@media only screen and (max-width: 860px) {
.btn-nouvel-abonnement, .btn-presence {
    display : none !important;
}
}


@media only screen and (max-width: 470px) {

    .navbar.default-layout .navbar-brand-wrapper {
      width: 40%!important;
    }
    .navbar.default-layout .navbar-menu-wrapper {
      width: calc(100% - 40% ) !important;
padding-left: 5px;
padding-right: 5px;
    }
    .navbar.default-layout .navbar-menu-wrapper .navbar-nav .nav-item.user-dropdown {
        margin-left: 2px;
    
    }
    .navbar.default-layout .navbar-menu-wrapper .navbar-nav .nav-item {
      margin-left: 2px;
      margin-right: 0px;
    }
    .width-logo-mobile {
      width: 75% !important;
top: 1px;
    }
    .navbar.default-layout .navbar-menu-wrapper .navbar-nav .nav-item .nav-link i {
        font-size : 1rem !important;
    }
    .navbar.default-layout .navbar-menu-wrapper .navbar-toggler {
        padding : 0!important;
    }
}

@media only screen and (min-width: 471px) and (max-width: 588px)  {
    .navbar.default-layout .navbar-brand-wrapper {
      width: 150px !important;
    }
    .navbar.default-layout .navbar-menu-wrapper {
      width: calc(100% - 150px) !important;
    }
}



@media only screen and (min-width: 589px) {
.sidebar , .navbar.default-layout .navbar-brand-wrapper{
    width : 270px !important ;
}
.navbar.default-layout .navbar-menu-wrapper {
  width: calc(100% - 270px) !important;
}
}



.width-logo{
    width : 70%;
}


@media only screen and (min-width: 601px) {
.card-title .titre {
    font-size : 20px !important;
}
.card-title .titre:before { 
  background: -webkit-linear-gradient(45deg, #011481, #0030E0, #0073F8) !important;
 }

}





@media only screen and (min-width: 471px) and (max-width: 588px) {

.width-logo-mobile{
    width: 85% !important;
top: 2px;
}

}

@media only screen and (max-width: 600px) {


.card-title i {
    display : none !important;
}

.adherent-status span{
    top: 10px;
position: relative;
}


.card-title { 
        display: flex;
 align-items: center;
margin: 0;
    }

.card-title .titre {
    font-size : 19px !important;
    margin-top: 20px;
}
.card-title .titre:before {
    background : none !important;
}

}


@media only screen and (max-width: 480px) {
.wizard-card-footer div, .wizard-card-footer span, .wizard-card-footer button {
    width : 100% !important ;
}
.wizard-card-footer div  {
    margin-top : 20px !important ;
    margin-bottom : 20px !important ;
}


}



@media only screen  and (min-width: 768px) and (max-width: 990px) {
.col-md-3 {
  flex: 0 0 33.3333% !important ;
  max-width: 33.3333% !important ;
}
}
@media only screen  and (min-width: 991px) and (max-width: 1120px) {
.col-md-3 {
  flex: 0 0 33.3333% !important ;
  max-width: 33.3333% !important ;
}
}


.sidebar .menu-title {
    font-size : 14px !important;
}


.bloc-fiche-adherent{
    display: flex;
     justify-content: space-between;
     align-items: center;

}


@media only screen and (max-width: 720px) {

.bloc-fiche-adherent{
    display : block!important;
}

.assurance-mobile{
    margin-top : 20px;
    width: 100%;
display: grid;
grid-template-columns: auto auto;
}

}

@media only screen and (max-width: 550px) {
 

.assurance-mobile{ 
grid-template-columns:  auto !important;
}

}



/**** button **********/
.mdi-edit-btn, .mdi-delete-btn, .mdi-regler-btn, .mdi-details-btn, .mdi-history-btn {
    border-radius: 3px;
   padding: 3px 7px;
   color: #fff;
   cursor: pointer;
   font-size: 16px;
}

.mdi-edit-btn{
background: #0073F8 !important;
}
.mdi-delete-btn {
background: #011481 !important;
}
.mdi-regler-btn {
background: #0030E0 !important;
}
.mdi-details-btn{
background: #1CB5E0 !important;
}

.mdi-history-btn{
background: #1CB5E0 !important;
}

.mdi-block-btn{
background: #8686ff;
}

.swal2-cancel {

}
.swal2-confirm {

}
 
 

/**** end button ***/


/*

.mx-datepicker input {

      padding: 20px 12px !important;
}*/


.text-black.border-none.cards h4{
    justify-content: center;
}



/** regler abonnment **/

@media only screen and (max-width: 991px) {

.regler.width-100{
    width: 100% !important;
max-width: 100% !important;
flex: 0 0 100%!important;
}
}


@media only screen and (min-width: 767px) and (max-width: 1121px) {
    .verifier-adherent .col-mobile.col-md-9 {
        flex: 0 0 66%;
    }
}

@media only screen and (min-width: 500px) and (max-width: 766px) {
    .verifier-adherent .col-mobile.col-md-9 {
        flex: 0 0 50%;
    }
    .verifier-adherent .col-mobile.col-md-3 {
        flex: 0 0 50%;
    }
}

@media only screen and  (min-width: 499px) {
    .verifier-adherent .col-mobile.col-md-9 {
        flex: 0 0 100%;
        margin-bottom : 35px;
    }
    .verifier-adherent .col-mobile.col-md-3 {
        flex: 0 0 100%;
    }
}


</style>
