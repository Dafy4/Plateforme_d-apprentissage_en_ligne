<template>
    <transition name="chargement">
        <div v-if="chargement" class="sidenav1" key="active"> <!-- v-if -->
            <div class="loader centre"></div>
        </div>
    </transition>

    <section style="height: 100vh;text-align: center;">
        <div style="width: 20vw;width: 20vw;display: flex;flex-direction: column;justify-content: space-between;">
            <div>
            <p style="color: white;" @click="examen">chapitre</p><br>
            
            <div class="chapitree" v-for="chp,i in chapitres" :key="chp"
                :class="chapitre===chp ? 'chp':''"
                >
                <div v-if="chapitre===chp" class="radius haut"><div></div></div>
                <h3
                    :style="chapitre===chp? 'color:#000047':'color: white;'"
                    @click="selectionChapitre(chp,i);"
                >{{chp.nom}}</h3>
                <div v-if="chapitre===chp " class="radius bas"><div></div></div>
            </div>
            </div>
            <div v-if="exam" @click="examen" class="ff">Examen</div>
        </div>
        <div class="contenue" style="width: 100%;">
            <div v-if="numchapitre!==null">
                <table v-if="numchapitre.partie[numPartie].cours!==undefined">
                  <tr v-for="contenue,i in numchapitre.partie[numPartie].cours" :key="contenue" class="contenuee">
                    <th style="width: 95%;">
                        <div @dblclick="commentaires(i)">
                            <p v-if="contenue.type==='paragraphe'">{{ contenue.text }}</p>
                            <h1 v-if="contenue.type==='titre'">{{ contenue.text }}</h1>
                            <p v-if="contenue.type==='input'">{{ contenue.text }}</p>
                            <div v-if="contenue.type==='image'">
                                <img :src="contenue.text" alt=":)">
                            </div>
                            <input v-if="contenue.type==='input'" type="text"><button v-if="contenue.type=='input'">Envoyer</button>
                        </div>
                    </th>
                    <th style="width: 50px;">
                        <div v-if="contenue.nb>0" class="notification">{{ contenue.nb }}</div>
                        <i @click="commentaires(i)" class="fa fa-comment-o icon" style="font-size:24px"></i>
                    </th>
                  </tr>
                </table>
                <div v-else class="cadenas">
                    <img src="/css/assets/cadenas.png" alt="gg">
                </div>
            </div>
            
            <div class="page" v-if="numchapitre!==null">
                <div class="pagination">
                    <a @click="partie--;this.i2--;" v-show="partie>0">&laquo;</a>
                    <a
                        :class="partie==i-1?'active':''"
                        @click="selectionPartie(i)"
                        v-for="i in numchapitre.partie.length" :key="i"
                    >{{i}}</a>
                    <a @click="clickSuivant" v-if="numchapitre.partie.length>partie+1">&raquo;</a>
                </div>
            </div>
        </div>
    </section>
    <transition name="affiche">
        <div class="sidenav1" v-if="active" key="active">
        <div v-if="chargement" class="loader centre"></div>
            <div class="sidenav"><p style="font-size: 25px;" @click="commentaires">&times;</p>
                <div style="overflow-y: scroll;height: 80vh;" >
                    <div>
                        <div v-for="coms,i in commentaire">
                            <div :class="coms.user.id==uuser ? 'float':''">
                                <h4>{{ coms.nom_utilisateur }}</h4>
                                <p :class="coms.user.id==uuser ? 'border':''">{{ commmentairePhrase(coms.comentaires) }}</p>
                            </div>
                        </div>
                    <div id="coms" ref="coms" style="height: 70px;"></div>
                    </div>
                </div>
                <div class="send">
                    <textarea name="" id="" cols="50" rows="3" v-model="coms"></textarea>
                    <a href="#coms"><div @click="envoyer">icon</div></a>
                </div>
            </div>
        </div>
    </transition>
