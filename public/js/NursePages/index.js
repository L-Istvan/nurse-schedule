var chosen = "Kérés";
var eventID = 0;

var forbidden_day = [];
var forbidden_year_month = [];

var eventColor = "rgb(9, 147, 20)";
var colorHoliday = "#3e7eb3";
var colorSickLeave = "red";
var colorPetition = "rgb(9, 147, 20)";
var colorDay = 'blue';
var colorNight = "#393e46";


function getRestPeriods(){
    $.ajax({
        headers:{
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        method: 'GET',
        url: '/getRestPeriods',
        dataType: 'json',
        success: function(data){
            forbidden_day = data['holiday'] + data['sickLeave'] + data['petition'];
            data['holiday'].forEach(element => {
                calendar.addEvent({
                    id: 0,
                    title: "Szabadság",
                    start: element,
                    color: colorHoliday
                });
            });
            data['sickLeave'].forEach(element => {
                calendar.addEvent({
                    id: 0,
                    title: "Beteg Szabadság",
                    start: element,
                    color: colorSickLeave
                });
            });
            data['petition'].forEach(element => {
                calendar.addEvent({
                    id: 0,
                    title: "Kérés",
                    start: element,
                    color: colorPetition
                });
            });
        },
        error: function(xhr){
            toastr.error("Hiba történt a naptár betöltése során.");
        }
    });
}

function getScheduledDays(year,month,successCallback,errorCallback){
    $.ajax({
        headers:{
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        method: 'POST',
        url: '/getScheduledDates',
        data:{
            year : year,
            month : month,
        },
        dataType: 'json',
        success: function(data){
            successCallback(data);
        },
        error: function(xhr){
            errorCallback(xhr);
        }
    })
}

function containsDate(array, year, month) {
    return array.some(element => element[0] === year && element[1] === month);
}


function addscheduledDaysToCalendar(array){
    array.forEach(element => {
        if (element['position'] == 2){
            calendar.addEvent({
                id: 0,
                title: "Nappal",
                start: element['date'],
                color: colorDay
            });
        }
        else{
            calendar.addEvent({
                id: 0,
                title: "Éjszaka",
                start: element['date'],
                color: colorNight
            });
        }
    });
}


//calendar check, add or delete
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
            return 1
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
            numberdown("maxYearHoliday","SickLeaves");
            return 1;
        }
    }
    return 0;
}


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
        datesSet: function(info) {
            var currentYear = info.view.currentStart.getFullYear();
            var currentMonth = info.view.currentStart.getMonth()+1;

            var existingItem = containsDate(forbidden_year_month,currentYear,currentMonth);

            if (!existingItem){
                var newItem = [currentYear, currentMonth];
                forbidden_year_month.push(newItem);
                getScheduledDays(currentYear, currentMonth, function(data) {
                    addscheduledDaysToCalendar(data);
                }, function(xhr) {
                    toastr.error("Hiba történt a naptár betöltése során.");
                });

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

    getRestPeriods();
    //Calendar load
    calendar.render();

});

//----------------------------------------------------------------
//----------------------------buttons-----------------------------
function keres(){
    chosen = "Kérés";
    eventColor = colorPetition;
    eventID = 1;
}

function szabadsag(){
    chosen = "Szabadság";
    eventColor = colorHoliday;
    eventID = 2;
}

function betegSzabadsag(){
    chosen = "Beteg Szabadság";
    eventColor = colorSickLeave;
    eventID = 3;
}



//-----------------------------------------------------------
//------------------upload data in calendar------------------
//------------------------functions--------------------------
function save() {
    var array = [];
    calendar.getEvents().forEach(element => {
      array.push({"id": element.id, "title": element.title, "date": element.startStr});
    });
    $.ajax({
        headers:{
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        method: 'POST',
        url: '/sendCalendarData',
        data:{
            dates : JSON.stringify(array),
        },
        dataType: 'json',
        complete: function(xhr){
            if(xhr.status == 200) toastr.success("Sikeres mentés");
            else if(xhr.status == 204) toastr.warning("Nem történt változás");
            else {
                toastr.error("Hiba történt a mentés során.");
            }
        }
    });
  }
