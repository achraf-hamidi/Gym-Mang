<template>
    <div style="overflow: auto;" class="card">
        <div class="card-header ">
            <div class="row">
                <div class="col-md-12">
                    <div class="d-flex justify-content-between">
                        <h3 class="card-title mb-0">{{$t('content.pages.adherents.profile.historiques.abonnements.titre')}}</h3>
                        <!--<a href="javascript::void(0);"  @click="ListePaiementsbyAbonner('tous')"><small>{{$t('content.bouton.afficher_tout')}}</small></a>-->
 

                         <router-link style="padding : 0px!important;" v-if="abonners.length > 0"  :to="{name: 'historiques-abonnement', params : { code : `${abonners[0].adherent.code_client}` }}" class="nav-link">
                           Voir détails
                         </router-link>

                    </div>
                </div>
            </div>
        </div>
        <div class="card-body" ><!--:class="[ abonners.length > 0 ? 'height-scroll' : '' ]"--> 
            <div v-if="abonners.length > 0" class="table-responsive">
                 <table class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th>{{$t('content.pages.adherents.profile.historiques.abonnements.tableau.date_debut')}}</th>

                            <th>{{$t('content.pages.adherents.profile.historiques.abonnements.tableau.date_fin')}}</th>
                            <th>Abonnement & Pack</th>
                            <th>Jours restants</th>
                            <!--<th>NB des mois * Prix UN</th>-->
                            <th>{{$t('content.pages.adherents.profile.historiques.abonnements.tableau.remise')}}</th>
                            
                            <th>Net à payer</th>
                            <th>Sommes Payés</th>
                            <th>Restant à payer</th>
                            <th>Statut</th>
                            <th>Action</th>

                            <!--<th>Abonnement</th>
                                <th>Pack</th>-->
                        </tr>
                    </thead>
                    <tbody>
                        <tr :class="[(active_row == index ? 'active_row' : '')]" v-for="(abonner, index) in abonners" ><!--@click="ListePaiementsbyAbonner(abonner.id, index)" -->
                            <td> {{ abonner.date_debut | formatDate }} </td>
                            <td> {{ abonner.date_fin | formatDate }} </td>
                            <td> 
                            <b>{{ abonner.abonnements[0].libelle }}, {{ abonner.packs[0].description }}</b> : <br>
                            <span v-for="(activitie, i) in abonner.packs[0].activities">
                                {{ activitie.name }} <span v-if="((i + 1) != abonner.packs[0].activities.length)">,</span>
                            </span> 
                            <td :class="[ abonner.RestDays < 0 ? 'bg-red' : 'bg-green' ]" >
                                                        <span v-if="abonner.RestDays < 0">
                                        {{$t('content.text.jours_terminer')}}
                                    </span>
                                    <span v-else >
                                        {{ abonner.RestDays }} {{$t('content.text.jours')}}
                                    </span>


                                                    </td>


                             </td>
                            
                            <!--<td> {{  PackFoisMois(abonner) }} Dh </td>-->
                            <td> {{ RemisePromo(abonner)  }} {{$t('content.text.dh')}}</td>
                            <td> {{ Total(abonner)  }} {{$t('content.text.dh')}}</td>
                            <td>
                                {{  abonner.sommes_paye }} {{$t('content.text.dh')}}
                            </td>
                            <td>
                                {{  Total(abonner) - abonner.sommes_paye }} {{$t('content.text.dh')}}
                            </td>
                             <td>
                                <label v-if="abonner.RestDays > 0" class="badge badge-success">Actif</label>
                                <label v-else class="badge badge-danger">Inactif</label>
                            </td>
                            <td> 
                                <span v-if="(Total(abonner) - abonner.sommes_paye) > 0">
                                    <router-link v-if="$can('Régler les impayés')"  title="Régler"  :to="{name: 'impayes', query : { adherent : `${abonner.adherent.code_client}`, id_abonnement : `${abonner.id}` }}" class="mdi-history-btn" >
                                   <i class="mdi mdi-cash-multiple"></i>
                                 </router-link>
                                </span>
                                <span v-else  >
                                    <router-link v-if="$can('Consulter l’historique des réglements')"  title="Historique des réglements "  :to="{name: 'reglements', query : { adherent : `${abonner.adherent.code_client}`, id_abonnement : `${abonner.id}` }}" class="mdi-history-btn" >
                                   <i class="mdi mdi-cash-multiple"></i>
                                 </router-link>
                                </span>
                                 

                                 <span title="Supprimer" v-if="$can('Supprimer un abonnement')" @click="SupprimerAbonnement( abonner.id )" class="mdi-delete-btn"> <i class="mdi mdi-delete-forever"></i> </span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div v-else class="aucune col-md-12">
                <i class="mdi-style mdi mdi-alert"></i> {{$t('content.alerts.aucune_info')}}
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
            active_row : ''
        }
    },
    mounted() {
        //console.log(this.code)
    },
    methods: {
        HistoriquesAbonners() {
            axios.get('/api-admin/historiques-abonners/' + this.code).then(res => {
                this.abonners = res.data
                console.log("res.data")
                console.log(res.data)
                this.eventProfile.$emit('list-paiements', this.abonners)
                this.eventProfile.$emit('list-activities', this.abonners)

                for (var i = 0 ; i < this.abonners.length ; i++ ) {
                    var sommes_paye = this.abonners[i].paiements.reduce((n, {prix}) => n + parseFloat(prix) , 0);

                    this.abonners[i].sommes_paye =  sommes_paye
                }


            });
        },
        ListePaiementsbyAbonner(abonnerID, index) {
            this.active_row = index
            this.eventProfile.$emit('filtrer-paiements', abonnerID)
            this.eventProfile.$emit('filtrer-activities', abonnerID)
        },
        PackFoisMois(abonner) {
            return parseFloat(abonner.packs[0].prix  ).toFixed(2)
            //return parseFloat(abonner.packs[0].prix * abonner.abonnements[0].nb_mois).toFixed(2)
        },
        RemisePromo(abonner) {
            var promo = (abonner.packs[0].pivot.promo) ? abonner.packs[0].pivot.promo : 0;
            return  parseFloat( abonner.remise) + parseFloat(promo)
        },
        Total(abonner){
            //return parseFloat( this.PackFoisMois(abonner) - this.RemisePromo(abonner) ) 
            return abonner.prix_ttc
        },
        SupprimerAbonnement(id_abonner) {
            this.$fire(
                    this.AlertFire('delete')
                ).then((result) => {
                    if (result.value) {
                        this.submitStatus = 'PENDING'
                        this.formData = new FormData();
                        this.formData.append('id_abonner', id_abonner); 
                        const config = { headers: { 'content-type': 'multipart/form-data' } }
                        axios.post('/api-admin/abonner/supprimer-abonnement', this.formData, config).then(res => {
                                switch (res.data.etat) {
                                    case false:
                                        this.AlertResponseFalse("Abonnement", "Abonnement n'existe pas", "warning")
                                        break;
                                    default:
                                        this.AlertResponseTrue("", "La suppression est effectué avec succès", "success");
                                        window.location.reload();
                                    break;
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
    beforeMount() {
        this.HistoriquesAbonners();
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