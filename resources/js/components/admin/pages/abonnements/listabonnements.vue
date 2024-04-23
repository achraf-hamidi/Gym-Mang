<template>
    <div class="col-md-8 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">{{ $t('content.pages.activities.activitie.titre') }}</h4>
           <div id="abonnements" class="">
              <br><br>
                <div class="form-group mr-b-0em"><label class="form__label">Recherche</label> <input v-model="search_abonnement" placeholder="Price..." class="form-control"></div>
                <table id="data-abonnements" class="datatables table table-striped table-bordered table-hover">
                  <thead class="thead-dark">
                    <tr>
                      <th>{{ $t('content.pages.activities.activitie.table.image') }}</th>
                      <th>{{ $t('content.pages.activities.activitie.table.libelle') }}</th>
                      <th>{{ $t('content.pages.activities.activitie.table.status') }}</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr  v-for="(abonnement, index) in filteredListAbonnements">
                       <td>{{ abonnement.libelle }}</td>
                       <td>{{ abonnement.nb_mois }}</td>
                      <td>
                          <button @click="GetListAbonnerByAbonnement(abonnement)" class="">Get</button>
                      </td>
                    </tr>
                  </tbody>
                </table>
            </div>
        </div>
      </div>
    </div>
</template>

<script>

    export default {
       props : ["abonnements"],
        data() {
            return {
                  search_pack :'',
                search_abonnement :'',
             }
        },
        mounted() {
            console.log('Component mounted.')
        },
        methods : {
            GetListAbonnerByAbonnement(abonnement) {
              console.log('from list ' + abonnement.id)
              this.eventFilterListAbonners.$emit('update', abonnement )
            }
           
      },
        created: function () {
          this.eventAbonnement.$on('update', data => {
              if (data != null ) {
                this.abonnements.unshift(data)
              }
           })
        },
        beforeMount(){ 
            
         },
        computed: {
            filteredListAbonnements() {
              return this.abonnements.filter(abonnement => {
                return abonnement.libelle.toLowerCase().includes(this.search_abonnement.toLowerCase()) || abonnement.nb_mois.toString().toLowerCase().includes(this.search_abonnement.toString().toLowerCase())
              })
            }
        }, 

    }
</script> 

<style>

.nav.nav-tabs li {
    margin-left : 8px;
    position : relative;
    margin-bottom : 15px;
}
.nav.nav-tabs li a {
    text-decoration : none;
}


.nav.nav-tabs li a.active:after { 
content: '';
width: 100%;
position: absolute;
height: 2px;
background: #000;
}

</style>