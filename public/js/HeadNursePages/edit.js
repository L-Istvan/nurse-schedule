const array = [];

//Month
const d = new Date();
var monthNumber = d.getMonth();
var year = d.getFullYear();
const months = ["Január","Február","Március","Április","Május","Június",
    "Július","Agusztus","Szeptember","Oktober","November","December"];
document.getElementById("month").innerHTML = months[monthNumber];
function prev(){
    if (monthNumber == 0){
        monthNumber = 11;
        year--;
        document.getElementById("year").innerHTML = year;
        document.getElementById("month").innerHTML = months[monthNumber];
    }
    else{
        monthNumber--;
        document.getElementById("month").innerHTML = months[monthNumber];
    }

}
function next(){
    if(monthNumber == 11){
        monthNumber = 0;
        year++;
        document.getElementById("year").innerHTML = year;
        document.getElementById("month").innerHTML = months[monthNumber];
    }
    else{
        monthNumber++;
        document.getElementById("month").innerHTML = months[monthNumber];
    }
}

//Year
document.getElementById("year").innerHTML = year;



/*----------Colors-------------*/
$colorBackground = "";
$day = "rgb(62, 126, 179)"; // blue --> value = 2
$night = "rgb(57, 62, 70)"; //gray --> value = 1

/*------Fegyeli a táblázatot szín módosítás céljából-------*/
const tbody = document.querySelector('table');
tbody.addEventListener('click', function (e) {
    const cell = e.target.closest('td');
    if (!cell) {return;} // ha nem táblázatba kattint akkor kilépés
    const row = cell.parentElement;
    //id = document.getElementById("table").rows[row.rowIndex].id;
    //oszlop = cell.cellIndex;
    x = document.getElementById("table").rows[row.rowIndex].cells[cell.cellIndex];
    if (window.getComputedStyle(e.target,null).backgroundColor == "rgba(0, 0, 0, 0)" ||
    window.getComputedStyle(e.target,null).backgroundColor == "rgb(0, 0, 255)"){ //eredeti szín -e
        x.style.backgroundColor = "#3e7eb3"; //vilagos kek
        }
    else{
        if (window.getComputedStyle(e.target,null).backgroundColor == "rgb(62, 126, 179)"){ //kék -e
            x.style.backgroundColor = "#393e46"; //szürke
        }
        else{
            if (window.getComputedStyle(e.target,null).backgroundColor == "rgb(57, 62, 70)"){ //szürke -e
                x.style.backgroundColor = "rgba(0, 0, 0, 0)";
            }
            else{
                console.log("ERROR: COLOR ");
                }
            }
        }
});


//Táblázat betöltés
function tableload() {
    baseURL
    $count = 0;
    $value = 0;
    var table = document.getElementById('table');
    for(var i = 0; i<baseURL.length;i++){
        const baseURLSplit = baseURL[i].split(' ');
        console.log(baseURLSplit);
        for (var r = 0, n = table.rows.length; r < n; r++) {
            if (table.rows[r].id == baseURLSplit[0]){
                //day
                if (baseURLSplit[2] == 0){
                    table.rows[r].cells[baseURLSplit[1]].style.backgroundColor = $day;
                }
                //night
                else{
                    table.rows[r].cells[baseURLSplit[1]].style.backgroundColor = $night;
                }
            }
        }
    }
}


function save() {
    $count = 0;
    $value = 0;
    var table = document.getElementById('table');
    for (var r = 0, n = table.rows.length; r < n; r++) {
        for (var c = 0, m = table.rows[r].cells.length; c < m; c++) {
            // Day
            if (window.getComputedStyle(table.rows[r].cells[c],null).backgroundColor == $day){
                //                  dolgozoID            nap         muszak
                array[$count++] = {"email": table.rows[r].id,"date": year+"-"+monthNumber+"-"+c,"shift": 2}; //
            }
            // night
            if (window.getComputedStyle(table.rows[r].cells[c],null).backgroundColor ==  $night){
                //                  dolgozoID            nap         muszak
                array[$count++] = {"email": table.rows[r].id,"date": year+"-"+monthNumber+"-"+c,"shift": 1}; //
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

function valami(){
    console.log("hello");
}
