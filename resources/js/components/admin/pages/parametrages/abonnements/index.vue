<template>
    <div class="main-panel">
        <div v-if="$can('Consulter les types d\'abonnement')" class="content-wrapper">
            <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <h1 class="card-title">
                                        <i class="mdi-style-content  mdi mdi-shape-plus"></i>
                                         
                                        <span class="titre"> Types d'abonnement
                                        </span>
                                    </h1><br><br>
                                </div>
                            </div>
                            <div class="parametrages-tablette-mobile row">
                                <add-abonnement v-if="$can('Ajouter un nouveau type d’abonnement')" ></add-abonnement>
                                <list-abonnements :abonnements="abonnements"></list-abonnements>
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

            abonnements: [],
        }
    },
    mounted() { 
    },
    methods: { 

        ListAbonnements() {
            axios.get('/api-admin/parametrages/abonnements').then((response) => {
                this.abonnements = response.data;
                console.log(this.abonnements)
            });
        }

    },
    beforeMount() {
        if (this.$can('Consulter les types d\'abonnement'))
            this.ListAbonnements();
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
