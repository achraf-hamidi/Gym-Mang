<template>
    <div v-if="$can('Modifier les mots de passe des utilisateurs') || $can('Modifier le mot de passe personnel')" class="modal fade change-password" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="card-header ">
                    <div class="row">
                        <div class="col-md-11">
                            <div class="d-flex justify-content-between">
                                <h3 class="card-title mb-0"> 
                                    Modifier le mot de passe
                                </h3>
                            </div>
                        </div>
                        <div class="col-1">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="modal-body grid-margin modal-utilisateur ">
                    <div class="row">
                        <div class="col-md-6">
                            Nom : {{ nom }}
                        </div>
                        <div class="col-md-6">
                            Email : {{ email }}
                        </div> 
                    </div>
                    <form-wizard @on-complete="submit($event)" title="" subtitle="" shape="circle" :back-button-text="$t('content.bouton.prev')" :next-button-text="$t('content.bouton.next')" :finish-button-text="$t('content.bouton.enregistrer')" color="#ff9c00e6">
                        <tab-content :title="$t('content.pages.adherents.add_modale.steps.infos')" icon="far fa-user">
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group mr-b-0em" :class="{ 'form-group--error': $v.utilisateur.password.$error }">
                                        <label class="form__label">Mot de passe </label>
                                        <input class="form-control" v-model.trim="$v.utilisateur.password.$model" @input="setpassword($event.target.value)" placeholder="Mot de passe" />
                                    </div>
                                    <div v-if="$v.utilisateur.password.$dirty">
                                        <div class="error" v-if="!$v.utilisateur.password.required && submitStatus == true ">
                                            {{ $t('validation.required', { attribute : 'Mot de passe' }) }}
                                        </div>
                                        <div class="error" v-if="!$v.utilisateur.password.minLength">
                                             Le mot de passe doit contenir plus de 6 caractère 
                                        </div>
                                    </div>
                                </div> 
                                <div class="col-6">
                                    <div class="form-group mr-b-0em" :class="{ 'form-group--error': $v.utilisateur.confirmpassword.$error }">
                                        <label class="form__label">Confirmation de mot de passe</label>
                                        <input class="form-control" v-model.trim="$v.utilisateur.confirmpassword.$model" @input="setconfirmpassword($event.target.value)" placeholder="Confirmation de mot de passe" />
                                    </div>
                                    <div v-if="$v.utilisateur.confirmpassword.$dirty">
                                        <div class="error" v-if="!$v.utilisateur.confirmpassword.required && submitStatus == true ">
                                            {{ $t('validation.required', { attribute : 'Confirmation de mot de passe' }) }}
                                        </div>
                                        <div class="error" v-if="!$v.utilisateur.confirmpassword.minLength">
                                            le mot de passe doit contenir plus de 6 caractère 
                                        </div>
                                        <div class="error" v-if="!$v.utilisateur.confirmpassword.confirmPass">
                                            les mots de passe entrés ne sont pas identiques
                                        </div>
                                    </div>
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
    //props : ['packs', 'abonnements'],
    data() {
        return {
            utilisateur: {
                id_utilisateur: '',
                password : '',
                confirmpassword : ''
            },
            formData: {},
            submitStatus: false, 
            nom : '',
            email : '',
         }
    },
    validations() {
        return {
            utilisateur: {
                id_utilisateur: {
                    required
                },
                password: {
                    required,
                    minLength: minLength(6)
                },
                confirmpassword: {
                    required,
                    minLength: minLength(6),
                    async confirmPass(value) {
                        if (value == this.$v.utilisateur.password.$model ) 
                            return true
                    }
                },
                
            }
        }

    },
    methods: {
        setid_utilisateur(value) {
            console.log(value)
            this.utilisateur.id_utilisateur = value
            this.$v.utilisateur.id_utilisateur.$touch()
        },
        setpassword(value) {
            console.log(value)
            this.utilisateur.password = value
            this.$v.utilisateur.password.$touch()
        },
        setconfirmpassword(value) {
            console.log(value)
            this.utilisateur.confirmpassword = value
            this.$v.utilisateur.confirmpassword.$touch()
        },
         
        submit(event) {
            this.$v.$touch()
            console.log(this.$v.$invalid)
            this.submitStatus = true
            if (this.$v.$invalid) {
                //this.submitStatus = 'ERROR'
            } else {
                this.$fire(
                    this.AlertFire('modifier_password')
                ).then((result) => {
                    if (result.value) {

                        //this.submitStatus = 'PENDING'
                        this.formData = new FormData();
                        //### Informations personnelle
                        this.formData.append('utilisateur[id_utilisateur]', this.$v.utilisateur.id_utilisateur.$model);
                        this.formData.append('utilisateur[password]', this.$v.utilisateur.password.$model); 
                        this.formData.append('utilisateur[confirmpassword]', this.$v.utilisateur.confirmpassword.$model); 

                        const config = { headers: { 'content-type': 'multipart/form-data' } }
                        axios.post('/api-admin/utilisateurs/change-password', this.formData, config).then(res => { 
                                    if (res.data.type =="warning") {
                                        this.AlertResponseFalse("", res.data.message  , "warning");
                                    }else{
                                        $('.bd-example-modal-lg').modal('hide');
                                         this.AlertResponseTrue("", res.data.message, "success");
                                        this.$v.utilisateur.id_utilisateur.$model = null
                                        this.$v.utilisateur.confirmpassword.$model = null
                                        this.$v.utilisateur.password.$model = null
                                        this.submitStatus = false
                                        this.$v.$reset() 
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
        this.eventUtilisateurs.$on('change-password', data => {
             this.$v.utilisateur.id_utilisateur.$model = data.utilisateur.id 
             this.nom = data.utilisateur.name
            this.email = data.utilisateur.email

             console.log(data.utilisateur.code_client)

            $('.btn-add-edit').text(this.$t('content.bouton.modifier'))
        });

        this.eventUtilisateurs.$on('clear', data => {
            this.$v.utilisateur.id_utilisateur.$model = null
            this.$v.utilisateur.confirmpassword.$model = null
            this.$v.utilisateur.password.$model = null
            this.nom = null
            this.email = null
             $('.btn-add-edit').text(this.$t('content.bouton.modifier'))
        })
    },
    computed: {
        /*text_valide() {
            return (this.is_valide == true) ? 'Bloqué' : 'Validé'
        }*/
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


.invioce-utilisateur {
    margin-top: 25px;
}

.invioce-utilisateur p {
    margin-bottom: 0rem ! important;
}

.invioce-utilisateur p span {
    font-weight: bold;
}

</style>
