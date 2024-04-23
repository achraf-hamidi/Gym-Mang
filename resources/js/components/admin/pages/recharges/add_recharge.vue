<template>
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-header ">
                <div class="row">
                    <div class="col-md-12">
                        <h3> {{ $t('content.pages.paiements.recharges.nouveau.titre') }} </h3>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form @submit.prevent="Recharge($event)" class="forms-sample">
                    <div class="row">
                        <!--<div class="col-md-4">
                            <div class="form-group mr-b-0em" :class="{ 'form-group--error': $v.type.$error }">
                                <label class="form__label">{{ $t('content.pages.paiements.recharges.nouveau.inputs.type.titre') }}</label>
                                <select class="form-control" v-model.trim="$v.type.$model" @change="setType($event.target.value)">
                                    <option value="Recharge"> {{$t('content.pages.paiements.recharges.nouveau.inputs.type.recharge')}} </option>
                                    <option value="Achat"> {{$t('content.pages.paiements.recharges.nouveau.inputs.type.achat')}} </option>
                                    <option value="Parrinage">{{ $t('content.pages.paiements.recharges.nouveau.inputs.type.parrinage') }}</option>
                                </select>
                            </div>
                            <div v-if="$v.type.$dirty">
                                <div class="error" v-if="!$v.type.required">{{ $t('validation.required', { attribute : $t('content.pages.paiements.recharges.nouveau.inputs.type.titre') }) }}</div>
                            </div>
                        </div>-->
                        <!--<div class="col-md-4">
                            <div class="form-group mr-b-0em" :class="{ 'form-group--error': $v.code_client.$error }">
                                <label class="form__label">{{$t('content.pages.paiements.recharges.nouveau.inputs.matricule.titre')}}</label>
                                <input class="form-control" v-model.trim="$v.code_client.$model" @input="setcode_client($event.target.value)" :placeholder="$t('content.pages.paiements.recharges.nouveau.inputs.matricule.placeholder')" />
                            </div>
                            <div v-if="$v.code_client.$dirty">
                                <div class="error" v-if="!$v.code_client.required">{{ $t('validation.required', { attribute : $t('content.pages.paiements.recharges.nouveau.inputs.matricule.titre') }) }}</div>
                                <div class="error" v-if="!$v.code_client.minLength">
                                    {{ $t('validation.min.numeric', { attribute : $t('content.pages.paiements.recharges.nouveau.inputs.matricule.titre'), min : $v.code_client.$params.minLength.min }) }}
                                </div>
                            </div>
                        </div>-->
                        <div class="col-6">
                            <div class="form-group mr-b-0em">
                                <label class="form__label">
                                    {{$t('content.pages.paiements.recharges.nouveau.inputs.matricule.titre')}}
                                </label>
                                <multiselect v-model.trim="value_id_adherent" :options="list_adherents" :custom-label="nameWithCodeClient" placeholder="Recherche.." label="code_client" track-by="code_client"></multiselect>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mr-b-0em" :class="{ 'form-group--error': $v.recharge.$error }">
                                <label class="form__label">{{$t('content.pages.paiements.recharges.nouveau.inputs.prix')}}</label>
                                <input class="form-control" v-model.trim="$v.recharge.$model" @input="setrecharge($event.target.value)" :placeholder="$t('content.pages.paiements.recharges.nouveau.inputs.prix')" />
                            </div>
                            <div v-if="$v.recharge.$dirty">
                                <div class="error" v-if="!$v.recharge.required">{{ $t('validation.required', { attribute : $t('content.pages.paiements.recharges.nouveau.inputs.prix') }) }}</div>
                                <!--<div class="error" v-if="!$v.recharge.numeric">
                          Number ...
                      </div>-->
                            </div>
                        </div>
                    </div>
                    <div class="col-12 text-right">
                        <button type="submit" class="btn btn-primary mr-2"> <i class=" mdi mdi-plus"></i> {{ $t('content.bouton.ajout') }}</button>
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
            list_adherents: [],
            value_id_adherent: [],
            recharge: '',
            type: 'achat',
            formData: {},
            submitStatus: null
        }
    },
    validations: {

        recharge: {
            required,
            //numeric
        },
        type: {
            required
        }
    },
    methods: {
        nameWithCodeClient({ code_client, nom }) {
            return `${code_client} -  ${nom} `
        },
        ListAdherents() {
            axios.get('/api-admin/list-adherents-has-abonners').then((response) => {
                this.list_adherents = response.data;
            });
        },
        setrecharge(value) {
            this.recharge = value
            this.$v.recharge.$touch()
        },
        setType(value) {
            this.type = value
            this.$v.type.$touch()
        },
        Recharge(event) {
            this.$v.$touch()
            if (this.$v.$invalid) {
                this.submitStatus = 'ERROR'
            } else {

                this.$fire(this.AlertFire('add')).then((result) => {
                    if (result.value) {
                        this.submitStatus = 'PENDING'
                        this.formData = new FormData();
                        if (this.value_id_adherent.code_client != null)
                            this.formData.append("code_client", this.value_id_adherent.code_client);


                        this.formData.append('recharge', this.$v.recharge.$model);
                        this.formData.append('type', this.$v.type.$model);
                        const config = { headers: { 'content-type': 'multipart/form-data' } }
                        axios.post('/api-admin/recharge/store', this.formData, config).then(response => {

                                if (response.data == "adhérent n'existe pas") {
                                    this.AlertResponseFalse("", this.$t('content.alerts.adherents.n_existe'), "warning")
                                } else {
                                    this.AlertResponseTrue("", this.$t('content.alerts.ajout.success'), "success");
                                    this.eventRecharge.$emit('update', response.data)
                                    this.value_id_adherent = null
                                    this.$v.recharge.$model = null
                                    this.$v.type.$model = null
                                    this.$v.$reset()
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
        clearDataInputs() {
            this.value_id_adherent = []
            this.recharge = ''
            this.type = ''
        }
    },
    beforeMount() {
        this.ListAdherents()
    }
}

</script>
