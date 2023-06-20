const array = [];

//--------------------Month-------------------------
const d = new Date();
var monthNumber = d.getMonth();
var year = d.getFullYear();
const months = ["Január","Február","Március","Április","Május","Június",
    "Július","Agusztus","Szeptember","Oktober","November","December"];
document.getElementById("month").innerHTML = months[monthNumber];

//---------------------Year--------------------------
document.getElementById("year").innerHTML = year;

//--------------the days of the month-----------------
function getNumberOfDaysInMonth(month, year) {
    return new Date(year, month + 1, 0).getDate();
  }

function showNumberOfDaysInMonth(day){
    var elements;
    //show
    for (i=29; i<=day; i++){
        elements = document.getElementsByClassName(i);
        for (var j = 0; j < elements.length; j++) {
            elements[j].style.display = '';
        }
    }
    //hidden
    for (i=day+1; i<32; i++){
        elements = document.getElementsByClassName(i);
        for (var j = 0; j < elements.length; j++) {
            elements[j].style.display = 'none';
        }
    }
}

//-----------------Table header------------------------
function prev(){
    if (monthNumber == 0){
        monthNumber = 11;
        year--;
        document.getElementById("year").innerHTML = year;
        document.getElementById("month").innerHTML = months[monthNumber];
        tableLoad();
        emptyTable();
        showNumberOfDaysInMonth(getNumberOfDaysInMonth(monthNumber,year));
    }
    else{
        monthNumber--;
        document.getElementById("month").innerHTML = months[monthNumber];
        tableLoad();
        emptyTable();
        showNumberOfDaysInMonth(getNumberOfDaysInMonth(monthNumber,year));
    }
}

function next(){
    if(monthNumber == 11){
        monthNumber = 0;
        year++;
        document.getElementById("year").innerHTML = year;
        document.getElementById("month").innerHTML = months[monthNumber];
        tableLoad();
        emptyTable();
        showNumberOfDaysInMonth(getNumberOfDaysInMonth(monthNumber,year));
    }
    else{
        monthNumber++;
        document.getElementById("month").innerHTML = months[monthNumber];
        tableLoad();
        emptyTable();
        showNumberOfDaysInMonth(getNumberOfDaysInMonth(monthNumber,year));
    }
}

//------------------Colors---------------------
colorBackground = "";
dayColor = "rgb(62, 126, 179)"; // blue --> value = 2
nightColor = "rgb(57, 62, 70)"; //gray --> value = 1
petitionColor = "yellow";
holidayColor = "green";
sickLeaveColor = "red";

const tbody = document.querySelector('table');
tbody.addEventListener('click', function (e) {
    const cell = e.target.closest('td');
    if (!cell) {return;} //If the cell was not clicked, it exits
    const row = cell.parentElement;
    x = document.getElementById("table").rows[row.rowIndex].cells[cell.cellIndex];
    if (window.getComputedStyle(e.target,null).backgroundColor == "rgba(0, 0, 0, 0)" ||
    window.getComputedStyle(e.target,null).backgroundColor == 'rgb(255, 255, 255)'){ //Is it the original color?
        x.style.backgroundColor = "#3e7eb3"; //blue
        }
    else{
        if (window.getComputedStyle(e.target,null).backgroundColor == "rgb(62, 126, 179)"){ //Is it blue color?
            x.style.backgroundColor = "#393e46"; //gray
        }
        else{
            if (window.getComputedStyle(e.target,null).backgroundColor == "rgb(57, 62, 70)"){ //Is it gray color?
                x.style.backgroundColor = "rgb(255, 255, 255)"; //white
            }else{
                console.log("ERROR: COLOR ");
                }
            }
        }
});

