<template>
    <div class="main-panel">
        <div  class="content-wrapper">
            <div class="row">
                <div class="col-md-12">
                    <div id="containers">
                        <aside class="aside">
                            <header>
                                <input type="text" v-model="search_utilisateur" placeholder="search">
                            </header>
                            <ul>
                                <li :class="[user.id == to_user.id ? 'active' : '' ]" v-for="user in filteredListUtilisateur" @click="fetchMessages(user)">
                                    <img :src="`/clubi/public/admin/utilisateurs/photos/${user.image}`" alt="">
                                    <div>
                                        <span>{{user.name}} </span>
                                        <span v-if="user.messages_count > 0" class=" messages_count text-right"> {{user.messages_count}} </span>
                                    </div>
                                </li>
                            </ul>
                        </aside>
                        <main>
                            <header style="display: flex;justify-content: flex-start;align-items: center;">
                                <img style="width :45px; " :src="`/clubi/public/admin/utilisateurs/photos/${to_user.image}`" alt="">
                                <div>
                                    <h2 class="mb-0">{{to_user.name}}</h2>
                                    <p class="mb-0"> {{ to_user.email }} </p>
                                </div>
                            </header>
                            <ul ref="formChat" id="chat">
                                <li>
                                    <infinite-loading spinner="waveDots" direction="top" @infinite="infiniteHandler" ref='InfiniteLoading'>
                                        <span slot="no-more"></span>
                                    </infinite-loading>
                                    <!--@distance="1" -->
                                </li>
                                <li v-for="(item,  index) in messages" :class="[item.users[0].pivot.user_id == auth.id  ? 'me' : 'you']" :key='index'>
                                    <div class="entete">
                                        <small class="text-muted ml-auto">{{item.created_at | formatDate }}</small>
                                    </div>
                                    <div class="message">
                                        {{ item.message }}<br>
                                    </div>
                                </li>
                            </ul>
                            <footer>
                                <div class="col-12">
                                    <div class="form-group mr-b-0em">
                                        <textarea v-model="text_message" placeholder="Message..." class="form-control" @keyup.enter.exact="sendMessage"></textarea>
                                    </div>
                                    <!---->
                                </div>
                            </footer>
                        </main>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-6"><br><br>
                    <div class="form-group mr-b-0em">
                        <label class="form__label">Consomation electrice en Kw</label>
                        <input class="form-control" v-model.trim="consomation_electrice_kw" />
                    </div>
                </div>
                <div class="col-6"><br><br>
                    <div class="form-group mr-b-0em">
                        <label class="form__label">Consomation eau en m3</label>
                        <input class="form-control" v-model.trim="consomation_eau_m3" />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-4">
                    <div class="form-group mr-b-0em">
                        <label class="form__label">Prix de Timbre pour electrice</label>
                        <input class="form-control" v-model.trim="timber_electrice" />
                    </div>
                </div>
                <div class="col-4">
                    <div class="form-group mr-b-0em">
                        <label class="form__label">Prix de Timbre pour Eau</label>
                        <input class="form-control" v-model.trim="timber_eau" />
                    </div>
                </div>
                <div class="col-4">
                    <div class="form-group mr-b-0em">
                        <label class="form__label">Divisé par</label>
                        <input class="form-control" v-model.trim="division" />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <button @click="consommation" >Calcule</button>
                </div>
            </div>
            <div class="row">
                <div class="col-12" v-for="(item, index) in array">
                    <br> 
                    <span><b>Electricite : </b></span>
                    <div v-for="(Tranche_electricite , indexTranche) in item[1].Tranche_electricite">
                        <span>Tranche {{ indexTranche +1 }} : </span> {{ Tranche_electricite.toFixed(2) }} Dh
                    </div>
                    <span>
                       Timber elec : {{ parseFloat((19.510 / division) + timber_electrice).toFixed(2) }}
                    </span><br>
                    <span><b>Total electricite : </b> {{ parseFloat(item[0].total_electricite).toFixed(2) }} Dh </span><br>
                    <span><b>Eau : </b></span>
                    <div v-for="(Tranche_eau , indexTranche) in item[3].Tranche_eau">
                        <span>Tranche {{ indexTranche +1 }} : </span> {{ parseFloat(Tranche_eau).toFixed(2) }} Dh
                    </div>
                    <span><b>Assainissement : </b></span>
                    <div v-for="(Tranche_assainissement , indexTranche) in item[4].Tranche_assainissement">
                        <span>Tranche {{ indexTranche +1 }} : </span> {{ parseFloat(Tranche_assainissement).toFixed(2) }} Dh
                    </div>
                    <span>
                         timber :  {{ parseFloat((9.98 / division) + timber_eau).toFixed(2)}}
                    </span><br>
                    <span><b>Total eau + Assainissement: </b> {{parseFloat(item[2].total_eau).toFixed(2) }} Dh </span><br>
                    <p> <b>Montant Total est : </b> {{ parseFloat(item[2].total_eau + parseFloat(item[0].total_electricite) ).toFixed(2) }} Dh</p>
                </div>
            </div>
        </div>
        
    </div>
