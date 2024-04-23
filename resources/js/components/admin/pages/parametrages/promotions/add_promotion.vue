<template>
    <div v-if="$can('Ajouter une promotion') || $can('Modifier une promotion')" class="col-md-4 grid-margin stretch-card">
        <div class="card">
            <div class="card-header ">
                <div class="row">
                    <div class="col-md-12"> 
                        <h3 v-if="action == 'add'">Nouvelle promotion </h3>
                        <h3 v-else>{{$t('content.pages.parametrages.promotions.nouveau.titre_modif')}}</h3>
                    </div>
                </div>
            </div>
            <div class="card-body"> <br>
                <form @submit.prevent="submit($event, action)" class="forms-sample">
                    <div class="">
                        <div class="form-group mr-b-0em" :class="{ 'form-group--error': $v.description.$error }">
                            <label class="form__label">{{$t('content.pages.parametrages.promotions.nouveau.inputs.description.titre')}} : </label>
                            <input class="form-control" v-model.trim="$v.description.$model" @input="setdescription($event.target.value)" :placeholder="$t('content.pages.parametrages.promotions.nouveau.inputs.description.placeholder')" />
                        </div>
                        <div v-if="$v.description.$dirty">
                            <div class="error" v-if="!$v.description.required && submitStatus == true ">{{ $t('validation.required', { attribute : $t('content.pages.parametrages.promotions.nouveau.inputs.description.titre') }) }}</div>
                            <div class="error" v-if="!$v.description.minLength">
                                {{ $t('validation.min.numeric', { attribute : $t('content.pages.parametrages.promotions.nouveau.inputs.description.titre'), min : $v.description.$params.minLength.min }) }}
                            </div>
                        </div>
                    </div>
                    <div class="">
                        <div class="form-group mr-b-0em" :class="{ 'form-group--error': $v.remise.$error }">
                            <label class="form__label">{{$t('content.pages.parametrages.promotions.nouveau.inputs.remise.titre')}} : </label>
                            <input class="form-control" v-model.trim="$v.remise.$model" @input="setremise($event.target.value)" :placeholder="$t('content.pages.parametrages.promotions.nouveau.inputs.remise.placeholder')" />
                        </div>
                        <div v-if="$v.remise.$dirty">
                            <div class="error" v-if="!$v.remise.required && submitStatus == true ">{{ $t('validation.required', { attribute : $t('content.pages.parametrages.promotions.nouveau.inputs.remise.titre') }) }}</div>
                            <div class="error" v-if="!$v.remise.numeric">
                                Entrer un valeur correct
                            </div>
                        </div>
                    </div>
                    <div class="">
                        <div class="form-group mr-b-0em" :class="{ 'form-group--error': $v.date_debut.$error }">
                            <label class="form__label">{{$t('content.pages.parametrages.promotions.nouveau.inputs.date_lancement.titre')}} : </label>
                            <date-picker format="DD/MM/YYYY" style="width : 100%;" v-model.trim="$v.date_debut.$model" @change="setdate_debut" type="date"></date-picker>
                        </div>
                        <div v-if="$v.date_debut.$dirty">
                            <div class="error" v-if="!$v.date_debut.required && submitStatus == true ">{{ $t('validation.required', { attribute : $t('content.pages.parametrages.promotions.nouveau.inputs.date_lancement.titre') }) }}</div>
                        </div>
                    </div>
                    <div class="">
                        <div class="form-group mr-b-0em" :class="{ 'form-group--error': $v.date_fin.$error }">
                            <label class="form__label">{{$t('content.pages.parametrages.promotions.nouveau.inputs.date_fin.titre')}} : </label>
                            <date-picker style="width : 100%;" v-model.trim="$v.date_fin.$model" @change="setdate_fin" type="date"></date-picker>
                        </div>
                        <div v-if="$v.date_fin.$dirty">
                            <div class="error" v-if="!$v.date_fin.required && submitStatus == true ">{{ $t('validation.required', { attribute : $t('content.pages.parametrages.promotions.nouveau.inputs.date_fin.titre') }) }}</div>
                        </div>
                    </div>
                    <div class="">
                        <div class="form-group mr-b-0em">
                            <label class="form__label">{{ $t('content.pages.parametrages.promotions.nouveau.inputs.pack.titre') }} : </label>
                            <!--<select class="form-control" v-model.trim="$v.id_pack.$model" @input="setid_pack($event.target.value)">
                                <option v-for="(pack, index) in packs" :value="pack">
                                    {{ pack.description }} ( <span v-for="(acts) in pack.activities"> {{ acts.name }} </span> )
                                </option>
                            </select>-->

                            <multiselect v-model.trim="$v.id_pack.$model" @input="setid_pack($event)" :options="packs" :custom-label="libelePack" placeholder="Recherche.." label="description" track-by="description"></multiselect>

                        </div>
                        <div v-if="$v.id_pack.$dirty">
                            <div class="error" v-if="!$v.id_pack.required && submitStatus == true ">{{ $t('validation.required', { attribute : $t('content.pages.parametrages.promotions.nouveau.inputs.pack.titre') }) }}</div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>{{ $t('content.pages.parametrages.promotions.nouveau.inputs.image.titre') }} : </label>
                        <input type="file" id="upload-image" class="file-upload-default" v-on:change="onImageChange">
                        <div class="input-group col-xs-12">
                            <input type="text" id="input-name-image" class="form-control file-upload-info" disabled :placeholder="$t('content.pages.parametrages.promotions.nouveau.inputs.image.placeholder')">
                            <span class="input-group-append">
                                <button onclick="document.getElementById('upload-image').click()" class="file-upload-browse btn btn-info" type="button">{{ $t('content.bouton.upload') }}</button>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <img style="width: 100%;" :src="url">
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
    props: ['promotions'],
    data() {
        return {
            description: '',
            date_debut: '',
            date_fin: '',
            id_pack: [],
            remise: '',
            image: null,
            url: '',
            formData: {},
            submitStatus: false,
            packs: [],

            action: 'add',
            promotion_id: null,
            promotion_index: null
        }
    },
    validations: {
        description: {
            required,
            minLength: minLength(3)
        },
        date_debut: {
            required,
        },
        date_fin: {
            required,
        },
        remise: {
            required,
            decimal,
            numeric
        },
        id_pack: {
            required,
        },
        image: {
            // required
        }
    },
    methods: {
        libelePack({ description, prix, activities }) {
            var all_activities = ''
            for (var i = 0; i < activities.length; i++)
                all_activities = activities[i].name + ', ' + all_activities

            return `${description} ( ${all_activities.replace(/,(?=\s*$)/, '')} )`
        },

        setdescription(value) {
            this.description = value
            this.$v.description.$touch()
        },
        setdate_debut(value) {
            this.date_debut = value
            this.$v.date_debut.$touch()
        },
        setdate_fin(value) {
            this.date_fin = value
            this.$v.date_fin.$touch()
        },
        setremise(value) {
            this.remise = value
            this.$v.remise.$touch()
        },

        setid_pack(value) {
            this.id_pack = value
            this.$v.id_pack.$touch()
        },
        setimage(value) {
            this.image = value
            this.$v.image.$touch()
        },
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
        ListPacks() {
            axios.get('/api-admin/parametrages/packs').then((response) => {
                this.packs = response.data;
            });
        },
        submit(event, is_action) {
            this.$v.$touch()
            this.submitStatus = true
            if (this.$v.$invalid) {
                //this.submitStatus = 'ERROR'
            } else {

                const post = (is_action == 'add') ? 'store-promotion' : 'update-promotion';
                //this.submitStatus = 'PENDING'
                this.formData = new FormData();
                this.formData.append('description', this.$v.description.$model);
                this.formData.append('date_debut', this.$v.date_debut.$model.toDateString() );
                this.formData.append('date_fin', this.$v.date_fin.$model.toDateString() );
                this.formData.append('remise', this.$v.remise.$model);
                this.formData.append('id_pack', this.$v.id_pack.$model.id);
                if (this.$v.image.$model)
                    this.formData.append('image', this.$v.image.$model);

                console.log(is_action)
                if (is_action == 'edit')
                    this.formData.append('promotion_id', this.promotion_id);

                const config = { headers: { 'content-type': 'multipart/form-data' } }
                axios.post('/api-admin/parametrages/' + post, this.formData, config).then(res => {

                        if (is_action == 'add')
                            this.$emit('RefreshListPromotions', res.data);
                        else
                            this.eventPromotions.$emit('update', { "promotion": res.data, "index": this.promotion_index })

                        this.clearDataInputs() 
                        this.$v.$reset()
                        this.action = 'add'
                        this.promotion_id = null
                        this.promotion_index = null
                        this.submitStatus = false
                        $('.btn-add-edit').text(this.$t('content.bouton.ajout'))

                        console.log(res)
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

            this.$v.description.$model = null ///data.promotion.description
            this.$v.remise.$model = null ///data.promotion.remise
            this.$v.date_debut.$model = null ///new Date(data.promotion.date_debut)
            this.$v.date_fin.$model = null ///new Date(data.promotion.date_fin)
            this.$v.id_pack.$model = null ///data.promotion.pack
            this.$v.image.$model = null ///data.promotion.pack
            this.url = null
            $('.btn-add-edit').text(this.$t('content.bouton.ajout'))
        }
    },
    created: function() {
        this.eventPromotions.$on('edit', data => {
            this.action = 'edit'
            this.$v.description.$model = data.promotion.description
            this.$v.remise.$model = data.promotion.remise
            this.$v.date_debut.$model = new Date(data.promotion.date_debut)
            this.$v.date_fin.$model = new Date(data.promotion.date_fin)
            this.$v.id_pack.$model = data.promotion.pack
            //this.$v.image.$model  = data.promotion.image
            this.url = `/admin/promotions/${data.promotion.image}`

            this.promotion_id = data.promotion.id
            this.promotion_index = data.index
            $('.btn-add-edit').text(this.$t('content.bouton.modifier'))
        })
    },
    beforeMount() {
        this.ListPacks();

    }
}

</script>
