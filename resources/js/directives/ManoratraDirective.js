export default{
    mounted(el) {
        var text=el.innerText;
        var i=0;
        el.innerText='_';
        setTimeout(function(){
            var manoratra=setInterval(function(){ 
                el.innerText=text.slice(0, i);
                el.innerText+='_';
                if(text.length<=i){
                    clearInterval(manoratra);
                    el.innerText=text
                }
                i++;
            }, 50);
        }, 1000);
    },
}