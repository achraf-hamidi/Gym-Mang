<template>
    <div style="overflow: auto;" class="card">
        <div class="card-header ">
            <div class="row">
                <div class="col-md-12">
                    <div class="d-flex justify-content-between">
                        <h3 class="card-title mb-0">Historique des services</h3>  

                         <router-link v-if="$can('Consulter la liste des recettes')" style="padding : 0px!important;"   :to="{name: 'recettes', query : { adherent : `${code}` }}" class="nav-link">
                           Voir détails
                         </router-link>


                    </div>
                </div>
            </div>
        </div>
        <div class="card-body" ><!--:class="[ abonners.length > 0 ? 'height-scroll' : '' ]"--> 
            <div class="row mt-2"> 
                                <div v-if="recettes.length>0" class="col-md-12">
                                    <div style="overflow-x:auto;" id="packs" class="tab-pane fade in active show table-responsive ">
                                        <table id="data-packs" class="datatables table table-striped table-bordered table-hover">
                                            <thead class="thead-dark">
                                                <tr>
                                                     <th>Services</th>
                                                     <th>Date de commande</th>
                                                    <th>Montant</th>
                                                    <th>Montant payé</th>
                                                    <th>Reste à payer</th>
                                                 </tr>
                                            </thead>
                                            <tbody v-for="(recette, index) in recettes">
                                                <tr> 
                                                    <td> 
                                                        <span v-if="recette.service" >
                                                            {{ recette.service.nom }} 
                                                        </span>
                                                    </td>
                                                    <td>
                                                        {{ recette.date_commande | formatDate }}
                                                    </td>
                                                    <td> {{ recette.montant }} {{$t('content.text.dh')}}</td>
                                                    <td>
                                                        <span v-if="recette.recettepaiements" >
                                                            {{TotalRecettePaiements( recette.montant, recette.recettepaiements, recette.id)}}
                                                           
                                                        </span>
                                                    </td>
                                                    <td :class="[ rest_a_paye[recette.id] > 0 ? 'bg-red' : 'bg-green' ]">  {{ rest_a_paye[recette.id] }} {{$t('content.text.dh')}}
                                                    </td>                                                </tr>
                                            </tbody>
                                        </table>
                                    </div> 
                                </div>
                                <div v-else class="aucune col-md-12">
                                    <i class="mdi-style mdi mdi-alert"></i> {{$t('content.alerts.aucune_info')}}
                                </div>
                            </div>
        </div>
    </div>
</template>
<script>
export default {
    props: ['code'],
    data() {
        return {
            abonners: [],
            active_row : '',
             recettes: [],
             pagination: [],
             formData: {}, 
             paiements : [],
             rest_a_paye : [],
        }
    },
    mounted() {
        //console.log(this.code)
    },
    methods: {
        ListRecettes(data_filtrer) {
            if (typeof this.$refs.formContainer !== "undefined")  
                this.PluginLoader(false, this.$refs.formContainer)
            const current_page = (this.pagination.current_page) ? this.pagination.current_page : 1;
            this.formData = new FormData(); 

                 console.log('matricule : ' + this.code)
                this.formData.append("filtrer[matricule]", this.code);
            
 
            const config = { headers: { 'content-type': 'multipart/form-data' } }
            axios.post('/api-admin/recettes?page=' + current_page+'&take=10', this.formData, config).then((response) => {
                this.recettes = response.data.recettes;
                //this.pagination = response.data.recettes;
                console.log(response.data.recettes)
             });
        },
        filtrer(event) {
            if (this.datetimePicker != null) {
                const date = this.datetimePicker; 
                this.data_filtrer.datetimes = [date[0].toDateString(), date[1].toDateString()]
            }
            this.pagination = []
             this.ListRecettes(this.data_filtrer)
        },
        TotalRecettePaiements(montant, paiements, recette_id){
            var total = 0.00;
            for (var i = 0; i < paiements.length; i++) {
                total += parseFloat(paiements[i].montant_paye)
            }
            if (paiements) {
                this.paiements[recette_id] = parseFloat(total).toFixed(2)
                this.rest_a_paye[recette_id] = parseFloat(montant - total).toFixed(2)
            }

            return parseFloat(total).toFixed(2);

        }

    },
    beforeMount() {
        if (this.$route.query.adherent) {
            this.data_filtrer.matricule = this.$route.query.adherent
        } 
        this.filtrer();  
      },
    computed:  {



    }
}

</script>

<style>
.active_row {
    background: rgba(0, 0, 0, 0.05);
}
</style>