<template>
    <div class="col-md-4 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">{{ $t('content.pages.activities.activitie.titre') }}</h4>
          <form @submit.prevent="submit($event)" class="forms-sample">
              <div class="form-group mr-b-0em" :class="{ 'form-group--error': $v.libelle.$error }">
                  <label class="form__label">{{ $t('content.pages.activities.activitie.libelle') }}</label>
                  <input class="form-control" v-model.trim="$v.libelle.$model" @input="setlibelle($event.target.value)" :placeholder="$t('content.pages.activities.activitie.libelle_placeholder')"/>
              </div>
              <div v-if="$v.libelle.$dirty">
                    <div class="error" v-if="!$v.libelle.required">{{ $t('validation.required', { attribute : $t('content.pages.activities.activitie.libelle') }) }}</div>
                    <div class="error" v-if="!$v.libelle.minLength">
                      {{ $t('validation.min.numeric', { attribute : $t('content.pages.activities.activitie.libelle'), min : $v.libelle.$params.minLength.min  }) }}
                  </div>
              </div>
            <div class="form-group">
              <label>{{ $t('content.pages.activities.activitie.image') }}</label>
              <input type="file" id="upload-image" class="file-upload-default"  v-on:change="onImageChange">
              <div class="input-group col-xs-12">
                <input type="text" id="input-name-image" class="form-control file-upload-info" disabled :placeholder="$t('content.pages.activities.activitie.image_placeholder')">
                <span class="input-group-append">
                  <button  onclick="document.getElementById('upload-image').click()"  class="file-upload-browse btn btn-info" type="button">{{ $t('content.bouton.upload') }}</button>
                </span>
              </div>
              <div v-if="$v.image.$dirty">
                <div class="error" v-if="!$v.image.required">{{ $t('validation.required', { attribute : $t('content.pages.activities.activitie.image') }) }}</div>
              </div>
            </div>
            <div  class="form-group">
              <img style="width: 100%;" :src="url">
            </div>
            <button type="submit" class="btn btn-success mr-2">{{ $t('content.bouton.ajout') }}</button>
            <button class="btn btn-light">{{ $t('content.bouton.annuler') }}</button>
          </form>
        </div>
      </div>
    </div>
</template>


<script>
    import { required, minLength, numeric, between, maxLength, email   } from 'vuelidate/lib/validators'
export default {
  props : ['activities'],
  data() {
    return {
        libelle: '',
        image : '',
        url : '',
        formData         : {},
        submitStatus : null
     }
  },
  validations: {
    libelle: {
      required,
      minLength: minLength(3)
    },
    image : {
      required
    }
  },
  methods: {
    setlibelle(value) {
      this.libelle = value
      this.$v.libelle.$touch()
    },
    setimage(value) {
      this.image = value
      this.$v.image.$touch()
    },
    onImageChange(e){
        document.getElementById("input-name-image").placeholder = e.target.files[0].name; 
        console.log(e.target.files[0]);
        this.$v.image.$model = e.target.files[0];

       if ( /\.(jpe?g|png|gif)$/i.test( e.target.files[0].name ) ) {
            let reader    = new FileReader();
            reader.onload = (e) => {  this.url = e.target.result;  };
            reader.readAsDataURL(this.$v.image.$model);
        }else{
            console.log('not image');
        }
        console.log(this.url)


    },
    submit(event) {   
      this.$v.$touch()
      if (this.$v.$invalid) {
        this.submitStatus = 'ERROR'
      } else {
        this.submitStatus = 'PENDING'
        this.formData = new FormData();
        this.formData.append('libelle', this.$v.libelle.$model);
        this.formData.append('image', this.$v.image.$model);
        const config  = {  headers: { 'content-type': 'multipart/form-data' }   }
        axios.post('/api-admin/store-activitie', this.formData, config ).then(res => {
              document.getElementById("input-name-image").placeholder = this.$t('content.pages.activities.activitie.image_placeholder')
              this.$v.libelle.$model = null
              this.$v.image.$model = null 
              this.url = null
              this.$v.$reset()
              this.$emit('RefreshListActivities', res.data);
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
