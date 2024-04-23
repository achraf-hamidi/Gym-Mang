<template>
   <div ref="formContainer" class="main-panel">
      <div  v-if="$can('Consulter la fiche d\'adhérent')" class="content-wrapper">
         <div class="row">
            <div class="col-md-12 ">
               <router-link class="float-right" v-if="$can('Gestions des adhérents')" :to="{name: 'adherents'}">
                 {{ $t('side.menu.adherents.liste') }}
               </router-link>
               <br><br>
            </div>
            <div class="col-md-12 grid-margin stretch-card">
               <div class="card">
                  <div class="card-body">
                     <div class="row">
                        <div   class="col-md-12 bloc-fiche-adherent ">
                           <h1 class="card-top-0 card-title">
                              <i class="mdi-style-content  mdi mdi-account"></i>
                              <span class="titre">
                              Fiche adhérent 
                              </span>
                              <span v-if="details_abonner" >
                              <span v-if="details_abonner.abonner" class=" adherent-status " >
                              <span class="actif" v-if="details_abonner.abonner.RestDays > 0" >
                              actif
                              </span>
                              <span class="inactif" v-else >  
                              inactif
                              </span>
                              </span>
                              </span>
                           </h1>
                           <div v-if="assurance" class="assurance-mobile float-right">
                              <p> <b>Date de déclaration</b>  : {{ assurance.date_assuree | formatDate }}  </p>
                              <p> <b>date d'échéance</b>  : {{ assurance.date_fin | formatDate }}  </p>
                              <p> <b>Jours restants </b> : {{ assurance.RestDays }} {{$t('content.text.jours')}}  </p>
                              <p> <b>Prix d'assurance</b>  : {{ assurance.prix }} {{$t('content.text.dh')}} </p>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="row">
            <div class="col-md-12 mb-3 text-center">
               <h5>Statistiques pour le dernier abonnement actif
               </h5>
            </div>
         </div>
         <revenu-paiements v-if="revenu" :revenu="revenu" :code="code"></revenu-paiements>
         <div   class="col-md- grid-margin stretch-card">
            <div   class="card">
               <div class="card-body">
                  <div v-if="montantTotalNetPayer" class="row mt-3 mb-3">
                     <div class="col-md-10 mb-2">
                        <h5>Total des crédits des abonnements actifs et inactifs 
                        </h5>
                     </div>
                     <div  class="col-md-2 mb-2 text-right"> 
                        <router-link style="padding : 0px!important;" v-if="details_adherent"  :to="{name: 'abonnements_non_paye', query : { adherent : `${details_adherent.code_client}` }}" class="nav-link">
                           Voir détails
                         </router-link>
                     </div>
                     <div class="col-md-4 mt-4">
                        <div class="d-flex align-items-center pb-2">
                           <div class="dot-indicator bg-dot-primary mr-2"></div>
                           <p class="mb-0 dot-font-size">Montant Total net à payer</p>
                        </div>
                        <h4 class="font-weight-semibold font-size-semibold">{{montantTotalNetPayer}} {{$t('content.text.dh')}}</h4>
                        <div class="progress progress-md">
                           <div class="progress-bar bg-dot-primary" role="progressbar" style="width: 100%"></div>
                        </div>
                     </div>
                     <div class="col-md-4 mt-4">
                        <div class="d-flex align-items-center pb-2">
                           <div class="dot-indicator bg-dot-success mr-2"></div>
                           <p class="mb-0 dot-font-size">Montant Total payé</p>
                        </div>
                        <h4 class="font-weight-semibold font-size-semibold">{{montantTotal_Paye}} {{$t('content.text.dh')}}</h4>
                        <div class="progress progress-md">
                           <div class="progress-bar bg-dot-success" role="progressbar" style="width: 100%"></div>
                        </div>
                     </div>
                     <div class="col-md-4 mt-4">
                        <div class="d-flex align-items-center pb-2">
                           <div class="dot-indicator bg-dot-danger mr-2"></div>
                           <p class="mb-0 dot-font-size">Total restant à payer</p>
                        </div>
                        <h4 class="font-weight-semibold font-size-semibold">{{ parseFloat(montantTotalNetPayer - montantTotal_Paye).toFixed(2)}} {{$t('content.text.dh')}}</h4>
                        <div class="progress progress-md">
                           <div class="progress-bar bg-dot-danger" role="progressbar" style="width: 100%"></div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="row">
            <info-personnelle v-if="details_adherent" :details_adherent="details_adherent" :details_abonner="details_abonner"  :code="code"></info-personnelle>
            <abonnement-actuel v-if="details_abonner" :details_abonner="details_abonner" :code="code" :reste_a_payer="revenu.reste"></abonnement-actuel>
            <!--<qr-code v-if="details_adherent" :details_adherent="details_adherent" :code="code"></qr-code>-->
         </div>
         <div class="row">
            <div  class="col-md-12 grid-margin stretch-card">
               <historique-abonnement :code="code"></historique-abonnement>
            </div>
            <!--<div  class="col-md-6 grid-margin stretch-card">
               <paiements :code="code"></paiements>
               </div>
               <activities :code='code'></activities>-->
         </div>
         <div class="row" v-if="details_abonner && details_abonner.abonner && details_abonner.abonner.empeches[0]">
            <empeches :code="code" :empeches="details_abonner.abonner.empeches[0]"> </empeches>
         </div>
         <div class="row">
            <div class="col-md-12">
               <div class="row">
                  <presences :code="code"></presences>
               </div>
            </div>
         </div>
         <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
               <historiques-assurance :code="code"></historiques-assurance>
            </div>
         </div>
         <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
               <historiques-recettes :code="code"></historiques-recettes>
            </div>
         </div>
         <!--<div class="row">
            <recharges v-if="wallet" :code="code" :wallet="wallet"></recharges>
            <children-parrinage v-if="details_adherent && details_adherent.children" :code="code" :children_parrinage="details_adherent.children"></children-parrinage>
            </div> -->
      </div>
      <div v-else class="content-wrapper">
         <havent-permission></havent-permission>
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
               assurance : null,
               montantTotalNetPayer : 0,
               montantTotal_Paye : 0
           }
       },
       mounted() {
           console.log(this.code)
           this.DetailsAdherent(this.code);
           this.ListAbonnementsNonPaye(this.code) ;
       },
       methods: {
           DetailsAdherent(code) {
              if (typeof this.$refs.formContainer !== "undefined")  
                   this.PluginLoader(false, this.$refs.formContainer)
               axios.get('/api-admin/details-adherent/' + this.code).then(res => {
                   if (res.data != false) {
                       this.details_adherent = res.data.details_adherent
                       this.details_abonner = res.data.details_abonner
                       this.revenu = res.data.revenu
                       this.wallet = res.data.wallet
                       this.assurance = res.data.assurance
                       //console.log("absence")
                      // console.log(this.details_abonner.abonner.empeches[0])
                   }else
                       window.location.href = `/admin/404?code=` + this.code
   
               })
               /*.catch (err => {
                                  alert("Adhérent n'existe pas")
                             }) */
           },
   
           ListAbonnementsNonPaye() {
               if (typeof this.$refs.formContainer !== "undefined")  
                   this.PluginLoader(false, this.$refs.formContainer)
   
               const current_page =  1;
               this.formData = new FormData(); 
   
               if (this.code != '')
                   this.formData.append("filtrer[matricule]", this.code); 
   
   
               const config = { headers: { 'content-type': 'multipart/form-data' } }
               axios.post('/api-admin/list-abonnements-non-paye?page=' + current_page, this.formData, config).then((response) => {
                   
                   this.abonnements_non_paye = response.data.abonnements_non_paye.data;
                   //this.pagination = response.data.abonnements_non_paye;
   
                   this.montantTotalNetPayer = parseFloat(this.abonnements_non_paye.reduce((n, {prix_ttc}) => n + parseFloat(prix_ttc)  , 0) ).toFixed(2);
   
                   this.montantTotal_Paye = parseFloat(this.abonnements_non_paye.reduce((n, {sums}) => n +  parseFloat(sums)  , 0)).toFixed(2);
   
                   console.log('montantTotalNetPayer est : ' + this.montantTotalNetPayer)
                   console.log('montantTotal_Paye est : ' + this.montantTotal_Paye)
                   console.log('Restant a payer est : ' + (this.montantTotalNetPayer - this.montantTotal_Paye))
   
   
   
                });
           },  
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
   .card-top-0.card-title {
   top : -10px !important;
   }
   .height-scroll {
   max-height: 500px;
   overflow: scroll;
   margin-bottom : 20px;
   }
   .adherent-status span{
   /*width: 100%;
   display: block;*/
   text-align: center;
   padding: 6px;
   border-radius: 3px;
   margin-bottom: 20px;
   color: #fff;
   font-weight: 600;
   font-size: 16px;
   text-transform: uppercase;
   margin-left : 14px;
   }
   .adherent-status .actif {
   background  :#22b622;
   }
   .adherent-status .inactif {
   background: #ff5656;
   }
</style>
