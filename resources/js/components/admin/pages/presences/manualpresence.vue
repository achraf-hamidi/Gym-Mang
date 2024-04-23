

<template>
   <div v-if="$can('Pointage des adhérents')" class="col-md-12 grid-margin stretch-card">
      <div class="card">
         <div class="card-header ">
            <div class="row">
               <div class="col-md-12">
                  <h3>Pointage des adhérents </h3>
               </div>
            </div>
         </div>
         <div class="card-body">
            <form @submit.prevent="manualPresence($event)" class="forms-sample">
               <!--<div class="form-group mr-b-0em" :class="{ 'form-group--error': $v.code_client.$error }">
                  <label class="form__label">{{ $t('content.pages.presences.aujourdhui.nouveau.matricule.titre') }}</label>
                  <input class="form-control" v-model.trim="$v.code_client" @input="setcode_client($event.target.value)" :placeholder="$t('content.pages.presences.aujourdhui.nouveau.matricule.placeholder')" />
                  </div>-->
               <div class="col-12">
                  <div class="form-group mr-b-0em">
                     <label class="form__label"> ID</label>
                     <!--<multiselect v-model.trim="value_id_adherent"  :options="list_adherents" :custom-label="nameWithCodeClient" placeholder="Recherche.." label="code_client" track-by="code_client"></multiselect>-->
                     <input class="form-control" v-model.trim="matricule_cin_adherent"   placeholder="ID" />
                  </div>
               </div>
               <!--<div v-if="$v.value_id_adherent.$dirty">
                  <div class="error" v-if="!$v.value_id_adherent.required">{{ $t('validation.required', { attribute : $t('content.pages.presences.aujourdhui.nouveau.matricule.titre') }) }}</div>
                  <div class="error" v-if="!$v.value_id_adherent.minLength">
                      {{ $t('validation.min.numeric', { attribute : $t('content.pages.presences.aujourdhui.nouveau.matricule.titre'), min : $v.code_client.$params.minLength.min }) }}
                  </div>
                  </div>-->
               <div class="col-12 text-right">
                  <button type="submit" class="btn btn-primary mr-2"> <i class=" mdi mdi-plus"></i> {{ $t('content.bouton.ajout') }}</button>
                  <a @click="clearDataInputs" href="javascript:void(0)" class="btn btn-light">{{ $t('content.bouton.annuler') }}</a>
               </div>
            </form>
         </div>
      </div>
   </div>
</template>
<script>
   import { required, minLength, numeric, between, maxLength, email } from 'vuelidate/lib/validators'
   export default {
       props: ['activities'],
       data() {
           return {
               code_client: '',
               id_empreinte:'',
               matricule_cin_adherent : '',
               
               formData: {},
               submitStatus: null,
               list_adherents: [],
               value_id_adherent: [],
           }
       }, 
       methods: {
           nameWithCodeClient({ code_client, nom }) {
               return `${code_client} -  ${nom} `
           },
           ListAdherents() {
               axios.get('/api-admin/list-adherents-has-abonners').then((response) => {
                   this.list_adherents = response.data;
               });
           }, 
           manualPresence(event) {
   
               if (this.matricule_cin_adherent != null) {
   
                   //this.$fire(this.AlertFire('presences')).then((result) => {
                      // if (result.value) {
                   this.submitStatus = 'PENDING'
                   this.formData = new FormData();
                    
                    if (this.matricule_cin_adherent != null) {
                       this.formData.append("code_client", this.matricule_cin_adherent);
                       this.formData.append("id_empreinte", this.matricule_cin_adherent);
                   }
                 


                    const config = { headers: { 'content-type': 'multipart/form-data' } }

                   axios.post('/api-admin/get-information-adherent', this.formData, config).then(response => {
                        //console.log(response.data.adherent.nom)
                        if (response.data.adherent != null ) {
                            const adherent = response.data.adherent
                            const information_adherents = "<p style='margin-top: 20px; margin-bottom : 0px;'> <b>ID</b> : " + adherent.id_empreinte + "</p><br><p style='margin-bottom : 0px;'><b>Nom : </b>" + adherent.nom  + "</p>"

                            let _object = {
                                title: "Vérifier l'adhérent" ,
                                html: information_adherents,
                                type: 'question',
                                showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText:  this.$t('content.bouton.oui')  ,
                                cancelButtonText: this.$t('content.bouton.non') 
                            }


                            this.$fire(_object).then((result) => {
                                if (result.value) {
                                  // this.submitStatus = 'PENDING'
                                  // this.formData = new FormData();
           
                                   
           
                                    const config = { headers: { 'content-type': 'multipart/form-data' } }
                                    axios.post('/api-admin/manual-presence-or-qr', this.formData, config).then(response => {
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
                                                   this.eventPresences.$emit('manual-presence-or-qr', response.data)
                                                   const verbe = (response.data.type == 'entrer') ? this.$t('content.alerts.presences.entrer') : this.$t('content.alerts.presences.sortier')
                                                   //const _text = this.$t('content.alerts.presences.success', { verbe: verbe, date_entrer: response.data.presence.date_entrer, jours_restant: response.data.days })
                                                   const _text = "L'adhérent est ajouté avec succès "
                                                   this.AlertResponseTrue("", _text, "success")
                                                   this.matricule_cin_adherent = ''
                                                   this.id_empreinte = ''
                                                   break;
                                           }
                                           this.value_id_adherent = null
                                    }).catch(e => {})
                                   .finally(f => {
                                        setTimeout(() => {
                                           this.submitStatus = 'OK'
                                        }, 500)
                                    })
                                }   
                            }) 
                        }else{
                            this.AlertResponseFalse("", this.$t('content.alerts.adherents.n_existe'), "warning")
                        }                        
                   }).catch(e => {})
                   .finally(f => {
                        setTimeout(() => {
                           this.submitStatus = 'OK'
                        }, 500)
                    })
                }
   
                  // })
               //}
   
           },
           clearDataInputs() {
                this.value_id_adherent = []
           }
       },
       beforeMount() {
           //this.ListAdherents()
   
       }
   }
   
</script>

