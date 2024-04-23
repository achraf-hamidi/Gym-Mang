<template>
    <div class="main-panel">
          <div class="content-wrapper">
            <div class="row">
              <list-abonnements  :abonnements="abonnements"   ></list-abonnements>  
              <add-abonnement   ></add-abonnement>
            </div>
            <div class="row">
                <div class="col-lg-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                          <h4 class="card-title"> </h4> 
                          <div class=""> 
                            <div id="abonnements" class="">
                              <br><br>
                                <div class="form-group mr-b-0em"><label class="form__label">Recherche</label> <input v-model="search_abonnement" placeholder="Price..." class="form-control"></div>

                                <table id="data-abonnements" class="datatables table table-striped table-bordered table-hover">
                                  <thead class="thead-dark">
                                    <tr>
                                      <th>{{ $t('content.pages.activities.activitie.table.image') }}</th>
                                      <th>{{ $t('content.pages.activities.activitie.table.image') }}</th>
                                      <th>{{ $t('content.pages.activities.activitie.table.libelle') }}</th>
                                      <th>{{ $t('content.pages.activities.activitie.table.status') }}</th>
                                      <th>{{ $t('content.pages.activities.activitie.table.status') }}</th>
                                    </tr>
                                  </thead>
                                  <tbody v-for="(abonnement, index) in filteredListAbonners">
                                    <tr v-for="(abonner, index) in abonnement.abonners">
                                       <td>{{ abonner.adherent.nom }}</td>
                                       <td>{{ abonner.date_debut }}</td>
                                       <td>{{ abonner.date_fin }}</td>
                                       <td>{{ abonnement.libelle }}</td>
                                        <td>
                                          <label class="">{{ $t('content.bouton.modifier') }}</label>
                                        </td>
                                    </tr>
                                  </tbody>
                                </table>
                            </div>
                          </div>
                        </div>

                        </div>
                    </div>
                </div>  
                <!--<div class="col-lg-12 grid-margin stretch-card">    
                  <picture-input 
                    ref="pictureInput" 
                    @change="onChange" 
                    width="600" 
                    height="600" 
                    margin="16" 
                    accept="image/jpeg,image/png" 
                    size="10" 
                    buttonClass="btn"
                    :customStrings="{
                      upload: '<h1>Bummer!</h1>',
                      drag: 'Drag a 😺 GIF or GTFO'
                    }">
                  </picture-input>
                </div>  -->
                <div class="col-lg-12 grid-margin stretch-card"> 
                  <div><button id="snap" v-on:click="capture()">Take photo</button></div><br>
                    <div><video ref="video" id="video" width="360" height="280" autoplay></video></div><br>
                    <canvas ref="canvas" id="canvas" width="360" height="280"></canvas>
                    
                </div>   
                <div class="col-lg-12 grid-margin stretch-card"> 
                        <img v-bind:src="captures" style="width : auto; height : auto;" />
                </div>             
            </div>
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
              video: {},
                canvas: {},
                captures: [],

                abonnements : [],
                 search_pack :'',
                search_abonnement :'',
             }
        },
        mounted() {
           this.video = this.$refs.video;
           if(navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
              navigator.mediaDevices.getUserMedia({ video: true }).then(function(stream) {
                  video.srcObject = stream;
                  video.play();
              });
          }
        },
        methods : {
          capture() {
              this.canvas = this.$refs.canvas;
              var context = this.canvas.getContext("2d").drawImage(this.video, 0, 0, 360, 280);
              this.captures = canvas.toDataURL("image/png");
           },

             ListAbonnements(){
                axios.get('/api-admin/abonnements').then((response)=>{  
                    this.abonnements = response.data;
                    //console.log(this.abonnements)
                });
            }  ,
            onChange (image) {
      //console.log('New picture selected!')
      if (image) {
        //console.log('Picture loaded.')
        this.image = image
      } else {
        //console.log('FileReader API not supported: use the <form>, Luke!')
      }
    }
            
    },
    beforeMount(){ 
        this.ListAbonnements();
    },

    created: function () {
          this.eventFilterListAbonners.$on('update', data => {
              this.filteredListAbonners.filter(abonnement => { 
                   return  abonnement.abonners.find(abonner => {
                      return abonner.pivot.abonnement_id == data.id
                  })
              })
              
           })
        },

      computed: {
            filteredListAbonners() {
              return this.abonnements.filter(abonnement => {
                return abonnement.libelle.toLowerCase().includes(this.search_abonnement.toLowerCase()) ||
                  abonnement.abonners.find(abonner => {
                    return abonner.adherent.nom.toLowerCase().includes(this.search_abonnement.toLowerCase())
                })
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
 #video {
        background-color: #000000;
    }
    #canvas {
        display: none;
    }

</style>