</template>
<script>
export default {
    data() {
        return {
            auth: [],
            utilisateurs: [],
            messages: [],
            search_utilisateur: '',
            formData: {},
            text_message: '',
            to_user: [],
            count: 0,

            consomation_electrice_kw: 0,
            consomation_eau_m3: 0 ,
            timber_electrice: 0.20 ,
            timber_eau: 0.20,
            division : 0 ,
            array: [],
            electricite: [],
            eau: [],
            assainissement: []
        }
    },
    mounted() {
        ////console.log('Component mounted.')
    },
    beforeMount() {
        this.FetchUtilisateurs() 
    },
    computed: {
        filteredListUtilisateur() {
            return this.utilisateurs.filter(utilisateur => {
                return utilisateur.email.toString().toLowerCase().includes(this.search_utilisateur.toLowerCase()) ||
                    utilisateur.name.toString().toLowerCase().includes(this.search_utilisateur.toLowerCase());
            })
        },
    },
    methods: {
        FetchUtilisateurs() {
            if (typeof this.$refs.formContainer !== "undefined")
                this.PluginLoader(false, this.$refs.formContainer)
            const config = { headers: { 'content-type': 'multipart/form-data' } }
            axios.get('/api-admin/messagerie/fetch-utilisateurs', config).then((response) => {
                this.utilisateurs = response.data.utilisateurs;
                this.auth = response.data.auth
                this.to_user = this.utilisateurs[0]
            });
        },
        sendMessage() {
            this.formData = new FormData();
            //this.formData.append('user_id', this.auth.id);
            this.formData.append('to_user_id', this.to_user.id);
            this.formData.append('message', this.text_message);
            const config = { headers: { 'content-type': 'multipart/form-data' } }
            axios.post('/api-admin/utilisateur/store-message', this.formData, config).then((response) => {
                this.messages.push(response.data.message)
                this.text_message = ''
                var messageDisplay = this.$refs.formChat;
                messageDisplay.scrollTop = messageDisplay.scrollHeight;
            });
        },
        fetchMessages(to_user) {
            if (to_user.id != this.to_user.id) {
                this.to_user = []
                this.to_user = to_user
                this.messages = []
                this.count = 0
                this.$refs.InfiniteLoading.stateChanger.reset();
            }
        },

        infiniteHandler($state) {
            let limit = (this.messages) ? this.messages.length + 20 : 10;
            let offset = (!this.messages.length) ? 0 : 0; //this.messages.length  ;
            this.formData = new FormData();
            this.formData.append('to_user_id', this.to_user.id);
            this.formData.append('limit', limit);
            this.formData.append('offset', offset);
            const config = { headers: { 'content-type': 'multipart/form-data' } }
            axios.post('/api-admin/utilisateur/fetch-message', this.formData, config).then(({ data }) => {
                if (data.messages.length > this.count) {
                    if (data.messages.length) {
                        this.count = data.messages.length
                        this.messages = data.messages.reverse() // .unshift(data.reverse());
                        $state.loaded();
                        this.countUnreadMessages.$emit('edit', { "count": this.to_user.messages_count })
                        this.to_user.messages_count = 0;
                    } else {
                        $state.complete();
                    }
                } else
                    $state.complete();
            });
        },
        consommation(  ) {

            let kw = this.consomation_electrice_kw
            let m3 = this.consomation_eau_m3  
            this.electricite = []
            this.eau = []
            this.assainissement = []
           
            let index_kw = 0
            if (kw > 0) { // 1ere tranche 
                this.electricite[index_kw] = (kw <= 100) ? kw * 0.9010 : 100 * 0.9010
                kw = kw - 100;
                index_kw++
            }
            if (kw > 0) { // 2eme tranche  
                this.electricite[index_kw] = (kw <= 150) ? (kw * 1.073) : (150 * 1.073)
                kw = kw - 150;
                index_kw++
            }
            if (kw > 0) { // 3eme tranche
                this.electricite[index_kw] = (kw <= 200) ? (kw * 1.0541) : (200 * 1.0541)
                kw = kw - 200;
                index_kw++
            }
            if (kw > 0) { // 4eme tranche
                this.electricite[index_kw] = (kw <= 300) ? (kw * 1.4407) : (300 * 1.4407)
                kw = kw - 300;
                index_kw++
            }
            if (kw > 0) { // 5eme tranche
                this.electricite[index_kw] = (kw <= 500) ? (kw * 0.9689) : (500 * 0.9689)
                kw = kw - 500;
                index_kw++
            }
            if (kw > 0) { // 6eme tranche
                this.electricite[index_kw] = (kw * 0.9689)
            }
            let total = 0
            this.electricite.forEach((elect) => {
                total += elect
            });

            let index_m3 = 0
            //var assainissement = 0
            // var eau = 0
            if (m3 > 0) { // 1ere tranche 
                this.eau[index_m3] = (m3 <= 6) ? m3 * 3.306 : 6 * 3.306
                this.assainissement[index_m3] = (m3 <= 6) ? m3 * 0.589 : 6 * 0.589
                m3 = m3 - 6;
                index_m3++
            }
            if (m3 > 0) { // 2eme tranche   
                this.eau[index_m3] = (m3 <= 12) ? (m3 * 8.325) : (12 * 8.325)
                this.assainissement[index_m3] = (m3 <= 20) ? (m3 * 1.530) : (20 * 1.530)
                m3 = m3 - 12;
                index_m3++
            }
            if (m3 > 0) { // 3eme tranche
                this.eau[index_m3] = (m3 <= 20) ? (m3 * 1.0541) : (20 * 1.0541)
                this.assainissement[index_m3] = (m3 * 1.530)
                m3 = m3 - 20;
                index_m3++
            }
            if (m3 > 0) { // 4eme tranche
                this.eau[index_m3] = (m3 <= 35) ? (m3 * 1.4407) : (35 * 1.4407)
                this.assainissement[index_m3] = (m3 * 1.530)
                m3 = m3 - 35;
                index_m3++
            }
            if (m3 > 0) { // 5eme tranche
                this.eau[index_m3] = (m3 * 0.9689)
                this.assainissement[index_m3] = (m3 * 1.530)
                index_m3++
            }

            let total_ea = 0
            this.eau.forEach((eau) => {
                total_ea += eau
            });

            let total_ass = 0
            this.assainissement.forEach((assainissement) => {
                total_ass += assainissement
            });

            let total_ass_eau = total_ea + total_ass + (9.98 / this.division) + this.timber_eau;
            let total_electricite = total + (19.510 / this.division) + this.timber_electrice
            this.array.push([
                { "total_electricite": total_electricite },
                { "Tranche_electricite": this.electricite },
                { "total_eau": total_ass_eau },
                { 'Tranche_eau': this.eau },
                { 'Tranche_assainissement': this.assainissement }
            ])

        }
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



/*****/


* {
    box-sizing: border-box;
}

body {
    background-color: #abd9e9;
    font-family: Montserrat;
}

#containers {
    width: 100%;
    height: 800px;
    background: #fff;
    margin: 0 auto;
    font-size: 0;
    border-radius: 5px;
    overflow: hidden;
}

.aside {
    width: 30%;
    height: 800px;
    background-color: #3b3e49;
    display: inline-block;
    font-size: 15px;
    vertical-align: top;
}

main {
    width: 70%;
    height: 800px;
    display: inline-block;
    font-size: 15px;
    vertical-align: top;
}

.aside header {
    padding: 10px;
    margin-bottom: 20px;
}

.aside input {
    width: 100%;
    height: 50px;
    line-height: 50px;
    padding: 0 50px 0 20px;
    background-color: #5e616a;
    border: none;
    border-radius: 3px;
    color: #fff;
    background-image: url(https://s3-us-west-2.amazonaws.com/s.cdpn.io/1940306/ico_search.png);
    background-repeat: no-repeat;
    background-position: right;
    background-size: 40px;
}

.aside input::placeholder {
    color: #fff;
}

.aside ul {
    padding-left: 0;
    margin: 0;
    list-style-type: none;
    overflow-y: scroll;
    height: 690px;
}

.aside li {
    padding: 5px 0;
    display: flex;
    justify-content: flex-start;
    align-items: center;
    position: relative;
}

.aside li:hover,
.aside li.active {
    background-color: #5e616a;
}

.aside li img {
    border-radius: 18%;
    margin-left: 25px;
    margin-right: 15px;
    width: 35px;
}

.aside li div {
    display: inline-block;
    vertical-align: top;
    color: #fff;
}

.aside li span {
    font-size: 14px;
    color: #fff;
    font-weight: normal;
    margin-bottom: 5px;
}

.aside li h3 {
    font-size: 12px;
    color: #7e818a;
    font-weight: normal;
}

.status {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    display: inline-block;
    margin-right: 7px;
}

.green {
    background-color: #58b666;
}

.orange {
    background-color: #ff725d;
}

.blue {
    background-color: #6fbced;
    margin-right: 0;
    margin-left: 7px;
}

#containers main header {
    height: 70px;
    padding: 15px;
}

main header>* {
    display: inline-block;
    vertical-align: top;
}

main header img:first-child {
    border-radius: 50%;
}

main header img:last-child {
    width: 24px;
    margin-top: 8px;
}

main header div {
    margin-left: 10px;
    margin-right: 145px;
}

main header h2 {
    font-size: 16px;
    margin-bottom: 5px;
}

main header h3 {
    font-size: 14px;
    font-weight: normal;
    color: #7e818a;
}

#chat {
    padding-left: 0;
    margin: 0;
    list-style-type: none;
    overflow-y: scroll;
    height: 612px;
    border-top: 2px solid #eff3f7;
    border-bottom: 2px solid #eff3f7;
}

