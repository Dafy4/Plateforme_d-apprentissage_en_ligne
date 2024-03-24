<template>
    <div style="overflow-y: hidden;position: relative;">
        <div>
            <div class="text">
                <h1>APPRENTISSAGE EN LIGNE</h1>
                <h2 style="color: aqua;">ODATA LEARNING</h2>
                <p v-manoratra> Une plateforme d'apprentissage en ligne qui a pour but d'optimiser les compétences et les connaissances efficacement.     </p>
            </div>
            <div id="rectange1">
                <div id="rectange2">
                    <!-- <img class="saryyyy" src="css/assets/vue-face-adolescente-smiley-ecouteurs-au-cours-ecole-ligne.jpg" alt=""> -->
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import manoratra from '../directives/ManoratraDirective'
    export default{
        directives:{manoratra}
    }
</script>
<style>
    .text{
        color: white;
        margin-top: 20%;
        margin-left: 25px;
        width: 32%;
    }
    #rectange1{
        width: 30vw;
        height: 30vw;
        border-radius: 11%;
        transform: rotate(45deg);
        position: absolute;
        left: 53%;
        bottom: -10%;
        border:  5px solid #00a3e6;
    }
    #rectange2{
        width: 28.5vw;
        height: 28.5vw;
        border-radius: 11%;
        margin: 10px;
        background-image:url('css/assets/vue-face-adolescente-smiley-ecouteurs-au-cours-ecole-ligne.jpg');
        background-size:cover;
    }
    #rectange2 img {
        width: 100%;
        height: 100%;
        border-radius: 11%;

    }
</style>
