var chosen = "Kérés";
var eventColor = "gray";
var eventID = 0;
var forbidden_day = [];

document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    calendar = new FullCalendar.Calendar(calendarEl, {
        //settings calendar
        initialView: 'dayGridMonth',
        selectable: true,
        fixedWeekCount: false,
        unselectAuto: true,

        // Ha egy eseményre kattintunk
        eventClick: function(info) {
            if (info.event.id != 0) info.event.remove();
        },

        //Ha 1 napra kattintunk
        select: function(info) {
            var event = calendar.getEventById(info.startStr); // an event object
            if(event === null && forbidden_day.indexOf(info.startStr) === -1 ){
                calendar.addEvent({
                    id: info.startStr,
                    title: chosen,
                    start: info.startStr,
                    color: eventColor
                });
            }else if (forbidden_day.indexOf(info.startStr) === -1){
                event.remove();
            }
          }
      });

      //Szabadság feltöltése
      //Adatok lekérése
        let xhr = new XMLHttpRequest();
        xhr.open('GET', '/getdata', true);
        xhr.onload = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                let data = JSON.parse(xhr.responseText);
                console.log(data);
                forbidden_day = data[0].holidays + data[1].SickLeave + data[2].Petition;
                data[0].holidays.forEach(element => {
                    calendar.addEvent({
                        id: 0,
                        title: "Szabadság",
                        start: element,
                        color: "blue"
                    });
                });
                data[1].SickLeave.forEach(element => {
                    calendar.addEvent({
                        id: 0,
                        title: "Beteg Szabadság",
                        start: element,
                        color: "red"
                    });
                });
                data[2].Petition.forEach(element => {
                    calendar.addEvent({
                        id: 0,
                        title: "Kérés",
                        start: element,
                        color: "gray"
                    });
                });
            }
        };
        xhr.send();

    //naptár betölése
    calendar.render();

      //Esemény lekérdezése
      function getEvents() {
        calendar.getEvents().forEach(element => {
            console.log(element.title);
        });
        console.log(calendar.getEvents());
      }

      document.getElementById('getevent').addEventListener('click', getEvents);
    });

    //----- buttons -----------
    function keres(){
        chosen = "Keres";
        eventColor = 'gray';
        eventID = 1;
    }
    function szabadsag(){
        chosen = "Szabadság";
        eventColor = 'blue';
        eventID = 2;
    }

    function betegSzabadsag(){
        chosen = "Beteg Szabadság";
        eventColor = 'red';
        eventID = 3;
    }
