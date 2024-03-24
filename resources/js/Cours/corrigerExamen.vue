<template>
    <section style="height: 100vh;text-align: center;">
        <div class="parametre" >
            <button class="btn" style="border-radius: 10px" 
                v-for="etudiant,i in etudiants" 
                :key="etudiant"
                @click="clickEtudient(etudiant)"
            >{{ etudiant.nom }}</button>
        </div>
        <div class="contenue">
        <!-- @click="reponse=etudiant.reponse;" -->
        
            <table style="width: 100%;">
                <tr class="component" v-for="contenue,index in reponse" :key="contenue">
                    <th v-if="contenue.type==='sujet'">
                        <p>{{ contenue.text }}</p>
                    </th>
                    <div v-if="contenue.type==='question'">
                        <div v-if="contenue.type1!='quiz'">
                            <div class="question">
                                <th style="color: green;text-decoration: underline;">Reponse</th>
                                <th style="width: 97%;">
                                    <p v-if="contenue.type1=='text'">{{ contenue.reponse }}</p>
                                    <a v-else :href="contenue.reponse">Telecharger</a>
                                </th>

                                <!-- <div style="text-align: right;position: absolute;right: 5%;"> -->
                                <th style="display: flex;flex-direction: column;">
                                    <i style="float: right;">{{ contenue.point }}pts</i>
                                    <div style="display: flex;">
                                        <p class="p">F<br>a<br>u<br>x</p>
                                        <label class="switch">
                                            <input type="checkbox" v-model="contenue.vrai">
                                            <span class="slider"></span>
                                        </label>
                                        <p class="p">V<br>r<br>a<br>i</p>
                                    </div>
                                </th>
                                
                                <!-- </div> -->
                            </div>                   
                        </div>
                        <div v-else>
                            <div style="margin-bottom: 26px;padding-left: 55px;display: flex;align-items: center;">
                                <th style="margin: auto;">
                                    <div v-for="choix,i in contenue.choix" :key="choix">
                                        <label class="container">
                                            <p style="margin-top: 1px;" >{{ choix.text }}</p>
                                            <input type="checkbox" v-model="a">
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>
                                </th>
                                <!-- <div style="position: relative; right: 3%;"> -->
                                <th style="display: flex;flex-direction: column;">
                                    <i style="float: right;">{{ contenue.point }}pts</i>
                                    <div style="display: flex;">
                                        <p class="p">F<br>a<br>u<br>x</p>
                                        <label class="switch">
                                            <input type="checkbox" v-model="contenue.vrai">
                                            <span class="slider"></span>
                                        </label>
                                        <p class="p">V<br>r<br>a<br>i</p>
                                    </div>
                                </th>
                                <!-- </div> -->
                            </div>
                        </div>
                    </div>
                </tr>
            </table>
        </div>
    </section>
</template>
<script>

export default{
    props: ['idCours'],
    data() {
        return {
            exam:[],
            reponse:null,
            etudiants:[],
            a:false
        }
    },
    mounted(){
        axios.get("/Interface professeur/"+this.idCours+"/etudiants")
        .then((response)=>{
            this.etudiants=response.data
            // console.log(response.data)
        })
        .catch((error)=>{
            console.log(error)
        })

        axios.get("/Interface professeur/"+this.idCours+"/Création exam")
        .then((response)=>{
            this.reponse=response.data
        })
        .catch((error)=>{
            console.log(error)
        })
    },
    // computed:{
    //     reponsess(){
    //         return this.reponse
    //     }
    // },
    methods:{
        terminer(){
            console.log(this.exam)
        },
        clickEtudient(etudiant){
            this.reponse=etudiant.reponse.reponse;
            console.log(this.reponse)
        }
    }
}
</script>
<style>
    body{
        user-select: none;
    }
    .p{
        position: relative;
        top: -21px;
        margin: 10px;
        font-size: 11px;
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
/* 

height: 27px;
    display: flex;
    align-items: center;
    flex-direction: row;

*/
</style>