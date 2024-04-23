<template>
    <div v-if="$can('Ajouter une catégorie') || $can('Modifier une catégorie')" class="col-md-4 grid-margin stretch-card">
        <div class="card">
            <div class="card-header ">
                <div class="row">
                    <div class="col-md-12">
                        <h3 v-if="action == 'add'">Ajouter une catégorie</h3>
                        <h3 v-else>Modifier un catégorie</h3>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <br>
                <form @submit.prevent="submit($event, action)" class="forms-sample">
                    <div class="form-group mr-b-0em" :class="{ 'form-group--error': $v.nom.$error }">
                        <label class="form__label">Nom : </label>
                        <input class="form-control" v-model.trim="$v.nom.$model" @input="setnom($event.target.value)" placeholder="Nom" />
                    </div>
                    <div v-if="$v.nom.$dirty">
                        <div class="error" v-if="!$v.nom.required && submitStatus == true ">{{ $t('validation.required', { attribute : 'Nom est obligatoire' }) }}</div>
                        <div class="error" v-if="!$v.nom.minLength">
                            {{ $t('validation.min.numeric', { attribute : $t('content.pages.parametrages.pack_activities.activities.nouveau.inputs.libelle.titre'), min : $v.nom.$params.minLength.min }) }}
                        </div>
                    </div> 
                    <div class="form-group mr-b-0em" :class="{ 'form-group--error': $v.description.$error }">
                        <label class="form__label">Description : </label>
                        <input class="form-control" v-model.trim="$v.description.$model" @input="setdescription($event.target.value)" placeholder="Description" />
                    </div> 
                     <div class="form-group mr-b-0em">
                        <label class="form__label">Type de catégorie : </label>
                        <select class="form-control"  v-model.trim="$v.type_id.$model" @input="settype_id($event.target.value)">
                             <option value="1">Recette</option>
                            <option value="2">Dépense</option>
                        </select>
                    </div>
                    
                    <div v-if="$v.type_id.$dirty">
                        <div class="error" v-if="!$v.type_id.required && submitStatus == true ">{{ $t('validation.required', { attribute : 'Type est obligatoire' }) }}</div> 
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
import { required, minLength, numeric, between, maxLength, email } from 'vuelidate/lib/validators'
export default {
    props: ['categories'],
    data() {
        return {
            nom: '',
            description: '', 
            type_id : '',
            formData: {},
            submitStatus: false,
            action: 'add',
            categorie_id: null,
            categorie_index: null
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
        type_id: {
            required
        },
    
    },
    methods: {
        setnom(value) {
            this.nom = value
            this.$v.nom.$touch()
        }, 
        setdescription(value) {
            this.description = value
            this.$v.description.$touch()
        }, 
        settype_id(value) {
            this.type_id = value
            this.$v.type_id.$touch()
        }, 
        submit(event, is_action) {
            this.$v.$touch()
            this.submitStatus = true
            if (this.$v.$invalid) {
                //this.submitStatus = 'ERROR'
            } else {
                const post = (is_action == 'add') ? 'store-categorie' : 'update-categorie';
                //this.submitStatus = 'PENDING'
                this.formData = new FormData();
                this.formData.append('nom', this.$v.nom.$model);
                if (this.$v.description.$model != '' && this.$v.description.$model != null && this.$v.description.$model != 'null') {
                    console.log(this.$v.description.$model)
                    this.formData.append('description', this.$v.description.$model); 
                }
                this.formData.append('type_id', this.$v.type_id.$model); 

                if (is_action == 'edit')
                    this.formData.append('categorie_id', this.categorie_id);

                const config = { headers: { 'content-type': 'multipart/form-data' } }
                axios.post('/api-admin/parametrages/' + post, this.formData, config).then(res => {
                        if (is_action == 'add') {
                            console.log(res.data)
                            this.$emit('RefreshListcategories', res.data);
                        }
                        else
                            this.eventcategories.$emit('update', { "categorie": res.data, "index": this.categorie_index })

                        this.clearDataInputs()
                        this.$v.$reset()
                        this.action = 'add'
                        this.categorie_id = null
                        this.categorie_index = null
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

            this.$v.nom.$model = ''
            this.$v.description.$model = ''
            this.$v.type_id.$model = ''
             $('.btn-add-edit').text(this.$t('content.bouton.ajout'))
        }
    },
    created: function() {
        this.eventcategories.$on('edit', data => {
            this.action = 'edit'
            this.$v.nom.$model = data.categorie.nom
            this.$v.description.$model = data.categorie.description
            this.$v.type_id.$model = data.categorie.type_id
            this.categorie_id = data.categorie.id
             this.categorie_index = data.index
            $('.btn-add-edit').text(this.$t('content.bouton.modifier'))
        })
    },
    beforeMount() {

    }
}

</script>
