function updateClock() {
    var yourTimeZoneFrom = 8.00; //time zone value where you are at (+8 = Asia/Makasar atau WITA) (+7 = Asia/Jakarta atau WIB)

    var d = new Date();
    var tzDifference = yourTimeZoneFrom * 60 + d.getTimezoneOffset();
    //convert the offset to milliseconds, add to targetTime, and make a new Date
    var offset = tzDifference * 60 * 1000;


    var currentTime = new Date(new Date().getTime()+offset);
    // Operating System Clock Hours for 12h clock
    var currentHoursAP = currentTime.getHours();
    // Operating System Clock Hours for 24h clock
    var currentHours = currentTime.getHours();
    // Operating System Clock Minutes
    var currentMinutes = currentTime.getMinutes();
    // Operating System Clock Seconds
    var currentSeconds = currentTime.getSeconds();
    // Adding 0 if Minutes & Seconds is More or Less than 10
    currentMinutes = (currentMinutes < 10 ? "0" : "") + currentMinutes;
    currentSeconds = (currentSeconds < 10 ? "0" : "") + currentSeconds;
    // Picking "AM" or "PM" 12h clock if time is more or less than 12
    var timeOfDay = (currentHours < 12) ? "AM" : "PM";
    // transform clock to 12h version if needed
    currentHoursAP = (currentHours > 12) ? currentHours - 12 : currentHours;
    // transform clock to 12h version after mid night
    currentHoursAP = (currentHoursAP == 0) ? 12 : currentHoursAP;
    // display first 24h clock and after line break 12h version
    var currentTimeString =  currentHours + ":" + currentMinutes + ":" + currentSeconds + "   WITA |   " ;
    // print clock js in div #clock.
    $("#clock").html(currentTimeString);}
    $(document).ready(function () {
    setInterval(updateClock, 1000);
});

// Source Code : https://codepen.io/kase/pen/LxNzWj