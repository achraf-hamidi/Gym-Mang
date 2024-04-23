<template>
    <div class="main-panel">
        <div v-if="$can('Recharges')" class="content-wrapper">
                <div v-if="$can('Ajouter un recharge')" class="row">
                                <add-recharge></add-recharge>
                            </div>
            <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <h1 class="card-title">
                                        <i class="mdi-style-content  mdi mdi-cash-100"></i>
                                        <span class="titre"> {{ $t('content.pages.paiements.recharges.titre') }} </span>
                                    </h1><br><br>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group mr-b-0em"><br>
                                        <label class="form__label"><i class="mdi mdi-filter-outline"></i> {{$t('content.pages.paiements.recharges.filtrer.titre')}}</label>
                                        <input v-model="search_adherent" :placeholder="$t('content.pages.paiements.recharges.filtrer.placeholder')" class="form-control">
                                    </div>
                                </div>
                                <div v-if="filteredListRecharges.length>0" class="col-md-12">
                                    <table id="data-packs" class="datatables table table-striped table-bordered table-hover">
                                        <thead class="thead-dark">
                                            <tr>

                                                <th>{{ $t('content.pages.paiements.recharges.tableau.matricule') }} </th>
                                                <th>{{ $t('content.pages.paiements.recharges.tableau.nom') }} </th>
                                                <th>{{ $t('content.pages.paiements.recharges.tableau.date_recharge') }} </th>
                                                <th>{{ $t('content.pages.paiements.recharges.tableau.prix') }} </th>
                                                <th>{{ $t('content.pages.paiements.recharges.tableau.type') }} </th>
                                                <th>{{ $t('content.pages.paiements.recharges.tableau.action') }} </th> 
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(recharge, index) in filteredListRecharges">
                                                <td>
                                                    <router-link v-if="$can('Profile adhérent')" :to="{name: 'adherent', params:{code: recharge.ToAdherent.code_client }}">
                                                        <a> {{ recharge.ToAdherent.code_client }} </a>
                                                    </router-link>
                                                    <span v-else>{{ recharge.ToAdherent.code_client }}</span>
                                                </td>
                                                <td> {{ recharge.ToAdherent.nom }}</td>
                                                <td> {{ recharge.created_at | formatDate }} </td>
                                                <td> {{ recharge.recharge }} {{$t('content.text.dh')}} </td>
                                                <td> {{ recharge.type }} </td>
                                                <td>
                                                    <span v-if="$can('Supprimer un recharge')" @click="Delete(recharge.id, index)" class="mdi-delete-btn"> <i class="mdi mdi-delete-forever"></i> </span>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div v-else class="aucune col-md-12">
                                    <i class="mdi-style mdi mdi-alert"></i> {{$t('content.alerts.aucune_info')}}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <vue-pagination :pagination="pagination" @paginate="listRecharges()" :offset="4"></vue-pagination>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div v-else class="content-wrapper">
            <havent-permission></havent-permission>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            pagination: [],
            list_recharges: [],
            search_adherent: '',
            saveIndex: -1
        }
    },
    mounted() {
        console.log('Component mounted.')
    },
    methods: {
        listRecharges() {
            const current_page = (this.pagination.current_page) ? this.pagination.current_page : 1;
            axios.get('/api-admin/recharges?page=' + current_page).then((response) => {
                this.list_recharges = response.data.recharges.data;
                this.pagination = response.data.recharges;
            });
        },
        Delete(id_recharge, index) {
            this.$fire(this.AlertFire('delete')).then((result) => {
                if (result.value) {
                    this.submitStatus = 'PENDING'
                    this.formData = new FormData();
                    this.formData.append('id_recharge', id_recharge);
                    const config = { headers: { 'content-type': 'multipart/form-data' } }
                    axios.post('/api-admin/recharge/destroy', this.formData, config).then(res => {
                            switch (res.data) {
                                case false:
                                    this.AlertResponseFalse("",  this.$t('content.alerts.recharge.n_existe'), "warning")
                                    break;
                                default:
                                    this.AlertResponseTrue("", this.$t('content.alerts.suppression.success') , "success");
                                    this.list_recharges.splice(index, 1)
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
        this.listRecharges();
    },
    computed: {
        filteredListRecharges() {
            return this.list_recharges.filter(recharge => {
                return recharge.ToAdherent.code_client.toLowerCase().includes(this.search_adherent.toLowerCase()) ||
                recharge.ToAdherent.cin.toLowerCase().includes(this.search_adherent.toLowerCase()) ||
                recharge.ToAdherent.nom.toLowerCase().includes(this.search_adherent.toLowerCase())
            })
        }
    },
    created: function() {
        this.eventRecharge.$on('update', data => {
            this.list_recharges.unshift(data)
        })
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
