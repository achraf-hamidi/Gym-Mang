<template>
    <div class="main-panel">
        <div v-if="$can('Consulter la liste des utilisateurs')" class="content-wrapper">
            <div v-if="$can('Ajouter un utilisateur')" class="row">
                <div class="col-md-12 float-right text-right">
                    <button @click="ClearInputs" type="button" class="btn btn-primary" data-toggle="modal" data-target=".bd-example-modal-lg"><i class=" mdi mdi-plus"></i>{{ $t('content.pages.utilisateurs.nouveau.btn_ajout') }} </button>
                </div>
            </div><br>
            <div v-if="$can('Ajouter un utilisateur') || $can('Modifier un utilisateur')" class="col-md-12">
                <add-utilisateur @RefreshListUtlisateurs="RefreshListUtlisateurs($event)"></add-utilisateur>
            </div>
            <div v-if="$can('Modifier les mots de passe des utilisateurs')" class="col-md-12">
                <modifier-password ></modifier-password>
            </div>
            <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                    <div ref="formContainer" class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-8">
                                    <h1 class="card-title">
                                        <i class="mdi-style-content  mdi mdi-account-key"></i>
                                        <span class="titre"> {{ $t('content.pages.utilisateurs.titre') }}</span>
                                    </h1><br><br>
                                </div>
                                <div class="col-md-4">
                                    <p  class="text-right">
                                       <b> {{count_utilisateurs}} Utilisateurs</b>
                                    </p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <form @submit.prevent="filtrer($event)" class="forms-sample">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group mr-b-0em">
                                                    <label class="form__label">{{ $t('content.pages.utilisateurs.recherche.statut.titre') }}</label>
                                                    <select class="form-control" v-model="data_filtrer.is_valide">
                                                        <option value="tous">{{ $t('content.pages.utilisateurs.recherche.statut.tous') }}</option>
                                                        <option value="1">{{ $t('content.pages.utilisateurs.recherche.statut.valid') }} </option>
                                                        <option value="0">{{ $t('content.pages.utilisateurs.recherche.statut.bloque') }} </option>
                                                    </select>
                                                </div>
                                            </div>
                                            <!--<div class="col-6">
                                                <div class="form-group mr-b-0em">
                                                    <label class="form__label">{{ $t('content.pages.utilisateurs.recherche.date') }} (Optionnel) </label> <br>
                                                    <date-picker style="width: 100%;" :show-time-panel="showTimeRangePanel" @close="handleRangeClose" v-model="datetimePicker" range type="datetime" format="DD/MM/YYYY"></date-picker>
                                                </div>
                                            </div>-->
                                            <div class="col-12 text-right">
                                                <button type="submit" class="btn btn-success mr-2"> <i class="mdi mdi-magnify"></i> {{ $t('content.bouton.recherche') }}</button>
                                                <a @click="clearDataInputs" href="javascript:void(0)" class="btn btn-light">{{ $t('content.bouton.annuler') }}</a>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group mr-b-0em"><br>
                                        <label class="form__label"><i class="mdi mdi-filter-outline"></i> {{ $t('content.pages.utilisateurs.filtrer.titre') }}</label>
                                        <input v-model="search_utilisateur" :placeholder="$t('content.pages.utilisateurs.filtrer.placeholder')" class="form-control">
                                    </div>
                                </div>
                                <div v-if="filteredListUtilisateur.length>0" class="col-md-12">
                                    <div style="overflow-x:auto;" id="packs" class="tab-pane fade in active show">
                                        <table id="data-packs" class="datatables table table-striped table-bordered table-hover">
                                            <thead class="thead-dark">
                                                <tr>
                                                    <th v-if="$can('Autoriser les accès aux utilisateurs')"></th>
                                                    <th>{{$t('content.pages.utilisateurs.tableau.cin')}}</th>
                                                    <th>{{$t('content.pages.utilisateurs.tableau.nom')}}</th>
                                                    <th>{{$t('content.pages.utilisateurs.tableau.email')}}</th>
                                                    <th>{{$t('content.pages.utilisateurs.tableau.tele')}}</th>
                                                    <th>{{$t('content.pages.utilisateurs.tableau.genre')}}</th>
                                                    <!--<th>{{$t('content.pages.utilisateurs.tableau.parrain')}}</th>-->
                                                    <th>{{$t('content.pages.utilisateurs.tableau.statut')}}</th>
                                                    <th v-if="$can('Supprimer un utilisateur') || $can('Modifier un utilisateur') || $can('Modifier les mots de passe des utilisateurs')"  >{{$t('content.pages.utilisateurs.tableau.action')}}</th>
                                                </tr>
                                            </thead>
                                            <tbody v-for="(utilisateur, indexU) in filteredListUtilisateur">
                                                <tr class="header-level">
                                                    <td style="cursor : pointer;" v-if="$can('Autoriser les accès aux utilisateurs')" @click="ShowRoles(utilisateur.id)" :class="'hide-'+utilisateur.id" class="">
                                                        <i style="font-size: 24px !important;" class="mdi hide"></i>
                                                    </td>
                                                    <td> {{ utilisateur.cin }} </td>
                                                     <td>
                                                        <router-link v-if="$can('Consulter le profil d\'un utilisateur')" :to="{name: 'profile-utilisateur', params :{email: utilisateur.email }}">
                                                            {{ utilisateur.name }}
                                                        </router-link>
                                                        <span v-else >{{ utilisateur.name }}</span>
                                                    </td>

                                                    <td>
                                                        <span  >{{ utilisateur.email }}</span>
                                                    </td>
                                                    <td> {{ utilisateur.tele }} </td>
                                                    <td> 

                                                        <span v-if="utilisateur.gender == 'Homme'">{{$t('content.text.homme_H')}}</span>
                                                        <span v-else>{{$t('content.text.femme_F')}}</span>
                                                    </td>
                                                    <!--<td>{{ utilisateur.parent.name }}</td>-->
                                                    <td>
                                                        <label v-if="utilisateur.is_valide == 1" class="badge badge-success">{{$t('content.pages.utilisateurs.recherche.statut.valid')}}</label>
                                                        <label v-else class="badge badge-danger">{{$t('content.pages.utilisateurs.recherche.statut.bloque')}}</label>
                                                    </td>
                                                    <td v-if="$can('Supprimer un utilisateur') || $can('Modifier un utilisateur') || $can('Modifier les mots de passe des utilisateurs')">
                                                        <span title="Modifier" v-if="$can('Modifier un utilisateur')" data-toggle="modal" data-target=".bd-example-modal-lg" @click="Edit(utilisateur, indexU)" class="mdi-edit-btn"> <i class="mdi mdi-pen"></i> </span>
                                                        <span title="Supprimer" v-if="$can('Supprimer un utilisateur')" @click="Delete(utilisateur.id, indexU)" class="mdi-delete-btn"> <i class="mdi mdi-delete-forever"></i> </span>

                                                         <span title="Modifier le mot de passe" v-if="$can('Modifier les mots de passe des utilisateurs')" data-toggle="modal" data-target=".change-password" @click="EditPassword(utilisateur)" class="mdi-edit-btn"> <i class="mdi mdi-key"></i> </span>


                                                    </td>
                                                </tr>
                                                <tr v-if="$can('Autoriser les accès aux utilisateurs')" :class="'sub-level-' + utilisateur.id" class='sub-level' colspan="9">
                                                    <td colspan="9">
                                                        <table style="width : 100%;">
                                                            <thead>
                                                                <tr>
                                                                    <th><b>{{$t('content.pages.utilisateurs.tableau.sous_tableau.role')}}</b></th>
                                                                    <th><b>{{$t('content.pages.utilisateurs.tableau.sous_tableau.action')}}</b></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td>Tous les accès </td>
                                                                    <td>
                                                                        <div class="btn-group" role="group" aria-label="Second group">
                                                                            <button @click="EventRole('revoke', utilisateur.id, 'all', indexU)" type="button" class="btn btn-lights">{{ $t('content.bouton.desactive') }}</button>
                                                                            <button @click="EventRole('give', utilisateur.id, 'all', indexU)" type="button" class="btn btn-lights">{{ $t('content.bouton.active') }}</button>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <tr v-for="(permission, indexP ) in ListPermissions">
                                                                    <td>{{ permission.name }}</td>
                                                                    <td>
                                                                        <div class="btn-group" role="group" aria-label="Second group">
                                                                            <button @click="EventRole('revoke', utilisateur.id, permission.name, indexU)" :class="{ 'btn-off': (utilisateur.user_permissions.indexOf(permission.name) === -1) }" type="button" class="btn btn-lights">
                                                                                {{ $t('content.bouton.desactive') }}
                                                                            </button>
                                                                            <button @click="EventRole('give', utilisateur.id, permission.name, indexU)" :class="{ 'btn-on': (utilisateur.user_permissions.indexOf(permission.name) !== -1) }" type="button" class="btn btn-lights">
                                                                                {{ $t('content.bouton.active') }}
                                                                            </button>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <vue-pagination :pagination="pagination" @paginate="ListUtlisateurs(data_filtrer)" :offset="4"></vue-pagination>
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
        <div v-else class="content-wrapper">
            <havent-permission></havent-permission>
        </div>
    </div>
