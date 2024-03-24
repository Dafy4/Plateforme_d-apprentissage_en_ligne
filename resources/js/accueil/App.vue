<template>
    <div id="gg">
        <div id="a">
            <div class="cercle"></div>
            <div id="carre" v-mouvement v-for="i in 6" :key="chp"></div>
        </div>
        <div class="ligne">
            <svg class="rectangle" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="180%" height="200%" viewBox="0 0 1954.346 1945.375">
                <defs>
                    <filter id="Bande_horizentale" x="616.149" y="0" width="1338.197" height="1329.197" filterUnits="userSpaceOnUse">
                        <feOffset dx="-22" dy="13" input="SourceAlpha"/>
                        <feGaussianBlur stdDeviation="3" result="blur"/>
                        <feFlood flood-opacity="0.161"/>
                        <feComposite operator="in" in2="blur"/>
                        <feComposite in="SourceGraphic"/>
                    </filter>
                </defs>
                <g id="Fond2" transform="translate(0 711.01) rotate(-45)" fill="#001a4b" stroke="#707070" stroke-width="1">
                    <rect width="958" height="1745.657" stroke="none"/>
                    <rect x="0.5" y="0.5" width="957" height="1744.657" fill="none"/>
                </g>
                <g transform="matrix(1, 0, 0, 1, 0, 0)" filter="url(#Bande_horizentale)">
                    <g id="Bande_horizentale-2" data-name="Bande horizentale" transform="translate(647.15 98.29) rotate(-45)" fill="#001a4b" stroke="#001a4b" stroke-width="1">
                        <rect width="139" height="1709.656" stroke="none"/>
                        <rect x="0.5" y="0.5" width="138" height="1708.656" fill="none"/>
                    </g>
                </g>
            </svg>
        </div>
    </div>
</template>
<script>
    import mouvement from '../directives/MouvementDirective'
    export default{
        directives:{mouvement},

    }
</script>
<style>
    .rectangle{
        position: absolute;
        top: -21%;
        left: -73%;
    }
    #gg{
        width: 150%;
        height: 100%;
        background-color: #02133f;
    }
    #a{
        position: absolute;
        width: 100%;
        height: 100%;
        top: 0px;
        left: 0px;
        overflow-y: hidden;
        overflow-x: hidden;
    }
    .cercle{
        border-radius: 50%;
        box-shadow: inset 0px 0px 15px 6px #000000;
        width: 600px;
        height: 600px;
        position: absolute;
        top: 5%;
        left: 35%;
    }
    .ligne{
        position: absolute;
        width: 100vw;
        height: 100vh;
        top: 0px;
        left: 0px;
        overflow-y: hidden;
        overflow-x: hidden;
    }
    #carre{
        width: 150px;
        height: 150px;
        background-color: #00a3e6;
        opacity: 0.7;
        position: absolute;
        top: 50%;
        left: 50%;
        border-radius: 20px;
        transform: rotate(-30deg);
    }
    body{
        background-color: #02133f;
    }
</style>
