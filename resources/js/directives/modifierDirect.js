export default{
    mounted(el,binding) {
        el.innerText=binding.value.text
        el.addEventListener('input',function(){
            binding.value.text=el.innerText
        })
    },
}