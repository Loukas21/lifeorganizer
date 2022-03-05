var clock = document.getElementById('clock');

function time() {
  var d = new Date();
  var s = d.getSeconds();
  var m = d.getMinutes();
  var h = d.getHours();
  var date = d.getDate();
  var month = d.getMonth()+1;
  var day = d.getDay();
  var plday = ["Niedziela", "Poniedziałek", "Wtorek", "Środa", "Czwartek", "Piątek", "Sobota"]
  clock.innerHTML =
    //("0" + h).substr(-2) + ":" + ("0" + m).substr(-2) + ":" + ("0" + s).substr(-2);
    '<i class="fas fa-calendar-day"></i> ' + plday[day] + " " + ("0" + date).substr(-2) + "." + ("0" + month).substr(-2) + "." + d.getFullYear() + '<br /><i class="far fa-clock"></i> ' + ("0" + h).substr(-2) + ":" + ("0" + m).substr(-2);
}

setInterval(time, 1000);
