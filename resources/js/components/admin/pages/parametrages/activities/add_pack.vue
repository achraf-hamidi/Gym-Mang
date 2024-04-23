<template>
    <div v-if="$can('Ajouter un pack') || $can('Modifier un pack')" class="col-md-4 grid-margin stretch-card">
        <div class="card">
            <div class="card-header ">
                <div class="row">
                    <div class="col-md-12">
                        <h3 v-if="action == 'add'">{{
                            $t('content.pages.parametrages.pack_activities.packs.nouveau.titre_ajout')
                        }}</h3>
                        <h3 v-else>{{ $t('content.pages.parametrages.pack_activities.packs.nouveau.titre_modif') }}</h3>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <br>
                <form @submit.prevent="submit($event, action)" class="forms-sample">
                    <!--<div class="form-group">
                    <label for="descriptionpack">{{ $t('content.pages.activities.pack.description') }}</label>
                    <input type="email" class="form-control" id="descriptionpack" :placeholder="$t('content.pages.activities.pack.desc_placeholder')">
                  </div>-->
                    <div class="form-group mr-b-0em" :class="{ 'form-group--error': $v.description.$error }">
                        <label class="form__label">Nom de pack : </label>
                        <input class="form-control" v-model.trim="$v.description.$model"
                            @input="setdescription($event.target.value)" placeholder="Nom de pack" />
                    </div>
                    <div v-if="$v.description.$dirty">
                        <div class="error" v-if="!$v.description.required && submitStatus == true">
                            {{ $t('validation.required', { attribute: 'Nom de pack' }) }}
                        </div>
                        <div class="error" v-if="!$v.description.minLength">
                            {{
                                $t('validation.min.numeric', { attribute: 'Nom de pack' , min:
                                    $v.description.$params.minLength.min
                            }) }}
                        </div>
                    </div>
                    <div class="form-group mr-b-0em" :class="{ 'form-group--error': $v.value_activities.$error }">
                        <label class="form__label">{{
                            $t('content.pages.parametrages.pack_activities.packs.nouveau.inputs.activities.titre')
                        }} :
                        </label>
                        <multiselect v-model.trim="value_activities" tag-placeholder="Add this as new tag"
                            :placeholder="$t('content.pages.parametrages.pack_activities.packs.nouveau.inputs.activities.placeholder')"
                            label="name" track-by="id" :options="options_activities" :multiple="true" :taggable="true"
                            @tag="addTag"></multiselect>

                    </div>
                    <div v-if="$v.value_activities.$dirty">
                        <div class="error" v-if="!$v.value_activities.required && submitStatus == true">{{
                            $t('validation.required', { attribute:
                                $t('content.pages.parametrages.pack_activities.packs.nouveau.inputs.activities.titre')
                        }) }}</div>
                    </div>
                    <div class="form-group mr-b-0em">
                        <label class="form__label">
                            {{ $t('content.pages.abonnements.nouveau.inputs.abonnements.abonnement.titre') }}</label>
                        <multiselect v-model.trim="$v.id_abonnement.$model" @input="setid_abonnement($event)"
                            :options="abonnements" :custom-label="libeleAbonnement" placeholder="Recherche.."
                            label="libelle" track-by="libelle"></multiselect>

                    </div>
                    <div v-if="$v.id_abonnement.$dirty">
                        <div class="error" v-if="!$v.id_abonnement.required && submitStatus == true">{{
                    $t('validation.required', { attribute:
                        $t('content.pages.abonnements.nouveau.inputs.abonnements.abonnement.titre') }) }}</div>
                    </div>
                    <div class="form-group mr-b-0em" :class="{ 'form-group--error': $v.prix.$error }">
                        <label class="form__label">{{
                            $t('content.pages.parametrages.pack_activities.packs.nouveau.inputs.prix.titre')
                        }} :
                        </label>
                        <input class="form-control" v-model.trim="$v.prix.$model" @input="setprix($event.target.value)"
                            :placeholder="$t('content.pages.parametrages.pack_activities.packs.nouveau.inputs.prix.placeholder')" />
                    </div>
                    <div v-if="$v.prix.$dirty">
                        <div class="error" v-if="!$v.prix.required && submitStatus == true">{{
                    $t('validation.required', { attribute:
                        $t('content.pages.parametrages.pack_activities.packs.nouveau.inputs.prix.titre') }) }}</div>
                        <div class="error" v-if="!$v.prix.decimal">
                            {{
                        $t('validation.numeric', { attribute:
                            $t('content.pages.parametrages.pack_activities.packs.nouveau.inputs.prix.titre') }) }}
                        </div>
                    </div>



                    <div class="col-12 text-right">
                        <button type="submit" class="btn-add-edit btn btn-primary mr-2"> <i class=" mdi mdi-plus"></i>
                            {{ $t('content.bouton.ajout') }}</button>
                        <a @click="clearDataInputs" href="javascript:void(0)" class="btn btn-light">{{
                            $t('content.bouton.annuler')
                        }}</a>
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
            description: '',
            prix: '',
            formData: {},
            submitStatus: false,
            value_activities: [],
            arr: [],
            action: 'add',
            pack_id: null,
            pack_index: null,
            id_abonnement: null,
            abonnements: [],


        }
    },
    validations: {
        value_activities: {
            required
        },
        description: {
            required,
            minLength: minLength(3)
        },
        prix: {
            required,
            decimal
        },
        id_abonnement: {
            required
        }
    },
    methods: {
        addTag(newTag) {
            const tag = {
                name: newTag,
                id: newTag.substring(0, 2) + Math.floor((Math.random() * 10000000))
            }
            this.options_activities.push(tag)
            this.value_activities.push(tag)
        },
        setid_abonnement(value) {
            ////console.log(value.libelle)
            this.id_abonnement = value
            this.$v.id_abonnement.$touch()
        },
        libeleAbonnement({ nb_mois, libelle }) {
            return `${libelle} ( ${nb_mois} Mois )`
        },
        ListTypeAbonnements() {
            axios.get('/api-admin/parametrages/abonnements').then((response) => {
                this.abonnements = response.data;
            });
        },
        setdescription(value) {
            this.description = value
            this.$v.description.$touch()
        },
        setprix(value) {
            this.prix = value
            this.$v.prix.$touch()
        },
        setvalue_activities(value) {
            this.secteur = value
            this.$v.secteur.$touch()
        },




        submit(event, is_action) {
            this.$v.$touch()
            this.submitStatus = true
            if (this.$v.$invalid) {
                //this.submitStatus = 'ERROR'
            } else {
                const post = (is_action == 'add') ? 'store-pack' : 'update-pack';

                //this.submitStatus = 'PENDING'
                this.formData = new FormData();
                this.formData.append('description', this.$v.description.$model);
                this.formData.append('prix', this.$v.prix.$model);
                for (var i = 0; i < this.value_activities.length; i++) {
                    this.formData.append("value_activities[" + i + "]", this.value_activities[i]['id']);
                }
                if (is_action == 'edit')
                    this.formData.append('pack_id', this.pack_id);

                this.formData.append('id_abonnement', this.$v.id_abonnement.$model.id);

                const config = { headers: { 'content-type': 'multipart/form-data' } }
                axios.post('/api-admin/parametrages/is-pack-activities', this.formData, config).then(response => {
                    if (response.data == false) {
                        axios.post('/api-admin/parametrages/' + post, this.formData, config).then(res => {
                            if (is_action == 'add')
                                this.$emit('RefreshlistPacks', res.data);
                            else
                                this.eventPacks.$emit('update', { "pack": res.data, "index": this.pack_index })

                            this.clearDataInputs()
                            this.$v.$reset()

                            this.action = 'add'
                            this.pack_id = null
                            this.pack_index = null
                            this.submitStatus = false
                            $('.btn-add-edit').text(this.$t('content.bouton.ajout'))

                        }).catch(e => { })
                            .finally(f => {
                                setTimeout(() => {
                                    //this.submitStatus = 'OK'
                                }, 500)
                            })
                    } else {
                        this.AlertResponseFalse("", "Ce est pack déja existe", "warning")
                    }
                }).catch(e => {

                })


            }
        },
        clearDataInputs() {
            if (this.action == 'edit')
                this.action = "add"

            this.$v.description.$model = null
            this.$v.id_abonnement.$model = null
            this.$v.prix.$model = null
            this.$v.value_activities.$model = null
            $('.btn-add-edit').text(this.$t('content.bouton.ajout'))
        }
    },
    created: function () {
        this.eventPacks.$on('edit', data => {
            this.value_activities = []
            this.action = 'edit'
            this.$v.description.$model = data.pack.description
            this.$v.prix.$model = data.pack.prix
            this.$v.id_abonnement.$model = data.pack.abonnement
            //this.value_activities = data.pack.activities

            for (var i = 0; i < data.pack.activities.length; i++) {
                //this.formData.append("value_activities["+i+"]", this.value_activities[i]['id']);
                this.value_activities.push(data.pack.activities[i])
            }


            this.pack_id = data.pack.id
            this.pack_index = data.index
            $('.btn-add-edit').text(this.$t('content.bouton.modifier'))
        })
    },
    beforeMount() {
        this.ListTypeAbonnements();
    }
}

</script>
<style src='vue-multiselect/dist/vue-multiselect.min.css'>

</style>
