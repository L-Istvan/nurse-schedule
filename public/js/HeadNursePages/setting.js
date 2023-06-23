function sendDropdownItems(type,number){
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

function sendformCheckInputs(id,value){
    var data = {
        id :id,
        value: value,
    };
    $.ajax({
        headers:{
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'POST',
        url: 'saveFormCheckInputs',
        data: JSON.stringify(data),
        contentType: 'application/json',
        success : function(xhr){
            toastr.success(xhr);
        },
        error: function(xhr){
            toastr.error("Sikertelen mentés.");
        }
    });
}

var dropdownItems = document.getElementsByClassName("dropdown-item");
for (var i = 0; i < dropdownItems.length; i++) {
    dropdownItems[i].addEventListener("click", function() {
        var selectedValue = this.textContent;
        send(this.id,selectedValue);
    });
}

var formCheckInputs = document.getElementsByClassName('form-check-input');
for (var i = 0; i < formCheckInputs.length; i++) {
    formCheckInputs[i].addEventListener("click", function() {
        console.log(this.checked);
        console.log(this.id);
        sendformCheckInputs(this.id,this.checked);
    });
}
