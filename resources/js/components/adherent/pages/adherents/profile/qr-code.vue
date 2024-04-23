<template>
    <div class="col-md-4">
        <div class="adherent-qr-code">
            <div class="d-flex badge-style ">
                <div style="z-index: 9;">
                    <img class="photo-adherent" style="width: 70px; height : 70px;" :src="`/clubi/public/admin/adherents/photos/${details_adherent.image}`">
                    <p><b> {{ details_adherent.nom }}</b> </p>
                    <p><b> {{ details_adherent.email }}</b> </p>
                    <p> {{$t('content.pages.adherents.profile.qrcode.matricule')}} : <b>{{ details_adherent.code_client }}</b> </p>
                </div>
                <div style="z-index: 9;" class="qr-code">
                    <div class="d-flex pl-4">
                        <img style="width: 75px;" :src="`/clubi/public/admin/adherents/qr_code/${details_adherent.qr_code}.png`">
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props: ['code', 'details_adherent'],
    data() {
        return {
            adherent: []
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
