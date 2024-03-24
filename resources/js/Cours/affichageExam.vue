<template>
    <transition name="chargement">
        <div class="alert" v-if="fenetre">
            <div>ON A VUE QUE VOUS AVEZ QUITTÉ <span style="color: black;">{{ tentative }}</span> FOIS CETTE ONGET!
                <i @click="fenetre=false;">x</i>
            </div>
        </div>
    </transition>
    
    <section style="height: 87vh;text-align: center;">
        <div class="minuteur" >Temps restant:{{ tempss }}</div>
        <div class="contenue">
            <table style="width: 100%;">
                <tr class="component" v-for="contenue,index in exam" :key="contenue">
                    <th v-if="contenue.type==='sujet'">
                        <p>{{ contenue.text }}</p>
                    </th>
                    <div v-if="contenue.type==='question'">
                        <div v-if="contenue.type1!='quiz'">
                            <div class="question">
                                <th style="width: 97%;">
                                    <input :type="contenue.type1=='text'?'text':'file'" placeholder="ecrire la reponse ici" v-model="contenue.reponse" style="width: 45%;border-radius: 5px;">
                                </th>
                                <!-- <div style="text-align: right;position: absolute;right: 5%;"> -->
                                
                                <th><i style="float: right;">{{ contenue.point }}pts</i></th>
                                <!-- </div> -->
                            </div>                   
                        </div>
                        <div v-else>
                            <div style="margin-bottom: 26px;padding-left: 55px;display: flex;align-items: center;">
                                <th style="margin: auto;">
                                    <div v-for="choix,i in contenue.choix" :key="choix">
                                        <label class="container">
                                            <p style="margin-top: 1px;" >{{ choix.text }}</p>
                                            <input type="checkbox" v-model="choix.reponse">
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>
                                </th>
                                <!-- <div style="position: relative; right: 3%;"> -->
                                <th><i style="float: right;">{{ contenue.point }}pts</i></th>
                                <!-- </div> -->
                            </div>
                        </div>
                    </div>
                </tr>
            </table>
            <button @click="terminer" class="terminer">Terminer</button>
        </div>
    </section>
</template>
<script>
export default{
    props: ['idCours'],
    data() {
        return {
            exam:[],
            tentative:0,
            temps:6000,
            tempsRest:'',
            fenetre:false
        }
    },
    computed:{
        tempss(){
            return this.tempsRest
        }
    },
    mounted(){
        
        const self=this
        window.addEventListener("blur", function() {
            self.tentative++
            window.localStorage.setItem(`tentative${self.idCours}`,self.tentative)
        });
        window.addEventListener("focus", function() {
            self.fenetre=true
        });
        axios.get("/Interface étudiant/"+this.idCours+"/exam")
            .then((response)=>{
                let t=window.localStorage.getItem(`temps${this.idCours}`);
                this.exam=response.data.examen
                this.temps=t==null ? response.data.temps:t;
            })
            .catch((error)=>{
                console.log(error)
            })
        let tentativeSave=window.localStorage.getItem(`tentative${this.idCours}`)
        this.tentative=tentativeSave==null ? 0:tentativeSave
        setInterval(self.maj,10000)
        setInterval(self.updateTimer,1000)
        // setTimeout(document.documentElement.requestFullscreen(),1000)
    },
    methods:{
        maj(){
            axios.post("/Interface étudiant/"+this.idCours+"/exam",{
                'reponse':this.exam
            }).catch((error)=>{
                console.log(error)
            })
        },
        terminer(){
            axios.post("/Interface étudiant/"+this.idCours+"/exam",{
                'reponse':this.exam,
                'fenetre':this.tentative
            })
            window.location.href=window.location.href.slice(0,-7)
        },
        updateTimer() {
            const heure=Math.floor(this.temps/3600)
            const minute = Math.floor((this.temps%3600)/60);
            const second = (this.temps%60);
            this.tempsRest = `${heure}:${minute}:${second }`;
            this.temps--;
            window.localStorage.setItem(`temps${this.idCours}`,this.temps)
            if(this.temps<0){
                window.location.href=window.location.href.slice(0,-7)
            }
        },

    }
    
}
</script>
<style>
    body{
        user-select: none;
    }
    .terminer {
        position: fixed;
        bottom: 0;
        right: 0;
        border-radius: 8px;
        margin: 0;
        background: rgb(91, 187, 91);
        color: #dedef8;
        height: 50px;
        width: 229px;
    }
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
        height: 100vh;
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
.alert{
    position: fixed;
    top: 0;
    left: 0;
    z-index: 2;
    width: 100vw;
    height: 100vh;
    background-color: #000000ba;
}
.alert > div{
    background-color: #cd5454;
    margin: auto;
    color: aliceblue;
    width: max-content;
    margin-top: 40vh;
    padding: 34px;
    border-radius: 10px;
}
.alert > div > i{
    position: relative;
    top: -34px;
    right: -22px;
    padding: 10px;
    transition: 0.5s;
}
.alert > div > i:hover{
    color: black;
}
</style>