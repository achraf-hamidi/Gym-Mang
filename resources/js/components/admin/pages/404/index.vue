<template>
    <div class="main-panel" >
        <div class="content-wrapper page-404">
            <div class="row flex-grow">
                <div class="col-lg-7 mx-auto text-white">
                    <div class="row ">
                        <div class="col-lg-12 error-page-divider  pl-lg-4">
                            <h1 class="display-1 mb-0 text-center error-404" style="font-size: 10rem; color: #fff !important;">404</h1>
                             <h3 v-if="$route.query.code" style="color: #fff !important;" class="font-weight-light text-center">
                                Adhérent n'existe pas
                            </h3>
                            <h3 v-else style="color: #fff !important;" class="font-weight-light text-center">
                                La page que vous recherchez est introuvable.
                            </h3>
                        </div>
                    </div>
                    <div class="row mt-5">
                        <div class="col-12 text-center mt-xl-2">
                            <router-link class="text-white font-weight-medium back-to-home" :to="{name: 'dashboard'}">
                                <span style="color : #fff !important;">Retour au tableau de bord</span>
                            </router-link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {}
    },
    mounted() {},
    methods: {}
}

</script>
<style>


.page-404 {
    background: linear-gradient(45deg, #0030E0, #0073F8AB, #1CB5E0D9, #00C9EBCC) !important;
    background: -webkit-linear-gradient(45deg, #0030E0, #0073F8AB, #1CB5E0D9, #00C9EBCC) !important;
    width : 100% !important;
   display: flex;
   justify-content: center;
   align-items: center;


}


@media only screen and (min-width: 768px)  {

.error-404 {
    font-size: 10rem !important;  
}

}

@media only screen and (max-width: 767px)  {

.error-404 {
    font-size: 6rem !important;
}

}


</style>