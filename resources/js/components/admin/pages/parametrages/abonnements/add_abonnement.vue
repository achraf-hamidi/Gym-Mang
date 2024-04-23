<template>
    <div v-if="$can('Ajouter un nouveau type d’abonnement') || $can('Modifier un type d’abonnement')" class="col-md-4 grid-margin stretch-card">
        <div class="card">
            <div class="card-header ">
                <div class="row">
                    <div class="col-md-12">
                        <h3 v-if="action=='add'">Nouveau type d'abonnement</h3>
                        <h3 v-else>{{ $t('content.pages.parametrages.abonnements.nouveau.titre_modif') }}</h3>
                    </div>
                </div>
            </div>
            <div class="card-body"> <br>
                <form @submit.prevent="submit($event, action)" class="forms-sample">
                    <div class="form-group mr-b-0em" :class="{ 'form-group--error': $v.libelle.$error }">
                        <label class="form__label">Nom : </label>
                        <input class="form-control" v-model.trim="$v.libelle.$model" @input="setlibelle($event.target.value)" placeholder="Nom" />
                    </div>
                    <div v-if="$v.libelle.$dirty">
                        <div class="error" v-if="!$v.libelle.required && submitStatus == true ">
                            {{ $t('validation.required', { attribute : $t('content.pages.parametrages.abonnements.nouveau.inputs.libelle.titre') }) }}
                        </div>
                        <div class="error" v-if="!$v.libelle.minLength">
                            {{ $t('validation.min.numeric', { attribute : $t('content.pages.parametrages.abonnements.nouveau.inputs.libelle.titre'), min : $v.libelle.$params.minLength.min }) }}
                        </div>
                    </div>
                    <div class="form-group mr-b-0em" :class="{ 'form-group--error': $v.nb_mois.$error }">
                        <label class="form__label">{{$t('content.pages.parametrages.abonnements.nouveau.inputs.nb_mois.titre')}} :</label>
                        <input class="form-control" v-model.trim="$v.nb_mois.$model" @input="setnb_mois($event.target.value)" :placeholder="$t('content.pages.parametrages.abonnements.nouveau.inputs.nb_mois.placeholder')" />
                    </div>
                    <div v-if="$v.nb_mois.$dirty">
                        <div class="error" v-if="!$v.nb_mois.required && submitStatus == true ">{{ $t('validation.required', { attribute : $t('content.pages.parametrages.abonnements.nouveau.inputs.nb_mois.titre') }) }}</div>
                        <div class="error" v-if="!$v.nb_mois.decimal">
                            {{ $t('validation.numeric', { attribute : $t('content.pages.parametrages.abonnements.nouveau.inputs.nb_mois.titre') }) }}
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
import { required, minLength, numeric, decimal, between, maxLength, email } from 'vuelidate/lib/validators'
export default {
    props: ['options_activities', 'packs'],
    data() {
        return {
            libelle: '',
            nb_mois: '',
            formData: {},
            submitStatus: false,
            arr: [],
            action: 'add',
            abonnement_id: null,
            abonnement_index: null
        }
    },
    validations: {
        libelle: {
            required,
            minLength: minLength(3)
        },
        nb_mois: {
            required,
            decimal
        }
    },
    methods: {

        setlibelle(value) {
            this.libelle = value
            this.$v.libelle.$touch()
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
                const post = (is_action == 'add') ? 'store-abonnement' : 'update-abonnement';
                //this.submitStatus = 'PENDING'
                this.formData = new FormData();
                this.formData.append('libelle', this.$v.libelle.$model);
                this.formData.append('nb_mois', this.$v.nb_mois.$model);
                if (is_action == 'edit')
                    this.formData.append('abonnement_id', this.abonnement_id);
                const config = { headers: { 'content-type': 'multipart/form-data' } }
                axios.post('/api-admin/parametrages/' + post, this.formData, config).then(res => {
                        if (is_action == 'add')
                            this.eventTypeAbonnement.$emit('add', res.data)
                        else
                            this.eventTypeAbonnement.$emit('update', { "abonnement": res.data, "index": this.abonnement_index })

                        this.clearDataInputs() 
                        this.$v.$reset()
                        this.action = 'add'
                        this.abonnement_id = null
                        this.abonnement_index = null
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
            this.$v.nb_mois.$model = null
            $('.btn-add-edit').text(this.$t('content.bouton.ajout'))
        }

    },
    created: function() {
        this.eventTypeAbonnement.$on('edit', data => {
            this.action = 'edit'
            this.$v.libelle.$model = data.abonnement.libelle
            this.$v.nb_mois.$model = data.abonnement.nb_mois
            this.abonnement_id = data.abonnement.id
            this.abonnement_index = data.index
            $('.btn-add-edit').text(this.$t('content.bouton.modifier'))
        })
    },
    beforeMount() {}
}

</script>
<style src='vue-multiselect/dist/vue-multiselect.min.css'></style>
