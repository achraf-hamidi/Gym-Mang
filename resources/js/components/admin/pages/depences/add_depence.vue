<template>
    <div v-if="$can('Ajouter une dépense') || $can('Modifier une dépense')" class="hide-headr-wizad modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="card-header ">
                    <div class="row">
                        <div class="col-md-11">
                            <div class="d-flex justify-content-between">
                                <h3 v-if="action == 'add'" class="card-title mb-0"> 
                                    Ajouter une dépense
                                </h3>
                                <h3 v-else class="card-title mb-0"> 
                                    Modifier une dépense
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
                    <form-wizard @on-complete="submit($event, action)" title="" subtitle="" shape="circle" :back-button-text="$t('content.bouton.prev')" :next-button-text="$t('content.bouton.next')" :finish-button-text="$t('content.bouton.enregistrer')" color="#ff9c00e6">
                        <tab-content :title="$t('content.pages.adherents.add_modale.steps.infos')" icon="far fa-user">
                            <div class="row">   
                                <div class="col-md-12">
                                    <div class="form-group mr-b-0em" :class="{ 'form-group--error': $v.depence.nom.$error }">
                                        <label class="form__label">Nom</label>
                                        <input class="form-control" v-model.trim="$v.depence.nom.$model" @input="setnom($event.target.value)" placeholder="Nom" />
                                    </div> 
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mr-b-0em">
                                        <label class="form__label"> Catégorie </label>
                                        <multiselect v-model.trim="$v.depence.categorie.$model" @input="setcategorie($event)"    :options="Categories" :custom-label="libeleNomCategorie" placeholder="Rechercher" label="id" track-by="id"  ></multiselect>
                                    </div>
                                    <div v-if="$v.depence.categorie.$dirty">
                                        <div class="error" v-if="!$v.depence.categorie.required && submitStatus == true ">{{ $t('validation.required', { attribute : 'Catégorie' }) }}</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mr-b-0em">
                                        <label class="form__label"> Dépense </label>
                                        <multiselect v-model.trim="$v.depence.servicetypedepence.$model" @input="setservicetypedepence($event)" :options="optionServices" :custom-label="libeleServices" placeholder="Rechercher" label="id_service" track-by="id_service"  ></multiselect>
                                    </div>
                                    <div v-if="$v.depence.servicetypedepence.$dirty">
                                        <div class="error" v-if="!$v.depence.servicetypedepence.required && submitStatus == true ">{{ $t('validation.required', { attribute : 'Dépense' }) }}</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mr-b-0em" :class="{ 'form-group--error': $v.depence.montant.$error }">
                                        <label class="form__label">Montant de la dépense</label>
                                        <input class="form-control" v-model.trim="$v.depence.montant.$model" @input="setmontant($event.target.value)" placeholder="Montant de la dépense" />
                                    </div> 
                                    <div v-if="$v.depence.montant.$dirty">
                                        <div class="error" v-if="!$v.depence.montant.required && submitStatus == true ">{{ $t('validation.required', { attribute : 'Montant de la dépense' }) }}</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mr-b-0em" :class="{ 'form-group--error': $v.depence.montant_paye.$error }">
                                        <label class="form__label">Montant payé</label>
                                        <input class="form-control" v-model.trim="$v.depence.montant_paye.$model" @input="setmontant_paye($event.target.value)" placeholder="Montant payé" />
                                    </div> 
                                </div> 
                                <div class="col-md-12">
                                    <div class="form-group mr-b-0em" :class="{ 'form-group--error': $v.depence.date_paiement.$error }">
                                        <label class="form__label">Date de paiement</label>
                                        <date-picker format="DD/MM/YYYY HH:mm" style="width : 100%;" v-model.trim="$v.depence.date_paiement.$model" @change="setdate_paiement" type="datetime"></date-picker>
                                    </div>
                                    <div v-if="$v.depence.date_paiement.$dirty">
                                        <div class="error" v-if="!$v.depence.date_paiement.required && submitStatus == true ">{{ $t('validation.required', { attribute : 'Date de paiement' }) }}</div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group mr-b-0em" :class="{ 'form-group--error': $v.depence.note.$error }">
                                        <label class="form__label">Note</label>
                                        <textarea rows="3" class="form-control" v-model.trim="$v.depence.note.$model" @input="setnote($event.target.value)" placeholder="Note" >
                                        </textarea>
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
    props : ['ServicesTypeDepence', 'Categories'],
    data() {
        return {
            depence: {
                nom : null,
                matricule : '', 
                servicetypedepence : '', 
                montant : '', 
                montant_paye : '', 
                date_paiement : new Date(),
                note : '',
                categorie : ''
            },
            formData: {},
            submitStatus: false,
            action: 'add',
            depence_id: null,
             depence_index: null,
            depences : [],
            optionServices : []
        }
    },
    validations() {
        return {
            depence: {
                nom :{

                },
                matricule: { 
                }, 
                servicetypedepence: {
                    required
                 },

                categorie: {
                    required
                 },
                montant: {
                    required,
                    decimal
                },
                 montant_paye: {
                    decimal
                },
                date_paiement: {
                    required
                },
                note: {
                    //required
                }, 
            }
        }

    },
    methods: {

         libeleNomCategorie({ nom }) {
            return `${nom}`
        },
        libeleServices({ nom_service, prix_service }) {
            return `${nom_service}, Prix : ${prix_service} Dh `
        },
        /*Listdepences() {
            axios.get('/api-admin/services-type-depence').then((response) => {
                this.depences = response.data;
                console.log(this.depences)
            });
        },*/

         setnom(value) {
            console.log(value)
            this.depence.nom = value
            this.$v.depence.nom.$touch()
        },
        setmatricule(value) {
            console.log(value)
            this.depence.matricule = value
            this.$v.depence.matricule.$touch()
        },
        setcategorie(value) {
            //console.log(value)
            this.depence.categorie = value
            this.$v.depence.categorie.$touch() 

            this.optionServices = []
            if (this.depence.categorie != null) {
                this.optionServices = this.ServicesTypeDepence; 
                this.optionServices = this.optionServices.filter(service => {
                     return   service.id_categorie == this.depence.categorie.id 
                })
            }

        },

        setservicetypedepence(value) {
            console.log(value)
            this.depence.servicetypedepence = value
            this.$v.depence.servicetypedepence.$touch()
            this.depence.montant = value.prix_service
        },
        setmontant(value) {
            console.log(value)
            this.depence.montant = value
            this.$v.depence.montant.$touch()
        },
        setmontant_paye(value) {
            console.log(value)
            this.depence.montant_paye = value
            this.$v.depence.montant_paye.$touch()
        },
        setdate_paiement(value) {
            console.log(value)
            this.depence.date_paiement = value
            this.$v.depence.date_paiement.$touch()
        },
        setnote(value) {
            console.log(value)
            this.depence.note = value
            this.$v.depence.note.$touch()
        },

        submit(event, is_action) {
            this.$v.$touch()
            console.log(this.$v.$invalid)
            this.submitStatus = true
            if (this.$v.$invalid) {
                //this.submitStatus = 'ERROR'
            } else {
                this.$fire(
                    this.AlertFire(is_action)
                ).then((result) => {
                    if (result.value) {
                        const post = (is_action == 'add') ? 'store' : 'update';

                        //this.submitStatus = 'PENDING'
                        this.formData = new FormData();
                        //### Informations personnelle
                        //console.log(this.$v.depence.matricule.$model)
                        //this.formData.append('depence[matricule]', this.$v.depence.matricule.$model);
                        if (this.$v.depence.nom.$model != null && this.$v.depence.nom.$model != '') {
                            this.formData.append('depence[nom]', this.$v.depence.nom.$model);
                        }

                        this.formData.append('depence[id_service]', this.$v.depence.servicetypedepence.$model.id_service);
                        this.formData.append('depence[montant]', this.$v.depence.montant.$model);
                        this.formData.append('depence[note]', this.$v.depence.note.$model);
                        
                        if ( this.$v.depence.montant_paye.$model ) {
                            this.formData.append('depence[date_paiement]', this.$v.depence.date_paiement.$model.toLocaleDateString()  );
                            this.formData.append('depence[time_paiement]', this.$v.depence.date_paiement.$model.toLocaleTimeString()  ); 
                            this.formData.append('depence[montant_paye]', this.$v.depence.montant_paye.$model);
                        }
                       
                        if (is_action == 'edit') {
                            this.formData.append('depence_id', this.depence_id);
                         }
                        const config = { headers: { 'content-type': 'multipart/form-data' } }
                        axios.post('/api-admin/depence/' + post, this.formData, config).then(res => {
                                switch (res.data) {
                                    case false:
                                        this.AlertResponseFalse("", this.$t('content.alerts.utilisateur.n_existe'), "warning");
                                        break;
                                    default:
                                        const _text = (this.action == 'add') ? this.$t('content.alerts.ajout.success') : this.$t('content.alerts.modification.success');

                                        this.AlertResponseTrue("", _text, "success");

                                        if (is_action == 'add')
                                            this.$emit('RefreshListDepences', res.data.depence);
                                        else
                                            this.eventDepences.$emit('update', { "depence": res.data.depence, "index": this.depence_index })


                                        $('.bd-example-modal-lg').modal('hide');

                                        this.$v.depence.nom.$model = null
                                        this.$v.depence.matricule.$model = null
                                        this.$v.depence.servicetypedepence.$model = null
                                        this.$v.depence.montant.$model = null
                                        this.$v.depence.montant_paye.$model = null 
                                        this.$v.depence.date_paiement.$model = null 
                                        this.$v.$reset()
                                        this.action = 'add'
                                         this.depence_id = null
                                        this.depence_index = null
                                        this.submitStatus = false
                                        $('.btn-add-edit').text(this.$t('content.bouton.ajout'))

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
     beforeMount() {
        //this.Listdepences(); 
        console.log(new Date())
        this.depence.date_paiement = new Date()
        this.optionServices = this.ServicesTypeDepence;
        
    },
    created: function() {
        this.eventDepences.$on('edit', data => {
            this.action = 'edit'

            console.log(data.depence.id) 

            //this.$v.depence.servicetypedepence.$model = data.depence.id
            this.$v.depence.montant.$model = data.depence.montant
            //this.$v.depence.montant_paye.$model = data.depence.montant_paye

            this.depence_id = data.depence.id
             this.depence_index = data.index
            $('.btn-add-edit').text(this.$t('content.bouton.modifier'))
        });

        this.eventDepences.$on('clear', data => {
            this.action = 'add'
             this.$v.depence.servicetypedepence.$model = null 
            this.$v.depence.montant.$model = null  
            this.$v.depence.montant_paye.$model = null  
            this.$v.depence.date_paiement.$model = new Date()  

            this.depence_id = null //data.depence.id
             this.depence_index = null //data.index
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
