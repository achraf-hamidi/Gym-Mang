<template>
    <div class="row">
        <div class="col-md-3 grid-margin stretch-card">
            <div class="card bg-primary text-black ">
                <div class="card-body pb-0">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mb-0">{{$t('content.pages.adherents.profile.revenu.net_paye')}}</h4>
                        <p class="font-weight-semibold mb-0"></p>
                    </div>
                    <h3 class="font-weight-medium"> {{revenu.total}} {{$t('content.text.dh')}}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3 grid-margin stretch-card ">
            <div class="card bg-success text-black">
                <div class="card-body pb-0">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mb-0">{{$t('content.pages.adherents.profile.revenu.montant_paye')}}</h4>
                        <p class="font-weight-semibold mb-0"> </p>
                    </div>
                    <h3 class="font-weight-medium mb-4"> {{revenu.montant_paye}} {{$t('content.text.dh')}}</h3>
                </div>
            </div>
        </div>
         <div class="col-md-3 grid-margin stretch-card">
            <div class="card bg-warning text-white ">
                <div class="card-body pb-0">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mb-0">{{$t('content.pages.adherents.profile.revenu.retourne')}}</h4>
                        <p class="font-weight-semibold mb-0"></p>
                    </div>
                    <h3 class="font-weight-medium">{{revenu.is_money}} {{$t('content.text.dh')}}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3 grid-margin stretch-card">
            <div class="card bg-danger text-white ">
                <div class="card-body pb-0">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mb-0">{{$t('content.pages.adherents.profile.revenu.reste')}}</h4>
                        <p class="font-weight-semibold mb-0"></p>
                    </div>
                    <h3 class="font-weight-medium">{{revenu.reste}} {{$t('content.text.dh')}}</h3>
                </div>
            </div>
        </div> 
    </div>
</template>
<script>
export default {
    props: ['code', 'revenu'],
    data() {
        return {
            //  paiements : []
        }
    },
    mounted() {
        console.log(this.code)
    },
    methods: {
        /*RevenuPaiements(code){
           axios.get('/api-admin/revenu-paiements/'+this.code).then(res => {
               console.log(res.data)
               this.paiements = res.data
           });
        }*/
    },
    beforeMount() {
        //this.RevenuPaiements(this.code);
    },
}

</script>
