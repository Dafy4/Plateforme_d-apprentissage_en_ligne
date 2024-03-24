export default {
    mounted(el, binding) {
        var temps= parseInt(binding.value);
        function updateTimer() {
            const heure=Math.floor(temps/3600)
            const minute = Math.floor((temps%3600)/60);
            const second = Math.floor(temps%60);
            el.textContent = `${heure}:${minute}:${second % 60}`;
            temps--;
        }
        setInterval(updateTimer, 1000);
    }
}