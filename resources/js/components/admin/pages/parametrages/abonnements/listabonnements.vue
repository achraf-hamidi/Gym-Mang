<template>
    <div class="col-md-8 grid-margin stretch-card">
        <div class="card">
            <div class="card-header ">
                <div class="row">
                    <div class="col-md-12">
                        <h3>Liste des types d'abonnement </h3>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="form-group mr-b-0em"><label class="form__label"><i class="mdi mdi-filter-outline"></i> {{$t('content.pages.parametrages.abonnements.liste.filtrer.titre')}}</label> <input v-model="search_abonnement" :placeholder="$t('content.bouton.filtrer_recherche')" class="form-control"></div>
                <div v-if="filteredListAbonnements.length>0" id="abonnements" class="">                   
                    <table id="data-abonnements" class="datatables table table-striped table-bordered table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th> Nom </th>
                                <th> {{$t('content.pages.parametrages.abonnements.liste.tableau.nb_mois')}} </th>
                                <th> {{$t('content.pages.parametrages.abonnements.liste.tableau.action')}} </th> 
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(abonnement, index) in filteredListAbonnements">
                                <td>{{ abonnement.libelle }}</td>
                                <td>{{ abonnement.nb_mois }} {{$t('content.text.mois')}}</td>
                                <td>
                                    <span v-if="$can('Modifier un type d’abonnement')"  @click="Edit(abonnement, index)" class="mdi-edit-btn"> <i class="mdi mdi-pen"></i> </span>
                                    <span v-if="$can('Supprimer un type d’abonnement')"  @click="Delete(abonnement.id, index)" class="mdi-delete-btn"> <i class="mdi mdi-delete-forever"></i> </span>
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
    </div>
</template>
<script>
export default {
    props: ["abonnements"],
    data() {
        return {
            search_abonnement: '',
        }
    },
    mounted() {
        console.log('Component mounted.')
    },
    methods: {
        Edit(abonnement, index) {
            this.eventTypeAbonnement.$emit('edit', { "abonnement": abonnement, "index": index })
        },
        Delete(abonnement_id, index) {
            this.$fire(this.AlertFire('delete')).then((result) => {
                if (result.value) {
                    this.submitStatus = 'PENDING'
                    this.formData = new FormData();
                    this.formData.append('abonnement_id', abonnement_id);
                    const config = { headers: { 'content-type': 'multipart/form-data' } }
                    axios.post('/api-admin/parametrages/destroy-abonnement', this.formData, config).then(res => {
                            switch (res.data) {
                                case "relationship":
                                    this.AlertResponseFalse("", this.$t('content.alerts.abonnement.affecter'), "warning")
                                    break;
                                case false:
                                    this.AlertResponseFalse("", this.$t('content.alerts.abonnement.n_existe'), "warning")
                                    break;
                                default:
                                    this.AlertResponseTrue("", "La suppression est effectué avec succès" , "success");
                                    this.abonnements.splice(index, 1)
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
    created: function() {
        this.eventTypeAbonnement.$on('add', data => {
            if (data != null) {
                this.abonnements.unshift(data)
            }
        })
        this.eventTypeAbonnement.$on('update', data => {
            if (data != null) {
                Vue.set(this.abonnements, data.index, data.abonnement)
            }
        })
    },
    beforeMount() {

    },
    computed: {
        filteredListAbonnements() {
            return this.abonnements.filter(abonnement => {
                return abonnement.libelle.toLowerCase().includes(this.search_abonnement.toLowerCase()) || abonnement.nb_mois.toString().toLowerCase().includes(this.search_abonnement.toString().toLowerCase())
            })
        }
    },

}

</script>
<style>
.nav.nav-tabs li {
    margin-left: 8px;
    position: relative;
    margin-bottom: 15px;
}

.nav.nav-tabs li a {
    text-decoration: none;
}


.nav.nav-tabs li a.active:after {
    content: '';
    width: 100%;
    position: absolute;
    height: 2px;
    background: #000;
}

</style>
