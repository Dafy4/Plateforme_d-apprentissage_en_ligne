<template>
    <form v-on:submit.prevent="envoyer()" class="container">
        <h1> Engagez le meilleur pour former votre équipe <font-awesome-icon :icon="['far', 'laptop-mobile']" /> </h1>
        <hr>
        <div class="alert" :class="message==='echec d\'envoye'?'rouge':''" v-show="alert">{{ message }}</div>
        <div class="select-style">
          <select v-model="form.user">
              <option value="etudiants" > etudiant </option>
              <option value="professeur" > professeur </option>
              <option value="admin" > Admin </option>
          </select>          
        </div>
        <br>
        <label for="nom"><b>Nom</b></label>
        <input type="text" placeholder="Entrer votre nom" v-model="form.nom" required>
        <div v-if="utilisateur!=='admin'">
            <label for="prenom"><b>Prénom</b></label>
            <input type="text" placeholder="Entrer votre prenom" v-model="form.prenom"  required>
            <label for="telephone"><b>Telephone</b></label>
            <input type="tel" placeholder="Entrer votre numero telephone" v-model="form.telephone" required>            
        </div>
        <label for="email"><b>Email </b></label>
        <input type="email" placeholder="Entrer votre adress Email" v-model="form.email" required>
        <div v-if="utilisateur==='admin'">
            <label for="post"><b>Post </b></label>
            <input type="text" placeholder="Entrer votre Post" v-model="form.post" required>            
        </div>
        <div class="select-style">
          <select  v-if="utilisateur==='etudiants'" v-model="form.departement">
              <option v-for="dep in departement" :value="dep.id"> {{ dep.nom }} </option>
          </select>          
        </div>
        <br>
        <div class="clearfix">
            <button type="submit" class="signupbtn" >
              <div v-if="chargement" class="loaderr"></div>
              <div v-else >Ajouter</div>
              
            </button>
        </div>
    </form>
</template>
<script>
    export default{
        data() {
            return {
                form:{},
                formInitial:{
                    "user":"etudiants",
                    "nom":"",
                    "prenom":"",
                    "departement":"1",
                    "telephone":"",
                    "email":"",
                    "post":""
                },
                departement:[],
                alert:false,
                message:'',
                chargement:false
            }
        },
        mounted(){
            this.form=this.formInitial
            axios.get("/departement")
            .then((response)=>{
                this.departement=response.data
                console.log(response.data)
            })
            .catch((error)=>{
                console.log(error)
            })
            
        },
        computed:{
            utilisateur(){
              return this.form.user
            },
            getForm(){
              this.alert=false
              return this.form
            }
        },
        methods:{
            envoyer(){
                const data=this.convertion()
                this.chargement=true;
                axios.post("/account",data)
                  .then((response)=>{
                      this.chargement=false
                      this.alert=true
                      this.message=response.data
                      this.form=this.formInitial
                  })
                .catch((error)=>{
                  console.log(error)
                  this.alert=true
                  this.message="echec d'envoye"
                  this.chargement=false
                })
            },
            convertion(){
                var data = new FormData()
                data.append('nom',this.form.nom)
                data.append('prenom',this.form.prenom)
                data.append('email',this.form.email)
                data.append('departement',this.form.departement)
                data.append('telephone',this.form.telephone)
                data.append('post',this.form.post)
                data.append('type_user',this.form.user)
                return data
            }
        }

    }
</script>
<style>


/* -------------------- */
.alert{
  border-radius: 15px;
  background-color: rgb(123 180 123);
  border: 2px solid green;
  color: #f1f1f1;
  text-align: center;
  padding: 15px;
}
.rouge{
  background-color: rgb(215 122 122);
  border: 2px solid #fd2828;
}
.formInscri input {
  width: 100%;
  padding: 15px;
  margin: 5px 0 22px 0;
  display: inline-block;
  border: none;
  background: #e3e3e3;
}
.formInscri input::placeholder {
    color: rgb(31, 31, 32);
}
.formInscri input:focus {
  background-color: #999999;
  outline: none;
}

hr {
  border: 1px solid #f1f1f1;
  margin-bottom: 25px;
}

button {
  background-color: #00a3e6;
  color: white;
  padding: 14px 20px;
  margin: 8px 0;
  border: none;
  cursor: pointer;
  width: 100%;
  opacity: 0.9;
}

button:hover {
  opacity:1;
}


.signupbtn {
  margin-left: 25%;
  width: 50%;
}

.container {
  padding: 16px;
}

.clearfix::after {
  content: "";
  clear: both;
  display: table;
}

@media screen and (max-width: 300px) {
  .signupbtn {
    width: 100%;
  }
}
.formInscri{
  border:1px solid #ccc;
  position: relative;
  color:white;
  background-color: #000612bf;
  padding-right: 34px;
  max-width: 700px;
  margin: auto;
}
</style>