<template>
    
    <section style="height: 87vh;text-align: center;">
        <div class="parametre" >
            <button class="btn" @click="ajout('sujet')">+ Sujet/Question</button>
            <div class="quest">
                <button class="btn" @mouseover="handleMouseOver" @mouseout="handleMouseOut">+ Reponse</button>
                <div @mouseover="handleMouseOver" v-show="afficheReponse" class="dropdown-content">
                    <div @click="reponse('text')">text</div>
                    <div @click="reponse('quiz')">quiz</div>
                    <div @click="reponse('fichier')">ficher</div>
                </div>
            </div>
            <button class="btn jaune" @click="insertion">Valider</button>
        </div> 
        <div class="contenue">
            <input class="minuteur minuteurr" type="time" v-model="temps">
            <div>
                <div class="component" v-for="contenue in exam" :key="contenue">
                    <i @click="suppressinContenue(contenue)" class="fa fa-close icon" style="z-index: 1;"></i>
                    <div v-if="contenue.type==='sujet'">
                        <p
                            :class="edit===contenue ? contenue.class+' couleurEdit ':contenue.class"
                            :contenteditable="edit===contenue"
                            @dblclick="edit=contenue"
                            v-modifiertxt="contenue"
                        ></p>
                        <i v-if="edit===contenue" @click="edit=null">Valider</i>                  
                    </div>
                    <div v-if="contenue.type==='question'">
                        <div v-if="contenue.type1!='quiz'">
                            <div class="question">
                                <input :type="contenue.type1=='text'?'text':'file'" placeholder="ecrire ici la vrai reponse" v-model="contenue.reponse" style="width: 45%;border-radius: 5px;">
                                <div style="text-align: right;position: absolute;right: 5%;">
                                    <div><i>Point:</i><input step="0.25" min="0" type="number" v-model="contenue.point"></div>
                                </div>
                            </div>                            
                        </div>
                        <div v-else>
                            <div @dblclick="contenue=edit" style="margin-bottom: 26px;padding-left: 55px;padding-left: 55px;display: flex;flex-direction: column;align-content: stretch;align-items: center;">
                                <div v-for="choix,i in contenue.choix" :key="choix">
                                    
                                    <label class="container" @dblclick="indexEdit=i;edit=contenue">
                                        <p style="margin-top: 1px;" v-show="indexEdit!=i" >{{ choix.text }}</p>
                                        <input type="checkbox" v-model="choix.reponse">
                                        <input v-show="contenue===edit && indexEdit==i" @keyup.enter="indexEdit=null" type="text" v-model="choix.text">
                                        <span class="checkmark"></span>
                                    </label>
                                    <i @click="suppressinquiz(contenue,choix)" class="fa fa-close"></i>
                                </div>
                                <label v-if="contenue==edit" v-show="isInput" class="container">
                                        <input v-model="inputValeur" type="text" @keyup.enter="ajoutChoix(contenue)">
                                        <input type="checkbox" v-model="reponseValue">
                                        <span class="checkmark"></span>
                                </label>
                                <div style="position: absolute; right: 3%;"><i>Point:</i><input min="0" step="0.25" type="number" v-model="contenue.point"></div>
                            </div>
                            <span v-if="contenue==edit && indexEdit==null" v-show="!isInput"><h1 @click="isInput=true">+</h1></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
