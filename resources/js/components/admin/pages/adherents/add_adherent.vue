<template>
    <div v-if="$can('Ajouter un adhérent')" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="card-header ">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="d-flex justify-content-between">
                                <h3 class="card-title mb-0">{{ $t('content.pages.adherents.modale_nouveau.titre') }}</h3>
                            </div>
                        </div> 
                    </div>
                </div>
                <div class="modal-body grid-margin modal-adherent">
                    <form-wizard @on-complete="submit" title="" subtitle="" shape="circle" :back-button-text="$t('content.bouton.prev')" :next-button-text="$t('content.bouton.next')" :finish-button-text="$t('content.bouton.enregistrer')" color="#ff9c00e6">
                        <tab-content title="" icon="">
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group mr-b-0em" :class="{ 'form-group--error': $v.adherent.nom.$error }">
                                        <label class="form__label">{{ $t('content.pages.adherents.modale_nouveau.inputs.nom.titre') }}</label>
                                        <input class="form-control" v-model.trim="$v.adherent.nom.$model" @input="setnom($event.target.value)" :placeholder="$t('content.pages.adherents.modale_nouveau.inputs.nom.placeholder')" />
                                    </div>
                                    <div v-if="$v.adherent.nom.$dirty">
                                        <div class="error" v-if="!$v.adherent.nom.required">
                                            {{ $t('validation.required', { attribute : $t('content.pages.adherents.modale_nouveau.inputs.nom.titre') }) }}
                                        </div>
                                        <div class="error" v-if="!$v.adherent.nom.minLength">
                                            {{ $t('validation.min.numeric', { attribute : $t('content.pages.adherents.modale_nouveau.inputs.nom.titre') , min : $v.adherent.nom.$params.minLength.min }) }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group mr-b-0em" :class="{ 'form-group--error': $v.adherent.email.$error }">
                                        <label class="form__label">{{$t('content.pages.adherents.modale_nouveau.inputs.email.titre')}}</label>
                                        <input class="form-control" v-model.trim="$v.adherent.email.$model" @input="setemail($event.target.value)" :placeholder="$t('content.pages.adherents.modale_nouveau.inputs.email.placeholder')" />
                                    </div>
                                    <div v-if="$v.adherent.email.$dirty">
                                        <div class="error" v-if="!$v.adherent.email.required">
                                            {{ $t('validation.required', { attribute : $t('content.pages.adherents.modale_nouveau.inputs.email.titre') }) }}
                                        </div>
                                        <div class="error" v-if="!$v.adherent.email.minLength">
                                            {{ $t('validation.min.numeric', { attribute : $t('content.pages.adherents.modale_nouveau.inputs.email.titre'), min : $v.adherent.email.$params.minLength.min }) }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group mr-b-0em" :class="{ 'form-group--error': $v.adherent.cin.$error }">
                                        <label class="form__label">{{$t('content.pages.adherents.modale_nouveau.inputs.cin.titre')}}</label>
                                        <input class="form-control" v-model.trim="$v.adherent.cin.$model" @input="setcin($event.target.value)" :placeholder="$t('content.pages.adherents.modale_nouveau.inputs.cin.placeholder')" />
                                    </div>
                                    <div v-if="$v.adherent.cin.$dirty">
                                        <div class="error" v-if="!$v.adherent.cin.required">
                                            {{ $t('validation.required', { attribute : $t('content.pages.adherents.modale_nouveau.inputs.cin.titre') }) }}
                                        </div>
                                        <div class="error" v-if="!$v.adherent.cin.minLength">
                                            {{ $t('validation.min.numeric', { attribute : $t('content.pages.adherents.modale_nouveau.inputs.cin.titre'), min : $v.adherent.cin.$params.minLength.min }) }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group mr-b-0em" :class="{ 'form-group--error': $v.adherent.tele.$error }">
                                        <label class="form__label">{{$t('content.pages.adherents.modale_nouveau.inputs.tele.titre')}}</label>
                                        <input class="form-control" v-model.trim="$v.adherent.tele.$model" @input="settele($event.target.value)" :placeholder="$t('content.pages.adherents.modale_nouveau.inputs.tele.placeholder')" />
                                    </div>
                                    <div v-if="$v.adherent.tele.$dirty">
                                        <div class="error" v-if="!$v.adherent.tele.required">
                                            {{ $t('validation.required', { attribute : $t('content.pages.adherents.modale_nouveau.inputs.tele.titre') }) }}
                                        </div>
                                        <div class="error" v-if="!$v.adherent.tele.minLength">
                                            {{ $t('validation.min.numeric', { attribute : $t('content.pages.adherents.modale_nouveau.inputs.tele.titre'), min : $v.adherent.tele.$params.minLength.min }) }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group mr-b-0em" :class="{ 'form-group--error': $v.adherent.gender.$error }">
                                        <label class="form__label">{{$t('content.pages.adherents.modale_nouveau.inputs.gender.titre')}}</label>
                                        <input class="form-control" v-model.trim="$v.adherent.gender.$model" @input="setgender($event.target.value)" :placeholder="$t('content.pages.adherents.modale_nouveau.inputs.gender.placeholder')" />

                                        


                                    </div>
                                    <div v-if="$v.adherent.gender.$dirty">
                                        <div class="error" v-if="!$v.adherent.gender.required">
                                            {{ $t('validation.required', { attribute : $t('content.pages.adherents.modale_nouveau.inputs.gender.titre') }) }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group mr-b-0em" :class="{ 'form-group--error': $v.adherent.date_naiss.$error }">
                                        <label class="form__label">
                                            {{$t('content.pages.adherents.modale_nouveau.inputs.date_naiss.titre')}}
                                        </label>
                                        <date-picker format="DD/MM/YYYY" style="width : 100%;" v-model.trim="$v.adherent.date_naiss.$model" @change="setdate_naiss" type="date"></date-picker>
                                    </div>
                                    <div v-if="$v.adherent.date_naiss.$dirty">
                                        <div class="error" v-if="!$v.adherent.date_naiss.required">
                                            {{ $t('validation.required', { attribute : $t('content.pages.adherents.modale_nouveau.inputs.date_naiss.titre') }) }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group mr-b-0em" :class="{ 'form-group--error': $v.adherent.adresse.$error }">
                                        <label class="form__label">{{$t('content.pages.adherents.modale_nouveau.inputs.address.titre')}}</label>
                                        <textarea class="form-control" v-model.trim="$v.adherent.adresse.$model" @input="setadresse($event.target.value)" :placeholder="$t('content.pages.adherents.modale_nouveau.inputs.address.placeholder')"> </textarea>
                                    </div>
                                    <div v-if="$v.adherent.adresse.$dirty">
                                        <div class="error" v-if="!$v.adherent.adresse.required">
                                            {{ $t('validation.required', { attribute : $t('content.pages.adherents.modale_nouveau.inputs.address.titre') }) }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label>{{$t('content.pages.adherents.modale_nouveau.inputs.photos.titre')}}</label>
                                        <input type="file" id="upload-image" class="file-upload-default" v-on:change="onImageChange">
                                        <div class="input-group col-xs-12">
                                            <input type="text" id="input-name-image" class="form-control file-upload-info" disabled :placeholder="$t('content.pages.adherents.modale_nouveau.inputs.photos.placeholder')">
                                            <span class="input-group-append">
                                                <button onclick="document.getElementById('upload-image').click()" class="file-upload-browse btn btn-info" type="button">{{ $t('content.bouton.upload') }}</button>
                                            </span>
                                        </div>
                                    </div>
                                    <div v-if="$v.adherent.image.$dirty">
                                        <div class="error" v-if="!$v.adherent.image.required">
                                            {{ $t('validation.required', { attribute : $t('content.pages.adherents.modale_nouveau.inputs.photos.titre') }) }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group mr-b-0em" :class="{ 'form-group--error': $v.adherent.code_client.$error }">
                                        <label class="form__label">{{$t('content.pages.adherents.modale_nouveau.inputs.parrain.titre')}}</label>
                                        <input class="form-control" v-model.trim="$v.adherent.code_client.$model" @input="setcode_client($event.target.value)" :placeholder="$t('content.pages.adherents.modale_nouveau.inputs.parrain.placeholder')" />
                                    </div>
                                    <div v-if="$v.adherent.code_client.$dirty"> 
                                        <div class="error" v-if="!$v.adherent.code_client.minLength">
                                            {{ $t('validation.min.numeric', { attribute : $t('content.pages.adherents.modale_nouveau.inputs.parrain.titre'), min : $v.adherent.code_client.$params.minLength.min }) }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <img style="width: 100%;" :src="adherent.url">
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
            adherent: {
                nom: '',
                email: '',
                tele: '',
                cin: '',
                gender: '',
                adresse: '',
                date_naiss: '',
                image: '',
                url: '',
                code_client : ''
            },
            formData: {},
            submitStatus: null
        }
    },
    validations() {
        return {
            adherent: {
                nom: {
                    required,
                    minLength: minLength(3)
                },
                email: {
                    required,
                    minLength: minLength(3)
                },
                tele: {
                    required,
                    minLength: minLength(3)
                },
                cin: {
                    required,
                    minLength: minLength(4)
                },
                gender: {
                    required
                },
                adresse: {
                    required
                },
                date_naiss: {
                    required
                },
                image: {
                    required
                },
                code_client: {
                    minLength: minLength(3)
                },
            }
        }

    },
    methods: {
        setcode_client(value) {
            console.log(value)
            this.adherent.code_client = value
            this.$v.adherent.code_client.$touch()
        },
        setnom(value) {
            console.log(value)
            this.adherent.nom = value
            this.$v.adherent.nom.$touch()
        },
        setemail(value) {
            console.log(value)
            this.adherent.email = value
            this.$v.adherent.email.$touch()
        },
        settele(value) {
            console.log(value)
            this.adherent.tele = value
            this.$v.adherent.tele.$touch()
        },
        setcin(value) {
            console.log(value)
            this.adherent.cin = value
            this.$v.adherent.cin.$touch()
        },
        setgender(value) {
            console.log(value)
            this.adherent.gender = value
            this.$v.adherent.gender.$touch()
        },
        setadresse(value) {
            console.log(value)
            this.adherent.adresse = value
            this.$v.adherent.adresse.$touch()
        },
        setdate_naiss(value) {
            console.log(value)
            this.adherent.date_naiss = value
            this.$v.adherent.date_naiss.$touch()
        },
        setimage(value) {
            console.log(value)
            this.adherent.image = value
            this.$v.adherent.image.$touch()
        },
        onImageChange(e) {
            document.getElementById("input-name-image").placeholder = e.target.files[0].name;
            console.log(e.target.files[0]);
            this.$v.adherent.image.$model = e.target.files[0];

            if (/\.(jpe?g|png|gif)$/i.test(e.target.files[0].name)) {
                let reader = new FileReader();
                reader.onload = (e) => { this.adherent.url = e.target.result; };
                reader.readAsDataURL(this.$v.adherent.image.$model);
            } else {
                console.log('not image');
            }
            console.log(this.adherent.url)


        },
        onComplete: function() {
            alert('Yay. Done!');
        },
        submit(event) {
            this.$v.$touch()
            console.log(this.$v.$invalid)
            if (this.$v.$invalid) {
                this.submitStatus = 'ERROR'
            } else {
                this.submitStatus = 'PENDING'
                this.formData = new FormData();
                //### Informations personnelle
                this.formData.append('adherent[nom]', this.$v.adherent.nom.$model);
                this.formData.append('adherent[email]', this.$v.adherent.email.$model);
                this.formData.append('adherent[tele]', this.$v.adherent.tele.$model);
                this.formData.append('adherent[cin]', this.$v.adherent.cin.$model);
                this.formData.append('adherent[gender]', this.$v.adherent.gender.$model);
                this.formData.append('adherent[adresse]', this.$v.adherent.adresse.$model);
                this.formData.append('adherent[date_naiss]', this.$v.adherent.date_naiss.$model.toDateString());
                this.formData.append('adherent[image]', this.$v.adherent.image.$model);
                this.formData.append('adherent[parrain]', this.$v.adherent.code_client.$model);
                const config = { headers: { 'content-type': 'multipart/form-data' } }
                axios.post('/api-admin/adherent/store', this.formData, config).then(res => {
                    if (res.data) {

                        this.AlertResponseTrue("", this.$t('content.alerts.ajout.success'), "success");

                        this.$v.adherent.nom.$model = null
                        this.$v.adherent.email.$model = null
                        this.$v.adherent.tele.$model = null
                        this.$v.adherent.date_naiss.$model = null
                        this.$v.adherent.cin.$model = null
                        this.$v.adherent.gender.$model = null
                        this.$v.adherent.adresse.$model = null
                        this.$v.adherent.image.$model = null
                        this.adherent.url = null
                        this.$v.$reset()
                        this.$emit('RefreshListAdherents', res.data);

                        } else {
                            this.AlertResponseFalse("", this.$t('content.alerts.adherents.ni_ajout') , "warning")
                        }

                }).catch(e => {})
                .finally(f => {
                    setTimeout(() => {
                        this.submitStatus = 'OK'
                    }, 500)
                })
            }
        }
    },
}

</script>
<style>
.error {
    color: #ff4747;
    bottom: 16px;
    position: relative;
    text-transform: lowercase;
}


.invioce-adherent {
    margin-top: 25px;
}

.invioce-adherent p {
    margin-bottom: 0rem ! important;
}

.invioce-adherent p span {
    font-weight: bold;
}


.modal-adherent .wizard-progress-with-circle,
.modal-adherent .wizard-nav,
.modal-utilisateur .wizard-progress-with-circle,
.modal-utilisateur .wizard-nav {
    display: none ! important;
}

</style>
