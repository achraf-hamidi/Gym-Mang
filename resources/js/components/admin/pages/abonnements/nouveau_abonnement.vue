<template>
    <div class="main-panel">
        <div v-if="$can('Ajouter un abonnement')" class="content-wrapper">
            <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                    <div ref="formContainer" class="card">
                        <div class="card-header ">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="d-flex justify-content-between">
                                        <h3 class="card-title mb-0">{{ $t('content.pages.abonnements.nouveau.titre') }}
                                        </h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <form-wizard :ref="'vuewizard'" @on-change="onChangeStep" @on-complete="submit" title=""
                                subtitle="" shape="circle" :back-button-text="$t('content.bouton.prev')"
                                :next-button-text="$t('content.bouton.next')"
                                :finish-button-text="$t('content.bouton.enregistrer')" color="#ff9c00e6"><br>
                                <tab-content :title="$t('content.pages.abonnements.nouveau.steps.infos')"
                                    icon="mdi  mdi-account-outline">
                                    <!--<form @submit.prevent="submit($event)" class="forms-sample">-->
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-check form-check-flat">
                                                <label class="form-check-label">
                                                    <input type="checkbox" @click="disabledButtonSuivant"
                                                        class="form-check-input" v-model="abonner.renouvler"> {{
                                                            $t('content.pages.abonnements.nouveau.inputs.infos.checkbox')
                                                        }} <i
                                                        class="input-helper"></i></label>
                                            </div><br>
                                        </div>
                                    </div>
                                    <div v-if="!abonner.renouvler" class="row">
                                        <div class="col-6">
                                            <div class="form-group mr-b-0em"
                                                :class="{ 'form-group--error': $v.adherent.nom.$error }">
                                                <label
                                                    class="form__label">{{ $t('content.pages.abonnements.nouveau.inputs.infos.nom.titre') }}</label>
                                                <input class="form-control" v-model.trim="$v.adherent.nom.$model"
                                                    @input="setnom($event.target.value)"
                                                    :placeholder="$t('content.pages.abonnements.nouveau.inputs.infos.nom.placeholder')" />
                                            </div>
                                            <div v-if="$v.adherent.nom.$dirty">
                                                <div class="error"
                                                    v-if="!$v.adherent.nom.required && submitStatus == true">{{
                                                $t('validation.required', { attribute:
                                                    $t('content.pages.abonnements.nouveau.inputs.infos.nom.titre') }) }}
                                                </div>
                                                <div class="error" v-if="!$v.adherent.nom.minLength">
                                                    {{
    $t('validation.min.numeric', { attribute:
        $t('content.pages.abonnements.nouveau.inputs.infos.nom.titre'), min
                                                    : $v.adherent.nom.$params.minLength.min }) }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group mr-b-0em"
                                                :class="{ 'form-group--error': $v.adherent.email.$error }">
                                                <label
                                                    class="form__label">{{ $t('content.pages.abonnements.nouveau.inputs.infos.email.titre') }}</label>
                                                <input class="form-control" v-model.trim="$v.adherent.email.$model"
                                                    @input="setemail($event.target.value)"
                                                    :placeholder="$t('content.pages.abonnements.nouveau.inputs.infos.email.placeholder')" />
                                            </div>
                                            <div v-if="$v.adherent.email.$dirty">
                                                <!--<div class="error" v-if="!$v.adherent.email.required && submitStatus == true ">{{ $t('validation.required', { attribute : $t('content.pages.abonnements.nouveau.inputs.infos.email.titre') }) }}</div>
                                                <div class="error" v-if="!$v.adherent.email.minLength">
                                                    {{ $t('validation.min.numeric', { attribute : $t('content.pages.abonnements.nouveau.inputs.infos.email.titre'), min : $v.adherent.email.$params.minLength.min }) }}
                                                </div>-->
                                                <div class="error" v-if="!$v.adherent.email.email">
                                                    S'il vous plaît, mettez une adresse email valide
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                        <!-- <div class="form-group mr-b-0em" :class="{ 'form-group--error': $v.adherent.id_empreinte.$error }">
                                            <label class="form__label"> ID empreinte</label>
                                            <input disabled class="form-control" v-model.trim="$v.adherent.id_empreinte.$model" @input="setid_empreinte(this.latestIdEmpreinte)"  :placeholder="latestIdEmpreinte ? latestIdEmpreinte : 'ID empreinte'" />
                                        </div>
                                        <div v-if="$v.adherent.id_empreinte.$dirty">
                                            <div class="error" v-if="!$v.adherent.id_empreinte.numeric">
                                                ce champ doit etre un nombre entier
                                            </div> 
                                             
                                        </div> -->

                                        <div class="form-group mr-b-0em" :class="{ 'form-group--error': $v.adherent.id_empreinte.$error }">
                                        <label class="form__label"> ID </label>
                                        <input disabled class="form-control" v-model.trim="$v.adherent.id_empreinte.$model" @input="setidempreinte()"  :placeholder="latestIdEmpreinte ? latestIdEmpreinte : 'ID '" />
                                        </div>
                                        <div v-if="$v.adherent.id_empreinte.$dirty">
                                            <div class="error" v-if="!$v.adherent.id_empreinte.numeric">
                                            ce champ doit etre un nombre entier
                                            </div>
                                        </div>

                                    </div>
                                        <div class="col-6">
                                            <div class="form-group mr-b-0em"
                                                :class="{ 'form-group--error': $v.adherent.cin.$error }">
                                                <label
                                                    class="form__label">{{ $t('content.pages.abonnements.nouveau.inputs.infos.cin.titre') }}</label>
                                                <input class="form-control" v-model.trim="$v.adherent.cin.$model"
                                                    @input="setcin($event.target.value)"
                                                    :placeholder="$t('content.pages.abonnements.nouveau.inputs.infos.cin.placeholder')" />
                                            </div>
                                            <div v-if="$v.adherent.cin.$dirty">
                                                <!--<div class="error" v-if="!$v.adherent.cin.required && submitStatus == true ">{{ $t('validation.required', { attribute : $t('content.pages.abonnements.nouveau.inputs.infos.cin.titre') }) }}</div>-->
                                                <div class="error" v-if="!$v.adherent.cin.minLength">
                                                    {{ 'Veuillez entrer une valeur correcte' }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group mr-b-0em"
                                                :class="{ 'form-group--error': $v.adherent.tele.$error }">
                                                <label
                                                    class="form__label">{{ $t('content.pages.abonnements.nouveau.inputs.infos.tele.titre') }}</label>
                                                <input class="form-control" v-model.trim="$v.adherent.tele.$model"
                                                    @input="settele($event.target.value)"
                                                    :placeholder="$t('content.pages.abonnements.nouveau.inputs.infos.tele.placeholder')" />
                                            </div>
                                            <div v-if="$v.adherent.tele.$dirty">
                                                <!--<div class="error" v-if="!$v.adherent.tele.required && submitStatus == true ">{{ $t('validation.required', { attribute : $t('content.pages.abonnements.nouveau.inputs.infos.tele.titre') }) }}</div>-->
                                                <div class="error" v-if="!$v.adherent.tele.minLength">
                                                    {{
    $t('validation.min.numeric', { attribute:
        $t('content.pages.abonnements.nouveau.inputs.infos.tele.titre'), min
                                                    : $v.adherent.tele.$params.minLength.min }) }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group mr-b-0em"
                                                :class="{ 'form-group--error': $v.adherent.tele_urgence.$error }">
                                                <label class="form__label">Téléphone d’urgence </label>
                                                <input class="form-control"
                                                    v-model.trim="$v.adherent.tele_urgence.$model"
                                                    @input="settele_urgence($event.target.value)"
                                                    placeholder="Téléphone d’urgence" />
                                            </div>
                                            <div v-if="$v.adherent.tele_urgence.$dirty">

                                                <div class="error" v-if="!$v.adherent.tele_urgence.minLength">
                                                    {{
                                                        $t('validation.min.numeric', { attribute: 'Téléphone parent' ,
                                                            min: $v.adherent.tele_urgence.$params.minLength.min
                                                    }) }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group mr-b-0em"
                                                :class="{ 'form-group--error': $v.adherent.gender.$error }">
                                                <label
                                                    class="form__label">{{ $t('content.pages.abonnements.nouveau.inputs.infos.genre.titre') }}</label>
                                                <!-- <input class="form-control"  v-model.trim="$v.adherent.gender.$model" @input="setgender($event.target.value)" :placeholder="$t('content.pages.abonnements.nouveau.inputs.infos.genre.placeholder')" />-->
                                                <select class="form-control" v-model.trim="$v.adherent.gender.$model"
                                                    @input="setgender($event.target.value)">
                                                    <option :value="$t('content.text.homme')">
                                                        {{ $t('content.text.homme') }}</option>
                                                    <option :value="$t('content.text.femme')">
                                                        {{ $t('content.text.femme') }}</option>
                                                </select>
                                            </div>
                                            <div v-if="$v.adherent.gender.$dirty">
                                                <div class="error"
                                                    v-if="!$v.adherent.gender.required && submitStatus == true">{{
    $t('validation.required', { attribute:
        $t('content.pages.abonnements.nouveau.inputs.infos.genre.titre') })
                                                    }}</div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group mr-b-0em"
                                                :class="{ 'form-group--error': $v.adherent.date_naiss.$error }">
                                                <label
                                                    class="form__label">{{ $t('content.pages.abonnements.nouveau.inputs.infos.date_naiss.titre') }}</label>
                                                <date-picker format="DD/MM/YYYY" style="width : 100%;"
                                                    v-model.trim="$v.adherent.date_naiss.$model" @change="setdate_naiss"
                                                    type="date"></date-picker>
                                            </div>
                                            <div v-if="$v.adherent.date_naiss.$dirty">
                                                <div class="error"
                                                    v-if="!$v.adherent.date_naiss.required && submitStatus == true">{{
    $t('validation.required', { attribute:
        $t('content.pages.abonnements.nouveau.inputs.infos.date_naiss.titre')
                                                    }) }}</div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group mr-b-0em"
                                                :class="{ 'form-group--error': $v.adherent.adresse.$error }">
                                                <label
                                                    class="form__label">{{ $t('content.pages.abonnements.nouveau.inputs.infos.address.titre') }}</label>
                                                <textarea class="form-control" v-model.trim="$v.adherent.adresse.$model"
                                                    @input="setadresse($event.target.value)"
                                                    :placeholder="$t('content.pages.abonnements.nouveau.inputs.infos.address.placeholder')"> </textarea>
                                            </div>
                                            <div v-if="$v.adherent.adresse.$dirty">
                                                <!--<div class="error" v-if="!$v.adherent.adresse.required && submitStatus == true ">{{ $t('validation.required', { attribute : $t('content.pages.abonnements.nouveau.inputs.infos.address.titre') }) }}</div>-->
                                            </div>
                                        </div>
                                        <div class="col-11">
                                            <div class="form-group">
                                                <label>{{ $t('content.pages.abonnements.nouveau.inputs.infos.photos.titre') }} </label>
                                                <input type="file" id="upload-image" class="file-upload-default"
                                                    v-on:change="onImageChange" accept="image/*">
                                                <div class="input-group col-xs-12">
                                                    <input type="text" id="input-name-image"
                                                        class="form-control file-upload-info" disabled
                                                        :placeholder="$t('content.pages.abonnements.nouveau.inputs.infos.photos.placeholder')">
                                                    <span class="input-group-append">
                                                        <button
                                                            onclick="document.getElementById('upload-image').click()"
                                                            class="file-upload-browse btn btn-info" type="button">{{
                                                                $t('content.bouton.upload')
                                                            }}</button>
                                                    </span>
                                                </div>
                                            </div>
                                            <div v-if="$v.adherent.image.$dirty">
                                                <!--<div class="error" v-if="!$v.adherent.image.required && submitStatus == true ">{{ $t('validation.required', { attribute : $t('content.pages.abonnements.nouveau.inputs.infos.photos.titre') }) }}</div>-->
                                            </div>
                                        </div>
                                        <!--<div class="col-6">
                                            <div class="form-group mr-b-0em" :class="{ 'form-group--error': $v.adherent.code_client.$error }">
                                                <label class="form__label"> {{$t('content.pages.abonnements.nouveau.inputs.infos.parrain.titre')}}</label>
                                                <input class="form-control" v-model.trim="$v.adherent.code_client.$model" @input="setcode_client($event.target.value)" :placeholder="$t('content.pages.abonnements.nouveau.inputs.infos.parrain.titre')" />
                                            </div>
                                            <div v-if="$v.adherent.code_client.$dirty">
                                                <div class="error" v-if="!$v.adherent.code_client.required && submitStatus == true ">{{ $t('validation.required', { attribute : $t('content.pages.abonnements.nouveau.inputs.infos.parrain.titre') }) }}</div>
                                                <div class="error" v-if="!$v.adherent.code_client.minLength">
                                                    {{ $t('validation.min.numeric', { attribute : $t('content.pages.abonnements.nouveau.inputs.infos.parrain.titre'), min : $v.adherent.code_client.$params.minLength.min }) }}
                                                </div>
                                            </div>
                                        </div>-->
                                        <div class="col-1">
                                            <div class="form-groups">
                                                <img class="image-base64" :src="adherent.url">
                                            </div>
                                        </div>
                                    </div>
                                    <div v-else class="row">
                                        <!---->
                                        <div class="col-md-12">
                                            <div class="form-group mr-b-0em"
                                                :class="{ 'form-group--error': $v.adherent.code_client.$error }">
                                                <label class="form__label"> ID </label>
                                                <div class="row verifier-adherent ">
                                                    <div class="col-mobile"
                                                        :class="[(typeof $route.query.matricule === 'undefined') ? 'col-md-9' : 'col-md-12']">
                                                        <input @keyup.enter="VerifierAdherent" class="form-control"
                                                            v-model.trim="$v.adherent.code_client.$model"
                                                            @input="setcode_client($event.target.value)"
                                                            placeholder="Matricule ou Cin" />
                                                    </div>
                                                    <div v-if="typeof $route.query.matricule === 'undefined'"
                                                        class="col-mobile col-md-3">
                                                        <button style="width : 100%;" type="button"
                                                            @click="VerifierAdherent"
                                                            class="btn btn-primary mr-2">Vérifier l'adhérent</button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div v-if="$v.adherent.code_client.$dirty">
                                                <div class="error"
                                                    v-if="!$v.adherent.code_client.required && submitStatus == true">{{
    $t('validation.required', { attribute:
        $t('content.pages.abonnements.nouveau.inputs.infos.matricule.titre')
                                                    }) }}</div>
                                                <div class="error" v-if="!$v.adherent.code_client.minLength">
                                                    {{
                                                    $t('validation.min.numeric', { attribute:
                                                        $t('content.pages.abonnements.nouveau.inputs.infos.matricule.titre')
                                                    , min : $v.adherent.code_client.$params.minLength.min }) }}
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <!--</form>-->
                                </tab-content>
                                <tab-content :title="$t('content.pages.abonnements.nouveau.steps.packs')"
                                    icon="mdi mdi-settings">
                                    <div class="row">
                                        <!--<div class="col-12">
                                            <div class="form-check form-check-flat">
                                                <label class="form-check-label">
                                                    <input type="checkbox" class="form-check-input" v-model="abonner.hasAbonner" @change="CheckBoxHasAbonner"> {{$t('content.pages.adherents.add_modale.inputs.subscription.checkbox')}} <i class="input-helper"></i></label>
                                            </div>
                                        </div>-->
                                        <div class="col-6">
                                            <div class="form-group mr-b-0em">
                                                <label class="form__label">
                                                    {{
                                                        $t('content.pages.abonnements.nouveau.inputs.abonnements.date_debut.titre')
                                                    }}</label>
                                                <date-picker format="DD/MM/YYYY" style="width : 100%;"
                                                    v-model.trim="$v.abonner.date_debut.$model" type="date"
                                                    @change="setdate_debut"></date-picker>
                                            </div>
                                            <div v-if="$v.abonner.date_debut.$dirty">
                                                <div class="error"
                                                    v-if="!$v.abonner.date_debut.required && submitStatus == true">{{
    $t('validation.required', { attribute:
        $t('content.pages.abonnements.nouveau.inputs.abonnements.date_debut.titre')
                                                    }) }}</div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group mr-b-0em"
                                                :class="{ 'form-group--error': $v.abonner.remise.$error }">
                                                <label
                                                    class="form__label">{{ $t('content.pages.abonnements.nouveau.inputs.abonnements.remise.titre') }}</label>
                                                <input class="form-control" v-model.trim="$v.abonner.remise.$model"
                                                    @input="setremise($event.target.value)" @focusout="isRemiseNull"
                                                    :placeholder="$t('content.pages.abonnements.nouveau.inputs.abonnements.remise.titre')" />
                                            </div>
                                            <div v-if="$v.abonner.remise.$dirty">
                                                <div class="error" v-if="!$v.abonner.remise.decimal">
                                                    {{
    $t('validation.numeric', { attribute:
        $t('content.pages.abonnements.nouveau.inputs.abonnements.remise.titre')
                                                    }) }}
                                                </div>
                                            </div>
                                        </div>
                                        <!--<div class="col-6">
                                            <div class="form-group mr-b-0em">
                                                <label class="form__label"> {{$t('content.pages.abonnements.nouveau.inputs.abonnements.abonnement.titre')}}</label>
                                                <select class="form-control" v-model.trim="$v.abonner.id_abonnement.$model" @input="setid_abonnement($event.target.value)">
                                                    <option v-for="(abonnement, index) in abonnements" :value="abonnement"> {{ abonnement.libelle }} </option>
                                                </select>
                                            </div>
                                            <div v-if="$v.abonner.id_abonnement.$dirty">
                                                <div class="error" v-if="!$v.abonner.id_abonnement.required && submitStatus == true ">{{ $t('validation.required', { attribute : $t('content.pages.abonnements.nouveau.inputs.abonnements.abonnement.titre') }) }}</div>
                                            </div>
                                        </div>-->
                                        <div class="col-md-6">
                                            <div class="form-group mr-b-0em">
                                                <label class="form__label">
                                                    {{ $t('content.pages.abonnements.nouveau.inputs.abonnements.abonnement.titre') }}</label>
                                                <multiselect v-model.trim="$v.abonner.id_abonnement.$model"
                                                    @input="setid_abonnement($event)" :options="abonnements"
                                                    :custom-label="libeleAbonnement" placeholder="Recherche.."
                                                    label="libelle" track-by="libelle"></multiselect>
                                            </div>
                                            <div v-if="$v.abonner.id_abonnement.$dirty">
                                                <div class="error"
                                                    v-if="!$v.abonner.id_abonnement.required && submitStatus == true">
                                                    {{
    $t('validation.required', { attribute:
        $t('content.pages.abonnements.nouveau.inputs.abonnements.abonnement.titre')
                                                    }) }}</div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mr-b-0em">
                                                <label class="form__label">{{
                                                    $t('content.pages.abonnements.nouveau.inputs.abonnements.packs.titre')
                                                }}</label>
                                                <multiselect v-model.trim="$v.abonner.id_pack.$model"
                                                    @input="setid_pack($event)" :options="packs"
                                                    :custom-label="libelePack" placeholder="Recherche.."
                                                    label="description" track-by="description"></multiselect>
                                            </div>
                                            <div v-if="$v.abonner.id_pack.$dirty">
                                                <div class="error"
                                                    v-if="!$v.abonner.id_pack.required && submitStatus == true">{{
    $t('validation.required', { attribute:
        $t('content.pages.abonnements.nouveau.inputs.abonnements.packs.titre')
                                                    }) }}</div>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group mr-b-0em">
                                                <label class="form__label">Les frais</label>
                                                <multiselect v-model.trim="arr_frais" :options="tous_les_frais"
                                                    :custom-label="TousLesFrais" placeholder="Recherche.."
                                                    label="libelle" track-by="libelle" :multiple="true" @tag="addFrais"
                                                    @input="setfrais($event)"></multiselect>
                                            </div>
                                            <span class="prix-total">
                                                <b>Total des frais est</b> : {{ totalFrais }} {{ $t('content.text.dh') }}
                                            </span>
                                        </div>

                                        <!--<div class="col-6">
                                            <div class="form-group mr-b-0em">
                                                <label class="form__label">{{ $t('content.pages.abonnements.nouveau.inputs.abonnements.packs.titre')}}</label>
                                                <select class="form-control" v-model.trim="$v.abonner.id_pack.$model" @input="setid_pack($event.target.value)">
                                                    <option v-for="(pack, index) in packs" :value="pack">
                                                        {{ pack.description }} ( <span v-for="(acts) in pack.activities"> {{ acts.name }} </span> )
                                                    </option>
                                                </select>
                                            </div>
                                            <div v-if="$v.abonner.id_pack.$dirty">
                                                <div class="error" v-if="!$v.abonner.id_pack.required && submitStatus == true ">{{ $t('validation.required', { attribute : $t('content.pages.abonnements.nouveau.inputs.abonnements.packs.titre') }) }}</div>
                                            </div>
                                        </div>-->
                                    </div>
                                </tab-content>
                                <tab-content :title="$t('content.pages.abonnements.nouveau.steps.paiements')"
                                    icon=" mdi mdi-currency-usd">
                                    <div class="row mb-1">
                                        <div v-if="!is_compte_assuree.date_assuree" class="col-md-12">
                                            <div class="form-check form-check-flat">
                                                <label class="form-check-label">
                                                    <input type="checkbox" class="form-check-input"
                                                        v-model="checkbox_assurance" @input="OnCheckedAssurance">
                                                    {{ $t('content.pages.abonnements.nouveau.inputs.paiements.checkbox_ass') }}
                                                    <i class="input-helper"></i></label>
                                            </div><br>
                                        </div>
                                        <div class="col-md-12">
                                            <div v-if="!assurance.hasAssurance" class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group mr-b-0em"
                                                        :class="{ 'form-group--error': $v.assurance.date_assuree.$error }">
                                                        <label class="form__label"> Date déclaration d'assurance
                                                        </label>
                                                        <date-picker format="DD/MM/YYYY" style="width : 100%;"
                                                            v-model.trim="$v.assurance.date_assuree.$model"
                                                            @change="setdate_assuree"></date-picker>
                                                    </div>
                                                    <div v-if="$v.assurance.date_assuree.$dirty">
                                                        <!--<div class="error" v-if="!$v.assurance.date_assuree.required && submitStatus == true ">{{ $t('validation.required', { attribute : $t('content.pages.abonnements.nouveau.inputs.assurance.date_assuree.titre') }) }}</div>-->
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-group mr-b-0em">
                                                        <label class="form__label"> Durée d'assurance</label>
                                                        <!--<select class="form-control" v-model.trim="$v.assurance.duree_assurance.$model" @input="setduree_assurance($event.target.value)">
                                                            <option value="0"> 0 Mois </option>
                                                            <option value="90"> 3 Mois </option>
                                                            <option value="182"> 6 Mois </option>
                                                            <option value="365"> 12 Mois </option>
                                                        </select>-->

                                                        <multiselect v-model.trim="$v.assurance.typeassurance.$model"
                                                            @input="settypeassurance($event)" :options="assurances"
                                                            :custom-label="libeleAssurance" placeholder="Recherche.."
                                                            label="id" track-by="id"></multiselect>

                                                    </div>
                                                    <div v-if="$v.assurance.duree_assurance.$dirty">
                                                        <!-- <div class="error" v-if="!$v.assurance.duree_assurance.required && submitStatus == true ">{{ $t('validation.required', { attribute : $t('content.pages.abonnements.nouveau.inputs.abonnements.abonnement.titre') }) }}</div>-->
                                                    </div>
                                                </div>
                                                <!--<div class="col-3">
                                                    <div class="form-group mr-b-0em" :class="{ 'form-group--error': $v.assurance.prix_assurance.$error }">
                                                        <label class="form__label">Prix</label>
                                                        <input disabled class="form-control" v-model.trim="$v.assurance.prix_assurance.$model" @input="setprix_assurance($event.target.value)" placeholder="prix.." />
                                                    </div>
                                                    <div v-if="$v.assurance.prix_assurance.$dirty">
                                                        <div class="error" v-if="!$v.assurance.prix_assurance.decimal">
                                                            {{ $t('validation.numeric', { attribute : $t('content.pages.abonnements.nouveau.inputs.assurance.prix.titre') }) }}
                                                        </div>
                                                        <div class="error" v-if="!$v.assurance.prix_assurance.required && submitStatus == true ">{{ $t('validation.required', { attribute : $t('content.pages.abonnements.nouveau.inputs.assurance.prix.titre') }) }}</div>
                                                        <div class="error" v-if="!$v.assurance.prix_assurance.isThanZero  ">
                                                        prix than a zero
                                                    </div> 
                                                    </div>
                                                </div>-->
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div v-if="is_compte_assuree.date_assuree" class="row">
                                                <div class="col-md-12">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <span> <b>Compte assuré</b> : {{
                                                                is_compte_assuree.date_assuree | formatDate
                                                            }} </span>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <span> <b>Date échéance assurance</b> : {{
                                                                is_compte_assuree.date_fin | formatDate
                                                            }} </span>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <span> <b>Jours restant</b> : {{
                                                                is_compte_assuree.RestDays
                                                            }} Jours </span>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <span> <b>Prix assurée</b> : {{ is_compte_assuree.prix }}
                                                                {{ $t('content.text.dh') }} </span>
                                                        </div>
                                                    </div><br><br>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-check form-check-flat">
                                                <label class="form-check-label">
                                                    <input type="checkbox" class="form-check-input"
                                                        v-model="paiements.hasPaiement">
                                                    {{ $t('content.pages.abonnements.nouveau.inputs.paiements.checkbox') }}
                                                    <i class="input-helper"></i></label>
                                            </div><br>
                                        </div>
                                    </div>
                                     <div v-if="paiements.hasPaiement">
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="form-group mr-b-0em"
                                                    :class="{ 'form-group--error': $v.paiements.date_paiement.$error }">
                                                    <label
                                                        class="form__label">{{ $t('content.pages.abonnements.nouveau.inputs.paiements.date_paiement.titre') }}</label>
                                                    <!-- <date-picker format="DD/MM/YYYY" style="width : 100%;"
                                                        v-model.trim="$v.paiements.date_paiement.$model"
                                                        @change="setdate_paiement" readonly></date-picker> -->
                                                      <date-picker 
                                                        format="DD/MM/YYYY" 
                                                        style="width: 100%;"
                                                        v-model.trim="$v.paiements.date_paiement.$model"
                                                        @change="setdate_paiement"
                                                        :disabled=true
                                                        ></date-picker>
                                                </div>
                                                <div v-if="$v.paiements.date_paiement.$dirty">
                                                    <div class="error"
                                                        v-if="!$v.paiements.date_paiement.required && submitStatus == true">
                                                        {{
    $t('validation.required', { attribute:
        $t('content.pages.abonnements.nouveau.inputs.paiements.date_paiement.titre')
                                                        }) }}</div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group mr-b-0em"
                                                    :class="{ 'form-group--error': $v.paiements.prix.$error }">
                                                    <label
                                                        class="form__label">{{ $t('content.pages.abonnements.nouveau.inputs.paiements.prix.titre') }}</label>
                                                    <input class="form-control" v-model.trim="$v.paiements.prix.$model"
                                                        @input="setprix($event.target.value)"
                                                        :placeholder="$t('content.pages.abonnements.nouveau.inputs.paiements.prix.placeholder')" />
                                                </div>
                                                <div v-if="$v.paiements.prix.$dirty">
                                                    <div class="error" v-if="!$v.paiements.prix.decimal">
                                                        {{
    $t('validation.numeric', { attribute:
        $t('content.pages.abonnements.nouveau.inputs.paiements.prix.titre')
                                                        }) }}
                                                    </div>
                                                    <div class="error"
                                                        v-if="!$v.paiements.prix.required && submitStatus == true">{{
    $t('validation.required', { attribute:
        $t('content.pages.abonnements.nouveau.inputs.paiements.prix.titre')
                                                        }) }}</div>
                                                    <div class="error"
                                                        v-if="!$v.paiements.prix.isThanZero || !$v.paiements.prix.CheckMontantPaye">
                                                        Vérifier le montant payé
                                                    </div>
                                                    <!--<div class="error" v-if="!$v.paiements.prix.CheckMontantPaye">
                                                        Vous payez plus que le net à payer
                                                        Vérifier le montant payé
                                                    </div>-->
                                                    <div class="error" v-if="!$v.paiements.prix.CheckPrixAssurance">
                                                        Vous devez payer au moins le prix total de l'assurance
                                                        (Obligatoire)
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group mr-b-0em"
                                                    :class="{ 'form-group--error': $v.paiements.date_echeance.$error }">
                                                    <label class="form__label">Date écheance</label>
                                                    <date-picker format="DD/MM/YYYY" style="width : 100%;"
                                                        v-model.trim="$v.paiements.date_echeance.$model"
                                                        @change="setdate_echeance"></date-picker>
                                                </div>
                                                <div v-if="$v.paiements.date_echeance.$dirty">

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="check-infos-adherent col-md-6" style="margin-top: 25px;">
                                            <div v-if="!abonner.renouvler">
                                                <h5 class="">INFORMATION ADHÉRENT</h5>
                                                <p :class="{ 'validate-champs': $v.adherent.nom.$error }"
                                                    class="form__label">
                                                    <b>{{ $t('content.pages.abonnements.nouveau.inputs.infos.nom.titre') }}
                                                        : </b> {{ $v.adherent.nom.$model }} </p>
                                                <p :class="{ 'validate-champs': $v.adherent.email.$error }"
                                                    class="form__label">
                                                    <b>{{ $t('content.pages.abonnements.nouveau.inputs.infos.email.titre') }}
                                                        : </b> {{ $v.adherent.email.$model }} </p>
                                                <p :class="{ 'validate-champs': $v.adherent.cin.$error }"
                                                    class="form__label">
                                                    <b>{{ $t('content.pages.abonnements.nouveau.inputs.infos.cin.titre') }}
                                                        : </b> {{ $v.adherent.cin.$model }} </p>
                                                <p :class="{ 'validate-champs': $v.adherent.tele.$error }"
                                                    class="form__label">
                                                    <b>{{ $t('content.pages.abonnements.nouveau.inputs.infos.tele.titre') }}
                                                        : </b> {{ $v.adherent.tele.$model }} </p>
                                                <p :class="{ 'validate-champs': $v.adherent.tele_urgence.$error }"
                                                    class="form__label"><b>Téléphone d'urgence : </b> {{
                                                        $v.adherent.tele_urgence.$model
                                                    }} </p>
                                                <p :class="{ 'validate-champs': $v.adherent.date_naiss.$error }"
                                                    class="form__label">
                                                    <b>{{ $t('content.pages.abonnements.nouveau.inputs.infos.date_naiss.titre') }}
                                                        : </b> {{ $v.adherent.date_naiss.$model | formatDate }} </p>
                                                <p :class="{ 'validate-champs': $v.adherent.gender.$error }"
                                                    class="form__label">
                                                    <b>{{ $t('content.pages.abonnements.nouveau.inputs.infos.genre.titre') }}
                                                        : </b> {{ $v.adherent.gender.$model }} </p>
                                                <!--<p :class="{ 'validate-champs': $v.adherent.adresse.$error }" class="form__label" ><b>Adresse : </b> {{ $v.adherent.adresse.$model }} </p>-->
                                                <p class="form__label">
                                                    <b>{{ $t('content.pages.abonnements.nouveau.inputs.infos.address.titre') }}
                                                        : </b> {{ $v.adherent.adresse.$model }} </p>
                                            </div>
                                            <div v-else>
                                                <p :class="{ 'validate-champs': $v.adherent.code_client.$error }"
                                                    class="form__label"><b>Matricule : </b> {{
                                                        $v.adherent.code_client.$model
                                                    }} </p>
                                                <p class="form__label">
                                                    <b>{{ $t('content.pages.abonnements.nouveau.inputs.infos.nom.titre') }}
                                                        : </b> {{ adherent_renouvler.nom }} </p>
                                                <!--<p class="form__label"><b>Email : </b> {{ adherent_renouvler.email }} </p>-->
                                                <p class="form__label">
                                                    <b>{{ $t('content.pages.abonnements.nouveau.inputs.infos.cin.titre') }}
                                                        : </b> {{ adherent_renouvler.cin }} </p>
                                                <p class="form__label">
                                                    <b>{{ $t('content.pages.abonnements.nouveau.inputs.infos.tele.titre') }}
                                                        : </b> {{ adherent_renouvler.tele }} </p>
                                                <!--<p class="form__label"><b>Téléphone parent : </b> {{ adherent_renouvler.tele_urgence }} </p>
                                            <p class="form__label"><b>Date de naissance : </b> {{ adherent_renouvler.date_naiss | formatDate  }} </p>
                                            <p class="form__label" ><b>Gene : </b> {{ adherent_renouvler.gender }} </p>
                                            <p class="form__label" ><b>Adresse : </b> {{ adherent_renouvler.adresse }} </p>-->


                                            </div>
                                        </div>
                                        <div class="check-infos-paiements invioce-adherent col-6">
                                            <h5 class=""> INFORMATIONS DE PAIEMENT</h5>
                                            <div class="float-left form-group mr-b-0em">
                                                <p v-if="$v.abonner.id_abonnement.$model" class="form__label">
                                                    <span>{{
                                                        $t('content.pages.abonnements.nouveau.facture.abonnement')
                                                    }}</span> : {{ $v.abonner.id_abonnement.$model.libelle }} (
                                                    {{ $v.abonner.id_abonnement.$model.nb_mois }} {{
                                                        $t('content.pages.abonnements.nouveau.facture.month')
                                                    }} )
                                                </p>
                                                <p v-if="$v.abonner.id_pack.$model" class="form__label">
                                                    <span>{{
                                                        $t('content.pages.abonnements.nouveau.facture.packs')
                                                    }}</span> :
                                                    {{ getNum(parseFloat($v.abonner.id_pack.$model.prix).toFixed(2)) }}
                                                    {{ $t('content.text.dh') }}/{{ $v.abonner.id_abonnement.$model.nb_mois }} mois
                                                </p>

                                                <p v-if="$v.assurance.typeassurance.$model" class="form__label">
                                                    <span>Prix assurance </span> : {{
                                                        getNum(
                                                            $v.assurance.typeassurance.$model.prix )
                                                    }}
                                                    {{ $t('content.text.dh') }}
                                                    <!--/ {{ $v.assurance.typeassurance.$model.nb_mois }} mois-->
                                                </p>
                                                <p v-if="totalFrais > 0">
                                                    <span>
                                                        Total des frais :
                                                    </span>
                                                    {{ getNum(totalFrais) }} {{ $t('content.text.dh') }}
                                                </p>
                                                <p class="form__label">
                                                    <span v-if="$v.abonner.id_pack.$model">
                                                        {{ $t('content.pages.abonnements.nouveau.facture.remise') }}
                                                        <span
                                                            v-if="(typeof $v.abonner.id_pack.$model.promotions !== 'undefined') && (typeof $v.abonner.id_pack.$model.promotions[0] !== 'undefined')">
                                                            + Promo </span>
                                                    </span> :
                                                    <span v-if="$v.abonner.id_pack.$model">
                                                        <span class="enleve-bold"
                                                            v-if="(typeof $v.abonner.id_pack.$model.promotions !== 'undefined') && (typeof $v.abonner.id_pack.$model.promotions[0] !== 'undefined')">
                                                            - {{ getNum( (parseFloat($v.abonner.remise.$model) +
                                                                parseFloat($v.abonner.id_pack.$model.promotions[0].remise)).toFixed(2)
                                                            ) }} {{ $t('content.text.dh') }}
                                                        </span>
                                                        <span class="enleve-bold" v-else>
                                                        - {{ getNum(parseFloat($v.abonner.remise.$model)) }}
                                                        {{ $t('content.text.dh') }}
                                                    </span>
                                                    </span>
                                                    
                                                </p>
                                                <p class="form__label">
                                                    <span>{{
                                                        $t('content.pages.abonnements.nouveau.facture.total_net_paye')
                                                    }}</span> : <!--{{TotalPaiementsOnText}} = -->{{
    getNum(
        TotalPaiements)
}} {{ $t('content.text.dh') }}
                                                </p>
                                                <p v-if="paiements.hasPaiement" class="form__label">
                                                    <span>{{
                                                        $t('content.pages.abonnements.nouveau.facture.montant_paye')
                                                    }}</span> : {{
    getNum(
parseFloat($v.paiements.prix.$model).toFixed(2)) }}
                                                    {{ $t('content.text.dh') }}
                                                </p>
                                                <p v-if="paiements.hasPaiement" class="form__label">
                                                    <span>{{
                                                        $t('content.pages.abonnements.nouveau.facture.reste')
                                                    }}</span> : {{ getNum( (parseFloat(TotalPaiements) -
parseFloat($v.paiements.prix.$model)).toFixed(2)) }}
                                                    {{ $t('content.text.dh') }}
                                                </p>

                                            </div>
                                        </div>




                                    </div>
                                    <div v-if="$v.abonner.date_debut.$error || $v.abonner.remise.$error || $v.abonner.id_abonnement.$error || $v.abonner.id_pack.$error"
                                        class="row">
                                        <div class="check-infos-paiements invioce-adherent col-12">
                                            <div>
                                                <h5 class="">Vérifier les champs d'abonnement & Pack : </h5>
                                            </div>
                                            <div v-if="$v.abonner.date_debut.$error">
                                                <p :class="{ 'validate-champs': $v.abonner.date_debut.$error }"
                                                    class="form__label">
                                                    Vérifier date de début
                                                </p>
                                            </div>
                                            <div v-if="$v.abonner.remise.$error">
                                                <p :class="{ 'validate-champs': $v.abonner.remise.$error }"
                                                    class="form__label">
                                                    Vérifier remise
                                                </p>
                                            </div>

                                            <div v-if="$v.abonner.id_abonnement.$error">
                                                <p :class="{ 'validate-champs': $v.abonner.id_abonnement.$error }"
                                                    class="form__label">
                                                    Vérifier le type d'abonnement
                                                </p>
                                            </div>

                                            <div v-if="$v.abonner.id_pack.$error">
                                                <p :class="{ 'validate-champs': $v.abonner.id_pack.$error }"
                                                    class="form__label">
                                                    Vérifier le type de pack
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </tab-content>


                            </form-wizard>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div v-else class="content-wrapper">
            <havent-permission></havent-permission>
        </div>
    </div>
</template>
<script>
import { required, minLength, numeric, decimal, between, maxLength, email, requiredUnless, requiredIf } from 'vuelidate/lib/validators'
export default {
    data() {
        return {
            loadingWizard: false,
            adherent_status: true,
            adherent: {
                id_empreinte : '',
                code_client: '',
                nom: '',
                email: '',
                tele: '',
                tele_urgence: '',
                cin: '',
                gender: '',
                adresse: '',
                date_naiss: '',
                image: '',
                url: '/clubi/public/admin/adherents/photos/homme.png',
            },
            latestIdEmpreinte: null,
            paiements: {
                hasPaiement: true,
                date_paiement: new Date(),
                prix: null,
                date_echeance: ''
            },
            assurance: {
                hasAssurance: true,
                date_assuree: new Date(),
                duree_assurance: null,
                prix_assurance: 0.00,
                typeassurance: null
            },
            abonner: {
                //hasAbonner: true,
                renouvler: false,
                id_pack: [],
                id_abonnement: [],
                remise: 0,
                date_debut: new Date()
            },
            arr_frais: [],
            formData: {},
            submitStatus: false,
            packs: [],
            List_Packs: [],
            abonnements: [],
            assurances: [],
            tous_les_frais: [],
            is_compte_assuree: [],
            adherent_renouvler: [],
            checkbox_assurance: false

        }
    },
    validations() {
        return {
            adherent: {
                code_client: {
                    required: requiredIf(function () { return this.isRenouvlerAbonnement }),
                    minLength: minLength(1)
                },
                id_empreinte: {
                    minLength: minLength(1),
                    numeric 
                },
                nom: {
                    required: requiredIf(function () { return !this.isRenouvlerAbonnement }),
                    minLength: minLength(3)
                },
                email: {
                    //required: requiredIf(function() { return !this.isRenouvlerAbonnement }),
                    //minLength: minLength(3),
                    email
                },
                tele: {
                    //required: requiredIf(function() { return !this.isRenouvlerAbonnement }),
                    minLength: minLength(8)
                },
                tele_urgence: {
                    //required: requiredIf(function() { return !this.isRenouvlerAbonnement }),
                    minLength: minLength(3)
                },
                cin: {
                    // required: requiredIf(function() { return !this.isRenouvlerAbonnement }),
                    minLength: minLength(4)
                },
                gender: {
                    required: requiredIf(function () { return !this.isRenouvlerAbonnement }),
                },
                adresse: {
                    // required: requiredIf(function() { return !this.isRenouvlerAbonnement }),
                },
                date_naiss: {
                    required: requiredIf(function () { return !this.isRenouvlerAbonnement }),
                },
                image: {
                    // required: requiredIf(function() { return !this.isRenouvlerAbonnement }),
                }
            },

            paiements: {
                date_paiement: {
                    required: requiredIf(function () { return this.isHasPaiement }), //requiredUnless('isHasPaiement'),
                },
                date_echeance: {
                    //required: requiredIf(function() { return this.isHasPaiement }), //
                },
                prix: {
                    required: requiredIf(function () { return this.isHasPaiement }), //requiredUnless('isHasPaiement'),
                    decimal,
                    async isThanZero(value) {
                        if (this.isHasPaiement) {
                            if (value > 0) return true
                        } else return true
                    },
                    async CheckMontantPaye(value) {
                        if (this.isHasPaiement == true) {
                            if (value <= parseFloat(this.TotalPaiements)) return true
                        } else return true
                    },
                    async CheckPrixAssurance(value) {
                        if (this.isHasPaiement == true && this.assurance.hasAssurance == false && this.$v.assurance.typeassurance.$model != null) {
                            if (value >= parseFloat(this.$v.assurance.typeassurance.$model.prix) && this.assurance.hasAssurance == false) return true
                        } else return true
                    }
                }
            },
            assurance: {
                date_assuree: {
                    //required: requiredIf(function() { return this.ifCompteNotAssuree }) //requiredUnless('ifCompteNotAssuree'),
                },
                prix_assurance: {
                    //required: requiredIf(function() { return this.ifCompteNotAssuree }), //requiredUnless('ifCompteNotAssuree'),
                    decimal,
                    /* async isThanZero(value) {
                         if (this.ifCompteNotAssuree) {
                             if (value > 0) return true
                         } //else return true
                     }*/
                },
                duree_assurance: {
                    //required: requiredIf(function() { return this.ifCompteNotAssuree }) //requiredUnless('ifCompteNotAssuree'),
                },
                typeassurance: {

                }
            },
            abonner: {
                id_abonnement: {
                    required
                    //required: function() {
                    //    return (this.abonner.hasAbonner == true && this.$v.abonner.id_abonnement.$model.id != null)
                    //}
                },
                id_pack: {
                    required
                    //required: function() {
                    //    return (this.abonner.hasAbonner == true && this.$v.abonner.id_pack.$model.id != null)
                    //}
                },
                remise: {
                    decimal
                },
                date_debut: {
                    required
                    //required: function() { 
                    //    return (this.abonner.hasAbonner == true && this.$v.abonner.date_debut.$model != null)
                    //}
                },
            }
        }

    },
    methods: {

        /*validEmail:function(email) {
          var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(email);
        },*/

        async fetchLatestIdEmpreinte() {
      try {
        const response = await axios.get('/api-admin/adherent/latestIdEmprinte');
        this.latestIdEmpreinte = response.data.latestIdEmpreinte;
      } catch (error) {
        console.error('Error fetching latest id_empreinte', error);
      }
     },
        OnCheckedAssurance(value) {
            //console.log(this.checkbox_assurance)
            if (this.checkbox_assurance) {
                this.assurance.hasAssurance = true
            } else
                this.assurance.hasAssurance = false
            ////console.log(value)
        },

        onChangeStep: function (isValid, tabIndex) {
            //console.log('Tab: '+tabIndex+ ' valid: '+isValid)
        },

        libeleAbonnement({ nb_mois, libelle }) {
            return `${libelle} ( ${nb_mois} Mois )`
        },
        libeleAssurance({ prix, libelle, nb_mois }) {
            return `${libelle} (${nb_mois} mois ),  ( ${prix} Dhs )`
        },
        TousLesFrais({ libelle, prix }) {
            return `${libelle} ( ${prix} Dh )`
        },
        addFrais(newTag) {
            //console.log(newTag)
            const tag = {
                name: newTag,
                id: newTag.substring(0, 2) + Math.floor((Math.random() * 10000000))
            }
            this.tous_les_frais.push(tag)
            this.arr_frais.push(tag)
        },
        setfrais(value) {
            ////console.log(value)
            //console.log(this.arr_frais)


        },

        libelePack({ description, prix, abonnement, activities, promotions }) {
            let NbMois = (abonnement != null && abonnement.nb_mois != undefined ) ? abonnement.nb_mois + ' Mois' : ''
            var all_activities = ''
            for (var i = 0; i < activities.length; i++)
                all_activities = activities[i].name + ', ' + all_activities

            //console.log('promotions'  )
            if (typeof promotions[0] !== 'undefined') {
                var promo = promotions[0].remise;
                return `${description} ( ${all_activities.replace(/,(?=\s*$)/, '')} ) =  ${prix} Dh avec promo de ${promo} Dh`
            } else
                return `${description} ( ${all_activities.replace(/,(?=\s*$)/, '')} ) =  ${prix} Dh/${NbMois}`
        },
        setidempreinte() {
            //this.adherent.id_empreinte = value
            // console.log("id emprient valueee"+value)
            // this.adherent.id_empreinte = this.latestIdEmpreinte
            // this.$v.adherent.id_empreinte.$touch()
            this.adherent.id_empreinte = this.latestIdEmpreinte;
        },
        setcode_client(value) {
            //console.log(value)
            this.adherent.code_client = value
            this.$v.adherent.code_client.$touch()
            $('.wizard-footer-right .wizard-btn').prop("disabled", true);
        },
        setnom(value) {
            //console.log(value)
            this.adherent.nom = value
            this.$v.adherent.nom.$touch()
        },
        setemail(value) {
            //console.log(value)
            this.adherent.email = value
            this.$v.adherent.email.$touch()
        },
        settele(value) {
            //console.log(value)
            this.adherent.tele = value
            this.$v.adherent.tele.$touch()
        },
        settele_urgence(value) {
            //console.log(value)
            this.adherent.tele_urgence = value
            this.$v.adherent.tele_urgence.$touch()
        },
        setcin(value) {
            //console.log(value)
            this.adherent.cin = value
            this.$v.adherent.cin.$touch()
        },
        setgender(value) {
            //console.log(value)
            this.adherent.gender = value
            this.$v.adherent.gender.$touch()
        },
        setadresse(value) {
            //console.log(value)
            this.adherent.adresse = value
            this.$v.adherent.adresse.$touch()
        },
        setdate_naiss(value) {
            //console.log(value)
            this.adherent.date_naiss = value
            this.$v.adherent.date_naiss.$touch()
        },
        setimage(value) {
            //console.log(value)
            this.adherent.image = value
            this.$v.adherent.image.$touch()
        },
        setdate_paiement(value) {
            //console.log(value)
            this.paiements.date_paiement = value
            this.$v.paiements.date_paiement.$touch()
        },
        setdate_echeance(value) {
            //console.log(value)
            this.paiements.date_echeance = value
            this.$v.paiements.date_echeance.$touch()
        },
        setprix(value) {
            //console.log(value)
            this.paiements.prix = value
            this.$v.paiements.prix.$touch()
        },
        setdate_assuree(value) {
            //console.log(value)
            this.assurance.date_assuree = value
            this.$v.assurance.date_assuree.$touch()

        },
        setprix_assurance(value) {
            //console.log(value)
            this.assurance.prix_assurance = value
            this.$v.assurance.prix_assurance.$touch()
        },
        setduree_assurance(value) {
            //console.log(value)
            this.assurance.duree_assurance = value
            this.$v.assurance.duree_assurance.$touch()

            if (this.$v.assurance.duree_assurance.$model == 0)
                this.$v.assurance.prix_assurance.$model = 0.00
            if (this.$v.assurance.duree_assurance.$model == 90)
                this.$v.assurance.prix_assurance.$model = 50
            else if (this.$v.assurance.duree_assurance.$model == 182)
                this.$v.assurance.prix_assurance.$model = 100
            else if (this.$v.assurance.duree_assurance.$model == 365)
                this.$v.assurance.prix_assurance.$model = 150

            this.$v.assurance.prix_assurance.$touch()
        },
        settypeassurance(value) {
            //console.log(value)
            this.assurance.typeassurance = value
            this.$v.assurance.typeassurance.$touch()
        },
        setid_pack(value) {
            // //console.log(value)
            this.abonner.id_pack = value
            this.$v.abonner.id_pack.$touch()

        },
        setid_abonnement(value) {
            ////console.log(value.libelle)
            this.abonner.id_abonnement = value
            this.$v.abonner.id_abonnement.$touch()
            let self = this
            this.packs = []
            this.packs =  this.List_Packs.filter( function(pack) { 
                return pack.id_abonnement == value.id 
            } )
         },
        setremise(value) {
            //console.log(value)
            this.abonner.remise = value
            this.$v.abonner.remise.$touch()
        },
        setdate_debut(value) {
            //console.log(value)
            this.abonner.date_debut = value
            this.$v.abonner.date_debut.$touch()
        },
        onImageChange(e) {
            document.getElementById("input-name-image").placeholder = e.target.files[0].name;
            //console.log(e.target.files[0]);
            this.$v.adherent.image.$model = e.target.files[0];

            if (/\.(jpe?g|png|gif)$/i.test(e.target.files[0].name)) {
                let reader = new FileReader();
                reader.onload = (e) => { this.adherent.url = e.target.result; };
                reader.readAsDataURL(this.$v.adherent.image.$model);
            } else {
                //console.log('not image');
            }
            //console.log(this.adherent.url)
        },
        onComplete: function () {
            alert('Yay. Done!');
        },
        isRemiseNull(event) {
            if (this.$v.abonner.remise.$model == '' || this.$v.abonner.remise.$model == null)
                this.setremise(0);
        },
        VerifierAdherent() {
            //this.assurance.hasAssurance = false
            //this.checkbox_assurance = false
            if (this.$v.adherent.code_client.$model != '') {
                //this.DernierEnregistrement(this.$v.adherent.code_client.$model)  
                this.formData = new FormData();
                this.formData.append('code_client', this.$v.adherent.code_client.$model);
                const config = { headers: { 'content-type': 'multipart/form-data' } }
                axios.post('/api-admin/adherent/check-adherent-is-existe', this.formData, config).then(res => {

                    if (res.data[0].adherent != null) {
                        if (typeof this.$route.query.matricule !== 'undefined') {
                            this.adherent_renouvler = res.data[0].adherent
                            $('.wizard-footer-right .wizard-btn').prop("disabled", false);
                        } else {

                            const adherent = res.data[0].adherent
                            const information_adherents = "<p style='margin-top: 20px; margin-bottom : 0px;'> <b>Id</b> : " + adherent.id_empreinte + "</p><br><p style='margin-bottom : 0px;'><b>Nom : </b>" + adherent.nom + "</p>"

                            let _object = {
                                title: "Vérifier l'adhérent",
                                html: information_adherents,
                                type: 'question',
                                showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: this.$t('content.bouton.oui'),
                                cancelButtonText: this.$t('content.bouton.non'),
                                allowOutsideClick: false
                            }

                            this.$fire(_object).then((result) => {

                                if (result.value) {
                                    this.adherent_renouvler = res.data[0].adherent
                                    this.$refs.vuewizard.changeTab(0, 1);
                                    $('.wizard-footer-right .wizard-btn').prop("disabled", false);
                                } else {
                                    this.adherent_renouvler = []
                                    $('.wizard-footer-right .wizard-btn').prop("disabled", true);
                                }
                            })
                        }
                    } else {
                        $('.wizard-footer-right .wizard-btn').prop("disabled", true);
                        this.AlertResponseFalse("", "Cet adhérent n'existe pas", "warning");
                    }

                    if (res.data[1].is_assuree != null) {
                        this.is_compte_assuree = res.data[1].is_assuree
                        this.assurance.hasAssurance = true
                        //this.checkbox_assurance = true
                    }


                    if (res.data[2].dernier_enregistrement != null) {

                        this.$v.abonner.id_pack.$model = res.data[2].dernier_enregistrement.packs[0]
                        this.$v.abonner.id_abonnement.$model = res.data[2].dernier_enregistrement.abonnements[0]
                        this.$v.abonner.remise.$model = res.data[2].dernier_enregistrement.remise
                    }

                });
            } else {
                $('.wizard-footer-right .wizard-btn').prop("disabled", false);
            }
        },
        submit(event) {

            /*var errors = [];
            if (this.$v.adherent.email.$model!= '') {
               if(!this.validEmail(this.$v.adherent.email.$model)) {
                errors.push("Valid email required.");        
              }
              if(!errors.length) return true;
              //console.log(errors.length)
             // event.preventDefault();
            }*/

            this.submitStatus = true
            this.$v.$touch()
            //console.log( this.$v.assurance.prix_assurance.$model);
            if (!this.$v.$invalid) {

                this.$fire(this.AlertFire('add')).then((result) => {
                    if (result.value) {
                        //this.PluginLoader(false, this.$refs.formContainer)
                        //this.submitStatus = 'PENDING'
                        this.formData = new FormData();

                        //### Informations personnelle
                        if (this.abonner.renouvler == false) {
                           // if (this.$v.adherent.id_empreinte.$model != '' && this.$v.adherent.id_empreinte.$model != null)
                            this.formData.append('adherent[id_empreinte]', this.latestIdEmpreinte);

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
                            if (this.$v.adherent.image.$model)
                                this.formData.append('adherent[image]', this.$v.adherent.image.$model);

                            //this.formData.append('adherent[parrain]', this.$v.adherent.code_client.$model);

                        } else
                            this.formData.append('code_client', this.$v.adherent.code_client.$model);


                        // if (this.abonner.hasAbonner == true) {
                        //#### Abonnement & pack 

                        this.formData.append('abonner[prix_pack]', this.$v.abonner.id_pack.$model.prix);
                        this.formData.append('abonner[nb_mois_abonnement]', this.$v.abonner.id_abonnement.$model.nb_mois);


                        this.formData.append('abonner[id_pack]', this.$v.abonner.id_pack.$model.id);
                        this.formData.append('abonner[id_abonnement]', this.$v.abonner.id_abonnement.$model.id);
                        this.formData.append('abonner[months]', this.$v.abonner.id_abonnement.$model.nb_mois);
                        this.formData.append('abonner[remise]', parseFloat(this.$v.abonner.remise.$model).toFixed(2));
                        this.formData.append('abonner[date_debut]', this.$v.abonner.date_debut.$model.toDateString());
                        if (this.$v.abonner.id_pack.$model.promotions[0])
                            this.formData.append('abonner[promo]', this.$v.abonner.id_pack.$model.promotions[0].remise);
                        //### Paiements 
                        if (this.paiements.hasPaiement == true && this.$v.paiements.prix.$model != '' && this.$v.paiements.prix.$model > 0) {
                            this.formData.append('paiements[date_paiement]', this.$v.paiements.date_paiement.$model.toDateString());

                            if (this.$v.paiements.date_echeance.$model != '') {
                                this.formData.append('paiements[date_echeance]', this.$v.paiements.date_echeance.$model.toDateString());
                            }

                            if (this.$v.assurance.typeassurance.$model) {
                                var prix_paye = this.$v.paiements.prix.$model - this.$v.assurance.typeassurance.$model.prix;
                            } else
                                var prix_paye = this.$v.paiements.prix.$model

                            this.formData.append('paiements[prix]', parseFloat(prix_paye).toFixed(2));

                            if (this.assurance.hasAssurance == false && this.$v.assurance.typeassurance.$model) {
                                this.formData.append('assurance[date_assuree]', this.$v.assurance.date_assuree.$model.toDateString());
                                //this.formData.append('assurance[prix_assurance]', parseFloat(this.$v.assurance.prix_assurance.$model).toFixed(2));
                                //this.formData.append('assurance[duree_assurance]', parseInt(this.$v.assurance.duree_assurance.$model));

                                this.formData.append('assurance[typeassurance]', parseInt(this.$v.assurance.typeassurance.$model));

                                this.formData.append('assurance[prix_assurance]', parseFloat(this.$v.assurance.typeassurance.$model.prix).toFixed(2));
                                this.formData.append('assurance[duree_assurance]', parseInt(this.$v.assurance.typeassurance.$model.nb_mois));

                            }
                        }

                        if (this.arr_frais.length > 0) {
                            for (var i = 0; i < this.arr_frais.length; i++) {
                                //this.formData.append("arr_frais[" + i + "]", this.arr_frais[i]['id']);
                                // //console.log(this.arr_frais[i])
                                this.formData.append("arr_frais[" + i + "]",
                                    [
                                        this.arr_frais[i]['id'],
                                        this.arr_frais[i]['libelle'],
                                        this.arr_frais[i]['prix']
                                    ]);
                            }
                            //console.log(this.arr_frais)
                        }

                        const config = { headers: { 'content-type': 'multipart/form-data' } }
                        axios.post('/api-admin/abonners/store', this.formData, config).then(res => {

                            var alert_unique_validation = ''
                            if (typeof res.data.unique_validation !== 'undefined') {
                                if (res.data.unique_validation.includes("email")) {
                                    alert_unique_validation += "L'email"
                                }
                                if (res.data.unique_validation.includes("cin")) {
                                    if (alert_unique_validation != '') {
                                        alert_unique_validation += ", "
                                    }
                                    alert_unique_validation += "Le CIN"
                                }
                                if (res.data.unique_validation.includes("tele")) {
                                    if (alert_unique_validation != '') {
                                        alert_unique_validation += " et "
                                    }
                                    alert_unique_validation += "Le numéro de téléphone"
                                }
                                // if (res.data.unique_validation.includes("empreinte")) {
                                //     if (alert_unique_validation != '') {
                                //         alert_unique_validation += " et "
                                //     }
                                //     alert_unique_validation += "ID empreinte"
                                // }
                                if (alert_unique_validation != '')
                                    alert_unique_validation += " entré existe déja"
                                this.AlertResponseFalse("", alert_unique_validation, "warning");
                            }


                            if (res.data.validator == false) {
                                //console.log('email incorrect');
                                this.$v.adherent.email.email = false
                            }
                            switch (res.data.adherent) {
                                case 'something_unique':
                                    this.AlertResponseFalse("", "something_unique", "warning");
                                    break;
                                case 'not_found':
                                    this.AlertResponseFalse("", this.$t('content.alerts.adherents.n_existe'), "warning");
                                    break;
                                default:
                                    /*this.AlertResponseTrue(`
                                                    <div>
                                                        <a href="/admin/adherent/${res.data.adherent.code_client}">Matricule : ${res.data.adherent.code_client}</a>
                                                        <p class="enleve-bold" style="margin-top: 10px !important;">
                                                            <b>Nom : </b> ${res.data.adherent.nom}, <b>Cin : </b> ${res.data.adherent.cin}
                                                        </p>
                                                      </div> `, this.$t('content.alerts.ajout.success'), "success");*/

                                    //window.location.href = '/admin/adherent/' + res.data.adherent.adherent.code_client;
                                    window.location.href = this.$router.resolve({ name: 'adherent', params: { code: res.data.adherent.adherent.code_client } }).href
                                    // this.$route.push({ name: 'adherent', params: { code: res.data.code_client } })
                                    // document.getElementById("input-name-image").placeholder = this.$t('content.pages.activities.activitie.image_placeholder')

                                    /*this.$v.adherent.nom.$model = null
                                    this.$v.adherent.email.$model = null
                                    this.$v.adherent.tele.$model = null
                                    this.$v.adherent.tele_urgence.$model = null
                                    this.$v.adherent.date_naiss.$model = null
                                    this.$v.adherent.cin.$model = null
                                    this.$v.adherent.gender.$model = null
                                    this.$v.adherent.adresse.$model = null
                                    this.$v.adherent.image.$model = null
                                    this.adherent.url = null
                                    this.$v.abonner.id_pack.$model = []
                                    this.$v.abonner.id_abonnement.$model = []
                                    this.$v.abonner.remise.$model = 0
                                    this.$v.abonner.date_debut.$model = new Date()
                                    this.$v.paiements.date_paiement.$model = new Date()
                                    this.$v.paiements.prix.$model = null
                                    this.$v.assurance.date_assuree.$model = new Date()
                                    this.$v.assurance.duree_assurance.$model = null
                                    this.$v.assurance.prix_assurance.$model = null

                                    this.$v.$reset()*/
                                    break;
                            }

                        }).catch(e => { })
                            .finally(f => {
                                setTimeout(() => {
                                    this.submitStatus = false
                                }, 500)
                            })

                    }
                })

            }
        },
        ListPacks() {
            axios.get('/api-admin/parametrages/packs').then((response) => {
                this.List_Packs = response.data
                //this.packs = response.data;
            });
        },
        ListTousLesFrais() {
            axios.get('/api-admin/parametrages/tous-les-frais').then((response) => {
                this.tous_les_frais = response.data.tous_les_frais;
                //console.log( "response.data.tous_les_frais")
                //console.log( response.data.tous_les_frais)
            });
        },

        ListAssurances() {
            axios.get('/api-admin/parametrages/assurances?type_frais=1').then((response) => {
                this.assurances = response.data.assurances;
                this.autres_frais = response.data.autres_frais;

            });
        },


        ListTypeAbonnements() {
            axios.get('/api-admin/parametrages/abonnements').then((response) => {
                this.abonnements = response.data;
            });
        },
        DernierEnregistrement(matricule) {
            this.abonner.renouvler = true
            this.$v.adherent.code_client.$model = matricule
            $('.wizard-footer-right .wizard-btn').prop("disabled", true);
            axios.get('/api-admin/abonners/dernier-enregistrement?adherent=' + matricule).then((response) => {
                this.$v.abonner.id_pack.$model = response.data.abonners.packs[0]
                this.$v.abonner.id_abonnement.$model = response.data.abonners.abonnements[0]
                this.$v.abonner.remise.$model = response.data.abonners.remise
            });
        },
        getNum(val) {
            if (isNaN(val)) {
                return parseFloat(0).toFixed(2);
            }
            return parseFloat(val).toFixed(2);
        },
        disabledButtonSuivant() {
            ////console.log(this.abonner.renouvler)
            if (typeof this.$route.query.matricule === 'undefined') {
                if (this.abonner.renouvler) {
                    $('.wizard-footer-right .wizard-btn').prop("disabled", false);
                } else {
                    $('.wizard-footer-right .wizard-btn').prop("disabled", true);
                }
            }
        },
    },
    beforeMount() {
        if (this.$can('Ajouter un abonnement')) {
            this.fetchLatestIdEmpreinte();
            this.ListTypeAbonnements();
            this.ListPacks();
            this.ListAssurances();
            if (typeof this.$route.query.matricule !== 'undefined') {
                this.abonner.renouvler = true
                this.$v.adherent.code_client.$model = this.$route.query.matricule
                //this.DernierEnregistrement(this.$route.query.matricule)  
                this.VerifierAdherent()
            }
            this.ListTousLesFrais()
        }
    },

    beforeRouteLeave(to, from, next) {
        if (this.$v.adherent.nom.$model != '' || this.$v.adherent.email.$model != '' || this.$v.adherent.tele.$model != '' || this.$v.adherent.tele_urgence.$model != '' || this.$v.adherent.date_naiss.$model != '' || this.$v.adherent.cin.$model != '' || this.$v.adherent.gender.$model != '' || this.$v.adherent.adresse.$model != '' || this.$v.adherent.code_client.$model != '') {
            this.$fire(this.AlertFire('leave')).then((result) => {
                if (result.value) {
                    next()
                } else {
                    next(false)
                }
            });
        } else {
            next()
        }
    },
    computed: {
        TotalPaiementsOnText() {
            var promo = 0
            if (this.$v.abonner.id_pack.$model != null) {
                promo = (typeof this.$v.abonner.id_pack.$model.promotions !== 'undefined') && (typeof this.$v.abonner.id_pack.$model.promotions[0] !== 'undefined') ? this.$v.abonner.id_pack.$model.promotions[0].remise : 0;
            }

            var text = ""
            if (this.$v.abonner.id_pack.$model != null && this.$v.abonner.id_abonnement.$model != null) {
                text = "[ ( " + this.$v.abonner.id_abonnement.$model.nb_mois + "*" + parseFloat(this.$v.abonner.id_pack.$model.prix).toFixed(2) + " ) - " + (parseFloat(this.$v.abonner.remise.$model) + parseFloat(promo)).toFixed(2) + " ] "
            }

            if (this.$v.assurance.typeassurance.$model)
                return text + " + " + parseFloat(this.$v.assurance.typeassurance.$model.prix).toFixed(2);
            else
                return text
        },
        TotalPaiements() {
            var promo = 0
            if (this.$v.abonner.id_pack.$model != null) {
                promo = (typeof this.$v.abonner.id_pack.$model.promotions !== 'undefined') && (typeof this.$v.abonner.id_pack.$model.promotions[0] !== 'undefined') ? this.$v.abonner.id_pack.$model.promotions[0].remise : 0;
            }

            var total = ""
            if (this.$v.abonner.id_pack.$model != null && this.$v.abonner.id_abonnement.$model != null) {
                //total = parseFloat((this.$v.abonner.id_abonnement.$model.nb_mois * parseFloat(this.$v.abonner.id_pack.$model.prix)) - [parseFloat(this.$v.abonner.remise.$model) + parseFloat(promo)]).toFixed(2);
                total = parseFloat((parseFloat(this.$v.abonner.id_pack.$model.prix)) - [parseFloat(this.$v.abonner.remise.$model) + parseFloat(promo)]).toFixed(2);
            }

            if (this.$v.assurance.typeassurance.$model) {
                //console.log(this.$v.assurance.typeassurance.$model.prix)
                total = parseFloat(this.$v.assurance.typeassurance.$model.prix) + parseFloat(total);
            }

            if (this.totalFrais > 0) {
                total = this.totalFrais + parseFloat(total);
            }
            return total;
        },
        isRenouvlerAbonnement() {

            return this.abonner.renouvler
        },
        isHasPaiement() {
            //this.$v.$touch()
            return this.paiements.hasPaiement
        },
        ifCompteNotAssuree() {
            return !this.assurance.hasAssurance
        },
        totalFrais() {
            var sommes_paye = this.arr_frais.reduce((n, { prix }) => n + parseFloat(prix), 0);
            return sommes_paye
        }

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


.invioce-adherent {
    margin-top: 25px;
}

.invioce-adherent p {
    margin-bottom: 0rem ! important;
}

.invioce-adherent p span {
    font-weight: bold;
}


.enleve-bold {
    font-weight: normal !important;
}


.check-infos-adherent h5,
.check-infos-paiements h5 {
    text-transform: uppercase;
    font-weight: 600;
    margin-bottom: 24px;
}


.check-infos-adherent p {
    margin-bottom: 0px !important;
}

.validate-champs {
    color: #fff;
    background: #fd8a8a;
    padding: 2px;
    font-size: 15px;
}


.image-base64 {
    width: 50px;
    margin-top: 16px;
    height: 50px;
    object-fit: cover;
}
</style>
