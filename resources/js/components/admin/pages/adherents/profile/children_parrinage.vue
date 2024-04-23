<template>
    <div class="col-md-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-header ">
                <div class="row">
                    <div class="col-md-12">
                        <div class="d-flex justify-content-between">
                            <h3 class="card-title mb-0">{{ $t('content.pages.adherents.profile.parrinages.titre') }} </h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body"  :class="[ children_parrinage.length > 0 ? 'height-scroll' : '' ]" >  
                <div class="row">
                    <div v-if="children_parrinage.length > 0" class="col-12">
                        <table id="data-packs" class="datatables table table-striped table-bordered table-hover">
                            <thead class="thead-dark">
                                <tr>
                                    <th>{{ $t('content.pages.adherents.profile.parrinages.tableau.matricule') }} </th>
                                    <th>{{ $t('content.pages.adherents.profile.parrinages.tableau.nom') }} </th>
                                    <th>{{ $t('content.pages.adherents.profile.parrinages.tableau.email') }} </th> 
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(children, index) in children_parrinage">
                                    <td>
                                        <a href="javascript:void(0)" v-if="$can('Profile adhérent')" @click="ProfileAdherent(children.code_client)">
                                            <a> {{ children.code_client }} </a>
                                        </a>
                                        <span v-else>{{ children.code_client }}</span>
                                    </td>
                                    <td> {{ children.nom }} </td>
                                    <td> {{ children.email }} </td> 
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div v-else class="aucune col-md-12">
                        <i class="mdi-style mdi mdi-alert" ></i> {{$t('content.alerts.aucune_info')}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props: ['code', 'children_parrinage'],
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
        ProfileAdherent(code_client) {
            const code = code_client;
            window.location.href = `/admin/adherent/${code}`
        },
    },
    beforeMount() {
        //this.QrCode(this.code);
    },
}

</script>
