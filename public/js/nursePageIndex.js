var chosen = "Kérés";
var eventColor = "gray";
var eventID = 0;
var holiday = [];

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
            if(event === null && holiday.indexOf(info.startStr) === -1 ){
                calendar.addEvent({
                    id: info.startStr,
                    title: chosen,
                    start: info.startStr,
                    color: eventColor
                });
            }else if (holiday.indexOf(info.startStr) === -1){
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
                holiday = data.holidays;
                data.holidays.forEach(element => {
                    calendar.addEvent({
                        id: 0,
                        title: "Szabadság",
                        start: element,
                        color: "blue"
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
