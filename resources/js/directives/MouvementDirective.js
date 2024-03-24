export default{
    mounted(el) {
        el.style.transition="10s";
        el.style.position="absolute";
        setTimeout(function(){
            el.style.top=((Math.random() * 100) + 1)+"vh";
            el.style.left=((Math.random() * 80) + 20)+"vw";
            el.style.transform="rotate("+(((Math.random() * 360)))+"deg)";
        }, 500);
        var duree=parseInt((Math.random() * 10000)+10000)
        setInterval(function(){ 
            el.style.top=((Math.random() * 100) + 1)+"vh";
            el.style.left=((Math.random() * 80) + 20)+"vw";
            el.style.transform="rotate("+(((Math.random() * 360)))+"deg)";
        }, duree);
    },
}