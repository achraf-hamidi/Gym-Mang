<template>
    <div class="main-panel">
        <div v-if="$can('Consulter les frais')" class="content-wrapper">
            <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <h1 class="card-title">
                                        <i class="mdi-style-content   mdi mdi-currency-usd"></i>
                                         
                                        <span class="titre">
                                            Liste des frais
                                        </span>
                                    </h1><br><br>
                                </div>
                            </div>
                            <div class="parametrages-tablette-mobile row">
                                <add-assurance v-if="$can('Ajouter des frais') || $can('Modifier des frais')" ></add-assurance>
                                <list-assurances :assurances="assurances"></list-assurances>
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
import PictureInput from 'vue-picture-input'

export default {
    components: {
        PictureInput
    },
    data() {
        return {
            assurances: [],
         }
    },
    mounted() { 
    },
    methods: {
         

        Listassurances() {
            axios.get('/api-admin/parametrages/assurances').then((response) => {
                this.assurances = response.data.tous_les_frais;
                console.log(this.assurances)
            });
        },

    },
    beforeMount() {
        if (this.$can('Consulter les frais'))
            this.Listassurances();
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

#video {
    background-color: #000000;
}

#canvas {
    display: none;
}

</style>
