<template>
    <div class="main-panel">
        <div v-if="$can('Consulter les promotions')" class="content-wrapper">
            <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <h1 class="card-title">
                                        <i class="mdi-style-content  mdi mdi-bullhorn"></i>
                                        <span class="titre">
                                            {{ $t('content.pages.parametrages.promotions.titre') }}
                                        </span>
                                    </h1><br><br>
                                </div>
                            </div>
                            <div class="row parametrages-tablette-mobile">
                                <add-promotion  v-if="$can('Ajouter une promotion') || $can('Modifier une promotion')" @RefreshListPromotions="RefreshListPromotions($event)" :promotions="promotions"></add-promotion>
                                <div class="col-md-8 grid-margin stretch-card">
                                    <div class="card">
                                        <div class="card-header ">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <h3>{{$t('content.pages.parametrages.promotions.liste.titre')}}</h3>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="form-group mr-b-0em"><label class="form__label"><i class="mdi mdi-filter-outline"></i> {{$t('content.pages.parametrages.promotions.liste.filtrer.titre')}}</label> <input v-model="search_promotion" :placeholder="$t('content.bouton.filtrer_recherche')" class="form-control"></div>
                                            <div v-if="filteredListPromotions.length>0" style="overflow-x:auto;" id="packs" class="tab-pane fade in active show">
                                                
                                                <table id="data-promotions" class="datatables table table-striped table-bordered table-hover">
                                                    <thead class="thead-dark">
                                                        <tr>

                                                            <th>Description</th>
                                                            <th>{{$t('content.pages.parametrages.promotions.liste.tableau.remise')}}</th>
                                                            <th>{{$t('content.pages.parametrages.promotions.liste.tableau.pack')}}</th>
                                                            <th>{{$t('content.pages.parametrages.promotions.liste.tableau.date_lancement')}}</th>
                                                            <th>{{$t('content.pages.parametrages.promotions.liste.tableau.date_fin')}}</th>
                                                            <th>{{$t('content.pages.parametrages.promotions.liste.tableau.statut')}}</th>
                                                            <th>{{$t('content.pages.parametrages.promotions.liste.tableau.action')}}</th> 
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr v-for="(promotion, index) in filteredListPromotions">
                                                             <!--<td><img v-if="promotion.image != null" :src="`/admin/promotions/${promotion.image}`"></td>-->
                                                           <td>{{ promotion.description }}</td>
                                                            <td>{{ promotion.remise }} {{$t('content.text.dh')}}</td>
                                                            <td>{{ promotion.pack.description }}</td>
                                                            <td>{{ promotion.date_debut | formatDate }}</td>
                                                            <td>{{ promotion.date_fin | formatDate }}</td>
                                                            <td>
                                                                <label v-if="Date.now() < new Date(promotion.date_fin)" class="badge badge-success">Active</label>
                                                                <label v-else class="badge badge-danger">Expiré</label>
                                                            </td>
                                                            <td>
                                                                <span  v-if="$can('Modifier une promotion')" @click="EditPromotion(promotion, index)" class="mdi-edit-btn"> <i class="mdi mdi-pen"></i> </span>
                                                                <span  v-if="$can('Supprimer une promotion')" @click="Delete(promotion.id, index)" class="mdi-delete-btn"> <i class="mdi mdi-delete-forever"></i> </span>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <vue-pagination :pagination="paginationPromotions" @paginate="Listpromotions()" :offset="4"></vue-pagination>
                                            </div>
                                            <div v-else class="aucune col-md-12">
                                                <i class="mdi-style mdi mdi-alert"></i> {{$t('content.alerts.aucune_info')}}
                                            </div>
                                        </div>
                                    </div>
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
            paginationPromotions: [],
            promotions: [],
            search_promotion: '',
        }
    },
    mounted() {
        console.log('Component mounted.')
    },
    methods: {
        Listpromotions() {
            const current_page = (this.paginationPromotions.current_page) ? this.paginationPromotions.current_page : 1;
            axios.get('/api-admin/parametrages/promotions?page=' + current_page).then((response) => {
                this.promotions = response.data.data;
                this.paginationPromotions = response.data;
                console.log(this.paginationPromotions)
            });
        },
        RefreshListPromotions(newpromotion) {
            if (newpromotion != null) {
                this.promotions.unshift(newpromotion)
            }
        },
        EditPromotion(promotion, index) {
            this.eventPromotions.$emit('edit', { "promotion": promotion, "index": index })
        },
        Delete(promotion_id, index) {
            this.$fire(this.AlertFire("delete")).then((result) => {
                if (result.value) {
                    this.submitStatus = 'PENDING'
                    this.formData = new FormData();
                    this.formData.append('promotion_id', promotion_id);
                    const config = { headers: { 'content-type': 'multipart/form-data' } }
                    axios.post('/api-admin/parametrages/destroy-promotion', this.formData, config).then(res => {
                            switch (res.data) {
                                case false:
                                    this.AlertResponseFalse("", this.$t('content.alerts.promotion.n_existe'), "warning")
                                    break;
                                default:
                                    this.AlertResponseTrue("",  this.$t('content.alerts.suppression.success') , "success");
                                    this.promotions.splice(index, 1)
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
        if (this.$can('Consulter les promotions'))
            this.Listpromotions();
    },
    created: function() {
        this.eventPromotions.$on('update', data => {
            if (data != null) {
                Vue.set(this.promotions, data.index, data.promotion)
            }
        })
    },
    computed: {
        filteredListPromotions() {
            return this.promotions.filter(promotion => {
                return promotion.description.toLowerCase().includes(this.search_promotion.toLowerCase())
            })
        }
    }
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