</template>
<script>
//import {en, fr, ar} from 'vuejs-datepicker/dist/locale'
import 'vue2-datepicker/index.css';
export default {
    data() {
        return {
            lang: {
                formatLocale: {
                    firstDayOfWeek: 1,
                },
                monthBeforeYear: false,
            },
            datetimePicker:  [null, null],
            showTimeRangePanel: false, 

            state: {
                disabledDates: {
                    to: new Date(2020, 0, 5), // Disable all dates up to specific date
                    from: new Date(), // Disable all dates after specific date
                    days: [6, 0], // Disable Saturday's and Sunday's
                }
            },
            data_filtrer: {
                is_valide: 'tous',
                datetimes: [],
            },
            utilisateurs: [],
            pagination: [],
            search_utilisateur: '',
            formData: {},

            ListPermissions: [],
            count_utilisateurs : 0



        }
    },
    mounted() {
        console.log('Component mounted.')
    },
    methods: {
        ListUtlisateurs(data_filtrer) {
            if (typeof this.$refs.formContainer !== "undefined")
                this.PluginLoader(false, this.$refs.formContainer)
            const current_page = (this.pagination.current_page) ? this.pagination.current_page : 1;
            this.formData = new FormData();
            if (this.data_filtrer.is_valide != 'tous')
                this.formData.append("filtrer[is_valide]", this.data_filtrer.is_valide);

            if (this.datetimePicker[0] != null && this.datetimePicker[1])
                this.formData.append("filtrer[date]", this.data_filtrer.datetimes);

            const config = { headers: { 'content-type': 'multipart/form-data' } }
            axios.post('/api-admin/utilisateurs?page=' + current_page, this.formData, config).then((response) => {
                this.utilisateurs = response.data.data;
                this.pagination = response.data;
                this.count_utilisateurs = response.data.total
                console.log(this.pagination)
            });
        },
        RefreshListUtlisateurs(newUtilisateurs) {
            if (newUtilisateurs != null) {
                this.utilisateurs.unshift(newUtilisateurs)
            }
        },
        filtrer(event) {
            if (this.datetimePicker[0] != null && this.datetimePicker[1]) {
                const date = this.datetimePicker;
                this.data_filtrer.datetimes = [date[0] , date[1] ]
            }
            this.pagination = []
            this.ListUtlisateurs(this.data_filtrer)
        },
        handleRangeClose() {
            this.showTimeRangePanel = false;
        },
        ShowRoles(id) {
            $('.sub-level-' + id).toggleClass('sub-level');
            $('.hide-' + id).find('.mdi').toggleClass('hide')
            $('.hide-' + id).find('.mdi').toggleClass('open')
        },
        EventRole(event, user_id, permission_name, index) {
            this.formData = new FormData();
            if (user_id != null)
                this.formData.append("user_id", user_id);

            if (permission_name != null)
                this.formData.append("permission_name", permission_name);

            if (event != null)
                this.formData.append("event", event);
            const config = { headers: { 'content-type': 'multipart/form-data' } }
            axios.post('/api-admin/utilisateur/affect-permission', this.formData, config).then((response) => {
                this.utilisateurs[index].user_permissions = response.data.user_permissions
            });
        },
        Edit(utilisateur, index) {
            this.eventUtilisateurs.$emit('edit', { "utilisateur": utilisateur, "index": index })
        },
        ClearInputs() {
            this.eventUtilisateurs.$emit('clear')
        },

        Delete(id_utilisateur, index) {
            this.$fire(
                this.AlertFire('delete')
            ).then((result) => {
                if (result.value) {
                    this.submitStatus = 'PENDING'
                    this.formData = new FormData();
                    this.formData.append('id_utilisateur', id_utilisateur);
                    const config = { headers: { 'content-type': 'multipart/form-data' } }
                    axios.post('/api-admin/utilisateurs/destroy', this.formData, config).then(res => {
                            switch (res.data) {
                                case false:
                                    this.AlertResponseFalse("utilisateur", "utilisateur n'existe pas", "warning")
                                    break;
                                default:
                                    this.AlertResponseTrue("", "La suppression est effectué avec succès", "success");
                                    this.utilisateurs.splice(index, 1)
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
        },
        EditPassword(utilisateur) {
            this.eventUtilisateurs.$emit('change-password', { "utilisateur": utilisateur })
        },
        clearDataInputs() {
            this.datetimePicker = [null, null]
            this.data_filtrer.is_valide = "tous"
        }

    },
    beforeMount() {
        if (this.$can('Consulter la liste des utilisateurs')) {
            this.filtrer();
            console.log(window.userPermissions)
            console.log(window.Role)

            console.log("List Permissions")
            this.ListPermissions = window.ListPermissions
            console.log(this.ListPermissions)
        }


    },
    created: function() {
        this.eventUtilisateurs.$on('update', data => {
            if (data != null) {
                console.log(data.utilisateur)
                Vue.set(this.utilisateurs, data.index, data.utilisateur)
            }
        })
    },
    computed: {
        filteredListUtilisateur() {
            return this.utilisateurs.filter(utilisateur => {
                return utilisateur.email.toString().toLowerCase().includes(this.search_utilisateur.toLowerCase()) ||
                    utilisateur.name.toString().toLowerCase().includes(this.search_utilisateur.toLowerCase())
                     ||
                    utilisateur.tele.toString().toLowerCase().includes(this.search_utilisateur.toLowerCase())
                     ||
                    utilisateur.cin.toString().toLowerCase().includes(this.search_utilisateur.toLowerCase());
            })
        },
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

.number {
    width: 33.333333% !important;
    display: inline-block;
    margin-bottom: 15px;
}

.resActive {
    background-color: #00b000;
    color: #fff;
}


.line {
    margin-bottom: 5px;

    text-align: center;
    counter-increment: line;
    position: relative;
    padding-left: 40px;
    padding-right: 40px;
}

.line div {
    border: 1px solid #ccc;

}

.line div:before {

    content: counter(line);
    position: absolute;
    left: 6px;
    top: 0px;
    background: #000;
    color: #fff;
    width: 35px;
    height: 51px;
    display: flex;
    justify-content: center;
    align-items: center;

}

.line button {
    border-radius: 50%;
    width: 40px;
    height: 40px;
    margin: 4px;
    border: none;
    outline: none;
}


.btn-off {
    background-color: red;
}


.btn-on {
    background-color: green;
}



.sub-level {
    display: none;
}


.open:before {
    content: "\F140";
}

.hide:before {
    content: "\F142";
}



.mdi-edit-btn {
    background: #f2ba4f !important;
    border-radius: 3px;
    padding: 3px 7px;
    color: #fff;
    cursor: pointer;
    font-size: 16px;
}

.mdi-delete-btn {
    background: #ff5656;
    border-radius: 3px;
    padding: 3px 7px;
    color: #fff;
    cursor: pointer;
    font-size: 16px;
}

.mdi-block-btn {

    background: #ff5656;
    border-radius: 3px;
    padding: 3px 7px;
    color: #fff;
    cursor: pointer;
    font-size: 16px;
}

</style>
