const array = [];

/*----------Colors-------------*/
$colorBackground = "";
$day = "rgb(0, 173, 181)"; // sárga --> value = 0
$night = "rgb(57, 62, 70)"; //nagyaransá --> value = 1

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
        x.style.backgroundColor = "#00ADB5"; //vilagos kek
        }
    else{
        if (window.getComputedStyle(e.target,null).backgroundColor == "rgb(0, 173, 181)"){ //sárga -e
            x.style.backgroundColor = "#393e46"; //sotet kek
        }
        else{
            if (window.getComputedStyle(e.target,null).backgroundColor == "rgb(57, 62, 70)"){ //narancs -e
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