#chat li {
    padding: 20px 20px 0px 20px;
}

#chat h2,
#chat h3 {
    display: inline-block;
    font-size: 13px;
    font-weight: normal;
}

#chat h3 {
    color: #bbb;
}

#chat .entete {
    margin-bottom: 5px;
}

#chat .message {
    padding: 10px;
    color: #fff;
    line-height: 22px;
    max-width: 90%;
    display: inline-block;
    text-align: left;
    border-radius: 5px;
}

#chat .me {
    text-align: right;
}

#chat .you .message {
    position: relative;
    background-color: #58b666;
}

#chat .me .message {
    position: relative;
    background-color: #6fbced;
}

#chat .you .message:before {
    content: '';
    border-color: transparent transparent #58b666 transparent;
    position: absolute;
    left: 8px;
    border-style: solid;
    border-width: 0 10px 10px 10px;
    top: -8px;
}

#chat .me .message:before {
    content: '';
    border-color: transparent transparent #6fbced transparent;
    position: absolute;
    right: 8px;
    border-style: solid;
    border-width: 0 10px 10px 10px;
    top: -8px;
}

main footer {
    height: 155px;
    padding: 15px;
}

main footer textarea {
    resize: none;
    border: none;
    display: block;
    width: 100%;
    height: 80px;
    border-radius: 3px;
    padding: 20px;
    font-size: 13px;
    margin-bottom: 13px;
}

main footer textarea::placeholder {
    color: #ddd;
}

main footer img {
    height: 30px;
    cursor: pointer;
}

main footer a {
    text-decoration: none;
    text-transform: uppercase;
    font-weight: bold;
    color: #6fbced;
    vertical-align: top;
    margin-left: 333px;
    margin-top: 5px;
    display: inline-block;
}


.messages_count {
    border-radius: 50%;
    background: #3490dc;
    width: 20px !important;
    height: 20px !important;
    position: absolute;
    right: 16px;
    top: 16px;
    font-size: 12px !important;
    display: flex;
    justify-content: center;
    align-items: center;
    font-weight: bold;
}

</style>
