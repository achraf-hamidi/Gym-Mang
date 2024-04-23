<template>
    <div v-if="$can('Ajouter une absence')" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div ref="formContainer" class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="card-header ">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="d-flex justify-content-between">
                                <h3 class="card-title mb-0"> {{ $t('content.pages.abonnements.empeches.nouveau.titre') }}  </h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-body grid-margin modal-utilisateur">
                    <form-wizard @on-complete="submit($event , action)" subtitle="" title='' shape="circle" :back-button-text="$t('content.bouton.prev')" :next-button-text="$t('content.bouton.next')" :finish-button-text="$t('content.bouton.enregistrer')" color="#ff9c00e6">
                        <tab-content :title="$t('content.pages.adherents.add_modale.steps.infos')" icon="far fa-user">
                            <!--<form @submit.prevent="submit($event)" class="forms-sample">-->
                            <div class="row">

                                <div v-if="action == 'add'" class="col-md-6">
                                    <div class="form-group mr-b-0em">
                                        <label class="form__label">ID </label>
                                        <!--<multiselect v-model.trim="info_adherent" :options="info_adherent" :custom-label="nameWithCodeClient" placeholder="Recherche.." label="code_client"   @input="AbonnerJoursRestant"></multiselect>-->

                                        <!-- <input class="form-control"  @blur="GetInfoAdherent"  
                                        v-model="matricule"  
                                         /> -->
                                         <input class="form-control"  @blur="GetInfoAdherent"  
                                        v-model="id_empreinte"  
                                         /> 

                                    </div>
                                </div>
 
                                <div v-else class="col-6">
                                    <div class="form-group mr-b-0em">
                                        <label class="form__label"> {{ $t('content.pages.abonnements.empeches.nouveau.inputs.adherents.titre')}}</label>
                                        <input class="form-control" :value="info_adherent.nom" disabled />
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group mr-b-0em" :class="{ 'form-group--error': $v.empeche.empeche.$error }">
                                        <label class="form__label"> {{$t('content.pages.abonnements.empeches.nouveau.inputs.empeche.titre')}} </label>
                                        <input class="form-control" v-model.trim="$v.empeche.empeche.$model" @input="setempeche($event.target.value)" :placeholder="$t('content.pages.abonnements.empeches.nouveau.inputs.empeche.placeholder')" />
                                    </div>
                                    <div v-if="$v.empeche.empeche.$dirty">
                                        <div class="error" v-if="!$v.empeche.empeche.required && submitStatus == true ">{{ $t('validation.required', { attribute :  $t('content.pages.abonnements.empeches.nouveau.inputs.empeche.titre') }) }}</div>
                                        <div class="error" v-if="!$v.empeche.empeche.minLength">
                                            {{ $t('validation.min.numeric', { attribute :  $t('content.pages.abonnements.empeches.nouveau.inputs.empeche.titre') , min : $v.empeche.empeche.$params.minLength.min }) }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group mr-b-0em" :class="{ 'form-group--error': $v.empeche.nb_jours.$error }">
                                        <label class="form__label">{{ $t('content.pages.abonnements.empeches.nouveau.inputs.nb_jours_declare.titre')}}</label>
                                        <input @blur="newDateFinAbonnement" class="form-control" v-model.trim="$v.empeche.nb_jours.$model" @input="setnb_jours($event.target.value)" :placeholder="$t('content.pages.abonnements.empeches.nouveau.inputs.nb_jours_declare.placeholder')" />
                                    </div>
                                    <div v-if="$v.empeche.nb_jours.$dirty">
                                        <div class="error" v-if="!$v.empeche.nb_jours.numeric">
                                            {{ $t('validation.numeric', { attribute : $t('content.pages.abonnements.empeches.nouveau.inputs.nb_jours_declare.titre') }) }}
                                        </div>
                                        <div class="error" v-if="!$v.empeche.nb_jours.isThanZero">
                                           Vous n'avez que {{ restJours }} jours restant 
                                        </div>
                                        <div class="error" v-if="!$v.empeche.nb_jours.required && submitStatus == true ">
                                            Nombre des jours est obligatoire
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group mr-b-0em" :class="{ 'form-group--error': $v.empeche.date_absence.$error }">
                                        <label class="form__label">{{$t('content.pages.abonnements.empeches.nouveau.inputs.date_absence.titre')}}</label>
                                        <date-picker format="DD/MM/YYYY" style="width : 100%;" v-model.trim="$v.empeche.date_absence.$model" @change="setdate_absence" type="date" :editable="false"></date-picker>
                                    </div>
                                    <div v-if="$v.empeche.date_absence.$dirty">
                                        <div class="error" v-if="!$v.empeche.date_absence.required && submitStatus == true ">{{ $t('validation.required', { attribute : $t('content.pages.abonnements.empeches.nouveau.inputs.date_absence.titre') }) }}</div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <span v-if="info_adherent.cin">
                                        <!-- <span> <b>ID : </b> {{info_adherent.code_client}} </span><br> -->

                                        <span> <b>ID : </b> {{info_adherent.id_empreinte}} </span><br>
                                        <span> <b>Nom : </b> {{info_adherent.nom}} </span><br>

                                        <span v-if="info_adherent.latest_abonner">
                                            <b> Date fin d'abonnement : </b> 

                                    

                                            <span v-if="action == 'edit'">
                                                {{ old_date_fin | formatDate }}
                                            </span>
                                            <span v-else>
                                                {{ info_adherent.latest_abonner.date_fin | formatDate }}
                                            </span> 
                                            <br>

                                             <b>Nouvelle date de fin : </b> {{new_date | formatDate }}<br>
                                            <b>Jours restants : </b> {{ restJours }} jours<br>
                                           


                                            <span v-if="$v.empeche.date_absence.$model">
                                                <b>
                                                    <span style="bottom: 0px !important;"  class="error" v-if="$v.empeche.nb_jours.$model > RestJoursWithDateAbsence()">
                                                        Votre absence dépasse le nombre de jours restants
                                                    </span>
                                                </b>
                                            </span>

                                        
                                         

                                    </span>


                                    </span>
                                    
                                </div>
                            </div>
                        </tab-content>
                    </form-wizard>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import { required, minLength, numeric, decimal, between, maxLength, email } from 'vuelidate/lib/validators'
export default {
     data() {
        return {
            empeche: {
                date_absence: new Date(),
                nb_jours: 0,
                id_adherent: '',
                empeche: '',
            },
            info_adherent: [],
            //info_adherent : [],
            restJours: 0,
            formData: {},
            submitStatus: false,
            action: 'add',
            empeche_id: null,
            empeche_index: null,
            nv_date_fin: null,
            old_date_fin : null,
            matricule : '',
            id_empreinte:'',
            new_date : null
        }
    },
    validations() {
        return {
            empeche: {
                empeche: {
                    required,
                    minLength: minLength(3)
                },
                date_absence: {
                    required
                },
                /*date_fin: {
                  required
                }, */
                nb_jours: {
                    required,
                    numeric,
                    async isThanZero(value) {
                        if (value <= this.restJours) return true
                    }
                }
                
              /*  id_adherent: {
                    required
                }*/
            }
        }
    },
    methods: {
        setempeche(value) {
            //console.log(value)
            this.empeche.empeche = value
            this.$v.empeche.empeche.$touch()
        },
        setnb_jours(value) {
            //console.log(value)
            this.empeche.nb_jours = value
            this.$v.empeche.nb_jours.$touch()
            //this.addDays(this.$v.empeche.date_absence.$model.toLocaleDateString(), value  ) 

        },
        setdate_absence(value) {
            //console.log(this.$v.empeche.nb_jours.$model)
            this.empeche.date_absence = value
            this.$v.empeche.date_absence.$touch()
            //this.addDays(this.$v.empeche.date_absence.$model.toLocaleDateString(), parseInt(this.$v.empeche.nb_jours.$model)  ) 

        },
        /*setdate_fin(value) {
          //console.log(value)
          this.empeche.date_fin = value
          this.$v.empeche.date_fin.$touch()
        }, */
        setid_adherent(value) {
            //console.log(value)
            this.empeche.id_adherent = value
            this.$v.empeche.id_adherent.$touch()
        },
         nameWithCodeClient({ code_client, nom }) {
            return `${code_client} -  ${nom} `
        }, 
        GetInfoAdherent() {
            if (this.matricule != '' && this.matricule != null ) {
                if (typeof this.$refs.formContainer !== "undefined")  
                this.PluginLoader(false, this.$refs.formContainer)

            this.formData = new FormData();
            this.formData.append('matricule', this.matricule); 
            this.formData.append('id_empreinte', this.id_empreinte);

            const config = { headers: { 'content-type': 'multipart/form-data' } }
            axios.post('/api-admin/empeche/find-adherent-has-abonnement-actif', this.formData, config).then((response) => {

                //console.log(response.data.adherent)
                switch(response.data.adherent) {
                    case null : 
                        this.AlertResponseFalse("", "Adhérent n'existe pas", "warning"); 
                        this.info_adherent = []
                        break
                    default : 
                        this.info_adherent = response.data.adherent;
                        this.AbonnerJoursRestant();
                        this.RestJoursWithDateAbsence()
                        this.newDateFinAbonnement()
                        //this.AlertResponseTrue("", "Adhérent existe", "warning"); 
                        break
                }
                
            });
            }
        },
        onComplete: function() {
            alert('Yay. Done!');
        },
        submit(event, is_action) {
            this.$v.$touch()
            //console.log(this.$v.$invalid)
            //       this.addDays(this.$v.empeche.date_absence.$model.toLocaleDateString(), parseInt(this.$v.empeche.nb_jours.$model)  ) 
            this.submitStatus = true
            if (this.$v.$invalid) {
               // this.submitStatus = 'ERROR'
            } else {

                if (this.action == 'add') {
                    var fire_title = this.$t('content.alerts.ajout.message')
                    var fire_text = this.$t('content.alerts.ajout.sous_message')
                    var fire_confirm = this.$t('content.bouton.oui') + ', ' +  this.$t('content.bouton.ajout'); 
                    var fire_cancle = this.$t('content.bouton.non') + ', ' + this.$t('content.bouton.annuler')
                }else{
                    var fire_title = this.$t('content.alerts.modification.message')
                    var fire_text = this.$t('content.alerts.modification.sous_message')
                    var fire_confirm = this.$t('content.bouton.oui') + ', ' +  this.$t('content.bouton.modifier'); 
                    var fire_cancle = this.$t('content.bouton.non') + ', ' + this.$t('content.bouton.annuler')
                }

                this.$fire(
                    this.AlertFire(this.action)
                ).then((result) => {
                    if (result.value) {
                        //console.log(is_action)
                        const post = (is_action == 'add') ? 'store' : 'update';

                        //this.submitStatus = 'PENDING'
                        this.formData = new FormData();
                        //### Informations personnelle
                        this.formData.append('empeche[date_absence]', this.$v.empeche.date_absence.$model.toDateString()); 
                        this.formData.append('empeche[nb_jours]', this.$v.empeche.nb_jours.$model);
                        this.formData.append('empeche[id_adherent]', this.info_adherent.id); 
                        this.formData.append('empeche[empeche]', this.$v.empeche.empeche.$model);

                        if (is_action == 'edit') {
                            this.formData.append('empeche_id', this.empeche_id);
                            this.formData.append('nv_date_fin', this.nv_date_fin);
                            //this.formData.append('date_fin_abonner', this.info_adherent.latest_abonner.date_fin);
                            this.formData.append('id_abonner', this.info_adherent.latest_abonner.id);
                        }
                        const config = { headers: { 'content-type': 'multipart/form-data' } }
                        axios.post('/api-admin/empeches/' + post, this.formData, config).then(res => {
                                switch(res.data) {
                                    case "empeche existe" : 
                                        this.AlertResponseFalse("", "Cet utilisateur a un date d'absences qui n'a pas encore expiré, vous devez ajouter une autre absence après la fin de l'absence en cours" , "warning"); 
                                        break
                                    case "abonner n'existe pas" : 
                                        this.AlertResponseFalse("", this.$t('content.alerts.adherents.ni_abonner'), "warning"); 
                                        break
                                    default :  
                                        const _text = (this.action == 'add') ? this.$t('content.alerts.ajout.success') : this.$t('content.alerts.modification.success')  ; 

                                        this.AlertResponseTrue("",  _text , "success"); 
                                        
                                        $('.modal').modal('hide');
                                        if (is_action == 'add')
                                            this.$emit('RefreshListEmpeches', res.data);
                                        else
                                            this.eventEmpeches.$emit('update', { "empeche": res.data, "index": this.empeche_index })

                                        $('.btn-add-edit').text(this.$t('content.bouton.ajout'))
                                        this.$v.empeche.date_absence.$model = null
                                        this.$v.empeche.empeche.$model = null
                                        this.$v.empeche.nb_jours.$model = null
                                        this.info_adherent = []
                                        this.action = 'add'
                                        this.empeche_id = null
                                        this.empeche_index = null
                                        this.matricule = '',
                                        this.id_empreinte='',
                                        this.submitStatus = false
                                        this.$v.$reset()


                                        break;   
                                }

                            }).catch(e => {})
                            .finally(f => {
                                setTimeout(() => {
                                   // this.submitStatus = 'OK'
                                }, 500)
                            })
                        }
                    })
            }
        },
        AbonnerJoursRestant() {

            if(typeof this.info_adherent.latest_abonner !== 'undefined') {

                //console.log(this.info_adherent)
                 
                //var day_start = new Date();
                //var day_end = new Date(this.info_adherent.latest_abonner.date_fin);
                //var total_days = (day_end - day_start) / (1000 * 60 * 60 * 24);
                this.restJours = this.info_adherent.latest_abonner.RestDays ; //Math.round(total_days + 2)


                //return Math.round(this.restJours); 
            }
        },
            RestJoursWithDateAbsence() {
                            if(typeof this.info_adherent.latest_abonner !== 'undefined') {
                var day_start = new Date(this.$v.empeche.date_absence.$model);
                var day_end = new Date(this.info_adherent.latest_abonner.date_fin);
                var total_days = (day_end - day_start) / (1000 * 60 * 60 * 24);
                return Math.round(total_days + 1)
                //return Math.round(this.restJours); 
            }

        },
        newDateFinAbonnement(){

            if(typeof this.info_adherent.latest_abonner !== 'undefined' && this.$v.empeche.nb_jours.$model != '') { 

                if(this.action == 'edit'){
                    var current_date_fin_abonnement = new Date(this.old_date_fin);
                }else if(this.action == 'add'){
                    var current_date_fin_abonnement = new Date(this.info_adherent.latest_abonner.date_fin);
                }

var duration = this.$v.empeche.nb_jours.$model; //In Days
current_date_fin_abonnement.setTime(current_date_fin_abonnement.getTime() +  (duration * 24 * 60 * 60 * 1000));
this.new_date = current_date_fin_abonnement


            }

            
        }
    },
    created: function() {
        this.eventEmpeches.$on('edit', data => {
            this.action = 'edit'
            this.$v.empeche.date_absence.$model = new Date(data.empeche.date_absence)
            this.$v.empeche.empeche.$model = data.empeche.empeche
            this.$v.empeche.nb_jours.$model = data.empeche.nb_jours
            this.info_adherent = data.empeche.abonner.adherent
            this.nv_date_fin = data.empeche.date_fin
            this.old_date_fin = data.empeche.old_date_fin_abonnement
            this.empeche_id = data.empeche.id
            this.empeche_index = data.index
            $('.btn-add-edit').text(this.$t('content.bouton.modifier'))
            this.AbonnerJoursRestant();
            this.RestJoursWithDateAbsence()
        })
        this.eventEmpeches.$on('empty', data => {
            this.action = 'add'
            this.$v.empeche.date_absence.$model = null
            this.$v.empeche.empeche.$model = null
            this.$v.empeche.nb_jours.$model = null
            this.info_adherent = []
            this.nv_date_fin = null;
            this.old_date_fin = null
            this.empeche_id = null;
            this.empeche_index = null;
            $('.btn-add-edit').text(this.$t('content.bouton.modifier'))
        })
    },
    beforeMount() {
        //this.GetInfoAdherent()
    },
    computed: {

    }
}

</script>
<style>
.error {
    color: #ff4747;
    bottom: 16px;
    position: relative;
    text-transform: lowercase;
}


.invioce-adherent {
    margin-top: 25px;
}

.invioce-adherent p {
    margin-bottom: 0rem ! important;
}

.invioce-adherent p span {
    font-weight: bold;
}

</style>
