<template>
    <nav class="sidebar sidebar-offcanvas" id="sidebar">
        <ul style="margin-bottom: 100px !important;" class="nav">
            <li class="nav-item nav-profile">
                <a href="#" class="nav-link">
                    <div class="profile-image">
                        <img class="img-xs rounded-circle" :src="`/clubi/public/admin/utilisateurs/photos/${user.image}`" alt="profile image">
                        <div class="dot-indicator bg-success"></div>
                    </div>
                    <div class="text-wrapper">
                        <p class="profile-name"> {{ user.name }} </p>
                        <p class="designation" v-if="role">Admin</p>
                        <p class="designation" v-else>Assistant</p>
                    </div>
                </a>
            </li>
            <li class="nav-item nav-category">Main Menu</li>
            <li class="nav-item">
                <router-link :to="`/dashboard`" class="nav-link">
                    <i class="mdi-style mdi mdi-view-dashboard"></i>
                    <span class="menu-title">{{ $t('side.menu.dashboard') }} shhs</span>
                </router-link>
            </li>
        </ul>
    </nav>
</template>
<script>
export default {
    props: ['user'],
    data() {
        return {
            formData: {},
            submitStatus: null,
            role: '',
        }
    },
    mounted() {
        console.log('Component mounted.') 

    },

}

</script>
<style>
.router-link-active:before {
    /* content: "";
    position: absolute;
    top: 0px;
    left: 35px;
    display: block;
    height: 100%;
    width: 2px;
    background: #fff !important;*/
}


.mdi-style {
    color: #fff;
    font-size: 25px;
    margin-right: 10px;
}

</style>
