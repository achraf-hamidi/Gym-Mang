<template>
    <div class="col-md-8 grid-margin stretch-card">
        <div class="card">
            <div class="card-header ">
                <div class="row">
                    <div class="col-md-12">
                        <h3>Liste des frais</h3>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="form-group mr-b-0em"><label class="form__label"><i class="mdi mdi-filter-outline"></i> Filtrer</label> <input v-model="search_typefrais" :placeholder="$t('content.bouton.filtrer_recherche')" class="form-control"></div>
                <div v-if="filteredListtypefrais.length>0" id="assurances" class="table-responsive">                   
                    <table id="data-assurances" class="datatables table table-striped table-bordered table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th> Nom de frais</th>
                                <th> Type </th>
                                <th> Prix </th>
                                <th> Action </th> 
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(frais, index) in filteredListtypefrais">
                                <td>
                                    {{ frais.libelle }}
                                    <span v-if="frais.typefrais.libelle == 'Assurance'">
                                         ( {{frais.nb_mois}} mois )
                                    </span>
                                </td>
                                <td>{{ frais.typefrais.libelle }}</td>
                                <td>{{ frais.prix }} Dh</td>
                                <td>
                                    <span v-if="$can('Modifier des frais')"  @click="Edit(frais, index)" class="mdi-edit-btn"> <i class="mdi mdi-pen"></i> </span>
                                    <span v-if="$can('Supprimer des frais')"  @click="Delete(frais.id, index)" class="mdi-delete-btn"> <i class="mdi mdi-delete-forever"></i> </span>
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
    props: ["assurances"],
    data() {
        return {
            search_typefrais: '',
        }
    },
    mounted() {
        console.log('Component mounted.')
    },
    methods: {
        Edit(assurance, index) {
            this.eventTypeassurance.$emit('edit', { "assurance": assurance, "index": index })
        },
        Delete(assurance_id, index) {
            this.$fire(this.AlertFire('delete')).then((result) => {
                if (result.value) {
                    this.submitStatus = 'PENDING'
                    this.formData = new FormData();
                    this.formData.append('assurance_id', assurance_id);
                    const config = { headers: { 'content-type': 'multipart/form-data' } }
                    axios.post('/api-admin/parametrages/destroy-assurance', this.formData, config).then(res => {
                            switch (res.data) {
                                case "relationship":
                                    this.AlertResponseFalse("", "Impossible de supprimer cet élément , car il est encore affecté à des adhérents", "warning")
                                    break;
                                case false:
                                    this.AlertResponseFalse("", this.$t('content.alerts.frais.n_existe'), "warning")
                                    break;
                                default:
                                    this.AlertResponseTrue("", this.$t('content.alerts.suppression.success') , "success");
                                    this.assurances.splice(index, 1)
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
        this.eventTypeassurance.$on('add', data => {
            if (data != null) {
                this.assurances.unshift(data)
            }
        })
        this.eventTypeassurance.$on('update', data => {
            if (data != null) {
                Vue.set(this.assurances, data.index, data.assurance)
            }
        })
    },
    beforeMount() {

    },
    computed: {
        filteredListtypefrais() {
            return this.assurances.filter(assurance => {
                return assurance.prix.toLowerCase().includes(this.search_typefrais.toLowerCase()) ||  assurance.libelle.toLowerCase().includes(this.search_typefrais.toLowerCase()) || assurance.nb_mois.toString().toLowerCase().includes(this.search_typefrais.toString().toLowerCase()) || assurance.typefrais.libelle.toLowerCase().includes(this.search_typefrais.toLowerCase())
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