</template>
<script>
import axios from 'axios'
import modifiertxt from '../directives/modifierDirect'
export default{
    props: ['idCours'],
    directives:{modifiertxt},
    data() {
        return {
            chapitres:[],
            chapitre:null,
            partie:0,
            commentaire:[],
            active:false,
            chargement:false,
            i1:0,i2:0,i3:0,
            coms:'',
            uuser:0,
            exam:false
        }
    },
    mounted(){
        this.chargement=true
        axios.get("/Interface professeur/"+this.idCours+"-0/Création contenu")
        .then((response)=>{
            this.chapitres=response.data
            this.chargement=false
            let a=this.chapitres[this.chapitres.length-1]
            if(a.partie[a.partie.length-1].cours!==undefined){
                this.exam=true
            }
        })
        .catch((error)=>{
            this.chargement=false
            console.log(error)
        })

    },
    computed:{
        numPartie(){
            return this.partie
        },
        numchapitre(){
            return this.chapitre
        }
    },
    methods:{
        envoyer(){
            if(this.coms.length>0){
                const id=`${this.i1},${this.i2},${this.i3},`
                let message=id+this.coms
                this.coms=''
                let data=new FormData()
                data.append('coms',message)
                axios.post(`/Interface professeur/${this.idCours}/commentaire`,data)
                .then((response)=>{
                    const data=response.data
                    this.commentaire.push({'user':{'id':this.uuser},'nom_utilisateur':data.nom,'comentaires':data.comentaires})
                    // this.$refs.coms.scrollIntoView()
                })
                .catch((error)=>{
                    console.log(error)
                })
            }
        },
        async nbComs(){
            if(this.chapitres[this.i1].partie[this.i2].cours!==undefined){
                for(let i=0;this.chapitres[this.i1].partie[this.i2].cours.length!=i;i++){
                    const reponse=await axios.get(`/Interface professeur/${this.idCours}-${this.i1},${this.i2},${i}/nbcommentaire`)
                    this.chapitres[this.i1].partie[this.i2].cours[i].nb=reponse.data
                }
            }
        },
        commentaires(i3){
            this.active=!this.active
            if(this.active){
                this.i3=i3
                const id=`${this.i1},${this.i2},${i3},`
                this.chargement=true
                axios.get(`/Interface professeur/${this.idCours}-${id}/commentaire`)
                .then((response)=>{
                    this.chargement=false
                    this.commentaire=response.data.coms
                    this.uuser=response.data.id
                })
                .catch((error)=>{
                    this.chargement=false
                    console.log(error)
                })
                
            }else{
                this.commentaire=[]
            }
            
        },
        commmentairePhrase(text){
            const tableau=text.split(",")
            return tableau.slice(3, tableau.length).toString();
        },
        selectionChapitre(chp,i){
            this.chapitre=chp;
            this.partie=0;
            this.i1=i;
            this.i2=0;
            this.nbComs()
        },
        selectionPartie(i){
            this.partie=i-1
            this.i2=i-1
            this.nbComs()
        },
        clickSuivant(){
            if(this.chapitre.partie[this.partie+1].cours!==undefined && this.chapitre.partie.length>this.partie+1){
                this.partie++
                this.i2++
            }else{
                if(this.chapitre.partie[this.partie].cours!==undefined){
                    this.chargement=true
                    axios.get("/Interface professeur/"+this.idCours+"-1/Création contenu")
                    .then((response)=>{
                        this.chapitres=response.data
                        this.chapitre=this.chapitres[this.i1]
                        this.partie++
                        this.i2++
                        this.chargement=false
                    })
                    .catch((error)=>{
                        this.chargement=false
                        console.log(error)
                    })
                    if(this.numchapitre.partie.length>this.partie+1){
                        axios.get("/Interface professeur/"+this.idCours+"-1/Création contenu")
                        .then((response)=>{
                            this.chapitres=response.data
                            let a=this.chapitres[this.chapitres.length-1]
                            if(a.partie[a.partie.length-1].cours!==undefined){
                                this.exam=true
                            }
                        })
                        .catch((error)=>{
                            console.log(error)
                        })
                    }
                }else{
                    this.partie++
                    this.i2++
                }
            }
        },
        examen(){
            let a=this.chapitres[this.chapitres.length-1]
            if(a.partie[a.partie.length-1].cours!==undefined){
                window.location.href=window.location.href+"/examen"
            }
        }
    }
}

