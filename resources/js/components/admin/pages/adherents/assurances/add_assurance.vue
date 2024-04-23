<template>
    <div  v-if="$can('Ajouter une assurance')"  class="modal fade modal-assurance" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div ref="formContainer" class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="card-header ">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="d-flex justify-content-between">
                                <h3 class="card-title mb-0 titre-add-edit"> Ajouter une assurance </h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-body grid-margin modal-utilisateur">
                    <form-wizard @on-complete="submit($event , action)" subtitle="" title='' shape="circle" :back-button-text="$t('content.bouton.prev')" :next-button-text="$t('content.bouton.next')" :finish-button-text="$t('content.bouton.enregistrer')" color="#ff9c00e6">
                        <tab-content :title="$t('content.pages.adherents.add_modale.steps.infos')" icon="far fa-user">
                            <!--<form @submit.prevent="submit($event)" class="forms-sample">-->
                            <div class="row">

                                <div v-if="action == 'add'" class="col-md-12">
                                    <div class="form-group mr-b-0em">
                                        <label class="form__label">{{ $t('content.pages.adherents.badges.recherche.matricule.titre') }} </label>
                                        <!--<multiselect v-model.trim="info_adherent" :options="info_adherent" :custom-label="nameWithCodeClient" placeholder="Recherche.." label="code_client"   @input="AbonnerJoursRestant"></multiselect>-->

                                        <input class="form-control"  @blur="GetInfoAdherent"  v-model="matricule"  />


                                    </div>
                                </div>
 
                                <div v-else class="col-12">
                                    <div class="form-group mr-b-0em">
                                        <label class="form__label">Nom adhérent</label>
                                        <input class="form-control" :value="info_adherent.nom" disabled />
                                    </div>
                                </div>

                                <div class="col-md-6">
                                                    <div class="form-group mr-b-0em" :class="{ 'form-group--error': $v.assurance.date_assuree.$error }">
                                                        <label class="form__label"> Date déclaration d'assurance </label>
                                                        <date-picker format="DD/MM/YYYY" style="width : 100%;" v-model.trim="$v.assurance.date_assuree.$model" @change="setdate_assuree"></date-picker>
                                                    </div>
                                                    <div v-if="$v.assurance.date_assuree.$dirty">
                                                        <!--<div class="error" v-if="!$v.assurance.date_assuree.required && submitStatus == true ">{{ $t('validation.required', { attribute : $t('content.pages.abonnements.nouveau.inputs.assurance.date_assuree.titre') }) }}</div>-->
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-group mr-b-0em">
                                                        <label class="form__label"> Durée d'assurance</label>
                                                    
                                                        <multiselect v-model.trim="$v.assurance.typeassurance.$model" @input="settypeassurance($event)" :options="assurances" :custom-label="libeleAssurance" placeholder="Recherche.." label="id" track-by="id"></multiselect>

                                                    </div>
                                                    <div v-if="$v.assurance.typeassurance.$dirty">
                                                        <div class="error" v-if="!$v.assurance.typeassurance.required && submitStatus == true ">{{ $t('validation.required', { attribute : 'Durée d\'assurance' }) }}</div>
                                                    </div>
                                                </div>



                                <div v-if="info_adherent.cin" class="col-12">
                                    <p v-if="info_adherent.cin">

                                        <span> <b>Matricule : </b> {{info_adherent.code_client}} </span><br>
                                        <span> <b>Nom : </b> {{info_adherent.nom}} </span>
                                    </p>
                                    <p v-if="if_has_assurance">
                                        <span> <b>Assurance : </b>  {{ if_has_assurance.date_assuree | formatDate }}  </span><br>
                                        <span>
                                            <b>Jours Restants : </b> {{ if_has_assurance.RestDays}} j
                                        </span>
                                    </p>  
                                    <p v-else>
                                        <span> <b>Compte non assurer</b> </span>
                                    </p>                                    
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
            assurance: {
                 date_assuree: new Date(),
                duree_assurance: null,
                prix_assurance: 0.00,
                typeassurance : null
            },
            info_adherent: [],
             assurances : [],

             formData: {},
            submitStatus: false,
            action: 'add',
             matricule : '',
             assurance_index : null,
             assurance_id : null,
             if_has_assurance : []
         }
    },
    validations() {
        return {
            assurance: {
                date_assuree: {
                    //required: requiredIf(function() { return this.ifCompteNotAssuree }) //requiredUnless('ifCompteNotAssuree'),
                },
                prix_assurance: {
                    //required: requiredIf(function() { return this.ifCompteNotAssuree }), //requiredUnless('ifCompteNotAssuree'),
                    decimal,
                    /* async isThanZero(value) {
                         if (this.ifCompteNotAssuree) {
                             if (value > 0) return true
                         } //else return true
                     }*/
                },
                duree_assurance: {
                    //required: requiredIf(function() { return this.ifCompteNotAssuree }) //requiredUnless('ifCompteNotAssuree'),
                },
                typeassurance :{
                        required
                }
            }
        }
    },
    methods: {

        libeleAssurance({ prix, libelle, nb_mois }) {
            return `${libelle} (${nb_mois} mois), ( ${prix} Dhs )`
        },  
        ListAssurances() {
            axios.get('/api-admin/parametrages/assurances?type_frais=1').then((response) => {
                this.assurances = response.data.assurances;
 
             });
        },

        setdate_assuree(value) {
            //console.log(value)
            this.assurance.date_assuree = value
            this.$v.assurance.date_assuree.$touch()

        },
        setprix_assurance(value) {
            //console.log(value)
            this.assurance.prix_assurance = value
            this.$v.assurance.prix_assurance.$touch()
        },

        settypeassurance(value) {
            //console.log(value)
            this.assurance.typeassurance = value
            this.$v.assurance.typeassurance.$touch()
        },

        GetInfoAdherent() {

            if (this.matricule != '' && this.matricule != null) {
                if (typeof this.$refs.formContainer !== "undefined")  
                this.PluginLoader(false, this.$refs.formContainer)

            this.formData = new FormData();
            this.formData.append('code_client', this.matricule); 

            const config = { headers: { 'content-type': 'multipart/form-data' } }
            axios.post('/api-admin/adherent/check-adherent-is-existe', this.formData, config).then((response) => {

                //console.log(response.data[0].adherent)
                switch(response.data[0].adherent) {
                    case null : 
                        this.AlertResponseFalse("", "Adhérent n'existe pas", "warning"); 
                        this.info_adherent = []
                        break
                    default : 
                        this.info_adherent = response.data[0].adherent;
                        this.if_has_assurance = response.data[1].is_assuree;

                         
                        break
                }
                
            });
            }
        },
        
        submit(event, is_action) {
            this.$v.$touch()
            //console.log(this.$v.$invalid)
            //       this.addDays(this.$v.empeche.date_absence.$model.toLocaleDateString(), parseInt(this.$v.empeche.nb_jours.$model)  ) 
            this.submitStatus = true
            if (this.$v.$invalid) {
                //this.submitStatus = 'ERROR'
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
                        const post = (is_action == 'add') ? 'ajouter-assurance-adherent' : 'modifier-assurance-adherent';

                        //this.submitStatus = 'PENDING'
                        this.formData = new FormData();
                        //### Informations personnelle
                         
                        this.formData.append('assurance[id_adherent]', this.info_adherent.id); 
                        this.formData.append('assurance[date_assuree]', this.$v.assurance.date_assuree.$model.toDateString());

                         this.formData.append('assurance[typeassurance]', parseInt(this.$v.assurance.typeassurance.$model));

                                this.formData.append('assurance[prix_assurance]', parseFloat(this.$v.assurance.typeassurance.$model.prix).toFixed(2));
                                this.formData.append('assurance[duree_assurance]', parseInt(this.$v.assurance.typeassurance.$model.nb_mois));

                        if (is_action == 'edit') {
                            this.formData.append('assurance[assurance_id]', this.assurance_id); 
                        }
                        const config = { headers: { 'content-type': 'multipart/form-data' } }
                        axios.post('/api-admin/adherents/' + post, this.formData, config).then(res => {
                                switch(res.data.etat) {
                                    case "has_assurance" : 
                                        this.AlertResponseFalse("", "Has assurance" , "warning"); 
                                        break
                                    case "adherent_not_found":
                                        this.AlertResponseFalse("", "Adhérent n'existe pas", "warning");
                                        break;
                                    case "assurance_not_found":
                                        this.AlertResponseFalse("", "assurance n'existe pas", "warning");
                                        break;
                                    default :  
                                        const _text = (this.action == 'add') ? this.$t('content.alerts.ajout.success') : this.$t('content.alerts.modification.success')  ; 

                                        this.AlertResponseTrue("",  _text , "success"); 
                                        
                                        $('.modal').modal('hide');
                                        if (is_action == 'add') {
                                            window.location.reload();
                                            //this.$emit('RefreshListAssurance', res.data.etat);
                                        }
                                        else
                                            this.eventAssuranceAdherent.$emit('update', { "assurance": res.data.etat, "index": this.assurance_index })


                                        $('.titre-add-edit').text(this.$t('content.bouton.ajout'))
                                        
                                        this.matricule = null
                                        this.action = 'add'
                                        this.$v.assurance.date_assuree.$model = new Date()
                                        //this.$v.assurance.duree_assurance.$model = null
                                        this.$v.assurance.prix_assurance.$model = 0.00
                                        this.$v.assurance.typeassurance.$model = null
                                        this.info_adherent = [] 
                                        this.assurance_index = null;
                                        this.assurance_id = null
                                        this.submitStatus = false
                                        this.$v.$reset()


                                        break;   
                                }

                            }).catch(e => {})
                            .finally(f => {
                                setTimeout(() => {
                                    //this.submitStatus = 'OK'
                                }, 500)
                            })
                        }
                    })
            }
        }
    },
    created: function() {
        this.eventAssuranceAdherent.$on('edit', data => {
            this.action = 'edit' 
            this.$v.assurance.date_assuree.$model = new Date(data.adherent.latest_assurance.date_assuree)
           // this.$v.assurance.duree_assurance.$model = data.assurance
            this.$v.assurance.prix_assurance.$model = data.adherent.latest_assurance.prix
            //this.$v.assurance.typeassurance.$model = data.assurance.date_fin
            this.info_adherent = data.adherent ; //.latest_assurance.adherent
            this.assurance_id = data.adherent.latest_assurance.id
            this.if_has_assurance = data.adherent.latest_assurance
            //this.info_adherent = [] 
            this.assurance_index = data.index;
            this.matricule = data.adherent.code_client
            $('.titre-add-edit').text(this.$t('content.bouton.modifier')) 
        })
        this.eventAssuranceAdherent.$on('empty', data => {
            this.action = 'add'
            this.$v.assurance.date_assuree.$model = new Date()
            //this.$v.assurance.duree_assurance.$model = null
            this.$v.assurance.prix_assurance.$model = 0.00
            this.$v.assurance.typeassurance.$model = null
            this.info_adherent = [] 
            this.assurance_index = null;
            this.assurance_id = null
            this.if_has_assurance = []
            $('.titre-add-edit').text(this.$t('content.bouton.ajout'))
        })
    },
    beforeMount() { 
        if (this.$can('Ajouter une assurance')) 
            this.ListAssurances();
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