//-------- schedule planner button--------------
function create_schedule(){
    $.ajax({
        headers:{
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'POST',
        url: 'create_schedule',
        data: JSON.stringify([year,monthNumber+1,getNumberOfDaysInMonth(monthNumber,year)]),
        contentType: 'application/json',
        complete: function(xhr){
            if (xhr.status == 200){
                toastr.success(xhr.responseText);
                emptyTable();
            }
            else toastr.error("Sikeretelen beosztás");
        }
    });
}

function tableLoad(){
    if (document.getElementById("day").checked){
        tableLoadDay(year,monthNumber+1);
    }
    if (document.getElementById("night").checked){
        tableLoadNight(year,monthNumber+1);
    }
    if (document.getElementById("petition").checked){
        tableLoadPetition(year,monthNumber+1);
    }
    if (document.getElementById("holiday").checked){
        tableLoadHoliday(year,monthNumber+1);
    }
    if (document.getElementById("sickLeave").checked){
        tableLoadSickLeave(year,monthNumber+1);
    }
}


function tableLoadDay(year,month){
    $.ajax({
        headers:{
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'POST',
        url:'tableLoadDay',
        data:{
            year : year,
            month : month
        },
        success: function(xhr){
            xhr[0].forEach(element =>{
                date = element['date'].split('-');
                for (var r = 0, n = table.rows.length; r < n; r++) { //table row
                    if (table.rows[r].id == element['person_id']){
                        table.rows[r].cells[parseInt(date[2])].style.backgroundColor = dayColor;
                    }
                }
            });
        }
    });
}

function tableLoadNight(year,month){
    $.ajax({
        headers:{
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'POST',
        url:'tableLoadNight',
        data:{
            year : year,
            month : month
        },
        success: function(xhr){
            xhr[0].forEach(element =>{
                date = element['date'].split('-');
                for (var r = 0, n = table.rows.length; r < n; r++) { //table row
                    if (table.rows[r].id == element['person_id']){
                        table.rows[r].cells[parseInt(date[2])].style.backgroundColor = nightColor;
                    }
                }
            });
        }
    });
}

function tableLoadPetition(year,month){
    $.ajax({
        headers:{
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'POST',
        url:'table_load_petition',
        data:{
            year : year,
            month : month
        },
        success: function(xhr){
            xhr[0].forEach(element =>{
                date = element['date'].split('-');
                for (var r = 0, n = table.rows.length; r < n; r++) { //table row
                    if (table.rows[r].id == element['person_id']){
                        table.rows[r].cells[parseInt(date[2])].style.backgroundColor = petitionColor;
                    }
                }
            });
        }
    });
}

function tableLoadHoliday(year,month){
    $.ajax({
        headers:{
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'POST',
        url: 'tableLoadHoliday',
        data:{
            year: year,
            month: month
        },
        success: function(xhr){
            xhr[0].forEach(element =>{
                date = element['date'].split('-');
                for (var r = 0, n = table.rows.length; r < n; r++) { //table row
                    if (table.rows[r].id == element['person_id']){
                        table.rows[r].cells[parseInt(date[2])].style.backgroundColor = holidayColor;
                    }
                }
            });
        }
    });
}

function tableLoadSickLeave(year,month){
    $.ajax({
        headers:{
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'POST',
        url: 'tableLoadSickLeave',
        data:{
            year : year,
            month : month
        },
        success: function(xhr){
            xhr[0].forEach(element =>{
                date = element['date'].split('-');
                for (var r = 0, n = table.rows.length; r < n; r++) { //table row
                    if (table.rows[r].id == element['person_id']){
                        table.rows[r].cells[parseInt(date[2])].style.backgroundColor = sickLeaveColor;
                    }
                }
            });
        }
    });
}


function emptyTable(){
  const cells = document.querySelectorAll('td');

  cells.forEach(cell => {
    cell.style.backgroundColor = 'rgba(0,0,0,0)';
  });

}

//----------------Save table to database-----------------------
function save() {
    $count = 0;
    $value = 0;
    var table = document.getElementById('table');
    for (var r = 0, n = table.rows.length; r < n; r++) {
        for (var c = 0, m = table.rows[r].cells.length; c < m; c++) {
            // Day
            if (window.getComputedStyle(table.rows[r].cells[c],null).backgroundColor == dayColor){
                //                  EmployeeId            date                                     shift/postion
                array[$count++] = {"id": table.rows[r].id,"date": year+"-"+(monthNumber+1)+"-"+c,"shift": 2}; // day
            }
            // night
            if (window.getComputedStyle(table.rows[r].cells[c],null).backgroundColor ==  nightColor){
                //                  EmployeeId           date                                     shift/position
                array[$count++] = {"id": table.rows[r].id,"date": year+"-"+(monthNumber+1)+"-"+c,"shift": 1}; // night
            }
        }
    }

    $.ajax({
        headers:{
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'POST',
        url: '/saveTableCells',
        data : JSON.stringify(array),
        contentType: 'application/json',
        complete: function(xhr){
            if (xhr.status == 200) toastr.success(xhr.responseText);
            else toastr.error(xhr.responseText);
        }
    });
}

//assignment delete button
function drop(){
    if (confirm("Biztosan törölni szeretné a hónap beosztását?")) {
        $.ajax({
            headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'POST',
            url: '/deleteActTable',
            data: JSON.stringify([year,monthNumber+1]),
            contentType: 'application/json',
            complete: function(xhr){
                if (xhr.status == 200){
                    toastr.success(xhr.responseText);
                    deleteColor(dayColor);
                    deleteColor(nightColor);
                }
                else toastr.error(xhr.responseText);
            }
        });
    }
    else {
      return false;
    }
}

function deleteColor(color){
    const cells = document.querySelectorAll('td');

    cells.forEach(cell => {
        if (cell.style.backgroundColor === color){
            cell.style.backgroundColor = 'rgba(0,0,0,0)';
        }

    });
}


var switches = document.querySelectorAll("input[name^=switch]");

switches.forEach(function(checkbox) {
  checkbox.addEventListener('change', function() {
    if (this.checked) {
      switch (this.id){
        case "day":
            tableLoadDay(year,monthNumber+1);
            break;
        case "night":
            tableLoadNight(year,monthNumber+1);
            break;
        case "holiday":
            tableLoadHoliday(year,monthNumber+1);
            break;
        case "sickLeave":
            tableLoadSickLeave(year,monthNumber+1)
            break;
        case "petition":
            tableLoadPetition(year,monthNumber+1);
            break;
        case "all":
              $(document).ready(function() {
                $('.switch').prop('checked', true);
                if ($('.switch').prop('checked')) {
                  tableLoad();
                }
              });
            break;
      }
    } else {
        switch (this.id){
            case "day":
                deleteColor(dayColor);
                break;
            case "night":
                deleteColor(nightColor);
                break;
            case "holiday":
                deleteColor(holidayColor);
                break;
            case "sickLeave":
                deleteColor(sickLeaveColor);
                break;
            case "petition":
                deleteColor(petitionColor);
                break;
            case "all":
                $(document).ready(function() {
                    $('.switch').prop('checked', false);
                    if ($('.switch').prop('checked')== false) {
                      emptyTable();
                    }
                  });
                break;
          }
    }
  });
});

showNumberOfDaysInMonth(getNumberOfDaysInMonth(monthNumber,year));
tableLoad();
