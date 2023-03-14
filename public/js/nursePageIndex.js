//--------------------------------------------------------
//-----------initalization of starting values-------------
var chosen = "Kérés";
var eventColor = "gray";
var eventID = 0;
var forbidden_day = [];

//--------------------------------------------------------
//----------------------Calendar--------------------------
document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    calendar = new FullCalendar.Calendar(calendarEl, {

        // Setting Calendar
        initialView: 'dayGridMonth',
        selectable: true,
        fixedWeekCount: false,
        unselectAuto: true,

        //When we click on an event
        eventClick: function(info) {
            if (info.event.id != 0){
                info.event.remove();
                ConditionalSelection(chosen,info.event.title,"-");
            }
        },

        //When we click on a day.
        select: function(info) {
            var event = calendar.getEventById(info.startStr); // an event object
            eventTitle = "";
            if (event != null) eventTitle = calendar.getEventById(info.startStr).title;
            if(event === null && forbidden_day.indexOf(info.startStr) === -1 ){
                if (ConditionalSelection(chosen,eventTitle,"+") === 1){
                    calendar.addEvent({
                        id: info.startStr,
                        title: chosen,
                        start: info.startStr,
                        color: eventColor
                    });
                }
            }else if (forbidden_day.indexOf(info.startStr) === -1){
                event.remove();
                ConditionalSelection(chosen,eventTitle,"-");
            }
          }
      });

        //request datas
        //upload dates in event
        let xhr = new XMLHttpRequest();
        xhr.open('GET', '/getdata', true);
        xhr.onload = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                let data = JSON.parse(xhr.responseText);
                forbidden_day = data[0] + data[1] + data[2];
                data[0].forEach(element => {
                    calendar.addEvent({
                        id: 0,
                        title: "Szabadság",
                        start: element,
                        color: "blue"
                    });
                });
                data[1].forEach(element => {
                    calendar.addEvent({
                        id: 0,
                        title: "Beteg Szabadság",
                        start: element,
                        color: "red"
                    });
                });
                data[2].forEach(element => {
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

    //Calendar load
    calendar.render();

});

//----------------------------------------------------------------
//----------------------------buttons-----------------------------
function keres(){
    chosen = "Kérés";
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

//-----------------------------------------------------------
//---------------calendar check, add or delete---------------
//----------------------functions----------------------------
function ConditionalSelection(chosen,evenTtitle,increase){
    if (increase == "+"){
        switch (chosen) {
        case "Kérés":
            return numberUp("maxPetitons","currentPetitons");

        case "Szabadság":
            if (numberUp("maxYearHoliday","currentYearHoliday") === 1)
                if (numberUp("maxMonthHoliday","currentMonthHoliday") === 1)
                    return 1;
                else return 0;
            else return 0;

        case "Beteg Szabadság":
            return numberUp("maxYearHoliday","currentYearHoliday");
        }
    }
    //delete "-"
    else{
        switch (evenTtitle) {
        case "Kérés":
            numberdown("maxPetitons","currentPetitons");
            return 1;

        case "Szabadság":
            numberdown("maxMonthHoliday","currentMonthHoliday");
            numberdown("maxYearHoliday","currentYearHoliday");
            return 1;

        case "Beteg Szabadság":
            numberdown("maxYearHoliday","currentYearHoliday");
            return 1;
        }
    }
    return 0;
}


function numberUp($max,$current){
    var maxNumber = parseInt(document.getElementById($max).innerHTML);
    var currentNumber = document.getElementById($current);
    var number = parseInt(currentNumber.innerHTML);
    if (maxNumber > number){
        number++;
        currentNumber.innerHTML = number;
        return 1;
    }
    else{
        alert("Elérted a maximumot!");
        return 0;
    }
}

function numberdown($max,$current){
    var maxNumber = parseInt(document.getElementById($max).innerHTML);
    var currentNumber = document.getElementById($current);
    var number = parseInt(currentNumber.innerHTML);
    number--;
    currentNumber.innerHTML = number;
}

//-----------------------------------------------------------
//------------------upload data in calendar------------------
//------------------------functions--------------------------
function save() {
    var array = []; // inicializáljuk a tömböt
    calendar.getEvents().forEach(element => {
      array.push({"id": element.id, "title": element.title, "date": element.startStr}); // hozzáadjuk az elemeket a tömbhöz
    });
    $.ajax({
        headers:{
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'POST',
        url: '/sendCalendarData',
        data: JSON.stringify(array),
        contentType: 'application/json',
        success: function(response) {
            console.log(response);
        },
        error: function(xhr, status, error) {
            console.log(xhr.responseText);
        }
    });
  }
