<template>
     <div class="col-md-8 d-flex align-items-stretch grid-margin">
        <div class="row flex-grow">
          <div class="col-12">
            <div class="card">
              <div class="card-body">
                <h4 class="card-title">{{ $t('content.pages.activities.pack.titre') }}</h4>
                <form @submit.prevent="submit($event)" class="forms-sample">
                  <!--<div class="form-group">
                    <label for="descriptionpack">{{ $t('content.pages.activities.pack.description') }}</label>
                    <input type="email" class="form-control" id="descriptionpack" :placeholder="$t('content.pages.activities.pack.desc_placeholder')">
                  </div>-->

                  <div class="form-group mr-b-0em" :class="{ 'form-group--error': $v.description.$error }">
                      <label class="form__label">{{ $t('content.pages.activities.pack.description') }}</label>
                      <input class="form-control" v-model.trim="$v.description.$model" @input="setdescription($event.target.value)" :placeholder="$t('content.pages.activities.pack.desc_placeholder')"/>
                  </div>
                  <div v-if="$v.description.$dirty">
                        <div class="error" v-if="!$v.description.required">
                          {{ $t('validation.required', { attribute : $t('content.pages.activities.pack.description') }) }}
                        </div>
                        <div class="error" v-if="!$v.description.minLength">
                          {{ $t('validation.min.numeric', { attribute : $t('content.pages.activities.pack.description'), min : $v.description.$params.minLength.min  }) }}
                      </div>
                  </div>

                  <div class="form-group mr-b-0em" :class="{ 'form-group--error': $v.prix.$error }">
                      <label class="form__label">{{ $t('content.pages.activities.pack.price') }}</label>
                      <input class="form-control" v-model.trim="$v.prix.$model" @input="setprix($event.target.value)" :placeholder="$t('content.pages.activities.pack.price_placeholder')"/>
                  </div>
                  <div v-if="$v.prix.$dirty">
                        <div class="error" v-if="!$v.prix.required">{{ $t('validation.required', { attribute : $t('content.pages.activities.pack.price') }) }}</div>
                        <div class="error" v-if="!$v.prix.decimal">
                          {{ $t('validation.numeric', { attribute : $t('content.pages.activities.pack.price') }) }}
                      </div>
                  </div>



                  <div class="form-group mr-b-0em" :class="{ 'form-group--error': $v.value_activities.$error }">
                      <label class="form__label">{{ $t('content.pages.activities.pack.tags_activities.name') }}</label>
                      <multiselect v-model.trim="value_activities" tag-placeholder="Add this as new tag" :placeholder="$t('content.pages.activities.pack.tags_activities.placeholder')" label="name" track-by="code" :options="options_activities" :multiple="true" :taggable="true" @tag="addTag"></multiselect>
                      <div v-if="$v.value_activities.$dirty">
                          <div class="error" v-if="!$v.value_activities.required">{{ $t('validation.required', { attribute : $t('content.pages.activities.pack.tags_activities.name') }) }}</div>
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
        description: '',
        prix : '',                         
        formData         : {},
        submitStatus : null,
        value_activities: [],
        arr : []
     }
  },
  validations: {
    value_activities : {
      required
    },
    description: {
      required,
      minLength: minLength(3)
    },
    prix : {
      required,
      decimal
    }
  },
  methods: {

    addTag (newTag) {
      const tag = {
        name: newTag,
        code: newTag.substring(0, 2) + Math.floor((Math.random() * 10000000))
      }
      this.options_activities.push(tag)
      this.value_activities.push(tag)
    },


    setdescription(value) {
      this.description = value
      this.$v.description.$touch()
    },
    setprix(value) {
      this.prix = value
      this.$v.prix.$touch()
    },
     setvalue_activities(value) {
      this.secteur = value
      this.$v.secteur.$touch()
    },

    


    submit(event) {
      this.$v.$touch()
      if (this.$v.$invalid) {
        this.submitStatus = 'ERROR'
      } else {
        this.submitStatus = 'PENDING'
        this.formData = new FormData();
        this.formData.append('description', this.$v.description.$model);
        this.formData.append('prix', this.$v.prix.$model);
        for (var  i = 0; i < this.value_activities.length; i++) {
          this.formData.append("value_activities["+i+"]", this.value_activities[i]['code']);
        }

        const config  = {  headers: { 'content-type': 'multipart/form-data' }   }
        axios.post('/api-admin/check-pack', this.formData, config ).then(response => {
          if (response.data == false) {
              axios.post('/api-admin/store-pack', this.formData, config ).then(res => {
                this.$v.description.$model = null
                this.$v.prix.$model = null 
                this.$v.value_activities.$model = null
                this.$v.$reset()

                this.$emit('RefreshListPacks', res.data);
              }).catch(e => {
              })
              .finally( f => { 
                  setTimeout(() => {
                    this.submitStatus = 'OK'
                  }, 500)
              })
          }else{
            alert('deja exist')
          }
        }).catch(e => {
        
        })
        
        
      }
    }
  },
  beforeMount(){ 
  }
}
</script>

<style src='vue-multiselect/dist/vue-multiselect.min.css'></style>
