<template>
    <div v-if="$can('Ajouter une activité') || $can('Modifier une activité')" class="col-md-4 grid-margin stretch-card">
        <div class="card">
            <div class="card-header ">
                <div class="row">
                    <div class="col-md-12">
                        <h3 v-if="action == 'add'">{{ $t('content.pages.parametrages.pack_activities.activities.nouveau.titre_ajout') }}</h3>
                        <h3 v-else>{{ $t('content.pages.parametrages.pack_activities.activities.nouveau.titre_modif') }}</h3>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <br>
                <form @submit.prevent="submit($event, action)" class="forms-sample">
                    <div class="form-group mr-b-0em" :class="{ 'form-group--error': $v.name.$error }">
                        <label class="form__label">Nom d'activité : </label>
                        <input class="form-control" v-model.trim="$v.name.$model" @input="setname($event.target.value)" :placeholder="$t('content.pages.parametrages.pack_activities.activities.nouveau.inputs.libelle.placeholder')" />
                    </div>
                    <div v-if="$v.name.$dirty">
                        <div class="error" v-if="!$v.name.required && submitStatus == true ">{{ $t('validation.required', { attribute : $t('content.pages.parametrages.pack_activities.activities.nouveau.inputs.libelle.titre') }) }}</div>
                        <div class="error" v-if="!$v.name.minLength">
                            {{ $t('validation.min.numeric', { attribute : $t('content.pages.parametrages.pack_activities.activities.nouveau.inputs.libelle.titre'), min : $v.name.$params.minLength.min }) }}
                        </div>
                    </div>
                    <!--<div class="form-group">
                        <label>{{ $t('content.pages.parametrages.pack_activities.activities.nouveau.inputs.image.titre') }}</label>
                        <input type="file" id="upload-image" class="file-upload-default" v-on:change="onImageChange">
                        <div class="input-group col-xs-12">
                            <input type="text" id="input-name-image" class="form-control file-upload-info" disabled :placeholder="$t('content.pages.parametrages.pack_activities.activities.nouveau.inputs.image.placeholder')">
                            <span class="input-group-append">
                                <button onclick="document.getElementById('upload-image').click()" class="file-upload-browse btn btn-info" type="button">{{ $t('content.bouton.upload') }}</button>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <img style="width: 100%;" :src="url">
                    </div>-->
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
    props: ['activities'],
    data() {
        return {
            name: '',
            //image: '',
            //url: '',
            formData: {},
            submitStatus: false,
            action: 'add',
            activitie_id: null,
            activitie_index: null
        }
    },
    validations: {
        name: {
            required,
            minLength: minLength(3)
        },
        /*image: {
            //required
        }*/
    },
    methods: {
        setname(value) {
            this.name = value
            this.$v.name.$touch()
        },
        /*setimage(value) {
            this.image = value
            this.$v.image.$touch()
        },*/
        onImageChange(e) {
            document.getElementById("input-name-image").placeholder = e.target.files[0].name;
            console.log(e.target.files[0]);
            this.$v.image.$model = e.target.files[0];

            if (/\.(jpe?g|png|gif)$/i.test(e.target.files[0].name)) {
                let reader = new FileReader();
                reader.onload = (e) => { this.url = e.target.result; };
                reader.readAsDataURL(this.$v.image.$model);
            } else {
                console.log('not image');
            }
            console.log(this.url)


        },
        submit(event, is_action) {
            this.$v.$touch()
            this.submitStatus = true
            if (this.$v.$invalid) {
                //this.submitStatus = 'ERROR'
            } else {
                const post = (is_action == 'add') ? 'store-activitie' : 'update-activitie';
                //this.submitStatus = 'PENDING'
                this.formData = new FormData();
                this.formData.append('name', this.$v.name.$model);
                //if (this.$v.image.$model && this.$v.image.$model != '' ) 
                //    this.formData.append('image', this.$v.image.$model);

                 if (is_action == 'edit')
                    this.formData.append('activitie_id', this.activitie_id);

                const config = { headers: { 'content-type': 'multipart/form-data' } }
                axios.post('/api-admin/parametrages/' + post, this.formData, config).then(res => {
                        if (is_action == 'add')
                            this.$emit('RefreshListActivities', res.data);
                        else
                            this.eventActivities.$emit('update', { "activitie": res.data, "index": this.activitie_index })

                        //document.getElementById("input-name-image").placeholder = this.$t('content.pages.activities.activitie.image_placeholder')

                        this.clearDataInputs()
                        this.$v.$reset()
                        this.action = 'add'
                        this.activitie_id = null
                        this.activitie_index = null
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

            this.$v.name.$model = null
            //this.$v.image.$model = null
            //this.url = null
            $('.btn-add-edit').text(this.$t('content.bouton.ajout'))
        }
    },
    created: function() {
        this.eventActivities.$on('edit', data => {
            this.action = 'edit'
            this.$v.name.$model = data.activitie.name
            this.activitie_id = data.activitie.id
            //this.url = `/admin/activities/${data.activitie.image}`
            //this.$v.image.$model  = ''
            this.activitie_index = data.index
            $('.btn-add-edit').text(this.$t('content.bouton.modifier'))
        })
    },
    beforeMount() {

    }
}

</script>
