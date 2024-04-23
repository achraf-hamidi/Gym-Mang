<template>
    <div  class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="card-header ">
                    <div class="row">
                        <div class="col-md-11">
                            <div class="d-flex justify-content-between">
                                <h3 class="card-title mb-0">Changement type Abonnement ou Pack</h3>
                            </div>
                        </div>
                        <div class="col-1">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="modal-body grid-margin modal-utilisateur">
                    <form-wizard @on-complete="submit" subtitle="" title='' shape="circle" :back-button-text="$t('content.bouton.prev')" :next-button-text="$t('content.bouton.next')" :finish-button-text="$t('content.bouton.modifier')" color="#ff9c00e6">
                        <tab-content :title="$t('content.pages.adherents.add_modale.steps.infos')" icon="far fa-user">
                            <div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <h3>Détails abonnement actuel</h3>
                                    </div>
                                    <div class="col-md-6">
                                        <h3>Détails nouvelle abonnement</h3>
                                    </div>
                                </div><br>
                                <div class="row">
                                    <div class="col-md-6">
                                        <ul v-if="old_data_abonner.abonners" class="timeline">
                                            <li class="timeline-item">
                                                <p class="timeline-content"><b>Type d'abonnement : </b>{{ old_data_abonner.abonners[0].abonnements[0].libelle }}, {{ old_data_abonner.abonners[0].abonnements[0].nb_mois }} Mois</p>
                                            </li>
                                            <li class="timeline-item">
                                                <p class="timeline-content"><b>Type de pack : </b>
                                                    {{ old_data_abonner.abonners[0].packs[0].description }}, {{ old_data_abonner.abonners[0].packs[0].prix }}
                                                </p>
                                            </li>
                                            <li class="timeline-item">
                                                <p class="timeline-content"><b>Remise abonner : </b>
                                                    {{ old_data_abonner.abonners[0].remise }}
                                                </p>
                                            </li>
                                            <li class="timeline-item">
                                                <p class="timeline-content"><b>Promotion : </b>
                                                    {{ old_data_abonner.abonners[0].packs[0].pivot.promo }}
                                                </p>
                                            </li>
                                            <li class="timeline-item">
                                                <p class="timeline-content"><b>Total de paiements : </b>
                                                    {{ t_paiements }} Dh
                                                </p>
                                            </li>
                                            <li class="timeline-item">
                                                <p class="timeline-content"><b>Total montant returner de cette abonnement : </b>
                                                    {{ t_ismoney }} Dh
                                                </p>
                                            </li>
                                            <li class="timeline-item">
                                                <p class="timeline-content"><b>Montant sur caisse : </b>
                                                    {{ t_paiements - t_ismoney }} Dh
                                                </p>
                                            </li>
                                            <li class="timeline-item">
                                                <p class="timeline-content"><b>Net à payé actuel : </b>
                                                    {{ ActuelNetPaye }}
                                                </p>
                                            </li>
                                            <li class="timeline-item">
                                                <p class="timeline-content"><b>Nombre de mois passé : </b>
                                                    {{ nb_mois_passe}} Mois
                                                </p>
                                                <p class="timeline-content">
                                                    <b>Nombre de mois choisier : </b>
                                                    {{ nb_mois_choiser }} Mois
                                                </p>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-md-6">
                                        <ul class="timeline">
                                            <li class="timeline-item">
                                                <p class="timeline-content"><b>Type d'abonnement : </b>
                                                    {{ this.$v.abonner.id_abonnement.$model.libelle }}, {{ this.$v.abonner.id_abonnement.$model.nb_mois }} Mois
                                                </p>
                                            </li>
                                            <li class="timeline-item">
                                                <p class="timeline-content"><b>Type de pack : </b>
                                                    {{ this.$v.abonner.id_pack.$model.description }}, {{ this.$v.abonner.id_pack.$model.prix }}
                                                </p>
                                            </li>
                                            <li class="timeline-item">
                                                <p class="timeline-content"><b>Remise abonner : </b>
                                                    {{ this.$v.abonner.remise.$model }}
                                                </p>
                                            </li>
                                            <li class="timeline-item">
                                                <p class="timeline-content"><b>Promotion : </b>
                                                    <span v-if="this.$v.abonner.id_pack.$model.promotions && this.$v.abonner.id_pack.$model.promotions[0]"> {{ this.$v.abonner.id_pack.$model.promotions[0].remise }} </span>
                                                    <span v-else>0.00 Dh</span>
                                                </p>
                                            </li>
                                            <li class="timeline-item">
                                                <p class="timeline-content"><b>Nouvel Net à payé : </b>
                                                    {{ NouvelleNetPaye }}
                                                </p>
                                            </li>
                                            <li class="timeline-item">
                                                <p class="timeline-content"><b>Nouvel net a paye - montant a caisse : </b>
                                                    {{ NouvelleNetPaye_montantSurCaisse }} Dh
                                                </p>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div><br><br>
                            <div class="row">
                                <div class="col-4">
                                    <div class="form-group mr-b-0em">
                                        <label class="form__label">{{ $t('content.pages.adherents.add_modale.inputs.subscription.packs.title')}}</label>
                                        <select class="form-control" v-model.trim="$v.abonner.id_pack.$model" @input="setid_pack($event.target.value)">
                                            <option v-for="(pack, index) in packs" :value="pack">
                                                {{ pack.description }} ( <span v-for="(acts) in pack.activities"> {{ acts.name }} </span> )
                                            </option>
                                        </select>
                                    </div>
                                    <div v-if="$v.abonner.id_pack.$dirty">
                                        <div class="error" v-if="!$v.abonner.id_pack.required">{{ $t('validation.required', { attribute : $t('content.pages.adherents.add_modale.inputs.subscription.packs.title') }) }}</div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group mr-b-0em">
                                        <label class="form__label"> {{$t('content.pages.adherents.add_modale.inputs.subscription.subscription.title')}}</label>
                                        <select class="form-control" v-model.trim="$v.abonner.id_abonnement.$model" @input="setid_abonnement($event.target.value)" @change="nbMoisChoiser($event)" >
                                            <option v-for="(abonnement, index) in abonnements" :value="abonnement"> {{ abonnement.libelle }} </option>
                                        </select>
                                    </div>
                                    <div v-if="$v.abonner.id_abonnement.$dirty">
                                        <div class="error" v-if="!$v.abonner.id_abonnement.required">{{ $t('validation.required', { attribute : $t('content.pages.adherents.add_modale.inputs.subscription.subscription.title') }) }}</div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group mr-b-0em" :class="{ 'form-group--error': $v.abonner.remise.$error }">
                                        <label class="form__label">{{$t('content.pages.adherents.add_modale.inputs.subscription.discount.title')}}</label>
                                        <input class="form-control" v-model.trim="$v.abonner.remise.$model" @input="setremise($event.target.value)" @focusout="isRemiseNull" :placeholder="$t('content.pages.adherents.add_modale.inputs.subscription.discount.title')" />
                                    </div>
                                    <div v-if="$v.abonner.remise.$dirty">
                                        <div class="error" v-if="!$v.abonner.remise.decimal">
                                            {{ $t('validation.numeric', { attribute : $t('content.pages.adherents.add_modale.inputs.subscription.discount.title') }) }}
                                        </div>
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
    props: ['abonnements', 'packs'],
    data() {
        return {
            abonner: {
                id_pack: [],
                id_abonnement: [],
                remise: 0,
                date_debut: new Date()
            },
            abonnement_encours_index: null,
            formData: {},
            submitStatus: null,
            old_data_abonner: [],
            t_ismoney: 0,
            t_paiements: 0,
            nb_mois_passe : 0,
            nb_mois_choiser : 0
            //packs: [],
            //abonnements: []
        }
    },
    validations() {
        return {

            abonner: {
                id_abonnement: {
                    required
                },
                id_pack: {
                    required
                },
                remise: {
                    decimal
                },
                /*date_debut: {
                    required: function() {
                        return (this.abonner.hasAbonner == true && this.$v.abonner.date_debut.$model != null)
                    }
                },*/
            }
        }

    },
    methods: {
        setid_pack(value) {
            console.log(value)
            this.abonner.id_pack = value
            this.$v.abonner.id_pack.$touch()
        },
        setid_abonnement(value) {
            console.log(value)
            this.abonner.id_abonnement = value
            this.$v.abonner.id_abonnement.$touch()
            //alert(this.$v.abonner.id_abonnement.$model.nb_mois)
        },
        setremise(value) {
            console.log(value)
            this.abonner.remise = value
            this.$v.abonner.remise.$touch()
        },
        /*setdate_debut(value) {
            console.log(value)
            this.abonner.date_debut = value
            this.$v.abonner.date_debut.$touch()
        },*/
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
        isRemiseNull(event) {
            if (this.$v.abonner.remise.$model == '' || this.$v.abonner.remise.$model == null)
                this.setremise(0);
        },
        submit(event) {
            this.$v.$touch()
            console.log(this.$v.$invalid)
            if (this.$v.$invalid) {
                this.submitStatus = 'ERROR'
            } else {

                console.log("this.$v.$invalid")
                this.submitStatus = 'PENDING'
                this.formData = new FormData();

                this.formData.append('abonner[old_id_abonnement]', this.old_data_abonner.abonners[0].abonnements[0].id);
                this.formData.append('abonner[old_id_pack]', this.old_data_abonner.abonners[0].packs[0].id);
                this.formData.append('abonner[id]', this.old_data_abonner.abonners[0].id);
                this.formData.append('abonner[new_id_pack]', this.$v.abonner.id_pack.$model.id);
                this.formData.append('abonner[new_id_abonnement]', this.$v.abonner.id_abonnement.$model.id);
                this.formData.append('abonner[months]', this.$v.abonner.id_abonnement.$model.nb_mois);
                this.formData.append('abonner[remise]', parseFloat(this.$v.abonner.remise.$model).toFixed(2));
                
                if (this.$v.abonner.id_pack.$model.promotions[0])
                    this.formData.append('abonner[promo]', this.$v.abonner.id_pack.$model.promotions[0].remise);

                if (this.NouvelleNetPaye_montantSurCaisse < 0)
                    this.formData.append('abonner[is_money]', Math.abs(this.NouvelleNetPaye_montantSurCaisse));

                const config = { headers: { 'content-type': 'multipart/form-data' } }
                axios.post('/api-admin/abonners/update', this.formData, config).then(res => {
                        
                        
                        this.eventAbonner.$emit('update', { "abonnement_encours": res.data, "index": this.abonnement_encours_index })

                        $('.modal').modal('hide');
                        this.old_data_abonner = []
                        this.abonnement_encours_index = null
                        this.$v.abonner.id_pack.$model = []
                        this.$v.abonner.id_abonnement.$model = []
                        this.$v.abonner.remise.$model = null


                        this.$v.$reset()
                    }).catch(e => {})
                    .finally(f => {
                        setTimeout(() => {
                            this.submitStatus = 'OK'
                        }, 500)
                    })
            }
        },
        TotalPaiements(id_abonner) {
            this.formData = new FormData();
            this.formData.append('id_abonner', id_abonner);
            const config = { headers: { 'content-type': 'multipart/form-data' } }
            axios.post('/api-admin/abonners/total-paiements', this.formData, config).then((response) => { // T. paiements - T .montant retourner
                this.t_paiements = response.data.t_paiements;
                this.t_ismoney = response.data.t_ismoney;
            });
        },
        nbMoisPasse(date_debut) {
            var nb = this.DaysBtwDates( new Date(date_debut) , new Date( Date.now()) ) / 30
            this.nb_mois_passe = (nb % 1 == 0 ) ? nb : (nb+1).toFixed(0); // if number has deciaml
        },
        nbMoisChoiser(event){
            this.nb_mois_choiser = this.$v.abonner.id_abonnement.$model.nb_mois
        }
         
    },
    created: function() {
        this.eventAbonner.$on('edit', data => { 
            this.old_data_abonner = data.abonnement_encours
            this.abonnement_encours_index = data.index
            $('.btn-add-edit').text(this.$t('content.bouton.modifier'))
            this.TotalPaiements(data.abonnement_encours.abonners[0].id)
            console.log(data.abonnement_encours)
            this.nbMoisPasse(this.old_data_abonner.abonners[0].date_debut)
        })
    },
    beforeMount() {
        //this.ListTypeAbonnements();
        //this.ListPacks();
        console.log(this.packs)
        

    },
    computed: {
        ActuelNetPaye() {
            if (this.old_data_abonner.abonners) {
                return parseFloat([ this.old_data_abonner.abonners[0].packs[0].prix] - [this.old_data_abonner.abonners[0].remise + this.old_data_abonner.abonners[0].packs[0].pivot.promo]).toFixed(2);
               // return parseFloat([this.old_data_abonner.abonners[0].abonnements[0].nb_mois * this.old_data_abonner.abonners[0].packs[0].prix] - [this.old_data_abonner.abonners[0].remise + this.old_data_abonner.abonners[0].packs[0].pivot.promo]).toFixed(2);
            } else
                return 0;
        },
        NouvelleNetPaye() {

            //if (this.$v.abonner.id_pack.$model != null) {
            const promo = (this.$v.abonner.id_pack.$model.promotions && this.$v.abonner.id_pack.$model.promotions[0]) ? parseFloat(this.$v.abonner.id_pack.$model.promotions[0].remise) : 0;

            const remise_abonner = (this.$v.abonner.remise.$model != '') ? parseFloat(this.$v.abonner.remise.$model) : 0;

            var  Total =  parseFloat([ this.$v.abonner.id_pack.$model.prix] - [remise_abonner + promo]).toFixed(2);
            //var  Total =  parseFloat([this.$v.abonner.id_abonnement.$model.nb_mois * this.$v.abonner.id_pack.$model.prix] - [remise_abonner + promo]).toFixed(2);

            if ( this.nb_mois_passe > this.nb_mois_choiser) {
                return Total * this.nb_mois_passe
            }
            else
                return Total;
            //}
            //else
            //return 0 ;
        },
        NouvelleNetPaye_montantSurCaisse() {
            return this.NouvelleNetPaye - [this.t_paiements - this.t_ismoney];
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

</style>
