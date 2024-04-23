<template>
    <div class="main-panel">
        <div  class="content-wrapper">
            <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-header ">
                <div class="row">
                    <div class="col-md-12">
                        <h3>Envoyer des emails  </h3>
                    </div>
                </div>
            </div>
            <div ref="formContainer" class="card-body">

                <form @submit.prevent="listMailsAdherents($event)" class="forms-sample">
                                        <div class="row" >
                                            <div class="col-md-6">
                                                <div class="form-group mr-b-0em">
                                                    <label class="form__label">Nom et prénom</label>
                                                     <input v-model="data_filtrer.nom" placeholder="Nom et prénom" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group mr-b-0em">
                                                    <label class="form__label">ID ou Cin</label>
                                                     <input v-model="data_filtrer.matricule" placeholder="ID ou Cin" class="form-control">
                                                </div>
                                            </div>  

                                            <div class="col-md-4">
                                                <div class="form-group mr-b-0em">
                                                    <label class="form__label">Genre</label>
                                                    <select class="form-control" v-model="data_filtrer.genre">
                                                        <option value="tous">Tous</option>
                                                        <option value="Homme">Homme</option>
                                                        <option value="Femme">Femme</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group mr-b-0em">
                                                    <label class="form__label">Statut</label>
                                                    <select class="form-control" v-model="data_filtrer.is_actif">
                                                        <option value="tous">Tous</option>
                                                        <option value=">=">Actif</option>
                                                        <option value="<">Inactif</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group mr-b-0em">
                                                    <label class="form__label">Paiements</label>
                                                    <select class="form-control" v-model="data_filtrer.completed_paiement">
                                                        <option value="tous">Tous</option>
                                                        <option value="0">Impayés </option>
                                                        <option value="1">Payés</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group mr-b-0em">
                                                    <label class="form__label"> {{ $t('content.pages.abonnements.encours.recherche.abonnement') }}</label>
                                                    <!--<select class="form-control" v-model="data_filtrer.abonnement">
                                                        <option value="tous">Tous</option>
                                                        <option v-for="(abonnement, index) in abonnements" :value="abonnement.id"> {{ abonnement.libelle }} </option>
                                                    </select>-->

                                                    <multiselect v-model="data_filtrer.abonnement" :options="abonnements" :custom-label="libeleAbonnement" placeholder="Recherche.." label="libelle" track-by="libelle"></multiselect>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group mr-b-0em">
                                                    <label class="form__label"> {{ $t('content.pages.abonnements.encours.recherche.pack') }}</label>
                                                    <!--<select class="form-control" v-model="data_filtrer.pack">
                                                        <option value="tous">Tous</option>
                                                        <option v-for="(pack, index) in packs" :value="pack.id">
                                                            {{ pack.description }} ( <span v-for="(acts) in pack.activities"> {{ acts.name }} </span> )
                                                        </option>
                                                    </select>-->

                                                    <multiselect v-model="data_filtrer.pack" :options="packs" :custom-label="libelePack" placeholder="Recherche.." label="description" track-by="description"></multiselect>

                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group mr-b-0em">
                                                    <label title="Date d'écheance" class="form__label"> Date du au</label> <br>
                                                    <!--<date-picker style="width: 100%;"  v-model="data_filtrer.date_echeance" type="date" format="DD/MM/YYYY"></date-picker>-->
                                                    <date-picker style="width: 100%;" :show-time-panel="showTimeRangePanel" @close="handleRangeClose" v-model="datetimePicker" range type="datetime" format="DD/MM/YYYY"></date-picker>
                                                </div>
                                            </div>

                                            
                                            <div class="col-6 text-left">
                                                <button type="button"  @click="clearDataInputs" class="btn btn-primary mr-2">{{$t('content.text.select_tout')}}</button>
                                             </div>
                                            <div class="col-6 text-right">
                                                <button type="submit" class="btn btn-success mr-2"> <i class="mdi mdi-magnify"></i> {{ $t('content.bouton.recherche') }}</button>
                                                <a  @click="clearDataInputs" href="javascript:void(0)" class="btn btn-light">{{ $t('content.bouton.annuler') }}</a>
                                            </div>
                                        </div>
                                    </form>


                    
                <div  class="row list-distinataires" v-if="list_mails_adherents.length > 0">
                    <div class="col-md-12">
                        <p> <b>Destinataires : </b> </p>
                    </div>
                    <div class="col-md-12" >
                        <div   >
                            <span class="distinataires" v-for="(adherent, index ) in list_mails_adherents">
                                <span class="delete-item-mail" @click="DeleteMail(adherent, index)" >
                                    X
                                </span>
                                {{adherent.id_empreinte }}, {{adherent.email }}
                            </span>
                        </div>
                    </div>
                </div>

                <form v-if="list_mails_adherents.length > 0" @submit.prevent="SubmitMail($event)" class="forms-sample">
                    <div class="row">  
                        <div class="col-md-12">
                            <div class="form-group mr-b-0em" :class="{ 'form-group--error': $v.titre.$error }">
                                <label class="form__label">Objet</label>
                                <input class="form-control" v-model.trim="$v.titre.$model" @input="settitre($event.target.value)" placeholder="Objet" />
                            </div>
                            <div v-if="$v.titre.$dirty">
                                <div class="error" v-if="!$v.titre.required && submitStatus == true ">{{ $t('validation.required', { attribute : 'Objet est obligatoire' }) }}</div>
                                <!--<div class="error" v-if="!$v.titre.numeric">
                          Number ...
                      </div>-->
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group mr-b-0em" :class="{ 'form-group--error': $v.description.$error }">
                                <label class="form__label">Message</label>
                                <textarea class="form-control" v-model.trim="$v.description.$model" @input="setdescription($event.target.value)" placeholder="Message" > 

                                </textarea>
                            </div>
                            <div v-if="$v.description.$dirty">
                                <div class="error" v-if="!$v.description.required && submitStatus == true ">{{ $t('validation.required', { attribute : 'Message est obligatoire' }) }}</div>
                                <!--<div class="error" v-if="!$v.description.numeric">
                          Number ...
                      </div>-->
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 text-right">
                        <button type="submit" class="btn btn-primary mr-2 btn-envoyer"> <i class=" mdi mdi-send"></i> Envoyer</button>
                        <a @click="clearDataInputs" href="javascript:void(0)" class="btn btn-light">{{ $t('content.bouton.annuler') }}</a>
                    </div>
                </form>

            </div>
        </div>
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
            lang: {
                formatLocale: {
                    firstDayOfWeek: 1,
                },
                monthBeforeYear: false,
            }, 
            datetimePicker: [null,null],
            showTimeRangePanel: false,
            data_filtrer: {
                abonnement : [],
                pack : [],
                nom : '',
                genre  :'tous',
                matricule : '',
                date_echeance : [],
                completed_paiement : 'tous',
                is_actif : 'tous'
             },
             list_mails_adherents: [],
             packs: [],
            abonnements: [],


            list_adherents: [],
            value_id_adherent: [],
            titre: '',
            description: '',
            formData: {},
            submitStatus: false
        }
    },
    validations: {

        titre: {
            required,
            //numeric
        },
        description: {
            required
        }
    },
    methods: {

        libeleAbonnement({ nb_mois, libelle }) {
            return `${libelle} ( ${nb_mois} Mois )`
        },
        libelePack({ description, prix, activities }) {
            var all_activities = ''
            for (var i = 0; i < activities.length; i++)
                all_activities = activities[i].name + ', ' + all_activities
            return `${description} ( ${all_activities.replace(/,(?=\s*$)/, '')} )`
        },
        ListPacks() {
            axios.get('/api-admin/parametrages/packs').then((response) => {
                this.packs = response.data;

            });
        },
        ListTypeAbonnements() {
            axios.get('/api-admin/parametrages/abonnements').then((response) => {
                console.log("data : " )
                                 console.log(response.data)
                this.abonnements = response.data;

            });
        },

        listMailsAdherents(data_filtrer) {
            if (typeof this.$refs.formContainer !== "undefined")  
                this.PluginLoader(false, this.$refs.formContainer)

            //const current_page = (this.pagination.current_page) ? this.pagination.current_page : 1;
            this.formData = new FormData();
            if (this.data_filtrer.nom != '')
                this.formData.append("filtrer[nom]", this.data_filtrer.nom);

             
            if (this.data_filtrer.matricule != '')
                this.formData.append("filtrer[matricule]", this.data_filtrer.matricule);


            if (this.data_filtrer.genre != '' && this.data_filtrer.genre != 'tous')
                this.formData.append("filtrer[genre]", this.data_filtrer.genre);


            if (this.data_filtrer.is_actif != '' && this.data_filtrer.is_actif != 'tous')
                this.formData.append("filtrer[is_actif]", this.data_filtrer.is_actif);

            if (this.data_filtrer.completed_paiement != '' && this.data_filtrer.completed_paiement != 'tous')
                this.formData.append("filtrer[completed_paiement]", this.data_filtrer.completed_paiement);
 


             if (this.data_filtrer.abonnement != null && typeof this.data_filtrer.abonnement.id !== "undefined") {
                console.log('test')
                this.formData.append("filtrer[abonnement_id]", this.data_filtrer.abonnement.id);
            }
            if (this.data_filtrer.pack != null && typeof this.data_filtrer.pack.id !== "undefined"){
                console.log('test')
                this.formData.append("filtrer[pack_id]", this.data_filtrer.pack.id);
            }

            /*if (this.data_filtrer.date_echeance  !=null )
                this.formData.append("filtrer[date_echeance]", this.data_filtrer.date_echeance.toDateString());
                */

            if (this.datetimePicker[0] != null && this.datetimePicker[1]) {
                const date = this.datetimePicker; 
                this.data_filtrer.date_echeance = [date[0].toDateString(), date[1].toDateString()]
                this.formData.append("filtrer[date][from]", this.data_filtrer.date_echeance[0]);
                this.formData.append("filtrer[date][to]", this.data_filtrer.date_echeance[1]);
            }

            //console.log(this.data_filtrer.date_echeance.toDateString())

            const config = { headers: { 'content-type': 'multipart/form-data' } }
            axios.post('/api-admin/list-mails-adherents', this.formData, config).then((response) => {
                console.log( response.data)
                 this.list_mails_adherents = response.data.list_mails_adherents; 
             });
        }, 


        nameWithCodeClient({ code_client, nom }) {
            return `${code_client} -  ${nom} `
        },
        ListAdherents() {
            axios.get('/api-admin/list-adherents-has-abonners').then((response) => {
                this.list_adherents = response.data;
            });
        },
        settitre(value) {
            this.titre = value
            this.$v.titre.$touch()
        },
        setdescription(value) {
            this.description = value
            this.$v.description.$touch()
        },
        SubmitMail(event) {
            
            document.querySelector('.btn-envoyer').disabled = true;

            this.$v.$touch()
            this.submitStatus = true
            if (this.$v.$invalid) {
                //this.submitStatus = 'ERROR'
            } else {

                this.$fire(this.AlertFire('envoi_mail')).then((result) => {

                    if (typeof this.$refs.formContainer !== "undefined")  
                        this.PluginLoader(false, this.$refs.formContainer)

                    if (result.value) {
                        //this.submitStatus = 'PENDING'
                        this.formData = new FormData(); 

                        this.formData.append('titre', this.$v.titre.$model);
                        this.formData.append('description', this.$v.description.$model);


                        for (var i = 0; i <  this.list_mails_adherents.length; i++) {
                            console.log(this.list_mails_adherents[i]['email'])
                            this.formData.append("list_mails_adherents["+i+"]", this.list_mails_adherents[i]['email'] );
                        }

                        const config = { headers: { 'content-type': 'multipart/form-data' } }
                        axios.post('/api-admin/email-manuel', this.formData, config).then(response => {
                                     
                                if(response.data.email == true) {
                                    this.AlertResponseTrue("", "Email envoyé" , "success");
            document.querySelector('.btn-envoyer').disabled = false;

                                    this.$v.titre.$model = null
                                    this.$v.description.$model = null
                                    this.list_mails_adherents = []
                                    this.submitStatus = false
                                    this.$v.$reset()
                                }
                                
                            }).catch(e => {
                                    this.AlertResponseTrue("", "Email non envoyer" , "error");
                            })
                            .finally(f => {
                                setTimeout(() => {
                                    //this.submitStatus = 'OK'
                                }, 500)
                            })
                    }

                })


            }
        },
        DeleteMail(adherent, index){
            this.list_mails_adherents.splice(index, 1)
        },
        clearDataInputs() {
            this.$v.titre.$model = null
            this.$v.description.$model = null
            this.data_filtrer.abonnement =  []
            this.data_filtrer.pack =  []
            this.data_filtrer.nom =  ''
            this.data_filtrer.genre  = 'tous'
            this.data_filtrer.matricule =  ''
            this.data_filtrer.date_echeance =  []
            this.data_filtrer.completed_paiement =  'tous'
            this.data_filtrer.is_actif =  'tous'
            this.datetimePicker = [null, null]
            this.listMailsAdherents(this.data_filtrer)

        },
         handleRangeClose() {
            this.showTimeRangePanel = false;
        },
        handleRangeClose() {
            this.showTimeRangePanel = false;
        }, 
    },
    beforeMount() {
        this.ListAdherents()
         this.ListTypeAbonnements();
        this.ListPacks();
    }
}

</script>

<style>

.list-distinataires {
    margin: 28px 0px;
border: 1px solid #c0c0c0;
padding: 10px;
}


.distinataires {
     background: #1CB5E0;
border-radius: 12px;
padding: 2px 10px;
color: #000;
font-size: 14px;
font-weight: 500;
margin-right: 9px;
display: inline-flex;
margin-bottom: 6px;
justify-content: center;
align-items: center
}

.delete-item-mail{
  width: 18px;
  background: #f44;
  border-radius: 50%;
  font-size: 10px;
  display: flex;
  justify-content: center;
  align-items: center;
  cursor: pointer;
  height: 18px;
  color: #fff;
  margin-right: 10px;
}


</style>