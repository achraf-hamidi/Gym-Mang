<template>
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-header ">
                    <div class="row">
                        <div class="col-md-12">
                            <h3>
                                {{ $t('content.pages.adherents.profile.info_adherent.titre') }} 
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="card-body"> <br>
                    <div class="row">
                        <div class="col-md-8">
                            <form class="form-sample">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group mr-b-0em"  >
                                            <label class="form__label">{{$t('content.pages.adherents.profile.info_adherent.inputs.nom.titre')}}</label>
                                            <input  class="form-control mise_a_jour" v-model.trim="details_adherent.nom"  :placeholder="$t('content.pages.adherents.profile.info_adherent.inputs.nom.placeholder')" />
                                        </div> 
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group mr-b-0em"  >
                                            <label class="form__label">{{$t('content.pages.adherents.profile.info_adherent.inputs.email.titre')}}</label>
                                            <input  class="form-control mise_a_jour" v-model.trim="details_adherent.email"   :placeholder="$t('content.pages.adherents.profile.info_adherent.inputs.email.placeholder')" />
                                        </div> 
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group mr-b-0em" >
                                            <label class="form__label">{{$t('content.pages.adherents.profile.info_adherent.inputs.cin.titre')}}</label>
                                            <input  class="form-control mise_a_jour" v-model.trim="details_adherent.cin" :placeholder="$t('content.pages.adherents.profile.info_adherent.inputs.cin.placeholder')" />
                                        </div>
                                         
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group mr-b-0em"  >
                                            <label class="form__label">{{$t('content.pages.adherents.profile.info_adherent.inputs.phone.titre')}}</label>
                                            <input  class="form-control mise_a_jour" v-model.trim="details_adherent.tele"   :placeholder="$t('content.pages.adherents.profile.info_adherent.inputs.phone.placeholder')" />
                                        </div>
                                         
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group mr-b-0em"  >
                                            <label class="form__label">{{$t('content.pages.adherents.profile.info_adherent.inputs.gender.titre')}}</label>
                                            <input  class="form-control mise_a_jour" v-model.trim="details_adherent.gender"   :placeholder="$t('content.pages.adherents.profile.info_adherent.inputs.gender.placeholder')" />
                                        </div>
                                        
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group mr-b-0em"  >
                                            <label class="form__label">{{$t('content.pages.adherents.profile.info_adherent.inputs.birth.titre')}}</label> 
                                            <input  class="form-control mise_a_jour" v-model.trim="details_adherent.date_naiss" />
                                        </div> 
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group mr-b-0em"  >
                                            <label class="form__label">{{$t('content.pages.adherents.profile.info_adherent.inputs.address.titre')}}</label>
                                            <textarea  class="form-control mise_a_jour" v-model.trim="details_adherent.adresse" :placeholder="$t('content.pages.adherents.profile.info_adherent.inputs.address.placeholder')"> </textarea>
                                        </div>
                                         
                                    </div> 
                                </div>
                            </form>
                        </div>
                        <div class="col-md-4">
                            <div class="d-flex flex-column">
                                <div class="wrapper text-center">
                                    <div class="text-center">
                                        <img class="photo-adherent" style="width: 70%; height : 100%;" :src="adherent.url">
                                    </div>
                                    <p><b>{{ $t('content.pages.adherents.profile.info_adherent.integrer') }}  : </b>
                                        <span class="mb-4" id="net-profit-legend"> {{date_integration}} </span></p>
                                    <p><b>{{ $t('content.pages.adherents.profile.info_adherent.parrain') }}  : </b> {{ details_adherent.parent.code_client }} {{details_adherent.parent.nom }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
 
export default {
    props: ['code', 'details_adherent'],
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
                image: null,
                url: '',
            }, 
             date_integration: null,
        }
    },

    mounted() {
        console.log('Component mounted.')
    },
    methods: { 
       /* PersonnellesInfos(code) {
            this.adherent.nom = this.details_adherent.nom
            this.adherent.email = this.details_adherent.email
            this.adherent.tele = this.details_adherent.tele
            this.adherent.date_naiss = new Date(this.details_adherent.date_naiss)
            this.adherent.cin = this.details_adherent.cin
            this.adherent.gender = this.details_adherent.gender
            this.adherent.adresse = this.details_adherent.adresse
            //this.details_adherent.image = this.details_adherent.image
            this.adherent.url = `/admin/adherents/photos/${this.details_adherent.image}`
            if (typeof this.details_adherent.integrations[0] !== "undefined")
                this.date_integration = this.details_adherent.integrations[0].date_debut
        }, */
         
    },
    beforeMount() {
       // this.PersonnellesInfos(this.code);
       //this.adherent.url = `/admin/adherents/photos/${this.details_adherent.image}`
       this.adherent.url =`${window.location.origin}/clubi/public/admin/adherents/photos/${this.details_adherent.image}`

    },
    mounted() {},
}

</script>
<style>
.mise_a_jour {
    pointer-events: none;
    background: #eee;
}

</style>
