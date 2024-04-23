<template>
    <div class="main-panel">
        <div v-if="($can('Consulter le profil d\'un utilisateur') && auth.id != utilisateur.id ) || ( auth.id == utilisateur.id && $can('Consulter le profil personnel') )" class="content-wrapper">
            <div class="row">
                <add-utilisateur v-if="$can('Ajouter un utilisateur') || $can('Modifier un utilisateur')" @RefreshListUtlisateurs="RefreshListUtlisateurs($event)"></add-utilisateur>
                <modifier-password v-if="$can('Modifier les mots de passe des utilisateurs') || $can('Modifier le mot de passe personnel')" ></modifier-password>

                <div class="col-md-12 ">
                    <router-link class="float-right" v-if="$can('Consulter la liste des utilisateurs')" :to="{name: 'utilisateurs'}">
                        {{ $t('side.menu.utilisateurs') }}
                    </router-link><br><br>
                </div>

                <div class="col-md-6 grid-margin stretch-card">
                    <div class="card">
                        <div  class="card-body">
                            <div class="row">
                                <!-- <div class="col-md-12">
                                    <img style="width : 150px;" :src="`/admin/utilisateurs/photos/${utilisateur.image}`" alt="Profile image"> </a>
                                </div> -->
                                <div class="col-md-12">
                                <a href="#"> <!-- Add your actual href value here -->
                                    <img style="width: 150px;" :src="`/clubi/public/admin/utilisateurs/photos/${utilisateur.image}`" alt="Profile image">
                                </a>
                                </div>
                            </div>
                            <div v-if="utilisateur.name" class="wrapper">
                                <div class="d-flex w-100 pt-2 mt-4">
                                    <p class="mb-0 font-weight-semibold">Nom et prénom</p>
                                    <div class="wrapper ml-auto d-flex align-items-center">
                                        <p class="mb-0">{{utilisateur.name}}</p>
                                    </div>
                                </div>
                                <div class="d-flex w-100 pt-2">
                                    <p class="mb-0 font-weight-semibold">Adresse Email</p>
                                    <div class="wrapper ml-auto d-flex align-items-center">
                                        <p class="mb-0">{{utilisateur.email}}</p>
                                    </div>
                                </div>
                                <div class="d-flex w-100 pt-2">
                                    <p class="mb-0 font-weight-semibold">Numéro de téléphone</p>
                                    <div class="wrapper ml-auto d-flex align-items-center">
                                        <p class="mb-0">{{utilisateur.tele}}</p>
                                    </div>
                                </div>
                                <div class="d-flex w-100 pt-2">
                                    <p class="mb-0 font-weight-semibold">CIN</p>
                                    <div class="wrapper ml-auto d-flex align-items-center">
                                        <p class="mb-0">{{utilisateur.cin}}</p>
                                    </div>
                                </div>
                                <div class="d-flex w-100 pt-2">
                                    <p class="mb-0 font-weight-semibold">Genre</p>
                                    <div class="wrapper ml-auto d-flex align-items-center">
                                        <span v-if="utilisateur.gender == 'Homme'">{{$t('content.text.homme')}}</span>
                                        <span v-else>{{$t('content.text.femme')}}</span>
                                    </div>
                                </div>
                                <div class="d-flex w-100 pt-2">
                                    <p class="mb-0 font-weight-semibold">Date de création </p>
                                    <div class="wrapper ml-auto d-flex align-items-center">
                                         <p class="mb-0">{{utilisateur.created_at | formatDate }}</p>
                                    </div>
                                </div>
                                <div class="d-flex w-100 pt-2">
                                    <p class="mb-0 font-weight-semibold">Statut</p>
                                    <div class="wrapper ml-auto d-flex align-items-center">
                                         

                                        <label v-if="utilisateur.is_valide == 1" class="badge badge-success pb-2 pt-2">{{$t('content.pages.utilisateurs.recherche.statut.valid')}}</label>
                                                        <label v-else class="badge badge-danger pb-2 pt-2">{{$t('content.pages.utilisateurs.recherche.statut.bloque')}}</label>


                                    </div>


                                </div>
                            </div>
                            <div class="row">
                                <div class="mt-3 col-12">    
                                <span v-if="($can('Modifier un utilisateur') && auth.id != utilisateur.id ) || ( auth.id == utilisateur.id )" data-toggle="modal" data-target=".bd-example-modal-lg" @click="Edit(utilisateur)" class="pt-2 pb-2 mdi-edit-btn"> <i class="mdi mdi-pen"></i> Modifier Les informations </span>
                            </div>




                               <div class="mt-3 col-12"> 
                                <span v-if="($can('Modifier les mots de passe des utilisateurs') && auth.id != utilisateur.id ) || ( auth.id == utilisateur.id && $can('Modifier le mot de passe personnel') )" data-toggle="modal" data-target=".change-password" @click="EditPassword(utilisateur)" class="pt-2 pb-2 mdi-edit-btn"> <i class="mdi mdi-key"></i> Modifier le mot de passe</span>
                            </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-header ">
                            <div class="row">
                                <div class="col-md-12">
                                    <h3>
                                        Listes des accès 
                                    </h3>
                                </div>
                            </div>
                        </div>
                        <div class="card-body" style="position: relative;">
                            <div class="table-responsive" style="height: 100%;position: relative;"><br>
                                <table v-if="paginatedPermissions.length >0" class="table table-striped table-hover">
                                    <thead class="thead-dark">
                                        <tr>
                                             <th>Permissions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(permission, index) in paginatedPermissions" :key="index">
                                            <!--<td width="10%"> {{ indexStart + ++index }}</td>-->
                                            <td>{{ permission.name }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div v-else class="aucune col-md-12">
                                    <span v-if="utilisateur.id == auth.id"><i class="mdi-style mdi mdi-alert"></i> Aucun accès</span>
                                    <span v-else><i class="mdi-style mdi mdi-alert"></i>Aucun accès</span>
                                </div>
                                <br>
                                <br>
                                <br>
                                <br>
                                <div v-if="pageSize <= permissions.length" class="mt-3 column is-12" style="position: absolute;bottom: 5px;width: 100%;"><br>
                                    <nav class="pagination is-right" role="navigation" aria-label="pagination">
                                        <div class="pagination-list">
                                            <div>
                                                <a  @click="prev"> {{$t('content.bouton.prev')}} </a>
                                            </div>
                                            <div>
                                                <span class="pagination-link go-to has-text-orange" aria-label="Goto page 1"> {{Showing}} </span>
                                            </div>
                                            <div>
                                                <a  @click="next"> {{$t('content.bouton.next')}} </a>
                                            </div>
                                        </div>
                                    </nav>
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
            utilisateur: [],
            auth: [],
            permissions: [],
            current: 1,
            pageSize: 12,
            index: 12,
            search_utilisateur: '',
            formData: {},

        }
    },
    mounted() {
        //console.log('Component mounted.')
    },
    beforeMount() {
        this.InfosUtilisateur()
    },
    computed: {
        indexStart() {
            // console.log((this.current - 1) * this.pageSize)
            return (this.current - 1) * this.pageSize;
        },
        indexEnd() {
            //console.log(this.indexStart + this.pageSize)
            return this.indexStart + this.pageSize;
        },
        paginatedPermissions() {
            //console.log(this.permissions.slice(this.indexStart, this.indexEnd))
            return this.permissions.slice(this.indexStart, this.indexEnd);
        },
        Showing() {

            return this.$t('content.text.affichage', { start : (this.indexStart + 1), end : this.index , total : this.permissions.length  } ) ; //,  page : this.current
           // return 'Showing ' + (this.indexStart + 1) + '-' + this.index + ' of ' + this.permissions.length + ', Page ' + this.current
        },

    },
    methods: {
        prev() {
            if (this.index != this.pageSize) {
                if (this.current == 1)
                    this.current = 1
                else {
                    this.index = this.index - this.paginatedPermissions.length
                    this.current--;
                    //console.log('index : ' + this.index)
                }
            }
        },
        next() {
            if (this.index != this.permissions.length) {
                if (this.index != this.permissions.length && this.pageSize <= this.permissions.length) {
                    this.current++;
                    this.index = this.index + this.paginatedPermissions.length
                    //console.log('index : ' + this.index)
                }
            }
        },
        InfosUtilisateur() {
            if (typeof this.$refs.formContainer !== "undefined")
                this.PluginLoader(false, this.$refs.formContainer)
            const config = { headers: { 'content-type': 'multipart/form-data' } }
            axios.get('/api-admin/utilisateur/' + this.$route.params.email, config).then((response) => {
                this.utilisateur = response.data.utilisateur;
                this.permissions = response.data.permissions;
                this.auth = response.data.auth

            });
        },

        RefreshListUtlisateurs(newUtilisateurs) {
            if (newUtilisateurs != null) {
                this.utilisateur.unshift(newUtilisateurs)
            }
        },
        Edit(utilisateur) {
            this.eventUtilisateurs.$emit('edit', { "utilisateur": utilisateur })
        },
        EditPassword(utilisateur) {
            this.eventUtilisateurs.$emit('change-password', { "utilisateur": utilisateur })
        },
    },

}

</script>
<style>
.img-xlg {
    width: 100%;
}


.pagination-list {
    display: flex;
    justify-content: space-between;
    align-items: center;
    width: 100%;
}

.pagination-list a {
    cursor: pointer;
}

.pagination-list .disabled {
    cursor: no-drop !important;
}


.change-info {
    cursor : pointer;
    color : #5b5bff;
    font-size: 16px;
}


</style>
