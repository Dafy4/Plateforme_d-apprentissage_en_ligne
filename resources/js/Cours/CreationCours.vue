<template>
    <section style="height: 100vh;text-align: center;">
        <div class="chapitre">
            <div>
                <p style="color: white;" >chapitre</p><br>
                <div class="chapitree" v-for="chp in chapitres" :key="chp"
                    :class="chapitre===chp ? 'chp':''"
                    >
                    <i @click="suppressinChapitre(chp)"  class="fa fa-close iconn icon " ></i>
                    <div v-if="chapitre===chp " class="radius haut"><div></div></div>
                    <h3
                        :style="chapitre===chp? 'color:#000047':'color: white;'"
                        @click="chapitre=chp;partie=0;"
                    >{{chp.nom}}</h3>
                    <div v-if="chapitre===chp " class="radius bas"><div></div></div>
                </div>

                <input v-if="chpActive" v-model="chapitreValeur" @keyup.enter="ajoutChapitre" type="text">
                <button class="btn" @click="chpActive=true">+ chapitre</button>
            </div>
            <button class="btn" style="width: 100%;margin: 0;border-radius: 14px;">Examen</button>
        </div>
        <div class="contenue">
            <div v-if="numchapitre!==null">
                <div class="contenuee"  v-for="contenue in numchapitre.partie[numPartie].cours" :key="contenue">
                    <i @click="suppressinContenue(contenue)"  class="fa fa-close icon" ></i>
                    <!-- si paragraphe -->
                    <p
                        :class="edit===contenue ? 'couleurEdit':''"
                        :contenteditable="edit===contenue"
                        v-modifiertxt="contenue"
                        v-if="contenue.type==='paragraphe'"
                        @dblclick="modifier(contenue)"
                    ></p>
                    <!-- si titre -->
                    <h1
                        :class="edit===contenue ? 'couleurEdit':''"
                        :contenteditable="edit===contenue"
                        v-modifiertxt="contenue"
                        v-if="contenue.type==='titre'"
                        @dblclick="modifier(contenue)"
                    ></h1>
                    <!-- si question -->
                    <p
                        :class="edit===contenue ? 'couleurEdit':''"
                        :contenteditable="edit===contenue"
                        v-modifiertxt="contenue"
                        v-if="contenue.type==='input'"
                        @dblclick="modifier(contenue)"
                    ></p>
                    <div v-if="contenue.type==='image'">
                        <img :src="contenue.text" alt=":)">
                    </div>
                    <button v-if="edit===contenue && contenue.type!=='image'" @click="valider(contenue);">valider</button>
                    <input v-if="contenue.type==='input'" type="text"><button v-if="contenue.type=='input'">aa</button>
                </div>
            </div>
            <div class="page" v-if="numchapitre!==null">
                <div class="pagination">
                    <a >&laquo;</a>
                    <a
                        :class="partie==i-1?'active':''"
                        @click="partie=i-1"
                        v-for="i in numchapitre.partie.length" :key="i"
                    >{{i}}</a>
                    <a @click="ajoutPartie">+</a>
                    <a >&raquo;</a>
                </div>
            </div>
        </div>
        <div class="parametre" v-if="numchapitre!==null" >
            <button class="btn" @click="ajout('titre')">+ titre</button>
            <button class="btn" @click="ajout('paragraphe')">+ texte</button>
            <button class="btn" @click="ajout('input')">+ question</button>
            <div class="btn file">
                <input @change="fichierSelectionne"  type="file" name="file">
                <span @click="importationFile">&raquo;</span>
            </div>
            <button class="btn" @click="ajout('image')"></button>
            <button class="btn">+ video</button>
            <button class="btn">+ fichier</button>
            <button class="btn">+ Quiz</button>
            <button class="btn jaune" @click="insertion" >Valider</button>
        </div>
    </section>

</template>

<script>
import axios from 'axios'
import modifiertxt from '../directives/modifierDirect'
export default{
    props: ['idCours'],
    directives:{modifiertxt},
    data() {
        return {
            edit:null,
            chapitres:[],
            chapitre:null,
            partie:0,
            chapitreValeur:'',
            chpActive:false,
            fileSelect:null,
            courseId:null
        }
    },
    mounted(){
        axios.get("/Interface professeur/"+this.idCours+"-0/Création contenu/")
        .then((response)=>{
            this.chapitres=response.data
        })
        .catch((error)=>{
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
    methods: {
        ajoutChapitre(){
            var chp={
                nom:this.chapitreValeur,
                partie:[
                    {'cours':[]}
                ]
            }
            this.chapitres.push(chp)
            this.partie=0;
            this.chapitreValeur=''
            this.chpActive=false
            this.chapitre=this.chapitres[this.chapitres.length-1]
        },
        modifier(contenue){
            this.edit=contenue
        },
        ajout(type){
            var a={'type':type,'class':'','text':''}
            this.edit=a
            this.chapitre.partie[this.partie].cours.push(a)
            // console.log(this.chapitre.partie[this.partie].cours)
        },
        valider(cont){
            this.edit=null
            if(cont.text===''){
                this.cours=this.cours.filter(cour=>cour!==cont)
            }
            console.log(JSON.stringify(this.chapitres))
        },
        ajoutPartie(){
            this.chapitre.partie.push({'cours':[]})
            this.partie=this.chapitre.partie.length-1
        },
        fichierSelectionne(event){
            this.fileSelect=event.target.files[0]
        },
        importationFile(){
            const formData=new FormData();
            formData.append('fichier',this.fileSelect)
            axios
                .post("api/uploadFichier",formData)
                .then((response)=>{
                    var a={'type':'image','class':'','text':response.data.message}
                    this.chapitre.partie[this.partie].cours.push(a)
                })
                .catch((error)=>{
                    console.log(error)
                })
        },
        suppressinContenue(contenue){
            this.chapitre.partie[this.partie].cours=this.chapitre.partie[this.partie].cours.filter(a=>a!==contenue)
        },
        suppressinChapitre(chp){
            this.chapitres=this.chapitres.filter(a=>a!=chp)
        },
        insertion(){
            var data=new FormData()
            data.append('cours',JSON.stringify(this.chapitres))
            axios
                .post("/Interface professeur/"+this.idCours+"/Création contenu/",data)
                .then((response)=>{
                    console.log(response)
                })
                .catch((error)=>{
                    console.log(error)
                })
        }
    },
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
        background-color: rgb(222, 222, 248);
    }
    .jaune{
        background-color: #fdbe00;
    }
    .pagination{
        display: flex;
    }
    .pagination a {color: black;float: left;padding: 8px 16px;text-decoration: none; transition: background-color .3s;}

    .pagination a.active {background-color: dodgerblue;color: white;}

    .pagination a:hover:not(.active) {background-color: #ddd;}
    .page{
        background-color:#ffff;
        position: absolute;
        bottom: -53.5vh;
    }
    .icon{
        display: none;
        position: absolute;
        left: 75%;
        color: rgb(117, 117, 117);
        width: 100px;
    }
    .iconn{
        left: 10px !important;
    }
    .contenuee:hover .icon{
        display: block;
    }
    .chapitree:hover .icon{
        display: block;
    }
    .icon:hover{
        color: rgb(219, 68, 68);
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
    div.chapitre{
        width: 20vw;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }
</style>
