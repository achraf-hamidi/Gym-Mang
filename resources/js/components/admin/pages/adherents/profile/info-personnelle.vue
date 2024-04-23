<template>
         <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-header ">
                    <div class="row">
                        <div class="col-md-12">
                            <h3>
                                Informations d'adhérent   
                            </h3>
                        </div> 
                    </div>
                </div>
                <div class="card-body"> <br>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="d-flex flex-column">
                                <div class="wrapper info-adherent-tablette">
                                    <div class="flex-1 img-adherent text-centers">
                                        <img class="photo-adherent"  :src="adherent.url">
                                    </div>
                                    <p>
                                       
                                        <h2 class="mb-4" id="net-profit-legend"> {{capitalizedNom}} </h2>
                                    </p>
                                    <div class="flex-2 info-tablette mt-5">
                                        <p> 
                                            <b>Âge : </b>  
                                        <span>
                                            {{calculateAge}} ans
                                        </span>
                                    </p>
                                    <!--<div class="text-centers">
                                        <img class="photo-adherent" style="width: 90px; height : auto;" 
                                        :src="`/admin/adherents/qr_code/${details_adherent.qr_code}.png`" >
                                    </div>-->
                                    <!-- <p>
                                        <b>{{$t('content.pages.adherents.profile.qrcode.matricule')}} : </b>
                                        <span class="mb-4" id="net-profit-legend"> {{details_adherent.code_client}} </span>
                                    </p> -->
                                    <p>
                                        <b>ID : </b>
                                        <span class="mb-4" id="net-profit-legend"> {{details_adherent.id_empreinte}} </span>
                                    </p>

                                   
                                    <p>
                                        <b>Adresse email : </b>
                                        <span class="mb-4" id="net-profit-legend"> {{$v.adherent.email.$model}} </span>
                                    </p>
                                    <p>
                                        <b>Téléphone : </b>
                                        <span class="mb-4" id="net-profit-legend"> {{$v.adherent.tele.$model}} </span>
                                    </p>
                                     <p>
                                        <b>Téléphone d'urgence : </b>
                                        <span class="mb-4" id="net-profit-legend"> {{$v.adherent.tele_urgence.$model}} </span>
                                    </p>
                                    </div>
                                        
                                    <div class="flex-3 info-tablette">
                                        <p>
                                        <b>CIN : </b>
                                        <span class="mb-4" id="net-profit-legend"> {{$v.adherent.cin.$model}} </span>
                                    </p>                        
                                    <p>
                                        <b>Genre : </b>
                                        <span class="mb-4" id="net-profit-legend"> {{$v.adherent.gender.$model}} </span>
                                    </p>
                                    <p>
                                        <b>Date de naissance : </b>
                                        <span class="mb-4" id="net-profit-legend"> {{$v.adherent.date_naiss.$model | formatDate }} </span>
                                        
                                    </p>
                                    

                                    
                                    <p>
                                        <b>Adresse : </b>
                                        <span class="mb-4" id="net-profit-legend"> {{$v.adherent.adresse.$model}} </span>
                                    </p>
                                    <p>
                                        <b>Date d'inscription : </b>
                                        <span class="mb-4" id="net-profit-legend"> {{date_integration | formatDate}} </span>
                                    </p> 
                                   
                                    </div>
                                    
                                     <!--<p>
                                        <b>{{ $t('content.pages.adherents.profile.info_adherent.parrain') }} : </b>
                                       <router-link v-if="$can('Profile adhérent')" :to="{name: 'adherent', params:{code: details_adherent.parent.code_client }}">
                                            {{ details_adherent.parent.code_client }}
                                        </router-link>
                                        {{ details_adherent.parent.code_client }},
                                        {{details_adherent.parent.nom }}
                                    </p>-->
                                </div>
                            </div>
                        </div>


                       

                         
                        
                    </div>

                     <div class="row mt-5"> 
                         <div :class="[details_abonner.abonner ? 'col-6' : 'col-12']">
                            <div v-if="$can('Modifier un adhérent')" class="form-group mr-b-0em mb-0-important">
                                <button  data-toggle="modal" data-target=".modifier-fiche-adherent" style="width : 100%;" type="button" class="btn-width-100 btn btn-primary ">{{ $t('content.bouton.modifier') }}</button>
                            </div>
                        </div>
                        <div  class="col-6">
                            <div v-if="$can('Envoyer la fiche d\'inscription') && details_abonner.abonner" class="form-group mr-b-0em mb-0-important">
                                <span class="btn-width-100 btn btn-primary " @click="FicheInscription(details_abonner.abonner.id, details_abonner.abonner.adherent)" > <i class=" mdi mdi-send"></i> Fiche d'inscription</span>
                            </div>
                        </div>
                     </div>
                       <!-- Modifier -->
        <div v-if="$can('Modifier un adhérent')" class="modal fade modifier-fiche-adherent" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
               <div class="modal-content">
                  <div class="card-header ">
                     <div class="row">
                        <div class="col-md-12">
                           <div class="d-flex justify-content-between">
                              <h3 class="card-title mb-0"> 
                                 Modification fiche adhérent 
                              </h3>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="modal-body grid-margin modal-utilisateur ">
                    <form class="form-sample" @submit.prevent="submit($event)">
                                <div class="row">

                                    


                                    <div class="col-6">
                                        <div class="form-group mr-b-0em" :class="{ 'form-group--error': $v.adherent.nom.$error }">
                                            <label class="form__label">{{$t('content.pages.adherents.profile.info_adherent.inputs.nom.titre')}}</label>
                                            <input :class="{ 'mise_a_jour' : mise_a_jour === false}" class="form-control" v-model.trim="$v.adherent.nom.$model" @input="setnom($event.target.value)" :placeholder="$t('content.pages.adherents.profile.info_adherent.inputs.nom.placeholder')" />
                                        </div>
                                        <div v-if="$v.adherent.nom.$dirty">
                                            <div class="error" v-if="!$v.adherent.nom.required">{{ $t('validation.required', { attribute : $t('content.pages.adherents.profile.info_adherent.inputs.nom.titre') }) }}</div>
                                            <div class="error" v-if="!$v.adherent.nom.minLength">
                                                {{ $t('validation.min.numeric', { attribute : $t('content.pages.adherents.profile.info_adherent.inputs.nom.titre'), min : $v.adherent.nom.$params.minLength.min }) }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group mr-b-0em" :class="{ 'form-group--error': $v.adherent.email.$error }">
                                            <label class="form__label">Adresse email</label>
                                            <input :class="{ 'mise_a_jour' : mise_a_jour === false}" class="form-control" v-model.trim="$v.adherent.email.$model" @input="setemail($event.target.value)" placeholder="Adresse email" />
                                        </div>
                                        <div v-if="$v.adherent.email.$dirty">
                                            <!--<div class="error" v-if="!$v.adherent.email.required">{{ $t('validation.required', { attribute : 'Adresse email' }) }}</div>-->
                                            <div class="error" v-if="!$v.adherent.email.minLength">
                                                {{ $t('validation.min.numeric', { attribute : 'Adresse email', min : $v.adherent.email.$params.minLength.min }) }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group mr-b-0em" :class="{ 'form-group--error': $v.adherent.id_empreinte.$error }">
                                            <label class="form__label"> ID </label>
                                            <!-- <input disabled :class="{ 'mise_a_jour' : mise_a_jour === false}" class="form-control" v-model.trim="$v.adherent.id_empreinte.$model" @input="setid_empreinte($event.target.value)" placeholder="ID empreinte" /> -->

                                            <input disabled  class="form-control" v-model.trim="$v.adherent.id_empreinte.$model"  placeholder="ID " />
                                        </div>
                                        <div v-if="$v.adherent.id_empreinte.$dirty">
                                            <div class="error" v-if="!$v.adherent.id_empreinte.numeric">
                                                
                                                ce champ doit etre un nombre entier
                                            </div> 
                                             
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group mr-b-0em" :class="{ 'form-group--error': $v.adherent.cin.$error }">
                                            <label class="form__label">{{$t('content.pages.adherents.profile.info_adherent.inputs.cin.titre')}}</label>
                                            <input :class="{ 'mise_a_jour' : mise_a_jour === false}" class="form-control" v-model.trim="$v.adherent.cin.$model" @input="setcin($event.target.value)" :placeholder="$t('content.pages.adherents.profile.info_adherent.inputs.cin.placeholder')" />
                                        </div>
                                        <div v-if="$v.adherent.cin.$dirty">
                                            <!--<div class="error" v-if="!$v.adherent.cin.required">{{ $t('validation.required', { attribute : $t('content.pages.adherents.profile.info_adherent.inputs.cin.titre') }) }}</div>-->
                                            <div class="error" v-if="!$v.adherent.cin.minLength">
                                                {{ $t('validation.min.numeric', { attribute : $t('content.pages.adherents.profile.info_adherent.inputs.cin.titre'), min : $v.adherent.cin.$params.minLength.min }) }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group mr-b-0em" :class="{ 'form-group--error': $v.adherent.tele.$error }">
                                            <label class="form__label">{{$t('content.pages.adherents.profile.info_adherent.inputs.phone.titre')}}</label>
                                            <input :class="{ 'mise_a_jour' : mise_a_jour === false}" class="form-control" v-model.trim="$v.adherent.tele.$model" @input="settele($event.target.value)" :placeholder="$t('content.pages.adherents.profile.info_adherent.inputs.phone.placeholder')" />
                                        </div>
                                        <div v-if="$v.adherent.tele.$dirty">
                                            <!--<div class="error" v-if="!$v.adherent.tele.required">{{ $t('validation.required', { attribute : $t('content.pages.adherents.profile.info_adherent.inputs.phone.titre') }) }}</div>-->
                                            <div class="error" v-if="!$v.adherent.tele.minLength">
                                                {{ $t('validation.min.numeric', { attribute : $t('content.pages.adherents.profile.info_adherent.inputs.phone.titre'), min : $v.adherent.tele.$params.minLength.min }) }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group mr-b-0em" :class="{ 'form-group--error': $v.adherent.tele_urgence.$error }">
                                            <label class="form__label">Téléphone d'urgence</label>
                                            <input :class="{ 'mise_a_jour' : mise_a_jour === false}" class="form-control" v-model.trim="$v.adherent.tele_urgence.$model" @input="settele_urgence($event.target.value)" placeholder="Téléphone d'urgence" />
                                        </div>
                                        <div v-if="$v.adherent.tele_urgence.$dirty"> 
                                            <div class="error" v-if="!$v.adherent.tele_urgence.minLength">
                                                {{ $t('validation.min.numeric', { attribute : 'Téléphone d\'urgence', min : $v.adherent.tele_urgence.$params.minLength.min }) }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group mr-b-0em" :class="{ 'form-group--error': $v.adherent.gender.$error }">
                                            <label class="form__label">{{$t('content.pages.adherents.profile.info_adherent.inputs.gender.titre')}}</label>
                                            <!--<input :class="{ 'mise_a_jour' : mise_a_jour === false}" class="form-control" v-model.trim="$v.adherent.gender.$model" @input="setgender($event.target.value)" :placeholder="$t('content.pages.adherents.profile.info_adherent.inputs.gender.placeholder')" />-->

                                            <select :class="{ 'mise_a_jour' : mise_a_jour === false}" class="form-control" v-model.trim="$v.adherent.gender.$model" @input="setgender($event.target.value)" >
                                                <option value="Homme"> Homme </option>
                                                <option value="Femme"> Femme </option>
                                            </select>

                                        </div>
                                        <div v-if="$v.adherent.gender.$dirty">
                                            <div class="error" v-if="!$v.adherent.gender.required">{{ $t('validation.required', { attribute : $t('content.pages.adherents.profile.info_adherent.inputs.gender.titre') }) }}</div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group mr-b-0em" :class="{ 'form-group--error': $v.adherent.date_naiss.$error }">
                                            <label class="form__label">{{$t('content.pages.adherents.profile.info_adherent.inputs.birth.titre')}}</label>
                                            <date-picker :class="{ 'mise_a_jour' : mise_a_jour === false}" style="width : 100%;" v-model.trim="$v.adherent.date_naiss.$model" @change="setdate_naiss" type="date"></date-picker>
                                        </div>
                                        <div v-if="$v.adherent.date_naiss.$dirty">
                                            <div class="error" v-if="!$v.adherent.date_naiss.required">{{ $t('validation.required', { attribute : $t('content.pages.adherents.profile.info_adherent.inputs.birth.titre') }) }}</div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group mr-b-0em" :class="{ 'form-group--error': $v.adherent.adresse.$error }">
                                            <label class="form__label">{{$t('content.pages.adherents.profile.info_adherent.inputs.address.titre')}}</label>
                                            <textarea :class="{ 'mise_a_jour' : mise_a_jour === false}" class="form-control" v-model.trim="$v.adherent.adresse.$model" @input="setadresse($event.target.value)" :placeholder="$t('content.pages.adherents.profile.info_adherent.inputs.address.placeholder')"> </textarea>
                                        </div>
                                        <div v-if="$v.adherent.adresse.$dirty"> 
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>{{$t('content.pages.adherents.profile.info_adherent.inputs.photos.titre')}}</label>
                                            <input type="file" id="upload-image" class="file-upload-default" v-on:change="onImageChange" :class="{ 'mise_a_jour' : mise_a_jour === false}">
                                            <div class="input-group col-xs-12">
                                                <input type="text" id="input-name-image" :class="{ 'mise_a_jour' : mise_a_jour === false}" class="form-control file-upload-info" disabled :placeholder="$t('content.pages.adherents.profile.info_adherent.inputs.photos.placeholder')">
                                                <span class="input-group-append">
                                                    <button :class="{ 'mise_a_jour' : mise_a_jour === false}" onclick="document.getElementById('upload-image').click()" class="file-upload-browse btn btn-info" type="button">{{ $t('content.bouton.upload') }}</button>
                                                </span>
                                            </div>
                                        </div>
                                        <div v-if="$v.adherent.image.$dirty">
                                            <!--<div class="error" v-if="!$v.adherent.image.required">
                                                {{ $t('validation.required', { attribute : $t('content.pages.adherents.profile.info_adherent.inputs.photos.titre') }) }}
                                            </div>-->
                                        </div>
                                    </div>
                                    <div class="col-12 text-right" v-if="mise_a_jour"><br>
                                        <div class="form-group mr-b-0em">
                                            <div class="row">
                                                <div class="col-12 text-right">
                                                    <div class="form-group mr-b-0em">
                                                        <button style="width : 35%;" type="submit" class="btn btn-success mr-2">{{ $t('content.bouton.modifier') }}</button>
                                                    </div>
                                                </div>
                                                 
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 text-right" v-else>
                                        <a href="javascript:void(0)" @click="MiseaJour"><span> <i class="mdi mdi-pen"></i> </span>{{ $t('content.bouton.mise_jour') }}</a>
                                    </div>
                                </div>
                            </form>
                  </div>
               </div>
            </div>
         </div>
         <!-- end regler -->


                </div>
            </div>
        </div>
     
</template>
<script>
import { required, minLength, numeric, decimal, between, maxLength, email } from 'vuelidate/lib/validators'

export default {
    props: ['code', 'details_adherent', 'details_abonner'],
    data() {
        return {
            adherent: {
                id_empreinte : null,
                nom: null,
                email: null,
                tele: null,
                tele_urgence: null,
                cin: null,
                gender: null,
                adresse: null,
                date_naiss: null,
                image: null,
                url: '',
            },
            formData: {},
            submitStatus: null,
            mise_a_jour: true,
            date_integration: null,
        }
    },

    mounted() {
        console.log('Component mounted.')
    },
    validations() {
        return {
            adherent: {
                id_empreinte: {
                   numeric 
                },
                nom: {
                    required,
                    minLength: minLength(3)
                },
                email: {
                    //required,
                    minLength: minLength(8)
                },
                tele: {
                    //required,
                    minLength: minLength(8)
                },
                tele_urgence: {
                     minLength: minLength(8)
                },
                cin: {
                    //required,
                    minLength: minLength(4)
                },
                gender: {
                    required
                },
                adresse: {
                    //required
                },
                date_naiss: {
                    required
                },
                image: {
                    //  required
                }
            },

        }
    },
    methods: {
        setid_empreinte(value) {
            console.log(value)
            this.adherent.id_empreinte = value
            this.$v.adherent.id_empreinte.$touch()
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
        settele_urgence(value) {
            console.log(value)
            this.adherent.tele_urgence = value
            this.$v.adherent.tele_urgence.$touch()
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
        PersonnellesInfos(code) {
            this.$v.adherent.id_empreinte.$model = this.details_adherent.id_empreinte
            this.$v.adherent.nom.$model = this.details_adherent.nom
            this.$v.adherent.email.$model = this.details_adherent.email
            this.$v.adherent.tele.$model = this.details_adherent.tele
            this.$v.adherent.tele_urgence.$model = this.details_adherent.tele_urgence
            this.$v.adherent.date_naiss.$model = new Date(this.details_adherent.date_naiss)
            this.$v.adherent.cin.$model = this.details_adherent.cin
            this.$v.adherent.gender.$model = this.details_adherent.gender
            this.$v.adherent.adresse.$model = this.details_adherent.adresse
            //this.$v.adherent.image.$model = this.details_adherent.image
            this.adherent.url = `/clubi/public/admin/adherents/photos/${this.details_adherent.image}`
            if (typeof this.details_adherent.integrations[0] !== "undefined")
                this.date_integration = this.details_adherent.integrations[0].date_debut
        },
        MiseaJour() {
            this.mise_a_jour = true
        },
        submit(event) {
            this.$v.$touch()
            console.log(this.$v.$invalid)
            if (this.$v.$invalid) {
                this.submitStatus = 'ERROR'
            } else {
                this.$fire(this.AlertFire('edit-adherent')).then((result) => {
                    if (result.value) {

                        this.submitStatus = 'PENDING'
                        this.formData = new FormData();
                        //### Informations personnelle
                        this.formData.append('adherent[code_client]', this.code);
                        if (this.$v.adherent.id_empreinte.$model != '' && this.$v.adherent.id_empreinte.$model != null)
                            this.formData.append('adherent[id_empreinte]', this.$v.adherent.id_empreinte.$model);
                             
                        if (this.$v.adherent.nom.$model != '' && this.$v.adherent.nom.$model != null)
                            this.formData.append('adherent[nom]', this.$v.adherent.nom.$model);
                        if (this.$v.adherent.email.$model != '' && this.$v.adherent.email.$model != null)
                            this.formData.append('adherent[email]', this.$v.adherent.email.$model);
                        if (this.$v.adherent.tele.$model != '' && this.$v.adherent.tele.$model != null)
                            this.formData.append('adherent[tele]', this.$v.adherent.tele.$model);
                        if (this.$v.adherent.tele_urgence.$model != '' && this.$v.adherent.tele_urgence.$model != null)
                            this.formData.append('adherent[tele_urgence]', this.$v.adherent.tele_urgence.$model);
                        if (this.$v.adherent.cin.$model != '' && this.$v.adherent.cin.$model != null)
                            this.formData.append('adherent[cin]', this.$v.adherent.cin.$model);
                        if (this.$v.adherent.gender.$model != '' && this.$v.adherent.gender.$model != null)
                            this.formData.append('adherent[gender]', this.$v.adherent.gender.$model);
                        if (this.$v.adherent.adresse.$model != '' && this.$v.adherent.adresse.$model != null)
                            this.formData.append('adherent[adresse]', this.$v.adherent.adresse.$model);
                        if (this.$v.adherent.date_naiss.$model != '' && this.$v.adherent.date_naiss.$model != null)
                            this.formData.append('adherent[date_naiss]', this.$v.adherent.date_naiss.$model.toDateString());

                        if (this.$v.adherent.image.$model != null)
                            this.formData.append('adherent[image]', this.$v.adherent.image.$model);

                     const config = { headers: { 'content-type': 'multipart/form-data' } }
                        axios.post('/api-admin/adherent/update', this.formData, config).then(res => {


                                /*var alert_unique_validation = ''
                                if (typeof res.data.unique_validation !== 'undefined') {
                                    if ( res.data.unique_validation.includes("email")) {
                                        alert_unique_validation += "L'email"
                                     }
                                    if ( res.data.unique_validation.includes("cin")) {
                                        if (alert_unique_validation != ''){
                                            alert_unique_validation += ", "
                                        }
                                        alert_unique_validation += "Le CIN"
                                    }
                                    if ( res.data.unique_validation.includes("tele")) {
                                        if (alert_unique_validation != ''){
                                            alert_unique_validation += " et "
                                        }
                                        alert_unique_validation += "Le numéro de téléphone"
                                    }
                                    if (alert_unique_validation != '')
                                        alert_unique_validation += " entré existe déja"
                                        this.AlertResponseFalse("", alert_unique_validation, "warning");
                                } */


                                if (typeof res.data.email_adherent !== 'undefined') {
                                    this.AlertResponseFalse("", "L'email entré existe déja", "warning");
                                 }
                                else if (typeof res.data.empriente_existe !== 'undefined') {
                                    this.AlertResponseFalse("", "ID Empeinte entré existe déja", "warning");
                                 }
                                 else{
                                switch (res.data) {
                                    case false:
                                        this.AlertResponseFalse("", this.$t('content.alerts.adherents.n_existe'), "warning");
                                        this.PersonnellesInfos(this.code)
                                        break;
                                    default:
                                        $('.modifier-fiche-adherent').modal('hide');

                                        this.AlertResponseTrue("", this.$t('content.alerts.modification_adherent.success'), "success");
                                        this.mise_a_jour = true
                                        break;
                                }
                            }
                            }).catch(e => {})
                            .finally(f => {
                                setTimeout(() => {
                                    this.submitStatus = 'OK'
                                }, 500)
                            })
                    }
                })
            }
        },
        Annuler() {
            this.PersonnellesInfos(this.code)
            this.mise_a_jour = true

        },
        FicheInscription(id_abonner, adherent){
             
            if(adherent.email != '' && adherent.email != null) {
                this.$fire(this.AlertFire('envoi_mail')).then((result) => {
                    if (result.value) 
                        window.location.href = "/api-admin/fiche-inscription/"+id_abonner
                });
            }else{
                this.AlertResponseFalse("", "L'e-mail est vide", "warning");
            }

 
        }
    },
    beforeMount() {
        this.PersonnellesInfos(this.code);
        console.log(this.details_adherent)

    },
    computed:{
        calculateAge () {
          let currentDate = new Date();
          let birthDate = new Date(this.details_adherent.date_naiss);
          let difference = currentDate - birthDate;
          let age = Math.floor(difference/31557600000);
          return age
        },
        capitalizedNom() {
            return this.$v.adherent.nom.$model.toUpperCase(); // or use any other capitalization logic
         },
      },
    mounted() {},
}

</script>
<style>
.mise_a_jour {
    background: #eee;
    pointer-events: none;
}

</style>
