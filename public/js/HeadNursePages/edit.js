const array = [];
                //JSON.stringify(array)

                /*----------Colors-------------*/
                $colorBackground = "";
                $day = "rgb(0, 173, 181)"; // sárga --> value = 0
                $night = "rgb(57, 62, 70)"; //nagyaransá --> value = 1

                /*------Fegyeli a táblázatot szín módosítás céljából-------*/
                const tbody = document.querySelector('table');
                tbody.addEventListener('click', function (e) {
                    console.log("hello");
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
                        if (window.getComputedStyle(e.target,null).backgroundColor == "rgb(57, 62, 70)"){ //nagyarancs -e
                            x.style.backgroundColor = "rgba(0, 0, 0, 0)";
                        }
                        else{
                            console.log("ERROR: COLOR ");
                            }
                        }
                    }
                });
