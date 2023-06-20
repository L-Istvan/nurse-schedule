var dropdownItems = document.getElementsByClassName("dropdown-item");
    for (var i = 0; i < dropdownItems.length; i++) {
        dropdownItems[i].addEventListener("click", function() {
            // Esemény kezelése
            var selectedValue = this.textContent;
            send(this.id,selectedValue);
        });
    }

function send(type,number){
    var x = document.getElementById(type);
    $.ajax({
        headers:{
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'POST',
        url: 'saveSettingValue',
        data: {
            type: type,
            number: number
        },
        success : function(xhr){
            x.textContent = number;
            toastr.success(xhr);
        },
        error: function(xhr){
            toastr.error("Sikertelen mentés.");
        }
    });
}
