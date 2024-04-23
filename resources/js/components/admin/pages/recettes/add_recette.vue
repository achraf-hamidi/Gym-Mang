<template>
    <div v-if="$can('Ajouter une recette') || $can('Modifier une recette')" class=" hide-headr-wizad modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="card-header ">
                    <div class="row">
                        <div class="col-md-11">
                            <div class="d-flex justify-content-between">
                                <h3 v-if="action == 'add'" class="card-title mb-0"> 
                                    Ajouter une recette
                                </h3>
                                <h3 v-else class="card-title mb-0"> 
                                    Modifier une recette
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
                                <div class="col-12">
                                    <div class="row"> 
                                         <div class="col-12">
                                            <div class="form-check form-check-flat">
                                                <label class="form-check-label">
                                                    <input type="checkbox" @click="disabledButtonSuivant"  class="form-check-input" v-model="is_adherent">  Client interne   <i class="input-helper"></i></label>
                                            </div><br>
                                        </div>
                                    </div>
                                </div>
                                 <div v-if="is_adherent" class="col-12">
                                    <div class="row"> 
                                        <div  class="col-md-12">
                                            <label class="form__label">ID </label>
                                            <div class="form-group mr-b-0em" :class="{ 'form-group--error': $v.recette.matricule.$error }">
                                                <div class="recette-check-adherent row">
                                                    <div class="col-md-9">
                                                        <input @keyup.enter="CheckAdherentIsExiste"   class="form-control" v-model.trim="$v.recette.matricule.$model" @input="setmatricule($event.target.value)" placeholder="ID / CIN" />
                                                    </div>
                                                    <div class="col-md-3">
                                                        
                                                <button style="width : 100%;" type="button" @click="CheckAdherentIsExiste"  class="btn btn-primary mr-2">Vérifier l'adhérent</button>
                                                    </div>
                                                </div>
                                            </div> 
                                        </div> 
                                    </div>
                                </div>
                                 <div v-if="!is_adherent" class="col-12">
                                    <div class="row"> 
                                        <div   class="col-md-12">
                                            <div class="form-group mr-b-0em" :class="{ 'form-group--error': $v.recette.nom.$error }">
                                                <label class="form__label">Nom et prénom</label>
                                                <input class="form-control" v-model.trim="$v.recette.nom.$model" @input="setnom($event.target.value)" placeholder="Nom et prénom" />
                                            </div> 
                                        </div>
                                    </div>
                                </div>

                                <div v-if="adherent_existe" class="col-12">
                                    <div class="row"> 
                                    <div class="col-md-6">
                                        <div class="form-group mr-b-0em">
                                            <label class="form__label"> Catégorie </label>
                                            <multiselect v-model.trim="$v.recette.categorie.$model" @input="setcategorie($event)"    :options="Categories" :custom-label="libeleNomCategorie" placeholder="Rechercher" label="id" track-by="id"  ></multiselect>
                                        </div>
                                        <div v-if="$v.recette.categorie.$dirty">
                                            <div class="error" v-if="!$v.recette.categorie.required && submitStatus == true">{{ $t('validation.required', { attribute : 'Catégorie' }) }}</div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group mr-b-0em">
                                            <label class="form__label"> Recette </label>
                                            <multiselect v-model.trim="$v.recette.servicetypercette.$model" @input="setservicetypercette($event)" :options="optionServices" :custom-label="libeleServices" placeholder="Rechercher" label="id_service" track-by="id_service"  ></multiselect>
                                        </div>
                                        <div v-if="$v.recette.servicetypercette.$dirty">
                                            <div class="error" v-if="!$v.recette.servicetypercette.required && submitStatus == true">{{ $t('validation.required', { attribute : 'recette' }) }}</div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group mr-b-0em" :class="{ 'form-group--error': $v.recette.montant.$error }">
                                            <label class="form__label">Montant de la recette</label>
                                            <input class="form-control" v-model.trim="$v.recette.montant.$model" @input="setmontant($event.target.value)" placeholder="Montant de la recette" />
                                        </div> 
                                        <div v-if="$v.recette.montant.$dirty">
                                            <div class="error" v-if="!$v.recette.montant.required && submitStatus == true">{{ $t('validation.required', { attribute : 'Montant de la recette' }) }}</div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group mr-b-0em" :class="{ 'form-group--error': $v.recette.montant_paye.$error }">
                                            <label class="form__label">Montant payé</label>
                                            <input class="form-control" v-model.trim="$v.recette.montant_paye.$model" @input="setmontant_paye($event.target.value)" placeholder="Montant payé" />
                                        </div> 
                                    </div> 
                                    <div class="col-md-4">
                                        <div class="form-group mr-b-0em" :class="{ 'form-group--error': $v.recette.date_paiement.$error }">
                                            <label class="form__label">Date de paiement</label>
                                            <date-picker  format="DD/MM/YYYY HH:mm" style="width : 100%;" v-model.trim="$v.recette.date_paiement.$model" @change="setdate_paiement" type="datetime"></date-picker>
                                        </div>
                                        <div v-if="$v.recette.date_paiement.$dirty">
                                            <div class="error" v-if="!$v.recette.date_paiement.required && submitStatus == true">{{ $t('validation.required', { attribute : 'Date de paiement' }) }}</div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group mr-b-0em" :class="{ 'form-group--error': $v.recette.note.$error }">
                                            <label class="form__label">Note</label>
                                            <textarea rows="3" class="form-control" v-model.trim="$v.recette.note.$model" @input="setnote($event.target.value)" placeholder="Note" >
                                            </textarea> 
                                        </div> 
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
    props : ['ServicesTypeRecette', 'Categories'],
    data() {
        return {
            is_adherent : false,
            adherent_existe : true,
            recette: {
                matricule : '', 
                id_empreinte : '', 
                nom : '',
                servicetypercette : '', 
                categorie : '',
                montant : '', 
                montant_paye : '', 
                date_paiement : new Date(),
                note : ''
            },
            formData: {},
            submitStatus: false,
            action: 'add',
            recette_id: null,
            recette_index: null,
            recettes : [],
            optionServices : []
        }
    },
    validations() {
        return {
            recette: {
                matricule: { 
                }, 
                id_empreinte : {

                }, 
                nom : {

                },
                servicetypercette: {
                    required
                 },
                 categorie : {
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
                note : {

                }
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
        /*ListRecettes() {
            axios.get('/api-admin/services-type-recette').then((response) => {
                this.recettes = response.data;
                console.log(this.recettes)
            });
        },*/

        setmatricule(value) {
            console.log(value)
            this.recette.matricule = value
            this.recette.id_empriente = value
            this.$v.recette.matricule.$touch()
            this.$v.recette.id_empriente.$touch()
        },
        setnom(value) {
            console.log(value)
            this.recette.nom = value
            this.$v.recette.nom.$touch()
        },
        setservicetypercette(value) {
            //console.log(value)
            this.recette.servicetypercette = value
            this.$v.recette.servicetypercette.$touch()
            this.recette.montant = value.prix_service
        },
        setcategorie(value) {
            //console.log(value)
            this.recette.categorie = value
            this.$v.recette.categorie.$touch() 
            this.optionServices = []
            if (this.recette.categorie != null) {
                this.optionServices = this.ServicesTypeRecette; 
                this.optionServices = this.optionServices.filter(service => {
                     return   service.id_categorie == this.recette.categorie.id 
                })
            }

        },
        setmontant(value) {
            console.log(value)
            this.recette.montant = value
            this.$v.recette.montant.$touch()
        },
        setmontant_paye(value) {
            console.log(value)
            this.recette.montant_paye = value
            this.$v.recette.montant_paye.$touch()
        },
        setdate_paiement(value) {
            console.log(value)
            this.recette.date_paiement = value
            this.$v.recette.date_paiement.$touch()
        },
        setnote(value) {
            console.log(value)
            this.recette.note = value
            this.$v.recette.note.$touch()
        },
         
        disabledButtonSuivant(){
            if (this.is_adherent) {
                this.adherent_existe = true
                $('.wizard-footer-right .wizard-btn').prop("disabled",false);
            }else {
                this.adherent_existe = false
                $('.wizard-footer-right .wizard-btn').prop("disabled",true);
            }
         }, 
        CheckAdherentIsExiste() {
            if (this.$v.recette.matricule.$model != '' && this.$v.recette.matricule.$model != null) {
                 this.formData = new FormData();
                 this.formData.append('code_client', this.$v.recette.matricule.$model);
                 this.formData.append('id_empreinte', this.$v.recette.matricule.$model);

                const config = { headers: { 'content-type': 'multipart/form-data' } }   
                // /api-admin/adherent/check-adherent-is-existe
                // /api-admin/get-information-adherent'
                axios.post('/api-admin/get-information-adherent', this.formData, config).then(res => {
                    if (res.data.adherent != null) {
                        const adherent = res.data.adherent
                            const information_adherents = "<p style='margin-top: 20px; margin-bottom : 0px;'> <b>Matricule</b> : " + adherent.id_empreinte + "</p><br><p style='margin-bottom : 0px;'><b>Nom : </b>" + adherent.nom  + "</p>"

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
                                    console.log("oui")
                                    this.adherent_existe = true
                                    $('.wizard-footer-right .wizard-btn').prop("disabled",false);
                                }else{
                                    console.log("non")
                                    this.adherent_existe = false
                                    $('.wizard-footer-right .wizard-btn').prop("disabled",true);
                                }   
                            })

                    }else{
                        this.adherent_existe = false
                        $('.wizard-footer-right .wizard-btn').prop("disabled",true);
                         this.AlertResponseFalse("", "Cet adhérent n'existe pas", "warning");
                    }                     
                });
            } else{
                this.adherent_existe = false
                $('.wizard-footer-right .wizard-btn').prop("disabled",false);
            }  
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
                        if (this.$v.recette.matricule.$model != '' && this.$v.recette.matricule.$model != null) {
                        console.log(this.$v.recette.matricule.$model)
                        this.formData.append('recette[matricule]', this.$v.recette.matricule.$model);
                    }
                    if(this.$v.recette.nom.$model != null && this.$v.recette.nom.$model != ''){
                        this.formData.append('recette[nom]', this.$v.recette.nom.$model);
                    }
                    
                        this.formData.append('recette[id_service]', this.$v.recette.servicetypercette.$model.id_service);
                        this.formData.append('recette[montant]', this.$v.recette.montant.$model);
                        this.formData.append('recette[note]', this.$v.recette.note.$model);
                        
                        if ( this.$v.recette.montant_paye.$model ) {
                            this.formData.append('recette[date_paiement]', this.$v.recette.date_paiement.$model.toLocaleDateString()  );
                            this.formData.append('recette[time_paiement]', this.$v.recette.date_paiement.$model.toLocaleTimeString()  ); 
                            this.formData.append('recette[montant_paye]', this.$v.recette.montant_paye.$model);
                        }
                       
                        if (is_action == 'edit') {
                            this.formData.append('recette_id', this.recette_id);
                         }
                        const config = { headers: { 'content-type': 'multipart/form-data' } }
                        axios.post('/api-admin/recette/' + post, this.formData, config).then(res => {
                                switch (res.data) {
                                    case false:
                                        this.AlertResponseFalse("", this.$t('content.alerts.utilisateur.n_existe'), "warning");
                                        break;
                                    default:
                                        const _text = (this.action == 'add') ? this.$t('content.alerts.ajout.success') : this.$t('content.alerts.modification.success');

                                        this.AlertResponseTrue("", _text, "success");

                                        if (is_action == 'add')
                                            this.$emit('RefreshListRecettes', res.data.recette);
                                        else
                                            this.eventRecettes.$emit('update', { "recette": res.data.recette, "index": this.recette_index })


                                        $('.bd-example-modal-lg').modal('hide');

                                        this.$v.recette.nom.$model = null
                                        this.$v.recette.matricule.$model = null
                                        this.$v.recette.servicetypercette.$model = null
                                        this.$v.recette.montant.$model = null
                                        this.$v.recette.montant_paye.$model = null 
                                        this.$v.recette.date_paiement.$model = null 
                                        this.$v.$reset()
                                        this.action = 'add'
                                         this.recette_id = null
                                        this.recette_index = null
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
        //this.ListRecettes(); 
        console.log(new Date())
        this.recette.date_paiement = new Date()
        this.optionServices = this.ServicesTypeRecette;
        
    },
    created: function() {
        this.eventRecettes.$on('edit', data => {
            this.action = 'edit'

             if (data.recette.adherent)
                this.$v.recette.matricule.$model = data.recette.adherent.matricule

            //this.$v.recette.servicetypercette.$model = data.recette.id
            this.$v.recette.montant.$model = data.recette.montant
            //this.$v.recette.montant_paye.$model = data.recette.montant_paye

            this.recette_id = data.recette.id
             this.recette_index = data.index
            $('.btn-add-edit').text(this.$t('content.bouton.modifier'))
        });

        this.eventRecettes.$on('clear', data => {
            this.action = 'add'
            this.$v.recette.matricule.$model = null 
            this.$v.recette.servicetypercette.$model = null 
            this.$v.recette.montant.$model = null  
            this.$v.recette.montant_paye.$model = null  
            this.$v.recette.date_paiement.$model = new Date()  
            this.is_adherent = false
            this.recette_id = null //data.recette.id
             this.recette_index = null //data.index
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


@media only screen and (min-width: 470px) and (max-width: 1121px){
    .recette-check-adherent .col-md-9 , .recette-check-adherent .col-md-3 {
        flex :  0 0 50% !important ; 
        max-width: 50% !important ; 
    }

}
@media only screen and (max-width: 469px){
    .recette-check-adherent .col-md-9 , .recette-check-adherent .col-md-3 {
        flex :  0 0 100% !important ; 
        max-width: 100% !important ; 
    }
    .recette-check-adherent .col-md-3 {
        margin-top : 25px !important;
    }

}



</style>