</script>
<style>
    input{
        background-color: #ffff;
        padding-left: 10px;
        border: none;
        height: 30px;
        width: 150px;
        border-radius: 30px;
    }
    .couleurEdit{
        background-color: cadetblue;
    }
    .parametre{
        display: grid;
        margin-right: 0%;
        align-content: center;
    }
    .btn{
        background-color: #ffff;
        color:rgb(0, 0, 71);
        border: none;
        margin: 10px;
        height: 50px;
        width: 150px;
        border-radius: 30px;

    }
    section{
        display: flex;
        background-color: rgb(0, 0, 71);
        height: 80vh;

    }
    .contenue{
        width: 60%;
        overflow-y: scroll;
        padding-right: 10px;
        padding-right: 0;
        display: flex;
        background-color: rgb(222, 222, 248);
        flex-direction: column;
        justify-content: space-between;
        align-items: center;
    }
    .jaune{
        background-color: #fdbe00;
        position: absolute;
        bottom: 10px;
        margin-left: 7%;
    }
    .pagination {display: flex;}
    .pagination a {background-color: white;color: black;float: left;padding: 8px 16px;text-decoration: none; transition: background-color .3s;}

    .pagination a.active {background-color: dodgerblue;color: white;}

    .pagination a:hover:not(.active) {background-color: #ddd;}
    .page{
        background-color:#ffff; 
    }
    .icon{
        visibility: hidden;
        color: rgb(0, 0, 71);
        width: 30px;
        float: right;
    }
    .iconn{
        left: 10px !important;
    }
    .contenuee{
        width: 100%;
    }
    .contenuee:hover .icon{
        visibility: visible;
    }
    .chapitree:hover .icon{
        display: block;
    }
    .icon:hover{
        color:  rgb(30, 149, 253);
    }
    .chp{
        background-color: #dedef8;
        color:#000047 !important;
    }
    .chp h3{
        margin-top: 0px;
        margin-bottom: 0px;
    }
    .radius{
        background-color: #dedef8;
        width: 20px;
        height: 20px;
        position: relative;
        left: 91.3%;
    }
    .radius div{
        width: 100%;
        height: 100%;
        background-color: #000047;
    }
    .bas{
        bottom: -20px;
    }
    .bas div{
        border-top-right-radius: 100%;
    }
    .haut{
        top: -20px;
    }
    .haut div{
        border-bottom-right-radius: 100%;
    }
    .affiche-enter-active{
        animation: apparition .5s;
    }
    .affiche-leave-active{
        animation: disparition .5s;
    }
    @keyframes apparition {
        from{transform: scale(0,0);opacity: 0;}
        to{transform: scale(1,1);opacity: 1;}
    }
    @keyframes disparition {
        from{transform: scale(1,1);opacity: 1;}
        to{transform: scale(3,3);opacity: 0;}
    }
    .chargement-enter-active{
        animation: apparition1 .5s;
    }
    .chargement-leave-active{
        animation: disparition1 .5s;
    }
    @keyframes apparition1 {
        from{opacity: 0;}
        to{opacity: 1;}
    }
    @keyframes disparition1 {
        from{opacity: 1;}
        to{opacity: 0;}
    }
    .ff{
        margin: 10px;
        background-color: #2525d4;
        color: white;
        border-radius: 10px;
        padding: 20px;
    }
</style>
