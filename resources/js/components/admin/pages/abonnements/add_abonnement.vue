
<template>
     <div class="col-md-4 d-flex align-items-stretch grid-margin">
        <div class="row flex-grow">
          <div class="col-12">
            <div class="card">
              <div class="card-body">
                <h4 class="card-title">{{ $t('content.pages.activities.pack.titre') }}</h4>
                <form @submit.prevent="submit($event)" class="forms-sample">
                  <div class="form-group mr-b-0em" :class="{ 'form-group--error': $v.libelle.$error }">
                      <label class="form__label">{{ $t('content.pages.activities.pack.libelle') }}</label>
                      <input class="form-control" v-model.trim="$v.libelle.$model" @input="setlibelle($event.target.value)" :placeholder="$t('content.pages.activities.pack.desc_placeholder')"/>
                  </div>
                  <div v-if="$v.libelle.$dirty">
                        <div class="error" v-if="!$v.libelle.required">
                          {{ $t('validation.required', { attribute : $t('content.pages.activities.pack.libelle') }) }}
                        </div>
                        <div class="error" v-if="!$v.libelle.minLength">
                          {{ $t('validation.min.numeric', { attribute : $t('content.pages.activities.pack.libelle'), min : $v.libelle.$params.minLength.min  }) }}
                      </div>
                  </div>

                  <div class="form-group mr-b-0em" :class="{ 'form-group--error': $v.nb_mois.$error }">
                      <label class="form__label">{{ $t('content.pages.activities.pack.price') }}</label>
                      <input class="form-control" v-model.trim="$v.nb_mois.$model" @input="setnb_mois($event.target.value)" :placeholder="$t('content.pages.activities.pack.price_placeholder')"/>
                  </div>
                  <div v-if="$v.nb_mois.$dirty">
                        <div class="error" v-if="!$v.nb_mois.required">{{ $t('validation.required', { attribute : $t('content.pages.activities.pack.price') }) }}</div>
                        <div class="error" v-if="!$v.nb_mois.decimal">
                          {{ $t('validation.numeric', { attribute : $t('content.pages.activities.pack.price') }) }}
                      </div>
                  </div>
                  <button type="submit" class="btn btn-success mr-2">{{ $t('content.bouton.ajout') }}</button>
            <button class="btn btn-light">{{ $t('content.bouton.annuler') }}</button>
                </form>
              </div>
            </div>
          </div>
        </div>
    </div>
</template>

<script>
    import { required, minLength, numeric,  decimal, between, maxLength, email   } from 'vuelidate/lib/validators'
export default {
  props : ['options_activities', 'packs'],
  data() {
    return {
        libelle: '',
        nb_mois : '',                         
        formData         : {},
        submitStatus : null,
        arr : []
     }
  },
  validations: {
    libelle: {
      required,
      minLength: minLength(3)
    },
    nb_mois : {
      required,
      decimal
    }
  },
  methods: {

    setlibelle(value) {
      this.libelle = value
      this.$v.libelle.$touch()
    },
    setnb_mois(value) {
      this.nb_mois = value
      this.$v.nb_mois.$touch()
    },

    


    submit(event) {
      this.$v.$touch()
      if (this.$v.$invalid) {
        this.submitStatus = 'ERROR'
      } else {
        this.submitStatus = 'PENDING'
        this.formData = new FormData();
        this.formData.append('libelle', this.$v.libelle.$model);
        this.formData.append('nb_mois', this.$v.nb_mois.$model);
        const config  = {  headers: { 'content-type': 'multipart/form-data' }   }
        axios.post('/api-admin/store-abonnement', this.formData, config ).then(res => {
          this.eventAbonnement.$emit('update', res.data)
          this.$v.libelle.$model = null
          this.$v.nb_mois.$model = null 
          this.$v.$reset()
         }).catch(e => {
        })
        .finally( f => { 
            setTimeout(() => {
              this.submitStatus = 'OK'
            }, 500)
        })        
        
      }
    }
  },
  beforeMount(){ 
  }
}
</script>

<style src='vue-multiselect/dist/vue-multiselect.min.css'></style>