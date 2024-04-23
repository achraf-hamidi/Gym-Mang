<template>
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-header ">
                <div class="row">
                    <div class="col-md-12">
                        <div class="d-flex justify-content-between">
                            <h3 class="card-title mb-0">{{ $t('content.pages.adherents.profile.recharges.titre') }} </h3>
                            <span style="color : #000 !important;">
                                {{ $t('content.pages.adherents.profile.recharges.solde') }} : {{ wallet.solde }} Dh
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body"> <br>
                <div class="row">
                    <div v-if="wallet.recharges.length > 0" class="col-12">
                        <table id="data-packs" class="datatables table table-striped table-bordered table-hover">
                            <thead class="thead-dark">
                                <tr>
                                    <th>{{ $t('content.pages.adherents.profile.recharges.tableau.date_recharge') }} </th>
                                    <th>{{ $t('content.pages.adherents.profile.recharges.tableau.recharge') }} </th>
                                    <th>{{ $t('content.pages.adherents.profile.recharges.tableau.type') }} </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(recharge, index) in wallet.recharges">
                                    <td> {{ recharge.created_at}} </td>
                                    <td> {{ recharge.recharge }} {{$t('content.text.dh')}} </td>
                                    <td> {{ recharge.type }} </td>
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
    </div>
</template>
<script>
export default {
    props: ['code', 'wallet'],
    data() {
        return {
            //adherent : []
        }
    },
    mounted() {
        console.log(this.code)
    },
    methods: {
        /* QrCode(code){
            axios.get('/api-admin/adherent-qr-code/'+this.code).then(res => {
                console.log(res.data)
                this.adherent = res.data
            });
         }*/
    },
    beforeMount() {
        //this.QrCode(this.code);
    },
}

</script>
