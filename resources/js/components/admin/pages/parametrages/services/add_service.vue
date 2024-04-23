<template>
    <div  v-if="$can('Ajouter un service') || $can('Modifier un service')"  class="col-md-4 grid-margin stretch-card">
        <div class="card">
            <div class="card-header ">
                <div class="row">
                    <div class="col-md-12">
                        <h3 v-if="action == 'add'">Ajouter un service</h3>
                        <h3 v-else>Modifier un service</h3>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <br>
                <form @submit.prevent="submit($event, action)" class="forms-sample">
                    <!--<div class="form-group">
                    <label for="descriptionservice">{{ $t('content.pages.categories.service.description') }}</label>
                    <input type="email" class="form-control" id="descriptionservice" :placeholder="$t('content.pages.categories.service.desc_placeholder')">
                  </div>-->
                    <div class="form-group mr-b-0em" :class="{ 'form-group--error': $v.nom.$error }">
                        <label class="form__label">Nom : </label>
                        <input class="form-control" v-model.trim="$v.nom.$model" @input="setnom($event.target.value)" placeholder="Nom" />
                    </div>
                    <div v-if="$v.nom.$dirty">
                        <div class="error" v-if="!$v.nom.required && submitStatus == true ">
                            {{ $t('validation.required', { attribute : 'Nom est obligatoire' }) }}
                        </div>
                        <div class="error" v-if="!$v.nom.minLength">
                            {{ $t('validation.min.numeric', { attribute : 'nom' , min : $v.nom.$params.minLength.min }) }}
                        </div>
                    </div>

                    <div class="form-group mr-b-0em" :class="{ 'form-group--error': $v.description.$error }">
                        <label class="form__label">Description : </label>
                        <input class="form-control" v-model.trim="$v.description.$model" @input="setdescription($event.target.value)" placeholder="Description" />
                    </div>
                    <div v-if="$v.description.$dirty"> 
                        <div class="error" v-if="!$v.description.minLength">
                            {{ $t('validation.min.numeric', { attribute : 'Description' , min : $v.description.$params.minLength.min }) }}
                        </div>
                    </div>

                    <div class="form-group mr-b-0em" :class="{ 'form-group--error': $v.prix.$error }">
                        <label class="form__label">Prix : </label>
                        <input class="form-control" v-model.trim="$v.prix.$model" @input="setprix($event.target.value)" placeholder="Prix" />
                    </div>
                    <div v-if="$v.prix.$dirty">
                        <div class="error" v-if="!$v.prix.required && submitStatus == true ">{{ $t('validation.required', { attribute : 'Prix est obligatoire' }) }}</div>
                        <div class="error" v-if="!$v.prix.decimal">
                            {{ $t('validation.numeric', { attribute : $t('content.pages.parametrages.service_categories.services.nouveau.inputs.prix.titre') }) }}
                        </div>
                    </div>
                    <div class="form-group mr-b-0em"  >
                        <label class="form__label">Catégories : </label>
                         
                        <multiselect v-model.trim="$v.categorie_id.$model" @input="setcategorie_id($event)" :options="options_categories" :custom-label="NomCategorie" placeholder="Recherche.." label="nom" track-by="nom"></multiselect>


                    </div>

                    <div class="col-12 text-right">
                        <button type="submit" class="btn-add-edit btn btn-primary mr-2"> <i class=" mdi mdi-plus"></i> {{ $t('content.bouton.ajout') }}</button>
                        <a @click="clearDataInputs" href="javascript:void(0)" class="btn btn-light">{{ $t('content.bouton.annuler') }}</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>
<script>
import { required, minLength, numeric, decimal, between, maxLength, email } from 'vuelidate/lib/validators'
export default {
    props: ['options_categories', 'services'],
    data() {
        return {
            nom: '',
            description: '',
            prix: '',
            categorie_id : '',
            formData: {},
            submitStatus: false,
             arr: [],
            action: 'add',
            service_id: null,
            service_index: null,



        }
    },
    validations: { 
        nom: {
            required,
            minLength: minLength(3)
        },
        description: {
             minLength: minLength(3)
        },
        prix: {
            required,
            decimal
        }, 
        categorie_id : {

        }
    },
    methods: {
        NomCategorie({ nom, type_id }) {
            if (type_id == 1)   
                var type = 'Recettes'
            else if(type_id == 2 )
                var type = 'Dépenses'
            return `${nom} ( ${type }) `
        }, 


        setnom(value) {
            this.nom = value
            this.$v.nom.$touch()
        },
        setdescription(value) {
            this.description = value
            this.$v.description.$touch()
        },
        setprix(value) {
            this.prix = value
            this.$v.prix.$touch()
        },
        setcategorie_id(value) {
            this.categorie_id = value
            this.$v.categorie_id.$touch()
        },


        submit(event, is_action) {
            this.$v.$touch()
            this.submitStatus = true
            if (this.$v.$invalid) {
                //this.submitStatus = 'ERROR'
            } else {
                const post = (is_action == 'add') ? 'store-service' : 'update-service';

                //this.submitStatus = 'PENDING'
                this.formData = new FormData();
                this.formData.append('nom', this.$v.nom.$model);
                
                if (this.$v.description.$model != '' && this.$v.description.$model != null && this.$v.description.$model != 'null') {
                    console.log(this.$v.description.$model)
                    this.formData.append('description', this.$v.description.$model); 
                }
                
                this.formData.append('prix', this.$v.prix.$model);
                this.formData.append('categorie_id', this.$v.categorie_id.$model.id);
              
                if (is_action == 'edit')
                    this.formData.append('service_id', this.service_id);

                const config = { headers: { 'content-type': 'multipart/form-data' } } 

                axios.post('/api-admin/parametrages/' + post, this.formData, config).then(res => {
                        if (is_action == 'add')
                            this.$emit('RefreshlistServices', res.data);
                        else
                            this.eventservices.$emit('update', { "service": res.data, "index": this.service_index })

                        this.clearDataInputs()
                        this.$v.$reset()

                        this.action = 'add'
                        this.service_id = null
                        this.service_index = null
                        this.submitStatus = false
                        $('.btn-add-edit').text(this.$t('content.bouton.ajout'))

                    }).catch(e => {})
                    .finally(f => {
                        setTimeout(() => {
                            //this.submitStatus = 'OK'
                        }, 500)
                    }) 


            }
        },
        clearDataInputs() {
            if (this.action == 'edit')
                this.action = "add"

            this.$v.nom.$model = null
            this.$v.description.$model = null
            this.$v.prix.$model = null
             $('.btn-add-edit').text(this.$t('content.bouton.ajout'))
        }
    },
    created: function() {
        this.eventservices.$on('edit', data => {
             this.action = 'edit'
            this.$v.nom.$model = data.service.nom
            this.$v.description.$model = data.service.description
            this.$v.prix.$model = data.service.prix
            this.$v.categorie_id.$model = data.service.categorie 

            this.service_id = data.service.id
            this.service_index = data.index
            $('.btn-add-edit').text(this.$t('content.bouton.modifier'))
        })
    },
    beforeMount() {}
}

</script>
<style src='vue-multiselect/dist/vue-multiselect.min.css'></style>