<script>
import modifiertxt from '../directives/modifierDirect.js'
export default{
    directives:{modifiertxt},
    props: ['idCours'],
    data() {
        return {
            indexEdit:null,
            editReponse:false,
            edit:null,
            exam:[],
            isInput:false,
            inputValeur:'',
            reponseValue:false,
            afficheReponse:false,
            temps:'01:00'
        }
    },
    mounted(){
        axios.get("/Interface professeur/"+this.idCours+"/Création exam")
        .then((response)=>{
            // console.log((JSON.stringify({'examen':JSON.stringify(response.data),'temps':3600})))
            this.exam=JSON.parse(response.data.examen)
            let a=response.data.temps
            let heure=`${Math.floor(a/3600)}`.length==1 ? `0${Math.floor(a/3600)}`:`${Math.floor(a/3600)}`
            let minute=`${Math.floor((a%3600)/60)}`.length==1 ? `0${Math.floor((a%3600)/60)}`:`${Math.floor((a%3600)/60)}`
            this.temps=`${heure}:${minute}`
        })
        .catch((error)=>{
            console.log(error)
        })
    },
    computed:{

    },
    methods:{
        ajout(type){
            var a={'type':type,'class':'','text':''}
            this.edit=a
            this.exam.push(a)
            console.log(this.exam)
        },
        reponse(type){
            this.afficheReponse=false
            var a={'type':'question','type1':type,'class':'','reponse':'','point':0};
            if(type=='quiz'){
                a={'type':'question','type1':type,'class':'','choix':[],'point':0};
            }
            this.edit=a;
            this.exam.push(a);
        },
        ajoutChoix(contenue){
            contenue.choix.push({'text':this.inputValeur,'reponse':this.reponseValue})
            this.inputValeur=''
            this.reponseValue=false
            this.isInput=false
        },
        suppressinContenue(contenue){
            this.exam=this.exam.filter(a=>a!==contenue)
        },
        suppressinquiz(contenue,quiz){
            contenue.choix=contenue.choix.filter(a=>a!==quiz)
        },
        handleMouseOver(){
            this.afficheReponse=true
        },
        handleMouseOut(){
            this.afficheReponse=false
        },
        insertion(){
            var data=new FormData()
            data.append('cours',JSON.stringify(this.exam))
            let temps=this.temps.split(':')
            const seconde=temps[0]*3600+temps[1]*60
            data.append('temps',seconde)
            axios
                .post("/Interface professeur/"+this.idCours+"/Création exam/",data)
                .then((response)=>{
                    console.log(response)
                })
                .catch((error)=>{
                    console.log(error)
                })
        },
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
        display: flex;
        margin-right: 0%;
        justify-content: flex-start;
        justify-items: end;
        flex-direction: column;
        align-items: flex-end;
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
        width: 100%;
        overflow-y: scroll;
        background-color: rgb(222, 222, 248);
    }
    .jaune{
        background-color: #fdbe00;
        position: absolute;
        bottom: 10px;
        margin-left: 7%;
    }
    .pagination a {color: black;float: left;padding: 8px 16px;text-decoration: none; transition: background-color .3s;}
      
    .pagination a.active {background-color: dodgerblue;color: white;}
      
    .pagination a:hover:not(.active) {background-color: #ddd;}
    .page{
        background-color:#ffff;
        position: absolute;
        bottom: 0px;
    }
    .dropdown-content {
        display: none;
        margin-top: -8px;
        position: absolute;
        background-color: #f1f1f1;
        min-width: 160px;
        box-shadow: 0px 0px 13px 4px rgb(0 0 0);
        z-index: 1;
        border-radius: 0 0 10px 10px;
    }
    .dropdown-content div {
        color: black;
        padding: 12px 16px;
        text-decoration: none;
        display: block;
        cursor: pointer;
    }
    .dropdown-content div:hover {background-color: #ddd;border-radius: 10px;box-shadow: 0px 0px 13px 4px rgb(0 0 0);}

    .quest:hover .dropdown-content {display: block;}
    .dropdown-content > div:checked ~ .dropdown-content{
        display: none;
    }
    .question{
        display: flex;
        flex-direction: row;
        justify-content: center;
        margin-bottom: 45px;
    }
    .question input::placeholder{
        color: rgb(63, 63, 63);
    }
    input[type="number"]{
        width: 60px;
        border-radius: 2px;
    }


    /* The container */
.container {
  position: relative;
  padding-left: 50px;
  margin-bottom: -8px;
  cursor: pointer;
  font-size: 18px;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
  display: block;
  margin-top: 18px;
}

/* Hide the browser's default checkbox */
.container input[type="checkbox"] {
  position: absolute;
  opacity: 0;
  cursor: pointer;
  height: 0;
  width: 0;
}
.container input[type="text"] {
  border-radius: 5px;
}

/* Create a custom checkbox */
.checkmark {
  position: absolute;
  top: 0;
  left: 0;
  height: 25px;
  width: 25px;
  background-color: #eee;
}

/* On mouse-over, add a grey background color */
.container:hover input ~ .checkmark {
  background-color: #ccc;
}

/* When the checkbox is checked, add a blue background */
.container input:checked ~ .checkmark {
  background-color: #2196F3;
}

/* Create the checkmark/indicator (hidden when not checked) */
.checkmark:after {
  content: "";
  position: absolute;
  display: none;
}

/* Show the checkmark when checked */
.container input:checked ~ .checkmark:after {
  display: block;
}

/* Style the checkmark/indicator */
.container .checkmark:after {
  left: 9px;
  top: 5px;
  width: 5px;
  height: 10px;
  border: solid white;
  border-width: 0 3px 3px 0;
  -webkit-transform: rotate(45deg);
  -ms-transform: rotate(45deg);
  transform: rotate(45deg);
}
.icon{
    display: none;
    position: absolute;
    left: 95%;
    font-size: 20px;
    color: rgb(117, 117, 117);
}
.kely{
    left: 50%;
}
.component:hover .icon{
    display: block;
}
.component > div > div > div > div{
    height: 27px;
    display: flex;
    align-items: center;
    flex-direction: row;
}
.icon:hover{
    color: rgb(219, 68, 68);
}
/* 

height: 27px;
    display: flex;
    align-items: center;
    flex-direction: row;

*/
.minuteurr{
    position: relative;
    float: left;
}
</style>