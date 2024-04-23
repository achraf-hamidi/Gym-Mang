<template>
    <div v-if="$can('Ajouter des frais') || $can('Modifier des frais')" class="col-md-4 grid-margin stretch-card">
        <div class="card">
            <div class="card-header ">
                <div class="row">
                    <div class="col-md-12">
                        <h3 v-if="action=='add'">Ajouter des frais </h3>
                        <h3 v-else>Modifier</h3>
                    </div>
                </div>
            </div>
            <div class="card-body"> <br>
                <form @submit.prevent="submit($event, action)" class="forms-sample">
                    <div class="form-group mr-b-0em" :class="{ 'form-group--error': $v.typefrais.$error }">
                        <label class="form__label">Type de frais : </label>

                        <multiselect v-model.trim="$v.typefrais.$model" @input="settypefrais($event)" :options="list_typefrais" :custom-label="libeleTypeFrais" placeholder="Recherche.." label="libelle" track-by="libelle"></multiselect>
                    </div>
                    <div v-if="$v.typefrais.$dirty">
                        <div class="error" v-if="!$v.typefrais.required && submitStatus == true ">
                            {{ $t('validation.required', { attribute : 'Type de frais' }) }}
                        </div> 
                    </div>

                    <div class="form-group mr-b-0em" :class="{ 'form-group--error': $v.libelle.$error }">
                        <label class="form__label">Nom de frais  : </label>
                        <input class="form-control" v-model.trim="$v.libelle.$model" @input="setlibelle($event.target.value)" placeholder="Nom de frais " />
                    </div>
                    <div v-if="$v.libelle.$dirty">
                        <div class="error" v-if="!$v.libelle.required && submitStatus == true ">
                            {{ $t('validation.required', { attribute : 'Nom de frais ' }) }}
                        </div>
                        <div class="error" v-if="!$v.libelle.minLength">
                            {{ $t('validation.min.numeric', { attribute : 'Nom de frais ', min : $v.libelle.$params.minLength.min }) }}
                        </div>
                    </div>

                    <div v-if="asurance_nb_mois" class="form-group mr-b-0em" :class="{ 'form-group--error': $v.nb_mois.$error }">
                        <label class="form__label">Nombre de mois : </label>
                        <input class="form-control" type="number" v-model.trim="$v.nb_mois.$model" @input="setnb_mois($event.target.value)" placeholder="Nombre de mois" />
                    </div>
                    <div v-if="$v.nb_mois.$dirty">
                        <div class="error" v-if="!$v.nb_mois.required && submitStatus == true ">
                            {{ $t('validation.required', { attribute : 'Nom assurance' }) }}
                        </div>
                        <div class="error" v-if="!$v.nb_mois.numeric">
                            {{ $t('validation.min.numeric', { attribute : 'Nom assurance', min : $v.nb_mois.$params.numeric.min }) }}
                        </div>
                    </div>


                    <div class="form-group mr-b-0em" :class="{ 'form-group--error': $v.prix.$error }">
                        <label class="form__label">Prix : </label>
                        <input class="form-control" v-model.trim="$v.prix.$model" @input="setprix($event.target.value)" placeholder="Prix" />
                    </div>
                    <div v-if="$v.prix.$dirty">
                        <div class="error" v-if="!$v.prix.required && submitStatus == true ">{{ $t('validation.required', { attribute : 'Prix' }) }}</div>
                        <div class="error" v-if="!$v.prix.decimal">
                            {{ $t('validation.numeric', { attribute : 'Prix' }) }}
                        </div>
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
import { required, minLength, numeric, decimal, between, maxLength, email, requiredIf  } from 'vuelidate/lib/validators'
export default {
    props: ['options_activities', 'packs'],
    data() {
        return {
            libelle: '',
            typefrais : [],
            prix: '',
            nb_mois : 0,
            formData: {},
            submitStatus: false,
            arr: [],
            action: 'add',
            assurance_id: null,
            assurance_index: null,
            list_typefrais: [],
            asurance_nb_mois : false
        }
    },
    validations: {
        typefrais : {
            required
        },
        libelle: {
            required,
            minLength: minLength(3)
        },
        prix: {
            required,
            decimal
        },
        nb_mois: {
            required: requiredIf(function() { return this.asurance_nb_mois }),
            numeric
        }
    },
    methods: {
        settypefrais(value){
            if (value.libelle == 'Assurance') {
                this.asurance_nb_mois = true
            }else{
                 this.asurance_nb_mois = false
                 this.$v.nb_mois.$model = 0
            }
            this.typefrais = value
            this.$v.typefrais.$touch()
            console.log(value)
        },
        setlibelle(value) {
            this.libelle = value
            this.$v.libelle.$touch()
        },
        setprix(value) {
            this.prix = value
            this.$v.prix.$touch()
        },
        setnb_mois(value) {
            this.nb_mois = value
            this.$v.nb_mois.$touch()
        },
        submit(event, is_action) {
            this.$v.$touch()
            this.submitStatus = true
            if (this.$v.$invalid) {
                //this.submitStatus = 'ERROR'
            } else {
                const post = (is_action == 'add') ? 'store-assurance' : 'update-assurance';
                //this.submitStatus = 'PENDING'
                this.formData = new FormData();
                this.formData.append('id_typefrais', this.$v.typefrais.$model.id);
                this.formData.append('libelle', this.$v.libelle.$model);
                this.formData.append('prix', this.$v.prix.$model);
                this.formData.append('nb_mois', this.$v.nb_mois.$model);
                if (is_action == 'edit')
                    this.formData.append('assurance_id', this.assurance_id);
                const config = { headers: { 'content-type': 'multipart/form-data' } }
                axios.post('/api-admin/parametrages/' + post, this.formData, config).then(res => {
                        if (is_action == 'add')
                            this.eventTypeassurance.$emit('add', res.data)
                        else
                            this.eventTypeassurance.$emit('update', { "assurance": res.data, "index": this.assurance_index })

                        this.clearDataInputs() 
                        this.$v.$reset()
                        this.action = 'add'
                        this.assurance_id = null
                        this.assurance_index = null
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

            this.$v.libelle.$model = null
            this.$v.prix.$model = null
            this.$v.nb_mois.$model = null
            $('.btn-add-edit').text(this.$t('content.bouton.ajout'))
        },

        libeleTypeFrais({ libelle }) {
            return `${libelle}`
        },

        Gettypefrais(){
            axios.get('/api-admin/parametrages/typefrais').then((response) => {
                this.list_typefrais = response.data.typefrais;
                console.log(this.list_typefrais)
            });
        }

    },
    created: function() {
        this.eventTypeassurance.$on('edit', data => {
            this.action = 'edit'
            this.$v.typefrais.$model = data.assurance.typefrais
            this.$v.libelle.$model = data.assurance.libelle
            this.$v.prix.$model = data.assurance.prix
            this.$v.nb_mois.$model = data.assurance.nb_mois
            this.assurance_id = data.assurance.id
            this.assurance_index = data.index
            if (data.assurance.typefrais.libelle == 'Assurance') {
                this.asurance_nb_mois = true
            }else{
                 this.asurance_nb_mois = false
            }
            $('.btn-add-edit').text(this.$t('content.bouton.modifier'))
        })
    },
    beforeMount() {
        this.Gettypefrais();
    }
}

</script>
<style src='vue-multiselect/dist/vue-multiselect.min.css'></style>
