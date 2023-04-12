//-----------initalization of starting values-------------
var gray = "rgb(9, 147, 20)";

//--------------------------------------------------------
//----------------------Calendar--------------------------
document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
       // Setting Calendar
       initialView: 'dayGridMonth',
       fixedWeekCount: false,
       unselectAuto: true,
    });
    let xhr = new XMLHttpRequest();
    xhr.open('GET', 'getShift', true);
    xhr.onload = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            let data = JSON.parse(xhr.responseText);
            console.log(data);
            data.forEach(element => {
                if (element.position == 1) shift = "blue";
                else shift = gray;
                calendar.addEvent({
                    id: 0,
                    title: element.name
                    ,
                    start: element.date,
                    color: shift,
                });
            });
        }
    };
    xhr.send();

    //calendar load
    calendar.render();
  });
