<template>
    <div v-if="$can('Ajouter un utilisateur')" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="card-header ">
                    <div class="row">
                        <div class="col-md-11">
                            <div class="d-flex justify-content-between">
                                <h3 v-if="action == 'add'" class="card-title mb-0"> {{$t('content.pages.utilisateurs.nouveau.titre_ajout')}} </h3>
                                <h3 v-else class="card-title mb-0"> {{$t('content.pages.utilisateurs.nouveau.titre_modif')}} </h3>
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
                                <div class="col-6">
                                    <div class="form-group mr-b-0em" :class="{ 'form-group--error': $v.utilisateur.nom.$error }">
                                        <label class="form__label">{{$t('content.pages.utilisateurs.nouveau.inputs.nom')}} </label>
                                        <input class="form-control" v-model.trim="$v.utilisateur.nom.$model" @input="setnom($event.target.value)" :placeholder="$t('content.pages.utilisateurs.nouveau.inputs.nom')" />
                                    </div>
                                    <div v-if="$v.utilisateur.nom.$dirty">
                                        <div class="error" v-if="!$v.utilisateur.nom.required && submitStatus == true ">
                                            {{ $t('validation.required', { attribute : $t('content.pages.utilisateurs.nouveau.inputs.nom') }) }}
                                        </div>
                                        <div class="error" v-if="!$v.utilisateur.nom.minLength">
                                            {{ $t('validation.min.numeric', { attribute : $t('content.pages.utilisateurs.nouveau.inputs.nom'), min : $v.utilisateur.nom.$params.minLength.min }) }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group mr-b-0em" :class="{ 'form-group--error': $v.utilisateur.email.$error }">
                                        <label class="form__label">{{$t('content.pages.utilisateurs.nouveau.inputs.email')}}</label>
                                        <input class="form-control" v-model.trim="$v.utilisateur.email.$model" @input="setemail($event.target.value)" :placeholder="$t('content.pages.utilisateurs.nouveau.inputs.email')" />
                                    </div>
                                    <div v-if="$v.utilisateur.email.$dirty">
                                        <div class="error" v-if="!$v.utilisateur.email.required && submitStatus == true ">
                                            {{ $t('validation.required', { attribute : $t('content.pages.utilisateurs.nouveau.inputs.email') }) }}
                                        </div>
                                        <div class="error" v-if="!$v.utilisateur.email.minLength">
                                            {{ $t('validation.min.numeric', { attribute : $t('content.pages.utilisateurs.nouveau.inputs.email'), min : $v.utilisateur.email.$params.minLength.min }) }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group mr-b-0em" :class="{ 'form-group--error': $v.utilisateur.cin.$error }">
                                        <label class="form__label">{{'CIN'}}</label>
                                        <input class="form-control" v-model.trim="$v.utilisateur.cin.$model" @input="setcin($event.target.value)" :placeholder="'CIN'" />
                                    </div>
                                    <div v-if="$v.utilisateur.cin.$dirty">
                                        <div class="error" v-if="!$v.utilisateur.cin.required && submitStatus == true ">
                                            {{ $t('validation.required', { attribute : 'CIN' }) }}
                                        </div>
                                        <div class="error" v-if="!$v.utilisateur.cin.minLength">
                                            {{ $t('validation.min.numeric', { attribute : 'CIN', min : $v.utilisateur.cin.$params.minLength.min }) }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group mr-b-0em" :class="{ 'form-group--error': $v.utilisateur.tele.$error }">
                                        <label class="form__label">{{$t('content.pages.utilisateurs.nouveau.inputs.tele')}}</label>
                                        <input class="form-control" v-model.trim="$v.utilisateur.tele.$model" @input="settele($event.target.value)" :placeholder="$t('content.pages.utilisateurs.nouveau.inputs.tele')" />
                                    </div>
                                    <div v-if="$v.utilisateur.tele.$dirty">
                                        <div class="error" v-if="!$v.utilisateur.tele.required && submitStatus == true ">
                                            {{ $t('validation.required', { attribute : $t('content.pages.utilisateurs.nouveau.inputs.tele') }) }}
                                        </div>
                                        <div class="error" v-if="!$v.utilisateur.tele.minLength">
                                            {{ $t('validation.min.numeric', { attribute : $t('content.pages.utilisateurs.nouveau.inputs.tele'), min : $v.utilisateur.tele.$params.minLength.min }) }}
                                        </div>
                                    </div>
                                </div> 
                                <div class="col-6">
                                    <div class="form-group mr-b-0em" :class="{ 'form-group--error': $v.utilisateur.gender.$error }">
                                        <label class="form__label">Genre</label> 
                                        <select class="form-control" v-model.trim="$v.utilisateur.gender.$model" @input="setgender($event.target.value)">
                                                        <option :value="$t('content.text.homme')">{{$t('content.text.homme')}}</option>
                                                        <option :value="$t('content.text.femme')">{{$t('content.text.femme')}}</option>
                                        </select>
                                    </div>
                                    <div v-if="$v.utilisateur.gender.$dirty">
                                        <div class="error" v-if="!$v.utilisateur.gender.required && submitStatus == true ">{{ $t('validation.required', { attribute : 'Genre'}) }}</div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label>{{$t('content.pages.utilisateurs.nouveau.inputs.photo')}}</label>
                                        <input type="file" id="upload-image" class="file-upload-default" v-on:change="onImageChange">
                                        <div class="input-group col-xs-12">
                                            <input type="text" id="input-name-image" class="form-control file-upload-info" disabled :placeholder="$t('content.pages.utilisateurs.nouveau.inputs.photo')">
                                            <span class="input-group-append">
                                                <button onclick="document.getElementById('upload-image').click()" class="file-upload-browse btn btn-info" type="button">{{ $t('content.bouton.upload') }}</button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <p class="card-description"> <label>Statut :</label> </p>
                                    <div class="form-group">
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input type="checkbox" :checked="is_valide" v-model="is_valide" class="form-check-input"> Validé <i class="input-helper"></i></label>
                                        </div>
                                    </div>
                                </div>
                                <!--<div class="col-6">
                                    <div class="form-group">
                                        <img style="width: 100%;" :src="utilisateur.url">
                                    </div>
                                </div>-->
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
            utilisateur: {
                nom: '',
                email: '',
                tele: '',
                cin: '',
                gender: '',
                image: '',
                url: '',
            },
            formData: {},
            submitStatus: false,
            action: 'add',
            utilisateur_id: null,
            is_valide: true,
            utilisateur_index: null
        }
    },
    validations() {
        return {
            utilisateur: {
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
                image: {
                    //required
                }
            }
        }

    },
    methods: {
        setnom(value) {
            console.log(value)
            this.utilisateur.nom = value
            this.$v.utilisateur.nom.$touch()
        },
        setemail(value) {
            console.log(value)
            this.utilisateur.email = value
            this.$v.utilisateur.email.$touch()
        },
        settele(value) {
            console.log(value)
            this.utilisateur.tele = value
            this.$v.utilisateur.tele.$touch()
        },
        setcin(value) {
            console.log(value)
            this.utilisateur.cin = value
            this.$v.utilisateur.cin.$touch()
        },
        setgender(value) {
            console.log(value)
            this.utilisateur.gender = value
            this.$v.utilisateur.gender.$touch()
        },
        setimage(value) {
            console.log(value)
            this.utilisateur.image = value
            this.$v.utilisateur.image.$touch()
        },
        onImageChange(e) {
            document.getElementById("input-name-image").placeholder = e.target.files[0].name;
            console.log(e.target.files[0]);
            this.$v.utilisateur.image.$model = e.target.files[0];

            if (/\.(jpe?g|png|gif)$/i.test(e.target.files[0].name)) {
                let reader = new FileReader();
                reader.onload = (e) => { this.utilisateur.url = e.target.result; };
                reader.readAsDataURL(this.$v.utilisateur.image.$model);
            } else {
                console.log('not image');
            }
            console.log(this.utilisateur.url)
        },
        onComplete: function() {
            alert('Yay. Done!');
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
                        this.formData.append('utilisateur[nom]', this.$v.utilisateur.nom.$model);
                        this.formData.append('utilisateur[email]', this.$v.utilisateur.email.$model);
                        this.formData.append('utilisateur[tele]', this.$v.utilisateur.tele.$model);
                        this.formData.append('utilisateur[cin]', this.$v.utilisateur.cin.$model);
                        this.formData.append('utilisateur[gender]', this.$v.utilisateur.gender.$model);
                        if (this.$v.utilisateur.image.$model != null)
                            this.formData.append('utilisateur[image]', this.$v.utilisateur.image.$model);

                        if (is_action == 'edit') {
                            this.formData.append('utilisateur_id', this.utilisateur_id);
                            this.formData.append('utilisateur[is_valide]', (this.is_valide) ? 1 : 0);
                        }
                        const config = { headers: { 'content-type': 'multipart/form-data' } }
                        axios.post('/api-admin/utilisateurs/' + post, this.formData, config).then(res => {
                                switch (res.data) {
                                    case false:
                                        this.AlertResponseFalse("", this.$t('content.alerts.utilisateur.n_existe'), "warning");
                                        break;
                                    default:
                                        const _text = (this.action == 'add') ? this.$t('content.alerts.ajout.success') : this.$t('content.alerts.modification.success');

                                        this.AlertResponseTrue("", _text, "success");

                                        if (is_action == 'add'){
                                            this.$emit('RefreshListUtlisateurs', res.data);
                                        }
                                        else {
                                            console.log("Path")
                                            if (this.$router.history.current["name"] == "profile-utilisateur") {
                                                this.$router.push({name: 'profile-utilisateur', params: {email : this.$v.utilisateur.email.$model } })
                                                location.reload();

                                             }else {
                                                this.eventUtilisateurs.$emit('update', { "utilisateur": res.data, "index": this.utilisateur_index })
                                            }
                                        }

                                        $('.bd-example-modal-lg').modal('hide');

                                        this.$v.utilisateur.nom.$model = null
                                        this.$v.utilisateur.email.$model = null
                                        this.$v.utilisateur.tele.$model = null
                                        this.$v.utilisateur.cin.$model = null
                                        this.$v.utilisateur.gender.$model = null
                                        this.$v.utilisateur.image.$model = null
                                        this.utilisateur.url = null
                                        this.$v.$reset()
                                        this.action = 'add'
                                        this.is_valide = null
                                        this.utilisateur_id = null
                                        this.utilisateur_index = null
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
    created: function() {
        this.eventUtilisateurs.$on('edit', data => {
            this.action = 'edit'
            this.$v.utilisateur.nom.$model = data.utilisateur.name
            this.$v.utilisateur.email.$model = data.utilisateur.email
            this.$v.utilisateur.tele.$model = data.utilisateur.tele
            this.$v.utilisateur.cin.$model = data.utilisateur.cin
            this.$v.utilisateur.gender.$model = data.utilisateur.gender
            this.utilisateur.url = `/clubi/public/admin/utilisateurs/photos/${data.utilisateur.image}`

            this.utilisateur_id = data.utilisateur.id
            this.is_valide = (data.utilisateur.is_valide == 1 ) ? true : false
 

            this.utilisateur_index = data.index
            $('.btn-add-edit').text(this.$t('content.bouton.modifier'))
        });

        this.eventUtilisateurs.$on('clear', data => {
            this.action = 'add'
            this.$v.utilisateur.nom.$model = null // data.utilisateur.name
            this.$v.utilisateur.email.$model = null // data.utilisateur.email
            this.$v.utilisateur.tele.$model = null // data.utilisateur.tele
            this.$v.utilisateur.cin.$model = null // data.utilisateur.cin
            this.$v.utilisateur.gender.$model = null // data.utilisateur.gender
            this.utilisateur.url = null // `/admin/utilisateurs/photos/${data.utilisateur.image}`
            this.is_valide = true

            this.utilisateur_id = null //data.utilisateur.id
            //this.is_valide = null //data.index
            this.utilisateur_index = null //data.index
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
